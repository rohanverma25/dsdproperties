<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoSitemapController extends Controller
{
    public function index(): Response
    {
        $slugs = SeoLandingController::getSlugs();
        $today = now()->toAtomString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($slugs as $slug) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . url('/' . $slug) . "</loc>\n";
            $xml .= "    <lastmod>{$today}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
