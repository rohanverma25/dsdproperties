# WhatsApp gateway (Baileys)

The admin panel's WhatsApp CRM has two halves:

| Half | Lives in | Job |
|---|---|---|
| Gateway | `whatsapp-service/` (Node 20+) | Owns the WhatsApp Web socket and the login session |
| CRM | Laravel (`/admin/whatsapp`) | Inbox UI, stores every message, links chats to CRM leads |

They talk over HTTP. Locally both run on this PC; in production the gateway
runs on its own VPS at `https://whatsapp.dsdproperties.in` (see
[DEPLOYMENT.md](DEPLOYMENT.md)). Laravel calls the gateway to send; the gateway
posts everything it receives to `POST /api/whatsapp/webhook`. Two shared tokens
guard the two directions.

```
 WhatsApp  <--socket-->  gateway :3001  <--HTTP-->  Laravel  -->  MySQL
                                        (send)      (webhook)
```

## Setup

```bash
cd whatsapp-service
npm install
cp .env.example .env      # then fill in the two tokens and the webhook URL
npm start
```

The values in `whatsapp-service/.env` must line up with Laravel's `.env`:

| whatsapp-service | Laravel | Must match |
|---|---|---|
| `WA_PORT=3001` | `WHATSAPP_URL=http://127.0.0.1:3001` | port |
| `WA_API_TOKEN` | `WHATSAPP_API_TOKEN` | yes |
| `WA_WEBHOOK_TOKEN` | `WHATSAPP_WEBHOOK_TOKEN` | yes |
| `WA_WEBHOOK_URL` | — | must be a URL that reaches this site |
| `WA_MAX_MEDIA_MB` | `WHATSAPP_MAX_MEDIA_MB` | keep in step |
| `WA_VAPID_PUBLIC_KEY` | `WHATSAPP_VAPID_PUBLIC_KEY` | yes |
| `WA_VAPID_PRIVATE_KEY` | — | **gateway only** — Laravel never needs it |

`WA_WEBHOOK_URL` is the one value that differs per machine. It has to be the real
base URL of the site, not just `localhost`:

- XAMPP here: `http://localhost/Lucknow-Properties/public/api/whatsapp/webhook`
- `php artisan serve`: `http://127.0.0.1:8000/api/whatsapp/webhook`
- Production: `https://dsdproperties.in/api/whatsapp/webhook`

## Linking the phone

Open **/admin/whatsapp/connect** and scan the QR code from the business phone
(WhatsApp → Settings → Linked devices → Link a device). The page polls every
3 seconds and jumps to the inbox once the link is live.

The session is then stored in `whatsapp-service/auth/`. Keep that folder:

- **Back it up.** Deleting it means scanning a QR again.
- **Never commit it or expose it over the web.** It is the WhatsApp login.

## Deploying to production

See **[DEPLOYMENT.md](DEPLOYMENT.md)**. The gateway runs on the Hostinger VPS
under pm2 behind nginx, separate from the shared hosting that serves Laravel.

## Running it for real

`npm start` stops when the terminal closes, so use a supervisor:

```bash
# any OS
npm install -g pm2
pm2 start ecosystem.config.cjs
pm2 save && pm2 startup
```

On Windows, [NSSM](https://nssm.cc/) also works: point it at `node.exe` with
`index.js` as the argument and this folder as the working directory.

The gateway reconnects on its own with a backoff, so a dropped connection does
not need a restart. It only needs a fresh QR when WhatsApp ends the session —
usually because the phone was offline for a long time, or the device was
unlinked from the phone.

## HTTP API

Every route except `/health` needs the `X-Api-Token` header.

| Route | Purpose |
|---|---|
| `GET /health` | Liveness, no auth |
| `GET /status` | `connection` (`open`/`connecting`/`close`), the QR while pairing, and `me` |
| `POST /send` | `{ to, text }` — rejects numbers that are not on WhatsApp |
| `POST /send-media` | multipart `file` plus `to`, `caption`, `kind` |
| `POST /push` | `{ payload, subscriptions }` — signs and delivers browser notifications |
| `POST /read` | `{ jid, message_ids }` — blue ticks for messages read in the panel |
| `POST /logout` | Ends the session and clears `auth/` |

## Notifications

Browser notifications are signed **here**, not in PHP: Web Push encryption
needs elliptic-curve maths that PHP only has with `ext-gmp`, which many shared
hosts leave disabled. Laravel still owns the subscriptions and simply hands the
gateway the list to deliver to.

Generate the key pair once, then put the public key in both `.env` files and the
private key only in this one:

```bash
php artisan whatsapp:vapid
```

Notifications need HTTPS in production (localhost is exempt), because service
workers do.

## Media

Incoming photos, voice notes and documents up to `WA_MAX_MEDIA_MB` are
downloaded here and posted to Laravel as one multipart request, which stores
them on a private disk under `storage/app/whatsapp/`. Anything larger stays in
the thread as a label with no file attached.

Files are served back only through `/admin/whatsapp/media/{message}`, so they
inherit the admin login and never sit under the web root.

## Notes and limits

- **One-to-one chats only.** Group messages are ignored on purpose; a group is
  not a lead.
- **Sending is text, photos and documents.** Voice notes can be received but not
  recorded in the panel.
- **Messages sent from the phone show up too**, as outgoing bubbles, so the
  thread in the panel matches the phone.
- The gateway binds to localhost; in production nginx publishes it over HTTPS
  with a rate limit. Never open port 3001 itself. The API token is the only
  lock, so the gateway refuses to start with one shorter than 32 characters.
- This uses WhatsApp Web, not the official Business Cloud API. Sending bulk
  unsolicited messages from a linked device is how numbers get banned — keep it
  to replies and follow-ups with people who enquired.
