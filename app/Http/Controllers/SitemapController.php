<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    // Google News sitemap: only stories published in the last 2 days (Google's rule),
    // max 1000, with <news:news> tags. Older stories are in /sitemap-news-archive.xml.
    public function index(): Response
    {
        $articles = NewsArticle::published()
            ->where('created_at', '>=', now()->subDays(2))
            ->orderBy('created_at', 'desc')
            ->limit(1000)
            ->get(['slug', 'title', 'lang', 'created_at']);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . "\n";

        foreach ($articles as $article) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . e(route('news.show', $article->slug)) . "</loc>\n";
            $xml .= "    <news:news>\n";
            $xml .= "      <news:publication>\n";
            $xml .= "        <news:name>DSD Properties</news:name>\n";
            $xml .= '        <news:language>' . ($article->lang === 'en' ? 'en' : 'hi') . "</news:language>\n";
            $xml .= "      </news:publication>\n";
            $xml .= '      <news:publication_date>' . $article->created_at->toAtomString() . "</news:publication_date>\n";
            $xml .= '      <news:title>' . e($article->title) . "</news:title>\n";
            $xml .= "    </news:news>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    // Every published story, for normal search indexing.
    public function archive(): Response
    {
        $articles = NewsArticle::published()
            ->orderBy('created_at', 'desc')
            ->get(['slug', 'updated_at']);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($articles as $article) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . e(route('news.show', $article->slug)) . "</loc>\n";
            $xml .= '    <lastmod>' . $article->updated_at->toAtomString() . "</lastmod>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
