<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Blog posts, news stories and their schema are stored in the database with the
 * phone number typed into the HTML. When the business number changes, this
 * swaps every retired number (config/contact.php) for the current one on the
 * way out, so old content follows the new number without editing the database.
 *
 * Admin pages are left alone: chat history, leads and logs must show the
 * numbers that were really used.
 */
class SwapRetiredPhone
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $retired = config('contact.retired', []);
        if (! $retired || $request->is('admin', 'admin/*', 'seller/*', 'api/*')) {
            return $response;
        }

        $type = (string) $response->headers->get('Content-Type', 'text/html');
        if (! preg_match('#text/|xml|json|javascript#i', $type)) {
            return $response;
        }

        $content = $response->getContent();
        if ($content === false || $content === '') {
            return $response;
        }

        $new = config('contact.phone');
        $map = [];
        foreach ($retired as $old) {
            $map[$old] = $new;                                                                   // 9554102933
            $map[substr($old, 0, 5) . ' ' . substr($old, 5)] = substr($new, 0, 5) . ' ' . substr($new, 5); // 95541 02933
            $map[substr($old, 0, 5) . '-' . substr($old, 5)] = substr($new, 0, 5) . '-' . substr($new, 5); // 95541-02933
        }

        $swapped = strtr($content, $map);
        if ($swapped !== $content) {
            $response->setContent($swapped);
            if ($response->headers->has('Content-Length')) {
                $response->headers->set('Content-Length', (string) strlen($swapped));
            }
        }

        return $response;
    }
}
