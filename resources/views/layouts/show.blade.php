
@extends('layouts.blogs-app')
@php
    $langMap = [
        'en' => 'en-IN',
        'hi' => 'hi-IN',
    ];

    $htmlLang = 'en-IN'; // default

    if (isset($blog) && !empty($blog->language)) {
        $htmlLang = $langMap[$blog->language] ?? 'en-IN';
    } elseif (isset($news) && !empty($news->language)) {
        $htmlLang = $langMap[$news->language] ?? 'en-IN';
    }
@endphp
@section('title', $blog->title)
@section('lang', $htmlLang)
@section('meta_description', $blog->meta_description)
@section('meta_keywords', $blog->meta_keywords)
@section('og_image', asset($blog->featured_image))

@push('faq_schema')
    @if(!empty($blog->seo_schema))
        <script type="application/ld+json">
            {!! $blog->seo_schema !!}
        </script>
    @endif
@endpush
@push('main_schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url()->current() }}"
  },
"headline": {!! json_encode(Str::limit(html_entity_decode(strip_tags($blog->title)), 110, ''), JSON_UNESCAPED_UNICODE) !!},
"description": {!! json_encode(Str::limit(html_entity_decode(strip_tags($blog->meta_description ?? $blog->content_html)), 160, ''), JSON_UNESCAPED_UNICODE) !!},
  "image": {
    "@type": "ImageObject",
    "url": "{{ $blog->featured_image }}",
    "width": 1200,
    "height": 630
  },
  "author": {
    "@type": "Person",
    "name": "{{ e($author['name'] ?? 'DSD Properties') }}",
    "url": "https://dsdproperties.in/about",
    "worksFor": {
      "@type": "Organization",
      "name": "DSD Properties"
    }
  },
  "publisher": {
    "@type": "Organization",
    "name": "DSD Properties",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('logo/image911.png') }}",
      "width": 600,
      "height": 60
    }
  },
  "datePublished": "{{ $blog->created_at->toIso8601String() }}",
  "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
  "keywords": "{{ e($blog->meta_keywords ?? '') }}",
  "wordCount": {{ str_word_count(strip_tags($blog->content_html ?? '')) }},
  "inLanguage": "{{$blog->language === 'hi' ? 'hi-IN' : 'en-IN' }}",
  "url": "{{ url()->current() }}"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Blog",
      "item": "{{ url('/blog') }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name":  {!! json_encode(Str::limit(html_entity_decode(strip_tags($blog->title)), 110, ''), JSON_UNESCAPED_UNICODE) !!},
      "item": "{{ url()->current() }}"
    }
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
<style>/* FAQ List */
.faq-ol-class {
  list-style: none;
  padding: 0;
  margin: 0;
  counter-reset: faq-counter;
}

/* FAQ Item */
.faq-li-class {
  background: #f9fbfd;
  margin-bottom: 1rem;
  padding: 1.2rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
  border-left: 5px solid #008080;
  position: relative;
  counter-increment: faq-counter;
  cursor: pointer;
}

/* Numbering */
.faq-li-class::before {
  content: counter(faq-counter) ".";
  font-weight: 700;
  color: #008080;
  position: absolute;
  left: -2rem;
  top: 1.2rem;
  font-size: 1.1rem;
}

/* Hover Effect */
.faq-li-class:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  background: #ffffff;
}

/* Question */
.faq-li-class {
  font-size: 1.1rem;
  font-weight: 600;
  color: #011f4b;
}

/* Answer */
.faq-li-class p {
  margin-top: 0.5rem;
  font-size: 0.95rem;
  line-height: 1.6;
  color: #555;
  font-weight: 400;
}
/* ── Plot card text — force override content-area global rules ── */
.content-area .dsd-plot-card .dsd-plot-size,
.blog-content .dsd-plot-card .dsd-plot-size {
    color: #ffffff !important;
    font-size: 20px !important;
    font-weight: 700 !important;
}

.content-area .dsd-plot-card .dsd-plot-sqft,
.blog-content .dsd-plot-card .dsd-plot-sqft {
    color: #20B2AA !important;
    font-size: 13px !important;
    font-weight: 600 !important;
}

.content-area .dsd-plot-card .dsd-plot-unit,
.blog-content .dsd-plot-card .dsd-plot-unit {
    color: rgba(255,255,255,0.75) !important;
    font-size: 11px !important;
}
/* ── Stats bar — force override content-area global rules ── */
.content-area .dsd-stat-num,
.blog-content .dsd-stat-num {
    color: #20B2AA !important;
    font-size: 24px !important;
    font-weight: 700 !important;
}

.content-area .dsd-stat-label,
.blog-content .dsd-stat-label {
    color: rgba(255, 255, 255, 0.65) !important;
    font-size: 11px !important;
}

/* ── Plot cards ── */
.content-area .dsd-plot-card .dsd-plot-size,
.blog-content .dsd-plot-card .dsd-plot-size {
    color: #ffffff !important;
    font-weight: 700 !important;
}

.content-area .dsd-plot-card .dsd-plot-sqft,
.blog-content .dsd-plot-card .dsd-plot-sqft {
    color: #20B2AA !important;
    font-weight: 600 !important;
}

.content-area .dsd-plot-card .dsd-plot-unit,
.blog-content .dsd-plot-card .dsd-plot-unit {
    color: rgba(255, 255, 255, 0.75) !important;
}
</style>
<article class="bg-card rounded-xl card-shadow overflow-hidden">
    <!-- Blog Header -->
    @include('components.blogs-header-one', ['blog' => $blog])
    
    <!-- Featured Image -->
    @if($blog->featured_image)
    <div class="w-full h-100 md:h-120 overflow-hidden">
        <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-100" fetchpriority="high" width="1200" height="630">
    </div>
    @endif
    <div class="p-6 md:p-4">
    <span class="flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
    </svg>
    Updated: {{ $blog->updated_at->format('M d, Y') }}
  </span>
    <!-- Blog Content -->
    
        <!-- Tags -->
        @php $tags = explode(',', $blog->tags); @endphp
        @if(!empty($tags) && $tags[0] != '')
        <div class="ml-1 flex flex-wrap gap-2 mb-6">
            @foreach($tags as $tag)
                <span class="tag">#{{ trim($tag) }}</span>
            @endforeach
        </div>
        @endif
        
        <!-- Blog Title -->
        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $blog->title }}</h1>
        
        @php
            $content = $blog->content_html;

            $content = preg_replace_callback(
                '/\{\{CONSULTATION_BUTTON(?::(.*?))?\}\}/',
                function ($matches) {
                    $text = !empty($matches[1])
                        ? trim($matches[1])
                        : 'REQUEST A CONSULTATION TODAY!';

                    return view('components.consultation-button', [
                        'text' => $text,
                        'url'  => request()->getRequestUri()
                    ])->render();
                },
                $content
            );
        @endphp
        @if($blog->alternate_slug)
            @php
                $altBlog = \App\Models\BlogPost::where('slug', $blog->alternate_slug)->first();
            @endphp
            @if($altBlog)
            <div class="text-right px-4 py-2 text-sm pb-2">
                @if($blog->language === 'en')
                    <a href="{{ route('blog.show', $altBlog->slug) }}"
                    class="inline-flex items-center gap-1 text-teal-700 hover:underline font-medium">
                        🇮🇳 हिंदी में पढ़ें
                    </a>
                @else
                    <a href="{{ route('blog.show', $altBlog->slug) }}"
                    class="inline-flex items-center gap-1 text-teal-700 hover:underline font-medium">
                        HI Read in English
                    </a>
                @endif
            </div>
            @endif
        @endif
        <div class="blog-content prose max-w-none hindi-content">
            {!! $content !!}
        </div>


        <!-- Blog Footer -->
        @include('components.blogs-footer-one')
    </div>
</article>

<!-- Related Posts Section -->
<section class="mt-24 bg-gray-50 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <!-- Heading -->
        <div class="text-center mb-14">
            <h3 class="text-3xl font-bold text-accent">Related Articles</h3>
            <p class="mt-2 text-gray-600">Explore more insights from Lucknow’s real estate market</p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4 items-stretch">
            @foreach($relatedPosts as $relatedPost)
            <div class="related-post group bg-green-50 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col h-full">
                @if($relatedPost->featured_image)
                <div class="overflow-hidden">
                    <img src="{{ asset($relatedPost->featured_image) }}" 
                         alt="{{ $relatedPost->title }}" 
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" width="400" height="192" loading="lazy">
                </div>
                @endif
                <div class="p-6 flex flex-col flex-grow">
                    <h4 class="text-lg font-semibold mb-3 leading-snug">
                        <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                           class="hover:text-primary transition">
                           {{ $relatedPost->title }}
                        </a>
                    </h4>
                    <div class="mt-auto flex items-center text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-4 w-4 mr-2 text-secondary" 
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                   d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $relatedPost->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- CTA -->
        <!-- <div class="text-center mt-16">
            <a href="{{ route('blog.index') }}" 
               class="inline-block bg-primary text-white font-semibold px-8 py-4 rounded-lg shadow hover:bg-accent transition">
               View All Articles
            </a>
        </div>
    </div> -->
</section>
@endsection