@extends('layouts.user-app')

{{--
    DSD Research — Lucknow Real Estate Research Centre (/research). Built 7 Nov 2026 as phase 1 of the
    "research centre" plan: one hub that groups the site's data pages, trackers and source-checked guides.
    Every "Updated" date and count is read live (blog_posts.updated_at, news_articles, data-file mtimes,
    circle-rate JSONs), so nothing here goes stale by hand. A card whose blog post is missing or unpublished
    is skipped. Phase 2 (monthly Lucknow Property Report) will be added as its own section.
--}}
@php
    use App\Support\CircleRates as CRS;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    $fmtDate = fn ($d) => $d ? Carbon::parse($d)->format('j M Y') : null;
    $fileDate = fn ($rel) => is_file(storage_path($rel)) ? date('Y-m-d', filemtime(storage_path($rel))) : null;
    $fileCount = function ($rel) {
        if (! is_file(storage_path($rel))) return null;
        $j = json_decode(file_get_contents(storage_path($rel)), true);
        return is_array($j) ? count($j['projects'] ?? $j['schemes'] ?? $j) : null;
    };

    // Blog guides, by id: slug + updated_at, published only
    $guideIds = [9, 37, 70, 80, 87, 89, 91, 95, 102, 105, 113, 115, 116, 121, 127, 133, 145, 162];
    $posts = DB::table('blog_posts')->whereIn('id', $guideIds)->where('status', 'published')
        ->get(['id', 'slug', 'updated_at'])->keyBy('id');
    $guide = fn ($id, $title, $desc, $source) => isset($posts[$id]) ? [
        'href' => '/blog/' . $posts[$id]->slug, 'title' => $title, 'desc' => $desc,
        'source' => $source, 'updated' => $posts[$id]->updated_at, 'kind' => 'Guide',
    ] : null;

    // Circle rates: every SRO list in resources/data/circle-rates
    $sros = CRS::all();
    $mohallas = array_sum(array_map(fn ($l) => count($l['rows'] ?? []), $sros));
    $crEffective = collect($sros)->pluck('effective')->filter()->max();

    // News
    $newsQ = DB::table('news_articles')->where('status', 'published');
    $newsCount = (clone $newsQ)->count();
    $newsLatest = (clone $newsQ)->max('created_at');

    $reraCount = $fileCount('app/data/rera-projects.json');
    $demolCount = $fileCount('app/data/lda_demolitions.json');

    $sections = [
        ['id' => 'rates', 'icon' => 'fa-indian-rupee-sign', 'title' => 'Rates & taxes',
         'intro' => 'Official circle rates and the stamp duty you pay on them.',
         'items' => [
            ['href' => '/lucknow-circle-rate', 'title' => 'Lucknow circle rate lookup', 'kind' => 'Data',
             'desc' => number_format($mohallas) . ' mohallas across ' . count($sros) . ' sub-registrar offices, with a minimum-value calculator.',
             'source' => 'IGRSUP DM rate lists (मूल्यांकन सूची)', 'updated' => $crEffective, 'updated_label' => 'Rates effective'],
            ['href' => '/tools/stamp-duty-calculator-lucknow', 'title' => 'Stamp duty calculator', 'kind' => 'Tool',
             'desc' => 'Stamp duty and registration fee for men, women and joint buyers, on the circle rate or the deal value.',
             'source' => 'IGRSUP stamp duty rules', 'updated' => null],
            $guide(102, 'Stamp duty & registry charges guide', 'What you pay at registry in Lucknow, and the concessions that apply.', 'IGRSUP'),
         ]],
        ['id' => 'schemes', 'icon' => 'fa-city', 'title' => 'Government housing schemes',
         'intro' => 'LDA and Awas Vikas plot schemes: rates, sizes, maps and registration status.',
         'items' => [
            ['href' => '/lda-schemes', 'title' => 'All LDA schemes', 'kind' => 'Data',
             'desc' => 'Every current LDA scheme on one map, with status, plot sizes and rates.',
             'source' => 'LDA notices and brochures', 'updated' => $fileDate('app/data/lda_schemes.json')],
            ['href' => '/awas-vikas-schemes', 'title' => 'All Awas Vikas schemes', 'kind' => 'Data',
             'desc' => 'UP Awas Vikas Parishad schemes in Lucknow, including Saumitra Vihar and Awadh Vihar.',
             'source' => 'UPAVP notices', 'updated' => $fileDate('app/data/awas_vikas_schemes.json')],
            ['href' => '/lda-plot-calculator', 'title' => 'LDA plot price calculator', 'kind' => 'Tool',
             'desc' => 'Plot cost from the official rate per sq m, for five LDA schemes.',
             'source' => 'LDA rate notifications', 'updated' => null],
            $guide(95, 'Saumitra Vihar', 'Awas Vikas scheme on Mohanlalganj side: RERA, phase-1 plots and launch.', 'UPAVP, UP RERA'),
            $guide(87, 'IT City', 'LDA IT City on Sultanpur Road: land pooling, villages and sector map.', 'LDA'),
            $guide(89, 'Wellness City', 'LDA Wellness City: official rate, sectors and villages.', 'LDA'),
            $guide(91, 'Varun Vihar', 'Georeferenced LDA layout on satellite, plot sizes and lottery results.', 'LDA'),
            $guide(105, 'Naimish Nagar', 'LDA Naimish Nagar on Sitapur Road: phases, plots and lottery.', 'LDA'),
            $guide(162, 'Land pooling in IT City & Wellness City', 'How land pooling works for farmers and buyers, with the board decisions.', 'LDA board'),
         ]],
        ['id' => 'rera', 'icon' => 'fa-building-circle-check', 'title' => 'RERA & builder projects',
         'intro' => 'Registered projects and how to check a builder before you book.',
         'items' => [
            ['href' => '/rera-approved-projects-lucknow', 'title' => 'RERA approved projects in Lucknow', 'kind' => 'Data',
             'desc' => ($reraCount ? $reraCount . ' projects' : 'Projects') . ' checked against UP RERA, with registration numbers.',
             'source' => 'UP RERA portal', 'updated' => $fileDate('app/data/rera-projects.json')],
            $guide(9, 'RERA guide for Lucknow buyers', 'What a RERA number proves, and what it does not.', 'UP RERA Act and rules'),
            $guide(127, 'How to file a UP RERA complaint', 'Step-by-step complaint process against a builder.', 'UP RERA'),
         ]],
        ['id' => 'enforcement', 'icon' => 'fa-triangle-exclamation', 'title' => 'Enforcement & fraud',
         'intro' => 'Where LDA is acting against illegal plotting, and the frauds buyers fall for.',
         'items' => [
            ['href' => '/lda-demolition-tracker', 'title' => 'LDA demolition tracker', 'kind' => 'Tracker',
             'desc' => ($demolCount ? $demolCount . ' recorded actions' : 'Recorded actions') . ' against illegal plotting and construction, by area.',
             'source' => 'Newspaper reports, checked one by one', 'updated' => $fileDate('app/data/lda_demolitions.json')],
            $guide(80, 'LDA illegal colony list', 'The colonies LDA has listed as illegal, and what it means for buyers.', 'LDA'),
            $guide(121, 'Top 10 property frauds in Lucknow', 'Real cases and the red flags behind them.', 'Police FIRs and court reports'),
            $guide(133, 'How to check an LDA approved map', 'Confirm a building or layout map before you pay.', 'LDA'),
         ]],
        ['id' => 'records', 'icon' => 'fa-file-signature', 'title' => 'Land records & title',
         'intro' => 'How to read registry, khatauni, mutation and encumbrance records yourself.',
         'items' => [
            $guide(115, 'IGRSUP property search', 'Login, IGRSUP Index and registry search by name.', 'igrsup.gov.in'),
            $guide(37, 'Check property ownership records', 'Urban and rural ownership records in Lucknow.', 'IGRSUP, UP Bhulekh'),
            $guide(113, 'Encumbrance certificate', 'How to get one online and what it shows.', 'IGRSUP'),
            $guide(116, 'Dakhil kharij (mutation)', 'Mutation process at the tehsil, step by step.', 'UP Revenue'),
            $guide(70, 'LDA vs Zila Panchayat plots', 'Which approval your plot actually needs.', 'LDA, Zila Panchayat'),
         ]],
        ['id' => 'planning', 'icon' => 'fa-map', 'title' => 'City planning',
         'intro' => 'Land use and growth corridors from the official master plan.',
         'items' => [
            $guide(145, 'Lucknow Master Plan 2031 (zoomable map)', 'The official LDA master plan map you can zoom, with the land-use legend.', 'LDA Mahayojana 2031'),
         ]],
        ['id' => 'news', 'icon' => 'fa-newspaper', 'title' => 'News & weekly briefing',
         'intro' => 'Property news for Lucknow, checked against the original report or notice.',
         'items' => [
            ['href' => '/news', 'title' => 'Lucknow property news', 'kind' => 'News',
             'desc' => number_format($newsCount) . ' source-checked stories on LDA, Awas Vikas, RERA, registry and builders.',
             'source' => 'Official notices and original newspaper reports', 'updated' => $newsLatest, 'updated_label' => 'Latest story'],
            ['href' => '/news/weekly', 'title' => 'Weekly briefing', 'kind' => 'News',
             'desc' => 'The week\'s most important stories in one page.', 'source' => '/news', 'updated' => null],
         ]],
    ];
    foreach ($sections as &$s) { $s['items'] = array_values(array_filter($s['items'])); }
    unset($s);
    $cardCount = array_sum(array_map(fn ($s) => count($s['items']), $sections));
@endphp

@section('title', 'DSD Research — Lucknow Real Estate Research Centre')
@section('meta_description', 'Lucknow real estate data in one place: circle rates, LDA and Awas Vikas schemes, RERA projects, LDA demolitions, master plan and land-record guides, with sources and update dates.')
@section('canonical', url('/research'))
@section('ga_page_type', 'scheme_hub')

@push('head')
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => 'DSD Research — Lucknow Real Estate Research Centre',
    'url' => url('/research'),
    'inLanguage' => 'en-IN',
    'about' => ['@type' => 'Place', 'name' => 'Lucknow, Uttar Pradesh'],
    'publisher' => ['@type' => 'Organization', 'name' => 'DSD Properties', 'url' => url('/')],
    'mainEntity' => ['@type' => 'ItemList', 'itemListElement' => collect($sections)->flatMap(fn ($s) => $s['items'])->values()
        ->map(fn ($it, $i) => ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $it['title'], 'url' => url($it['href'])])->all()],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<style>
.rs { --rs-navy:#011f4b; --rs-orange:#FF5C00; --rs-teal:#008080; --rs-t1:#0f172a; --rs-t2:#475569; --rs-t3:#64748b;
      --rs-bg:#ffffff; --rs-bg2:#f8fafc; --rs-line:#e2e8f0; background:var(--rs-bg); color:var(--rs-t1);
      font-family:'Plus Jakarta Sans', system-ui, sans-serif; }
.rs * { box-sizing:border-box; }
.rs-wrap { max-width:1120px; margin:0 auto; padding:0 16px; }
.rs-hero { background:var(--rs-navy); color:#fff; padding:48px 0 40px; }
.rs-eyebrow { font-size:.75rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:#ffb380; margin:0 0 10px; }
.rs-hero h1 { font-size:clamp(1.7rem, 4vw, 2.5rem); line-height:1.2; font-weight:800; margin:0 0 14px; color:#fff; }
.rs-hero p { font-size:1rem; line-height:1.7; color:rgba(255,255,255,.82); max-width:720px; margin:0; }
.rs-stats { display:grid; grid-template-columns:repeat(4, minmax(0,1fr)); gap:12px; margin-top:28px; }
.rs-stat { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); border-radius:12px; padding:14px 16px; }
.rs-stat b { display:block; font-size:1.5rem; font-weight:800; color:#fff; line-height:1.1; }
.rs-stat span { font-size:.78rem; color:rgba(255,255,255,.72); }
.rs-toc { display:flex; flex-wrap:wrap; gap:8px; padding:18px 0; border-bottom:1px solid var(--rs-line); }
.rs-toc a { font-size:.82rem; font-weight:600; color:var(--rs-navy); background:var(--rs-bg2); border:1px solid var(--rs-line);
            border-radius:999px; padding:6px 14px; text-decoration:none; }
.rs-toc a:hover { border-color:var(--rs-teal); color:var(--rs-teal); }
.rs-sec { padding:36px 0 8px; scroll-margin-top:90px; }
.rs-sec h2 { font-size:1.35rem; font-weight:800; color:var(--rs-navy); margin:0 0 6px; display:flex; align-items:center; gap:10px; }
.rs-sec h2 i { color:var(--rs-orange); font-size:1.05rem; }
.rs-sec > p { color:var(--rs-t2); font-size:.95rem; margin:0 0 18px; }
.rs-grid { display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:14px; }
.rs-card { display:flex; flex-direction:column; background:var(--rs-bg); border:1px solid var(--rs-line); border-radius:14px;
           padding:16px 18px; text-decoration:none; color:inherit; transition:border-color .15s, box-shadow .15s; }
.rs-card:hover { border-color:var(--rs-teal); box-shadow:0 6px 20px rgba(1,31,75,.08); }
.rs-kind { align-self:flex-start; font-size:.68rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase;
           color:var(--rs-teal); background:#e6f4f4; border-radius:6px; padding:3px 8px; margin-bottom:10px; }
.rs-kind--data, .rs-kind--tracker, .rs-kind--tool { color:#9a3412; background:#fff1e6; }
.rs-card h3 { font-size:1rem; font-weight:700; color:var(--rs-navy); margin:0 0 6px; line-height:1.35; }
.rs-card p { font-size:.86rem; color:var(--rs-t2); line-height:1.6; margin:0 0 12px; flex:1; }
.rs-meta { font-size:.75rem; color:var(--rs-t3); line-height:1.6; border-top:1px dashed var(--rs-line); padding-top:8px; }
.rs-meta strong { color:var(--rs-t2); font-weight:600; }
.rs-method { background:var(--rs-bg2); border:1px solid var(--rs-line); border-radius:14px; padding:22px 24px; margin:40px 0 0; }
.rs-method h2 { font-size:1.15rem; font-weight:800; color:var(--rs-navy); margin:0 0 10px; }
.rs-method ul { margin:0; padding-left:20px; color:var(--rs-t2); font-size:.9rem; line-height:1.8; }
.rs-cta { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px; background:#fff7ed;
          border:1px solid #fed7aa; border-left:4px solid var(--rs-orange); border-radius:0 14px 14px 0; padding:20px 24px; margin:28px 0 48px; }
.rs-cta p { margin:0; color:var(--rs-t1); font-size:.95rem; line-height:1.6; max-width:640px; }
.rs-cta a { display:inline-block; background:var(--rs-orange); color:#fff; font-weight:700; padding:11px 22px; border-radius:10px; text-decoration:none; white-space:nowrap; }
@media (max-width: 900px) { .rs-grid { grid-template-columns:repeat(2, minmax(0,1fr)); } .rs-stats { grid-template-columns:repeat(2, minmax(0,1fr)); } }
@media (max-width: 600px) { .rs-grid { grid-template-columns:1fr; } .rs-hero { padding:36px 0 30px; } }
</style>
@endpush

@section('content')
<div class="rs">
    <section class="rs-hero">
        <div class="rs-wrap">
            <p class="rs-eyebrow">DSD Research</p>
            <h1>Lucknow Real Estate Research Centre</h1>
            <p>Official rates, government scheme data, RERA approvals and enforcement records for Lucknow, in one place. Every page lists its sources and the date it was last updated.</p>
            <div class="rs-stats">
                <div class="rs-stat"><b>{{ number_format($mohallas) }}</b><span>mohallas with official circle rates</span></div>
                <div class="rs-stat"><b>{{ count($sros) }}</b><span>sub-registrar office lists</span></div>
                <div class="rs-stat"><b>{{ number_format($newsCount) }}</b><span>source-checked news stories</span></div>
                <div class="rs-stat"><b>{{ $cardCount }}</b><span>data pages, trackers &amp; guides</span></div>
            </div>
        </div>
    </section>

    <div class="rs-wrap">
        <nav class="rs-toc" aria-label="Research sections">
            @foreach ($sections as $s)
                <a href="#{{ $s['id'] }}">{{ $s['title'] }}</a>
            @endforeach
        </nav>

        @foreach ($sections as $s)
            <section class="rs-sec" id="{{ $s['id'] }}">
                <h2><i class="fas {{ $s['icon'] }}" aria-hidden="true"></i> {{ $s['title'] }}</h2>
                <p>{{ $s['intro'] }}</p>
                <div class="rs-grid">
                    @foreach ($s['items'] as $it)
                        <a class="rs-card" href="{{ $it['href'] }}">
                            <span class="rs-kind rs-kind--{{ strtolower($it['kind']) }}">{{ $it['kind'] }}</span>
                            <h3>{{ $it['title'] }}</h3>
                            <p>{{ $it['desc'] }}</p>
                            <div class="rs-meta">
                                <strong>Source:</strong> {{ $it['source'] }}
                                @if (!empty($it['updated']))
                                    <br><strong>{{ $it['updated_label'] ?? 'Updated' }}:</strong> {{ $fmtDate($it['updated']) }}
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach

        <section class="rs-method" id="method">
            <h2>How we research</h2>
            <ul>
                <li>Every figure comes from an official notice, a government portal or the original newspaper report. We do not publish numbers that only appear on other property websites.</li>
                <li>Each page shows its sources and when it was last updated. When a newer notice changes a fact, we update the page and date the change.</li>
                <li>Where two reports disagree, we show both and say so, instead of picking one.</li>
                <li><strong>Disclosure:</strong> DSD Properties also sells plots in some schemes covered here (Saumitra Vihar, IT City and Wellness City) and offers paid property verification. Research pages follow the same sourcing rules either way.</li>
            </ul>
        </section>

        <div class="rs-cta">
            <p><strong>Buying a specific plot or flat?</strong> Public data tells you about the area. Our ₹5,000 verification checks the property itself: registry chain, encumbrance, khatauni, LDA records and court cases.</p>
            <a href="/services/property-verification-lucknow">See the verification service →</a>
        </div>
    </div>
</div>
@endsection
