<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificationAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->get('ver_admin_authenticated')) {
            return redirect()->route('ver.admin.login');
        }

        return $next($request);
    }
}
