@extends('layouts.user-app')
@section('title', 'Properties for Sale in Lucknow | DSD Properties')
@section('meta_description', 'Browse verified properties for sale in Lucknow. Flats, houses, plots, commercial spaces — find your perfect property in Lucknow.')

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home",       "item": "{{ url('/') }}" },
        { "@type": "ListItem", "position": 2, "name": "Properties", "item": "{{ url('/properties') }}" }
        @if(request('locality'))
        ,{ "@type": "ListItem", "position": 3, "name": "{{ request('locality') }}", "item": "{{ url()->full() }}" }
        @endif
      ]
    },
    {
      "@type": "ItemList",
      "name": "Properties for Sale in Lucknow",
      "description": "Browse verified properties for sale in Lucknow — flats, houses, plots, commercial spaces.",
      "url": "{{ url('/properties') }}",
      "numberOfItems": {{ $listings->total() }},
      "itemListElement": [
        @foreach($listings as $l)
        {
          "@type": "ListItem",
          "position": {{ ($listings->currentPage() - 1) * $listings->perPage() + $loop->index + 1 }},
          "name": "{{ e($l->title) }}",
          "url": "{{ route('properties.show', $l->slug) }}"
        }{{ $loop->last ? '' : ',' }}
        @endforeach
      ]
    }
  ]
}
</script>
<style>
:root{--n:#011f4b;--t:#008080;--o:#FF5C00;--border:#e5e7eb;--bg2:#f4f7fb;--card:#fff;--t1:#111827;--t2:#4b5563;--t3:#9ca3af}
*{box-sizing:border-box}

/* ── Hero ── */
.prop-hero{background:linear-gradient(135deg,#011f4b,#013870);padding:40px 20px 64px;}
.prop-hero-inner{max-width:1140px;margin:0 auto;}
.prop-hero h1{color:#fff;font-size:clamp(20px,3vw,28px);font-weight:800;margin-bottom:6px;}
.prop-hero p{color:rgba(255,255,255,.6);font-size:14px;}

/* ── Filter bar ── */
.prop-filter-bar{
    background:#fff;border-radius:14px;box-shadow:0 6px 28px rgba(1,31,75,.12);
    padding:20px 22px;margin:-28px 0 28px;position:relative;z-index:10;
    border:1px solid var(--border);
}
.filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:12px;align-items:end;}
.filter-label{font-size:11px;font-weight:700;color:var(--t2);margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px;}
.filter-input,.filter-select{
    width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:9px;
    font-family:'Poppins',sans-serif;font-size:13px;color:var(--n);background:#fff;
    transition:border-color .15s;
}
.filter-input:focus,.filter-select:focus{outline:none;border-color:var(--t);}
.filter-actions{display:flex;gap:8px;align-items:center;}
.btn-filter{
    padding:10px 22px;background:var(--n);color:#fff;border:none;
    border-radius:9px;font-family:'Poppins',sans-serif;font-size:13.5px;
    font-weight:700;cursor:pointer;white-space:nowrap;transition:background .15s;
}
.btn-filter:hover{background:#023372;}
.btn-clear{background:none;border:none;color:var(--t3);font-size:12.5px;cursor:pointer;padding:0 4px;font-family:'Poppins',sans-serif;}
.btn-clear:hover{color:#dc2626;}

/* ── Results header ── */
.prop-count{font-size:13px;color:var(--t2);margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
.prop-count strong{color:var(--n);}

/* ── Card grid ── */
.prop-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:22px;}

.prop-card{
    background:var(--card);border-radius:18px;overflow:hidden;
    border:1px solid var(--border);
    box-shadow:0 2px 14px rgba(0,0,0,.06);
    transition:transform .25s,box-shadow .25s,border-color .25s;
    display:flex;flex-direction:column;position:relative;
    text-decoration:none;color:inherit;
}
.prop-card::before{
    content:'';position:absolute;top:0;left:0;right:0;height:3px;
    background:linear-gradient(90deg,var(--n),var(--t));
    opacity:0;transition:opacity .25s;z-index:2;
}
.prop-card:hover::before{opacity:1;}
.prop-card:hover{transform:translateY(-5px);box-shadow:0 18px 48px rgba(1,31,75,.13);border-color:rgba(0,128,128,.22);text-decoration:none;color:inherit;}

.prop-img{position:relative;height:215px;background:var(--bg2);overflow:hidden;flex-shrink:0;}
.prop-img img{width:100%;height:100%;object-fit:cover;transition:transform .4s;display:block;}
.prop-card:hover .prop-img img{transform:scale(1.05);}
.prop-img-ph{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;color:var(--t3);background:linear-gradient(135deg,#f1f5f9,#e2e8f0);}
.prop-img-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,transparent 35%,rgba(1,31,75,.5) 100%);pointer-events:none;}

.prop-tag{position:absolute;top:12px;left:12px;padding:4px 12px;border-radius:99px;font-size:10.5px;font-weight:700;letter-spacing:.03em;z-index:1;}
.prop-tag-sell{background:var(--n);color:#fff;}
.prop-tag-rent{background:var(--t);color:#fff;}
.prop-type-badge{position:absolute;bottom:12px;right:12px;background:rgba(255,255,255,.92);backdrop-filter:blur(6px);color:var(--n);padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;z-index:1;}

.prop-body{padding:18px;flex:1;display:flex;flex-direction:column;}
.prop-price{font-size:1.22rem;font-weight:800;color:#FF5C00;line-height:1.1;margin-bottom:5px;}
.prop-title{font-size:.88rem;font-weight:600;color:var(--t1);line-height:1.45;margin-bottom:8px;}
.prop-loc{display:flex;align-items:center;gap:4px;font-size:.75rem;color:var(--t3);margin-bottom:14px;}
.prop-divider{height:1px;background:var(--border);margin-bottom:14px;}
.prop-specs{display:flex;gap:14px;flex-wrap:wrap;font-size:.75rem;color:var(--t2);margin-bottom:18px;}
.prop-spec-item{display:flex;align-items:center;gap:4px;}
.prop-foot-btns{display:flex;gap:8px;margin-top:auto;}
.prop-view{
    display:flex;align-items:center;justify-content:center;gap:7px;
    padding:11px 16px;border-radius:10px;font-size:.84rem;font-weight:700;
    text-decoration:none;transition:all .2s;flex:1;
}
.prop-view-sell,.prop-view-rent{background:#008080;color:#fff;}
.prop-view-sell:hover,.prop-view-rent:hover{background:#006666;color:#fff;text-decoration:none;}
.prop-map-btn{
    display:flex;align-items:center;justify-content:center;gap:5px;
    padding:11px 14px;border-radius:10px;font-size:.84rem;font-weight:700;
    text-decoration:none;transition:all .2s;flex-shrink:0;
    background:#f1f5f9;color:var(--n);border:1.5px solid #e2e8f0;
}
.prop-map-btn:hover{background:#e2e8f0;color:var(--n);text-decoration:none;border-color:#cbd5e1;}

/* ── Empty ── */
.prop-empty{text-align:center;padding:64px 20px;color:var(--t3);}
.prop-empty .icon{font-size:52px;margin-bottom:12px;}

/* ── Pagination ── */
.prop-pagination{display:flex;justify-content:center;gap:6px;margin-top:40px;flex-wrap:wrap;}
.prop-pagination a,.prop-pagination span{
    padding:8px 16px;border-radius:9px;font-size:13.5px;
    border:1.5px solid var(--border);color:var(--n);text-decoration:none;transition:all .15s;
}
.prop-pagination .on,.prop-pagination a:hover{background:var(--n);color:#fff;border-color:var(--n);}

/* ── Responsive ── */
@media(max-width:860px){.prop-grid{grid-template-columns:1fr 1fr;}}
@media(max-width:640px){
    .filter-grid{grid-template-columns:1fr 1fr;}
    .prop-grid{grid-template-columns:1fr;}
    .prop-hero{padding:28px 16px 52px;}
}
@media(max-width:420px){.filter-grid{grid-template-columns:1fr;}}
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="prop-hero">
    <div class="prop-hero-inner">
        <h1>Properties in Lucknow</h1>
        <p>{{ $listings->total() }} verified listings — flats, houses, plots, commercial spaces</p>
    </div>
</div>

<div style="max-width:1140px;margin:0 auto;padding:0 16px 56px;">

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('properties.index') }}">
        <div class="prop-filter-bar">
            <div class="filter-grid">
                <div>
                    <div class="filter-label">Property Type</div>
                    <select name="type" class="filter-select">
                        <option value="">All Types</option>
                        @foreach(\App\Support\PropertyTypeSchema::grouped() as $group => $groupTypes)
                        <optgroup label="{{ \App\Support\PropertyTypeSchema::groupLabel($group) }}">
                            @foreach($groupTypes as $val => $cfg)
                            <option value="{{ $val }}" {{ request('type') == $val ? 'selected' : '' }}>{{ $cfg['label'] }}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <div class="filter-label">Locality</div>
                    <input type="text" name="locality" value="{{ request('locality') }}" class="filter-input" list="localityList" placeholder="e.g. Gomti Nagar">
                    <datalist id="localityList">
                        @foreach($localities as $loc)<option value="{{ $loc }}">@endforeach
                    </datalist>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-filter">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:5px;"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                        Search
                    </button>
                    @if(request()->hasAny(['type','transaction','locality']))
                        <a href="{{ route('properties.index') }}" class="btn-clear">✕ Clear</a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    {{-- Results count --}}
    <div class="prop-count">
        <span>
            Showing <strong>{{ $listings->firstItem() ?? 0 }}–{{ $listings->lastItem() ?? 0 }}</strong>
            of <strong>{{ $listings->total() }}</strong> properties
            @if(request('locality')) in <strong>{{ request('locality') }}</strong>@endif
        </span>
        @if($listings->lastPage() > 1)
        <span style="font-size:12px;color:var(--t3);">Page {{ $listings->currentPage() }} of {{ $listings->lastPage() }}</span>
        @endif
    </div>

    {{-- Listings grid --}}
    @if($listings->isEmpty())
        <div class="prop-empty">
            <div class="icon">🔍</div>
            <div style="font-size:16px;font-weight:700;color:#64748b;margin-bottom:6px;">No properties found</div>
            <div style="font-size:14px;margin-bottom:16px;">Try adjusting your search filters</div>
            <a href="{{ route('properties.index') }}" style="color:var(--t);font-weight:600;text-decoration:none;">Clear all filters →</a>
        </div>
    @else
    <div class="prop-grid">
        @foreach($listings as $l)
        <div class="prop-card">

            {{-- Image --}}
            <div class="prop-img">
                @if($l->featured_image && file_exists(public_path($l->featured_image)))
                    <img src="{{ asset($l->featured_image) }}" alt="{{ $l->title }}" loading="lazy">
                @elseif($l->images->first())
                    <img src="{{ asset($l->images->first()->image_path) }}" alt="{{ $l->title }}" loading="lazy">
                @else
                    <div class="prop-img-ph">🏠</div>
                @endif
                <div class="prop-img-overlay"></div>
                <span class="prop-tag prop-tag-{{ $l->transaction_type }}">
                    For Sale
                </span>
                <span class="prop-type-badge">{{ $l->getTypeLabel() }}</span>
            </div>

            {{-- Body --}}
            <div class="prop-body">
                <div class="prop-price">{{ $l->getPriceDisplay() }}</div>
                <div class="prop-title">{{ Str::limit($l->title, 52) }}</div>
                <div class="prop-loc">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $l->locality }}, Lucknow
                </div>

                @if($l->bedrooms !== null || $l->bathrooms || $l->area)
                <div class="prop-divider"></div>
                <div class="prop-specs">
                    @if($l->bedrooms !== null && $l->bedrooms >= 0)
                    <span class="prop-spec-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        {{ $l->bedrooms == 0 ? 'Studio' : $l->bedrooms . ' BHK' }}
                    </span>
                    @endif
                    @if($l->bathrooms)
                    <span class="prop-spec-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        {{ $l->bathrooms }} Bath
                    </span>
                    @endif
                    @if($l->area)
                    <span class="prop-spec-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        {{ number_format($l->area, 0) }} {{ $l->getAreaUnitLabel() }}
                    </span>
                    @endif
                </div>
                @endif

                <div class="prop-foot-btns">
                    <a href="{{ route('properties.show', $l->slug) }}" class="prop-view prop-view-{{ $l->transaction_type }}">
                        View Property
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @if($l->lat && $l->lng)
                    <a href="https://www.google.com/maps?q={{ $l->lat }},{{ $l->lng }}"
                       target="_blank" rel="noopener" class="prop-map-btn" title="View on map">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
    <div class="prop-pagination">
        @if($listings->onFirstPage())
            <span style="opacity:.4;">‹</span>
        @else
            <a href="{{ $listings->previousPageUrl() }}">‹</a>
        @endif

        @foreach($listings->getUrlRange(1, $listings->lastPage()) as $p => $url)
            @if($p == $listings->currentPage())
                <span class="on">{{ $p }}</span>
            @else
                <a href="{{ $url }}">{{ $p }}</a>
            @endif
        @endforeach

        @if($listings->hasMorePages())
            <a href="{{ $listings->nextPageUrl() }}">›</a>
        @else
            <span style="opacity:.4;">›</span>
        @endif
    </div>
    @endif
    @endif

</div>
@endsection

@push('scripts')
<script>
// ── Property Search & Listing Analytics ─────────────────────────
(function(){
  if (typeof gtag !== 'function') return;

  // 1. Track active filters on page load (from URL params)
  @if(request()->hasAny(['type','transaction','locality']))
  gtag('event', 'property_search', {
    event_category: 'search',
    search_term:    '{{ request("locality","") }}',
    property_type:  '{{ request("type","all") }}',
    transaction:    '{{ request("transaction","any") }}',
    result_count:   {{ $listings->total() }},
    page:           {{ $listings->currentPage() }},
  });
  @endif

  document.addEventListener('DOMContentLoaded', function() {

    // 2. Search form submit
    var filterForm = document.querySelector('form[action]');
    if (filterForm) filterForm.addEventListener('submit', function() {
      var locality = (filterForm.querySelector('[name=locality]') || {}).value || '';
      var type     = (filterForm.querySelector('[name=type]') || {}).value || 'all';
      var trans    = (filterForm.querySelector('[name=transaction]') || {}).value || 'any';
      gtag('event', 'property_search', {
        event_category: 'search',
        search_term:    locality || 'all',
        property_type:  type,
        transaction:    trans,
      });
    });

    // 3. Property card click — "View Property" button
    document.querySelectorAll('.prop-view').forEach(function(a) {
      a.addEventListener('click', function() {
        var card  = this.closest('.prop-card');
        var title = card ? (card.querySelector('.prop-title') || {}).textContent : '';
        var price = card ? (card.querySelector('.prop-price') || {}).textContent : '';
        var loc   = card ? (card.querySelector('.prop-loc') || {}).textContent : '';
        gtag('event', 'select_item', {
          event_category: 'property_listing',
          item_name:  title.trim(),
          item_price: price.trim(),
          item_loc:   loc.trim(),
          link_url:   this.href,
        });
      });
    });

    // 4. Pagination click
    document.querySelectorAll('.prop-pagination a').forEach(function(a) {
      a.addEventListener('click', function() {
        gtag('event', 'pagination_click', {
          event_category: 'search',
          page_url:       this.href,
        });
      });
    });

  });
})();
</script>
@endpush
