@extends('layouts.user-app')
@section('title', $title)
@section('meta_description', $meta_description)

@push('head')
<link rel="canonical" href="{{ url($canonical) }}">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home",       "item": "{{ url('/') }}" },
        { "@type": "ListItem", "position": 2, "name": "Properties", "item": "{{ url('/properties') }}" },
        { "@type": "ListItem", "position": 3, "name": "{{ $breadcrumb_label }}", "item": "{{ url($canonical) }}" }
      ]
    },
    {
      "@type": "CollectionPage",
      "name": "{{ $title }}",
      "description": "{{ $meta_description }}",
      "url": "{{ url($canonical) }}",
      "numberOfItems": {{ $listings->total() }},
      "publisher": {
        "@type": "Organization",
        "name": "DSD Properties",
        "url": "{{ url('/') }}"
      }
    }
    @if(count($faq ?? []))
    ,{
      "@type": "FAQPage",
      "mainEntity": [
        @foreach($faq as $item)
        {
          "@type": "Question",
          "name": "{{ e($item['q']) }}",
          "acceptedAnswer": { "@type": "Answer", "text": "{{ e($item['a']) }}" }
        }{{ $loop->last ? '' : ',' }}
        @endforeach
      ]
    }
    @endif
  ]
}
</script>
<style>
/* ── SEO Landing Page ── */
:root {
  --sl-n:  #011f4b;
  --sl-t:  #008080;
  --sl-or: #FF5C00;
}

/* Hero */
.sl-hero {
  position: relative;
  padding: 52px 20px 80px;
  overflow: hidden;
  color: #fff;
}
.sl-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
}
.sl-hero-inner { max-width: 900px; margin: 0 auto; position: relative; z-index: 1; }
.sl-breadcrumb {
  font-size: 12.5px;
  color: rgba(255,255,255,.65);
  margin-bottom: 14px;
  display: flex;
  align-items: center;
  gap: 6px;
  flex-wrap: wrap;
}
.sl-breadcrumb a { color: rgba(255,255,255,.7); text-decoration: none; }
.sl-breadcrumb a:hover { color: #fff; }
.sl-breadcrumb span { color: rgba(255,255,255,.4); }
.sl-hero h1 {
  font-size: clamp(22px, 4vw, 36px);
  font-weight: 700;
  margin: 0 0 10px;
  line-height: 1.25;
  color: #fff;
}
.sl-hero-sub {
  font-size: 15px;
  color: rgba(255,255,255,.75);
  margin: 0;
}
.sl-count-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,.15);
  border: 1px solid rgba(255,255,255,.25);
  border-radius: 99px;
  padding: 5px 14px;
  font-size: 13px;
  font-weight: 600;
  color: #fff;
  margin-top: 16px;
}

/* Main container */
.sl-container { max-width: 1140px; margin: 0 auto; padding: 0 16px 64px; }

/* Intro card */
.sl-intro {
  background: #fff;
  border-radius: 14px;
  border: 1px solid #e8edf3;
  box-shadow: 0 2px 12px rgba(1,31,75,.05);
  padding: 28px 32px;
  margin: -44px 0 36px;
  position: relative;
  z-index: 5;
}
.sl-intro p {
  font-size: 14.5px;
  line-height: 1.75;
  color: #334155;
  margin: 0 0 14px;
}
.sl-intro p:last-child { margin-bottom: 0; }

/* Property count bar */
.sl-count-bar {
  font-size: 13.5px;
  color: #64748b;
  margin-bottom: 18px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.sl-count-bar strong { color: #011f4b; }
.sl-count-bar .sl-cta-link {
  margin-left: auto;
  font-size: 13px;
  color: var(--sl-t);
  font-weight: 600;
  text-decoration: none;
}
.sl-count-bar .sl-cta-link:hover { text-decoration: underline; }

/* Property grid */
.sl-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 22px;
  margin-bottom: 36px;
}

/* Card */
.sl-card {
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0,0,0,.06);
  border: 1px solid #f1f5f9;
  transition: box-shadow .2s, transform .2s;
  display: flex;
  flex-direction: column;
  position: relative;
}
.sl-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--sl-n), var(--sl-t));
  opacity: 0;
  transition: opacity .25s;
  z-index: 2;
}
.sl-card:hover { box-shadow: 0 8px 28px rgba(1,31,75,.13); transform: translateY(-3px); }
.sl-card:hover::before { opacity: 1; }

.sl-img {
  position: relative;
  height: 210px;
  background: #f1f5f9;
  overflow: hidden;
  flex-shrink: 0;
}
.sl-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s; }
.sl-card:hover .sl-img img { transform: scale(1.04); }
.sl-img-placeholder {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
  font-size: 52px;
}
.sl-img-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to bottom, transparent 35%, rgba(1,31,75,.5) 100%);
  pointer-events: none;
}
.sl-tag {
  position: absolute; top: 10px; left: 10px;
  padding: 3px 10px; border-radius: 99px;
  font-size: 11px; font-weight: 700; letter-spacing: .03em;
}
.sl-tag-sell { background: var(--sl-n); color: #fff; }
.sl-tag-rent { background: var(--sl-t); color: #fff; }
.sl-type-badge {
  position: absolute; bottom: 10px; right: 10px;
  background: rgba(255,255,255,.92);
  backdrop-filter: blur(6px);
  color: var(--sl-n);
  padding: 3px 10px; border-radius: 99px;
  font-size: 10px; font-weight: 700; z-index: 1;
}

.sl-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
.sl-price { font-size: 18px; font-weight: 700; color: var(--sl-or); }
.sl-title { font-size: 14px; font-weight: 600; color: #1a2235; margin: 4px 0 6px; line-height: 1.4; }
.sl-loc  { font-size: 12.5px; color: #64748b; margin-bottom: 10px; display: flex; align-items: center; gap: 4px; }
.sl-divider { height: 1px; background: #f1f5f9; margin: 8px 0; }
.sl-specs { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 12px; }
.sl-spec  { display: flex; align-items: center; gap: 4px; font-size: 12px; color: #475569; }

.sl-foot-btns { display: flex; gap: 8px; margin-top: auto; }
.sl-view-btn {
  flex: 1; padding: 8px 12px; border-radius: 10px;
  font-size: 13px; font-weight: 600; text-decoration: none;
  text-align: center; transition: background .15s;
  display: flex; align-items: center; justify-content: center; gap: 5px;
  background: var(--sl-t); color: #fff;
}
.sl-view-btn:hover { background: #006666; color: #fff; }
.sl-map-btn {
  flex-shrink: 0;
  padding: 8px 11px; border-radius: 10px;
  font-size: 12px; font-weight: 600; text-decoration: none;
  background: #f1f5f9; color: var(--sl-n);
  border: 1.5px solid #e2e8f0;
  display: flex; align-items: center; gap: 4px;
  transition: background .15s;
}
.sl-map-btn:hover { background: #e2e8f0; }

/* Empty state */
.sl-empty { text-align: center; padding: 60px 20px; color: #94a3b8; }
.sl-empty-icon { font-size: 52px; margin-bottom: 12px; }

/* Pagination */
.sl-pagination { display: flex; justify-content: center; gap: 6px; margin: 8px 0 44px; flex-wrap: wrap; }
.sl-pagination a, .sl-pagination span {
  padding: 7px 14px; border-radius: 8px; font-size: 13.5px;
  border: 1.5px solid #e2e8f0; color: #1a2235; text-decoration: none;
  transition: background .15s;
}
.sl-pagination .active, .sl-pagination a:hover { background: var(--sl-n); color: #fff; border-color: var(--sl-n); }

/* Related searches */
.sl-related {
  background: #f8fafc;
  border-radius: 14px;
  border: 1px solid #e8edf3;
  padding: 24px 28px;
  margin-bottom: 36px;
}
.sl-related h2 {
  font-size: 16px; font-weight: 700; color: var(--sl-n);
  margin: 0 0 16px;
}
.sl-related-links { display: flex; flex-wrap: wrap; gap: 10px; }
.sl-related-links a {
  padding: 7px 16px;
  border-radius: 99px;
  font-size: 13px; font-weight: 500;
  background: #fff;
  border: 1.5px solid #e2e8f0;
  color: #334155;
  text-decoration: none;
  transition: all .15s;
}
.sl-related-links a:hover {
  background: var(--sl-n); color: #fff; border-color: var(--sl-n);
}

/* FAQ */
.sl-faq { margin-bottom: 44px; }
.sl-faq > h2 {
  font-size: 20px; font-weight: 700; color: var(--sl-n);
  margin: 0 0 20px;
  padding-bottom: 12px;
  border-bottom: 2px solid #e8edf3;
}
.sl-faq-item {
  border: 1px solid #e8edf3;
  border-radius: 10px;
  margin-bottom: 10px;
  overflow: hidden;
}
.sl-faq-q {
  width: 100%; text-align: left;
  background: #fff; border: none; cursor: pointer;
  padding: 16px 20px;
  font-family: 'Poppins', sans-serif;
  font-size: 14.5px; font-weight: 600;
  color: #1a2235;
  display: flex; justify-content: space-between; align-items: center; gap: 12px;
  transition: background .15s;
}
.sl-faq-q:hover { background: #f8fafc; }
.sl-faq-q .sl-faq-icon { flex-shrink: 0; font-size: 18px; color: var(--sl-t); transition: transform .25s; }
.sl-faq-item.open .sl-faq-icon { transform: rotate(45deg); }
.sl-faq-a {
  max-height: 0; overflow: hidden;
  transition: max-height .3s ease, padding .3s;
  background: #f8fafc;
  border-top: 1px solid #e8edf3;
}
.sl-faq-item.open .sl-faq-a { max-height: 400px; padding: 14px 20px; }
.sl-faq-a p { font-size: 14px; line-height: 1.7; color: #475569; margin: 0; }

/* CTA strip */
.sl-cta {
  background: linear-gradient(135deg, var(--sl-n) 0%, #023372 100%);
  border-radius: 16px;
  padding: 36px 32px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
  flex-wrap: wrap;
}
.sl-cta-text h3 { font-size: 20px; font-weight: 700; color: #fff; margin: 0 0 6px; }
.sl-cta-text p  { font-size: 14px; color: rgba(255,255,255,.75); margin: 0; }
.sl-cta-btns { display: flex; gap: 12px; flex-wrap: wrap; }
.sl-cta-btn-primary {
  padding: 11px 24px; border-radius: 10px;
  background: var(--sl-or); color: #fff;
  font-size: 14px; font-weight: 700; text-decoration: none;
  transition: background .15s;
  white-space: nowrap;
}
.sl-cta-btn-primary:hover { background: #e04e00; color: #fff; }
.sl-cta-btn-secondary {
  padding: 11px 24px; border-radius: 10px;
  background: rgba(255,255,255,.12); color: #fff;
  border: 1.5px solid rgba(255,255,255,.3);
  font-size: 14px; font-weight: 600; text-decoration: none;
  transition: background .15s;
  white-space: nowrap;
}
.sl-cta-btn-secondary:hover { background: rgba(255,255,255,.2); }

@media (max-width: 768px) {
  .sl-hero { padding: 36px 16px 70px; }
  .sl-grid { grid-template-columns: 1fr; }
  .sl-intro { padding: 20px; }
  .sl-related { padding: 18px 16px; }
  .sl-cta { padding: 24px 20px; }
  .sl-cta-text h3 { font-size: 17px; }
}
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<div class="sl-hero" style="background: linear-gradient(135deg, {{ $hero_color }}f0 0%, {{ $hero_color }}bb 100%)">
  <div class="sl-hero-inner">
    <nav class="sl-breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">Home</a>
      <span>›</span>
      <a href="{{ route('properties.index') }}">Properties</a>
      <span>›</span>
      <span>{{ $breadcrumb_label }}</span>
    </nav>
    <h1>{{ $h1 }}</h1>
    <p class="sl-hero-sub">Verified properties in Lucknow — personally reviewed by DSD Properties advisors</p>
    <div class="sl-count-badge">
      <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
      {{ $listings->total() }} Properties Found
    </div>
  </div>
</div>

<div class="sl-container">

  {{-- ── Intro ── --}}
  <div class="sl-intro">
    @foreach($intro as $para)
    <p>{{ $para }}</p>
    @endforeach
  </div>

  {{-- ── Count bar ── --}}
  <div class="sl-count-bar">
    Showing <strong>{{ $listings->firstItem() ?? 0 }}–{{ $listings->lastItem() ?? 0 }}</strong>
    of <strong>{{ $listings->total() }}</strong> properties
    <a href="{{ route('properties.index') }}" class="sl-cta-link">View all properties →</a>
  </div>

  {{-- ── Property Grid ── --}}
  @if($listings->isEmpty())
    <div class="sl-empty">
      <div class="sl-empty-icon">🔍</div>
      <div style="font-size:16px;font-weight:600;color:#64748b;margin-bottom:6px;">No listings found right now</div>
      <div style="font-size:14px;color:#94a3b8;margin-bottom:20px;">Check back soon — new properties are added daily</div>
      <a href="{{ route('properties.index') }}" style="background:var(--sl-t);color:#fff;padding:10px 24px;border-radius:10px;font-weight:600;text-decoration:none;font-size:14px;">Browse All Properties</a>
    </div>
  @else
    <div class="sl-grid">
      @foreach($listings as $l)
      <div class="sl-card">
        <div class="sl-img">
          @if($l->featured_image && file_exists(public_path($l->featured_image)))
            <img src="{{ asset($l->featured_image) }}" alt="{{ $l->title }}" loading="lazy">
          @elseif($l->images->first())
            <img src="{{ asset($l->images->first()->image_path) }}" alt="{{ $l->title }}" loading="lazy">
          @else
            <div class="sl-img-placeholder">🏠</div>
          @endif
          <div class="sl-img-overlay"></div>
          <span class="sl-tag sl-tag-{{ $l->transaction_type }}">
            {{ $l->transaction_type === 'rent' ? 'For Rent' : 'For Sale' }}
          </span>
          <span class="sl-type-badge">{{ $l->getTypeLabel() }}</span>
        </div>
        <div class="sl-body">
          <div class="sl-price">{{ $l->getPriceDisplay() }}</div>
          <div class="sl-title">{{ Str::limit($l->title, 52) }}</div>
          <div class="sl-loc">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            {{ $l->locality }}, Lucknow
          </div>
          @if($l->bedrooms > 0 || $l->bathrooms || $l->area)
          <div class="sl-divider"></div>
          <div class="sl-specs">
            @if($l->bedrooms > 0)
            <span class="sl-spec">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
              {{ $l->bedrooms }} BHK
            </span>
            @endif
            @if($l->bathrooms)
            <span class="sl-spec">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v2H4V6zM4 8h16v8a2 2 0 01-2 2H6a2 2 0 01-2-2V8z"/></svg>
              {{ $l->bathrooms }} Bath
            </span>
            @endif
            @if($l->area)
            <span class="sl-spec">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
              {{ number_format($l->area, 0) }} {{ $l->getAreaUnitLabel() }}
            </span>
            @endif
          </div>
          @endif
          <div class="sl-foot-btns">
            <a href="{{ route('properties.show', $l->slug) }}" class="sl-view-btn">
              View Property
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            @if($l->lat && $l->lng)
            <a href="https://www.google.com/maps?q={{ $l->lat }},{{ $l->lng }}" target="_blank" rel="noopener" class="sl-map-btn" title="View on Google Maps">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              Map
            </a>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    @if($listings->hasPages())
    <div class="sl-pagination">
      @if($listings->onFirstPage())
        <span>‹</span>
      @else
        <a href="{{ $listings->previousPageUrl() }}">‹</a>
      @endif
      @foreach($listings->getUrlRange(1, $listings->lastPage()) as $p => $url)
        @if($p == $listings->currentPage())
          <span class="active">{{ $p }}</span>
        @else
          <a href="{{ $url }}">{{ $p }}</a>
        @endif
      @endforeach
      @if($listings->hasMorePages())
        <a href="{{ $listings->nextPageUrl() }}">›</a>
      @else
        <span>›</span>
      @endif
    </div>
    @endif
  @endif

  {{-- ── Related Searches ── --}}
  @if(!empty($related_links))
  <div class="sl-related">
    <h2>Related Property Searches in Lucknow</h2>
    <div class="sl-related-links">
      @foreach($related_links as $link)
      <a href="{{ url($link['url']) }}">{{ $link['text'] }}</a>
      @endforeach
    </div>
  </div>
  @endif

  {{-- ── FAQ ── --}}
  @if(!empty($faq))
  <div class="sl-faq">
    <h2>Frequently Asked Questions</h2>
    @foreach($faq as $item)
    <div class="sl-faq-item">
      <button class="sl-faq-q" type="button" aria-expanded="false">
        {{ $item['q'] }}
        <span class="sl-faq-icon">+</span>
      </button>
      <div class="sl-faq-a">
        <p>{{ $item['a'] }}</p>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  {{-- ── CTA ── --}}
  <div class="sl-cta">
    <div class="sl-cta-text">
      <h3>Find Your Perfect Property in Lucknow</h3>
      <p>Talk to our expert advisors — free consultation, no obligation</p>
    </div>
    <div class="sl-cta-btns">
      <a href="https://wa.me/919415017678?text=Hi, I'm looking for {{ urlencode($h1) }}" target="_blank" rel="noopener" class="sl-cta-btn-primary">
        WhatsApp Us
      </a>
      <a href="{{ route('contact-us') }}" class="sl-cta-btn-secondary">
        Contact Us
      </a>
    </div>
  </div>

</div>

@push('scripts')
<script>
// FAQ accordion
document.querySelectorAll('.sl-faq-q').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var item = this.closest('.sl-faq-item');
    var isOpen = item.classList.contains('open');
    document.querySelectorAll('.sl-faq-item.open').forEach(function(el) {
      el.classList.remove('open');
      el.querySelector('.sl-faq-q').setAttribute('aria-expanded', 'false');
    });
    if (!isOpen) {
      item.classList.add('open');
      this.setAttribute('aria-expanded', 'true');
    }
  });
});
</script>
@endpush

@endsection
