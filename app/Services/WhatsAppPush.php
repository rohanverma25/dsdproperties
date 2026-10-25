<?php

namespace App\Services;

use App\Models\WaChat;
use App\Models\WaMessage;
use App\Models\WaPushSubscription;
use Illuminate\Support\Facades\Log;

/**
 * Browser notifications for incoming WhatsApp messages.
 *
 * Laravel owns the subscriptions; the Node gateway signs and delivers them.
 * The encryption Web Push needs is elliptic-curve work that PHP can only do
 * with ext-gmp, which many shared hosts leave off — the gateway is already a
 * long-running process and has it built in.
 *
 * Nothing here is allowed to break message handling: every failure is logged
 * and swallowed, because a missed notification is far cheaper than a dropped
 * message.
 */
class WhatsAppPush
{
    public function __construct(protected WhatsAppGateway $gateway)
    {
    }

    public function configured(): bool
    {
        return filled(config('whatsapp.vapid.public_key'));
    }

    public function notifyNewMessage(WaChat $chat, WaMessage $message): void
    {
        $this->send([
            'title' => $chat->display_name,
            'body'  => mb_substr($message->preview, 0, 160),
            'tag'   => 'wa-chat-' . $chat->id,          // one notification per chat, replaced not stacked
            'url'   => route('admin.whatsapp.chat', $chat),
            'chat'  => $chat->id,
        ]);
    }

    /** @param  array<string,mixed>  $payload */
    public function send(array $payload): void
    {
        if (! $this->configured()) {
            return;
        }

        $subscriptions = WaPushSubscription::all();

        if ($subscriptions->isEmpty()) {
            return;
        }

        $results = $this->gateway->push($payload, $subscriptions->map(fn ($s) => [
            'endpoint' => $s->endpoint,
            'p256dh'   => $s->p256dh,
            'auth'     => $s->auth,
        ])->all());

        $byEndpoint = $subscriptions->keyBy('endpoint');

        foreach ($results as $result) {
            $sub = $byEndpoint[$result['endpoint'] ?? ''] ?? null;

            if (! $sub) {
                continue;
            }

            // 404/410 means the browser threw the subscription away.
            if ($result['expired'] ?? false) {
                $sub->delete();
            } elseif ($result['ok'] ?? false) {
                $sub->forceFill(['last_sent_at' => now()])->save();
            }
        }

        $failed = collect($results)->filter(fn ($r) => ! ($r['ok'] ?? false) && ! ($r['expired'] ?? false))->count();

        if ($failed > 0) {
            Log::warning('WhatsApp push: ' . $failed . ' notification(s) were not delivered');
        }
    }
}
