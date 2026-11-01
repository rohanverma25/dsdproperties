<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrmLead;
use App\Models\WaChat;
use App\Models\WaMessage;
use App\Services\WhatsAppPush;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Everything the Baileys gateway sees arrives here.
 *
 * The route is unauthenticated (it is called by a background process, not a
 * browser), so the shared token is checked on every request and the endpoint
 * should stay bound to localhost in production.
 */
class WhatsAppWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($bad = $this->rejectBadToken($request)) {
            return $bad;
        }

        match ($request->input('event')) {
            'message' => $this->onMessage($request),
            'status'  => $this->onStatus($request),
            'contacts' => $this->onContacts($request),
            'history'  => $this->onHistory($request),
            'lids'     => $this->onLids($request),
            default   => null,   // connection events are read from /status instead
        };

        return response()->json(['ok' => true]);
    }

    /**
     * Same as a message webhook, but multipart with the file attached.
     *
     * The gateway has already downloaded the bytes from WhatsApp; all that is
     * left is to put them on a private disk and record where they went.
     */
    public function media(Request $request)
    {
        if ($bad = $this->rejectBadToken($request)) {
            return $bad;
        }

        $data = $request->validate([
            'wa_message_id' => ['nullable', 'string', 'max:191'],
            'jid'           => ['required', 'string', 'max:191'],
            'from_me'       => ['required'],
            'push_name'     => ['nullable', 'string', 'max:191'],
            'type'          => ['required', 'string', 'max:20'],
            'body'          => ['nullable', 'string'],
            'timestamp'     => ['required', 'integer'],
            'media_name'    => ['nullable', 'string', 'max:191'],
            'file'          => ['required', 'file', 'max:' . (config('whatsapp.media.max_mb') * 1024)],
        ]);

        // A validated array only carries the keys that were actually sent, so
        // every optional field needs a default before it is read.
        $data += ['wa_message_id' => null, 'push_name' => null, 'body' => null, 'media_name' => null];

        if ($data['wa_message_id'] && WaMessage::where('wa_message_id', $data['wa_message_id'])->exists()) {
            return response()->json(['ok' => true, 'duplicate' => true]);
        }

        $file    = $request->file('file');
        $inbound = ! filter_var($data['from_me'], FILTER_VALIDATE_BOOLEAN);
        $chat    = WaChat::forJid($data['jid'], $data['push_name']);
        $sentAt  = Carbon::createFromTimestamp($data['timestamp']);

        // Keep the original name for display, but never let it pick the path.
        $name = $data['media_name'] ?: $file->getClientOriginalName();
        $path = $file->storeAs(
            'whatsapp/' . $chat->id,
            Str::uuid() . '.' . ($file->guessExtension() ?: 'bin'),
            config('whatsapp.media.disk')
        );

        $message = $chat->messages()->create([
            'wa_message_id' => $data['wa_message_id'],
            'direction'     => $inbound ? 'in' : 'out',
            'type'          => $data['type'],
            'body'          => $data['body'] ?: null,
            'status'        => $inbound ? 'read' : 'sent',
            'sent_at'       => $sentAt,
            'media_path'    => $path,
            'media_mime'    => $file->getClientMimeType(),
            'media_name'    => mb_substr($name, 0, 191),
            'media_size'    => $file->getSize(),
        ]);

        $this->afterMessage($chat, $message, $inbound, $sentAt);

        return response()->json(['ok' => true]);
    }

    protected function rejectBadToken(Request $request)
    {
        $expected = (string) config('whatsapp.webhook_token');

        if ($expected === '' || ! hash_equals($expected, (string) $request->header('X-WA-Token'))) {
            return response()->json(['ok' => false, 'error' => 'unauthorised'], 401);
        }

        return null;
    }

    protected function onMessage(Request $request): void
    {
        $data = $request->validate([
            'wa_message_id' => ['nullable', 'string', 'max:191'],
            'jid'           => ['required', 'string', 'max:191'],
            'from_me'       => ['required', 'boolean'],
            'push_name'     => ['nullable', 'string', 'max:191'],
            'type'          => ['required', 'string', 'max:20'],
            'body'          => ['nullable', 'string'],
            'timestamp'     => ['required', 'integer'],
        ]);

        // Messages we sent from the panel come back on the socket too; the row already exists.
        if ($data['wa_message_id'] && WaMessage::where('wa_message_id', $data['wa_message_id'])->exists()) {
            return;
        }

        $chat   = WaChat::forJid($data['jid'], $data['push_name'] ?? null);
        $inbound = ! $data['from_me'];
        $sentAt = Carbon::createFromTimestamp($data['timestamp']);

        $message = $chat->messages()->create([
            'wa_message_id' => $data['wa_message_id'],
            'direction'     => $inbound ? 'in' : 'out',
            'type'          => $data['type'],
            'body'          => $data['body'] ?: null,
            'status'        => $inbound ? 'read' : 'sent',
            'sent_at'       => $sentAt,
        ]);

        $this->afterMessage($chat, $message, $inbound, $sentAt);
    }

    /**
     * Everything that happens once a message row exists, whichever path wrote
     * it: the chat summary, the linked lead, and the notification.
     */
    protected function afterMessage(WaChat $chat, WaMessage $message, bool $inbound, Carbon $sentAt): void
    {
        $chat->forceFill([
            'last_preview'    => mb_substr($message->preview, 0, 280),
            'last_message_at' => $sentAt,
            'unread_count'    => $inbound ? $chat->unread_count + 1 : 0,
        ])->save();

        if (! $inbound) {
            return;
        }

        // Like WhatsApp itself: a new message brings an archived chat back. Without
        // this, someone from the imported history who writes again stays hidden.
        if ($chat->archived) {
            $chat->forceFill(['archived' => false])->save();
        }

        // A reply is contact — and brings a lost or dormant lead back to Today.
        if ($chat->crm_lead_id) {
            CrmLead::find($chat->crm_lead_id)?->reopenOnReply($sentAt);
        }

        app(WhatsAppPush::class)->notifyNewMessage($chat, $message);
    }

    protected function onStatus(Request $request): void
    {
        $data = $request->validate([
            'wa_message_id' => ['required', 'string', 'max:191'],
            'status'        => ['required', 'string', 'max:20'],
        ]);

        if (! array_key_exists($data['status'], WaMessage::STATUS_ORDER)) {
            return;
        }

        $message = WaMessage::where('wa_message_id', $data['wa_message_id'])->first();

        if (! $message || $message->direction !== 'out') {
            return;
        }

        // Receipts can arrive out of order; never walk a status backwards.
        $current = WaMessage::STATUS_ORDER[$message->status] ?? 0;

        if (WaMessage::STATUS_ORDER[$data['status']] > $current) {
            $message->forceFill(['status' => $data['status']])->save();
        }
    }

    /**
     * A batch of contact names from the address-book sync.
     *
     * Only chats we already know about are named, and only when they have no
     * name yet — a name an admin set must never be overwritten.
     */
    protected function onContacts(Request $request): void
    {
        $data = $request->validate([
            'contacts'        => ['required', 'array', 'max:500'],
            'contacts.*.jid'  => ['required', 'string', 'max:191'],
            'contacts.*.name' => ['required', 'string', 'max:191'],
        ]);

        $names = collect($data['contacts'])->pluck('name', 'jid');

        WaChat::whereIn('jid', $names->keys())
            ->whereNull('name')
            ->get()
            ->each(fn (WaChat $chat) => $chat->forceFill(['name' => $names[$chat->jid]])->save());
    }

    /**
     * Old chats the phone hands over when a device is linked.
     *
     * Imported chats get no unread badge, and nothing here fires a
     * notification — months of old messages must not look like new ones. A
     * chat that is already in the inbox keeps its state.
     */
    protected function onHistory(Request $request): void
    {
        $data = $request->validate([
            'chats'                      => ['present', 'array', 'max:500'],
            'chats.*.jid'                => ['required', 'string', 'max:191'],
            'chats.*.name'               => ['nullable', 'string', 'max:191'],
            'chats.*.last_message_at'    => ['nullable', 'integer'],
            'messages'                   => ['present', 'array', 'max:500'],
            'messages.*.wa_message_id'   => ['nullable', 'string', 'max:191'],
            'messages.*.jid'             => ['required', 'string', 'max:191'],
            'messages.*.from_me'         => ['required', 'boolean'],
            'messages.*.push_name'       => ['nullable', 'string', 'max:191'],
            'messages.*.type'            => ['required', 'string', 'max:20'],
            'messages.*.body'            => ['nullable', 'string'],
            'messages.*.timestamp'       => ['required', 'integer'],
        ]);

        foreach ($data['chats'] as $row) {
            $chat = $this->importedChat($row['jid'], $row['name'] ?? null);

            if (! empty($row['last_message_at']) && ! $chat->last_message_at) {
                $chat->forceFill(['last_message_at' => Carbon::createFromTimestamp($row['last_message_at'])])->save();
            }
        }

        $rows = collect($data['messages'])->filter(fn ($m) => $m['timestamp'] > 0);

        if ($rows->isEmpty()) {
            return;
        }

        $chats = [];
        $now   = now();

        $insert = $rows->map(function ($m) use (&$chats, $now) {
            $chats[$m['jid']] ??= $this->importedChat($m['jid'], $m['from_me'] ? null : ($m['push_name'] ?? null));

            return [
                'wa_chat_id'    => $chats[$m['jid']]->id,
                'wa_message_id' => $m['wa_message_id'] ?? null,
                'direction'     => $m['from_me'] ? 'out' : 'in',
                'type'          => $m['type'],
                'body'          => ($m['body'] ?? '') !== '' ? $m['body'] : null,
                'status'        => $m['from_me'] ? 'delivered' : 'read',
                'sent_at'       => Carbon::createFromTimestamp($m['timestamp']),
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        });

        // wa_message_id is unique, so a chunk the phone sends twice is skipped.
        WaMessage::insertOrIgnore($insert->all());

        // Chats created by the import have no preview yet; give them their latest line.
        foreach ($chats as $chat) {
            $latest = $chat->messages()->latest('sent_at')->first();

            if ($latest && (! $chat->last_preview || ! $chat->last_message_at || $latest->sent_at->gt($chat->last_message_at))) {
                $chat->forceFill([
                    'last_preview'    => mb_substr($latest->preview, 0, 280),
                    'last_message_at' => $latest->sent_at,
                ])->save();
            }
        }
    }

    /**
     * Privacy id -> number pairs from the gateway. Any chat saved under one of
     * those privacy ids is moved onto the real number (merged if needed).
     */
    protected function onLids(Request $request): void
    {
        $data = $request->validate([
            'lids'       => ['required', 'array', 'max:1000'],
            'lids.*.lid' => ['required', 'string', 'max:191', 'ends_with:@lid'],
            'lids.*.pn'  => ['required', 'string', 'max:191', 'ends_with:@s.whatsapp.net'],
        ]);

        $map = collect($data['lids'])->pluck('pn', 'lid');

        // Only the few chats that are actually stored under a privacy id get touched.
        WaChat::whereIn('jid', $map->keys())->pluck('jid')
            ->each(fn ($lid) => WaChat::resolvePrivacyId($lid, $map[$lid]));
    }

    /**
     * forJid() for history. Imported chats sit in the normal list (sorted by
     * date, so live ones stay on top) but never carry an unread badge. They
     * were archived at first, and the owner took that to mean nothing arrived.
     */
    protected function importedChat(string $jid, ?string $name): WaChat
    {
        $existed = WaChat::where('jid', $jid)->exists();
        $chat    = WaChat::forJid($jid, $name);

        if (! $existed) {
            $chat->forceFill(['unread_count' => 0])->save();
        }

        return $chat;
    }
}
