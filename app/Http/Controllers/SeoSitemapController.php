<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoSitemapController extends Controller
{
    // High-priority static pages that are not SEO landing pages or blogs
    protected static array $staticPages = [
        ['loc' => 'services/property-advisory-lucknow',   'changefreq' => 'monthly', 'priority' => '0.9'],
        ['loc' => 'services/property-verification-lucknow','changefreq' => 'monthly', 'priority' => '0.9'],
        ['loc' => 'tools/stamp-duty-calculator-lucknow',  'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => 'about',                                 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['loc' => 'contact-us',                            'changefreq' => 'monthly', 'priority' => '0.7'],
        ['loc' => 'lda-schemes',                           'changefreq' => 'weekly',  'priority' => '0.8'],
        ['loc' => 'awas-vikas-schemes',                    'changefreq' => 'weekly',  'priority' => '0.8'],
        ['loc' => 'rera-approved-projects-lucknow',        'changefreq' => 'weekly',  'priority' => '0.8'],
    ];

    public function index(): Response
    {
        $slugs = SeoLandingController::getSlugs();
        $today = now()->toAtomString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static service/tool/info pages
        foreach (self::$staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . url($page['loc']) . "</loc>\n";
            $xml .= "    <lastmod>{$today}</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        // SEO landing pages
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
