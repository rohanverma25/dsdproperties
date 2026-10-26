@extends('layouts.blogs-app')
@php
    $langMap = ['en' => 'en-IN', 'hi' => 'hi-IN'];
    $htmlLang = 'en-IN';
    if (isset($blog) && !empty($blog->language)) {
        $htmlLang = $langMap[$blog->language] ?? 'en-IN';
    } elseif (isset($news) && !empty($news->language)) {
        $htmlLang = $langMap[$news->language] ?? 'en-IN';
    }
    $wordCount = str_word_count(strip_tags($blog->content_html ?? ''));
    $readTime  = max(1, ceil($wordCount / 200));
@endphp
@section('title', $blog->title)
@section('lang', $htmlLang)
@section('meta_description', $blog->meta_description)
@section('meta_keywords', $blog->meta_keywords)
@section('og_image', asset($blog->featured_image))

@push('faq_schema')
    @if(!empty($blog->seo_schema))
        {{-- Editors sometimes paste the schema with its own <script> wrapper; nesting it breaks the JSON. --}}
        <script type="application/ld+json">{!! trim(preg_replace('#</?script[^>]*>#i', '', $blog->seo_schema)) !!}</script>
    @endif
@endpush

@push('main_schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": { "@type": "WebPage", "@id": "{{ url()->current() }}" },
  "headline": {!! json_encode(Str::limit(html_entity_decode(strip_tags($blog->title)), 110, ''), JSON_UNESCAPED_UNICODE) !!},
  "description": {!! json_encode(Str::limit(html_entity_decode(strip_tags($blog->meta_description ?? $blog->content_html)), 160, ''), JSON_UNESCAPED_UNICODE) !!},
  "image": { "@type": "ImageObject", "url": "{{ $blog->featured_image }}", "width": 1200, "height": 630 },
  "author": {
    "@type": "Person",
    "name": "{{ e($author['name'] ?? 'DSD Properties') }}",
    "url": "https://dsdproperties.in/about",
    "worksFor": { "@type": "Organization", "name": "DSD Properties" }
  },
  "publisher": {
    "@type": "Organization",
    "name": "DSD Properties",
    "logo": { "@type": "ImageObject", "url": "{{ asset('logo/image911.png') }}", "width": 600, "height": 60 }
  },
  "datePublished": "{{ $blog->created_at->toIso8601String() }}",
  "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
  "keywords": "{{ e($blog->meta_keywords ?? '') }}",
  "wordCount": {{ $wordCount }},
  "inLanguage": "{{ $blog->language === 'hi' ? 'hi-IN' : 'en-IN' }}",
  "url": "{{ url()->current() }}"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
    { "@type": "ListItem", "position": 2, "name": "Blog", "item": "{{ url('/blog') }}" },
    { "@type": "ListItem", "position": 3, "name": {!! json_encode(Str::limit(html_entity_decode(strip_tags($blog->title)), 110, ''), JSON_UNESCAPED_UNICODE) !!}, "item": "{{ url()->current() }}" }
  ]
}
</script>
@endpush

@php
    use League\CommonMark\CommonMarkConverter;
    $converter = new CommonMarkConverter();
    $html = $converter->convertToHtml($blog->content_html);
@endphp

@section('content')
<style>
/* ── Reading Progress Bar ── */
#bs-progress {
    position:fixed; top:0; left:0; height:3px; width:0%;
    background:linear-gradient(90deg,#FF5C00,#ff8840);
    z-index:9999; transition:width .1s linear;
}


/* ── Article wrapper ── */
.bs-article {
    background:var(--card-bg,#fff);
    border:1px solid var(--border-color,#e5e7eb);
    border-radius:16px; overflow:hidden;
    box-shadow:0 4px 24px rgba(0,0,0,.06);
}
@media(max-width:1023px) {
    .bs-article {
        margin:0 -8px;
        border-radius:0;
        border-left:none;
        border-right:none;
        box-shadow:none;
    }
    .bs-related {
        margin-left:-8px;
        margin-right:-8px;
    }
}

/* ── Featured image ── */
.bs-hero-img {
    width:100%; max-height:480px; overflow:hidden;
    position:relative;
}
.bs-hero-img img {
    width:100%; height:100%; object-fit:cover;
    object-position:top left; display:block;
    max-height:480px;
}

/* ── Meta bar ── */
.bs-meta {
    display:flex; align-items:center; gap:16px; flex-wrap:wrap;
    font-size:.78rem; color:var(--text-tertiary,#9ca3af);
    padding:18px 28px 0; font-family:'Poppins',sans-serif;
}
.bs-meta-item { display:flex; align-items:center; gap:5px; }
.bs-meta svg { flex-shrink:0; }
@media(max-width:640px){ .bs-meta { padding:14px 16px 0; } }

/* ── Tags ── */
.bs-tags { display:flex; flex-wrap:wrap; gap:8px; padding:14px 28px 0; }
.bs-tag {
    font-size:.72rem; font-weight:600; padding:4px 12px;
    border-radius:99px; background:rgba(0,128,128,.08);
    border:1px solid rgba(0,128,128,.2); color:#008080;
    font-family:'Poppins',sans-serif;
}
@media(max-width:640px){ .bs-tags { padding:12px 16px 0; } }

/* ── Article body ── */
.bs-body { padding:24px 28px 32px; }
@media(max-width:640px){ .bs-body { padding:16px 16px 24px; } }

/* ── H1 title ── */
.bs-title {
    font-size:clamp(1.45rem,3vw,2rem); font-weight:800;
    color:var(--text-primary,#111827); line-height:1.25;
    margin:6px 0 14px; font-family:'Poppins',sans-serif;
}
@media(max-width:640px){ .bs-title { font-size:1.35rem; line-height:1.3; margin:2px 0 12px; } }

/* ── Title actions: language switch + share, one row ── */
.bs-title-actions {
    display:flex; align-items:center; flex-wrap:wrap; gap:10px 14px;
    margin-bottom:14px;
}
.bs-title-actions .bs-share { margin-left:auto; }
@media(max-width:640px){
    .bs-title-actions { gap:10px; margin-bottom:12px; }
    .bs-title-actions .bs-share { margin-left:0; }
}

/* ── Language switcher ── */
.bs-lang-switch {
    display:inline-flex; align-items:center; gap:7px;
    padding:7px 14px; border-radius:99px; text-decoration:none;
    font-size:.8rem; font-weight:600; font-family:'Poppins',sans-serif;
    background:rgba(0,128,128,.08); border:1px solid rgba(0,128,128,.25);
    color:#008080; transition:all .2s;
}
.bs-lang-switch:hover { background:rgba(0,128,128,.15); color:#008080; text-decoration:none; }
.bs-lang-switch svg { flex-shrink:0; }

/* ── Share buttons (components/blog-share) ── */
.bs-share-row { display:flex; align-items:center; flex-wrap:wrap; gap:8px; }
.bs-share-btn {
    display:inline-flex; align-items:center; justify-content:center; gap:6px;
    height:36px; padding:0 14px; border-radius:99px;
    border:1px solid var(--border-color,#e5e7eb); background:var(--card-bg,#fff);
    color:#4b5563; font-size:.78rem; font-weight:600; font-family:'Poppins',sans-serif;
    text-decoration:none; cursor:pointer; transition:all .18s;
}
.bs-share-btn:hover { text-decoration:none; transform:translateY(-1px); box-shadow:0 3px 10px rgba(0,0,0,.08); }
.bs-share-copy:hover { color:#008080; border-color:#008080; }
.bs-share-copy.is-done { color:#008080; border-color:#008080; }
.bs-share--full {
    margin:28px 0 8px; padding:18px 20px; border-radius:14px;
    background:rgba(0,128,128,.05); border:1px solid rgba(0,128,128,.18);
}
.bs-share-heading {
    margin:0 0 12px; font-size:.95rem; font-weight:700;
    color:var(--text-primary,#111827); font-family:'Poppins',sans-serif;
}
@media(max-width:640px){ .bs-share--full { padding:14px 14px; } }

/* ── FAQ styles ── */
.faq-ol-class { list-style:none; padding:0; margin:0; counter-reset:faq-counter; }
.faq-li-class {
    background:#f9fbfd; margin-bottom:1rem; padding:1.2rem 1.5rem;
    border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.05);
    transition:all .3s ease; border-left:4px solid #008080;
    position:relative; counter-increment:faq-counter; cursor:pointer;
    font-size:1rem; font-weight:600; color:#011f4b;
}
.faq-li-class:hover { transform:translateY(-2px); box-shadow:0 5px 15px rgba(0,0,0,.1); background:#fff; }
.faq-li-class p { margin-top:.5rem; font-size:.9rem; line-height:1.6; color:#555; font-weight:400; }
/* FAQs whose question is a .faq-q div (posts 138, 139): one flat card with a +/− toggle,
   instead of the padded card-inside-a-card the generic rule above produces. */
.faq-li-class:has(> .faq-q) { padding:0; background:#fff; box-shadow:none; }
.faq-li-class:has(> .faq-q):hover { transform:none; box-shadow:0 3px 10px rgba(0,0,0,.06); }
.faq-li-class > .faq-q { position:relative; padding-right:46px !important; font-size:15px; line-height:1.5; }
.faq-li-class > .faq-q::after {
    content:'+'; position:absolute; right:18px; top:50%; transform:translateY(-50%);
    font-size:22px; font-weight:400; color:#008080; line-height:1;
}
.faq-li-class:has(> .faq-q + p[style*="block"]) > .faq-q::after { content:'−'; }
.faq-li-class > .faq-q + p { margin-top:0; font-size:15px; line-height:1.75; border-top:1px solid #e0e6ed; }
@media(max-width:640px){ .faq-li-class > .faq-q { font-size:14.5px; padding:13px 44px 13px 14px !important; } }
/* Questions that carry their own .faq-toggle icon (post 138): hide the duplicate icon added above */
.faq-li-class > .faq-q:has(.faq-toggle)::after { content:none; }
.faq-li-class > .faq-q:has(.faq-toggle) { padding-right:18px !important; }
.faq-li-class > .faq-q + .faq-a { font-size:15px; line-height:1.75; font-weight:400; color:#444; border-top:1px solid #e0e6ed; }
.content-area .dsd-plot-card .dsd-plot-size,
.blog-content .dsd-plot-card .dsd-plot-size { color:#fff!important; font-size:20px!important; font-weight:700!important; }
.content-area .dsd-plot-card .dsd-plot-sqft,
.blog-content .dsd-plot-card .dsd-plot-sqft { color:#20B2AA!important; font-size:13px!important; font-weight:600!important; }
.content-area .dsd-plot-card .dsd-plot-unit,
.blog-content .dsd-plot-card .dsd-plot-unit { color:rgba(255,255,255,.75)!important; font-size:11px!important; }
.content-area .dsd-stat-num,.blog-content .dsd-stat-num { color:#20B2AA!important; font-size:24px!important; font-weight:700!important; }
.content-area .dsd-stat-label,.blog-content .dsd-stat-label { color:rgba(255,255,255,.65)!important; font-size:11px!important; }
@media(max-width:768px){ .dsd-stats-bar{display:none!important} }

/* ── Author box ── */
.bs-author {
    display:flex; align-items:flex-start; gap:16px;
    background:var(--bg-secondary,#f3f4f6);
    border:1px solid var(--border-color,#e5e7eb);
    border-radius:14px; padding:20px; margin-top:32px;
    position:relative; overflow:hidden;
}
.bs-author::before {
    content:''; position:absolute; left:0; top:0; bottom:0;
    width:4px; background:linear-gradient(to bottom,#011f4b,#008080);
}
.bs-author-ico {
    width:48px; height:48px; border-radius:50%; flex-shrink:0;
    background:linear-gradient(135deg,#011f4b,#008080);
    display:flex; align-items:center; justify-content:center;
    font-size:18px; color:#fff; font-weight:700; font-family:'Poppins',sans-serif;
}
.bs-author-name { font-size:.95rem; font-weight:700; color:var(--text-primary,#111827); margin:0 0 2px; }
.bs-author-role { font-size:.72rem; font-weight:600; color:#008080; text-transform:uppercase; letter-spacing:.8px; margin:0 0 8px; }
.bs-author-bio  { font-size:.83rem; color:var(--text-secondary,#4b5563); line-height:1.72; margin:0; }

/* ── Disclaimer ── */
.bs-disclaimer {
    background:var(--bg-secondary,#f9fafb);
    border:1px solid var(--border-color,#e5e7eb);
    border-left:4px solid #FF5C00;
    border-radius:10px; padding:14px 16px;
    font-size:.78rem; color:var(--text-secondary,#4b5563);
    line-height:1.65; margin-top:28px;
}

/* ── Comment form ── */
.bs-comment-box {
    background:var(--card-bg,#fff);
    border:1px solid var(--border-color,#e5e7eb);
    border-radius:14px; padding:24px; margin-top:20px;
}
.bs-comment-box h4 {
    font-size:.95rem; font-weight:700; color:var(--text-primary);
    margin:0 0 16px; font-family:'Poppins',sans-serif;
}
.bs-input {
    width:100%; border:1.5px solid var(--border-color,#e5e7eb);
    border-radius:9px; padding:11px 14px;
    font-size:.85rem; color:var(--text-primary); background:var(--card-bg);
    font-family:'Poppins',sans-serif; transition:border-color .2s; box-sizing:border-box;
}
.bs-input:focus { outline:none; border-color:#008080; }
.bs-submit {
    padding:11px 24px; border-radius:9px; border:none; cursor:pointer;
    background:linear-gradient(135deg,#FF5C00,#ff8840); color:#fff;
    font-size:.85rem; font-weight:700; font-family:'Poppins',sans-serif;
    transition:all .22s; box-shadow:0 4px 14px rgba(255,92,0,.28);
}
.bs-submit:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(255,92,0,.38); }

/* ── Related posts ── */
.bs-related {
    padding:72px 0 80px;
    background:var(--color-light-teal,#e0f2f1);
    margin-top:48px;
}
.bs-rel-head { text-align:center; margin-bottom:40px; }
.bs-rel-label { font-size:10px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#008080; margin-bottom:8px; }
.bs-rel-title { font-size:clamp(1.4rem,2.5vw,1.9rem); font-weight:800; color:var(--text-primary,#111827); line-height:1.2; }

.bs-rel-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; max-width:1100px; margin:0 auto; padding:0 24px; }
@media(max-width:900px){ .bs-rel-grid{ grid-template-columns:1fr 1fr; } }
@media(max-width:520px){ .bs-rel-grid{ grid-template-columns:1fr; } }

.bs-rel-card {
    background:var(--card-bg,#fff); border:1px solid var(--border-color,#e5e7eb);
    border-radius:14px; overflow:hidden;
    display:flex; flex-direction:column;
    transition:transform .25s, box-shadow .25s, border-color .25s;
    text-decoration:none; position:relative;
}
.bs-rel-card::before {
    content:''; position:absolute; top:0; left:0;
    width:3px; height:0;
    background:linear-gradient(to bottom,#008080,#FF5C00);
    transition:height .3s;
}
.bs-rel-card:hover::before { height:100%; }
.bs-rel-card:hover { transform:translateY(-4px); box-shadow:0 14px 36px rgba(0,0,0,.1); border-color:rgba(0,128,128,.25); text-decoration:none; }

.bs-rel-img { height:160px; overflow:hidden; }
.bs-rel-img img { width:100%; height:100%; object-fit:cover; object-position:top left; transition:transform .4s; }
.bs-rel-card:hover .bs-rel-img img { transform:scale(1.05); }
.bs-rel-img-placeholder {
    width:100%; height:160px;
    background:linear-gradient(135deg,#011f4b,#008080);
    display:flex; align-items:center; justify-content:center;
}

.bs-rel-body { padding:16px; flex:1; display:flex; flex-direction:column; }
.bs-rel-date { font-size:.7rem; color:var(--text-tertiary,#9ca3af); margin-bottom:8px; display:flex; align-items:center; gap:4px; }
.bs-rel-name {
    font-size:.86rem; font-weight:700; color:var(--text-primary,#111827);
    line-height:1.38; margin:0 0 12px; flex:1;
    display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;
}
.bs-rel-link {
    font-size:.78rem; font-weight:600; color:#FF5C00;
    display:inline-flex; align-items:center; gap:5px; margin-top:auto;
}

.bs-rel-cta { text-align:center; margin-top:36px; }
.bs-rel-btn {
    display:inline-flex; align-items:center; gap:8px;
    padding:13px 28px; border-radius:11px;
    background:linear-gradient(135deg,#FF5C00,#ff8840); color:#fff;
    font-size:.88rem; font-weight:700; font-family:'Poppins',sans-serif;
    text-decoration:none; box-shadow:0 5px 18px rgba(255,92,0,.28);
    transition:all .22s;
}
.bs-rel-btn:hover { transform:translateY(-2px); box-shadow:0 8px 26px rgba(255,92,0,.4); color:#fff; text-decoration:none; }
</style>

{{-- Reading progress bar --}}
<div id="bs-progress"></div>


<article class="bs-article">

    {{-- Featured Image --}}
    @if($blog->featured_image)
    <div class="bs-hero-img">
        <img src="{{ asset($blog->featured_image) }}"
             alt="{{ $blog->title }}"
             fetchpriority="high" width="1200" height="630">
    </div>
    @endif

    {{-- Meta bar --}}
    <div class="bs-meta">
        <span class="bs-meta-item">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Updated: {{ $blog->updated_at->format('M d, Y') }}
        </span>
        <span class="bs-meta-item">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $readTime }} min read
        </span>
        @if($blog->tag)
        <span class="bs-meta-item" style="color:#008080;font-weight:600;">
            {{ $blog->tag }}
        </span>
        @endif
        <span class="bs-meta-item" style="margin-left:auto;">
            <a href="{{ url('/blog') }}" style="display:inline-flex;align-items:center;gap:5px;font-size:.75rem;font-weight:600;color:#008080;text-decoration:none;">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                All Articles
            </a>
        </span>
    </div>

    {{-- Tags --}}
    @php $tags = is_array($blog->tags) ? $blog->tags : explode(',', $blog->tags ?? ''); @endphp
    @if(!empty($tags) && $tags[0] != '')
    <div class="bs-tags">
        @foreach($tags as $tag)
            @if(trim($tag))
            <span class="bs-tag">#{{ trim($tag) }}</span>
            @endif
        @endforeach
    </div>
    @endif

    <div class="bs-body">

        {{-- Include header component (table CSS + FAQ script) --}}
        @include('components.blogs-header-one', ['blog' => $blog])

        {{-- H1 Title --}}
        <h1 class="bs-title">{{ $blog->title }}</h1>

        {{-- Language switcher + share, one row under the title --}}
        @php
            $altBlog = $blog->alternate_slug
                ? \App\Models\BlogPost::where('slug', $blog->alternate_slug)->first()
                : null;
        @endphp
        <div class="bs-title-actions">
            @if($altBlog)
                {{-- No flag emoji: Windows renders them as the letters "GB"/"IN" --}}
                <a href="{{ route('blog.show', $altBlog->slug) }}" class="bs-lang-switch"
                   hreflang="{{ $altBlog->language === 'hi' ? 'hi' : 'en' }}">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    {{ $blog->language === 'en' ? 'हिंदी में पढ़ें' : 'Read in English' }}
                </a>
            @endif
            @include('components.blog-share', ['blog' => $blog, 'variant' => 'compact'])
        </div>

        {{-- Blog Content --}}
        @php
            $content = $blog->content_html;

            // No-WhatsApp pages: WhatsApp links go to the inquiry form (App\Support\NoWhatsAppPages)
            if (\App\Support\NoWhatsAppPages::active()) {
                $content = \App\Support\NoWhatsAppPages::cleanContent($content);
            }

            // Consultation button shortcode: {{CONSULTATION_BUTTON}} or {{CONSULTATION_BUTTON:custom text}}
            $content = preg_replace_callback(
                '/\{\{CONSULTATION_BUTTON(?::(.*?))?\}\}/',
                function ($matches) {
                    $text = !empty($matches[1]) ? trim($matches[1]) : 'REQUEST A CONSULTATION TODAY!';
                    return view('components.consultation-button', ['text' => $text, 'url' => request()->getRequestUri()])->render();
                },
                $content
            );

            // Property slider shortcode:
            //   <div data-property-slider="it-city"></div>
            //   <div data-property-slider="it-city,wellness-city" data-slider-title="My Title"></div>
            if (stripos($content, 'data-property-slider') !== false) {
                $content = preg_replace_callback(
                    '/<div[^>]+data-property-slider=(["\']|&quot;)(.*?)\1[^>]*>.*?<\/div>/si',
                    function ($matches) {
                        try {
                            $raw      = html_entity_decode($matches[2], ENT_QUOTES);
                            $tagSlugs = array_values(array_filter(array_map(
                                function ($t) { return \Illuminate\Support\Str::slug(trim($t)); },
                                explode(',', $raw)
                            )));
                            if (empty($tagSlugs)) return '<!-- property-slider: empty tag list -->';

                            $customTitle = null;
                            if (preg_match('/data-slider-title=(["\']|&quot;)(.*?)\1/', $matches[0], $tm)) {
                                $customTitle = html_entity_decode(trim($tm[2]), ENT_QUOTES);
                            }

                            $properties = \App\Models\PropertyListing::published()
                                ->whereHas('tags', function ($q) use ($tagSlugs) {
                                    $q->whereIn('slug', $tagSlugs);
                                })
                                ->with('images')
                                ->orderByDesc('created_at')
                                ->limit(10)
                                ->get();

                            if ($properties->isEmpty()) {
                                return '<!-- property-slider: no published properties found for [' . implode(',', $tagSlugs) . '] -->';
                            }

                            return view('components.property-slider', [
                                'properties' => $properties,
                                'tags'       => $tagSlugs,
                                'title'      => $customTitle,
                            ])->render();
                        } catch (\Exception $e) {
                            return '<!-- property-slider error: ' . htmlspecialchars($e->getMessage()) . ' -->';
                        }
                    },
                    $content
                );
            }

            // Gallery shortcode: [gallery:some-slug]
            if (stripos($content, '[gallery:') !== false) {
                $content = preg_replace_callback(
                    '/\[gallery:([a-z0-9\-]+)\]/i',
                    function ($matches) {
                        $gallery = \App\Models\Gallery::where('slug', $matches[1])->with('images')->first();
                        if (!$gallery) {
                            return '<!-- gallery not found: ' . htmlspecialchars($matches[1]) . ' -->';
                        }
                        return view('components.gallery-section', ['gallery' => $gallery])->render();
                    },
                    $content
                );
            }
        @endphp
        <div class="blog-content prose max-w-none hindi-content">
            {!! $content !!}
        </div>

        @include('components.blog-share', ['blog' => $blog, 'variant' => 'full'])

        {{-- Disclaimer --}}
        <div class="bs-disclaimer">
            <strong style="color:var(--text-primary);">Disclaimer:</strong> The information on this website is shared for general awareness about property and real estate, collected from various reports and news sources. While we strive to provide accurate and updated details, we do not guarantee the completeness, accuracy, or reliability of the content. We are not responsible for any financial, legal, or property-related decisions made based on this information. For accurate details, please verify with the concerned authorities before proceeding.
        </div>

        {{-- Author Box --}}
        @if(isset($author) && $author)
        <div class="bs-author">
            <div class="bs-author-ico">{{ strtoupper(substr($author['name'] ?? 'D', 0, 1)) }}</div>
            <div style="flex:1;min-width:0;">
                <p class="bs-author-name">{{ $author['name'] }}</p>
                <p class="bs-author-role">Author · DSD Properties</p>
                <p class="bs-author-bio">{{ $author['description'] }}</p>
            </div>
        </div>
        @endif

        {{-- Approved Comments --}}
        @if($approvedComments->isNotEmpty())
        <div class="bs-comment-box" style="margin-top:28px;">
            <h4 style="margin-bottom:20px;">
                💬 {{ $approvedComments->count() }} {{ Str::plural('Comment', $approvedComments->count()) }}
            </h4>
            @foreach($approvedComments as $c)
            <div style="padding:16px 0;border-bottom:1px solid var(--border-color,#e5e7eb);{{ $loop->last ? 'border-bottom:none;' : '' }}">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                    <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#011f4b,#008080);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($c->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:.88rem;font-weight:700;color:var(--text-primary,#111827);">{{ e($c->name) }}</div>
                        <div style="font-size:.72rem;color:#94a3b8;">{{ $c->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <p style="font-size:.85rem;color:var(--text-secondary,#4b5563);line-height:1.7;margin:0;padding-left:46px;">{{ e($c->comment) }}</p>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Comment Form --}}
        <div class="bs-comment-box" style="margin-top:20px;">
            <h4>Leave a Comment</h4>
            <div id="comment-success" style="display:none;padding:14px 16px;background:#d1fae5;border:1px solid #6ee7b7;border-radius:9px;color:#065f46;font-size:.85rem;font-weight:600;margin-bottom:14px;">
                ✓ Thank you! Your comment has been submitted and is awaiting moderation.
            </div>
            <form id="comment_form" class="space-y-3"
                  action="{{ route('blog.comment.store', $blog->slug) }}"
                  method="POST">
                @csrf
                <textarea name="comment" rows="4" placeholder="Your comment…" class="bs-input" required style="resize:vertical;margin-bottom:10px;"></textarea>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <input type="text"  name="name"  placeholder="Name *"     class="bs-input" required style="flex:1;min-width:140px;">
                    <input type="email" name="email" placeholder="Email *"    class="bs-input" required style="flex:1;min-width:140px;">
                    <button type="submit" id="comment-submit" class="bs-submit">Post Comment</button>
                </div>
                <div id="comment-error" style="display:none;font-size:.78rem;color:#dc2626;margin-top:6px;"></div>
            </form>
        </div>

    </div>{{-- end .bs-body --}}
</article>

{{-- Google Reviews --}}
@include('components.google-reviews', ['googleReviews' => $googleReviews])

{{-- Related Posts --}}
<section class="bs-related">
    <div class="bs-rel-head">
        <p class="bs-rel-label">Keep Reading</p>
        <h2 class="bs-rel-title">Related Articles</h2>
    </div>

    <div class="bs-rel-grid">
        @foreach($relatedPosts as $relatedPost)
        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="bs-rel-card">
            @if($relatedPost->featured_image)
            <div class="bs-rel-img">
                <img src="{{ asset($relatedPost->featured_image) }}"
                     alt="{{ $relatedPost->title }}"
                     width="400" height="160" loading="lazy">
            </div>
            @else
            <div class="bs-rel-img-placeholder">
                <svg width="36" height="36" fill="none" stroke="rgba(255,255,255,.35)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"/></svg>
            </div>
            @endif
            <div class="bs-rel-body">
                <div class="bs-rel-date">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $relatedPost->created_at->format('M d, Y') }}
                </div>
                <p class="bs-rel-name">{{ $relatedPost->title }}</p>
                <span class="bs-rel-link">
                    Read More
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </div>
        </a>
        @endforeach
    </div>

    <div class="bs-rel-cta">
        <a href="{{ route('blog.index') }}" class="bs-rel-btn">
            View All Articles
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

<script>
// Reading progress
(function () {
    var bar = document.getElementById('bs-progress');
    if (!bar) return;
    window.addEventListener('scroll', function () {
        var doc  = document.documentElement;
        var top  = doc.scrollTop  || document.body.scrollTop;
        var h    = doc.scrollHeight - doc.clientHeight;
        bar.style.width = (h > 0 ? (top / h * 100) : 0) + '%';
    }, { passive: true });
})();

// Comment form
document.addEventListener('DOMContentLoaded', function () {
    var form    = document.getElementById('comment_form');
    var success = document.getElementById('comment-success');
    var errBox  = document.getElementById('comment-error');
    var submit  = document.getElementById('comment-submit');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        errBox.style.display = 'none';
        errBox.textContent   = '';
        submit.disabled      = true;
        submit.textContent   = 'Posting…';

        fetch(form.action, {
            method:  'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept':       'application/json',
            },
            body: new FormData(form),
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            submit.disabled    = false;
            submit.textContent = 'Post Comment';
            if (data.success) {
                form.reset();
                success.style.display = 'block';
                success.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                var msgs = [];
                if (data.errors) {
                    Object.values(data.errors).forEach(function (m) { msgs.push(m[0]); });
                }
                errBox.textContent   = msgs.length ? msgs.join(' ') : (data.message || 'Something went wrong. Please try again.');
                errBox.style.display = 'block';
            }
        })
        .catch(function () {
            submit.disabled      = false;
            submit.textContent   = 'Post Comment';
            errBox.textContent   = 'Submission failed. Please check your connection and try again.';
            errBox.style.display = 'block';
        });
    });
});
</script>
@endsection
