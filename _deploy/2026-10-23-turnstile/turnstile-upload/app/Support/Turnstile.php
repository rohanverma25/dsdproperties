<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Cloudflare Turnstile check for the public forms.
 * Off until both TURNSTILE_SITE_KEY and TURNSTILE_SECRET_KEY are in .env.
 */
class Turnstile
{
    public static function enabled(): bool
    {
        return (bool) config('services.turnstile.site_key') && (bool) config('services.turnstile.secret_key');
    }

    /**
     * True when the token is valid (or Turnstile is off). If Cloudflare itself can't be reached,
     * the form is let through and the outage is logged, so a Cloudflare problem never costs us leads.
     */
    public static function passes(?string $token, ?string $ip = null): bool
    {
        if (! self::enabled()) {
            return true;
        }
        if (! $token) {
            return false;
        }
        try {
            $res = Http::asForm()->timeout(6)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret'   => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $ip,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Turnstile unreachable, form allowed', ['error' => $e->getMessage()]);
            return true;
        }
        if (! $res->successful()) {
            Log::warning('Turnstile error response, form allowed', ['status' => $res->status()]);
            return true;
        }
        return (bool) $res->json('success');
    }
}
