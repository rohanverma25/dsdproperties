<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // ─────────────────────────────────────────────────────
    //  GET /news
    // ─────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $category = $request->query('category');

        $query = NewsArticle::published()
            ->orderBy('created_at', 'desc');

        if ($category && $category !== 'all') {
            $query->byCategory($category);
        }

        $articles = $query->paginate(10);

        return view('news.index', compact('articles', 'category'));
    }

    // ─────────────────────────────────────────────────────
    //  GET /news/{slug}
    // ─────────────────────────────────────────────────────
    public function show(string $slug)
    {
        $article = NewsArticle::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = NewsArticle::published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('news.show', compact('article', 'related'));
    }

    // ─────────────────────────────────────────────────────
    //  GET /admin/news/fetch
    //  Trigger via browser:
    //  /admin/news/fetch?token=YOUR_SECRET&topic=YOUR+TOPIC
    // ─────────────────────────────────────────────────────
    public function fetch(Request $request)
    {
        // ── Token guard ───────────────────────────────────
        $token = $request->query('token');
        // if ($token !== 111) {
        //     abort(403, 'Unauthorised.');
        // }

        // ── Topic guard ───────────────────────────────────
        $topic = trim($request->query('topic', ''));
        if (empty($topic)) {
            return response(
                '<pre style="font-family:monospace;padding:20px;">'
                . '❌ No topic provided.\n\n'
                . 'Usage: /admin/news/fetch?token=YOUR_TOKEN&amp;topic=YOUR+TOPIC\n\n'
                . 'Example:\n'
                . '/admin/news/fetch?token=abc123&amp;topic=ED attaches ₹313 crore in Ansal Group case'
                . '</pre>',
                400
            )->header('Content-Type', 'text/html');
        }

        // ── Run the service ───────────────────────────────
        $service = new NewsService();
        $result  = $service->run($topic);

        // ── Render a simple browser-readable log page ─────
        $html  = '<!DOCTYPE html><html><head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<title>News Fetch — DSD Properties</title>';
        $html .= '<style>
            body  { font-family: monospace; background: #0f172a; color: #e2e8f0;
                    padding: 30px; line-height: 1.7; font-size: 14px; }
            h2    { color: #93c5fd; margin-bottom: 20px; }
            .line { padding: 3px 0; }
            .info    { color: #94a3b8; }
            .success { color: #4ade80; }
            .warn    { color: #fbbf24; }
            .error   { color: #f87171; }
            .skip    { color: #a78bfa; }
            .time    { color: #475569; margin-right: 10px; }
            .summary { margin-top: 24px; padding: 16px 20px;
                       background: #1e293b; border-radius: 10px;
                       border-left: 4px solid #3b82f6; }
            a { color: #60a5fa; }
        </style>';
        $html .= '</head><body>';
        $html .= '<h2>✦ DSD News Fetch Log</h2>';
        $html .= '<div><strong style="color:#cbd5e1;">Topic:</strong> '
               . htmlspecialchars($topic) . '</div><br>';

        foreach ($result['log'] as $entry) {
            $cls  = htmlspecialchars($entry['type']);
            $time = htmlspecialchars($entry['time']);
            $msg  = htmlspecialchars($entry['message']);
            $html .= "<div class=\"line\"><span class=\"time\">{$time}</span>"
                   . "<span class=\"{$cls}\">{$msg}</span></div>";
        }

        $html .= '<div class="summary">';
        if ($result['success']) {
            $html .= '✅ <strong>Success.</strong> '
                   . $result['saved'] . ' article(s) saved with status = <em>pending</em>.<br>'
                   . '<a href="/admin/news" style="color:#60a5fa;">→ Go to Admin to review &amp; publish</a>';
        } else {
            $html .= '❌ <strong>Failed.</strong> No articles were saved. See errors above.';
        }
        $html .= '</div></body></html>';

        return response($html)->header('Content-Type', 'text/html');
    }

}