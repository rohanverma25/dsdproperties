<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $articles = NewsArticle::published()
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // ── Static pages ──────────────────────────────────────
        $staticPages = [
            ['url' => url('/'),                                              'priority' => '1.0', 'freq' => 'weekly'],
            ['url' => url('/about'),                                         'priority' => '0.7', 'freq' => 'monthly'],
            ['url' => url('/blog'),                                          'priority' => '0.9', 'freq' => 'weekly'],
            ['url' => route('news.index'),                                   'priority' => '0.9', 'freq' => 'daily'],
            ['url' => url('/rera-approved-projects-lucknow'),                'priority' => '0.9', 'freq' => 'weekly'],
            ['url' => url('/lda-schemes'),                                   'priority' => '0.9', 'freq' => 'weekly'],
            ['url' => url('/services/property-verification-lucknow'),        'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => url('/services/property-advisory-lucknow'),            'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => url('/contact-us'),                                    'priority' => '0.5', 'freq' => 'monthly'],
        ];

        $today = date('Y-m-d');
        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$page['url']}</loc>\n";
            $xml .= "    <lastmod>{$today}</lastmod>\n";
            $xml .= "    <changefreq>{$page['freq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        // ── News article pages ────────────────────────────────
        foreach ($articles as $article) {
            $url     = route('news.show', $article->slug);
            $lastmod = $article->updated_at->toAtomString();

            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url}</loc>\n";
            $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}