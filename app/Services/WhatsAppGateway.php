<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Thin HTTP client for the Baileys gateway in whatsapp-service/.
 *
 * Every method here can fail because a separate process is down, so callers get
 * either a plain array or a RuntimeException with a message fit to show an admin.
 */
class WhatsAppGateway
{
    protected function request()
    {
        return Http::baseUrl(rtrim(config('whatsapp.base_url'), '/'))
            ->timeout(config('whatsapp.timeout'))
            ->acceptJson()
            ->withHeaders(['X-Api-Token' => config('whatsapp.api_token')]);
    }

    /**
     * Connection state, plus the QR data-url while a scan is pending.
     * Never throws — the connect screen has to render even when the gateway is off.
     */
    public function status(): array
    {
        try {
            $res = $this->request()->get('/status');

            if ($res->failed()) {
                return $this->offline('Gateway returned HTTP ' . $res->status());
            }

            return $res->json() + ['ok' => true];
        } catch (\Throwable $e) {
            return $this->offline($e->getMessage());
        }
    }

    public function isConnected(): bool
    {
        return ($this->status()['connection'] ?? null) === 'open';
    }

    /**
     * Send a text message.
     *
     * @return array{wa_message_id:?string, jid:string, timestamp:int}
     * @throws RuntimeException when the gateway refuses or is unreachable
     */
    public function sendText(string $to, string $text): array
    {
        try {
            $res = $this->request()->post('/send', ['to' => $to, 'text' => $text]);
        } catch (\Throwable $e) {
            Log::warning('WhatsApp gateway unreachable', ['error' => $e->getMessage()]);
            throw new RuntimeException('The WhatsApp service is not running. Start it and try again.');
        }

        if ($res->failed()) {
            throw new RuntimeException($res->json('error') ?: 'WhatsApp refused the message (HTTP ' . $res->status() . ').');
        }

        return $res->json();
    }

    /**
     * Send a file. The bytes are posted to the gateway rather than shared on
     * disk, so the two processes only have to agree on a port.
     *
     * @param  string  $kind  image|video|audio|document — how WhatsApp renders it
     * @throws RuntimeException when the gateway refuses or is unreachable
     */
    public function sendMedia(string $to, string $path, string $name, string $kind, ?string $caption = null): array
    {
        try {
            $res = $this->request()
                ->attach('file', file_get_contents($path), $name)
                ->post('/send-media', array_filter([
                    'to'      => $to,
                    'kind'    => $kind,
                    'caption' => $caption,
                ], fn ($v) => $v !== null && $v !== ''));
        } catch (\Throwable $e) {
            Log::warning('WhatsApp gateway unreachable', ['error' => $e->getMessage()]);
            throw new RuntimeException('The WhatsApp service is not running. Start it and try again.');
        }

        if ($res->failed()) {
            throw new RuntimeException($res->json('error') ?: 'WhatsApp refused the file (HTTP ' . $res->status() . ').');
        }

        return $res->json();
    }

    /** Mark messages read on WhatsApp itself. Best effort — a failure is not worth an error. */
    public function markRead(string $jid, array $messageIds): void
    {
        if (! $messageIds) {
            return;
        }

        try {
            $this->request()->post('/read', ['jid' => $jid, 'message_ids' => $messageIds]);
        } catch (\Throwable $e) {
            Log::debug('WhatsApp read receipt failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Ask the gateway to deliver one notification to many browsers.
     *
     * @param  array<int,array{endpoint:string,p256dh:string,auth:string}>  $subscriptions
     * @return array<int,array{endpoint:string,ok:bool,expired:bool}>  empty when the gateway is unreachable
     */
    public function push(array $payload, array $subscriptions): array
    {
        if (! $subscriptions) {
            return [];
        }

        try {
            $res = $this->request()
                ->timeout(20)   // one HTTP call per browser happens inside the gateway
                ->post('/push', ['payload' => $payload, 'subscriptions' => $subscriptions]);
        } catch (\Throwable $e) {
            Log::warning('WhatsApp push: gateway unreachable', ['error' => $e->getMessage()]);

            return [];
        }

        if ($res->failed()) {
            Log::warning('WhatsApp push: gateway refused', ['error' => $res->json('error') ?: $res->status()]);

            return [];
        }

        return $res->json('results') ?: [];
    }

    /** Drop the session so the next scan can link a different number. */
    public function logout(): void
    {
        try {
            $this->request()->post('/logout');
        } catch (\Throwable $e) {
            throw new RuntimeException('Could not reach the WhatsApp service to log out.');
        }
    }

    protected function offline(string $reason): array
    {
        return [
            'ok'         => false,
            'connection' => 'offline',
            'qr'         => null,
            'me'         => null,
            'last_error' => $reason,
        ];
    }
}
