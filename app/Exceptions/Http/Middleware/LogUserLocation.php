<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Http;

class LogUserLocation
{
    public function handle(Request $request, Closure $next)
    {
        // Check if cookie exists → skip
        if (!$request->hasCookie('location_logged')) {
            $ip = $request->ip();

            // Prevent logging localhost
            if ($ip !== "127.0.0.1" && $ip !== "::1" && $ip !== "103.226.203.31"  && $ip !== "103.226.203.31") {
                // Check if IP is already stored
                if (!UserLocation::where('ip', $ip)->exists()) {
                    // Fetch location from ipinfo.io (free up to 50k req/month)
                    $response = Http::get("https://ipinfo.io/{$ip}/json?token=8e966db63bb9ef");
 
                    if ($response->successful()) {
                        $data = $response->json();
                        $currentPage = request()->fullUrl();
                        UserLocation::create([
                            'ip'      => $ip,
                            'city'    => $data['city'] ?? null,
                            'region'  => $data['region'] ?? null,
                            'country' => $data['country'] ?? null,
                            'page'    => $currentPage ?? null,

                        ]);
                   }
                }
            }

            // Set cookie for 1 day (1440 min) → adjust as needed
            cookie()->queue(cookie('location_logged', true, 1440));
        }

        return $next($request);
    }
}
