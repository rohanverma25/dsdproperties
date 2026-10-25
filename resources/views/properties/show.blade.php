@extends('layouts.user-app')
@section('title', $listing->title . ' — ' . $listing->locality . ', Lucknow | DSD Properties')
@section('meta_description', Str::limit(strip_tags($listing->description), 155))

@push('head')
<link rel="canonical" href="{{ url()->current() }}">
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
      }
      @if(!$listing->price_on_request && $listing->price > 0)
      ,"offers": {
        "@type": "Offer",
        "price": "{{ $listing->price }}",
        "priceCurrency": "INR",
        "availability": "https://schema.org/InStock"
      }
      @endif
    }
  ]
}
</script>
<style>
/* ── Reset / Base ────────────────────────────────────── */
:root {
  --n:  #011f4b;
  --t:  #008080;
  --or: #FF5C00;
  --g:  #64748b;
  --bg: #f4f7fb;
  --card: #ffffff;
  --border: #e2e8f0;
  --radius: 14px;
}
.pd2-page { background: var(--bg); min-height: 60vh; overflow-x: clip; }
.pd2-page *, .pd2-page *::before, .pd2-page *::after { box-sizing: border-box; }

/* ── Breadcrumb ──────────────────────────────────────── */
.pd2-bc { max-width: 1180px; width: 100%; margin: 0 auto; padding: 14px 20px 0; font-size: 12.5px; color: var(--g); display: flex; align-items: center; gap: 6px; flex-wrap: wrap; min-width: 0; }
.pd2-bc a { color: var(--g); text-decoration: none; min-width: 0; } .pd2-bc a:hover { color: var(--t); }
.pd2-bc-sep { opacity: .45; flex-shrink: 0; }
.pd2-bc-cur { color: #374151; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ── Main grid ───────────────────────────────────────── */
.pd2-wrap { max-width: 1180px; width: 100%; margin: 0 auto; padding: 18px 20px 60px; display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start; }
.pd2-wrap > * { min-width: 0; }

/* ── Gallery ─────────────────────────────────────────── */
.pd2-gallery-card { background: var(--card); border-radius: var(--radius); overflow: hidden; box-shadow: 0 2px 16px rgba(1,31,75,.07); }
.pd2-gallery-hero { position: relative; background: #0d1b2a; }
.pd2-hero-img { width: 100%; height: 460px; object-fit: cover; display: block; cursor: zoom-in; transition: opacity .2s; }
.pd2-hero-video { width: 100%; height: 460px; display: block; background: #000; }
.pd2-img-count { position: absolute; bottom: 14px; right: 14px; background: rgba(0,0,0,.6); color: #fff; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; backdrop-filter: blur(4px); display: flex; align-items: center; gap: 5px; }
.pd2-trans-badge { position: absolute; top: 14px; left: 14px; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; letter-spacing: .3px; }
.pd2-trans-sell { background: var(--n); color: #fff; }
.pd2-trans-rent { background: #065f46; color: #fff; }
.pd2-placeholder-hero { width: 100%; height: 460px; display: flex; align-items: center; justify-content: center; font-size: 80px; background: linear-gradient(135deg,#e8edf5,#f4f7fb); }
.pd2-thumbs { display: flex; gap: 8px; padding: 12px; overflow-x: auto; background: #f8fafc; border-top: 1px solid var(--border); }
.pd2-thumb { width: 84px; height: 64px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 2px solid transparent; flex-shrink: 0; opacity: .65; transition: all .15s; }
.pd2-thumb:hover, .pd2-thumb.active { border-color: var(--t); opacity: 1; }
.pd2-vthumb { background: #1a2235; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 22px; }

/* ── Info card ───────────────────────────────────────── */
.pd2-info { background: var(--card); border-radius: var(--radius); padding: 26px 28px 28px; box-shadow: 0 2px 16px rgba(1,31,75,.07); margin-top: 20px; min-width: 0; }
.pd2-info > * { min-width: 0; max-width: 100%; }
.pd2-type-row { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; flex-wrap: wrap; }
.pd2-pill { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.pd2-pill-type { background: #e8edf5; color: var(--n); }
.pd2-pill-fur  { background: #fef9c3; color: #713f12; }
.pd2-pill-new  { background: #dcfce7; color: #166534; }
.pd2-h1 { font-size: 22px; font-weight: 800; color: var(--n); line-height: 1.3; margin: 0 0 8px; word-break: break-word; }
.pd2-locality { font-size: 13.5px; color: var(--g); display: flex; align-items: center; gap: 6px; }

/* ── Price strip ─────────────────────────────────────── */
.pd2-price-strip { background: linear-gradient(90deg,#011f4b,#023372); border-radius: 12px; padding: 18px 22px; margin: 18px 0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.pd2-price-main { font-size: 30px; font-weight: 900; color: var(--or); letter-spacing: -.5px; }
.pd2-price-neg  { font-size: 12px; color: #7dd3b4; font-weight: 500; margin-top: 3px; }
.pd2-price-sqft { background: rgba(255,255,255,.12); border-radius: 8px; padding: 8px 14px; text-align: center; }
.pd2-price-sqft-val  { font-size: 16px; font-weight: 800; color: #fff; }
.pd2-price-sqft-lbl  { font-size: 11px; color: rgba(255,255,255,.6); margin-top: 1px; }

/* ── Specs bar ───────────────────────────────────────── */
.pd2-specs { display: flex; flex-wrap: wrap; gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-bottom: 22px; }
.pd2-spec { flex: 1 1 85px; background: var(--card); padding: 14px 10px; text-align: center; }
.pd2-spec-ic { font-size: 22px; margin-bottom: 5px; }
.pd2-spec-v  { font-size: 16px; font-weight: 800; color: var(--n); line-height: 1; }
.pd2-spec-l  { font-size: 10.5px; color: var(--g); margin-top: 3px; text-transform: uppercase; letter-spacing: .3px; }

/* ── Tabs ────────────────────────────────────────────── */
.pd2-tabs { display: flex; gap: 0; border-bottom: 2px solid var(--border); overflow-x: auto; scrollbar-width: none; background: #fff; position: sticky; top: 70px; z-index: 20; margin: 0 -28px 28px; padding: 0 28px; box-shadow: 0 2px 8px rgba(1,31,75,.06); }
.pd2-tabs::-webkit-scrollbar { display: none; }
.pd2-tab { padding: 10px 18px; font-size: 13.5px; font-weight: 600; color: var(--g); cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; white-space: nowrap; background: none; border-top: none; border-left: none; border-right: none; font-family: inherit; transition: color .15s; }
.pd2-tab:hover { color: var(--n); }
.pd2-tab.active { color: var(--t); border-bottom-color: var(--t); }
.pd2-pane { display: block; scroll-margin-top: 130px; }
.pd2-pane + .pd2-pane { margin-top: 32px; padding-top: 32px; border-top: 1.5px solid var(--border); }

/* ── Description ─────────────────────────────────────── */
.pd2-desc { font-size: 14.5px; color: #374151; line-height: 1.85; }
.pd2-desc p { margin: 0 0 10px; }
.pd2-desc h2 { font-size: 17px; font-weight: 700; color: var(--n); margin: 18px 0 8px; }
.pd2-desc h3 { font-size: 15px; font-weight: 700; color: var(--n); margin: 14px 0 6px; }
.pd2-desc ul, .pd2-desc ol { padding-left: 20px; margin: 0 0 10px; }
.pd2-desc li { margin-bottom: 4px; }
.pd2-desc strong { color: var(--n); }
/* ── Plot segments table ────────────────────────────── */
.pd2-plot-seg-table { width: 100%; border-collapse: collapse; margin-top: 12px; font-size: 13.5px; }
.pd2-plot-seg-table th { background: #f1f5f9; color: #475569; font-weight: 700; padding: 9px 12px; text-align: left; border: 1px solid var(--border); font-size: 12px; text-transform: uppercase; letter-spacing: .3px; }
.pd2-plot-seg-table td { padding: 9px 12px; border: 1px solid var(--border); color: var(--n); }
.pd2-plot-seg-table tr:nth-child(even) td { background: #f8fafc; }
/* ── Brochure download ──────────────────────────────── */
.pd2-brochure-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #fff; border: 2px solid var(--n); border-radius: 10px; color: var(--n); font-size: 13.5px; font-weight: 700; text-decoration: none; transition: all .15s; margin-top: 14px; }
.pd2-brochure-btn:hover { background: var(--n); color: #fff; }
.pd2-sec-title { font-size: 14px; font-weight: 700; color: var(--n); margin: 22px 0 12px; display: flex; align-items: center; gap: 8px; }
.pd2-sec-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

/* ── Details table ───────────────────────────────────── */
.pd2-details { display: grid; grid-template-columns: 1fr 1fr; gap: 0 24px; }
.pd2-drow { display: flex; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid #f1f5f9; font-size: 13.5px; }
.pd2-drow:last-child { border: none; }
.pd2-dlbl { color: var(--g); }
.pd2-dval { font-weight: 700; color: var(--n); text-align: right; }

/* ── Amenities ───────────────────────────────────────── */
.pd2-amen { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px,1fr)); gap: 10px; }
.pd2-amen-item { display: flex; align-items: center; gap: 8px; padding: 10px 12px; background: #f0fdf4; border: 1px solid #d1fae5; border-radius: 10px; font-size: 13px; color: #166534; font-weight: 500; }
.pd2-amen-chk { width: 18px; height: 18px; background: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.pd2-amen-chk svg { width: 10px; height: 10px; }

/* ── Map ─────────────────────────────────────────────── */
#pd2Map { width: 100%; height: 320px; border-radius: 12px; border: 1px solid var(--border); }
.pd2-dir-btn { display: inline-flex; align-items: center; gap: 8px; margin-top: 12px; padding: 10px 20px; background: var(--t); color: #fff; border-radius: 8px; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: background .15s; }
.pd2-dir-btn:hover { background: #006666; color: #fff; }

/* ── Overview highlights bar ─────────────────────────── */
.pd2-overview-highlights { display: grid; grid-template-columns: repeat(auto-fill, minmax(90px,1fr)); gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-bottom: 22px; }
.pd2-ov-hlt { display: flex; flex-direction: column; align-items: center; text-align: center; gap: 2px; padding: 14px 10px; background: #f8fafc; }
.pd2-ov-hlt-ic { font-size: 20px; line-height: 1; }
.pd2-ov-hlt-v { font-size: 13.5px; font-weight: 800; color: var(--n); line-height: 1.2; margin-top: 4px; }
.pd2-ov-hlt-l { font-size: 10px; color: var(--g); text-transform: uppercase; letter-spacing: .4px; margin-top: 2px; }

/* ── Location pane info ──────────────────────────────── */
.pd2-loc-info { margin-top: 16px; display: flex; flex-direction: column; gap: 10px; }
.pd2-loc-addr-card { display: flex; align-items: flex-start; gap: 14px; background: #f8fafc; border: 1px solid var(--border); border-radius: 12px; padding: 16px; }
.pd2-loc-addr-icon { font-size: 26px; flex-shrink: 0; line-height: 1; margin-top: 1px; }
.pd2-loc-addr-main { font-size: 14px; font-weight: 600; color: var(--n); line-height: 1.5; }
.pd2-loc-addr-sub { font-size: 12.5px; color: var(--g); margin-top: 4px; }
.pd2-loc-landmark { display: flex; align-items: center; gap: 9px; font-size: 13px; color: #92400e; padding: 11px 14px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; font-weight: 500; }
.pd2-dir-btn-full { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 13px 20px; background: var(--t); color: #fff; border-radius: 10px; font-size: 14.5px; font-weight: 700; text-decoration: none; transition: background .15s; }
.pd2-dir-btn-full:hover { background: #006666; color: #fff; }

/* ── Details sections ────────────────────────────────── */
.pd2-det-section { margin-bottom: 20px; }
.pd2-det-sec-hd { font-size: 11px; font-weight: 700; color: var(--g); text-transform: uppercase; letter-spacing: .8px; margin-bottom: 8px; padding: 0 2px; }
.pd2-det-grid { border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
.pd2-det-row { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13.5px; }
.pd2-det-row:last-child { border-bottom: none; }
.pd2-det-row:nth-child(even) { background: #f8fafc; }
.pd2-det-ic { font-size: 15px; flex-shrink: 0; width: 22px; text-align: center; }
.pd2-det-lbl { color: var(--g); flex: 1; }
.pd2-det-val { font-weight: 700; color: var(--n); text-align: right; }
.pd2-det-meta { background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 13px 16px; font-size: 12.5px; color: var(--g); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.pd2-det-meta-id { font-size: 13px; font-weight: 700; color: var(--n); }

/* ── Tags (locality tags) ────────────────────────────── */
.pd2-prop-tags { display: flex; flex-wrap: wrap; gap: 8px; }
.pd2-prop-tag { padding: 5px 14px; border-radius: 20px; font-size: 12.5px; font-weight: 500; background: #e8edf5; color: var(--n); border: 1px solid #c7d5e8; }

/* ══ SIDEBAR ═════════════════════════════════════════════ */
.pd2-sidebar { position: sticky; top: 76px; display: flex; flex-direction: column; gap: 16px; }

/* ── Contact card ────────────────────────────────────── */
.pd2-contact { background: var(--card); border-radius: var(--radius); box-shadow: 0 4px 24px rgba(1,31,75,.1); overflow: hidden; }
.pd2-contact-top { background: linear-gradient(135deg, #011f4b 60%, #023372); padding: 18px 20px; }
.pd2-contact-price { font-size: 26px; font-weight: 900; color: var(--or); }
.pd2-contact-price-sub { font-size: 12px; color: rgba(255,255,255,.6); margin-top: 2px; }
.pd2-contact-body { padding: 18px 20px; }

.pd2-seller { display: flex; align-items: center; gap: 12px; padding-bottom: 16px; margin-bottom: 16px; border-bottom: 1px solid var(--border); }
.pd2-seller-av { width: 46px; height: 46px; border-radius: 50%; overflow: hidden; background: var(--n); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #fff; flex-shrink: 0; }
.pd2-seller-av img { width: 100%; height: 100%; object-fit: cover; }
.pd2-seller-name { font-size: 14px; font-weight: 700; color: var(--n); }
.pd2-seller-sub  { font-size: 12px; color: var(--g); margin-top: 2px; }
.pd2-verified    { display: inline-flex; align-items: center; gap: 3px; background: #f0fdf4; color: #166534; border-radius: 20px; padding: 2px 8px; font-size: 11px; font-weight: 600; }

/* CTA buttons */
.pd2-btn-wa { display: flex; align-items: center; justify-content: center; gap: 9px; width: 100%; padding: 13px 16px; background: #25D366; color: #fff; border-radius: 10px; font-size: 14.5px; font-weight: 700; text-decoration: none; transition: background .15s; margin-bottom: 10px; }
.pd2-btn-wa:hover { background: #128c4e; color: #fff; }
.pd2-btn-call { display: flex; align-items: center; justify-content: center; gap: 9px; width: 100%; padding: 11px 16px; background: #fff; color: var(--n); border: 2px solid var(--n); border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all .15s; margin-bottom: 14px; }
.pd2-btn-call:hover { background: var(--n); color: #fff; }

/* Inquiry form */
.pd2-form-toggle { display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; font-weight: 700; color: var(--n); cursor: pointer; padding: 10px 0; border-top: 1px solid var(--border); user-select: none; }
.pd2-form-toggle svg { transition: transform .25s; }
.pd2-form-toggle.open svg { transform: rotate(180deg); }
.pd2-form-body { display: none; padding-top: 12px; }
.pd2-form-body.open { display: block; }
.pd2-inp { width: 100%; padding: 10px 13px; border: 1.5px solid var(--border); border-radius: 9px; font-family: inherit; font-size: 13px; color: var(--n); margin-bottom: 10px; box-sizing: border-box; transition: border-color .15s; }
.pd2-inp:focus { outline: none; border-color: var(--t); }
.pd2-textarea { resize: none; height: 76px; }
.pd2-btn-send { width: 100%; padding: 12px; background: var(--t); color: #fff; border: none; border-radius: 10px; font-family: inherit; font-size: 14px; font-weight: 700; cursor: pointer; transition: background .15s; }
.pd2-btn-send:hover { background: #006666; }
.pd2-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 12px; }

/* ── EMI estimator ───────────────────────────────────── */
.pd2-emi-card { background: var(--card); border-radius: var(--radius); padding: 18px 20px; box-shadow: 0 2px 12px rgba(1,31,75,.07); border: 1px solid var(--border); }
.pd2-emi-title { font-size: 13.5px; font-weight: 700; color: var(--n); margin-bottom: 14px; display: flex; align-items: center; gap: 7px; }
.pd2-emi-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 12.5px; }
.pd2-emi-lbl { color: var(--g); }
.pd2-emi-val { font-weight: 700; color: var(--n); }
.pd2-emi-slider { width: 100%; accent-color: var(--t); margin: 4px 0 14px; cursor: pointer; }
.pd2-emi-result { background: linear-gradient(90deg,#011f4b,#023372); border-radius: 10px; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; }
.pd2-emi-lbl-w { font-size: 11.5px; color: rgba(255,255,255,.7); }
.pd2-emi-amount { font-size: 20px; font-weight: 900; color: #fff; }
.pd2-emi-note { font-size: 10.5px; color: rgba(255,255,255,.55); margin-top: 2px; }

/* ── Share / quick facts ─────────────────────────────── */
.pd2-share-card { background: var(--card); border-radius: var(--radius); padding: 16px 20px; box-shadow: 0 2px 12px rgba(1,31,75,.07); border: 1px solid var(--border); }
.pd2-share-title { font-size: 13px; font-weight: 700; color: var(--n); margin-bottom: 12px; }
.pd2-share-btns { display: flex; gap: 8px; flex-wrap: wrap; }
.pd2-share-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-family: inherit; }
.pd2-share-link  { background: #e8edf5; color: var(--n); }
.pd2-share-link:hover  { background: #d1d9e6; }
.pd2-share-fb { background: #1877f2; color: #fff; }
.pd2-share-wa { background: #25D366; color: #fff; }

/* ── Lightbox ────────────────────────────────────────── */
.pd2-lb { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.93); z-index: 9999; align-items: center; justify-content: center; }
.pd2-lb.open { display: flex; }
.pd2-lb-inner { position: relative; max-width: 90vw; max-height: 90vh; }
.pd2-lb-inner img { max-width: 90vw; max-height: 85vh; object-fit: contain; border-radius: 8px; display: block; }
.pd2-lb-close { position: fixed; top: 16px; right: 20px; font-size: 34px; color: #fff; cursor: pointer; background: rgba(255,255,255,.1); border: none; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; line-height: 1; }
.pd2-lb-close:hover { background: rgba(255,255,255,.2); }
.pd2-lb-arrow { position: fixed; top: 50%; transform: translateY(-50%); font-size: 36px; color: rgba(255,255,255,.8); cursor: pointer; background: rgba(255,255,255,.1); border: none; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.pd2-lb-arrow:hover { background: rgba(255,255,255,.2); color: #fff; }
.pd2-lb-prev { left: 16px; } .pd2-lb-next { right: 16px; }
.pd2-lb-counter { position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,.6); color: #fff; font-size: 13px; padding: 4px 16px; border-radius: 20px; }

/* ── Related ─────────────────────────────────────────── */
.pd2-related { max-width: 1180px; margin: 0 auto; padding: 0 20px 60px; }
.pd2-related-hd { font-size: 20px; font-weight: 800; color: var(--n); margin-bottom: 18px; padding-bottom: 12px; border-bottom: 2px solid var(--border); }
.pd2-rel-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px,1fr)); gap: 16px; }
.pd2-rel-card { background: var(--card); border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(1,31,75,.07); border: 1px solid var(--border); text-decoration: none; color: inherit; display: block; transition: transform .2s, box-shadow .2s; }
.pd2-rel-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(1,31,75,.12); }
.pd2-rel-img { height: 150px; overflow: hidden; background: #f1f5f9; position: relative; }
.pd2-rel-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s; }
.pd2-rel-card:hover .pd2-rel-img img { transform: scale(1.04); }
.pd2-rel-badge { position: absolute; top: 8px; left: 8px; background: var(--n); color: #fff; font-size: 10.5px; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
.pd2-rel-body { padding: 14px; }
.pd2-rel-price { font-size: 16px; font-weight: 800; color: var(--n); }
.pd2-rel-title { font-size: 12.5px; color: var(--g); margin-top: 3px; line-height: 1.4; }
.pd2-rel-specs { font-size: 11.5px; color: #94a3b8; margin-top: 6px; display: flex; gap: 10px; }

/* ── Responsive ──────────────────────────────────────── */
@media (max-width: 960px) {
  .pd2-wrap { grid-template-columns: 1fr; }
  .pd2-sidebar { position: static; }
  .pd2-hero-img, .pd2-hero-video, .pd2-placeholder-hero { height: 300px; }
  .pd2-rel-grid { grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); }
}
@media (max-width: 600px) {
  /* Layout & spacing */
  .pd2-bc { font-size: 11px; padding: 10px 12px 0; gap: 4px; }
  .pd2-wrap { padding: 10px 10px 48px; gap: 14px; }
  .pd2-gallery-card, .pd2-info, .pd2-contact, .pd2-emi-card, .pd2-share-card { border-radius: 10px; }
  .pd2-hero-img, .pd2-hero-video, .pd2-placeholder-hero { height: 220px; }

  /* Info card */
  .pd2-info { padding: 14px 14px 18px; }
  .pd2-h1 { font-size: 17px; }
  .pd2-locality { font-size: 12.5px; }

  /* Price strip */
  .pd2-price-strip { flex-direction: column; align-items: flex-start; gap: 10px; padding: 14px 16px; border-radius: 10px; }
  .pd2-price-main { font-size: 22px; }
  .pd2-price-sqft { align-self: flex-start; }
  .pd2-price-sqft-val { font-size: 14px; }

  /* Specs */
  .pd2-specs { grid-template-columns: repeat(3, 1fr); }
  .pd2-spec { padding: 10px 6px; }
  .pd2-spec-ic { font-size: 18px; }
  .pd2-spec-v { font-size: 14px; }

  /* Tabs */
  .pd2-tabs { top: 56px; margin: 0 -14px 20px; padding: 0 14px; }
  .pd2-tab { padding: 9px 12px; font-size: 12.5px; }

  /* Overview highlights */
  .pd2-ov-hlt { padding: 12px 8px; }
  .pd2-ov-hlt-v { font-size: 12.5px; }

  /* Location pane */
  .pd2-loc-addr-card { padding: 12px; gap: 10px; }
  .pd2-loc-addr-icon { font-size: 20px; }
  .pd2-loc-addr-main { font-size: 13px; }
  .pd2-dir-btn-full { font-size: 13.5px; padding: 12px 16px; }

  /* Details sections */
  .pd2-det-row { padding: 10px 12px; font-size: 13px; gap: 8px; }
  .pd2-det-ic { font-size: 14px; width: 18px; }
  .pd2-det-meta { flex-direction: column; align-items: flex-start; gap: 3px; }

  /* Amenities */
  .pd2-amen { grid-template-columns: 1fr 1fr; gap: 8px; }
  .pd2-amen-item { font-size: 12px; padding: 8px 10px; }

  /* Sidebar */
  .pd2-contact-top { padding: 14px 16px; }
  .pd2-contact-price { font-size: 22px; }
  .pd2-contact-body { padding: 14px 16px; }
  .pd2-btn-wa, .pd2-btn-call { font-size: 13.5px; padding: 11px 14px; }

  /* EMI */
  .pd2-emi-card { padding: 14px 16px; }

  /* Related */
  .pd2-related { padding: 0 10px 40px; }
  .pd2-rel-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
  .pd2-rel-img { height: 120px; }
  .pd2-rel-body { padding: 10px; }
  .pd2-rel-price { font-size: 14px; }
  .pd2-rel-title { font-size: 11.5px; }
}
</style>
@endpush

@section('content')
<div class="pd2-page">

{{-- Breadcrumb --}}
<div class="pd2-bc">
  <a href="{{ url('/') }}">Home</a>
  <span class="pd2-bc-sep">›</span>
  <a href="{{ route('properties.index') }}">Properties</a>
  <span class="pd2-bc-sep">›</span>
  <a href="{{ route('properties.index') }}?locality={{ urlencode($listing->locality) }}">{{ $listing->locality }}</a>
  <span class="pd2-bc-sep">›</span>
  <span class="pd2-bc-cur">{{ Str::limit($listing->title, 50) }}</span>
</div>

{{-- Main layout --}}
<div class="pd2-wrap">

  {{-- ════ LEFT COLUMN ════ --}}
  <div>

    {{-- Gallery --}}
    @php
      $allMedia = [];
      if ($listing->featured_image && file_exists(public_path($listing->featured_image)))
          $allMedia[] = ['type' => 'image', 'src' => asset($listing->featured_image)];
      foreach ($listing->images as $img)
          $allMedia[] = ['type' => 'image', 'src' => asset($img->image_path)];
      if ($listing->video_path && file_exists(public_path($listing->video_path)))
          $allMedia[] = ['type' => 'video', 'src' => asset($listing->video_path)];
      $allImages = array_values(array_map(fn($m) => $m['src'], array_filter($allMedia, fn($m) => $m['type'] === 'image')));
      $imgCount = count($allImages);
    @endphp

    <div class="pd2-gallery-card">
      <div class="pd2-gallery-hero">
        {{-- Transaction badge --}}
        <div class="pd2-trans-badge pd2-trans-{{ $listing->transaction_type }}">
          🏷 For Sale
        </div>

        @if(count($allMedia))
          <img src="{{ $allMedia[0]['src'] }}" alt="{{ $listing->title }}" class="pd2-hero-img" id="pd2MainImg"
               onclick="pd2OpenLb()" style="{{ $allMedia[0]['type']==='video' ? 'display:none;' : '' }}">
          <video id="pd2MainVideo" class="pd2-hero-video" controls preload="none"
                 style="{{ $allMedia[0]['type']==='video' ? '' : 'display:none;' }}">
            @if($allMedia[0]['type']==='video')<source src="{{ $allMedia[0]['src'] }}">@endif
          </video>
          @if($imgCount > 1)
          <div class="pd2-img-count" onclick="pd2OpenLb()" style="cursor:pointer;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            {{ $imgCount }} photos
          </div>
          @endif
        @else
          <div class="pd2-placeholder-hero">🏠</div>
        @endif
      </div>

      @if(count($allMedia) > 1)
      <div class="pd2-thumbs" id="pd2Thumbs">
        @foreach($allMedia as $i => $m)
          @if($m['type'] === 'video')
            <div class="pd2-thumb pd2-vthumb {{ $i===0?'active':'' }}" onclick="pd2Switch({{ $i }})">▶</div>
          @else
            <img src="{{ $m['src'] }}" class="pd2-thumb {{ $i===0?'active':'' }}" onclick="pd2Switch({{ $i }})" alt="Photo {{ $i+1 }}" loading="lazy">
          @endif
        @endforeach
      </div>
      @endif
    </div>

    {{-- Info card --}}
    <div class="pd2-info">

      {{-- Type pills --}}
      <div class="pd2-type-row">
        <span class="pd2-pill pd2-pill-type">{{ $listing->getTypeLabel() }}</span>
        @if($listing->furnishing)
          <span class="pd2-pill pd2-pill-fur">{{ $listing->getFurnishingLabel() }}</span>
        @endif
        @if($listing->property_age === 'new_construction')
          <span class="pd2-pill pd2-pill-new">New Construction</span>
        @endif
        @foreach($listing->tags as $tag)
          <span class="pd2-pill" style="background:#e8edf5;color:var(--n);">#{{ $tag->name }}</span>
        @endforeach
      </div>

      <h1 class="pd2-h1">{{ $listing->title }}</h1>
      <div class="pd2-locality">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        {{ $listing->locality }}{{ $listing->landmark ? ', near '.$listing->landmark : '' }}, Lucknow
        @if($listing->pincode) &nbsp;·&nbsp; {{ $listing->pincode }} @endif
      </div>

      {{-- Price strip --}}
      <div class="pd2-price-strip">
        <div>
          <div class="pd2-price-main">{{ $listing->getPriceDisplay() }}</div>
          <div class="pd2-price-neg">
            {{ $listing->price_negotiable ? '✓ Price Negotiable' : 'Fixed Price' }}
          </div>
        </div>
        @if(!$listing->price_on_request && $listing->price > 0 && $listing->area)
        @php $ppsf = round($listing->price / $listing->area); @endphp
        <div class="pd2-price-sqft">
          <div class="pd2-price-sqft-val">₹{{ number_format($ppsf) }}</div>
          <div class="pd2-price-sqft-lbl">per {{ $listing->getAreaUnitLabel() }}</div>
        </div>
        @endif
      </div>

      {{-- Specs bar --}}
      @if($listing->bedrooms !== null || $listing->bathrooms || $listing->area || $listing->balconies || $listing->floor_no !== null || $listing->parking)
      <div class="pd2-specs" style="margin-bottom:22px;">
        @if($listing->bedrooms !== null)
        <div class="pd2-spec">
          <div class="pd2-spec-ic">🛏</div>
          <div class="pd2-spec-v">{{ $listing->bedrooms == 0 ? 'Studio' : $listing->bedrooms }}</div>
          <div class="pd2-spec-l">Bedroom{{ $listing->bedrooms != 1 ? 's' : '' }}</div>
        </div>
        @endif
        @if($listing->bathrooms)
        <div class="pd2-spec">
          <div class="pd2-spec-ic">🚿</div>
          <div class="pd2-spec-v">{{ $listing->bathrooms }}</div>
          <div class="pd2-spec-l">Bathroom{{ $listing->bathrooms != 1 ? 's' : '' }}</div>
        </div>
        @endif
        @if($listing->area)
        <div class="pd2-spec">
          <div class="pd2-spec-ic">📐</div>
          <div class="pd2-spec-v">{{ number_format($listing->area) }}</div>
          <div class="pd2-spec-l">{{ $listing->getAreaUnitLabel() }}</div>
        </div>
        @endif
        @if($listing->balconies)
        <div class="pd2-spec">
          <div class="pd2-spec-ic">🌿</div>
          <div class="pd2-spec-v">{{ $listing->balconies }}</div>
          <div class="pd2-spec-l">Balcon{{ $listing->balconies != 1 ? 'ies' : 'y' }}</div>
        </div>
        @endif
        @if($listing->floor_no !== null)
        <div class="pd2-spec">
          <div class="pd2-spec-ic">🏢</div>
          <div class="pd2-spec-v">{{ $listing->floor_no }}</div>
          <div class="pd2-spec-l">Floor{{ $listing->total_floors ? ' / '.$listing->total_floors : '' }}</div>
        </div>
        @endif
        @if($listing->parking)
        <div class="pd2-spec">
          <div class="pd2-spec-ic">🚗</div>
          <div class="pd2-spec-v" style="font-size:12px;">{{ ucfirst($listing->parking) }}</div>
          <div class="pd2-spec-l">Parking</div>
        </div>
        @endif
      </div>
      @endif

      {{-- Tabs --}}
      <div class="pd2-tabs">
        <button class="pd2-tab active" data-tab="overview" onclick="pd2Tab('overview',this)">Overview</button>
        @if(count($listing->getAmenityList()))
        <button class="pd2-tab" data-tab="amenities" onclick="pd2Tab('amenities',this)">Amenities ({{ count($listing->getAmenityList()) }})</button>
        @endif
        @if($listing->lat && $listing->lng)
        <button class="pd2-tab" data-tab="location" onclick="pd2Tab('location',this)">Location & Map</button>
        @endif
        <button class="pd2-tab" data-tab="details" onclick="pd2Tab('details',this)">Property Details</button>
      </div>

      {{-- Tab: Overview --}}
      <div class="pd2-pane" id="pd2-overview">
        @php
          $highlights = array_values(array_filter([
            $listing->bedrooms !== null ? ['🛏', $listing->bedrooms == 0 ? 'Studio' : $listing->bedrooms.' BHK', 'Bedrooms'] : null,
            $listing->area         ? ['📐', number_format($listing->area).' '.$listing->getAreaUnitLabel(), 'Area'] : null,
            $listing->furnishing   ? ['✨', $listing->getFurnishingLabel(), 'Furnishing'] : null,
            $listing->property_age ? ['🏗', $listing->getAgeLabel(), 'Property Age'] : null,
            $listing->facing       ? ['🧭', ucfirst($listing->facing).' Facing', 'Facing'] : null,
            $listing->floor_no !== null ? ['🏢', $listing->floor_no.($listing->total_floors ? '/'.$listing->total_floors : '').' Floor', 'Floor'] : null,
          ]));
        @endphp
        @if(count($highlights))
        <div class="pd2-overview-highlights">
          @foreach($highlights as $h)
          <div class="pd2-ov-hlt">
            <span class="pd2-ov-hlt-ic">{{ $h[0] }}</span>
            <span class="pd2-ov-hlt-v">{{ $h[1] }}</span>
            <span class="pd2-ov-hlt-l">{{ $h[2] }}</span>
          </div>
          @endforeach
        </div>
        @endif
        <div class="pd2-sec-title">About This Property</div>
        <div class="pd2-desc">{!! $listing->description !!}</div>

        @if($listing->brochure_path && file_exists(public_path($listing->brochure_path)))
        <a href="{{ asset($listing->brochure_path) }}" target="_blank" rel="noopener" class="pd2-brochure-btn">
          <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          Download Brochure (PDF)
        </a>
        @endif

        @if($listing->is_site && $listing->plot_segments)
        @php $ps = $listing->plot_segments; @endphp
        <div class="pd2-sec-title" style="margin-top:22px;">📐 Plot Configuration</div>
        @if(!empty($ps['min_area']) || !empty($ps['max_area']) || !empty($ps['total_plots']))
        <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
          @if(!empty($ps['min_area']))
          <div style="background:#f1f5f9;border-radius:10px;padding:12px 18px;text-align:center;min-width:100px;">
            <div style="font-size:16px;font-weight:800;color:var(--n);">{{ number_format($ps['min_area']) }}</div>
            <div style="font-size:11px;color:var(--g);margin-top:2px;">Min Area ({{ $ps['unit'] ?? 'sq.yd' }})</div>
          </div>
          @endif
          @if(!empty($ps['max_area']))
          <div style="background:#f1f5f9;border-radius:10px;padding:12px 18px;text-align:center;min-width:100px;">
            <div style="font-size:16px;font-weight:800;color:var(--n);">{{ number_format($ps['max_area']) }}</div>
            <div style="font-size:11px;color:var(--g);margin-top:2px;">Max Area ({{ $ps['unit'] ?? 'sq.yd' }})</div>
          </div>
          @endif
          @if(!empty($ps['total_plots']))
          <div style="background:#f1f5f9;border-radius:10px;padding:12px 18px;text-align:center;min-width:100px;">
            <div style="font-size:16px;font-weight:800;color:var(--n);">{{ number_format($ps['total_plots']) }}</div>
            <div style="font-size:11px;color:var(--g);margin-top:2px;">Total Plots</div>
          </div>
          @endif
        </div>
        @endif
        @if(!empty($ps['segments']) && count($ps['segments']))
        @php
          $fmtP = function($p) {
              $p = (float)$p;
              if ($p >= 10000000) return '₹ '.number_format($p/10000000, 2).' Cr';
              if ($p >= 100000)   return '₹ '.number_format($p/100000,   2).' Lakh';
              return '₹ '.number_format($p);
          };
        @endphp
        <table class="pd2-plot-seg-table">
          <thead>
            <tr>
              <th>Segment / Type</th>
              <th>Area</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ps['segments'] as $seg)
            @if(!empty($seg['label']) || !empty($seg['area']))
            <tr>
              <td>{{ $seg['label'] ?? '—' }}</td>
              <td>{{ !empty($seg['area']) ? number_format($seg['area']).' '.($ps['unit'] ?? 'sq.yd') : '—' }}</td>
              <td>{{ !empty($seg['price']) ? $fmtP((float)$seg['price']) : '—' }}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
        @endif
        @endif

        @if($listing->tags->count())
        <div class="pd2-sec-title" style="margin-top:22px;">Nearby Localities</div>
        <div class="pd2-prop-tags">
          @foreach($listing->tags as $tag)
            <a href="{{ route('properties.index') }}?locality={{ urlencode($tag->name) }}" class="pd2-prop-tag">📍 {{ $tag->name }}</a>
          @endforeach
        </div>
        @endif
      </div>

      {{-- Tab: Amenities --}}
      @if(count($listing->getAmenityList()))
      <div class="pd2-pane" id="pd2-amenities">
        <div class="pd2-sec-title">Amenities</div>
        <div class="pd2-amen">
          @foreach($listing->getAmenityList() as $a)
          <div class="pd2-amen-item">
            <div class="pd2-amen-chk">
              <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg>
            </div>
            {{ $a }}
          </div>
          @endforeach
        </div>
      </div>
      @endif

      {{-- Tab: Location --}}
      @if($listing->lat && $listing->lng)
      <div class="pd2-pane" id="pd2-location">
        <div class="pd2-sec-title">Location & Map</div>
        <div id="pd2Map"></div>
        <div class="pd2-loc-info">
          <div class="pd2-loc-addr-card">
            <span class="pd2-loc-addr-icon">📍</span>
            <div>
              <div class="pd2-loc-addr-main">{{ $listing->address }}</div>
              <div class="pd2-loc-addr-sub">{{ $listing->locality }}, Lucknow{{ $listing->pincode ? ' — '.$listing->pincode : '' }}</div>
            </div>
          </div>
          @if($listing->landmark)
          <div class="pd2-loc-landmark">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Near {{ $listing->landmark }}
          </div>
          @endif
          <a href="https://www.google.com/maps/dir/?api=1&destination={{ $listing->lat }},{{ $listing->lng }}"
             target="_blank" rel="noopener" class="pd2-dir-btn-full">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
            Get Directions on Google Maps
          </a>
        </div>
      </div>
      @endif

      {{-- Tab: Property Details --}}
      @php
        $configDet = array_filter([
          'Bedrooms'  => ['🛏', $listing->bedrooms !== null ? ($listing->bedrooms == 0 ? 'Studio' : $listing->bedrooms.' BHK') : null],
          'Bathrooms' => ['🚿', $listing->bathrooms ?: null],
          'Balconies' => ['🌿', $listing->balconies ?: null],
          $listing->getAreaLabel() => ['📐', $listing->area ? number_format($listing->area, 2).' '.$listing->getAreaUnitLabel() : null],
          'Floor'     => ['🏢', $listing->floor_no !== null ? $listing->floor_no.' of '.($listing->total_floors ?? '?').' floors' : null],
          'Parking'   => ['🚗', $listing->parking ? ucfirst($listing->parking) : null],
        ], fn($v) => $v[1] !== null && $v[1] !== '');
        $propDet = array_filter([
          'Property Type' => ['🏠', $listing->getTypeLabel()],
          'Furnishing'    => ['✨', $listing->getFurnishingLabel()],
          'Property Age'  => ['📅', $listing->getAgeLabel()],
          'Facing'        => ['🧭', $listing->facing ? ucfirst($listing->facing) : null],
        ], fn($v) => $v[1] !== null && $v[1] !== '');
        $locDet = array_filter([
          'Locality'  => ['📍', $listing->locality ?: null],
          'Landmark'  => ['🏛', $listing->landmark ?: null],
          'Pincode'   => ['📮', $listing->pincode ?: null],
        ], fn($v) => $v[1] !== null && $v[1] !== '');
      @endphp
      <div class="pd2-pane" id="pd2-details">
        <div class="pd2-sec-title">Property Details</div>
        @if(count($configDet))
        <div class="pd2-det-section">
          <div class="pd2-det-sec-hd">Configuration</div>
          <div class="pd2-det-grid">
            @foreach($configDet as $lbl => $item)
            <div class="pd2-det-row">
              <span class="pd2-det-ic">{{ $item[0] }}</span>
              <span class="pd2-det-lbl">{{ $lbl }}</span>
              <span class="pd2-det-val">{{ $item[1] }}</span>
            </div>
            @endforeach
          </div>
        </div>
        @endif
        @if(count($propDet))
        <div class="pd2-det-section">
          <div class="pd2-det-sec-hd">Property Info</div>
          <div class="pd2-det-grid">
            @foreach($propDet as $lbl => $item)
            <div class="pd2-det-row">
              <span class="pd2-det-ic">{{ $item[0] }}</span>
              <span class="pd2-det-lbl">{{ $lbl }}</span>
              <span class="pd2-det-val">{{ $item[1] }}</span>
            </div>
            @endforeach
          </div>
        </div>
        @endif
        @if(count($locDet))
        <div class="pd2-det-section">
          <div class="pd2-det-sec-hd">Location</div>
          <div class="pd2-det-grid">
            @foreach($locDet as $lbl => $item)
            <div class="pd2-det-row">
              <span class="pd2-det-ic">{{ $item[0] }}</span>
              <span class="pd2-det-lbl">{{ $lbl }}</span>
              <span class="pd2-det-val">{{ $item[1] }}</span>
            </div>
            @endforeach
          </div>
        </div>
        @endif
        @php $typeRows = $listing->getDetailRows(); @endphp
        @if(count($typeRows))
        <div class="pd2-det-section">
          <div class="pd2-det-sec-hd">{{ $listing->getTypeLabel() }} Specifics</div>
          <div class="pd2-det-grid">
            @foreach($typeRows as $lbl => $val)
            <div class="pd2-det-row">
              <span class="pd2-det-ic">•</span>
              <span class="pd2-det-lbl">{{ $lbl }}</span>
              <span class="pd2-det-val">{{ $val }}</span>
            </div>
            @endforeach
          </div>
        </div>
        @endif
        <div class="pd2-det-meta">
          <span class="pd2-det-meta-id">📋 Listing #{{ $listing->id }}</span>
          <span>Posted {{ $listing->created_at?->diffForHumans() }} · {{ number_format($listing->views) }} views{{ $listing->seller ? ' · '.$listing->seller->name : '' }}</span>
        </div>
      </div>

    </div>{{-- /pd2-info --}}
  </div>{{-- /left column --}}

  {{-- ════ SIDEBAR ════ --}}
  <div class="pd2-sidebar">

    {{-- Contact card --}}
    <div class="pd2-contact">
      <div class="pd2-contact-top">
        <div class="pd2-contact-price">{{ $listing->getPriceDisplay() }}</div>
        <div class="pd2-contact-price-sub">
          {{ $listing->price_negotiable ? '✓ Negotiable' : 'Fixed Price' }}
        </div>
      </div>
      <div class="pd2-contact-body">

        {{-- Seller info --}}
        <div class="pd2-seller">
          <div class="pd2-seller-av">
            @if($listing->seller->profile_photo && file_exists(public_path($listing->seller->profile_photo)))
              <img src="{{ asset($listing->seller->profile_photo) }}" alt="{{ $listing->seller->name }}">
            @else
              {{ strtoupper(substr($listing->seller->name, 0, 1)) }}
            @endif
          </div>
          <div>
            <div class="pd2-seller-name">{{ $listing->seller->name }}</div>
            <div class="pd2-seller-sub">{{ $listing->seller->city ?? 'Lucknow' }}</div>
            <div class="pd2-verified" style="margin-top:4px;">
              <svg width="9" height="9" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg>
              Verified Seller
            </div>
          </div>
        </div>

        @if(session('inquiry_sent'))
          <div class="pd2-success">✓ {{ session('inquiry_sent') }}</div>
        @endif

        {{-- WhatsApp CTA --}}
        @php
          $waNum = preg_replace('/[^0-9]/', '', $listing->seller->whatsapp ?: $listing->seller->phone ?? '9415017678');
          $waMsg = urlencode('Hi, I saw your property "' . $listing->title . '" on DSD Properties. I am interested. Is it still available?');
        @endphp
        <a href="https://wa.me/91{{ ltrim($waNum,'91') }}?text={{ $waMsg }}" target="_blank" rel="noopener" class="pd2-btn-wa">
          <svg width="19" height="19" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp Now
        </a>

        {{-- Call CTA --}}
        @if($listing->seller->phone)
        <a href="tel:+91{{ ltrim(preg_replace('/[^0-9]/','',$listing->seller->phone),'91') }}" class="pd2-btn-call">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.55a16 16 0 0 0 6.29 6.29l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          Call Seller
        </a>
        @endif

        {{-- Collapsible inquiry form --}}
        <div class="pd2-form-toggle" id="pd2FormToggle" onclick="pd2ToggleForm()">
          <span>Send Inquiry</span>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
        <div class="pd2-form-body" id="pd2FormBody">
          <form method="POST" action="{{ route('properties.inquiry', $listing) }}">
            @csrf
            <input type="text"  name="name"    class="pd2-inp" value="{{ old('name') }}"  placeholder="Your full name" required>
            @error('name')<div style="font-size:11.5px;color:#dc2626;margin:-8px 0 8px;">{{ $message }}</div>@enderror
            <input type="tel"   name="phone"   class="pd2-inp" value="{{ old('phone') }}" placeholder="Phone number" required>
            @error('phone')<div style="font-size:11.5px;color:#dc2626;margin:-8px 0 8px;">{{ $message }}</div>@enderror
            <input type="email" name="email"   class="pd2-inp" value="{{ old('email') }}" placeholder="Email (optional)">
            <textarea name="message" class="pd2-inp pd2-textarea" placeholder="I'm interested in this property. Please contact me.">{{ old('message') }}</textarea>
            <button type="submit" class="pd2-btn-send">Send Inquiry →</button>
          </form>
        </div>

      </div>
    </div>

    {{-- EMI Estimator --}}
    @if(!$listing->price_on_request && $listing->price > 0)
    @php $loanAmt = round($listing->price * 0.8); @endphp
    <div class="pd2-emi-card">
      <div class="pd2-emi-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        EMI Estimator
      </div>
      <div class="pd2-emi-row">
        <span class="pd2-emi-lbl">Loan Amount (80%)</span>
        <span class="pd2-emi-val" id="pd2LoanAmt">{{ '₹ '.number_format($loanAmt) }}</span>
      </div>
      <div class="pd2-emi-row">
        <span class="pd2-emi-lbl">Interest Rate</span>
        <span class="pd2-emi-val"><span id="pd2RateVal">8.5</span>% p.a.</span>
      </div>
      <input type="range" class="pd2-emi-slider" id="pd2RateSlider" min="7" max="12" step="0.5" value="8.5" oninput="pd2CalcEMI()">
      <div class="pd2-emi-row">
        <span class="pd2-emi-lbl">Loan Tenure</span>
        <span class="pd2-emi-val"><span id="pd2TenureVal">20</span> years</span>
      </div>
      <input type="range" class="pd2-emi-slider" id="pd2TenureSlider" min="5" max="30" step="1" value="20" oninput="pd2CalcEMI()">
      <div class="pd2-emi-result">
        <div>
          <div class="pd2-emi-lbl-w">Monthly EMI</div>
          <div class="pd2-emi-note">Approximate estimate</div>
        </div>
        <div class="pd2-emi-amount" id="pd2EmiAmt">—</div>
      </div>
    </div>
    @endif

    {{-- Share --}}
    <div class="pd2-share-card">
      <div class="pd2-share-title">Share This Property</div>
      <div class="pd2-share-btns">
        <button class="pd2-share-btn pd2-share-link" onclick="pd2CopyLink()">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
          <span id="pd2CopyTxt">Copy Link</span>
        </button>
        <a class="pd2-share-btn pd2-share-wa" target="_blank" rel="noopener"
           href="https://wa.me/?text={{ urlencode($listing->title.' — '.$listing->getPriceDisplay().' — '.url()->current()) }}">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp
        </a>
      </div>
    </div>

  </div>{{-- /sidebar --}}
</div>{{-- /pd2-wrap --}}

{{-- Lightbox --}}
<div class="pd2-lb" id="pd2Lb" onclick="if(event.target===this)pd2CloseLb()">
  <button class="pd2-lb-close" onclick="pd2CloseLb()">×</button>
  <button class="pd2-lb-arrow pd2-lb-prev" onclick="pd2LbNav(-1)">‹</button>
  <div class="pd2-lb-inner"><img src="" id="pd2LbImg" alt=""></div>
  <button class="pd2-lb-arrow pd2-lb-next" onclick="pd2LbNav(1)">›</button>
  <div class="pd2-lb-counter"><span id="pd2LbCount">1</span> / {{ $imgCount }}</div>
</div>

{{-- Related properties --}}
@if($related->count())
<div class="pd2-related">
  <div class="pd2-related-hd">More Properties in {{ $listing->locality }}</div>
  <div class="pd2-rel-grid">
    @foreach($related as $r)
    <a href="{{ route('properties.show', $r->slug) }}" class="pd2-rel-card">
      <div class="pd2-rel-img">
        @if($r->featured_image && file_exists(public_path($r->featured_image)))
          <img src="{{ asset($r->featured_image) }}" alt="{{ $r->title }}" loading="lazy">
        @elseif($r->images->first())
          <img src="{{ asset($r->images->first()->image_path) }}" alt="{{ $r->title }}" loading="lazy">
        @else
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:40px;background:#f1f5f9;">🏠</div>
        @endif
        <div class="pd2-rel-badge">For Sale</div>
      </div>
      <div class="pd2-rel-body">
        <div class="pd2-rel-price">{{ $r->getPriceDisplay() }}</div>
        <div class="pd2-rel-title">{{ Str::limit($r->title, 55) }}</div>
        <div class="pd2-rel-specs">
          @if($r->bedrooms !== null)<span>🛏 {{ $r->bedrooms == 0 ? 'Studio' : $r->bedrooms.' BHK' }}</span>@endif
          @if($r->area)<span>📐 {{ number_format($r->area) }} {{ $r->getAreaUnitLabel() }}</span>@endif
        </div>
      </div>
    </a>
    @endforeach
  </div>
</div>
@endif

</div>{{-- /pd2-page --}}
@endsection

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIrA0YRspz_UGlpWuNR1_LXX_8DfHWdj4&libraries=visualization,places&callback=pmInitMap&loading=async">
</script>

@push('scripts')
<script>
// ── Gallery ──────────────────────────────────────────────────────
var pd2Media   = @json($allMedia);
var pd2Images  = pd2Media.filter(function(m){ return m.type==='image'; }).map(function(m){ return m.src; });
var pd2CurIdx  = 0;
var pd2LbIdx   = 0;

var pd2MI = document.getElementById('pd2MainImg');
var pd2MV = document.getElementById('pd2MainVideo');

function pd2Switch(i) {
  pd2CurIdx = i;
  document.querySelectorAll('.pd2-thumb').forEach(function(t,idx){ t.classList.toggle('active', idx===i); });
  var m = pd2Media[i];
  if (m.type === 'video') {
    if (pd2MI) pd2MI.style.display = 'none';
    if (pd2MV) { pd2MV.style.display='block'; pd2MV.src=m.src; pd2MV.load(); }
  } else {
    if (pd2MV && !pd2MV.paused) pd2MV.pause();
    if (pd2MV) pd2MV.style.display = 'none';
    if (pd2MI) { pd2MI.style.display='block'; pd2MI.src=m.src; }
    var ii = pd2Images.indexOf(m.src); if (ii !== -1) pd2LbIdx = ii;
  }
}

function pd2OpenLb() {
  if (!pd2Images.length) return;
  if (pd2Media[pd2CurIdx] && pd2Media[pd2CurIdx].type !== 'image') return;
  document.getElementById('pd2LbImg').src = pd2Images[pd2LbIdx];
  document.getElementById('pd2LbCount').textContent = pd2LbIdx + 1;
  document.getElementById('pd2Lb').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function pd2CloseLb() {
  document.getElementById('pd2Lb').classList.remove('open');
  document.body.style.overflow = '';
}
function pd2LbNav(d) {
  pd2LbIdx = (pd2LbIdx + d + pd2Images.length) % pd2Images.length;
  document.getElementById('pd2LbImg').src = pd2Images[pd2LbIdx];
  document.getElementById('pd2LbCount').textContent = pd2LbIdx + 1;
}
document.addEventListener('keydown', function(e){
  if (!document.getElementById('pd2Lb').classList.contains('open')) return;
  if (e.key==='Escape') pd2CloseLb();
  if (e.key==='ArrowLeft')  pd2LbNav(-1);
  if (e.key==='ArrowRight') pd2LbNav(1);
});

// ── Tabs ─────────────────────────────────────────────────────────
function pd2Tab(id, btn) {
  document.querySelectorAll('.pd2-tab').forEach(function(t){ t.classList.remove('active'); });
  btn.classList.add('active');
  var el = document.getElementById('pd2-' + id);
  if (el) {
    var top = el.getBoundingClientRect().top + window.pageYOffset - 130;
    window.scrollTo({ top: top, behavior: 'smooth' });
  }
  @if($listing->lat && $listing->lng)
  if (id === 'location' && !window.pd2MapLoaded) { pd2InitMap(); window.pd2MapLoaded = true; }
  @endif
}
// Auto-highlight tab on scroll
(function(){
  if (!window.IntersectionObserver) return;
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (!e.isIntersecting) return;
      var id = e.target.id.replace('pd2-','');
      document.querySelectorAll('.pd2-tab').forEach(function(t){
        t.classList.toggle('active', t.getAttribute('data-tab') === id);
      });
      @if($listing->lat && $listing->lng)
      if (id === 'location' && !window.pd2MapLoaded && window.google && window.google.maps) {
        pd2InitMap(); window.pd2MapLoaded = true;
      }
      @endif
    });
  }, { rootMargin: '-20% 0px -70% 0px', threshold: 0 });
  document.querySelectorAll('.pd2-pane[id]').forEach(function(p){ obs.observe(p); });
})();

// ── Inquiry form toggle ───────────────────────────────────────────
function pd2ToggleForm() {
  var body   = document.getElementById('pd2FormBody');
  var toggle = document.getElementById('pd2FormToggle');
  var open   = body.classList.toggle('open');
  toggle.classList.toggle('open', open);
}
// Auto-open if there are errors
@if($errors->any()) pd2ToggleForm(); @endif

// ── EMI Calculator ────────────────────────────────────────────────
@if(!$listing->price_on_request && $listing->price > 0)
var pd2LoanBase = {{ round($listing->price * 0.8) }};
function pd2CalcEMI() {
  var r = parseFloat(document.getElementById('pd2RateSlider').value);
  var n = parseInt(document.getElementById('pd2TenureSlider').value);
  document.getElementById('pd2RateVal').textContent = r.toFixed(1);
  document.getElementById('pd2TenureVal').textContent = n;
  var mr = r / 100 / 12;
  var months = n * 12;
  var emi = pd2LoanBase * mr * Math.pow(1+mr,months) / (Math.pow(1+mr,months)-1);
  var fmt = '₹ ';
  if (emi >= 100000) fmt += (emi/100000).toFixed(2) + ' L';
  else fmt += Math.round(emi).toLocaleString('en-IN');
  fmt += '/mo';
  document.getElementById('pd2EmiAmt').textContent = fmt;
}
pd2CalcEMI();
@endif

// ── Share / copy link ─────────────────────────────────────────────
function pd2CopyLink() {
  navigator.clipboard.writeText(window.location.href).then(function(){
    var el = document.getElementById('pd2CopyTxt');
    el.textContent = 'Copied!';
    setTimeout(function(){ el.textContent = 'Copy Link'; }, 2000);
  });
}

// ── Property Page Analytics ──────────────────────────────────────
(function(){
  if (typeof gtag !== 'function') return;

  var _p = {
    property_id:      {{ $listing->id }},
    property_title:   '{{ addslashes($listing->title) }}',
    property_type:    '{{ $listing->property_type }}',
    transaction_type: '{{ $listing->transaction_type }}',
    locality:         '{{ addslashes($listing->locality) }}',
    price:            {{ $listing->price }},
  };

  function trackP(ev, extra) {
    gtag('event', ev, Object.assign({}, _p, extra || {}));
  }

  // 1. Property view — fires immediately on page load
  trackP('property_view', {
    event_category: 'property',
    has_photos:   {{ count($allMedia) > 0   ? 'true' : 'false' }},
    has_video:    {{ ($listing->video_path || $listing->youtube_url) ? 'true' : 'false' }},
    has_brochure: {{ $listing->brochure_path ? 'true' : 'false' }},
    has_map:      {{ ($listing->lat && $listing->lng) ? 'true' : 'false' }},
    photo_count:  {{ count($allMedia) }},
  });

  document.addEventListener('DOMContentLoaded', function() {

    // 2. WhatsApp CTA (contact card)
    var waBtn = document.querySelector('.pd2-contact .pd2-btn-wa');
    if (waBtn) waBtn.addEventListener('click', function() {
      trackP('whatsapp_click', { event_category: 'lead' });
    });

    // 3. Phone call CTA
    var callBtn = document.querySelector('.pd2-btn-call');
    if (callBtn) callBtn.addEventListener('click', function() {
      trackP('phone_call', { event_category: 'lead' });
    });

    // 4. Inquiry form open
    var origToggle = window.pd2ToggleForm;
    window.pd2ToggleForm = function() {
      origToggle && origToggle();
      var body = document.getElementById('pd2FormBody');
      if (body && body.classList.contains('open'))
        trackP('inquiry_form_open', { event_category: 'lead' });
    };

    // 5. Inquiry form submit
    var iForm = document.querySelector('#pd2FormBody form');
    if (iForm) iForm.addEventListener('submit', function() {
      trackP('inquiry_submit', { event_category: 'lead' });
    });

    // 6. Gallery / lightbox open
    var origLb = window.pd2OpenLb;
    window.pd2OpenLb = function() {
      origLb && origLb();
      trackP('gallery_view', { event_category: 'engagement', photo_count: typeof pd2Images !== 'undefined' ? pd2Images.length : 0 });
    };

    // 7. Video play
    var vid = document.getElementById('pd2MainVideo');
    if (vid) vid.addEventListener('play', function() {
      trackP('video_play', { event_category: 'engagement' });
    }, { once: true });

    // 8. Tab section view
    var origTab = window.pd2Tab;
    window.pd2Tab = function(id, btn) {
      origTab && origTab(id, btn);
      trackP('tab_view', { event_category: 'engagement', tab_name: id });
    };

    // 9. Copy link share
    var origCopy = window.pd2CopyLink;
    window.pd2CopyLink = function() {
      origCopy && origCopy();
      trackP('share', { event_category: 'engagement', method: 'copy_link' });
    };

    // 10. WhatsApp share button
    var waShare = document.querySelector('.pd2-share-wa');
    if (waShare) waShare.addEventListener('click', function() {
      trackP('share', { event_category: 'engagement', method: 'whatsapp' });
    });

    // 11. Brochure download
    var brochureBtn = document.querySelector('.pd2-brochure-btn');
    if (brochureBtn) brochureBtn.addEventListener('click', function() {
      trackP('brochure_download', { event_category: 'engagement' });
    });

    // 12. EMI calculator — first use
    var emiUsed = false;
    document.querySelectorAll('.pd2-emi-slider').forEach(function(s) {
      s.addEventListener('input', function() {
        if (emiUsed) return;
        emiUsed = true;
        trackP('emi_calculator_use', { event_category: 'engagement' });
      });
    });

    // 13. Related property clicks
    document.querySelectorAll('.pd2-rel-card').forEach(function(card) {
      card.addEventListener('click', function() {
        trackP('related_property_click', { event_category: 'engagement', clicked_url: this.href });
      });
    });

    // 14. Scroll depth milestones
    var hit = {};
    window.addEventListener('scroll', function() {
      var pct = Math.min(100, Math.round((window.scrollY + window.innerHeight) / document.body.scrollHeight * 100));
      [25, 50, 75, 90].forEach(function(m) {
        if (!hit[m] && pct >= m) {
          hit[m] = true;
          trackP('scroll_depth', { event_category: 'engagement', depth_percent: m });
        }
      });
    }, { passive: true });

  });
})();

// ── Map ───────────────────────────────────────────────────────────
@if($listing->lat && $listing->lng)
function pd2InitMap() {
  var pos = { lat: {{ $listing->lat }}, lng: {{ $listing->lng }} };
  var map = new google.maps.Map(document.getElementById('pd2Map'), {
    center: pos, zoom: 14,
    mapTypeControl: false, streetViewControl: false, fullscreenControl: false,
    styles: [{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]}]
  });
  new google.maps.Marker({ map: map, position: pos, title: '{{ addslashes($listing->title) }}',
    icon: { path: google.maps.SymbolPath.CIRCLE, scale: 10, fillColor: '#008080', fillOpacity: 1, strokeColor: '#fff', strokeWeight: 2 }
  });
}
@endif
</script>
@endpush
