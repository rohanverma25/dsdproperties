{{--
    resources/views/news/index.blade.php
    Plain news list (simplified 2026-10-31): a short header, text tabs, the latest story, then the
    rest as a list grouped by date. Colour is limited to the small category label; the sidebar keeps
    the plot-sale cards (plain variant), the verification offer and guides. Page text is English;
    the Hindi story titles and summaries fall back to Hind.
--}}

@extends('layouts.app-article')

@section('seo')
    <title>लखनऊ प्रॉपर्टी न्यूज़: LDA, आवास विकास, RERA की ताज़ा ख़बरें | Lucknow Property News</title>
    <meta name="description"  content="लखनऊ प्रॉपर्टी की ताज़ा ख़बरें हिंदी में: LDA योजना, प्लॉट पंजीकरण, आवास विकास, RERA, अवैध निर्माण पर कार्रवाई और रजिस्ट्री। हर खबर मूल रिपोर्ट से जांची हुई। Lucknow property news.">
    <meta name="keywords"     content="Lucknow real estate news, LDA updates, IT City Lucknow, Gomti Nagar property news, Lucknow property prices, RERA Lucknow">
    <link rel="canonical"     href="{{ url('/news') }}">
    <meta name="robots"       content="index, follow">

    <meta property="og:type"        content="website">
    <meta property="og:title"       content="लखनऊ प्रॉपर्टी न्यूज़ | Lucknow Property News">
    <meta property="og:description" content="LDA योजना, आवास विकास, RERA और प्लॉट की ताज़ा ख़बरें, मूल रिपोर्ट से जांची हुई।">
    <meta property="og:url"         content="{{ url('/news') }}">
    <meta property="og:site_name"   content="DSD Properties">
    <meta property="og:image"       content="{{ asset('images/og-news.png') }}">
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="लखनऊ प्रॉपर्टी न्यूज़ | Lucknow Property News">
    <meta name="twitter:description" content="LDA योजना, आवास विकास, RERA और प्लॉट की ताज़ा ख़बरें।">
    <meta name="twitter:image"       content="{{ asset('images/og-news.png') }}">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "लखनऊ प्रॉपर्टी न्यूज़ (Lucknow Property News)",
        "inLanguage": "hi",
        "description": "लखनऊ प्रॉपर्टी की ताज़ा ख़बरें: LDA योजना, आवास विकास, RERA, अवैध निर्माण पर कार्रवाई और नए प्रोजेक्ट।",
        "url": "{{ url('/news') }}",
        "publisher": {
            "@type": "Organization",
            "name": "DSD Properties",
            "url": "{{ url('/') }}",
            "logo": { "@type": "ImageObject", "url": "{{ asset('images/logo.webp') }}" }
        }
    }
    </script>


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Hind:wght@400;500;600;700&display=swap" rel="stylesheet">


    <style>
        /* ─── Tokens ─────────────────────────────────────── */
        .nr {
            --nr-ink:    #0f172a;
            --nr-body:   #334155;
            --nr-muted:  #64748b;
            --nr-faint:  #94a3b8;
            --nr-line:   #e5e7eb;
            --nr-paper:  #ffffff;
            --nr-bg:     #f8fafc;
            --nr-navy:   #0b1e5b;
            --nr-orange: #FF5C00;
            font-family:'Plus Jakarta Sans','Hind',sans-serif;
            color:var(--nr-body);
            background:var(--nr-bg);
        }
        .nr-hi { font-family:'Plus Jakarta Sans','Hind',sans-serif; }
        .nr-c  { max-width:1140px; margin:0 auto; padding:0 16px; }

        /* ─── Header ─────────────────────────────────────── */
        .nr-head { background:var(--nr-paper); border-bottom:1px solid var(--nr-line); padding:32px 0 0; }
        .nr-head__h1 { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:clamp(1.7rem,3.6vw,2.4rem); font-weight:800; color:var(--nr-ink); line-height:1.2; margin:0; }
        .nr-head__sub { font-size:1rem; color:var(--nr-muted); margin:8px 0 0; line-height:1.6; max-width:620px; }
        .nr-head__meta { font-size:.85rem; color:var(--nr-faint); margin:6px 0 0; }

        /* ─── Tabs ───────────────────────────────────────── */
        .nr-tabs { margin-top:20px; overflow-x:auto; scrollbar-width:none; }
        .nr-tabs::-webkit-scrollbar { display:none; }
        .nr-tabs__list { display:flex; gap:4px; width:max-content; }
        .nr-tab {
            display:inline-block; padding:10px 14px; font-size:.92rem; font-weight:600; color:var(--nr-muted);
            text-decoration:none; white-space:nowrap; border-bottom:2px solid transparent;
        }
        .nr-tab:hover { color:var(--nr-ink); text-decoration:none; }
        .nr-tab--on { color:var(--nr-navy) !important; border-bottom-color:var(--nr-navy); }

        /* ─── Layout ─────────────────────────────────────── */
        .nr-main { padding:28px 0 72px; }
        .nr-layout { display:grid; grid-template-columns:minmax(0,1fr) 320px; gap:32px; align-items:start; }
        @media (max-width:1020px) { .nr-layout { grid-template-columns:minmax(0,1fr); } }

        /* ─── Meta line: category · date · important ─────── */
        .nr-meta { display:flex; align-items:center; gap:8px; flex-wrap:wrap; font-size:.8rem; color:var(--nr-faint); }
        .nr-tag { font-size:.78rem; font-weight:700; color:var(--c); }
        .nr-hot { font-size:.75rem; font-weight:700; color:#dc2626; }
        .nr-dot { color:var(--nr-line); }

        /* ─── Lead story ─────────────────────────────────── */
        .nr-lead { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:12px; padding:24px 26px; margin-bottom:28px; }
        @media (max-width:600px) { .nr-lead { padding:18px; } }
        .nr-lead__title {
            display:block; font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:clamp(1.3rem,2.6vw,1.7rem);
            font-weight:700; line-height:1.45; color:var(--nr-ink); text-decoration:none; margin:10px 0;
        }
        .nr-lead__title:hover { color:var(--nr-navy); text-decoration:underline; }
        .nr-lead__summary { font-size:1.04rem; line-height:1.75; color:var(--nr-body); margin:0 0 14px; }
        .nr-link { font-size:.92rem; font-weight:700; color:var(--nr-navy); text-decoration:none; }
        .nr-link:hover { text-decoration:underline; }

        /* ─── Date groups + story list ───────────────────── */
        .nr-day { margin-bottom:26px; }
        .nr-day__date { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:.82rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--nr-muted); margin:0 0 8px; }
        .nr-list { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:12px; }
        .nr-story { position:relative; padding:16px 20px; border-top:1px solid var(--nr-line); }
        .nr-story:first-child { border-top:none; }
        .nr-story:hover { background:#fafbfc; }
        .nr-story__title {
            display:block; font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:1.05rem; font-weight:600;
            line-height:1.5; color:var(--nr-ink); text-decoration:none; margin:6px 0 4px;
        }
        .nr-story__title::after { content:''; position:absolute; inset:0; }  /* whole row clickable */
        .nr-story:hover .nr-story__title { color:var(--nr-navy); text-decoration:underline; }
        .nr-story__summary {
            font-size:.93rem; line-height:1.65; color:var(--nr-muted); margin:0;
            display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
        }
        @media (max-width:600px) { .nr-story { padding:14px 16px; } }

        /* ─── Empty state ────────────────────────────────── */
        .nr-empty { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:12px; padding:48px 24px; text-align:center; }
        .nr-empty p { margin:0; }

        /* ─── Sidebar ────────────────────────────────────── */
        .nr-side { display:flex; flex-direction:column; gap:18px; position:sticky; top:88px; }
        @media (max-width:1020px) { .nr-side { position:static; } }
        .nr-mobile-only { display:none; }
        @media (max-width:1020px) { .nr-mobile-only { display:block; } .nr-side .psc { display:none; } }
        .nr-box { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:12px; padding:20px; }
        .nr-box__kicker { font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--nr-muted); margin:0 0 6px; }
        .nr-box__title { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:1.05rem; font-weight:700; color:var(--nr-ink); line-height:1.4; margin:0 0 6px; }
        .nr-box__text { font-size:.9rem; line-height:1.6; color:var(--nr-muted); margin:0 0 14px; }
        .nr-checks { list-style:none; padding:0; margin:0 0 16px; }
        .nr-checks li { font-size:.9rem; color:var(--nr-body); margin-bottom:6px; }
        .nr-checks li::before { content:'✓  '; color:#16a34a; font-weight:700; }
        .nr-cta {
            display:flex; align-items:center; justify-content:center; width:100%; padding:11px 16px; border-radius:8px;
            font-size:.92rem; font-weight:700; text-decoration:none; background:var(--nr-orange); color:#fff !important; border:0; cursor:pointer;
        }
        .nr-cta:hover { background:#e65300; text-decoration:none; }
        .nr-cta--quiet { background:var(--nr-paper); color:var(--nr-navy) !important; border:1px solid var(--nr-line); }
        .nr-cta--quiet:hover { background:#f1f5f9; }
        .nr-guides { list-style:none; padding:0; margin:0; }
        .nr-guides li { border-top:1px solid var(--nr-line); }
        .nr-guides li:first-child { border-top:none; }
        .nr-guides a { display:block; padding:9px 0; font-size:.92rem; font-weight:600; color:var(--nr-ink); text-decoration:none; }
        .nr-guides a:hover { color:var(--nr-navy); text-decoration:underline; }

        /* ─── Pagination (news/_pagination.blade.php) ─────── */
        .nr-pg { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:12px; padding:14px 18px;
                 display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; }
        .nr-pg__info { margin:0; font-size:.88rem; color:var(--nr-muted); }
        .nr-pg__info strong { color:var(--nr-ink); }
        .nr-pg__row { display:flex; align-items:center; gap:8px; }
        .nr-pg__nums { display:flex; align-items:center; gap:6px; }
        .nr-pg__num, .nr-pg__dots {
            display:inline-flex; align-items:center; justify-content:center; min-width:38px; height:38px; padding:0 8px;
            border-radius:8px; font-size:.92rem; font-weight:700; text-decoration:none;
        }
        .nr-pg__num { color:var(--nr-ink); background:#f1f5f9; }
        .nr-pg__num:hover { background:#e2e8f0; text-decoration:none; }
        .nr-pg__num.is-on { background:var(--nr-navy); color:#fff; }
        .nr-pg__dots { color:var(--nr-faint); min-width:24px; }
        .nr-pg__btn {
            display:inline-flex; align-items:center; height:38px; padding:0 14px; border-radius:8px; font-size:.9rem; font-weight:700;
            color:var(--nr-navy); background:#fff; border:1px solid var(--nr-line); text-decoration:none; white-space:nowrap;
        }
        .nr-pg__btn:hover { border-color:var(--nr-navy); text-decoration:none; color:var(--nr-navy); }
        .nr-pg__btn--next { background:var(--nr-navy); color:#fff !important; border-color:var(--nr-navy); }
        .nr-pg__btn.is-off { color:var(--nr-faint); background:#f8fafc; border-color:var(--nr-line); pointer-events:none; }
        .nr-pg__mob { display:none; font-size:.9rem; font-weight:700; color:var(--nr-ink); }
        @media (max-width:640px) {
            .nr-pg { justify-content:center; text-align:center; }
            .nr-pg__info { width:100%; }
            .nr-pg__row { width:100%; justify-content:space-between; }
            .nr-pg__nums { display:none; }
            .nr-pg__mob { display:inline; }
        }

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
    // Tabs, labels and colours come from NewsArticle::CATEGORIES (the one list to edit).
    $cats      = \App\Models\NewsArticle::CATEGORIES;
    $catLabel  = array_map(fn ($c) => $c['label'], $cats);
    $catColor  = array_map(fn ($c) => $c['color'], $cats);
    $categories = ['all' => 'All News'] + array_map(fn ($c) => $c['tab'] ?? $c['label'], $cats);
    $activeCategory = $category ?? 'all';

    $allItems  = collect($articles->items());
    $lead      = $articles->onFirstPage() ? $allItems->first() : null;
    $restItems = $lead ? $allItems->slice(1) : $allItems;
    $byDay     = $restItems->groupBy(fn ($a) => $a->created_at->format('Y-m-d'));
    $lastUpdate = $allItems->max('created_at');
@endphp

<div class="nr">

{{-- ══ HEADER + TABS ════════════════════════════════════ --}}
<header class="nr-head">
    <div class="nr-c">
        <h1 class="nr-head__h1">Lucknow Property News</h1>
        <p class="nr-head__sub">LDA, Awas Vikas, IT City and RERA updates that matter if you are buying a plot or flat in Lucknow. Every story is checked against the original report.</p>
        @if($lastUpdate)
            <p class="nr-head__meta">Updated {{ $lastUpdate->format('j M Y') }} · {{ $articles->total() }} stories</p>
        @endif

        <nav class="nr-tabs" aria-label="News categories">
            <div class="nr-tabs__list">
                @foreach($categories as $key => $label)
                    <a href="{{ $key === 'all' ? route('news.index') : route('news.index', ['category' => $key]) }}"
                       class="nr-tab {{ $activeCategory === $key ? 'nr-tab--on' : '' }}"
                       @if($activeCategory === $key) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
            </div>
        </nav>
    </div>
</header>

{{-- ══ MAIN ══════════════════════════════════════════════ --}}
<div class="nr-main">
<div class="nr-c nr-layout">

    <main>
        @if($articles->isEmpty())
            <div class="nr-empty nr-hi">
                <p style="font-size:1.15rem; font-weight:700; color:#0f172a; margin-bottom:6px;">No stories in this category yet</p>
                <p style="font-size:.98rem; color:#64748b; margin-bottom:16px;">See all news or read our guides.</p>
                <a href="{{ route('news.index') }}" class="nr-link">See all news →</a>
            </div>
        @else

            {{-- ── Latest story ───────────────────────── --}}
            @if($lead)
            <article class="nr-lead nr-hi">
                <div class="nr-meta">
                    <span class="nr-tag" style="--c:{{ $catColor[$lead->category] ?? '#64748b' }}">{{ $catLabel[$lead->category] ?? 'News' }}</span>
                    <span class="nr-dot">•</span>
                    <time datetime="{{ $lead->created_at->toIso8601String() }}">{{ $lead->created_at->format('j F Y') }}</time>
                    @if($lead->is_hot)<span class="nr-dot">•</span><span class="nr-hot">Important</span>@endif
                </div>
                <a href="{{ route('news.show', $lead->slug) }}" class="nr-lead__title">{{ $lead->title }}</a>
                <p class="nr-lead__summary">{{ $lead->summary }}</p>
                <div class="nr-meta" style="justify-content:space-between;">
                    <span>@if($lead->source_name) Source: {{ $lead->source_name }} @endif</span>
                    <a href="{{ route('news.show', $lead->slug) }}" class="nr-link">Read full story →</a>
                </div>
            </article>
            @endif

            {{-- ── Stories grouped by day ─────────────── --}}
            @foreach($byDay as $day => $items)
            <section class="nr-day nr-hi">
                <h2 class="nr-day__date">{{ \Carbon\Carbon::parse($day)->format('j F Y') }}</h2>
                <div class="nr-list">
                    @foreach($items as $article)
                    <article class="nr-story">
                        <div class="nr-meta">
                            <span class="nr-tag" style="--c:{{ $catColor[$article->category] ?? '#64748b' }}">{{ $catLabel[$article->category] ?? 'News' }}</span>
                            @if($article->is_hot)<span class="nr-dot">•</span><span class="nr-hot">Important</span>@endif
                            @if($article->source_name)<span class="nr-dot">•</span><span>{{ $article->source_name }}</span>@endif
                        </div>
                        <a href="{{ route('news.show', $article->slug) }}" class="nr-story__title">{{ $article->title }}</a>
                        <p class="nr-story__summary">{{ $article->summary }}</p>
                    </article>
                    @endforeach
                </div>
            </section>

            {{-- On phones the sidebar sits below every story, so the plot cards also show after the first day. --}}
            @if($loop->first)
            <div class="nr-mobile-only" style="margin:0 0 26px;">
                @include('components.plot-sale-cta', ['from' => 'news', 'plain' => true])
            </div>
            @endif
            @endforeach

            @if($articles->hasPages())
                <div style="margin-top:32px;">
                    {{ $articles->appends($activeCategory !== 'all' ? ['category' => $activeCategory] : [])->links('news._pagination') }}
                </div>
            @endif
        @endif
    </main>

    {{-- ══ SIDEBAR ═══════════════════════════════════════ --}}
    <aside class="nr-side nr-hi">
        {{-- Shown by partials/onesignal only when push works here and this browser isn't subscribed yet. --}}
        <div class="nr-box" data-push-ask hidden>
            <p class="nr-box__kicker">Notifications</p>
            <p class="nr-box__title">Get new stories first</p>
            <p class="nr-box__text">Important LDA, Awas Vikas and RERA news, 1–2 times a week, straight to your phone or browser.</p>
            <button type="button" class="nr-cta nr-cta--quiet" onclick="window.dsdPushAsk && window.dsdPushAsk()">🔔 Turn on notifications</button>
        </div>

        @include('components.plot-sale-cta', ['from' => 'news', 'verify' => false, 'plain' => true])

        <div class="nr-box">
            <p class="nr-box__kicker">Property Verification</p>
            <p class="nr-box__title">Get the property checked before you buy</p>
            <ul class="nr-checks">
                <li>Ownership and khatauni check</li>
                <li>LDA / RERA approval and map</li>
                <li>PDF report in 48 hours</li>
            </ul>
            <a href="{{ url('/services/property-verification-lucknow') }}" class="nr-cta" data-cta-kind="verify">Book verification →</a>
        </div>

        <div class="nr-box">
            <p class="nr-box__kicker">Guides</p>
            <ul class="nr-guides">
                <li><a href="{{ url('/lda-schemes') }}">All LDA schemes</a></li>
                <li><a href="{{ url('/blog/saumitra-vihar-yojana-lucknow-2026') }}">Saumitra Vihar guide</a></li>
                <li><a href="{{ url('/blog/it-city-lucknow-lda-plots-guide-2026') }}">IT City plots guide</a></li>
                <li><a href="{{ url('/blog/wellness-city-lucknow-lda-plots-guide-2026') }}">Wellness City plots guide</a></li>
                <li><a href="{{ url('/blog/lda-online-property-verification-lucknow-2026') }}">LDA online verification</a></li>
                <li><a href="{{ url('/blog') }}">All guides →</a></li>
            </ul>
        </div>
    </aside>

</div>
</div>

</div>

{{-- ══ MOBILE BUY / SELL BAR ════════════════════════════ --}}
@include('components.mobile-cta-bar')

@endsection
