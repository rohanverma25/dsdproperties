<?php
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\BlogGenerateController;

use App\Http\Controllers\RentReceiptController;

use App\Http\Controllers\Admin\LeadImportController;
use App\Http\Controllers\Admin\CrmLeadController;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\Admin\WhatsAppSettingsController;
use App\Http\Controllers\Admin\CrmLeadImportController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;

use App\Http\Controllers\UserLocationController;
use App\Http\Controllers\NewsFetchController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BlogEditor\BlogEditorController;

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Artisan;
use App\Services\FetchLucknowNewsService;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\LdaSchemesController;
use App\Http\Controllers\AwasVikasSchemesController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SeoLandingController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogFeedbackController;
use App\Http\Controllers\Admin\FormSubmissionController;
use App\Http\Controllers\GoogleReviewController;
use App\Http\Controllers\SeoSitemapController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Seller\AuthController as SellerAuthController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ListingController as SellerListingController;
use App\Http\Controllers\Seller\TagController as SellerTagController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Mak.0e something great!
|
*/
// routes/web.php

use App\Http\Controllers\BlogsitemapController;

use App\Http\Controllers\SitemapController;

use App\Http\Controllers\ReraProjectController;

Route::get('/run-route-cache', function () {
    // config:clear makes Laravel re-read .env — needed after adding keys to the server .env
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    return "Config cleared; routes cleared and cached; views cleared!";
});

// ─────────────────────────────────────────────
// Seller Auth (public)
// ─────────────────────────────────────────────
Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/login',    [SellerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [SellerAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [SellerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register/step1', [SellerAuthController::class, 'registerStep1'])->name('register.step1');
    Route::get('/register/step2',  [SellerAuthController::class, 'showRegisterStep2'])->name('register.step2');
    Route::post('/register/step2', [SellerAuthController::class, 'registerStep2'])->name('register.step2.post');
    Route::get('/register/step3',  [SellerAuthController::class, 'showRegisterStep3'])->name('register.step3');
    Route::post('/register/step3', [SellerAuthController::class, 'registerStep3'])->name('register.step3.post');
    Route::post('/logout',  [SellerAuthController::class, 'logout'])->name('logout');

    // Protected seller routes
    Route::middleware('seller.auth')->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile',   [SellerDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile',   [SellerDashboardController::class, 'updateProfile'])->name('profile.update');

        Route::get('/listings',                        [SellerListingController::class, 'index'])->name('listings.index');
        Route::get('/listings/create',                 [SellerListingController::class, 'create'])->name('listings.create');
        Route::post('/listings/draft',                 [SellerListingController::class, 'saveDraft'])->name('listings.draft.save');
        Route::post('/listings',                       [SellerListingController::class, 'store'])->name('listings.store');
        Route::get('/listings/{listing}/edit',         [SellerListingController::class, 'edit'])->name('listings.edit');
        Route::put('/listings/{listing}',              [SellerListingController::class, 'update'])->name('listings.update');
        Route::delete('/listings/{listing}',           [SellerListingController::class, 'destroy'])->name('listings.destroy');
        Route::get('/listings/{listing}/inquiries',    [SellerListingController::class, 'inquiries'])->name('listings.inquiries');

        Route::post('/tags', [SellerTagController::class, 'store'])->name('tags.store');
    });
});

// ─────────────────────────────────────────────
// Public Property Listings
// ─────────────────────────────────────────────
Route::get('/properties',           [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{slug}',    [PropertyController::class, 'show'])->name('properties.show');
Route::post('/properties/{listing}/inquiry', [PropertyController::class, 'inquiry'])->name('properties.inquiry');

// ─── SEO Landing Pages (slugs generated from SeoLandingController::getSlugs) ─
Route::get('/{seoPage}', [SeoLandingController::class, 'show'])
    ->where('seoPage', implode('|', SeoLandingController::getSlugs()))
    ->name('seo.landing');

// ─── Retired rental landing pages ───────────────────────────────────────────
// These URLs were indexed before letting was dropped from the site, so each one is
// permanently redirected to its sale equivalent instead of being left to 404.
Route::get('/{retiredPage}', function (string $retiredPage) {
    return redirect(SeoLandingController::retiredRedirects()[$retiredPage], 301);
})->where('retiredPage', implode('|', array_keys(SeoLandingController::retiredRedirects())))
  ->name('seo.retired');

// Unknown URLs get a real 404 (errors/404.blade.php), not a redirect — a
// redirect to a 200 page is a soft 404 to Google.
Route::fallback(function () {
    abort(404);
});

Route::get('/rera-approved-projects-lucknow', [ReraProjectController::class, 'index']);

Route::get('/sitemap-news.xml', [SitemapController::class, 'index'])->name('sitemap.news');

// Sitemap index. The old static sitemap.xml / sitemap-blogs.xml / sitemap-pages.xml files
// in the web root shadowed these routes and listed dead blog URLs — keep them deleted.
Route::get('/sitemap.xml', function () {
    $blogsLastmod = \Illuminate\Support\Facades\DB::table('blog_posts')->max('updated_at');
    $maps = [
        ['loc' => 'https://dsdproperties.in/sitemap-pages.xml',    'lastmod' => null],
        ['loc' => 'https://dsdproperties.in/sitemap-blogs.xml',    'lastmod' => $blogsLastmod],
        ['loc' => 'https://dsdproperties.in/sitemap-services.xml', 'lastmod' => null],
        ['loc' => 'https://dsdproperties.in/sitemap-seo.xml',      'lastmod' => null],
        ['loc' => 'https://dsdproperties.in/sitemap-news.xml',     'lastmod' => null],
    ];
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($maps as $m) {
        $xml .= "  <sitemap>\n    <loc>{$m['loc']}</loc>\n";
        if ($m['lastmod']) {
            $xml .= '    <lastmod>' . \Carbon\Carbon::parse($m['lastmod'])->toAtomString() . "</lastmod>\n";
        }
        $xml .= "  </sitemap>\n";
    }
    $xml .= '</sitemapindex>';
    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap.index');

// Static pages not covered by the services / seo / blog sitemaps.
Route::get('/sitemap-pages.xml', function () {
    $pages = [
        ['url' => 'https://dsdproperties.in/',                                           'priority' => '1.0', 'changefreq' => 'daily'],
        ['url' => 'https://dsdproperties.in/blog',                                       'priority' => '0.9', 'changefreq' => 'daily'],
        ['url' => 'https://dsdproperties.in/news',                                       'priority' => '0.8', 'changefreq' => 'daily'],
        ['url' => 'https://dsdproperties.in/properties',                                 'priority' => '0.8', 'changefreq' => 'daily'],
        ['url' => 'https://dsdproperties.in/tools/stamp-duty-calculator-lucknow',        'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/tools/stamp-duty-calculator-lucknow-hindi',  'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/lda-demolition-tracker',                     'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => 'https://dsdproperties.in/how-property-prices-are-calculated-in-lucknow', 'priority' => '0.6', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/reviews',                                    'priority' => '0.6', 'changefreq' => 'weekly'],
        ['url' => 'https://dsdproperties.in/about',                                      'priority' => '0.6', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/contact-us',                                 'priority' => '0.6', 'changefreq' => 'monthly'],
    ];
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($pages as $p) {
        $xml .= "  <url>\n    <loc>{$p['url']}</loc>\n    <changefreq>{$p['changefreq']}</changefreq>\n    <priority>{$p['priority']}</priority>\n  </url>\n";
    }
    $xml .= '</urlset>';
    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap.pages');

Route::get('/sitemap-blogs.xml', [BlogsitemapController::class, 'blogs'])->name('sitemap.blogs');
Route::get('/llms.txt', \App\Http\Controllers\LlmsTxtController::class)->name('llms.txt');
Route::get('/sitemap-seo.xml', [SeoSitemapController::class, 'index'])->name('sitemap.seo');
Route::get('/sitemap-services.xml', function () {
    $services = [
        ['url' => 'https://dsdproperties.in/services/property-verification-lucknow', 'priority' => '1.0', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-advisory-lucknow', 'priority' => '1.0', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-registry-lucknow', 'priority' => '1.0', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-verification-varanasi', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-verification-ayodhya', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-verification-prayagraj', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-verification-gorakhpur', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-verification-noida', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-verification-greater-noida', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-verification-agra', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-registry-varanasi',     'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-registry-ayodhya',      'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-registry-gorakhpur',    'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-registry-prayagraj',    'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-registry-agra',         'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-registry-noida',        'priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/services/property-registry-greater-noida','priority' => '0.9', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/lda-schemes', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['url' => 'https://dsdproperties.in/lda-plot-calculator', 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => 'https://dsdproperties.in/awas-vikas-schemes', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['url' => 'https://dsdproperties.in/seller/register', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/buyer/register', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => 'https://dsdproperties.in/rera-approved-projects-lucknow', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ];
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($services as $s) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$s['url']}</loc>\n";
        $xml .= "    <changefreq>{$s['changefreq']}</changefreq>\n";
        $xml .= "    <priority>{$s['priority']}</priority>\n";
        $xml .= "  </url>\n";
    }
    $xml .= '</urlset>';
    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap.services');

Route::get('/lda-schemes', [LdaSchemesController::class, 'index'])->name('lda.schemes');
Route::view('/lda-plot-calculator', 'pages.lda-plot-calculator')->name('lda.plot.calculator');
Route::view('/lucknow-circle-rate', 'pages.lucknow-circle-rate')->name('lucknow.circle.rate');
// Every mohalla page. NOT yet listed in /sitemap.xml: add it there when the noindex on the circle-rate page is lifted.
Route::get('/sitemap-circle-rate.xml', function () {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach (\App\Support\CircleRates::all() as $sro => $l) {
        foreach ($l['rows'] as $r) $xml .= '  <url><loc>' . e(\App\Support\CircleRates::url($sro, $r)) . "</loc></url>\n";
    }
    return response($xml . '</urlset>', 200, ['Content-Type' => 'application/xml']);
})->name('sitemap.circle-rate');

// One page per mohalla / village, e.g. /lucknow-circle-rate/mohanlalganj/mastemau: same page, opened on that mohalla
Route::get('/lucknow-circle-rate/{sro}/{mohalla}', function (string $sro, string $mohalla) {
    $row = \App\Support\CircleRates::find($sro, $mohalla);
    abort_unless($row, 404);
    return view('pages.lucknow-circle-rate', ['mSro' => $sro, 'mRow' => $row]);
})->where(['sro' => '[a-z-]+', 'mohalla' => '[a-z0-9-]+'])->name('lucknow.circle.rate.mohalla');
Route::get('/awas-vikas-schemes', [AwasVikasSchemesController::class, 'index'])->name('awas.vikas.schemes');
Route::get('/lda-demolition-tracker', function () {
    $genericUrls = [
        'https://www.jagran.com/uttar-pradesh/lucknow-city.html',
        'https://www.jagran.com/',
        'https://www.amarujala.com/lucknow',
        'https://www.amarujala.com/',
        'https://www.etvbharat.com/',
        'https://navbharattimes.indiatimes.com/',
        'https://realtyquarter.com/',
        'https://www.sandeshwahak.com/',
        'https://www.thejaipurdialogues.com/',
        'https://1acre.in/',
        'https://antiaero.org/2024/',
    ];
    $items = collect(json_decode(file_get_contents(storage_path('app/data/lda_demolitions.json')), true))
        ->filter(fn($item) => !empty($item['source_url']) && !in_array($item['source_url'], $genericUrls))
        ->unique(fn($item) => $item['date'] . '|' . $item['headline'])
        ->sortByDesc('date')->values()->all();
    $stats = [
        'total'    => count($items),
        'critical' => collect($items)->where('risk_level','critical')->count(),
        'high'     => collect($items)->where('risk_level','high')->count(),
        'areas'    => collect($items)->pluck('area')->unique()->count(),
    ];
    return view('pages.lda-demolition', compact('items', 'stats'));
})->name('lda.demolition');

Route::get('/how-property-prices-are-calculated-in-lucknow', function () { 
    return view('CaseStudies.mapMethodology');
});
Route::get('/services/property-verification-lucknow', function () {
    $googleReviews = \App\Models\GoogleReview::active()
        ->where(function ($q) {
            $q->whereNull('tags')
              ->orWhereJsonContains('tags', 'Legal Advice');
        })
        ->orderByRaw('CASE WHEN tags IS NOT NULL THEN 0 ELSE 1 END ASC')
        ->orderBy('sort_order')
        ->orderByDesc('review_date')
        ->get();
    return view('pages.services.property-verification-lucknow', compact('googleReviews'));
})->name('property.verification');

Route::get('/services/property-verification-varanasi', function () {
    return view('pages.services.property-verification-varanasi');
})->name('property.verification.varanasi');

Route::get('/services/property-verification-ayodhya', function () {
    return view('pages.services.property-verification-ayodhya');
})->name('property.verification.ayodhya');

Route::get('/services/property-verification-gorakhpur', function () {
    return view('pages.services.property-verification-gorakhpur');
})->name('property.verification.gorakhpur');

Route::get('/services/property-verification-prayagraj', function () {
    return view('pages.services.property-verification-prayagraj');
})->name('property.verification.prayagraj');

Route::get('/services/property-verification-noida', function () {
    return view('pages.services.property-verification-noida');
})->name('property.verification.noida');

Route::get('/services/property-verification-greater-noida', function () {
    return view('pages.services.property-verification-greater-noida');
})->name('property.verification.greater.noida');

Route::get('/services/property-verification-agra', function () {
    return view('pages.services.property-verification-agra');
})->name('property.verification.agra');

Route::view('/services/property-registry-lucknow',      'pages.services.property-registry-lucknow')     ->name('services.registry.lucknow');
Route::view('/services/property-registry-varanasi',     'pages.services.property-registry-varanasi')    ->name('services.registry.varanasi');
Route::view('/services/property-registry-ayodhya',      'pages.services.property-registry-ayodhya')     ->name('services.registry.ayodhya');
Route::view('/services/property-registry-gorakhpur',    'pages.services.property-registry-gorakhpur')   ->name('services.registry.gorakhpur');
Route::view('/services/property-registry-prayagraj',    'pages.services.property-registry-prayagraj')   ->name('services.registry.prayagraj');
Route::view('/services/property-registry-agra',         'pages.services.property-registry-agra')        ->name('services.registry.agra');
Route::view('/services/property-registry-noida',        'pages.services.property-registry-noida')       ->name('services.registry.noida');
Route::view('/services/property-registry-greater-noida','pages.services.property-registry-greater-noida')->name('services.registry.greater-noida');

Route::get('/services/property-advisory-lucknow', function () {
    $googleReviews = \App\Models\GoogleReview::active()
        ->where(function ($q) {
            $q->whereNull('tags')
              ->orWhereJsonContains('tags', 'LDA Scheme Guide')
              ->orWhereJsonContains('tags', 'Buying Tips');
        })
        ->orderByRaw('CASE WHEN tags IS NOT NULL THEN 0 ELSE 1 END ASC')
        ->orderBy('sort_order')
        ->orderByDesc('review_date')
        ->get();
    return view('pages.services.property-advisory', compact('googleReviews'));
})->name('property.advisory');

Route::view('/privacy-policy', 'pages.legal.privacy-policy')->name('privacy.policy');
Route::view('/terms-and-conditions', 'pages.legal.terms-and-conditions')->name('terms.conditions');
Route::view('/cookie-policy', 'pages.legal.cookie-policy')->name('cookie.policy');
Route::view('/tools/stamp-duty-calculator-lucknow', 'pages.tools.stamp-duty-calculator', ['lang' => 'en'])->name('tools.stamp-duty-calculator');
Route::view('/tools/stamp-duty-calculator-lucknow-hindi', 'pages.tools.stamp-duty-calculator', ['lang' => 'hi'])->name('tools.stamp-duty-calculator.hi');

Route::get('/page-not-found', function () {
    return response()->view('pages.404', [], 404);
})->name('page.not.found');

 
Route::prefix('api')->group(function () {
    Route::get('/blogs', [BlogApiController::class, 'index']);
    Route::get('/blogs/search', [BlogApiController::class, 'search']);
    Route::get('/blogs/categories', [BlogApiController::class, 'categories']);
});

Route::get('/reda', function () { 
    return view('reda.index');
});


Route::prefix('blogseditor')->group(function () {
    Route::get('/', [BlogEditorController::class, 'index'])->name('blog_editor.index');
    
    // The "Full Edit" routes for all 18 fields
    Route::get('/{id}/full-edit', [BlogEditorController::class, 'fullEdit'])->name('blog_editor.full_edit');
    Route::post('/{id}/full-update', [BlogEditorController::class, 'fullUpdate'])->name('blog_editor.full_update');

    // Your existing routes
    Route::get('/{id}/edit', [BlogEditorController::class, 'edit'])->name('blog_editor.edit');
    Route::post('/{id}/update', [BlogEditorController::class, 'update'])->name('blog_editor.update');
    Route::post('/{id}/autosave', [BlogEditorController::class, 'autosave'])->name('blog_editor.autosave');
    Route::post('/{id}/save-metadata', [BlogEditorController::class, 'saveMetadata'])->name('blog_editor.save_metadata');
    Route::get('/{id}/preview', [BlogEditorController::class, 'preview'])->name('blog_editor.preview');

    Route::get('/create', [BlogEditorController::class, 'create'])->name('blog_editor.create');
    Route::post('/store', [BlogEditorController::class, 'store'])->name('blog_editor.store');

    Route::patch('/{id}/toggle-status', [BlogEditorController::class, 'toggleStatus'])->name('blog_editor.toggle_status');
    Route::delete('/{id}/delete', [BlogEditorController::class, 'destroy'])->name('blog_editor.destroy');
});
// Retired blog/news URLs → the closest live post, so backlinks keep their value.
// abort(404) is not an option here: App\Exceptions\Handler turns every 404 into
// a 302 to the homepage, which Google reads as a soft 404.
$retiredBlogRedirects = [
    // old posts with a matching replacement
    '/blog/top-residential-areas-lucknow-2025-5DYWl'                    => '/blog/fastest-growing-residential-areas-lucknow-2026',
    '/news/lda-anant-nagar-lottery-results-mohaan-road-2026'             => '/blog/anant-nagar-yojana-lucknow-lda-2026',
    '/blog/lda-plot-vs-builder-flat-lucknow-2026-english'                => '/blog/lda-plot-vs-builder-flat-lucknow-2026',
    '/news/lucknow-scr-masterplan-2026-impact-analysis'                  => '/blog/lucknow-master-plan-2031-mahayojna-guide',
    '/blog/best-social-media-strategies-sell-property-faster-Kzysd'      => '/blog/step-by-step-guide-selling-house-lucknow-GXCwj',
    '/blog/buy-lda-approved-plots-lucknow-avoid-scams-3W95Z'             => '/blog/lda-illegal-colony-list-lucknow-2026',
    '/blog/best-time-to-sell-your-property-lucknow-maximum-profit-rAhwd' => '/blog/best-time-to-sell-property-lucknow-2026',
    '/blog/discover-lucknow-ultimate-guide-real-estate-FOyaL'            => '/blog/lucknow-investment-hotspots-2026',
    '/blog/under-construction-vs-ready-to-move-lucknow-MuHT9'            => '/blog/ready-to-move-vs-under-construction-homes-lucknow-sDWih',
    '/blog/power-of-attorney-real-estate-benefits-risks-BwKuP'           => '/blog/bainama-vs-registry-vs-power-of-attorney-lucknow-2026',

    // wrong slugs still linked from inside other posts
    '/blog/bainama-vs-registry-vs-poa-lucknow-2026'                      => '/blog/bainama-vs-registry-vs-power-of-attorney-lucknow-2026',
    '/blog/igrsup-property-search-tutorial-lucknow-2026'                 => '/blog/igrsup-lucknow-property-search-tutorial',
    '/blog/anant-nagar-yojana-lda-lucknow-2026'                          => '/blog/anant-nagar-yojana-lucknow-lda-2026',
    '/blog/encumbrance-certificate-lucknow-2026'                         => '/blog/encumbrance-certificate-lucknow-how-to-apply-online',
    '/blog/nri-guide-verification-lucknow-2026'                          => '/blog/nri-guide-lucknow-property-verification-remote',
    '/blog/lda-illegal-colony-list-lucknow-2026-hindi'                   => '/blog/LDA-illegal-colony-list-lucknow-2026-verification-hindi',
    '/blog/lda-illegal-colony-hindi-lucknow-2026'                        => '/blog/LDA-illegal-colony-list-lucknow-2026-verification-hindi',
    '/blog/dakhil-kharij-lucknow-2026'                                   => '/blog/dakhil-kharij-lucknow-mutation-process-guide',
    '/blog/dakhil-kharij-hindi-lucknow-2026'                             => '/blog/dakhil-kharij-lucknow-mutation-process-guide-hindi',
    '/blog/sultanpur-road-hindi-lucknow-2026'                            => '/blog/plots-sultanpur-road-lucknow-2026-hindi',
    '/blog/sky-limit-hindi-lucknow-2026'                                 => '/blog/lucknow-sky-limit-aai-vs-iaf-construction-height-rules-hindi',
    '/blog/atal-nagar-awasiya-yojana-phase2-lucknow-2026'                => '/blog/atal-nagar-awasiya-yojana-phase-2-devpur-para-lucknow-2026',
];

foreach ($retiredBlogRedirects as $from => $to) {
    Route::permanentRedirect($from, $to);
}

// Retired posts with no matching replacement: 410 tells Google they are gone on purpose.
$goneBlogPosts = [
    '/blog/hospitals-medical-facilities-lucknow-NYIxO',
    '/blog/best-places-to-visit-lucknow-9xJgT',
    '/blog/rent-vs-buy-smart-property-decisions-lucknow-S9AkI',
    '/blog/step-by-step-guide-buying-first-home-lucknow-9iGyo',
    '/blog/home-loan-guide-emis-interest-rates-lucknow-Q0d3A',
];

foreach ($goneBlogPosts as $url) {
    Route::get($url, fn () => abort(410));
}

// Old news stories hidden on 2026-10-18 → closest live guide (they still had search traffic).
$retiredNewsRedirects = [
    '/news/it-city-phase-2-registry-ban-proposal-11-villages-2026'                             => '/blog/it-city-lucknow-lda-plots-guide-hindi-2026',
    '/news/varun-vihar-yojna-gaata-no-list-lucknow-2026'                                       => '/blog/varun-vihar-yojana-lucknow-hindi-2026',
    '/news/varun-vihar-yojna-gaata-no-list-lucknow-comprehensive-2026'                         => '/blog/varun-vihar-yojana-lucknow-lda-plots-guide-2026',
    '/news/varun-vihar-yojna-lda-largest-housing-scheme-lucknow-2026'                          => '/blog/varun-vihar-yojana-lucknow-lda-plots-guide-2026',
    '/news/lucknow-international-convention-centre-vrindavan-yojna-2026'                       => '/blog/vrindavan-yojna-lucknow-investment-guide-2026',
    '/news/lda-beautification-drive-gomti-nagar-vrindavan-yojna-2026'                          => '/blog/vrindavan-yojna-lucknow-investment-guide-2026',
    '/news/up-abolishes-section-80-land-use-conversion-lucknow-2026'                           => '/blog/transforming-agricultural-land-residential-property-lucknow',
    '/news/green-corridor-sultanpur-road-link-lucknow-2026'                                    => '/blog/plots-sultanpur-road-lucknow-2026',
    '/news/green-corridor-phase-2-inauguration-lucknow-2026'                                   => '/blog/plots-sultanpur-road-lucknow-2026',
    '/news/lda-digital-portal-land-verification-lucknow-2026'                                  => '/blog/lda-online-property-verification-lucknow-2026',
    '/news/lucknow-real-estate-news-lda-digital-portal-aishbagh-2026'                          => '/blog/lda-online-property-verification-lucknow-2026',
    '/news/wellness-city-lucknow-lda-site-office-update-2026'                                  => '/blog/wellness-city-lucknow-lda-plots-guide-2026',
    '/news/lda-budget-2026-it-city-wellness-city-update'                                       => '/lda-schemes',
    '/news/lda-budget-2026-27-lucknow-infrastructure-allocation'                               => '/lda-schemes',
    '/news/lda-budget-approval-lucknow-2026-27'                                                => '/lda-schemes',
    '/news/lda-price-freeze-vacant-flats-lucknow-2026'                                         => '/lda-schemes',
    '/news/lda-new-ews-homes-private-townships-lucknow-2026'                                   => '/lda-schemes',
    '/news/lmc-property-tax-rebate-deadline-march-2026'                                        => '/blog/nagar-nigam-lucknow-2026',
    '/news/kisan-path-lucknow-infrastructure-update-2026'                                      => '/blog/kisan-path-lucknow-investment-map-2026',
    '/news/lda-it-city-phase-1-possession-handover-2026'                                       => '/blog/it-city-lucknow-lda-plots-guide-2026',
    '/news/lda-naimish-nagar-township-update-april-2026'                                       => '/blog/naimish-nagar-yojana-lucknow-lda-plots-guide-2026',
    '/news/up-rera-approves-24-new-projects-lucknow-march-2026'                                => '/rera-approved-projects-lucknow',
    '/news/up-rera-fines-lucknow-developers-2-crore-qpr-default-2026'                          => '/rera-approved-projects-lucknow',
    '/news/ed-attaches-rs313-crore-in-ansal-properties-case-linked-to-sushant-golf-cit'        => '/blog/sushant-golf-city-lucknow-buyers-guide-2026',
    '/news/lucknow-real-estate-news-metro-phase-2-aishbagh-2026'                               => '/blog/lda-aishbagh-square-mill-road-lucknow',
    '/news/lucknow-real-estate-news-april-14-2026'                                             => '/blog/lda-aishbagh-square-mill-road-lucknow',
    '/news/lda-luxury-housing-projects-lucknow-april-2026'                                     => '/blog/lda-aishbagh-square-mill-road-lucknow',
];

foreach ($retiredNewsRedirects as $from => $to) {
    Route::permanentRedirect($from, $to);
}

// Blogs Redirect


Route::redirect(
    '/blog/check-property-ownership-records-lucknow-H2XMt',
    '/blog/check-property-ownership-records-lucknow',
    301
);

Route::redirect(
    '/blog/transfer-property-after-death-lucknow-guide-YxaL8',
    '/blog/transfer-property-after-death-lucknow-guide',
    301
);

Route::redirect(
    '/blog/transforming-agricultural-land-residential-property-lucknow-B7s7f',
    '/blog/transforming-agricultural-land-residential-property-lucknow',
    301
);

Route::redirect(
    '/blog/up-rera-lucknow-verify-projects-complaints',
    '/blog/understanding-rera-guide-lucknow-property-buyers-C7ECl',
    301
);

Route::redirect(
    '/blog/rise-of-sultanpur-road-lucknow-real-estate-hotspot',
    '/blog/plots-sultanpur-road-lucknow-2026',
    301
);

Route::redirect(
    '/blog/property-document-verification-checklist-lucknow',
    '/services/property-verification-lucknow',
    301
);

Route::redirect(
    '/blog/maximize-profits-lucknow-real-estate-market-htgDg',
    '/blog/lucknow-investment-hotspots-2026',
    301
);


Route::redirect(
    '/blog/lucknow-real-estate-market-predictions-2026-2027',
    '/blog/lucknow-investment-hotspots-2026',
    301
);

Route::redirect(
    '/blog/fsi-rules-lucknow',
    '/services/property-verification-lucknow',
    301
);
Route::redirect(
    '/blog/tds-guide-property-purchase-lucknow-hG99H',
    '/services/property-verification-lucknow',
    301
);
Route::redirect(
    '/blog/avoid-common-property-selling-scams-lucknow-wfACe',
    '/services/property-verification-lucknow',
    301
);

Route::redirect(
    '/blog/property-verification-checklist',
    '/services/property-verification-lucknow',
    301
);


Route::redirect(
    '/blog/gomti-nagar-extension-lucknow-real-estate-guide',
    '/blog/gomti-nagar-extension-lucknow-guide-2026',
    301
);

Route::redirect(
    '/blog/rera-verification-guide',
    '/blog/understanding-rera-guide-lucknow-property-buyers-C7ECl',
    301
);

Route::redirect(
    '/news/lda-park-view-apartments-364-flats-registration-april-2026',
    '/blog/lda-park-view-apartments-basant-kunj-2026',
    301
);

Route::redirect(
    '/news/lda-park-view-apartments-basant-kunj-registration-2026',
    '/blog/lda-park-view-apartments-basant-kunj-2026',
    301
);

Route::redirect(
    '/blog/cost-of-living-in-lucknow-detailed-breakdown-j5xhK',
    '/blog/cost-of-living-lucknow-2026',
    301
);

Route::redirect(
    '/blog/top-5-fastest-growing-residential-areas-lucknow-luahx',
    '/blog/fastest-growing-residential-areas-lucknow-2026',
    301
);

Route::redirect(
    '/blog/land-conversion-lucknow-guide',
    '/blog/transforming-agricultural-land-residential-property-lucknow',
    301
);

Route::redirect(
    '/blog/sell-property-fast-lucknow-complete-sellers-guide-3Wid8',
    '/blog/step-by-step-guide-selling-house-lucknow-GXCwj',
    301
);

Route::redirect(
    '/news/atal-nagar-lda-affordable-flats-registration-guide-2026',
    '/blog/atal-nagar-awasiya-yojana-phase-2-devpur-para-lucknow-2026',
    301
);
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/comment', [BlogCommentController::class, 'store'])->name('blog.comment.store');

// Blog Feedback (popup form)
Route::post('/blog-feedback', [BlogFeedbackController::class, 'store'])->name('blog.feedback.store');
// Admin — one inbox for every public form (contact us, blog sidebar, exit-intent
// popup, newsletter). Enquiries become CRM leads only when converted by hand.
Route::get('/admin/enquiries', [FormSubmissionController::class, 'index'])->name('admin.enquiries.index');
Route::post('/admin/enquiries/{submission}/convert', [FormSubmissionController::class, 'convert'])->name('admin.enquiries.convert');
Route::post('/admin/enquiries/{submission}/status',  [FormSubmissionController::class, 'status'])->name('admin.enquiries.status');
// Old URL kept so existing bookmarks and links keep working.
Route::get('/admin/feedbacks', fn () => redirect()->route('admin.enquiries.index', request()->query()))
    ->name('admin.feedbacks.index');

// Admin — Google Reviews
Route::get('/admin/reviews',                          [GoogleReviewController::class, 'adminIndex'])->name('admin.reviews.index');
Route::post('/admin/reviews',                         [GoogleReviewController::class, 'store'])->name('admin.reviews.store');
Route::put('/admin/reviews/{review}',                 [GoogleReviewController::class, 'update'])->name('admin.reviews.update');
Route::post('/admin/reviews/{review}/toggle',         [GoogleReviewController::class, 'toggle'])->name('admin.reviews.toggle');
Route::delete('/admin/reviews/{review}',              [GoogleReviewController::class, 'destroy'])->name('admin.reviews.destroy');

// Admin comment moderation
Route::get('/admin/comments',                     [BlogCommentController::class, 'adminIndex'])->name('admin.comments.index');
Route::post('/admin/comments/{comment}/approve',  [BlogCommentController::class, 'approve'])->name('admin.comments.approve');
Route::post('/admin/comments/{comment}/spam',     [BlogCommentController::class, 'spam'])->name('admin.comments.spam');
Route::delete('/admin/comments/{comment}',        [BlogCommentController::class, 'destroy'])->name('admin.comments.destroy');

Route::get('/', [BlogController::class, 'homePage'])->name('homepage');
Route::get('/dashboard', function () {
    // Admins have a real panel; the stock Breeze page is only a fallback.
    $email = strtolower((string) auth()->user()?->email);
    if (in_array($email, config('admin.emails', []), true)) {
        return redirect('/admin/crm/leads');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/inquiry-submit', [InquiryController::class, 'submit'])->name('inquiry.submit');
Route::post('/subscribe', [InquiryController::class, 'subscribe'])->middleware('throttle:5,60')->name('newsletter.subscribe');
Route::get('/preview', [BlogController::class, 'previewBlog'])->name('blogs.preview');

Route::get('/contact-us', [InquiryController::class, 'ShowContcatUs'])->name('contact-us');
Route::get('/reviews', [GoogleReviewController::class, 'publicIndex'])->name('reviews.index');
Route::get('/about', function () {
    return view('pages.about-us');
})->name('about');
//Receipt
Route::post('/generate-rent-receipt', [RentReceiptController::class, 'generate'])->name('rent-receipt.generate');

Route::get('/generate-ai-blog', [BlogGenerateController::class, 'generate'])->name('ai.blog.generate');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin — Property Management
Route::get('/admin/properties',                              [AdminPropertyController::class, 'index'])->name('admin.properties.index');
Route::get('/admin/properties/{property}',                   [AdminPropertyController::class, 'show'])->name('admin.properties.show');
Route::post('/admin/properties/{property}/status',           [AdminPropertyController::class, 'updateStatus'])->name('admin.properties.status');
Route::delete('/admin/properties/{property}/delete',         [AdminPropertyController::class, 'destroy'])->name('admin.properties.destroy');

// Admin — Seller Management
Route::get('/admin/sellers',                              [AdminSellerController::class, 'index'])->name('admin.sellers.index');
Route::post('/admin/sellers/{seller}/impersonate',        [AdminSellerController::class, 'impersonate'])->name('admin.sellers.impersonate');

// Admin — Gallery Management
Route::get('/admin/galleries',                        [AdminGalleryController::class, 'index'])->name('admin.galleries.index');
Route::get('/admin/galleries/create',                  [AdminGalleryController::class, 'create'])->name('admin.galleries.create');
Route::post('/admin/galleries',                        [AdminGalleryController::class, 'store'])->name('admin.galleries.store');
Route::get('/admin/galleries/{gallery}/edit',          [AdminGalleryController::class, 'edit'])->name('admin.galleries.edit');
Route::post('/admin/galleries/{gallery}/images',       [AdminGalleryController::class, 'uploadImages'])->name('admin.galleries.images.upload');
Route::put('/admin/galleries/images/{image}',          [AdminGalleryController::class, 'updateImage'])->name('admin.galleries.images.update');
Route::delete('/admin/galleries/images/{image}',       [AdminGalleryController::class, 'destroyImage'])->name('admin.galleries.images.destroy');
Route::post('/admin/galleries/{gallery}/links',        [AdminGalleryController::class, 'addPageLink'])->name('admin.galleries.links.add');
Route::delete('/admin/galleries/links/{link}',         [AdminGalleryController::class, 'removePageLink'])->name('admin.galleries.links.remove');
Route::delete('/admin/galleries/{gallery}',            [AdminGalleryController::class, 'destroy'])->name('admin.galleries.destroy');

// Admin Routes for Lead Import and Email Template Management
Route::view('/admin/leads/upload', 'admin.leads.upload');
Route::view('/admin/templates/create', 'admin.templates.create');
 Route::post('/admin/leads/upload',[LeadImportController::class,'upload']);
Route::get('/admin/campaigns', [CampaignController::class, 'index']);   // SHOW PAGE
Route::any('/admin/campaigns/start', [CampaignController::class, 'start']); // START CAMPAIGN
// Route::get('/admin/templates',[EmailTemplateController::class,'index']);
 Route::post('/admin/templates',[EmailTemplateController::class,'store']);

// Admin — CRM follow-up tracker (DSD Properties buyer leads).
// Kept separate from the older /admin/leads email-campaign module above.
Route::prefix('admin/crm')->name('admin.crm.')->group(function () {
    Route::get('leads/all',    [CrmLeadController::class, 'all'])->name('leads.all');
    Route::get('leads/debug',  [CrmLeadController::class, 'debug'])->name('leads.debug'); // TEMPORARY - remove after diagnosis
    Route::get('leads/import', [CrmLeadImportController::class, 'form'])->name('leads.import.form');
    Route::post('leads/import/headers', [CrmLeadImportController::class, 'headers'])->name('leads.import.headers');
    Route::post('leads/import', [CrmLeadImportController::class, 'import'])->name('leads.import');
    Route::post('leads/{lead}/log', [CrmLeadController::class, 'log'])->name('leads.log');
    Route::resource('leads', CrmLeadController::class)->parameters(['leads' => 'lead']);
});
 

//UserLocation Routes
Route::get('/users', [UserLocationController::class, 'index'])->name('locations.index');
Route::get('/locations/data', [UserLocationController::class, 'getData'])->name('locations.data');
Route::get('/locations/charts', [UserLocationController::class, 'getChartData'])->name('locations.charts');
Route::get('/locations/summary', [UserLocationController::class, 'getDailySummary'])->name('locations.summary');
Route::get('/locations/url-stats', [UserLocationController::class, 'getUrlDailyStats'])->name('locations.url-stats');
require __DIR__.'/auth.php';

//unscribe route
Route::any('/unsubscribe', [CampaignController::class, 'unsubscribe'])->name('email.unsubscribe');

Route::post('/log-consultation-click', function (Request $request) {

    Log::channel('consultation_clicks')->info('Consultation Button Clicked', [
        'ip' => $request->ip(),
        'page_url' => $request->page_url,
        'user_agent' => $request->userAgent(),
        'referer' => $request->headers->get('referer'),
        'clicked_at' => now()->toDateTimeString(),
    ]);

    return response()->json(['status' => true]);
})->name('log.consultation.click');

Route::get('/admin/news/fetch', [NewsFetchController::class, 'fetch'])->name('admin.news.fetch');

// ── Verification Admin Login (public) ──────────────────────────────────────
Route::get('/admin/verifications/login',  [VerificationController::class, 'loginForm'])->name('ver.admin.login');
Route::post('/admin/verifications/login', [VerificationController::class, 'login'])->name('ver.admin.login.post');

// ── Verification Admin (protected) ────────────────────────────────────────
Route::middleware('ver.admin')->prefix('admin/verifications')->name('ver.admin.')->group(function () {
    Route::post('/logout',                                     [VerificationController::class, 'logout'])->name('logout');
    Route::get('/',                                            [VerificationController::class, 'index'])->name('index');
    Route::get('/create',                                      [VerificationController::class, 'create'])->name('create');
    Route::post('/',                                           [VerificationController::class, 'store'])->name('store');
    Route::get('/{report}/edit',                               [VerificationController::class, 'edit'])->name('edit');
    Route::patch('/{report}',                                  [VerificationController::class, 'update'])->name('update');
    Route::post('/{report}/findings/{slug}',                   [VerificationController::class, 'saveFinding'])->name('findings.save');
    Route::post('/{report}/evidences',                         [VerificationController::class, 'uploadEvidence'])->name('evidences.upload');
    Route::delete('/{report}/evidences/{evidence}',            [VerificationController::class, 'deleteEvidence'])->name('evidences.delete');
    Route::get('/{report}/evidences/{evidence}/download',      [VerificationController::class, 'downloadEvidence'])->name('evidences.download');
    Route::post('/{report}/generate-pdf',                      [VerificationController::class, 'generatePdf'])->name('generate-pdf');
    Route::get('/{report}/download-pdf',                       [VerificationController::class, 'downloadPdf'])->name('download-pdf');
    Route::get('/{report}/status',                             [VerificationController::class, 'statusCheck'])->name('status');
    Route::post('/{report}/deliver',                           [VerificationController::class, 'deliver'])->name('deliver');
    Route::get('/setup/fonts',                                 [VerificationController::class, 'setupFonts'])->name('setup.fonts');
});

// ── Customer: Signed download (no auth, time-limited) ─────────────────────
Route::get('/verification-download/{report}', [VerificationController::class, 'downloadSigned'])->name('ver.download.signed');

// ── Public Verification Check Page ────────────────────────────────────────
Route::get('/verify/{reportId}', function (string $reportId) {
    $report = \App\Models\VerificationReport::where('report_id', $reportId)
        ->whereNotNull('verdict')
        ->with('findings')
        ->first();
    $checks   = config('verification_checks', []);
    $findings = $report ? $report->findings->keyBy('check_slug') : collect();
    return view('verify.show', compact('report', 'reportId', 'checks', 'findings'));
})->name('ver.public.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
// Weekly report pages (built from the week's stories) — must come before /news/{slug}
Route::get('/news/weekly', [\App\Http\Controllers\NewsWeeklyController::class, 'index'])->name('news.weekly.index');
Route::get('/news/weekly/{week}', [\App\Http\Controllers\NewsWeeklyController::class, 'show'])
    ->where('week', '\d{4}-[Ww]\d{2}')->name('news.weekly.show');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Weekly newsletter unsubscribe (signed link in every email; POST = one-click from mail apps)
Route::match(['get', 'post'], '/newsletter/unsubscribe', [\App\Http\Controllers\NewsWeeklyController::class, 'unsubscribe'])
    ->middleware('throttle:30,1')->name('newsletter.unsubscribe');
Route::match(['get', 'post'], '/newsletter/language', [\App\Http\Controllers\NewsWeeklyController::class, 'language'])
    ->middleware('throttle:30,1')->name('newsletter.language');

// Weekly newsletter open pixel + click redirects (token per delivery)
Route::get('/n/o/{token}.gif', [\App\Http\Controllers\NewsletterTrackController::class, 'open'])
    ->where('token', '[A-Za-z0-9]{24,32}')->middleware('throttle:60,1')->name('newsletter.open');
Route::get('/n/c/{token}', [\App\Http\Controllers\NewsletterTrackController::class, 'click'])
    ->where('token', '[A-Za-z0-9]{24,32}')->middleware('throttle:60,1')->name('newsletter.click');

// Newsletter batch for an external cron service (cron-job.org, every 10 min), since the server has no cron.
// Secret token from NEWSLETTER_CRON_TOKEN; sends only 9:00–20:00 IST.
Route::get('/cron/newsletter/{token}', function (string $token) {
    $secret = (string) config('newsletter.cron_token');
    abort_unless($secret !== '' && hash_equals($secret, $token), 404);
    $hour = (int) now('Asia/Kolkata')->format('G');
    if ($hour < 9 || $hour >= 20) return response('outside sending hours', 200)->header('Content-Type', 'text/plain');
    ignore_user_abort(true);
    set_time_limit(120);
    $out = [];
    foreach (\App\Models\NewsletterCampaign::where('status', 'sending')->orderBy('id')->get() as $c) {
        [$sent, $failed, $left] = \App\Support\Newsletter::sendBatch($c, config('newsletter.cron_batch'));
        $out[] = "{$c->week}: {$sent} sent, {$failed} failed, {$left} left";
    }
    return response($out ? implode("\n", $out) : 'nothing to send', 200)->header('Content-Type', 'text/plain');
})->middleware('throttle:10,1');

// Admin — weekly newsletter (behind EnsureAdmin like every /admin URL)
Route::prefix('admin/newsletter')->name('admin.newsletter.')->group(function () {
    Route::get('/',                    [\App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('index');
    Route::post('/',                   [\App\Http\Controllers\Admin\NewsletterController::class, 'store'])->name('store');
    Route::get('{campaign}/preview',   [\App\Http\Controllers\Admin\NewsletterController::class, 'preview'])->name('preview');
    Route::post('{campaign}/test',     [\App\Http\Controllers\Admin\NewsletterController::class, 'test'])->name('test');
    Route::post('{campaign}/items',    [\App\Http\Controllers\Admin\NewsletterController::class, 'items'])->name('items');
    Route::post('{campaign}/start',    [\App\Http\Controllers\Admin\NewsletterController::class, 'start'])->name('start');
    Route::post('{campaign}/batch',    [\App\Http\Controllers\Admin\NewsletterController::class, 'batch'])->name('batch');
    Route::delete('{campaign}',        [\App\Http\Controllers\Admin\NewsletterController::class, 'destroy'])->name('destroy');
});

// Route::get('/run-news/{key}', function ($key, FetchLucknowNewsService $service) {

//     if ($key !== 'secret123') {
//         abort(403);
//     }

//     $result = $service->fetch();

//     return response()->json($result);

// });


// Website browser notifications (OneSignal). The public route records which page a
// visitor subscribed on; /admin/push sends to everyone, one topic, or one test browser.
Route::post('/push/subscribed', [\App\Http\Controllers\PushSubscriptionController::class, 'store'])
    ->middleware('throttle:20,1')->name('push.subscribed');
Route::prefix('admin/push')->name('admin.push.')->group(function () {
    Route::get('/',     [\App\Http\Controllers\Admin\PushController::class, 'index'])->name('index');
    Route::post('send', [\App\Http\Controllers\Admin\PushController::class, 'send'])->name('send');
});

// Admin — WhatsApp CRM. The socket itself runs in whatsapp-service/ (Baileys);
// these routes are the inbox, the QR pairing screen and the polling endpoints.
Route::prefix('admin/whatsapp')->name('admin.whatsapp.')->group(function () {
    Route::get('/',                    [WhatsAppController::class, 'index'])->name('index');
    Route::get('connect',              [WhatsAppController::class, 'connect'])->name('connect');
    Route::get('connect/status',       [WhatsAppController::class, 'connectStatus'])->name('connect.status');
    Route::post('logout',              [WhatsAppController::class, 'logout'])->name('logout');
    Route::get('poll',                 [WhatsAppController::class, 'poll'])->name('poll');
    Route::get('export',               [WhatsAppController::class, 'export'])->name('export');
    Route::post('start',               [WhatsAppController::class, 'start'])->name('start');
    Route::get('chat/{chat}',          [WhatsAppController::class, 'index'])->name('chat');
    Route::get('chat/{chat}/messages', [WhatsAppController::class, 'messages'])->name('messages');
    Route::post('chat/{chat}/send',    [WhatsAppController::class, 'send'])->name('send');
    Route::post('chat/{chat}/archive', [WhatsAppController::class, 'archive'])->name('archive');
    Route::post('chat/{chat}/lead',    [WhatsAppController::class, 'createLead'])->name('lead');

    // Media: uploads go out through the gateway, downloads stream from the
    // private disk so files never sit under the web root.
    Route::post('chat/{chat}/media',   [WhatsAppController::class, 'sendMedia'])->name('media.send');
    Route::get('media/{message}',      [WhatsAppController::class, 'media'])->name('media');

    Route::post('chat/{chat}/label',   [WhatsAppController::class, 'toggleLabel'])->name('label.toggle');

    // Browser notifications.
    Route::post('push/subscribe',      [WhatsAppController::class, 'subscribePush'])->name('push.subscribe');
    Route::post('push/unsubscribe',    [WhatsAppController::class, 'unsubscribePush'])->name('push.unsubscribe');

    // Quick replies and labels, managed in the panel.
    Route::get('settings',                  [WhatsAppSettingsController::class, 'index'])->name('settings');
    Route::post('settings/replies',         [WhatsAppSettingsController::class, 'storeReply'])->name('replies.store');
    Route::put('settings/replies/{reply}',  [WhatsAppSettingsController::class, 'updateReply'])->name('replies.update');
    Route::delete('settings/replies/{reply}', [WhatsAppSettingsController::class, 'destroyReply'])->name('replies.destroy');
    Route::post('settings/labels',          [WhatsAppSettingsController::class, 'storeLabel'])->name('labels.store');
    Route::put('settings/labels/{label}',   [WhatsAppSettingsController::class, 'updateLabel'])->name('labels.update');
    Route::delete('settings/labels/{label}', [WhatsAppSettingsController::class, 'destroyLabel'])->name('labels.destroy');
});
