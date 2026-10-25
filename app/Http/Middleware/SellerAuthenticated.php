<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('seller_id')) {
            return redirect()->route('seller.login')
                ->with('error', 'Please login to access your seller dashboard.');
        }
        return $next($request);
    }
}
