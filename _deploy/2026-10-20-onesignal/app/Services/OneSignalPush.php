<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Sends one web push through the OneSignal REST API.
 * Audience: 'all', 'topic:<key>' (tag topic_<key> = 1) or 'test:<subscription id>'.
 */
class OneSignalPush
{
    private const ENDPOINT = 'https://api.onesignal.com/notifications?c=push';

    public function configured(): bool
    {
        return filled(config('push.app_id')) && filled(config('push.rest_api_key'));
    }

    /**
     * @return array{status: string, id: ?string, error: ?string}
     */
    public function send(string $title, string $message, string $url, string $audience, ?string $image = null): array
    {
        $payload = [
            'app_id'          => config('push.app_id'),
            'target_channel'  => 'push',
            'headings'        => ['en' => $title],
            'contents'        => ['en' => $message],
            'web_url'         => $url,
            'chrome_web_icon' => asset(config('push.icon')),
        ] + $this->target($audience);

        if ($image) {
            $payload['chrome_web_image'] = $image;
        }

        try {
            $response = Http::timeout(20)
                ->withHeaders(['Authorization' => 'Key ' . config('push.rest_api_key')])
                ->acceptJson()
                ->post(self::ENDPOINT, $payload);
        } catch (\Throwable $e) {
            return ['status' => 'failed', 'id' => null, 'error' => $e->getMessage()];
        }

        $body   = $response->json() ?? [];
        $errors = $body['errors'] ?? null;

        if (!$response->successful()) {
            return ['status' => 'failed', 'id' => null, 'error' => 'HTTP ' . $response->status() . ': ' . $response->body()];
        }

        // An empty id means nobody matched the audience.
        if (empty($body['id'])) {
            return ['status' => 'no_recipients', 'id' => null, 'error' => $errors ? json_encode($errors, JSON_UNESCAPED_UNICODE) : null];
        }

        return ['status' => 'sent', 'id' => $body['id'], 'error' => $errors ? json_encode($errors, JSON_UNESCAPED_UNICODE) : null];
    }

    private function target(string $audience): array
    {
        if (str_starts_with($audience, 'test:')) {
            return ['include_subscription_ids' => [substr($audience, 5)]];
        }

        if (str_starts_with($audience, 'topic:')) {
            return ['filters' => [[
                'field'    => 'tag',
                'key'      => 'topic_' . substr($audience, 6),
                'relation' => '=',
                'value'    => '1',
            ]]];
        }

        return ['included_segments' => ['Total Subscriptions']];
    }
}
