<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Shared spam trap for the public forms. Pairs with the <x-honeypot /> blade
 * component — the field is invisible, so only a bot ever fills it.
 */
trait ChecksHoneypot
{
    /** The hidden field's name. Must match components/honeypot.blade.php. */
    protected string $honeypotField = 'website_url';

    protected function isSpam(Request $request): bool
    {
        $trap = trim((string) $request->input($this->honeypotField));

        if ($trap === '') {
            return false;
        }

        // A dropped submission must never be invisible. If a browser ever
        // autofills the trap, this log is the only way to find out that real
        // enquiries are being thrown away.
        Log::warning('Honeypot triggered — submission dropped', [
            'trap_value' => $trap,
            'name'       => $request->input('full_name') ?? $request->input('name'),
            'phone'      => $request->input('phone_number') ?? $request->input('mobile'),
            'email'      => $request->input('email'),
            'page_url'   => $request->input('page_url'),
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return true;
    }

    /**
     * Second layer: Cloudflare Turnstile (only when its keys are set; the widget comes with
     * <x-honeypot />). Unlike the honeypot, a failure here is shown to the visitor, because it
     * is usually a real person whose check hadn't finished or whose token was already used.
     * A fake "thank you" would lose their lead. Returns null when the check passes.
     */
    protected function turnstileFailed(Request $request): ?\Illuminate\Http\JsonResponse
    {
        if (\App\Support\Turnstile::passes($request->input('cf-turnstile-response'), $request->ip())) {
            return null;
        }
        Log::warning('Turnstile failed — visitor asked to retry', [
            'name'       => $request->input('full_name') ?? $request->input('name'),
            'phone'      => $request->input('phone_number') ?? $request->input('mobile'),
            'email'      => $request->input('email'),
            'page_url'   => $request->input('page_url'),
            'had_token'  => (bool) $request->input('cf-turnstile-response'),
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        $msg = "Security check didn't complete. Please wait a moment and try again.";
        return response()->json(['success' => false, 'message' => $msg, 'errors' => ['security' => [$msg]]]);
    }

    /**
     * Bots are told the submission succeeded. Returning an error just tells
     * whoever wrote the bot to go and fix it.
     */
    protected function silentSuccess(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['success' => true]);
    }
}
