@extends('layouts.user-app')

{{--
    Lucknow circle rate (DM rate list) lookup + minimum-value calculator. Built 24 Oct 2026.
    Data: resources/data/circle-rates/*.json, one file per sub-registrar office (SRO), built by
    _deploy/2026-10-24-circle-rate/build_data.py from the official IGRSUP "मूल्यांकन सूची" PDF.
    One JSON per SRO. The SRO dropdown at the top (?sro=<slug>) picks which list the search, calculator and table
    show; the user asked for this so each table stays small. To add an SRO, drop its JSON (with "slug", "pdf",
    "effective") in the folder; it appears in the dropdown automatically.
    Every figure is copied from the official list. Do not round or "fix" numbers here; change the TSVs and rebuild.
--}}
@php
    $all = [];
    foreach (glob(resource_path('data/circle-rates/*.json')) as $file) {
        $l = json_decode(file_get_contents($file), true);
        $all[$l['slug']] = $l;
    }
    uasort($all, fn ($a, $b) => strcmp($a['sro_code'], $b['sro_code']));   // SRO number order: Sadar Pratham 227 first
    $defaultSro = array_key_first($all);
    $sel = isset($all[request('sro')]) ? request('sro') : $defaultSro;
    $L = $all[$sel];
    $lists = [[
        'sro' => $L['sro'], 'sro_hi' => $L['sro_hi'], 'effective' => $L['effective'], 'order' => $L['order'],
        'pdf' => asset('downloads/circle-rate/' . $L['pdf']), 'construction_3floor' => $L['construction_3floor'],
        'general_roads' => $L['general_roads'] ?? [],
    ]];
    $fmt = fn ($v) => $v === null ? '–' : number_format($v);
    // Search placeholder and the mohalla the calculator opens with, per SRO
    $rows = array_map(fn ($r) => $r + ['list' => 0, 'id' => $r['sr']], $L['rows']);
    // Mostly rural SROs, where land is bought by the bigha: offer bigha / biswa as area units (user's request, 26 Oct 2026)
    $bighaSro = in_array($sel, ['mohanlalganj', 'sarojini-nagar', 'sarojini-nagar-dwitiya'], true);
    $examples = ['sadar-pratham' => ['Alambagh, Charbagh, Park Road, आलमबाग', 'Alambagh'],
                 'sadar-dwitiya' => ['Vibhuti Khand, Aminabad, Hazratganj, गोमतीनगर', 'Vibhuti Khand'],
                 'sadar-tritiya' => ['Indira Nagar, Mahanagar, Vikas Nagar, इन्दिरा नगर', 'Mahanagar Gol Market'],
                 'mohanlalganj' => ['Nigohan, Purseni, Sisendi, नगराम', 'Purseni'],
                 'sarojini-nagar' => ['Telibagh, Vrindavan Yojana, Sushant City, शारदा नगर', 'Telibagh'],
                 'sarojini-nagar-dwitiya' => ['Ashiyana, Transport Nagar, Amausi, आशियाना', 'Ashiyana']][$sel]
                ?? [implode(', ', array_slice(array_column($rows, 'en'), 0, 3)), $rows[0]['en']];
    $count = count($rows);
    $cr = ['lists' => $lists, 'rows' => $rows];
    $effLabel = \Carbon\Carbon::parse($L['effective'])->format('j F Y');
    $sroName = $L['sro'] . ' (' . $L['sro_hi'] . ')';
    $pageUrl = url('/lucknow-circle-rate') . ($sel === $defaultSro ? '' : '?sro=' . $sel);
    // Names in the other SRO lists, so a search that finds nothing here can point to the right SRO
    $elsewhere = [];
    foreach ($all as $slug => $l) {
        if ($slug === $sel) continue;
        foreach ($l['rows'] as $r) $elsewhere[] = [$r['en'], $r['hi'], $slug, $l['sro']];
    }
    $sampleUrl = 'https://dsdproperties.in/public/downloads/DSD-Property-Verification-Sample-Report-Lucknow.pdf';
    $faqs = [
        ['What is the circle rate in Lucknow?', 'The circle rate (DM rate) is the minimum value per square metre that the District Magistrate of Lucknow fixes for land, flats and commercial property in each mohalla. Stamp duty is charged on the circle-rate value or the sale price, whichever is higher.'],
        ['When were the current Lucknow circle rates fixed?', 'Each sub-registrar office (SRO) of Lucknow has its own DM valuation list (मूल्यांकन सूची). The ' . $L['sro'] . ' list on this page is in force from ' . $effLabel . ' (' . $L['order'] . '). Pick another SRO from the menu at the top.'],
        ['How is the circle rate of a plot calculated?', 'Plot value = plot area in sq m × the rate for your mohalla and road width. Park-facing plots add 10%, plots on two roads use the higher road rate plus 10%, and both together add 20%. Area above 1,000 sq m is valued 30% lower.'],
        ['How is the circle rate of a flat calculated in Lucknow?', 'For flats in buildings of more than three floors: covered area × construction rate (ordinary or premium) + land share. The land share is at least 30% of the covered area, valued at the mohalla plot rate. Floors 4–6 get 5% off, 7th floor and above 10% off.'],
        ['How much is stamp duty in Lucknow?', 'Stamp duty in Uttar Pradesh is 7% of the value. If the buyer is a woman, it is 6% on property worth up to ₹1 crore. The registration fee is 1%.'],
        ['My mohalla is not in the list. Which rate applies?', 'The DM rules say that a mohalla or village not in the list takes the rate of the nearest listed one. We are adding more areas of Lucknow; ask us on WhatsApp for your area meanwhile.'],
    ];
@endphp

@section('title', 'Lucknow Circle Rate ' . $L['sro'] . ': Mohalla-wise DM Rate List and Stamp Duty Calculator')
@section('meta_description', 'Official Lucknow circle rates for ' . $count . ' mohallas of ' . $L['sro'] . ' SRO: plot rate by road width, flat, shop and office rates per sq m, plus a stamp duty calculator. Copied from the DM Lucknow valuation list.')
@section('meta_keywords', 'Lucknow circle rate, circle rate Lucknow 2025, DM rate Lucknow, Lucknow circle rate list, circle rate Hazratganj, circle rate Alambagh, Charbagh circle rate, Gomti Nagar circle rate, Vibhuti Khand circle rate, Aminabad circle rate, Indira Nagar circle rate, Mahanagar circle rate, Vikas Nagar circle rate, Mohanlalganj circle rate, Nigohan circle rate, Sarojini Nagar circle rate, Telibagh circle rate, Ashiyana circle rate, Transport Nagar circle rate, Lucknow mulyankan suchi, stamp duty Lucknow')

@section('canonical', $pageUrl)

@push('head')
{{-- Kept out of search on the user's request (26 Oct 2026) while all SROs are being added --}}
<meta name="robots" content="noindex, nofollow">
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Dataset',
            'name' => 'Lucknow circle rates (DM valuation list), ' . $L['sro'] . ' sub-registrar office',
            'description' => 'Minimum property values per square metre for ' . $count . ' mohallas of ' . $L['sro'] . ', Lucknow: plot rates by road width, flat construction rates, commercial carpet rates and main-road segment rates.',
            'url' => $pageUrl,
            'temporalCoverage' => '2025-08-01/..',
            'spatialCoverage' => ['@type' => 'Place', 'name' => 'Lucknow, Uttar Pradesh, India'],
            'isBasedOn' => 'Office of the District Magistrate, Lucknow: मूल्यांकन सूची, उप निबंधक कार्यालय सदर प्रथम, order no. 971 dated 01.08.2025',
            'creator' => ['@type' => 'Organization', 'name' => 'DSD Properties', 'url' => 'https://dsdproperties.in'],
            'distribution' => array_map(fn ($l) => ['@type' => 'DataDownload', 'encodingFormat' => 'application/pdf', 'contentUrl' => $l['pdf']], $lists),
        ],
        [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]], $faqs),
        ],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<style>
.lcr{--n:#011f4b;--t:#008080;--o:#FF5C00;--g:#64748b;--line:#e5e9f0;--soft:#f6f8fb;max-width:1120px;margin:0 auto;padding:28px 16px 56px;color:#1f2937}
.lcr h1{font-size:clamp(1.6rem,4vw,2.3rem);font-weight:800;color:var(--n);line-height:1.2;margin:0 0 8px;text-wrap:balance}
.lcr h2{font-size:clamp(1.25rem,3vw,1.55rem);font-weight:800;color:var(--n);margin:36px 0 10px}
.lcr .sub{color:var(--g);font-size:15px;line-height:1.7;margin:0 0 16px;max-width:760px}
.lcr-src{display:flex;flex-wrap:wrap;gap:8px 18px;align-items:center;background:#effaf9;border:1px solid #b2dfdb;border-radius:14px;padding:12px 16px;font-size:13.5px;color:#134e4a;margin-bottom:22px}
.lcr-src a{color:var(--t);font-weight:700}
.lcr-sro{display:flex;flex-wrap:wrap;align-items:center;gap:8px 12px;background:var(--n);color:#fff;border-radius:16px;padding:14px 16px;margin:0 0 20px}
.lcr-sro label{font-size:12px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:#99d6d6}
.lcr-sro select{flex:1;min-width:220px;max-width:420px;padding:11px 14px;border:0;border-radius:11px;background:#fff;color:var(--n);font:inherit;font-size:16px;font-weight:700}
.lcr-sro span{flex-basis:100%;font-size:12.5px;color:#cbd5e1}
.lcr-sro button{padding:10px 14px;border:0;border-radius:10px;background:var(--o);color:#fff;font-weight:700}
.lcr-box{background:#fff;border:1px solid var(--line);border-radius:18px;padding:20px;box-shadow:0 10px 30px rgba(1,31,75,.06)}
.lcr-search{position:relative}
.lcr-search input{width:100%;box-sizing:border-box;padding:14px 16px 14px 44px;border:1.5px solid var(--line);border-radius:12px;background:var(--soft);font:inherit;font-size:16px;color:var(--n)}
.lcr-search input:focus{outline:none;border-color:var(--t);background:#fff}
.lcr-search svg{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--g)}
.lcr-hint{font-size:12.5px;color:var(--g);margin:8px 2px 0}
.lcr-results{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:14px;margin-top:16px}
.lcr-card{border:1px solid var(--line);border-radius:16px;padding:16px;background:#fff}
.lcr-card h3{margin:0;font-size:17px;color:var(--n);line-height:1.3}
.lcr-card .hi{font-size:14px;color:#475569;margin:2px 0 8px}
.lcr-card .meta{font-size:12px;color:var(--g);margin-bottom:10px}
.lcr-rates{width:100%;border-collapse:collapse;font-size:13.5px}
.lcr-rates td{padding:6px 0;border-bottom:1px dashed var(--line)}
.lcr-rates td:last-child{text-align:right;font-weight:700;color:var(--n);font-variant-numeric:tabular-nums;white-space:nowrap}
.lcr-rates tr.h td{font-size:11px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--t);border-bottom:0;padding-top:10px}
.lcr-rates small{font-weight:500;color:var(--g)}
.lcr-road{background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;padding:8px 10px;margin-top:8px;font-size:12.5px;color:#7c2d12;line-height:1.5}
.lcr-note{background:#fef9c3;border:1px solid #fde68a;border-radius:10px;padding:8px 10px;margin-top:8px;font-size:12.5px;color:#713f12;line-height:1.5}
.lcr-card button{margin-top:12px;width:100%;padding:10px;border:1.5px solid var(--t);border-radius:10px;background:#fff;color:var(--t);font:inherit;font-weight:700;font-size:14px;cursor:pointer}
.lcr-card button:hover{background:#effaf9}
.lcr-empty{padding:18px;border:1px dashed var(--line);border-radius:14px;color:var(--g);font-size:14px;line-height:1.7}
.lcr-grid{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:22px;align-items:start}
@media(max-width:860px){.lcr-grid{grid-template-columns:1fr}}
.lcr-label{display:block;font-size:12px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--g);margin:0 0 7px}
.lcr-field{margin-bottom:16px}
.lcr select,.lcr .num{width:100%;box-sizing:border-box;padding:12px 14px;border:1.5px solid var(--line);border-radius:11px;background:var(--soft);font:inherit;font-size:16px;color:var(--n);font-weight:600}
.lcr select:focus,.lcr .num:focus{outline:none;border-color:var(--t);background:#fff}
.lcr-two{display:grid;grid-template-columns:1.4fr 1fr;gap:10px}
.lcr-seg{display:flex;gap:6px;flex-wrap:wrap}
.lcr-seg button{flex:1;min-width:0;padding:10px 8px;border:1.5px solid var(--line);border-radius:10px;background:#fff;font:inherit;font-size:13.5px;font-weight:600;color:#334155;cursor:pointer}
.lcr-seg button.on{border-color:var(--t);background:#effaf9;color:var(--n)}
.lcr-chk{display:flex;gap:10px;align-items:flex-start;font-size:14px;color:#334155;margin:8px 0;cursor:pointer;line-height:1.45}
.lcr-chk input{margin-top:3px;width:17px;height:17px;accent-color:var(--t)}
.lcr-price{background:linear-gradient(135deg,#011f4b,#035e6b);color:#fff;border-radius:16px;padding:20px 22px;margin-bottom:14px}
.lcr-price small{font-size:12px;letter-spacing:.06em;text-transform:uppercase;opacity:.8}
.lcr-price .big{font-size:clamp(1.9rem,6vw,2.6rem);font-weight:800;line-height:1.1;margin:4px 0 6px;font-variant-numeric:tabular-nums}
.lcr-price p{margin:0;font-size:13.5px;opacity:.9}
.lcr-row{display:flex;justify-content:space-between;gap:12px;padding:9px 0;border-bottom:1px dashed var(--line);font-size:14px}
.lcr-row span:last-child{font-weight:700;color:var(--n);font-variant-numeric:tabular-nums;white-space:nowrap}
.lcr-row.tot{border-top:2px solid var(--n);border-bottom:0;margin-top:4px;padding-top:12px;font-size:15.5px}
.lcr-row.tot span:last-child{color:var(--o)}
.lcr-how{font-size:12.5px;color:var(--g);line-height:1.6;margin:10px 0 0}
.lcr-cta{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:14px}
@media(max-width:560px){.lcr-cta{grid-template-columns:1fr}}
.lcr-cta a{display:flex;align-items:center;justify-content:center;padding:13px;border-radius:12px;font-weight:700;font-size:14.5px;text-decoration:none;text-align:center}
.lcr-cta .vf{background:var(--o);color:#fff}.lcr-cta .wa{background:#25D366;color:#fff}
.lcr-sample{display:block;text-align:center;margin-top:8px;font-size:14px;color:var(--t);font-weight:700}
.lcr-tbl-wrap{overflow-x:auto;border:1px solid var(--line);border-radius:14px;max-height:620px}
.lcr-tbl{width:100%;border-collapse:collapse;font-size:13px;min-width:980px}
.lcr-tbl th{position:sticky;top:0;background:var(--n);color:#fff;text-align:left;padding:9px 8px;font-weight:700;z-index:1}
.lcr-tbl td{padding:8px;border-bottom:1px solid var(--line);font-variant-numeric:tabular-nums;white-space:nowrap}
.lcr-tbl td.r,.lcr-tbl th.r{text-align:right}
.lcr-tbl tbody tr:nth-child(even) td{background:#fafbfd}
.lcr-rules{font-size:14px;line-height:1.75;color:#334155}
.lcr-rules ul{padding-left:20px;margin:0}
.lcr-rules li{margin-bottom:6px}
.lcr-faq details{border:1px solid var(--line);border-radius:12px;padding:12px 16px;margin-bottom:10px;background:#fff}
.lcr-faq summary{cursor:pointer;font-weight:700;color:var(--n);font-size:15px}
.lcr-faq p{margin:8px 0 2px;font-size:14px;line-height:1.7;color:#475569}
.lcr-verify{margin-top:30px;background:#fff7ed;border:1px solid #fed7aa;border-radius:18px;padding:20px 22px}
.lcr-verify h2{margin:0 0 6px}
.lcr-verify p{margin:0 0 12px;font-size:14.5px;line-height:1.7;color:#7c2d12}
</style>
@endpush

@section('content')
<div class="lcr">
    <form class="lcr-sro" method="get" action="{{ url('/lucknow-circle-rate') }}">
        <label for="lcr-sro">SRO (उप निबंधक कार्यालय)</label>
        <select id="lcr-sro" name="sro" onchange="this.form.submit()">
            @foreach($all as $slug => $l)
                <option value="{{ $slug }}" @selected($slug === $sel)>{{ $l['sro'] }} ({{ $l['sro_hi'] }})</option>
            @endforeach
        </select>
        <noscript><button type="submit">Show</button></noscript>
        <span>Choose the sub-registrar office your property is registered in. More SROs are being added.</span>
    </form>
    <h1>Lucknow Circle Rate: {{ $L['sro'] }}</h1>
    <p class="sub">Search your mohalla to see the official minimum value per square metre for plots, flats, shops and offices, then calculate the circle-rate value and stamp duty for your property. Every rate below is copied from the District Magistrate's valuation list, without any rounding or changes.</p>

    <div class="lcr-src">
        <span><strong>SRO:</strong> {{ $sroName }}, {{ $count }} mohallas</span>
        <span><strong>In force from:</strong> {{ $effLabel }}@if(!empty($L['amendment'])), revised rates for some areas from 4 June 2026 (<a href="{{ asset('downloads/circle-rate/Lucknow-Circle-Rate-Revision-Order-1952-04-06-2026.pdf') }}" target="_blank" rel="noopener">DM order {{ $L['amendment']['no'] }}</a>)@endif</span>
        <span><strong>Source:</strong> DM Lucknow valuation list (मूल्यांकन सूची) · <a href="{{ $lists[0]['pdf'] }}" target="_blank" rel="noopener">official PDF</a></span>
    </div>

    {{-- Search --}}
    <div class="lcr-box">
        <label class="lcr-label" for="lcr-q">Find your mohalla</label>
        <div class="lcr-search">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            <input id="lcr-q" type="search" autocomplete="off" placeholder="e.g. {{ $examples[0] }}">
        </div>
        <p class="lcr-hint">Type in English or Hindi. All rates are in ₹ per square metre (sq m), as in the official list; ₹ per sq ft is shown in grey.</p>
        <div id="lcr-results" class="lcr-results"></div>
    </div>

    {{-- Calculator --}}
    <h2 id="calculator">Circle rate value and stamp duty calculator</h2>
    <div class="lcr-grid">
        <div class="lcr-box">
            <div class="lcr-field">
                <label class="lcr-label" for="c-moh">Mohalla</label>
                <select id="c-moh"></select>
            </div>
            <div class="lcr-field">
                <span class="lcr-label">Property type</span>
                <div class="lcr-seg" id="c-type">
                    <button type="button" class="on" data-v="plot">Plot</button>
                    <button type="button" data-v="flat">Flat</button>
                    <button type="button" data-v="house">House</button>
                    <button type="button" data-v="shop">Shop / office</button>
                </div>
            </div>
            <div class="lcr-field">
                <label class="lcr-label" for="c-road">Road in front of the property</label>
                <select id="c-road"></select>
            </div>
            <div class="lcr-field">
                <label class="lcr-label" for="c-area" id="c-area-l">Plot area</label>
                <div class="lcr-two">
                    <input id="c-area" class="num" type="number" inputmode="decimal" min="0" step="any" value="100">
                    <select id="c-unit"><option value="sqm">sq m</option><option value="sqft">sq ft</option><option value="gaj">gaj (sq yd)</option>@if($bighaSro)<option value="bigha">bigha</option><option value="biswa">biswa</option>@endif</select>
                </div>
            </div>

            {{-- flat only --}}
            <div id="g-flat" hidden>
                <div class="lcr-field">
                    <span class="lcr-label">Flat category</span>
                    <div class="lcr-seg" id="c-fcat">
                        <button type="button" class="on" data-v="ordinary">Ordinary</button>
                        <button type="button" data-v="premium">Premium</button>
                    </div>
                    <p class="lcr-hint">Premium = the complex has any two of: swimming pool, club, gym, or it is on a main road segment.</p>
                </div>
                <div class="lcr-field">
                    <label class="lcr-label" for="c-floor">Floor</label>
                    <select id="c-floor"><option value="0">Ground to 3rd floor</option><option value="5">4th to 6th floor (−5%)</option><option value="10">7th floor and above (−10%)</option><option value="pent">Penthouse (no rebate)</option></select>
                </div>
            </div>

            {{-- house only --}}
            <div id="g-house" hidden>
                <div class="lcr-field">
                    <label class="lcr-label" for="c-built">Covered (built-up) area, all floors</label>
                    <input id="c-built" class="num" type="number" inputmode="decimal" min="0" step="any" value="100">
                    <p class="lcr-hint">Same unit as the plot area above.</p>
                </div>
                <div class="lcr-field">
                    <label class="lcr-label" for="c-ctype">Construction (roof type)</label>
                    <select id="c-ctype"><option value="rcc">RCC</option><option value="rbc">RBC</option><option value="kadi">Kadi / girder-patiya / dat</option><option value="tin">Tin / asbestos / fibre shed</option><option value="kachcha">Kachcha / chhappar / khaprail</option></select>
                </div>
                <div class="lcr-field">
                    <span class="lcr-label">Finish</span>
                    <div class="lcr-seg" id="c-class">
                        <button type="button" class="on" data-v="0">First class</button>
                        <button type="button" data-v="1">Second class</button>
                    </div>
                    <p class="lcr-hint">First class = sheesham / teak / deodar / waterproof board / metal doors and windows, and marble / stone / vitrified floors.</p>
                </div>
                <div class="lcr-field">
                    <label class="lcr-label" for="c-age">Age of the building (years)</label>
                    <input id="c-age" class="num" type="number" inputmode="numeric" min="0" step="1" value="5">
                </div>
            </div>

            {{-- shop only --}}
            <div id="g-shop" hidden>
                <div class="lcr-field">
                    <span class="lcr-label">Use</span>
                    <div class="lcr-seg" id="c-use">
                        <button type="button" class="on" data-v="shop">Shop</button>
                        <button type="button" data-v="office">Office</button>
                        <button type="button" data-v="godown">Godown</button>
                    </div>
                </div>
                <div class="lcr-field">
                    <label class="lcr-label" for="c-sfloor">Floor</label>
                    <select id="c-sfloor"><option value="100">Ground / upper ground / lower ground</option><option value="90">Basement or 1st floor (90%)</option><option value="80">2nd, 3rd or 4th floor (80%)</option><option value="70">5th floor and above (70%)</option></select>
                </div>
                <label class="lcr-chk"><input type="checkbox" id="c-ac"> Air-conditioned, or in a shopping complex / mall / multiplex (+20%, no floor rebate)</label>
                <p class="lcr-hint">For a shop inside a commercial building. Enter the carpet area. A stand-alone shop sold with its land is valued differently; ask us.</p>
            </div>

            {{-- plot + house --}}
            <div id="g-extra">
                <label class="lcr-chk"><input type="checkbox" id="c-park"> Park facing (+10%)</label>
                <label class="lcr-chk"><input type="checkbox" id="c-corner"> Road on more than one side (higher road rate +10%)</label>
            </div>

            <div class="lcr-field" style="margin-top:14px">
                <span class="lcr-label">Buyer</span>
                <div class="lcr-seg" id="c-buyer">
                    <button type="button" class="on" data-v="m">Man / joint</button>
                    <button type="button" data-v="f">Woman</button>
                </div>
            </div>
            <div class="lcr-field">
                <label class="lcr-label" for="c-deal">Agreed sale price (optional, ₹)</label>
                <input id="c-deal" class="num" type="number" inputmode="numeric" min="0" step="1" placeholder="Stamp duty is on the higher of the two">
            </div>
        </div>

        <div>
            <div class="lcr-price">
                <small>Minimum value as per DM circle rate</small>
                <div class="big" id="r-val">–</div>
                <p id="r-line">–</p>
            </div>
            <div class="lcr-box">
                <div id="r-rows"></div>
                <div class="lcr-row tot"><span>Total to pay at registry</span><span id="r-total">–</span></div>
                <p class="lcr-how" id="r-how"></p>
                <p class="lcr-how">This follows the rules printed in the DM list. The sub-registrar's calculation on the IGRSUP portal is final, and some cases (agricultural land, industrial units, hotels, plots above 0.1 ha, roof rights) have extra rules listed below.</p>
                <div class="lcr-cta">
                    <a class="vf" id="r-verify" href="https://wa.me/918595002933" target="_blank" rel="noopener">Check the papers first (₹5,000)</a>
                    <a class="wa" id="r-wa" href="https://wa.me/918595002933" target="_blank" rel="noopener">Ask us on WhatsApp</a>
                </div>
                <a class="lcr-sample" href="{{ $sampleUrl }}" target="_blank" rel="noopener">See a sample verification report →</a>
            </div>
        </div>
    </div>

    {{-- Full table --}}
    <h2 id="all-rates">All {{ $count }} mohallas of {{ $L['sro'] }}</h2>
    <p class="sub">Plot rates by road width, flat construction rates and commercial carpet rates, in ₹ per sq m. Mohallas on a main road segment have a higher rate for that road; see the search results.</p>
    <div class="lcr-tbl-wrap">
        <table class="lcr-tbl">
            <thead><tr>
                <th>#</th><th>Mohalla</th><th>मोहल्ला</th><th>Ward</th>
                <th class="r">Plot, road &lt;9 m</th><th class="r">9–12 m</th><th class="r">12–18 m</th><th class="r">18 m+</th>
                <th class="r">Flat (ordinary)</th><th class="r">Flat (premium)</th>
                <th class="r">Shop</th><th class="r">Office</th><th class="r">Godown</th>
            </tr></thead>
            <tbody>
            @foreach($rows as $r)
                <tr>
                    <td>{{ $r['id'] }}</td><td>{{ $r['en'] }}</td><td>{{ $r['hi'] }}</td><td>{{ $r['ward'] }} {{ $r['ward_name'] }}</td>
                    <td class="r">{{ $fmt($r['plot']['lt9']) }}</td><td class="r">{{ $fmt($r['plot']['9_12']) }}</td><td class="r">{{ $fmt($r['plot']['12_18']) }}</td><td class="r">{{ $fmt($r['plot']['gt18']) }}</td>
                    <td class="r">{{ $fmt($r['flat']['ordinary']) }}</td><td class="r">{{ $fmt($r['flat']['premium']) }}</td>
                    <td class="r">{{ $fmt($r['commercial']['shop'] ?? null) }}</td><td class="r">{{ $fmt($r['commercial']['office'] ?? null) }}</td><td class="r">{{ $fmt($r['commercial']['godown'] ?? null) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if(count($lists[0]['general_roads']))
    <h2 id="main-roads">Main roads with one rate for every mohalla along them</h2>
    <p class="sub">The {{ $L['sro'] }} list gives these roads a single rate for all revenue villages and mohallas on both sides. Rates in ₹ per sq m.</p>
    <div class="lcr-tbl-wrap" style="max-height:none">
        <table class="lcr-tbl" style="min-width:720px">
            <thead><tr><th>Road segment (as in the official list)</th><th class="r">Plot</th><th class="r">Shop</th><th class="r">Office</th><th class="r">Godown</th></tr></thead>
            <tbody>
            @foreach($lists[0]['general_roads'] as $g)
                <tr><td style="white-space:normal">{{ $g['segment'] }}</td><td class="r">{{ $fmt($g['plot']) }}</td><td class="r">{{ $fmt($g['shop']) }}</td><td class="r">{{ $fmt($g['office']) }}</td><td class="r">{{ $fmt($g['godown']) }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Rules --}}
    <h2>How the DM list values a property</h2>
    <div class="lcr-box lcr-rules">
        <ul>
            <li><strong>Plot:</strong> area × the rate for the mohalla and the width of the road in front. Park facing +10%; road on more than one side: the higher road rate +10%; both +20%. Area above 1,000 sq m is valued at 30% less.</li>
            <li><strong>Main road segment:</strong> a property on a listed main road (or its service lane) takes that road's rate, e.g. Charbagh station to Awadh Hospital, MG Marg, Cantt Road, Subhash Marg.</li>
            <li><strong>Flat (building above 3 floors):</strong> covered area × construction rate + land share. The land share is at least 30% of the covered area, at the plot rate. Floors 4–6: −5%; 7th floor and up: −10%; penthouse: no rebate. Flats with any two of pool, club, gym or main road frontage are "premium".</li>
            <li><strong>House (up to 3 floors):</strong> land value + covered area × construction rate (RCC ₹18,000 / ₹15,000, RBC ₹12,000 / ₹10,000, kadi-girder ₹6,000 / ₹5,000, tin shed ₹4,500 / ₹4,000, kachcha ₹2,500 / ₹2,000 per sq m, first / second class). No depreciation for the first 20 years; after that, depreciation = value × age × 9 / (life × 10), and the building is never valued below 30%.</li>
            <li><strong>Floor-wise sale in a 2–3 storey house:</strong> land share 50% each (2 floors) or 33.3% (3 floors).</li>
            <li><strong>Shop / office in a commercial building:</strong> carpet area × rate. Basement or 1st floor 90%, 2nd–4th floor 80%, higher 70%. AC shops and shops in malls or shopping complexes +20% and no floor rebate.</li>
            <li><strong>Commercial plot</strong> (shown as commercial in the deed, layout or master plan): plot rate +50%. A plot with a commercial activity in its boundary: +20%. A stand-alone shop with its land: land +50% plus construction (shop ₹22,000, office ₹18,000, godown ₹14,000 per sq m).</li>
            <li><strong>Hotel, nursing home, guest house, marriage lawn, dhaba, cinema:</strong> land +50%; construction RCC ₹20,000, RBC ₹18,000, tin shed ₹10,000 per sq m.</li>
            <li><strong>Not listed?</strong> A mohalla or village missing from the list takes the rate of the nearest listed one.</li>
            <li><strong>Papers the deed needs:</strong> road width and name in the boundary, a route map (नक्शा नजरी), a geo-tagged photo with latitude and longitude, and for built property a map of the construction.</li>
        </ul>
    </div>

    {{-- FAQ --}}
    <h2>Frequently asked questions</h2>
    <div class="lcr-faq">
        @foreach($faqs as $f)
            <details><summary>{{ $f[0] }}</summary><p>{{ $f[1] }}</p></details>
        @endforeach
    </div>

    <div class="lcr-verify">
        <h2>Paying stamp duty on a property? Check the papers first.</h2>
        <p>The circle rate tells you the minimum value, not whether the seller really owns the land. We check the khatauni (CH-41, CH-45), the encumbrance certificate (भार मुक्त), court cases and the LDA approval, and send you a report in 48 hours for ₹5,000.</p>
        <div class="lcr-cta" style="margin-top:0">
            <a class="vf" href="{{ url('/services/property-verification-lucknow') }}">See what we check</a>
            <a class="wa" href="https://wa.me/918595002933?text={{ rawurlencode('Hi, I checked the circle rate on your website. I want to get a property verified before registry.') }}" target="_blank" rel="noopener">WhatsApp us</a>
        </div>
        <a class="lcr-sample" href="{{ $sampleUrl }}" target="_blank" rel="noopener">रिपोर्ट देखें →</a>
    </div>
</div>
@endsection

@push('scripts')
@include('partials.circle-rate-engine')
<script>
(function () {
    var DATA = @json($cr);
    var ELSEWHERE = @json($elsewhere);
    var ROWS = DATA.rows, SQFT = 10.7639, GAJ = 0.836127;
    var $ = function (id) { return document.getElementById(id); };
    function inr(n) { return Math.round(n).toLocaleString('en-IN'); }
    function money(n) {
        if (n >= 1e7) return '₹' + (n / 1e7).toFixed(2) + ' Cr';
        if (n >= 1e5) return '₹' + (n / 1e5).toFixed(2) + ' L';
        return '₹' + inr(n);
    }
    function perSqft(n) { return '<small>₹' + inr(n / SQFT) + '/sq ft</small>'; }
    function pick(id) { var b = document.querySelector('#' + id + ' button.on'); return b ? b.getAttribute('data-v') : null; }
    function track(name, p) { if (typeof window.gtag === 'function') window.gtag('event', name, p || {}); }
    function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
    function norm(s) { return String(s).toLowerCase().replace(/[\s.()\-]/g, '').replace(/ड़/g, 'ड').replace(/ँ|ं/g, 'ं'); }

    // ── Search ─────────────────────────────────────────
    function rate(v) { return v == null ? '<small>not in list</small>' : '₹' + inr(v) + ' ' + perSqft(v); }
    function segName(rd) { return rd.segment_en ? esc(rd.segment_en) + '</strong> (' + esc(rd.segment) + ')' : esc(rd.segment) + '</strong>'; }
    function card(r) {
        var p = r.plot, f = r.flat, c = r.commercial, a = r.agri;
        var h = '<div class="lcr-card"><h3>' + esc(r.en) + '</h3><div class="hi">' + esc(r.hi) + '</div>' +
            '<div class="meta">' + (r.category ? esc(r.category) + ' · ' : '') + (r.vcode === '-' && /^1\d\d$/.test(r.ward) ? 'Pargana ' : 'Ward ') + esc(r.ward) + ' (' + esc(r.ward_name) + ')' + (r.vcode === '-' ? '' : ' · V-code ' + r.vcode) + ' · ' + esc(DATA.lists[r.list].sro) + ' SRO</div>' +
            '<table class="lcr-rates">' +
            '<tr class="h"><td colspan="2">Residential plot, ₹/sq m</td></tr>' +
            '<tr><td>Road under 9 m</td><td>' + rate(p.lt9) + '</td></tr>' +
            '<tr><td>Road 9–12 m</td><td>' + rate(p['9_12']) + '</td></tr>' +
            '<tr><td>Road 12–18 m</td><td>' + rate(p['12_18']) + '</td></tr>' +
            '<tr><td>Road above 18 m</td><td>' + rate(p.gt18) + '</td></tr>' +
            '<tr class="h"><td colspan="2">Flat construction rate, ₹/sq m</td></tr>' +
            '<tr><td>Ordinary</td><td>₹' + inr(f.ordinary) + '</td></tr>' +
            '<tr><td>Premium</td><td>₹' + inr(f.premium) + '</td></tr>' +
            (c ? '<tr class="h"><td colspan="2">Commercial carpet area, ₹/sq m</td></tr>' +
            '<tr><td>Shop · Office · Godown</td><td>₹' + inr(c.shop) + ' · ' + inr(c.office) + ' · ' + inr(c.godown) + '</td></tr>' : '') +
            (a ? '<tr class="h"><td colspan="2">Agricultural land, ₹ lakh per hectare</td></tr>' +
            '<tr><td>On a district road</td><td>₹' + inr(a.district_road) + ' L</td></tr>' +
            '<tr><td>On a link road</td><td>₹' + inr(a.link_road) + ' L</td></tr>' +
            '<tr><td>Next to abadi</td><td>₹' + inr(a.near_abadi) + ' L</td></tr>' +
            '<tr><td>Other land</td><td>₹' + inr(a.general) + ' L</td></tr>' : '') +
            '</table>';
        r.roads.forEach(function (rd) {
            h += '<div class="lcr-road"><strong>On ' + segName(rd) + ': plot ₹' + inr(rd.plot) + '/sq m · shop ₹' + inr(rd.shop) + ' · office ₹' + inr(rd.office) + ' · godown ₹' + inr(rd.godown) + (rd.agri ? ' · agricultural ₹' + inr(rd.agri) + ' lakh/ha' : '') + '</div>';
        });
        if (r.amended) h += '<div class="lcr-note">Rates for this ' + (r.vcode === '-' ? 'village' : 'mohalla') + ' were revised by DM Lucknow order 1952 dated 04.06.2026; the figures above are the revised ones.</div>';
        if (r.note) h += '<div class="lcr-note">' + esc(r.note) + '</div>';
        h += '<button type="button" data-sr="' + r.id + '">Calculate for this mohalla</button></div>';
        return h;
    }
    var q = $('lcr-q'), out = $('lcr-results'), tq;
    function search() {
        var s = norm(q.value);
        if (s.length < 2) { out.innerHTML = ''; return; }
        // Mohalla-name matches first, then ward names, then mohallas on a matching main road
        function score(r) {
            if (norm(r.en).indexOf(s) === 0 || norm(r.hi).indexOf(s) === 0) return 4;
            if (norm(r.en).indexOf(s) > -1 || norm(r.hi).indexOf(s) > -1) return 3;
            if (norm(r.ward_name).indexOf(s) > -1) return 2;
            if (r.roads.some(function (x) { return norm(x.segment).indexOf(s) > -1 || norm(x.segment_en || '').indexOf(s) > -1; })) return 1;
            return 0;
        }
        var hits = ROWS.map(function (r) { return [score(r), r]; }).filter(function (x) { return x[0]; })
            .sort(function (a, b) { return b[0] - a[0] || a[1].id - b[1].id; }).map(function (x) { return x[1]; });
        var other = '';
        if (!hits.length) {
            var found = ELSEWHERE.filter(function (x) { return norm(x[0]).indexOf(s) > -1 || norm(x[1]).indexOf(s) > -1; }).slice(0, 5);
            if (found.length) other = ' It is in another SRO: ' + found.map(function (x) { return '<a href="?sro=' + x[2] + '">' + esc(x[0]) + ' (' + esc(x[3]) + ')</a>'; }).join(', ') + '.';
        }
        out.innerHTML = hits.length ? hits.slice(0, 24).map(card).join('') :
            '<div class="lcr-empty">No mohalla called "' + esc(q.value) + '" in the ' + esc(DATA.lists[0].sro) + ' list.' + other + ' Check that you picked the right SRO at the top. Under the DM rules, a mohalla that is not listed takes the rate of the nearest listed one. <a href="https://wa.me/918595002933?text=' + encodeURIComponent('Hi, what is the circle rate for ' + q.value + ', Lucknow?') + '" target="_blank" rel="noopener">Ask us on WhatsApp</a>.</div>';
        clearTimeout(tq); tq = setTimeout(function () { track('circle_rate_search', { search_term: q.value.slice(0, 60), results: hits.length }); }, 1200);
    }
    q.addEventListener('input', search);
    out.addEventListener('click', function (e) {
        var b = e.target.closest('button[data-sr]'); if (!b) return;
        moh.value = b.getAttribute('data-sr'); fillRoads(); calc();
        document.getElementById('calculator').scrollIntoView({ behavior: 'smooth' });
    });

    // ── Calculator ─────────────────────────────────────
    var moh = $('c-moh'), road = $('c-road');
    ROWS.slice().sort(function (a, b) { return a.en.localeCompare(b.en); }).forEach(function (r) {
        var o = document.createElement('option'); o.value = r.id; o.textContent = r.en + ' · ' + r.hi; moh.appendChild(o);
    });
    var first = ROWS.filter(function (r) { return r.en === @json($examples[1]); })[0] || ROWS[0];
    moh.value = first.id;

    function row() { var id = +moh.value; return ROWS.filter(function (r) { return r.id === id; })[0]; }
    var WIDTH_TXT = { lt9: 'Under 9 m wide', '9_12': '9 to 12 m', '12_18': '12 to 18 m', gt18: 'Above 18 m' };
    function fillRoads() {
        var r = row(), prev = road.value, list = DATA.lists[r.list], all = CRC.roads(r, list);
        var opt = function (x, txt) { return '<option value="' + x.v + '">' + txt + ' (₹' + inr(x.rate) + '/sq m)</option>'; };
        var gen = all.filter(function (x) { return x.kind === 'gen'; });
        road.innerHTML = all.filter(function (x) { return x.kind === 'width'; }).map(function (x) { return opt(x, WIDTH_TXT[x.v]); }).join('') +
            all.filter(function (x) { return x.kind === 'seg'; }).map(function (x) { return opt(x, 'On main road: ' + esc(x.name)); }).join('') +
            (gen.length ? '<optgroup label="Main roads with one rate for all mohallas">' + gen.map(function (x) { return opt(x, esc(x.name)); }).join('') + '</optgroup>' : '');
        if ([].some.call(road.options, function (o) { return o.value === prev; })) road.value = prev;
    }
    function toSqm(v) { return CRC.toSqm(v, $('c-unit').value); }
    function sqmTxt(v) {
        var t = (Math.round(v * 100) / 100).toLocaleString('en-IN') + ' sq m', u = $('c-unit').value;
        if (u === 'bigha' || u === 'biswa') t += ' (' + (Math.round(v / (u === 'bigha' ? CRC.BIGHA : CRC.BISWA) * 1000) / 1000).toLocaleString('en-IN') + ' ' + u + ')';
        return t;
    }

    // Engine line kinds → the English text this page has always shown
    function lineTxt(l) {
        switch (l.k) {
            case 'land': return ['Land: ' + sqmTxt(l.area) + ' × ₹' + inr(l.rate) + (l.pct ? ' (+' + l.pct + '%)' : ''), money(l.amount)];
            case 'bump': return ['Park facing / more than one road (+' + l.pct + '%)', money(l.amount)];
            case 'flat_build': return ['Construction: ' + sqmTxt(l.area) + ' × ₹' + inr(l.rate) + ' (' + l.cat + ')', money(l.amount)];
            case 'flat_land': return ['Land share: 30% = ' + sqmTxt(l.area) + ' × ₹' + inr(l.rate), money(l.amount)];
            case 'floor_rebate': return ['Floor rebate (−' + l.pct + '%)', '−' + money(l.amount)];
            case 'house_build': return ['Building: ' + sqmTxt(l.area) + ' × ₹' + inr(l.rate), money(l.amount)];
            case 'depreciation': return ['Depreciation (' + l.age + ' of ' + l.life + ' years)', '−' + money(l.amount)];
            case 'carpet': return ['Carpet: ' + sqmTxt(l.area) + ' × ₹' + inr(l.rate) + ' (' + l.use + (l.seg ? ', main road' : '') + ')', money(l.amount)];
            case 'shop_floor': return ['Floor (' + l.pct + '%)', '−' + money(l.amount)];
            case 'ac': return ['AC / shopping complex (+20%)', money(l.amount)];
        }
    }

    function calc() {
        var r = row(), type = pick('c-type'), area = toSqm(parseFloat($('c-area').value) || 0), how = '';
        $('g-flat').hidden = type !== 'flat'; $('g-house').hidden = type !== 'house'; $('g-shop').hidden = type !== 'shop';
        $('g-extra').hidden = !(type === 'plot' || type === 'house');
        $('c-area-l').textContent = { plot: 'Plot area', flat: 'Covered area of the flat', house: 'Plot (land) area', shop: 'Carpet area' }[type];

        var res = CRC.value({
            type: type, row: r, list: DATA.lists[r.list], road: road.value, area: area,
            park: $('c-park').checked, corner: $('c-corner').checked,
            fcat: pick('c-fcat'), floor: $('c-floor').value,
            built: toSqm(parseFloat($('c-built').value) || 0), ctype: $('c-ctype').value, cls: +pick('c-class'),
            age: parseInt($('c-age').value, 10) || 0,
            use: pick('c-use'), sfloor: $('c-sfloor').value, ac: $('c-ac').checked
        });
        var value = res.value, lines = res.lines.map(lineTxt);
        if (res.flags.over1000) how = 'Area above 1,000 sq m is valued at 30% less. ';
        if (res.flags.landShare) how = 'Land share is taken at the minimum 30% of covered area; if the deed gives a larger undivided share, the value is higher. ';
        if (type === 'house') how = res.flags.noDep ? 'No depreciation for the first 20 years. ' : '';

        var deal = parseFloat($('c-deal').value) || 0, basis = Math.max(value, deal);
        var woman = pick('c-buyer') === 'f', D = CRC.duty(basis, woman ? 'f' : 'm');
        var sdRate = D.rate, sd = D.sd, reg = D.reg;

        $('r-val').textContent = money(value);
        $('r-line').textContent = r.en + ' (' + r.hi + ') · ' + { plot: 'plot', flat: 'flat', house: 'house', shop: 'commercial unit' }[type] + ' · ' + sqmTxt(area);
        var html = lines.map(function (l) { return '<div class="lcr-row"><span>' + l[0] + '</span><span>' + l[1] + '</span></div>'; }).join('');
        html += '<div class="lcr-row"><span><strong>Circle-rate value</strong></span><span>' + money(value) + '</span></div>';
        if (deal) html += '<div class="lcr-row"><span>Stamp duty charged on ' + (deal > value ? 'the sale price' : 'the circle-rate value') + '</span><span>' + money(basis) + '</span></div>';
        html += '<div class="lcr-row"><span>Stamp duty (' + Math.round(sdRate * 100) + '%' + (woman ? (basis <= 1e7 ? ', woman buyer' : ', above ₹1 Cr') : '') + ')</span><span>' + money(sd) + '</span></div>';
        html += '<div class="lcr-row"><span>Registration fee (1%)</span><span>' + money(reg) + '</span></div>';
        $('r-rows').innerHTML = html;
        $('r-total').textContent = money(sd + reg);
        $('r-how').textContent = how;

        var msg = 'Hi, I calculated the circle rate for a ' + type + ' in ' + r.en + ', Lucknow (' + sqmTxt(area) + '): ' + money(value) + '. ';
        $('r-wa').href = 'https://wa.me/918595002933?text=' + encodeURIComponent(msg + 'I have a question about the registry.');
        $('r-verify').href = 'https://wa.me/918595002933?text=' + encodeURIComponent(msg + 'I want to get the papers verified (₹5,000) before buying.');
    }

    ['c-type', 'c-fcat', 'c-class', 'c-use', 'c-buyer'].forEach(function (id) {
        $(id).addEventListener('click', function (e) {
            var b = e.target.closest('button'); if (!b) return;
            [].forEach.call(this.querySelectorAll('button'), function (x) { x.classList.toggle('on', x === b); });
            calc();
        });
    });
    ['c-road', 'c-area', 'c-unit', 'c-floor', 'c-built', 'c-ctype', 'c-age', 'c-sfloor', 'c-ac', 'c-park', 'c-corner', 'c-deal'].forEach(function (id) {
        $(id).addEventListener('input', calc); $(id).addEventListener('change', calc);
    });
    moh.addEventListener('change', function () { fillRoads(); calc(); track('circle_rate_calc', { mohalla: row().en }); });
    // partials/ga4 already sends whatsapp_click + generate_lead for every wa.me link; only mark the verification intent here
    $('r-verify').addEventListener('click', function () { track('verify_click', { source: 'circle_rate' }); });

    fillRoads(); calc();
})();
</script>
@endpush
