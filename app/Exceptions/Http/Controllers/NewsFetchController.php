<?php

// FILE: app/Http/Controllers/NewsFetchController.php
//
// TRIGGER VIA BROWSER:
//   https://dsdproperties.in/admin/news/fetch?token=YOUR_SECRET_TOKEN
//
// SETUP:
//   1. Add to .env:  NEWS_FETCH_TOKEN=put_any_random_string_here
//   2. Add to routes/web.php:
//        Route::get('/admin/news/fetch', [NewsFetchController::class, 'fetch'])->name('admin.news.fetch');
//
// CRON (optional, if your hosting has cPanel cron):
//   Use the URL cron method — paste this into cPanel cron job:
//   curl -s "https://dsdproperties.in/admin/news/fetch?token=YOUR_SECRET_TOKEN" > /dev/null
//   Set schedule: Daily at 8:00 AM

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsService;
use Illuminate\Support\Facades\Log;

class NewsFetchController extends Controller
{
    // ─────────────────────────────────────────────────────
    //  GET /admin/news/fetch?token=YOUR_TOKEN
    // ─────────────────────────────────────────────────────
    public function fetch(Request $request)
    {
        // ── SECURITY CHECK ────────────────────────────────
        // Token protects this URL so random people can't trigger it
        $expectedToken = config('services.news_fetch.token'); // from .env
        $providedToken = $request->query('token');

        if (empty($expectedToken)) {
            Log::error('[NewsFetchController] NEWS_FETCH_TOKEN not set in .env');
            return $this->renderPage(false, 0, [[
                'type'    => 'error',
                'message' => 'NEWS_FETCH_TOKEN is not set in .env. Please add it.',
                'time'    => now()->format('H:i:s'),
            ]]);
        }

        if ($providedToken !== $expectedToken) {
            Log::warning('[NewsFetchController] Invalid token attempt', [
                'ip'    => $request->ip(),
                'token' => $providedToken,
            ]);
            // Return 403 — don't even hint what the right token is
            abort(403, 'Unauthorized. Provide the correct ?token= in the URL.');
        }

        // ── RUN THE SERVICE ───────────────────────────────
        Log::info('[NewsFetchController] Fetch triggered via browser', ['ip' => $request->ip()]);

        $service = new NewsService();
        $result  = $service->run();

        return $this->renderPage($result['success'], $result['saved'], $result['log']);
    }

    // ─────────────────────────────────────────────────────
    //  Render a clean HTML page in the browser
    //  Shows colour-coded log output so you can debug easily
    // ─────────────────────────────────────────────────────
    private function renderPage(bool $success, int $saved, array $logs): \Illuminate\Http\Response
    {
        // Colour map for each log type
        $colors = [
            'info'    => '#60a5fa', // blue
            'success' => '#4ade80', // green
            'warn'    => '#fbbf24', // yellow
            'error'   => '#f87171', // red
            'skip'    => '#94a3b8', // grey
        ];

        // Icons per type
        $icons = [
            'info'    => 'ℹ',
            'success' => '✓',
            'warn'    => '⚠',
            'error'   => '✗',
            'skip'    => '⏭',
        ];

        // Build log rows HTML
        $logRows = '';
        foreach ($logs as $entry) {
            $color   = $colors[$entry['type']]  ?? '#94a3b8';
            $icon    = $icons[$entry['type']]   ?? '·';
            $message = htmlspecialchars($entry['message']);
            $time    = htmlspecialchars($entry['time']);

            $logRows .= <<<HTML
                <div style="display:flex;gap:12px;align-items:flex-start;padding:6px 0;border-bottom:1px solid #1e293b">
                    <span style="color:{$color};font-weight:bold;min-width:20px;flex-shrink:0">{$icon}</span>
                    <span style="color:#94a3b8;font-size:12px;flex-shrink:0;margin-top:1px">{$time}</span>
                    <span style="color:{$color}">{$message}</span>
                </div>
            HTML;
        }

        $statusText  = $success ? '✅ Completed Successfully' : '❌ Completed with Errors';
        $statusColor = $success ? '#4ade80' : '#f87171';
        $savedText   = "{$saved} article(s) saved to DB with status = pending";

        // Full HTML page
        $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>News Fetch — DSD Properties</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #0f172a; color: #e2e8f0; font-family: 'Courier New', monospace; font-size: 14px; padding: 30px 20px; }
        .container { max-width: 860px; margin: 0 auto; }
        .header { border-bottom: 2px solid #1e293b; padding-bottom: 20px; margin-bottom: 24px; }
        .header h1 { font-size: 20px; color: #f8fafc; margin-bottom: 6px; }
        .header p  { color: #64748b; font-size: 12px; }
        .status-bar { background: #1e293b; border-radius: 8px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
        .status-text { color: {$statusColor}; font-weight: bold; font-size: 16px; }
        .saved-text  { color: #94a3b8; font-size: 13px; }
        .log-box { background: #0f172a; border: 1px solid #1e293b; border-radius: 8px; padding: 20px; }
        .log-title { color: #64748b; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 12px; }
        .actions { margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap; }
        .btn { background: #1e40af; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-size: 13px; font-weight: bold; transition: opacity 0.15s; }
        .btn:hover { opacity: 0.85; }
        .btn-secondary { background: #1e293b; }
        .footer { margin-top: 24px; color: #334155; font-size: 11px; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>DSD Properties — News Fetch Job</h1>
        <p>Ran at: {$this->currentDatetime()} &nbsp;·&nbsp; Check Laravel logs for full details: storage/logs/laravel.log</p>
    </div>

    <div class="status-bar">
        <span class="status-text">{$statusText}</span>
        <span class="saved-text">{$savedText}</span>
    </div>

    <div class="log-box">
        <div class="log-title">Job Output</div>
        {$logRows}
    </div>

    <div class="actions">
        <a href="/admin/news" class="btn">Review Pending Articles →</a>
        <a href="/news" class="btn btn-secondary">View News Page →</a>
    </div>

    <div class="footer">
        ⚠ Keep the ?token= URL secret. Regenerate the token in .env if exposed.<br>
        To set up auto-run: add a cPanel cron calling this URL daily at 8 AM.
    </div>

</div>
</body>
</html>
HTML;

        return response($html, 200)->header('Content-Type', 'text/html');
    }

    private function currentDatetime(): string
    {
        return now()->format('D, M j Y · H:i:s');
    }
}
