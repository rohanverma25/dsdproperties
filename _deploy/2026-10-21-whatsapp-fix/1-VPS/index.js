/**
 * DSD Properties — WhatsApp gateway.
 *
 * Baileys speaks WhatsApp Web; Laravel speaks HTTP. This process sits between
 * the two: it owns the socket and the login session, exposes a small HTTP API
 * for the admin panel to call, and pushes everything that arrives on the socket
 * to the Laravel webhook.
 *
 * Nothing here touches the database — Laravel is the only writer.
 */
import 'dotenv/config';
import crypto from 'node:crypto';
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import express from 'express';
import multer from 'multer';
import pino from 'pino';
import QRCode from 'qrcode';
import webpush from 'web-push';
import makeWASocket, {
    DisconnectReason,
    downloadHistory,
    downloadMediaMessage,
    fetchLatestBaileysVersion,
    isJidGroup,
    jidNormalizedUser,
    makeCacheableSignalKeyStore,
    useMultiFileAuthState,
} from 'baileys';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

// Passenger (cPanel 'Setup Node.js App') hands the port in PORT and needs the
// listener on every interface; on a normal host we stay on loopback.
const PORT          = Number(process.env.PORT || process.env.WA_PORT || 3001);
const HOST          = process.env.WA_HOST || (process.env.PORT ? '0.0.0.0' : '127.0.0.1');
const API_TOKEN     = process.env.WA_API_TOKEN || '';
const WEBHOOK_URL   = process.env.WA_WEBHOOK_URL || '';
const WEBHOOK_TOKEN = process.env.WA_WEBHOOK_TOKEN || '';
const AUTH_DIR      = process.env.WA_AUTH_DIR || path.join(__dirname, 'auth');
// Anything larger is left as a label in the thread rather than downloaded.
const MAX_MEDIA_MB  = Number(process.env.WA_MAX_MEDIA_MB || 25);
// Ask the phone for its old chats when a device is linked. Only takes effect on
// a fresh QR scan — the phone sends history once, at pairing time. Set to 0 to
// link without it.
const SYNC_HISTORY  = process.env.WA_SYNC_HISTORY !== '0';
// How the link presents itself. Baileys documents a desktop identity ('mac')
// for full history, but since 2026-10-20 WhatsApp refuses any 'Mac OS' or
// 'Windows' link with 428 before a QR is even shown — tested on a fresh login.
// Only the plain browser link pairs, so that is the default; the others stay
// here in case WhatsApp relents.
const BROWSERS = {
    chrome:  ['DSD Properties CRM', 'Chrome', '1.0.0'],
    mac:     ['Mac OS', 'Desktop', '14.4.1'],
    windows: ['Windows', 'Desktop', '10.0.22631'],
};
const BROWSER = BROWSERS[process.env.WA_BROWSER] || BROWSERS.chrome;

if (API_TOKEN.length < 32) {
    console.error('WA_API_TOKEN must be set to a random string of at least 32 characters. Refusing to start.');
    process.exit(1);
}

/*
 * Browser notifications are signed here rather than in PHP: the encryption
 * needs elliptic-curve maths that PHP only has with ext-gmp, which plenty of
 * shared hosts do not enable. This process is already long-running, so it is
 * the natural place for it. Laravel still owns the subscriptions.
 */
const VAPID = {
    subject: process.env.WA_VAPID_SUBJECT || '',
    publicKey: process.env.WA_VAPID_PUBLIC_KEY || '',
    privateKey: process.env.WA_VAPID_PRIVATE_KEY || '',
};

if (VAPID.publicKey && VAPID.privateKey) {
    webpush.setVapidDetails(VAPID.subject || 'mailto:admin@example.com', VAPID.publicKey, VAPID.privateKey);
}

// Baileys is chatty; keep its own logger quiet and log the few things we care about.
const waLogger = pino({ level: process.env.WA_LOG_LEVEL || 'silent' });

/* ------------------------------------------------------------------ state */

const state = {
    connection: 'close',   // close | connecting | open
    qr: null,              // data-url PNG, only while a scan is pending
    me: null,              // { id, name } once logged in
    lastError: null,
    startedAt: new Date().toISOString(),
    reconnectAttempts: 0,
};

let sock = null;
let stopping = false;

/* ---------------------------------------------------------------- helpers */

function log(...args) {
    console.log(new Date().toISOString(), '-', ...args);
}

/** Fire-and-forget POST to Laravel. A webhook failure must never kill the socket. */
async function pushToLaravel(event, payload) {
    if (!WEBHOOK_URL) return;

    try {
        const res = await fetch(WEBHOOK_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-WA-Token': WEBHOOK_TOKEN,
            },
            body: JSON.stringify({ event, ...payload }),
        });

        if (!res.ok) {
            const body = await res.text().catch(() => '');
            log(`webhook ${event} -> HTTP ${res.status}`, body.slice(0, 300));
        }
    } catch (e) {
        log(`webhook ${event} failed:`, e.message);
    }
}

/**
 * Send a message that has a file with it.
 *
 * Laravel is the only writer, so the bytes go to it rather than being saved
 * here: one multipart POST carrying the same fields as the JSON webhook plus
 * the file itself. The webhook URL gets a '/media' suffix.
 */
async function pushMediaToLaravel(fields, buffer, mime, filename) {
    if (!WEBHOOK_URL) return false;

    try {
        const form = new FormData();
        for (const [k, v] of Object.entries(fields)) {
            form.append(k, v === null || v === undefined ? '' : String(v));
        }
        form.append('file', new Blob([buffer], { type: mime }), filename);

        const res = await fetch(WEBHOOK_URL.replace(/\/+$/, '') + '/media', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-WA-Token': WEBHOOK_TOKEN },
            body: form,
        });

        if (!res.ok) {
            const body = await res.text().catch(() => '');
            log(`media webhook -> HTTP ${res.status}`, body.slice(0, 300));
            return false;
        }

        return true;
    } catch (e) {
        log('media webhook failed:', e.message);
        return false;
    }
}

/** Fetch the bytes of a media message, or null if that is not sensible. */
async function fetchMedia(msg, info) {
    const limit = MAX_MEDIA_MB * 1024 * 1024;

    if (info.size && info.size > limit) {
        log(`skipping ${info.name}: ${Math.round(info.size / 1048576)}MB is over the ${MAX_MEDIA_MB}MB limit`);
        return null;
    }

    try {
        const buffer = await downloadMediaMessage(msg, 'buffer', {}, {
            logger: waLogger,
            reuploadRequest: sock.updateMediaMessage,
        });

        if (buffer.length > limit) {
            log(`discarding ${info.name}: ${Math.round(buffer.length / 1048576)}MB once downloaded`);
            return null;
        }

        return buffer;
    } catch (e) {
        log(`could not download ${info.name}:`, e.message);
        return null;
    }
}

/** "919812345678" / "+91 98123 45678" / a full jid -> "919812345678@s.whatsapp.net" */
function toJid(to) {
    const raw = String(to || '').trim();
    if (raw.includes('@')) return jidNormalizedUser(raw);

    let digits = raw.replace(/\D+/g, '');
    if (digits.length === 10) digits = '91' + digits;
    if (digits.length === 11 && digits.startsWith('0')) digits = '91' + digits.slice(1);

    return digits + '@s.whatsapp.net';
}

/** Shape a media variant into the same envelope as a text message. */
function media(type, body, node, fallbackName) {
    return {
        type,
        body,
        media: {
            mime: node.mimetype || 'application/octet-stream',
            name: node.fileName || fallbackName,
            size: Number(node.fileLength) || 0,
        },
    };
}

/** Pull readable text out of whichever message variant arrived. */
function readMessage(msg) {
    const m = msg.message || {};
    const inner = m.ephemeralMessage?.message
        || m.viewOnceMessage?.message
        || m.viewOnceMessageV2?.message
        || m.documentWithCaptionMessage?.message
        || m;

    if (inner.conversation)           return { type: 'text',     body: inner.conversation };
    if (inner.extendedTextMessage)    return { type: 'text',     body: inner.extendedTextMessage.text || '' };

    // Media: `media` carries what Laravel needs to name and store the file.
    if (inner.imageMessage)    return media('image',    inner.imageMessage.caption || '', inner.imageMessage, 'photo.jpg');
    if (inner.videoMessage)    return media('video',    inner.videoMessage.caption || '', inner.videoMessage, 'video.mp4');
    if (inner.documentMessage) return media('document', '', inner.documentMessage, inner.documentMessage.fileName || 'document');
    if (inner.audioMessage)    return media('audio',    '', inner.audioMessage, inner.audioMessage.ptt ? 'voice-note.ogg' : 'audio.ogg');
    if (inner.stickerMessage)  return media('sticker',  '', inner.stickerMessage, 'sticker.webp');
    if (inner.locationMessage)        return {
        type: 'location',
        body: inner.locationMessage.degreesLatitude + ',' + inner.locationMessage.degreesLongitude,
    };
    if (inner.contactMessage)         return { type: 'contact',  body: inner.contactMessage.displayName || '' };
    if (inner.reactionMessage)        return { type: 'reaction', body: inner.reactionMessage.text || '' };
    if (inner.buttonsResponseMessage) return { type: 'text',     body: inner.buttonsResponseMessage.selectedDisplayText || '' };
    if (inner.listResponseMessage)    return { type: 'text',     body: inner.listResponseMessage.title || '' };

    return { type: 'unsupported', body: '' };
}

const STATUS_NAMES = { 0: 'pending', 1: 'sent', 2: 'sent', 3: 'delivered', 4: 'read', 5: 'read' };

function wipeAuth() {
    try {
        fs.rmSync(AUTH_DIR, { recursive: true, force: true });
        log('auth folder cleared — a new QR scan is needed');
    } catch (e) {
        log('could not clear auth folder:', e.message);
    }
}

/* ----------------------------------------------------------------- socket */

async function connect() {
    if (stopping) return;

    fs.mkdirSync(AUTH_DIR, { recursive: true });

    const { state: authState, saveCreds } = await useMultiFileAuthState(AUTH_DIR);
    const { version } = await fetchLatestBaileysVersion();

    log('connecting with WA web version ' + version.join('.') + ' as ' + BROWSER.slice(0, 2).join('/')
        + (SYNC_HISTORY ? ', history sync on' : ''));
    state.connection = 'connecting';

    sock = makeWASocket({
        version,
        logger: waLogger,
        auth: {
            creds: authState.creds,
            keys: makeCacheableSignalKeyStore(authState.keys, waLogger),
        },
        browser: BROWSER,
        markOnlineOnConnect: false,   // let the phone keep receiving notifications
        syncFullHistory: SYNC_HISTORY,
        // Baileys hands us history with the privacy-id -> number table thrown
        // away, so most chats arrive without a number. Read the raw chunk
        // ourselves for that table before Baileys processes it.
        shouldSyncHistoryMessage: (notification) => {
            if (!SYNC_HISTORY) return false;
            captureRawHistory(notification);
            return true;
        },
        generateHighQualityLinkPreview: true,
    });

    sock.ev.on('creds.update', saveCreds);

    sock.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (qr) {
            state.qr = await QRCode.toDataURL(qr, { margin: 1, width: 320 });
            log('QR ready — open /admin/whatsapp/connect to scan');
            pushToLaravel('connection', { connection: 'qr' });
        }

        if (connection === 'connecting') {
            state.connection = 'connecting';
        }

        if (connection === 'open') {
            state.connection = 'open';
            state.qr = null;
            state.lastError = null;
            state.reconnectAttempts = 0;
            state.me = { id: sock.user?.id || null, name: sock.user?.name || null };
            log('connected as', state.me.id);
            pushToLaravel('connection', { connection: 'open', me: state.me });
        }

        if (connection === 'close') {
            state.connection = 'close';

            const code   = lastDisconnect?.error?.output?.statusCode;
            const reason = lastDisconnect?.error?.message || 'unknown';
            state.lastError = reason;
            log('disconnected (' + (code ?? '—') + '): ' + reason);
            pushToLaravel('connection', { connection: 'close', reason });

            if (code === DisconnectReason.loggedOut) {
                // Logged out from the phone: the stored session is dead, start clean.
                state.me = null;
                wipeAuth();
            }

            if (stopping) return;

            const wait = Math.min(30000, 2000 * Math.pow(2, Math.min(state.reconnectAttempts, 4)));
            state.reconnectAttempts += 1;
            log('reconnecting in ' + wait / 1000 + 's');
            setTimeout(() => connect().catch((e) => log('reconnect failed:', e.message)), wait);
        }
    });

    // Inbound messages, plus anything sent from the phone itself.
    sock.ev.on('messages.upsert', async ({ messages, type }) => {
        if (type !== 'notify') return;

        for (const msg of messages) {
            const jid = msg.key?.remoteJid;
            if (!jid || jid === 'status@broadcast') continue;
            if (isJidGroup(jid)) continue;               // one-to-one chats only

            const read = readMessage(msg);
            if (read.type === 'unsupported' && !read.body) continue;

            // Chats keyed by a privacy id (@lid) carry the real number alongside.
            if (jid.endsWith('@lid') && msg.key.senderPn) {
                lidToPn.set(jidNormalizedUser(jid), jidNormalizedUser(msg.key.senderPn));
            }
            const chatJid = userJid(jid) || jidNormalizedUser(jid);
            if (chatJid.endsWith('@lid')) log('message from ' + chatJid + ' with no known number');

            const fields = {
                wa_message_id: msg.key.id,
                jid: chatJid,
                from_me: Boolean(msg.key.fromMe),
                push_name: msg.pushName || null,
                type: read.type,
                body: read.body,
                timestamp: Number(msg.messageTimestamp) || Math.floor(Date.now() / 1000),
            };

            if (read.media) {
                const buffer = await fetchMedia(msg, read.media);

                if (buffer) {
                    const sent = await pushMediaToLaravel(
                        { ...fields, media_name: read.media.name },
                        buffer,
                        read.media.mime,
                        read.media.name,
                    );

                    // Only fall through to the plain webhook if the upload failed,
                    // so the message still shows up as a label in the thread.
                    if (sent) continue;
                }
            }

            await pushToLaravel('message', fields);
        }
    });

    // Delivery / read receipts for what we sent.
    sock.ev.on('messages.update', async (updates) => {
        for (const u of updates) {
            const status = u.update?.status;
            if (status === undefined || status === null) continue;

            await pushToLaravel('status', {
                wa_message_id: u.key?.id,
                jid: u.key?.remoteJid ? jidNormalizedUser(u.key.remoteJid) : null,
                status: STATUS_NAMES[status] || String(status),
            });
        }
    });

    // Contact names, so the inbox can show something friendlier than a number.
    // A fresh link syncs the whole address book at once, so these go in batches
    // rather than one request per contact.
    // WhatsApp tells us a privacy id's number when the other side shares it.
    sock.ev.on('chats.phoneNumberShare', ({ lid, jid }) => {
        if (lid && jid) lidToPn.set(jidNormalizedUser(lid), jidNormalizedUser(jid));
    });

    sock.ev.on('contacts.upsert', async (contacts) => {
        for (const c of contacts) {
            if (c.lid && c.id?.endsWith('@s.whatsapp.net')) lidToPn.set(jidNormalizedUser(c.lid), jidNormalizedUser(c.id));
        }

        const named = contacts
            .filter((c) => c.id && !isJidGroup(c.id) && (c.name || c.notify || c.verifiedName))
            .map((c) => ({ jid: jidNormalizedUser(c.id), name: c.name || c.notify || c.verifiedName }));

        for (let i = 0; i < named.length; i += 200) {
            await pushToLaravel('contacts', { contacts: named.slice(i, i + 200) });
        }
    });

    // Old chats from the phone, sent in several chunks straight after pairing.
    sock.ev.on('messaging-history.set', (data) => {
        historyQueue = historyQueue
            .then(() => importHistory(data))
            .catch((e) => log('history import failed:', e.message));
    });
}

/* ---------------------------------------------------------- history sync */

// Chunks are imported one at a time so shared hosting sees a steady trickle
// of requests rather than every chunk at once.
let historyQueue = Promise.resolve();
const historyTotals = { chats: 0, messages: 0, skipped: 0 };

// Newer WhatsApp keys some chats by a privacy id (@lid) instead of the number.
// The history tells us which number each one belongs to; remember it across chunks.
const lidToPn = new Map();

function toNumber(v) {
    if (v === null || v === undefined) return 0;
    if (typeof v === 'object' && typeof v.toNumber === 'function') return v.toNumber();
    return Number(v) || 0;
}

/** A one-to-one chat's phone-number jid, or null if we cannot tell the number. */
function userJid(jid, hintPn) {
    if (!jid || isJidGroup(jid) || jid === 'status@broadcast' || jid.endsWith('@newsletter') || jid.endsWith('@broadcast')) {
        return null;
    }
    if (jid.endsWith('@s.whatsapp.net')) return jidNormalizedUser(jid);
    if (jid.endsWith('@lid')) {
        const pn = lidToPn.get(jidNormalizedUser(jid)) || hintPn;
        return pn && pn.endsWith('@s.whatsapp.net') ? jidNormalizedUser(pn) : null;
    }
    return null;
}

// Raw chunks are read in parallel with Baileys; an import waits for them so the
// number table is complete before any chat is resolved.
let rawHistoryReads = [];
const HISTORY_DIR = path.join(__dirname, 'history');

function captureRawHistory(notification) {
    const read = downloadHistory(notification, {})
        .then((raw) => {
            let added = 0;
            for (const m of raw.phoneNumberToLidMappings || []) {
                if (m.lidJid && m.pnJid) {
                    lidToPn.set(jidNormalizedUser(m.lidJid), jidNormalizedUser(m.pnJid));
                    added += 1;
                }
            }
            for (const c of raw.conversations || []) {
                if (c.id?.endsWith('@lid') && c.pnJid) lidToPn.set(jidNormalizedUser(c.id), jidNormalizedUser(c.pnJid));
                if (c.id?.endsWith('@s.whatsapp.net') && c.lidJid) lidToPn.set(jidNormalizedUser(c.lidJid), jidNormalizedUser(c.id));
            }
            log(`raw history chunk (type ${raw.syncType}): ${(raw.conversations || []).length} conversations, `
                + `${added} number mappings — ${lidToPn.size} known in all`);

            // Keep a copy on the VPS so a missed number can be fixed later
            // without asking the phone again. Private: nothing serves this folder.
            fs.mkdirSync(HISTORY_DIR, { recursive: true });
            const name = `${Date.now()}-type${raw.syncType}-${raw.chunkOrder ?? 0}.json`;
            fs.writeFileSync(path.join(HISTORY_DIR, name), JSON.stringify(raw.toJSON()));
        })
        .catch((e) => log('could not read raw history chunk:', e.message));

    rawHistoryReads.push(read);
}

async function importHistory({ chats = [], contacts = [], messages = [], syncType, progress }) {
    const pending = rawHistoryReads;
    rawHistoryReads = [];
    await Promise.all(pending);

    for (const c of chats) {
        if (c.lidJid && c.id?.endsWith('@s.whatsapp.net')) lidToPn.set(jidNormalizedUser(c.lidJid), c.id);
        if (c.pnJid && c.id?.endsWith('@lid')) lidToPn.set(jidNormalizedUser(c.id), c.pnJid);
    }

    const names = new Map();
    for (const c of contacts) {
        const jid = userJid(c.id || c.jid);
        const name = c.name || c.notify || c.verifiedName;
        if (jid && name) names.set(jid, name);
    }

    const chatRows = [];
    for (const c of chats) {
        const jid = userJid(c.id, c.pnJid);
        if (!jid) continue;

        chatRows.push({
            jid,
            name: c.name || c.displayName || names.get(jid) || null,
            last_message_at: toNumber(c.conversationTimestamp) || toNumber(c.lastMsgTimestamp) || null,
        });
    }

    const messageRows = [];
    for (const msg of messages) {
        const jid = userJid(msg.key?.remoteJid, msg.key?.senderPn);
        if (!jid) {
            historyTotals.skipped += 1;
            continue;
        }

        const read = readMessage(msg);
        if (read.type === 'unsupported' || (read.type === 'reaction')) continue;

        messageRows.push({
            wa_message_id: msg.key.id || null,
            jid,
            from_me: Boolean(msg.key.fromMe),
            push_name: msg.pushName || null,
            type: read.type,
            // Old media is left as a label in the thread; downloading months of
            // photos would take hours and most of the links have expired anyway.
            body: (read.body || '').slice(0, 4000),
            timestamp: toNumber(msg.messageTimestamp),
        });
    }

    for (let i = 0; i < chatRows.length; i += 200) {
        await pushToLaravel('history', { chats: chatRows.slice(i, i + 200), messages: [] });
    }
    for (let i = 0; i < messageRows.length; i += 250) {
        await pushToLaravel('history', { chats: [], messages: messageRows.slice(i, i + 250) });
    }

    historyTotals.chats += chatRows.length;
    historyTotals.messages += messageRows.length;
    log(`history chunk (type ${syncType}, ${progress ?? '?'}%): ${chatRows.length} chats, ${messageRows.length} messages`
        + ` — running total ${historyTotals.chats} chats, ${historyTotals.messages} messages, ${historyTotals.skipped} without a number`);
}

/* -------------------------------------------------------------- http api */

const app = express();
app.use(express.json({ limit: '2mb' }));

// Files are held in memory only long enough to hand them to Baileys.
const upload = multer({
    storage: multer.memoryStorage(),
    limits: { fileSize: MAX_MEDIA_MB * 1024 * 1024, files: 1 },
});

app.get('/health', (_req, res) => res.json({ ok: true, connection: state.connection }));

// Everything below needs the shared token. The gateway is published through
// nginx on its own subdomain, so this check is the only thing in front of the
// WhatsApp account — compare in constant time and never run without a token.
const API_TOKEN_BUF = Buffer.from(API_TOKEN);

app.use((req, res, next) => {
    const given = Buffer.from(req.get('X-Api-Token') || '');
    if (given.length !== API_TOKEN_BUF.length || !crypto.timingSafeEqual(given, API_TOKEN_BUF)) {
        return res.status(401).json({ ok: false, error: 'bad token' });
    }
    next();
});

app.get('/status', (_req, res) => res.json({
    ok: true,
    connection: state.connection,
    qr: state.connection === 'open' ? null : state.qr,
    me: state.me,
    last_error: state.lastError,
    started_at: state.startedAt,
}));

app.post('/send', async (req, res) => {
    const { to, text } = req.body || {};

    if (!to || !String(text || '').trim()) {
        return res.status(422).json({ ok: false, error: 'to and text are both required' });
    }
    if (state.connection !== 'open' || !sock) {
        return res.status(503).json({ ok: false, error: 'WhatsApp is not connected' });
    }

    try {
        const jid = toJid(to);

        // A number that is not on WhatsApp would otherwise fail silently.
        const [check] = await sock.onWhatsApp(jid).catch(() => []);
        if (check && check.exists === false) {
            return res.status(422).json({ ok: false, error: 'This number is not on WhatsApp' });
        }

        const sent = await sock.sendMessage(jid, { text: String(text) });

        res.json({
            ok: true,
            wa_message_id: sent?.key?.id || null,
            jid,
            timestamp: Number(sent?.messageTimestamp) || Math.floor(Date.now() / 1000),
        });
    } catch (e) {
        log('send failed:', e.message);
        res.status(500).json({ ok: false, error: e.message });
    }
});

/**
 * Send a file. Laravel posts it as multipart so the two processes never need to
 * share a filesystem — they only need to share a port.
 */
app.post('/send-media', upload.single('file'), async (req, res) => {
    const { to, caption, kind } = req.body || {};

    if (!to || !req.file) {
        return res.status(422).json({ ok: false, error: 'to and file are both required' });
    }
    if (state.connection !== 'open' || !sock) {
        return res.status(503).json({ ok: false, error: 'WhatsApp is not connected' });
    }

    try {
        const jid  = toJid(to);
        const mime = req.file.mimetype || 'application/octet-stream';
        const name = req.file.originalname || 'file';

        // WhatsApp renders each kind differently; a document sent as an image
        // loses its filename, and vice versa.
        let payload;
        if (kind === 'image' || (!kind && mime.startsWith('image/'))) {
            payload = { image: req.file.buffer, caption: caption || undefined, mimetype: mime };
        } else if (kind === 'video' || (!kind && mime.startsWith('video/'))) {
            payload = { video: req.file.buffer, caption: caption || undefined, mimetype: mime };
        } else if (kind === 'audio' || (!kind && mime.startsWith('audio/'))) {
            payload = { audio: req.file.buffer, mimetype: mime };
        } else {
            payload = { document: req.file.buffer, fileName: name, mimetype: mime, caption: caption || undefined };
        }

        const sent = await sock.sendMessage(jid, payload);

        res.json({
            ok: true,
            wa_message_id: sent?.key?.id || null,
            jid,
            timestamp: Number(sent?.messageTimestamp) || Math.floor(Date.now() / 1000),
        });
    } catch (e) {
        log('send-media failed:', e.message);
        res.status(500).json({ ok: false, error: e.message });
    }
});

app.post('/read', async (req, res) => {
    const { jid, message_ids } = req.body || {};

    if (state.connection !== 'open' || !sock) {
        return res.status(503).json({ ok: false, error: 'WhatsApp is not connected' });
    }

    try {
        await sock.readMessages((message_ids || []).map((id) => ({
            remoteJid: toJid(jid),
            id,
            participant: undefined,
        })));
        res.json({ ok: true });
    } catch (e) {
        res.status(500).json({ ok: false, error: e.message });
    }
});

/**
 * Fan a notification out to the browsers Laravel knows about.
 *
 * Returns a verdict per endpoint so Laravel can delete the dead ones — a 404
 * or 410 means the browser threw the subscription away.
 */
app.post('/push', async (req, res) => {
    const { payload, subscriptions } = req.body || {};

    if (!VAPID.publicKey || !VAPID.privateKey) {
        return res.status(503).json({ ok: false, error: 'VAPID keys are not configured on the gateway' });
    }
    if (!Array.isArray(subscriptions) || !subscriptions.length) {
        return res.json({ ok: true, results: [] });
    }

    const body = JSON.stringify(payload || {});

    const results = await Promise.all(subscriptions.map(async (sub) => {
        try {
            await webpush.sendNotification({
                endpoint: sub.endpoint,
                keys: { p256dh: sub.p256dh, auth: sub.auth },
            }, body, { TTL: 600 });

            return { endpoint: sub.endpoint, ok: true, expired: false };
        } catch (e) {
            const gone = e.statusCode === 404 || e.statusCode === 410;
            if (!gone) log('push failed:', e.statusCode || '', (e.body || e.message || '').toString().slice(0, 160));

            return { endpoint: sub.endpoint, ok: false, expired: gone };
        }
    }));

    res.json({ ok: true, results });
});

app.post('/logout', async (_req, res) => {
    try {
        if (sock) await sock.logout().catch(() => {});
    } finally {
        state.me = null;
        state.connection = 'close';
        state.qr = null;
        wipeAuth();
        setTimeout(() => connect().catch((e) => log('restart failed:', e.message)), 1500);
    }

    res.json({ ok: true });
});

app.listen(PORT, HOST, () => {
    log('WhatsApp gateway listening on http://' + HOST + ':' + PORT);
    if (!WEBHOOK_URL) log('WARNING: WA_WEBHOOK_URL is empty — inbound messages will be dropped');
    connect().catch((e) => log('initial connect failed:', e.message));
});

for (const sig of ['SIGINT', 'SIGTERM']) {
    process.on(sig, () => {
        stopping = true;
        log('shutting down');
        try { sock?.end(undefined); } catch (e) { /* already gone */ }
        process.exit(0);
    });
}
