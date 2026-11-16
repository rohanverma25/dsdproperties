@extends('layouts.user-app')

{{--
    LDA lottery results hub (/lda-lottery-result), built 17 Nov 2026.
    LINKS ONLY: every row opens the PDF on ldalucknow.in. We never copy LDA's PDFs to our server (user rule; LDA terms
    clause 5). Data: resources/data/lda-lottery-results.json, made by _deploy/2026-11-17-lda-lottery-hub/build.py, which
    reads LDA's own lottery pages and checks every link. To update: re-run build.py, commit the JSON. No code change.
--}}
@php
    $data = json_decode(file_get_contents(resource_path('data/lda-lottery-results.json')), true);
    $items = $data['items'];
    $checked = \Carbon\Carbon::parse($data['checked'])->format('j M Y');
    $fmt = function ($it) {
        if ($it['date']) return \Carbon\Carbon::parse($it['date'])->format('j M Y');
        if ($it['posted']) return \Carbon\Carbon::createFromFormat('Y-m', $it['posted'])->format('M Y');
        return '';
    };
    $groups = ['plots' => 'Plot schemes', 'flats' => 'Flats & apartments', 'pmay' => 'PMAY affordable flats',
               'pooling' => 'Land pooling (farmers)', 'parking' => 'Parking'];
    $counts = array_count_values(array_column($items, 'group'));
    $latest = array_slice(array_values(array_filter($items, fn ($i) => $i['kind'] === 'result')), 0, 4);
    $nResults = count(array_filter($items, fn ($i) => $i['kind'] !== 'eligibility'));
    $nElig = count($items) - $nResults;
    $guides = [];
    foreach ($items as $i) if ($i['guide'] && !isset($guides[$i['scheme']])) $guides[$i['scheme']] = $i['guide'];
    $pageUrl = url('/lda-lottery-result');
@endphp

@section('title', 'LDA Lottery Result 2026: Varun Vihar, Naimish Nagar, Anant Nagar, IT City & PMAY (Official PDFs)')
@section('meta_description', 'All LDA lottery results and eligibility lists in one place: Varun Vihar, Naimish Nagar, Anant Nagar, IT City and Wellness City land pooling, PMAY, Atal Nagar and LDA apartments. Each link opens the official PDF on ldalucknow.in.')
@section('meta_keywords', 'LDA lottery result, LDA lottery result 2026, Varun Vihar lottery result, Naimish Nagar lottery result, Anant Nagar lottery result, IT City lottery result, LDA eligibility list, PMAY Lucknow lottery result, Atal Nagar lottery result')
@section('canonical', $pageUrl)

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'CollectionPage',
            'name' => 'LDA Lottery Results',
            'url' => $pageUrl,
            'description' => 'Links to official Lucknow Development Authority lottery result and eligibility-list PDFs.',
            'dateModified' => $data['checked'],
            'publisher' => ['@type' => 'Organization', 'name' => 'DSD Properties', 'url' => 'https://dsdproperties.in'],
            'mainEntity' => [
                '@type' => 'ItemList',
                'numberOfItems' => count($items),
                'itemListElement' => array_map(fn ($it, $n) => [
                    '@type' => 'ListItem', 'position' => $n + 1,
                    'item' => ['@type' => 'DigitalDocument', 'name' => $it['scheme'] . ': ' . $it['label'],
                               'url' => $it['url'], 'encodingFormat' => 'application/pdf',
                               'publisher' => ['@type' => 'GovernmentOrganization', 'name' => 'Lucknow Development Authority', 'url' => 'https://ldalucknow.in']],
                ], array_slice($items, 0, 30), array_keys(array_slice($items, 0, 30))),
            ],
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://dsdproperties.in/'],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'LDA Schemes', 'item' => 'https://dsdproperties.in/lda-schemes'],
                ['@type' => 'ListItem', 'position' => 3, 'name' => 'LDA Lottery Results', 'item' => $pageUrl],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<style>
.llr{--n:#011f4b;--t:#008080;--o:#FF5C00;--g:#64748b;--line:#e5e9f0;--soft:#f6f8fb;max-width:1080px;margin:0 auto;padding:28px 16px 56px;color:#1f2937}
.llr h1{font-size:clamp(1.6rem,4vw,2.3rem);font-weight:800;color:var(--n);line-height:1.2;margin:0 0 8px;text-wrap:balance}
.llr h2{font-size:1.25rem;font-weight:800;color:var(--n);margin:34px 0 12px}
.llr .sub{color:var(--g);font-size:15px;line-height:1.7;margin:0 0 14px;max-width:760px}
.llr-trust{display:flex;flex-wrap:wrap;gap:8px;margin:0 0 24px}
.llr-trust span{font-size:12.5px;font-weight:600;color:#334155;background:var(--soft);border:1px solid var(--line);border-radius:999px;padding:5px 11px}
.llr-latest{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,230px),1fr));gap:12px;margin-bottom:8px}
.llr-latest a{display:flex;flex-direction:column;gap:4px;background:#fff;border:1px solid var(--line);border-top:3px solid var(--o);border-radius:14px;padding:14px 16px;text-decoration:none;box-shadow:0 8px 24px rgba(1,31,75,.05)}
.llr-latest a:hover{border-color:var(--t)}
.llr-latest .s{font-weight:800;color:var(--n);font-size:15.5px}
.llr-latest .l{font-size:13.5px;color:#334155}
.llr-latest .d{font-size:12px;color:var(--g)}
.llr-latest .go{font-size:13px;font-weight:700;color:var(--t);margin-top:4px}
.llr-bar{padding:4px 0 12px;border-bottom:1px solid var(--line);display:flex;flex-direction:column;gap:10px}
.llr-chips{display:flex;flex-wrap:wrap;gap:6px}
.llr-chips button{border:1.5px solid var(--line);background:#fff;border-radius:999px;padding:6px 12px;font:inherit;font-size:13px;font-weight:600;color:#334155;cursor:pointer}
.llr-chips button.on{border-color:var(--t);background:#effaf9;color:var(--n)}
.llr-chips button:focus-visible,.llr-search:focus-visible{outline:2px solid var(--t);outline-offset:2px}
.llr-search{width:100%;max-width:420px;padding:10px 14px;border:1.5px solid var(--line);border-radius:11px;background:var(--soft);font:inherit;font-size:15px}
.llr-list{list-style:none;margin:8px 0 0;padding:0}
.llr-row{display:grid;grid-template-columns:110px minmax(0,1fr) auto;gap:14px;align-items:center;padding:13px 4px;border-bottom:1px solid var(--line)}
.llr-row .dt{font-size:13px;color:var(--g);font-variant-numeric:tabular-nums}
.llr-row .sc{font-weight:700;color:var(--n);font-size:15px}
.llr-row .lb{font-size:14px;color:#334155;margin-top:2px}
.llr-row .og{font-size:12px;color:#94a3b8;margin-top:3px;line-height:1.45}
.llr-tag{display:inline-block;font-size:11px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;border-radius:6px;padding:2px 7px;margin-right:6px;vertical-align:1px}
.llr-tag.result{background:#e7f6ec;color:#166534}.llr-tag.waiting{background:#fff4e0;color:#9a5b00}.llr-tag.eligibility{background:#eef2ff;color:#3730a3}
.llr-row a.pdf{white-space:nowrap;font-size:13.5px;font-weight:700;color:#fff;background:var(--t);border-radius:10px;padding:9px 14px;text-decoration:none}
.llr-row a.pdf:hover{background:#006b6b}
.llr-empty{padding:24px 4px;color:var(--g)}
.llr-note{background:var(--soft);border:1px solid var(--line);border-radius:14px;padding:18px 20px;margin-top:28px;font-size:14.5px;line-height:1.75;color:#334155}
.llr-note ol{margin:6px 0 0;padding-left:20px}
.llr-guides{display:flex;flex-wrap:wrap;gap:8px}
.llr-guides a{font-size:13.5px;font-weight:600;color:var(--n);border:1px solid var(--line);border-radius:10px;padding:8px 12px;text-decoration:none;background:#fff}
.llr-guides a:hover{border-color:var(--t);color:var(--t)}
@media(max-width:640px){
  .llr-row{grid-template-columns:minmax(0,1fr);gap:6px}
  .llr-row a.pdf{justify-self:start}
}
</style>
@endpush

@section('content')
<div class="llr">
    <h1>LDA Lottery Results</h1>
    <p class="sub">Every lottery result, waiting list and eligibility list that Lucknow Development Authority has published, in one place. Each link opens the official PDF on <strong>ldalucknow.in</strong>. We link to LDA's files; we don't host or change them.</p>
    <div class="llr-trust">
        <span>{{ count($items) }} official PDFs</span>
        <span>{{ $nResults }} results &amp; waiting lists · {{ $nElig }} eligibility lists</span>
        <span>All links checked {{ $checked }}</span>
    </div>

    <h2>Latest results</h2>
    <div class="llr-latest">
        @foreach($latest as $it)
            <a href="{{ $it['url'] }}" target="_blank" rel="noopener">
                <span class="s">{{ $it['scheme'] }}</span>
                <span class="l">{{ $it['label'] }}</span>
                <span class="d">{{ $fmt($it) }}{{ $it['date'] ? '' : ' (posted)' }}</span>
                <span class="go">Open PDF on ldalucknow.in ↗</span>
            </a>
        @endforeach
    </div>

    <h2 id="all">All results and lists</h2>
    <div class="llr-bar">
        <div class="llr-chips" id="llr-groups" role="group" aria-label="Filter by type of scheme">
            <button type="button" class="on" data-g="">All ({{ count($items) }})</button>
            @foreach($groups as $k => $name)
                @if(!empty($counts[$k]))<button type="button" data-g="{{ $k }}">{{ $name }} ({{ $counts[$k] }})</button>@endif
            @endforeach
        </div>
        <div class="llr-chips" id="llr-kinds" role="group" aria-label="Filter by list type">
            <button type="button" class="on" data-k="">Results and eligibility lists</button>
            <button type="button" data-k="result">Winners &amp; waiting lists only</button>
            <button type="button" data-k="eligibility">Eligibility lists only</button>
        </div>
        <label for="llr-q" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Search scheme</label>
        <input class="llr-search" id="llr-q" type="search" placeholder="Search a scheme, e.g. Naimish, Anant Nagar, 200 sq m" autocomplete="off">
    </div>

    <ul class="llr-list" id="llr-list">
        @foreach($items as $it)
            <li class="llr-row" data-g="{{ $it['group'] }}" data-k="{{ $it['kind'] === 'eligibility' ? 'eligibility' : 'result' }}"
                data-q="{{ strtolower($it['scheme'] . ' ' . $it['label'] . ' ' . ($it['title'] ?? '') . ' ' . $it['file']) }}">
                <div class="dt">{{ $fmt($it) }}@if(!$it['date'])<br><small>posted</small>@endif</div>
                <div>
                    <div class="sc">{{ $it['scheme'] }}</div>
                    <div class="lb"><span class="llr-tag {{ $it['kind'] }}">{{ ['result' => 'Result', 'waiting' => 'Waiting list', 'eligibility' => 'Eligibility'][$it['kind']] }}</span>{{ $it['label'] }}</div>
                    {{-- Only LDA's own wording is shown as "LDA title"; otherwise the PDF's file name --}}
                    <div class="og">@if($it['title'])LDA title: {{ $it['title'] }}@else LDA file: {{ $it['file'] }}@endif</div>
                </div>
                <a class="pdf" href="{{ $it['url'] }}" target="_blank" rel="noopener">Open PDF ↗</a>
            </li>
        @endforeach
    </ul>
    <p class="llr-empty" id="llr-empty" hidden>No list matches. Clear the search or pick another filter.</p>

    <div class="llr-note">
        <strong>How to find your name in an LDA list</strong>
        <ol>
            <li>Open the PDF for your scheme and draw (check the date and plot size or flat type).</li>
            <li>On a computer press <strong>Ctrl + F</strong>; on a phone open the PDF in Chrome, tap ⋮ and choose <strong>Find in page</strong>.</li>
            <li>Search your <strong>registration or application number</strong> rather than your name, because names can be spelled differently in LDA's list.</li>
        </ol>
        <p style="margin:10px 0 0"><strong>Eligibility list</strong> = applicants accepted into the draw. <strong>Result</strong> = applicants who got a plot or flat in the draw. <strong>Waiting list</strong> = applicants next in line if an allotment is cancelled. For allotment letters and payment dates, follow LDA's notices on ldalucknow.in.</p>
    </div>

    @if($guides)
        <h2>Our guides to these schemes</h2>
        <div class="llr-guides">
            @foreach($guides as $scheme => $slug)
                <a href="{{ url($slug) }}">{{ $scheme }} guide →</a>
            @endforeach
            <a href="{{ url('/lda-schemes') }}">All LDA schemes →</a>
            <a href="{{ url('/lda-plot-calculator') }}">LDA plot cost calculator →</a>
        </div>
    @endif

    <p class="sub" style="font-size:13px;margin-top:26px">Source: Lucknow Development Authority, <a href="https://ldalucknow.in/lottery-result/" target="_blank" rel="noopener">ldalucknow.in/lottery-result</a>, <a href="https://ldalucknow.in/lottery-eligibity-list/" target="_blank" rel="noopener">eligibility lists</a>, <a href="https://ldalucknow.in/pmay-lottery-eligibility-list/" target="_blank" rel="noopener">PMAY lists</a> and <a href="https://ldalucknow.in/parking-lottery-result/" target="_blank" rel="noopener">parking results</a>. Dates are the draw or list dates LDA gives; where LDA gives none, the month the PDF was posted. DSD Properties is not connected with LDA.</p>
</div>

@include('components.plot-sale-cta', ['from' => 'lda-lottery-result', 'plain' => true])
@endsection

@push('scripts')
<script>
(function () {
    const rows = [...document.querySelectorAll('#llr-list .llr-row')], empty = document.getElementById('llr-empty');
    let g = '', k = '', q = '';
    function apply() {
        let shown = 0;
        rows.forEach(r => {
            const ok = (!g || r.dataset.g === g) && (!k || r.dataset.k === k) && (!q || q.split(/\s+/).every(w => r.dataset.q.includes(w)));
            r.hidden = !ok; if (ok) shown++;
        });
        empty.hidden = shown > 0;
    }
    function chips(id, set) {
        document.getElementById(id).addEventListener('click', e => {
            const b = e.target.closest('button'); if (!b) return;
            [...e.currentTarget.children].forEach(x => x.classList.toggle('on', x === b));
            set(b); apply();
        });
    }
    chips('llr-groups', b => g = b.dataset.g);
    chips('llr-kinds', b => k = b.dataset.k);
    document.getElementById('llr-q').addEventListener('input', e => { q = e.target.value.trim().toLowerCase(); apply(); });
})();
</script>
@endpush
