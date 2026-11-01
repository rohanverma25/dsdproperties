<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrmLead;
use App\Models\WaChat;
use App\Models\WaLabel;
use App\Models\WaMessage;
use App\Models\WaPushSubscription;
use App\Models\WaQuickReply;
use App\Services\WhatsAppGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * WhatsApp CRM — the admin-facing half.
 *
 * The socket lives in whatsapp-service/ (Baileys); this controller owns the
 * inbox UI, writes every message to the database and keeps linked CRM leads
 * up to date whenever a conversation moves.
 */
class WhatsAppController extends Controller
{
    public function __construct(protected WhatsAppGateway $gateway)
    {
    }

    /** The inbox. With a chat selected it also renders that thread. */
    public function index(Request $request, ?WaChat $chat = null)
    {
        $chats = $this->chatList($request);

        // Opening a chat clears its unread badge, here and on WhatsApp itself.
        if ($chat?->exists) {
            $chat->load('lead');
            $this->markChatRead($chat);
        }

        if ($chat?->exists) {
            $chat->load('labels');
        }

        return view('admin.whatsapp.index', [
            'chats'        => $chats,
            'chat'         => $chat?->exists ? $chat : null,
            'messages'     => $chat?->exists
                ? $chat->messages()->orderBy('sent_at')->orderBy('id')->get()
                : collect(),
            'status'       => $this->gateway->status(),
            'unreadTotal'  => WaChat::where('archived', false)->sum('unread_count'),
            'search'       => $request->input('q'),
            'labels'       => WaLabel::orderBy('sort')->orderBy('name')->get(),
            'activeLabel'  => $request->integer('label') ?: null,
            'pending'      => $request->boolean('pending'),
            'pendingCount' => WaChat::notHandled()->count(),
            'quickReplies' => $chat?->exists
                ? WaQuickReply::active()->get()->map(fn ($r) => [
                    'shortcut' => $r->shortcut,
                    'label'    => $r->label,
                    'body'     => $r->render($chat),
                ])->values()
                : collect(),
            'pushKey'      => config('whatsapp.vapid.public_key'),
        ]);
    }

    /** QR screen — link or re-link the phone that sends from the panel. */
    public function connect()
    {
        return view('admin.whatsapp.connect', ['status' => $this->gateway->status()]);
    }

    /** Polled by the connect screen every couple of seconds. */
    public function connectStatus()
    {
        return $this->uncached(response()->json($this->gateway->status()));
    }

    /**
     * Polled JSON must never come from a cache. On 2026-10-20 the host's page
     * cache kept serving an old "connecting" answer, so the QR never showed.
     */
    protected function uncached($response)
    {
        return $response
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('X-LiteSpeed-Cache-Control', 'no-cache');
    }

    public function logout()
    {
        try {
            $this->gateway->logout();
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.whatsapp.connect')
            ->with('info', 'Logged out. Scan the QR code to link a phone again.');
    }

    /** Open (or start) a chat from a typed number — used by "New chat" and lead cards. */
    public function start(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $phone = CrmLead::normalisePhone($data['phone']);

        if (strlen($phone) < 10) {
            return back()->with('error', 'That does not look like a valid phone number.');
        }

        $chat = WaChat::forJid($phone . '@s.whatsapp.net');

        return redirect()->route('admin.whatsapp.chat', $chat);
    }

    /**
     * Send a message. The gateway is the source of truth for the WhatsApp id,
     * so the row is only written once the send has actually gone through.
     */
    public function send(Request $request, WaChat $chat)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:4000'],
        ]);

        $body = str_replace('{name}', $chat->first_name, trim($data['body']));

        try {
            $sent = $this->gateway->sendText($chat->phone, $body);
        } catch (RuntimeException $e) {
            return $request->wantsJson()
                ? response()->json(['ok' => false, 'error' => $e->getMessage()], 422)
                : back()->with('error', $e->getMessage());
        }

        $message = $chat->messages()->create([
            'wa_message_id' => $sent['wa_message_id'] ?? null,
            'direction'     => 'out',
            'type'          => 'text',
            'body'          => $body,
            'status'        => 'sent',
            'sent_at'       => now(),
        ]);

        $chat->forceFill([
            'last_preview'    => mb_substr($body, 0, 280),
            'last_message_at' => $message->sent_at,
            'unread_count'    => 0,
        ])->save();

        $this->touchLead($chat);

        if ($request->wantsJson()) {
            return response()->json([
                'ok'      => true,
                'message' => $this->messageJson($message),
            ]);
        }

        return back();
    }

    /**
     * A private note on the chat — never sent to WhatsApp. It sits in the
     * thread where it was written and on the lead's timeline, now or once the
     * chat becomes a lead.
     */
    public function note(Request $request, WaChat $chat)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = $chat->messages()->create([
            'direction' => 'out',
            'type'      => 'note',
            'body'      => trim($data['body']),
            'status'    => 'sent',
            'sent_at'   => now(),
        ]);

        return $request->wantsJson()
            ? response()->json(['ok' => true, 'message' => $this->messageJson($message)])
            : back();
    }

    /**
     * Send to a lead by its number — the Waiting screen's per-row button.
     * Opens (or starts) the chat and sends exactly as the inbox would.
     */
    public function sendToLead(Request $request, CrmLead $lead)
    {
        return $this->send($request, WaChat::forJid(WaChat::phoneToJid($lead->phone)));
    }

    /** Thread poll — returns only what the browser has not seen yet. */
    public function messages(Request $request, WaChat $chat)
    {
        $after = (int) $request->input('after', 0);

        $new = $chat->messages()
            ->when($after > 0, fn ($q) => $q->where('id', '>', $after))
            ->orderBy('sent_at')->orderBy('id')
            ->get();

        // Statuses change in place, so recent bubbles are re-sent regardless of `after`.
        $recent = $chat->messages()
            ->where('direction', 'out')
            ->latest('id')->take(20)->get()
            ->map(fn ($m) => ['id' => $m->id, 'status' => $m->status, 'status_icon' => $m->status_icon]);

        if ($new->where('direction', 'in')->isNotEmpty()) {
            $this->markChatRead($chat);
        }

        return $this->uncached(response()->json([
            'messages'  => $new->map(fn ($m) => $this->messageJson($m))->values(),
            'statuses'  => $recent->values(),
            'connected' => ($this->gateway->status()['connection'] ?? null) === 'open',
        ]));
    }

    /** Chat-list poll — drives the sidebar ordering and the unread badges. */
    public function poll(Request $request)
    {
        return $this->uncached(response()->json([
            'unread_total' => (int) WaChat::where('archived', false)->sum('unread_count'),
            'chats'        => $this->chatList($request)->map(fn (WaChat $c) => [
                'id'           => $c->id,
                'name'         => $c->display_name,
                'phone'        => $c->phone,
                'preview'      => $c->last_preview,
                'unread'       => $c->unread_count,
                'at'           => $c->last_message_at?->diffForHumans(null, true),
                'url'          => route('admin.whatsapp.chat', $c),
            ])->values(),
        ]));
    }

    public function archive(WaChat $chat)
    {
        $chat->forceFill(['archived' => ! $chat->archived])->save();

        return redirect()
            ->route('admin.whatsapp.index')
            ->with('success', $chat->archived ? 'Chat archived.' : 'Chat moved back to the inbox.');
    }

    /**
     * Turn a chat into a CRM lead (or link an existing one), so a WhatsApp
     * conversation can enter the follow-up tracker without retyping anything.
     */
    public function createLead(WaChat $chat)
    {
        if ($chat->crm_lead_id) {
            return redirect()->route('admin.crm.leads.show', $chat->crm_lead_id);
        }

        $existing = CrmLead::where('phone', 'like', '%' . substr($chat->phone, -10))->first();

        // Scheme, intent and page come from the website's "Button:/Page:" lines
        // when the chat started from a button on the site.
        $site = $existing ? [] : $chat->websiteEnquiry();

        $lead = $existing ?: CrmLead::create([
            'name'             => $chat->name ?: 'WhatsApp ' . substr($chat->phone, -4),
            'phone'            => $chat->phone,
            'source_channel'   => 'whatsapp',
            'source_page'      => $site['source_page'] ?? null,
            'intent'           => $site['intent'] ?? 'buy',
            'scheme_interest'  => $site['scheme_interest'] ?? null,
            'stage'            => 'new',
            'next_followup_at' => now()->toDateString(),
            'last_contact_at'  => $chat->last_message_at ?? now(),
            'notes'            => 'Created from the WhatsApp inbox.'
                                  . (isset($site['button']) ? ' Website button: "' . $site['button'] . '".' : ''),
        ]);

        $chat->forceFill(['crm_lead_id' => $lead->id])->save();

        return redirect()
            ->route('admin.crm.leads.show', $lead)
            ->with('success', $existing
                ? 'Chat linked to the existing lead.'
                : 'Lead created from this chat — set the details and follow-up date.');
    }

    /**
     * Stream a stored file.
     *
     * Media never sits under the web root, so this route is the only way to it
     * and inherits the admin gate on /admin/*.
     */
    public function media(WaMessage $message)
    {
        abort_unless($message->has_media, 404);

        $disk = Storage::disk(config('whatsapp.media.disk'));

        abort_unless($disk->exists($message->media_path), 404, 'That file is no longer on disk.');

        // Images and audio play inline; everything else downloads under its
        // original name.
        $inline = $message->is_viewable_image || $message->is_playable_audio;

        return $disk->response(
            $message->media_path,
            $message->media_name,
            ['Content-Type' => $message->media_mime ?: 'application/octet-stream'],
            $inline ? 'inline' : 'attachment'
        );
    }

    /** Send a photo or a document from the composer's paperclip. */
    public function sendMedia(Request $request, WaChat $chat)
    {
        $max = (int) config('whatsapp.media.max_mb') * 1024;

        $data = $request->validate([
            'file'    => ['required', 'file', "max:{$max}"],
            'caption' => ['nullable', 'string', 'max:1000'],
        ], [], ['file' => 'attachment']);

        // `caption` is optional, so it is absent from $data when not supplied.
        $caption = trim((string) ($data['caption'] ?? ''));

        $file    = $data['file'];
        $mime    = $file->getClientMimeType();
        $name    = $file->getClientOriginalName() ?: 'file';
        $caption = $caption !== '' ? str_replace('{name}', $chat->first_name, $caption) : null;

        $kind = match (true) {
            str_starts_with($mime, 'image/') => 'image',
            str_starts_with($mime, 'video/') => 'video',
            str_starts_with($mime, 'audio/') => 'audio',
            default                          => 'document',
        };

        try {
            $sent = $this->gateway->sendMedia($chat->phone, $file->getRealPath(), $name, $kind, $caption);
        } catch (RuntimeException $e) {
            return $request->wantsJson()
                ? response()->json(['ok' => false, 'error' => $e->getMessage()], 422)
                : back()->with('error', $e->getMessage());
        }

        // Only keep our copy once WhatsApp has actually taken it.
        $path = $file->storeAs(
            'whatsapp/' . $chat->id,
            Str::uuid() . '.' . ($file->guessExtension() ?: 'bin'),
            config('whatsapp.media.disk')
        );

        $message = $chat->messages()->create([
            'wa_message_id' => $sent['wa_message_id'] ?? null,
            'direction'     => 'out',
            'type'          => $kind,
            'body'          => $caption,
            'status'        => 'sent',
            'sent_at'       => now(),
            'media_path'    => $path,
            'media_mime'    => $mime,
            'media_name'    => mb_substr($name, 0, 191),
            'media_size'    => $file->getSize(),
        ]);

        $chat->forceFill([
            'last_preview'    => mb_substr($message->preview, 0, 280),
            'last_message_at' => $message->sent_at,
            'unread_count'    => 0,
        ])->save();

        $this->touchLead($chat);

        return $request->wantsJson()
            ? response()->json(['ok' => true, 'message' => $this->messageJson($message)])
            : back();
    }

    /** Add or remove one label on one chat. */
    public function toggleLabel(Request $request, WaChat $chat)
    {
        $data = $request->validate(['label' => ['required', 'integer', 'exists:wa_labels,id']]);

        $changed = $chat->labels()->toggle([$data['label']]);

        return $request->wantsJson()
            ? response()->json([
                'ok'     => true,
                'labels' => $chat->labels()->get()->map(fn ($l) => [
                    'id' => $l->id, 'name' => $l->name, 'classes' => $l->classes,
                ])->values(),
                'added'  => (bool) $changed['attached'],
            ])
            : back();
    }

    /** Remember this browser so it can be notified of new messages. */
    public function subscribePush(Request $request)
    {
        $data = $request->validate([
            'endpoint'    => ['required', 'string', 'max:2048'],
            'keys.p256dh' => ['required', 'string', 'max:255'],
            'keys.auth'   => ['required', 'string', 'max:255'],
        ]);

        WaPushSubscription::remember($data, $request->user()?->id, $request->userAgent());

        return response()->json(['ok' => true]);
    }

    public function unsubscribePush(Request $request)
    {
        $data = $request->validate(['endpoint' => ['required', 'string', 'max:2048']]);

        WaPushSubscription::where('endpoint_hash', WaPushSubscription::hashFor($data['endpoint']))->delete();

        return response()->json(['ok' => true]);
    }

    /* ------------------------------------------------------------ internals */

    /**
     * Every chat as a CSV for Excel — archived and imported ones included.
     *
     * "Came from" is the page in the website's pre-filled WhatsApp message
     * ("Page: /blog/…"), taken from the first message that carries one.
     */
    public function export()
    {
        $filename = 'whatsapp-contacts-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");   // BOM, so Excel reads Hindi names correctly

            fputcsv($out, [
                'Phone', 'Name', 'CRM lead', 'Labels', 'First message', 'Last message',
                'Messages in', 'Messages out', 'Came from page', 'First message text', 'Archived',
            ]);

            WaChat::query()
                ->with(['lead:id,name', 'labels:id,name'])
                ->withCount([
                    'messages as in_count'  => fn ($q) => $q->where('direction', 'in'),
                    'messages as out_count' => fn ($q) => $q->where('direction', 'out')->notNote(),
                ])
                ->withMin('messages as first_at', 'sent_at')
                ->orderByDesc('last_message_at')
                ->chunkById(500, function ($chats) use ($out) {
                    $firstTexts = WaMessage::query()
                        ->whereIn('wa_chat_id', $chats->pluck('id'))
                        ->where('direction', 'in')
                        ->whereNotNull('body')
                        ->orderBy('sent_at')
                        ->get(['wa_chat_id', 'body'])
                        ->groupBy('wa_chat_id');

                    foreach ($chats as $chat) {
                        $bodies = $firstTexts->get($chat->id, collect())->pluck('body');
                        $page   = $bodies->map(fn ($b) => preg_match('~Page:\s*(\S+)~i', $b, $m) ? $m[1] : null)
                            ->filter()->first();

                        fputcsv($out, [
                            $this->csvPhone($chat),
                            $chat->display_name,
                            $chat->lead ? 'Yes' : '',
                            $chat->labels->pluck('name')->implode(', '),
                            $chat->first_at ? Carbon::parse($chat->first_at)->format('Y-m-d H:i') : '',
                            $chat->last_message_at?->format('Y-m-d H:i') ?? '',
                            $chat->in_count,
                            $chat->out_count,
                            $page ?? '',
                            Str::limit(preg_replace('/\s+/', ' ', (string) $bodies->first()), 300),
                            $chat->archived ? 'Yes' : '',
                        ]);
                    }
                });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            // The host's cache handed out a day-old file once; always build it fresh.
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'X-LiteSpeed-Cache-Control' => 'no-cache',
        ]);
    }

    /**
     * "+91 98123 45678". The spaces stop Excel turning the number into 9.18E+11,
     * and Meta's customer-list upload strips them again.
     */
    protected function csvPhone(WaChat $chat): string
    {
        if ($chat->is_privacy_id) {
            return 'Number hidden by WhatsApp';
        }

        $d = $chat->phone;

        if (strlen($d) === 12 && str_starts_with($d, '91')) {
            return '+91 ' . substr($d, 2, 5) . ' ' . substr($d, 7);
        }

        return '+' . substr($d, 0, 2) . ' ' . substr($d, 2);
    }

    protected function chatList(Request $request)
    {
        // A search looks through archived chats too — that is where the imported
        // phone history lives, and otherwise there is no way to reach it.
        return WaChat::query()
            ->when(! $request->filled('q'), fn ($q) => $q->where('archived', false))
            ->when($request->boolean('pending'), fn ($q) => $q->notHandled())
            ->orderByDesc('last_message_at')
            ->with(['lead:id,name,stage', 'labels'])
            ->when($request->filled('label'), fn ($q) => $q->whereHas(
                'labels',
                fn ($l) => $l->whereKey($request->integer('label'))
            ))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term   = trim($request->input('q'));
                $digits = preg_replace('/\D+/', '', $term);

                $q->where(function ($w) use ($term, $digits) {
                    $w->where('name', 'like', "%{$term}%")
                      ->orWhereHas('lead', fn ($l) => $l->where('name', 'like', "%{$term}%"));

                    // Only match on the number when the term actually has digits —
                    // otherwise the LIKE collapses to '%%' and matches every chat.
                    if ($digits !== '') {
                        $w->orWhere('phone', 'like', "%{$digits}%");
                    }
                });
            })
            ->limit(200)
            ->get();
    }

    protected function markChatRead(WaChat $chat): void
    {
        $unreadIds = $chat->messages()
            ->where('direction', 'in')
            ->whereNotNull('wa_message_id')
            ->latest('id')->take(50)
            ->pluck('wa_message_id')->all();

        if ($chat->unread_count > 0) {
            $chat->forceFill(['unread_count' => 0])->save();
            $this->gateway->markRead($chat->jid, $unreadIds);
        }
    }

    /**
     * An outbound WhatsApp message counts as contact on the linked lead. The
     * message itself shows on the lead's timeline straight from wa_messages,
     * so no activity row is written for it.
     */
    protected function touchLead(WaChat $chat): void
    {
        if ($chat->crm_lead_id) {
            CrmLead::whereKey($chat->crm_lead_id)->update(['last_contact_at' => now()]);
        }
    }

    protected function messageJson(WaMessage $m): array
    {
        return [
            'id'          => $m->id,
            'direction'   => $m->direction,
            'type'        => $m->type,
            'body'        => $m->has_media ? (string) $m->body : $m->preview,
            'status'      => $m->status,
            'status_icon' => $m->status_icon,
            'time'        => $m->sent_at->format('d M, g:i a'),
            'media'       => $m->has_media ? [
                'url'   => $m->media_url,
                'name'  => $m->media_name,
                'size'  => $m->media_size_label,
                'image' => $m->is_viewable_image,
                'audio' => $m->is_playable_audio,
                'label' => $m->mediaLabel(),
            ] : null,
        ];
    }
}
