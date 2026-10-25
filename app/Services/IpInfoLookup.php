<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Resolves an IP to a location via ipinfo.io.
 *
 * Tries the full API first (city + region + country). When its free 50k/month
 * quota is hit the API answers 429, so we park it in a short cooldown and fall
 * back to ipinfo Lite (country only, separate 50k quota). Once the cooldown
 * expires we probe the full API again, so the normal source resumes by itself
 * when the monthly quota resets.
 */
class IpInfoLookup
{
    private const COOLDOWN_FULL = 'ipinfo:cooldown:full';
    private const COOLDOWN_LITE = 'ipinfo:cooldown:lite';

    /** How long to stop calling an endpoint after it reports a rate limit. */
    private const COOLDOWN_MINUTES = 360; // 6 hours

    /** @return array{city: ?string, region: ?string, country: ?string, source: string}|null */
    public function lookup(string $ip): ?array
    {
        if (!Cache::has(self::COOLDOWN_FULL)) {
            if ($data = $this->full($ip)) {
                return $data;
            }
        }

        if (!Cache::has(self::COOLDOWN_LITE)) {
            if ($data = $this->lite($ip)) {
                return $data;
            }
        }

        return null;
    }

    private function full(string $ip): ?array
    {
        $token = config('services.ipinfo.token');
        $response = $this->call("https://ipinfo.io/{$ip}/json", $token, self::COOLDOWN_FULL);

        if (!$response) {
            return null;
        }

        return [
            'city'    => $response['city']    ?? null,
            'region'  => $response['region']  ?? null,
            'country' => $response['country'] ?? null, // already a 2-letter code
            'source'  => 'ipinfo',
        ];
    }

    private function lite(string $ip): ?array
    {
        $token = config('services.ipinfo.lite_token') ?: config('services.ipinfo.token');
        $response = $this->call("https://api.ipinfo.io/lite/{$ip}", $token, self::COOLDOWN_LITE);

        if (!$response) {
            return null;
        }

        // Lite carries no city/region — country is all we get.
        return [
            'city'    => null,
            'region'  => null,
            'country' => $response['country_code'] ?? null,
            'source'  => 'ipinfo-lite',
        ];
    }

    private function call(string $url, ?string $token, string $cooldownKey): ?array
    {
        if (!$token) {
            return null;
        }

        try {
            $response = Http::timeout(3)->get($url, ['token' => $token]);
        } catch (\Throwable $e) {
            Log::warning('ipinfo request failed: ' . $e->getMessage());
            return null;
        }

        // 429 = monthly quota exhausted, 403 = token rejected. Both mean
        // "stop asking for a while" rather than "this one IP failed".
        if (in_array($response->status(), [403, 429], true)) {
            Cache::put($cooldownKey, true, now()->addMinutes(self::COOLDOWN_MINUTES));
            Log::warning("ipinfo quota hit ({$response->status()}) on {$url}, cooling down.");
            return null;
        }

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        return is_array($data) ? $data : null;
    }
}
