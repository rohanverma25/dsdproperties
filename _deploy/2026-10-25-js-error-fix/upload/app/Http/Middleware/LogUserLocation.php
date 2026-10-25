<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\UserLocation;
use App\Services\IpInfoLookup;

class LogUserLocation
{
    /** IPs we never log (localhost + office). */
    private const SKIP_IPS = ['127.0.0.1', '::1', '103.226.203.31'];

    public function __construct(private IpInfoLookup $ipInfo)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        // Check if cookie exists → skip
        if (!$request->hasCookie('location_logged')) {
            $ip = $request->ip();

            if (!in_array($ip, self::SKIP_IPS, true)) {
                // Check if IP is already stored
                if (!UserLocation::where('ip', $ip)->exists()) {
                    $location = $this->ipInfo->lookup($ip);

                    if ($location) {
                        // Two parallel first requests from one visitor both pass the exists() check above;
                        // the second insert then hits the unique `ip` key. That used to crash the page, so
                        // treat "already logged" (MySQL 1062) as done.
                        try {
                            UserLocation::create([
                                'ip'      => $ip,
                                'city'    => $location['city'],
                                'region'  => $location['region'],
                                'country' => $location['country'],
                                'page'    => $request->fullUrl(),
                            ]);
                        } catch (QueryException $e) {
                            if (($e->errorInfo[1] ?? null) !== 1062) {
                                throw $e;
                            }
                        }
                    }
                }
            }

            // Set cookie for 1 day (1440 min) → adjust as needed
            cookie()->queue(cookie('location_logged', true, 1440));
        }

        return $next($request);
    }
}
