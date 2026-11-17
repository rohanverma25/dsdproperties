@extends('layouts.user-app')

{{--
    Author + editorial policy page (/author/dheer-singh), 18 Nov 2026. Every blog post and news story links here as the
    byline (blogs/show, news/show). Facts about the author come only from config/author.php. The "How we research"
    list describes how the site already works (see memory: research-firm content standard); change it only if the
    process changes. Data: $posts, $news from the route in routes/web.php.
--}}
@php
    $a = config('author');
    $pageUrl = url('/author/' . $a['slug']);
@endphp

@section('title', $a['name'] . ': Author, DSD Properties Lucknow | How We Research')
@section('meta_description', $a['name'] . ' writes the LDA, Awas Vikas and UP RERA guides and news on DSD Properties from official orders, notices, layout plans and lottery lists. Read how we research, check and correct our articles.')
@section('canonical', $pageUrl)

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'ProfilePage',
            'url' => $pageUrl,
            'name' => $a['name'] . ', DSD Properties',
            'dateModified' => optional($posts->max('updated_at'))->toIso8601String(),
            'mainEntity' => ['@id' => $pageUrl . '#person'],
        ],
        [
            '@type' => 'Person',
            '@id' => $pageUrl . '#person',
            'name' => $a['name'],
            'url' => $pageUrl,
            'jobTitle' => $a['job_title'],
            'description' => $a['bio'],
            'alumniOf' => ['@type' => 'CollegeOrUniversity', 'name' => $a['alumni_of']],
            'knowsAbout' => $a['knows_about'],
            'sameAs' => $a['same_as'],
            'worksFor' => ['@type' => 'Organization', 'name' => 'DSD Properties', 'url' => url('/')],
            'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'],
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'About', 'item' => url('/about')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $a['name'], 'item' => $pageUrl],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<style>
#au{max-width:960px;margin:0 auto;padding:28px 16px 56px;color:#334155;font-family:'Poppins',sans-serif}
#au h1{font-size:clamp(1.6rem,4vw,2.2rem);color:#011f4b;margin:0 0 4px;font-weight:800}
#au h2{font-size:1.25rem;color:#011f4b;margin:40px 0 14px;font-weight:800}
#au .au-card{display:flex;gap:18px;align-items:flex-start;background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:22px}
#au .au-ico{flex:0 0 64px;height:64px;border-radius:50%;background:#011f4b;color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:800}
#au .au-role{color:#008080;font-weight:700;font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;margin:0 0 10px}
#au p{line-height:1.75;margin:0 0 10px}
#au ol{margin:0;padding-left:20px}
#au ol li{margin:0 0 10px;line-height:1.7}
#au .au-list{list-style:none;margin:0;padding:0;display:grid;gap:8px}
#au .au-list a{display:flex;justify-content:space-between;gap:12px;padding:10px 14px;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#011f4b;font-weight:500;background:#fff}
#au .au-list a:hover{border-color:#008080;color:#008080}
#au .au-list time{flex:0 0 auto;color:#94a3b8;font-size:.8rem;white-space:nowrap}
#au .au-muted{font-size:.85rem;color:#64748b}
@media(max-width:560px){#au .au-card{flex-direction:column}#au .au-list a{flex-direction:column;gap:2px}}
</style>
@endpush

@section('content')
<div id="au">
    <nav class="au-muted" aria-label="Breadcrumb" style="margin-bottom:14px;">
        <a href="{{ url('/') }}" style="color:#64748b;text-decoration:none;">Home</a> /
        <a href="{{ url('/about') }}" style="color:#64748b;text-decoration:none;">About</a> /
        <span>{{ $a['name'] }}</span>
    </nav>

    <div class="au-card">
        <div class="au-ico" aria-hidden="true">{{ mb_substr($a['name'], 0, 1) }}</div>
        <div>
            <h1>{{ $a['name'] }}</h1>
            <p class="au-role">{{ $a['job_title'] }} · Lucknow</p>
            <p>{{ $a['bio'] }}</p>
            <p class="au-muted" style="margin:0;">
                Studied at {{ $a['alumni_of'] }} ·
                @foreach($a['same_as'] as $link)
                    <a href="{{ $link }}" target="_blank" rel="noopener me" style="color:#008080;font-weight:600;">LinkedIn</a>
                @endforeach
                · {{ $posts->count() }} articles and {{ $newsCount }} news stories on this site
            </p>
        </div>
    </div>

    <h2 id="how-we-research">How we research and check our articles</h2>
    <ol>
        <li><strong>Official sources first.</strong> Facts come from LDA, Awas Vikas (UPAVP), UP RERA and IGRSUP orders, notices, board minutes, layout plans and lottery lists. Newspaper reports are used only for statements made by officials, and we name the paper.</li>
        <li><strong>Nothing invented.</strong> We do not publish rumours, price predictions or figures we cannot trace to a source. If two sources disagree, we say so, or we use the official document.</li>
        <li><strong>Proposed is not final.</strong> A rate, date or plan that is not yet approved is marked "proposed", "expected" or "not confirmed".</li>
        <li><strong>Dated facts.</strong> Each article shows when it was last updated, and time-sensitive facts carry their own date. We revisit guides when an authority publishes something new.</li>
        <li><strong>Links, not copies.</strong> For lottery results and official PDFs we link to the authority's own file; we don't host or change them.</li>
        <li><strong>Corrections.</strong> If you find a mistake, tell us through the <a href="{{ url('/contact-us') }}" style="color:#008080;font-weight:600;">contact page</a>. We check it against the source and fix the article.</li>
        <li><strong>Independent.</strong> DSD Properties is a private firm, not connected with LDA, UPAVP or any government body.</li>
    </ol>

    @if($posts->isNotEmpty())
        <h2 id="articles">Articles by {{ $a['name'] }}</h2>
        <ul class="au-list">
            @foreach($posts as $p)
                <li><a href="{{ url('/blog/' . $p->slug) }}"><span>{{ $p->title }}</span><time datetime="{{ $p->updated_at->toDateString() }}">Updated {{ $p->updated_at->format('j M Y') }}</time></a></li>
            @endforeach
        </ul>
    @endif

    @if($news->isNotEmpty())
        <h2 id="news">Latest news by {{ $a['name'] }}</h2>
        <ul class="au-list">
            @foreach($news as $n)
                <li><a href="{{ $n->url }}"><span>{{ $n->title }}</span><time datetime="{{ $n->created_at->toDateString() }}">{{ $n->created_at->format('j M Y') }}</time></a></li>
            @endforeach
        </ul>
        <p class="au-muted" style="margin-top:12px;"><a href="{{ url('/news') }}" style="color:#008080;font-weight:600;">All news →</a></p>
    @endif
</div>
@endsection
