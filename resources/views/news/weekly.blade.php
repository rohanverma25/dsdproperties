{{--
    /news/weekly/{week} — the week's stories on one page, built from news_articles (NewsWeeklyController).
    The weekly newsletter email links here.
--}}
@extends('layouts.app-article')

@php
    $title = 'Lucknow Real Estate Weekly Report: ' . $weekLabel . ' | ' . $stories->count() . ' updates';
    $desc  = 'Lucknow property news for ' . $weekLabel . ' (' . $stories->count() . ' updates): ' . $stories->take(3)->pluck('title')->map(fn ($t) => \Illuminate\Support\Str::limit($t, 60))->implode(' · ');
@endphp

@section('seo')
    <title>{{ $title }}</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($desc, 300) }}">
    <link rel="canonical" href="{{ route('news.weekly.show', $week) }}">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($desc, 200) }}">
    <meta property="og:url" content="{{ route('news.weekly.show', $week) }}">
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => $title,
        'url' => route('news.weekly.show', $week), 'inLanguage' => 'en-IN',
        'mainEntity' => ['@type' => 'ItemList', 'numberOfItems' => $stories->count(),
            'itemListElement' => $stories->values()->map(fn ($s, $i) => ['@type' => 'ListItem', 'position' => $i + 1, 'url' => $s->url, 'name' => $s->title])->all()],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection

@push('head')
<link href="https://fonts.googleapis.com/css2?family=Mukta:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
body{font-family:'Plus Jakarta Sans','Mukta',sans-serif}
.wk{max-width:880px;margin:0 auto;padding:28px 16px 60px}
.wk-mast{background:#011f4b;color:#fff;border-radius:18px;padding:26px 24px;margin-bottom:22px}
.wk-mast small{font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#99d6d6;font-weight:700}
.wk-mast h1{font-size:clamp(1.5rem,4vw,2.1rem);font-weight:800;line-height:1.25;margin:8px 0 6px}
.wk-mast p{margin:0;color:#cbd5e1}
.wk-weeks{display:flex;flex-wrap:wrap;gap:8px;margin:0 0 22px}
.wk-weeks a{font-size:13px;font-weight:600;border:1.5px solid #e2e8f0;border-radius:999px;padding:6px 12px;text-decoration:none;color:#334155;background:#fff}
.wk-weeks a.on{background:#011f4b;border-color:#011f4b;color:#fff}
.wk-item{display:block;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:18px 20px;margin-bottom:12px;text-decoration:none;transition:border-color .15s,box-shadow .15s}
.wk-item:hover{border-color:#008080;box-shadow:0 8px 24px rgba(1,31,75,.08)}
.wk-item small{font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#008080}
.wk-item h2{font-size:1.15rem;font-weight:700;color:#011f4b;line-height:1.45;margin:6px 0 8px}
.wk-item p{margin:0;color:#4b5563;font-size:15px;line-height:1.75}
.wk-sub{background:#fff7ed;border:1px solid #fed7aa;border-radius:14px;padding:18px 20px;margin-top:22px}
.wk-sub h3{margin:0 0 6px;color:#011f4b;font-size:1.05rem;font-weight:700}
.wk-sub p{margin:0 0 12px;color:#7c2d12;font-size:14.5px;line-height:1.7}
.wk-sub .row{display:flex;flex-wrap:wrap;gap:10px}
.wk-sub a{display:inline-flex;padding:11px 16px;border-radius:10px;font-weight:700;font-size:14px;text-decoration:none}
</style>
@endpush

@section('content')
<div class="wk">
    <div class="wk-mast">
        <small>Weekly report</small>
        <h1>Lucknow Real Estate This Week</h1>
        <p>{{ $weekLabel }} · {{ $stories->count() }} updates, each checked against the original report · stories are in Hindi</p>
    </div>

    @if(count($weeks) > 1)
    <nav class="wk-weeks" aria-label="Other weeks">
        @foreach($weeks as $k => $n)
            <a href="{{ route('news.weekly.show', $k) }}" class="{{ $k === $week ? 'on' : '' }}">{{ \App\Support\Newsletter::weekLabel($k) }} ({{ $n }})</a>
        @endforeach
    </nav>
    @endif

    @foreach($stories as $s)
        <a class="wk-item" href="{{ $s->url }}">
            <small>{{ $s->category_label }} · {{ $s->created_at->format('j M Y') }}</small>
            <h2>{{ $s->title }}</h2>
            <p>{{ \Illuminate\Support\Str::limit($s->summary, 260) }}</p>
        </a>
    @endforeach

    <div class="wk-sub">
        <h3>Get this report every week</h3>
        <p>Weekly updates by email and new-story alerts in your browser. Buying a plot or flat? Get the papers checked first for ₹5,000.</p>
        <div class="row">
            <a href="{{ url('/news') }}" style="background:#011f4b;color:#fff">All news</a>
            <a href="{{ url('/services/property-verification-lucknow') }}" style="background:#FF5C00;color:#fff">₹5,000 verification</a>
        </div>
    </div>
</div>
@endsection
