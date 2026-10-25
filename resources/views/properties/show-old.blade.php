@extends('layouts.user-app')
@section('title', $listing->title . ' — ' . $listing->locality . ' | DSD Properties')
@section('meta_description', Str::limit(strip_tags($listing->description), 155))

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home",       "item": "{{ url('/') }}" },
        { "@type": "ListItem", "position": 2, "name": "Properties", "item": "{{ url('/properties') }}" },
        { "@type": "ListItem", "position": 3, "name": "{{ e($listing->locality) }}", "item": "{{ url('/properties') }}?locality={{ urlencode($listing->locality) }}" },
        { "@type": "ListItem", "position": 4, "name": "{{ e($listing->title) }}", "item": "{{ url()->current() }}" }
      ]
    },
    {
      "@type": "RealEstateListing",
      "name": "{{ e($listing->title) }}",
      "description": "{{ e(Str::limit(strip_tags($listing->description), 300)) }}",
      "url": "{{ url()->current() }}",
      "datePosted": "{{ $listing->created_at?->toIso8601String() }}",
      "validThrough": "{{ now()->addYear()->toIso8601String() }}",
      @if($listing->featured_image && file_exists(public_path($listing->featured_image)))
      "image": "{{ asset($listing->featured_image) }}",
      @elseif($listing->images->first())
      "image": "{{ asset($listing->images->first()->image_path) }}",
      @endif
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ e($listing->address) }}",
        "addressLocality": "{{ e($listing->locality) }}",
        "addressRegion": "Uttar Pradesh",
        "postalCode": "{{ $listing->pincode ?? '226001' }}",
        "addressCountry": "IN"
      },
      @if(!$listing->price_on_request && $listing->price > 0)
      "offers": {
        "@type": "Offer",
        "price": "{{ $listing->price }}",
        "priceCurrency": "INR",
        "availability": "https://schema.org/InStock",
        "priceValidUntil": "{{ now()->addYear()->toDateString() }}"
      },
      @endif
      @if($listing->bedrooms !== null)
      "numberOfRooms": {{ $listing->bedrooms }},
      "numberOfBedrooms": {{ $listing->bedrooms }},
      @endif
      @if($listing->bathrooms)
      "numberOfBathroomsTotal": {{ $listing->bathrooms }},
      @endif
      @if($listing->area)
      "floorSize": {
        "@type": "QuantitativeValue",
        "value": {{ $listing->area }},
        "unitCode": "{{ $listing->area_unit === 'sqft' ? 'FTK' : ($listing->area_unit === 'sqmtr' ? 'MTK' : 'FTK') }}"
      },
      @endif
      "leaseLength": {
        "@type": "QuantitativeValue",
        "value": "{{ $listing->transaction_type === 'rent' ? 'Monthly' : 'Permanent' }}"
      },
      "seller": {
        "@type": "RealEstateAgent",
        "name": "{{ e($listing->seller->name ?? 'DSD Properties') }}",
        "telephone": "{{ $listing->seller->phone ?? '' }}",
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "Lucknow",
          "addressRegion": "Uttar Pradesh",
          "addressCountry": "IN"
        }
      }
    }
  ]
}
</script>
<style>
    .pd-wrap { max-width: 1100px; margin: 0 auto; padding: 28px 16px 56px; display: grid; grid-template-columns: 1fr 340px; gap: 28px; align-items: start; }
    .pd-gallery { border-radius: 14px; overflow: hidden; margin-bottom: 0; background: #f1f5f9; position: relative; }
    .pd-main-img { width: 100%; height: 400px; object-fit: cover; display: block; cursor: pointer; }
    .pd-main-placeholder { width: 100%; height: 400px; display: flex; align-items: center; justify-content: center; font-size: 72px; background: #f1f5f9; }
    .pd-thumbs { display: flex; gap: 8px; margin-top: 8px; overflow-x: auto; padding-bottom: 4px; }
    .pd-thumb { width: 80px; height: 60px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 2px solid transparent; flex-shrink: 0; opacity: .7; transition: all .15s; }
    .pd-thumb.active, .pd-thumb:hover { border-color: #008080; opacity: 1; }
    .pd-video-thumb { background: #1a2235; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; }
    .pd-main-video { width: 100%; height: 400px; display: block; background: #000; border-radius: 0; }
    @media (max-width: 900px) { .pd-main-video { height: 260px; } }

    .pd-card { background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.07); border: 1px solid #f1f5f9; margin-bottom: 20px; }
    .pd-price { font-size: 26px; font-weight: 800; color: #011f4b; }
    .pd-price-sub { font-size: 13px; color: #64748b; margin-top: 2px; }
    .pd-title { font-size: 20px; font-weight: 700; color: #1a2235; margin: 10px 0 4px; line-height: 1.3; }
    .pd-location { font-size: 13.5px; color: #64748b; margin-bottom: 14px; }
    .pd-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
    .pd-tag { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .pd-tag-sell { background: #dbeafe; color: #1e40af; }
    .pd-tag-rent { background: #d1fae5; color: #065f46; }
    .pd-tag-type { background: #f1f5f9; color: #475569; }

    .pd-specs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 18px; }
    .pd-spec { background: #f8fafc; border-radius: 10px; padding: 12px; text-align: center; }
    .pd-spec-icon { font-size: 20px; margin-bottom: 4px; }
    .pd-spec-val { font-size: 14px; font-weight: 700; color: #011f4b; }
    .pd-spec-lbl { font-size: 11px; color: #94a3b8; }

    .pd-section-title { font-size: 15px; font-weight: 700; color: #011f4b; margin: 20px 0 12px; padding-bottom: 8px; border-bottom: 2px solid #f1f5f9; }
    .pd-description { font-size: 14px; color: #374151; line-height: 1.8; white-space: pre-wrap; }
    .pd-details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .pd-detail-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 13.5px; }
    .pd-detail-row:last-child { border: none; }
    .pd-detail-label { color: #64748b; }
    .pd-detail-val { font-weight: 600; color: #1a2235; text-align: right; }
    .pd-amenities { display: flex; flex-wrap: wrap; gap: 8px; }
    .pd-amenity { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 5px 12px; border-radius: 20px; font-size: 12.5px; }

    /* Sidebar */
    .pd-sticky { position: sticky; top: 80px; }
    .pd-contact-card { background: #fff; border-radius: 14px; padding: 22px; box-shadow: 0 2px 14px rgba(0,0,0,.09); border: 1px solid #f1f5f9; margin-bottom: 16px; }
    .pd-seller-info { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; }
    .pd-seller-avatar { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; background: #011f4b; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; color: #fff; flex-shrink: 0; }
    .pd-seller-name { font-weight: 700; font-size: 15px; color: #011f4b; }
    .pd-seller-city { font-size: 12px; color: #64748b; }
    .pd-contact-form input, .pd-contact-form textarea {
        width: 100%; padding: 9px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-family: 'Poppins', sans-serif; font-size: 13px; color: #1a2235; margin-bottom: 10px;
    }
    .pd-contact-form input:focus, .pd-contact-form textarea:focus { outline: none; border-color: #008080; }
    .pd-contact-form textarea { resize: none; height: 80px; }
    .pd-btn-contact {
        width: 100%; padding: 12px; background: #008080; color: #fff; border: none;
        border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700;
        cursor: pointer; transition: background .15s;
    }
    .pd-btn-contact:hover { background: #006666; }
    .pd-whatsapp {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 10px; background: #f0fdf4; color: #166534; border: 1.5px solid #bbf7d0;
        border-radius: 10px; font-size: 13.5px; font-weight: 600; text-decoration: none;
        margin-top: 10px; transition: background .15s;
    }
    .pd-whatsapp:hover { background: #dcfce7; }
    .pd-views { text-align: center; font-size: 12px; color: #94a3b8; margin-top: 12px; }

    /* Lightbox */
    .pd-lightbox { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.92); z-index: 9999; align-items: center; justify-content: center; }
    .pd-lightbox.open { display: flex; }
    .pd-lightbox img { max-width: 90vw; max-height: 88vh; object-fit: contain; border-radius: 8px; }
    .pd-lb-close { position: absolute; top: 16px; right: 20px; font-size: 30px; color: #fff; cursor: pointer; background: none; border: none; line-height: 1; }
    .pd-lb-arrow { position: absolute; top: 50%; transform: translateY(-50%); font-size: 32px; color: rgba(255,255,255,.7); cursor: pointer; background: none; border: none; padding: 10px; }
    .pd-lb-arrow:hover { color: #fff; }
    .pd-lb-prev { left: 10px; } .pd-lb-next { right: 10px; }

    /* Related */
    .pd-related { max-width: 1100px; margin: 0 auto; padding: 0 16px 48px; }
    .pd-related-title { font-size: 18px; font-weight: 700; color: #011f4b; margin-bottom: 16px; }
    .pd-related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px; }
    .pd-rel-card { background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.06); border: 1px solid #f1f5f9; text-decoration: none; color: inherit; display: block; transition: box-shadow .2s; }
    .pd-rel-card:hover { box-shadow: 0 6px 20px rgba(1,31,75,.1); }
    .pd-rel-img { height: 140px; overflow: hidden; background: #f1f5f9; }
    .pd-rel-img img { width: 100%; height: 100%; object-fit: cover; }
    .pd-rel-body { padding: 12px; }
    .pd-rel-price { font-size: 15px; font-weight: 700; color: #011f4b; }
    .pd-rel-title { font-size: 12.5px; color: #475569; margin-top: 2px; }

    .success-box { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 14px; font-size: 13.5px; }

    @media (max-width: 900px) {
        .pd-wrap { grid-template-columns: 1fr; }
        .pd-sticky { position: static; }
        .pd-main-img, .pd-main-placeholder { height: 260px; }
    }
    @media (max-width: 480px) { .pd-specs-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush

@section('content')

{{-- Gallery + Main Info --}}
<div class="pd-wrap">
    <div>
        {{-- Gallery --}}
        @php
            $allMedia = [];
            if ($listing->featured_image && file_exists(public_path($listing->featured_image))) {
                $allMedia[] = ['type' => 'image', 'src' => asset($listing->featured_image)];
            }
            foreach ($listing->images as $img) {
                $allMedia[] = ['type' => 'image', 'src' => asset($img->image_path)];
            }
            if ($listing->video_path && file_exists(public_path($listing->video_path))) {
                $allMedia[] = ['type' => 'video', 'src' => asset($listing->video_path)];
            }
            $allImages = array_values(array_map(fn($m) => $m['src'], array_filter($allMedia, fn($m) => $m['type'] === 'image')));
        @endphp

        <div class="pd-gallery">
            @if(count($allMedia))
                <img src="{{ $allMedia[0]['src'] }}" alt="{{ $listing->title }}" class="pd-main-img" id="mainImg"
                    onclick="openLightbox()" style="cursor:zoom-in;{{ $allMedia[0]['type']==='video' ? 'display:none;' : '' }}">
                <video id="mainVideo" class="pd-main-video" controls preload="none"
                    style="{{ $allMedia[0]['type']==='video' ? '' : 'display:none;' }}">
                    @if($allMedia[0]['type']==='video')
                    <source src="{{ $allMedia[0]['src'] }}">
                    @endif
                </video>
            @else
                <div class="pd-main-placeholder">🏠</div>
            @endif
        </div>
        @if(count($allMedia) > 1)
        <div class="pd-thumbs" style="margin-top:8px;">
            @foreach($allMedia as $i => $m)
                @if($m['type'] === 'video')
                <div class="pd-thumb pd-video-thumb {{ $i===0?'active':'' }}" onclick="changeMedia({{ $i }})" title="Play video">▶</div>
                @else
                <img src="{{ $m['src'] }}" class="pd-thumb {{ $i===0?'active':'' }}" onclick="changeMedia({{ $i }})" alt="">
                @endif
            @endforeach
        </div>
        @endif

        {{-- Info card --}}
        <div class="pd-card" style="margin-top:20px;">
            <div class="pd-price">{{ $listing->getPriceDisplay() }}
                @if($listing->price_negotiable) <span style="font-size:13px;font-weight:500;color:#16a34a;">• Negotiable</span> @endif
            </div>
            <div class="pd-title">{{ $listing->title }}</div>
            <div class="pd-location">📍 {{ $listing->locality }}{{ $listing->landmark ? ', near '.$listing->landmark : '' }}, Lucknow</div>
            <div class="pd-tags">
                <span class="pd-tag pd-tag-{{ $listing->transaction_type }}">
                    {{ $listing->transaction_type === 'rent' ? '🔑 For Rent' : '🏷 For Sale' }}
                </span>
                <span class="pd-tag pd-tag-type">{{ $listing->getTypeLabel() }}</span>
                @if($listing->furnishing) <span class="pd-tag pd-tag-type">{{ $listing->getFurnishingLabel() }}</span> @endif
            </div>

            @if($listing->bedrooms !== null || $listing->bathrooms || $listing->area)
            <div class="pd-specs-grid">
                @if($listing->bedrooms !== null)
                <div class="pd-spec">
                    <div class="pd-spec-icon">🛏</div>
                    <div class="pd-spec-val">{{ $listing->bedrooms == 0 ? 'Studio' : $listing->bedrooms }}</div>
                    <div class="pd-spec-lbl">Bedroom{{ $listing->bedrooms != 1 ? 's' : '' }}</div>
                </div>
                @endif
                @if($listing->bathrooms)
                <div class="pd-spec">
                    <div class="pd-spec-icon">🚿</div>
                    <div class="pd-spec-val">{{ $listing->bathrooms }}</div>
                    <div class="pd-spec-lbl">Bathroom{{ $listing->bathrooms != 1 ? 's' : '' }}</div>
                </div>
                @endif
                @if($listing->area)
                <div class="pd-spec">
                    <div class="pd-spec-icon">📐</div>
                    <div class="pd-spec-val">{{ number_format($listing->area, 0) }}</div>
                    <div class="pd-spec-lbl">{{ $listing->getAreaUnitLabel() }}</div>
                </div>
                @endif
                @if($listing->balconies)
                <div class="pd-spec">
                    <div class="pd-spec-icon">🌿</div>
                    <div class="pd-spec-val">{{ $listing->balconies }}</div>
                    <div class="pd-spec-lbl">Balcon{{ $listing->balconies != 1 ? 'ies' : 'y' }}</div>
                </div>
                @endif
            </div>
            @endif

            <div class="pd-section-title">Description</div>
            <div class="pd-description">{{ $listing->description }}</div>

            {{-- Details table --}}
            @php
            $details = array_filter([
                'Floor'          => $listing->floor_no !== null ? ($listing->floor_no.' / '.($listing->total_floors ?? '?').' floors') : null,
                'Property Age'   => $listing->getAgeLabel(),
                'Furnishing'     => $listing->getFurnishingLabel(),
                'Facing'         => $listing->facing,
                'Parking'        => $listing->parking,
                'Pincode'        => $listing->pincode,
            ]);
            @endphp
            @if(count($details))
            <div class="pd-section-title">Property Details</div>
            <div class="pd-details-grid">
                @foreach($details as $lbl => $val)
                <div class="pd-detail-row">
                    <span class="pd-detail-label">{{ $lbl }}</span>
                    <span class="pd-detail-val">{{ $val }}</span>
                </div>
                @endforeach
            </div>
            @endif

            @if($listing->amenities && count($listing->amenities))
            <div class="pd-section-title">Amenities</div>
            <div class="pd-amenities">
                @foreach($listing->amenities as $a)
                <span class="pd-amenity">✓ {{ $a }}</span>
                @endforeach
            </div>
            @endif

            @if($listing->lat && $listing->lng)
            <div class="pd-section-title">Location on Map</div>
            <div id="propertyMap" style="width:100%;height:280px;border-radius:10px;border:1px solid #e2e8f0;"></div>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $listing->lat }},{{ $listing->lng }}"
               target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:8px;margin-top:12px;padding:10px 20px;background:#008080;color:#fff;border-radius:8px;font-size:13.5px;font-weight:600;text-decoration:none;transition:background .15s;"
               onmouseover="this.style.background='#006666'" onmouseout="this.style.background='#008080'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                Get Directions
            </a>
            @endif
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="pd-sticky">
        <div class="pd-contact-card">
            <div class="pd-seller-info">
                @if($listing->seller->profile_photo && file_exists(public_path($listing->seller->profile_photo)))
                    <img src="{{ asset($listing->seller->profile_photo) }}" class="pd-seller-avatar" alt="">
                @else
                    <div class="pd-seller-avatar">{{ strtoupper(substr($listing->seller->name,0,1)) }}</div>
                @endif
                <div>
                    <div class="pd-seller-name">{{ $listing->seller->name }}</div>
                    <div class="pd-seller-city">📍 {{ $listing->seller->city }}</div>
                </div>
            </div>

            @if(session('inquiry_sent'))
                <div class="success-box">✓ {{ session('inquiry_sent') }}</div>
            @endif

            <div style="font-size:14px;font-weight:700;color:#011f4b;margin-bottom:12px;">Contact Seller</div>

            <form method="POST" action="{{ route('properties.inquiry', $listing) }}" class="pd-contact-form">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" required>
                @error('name') <div style="font-size:11.5px;color:#dc2626;margin-top:-8px;margin-bottom:8px;">{{ $message }}</div> @enderror
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone number" required>
                @error('phone') <div style="font-size:11.5px;color:#dc2626;margin-top:-8px;margin-bottom:8px;">{{ $message }}</div> @enderror
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email (optional)">
                <textarea name="message" placeholder="I'm interested in this property. Please contact me.">{{ old('message') }}</textarea>
                <button type="submit" class="pd-btn-contact">Send Inquiry →</button>
            </form>

            @if($listing->seller->whatsapp || $listing->seller->phone)
            @php
                $waNum = preg_replace('/[^0-9]/', '', $listing->seller->whatsapp ?: $listing->seller->phone);
                $waMsg = urlencode('Hi, I saw your property listing "' . $listing->title . '" on DSD Properties. I\'m interested. Is it still available?');
            @endphp
            <a href="https://wa.me/91{{ ltrim($waNum,'91') }}?text={{ $waMsg }}" target="_blank" rel="noopener" class="pd-whatsapp">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                WhatsApp Seller
            </a>
            @endif

            <div class="pd-views">👁 {{ number_format($listing->views) }} views</div>
        </div>

        <div style="background:#fff;border-radius:12px;padding:16px;font-size:13px;color:#475569;border:1px solid #f1f5f9;box-shadow:0 1px 6px rgba(0,0,0,.05);">
            <div style="font-weight:600;color:#011f4b;margin-bottom:8px;">📍 Address</div>
            <div>{{ $listing->address }}</div>
            @if($listing->pincode) <div style="margin-top:4px;color:#94a3b8;">Pincode: {{ $listing->pincode }}</div> @endif
        </div>
    </div>
</div>

{{-- Lightbox --}}
<div class="pd-lightbox" id="lightbox" onclick="if(event.target===this)closeLightbox()">
    <button class="pd-lb-close" onclick="closeLightbox()">×</button>
    <button class="pd-lb-arrow pd-lb-prev" onclick="lbNav(-1)">‹</button>
    <img src="" id="lbImg" alt="">
    <button class="pd-lb-arrow pd-lb-next" onclick="lbNav(1)">›</button>
</div>

{{-- Related --}}
@if($related->count())
<div class="pd-related">
    <div class="pd-related-title">More Properties in {{ $listing->locality }}</div>
    <div class="pd-related-grid">
        @foreach($related as $r)
        <a href="{{ route('properties.show', $r->slug) }}" class="pd-rel-card">
            <div class="pd-rel-img">
                @if($r->featured_image && file_exists(public_path($r->featured_image)))
                    <img src="{{ asset($r->featured_image) }}" alt="{{ $r->title }}" loading="lazy">
                @elseif($r->images->first())
                    <img src="{{ asset($r->images->first()->image_path) }}" alt="{{ $r->title }}" loading="lazy">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:36px;background:#f1f5f9;">🏠</div>
                @endif
            </div>
            <div class="pd-rel-body">
                <div class="pd-rel-price">{{ $r->getPriceDisplay() }}</div>
                <div class="pd-rel-title">{{ Str::limit($r->title, 55) }}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
var allMedia   = @json($allMedia);
var images     = allMedia.filter(function(m){ return m.type === 'image'; }).map(function(m){ return m.src; });
var currentIdx = 0;
var lbCurrent  = 0;

var mainImg   = document.getElementById('mainImg');
var mainVideo = document.getElementById('mainVideo');

function changeMedia(i) {
    currentIdx = i;
    var media = allMedia[i];

    document.querySelectorAll('.pd-thumb').forEach(function(t, idx) {
        t.classList.toggle('active', idx === i);
    });

    if (media.type === 'video') {
        if (mainImg)   mainImg.style.display   = 'none';
        if (mainVideo) {
            mainVideo.style.display = 'block';
            mainVideo.src = media.src;
            mainVideo.load();
        }
    } else {
        if (mainVideo && !mainVideo.paused) mainVideo.pause();
        if (mainVideo) mainVideo.style.display = 'none';
        if (mainImg)   { mainImg.style.display = 'block'; mainImg.src = media.src; }
        var imgIdx = images.indexOf(media.src);
        if (imgIdx !== -1) lbCurrent = imgIdx;
    }
}

function openLightbox() {
    if (!images.length) return;
    if (allMedia[currentIdx] && allMedia[currentIdx].type !== 'image') return;
    document.getElementById('lbImg').src = images[lbCurrent];
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}

function lbNav(dir) {
    if (!images.length) return;
    lbCurrent = (lbCurrent + dir + images.length) % images.length;
    document.getElementById('lbImg').src = images[lbCurrent];
}

document.addEventListener('keydown', function(e) {
    if (!document.getElementById('lightbox').classList.contains('open')) return;
    if (e.key === 'Escape')      closeLightbox();
    if (e.key === 'ArrowLeft')   lbNav(-1);
    if (e.key === 'ArrowRight')  lbNav(1);
});

@if($listing->lat && $listing->lng)
function pmInitMap() {
    var pos = { lat: {{ $listing->lat }}, lng: {{ $listing->lng }} };
    var map = new google.maps.Map(document.getElementById('propertyMap'), {
        center: pos, zoom: 13,
        mapTypeControl: false, streetViewControl: false, fullscreenControl: false,
    });
    new google.maps.Marker({ map: map, position: pos, title: '{{ addslashes($listing->title) }}' });
}
@endif
</script>
@endpush
