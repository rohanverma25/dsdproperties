{{--
    resources/views/news/show.blade.php
    URL: /news/{slug}
    FIXED: All arbitrary Tailwind [#hex] classes replaced with inline styles.
    Works on shared hosting with pre-compiled Tailwind CSS.
--}}

@extends('layouts.app-article')

@section('seo')
    <title>{{ $article->title }} | DSD Properties Lucknow</title>
    <meta name="description" content="{{ $article->meta_description }}">
    <link rel="canonical"    href="{{ $article->url }}">
    <meta name="robots"      content="index, follow">

    <meta property="og:type"                   content="article">
    <meta property="og:title"                  content="{{ $article->title }}">
    <meta property="og:description"            content="{{ $article->meta_description }}">
    <meta property="og:url"                    content="{{ $article->url }}">
    <meta property="og:site_name"              content="DSD Properties">
    <meta property="og:image"                  content="{{ asset('images/og-news.png') }}">
    <meta property="article:published_time"    content="{{ $article->created_at->toIso8601String() }}">
    <meta property="article:section"           content="{{ $article->category_label }}">
    <meta name="twitter:card"                  content="summary_large_image">
    <meta name="twitter:title"                 content="{{ $article->title }}">
    <meta name="twitter:description"           content="{{ $article->meta_description }}">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": "{{ addslashes($article->title) }}",
        "description": "{{ addslashes($article->meta_description) }}",
        "url": "{{ $article->url }}",
        "datePublished": "{{ $article->created_at->toIso8601String() }}",
        "dateModified":  "{{ $article->updated_at->toIso8601String() }}",
        "articleSection": "{{ $article->category_label }}",
        "publisher": {
            "@type": "Organization",
            "name": "DSD Properties",
            "url":  "{{ url('/') }}",
            "logo": { "@type": "ImageObject", "url": "{{ asset('images/logo.webp') }}" }
        },
        "mainEntityOfPage": { "@type": "WebPage", "@id": "{{ $article->url }}" }
        @if($article->source_url)
        ,"isBasedOn": {
            "@type": "NewsArticle",
            "url": "{{ $article->source_url }}",
            "publisher": { "@type": "Organization", "name": "{{ $article->source_name }}" }
        }
        @endif
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
            { "@type": "ListItem", "position": 2, "name": "News", "item": "{{ route('news.index') }}" },
            { "@type": "ListItem", "position": 3, "name": "{{ addslashes(Str::limit($article->title, 60)) }}", "item": "{{ $article->url }}" }
        ]
    }
    </script>

    <style>
        /* ── Category tag colours (--c from NewsArticle::CATEGORIES) ── */
        .news-tag { color:var(--c); background:color-mix(in srgb, var(--c) 8%, #fff); border-color:color-mix(in srgb, var(--c) 30%, #fff); }

        /* ── Article body typography ──────────────────────── */
        /* Stories are Hindi: Hind body text a size up, Poppins for Devanagari headings. */
        .article-body        { font-family:'Plus Jakarta Sans','Hind',sans-serif; }
        .article-body p      { margin-bottom: 1.25rem; line-height: 1.85; color: #334155; font-size: 1.05rem; }
        .article-body h2     { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size: 1.3rem; font-weight: 700; color: #0f172a; margin: 2rem 0 .75rem; }
        .article-body h3     { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 1.5rem 0 .5rem; }
        .article-body ul     { list-style: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .article-body ol     { list-style: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .article-body li     { margin-bottom: .45rem; color: #334155; font-size: 1.02rem; line-height: 1.75; }

        /* ── Share row + end-of-story links ───────────────── */
        .story-share { display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin:-6px 0 22px; }
        .story-share__lbl { font-size:.78rem; font-weight:600; color:#94a3b8; }
        .story-share__btn { display:inline-flex; align-items:center; gap:6px; padding:6px 12px; border-radius:999px; font-size:.8rem; font-weight:700;
                            text-decoration:none !important; border:1px solid #e2e8f0; background:#fff; color:#0b1e5b !important; cursor:pointer; transition:border-color .15s; }
        .story-share__btn:hover { border-color:#0b1e5b; }
        .story-share__btn--wa { background:#25D366; border-color:#25D366; color:#fff !important; }
        .story-share__btn--wa:hover { border-color:#128C7E; background:#128C7E; }
        .story-more { display:flex; gap:10px; flex-wrap:wrap; margin-top:20px; }
        .story-more a { display:inline-flex; align-items:center; gap:6px; padding:10px 16px; border-radius:12px; font-size:.88rem; font-weight:700;
                        text-decoration:none !important; border:1px solid #e2e8f0; background:#fff; color:#0b1e5b !important; transition:border-color .15s; }
        .story-more a:hover { border-color:#0b1e5b; }
        .article-body a      { color: #1d4ed8; text-decoration: underline; }
        .article-body strong { color: #111827; font-weight: 600; }
        .article-body table  { width:100%; border-collapse:collapse; margin-bottom:1.25rem; font-size:.88rem; }
        .article-body th,
        .article-body td     { border:1px solid #e5e7eb; padding:.55rem .75rem; text-align:left; }
        .article-body th     { background:#f9fafb; font-weight:600; color:#111827; }

        /* ── Mobile buy/sell bar ──────────────────────────── */
        .mob-cta-bar{display:none;position:fixed;bottom:0;left:0;right:0;z-index:9999;padding:10px 14px;background:#fff;border-top:1px solid #e5e7eb;box-shadow:0 -4px 18px rgba(0,0,0,.12);gap:10px}
        @media(max-width:1023px){.mob-cta-bar{display:flex}body{padding-bottom:72px}}
        .mob-cta-bar a{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:13px 10px;border-radius:10px;font-weight:700;font-size:.88rem;text-decoration:none;letter-spacing:.1px;transition:opacity .15s}
        .mob-cta-bar a:hover{opacity:.88;text-decoration:none}
        .mob-cta-buy{background:linear-gradient(135deg,#25D366,#128C7E);color:#fff !important}
        .mob-cta-sell{background:linear-gradient(135deg,#011f4b,#013870);color:#fff !important}

        /* ── Related article hover ────────────────────────── */
        .related-link { display:block; text-decoration:none; padding:12px 0;
                        border-bottom:1px solid #f3f4f6; }
        .related-link:last-child { border-bottom:none; }
        .related-link:hover .related-title { color:#0f1f5c; }
        .related-title { font-size:.85rem; font-weight:600; color:#111827;
                         line-height:1.4; transition:color .2s; }

        /* page bottom padding behind sticky bar */
        .show-page { padding-bottom: 80px; }
            .sticky-sidebar {
            position: sticky;
            z-index: 40;
        }
    </style>
@endsection

{{-- Plus Jakarta Sans has no Devanagari, so Hindi fell back to each device's own font.
     Mukta (same as the /news index) covers Hindi; English letters keep Plus Jakarta Sans. --}}
@push('head')
<link href="https://fonts.googleapis.com/css2?family=Mukta:wght@400;500;600;700;800&family=Poppins:wght@600;700&family=Hind:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>body{font-family:'Plus Jakarta Sans','Mukta',sans-serif;}</style>
@endpush

@section('content')

{{-- ══ BREADCRUMB ══════════════════════════════════════ --}}
<div style="background:#f9fafb; border-bottom:1px solid #e5e7eb;">
    <div style="max-width:900px; margin:0 auto; padding:10px 16px;">
        <nav style="font-size:.75rem; color:#6b7280; display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
            <a href="{{ url('/') }}"
               style="color:#6b7280; text-decoration:none;"
               onmouseover="this.style.color='#0f1f5c'"
               onmouseout="this.style.color='#6b7280'">Home</a>
            <span>›</span>
            <a href="{{ route('news.index') }}"
               style="color:#6b7280; text-decoration:none;"
               onmouseover="this.style.color='#0f1f5c'"
               onmouseout="this.style.color='#6b7280'">News</a>
            <span>›</span>
            <a href="{{ route('news.index', ['category' => $article->category]) }}"
               style="color:#6b7280; text-decoration:none;"
               onmouseover="this.style.color='#0f1f5c'"
               onmouseout="this.style.color='#6b7280'">{{ $article->category_label }}</a>
            <span>›</span>
            <span style="color:#374151; font-weight:500;">{{ Str::limit($article->title, 50) }}</span>
        </nav>
    </div>
</div>

{{-- ══ ARTICLE + SIDEBAR ═══════════════════════════════ --}}
<div class="show-page" style="max-width:1080px; margin:0 auto; padding:32px 16px;">
    <div style="display:grid; grid-template-columns:1fr; gap:32px;">

        {{-- On large screens: 2-col layout --}}
        <style>
            @media(min-width:1024px){
                .show-grid { grid-template-columns: 1fr 300px !important; }
            }
        </style>

        <div class="show-grid" style="display:grid; grid-template-columns:1fr; gap:32px;">

            {{-- ── MAIN ARTICLE ────────────────────────── --}}
            <article>

                {{-- Meta row: category tag + date + source --}}
                <div style="display:flex; flex-wrap:wrap; align-items:center; gap:8px; margin-bottom:16px;">

                    <span class="news-tag" style="--c:{{ $article->category_color }}; font-size:.7rem; font-weight:700; padding:3px 12px;
                                 border-radius:999px; border-width:1px; border-style:solid;">
                        {{ $article->category_label }}
                    </span>

                    @if($article->is_hot)
                        <span style="font-size:.68rem; font-weight:700; background:#fff5f5; color:#ef4444;
                                     border:1px solid #fecaca; padding:3px 10px; border-radius:999px;">
                            🔥 HOT
                        </span>
                    @endif

                    <span style="font-size:.75rem; color:#9ca3af;">
                        {{ $article->created_at->format('M j, Y') }}
                    </span>

                    @if($article->source_name)
                        <span style="font-size:.75rem; color:#9ca3af;">
                            · Source: {{ $article->source_name }}
                        </span>
                    @endif
                </div>

                {{-- H1 --}}
                <h1 style="font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:clamp(1.45rem,3.5vw,2.05rem); font-weight:700; color:#0f172a;
                            line-height:1.4; margin-bottom:20px;">
                    {{ $article->title }}
                </h1>

                {{-- Share: readers forward these stories on WhatsApp groups --}}
                <div class="story-share">
                    <span class="story-share__lbl">Share:</span>
                    <a class="story-share__btn story-share__btn--wa" target="_blank" rel="noopener" data-cta-kind="share-whatsapp"
                       href="https://wa.me/?text={{ rawurlencode($article->title.' '.$article->url) }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 005.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.9 0-3.18-1.24-6.17-3.48-8.41A11.82 11.82 0 0012.05 0zm5.42 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.13-.28-.2-.57-.35z"/></svg>
                        WhatsApp
                    </a>
                    <button type="button" class="story-share__btn"
                            onclick="navigator.clipboard && navigator.clipboard.writeText('{{ $article->url }}').then(() => { this.textContent = 'Link copied ✓'; })">
                        Copy link
                    </button>
                </div>

                {{-- Quick Summary box --}}
                <div style="background:#eff6ff; border-left:4px solid #0f1f5c; border-radius:0 12px 12px 0;
                             padding:16px 20px; margin-bottom:28px;">
                    <p style="font-size:.75rem; font-weight:700; color:#0f1f5c;
                               text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">
                        Quick Summary
                    </p>
                    <p style="font-family:'Plus Jakarta Sans','Hind',sans-serif; font-size:1.02rem; color:#1e293b; line-height:1.75; margin:0;">
                        {{ $article->summary }}
                    </p>
                </div>

                {{-- Full article body --}}
                <div class="article-body">
                     {!! $article->full_content !!}
                </div>

                {{-- Plot sales + verification CTA; a story about one of the three schemes puts that scheme first --}}
                @php
                    $ctaFocus = collect(['saumitra' => 'saumitra', 'it-city' => 'it-city', 'wellness' => 'wellness'])
                        ->first(fn ($k, $needle) => str_contains($article->slug, $needle));
                @endphp
                <div style="margin-top:28px;">
                    @include('components.plot-sale-cta', ['focus' => $ctaFocus, 'from' => 'news/'.$article->slug])
                </div>

                {{-- Source attribution --}}
                @if($article->source_url)
                    <div style="margin-top:28px; padding-top:16px; border-top:1px solid #e5e7eb;">
                        <p style="font-size:.75rem; color:#9ca3af;">
                            Source:
                            <a href="{{ $article->source_url }}" target="_blank" rel="noopener noreferrer"
                               style="color:#2563eb; text-decoration:underline;">
                                {{ $article->source_name ?? $article->source_url }}
                            </a>
                            &nbsp;— Facts checked against the original reports by DSD Properties.
                        </p>
                    </div>
                @endif

                <div class="story-more">
                    <a href="{{ route('news.index') }}">← All news</a>
                    @if(isset(\App\Models\NewsArticle::CATEGORIES[$article->category]))
                        <a href="{{ route('news.index', ['category' => $article->category]) }}">More {{ $article->category_label }} news →</a>
                    @endif
                </div>

            </article>

            {{-- ── SIDEBAR ──────────────────────────────── --}}
            <aside>
                <div class="sticky-sidebar">
                    @include('components.inquiry-form')
                </div>
                {{-- Related Articles --}}
                @if($related->count() > 0)
                    <div style="margin-top:20px; background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:20px;">
                        <h4 style="font-size:.85rem; font-weight:700; color:#111827; margin-bottom:16px;">
                            Related Articles
                        </h4>
                        @foreach($related as $item)
                            <a href="{{ route('news.show', $item->slug) }}" class="related-link">
                                <div style="display:flex; align-items:center; gap:6px; margin-bottom:5px; flex-wrap:wrap;">
                                    <span class="news-tag"
                                          style="--c:{{ $item->category_color }}; font-size:.62rem; font-weight:700; padding:2px 8px;
                                                 border-radius:999px; border-width:1px; border-style:solid;">
                                        {{ $item->category_label }}
                                    </span>
                                    <span style="font-size:.7rem; color:#9ca3af;">
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="related-title">{{ Str::limit($item->title, 75) }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif

            </aside>

        </div>
    </div>
</div>

{{-- ══ MOBILE BUY / SELL BAR ════════════════════════════ --}}
@include('components.mobile-cta-bar', ['ctaSlug' => $article->slug ?? null])

@push('scripts')
<script>
    const stickySidebar = document.querySelector('.sticky-sidebar');
    if (stickySidebar) {
        const header = document.querySelector('.sticky-header');
        const headerHeight = header ? header.offsetHeight : 0;
        stickySidebar.style.top = (headerHeight + 85) + 'px';
        window.addEventListener('resize', function() {
            const newHeaderHeight = header ? header.offsetHeight : 0;
            stickySidebar.style.top = (newHeaderHeight + 85) + 'px';
        });
    }
</script>
@endpush

@endsection