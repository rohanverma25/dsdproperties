@extends('layouts.user-app')

@section('title', 'Customer Reviews — DSD Properties Lucknow | ' . $totalReviews . '+ Google Reviews')
@section('meta_description', 'Read all ' . $totalReviews . ' Google reviews for DSD Properties — real feedback from Lucknow property buyers and sellers on our verification, advisory and registry services.')
@section('canonical', 'https://dsdproperties.in/reviews')

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "RealEstateAgent",
  "name": "DSD Properties",
  "url": "https://dsdproperties.in",
  "image": "https://dsdproperties.in/images/logo.webp",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $avgRating }}",
    "reviewCount": "{{ $totalReviews }}",
    "bestRating": "5",
    "worstRating": "1"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://dsdproperties.in" },
    { "@type": "ListItem", "position": 2, "name": "Reviews", "item": "https://dsdproperties.in/reviews" }
  ]
}
</script>
@endpush

@section('content')

<style>
.rv-wrap { font-family: 'Poppins', sans-serif; }
.rv-hero {
    background: linear-gradient(135deg, #011f4b 0%, #013870 45%, #005f6b 100%);
    padding: 56px 0 44px; text-align: center; color: #fff;
}
.rv-hero__label { font-size: 11px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,255,255,.6); margin: 0 0 10px; }
.rv-hero h1 { font-size: clamp(1.7rem, 3.4vw, 2.4rem); font-weight: 800; margin: 0 0 16px; }
.rv-hero__summary { display: inline-flex; align-items: center; gap: 14px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); border-radius: 16px; padding: 16px 26px; }
.rv-hero__rating { font-size: 2.4rem; font-weight: 900; line-height: 1; }
.rv-hero__stars { display: flex; gap: 2px; margin: 6px 0 4px; }
.rv-hero__stars svg { width: 18px; height: 18px; }
.rv-hero__count { font-size: .8rem; color: rgba(255,255,255,.75); margin: 0; }
.rv-hero__cta { margin-top: 22px; }
.rv-hero__cta a {
    display: inline-flex; align-items: center; gap: 8px; background: #4285F4; color: #fff;
    padding: 11px 22px; border-radius: 10px; font-weight: 700; font-size: .85rem; text-decoration: none;
    box-shadow: 0 5px 18px rgba(66,133,244,.35); transition: all .2s;
}
.rv-hero__cta a:hover { background: #2563eb; color:#fff; transform: translateY(-1px); }

.rv-section { max-width: 1100px; margin: 0 auto; padding: 44px 24px 60px; }
.rv-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 18px; margin-bottom: 40px; }

.rv-card {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 20px 20px 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,.05); transition: box-shadow .25s, transform .25s;
}
.rv-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,.09); transform: translateY(-2px); }
.rv-card-top { display: flex; align-items: center; gap: 11px; margin-bottom: 12px; }
.rv-avatar { width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0; display:flex; align-items:center; justify-content:center; font-size: 1rem; font-weight: 700; color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.15); }
.rv-name { font-size: .88rem; font-weight: 700; color: #111827; margin: 0 0 2px; }
.rv-date { font-size: .72rem; color: #9ca3af; margin: 0; }
.rv-stars { display: flex; gap: 2px; margin-bottom: 10px; }
.rv-stars svg { width: 15px; height: 15px; }
.rv-text { font-size: .84rem; color: #374151; line-height: 1.7; margin: 0; }
.rv-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 12px; }
.rv-tag { font-size: .68rem; font-weight: 600; color: #008080; background: #e0f2f1; padding: 3px 10px; border-radius: 99px; }

.rv-empty { text-align: center; padding: 60px 20px; color: #6b7280; }
</style>

<div class="rv-wrap">

<section class="rv-hero">
    <div class="rv-hero__label">Customer Reviews</div>
    <h1>What Lucknow Property Buyers Say About DSD Properties</h1>

    <div class="rv-hero__summary">
        <div>
            <div class="rv-hero__rating">{{ number_format($avgRating, 1) }}</div>
        </div>
        <div>
            <div class="rv-hero__stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($avgRating))
                        <svg viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @elseif($i - $avgRating < 1)
                        <svg viewBox="0 0 24 24"><defs><linearGradient id="hgh{{ $i }}"><stop offset="50%" stop-color="#f59e0b"/><stop offset="50%" stop-color="#d1d5db"/></linearGradient></defs><path fill="url(#hgh{{ $i }})" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="#d1d5db"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endif
                @endfor
            </div>
            <p class="rv-hero__count">Based on {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</p>
        </div>
    </div>

    <div class="rv-hero__cta">
        <a href="https://g.page/r/CSKaw-Vi5G_LEAE/review" target="_blank" rel="noopener">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            Write a Review on Google
        </a>
    </div>
</section>

<section class="rv-section">
    @if($reviews->isEmpty())
        <div class="rv-empty">No reviews to show yet.</div>
    @else
        @php
            $avatarColors = ['#4285F4', '#EA4335', '#FBBC05', '#34A853', '#8AB4F8', '#F28B82', '#c084fc', '#81C995', '#fb923c', '#FF8BCB', '#06b6d4', '#a3e635'];
        @endphp
        <div class="rv-grid">
            @foreach($reviews as $index => $review)
            @php
                $color = $avatarColors[$index % count($avatarColors)];
                $initial = strtoupper(substr($review->reviewer_name, 0, 1));
            @endphp
            <div class="rv-card">
                <div class="rv-card-top">
                    <div class="rv-avatar" style="background:{{ $color }}">{{ $initial }}</div>
                    <div>
                        <p class="rv-name">{{ e($review->reviewer_name) }}</p>
                        <p class="rv-date">{{ $review->review_date->format('M Y') }}</p>
                    </div>
                </div>
                <div class="rv-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <svg viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? '#f59e0b' : '#e5e7eb' }}"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endfor
                </div>
                <p class="rv-text">{{ $review->review_text }}</p>
                @if(!empty($review->tags))
                <div class="rv-tags">
                    @foreach($review->tags as $tag)
                        <span class="rv-tag">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div style="display:flex; justify-content:center;">
            {{ $reviews->links('vendor.pagination.dsd') }}
        </div>
    @endif
</section>

</div>
@endsection
