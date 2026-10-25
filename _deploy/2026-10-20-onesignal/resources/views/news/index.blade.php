{{--
    resources/views/news/index.blade.php
    Newsroom layout (redesigned 2026-10-20): compact masthead, lead story,
    stories grouped by date, sidebar with the verification + WhatsApp offers.
    Stories are written in Hindi, so headlines use Mukta (Devanagari).
--}}

@extends('layouts.app-article')

@section('seo')
    <title>Lucknow Real Estate News — LDA Updates, Price Trends & More | DSD Properties</title>
    <meta name="description"  content="Lucknow real estate news in Hindi — LDA schemes, IT City, Awas Vikas, RERA approvals and new projects. Every story checked against the original report by DSD Properties.">
    <meta name="keywords"     content="Lucknow real estate news, LDA updates, IT City Lucknow, Gomti Nagar property news, Lucknow property prices, RERA Lucknow">
    <link rel="canonical"     href="{{ url('/news') }}">
    <meta name="robots"       content="index, follow">

    <meta property="og:type"        content="website">
    <meta property="og:title"       content="Lucknow Real Estate News | DSD Properties">
    <meta property="og:description" content="LDA updates, IT City news, Awas Vikas and RERA approvals in Lucknow — checked against the original reports.">
    <meta property="og:url"         content="{{ url('/news') }}">
    <meta property="og:site_name"   content="DSD Properties">
    <meta property="og:image"       content="{{ asset('images/og-news.png') }}">
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="Lucknow Real Estate News | DSD Properties">
    <meta name="twitter:description" content="LDA updates, IT City news, Awas Vikas and RERA approvals in Lucknow.">
    <meta name="twitter:image"       content="{{ asset('images/og-news.png') }}">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "Lucknow Real Estate News",
        "inLanguage": "hi",
        "description": "Latest Lucknow real estate news including LDA updates, IT City, price trends and new projects.",
        "url": "{{ url('/news') }}",
        "publisher": {
            "@type": "Organization",
            "name": "DSD Properties",
            "url": "{{ url('/') }}",
            "logo": { "@type": "ImageObject", "url": "{{ asset('images/logo.webp') }}" }
        }
    }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ─── Tokens ─────────────────────────────────────── */
        .nr {
            --nr-ink:    #111827;
            --nr-body:   #374151;
            --nr-muted:  #6b7280;
            --nr-faint:  #9ca3af;
            --nr-line:   #e5e7eb;
            --nr-paper:  #ffffff;
            --nr-bg:     #f6f7f9;
            --nr-navy:   #0f1f5c;
            --nr-orange: #FF5C00;
            --nr-green:  #128C7E;
            font-family:'Plus Jakarta Sans','Mukta',sans-serif;
            color:var(--nr-body);
            background:var(--nr-bg);
        }
        .nr-hi { font-family:'Mukta','Plus Jakarta Sans',sans-serif; }
        .nr-c  { max-width:1140px; margin:0 auto; padding:0 16px; }

        /* ─── Masthead ───────────────────────────────────── */
        .nr-mast { background:var(--nr-navy); color:#fff; padding:40px 0 30px; }
        .nr-mast__row { display:flex; align-items:flex-end; justify-content:space-between; gap:24px; flex-wrap:wrap; }
        .nr-mast__kicker {
            font-size:.7rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase;
            color:#93c5fd; margin-bottom:8px;
        }
        .nr-mast__h1 {
            font-family:'Mukta',sans-serif; font-size:clamp(2rem,4.6vw,3rem);
            font-weight:800; line-height:1.1; color:#fff; margin:0;
        }
        .nr-mast__h1 span { color:var(--nr-orange); }
        .nr-mast__sub { font-size:.92rem; color:rgba(255,255,255,.72); margin-top:10px; max-width:560px; line-height:1.7; }
        .nr-mast__facts { display:flex; gap:10px; flex-wrap:wrap; }
        .nr-mast__fact {
            display:inline-flex; align-items:center; gap:8px;
            border:1px solid rgba(255,255,255,.18); background:rgba(255,255,255,.06);
            border-radius:8px; padding:8px 12px; font-size:.78rem; color:rgba(255,255,255,.85);
            white-space:nowrap;
        }
        .nr-mast__fact strong { color:#fff; font-weight:700; }
        .nr-mast__fact svg { flex-shrink:0; color:#4ade80; }

        /* ─── Category tabs ──────────────────────────────── */
        .nr-tabs {
            background:var(--nr-paper); border-bottom:1px solid var(--nr-line);
            position:sticky; top:68px; z-index:30;
        }
        .nr-tabs__scroll { overflow-x:auto; scrollbar-width:none; }
        .nr-tabs__scroll::-webkit-scrollbar { display:none; }
        .nr-tabs__list { display:flex; gap:4px; width:max-content; }
        .nr-tab {
            display:block; padding:14px 14px 12px; font-size:.86rem; font-weight:600;
            color:var(--nr-muted); text-decoration:none; white-space:nowrap;
            border-bottom:3px solid transparent; transition:color .15s, border-color .15s;
        }
        .nr-tab:hover { color:var(--nr-ink); text-decoration:none; }
        .nr-tab--on { color:var(--nr-navy); border-bottom-color:var(--nr-orange); }

        /* ─── Layout ─────────────────────────────────────── */
        .nr-main { padding:32px 0 72px; }
        .nr-layout { display:grid; grid-template-columns:minmax(0,1fr) 320px; gap:32px; align-items:start; }
        @media (max-width:960px) { .nr-layout { grid-template-columns:minmax(0,1fr); } }

        /* ─── Category tag ───────────────────────────────── */
        .nr-tag {
            display:inline-flex; align-items:center; gap:6px;
            font-size:.72rem; font-weight:700; letter-spacing:.02em; color:var(--c,#6b7280);
        }
        .nr-tag::before { content:''; width:8px; height:8px; border-radius:2px; background:var(--c,#6b7280); }
        .nr-hot {
            font-size:.68rem; font-weight:700; color:#b91c1c; background:#fef2f2;
            border:1px solid #fecaca; border-radius:4px; padding:1px 6px;
        }
        .nr-meta { display:flex; align-items:center; gap:10px; flex-wrap:wrap; font-size:.76rem; color:var(--nr-faint); }
        .nr-meta .sep { width:3px; height:3px; border-radius:50%; background:#d1d5db; }

        /* ─── Lead story ─────────────────────────────────── */
        .nr-lead {
            background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:14px;
            padding:28px 28px 24px; border-top:4px solid var(--c,#0f1f5c); margin-bottom:28px;
        }
        @media (max-width:600px) { .nr-lead { padding:20px 18px; } }
        .nr-lead__label {
            font-size:.68rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase;
            color:var(--nr-orange); margin-bottom:10px;
        }
        .nr-lead__title {
            display:block; font-family:'Mukta',sans-serif; font-size:clamp(1.45rem,3vw,2rem);
            font-weight:800; line-height:1.3; color:var(--nr-ink); text-decoration:none; margin:10px 0 12px;
        }
        .nr-lead__title:hover { color:var(--nr-navy); text-decoration:underline; text-decoration-thickness:2px; text-underline-offset:4px; }
        .nr-lead__summary { font-family:'Mukta',sans-serif; font-size:1.08rem; line-height:1.75; color:var(--nr-body); margin-bottom:20px; }
        .nr-lead__foot { display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; }
        .nr-btn {
            display:inline-flex; align-items:center; gap:8px; padding:11px 20px; border-radius:8px;
            background:var(--nr-navy); color:#fff; font-size:.85rem; font-weight:700; text-decoration:none;
            transition:background .15s;
        }
        .nr-btn:hover { background:#1a3a8f; color:#fff; text-decoration:none; }

        /* ─── Date groups + story rows ───────────────────── */
        .nr-day { margin-bottom:28px; }
        .nr-day__head {
            display:flex; align-items:baseline; gap:12px; margin-bottom:6px;
            padding-bottom:10px; border-bottom:2px solid var(--nr-ink);
        }
        .nr-day__date { font-family:'Mukta',sans-serif; font-size:1.15rem; font-weight:800; color:var(--nr-ink); }
        .nr-day__count { font-size:.76rem; color:var(--nr-faint); }

        .nr-story {
            display:grid; grid-template-columns:minmax(0,1fr) auto; gap:6px 20px;
            padding:18px 0; border-bottom:1px solid var(--nr-line);
        }
        .nr-story:last-child { border-bottom:none; }
        .nr-story__title {
            grid-column:1 / -1; font-family:'Mukta',sans-serif; font-size:1.22rem; font-weight:700;
            line-height:1.4; color:var(--nr-ink); text-decoration:none; margin:4px 0 2px;
        }
        .nr-story__title:hover { color:var(--nr-navy); text-decoration:underline; text-underline-offset:3px; }
        .nr-story__summary {
            grid-column:1 / -1; font-family:'Mukta',sans-serif; font-size:.98rem; line-height:1.7;
            color:var(--nr-muted); margin:0;
            display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
        }
        .nr-story__foot { grid-column:1 / -1; display:flex; justify-content:space-between; align-items:center; gap:10px; margin-top:6px; flex-wrap:wrap; }
        .nr-more { font-size:.8rem; font-weight:700; color:var(--nr-orange); text-decoration:none; white-space:nowrap; }
        .nr-more:hover { text-decoration:underline; color:var(--nr-orange); }
        .nr-list { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:14px; padding:6px 24px; }
        @media (max-width:600px) { .nr-list { padding:4px 16px; } }

        /* ─── Empty state ────────────────────────────────── */
        .nr-empty { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:14px; padding:56px 24px; text-align:center; }
        .nr-empty p { margin:0; }

        /* ─── Sidebar ────────────────────────────────────── */
        .nr-side { display:flex; flex-direction:column; gap:20px; position:sticky; top:132px; }
        @media (max-width:960px) { .nr-side { position:static; } }
        .nr-box { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:14px; padding:22px; }
        .nr-box__kicker { font-size:.68rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:var(--nr-orange); margin-bottom:6px; }
        .nr-box__title { font-size:1.08rem; font-weight:800; color:var(--nr-ink); line-height:1.35; margin-bottom:8px; }
        .nr-box__text { font-size:.84rem; line-height:1.65; color:var(--nr-muted); margin-bottom:14px; }
        .nr-box--verify { background:var(--nr-navy); border-color:var(--nr-navy); }
        .nr-box--verify .nr-box__title { color:#fff; }
        .nr-box--verify .nr-box__text  { color:rgba(255,255,255,.72); }
        .nr-price { font-size:1.9rem; font-weight:800; color:#fff; line-height:1; margin-bottom:4px; }
        .nr-price small { font-size:.78rem; font-weight:500; color:rgba(255,255,255,.6); }
        .nr-checks { list-style:none; padding:0; margin:12px 0 16px; }
        .nr-checks li { position:relative; padding-left:22px; font-size:.82rem; color:rgba(255,255,255,.85); margin-bottom:6px; }
        .nr-checks li::before { content:'✓'; position:absolute; left:0; color:#4ade80; font-weight:800; }
        .nr-cta {
            display:flex; align-items:center; justify-content:center; gap:8px; width:100%;
            padding:12px 16px; border-radius:8px; font-size:.86rem; font-weight:700; text-decoration:none;
            transition:opacity .15s;
        }
        .nr-cta:hover { opacity:.9; text-decoration:none; }
        .nr-cta--orange { background:var(--nr-orange); color:#fff !important; }
        .nr-cta--wa     { background:#25D366; color:#fff !important; }
        .nr-guides { list-style:none; padding:0; margin:0; }
        .nr-guides li { border-top:1px solid var(--nr-line); }
        .nr-guides li:first-child { border-top:none; }
        .nr-guides a {
            display:flex; justify-content:space-between; align-items:center; gap:10px;
            padding:11px 0; font-size:.86rem; font-weight:600; color:var(--nr-ink); text-decoration:none;
        }
        .nr-guides a:hover { color:var(--nr-orange); }
        .nr-guides a span { color:var(--nr-faint); }

        /* ─── Mobile buy/sell bar ────────────────────────── */
        .mob-cta-bar{display:none;position:fixed;bottom:0;left:0;right:0;z-index:9999;padding:10px 14px;background:#fff;border-top:1px solid #e5e7eb;box-shadow:0 -4px 18px rgba(0,0,0,.12);gap:10px}
        @media(max-width:1023px){.mob-cta-bar{display:flex}body{padding-bottom:72px}}
        .mob-cta-bar a{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:13px 10px;border-radius:10px;font-weight:700;font-size:.88rem;text-decoration:none;letter-spacing:.1px;transition:opacity .15s}
        .mob-cta-bar a:hover{opacity:.88;text-decoration:none}
        .mob-cta-buy{background:linear-gradient(135deg,#25D366,#128C7E);color:#fff !important}
        .mob-cta-sell{background:linear-gradient(135deg,#011f4b,#013870);color:#fff !important}
    </style>
@endsection

@section('content')

@php
    $categories = [
        'all'      => 'सभी खबरें',
        'lda'      => 'LDA',
        'it-city'  => 'आईटी सिटी',
        'projects' => 'नए प्रोजेक्ट',
        'price'    => 'कीमतें',
        'policy'   => 'नीति',
        'rera'     => 'RERA',
    ];
    $catHindi = [
        'lda'      => 'LDA अपडेट',
        'it-city'  => 'आईटी सिटी',
        'projects' => 'नए प्रोजेक्ट',
        'price'    => 'कीमतें',
        'policy'   => 'नीति',
        'rera'     => 'RERA',
    ];
    $catColor = [
        'lda'      => '#16a34a',
        'it-city'  => '#2563eb',
        'price'    => '#ea580c',
        'projects' => '#7c3aed',
        'policy'   => '#dc2626',
        'rera'     => '#0d9488',
    ];
    $activeCategory = $category ?? 'all';

    $allItems  = collect($articles->items());
    $lead      = $articles->onFirstPage() ? $allItems->first() : null;
    $restItems = $lead ? $allItems->slice(1) : $allItems;
    $byDay     = $restItems->groupBy(fn ($a) => $a->created_at->format('Y-m-d'));
    $lastUpdate = $allItems->max('created_at');

    $waNumber = '918595002933';
    $waBuy    = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode('नमस्ते, मैंने DSD Properties पर लखनऊ प्रॉपर्टी की खबरें पढ़ीं। मुझे लखनऊ में प्रॉपर्टी खरीदनी है।');
@endphp

<div class="nr">

{{-- ══ MASTHEAD ══════════════════════════════════════════ --}}
<header class="nr-mast">
    <div class="nr-c nr-mast__row">
        <div>
            <p class="nr-mast__kicker">Lucknow Property News</p>
            <h1 class="nr-mast__h1">लखनऊ प्रॉपर्टी <span>समाचार</span></h1>
            <p class="nr-mast__sub nr-hi">
                LDA, आवास विकास, आईटी सिटी और RERA की वो खबरें जो लखनऊ में प्लॉट या फ्लैट खरीदने वालों के काम की हैं।
            </p>
        </div>
        <div class="nr-mast__facts">
            @if($lastUpdate)
            <span class="nr-mast__fact nr-hi">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                अपडेट: <strong>{{ $lastUpdate->copy()->locale('hi')->translatedFormat('j F Y') }}</strong>
            </span>
            @endif
            <span class="nr-mast__fact nr-hi">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 13l4 4L19 7"/></svg>
                हर खबर मूल स्रोत से जाँची गई
            </span>
        </div>
    </div>
</header>

{{-- ══ CATEGORY TABS ═════════════════════════════════════ --}}
<nav class="nr-tabs" aria-label="News categories">
    <div class="nr-c nr-tabs__scroll">
        <div class="nr-tabs__list nr-hi">
            @foreach($categories as $key => $label)
                <a href="{{ $key === 'all' ? route('news.index') : route('news.index', ['category' => $key]) }}"
                   class="nr-tab {{ $activeCategory === $key ? 'nr-tab--on' : '' }}"
                   @if($activeCategory === $key) aria-current="page" @endif>
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</nav>

{{-- ══ MAIN ══════════════════════════════════════════════ --}}
<div class="nr-main">
<div class="nr-c nr-layout">

    <main>
        @if($articles->isEmpty())
            <div class="nr-empty nr-hi">
                <p style="font-size:1.15rem; font-weight:700; color:#111827; margin-bottom:6px;">इस श्रेणी में अभी कोई खबर नहीं है</p>
                <p style="font-size:.95rem; color:#6b7280; margin-bottom:18px;">बाकी खबरें देखें या हमारी गाइड पढ़ें।</p>
                <a href="{{ route('news.index') }}" class="nr-btn">सभी खबरें देखें</a>
            </div>
        @else

            {{-- ── Lead story ─────────────────────────── --}}
            @if($lead)
            @php $lc = $catColor[$lead->category] ?? '#0f1f5c'; @endphp
            <article class="nr-lead" style="--c:{{ $lc }}">
                <p class="nr-lead__label nr-hi">ताज़ा खबर</p>
                <div class="nr-meta nr-hi">
                    <span class="nr-tag" style="--c:{{ $lc }}">{{ $catHindi[$lead->category] ?? 'खबर' }}</span>
                    @if($lead->is_hot)<span class="nr-hot">अहम</span>@endif
                    <span class="sep"></span>
                    <time datetime="{{ $lead->created_at->toIso8601String() }}">{{ $lead->created_at->copy()->locale('hi')->translatedFormat('j F Y') }}</time>
                </div>
                <a href="{{ route('news.show', $lead->slug) }}" class="nr-lead__title">{{ $lead->title }}</a>
                <p class="nr-lead__summary">{{ $lead->summary }}</p>
                <div class="nr-lead__foot">
                    <span class="nr-meta nr-hi">
                        @if($lead->source_name) स्रोत: {{ $lead->source_name }} @endif
                    </span>
                    <a href="{{ route('news.show', $lead->slug) }}" class="nr-btn nr-hi">
                        पूरी खबर पढ़ें
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </article>
            @endif

            {{-- ── Stories grouped by day ─────────────── --}}
            @foreach($byDay as $day => $items)
            @php $dayDate = \Carbon\Carbon::parse($day)->locale('hi'); @endphp
            <section class="nr-day">
                <div class="nr-day__head nr-hi">
                    <h2 class="nr-day__date">{{ $dayDate->translatedFormat('j F Y') }}</h2>
                    <span class="nr-day__count">{{ $items->count() }} {{ $items->count() === 1 ? 'खबर' : 'खबरें' }}</span>
                </div>
                <div class="nr-list">
                    @foreach($items as $article)
                    @php $c = $catColor[$article->category] ?? '#6b7280'; @endphp
                    <article class="nr-story">
                        <div class="nr-meta nr-hi" style="grid-column:1 / -1;">
                            <span class="nr-tag" style="--c:{{ $c }}">{{ $catHindi[$article->category] ?? 'खबर' }}</span>
                            @if($article->is_hot)<span class="nr-hot">अहम</span>@endif
                        </div>
                        <a href="{{ route('news.show', $article->slug) }}" class="nr-story__title">{{ $article->title }}</a>
                        <p class="nr-story__summary">{{ $article->summary }}</p>
                        <div class="nr-story__foot nr-hi">
                            <span class="nr-meta">@if($article->source_name) स्रोत: {{ $article->source_name }} @endif</span>
                            <a href="{{ route('news.show', $article->slug) }}" class="nr-more">पढ़ें →</a>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endforeach

            @if($articles->hasPages())
                <div style="margin-top:32px;">
                    {{ $articles->appends($activeCategory !== 'all' ? ['category' => $activeCategory] : [])->links() }}
                </div>
            @endif
        @endif
    </main>

    {{-- ══ SIDEBAR ═══════════════════════════════════════ --}}
    <aside class="nr-side">
        {{-- Shown by partials/onesignal only when push works here and this browser isn't subscribed yet. --}}
        <div class="nr-box" data-push-ask hidden>
            <p class="nr-box__kicker">Notifications</p>
            <p class="nr-box__title nr-hi">नई खबर आते ही जानें</p>
            <p class="nr-box__text nr-hi">LDA, आवास विकास और RERA की ज़रूरी खबरें — हफ्ते में 1–2 बार, सीधे आपके फोन या ब्राउज़र पर।</p>
            <button type="button" class="nr-cta nr-cta--orange nr-hi" style="border:0; cursor:pointer;"
                    onclick="window.dsdPushAsk && window.dsdPushAsk()">🔔 नोटिफिकेशन चालू करें</button>
        </div>

        <div class="nr-box nr-box--verify">
            <p class="nr-box__kicker" style="color:#fdba74;">Property Verification</p>
            <p class="nr-box__title nr-hi">खरीदने से पहले प्रॉपर्टी की जाँच करवाएँ</p>
            <div class="nr-price">₹5,000 <small>/ प्लॉट या फ्लैट</small></div>
            <ul class="nr-checks nr-hi">
                <li>मालिकाना हक और खतौनी की जाँच</li>
                <li>LDA / RERA मंज़ूरी और नक्शा</li>
                <li>48 घंटे में PDF रिपोर्ट</li>
            </ul>
            <a href="{{ url('/services/property-verification-lucknow') }}" class="nr-cta nr-cta--orange nr-hi"
               data-cta-kind="verify">जाँच बुक करें →</a>
        </div>

        <div class="nr-box">
            <p class="nr-box__kicker">Buy in Lucknow</p>
            <p class="nr-box__title nr-hi">लखनऊ में प्लॉट या फ्लैट ढूंढ रहे हैं?</p>
            <p class="nr-box__text nr-hi">अपना बजट और इलाका बताइए — हम सही विकल्प और कीमत बताएँगे।</p>
            <a href="{{ $waBuy }}" target="_blank" rel="noopener" class="nr-cta nr-cta--wa nr-hi" data-cta-kind="buy">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                WhatsApp पर बात करें
            </a>
        </div>

        <div class="nr-box">
            <p class="nr-box__kicker">Guides</p>
            <p class="nr-box__title nr-hi">विस्तार से पढ़ें</p>
            <ul class="nr-guides nr-hi">
                <li><a href="{{ url('/lda-schemes') }}">LDA की सभी योजनाएँ <span>→</span></a></li>
                <li><a href="{{ url('/blog/varun-vihar-yojana-lucknow-hindi-2026') }}">वरुण विहार योजना गाइड <span>→</span></a></li>
                <li><a href="{{ url('/blog/it-city-lucknow-lda-plots-guide-hindi-2026') }}">आईटी सिटी प्लॉट गाइड <span>→</span></a></li>
                <li><a href="{{ url('/blog/lda-online-property-verification-lucknow-2026') }}">LDA ऑनलाइन वेरिफिकेशन <span>→</span></a></li>
                <li><a href="{{ url('/blog') }}">सभी गाइड <span>→</span></a></li>
            </ul>
        </div>
    </aside>

</div>
</div>

</div>

{{-- ══ MOBILE BUY / SELL BAR ════════════════════════════ --}}
@include('components.mobile-cta-bar')

@endsection
