<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Weekly newsletter tracking: the open pixel and click redirects in every email.
 * Clicks only redirect to our own site or WhatsApp, so the URL can't be used as an open redirect.
 * Hits within 2 minutes of sending, or from known scanners, are counted as likely bots.
 */
class NewsletterTrackController extends Controller
{
    private const HOSTS = ['dsdproperties.in', 'www.dsdproperties.in', 'wa.me', 'api.whatsapp.com'];

    private const BOT_UA = '/bot|crawler|spider|preview|scanner|barracuda|proofpoint|mimecast|safelinks|python|curl|wget|headless/i';

    public function open(string $token)
    {
        $d = DB::table('newsletter_deliveries')->where('token', $token)->first();
        if ($d && ! $this->isBot($d, request())) {
            DB::table('newsletter_deliveries')->where('id', $d->id)->update([
                'opened_at'  => $d->opened_at ?? now(),
                'open_count' => DB::raw('open_count + 1'),
            ]);
        }
        // 1x1 transparent GIF
        return response(base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'), 200, [
            'Content-Type'  => 'image/gif',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }

    public function click(Request $request, string $token)
    {
        $url  = (string) $request->query('u', '');
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        if (! in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true) || ! in_array($host, self::HOSTS, true)) {
            return redirect('https://dsdproperties.in/news');
        }

        $d = DB::table('newsletter_deliveries')->where('token', $token)->first();
        if ($d) {
            $bot = $this->isBot($d, $request);
            DB::table('newsletter_clicks')->insert([
                'campaign_id' => $d->campaign_id,
                'delivery_id' => $d->id,
                'label'       => mb_substr((string) $request->query('l', ''), 0, 40) ?: null,
                'url'         => $url,
                'user_agent'  => mb_substr((string) $request->userAgent(), 0, 255),
                'likely_bot'  => $bot,
                'created_at'  => now(),
            ]);
            if (! $bot) {
                // A real click also proves the email was opened (images may be blocked)
                DB::table('newsletter_deliveries')->where('id', $d->id)->update([
                    'clicked_at'  => $d->clicked_at ?? now(),
                    'click_count' => DB::raw('click_count + 1'),
                    'opened_at'   => $d->opened_at ?? now(),
                ]);
            }
        }
        return redirect()->away($url);
    }

    private function isBot(object $d, Request $request): bool
    {
        if (preg_match(self::BOT_UA, (string) $request->userAgent())) return true;
        return $d->sent_at && now()->diffInSeconds(\Illuminate\Support\Carbon::parse($d->sent_at)) < 120;
    }
}
