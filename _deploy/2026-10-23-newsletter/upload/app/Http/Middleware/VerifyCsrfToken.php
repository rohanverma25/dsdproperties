<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // One-click unsubscribe POSTs come from mail apps (Gmail etc.), not our forms; the URL is signed instead.
        'newsletter/unsubscribe',
        'newsletter/language',
    ];
}
