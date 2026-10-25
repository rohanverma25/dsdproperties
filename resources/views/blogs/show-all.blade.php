@extends('layouts.user-app')
@php
    $catLabel = $category ? ucwords(str_replace('-', ' ', $category)) : null;
@endphp
@section('title', $catLabel
    ? $catLabel . ' Articles | DSD Properties Blog — Lucknow Real Estate'
    : 'Real Estate Blog — Lucknow Property Insights | DSD Properties')
@section('meta_description', $catLabel
    ? 'Browse ' . $catLabel . ' articles on Lucknow real estate — expert tips, investment guides, property market insights by DSD Properties.'
    : 'Expert articles on Lucknow real estate — buying tips, investment guides, RERA regulations, market trends and property insights by DSD Properties.')
@section('meta_keywords', $catLabel
    ? strtolower($catLabel) . ', lucknow real estate blog, property guide lucknow, real estate investment lucknow'
    : 'lucknow real estate blog, property tips lucknow, real estate investment lucknow, RERA lucknow, property market insights')

@push('head')
{{-- Canonical for category/search pages --}}
@if($category || request('search'))
<link rel="canonical" href="{{ url('/blog') . ($category ? '?category='.urlencode($category) : '') }}">
@endif

{{-- OG image: use first post's image if available --}}
@if($blog->count() && $blog->first()->featured_image)
<meta property="og:image" content="{{ $blog->first()->featured_image }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
@endif
<meta property="og:type" content="website" />

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "{{ $catLabel ? $catLabel.' Articles — DSD Properties Blog' : 'Real Estate Blog — DSD Properties' }}",
  "description": "Expert articles on Lucknow real estate — buying tips, investment guides, RERA regulations, market trends and property insights.",
  "url": "{{ url('/blog') . ($category ? '?category='.urlencode($category) : '') }}",
  "inLanguage": "en-IN",
  "publisher": {
    "@type": "Organization",
    "name": "DSD Properties",
    "url": "{{ url('/') }}",
    "logo": { "@type": "ImageObject", "url": "{{ asset('images/logo.webp') }}" }
  },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@type": "ListItem", "position": 2, "name": "Blog", "item": "{{ url('/blog') }}" }
      @if($catLabel)
      ,{ "@type": "ListItem", "position": 3, "name": "{{ $catLabel }}", "item": "{{ url('/blog?category='.urlencode($category)) }}" }
      @endif
    ]
  },
  "mainEntity": {
    "@type": "ItemList",
    "itemListElement": [
      @foreach($blog as $i => $post)
      {
        "@type": "ListItem",
        "position": {{ ($blog->currentPage() - 1) * $blog->perPage() + $i + 1 }},
        "url": "{{ url('/blog/'.$post->slug) }}",
        "name": "{{ addslashes($post->title) }}"
      }{{ !$loop->last ? ',' : '' }}
      @endforeach
    ]
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
    { "@type": "ListItem", "position": 2, "name": "Blog", "item": "{{ url('/blog') }}" }
    @if($catLabel)
    ,{ "@type": "ListItem", "position": 3, "name": "{{ $catLabel }}", "item": "{{ url('/blog?category='.urlencode($category)) }}" }
    @endif
  ]
}
</script>
@endpush

@section('content')
<style>
:root {
    --b-navy:#011f4b; --b-teal:#008080; --b-orange:#FF5C00;
    --b-t1:var(--text-primary,#111827); --b-t2:var(--text-secondary,#4b5563);
    --b-t3:var(--text-tertiary,#9ca3af);
    --b-card:var(--card-bg,#fff); --b-border:var(--border-color,#e5e7eb);
    --b-bg:var(--bg-primary,#fff); --b-bg2:var(--bg-secondary,#f3f4f6);
    --b-teal-bg:var(--color-light-teal,#e0f2f1);
}

/* ── font ── */
.bp { font-family:'Poppins',sans-serif; overflow-x:hidden; }
.bp-c { max-width:1100px; margin:0 auto; padding:0 24px; }

/* ── scroll reveal ── */
@keyframes bp-up { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:none} }
.bp-rv { opacity:0; transform:translateY(22px); transition:opacity .6s ease, transform .6s ease; transition-delay:var(--rd,0s); }
.bp-rv.visible { opacity:1; transform:none; }

/* ── HERO ── */
.bp-hero {
    position:relative; overflow:hidden;
    background:linear-gradient(135deg,#011f4b 0%,#013870 45%,#005f6b 100%);
    padding:88px 0 72px;
}
.bp-hero__grid {
    position:absolute; inset:0;
    background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
                     linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
    background-size:50px 50px;
}
@keyframes bp-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
.bp-orb {
    position:absolute; border-radius:50%; filter:blur(90px); pointer-events:none;
}
.bp-orb--a { width:500px;height:500px;background:rgba(0,128,128,.22);top:-120px;right:-80px;animation:bp-float 9s ease-in-out infinite; }
.bp-orb--b { width:340px;height:340px;background:rgba(255,92,0,.13);bottom:-60px;left:-60px;animation:bp-float 11s ease-in-out infinite 3s; }

.bp-hero__inner { position:relative; z-index:2; text-align:center; }

.bp-hero__badge {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.18);
    border-radius:99px; padding:6px 16px; margin-bottom:20px;
    font-size:11px; font-weight:500; color:rgba(255,255,255,.82);
    backdrop-filter:blur(8px);
}
.bp-hero__badge span { width:7px;height:7px;border-radius:50%;background:#4ade80;display:inline-block; }

.bp-hero__h1 {
    font-size:clamp(2rem,4.5vw,3.2rem); font-weight:800; color:#fff;
    line-height:1.13; margin-bottom:16px; letter-spacing:-.4px;
}
.bp-hero__h1 em { font-style:normal; color:#FF5C00; }

.bp-hero__sub {
    font-size:.95rem; color:rgba(255,255,255,.68);
    line-height:1.8; max-width:520px; margin:0 auto 32px;
}

/* stats strip */
.bp-hero__stats {
    display:flex; justify-content:center; gap:40px; flex-wrap:wrap;
    margin-top:36px; padding-top:32px;
    border-top:1px solid rgba(255,255,255,.1);
}
.bp-hero__stat-val { font-size:1.6rem; font-weight:800; color:#fff; line-height:1; }
.bp-hero__stat-val em { font-style:normal; color:#FF5C00; }
.bp-hero__stat-lbl { font-size:.72rem; color:rgba(255,255,255,.5); margin-top:4px; text-transform:uppercase; letter-spacing:1px; }

/* ── SECTION LABELS ── */
.bp-slabel { font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--b-teal);margin-bottom:10px; }
.bp-stitle { font-size:clamp(1.5rem,2.8vw,2.1rem);font-weight:800;color:var(--b-t1);line-height:1.18;margin-bottom:10px; }
.bp-ssub   { font-size:.88rem;color:var(--b-t2);max-width:520px;margin:0 auto 48px;line-height:1.75; }


/* ── FEATURED CARD ── */
.bp-featured {
    background:var(--b-card); border:1px solid var(--b-border);
    border-radius:20px; overflow:hidden;
    box-shadow:0 8px 40px rgba(0,0,0,.07);
    display:grid; grid-template-columns:1fr 1fr; max-width:960px; margin:0 auto;
}
@media(max-width:700px){ .bp-featured{grid-template-columns:1fr} }
.bp-featured__img { position:relative; min-height:260px; overflow:hidden; }
.bp-featured__img img { width:100%; height:100%; object-fit:cover; object-position:top left; display:block; transition:transform .5s; }
.bp-featured:hover .bp-featured__img img { transform:scale(1.04); }
.bp-featured__tag {
    position:absolute; top:16px; left:16px;
    background:var(--b-orange); color:#fff;
    padding:4px 12px; border-radius:99px; font-size:.72rem; font-weight:700;
}
.bp-featured__new {
    position:absolute; top:16px; right:16px;
    background:rgba(1,31,75,.85); color:#fff;
    padding:4px 12px; border-radius:99px; font-size:.72rem; font-weight:700;
}
.bp-featured__body { padding:36px 32px; display:flex; flex-direction:column; justify-content:center; }
@media(max-width:700px){ .bp-featured__body{padding:24px} }
.bp-featured__label { font-size:.7rem; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--b-teal); margin-bottom:12px; }
.bp-featured__title { font-size:1.35rem; font-weight:800; color:var(--b-t1); line-height:1.3; margin-bottom:14px; }
.bp-featured__desc  { font-size:.86rem; color:var(--b-t2); line-height:1.72; margin-bottom:24px; flex-grow:1; }
.bp-featured__meta  { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
.bp-featured__author{ font-size:.8rem; color:var(--b-t3); }
.bp-featured__author strong { display:block; color:var(--b-t1); font-weight:600; font-size:.84rem; }
.bp-btn {
    display:inline-flex; align-items:center; gap:8px;
    font-family:'Poppins',sans-serif; font-weight:600; border-radius:10px;
    text-decoration:none; cursor:pointer; transition:all .22s; border:none;
    padding:11px 22px; font-size:.84rem;
    background:linear-gradient(135deg,#FF5C00,#ff8840); color:#fff;
    box-shadow:0 5px 18px rgba(255,92,0,.28);
}
.bp-btn:hover { transform:translateY(-2px); box-shadow:0 8px 26px rgba(255,92,0,.4); color:#fff; text-decoration:none; }

/* ── BLOG CARDS ── */
.bp-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:22px; }
@media(max-width:900px){ .bp-grid{grid-template-columns:1fr 1fr} }
@media(max-width:580px){ .bp-grid{grid-template-columns:1fr} }

.bp-card {
    background:var(--b-card); border:1px solid var(--b-border);
    border-radius:16px; overflow:hidden;
    display:flex; flex-direction:column;
    transition:transform .25s, box-shadow .25s, border-color .25s;
    position:relative;
}
.bp-card::before {
    content:''; position:absolute; top:0; left:0;
    width:3px; height:0;
    background:linear-gradient(to bottom,var(--b-teal),var(--b-orange));
    transition:height .3s;
}
.bp-card:hover::before { height:100%; }
.bp-card:hover { transform:translateY(-5px); box-shadow:0 16px 44px rgba(0,0,0,.09); border-color:rgba(0,128,128,.22); }

.bp-card__img { position:relative; height:210px; overflow:hidden; }
.bp-card__img img { width:100%; height:100%; object-fit:cover; object-position:top left; transition:transform .5s; }
.bp-card:hover .bp-card__img img { transform:scale(1.05); }
.bp-card__tag {
    position:absolute; top:12px; right:12px;
    background:rgba(1,31,75,.82); color:#fff;
    padding:4px 11px; border-radius:99px; font-size:.68rem; font-weight:700; z-index:2;
}
.bp-card__new {
    position:absolute; top:12px; left:12px;
    background:#FF5C00; color:#fff;
    padding:4px 11px; border-radius:99px; font-size:.68rem; font-weight:700; z-index:2;
}

.bp-card__body { padding:20px; display:flex; flex-direction:column; flex:1; }
.bp-card__meta { display:flex; align-items:center; gap:14px; margin-bottom:10px; }
.bp-card__date { font-size:.72rem; color:var(--b-t3); }
.bp-card__read { display:flex; align-items:center; gap:4px; font-size:.72rem; color:var(--b-t3); }
.bp-card__title {
    font-size:.95rem; font-weight:700; color:var(--b-t1);
    line-height:1.4; margin-bottom:10px;
    text-decoration:none; display:block;
    transition:color .2s;
}
.bp-card__title:hover { color:var(--b-teal); }
.bp-card__desc { font-size:.8rem; color:var(--b-t2); line-height:1.68; margin-bottom:16px; flex:1; }
.bp-card__link {
    display:inline-flex; align-items:center; gap:6px;
    font-size:.8rem; font-weight:600; color:var(--b-orange);
    text-decoration:none; margin-top:auto; transition:gap .2s;
}
.bp-card__link:hover { gap:10px; text-decoration:none; color:var(--b-orange); }

/* ── POPULAR ── */
.bp-popular {
    display:flex; align-items:center; gap:16px;
    background:var(--b-card); border:1px solid var(--b-border);
    border-radius:14px; overflow:hidden;
    transition:transform .22s, box-shadow .22s, border-color .22s;
}
.bp-popular:hover { transform:translateY(-3px); box-shadow:0 10px 28px rgba(0,0,0,.07); border-color:rgba(0,128,128,.2); }
.bp-popular__img { width:110px; height:100px; flex-shrink:0; overflow:hidden; }
.bp-popular__img img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.bp-popular:hover .bp-popular__img img { transform:scale(1.06); }
.bp-popular__body { padding:14px 16px 14px 0; }
.bp-popular__tag { font-size:.68rem; font-weight:700; color:var(--b-teal); text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; }
.bp-popular__title { font-size:.86rem; font-weight:700; color:var(--b-t1); line-height:1.4; margin-bottom:8px; }
.bp-popular__link { font-size:.78rem; font-weight:600; color:var(--b-orange); text-decoration:none; }
.bp-popular__link:hover { text-decoration:underline; }

/* ── PAGINATION ── */
.bp-pagination { display:flex; justify-content:center; margin-top:48px; }

/* ── WAVE ── */
.bp-wave { line-height:0; }
.bp-wave svg { display:block; width:100%; }
</style>

{{-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ --}}
<section class="bp bp-hero">
    <div class="bp-hero__grid"></div>
    <div class="bp-orb bp-orb--a"></div>
    <div class="bp-orb bp-orb--b"></div>

    <div class="bp-c bp-hero__inner">
        <div class="bp-hero__badge">
            <span></span> Updated Weekly — Lucknow Real Estate Insights
        </div>

        <h1 class="bp-hero__h1">
            Lucknow <em>Real Estate</em> Blog
        </h1>
        <p class="bp-hero__sub">
            Expert articles on buying, investing &amp; understanding the Lucknow property market — written by local consultants, backed by data.
        </p>

        {{-- Search --}}
        <div id="blog-search-wrapper" style="position:relative;margin:0 auto;max-width:560px;width:100%;padding:0 16px;box-sizing:border-box;">
            <div style="display:flex;width:100%;box-shadow:0 8px 32px rgba(0,0,0,.22);border-radius:9999px;">
                <input
                    type="text"
                    id="blog-search-input"
                    value="{{ $search ?? '' }}"
                    placeholder="Search articles, topics, keywords…"
                    autocomplete="off"
                    style="flex:1;min-width:0;padding:14px 22px;border-radius:9999px 0 0 9999px;border:none;outline:none;font-size:16px;font-family:'Poppins',sans-serif;color:#1f2937;width:100%;"
                >
                <button type="button" id="blog-search-btn"
                    style="padding:14px 24px;border-radius:0 9999px 9999px 0;border:none;cursor:pointer;font-size:.88rem;font-weight:700;font-family:'Poppins',sans-serif;color:#fff;white-space:nowrap;flex-shrink:0;background:linear-gradient(135deg,#FF5C00,#ff8840);">
                    Search
                </button>
            </div>

            {{-- Dropdown --}}
            <div id="blog-search-dropdown"
                 style="position:absolute;left:16px;right:16px;background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.18);margin-top:8px;overflow:hidden;z-index:50;display:none;">
                <div id="blog-search-results"></div>
                <div id="blog-search-loading" style="display:none;padding:16px;text-align:center;font-size:14px;color:#6b7280;font-family:'Poppins',sans-serif;">Searching…</div>
                <div id="blog-search-empty"   style="display:none;padding:16px;text-align:center;font-size:14px;color:#6b7280;font-family:'Poppins',sans-serif;">No results found.</div>
            </div>
        </div>

        @if(!empty($search))
        <p style="margin-top:14px;font-size:.82rem;color:rgba(255,255,255,.65);">
            Results for: <strong style="color:#fff;">"{{ $search }}"</strong> &mdash;
            <a href="{{ route('blog.index') }}" style="color:rgba(255,255,255,.65);text-decoration:underline;">Clear</a>
        </p>
        @endif

        {{-- Category Filter Pills --}}
        @if(!empty($allTags))
        <div style="display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:20px;" role="navigation" aria-label="Blog categories">
            <a href="{{ route('blog.index') }}"
               style="display:inline-block;padding:6px 18px;border-radius:99px;font-size:.78rem;font-weight:600;font-family:'Poppins',sans-serif;text-decoration:none;transition:all .2s;
                      {{ !$category ? 'background:#fff;color:#011f4b;' : 'background:rgba(255,255,255,.15);color:rgba(255,255,255,.85);border:1px solid rgba(255,255,255,.3);' }}">
                All Posts
            </a>
            @foreach($allTags as $tag)
            <a href="{{ route('blog.index', ['category' => $tag]) }}"
               style="display:inline-block;padding:6px 18px;border-radius:99px;font-size:.78rem;font-weight:600;font-family:'Poppins',sans-serif;text-decoration:none;transition:all .2s;
                      {{ $category === $tag ? 'background:#FF5C00;color:#fff;border:1px solid #FF5C00;' : 'background:rgba(255,255,255,.15);color:rgba(255,255,255,.85);border:1px solid rgba(255,255,255,.3);' }}">
                {{ ucwords(str_replace('-', ' ', $tag)) }}
            </a>
            @endforeach
        </div>
        @endif

        {{-- Stats --}}
        <div class="bp-hero__stats">
            <div>
                <div class="bp-hero__stat-val">50<em>+</em></div>
                <div class="bp-hero__stat-lbl">Articles</div>
            </div>
            <div>
                <div class="bp-hero__stat-val">8<em>+</em></div>
                <div class="bp-hero__stat-lbl">Topics</div>
            </div>
            <div>
                <div class="bp-hero__stat-val">10<em>+</em></div>
                <div class="bp-hero__stat-lbl">Expert Authors</div>
            </div>
            <div>
                <div class="bp-hero__stat-val">100<em>%</em></div>
                <div class="bp-hero__stat-lbl">Free to Read</div>
            </div>
        </div>
    </div>

    <div class="bp-wave">
        <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 56L1440 56L1440 28C1200 0 960 0 720 28C480 56 240 56 0 28L0 56Z" fill="var(--bg-primary,#fff)"/>
        </svg>
    </div>
</section>


{{-- ════════════════════════════════════════
     FEATURED POST
════════════════════════════════════════ --}}
<section class="bp" style="padding:72px 0 48px;background:var(--bg-primary);">
    <div class="bp-c">
        <div class="text-center mb-10 bp-rv" style="--rd:.05s">
            <p class="bp-slabel">Editor's Pick</p>
            <h2 class="bp-stitle">Featured Article</h2>
        </div>

        <div class="bp-featured bp-rv" style="--rd:.15s">
            <div class="bp-featured__img">
                <img src="https://dsdproperties.in/public/images/blogs/lucknow-real-estate-2026-2027.png"
                     alt="Lucknow Real Estate Market 2026-2027">
                <div class="bp-featured__tag">Market Trends</div>
                <div class="bp-featured__new">FEATURED</div>
            </div>
            <div class="bp-featured__body">
                <p class="bp-featured__label">In-depth Analysis</p>
                <h2 class="bp-featured__title">Lucknow Real Estate Market 2026–2027</h2>
                <p class="bp-featured__desc">
                    Planning to buy property in Lucknow in 2026? Read the verified price forecast, SCR infrastructure update, top 7 hotspots &amp; investment safety checklist from our expert team.
                </p>
                <div class="bp-featured__meta">
                    <div class="bp-featured__author">
                        <strong>Anjali Singh</strong>
                        <span>Mar 4, 2026 &nbsp;·&nbsp; 8 min read</span>
                    </div>
                    <a href="{{ url('blog/lucknow-investment-hotspots-2026') }}" class="bp-btn">
                        Read Article
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     BLOG GRID
════════════════════════════════════════ --}}
<section class="bp" style="padding:48px 0 80px;background:var(--color-light-teal,#e0f2f1);">
    <div class="bp-c">
        <div class="text-center mb-12 bp-rv" style="--rd:.05s">
            @if(!empty($search))
                <p class="bp-slabel">Search Results</p>
                <h2 class="bp-stitle">Results for "{{ $search }}"</h2>
            @elseif($catLabel)
                <p class="bp-slabel">{{ $catLabel }}</p>
                <h2 class="bp-stitle">{{ $catLabel }} Articles</h2>
            @else
                <p class="bp-slabel">Latest Articles</p>
                <h2 class="bp-stitle">Fresh from the Desk</h2>
            @endif
            <p class="bp-ssub">Explore our most recent insights on the Lucknow property market.</p>
        </div>

        <div class="bp-grid">
            @forelse ($blog as $post)
            @php
                $wordCount = $post->content_html ? str_word_count(strip_tags($post->content_html)) : 1000;
                $readTime  = max(1, ceil($wordCount / 200));
            @endphp
            <div class="bp-card bp-rv" style="--rd:{{ $loop->index * 0.07 }}s">
                <div class="bp-card__img">
                    @if($post->featured_image)
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" loading="lazy">
                    @else
                    <div style="width:100%;height:100%;background:linear-gradient(135deg,#011f4b,#008080);display:flex;align-items:center;justify-content:center;">
                        <svg width="48" height="48" fill="none" stroke="rgba(255,255,255,.4)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                    </div>
                    @endif
                    @if($post->tag)
                    <div class="bp-card__tag">{{ $post->tag }}</div>
                    @endif
                    @if($loop->first)
                    <div class="bp-card__new">NEW</div>
                    @endif
                </div>
                <div class="bp-card__body">
                    <div class="bp-card__meta">
                        <span class="bp-card__date">{{ $post->created_at->format('M d, Y') }}</span>
                        <span class="bp-card__read">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $readTime }} min read
                        </span>
                    </div>
                    <a href="{{ route('blog.show', $post->slug) }}" class="bp-card__title">{{ $post->title }}</a>
                    <p class="bp-card__desc">{{ Str::limit(strip_tags($post->meta_description ?? ''), 115) }}</p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="bp-card__link">
                        Read More
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:64px 24px;">
                <div style="width:72px;height:72px;border-radius:50%;background:rgba(0,128,128,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                    <svg width="32" height="32" fill="none" stroke="#008080" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                @if(!empty($search))
                <h3 style="font-size:1.15rem;font-weight:700;color:var(--text-primary);margin-bottom:8px;">No results for "{{ $search }}"</h3>
                <p style="color:var(--text-secondary);font-size:.88rem;margin-bottom:20px;">Try a different keyword or browse all posts.</p>
                <a href="{{ route('blog.index') }}" class="bp-btn" style="display:inline-flex;">View All Posts</a>
                @else
                <h3 style="font-size:1.15rem;font-weight:700;color:var(--text-primary);margin-bottom:8px;">No blog posts yet</h3>
                <p style="color:var(--text-secondary);font-size:.88rem;">Check back soon for new content.</p>
                @endif
            </div>
            @endforelse
        </div>

        <div class="bp-pagination">
            {{ $blog->links('vendor.pagination.dsd') }}
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     NEWSLETTER
════════════════════════════════════════ --}}
<x-newsletter
    title="Subscribe to Our Newsletter"
    description="Get the latest real estate insights and property updates delivered to your inbox."
/>

{{-- ════════════════════════════════════════
     POPULAR ARTICLES
════════════════════════════════════════ --}}
<section class="bp" style="padding:80px 0;background:var(--bg-primary);">
    <div class="bp-c">
        <div class="text-center mb-12 bp-rv" style="--rd:.05s">
            <p class="bp-slabel">Must Read</p>
            <h2 class="bp-stitle">Popular Articles</h2>
            <p class="bp-ssub">Our most-read guides on the Lucknow property market.</p>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;max-width:860px;margin:0 auto;" class="bp-pop-grid">
            <a href="{{ url('/blog/it-city-lucknow-lda-plots-guide-2026') }}" class="bp-popular bp-rv" style="--rd:.1s;text-decoration:none;">
                <div class="bp-popular__img">
                    <img src="https://dsdproperties.in/public/images/blogs/it-city-lucknow-2026.webp?auto=format&fit=crop&w=300&q=80" alt="Top Residential Areas in Lucknow">
                </div>
                <div class="bp-popular__body">
                    <div class="bp-popular__tag">Residential</div>
                    <div class="bp-popular__title">LDA IT City Lucknow</div>
                    <span class="bp-popular__link">Read Article →</span>
                </div>
            </a>

            <a href="{{ url('/blog/understanding-rera-guide-lucknow-property-buyers-C7ECl') }}" class="bp-popular bp-rv" style="--rd:.18s;text-decoration:none;">
                <div class="bp-popular__img">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=300&q=80" alt="RERA Guide Lucknow">
                </div>
                <div class="bp-popular__body">
                    <div class="bp-popular__tag">Legal Guide</div>
                    <div class="bp-popular__title">Understanding RERA Regulations in Uttar Pradesh</div>
                    <span class="bp-popular__link">Read Article →</span>
                </div>
            </a>

            <a href="{{ url('/blog/lda-park-view-apartments-basant-kunj-2026') }}" class="bp-popular bp-rv" style="--rd:.25s;text-decoration:none;">
                <div class="bp-popular__img">
                    <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=300&q=80" alt="LDA Park View Apartments">
                </div>
                <div class="bp-popular__body">
                    <div class="bp-popular__tag">LDA Schemes</div>
                    <div class="bp-popular__title">LDA Park View Apartments — Basant Kunj 2026</div>
                    <span class="bp-popular__link">Read Article →</span>
                </div>
            </a>

            <a href="{{ url('/blog/gomti-nagar-extension-lucknow-guide-2026') }}" class="bp-popular bp-rv" style="--rd:.32s;text-decoration:none;">
                <div class="bp-popular__img">
                    <img src="https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=300&q=80" alt="Gomti Nagar Extension Guide">
                </div>
                <div class="bp-popular__body">
                    <div class="bp-popular__tag">Area Guide</div>
                    <div class="bp-popular__title">Gomti Nagar Extension — Complete Real Estate Guide 2026</div>
                    <span class="bp-popular__link">Read Article →</span>
                </div>
            </a>
        </div>
    </div>
</section>

<style>
@media(max-width:580px){
    .bp-pop-grid { grid-template-columns:1fr !important; }
    .bp-popular__img { width:90px !important; height:90px !important; }
    .bp-hero__stats { gap:24px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── scroll reveal ──
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
    }, { threshold: 0.12 });
    document.querySelectorAll('.bp-rv').forEach(el => observer.observe(el));

    // ── live search ──
    const input     = document.getElementById('blog-search-input');
    const dropdown  = document.getElementById('blog-search-dropdown');
    const results   = document.getElementById('blog-search-results');
    const loading   = document.getElementById('blog-search-loading');
    const empty     = document.getElementById('blog-search-empty');
    const searchBtn = document.getElementById('blog-search-btn');
    let timer = null;

    const showDrop = () => dropdown.style.display = 'block';
    const hideDrop = () => dropdown.style.display = 'none';

    function renderResults(blogs) {
        results.innerHTML = '';
        loading.style.display = 'none';
        if (!blogs.length) { empty.style.display = 'block'; return; }
        empty.style.display = 'none';

        blogs.forEach(blog => {
            const item = document.createElement('a');
            item.href   = '/blog/' + blog.slug;
            item.target = '_blank';
            item.rel    = 'noopener noreferrer';
            item.style.cssText = 'display:flex;align-items:center;gap:12px;padding:12px 16px;text-decoration:none;border-bottom:1px solid #f3f4f6;transition:background .15s;cursor:pointer;font-family:Poppins,sans-serif;';
            item.onmouseover = () => item.style.background = '#f9fafb';
            item.onmouseout  = () => item.style.background = '';

            const imgHtml = blog.featured_image
                ? `<img src="${blog.featured_image}" alt="" style="width:54px;height:54px;object-fit:cover;border-radius:8px;flex-shrink:0;">`
                : `<div style="width:54px;height:54px;border-radius:8px;flex-shrink:0;background:linear-gradient(135deg,#011f4b,#008080);display:flex;align-items:center;justify-content:center;"><svg width="20" height="20" fill="none" stroke="rgba(255,255,255,.5)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"/></svg></div>`;

            const title = `<p style="margin:0;font-size:13px;font-weight:600;color:#111827;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${blog.title}</p>`;
            const desc  = blog.meta_description
                ? `<p style="margin:3px 0 0;font-size:11px;color:#9ca3af;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${blog.meta_description.substring(0, 85)}</p>`
                : '';

            item.innerHTML = imgHtml + `<div style="min-width:0;flex:1;">${title}${desc}</div>`;
            results.appendChild(item);
        });
    }

    function doSearch(q) {
        if (q.length < 2) { hideDrop(); return; }
        results.innerHTML = '';
        empty.style.display   = 'none';
        loading.style.display = 'block';
        showDrop();
        fetch('/api/blogs/search?q=' + encodeURIComponent(q))
            .then(r => r.json())
            .then(d => renderResults(d.results || []))
            .catch(() => { loading.style.display = 'none'; empty.style.display = 'block'; });
    }

    input.addEventListener('input', function () {
        clearTimeout(timer);
        const q = this.value.trim();
        if (q.length < 2) { hideDrop(); return; }
        timer = setTimeout(() => doSearch(q), 300);
    });

    searchBtn.addEventListener('click', () => {
        const q = input.value.trim();
        if (q) window.location.href = '/blog?search=' + encodeURIComponent(q);
    });

    input.addEventListener('keydown', e => {
        if (e.key === 'Enter')  searchBtn.click();
        if (e.key === 'Escape') hideDrop();
    });

    document.addEventListener('click', e => {
        if (!document.getElementById('blog-search-wrapper').contains(e.target)) hideDrop();
    });
});
</script>
@endsection
