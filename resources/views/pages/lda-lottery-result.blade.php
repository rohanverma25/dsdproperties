@extends('layouts.user-app')

{{--
    LDA lottery results hub (/lda-lottery-result), built 17 Nov 2026; card UI with Tailwind the same day.
    LINKS ONLY: every card opens the PDF on ldalucknow.in. We never copy LDA's PDFs to our server (user rule; LDA terms
    clause 5). Data: resources/data/lda-lottery-results.json, made by _deploy/2026-11-17-lda-lottery-hub/build.py, which
    reads LDA's own lottery pages and checks every link. To update: re-run build.py, commit the JSON. No code change.

    Styling: Tailwind classes with the tw- prefix, compiled to public/css/lda-lottery.css (config and rebuild command in
    resources/css/lda-lottery/tailwind.config.js). Rebuild the CSS after adding new classes here. Classes are written out
    in full (never built from string pieces) so Tailwind can find them.
--}}
@php
    $data = json_decode(file_get_contents(resource_path('data/lda-lottery-results.json')), true);
    $items = $data['items'];
    $checkedAt = \Carbon\Carbon::parse($data['checked']);
    $checked = $checkedAt->format('j M Y');
    $fmt = function ($it) {
        if ($it['date']) return \Carbon\Carbon::parse($it['date'])->format('j M Y');
        if ($it['posted']) return \Carbon\Carbon::createFromFormat('Y-m', $it['posted'])->format('M Y');
        return '';
    };
    // "New" = drawn or posted within 14 days of the last link check (month-only "posted" dates count as the 15th)
    $isNew = function ($it) use ($checkedAt) {
        $d = $it['date'] ? \Carbon\Carbon::parse($it['date']) : ($it['posted'] ? \Carbon\Carbon::createFromFormat('Y-m-d', $it['posted'] . '-15') : null);
        return $d && $d->diffInDays($checkedAt, false) <= 14 && $d->lte($checkedAt->copy()->endOfDay());
    };
    $groups = ['plots' => 'Plot schemes', 'flats' => 'Flats & apartments', 'pmay' => 'PMAY affordable flats',
               'pooling' => 'Land pooling (farmers)', 'parking' => 'Parking'];
    $groupStyle = [
        'plots'   => 'tw-border-l-brand-teal',
        'flats'   => 'tw-border-l-indigo-500',
        'pmay'    => 'tw-border-l-amber-500',
        'pooling' => 'tw-border-l-emerald-500',
        'parking' => 'tw-border-l-slate-400',
        'other'   => 'tw-border-l-slate-300',
    ];
    $kindStyle = [
        'result'      => ['Result', 'tw-bg-emerald-50 tw-text-emerald-700 tw-ring-emerald-200'],
        'waiting'     => ['Waiting list', 'tw-bg-amber-50 tw-text-amber-800 tw-ring-amber-200'],
        'eligibility' => ['Eligibility', 'tw-bg-indigo-50 tw-text-indigo-700 tw-ring-indigo-200'],
    ];
    $counts = array_count_values(array_column($items, 'group'));
    $latest = array_slice(array_values(array_filter($items, fn ($i) => $i['kind'] === 'result')), 0, 4);
    $nResults = count(array_filter($items, fn ($i) => $i['kind'] !== 'eligibility'));
    $nElig = count($items) - $nResults;
    $guides = [];
    foreach ($items as $i) if ($i['guide'] && !isset($guides[$i['scheme']])) $guides[$i['scheme']] = $i['guide'];
    // label "Eligibility list · Phase 1 · Day 3 · 288 & 450 sq m Plots" → chips after the first part
    $chips = fn ($it) => array_slice(explode(' · ', $it['label']), 1);
    $listName = fn ($it) => explode(' · ', $it['label'])[0];
    $pageUrl = url('/lda-lottery-result');
    $css = 'css/lda-lottery.css';
@endphp

@section('title', 'LDA Lottery Result 2026: Varun Vihar, Naimish Nagar, Anant Nagar, IT City & PMAY (Official PDFs)')
@section('meta_description', 'All LDA lottery results and eligibility lists in one place: Varun Vihar, Naimish Nagar, Anant Nagar, IT City and Wellness City land pooling, PMAY, Atal Nagar and LDA apartments. Each link opens the official PDF on ldalucknow.in.')
@section('meta_keywords', 'LDA lottery result, LDA lottery result 2026, Varun Vihar lottery result, Naimish Nagar lottery result, Anant Nagar lottery result, IT City lottery result, LDA eligibility list, PMAY Lucknow lottery result, Atal Nagar lottery result')
@section('canonical', $pageUrl)

@push('head')
<link rel="stylesheet" href="{{ asset($css) }}?v={{ @filemtime(public_path($css)) }}">
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
/* What Tailwind utilities can't say on their own: focus ring for chips, hidden cards, reduced motion */
#llr .llr-chip[aria-pressed="true"]{background:#011f4b;color:#fff;border-color:#011f4b}
#llr .llr-chip:focus-visible,#llr .llr-card:focus-within{outline:2px solid #008080;outline-offset:2px}
#llr [hidden]{display:none!important}
#llr button,#llr input{font-family:inherit}
@media (prefers-reduced-motion:reduce){#llr *{transition:none!important;transform:none!important}}
</style>
@endpush

@section('content')
{{-- #llr scopes the compiled CSS (it styles elements inside #llr), so the page's own classes sit on the inner div --}}
<div id="llr"><div class="tw-font-sans tw-text-slate-700">

    {{-- ── Hero ─────────────────────────────────────────────── --}}
    <section class="tw-bg-gradient-to-b tw-from-slate-50 tw-to-white tw-border-b tw-border-slate-100">
        <div class="tw-max-w-6xl tw-mx-auto tw-px-4 tw-pt-8 tw-pb-10 sm:tw-pt-12">
            <nav class="tw-text-xs tw-text-slate-500 tw-mb-4" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="tw-text-slate-500 hover:tw-text-brand-teal tw-no-underline">Home</a>
                <span class="tw-mx-1.5">/</span>
                <a href="{{ url('/lda-schemes') }}" class="tw-text-slate-500 hover:tw-text-brand-teal tw-no-underline">LDA Schemes</a>
                <span class="tw-mx-1.5">/</span><span class="tw-text-slate-700">Lottery results</span>
            </nav>
            <h1 class="tw-text-3xl sm:tw-text-4xl tw-font-extrabold tw-text-navy tw-leading-tight tw-m-0 tw-mb-3">LDA Lottery Results</h1>
            <p class="tw-max-w-3xl tw-text-base tw-leading-relaxed tw-text-slate-600 tw-m-0 tw-mb-5">
                Every lottery result, waiting list and eligibility list that Lucknow Development Authority has published, in one place.
                Each card opens the official PDF on <strong class="tw-text-navy">ldalucknow.in</strong>. We link to LDA's files; we don't host or change them.
            </p>
            <div class="tw-flex tw-flex-wrap tw-gap-2">
                <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-rounded-full tw-bg-white tw-ring-1 tw-ring-slate-200 tw-px-3 tw-py-1.5 tw-text-xs tw-font-semibold tw-text-slate-700">
                    <span class="tw-h-2 tw-w-2 tw-rounded-full tw-bg-brand-teal"></span>{{ count($items) }} official PDFs
                </span>
                <span class="tw-inline-flex tw-items-center tw-rounded-full tw-bg-white tw-ring-1 tw-ring-slate-200 tw-px-3 tw-py-1.5 tw-text-xs tw-font-semibold tw-text-slate-700">{{ $nResults }} results &amp; waiting lists · {{ $nElig }} eligibility lists</span>
                <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-rounded-full tw-bg-emerald-50 tw-ring-1 tw-ring-emerald-200 tw-px-3 tw-py-1.5 tw-text-xs tw-font-semibold tw-text-emerald-700">
                    ✓ All links checked {{ $checked }}
                </span>
            </div>
        </div>
    </section>

    <div class="tw-max-w-6xl tw-mx-auto tw-px-4 tw-pb-14">

        {{-- ── Latest results ──────────────────────────────────── --}}
        <h2 class="tw-text-xl tw-font-extrabold tw-text-navy tw-mt-8 tw-mb-4">Latest results</h2>
        <div class="tw-grid tw-gap-4 sm:tw-grid-cols-2 lg:tw-grid-cols-4">
            @foreach($latest as $it)
                <a href="{{ $it['url'] }}" target="_blank" rel="noopener"
                   class="tw-group tw-relative tw-flex tw-flex-col tw-gap-2 tw-rounded-2xl tw-bg-navy tw-p-5 tw-text-white tw-no-underline tw-shadow-lg tw-shadow-slate-900/10 tw-transition hover:-tw-translate-y-1 hover:tw-shadow-xl">
                    <span class="tw-absolute tw-inset-x-0 tw-top-0 tw-h-1 tw-rounded-t-2xl tw-bg-brand-orange"></span>
                    <span class="tw-flex tw-items-center tw-justify-between tw-gap-2">
                        <span class="tw-rounded-md tw-bg-white/10 tw-px-2 tw-py-0.5 tw-text-[11px] tw-font-bold tw-uppercase tw-tracking-wider tw-text-emerald-300">Result</span>
                        @if($isNew($it))<span class="tw-rounded-full tw-bg-brand-orange tw-px-2 tw-py-0.5 tw-text-[11px] tw-font-bold tw-text-white">New</span>@endif
                    </span>
                    <span class="tw-text-lg tw-font-bold tw-leading-snug">{{ $it['scheme'] }}</span>
                    <span class="tw-text-sm tw-text-slate-300">{{ $it['label'] }}</span>
                    <span class="tw-text-xs tw-text-slate-400">{{ $fmt($it) }}{{ $it['date'] ? '' : ' · posted' }}</span>
                    <span class="tw-mt-auto tw-pt-2 tw-text-sm tw-font-semibold tw-text-emerald-300 group-hover:tw-text-white">Open PDF on ldalucknow.in ↗</span>
                </a>
            @endforeach
        </div>

        {{-- ── Filters ─────────────────────────────────────────── --}}
        <h2 id="all" class="tw-text-xl tw-font-extrabold tw-text-navy tw-mt-12 tw-mb-4">All results and lists</h2>
        <div class="tw-rounded-2xl tw-bg-white tw-ring-1 tw-ring-slate-200 tw-p-4 sm:tw-p-5 tw-shadow-sm tw-flex tw-flex-col tw-gap-4">
            <div class="tw-relative">
                <label for="llr-q" class="tw-sr-only">Search scheme, size or day</label>
                <span class="tw-pointer-events-none tw-absolute tw-left-3.5 tw-top-1/2 -tw-translate-y-1/2 tw-text-slate-400">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                </span>
                <input id="llr-q" type="search" autocomplete="off" placeholder="Search a scheme, size or day, e.g. Naimish 200 sq m"
                       class="tw-w-full tw-rounded-xl tw-border tw-border-solid tw-border-slate-200 tw-bg-slate-50 tw-py-3 tw-pl-10 tw-pr-4 tw-text-[15px] tw-text-navy tw-outline-none focus:tw-border-brand-teal focus:tw-bg-white focus:tw-ring-2 focus:tw-ring-brand-teal/20">
            </div>
            <div>
                <p class="tw-m-0 tw-mb-2 tw-text-[11px] tw-font-bold tw-uppercase tw-tracking-wider tw-text-slate-400">Scheme type</p>
                <div class="tw-flex tw-flex-wrap tw-gap-2" id="llr-groups">
                    <button type="button" data-g="" aria-pressed="true" class="llr-chip tw-cursor-pointer tw-rounded-full tw-border tw-border-solid tw-border-slate-200 tw-bg-white tw-px-3.5 tw-py-1.5 tw-text-[13px] tw-font-semibold tw-text-slate-600 tw-transition hover:tw-border-navy">All <span class="tw-opacity-60">{{ count($items) }}</span></button>
                    @foreach($groups as $k => $name)
                        @if(!empty($counts[$k]))
                            <button type="button" data-g="{{ $k }}" aria-pressed="false" class="llr-chip tw-cursor-pointer tw-rounded-full tw-border tw-border-solid tw-border-slate-200 tw-bg-white tw-px-3.5 tw-py-1.5 tw-text-[13px] tw-font-semibold tw-text-slate-600 tw-transition hover:tw-border-navy">{{ $name }} <span class="tw-opacity-60">{{ $counts[$k] }}</span></button>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="tw-flex tw-flex-wrap tw-items-end tw-justify-between tw-gap-3">
                <div>
                    <p class="tw-m-0 tw-mb-2 tw-text-[11px] tw-font-bold tw-uppercase tw-tracking-wider tw-text-slate-400">List type</p>
                    <div class="tw-inline-flex tw-flex-wrap tw-gap-2" id="llr-kinds">
                        <button type="button" data-k="" aria-pressed="true" class="llr-chip tw-cursor-pointer tw-rounded-full tw-border tw-border-solid tw-border-slate-200 tw-bg-white tw-px-3.5 tw-py-1.5 tw-text-[13px] tw-font-semibold tw-text-slate-600 tw-transition hover:tw-border-navy">Everything</button>
                        <button type="button" data-k="result" aria-pressed="false" class="llr-chip tw-cursor-pointer tw-rounded-full tw-border tw-border-solid tw-border-slate-200 tw-bg-white tw-px-3.5 tw-py-1.5 tw-text-[13px] tw-font-semibold tw-text-slate-600 tw-transition hover:tw-border-navy">Winners &amp; waiting lists</button>
                        <button type="button" data-k="eligibility" aria-pressed="false" class="llr-chip tw-cursor-pointer tw-rounded-full tw-border tw-border-solid tw-border-slate-200 tw-bg-white tw-px-3.5 tw-py-1.5 tw-text-[13px] tw-font-semibold tw-text-slate-600 tw-transition hover:tw-border-navy">Eligibility lists</button>
                    </div>
                </div>
                <p class="tw-m-0 tw-text-sm tw-text-slate-500" aria-live="polite">Showing <strong id="llr-count" class="tw-text-navy">{{ count($items) }}</strong> of {{ count($items) }}</p>
            </div>
        </div>

        {{-- ── Cards ───────────────────────────────────────────── --}}
        <ul id="llr-list" class="tw-list-none tw-m-0 tw-mt-6 tw-p-0 tw-grid tw-gap-4 md:tw-grid-cols-2 lg:tw-grid-cols-3">
            @foreach($items as $it)
                @php [$kLabel, $kClass] = $kindStyle[$it['kind']]; @endphp
                <li class="llr-card tw-group tw-flex tw-flex-col tw-rounded-2xl tw-border tw-border-solid tw-border-slate-200 tw-border-l-4 {{ $groupStyle[$it['group']] ?? $groupStyle['other'] }} tw-bg-white tw-p-5 tw-shadow-sm tw-transition hover:-tw-translate-y-0.5 hover:tw-shadow-lg"
                    data-g="{{ $it['group'] }}" data-k="{{ $it['kind'] === 'eligibility' ? 'eligibility' : 'result' }}"
                    data-q="{{ strtolower($it['scheme'] . ' ' . $it['label'] . ' ' . ($it['title'] ?? '') . ' ' . $it['file']) }}">
                    <div class="tw-flex tw-items-center tw-justify-between tw-gap-2">
                        <span class="tw-inline-flex tw-items-center tw-rounded-md tw-px-2 tw-py-0.5 tw-text-[11px] tw-font-bold tw-uppercase tw-tracking-wider tw-ring-1 tw-ring-inset {{ $kClass }}">{{ $kLabel }}</span>
                        <span class="tw-flex tw-items-center tw-gap-2 tw-text-xs tw-text-slate-500 tw-tabular-nums">
                            @if($isNew($it))<span class="tw-rounded-full tw-bg-brand-orange tw-px-2 tw-py-0.5 tw-text-[11px] tw-font-bold tw-text-white">New</span>@endif
                            {{ $fmt($it) }}@if(!$it['date'])<span class="tw-text-slate-400">· posted</span>@endif
                        </span>
                    </div>

                    <h3 class="tw-m-0 tw-mt-3 tw-text-[17px] tw-font-bold tw-leading-snug tw-text-navy">{{ $it['scheme'] }}</h3>
                    <p class="tw-m-0 tw-mt-0.5 tw-text-sm tw-font-medium tw-text-slate-600">{{ $listName($it) }}</p>

                    @if($chips($it))
                        <div class="tw-mt-3 tw-flex tw-flex-wrap tw-gap-1.5">
                            @foreach($chips($it) as $c)
                                <span class="tw-rounded-lg tw-bg-slate-100 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-slate-700">{{ $c }}</span>
                            @endforeach
                        </div>
                    @endif

                    <details class="tw-mt-3 tw-text-xs tw-text-slate-500">
                        <summary class="tw-cursor-pointer tw-select-none tw-font-medium tw-text-slate-500 hover:tw-text-brand-teal">{{ $it['title'] ? "LDA's description" : 'File name' }}</summary>
                        <p class="tw-m-0 tw-mt-1.5 tw-leading-relaxed">{{ $it['title'] ?? $it['file'] }}</p>
                    </details>

                    <div class="tw-mt-auto tw-flex tw-items-center tw-gap-2 tw-pt-4">
                        <a href="{{ $it['url'] }}" target="_blank" rel="noopener"
                           class="tw-inline-flex tw-flex-1 tw-items-center tw-justify-center tw-gap-1.5 tw-rounded-xl tw-bg-brand-teal tw-px-4 tw-py-2.5 tw-text-sm tw-font-bold tw-text-white tw-no-underline tw-transition hover:tw-bg-brand-tealdark">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3h7v7"/><path d="M10 14 21 3"/><path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5"/></svg>
                            Open PDF
                        </a>
                        <button type="button" data-copy="{{ $it['url'] }}" title="Copy link to this PDF"
                                class="llr-copy tw-inline-flex tw-cursor-pointer tw-items-center tw-justify-center tw-rounded-xl tw-border tw-border-solid tw-border-slate-200 tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-slate-600 tw-transition hover:tw-border-brand-teal hover:tw-text-brand-teal">
                            Copy link
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
        <div id="llr-empty" hidden class="tw-mt-6 tw-rounded-2xl tw-border tw-border-dashed tw-border-slate-300 tw-p-8 tw-text-center tw-text-slate-500">
            No list matches. <button type="button" id="llr-reset" class="tw-cursor-pointer tw-border-0 tw-bg-transparent tw-p-0 tw-font-semibold tw-text-brand-teal tw-underline">Clear filters</button>
        </div>

        {{-- ── How to find your name ───────────────────────────── --}}
        <div class="tw-mt-12 tw-grid tw-gap-4 lg:tw-grid-cols-3">
            <div class="tw-rounded-2xl tw-bg-slate-50 tw-ring-1 tw-ring-slate-200 tw-p-6 lg:tw-col-span-2">
                <h2 class="tw-m-0 tw-mb-4 tw-text-lg tw-font-extrabold tw-text-navy">How to find your name in an LDA list</h2>
                <ol class="tw-m-0 tw-grid tw-gap-3 tw-p-0 tw-list-none">
                    <li class="tw-flex tw-gap-3"><span class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-navy tw-text-sm tw-font-bold tw-text-white">1</span><span class="tw-text-[15px] tw-leading-relaxed">Open the PDF for your scheme and draw. Check the date and the plot size or flat type.</span></li>
                    <li class="tw-flex tw-gap-3"><span class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-navy tw-text-sm tw-font-bold tw-text-white">2</span><span class="tw-text-[15px] tw-leading-relaxed">On a computer press <kbd class="tw-rounded tw-bg-white tw-px-1.5 tw-py-0.5 tw-text-xs tw-ring-1 tw-ring-slate-300">Ctrl</kbd> + <kbd class="tw-rounded tw-bg-white tw-px-1.5 tw-py-0.5 tw-text-xs tw-ring-1 tw-ring-slate-300">F</kbd>. On a phone, open the PDF in Chrome, tap ⋮ and choose <strong>Find in page</strong>.</span></li>
                    <li class="tw-flex tw-gap-3"><span class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-navy tw-text-sm tw-font-bold tw-text-white">3</span><span class="tw-text-[15px] tw-leading-relaxed">Search your <strong>registration or application number</strong>, not your name. Names can be spelled differently in LDA's list.</span></li>
                </ol>
            </div>
            <div class="tw-rounded-2xl tw-bg-white tw-ring-1 tw-ring-slate-200 tw-p-6">
                <h2 class="tw-m-0 tw-mb-4 tw-text-lg tw-font-extrabold tw-text-navy">What the lists mean</h2>
                <dl class="tw-m-0 tw-grid tw-gap-3 tw-text-sm tw-leading-relaxed">
                    <div><dt class="tw-font-bold tw-text-indigo-700">Eligibility list</dt><dd class="tw-m-0">Applicants accepted into the draw.</dd></div>
                    <div><dt class="tw-font-bold tw-text-emerald-700">Result</dt><dd class="tw-m-0">Applicants who got a plot or flat in the draw.</dd></div>
                    <div><dt class="tw-font-bold tw-text-amber-800">Waiting list</dt><dd class="tw-m-0">Next in line if an allotment is cancelled.</dd></div>
                </dl>
                <p class="tw-m-0 tw-mt-4 tw-text-xs tw-text-slate-500">For allotment letters and payment dates, follow LDA's notices on ldalucknow.in.</p>
            </div>
        </div>

        {{-- ── Guides ──────────────────────────────────────────── --}}
        @if($guides)
            <h2 class="tw-text-xl tw-font-extrabold tw-text-navy tw-mt-12 tw-mb-4">Our guides to these schemes</h2>
            <div class="tw-flex tw-flex-wrap tw-gap-2">
                @foreach($guides as $scheme => $slug)
                    <a href="{{ url($slug) }}" class="tw-rounded-xl tw-bg-white tw-ring-1 tw-ring-slate-200 tw-px-3.5 tw-py-2 tw-text-sm tw-font-semibold tw-text-navy tw-no-underline tw-transition hover:tw-ring-brand-teal hover:tw-text-brand-teal">{{ $scheme }} guide →</a>
                @endforeach
                <a href="{{ url('/lda-schemes') }}" class="tw-rounded-xl tw-bg-white tw-ring-1 tw-ring-slate-200 tw-px-3.5 tw-py-2 tw-text-sm tw-font-semibold tw-text-navy tw-no-underline tw-transition hover:tw-ring-brand-teal hover:tw-text-brand-teal">All LDA schemes →</a>
                <a href="{{ url('/lda-plot-calculator') }}" class="tw-rounded-xl tw-bg-white tw-ring-1 tw-ring-slate-200 tw-px-3.5 tw-py-2 tw-text-sm tw-font-semibold tw-text-navy tw-no-underline tw-transition hover:tw-ring-brand-teal hover:tw-text-brand-teal">LDA plot cost calculator →</a>
            </div>
        @endif

        <p class="tw-m-0 tw-mt-10 tw-text-xs tw-leading-relaxed tw-text-slate-500">
            Source: Lucknow Development Authority,
            <a href="https://ldalucknow.in/lottery-result/" target="_blank" rel="noopener" class="tw-text-brand-teal">ldalucknow.in/lottery-result</a>,
            <a href="https://ldalucknow.in/lottery-eligibity-list/" target="_blank" rel="noopener" class="tw-text-brand-teal">eligibility lists</a>,
            <a href="https://ldalucknow.in/pmay-lottery-eligibility-list/" target="_blank" rel="noopener" class="tw-text-brand-teal">PMAY lists</a> and
            <a href="https://ldalucknow.in/parking-lottery-result/" target="_blank" rel="noopener" class="tw-text-brand-teal">parking results</a>.
            Dates are the draw or list dates LDA gives; where LDA gives none, the month the PDF was posted. DSD Properties is not connected with LDA.
        </p>
    </div>
</div></div>

@include('components.plot-sale-cta', ['from' => 'lda-lottery-result', 'plain' => true])
@endsection

@push('scripts')
<script>
(function () {
    const root = document.getElementById('llr');
    const cards = [...root.querySelectorAll('#llr-list .llr-card')];
    const empty = document.getElementById('llr-empty'), count = document.getElementById('llr-count'), q = document.getElementById('llr-q');
    let g = '', k = '', words = [];
    function apply() {
        let shown = 0;
        cards.forEach(c => {
            const ok = (!g || c.dataset.g === g) && (!k || c.dataset.k === k) && words.every(w => c.dataset.q.includes(w));
            c.hidden = !ok; if (ok) shown++;
        });
        count.textContent = shown; empty.hidden = shown > 0;
    }
    function chips(id, set) {
        document.getElementById(id).addEventListener('click', e => {
            const b = e.target.closest('button'); if (!b) return;
            [...e.currentTarget.querySelectorAll('button')].forEach(x => x.setAttribute('aria-pressed', x === b ? 'true' : 'false'));
            set(b); apply();
        });
    }
    chips('llr-groups', b => g = b.dataset.g);
    chips('llr-kinds', b => k = b.dataset.k);
    q.addEventListener('input', () => { words = q.value.trim().toLowerCase().split(/\s+/).filter(Boolean); apply(); });
    document.getElementById('llr-reset').addEventListener('click', () => {
        g = k = ''; words = []; q.value = '';
        root.querySelectorAll('#llr-groups button, #llr-kinds button').forEach(b => b.setAttribute('aria-pressed', b.dataset.g === '' || b.dataset.k === '' ? 'true' : 'false'));
        apply();
    });
    root.addEventListener('click', e => {
        const b = e.target.closest('.llr-copy'); if (!b) return;
        const done = () => { const t = b.textContent; b.textContent = 'Copied ✓'; setTimeout(() => b.textContent = t, 1600); };
        if (navigator.clipboard) navigator.clipboard.writeText(b.dataset.copy).then(done).catch(() => window.prompt('Copy this link:', b.dataset.copy));
        else window.prompt('Copy this link:', b.dataset.copy);
    });
})();
</script>
@endpush
