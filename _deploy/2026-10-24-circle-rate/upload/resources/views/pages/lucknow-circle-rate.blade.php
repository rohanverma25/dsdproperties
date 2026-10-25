@extends('layouts.user-app')

{{--
    Lucknow circle rate (DM rate list) lookup + minimum-value calculator. Built 24 Oct 2026.
    Data: resources/data/circle-rates/*.json, one file per sub-registrar office (SRO), built by
    _deploy/2026-10-24-circle-rate/build_data.py from the official IGRSUP "मूल्यांकन सूची" PDF.
    Only Sadar Pratham (SRO 227, effective 01-08-2025) is in so far; add the other SROs the same way.
    Every figure is copied from the official list. Do not round or "fix" numbers here; change the TSVs and rebuild.
--}}
@php
    $cr = json_decode(file_get_contents(resource_path('data/circle-rates/lucknow-sadar-pratham.json')), true);
    $rows = $cr['rows'];
    $pdfUrl = asset('downloads/circle-rate/Lucknow-Circle-Rate-Sadar-Pratham-01-08-2025.pdf');
    $sampleUrl = 'https://dsdproperties.in/public/downloads/DSD-Property-Verification-Sample-Report-Lucknow.pdf';
    $faqs = [
        ['What is the circle rate in Lucknow?', 'The circle rate (DM rate) is the minimum value per square metre that the District Magistrate of Lucknow fixes for land, flats and commercial property in each mohalla. Stamp duty is charged on the circle-rate value or the sale price, whichever is higher.'],
        ['When were the current Lucknow circle rates fixed?', 'The rates on this page come from the DM Lucknow valuation list for Sadar Pratham sub-registrar office, effective from 1 August 2025 (order no. 971, dated 01.08.2025).'],
        ['How is the circle rate of a plot calculated?', 'Plot value = plot area in sq m × the rate for your mohalla and road width. Park-facing plots add 10%, plots on two roads use the higher road rate plus 10%, and both together add 20%. Area above 1,000 sq m is valued 30% lower.'],
        ['How is the circle rate of a flat calculated in Lucknow?', 'For flats in buildings of more than three floors: covered area × construction rate (ordinary or premium) + land share. The land share is at least 30% of the covered area, valued at the mohalla plot rate. Floors 4–6 get 5% off, 7th floor and above 10% off.'],
        ['How much is stamp duty in Lucknow?', 'Stamp duty in Uttar Pradesh is 7% of the value. If the buyer is a woman, it is 6% on property worth up to ₹1 crore. The registration fee is 1%.'],
        ['My mohalla is not in the list. Which rate applies?', 'The DM list says that a mohalla or village not in the list takes the rate of the nearest listed one. Other sub-registrar offices (Sadar 2, 3, 4, Mohanlalganj, BKT, Malihabad, Sarojini Nagar) have their own lists; we are adding them one by one.'],
    ];
@endphp

@section('title', 'Lucknow Circle Rate: Mohalla-wise DM Rate List (Sadar Pratham, from 1 Aug 2025)')
@section('meta_description', 'Official Lucknow circle rates for 162 mohallas of Sadar Pratham: plot rate by road width, flat, shop and office rates per sq m, plus a stamp duty calculator. Copied from the DM valuation list effective 01-08-2025.')
@section('meta_keywords', 'Lucknow circle rate, circle rate Lucknow 2025, DM rate Lucknow, Lucknow circle rate list, circle rate Hazratganj, circle rate Alambagh, Charbagh circle rate, Lucknow mulyankan suchi, stamp duty Lucknow')

@push('head')
<link rel="canonical" href="{{ url('/lucknow-circle-rate') }}">
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Dataset',
            'name' => 'Lucknow circle rates (DM valuation list), Sadar Pratham sub-registrar office',
            'description' => 'Minimum property values per square metre for 162 mohallas of Sadar Pratham, Lucknow: plot rates by road width, flat construction rates, commercial carpet rates and main-road segment rates. Effective 1 August 2025.',
            'url' => url('/lucknow-circle-rate'),
            'temporalCoverage' => '2025-08-01/..',
            'spatialCoverage' => ['@type' => 'Place', 'name' => 'Lucknow, Uttar Pradesh, India'],
            'isBasedOn' => 'Office of the District Magistrate, Lucknow: मूल्यांकन सूची, उप निबंधक कार्यालय सदर प्रथम, order no. 971 dated 01.08.2025',
            'creator' => ['@type' => 'Organization', 'name' => 'DSD Properties', 'url' => 'https://dsdproperties.in'],
            'distribution' => [['@type' => 'DataDownload', 'encodingFormat' => 'application/pdf', 'contentUrl' => $pdfUrl]],
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
    <h1>Lucknow Circle Rate: Mohalla-wise DM Rates</h1>
    <p class="sub">Search your mohalla to see the official minimum value per square metre for plots, flats, shops and offices, then calculate the circle-rate value and stamp duty for your property. Every rate below is copied from the District Magistrate's valuation list, without any rounding or changes.</p>

    <div class="lcr-src">
        <span><strong>Area:</strong> Sadar Pratham sub-registrar office (सदर प्रथम), 162 mohallas</span>
        <span><strong>Effective:</strong> 1 August 2025</span>
        <span><strong>Source:</strong> DM Lucknow order no. 971, dated 01.08.2025 · <a href="{{ $pdfUrl }}" target="_blank" rel="noopener">official list (PDF)</a></span>
    </div>

    {{-- Search --}}
    <div class="lcr-box">
        <label class="lcr-label" for="lcr-q">Find your mohalla</label>
        <div class="lcr-search">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            <input id="lcr-q" type="search" autocomplete="off" placeholder="e.g. Alambagh, Charbagh, Park Road, आलमबाग">
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
                    <select id="c-unit"><option value="sqm">sq m</option><option value="sqft">sq ft</option><option value="gaj">gaj (sq yd)</option></select>
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
    <h2 id="all-rates">All 162 mohallas of Sadar Pratham</h2>
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
                    <td>{{ $r['sr'] }}</td><td>{{ $r['en'] }}</td><td>{{ $r['hi'] }}</td><td>{{ $r['ward'] }} {{ $r['ward_name'] }}</td>
                    <td class="r">{{ number_format($r['plot']['lt9']) }}</td><td class="r">{{ number_format($r['plot']['9_12']) }}</td><td class="r">{{ number_format($r['plot']['12_18']) }}</td><td class="r">{{ number_format($r['plot']['gt18']) }}</td>
                    <td class="r">{{ number_format($r['flat']['ordinary']) }}</td><td class="r">{{ number_format($r['flat']['premium']) }}</td>
                    <td class="r">{{ number_format($r['commercial']['shop']) }}</td><td class="r">{{ number_format($r['commercial']['office']) }}</td><td class="r">{{ number_format($r['commercial']['godown']) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

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
<script>
(function () {
    var DATA = @json($cr);
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
    function card(r) {
        var p = r.plot, f = r.flat, c = r.commercial;
        var h = '<div class="lcr-card"><h3>' + esc(r.en) + '</h3><div class="hi">' + esc(r.hi) + '</div>' +
            '<div class="meta">Ward ' + r.ward + ' (' + esc(r.ward_name) + ') · V-code ' + r.vcode + ' · Sadar Pratham</div>' +
            '<table class="lcr-rates">' +
            '<tr class="h"><td colspan="2">Residential plot, ₹/sq m</td></tr>' +
            '<tr><td>Road under 9 m</td><td>₹' + inr(p.lt9) + ' ' + perSqft(p.lt9) + '</td></tr>' +
            '<tr><td>Road 9–12 m</td><td>₹' + inr(p['9_12']) + ' ' + perSqft(p['9_12']) + '</td></tr>' +
            '<tr><td>Road 12–18 m</td><td>₹' + inr(p['12_18']) + ' ' + perSqft(p['12_18']) + '</td></tr>' +
            '<tr><td>Road above 18 m</td><td>₹' + inr(p.gt18) + ' ' + perSqft(p.gt18) + '</td></tr>' +
            '<tr class="h"><td colspan="2">Flat construction rate, ₹/sq m</td></tr>' +
            '<tr><td>Ordinary</td><td>₹' + inr(f.ordinary) + '</td></tr>' +
            '<tr><td>Premium</td><td>₹' + inr(f.premium) + '</td></tr>' +
            '<tr class="h"><td colspan="2">Commercial carpet area, ₹/sq m</td></tr>' +
            '<tr><td>Shop · Office · Godown</td><td>₹' + inr(c.shop) + ' · ' + inr(c.office) + ' · ' + inr(c.godown) + '</td></tr>' +
            '</table>';
        r.roads.forEach(function (rd) {
            h += '<div class="lcr-road"><strong>On ' + esc(rd.segment_en) + '</strong> (' + esc(rd.segment) + '): plot ₹' + inr(rd.plot) + '/sq m · shop ₹' + inr(rd.shop) + ' · office ₹' + inr(rd.office) + ' · godown ₹' + inr(rd.godown) + '</div>';
        });
        if (r.note) h += '<div class="lcr-note">' + esc(r.note) + '</div>';
        h += '<button type="button" data-sr="' + r.sr + '">Calculate for this mohalla</button></div>';
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
            if (r.roads.some(function (x) { return norm(x.segment).indexOf(s) > -1 || norm(x.segment_en).indexOf(s) > -1; })) return 1;
            return 0;
        }
        var hits = ROWS.map(function (r) { return [score(r), r]; }).filter(function (x) { return x[0]; })
            .sort(function (a, b) { return b[0] - a[0] || a[1].sr - b[1].sr; }).map(function (x) { return x[1]; });
        out.innerHTML = hits.length ? hits.slice(0, 24).map(card).join('') :
            '<div class="lcr-empty">No mohalla called "' + esc(q.value) + '" in the Sadar Pratham list. Under the DM list, a mohalla that is not listed takes the rate of the nearest listed one. If your area falls under another sub-registrar office (Sadar 2, 3, 4, Mohanlalganj, BKT, Malihabad, Sarojini Nagar), we are adding those lists next. <a href="https://wa.me/918595002933?text=' + encodeURIComponent('Hi, what is the circle rate for ' + q.value + ', Lucknow?') + '" target="_blank" rel="noopener">Ask us on WhatsApp</a>.</div>';
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
        var o = document.createElement('option'); o.value = r.sr; o.textContent = r.en + ' · ' + r.hi; moh.appendChild(o);
    });
    moh.value = ROWS.filter(function (r) { return r.en === 'Alambagh'; })[0].sr;

    function row() { return ROWS[moh.value - 1]; }
    function fillRoads() {
        var r = row(), prev = road.value;
        var opts = [['lt9', 'Under 9 m wide'], ['9_12', '9 to 12 m'], ['12_18', '12 to 18 m'], ['gt18', 'Above 18 m']];
        road.innerHTML = opts.map(function (o) { return '<option value="' + o[0] + '">' + o[1] + ' (₹' + inr(r.plot[o[0]]) + '/sq m)</option>'; }).join('') +
            r.roads.map(function (x, i) { return '<option value="seg' + i + '">On main road: ' + esc(x.segment_en) + ' (₹' + inr(x.plot) + '/sq m)</option>'; }).join('');
        if ([].some.call(road.options, function (o) { return o.value === prev; })) road.value = prev;
    }
    function landRate() {
        var r = row(), v = road.value;
        return v.indexOf('seg') === 0 ? r.roads[+v.slice(3)].plot : r.plot[v];
    }
    function toSqm(v) { var u = $('c-unit').value; return u === 'sqft' ? v / SQFT : u === 'gaj' ? v * GAJ : v; }
    function sqmTxt(v) { return (Math.round(v * 100) / 100).toLocaleString('en-IN') + ' sq m'; }
    function bump() {
        var p = $('c-park').checked, c = $('c-corner').checked;
        return p && c ? 0.20 : (p || c) ? 0.10 : 0;
    }
    // Rule 17: plot rate applies up to 1,000 sq m; the area above that at 30% less
    function landValue(area, rate) {
        return area <= 1000 ? area * rate : 1000 * rate + (area - 1000) * rate * 0.7;
    }

    function calc() {
        var r = row(), type = pick('c-type'), area = toSqm(parseFloat($('c-area').value) || 0);
        var rate = landRate(), lines = [], how = '', value = 0;
        $('g-flat').hidden = type !== 'flat'; $('g-house').hidden = type !== 'house'; $('g-shop').hidden = type !== 'shop';
        $('g-extra').hidden = !(type === 'plot' || type === 'house');
        $('c-area-l').textContent = { plot: 'Plot area', flat: 'Covered area of the flat', house: 'Plot (land) area', shop: 'Carpet area' }[type];

        if (type === 'plot') {
            var b = bump(), lv = landValue(area, rate);
            value = lv * (1 + b);
            lines.push(['Land: ' + sqmTxt(area) + ' × ₹' + inr(rate), money(lv)]);
            if (area > 1000) how = 'Area above 1,000 sq m is valued at 30% less. ';
            if (b) lines.push(['Park facing / more than one road (+' + b * 100 + '%)', money(lv * b)]);
        } else if (type === 'flat') {
            var cat = pick('c-fcat'), crate = r.flat[cat], fl = $('c-floor').value;
            var cv = area * crate, share = area * 0.30, lv2 = share * rate;
            var reb = fl === '5' ? 0.05 : fl === '10' ? 0.10 : 0;
            value = (cv + lv2) * (1 - reb);
            lines.push(['Construction: ' + sqmTxt(area) + ' × ₹' + inr(crate) + ' (' + cat + ')', money(cv)]);
            lines.push(['Land share: 30% = ' + sqmTxt(share) + ' × ₹' + inr(rate), money(lv2)]);
            if (reb) lines.push(['Floor rebate (−' + reb * 100 + '%)', '−' + money((cv + lv2) * reb)]);
            how = 'Land share is taken at the minimum 30% of covered area; if the deed gives a larger undivided share, the value is higher. ';
        } else if (type === 'house') {
            var b2 = bump(), lv3 = landValue(area, rate) * (1 + b2);
            var built = toSqm(parseFloat($('c-built').value) || 0), ct = DATA.construction_3floor[$('c-ctype').value];
            var crate2 = ct[+pick('c-class')], life = ct[2], age = Math.max(0, parseInt($('c-age').value, 10) || 0);
            var cv2 = built * crate2, dep = 0;
            if (age > 20) dep = Math.min(cv2 * age * 9 / (life * 10), cv2 * 0.70);
            value = lv3 + cv2 - dep;
            lines.push(['Land: ' + sqmTxt(area) + ' × ₹' + inr(rate) + (b2 ? ' (+' + b2 * 100 + '%)' : ''), money(lv3)]);
            lines.push(['Building: ' + sqmTxt(built) + ' × ₹' + inr(crate2), money(cv2)]);
            if (dep) lines.push(['Depreciation (' + age + ' of ' + life + ' years)', '−' + money(dep)]);
            how = age > 20 ? '' : 'No depreciation for the first 20 years. ';
        } else {
            var use = pick('c-use'), v = road.value, seg = v.indexOf('seg') === 0;
            var srate = seg ? r.roads[+v.slice(3)][use] : r.commercial[use];
            var ac = $('c-ac').checked, fpct = ac ? 100 : +$('c-sfloor').value;
            var base = area * srate;
            value = base * fpct / 100 * (ac ? 1.2 : 1);
            lines.push(['Carpet: ' + sqmTxt(area) + ' × ₹' + inr(srate) + ' (' + use + (seg ? ', main road' : '') + ')', money(base)]);
            if (fpct !== 100) lines.push(['Floor (' + fpct + '%)', '−' + money(base * (100 - fpct) / 100)]);
            if (ac) lines.push(['AC / shopping complex (+20%)', money(base * 0.2)]);
        }

        var deal = parseFloat($('c-deal').value) || 0, basis = Math.max(value, deal);
        var woman = pick('c-buyer') === 'f', sdRate = woman && basis <= 1e7 ? 0.06 : 0.07;
        var sd = Math.round(basis * sdRate), reg = Math.round(basis * 0.01);

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
    [$('r-verify'), $('r-wa')].forEach(function (a) { a.addEventListener('click', function () { track(a.id === 'r-verify' ? 'verify_click' : 'whatsapp_click', { source: 'circle_rate' }); }); });

    fillRoads(); calc();
})();
</script>
@endpush
