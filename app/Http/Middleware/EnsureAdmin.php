<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Gates every /admin/* URL behind a login.
 *
 * This runs on the whole `web` group rather than being attached to individual
 * routes, because the admin routes in web.php are declared in a dozen scattered
 * blocks — a path-based guard cannot be forgotten when a new one is added.
 */
class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->is('admin', 'admin/*')) {
            return $next($request);
        }

        foreach (config('admin.public_paths', []) as $path) {
            if ($request->is($path)) {
                return $next($request);
            }
        }

        if (! Auth::check()) {
            // redirect()->guest() remembers the URL, so login returns you here.
            return $request->expectsJson()
                ? abort(401)
                : redirect()->guest(route('login'));
        }

        if (! $this->isAdmin(Auth::user()?->email)) {
            abort(403, 'This area is restricted.');
        }

        return $next($request);
    }

    private function isAdmin(?string $email): bool
    {
        return $email !== null
            && in_array(strtolower($email), config('admin.emails', []), true);
    }
}
