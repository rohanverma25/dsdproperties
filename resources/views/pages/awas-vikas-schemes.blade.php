@extends('layouts.user-app')

@section('title', 'Awas Vikas Schemes Lucknow 2026 – UP Housing Board Projects | DSD Properties')
@section('meta_description', 'Browse all UP Awas Vikas Parishad (UPAVP) housing schemes in Lucknow 2026 — plots, flats & townships. Updated prices, possession dates & availability. EWS, LIG, MIG, HIG categories.')
@section('meta_keywords', 'Awas Vikas schemes Lucknow 2026, UP Awas Vikas Parishad, UPAVP Lucknow, government housing scheme Lucknow, Awas Vikas plots Lucknow, Awas Vikas flats Lucknow, EWS LIG MIG HIG Lucknow, UP housing board schemes, affordable housing Lucknow')

@push('head')
    <link rel="canonical" href="{{ url()->current() }}" />

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is UP Awas Vikas Parishad (UPAVP)?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "UP Awas Vikas Parishad (UPAVP) is a government body under the Uttar Pradesh government that develops and allots affordable housing — plots, flats and townships — across UP. In Lucknow, UPAVP has developed several colonies including Indira Nagar, Kanpur Road, Aliganj and other areas. Properties allotted by UPAVP carry clear government-backed titles."
      }
    },
    {
      "@type": "Question",
      "name": "How do I apply for an Awas Vikas scheme in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Applications for active UPAVP schemes can be submitted through the official portal at upavp.in. For FCFS schemes, apply directly and allotment is on a first-come basis. For lottery schemes, submit during the application window and await the draw. DSD Properties can guide you through eligibility and documentation — contact us for a free consultation."
      }
    },
    {
      "@type": "Question",
      "name": "Are home loans available on Awas Vikas plots and flats?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Most nationalised and major private banks offer home loans on UPAVP-allotted properties, as UPAVP is a government authority. You will need your allotment letter, payment receipts, Aadhaar, PAN and address proof. EWS and LIG category buyers may also be eligible for PMAY CLSS interest subsidy."
      }
    },
    {
      "@type": "Question",
      "name": "What is the difference between Awas Vikas and LDA schemes?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "LDA (Lucknow Development Authority) focuses on planned township development within the Lucknow Metropolitan Area. UPAVP (UP Awas Vikas Parishad) is a state-level authority that develops housing colonies across all districts of Uttar Pradesh. Both offer government-backed properties with clear titles, but their schemes, pricing and locations differ. DSD Properties can help you compare and choose the right scheme."
      }
    },
    {
      "@type": "Question",
      "name": "What categories of housing does Awas Vikas offer?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "UPAVP schemes cover all income categories: EWS (Economically Weaker Section), LIG (Lower Income Group), MIG (Middle Income Group) and HIG (Higher Income Group). Plots, independent floors and multi-storey flats are available depending on the specific scheme and location."
      }
    }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "RealEstateAgent",
  "name": "DSD Properties",
  "url": "https://dsdproperties.in",
  "telephone": "+918595002933",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "226025",
    "addressCountry": "IN"
  },
  "areaServed": { "@type": "City", "name": "Lucknow" },
  "knowsAbout": ["Awas Vikas schemes Lucknow", "UPAVP Lucknow", "government housing scheme Lucknow"]
}
</script>

<style>
.av-page { background-color: var(--bg-secondary, #f3f4f6); min-height: 100vh; }

/* HERO */
.av-hero {
    background: linear-gradient(135deg, #1a3a5c 0%, #0d5c4a 60%, #008080 100%);
    padding: 3rem 1rem 2.5rem;
    color: #fff;
}
.av-hero h1 { font-size: clamp(1.4rem, 3vw, 2.1rem); font-weight: 700; margin-bottom: .4rem; }
.av-hero .hero-sub { font-size: .92rem; opacity: .85; max-width: 680px; margin: .4rem 0 0; line-height: 1.6; }
.hero-stats { display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1.25rem; }
.stat-pill {
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.22);
    border-radius: 50px; padding: .3rem .9rem; font-size: .78rem; font-weight: 500;
}
.hero-cta-row { display: flex; flex-wrap: wrap; gap: .75rem; margin-top: 1.5rem; align-items: center; }
.hero-btn-primary {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #fff; color: #1a3a5c; font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px; text-decoration: none;
    font-family: 'Poppins', sans-serif; transition: background .15s;
}
.hero-btn-primary:hover { background: #e0f2f1; color: #1a3a5c; text-decoration: none; }
.hero-btn-wa {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #25d366; color: #fff; font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px; text-decoration: none;
    font-family: 'Poppins', sans-serif; transition: background .15s;
}
.hero-btn-wa:hover { background: #1ebe5d; color: #fff; text-decoration: none; }

/* CONTROLS */
.av-controls {
    background: var(--bg-primary, #fff); border-bottom: 1px solid var(--border-color, #e5e7eb);
    padding: .75rem 1rem; position: sticky; top: 0; z-index: 40;
}
.av-controls-inner { max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: .5rem; align-items: center; }
.av-search {
    flex: 1; min-width: 180px; padding: .45rem .8rem;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .85rem; background: var(--input-bg, #fff);
    color: var(--text-primary, #111827); font-family: 'Poppins', sans-serif;
}
.av-search:focus { outline: none; border-color: #1a3a5c; box-shadow: 0 0 0 3px rgba(26,58,92,.1); }
.av-filter-btn {
    padding: .38rem .9rem; border: 1px solid var(--border-color, #d1d5db); border-radius: 50px;
    font-size: .78rem; font-weight: 500; cursor: pointer;
    background: var(--bg-primary, #fff); color: var(--text-secondary, #4b5563);
    transition: all .15s; font-family: 'Poppins', sans-serif; white-space: nowrap;
}
.av-filter-btn:hover, .av-filter-btn.active { background: #1a3a5c; color: #fff; border-color: #1a3a5c; }
.av-sort {
    padding: .38rem .7rem; border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .8rem; background: var(--input-bg, #fff);
    color: var(--text-primary, #111827); font-family: 'Poppins', sans-serif; cursor: pointer;
}
.av-count { font-size: .8rem; color: var(--text-tertiary, #6b7280); white-space: nowrap; }

/* GRID */
.av-grid {
    max-width: 1200px; margin: 0 auto; padding: 1.25rem 1rem;
    display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.1rem;
}

/* CARD */
.av-card {
    background: var(--card-bg, #fff); border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 14px; overflow: hidden; transition: transform .2s, box-shadow .2s;
    display: flex; flex-direction: column; box-shadow: 0 1px 4px rgba(26,58,92,.06);
}
.av-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(26,58,92,.12); }
.av-card.featured { border-color: #008080; border-width: 1.5px; }

.av-card-header {
    background: linear-gradient(135deg, #1a3a5c, #0d5c4a);
    padding: .9rem 1rem .75rem; position: relative;
}
.card-id   { font-size: .68rem; color: rgba(255,255,255,.5); letter-spacing: .05em; margin-bottom: .2rem; }
.card-name { font-size: .98rem; font-weight: 600; color: #fff; line-height: 1.35; margin: 0; }
.card-loc  { font-size: .75rem; color: rgba(255,255,255,.68); margin-top: .28rem; display: flex; align-items: center; gap: .25rem; }

.av-badge {
    position: absolute; top: .85rem; right: .85rem;
    padding: .22rem .65rem; border-radius: 50px;
    font-size: .68rem; font-weight: 600; letter-spacing: .04em; text-transform: uppercase;
}
.badge-active    { background: #d1fae5; color: #065f46; }
.badge-upcoming  { background: #fef3c7; color: #92400e; }
.badge-completed { background: #dbeafe; color: #1e40af; }
.badge-paused    { background: #f3f4f6; color: #374151; }

/* Progress */
.av-progress { padding: .6rem 1rem; border-bottom: 1px solid var(--border-color, #e5e7eb); }
.prog-label  { display: flex; justify-content: space-between; font-size: .7rem; color: var(--text-tertiary, #6b7280); margin-bottom: .28rem; }
.prog-bar    { height: 5px; background: var(--bg-tertiary, #e5e7eb); border-radius: 99px; overflow: hidden; }
.prog-fill   { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #1a3a5c, #008080); }

/* Meta */
.av-meta { padding: .65rem 1rem; display: grid; grid-template-columns: 1fr 1fr; gap: .45rem; }
.meta-label { font-size: .67rem; color: var(--text-tertiary, #6b7280); text-transform: uppercase; letter-spacing: .04em; }
.meta-value { font-size: .8rem; font-weight: 600; color: var(--text-primary, #111827); margin-top: 1px; }
.meta-value.avail { color: #059669; }

/* Tags */
.av-tags { padding: 0 1rem .6rem; display: flex; flex-wrap: wrap; gap: .3rem; }
.av-tag {
    font-size: .67rem; padding: .18rem .55rem;
    background: var(--bg-secondary, #f3f4f6); color: var(--text-secondary, #4b5563);
    border-radius: 50px; border: 1px solid var(--border-color, #e5e7eb);
}

/* Description */
.av-desc { padding: 0 1rem .65rem; font-size: .8rem; color: var(--text-secondary, #4b5563); line-height: 1.6; flex: 1; }

/* Card footer */
.av-card-foot { padding: .7rem 1rem; border-top: 1px solid var(--border-color, #e5e7eb); display: flex; gap: .4rem; flex-wrap: wrap; align-items: center; }
.btn-av {
    flex: 1; min-width: 90px; padding: .48rem .7rem; background: #1a3a5c; color: #fff;
    border: none; border-radius: 8px; font-size: .76rem; font-weight: 600; cursor: pointer;
    text-align: center; text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s; display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
}
.btn-av:hover { background: #0d2d4a; color: #fff; text-decoration: none; }
.btn-read-more {
    padding: .48rem .75rem; background: transparent; color: #008080;
    border: 1.5px solid #008080; border-radius: 8px; font-size: .76rem; font-weight: 600;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: all .15s; display: inline-flex; align-items: center; gap: .3rem; white-space: nowrap;
}
.btn-read-more:hover { background: #008080; color: #fff; text-decoration: none; }
.btn-wa-scheme {
    padding: .48rem .75rem; background: #25d366; color: #fff; border: none; border-radius: 8px;
    font-size: .76rem; font-weight: 600; text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s; display: inline-flex; align-items: center; gap: .3rem; white-space: nowrap;
}
.btn-wa-scheme:hover { background: #1ebe5d; color: #fff; text-decoration: none; }
.btn-icon {
    padding: .48rem .6rem; background: transparent; color: #1a3a5c;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px; font-size: .76rem;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: all .15s; display: inline-flex; align-items: center;
}
.btn-icon:hover { background: #1a3a5c; color: #fff; border-color: #1a3a5c; text-decoration: none; }

/* Empty */
.av-empty { grid-column: 1/-1; text-align: center; padding: 4rem 1rem; color: var(--text-tertiary, #6b7280); }
.av-empty i { font-size: 2.2rem; margin-bottom: .8rem; display: block; }

/* About section */
.av-about-section { background: var(--bg-primary, #fff); border-top: 1px solid var(--border-color, #e5e7eb); padding: 2.5rem 1rem; }
.av-about-inner { max-width: 860px; margin: 0 auto; }
.av-about-inner h2 { font-size: 1.15rem; font-weight: 700; color: var(--text-primary, #111827); margin-bottom: .9rem; }
.av-about-inner p { font-size: .87rem; color: var(--text-secondary, #4b5563); line-height: 1.8; margin-bottom: .9rem; }
.about-cta-row { display: flex; flex-wrap: wrap; gap: .75rem; margin-top: 1.25rem; }
.about-btn-primary {
    display: inline-flex; align-items: center; gap: .4rem; background: #1a3a5c; color: #fff;
    font-weight: 700; font-size: .85rem; padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif; transition: background .15s;
}
.about-btn-primary:hover { background: #0d2d4a; color: #fff; text-decoration: none; }
.about-btn-wa {
    display: inline-flex; align-items: center; gap: .4rem; background: #25d366; color: #fff;
    font-weight: 700; font-size: .85rem; padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif; transition: background .15s;
}
.about-btn-wa:hover { background: #1ebe5d; color: #fff; text-decoration: none; }

/* FAQ */
.av-faq { max-width: 860px; margin: 0 auto; padding: 2.5rem 1rem 0; }
.av-faq h2 { font-size: 1.15rem; font-weight: 700; color: var(--text-primary, #111827); margin-bottom: 1.2rem; }
.faq-item { border: 1px solid var(--border-color, #e5e7eb); border-radius: 10px; margin-bottom: .6rem; background: var(--card-bg, #fff); overflow: hidden; transition: box-shadow .15s; }
.faq-item:hover { box-shadow: 0 2px 12px rgba(26,58,92,.07); }
.faq-q {
    width: 100%; background: none; border: none; text-align: left; padding: .9rem 1rem;
    font-size: .85rem; font-weight: 600; color: var(--text-primary, #111827);
    font-family: 'Poppins', sans-serif; cursor: pointer;
    display: flex; justify-content: space-between; align-items: center; gap: .5rem;
}
.faq-q:hover { background: var(--bg-secondary, #f9fafb); }
.faq-q .faq-icon { font-size: .7rem; color: #008080; transition: transform .2s; flex-shrink: 0; }
.faq-q[aria-expanded="true"] .faq-icon { transform: rotate(180deg); }
.faq-q[aria-expanded="true"] { color: #1a3a5c; }
.faq-a { display: none; padding: .85rem 1rem .95rem; font-size: .83rem; color: var(--text-secondary, #4b5563); line-height: 1.75; border-top: 1px solid var(--border-color, #e5e7eb); }
.faq-a.open { display: block; }

/* Links bar */
.av-links-bar { max-width: 860px; margin: 0 auto; padding: 1.5rem 1rem 2.5rem; border-top: 1px solid var(--border-color, #e5e7eb); }
.av-links-bar p { font-size: .8rem; color: var(--text-secondary, #4b5563); line-height: 1.9; }
.av-links-bar a { color: #1a3a5c; font-weight: 500; text-decoration: none; }
.av-links-bar a:hover { text-decoration: underline; }

/* Dark mode */
[data-theme="dark"] .av-tag { background: #374151; color: #d1d5db; border-color: #4b5563; }
[data-theme="dark"] .av-card { border-color: #374151; background: #1f2937; }
[data-theme="dark"] .prog-bar { background: #374151; }
[data-theme="dark"] .faq-item { border-color: #374151; background: #1f2937; }
[data-theme="dark"] .faq-q { color: #f3f4f6; }
[data-theme="dark"] .faq-q:hover { background: #374151; }
[data-theme="dark"] .btn-icon { border-color: #4b5563; color: #d1d5db; }
[data-theme="dark"] .av-about-section { background: #111827; border-color: #374151; }

@media (max-width: 600px) {
    .av-grid { grid-template-columns: 1fr; }
    .hero-cta-row { flex-direction: column; align-items: flex-start; }
    .av-card-foot { gap: .35rem; }
}
</style>
@endpush

@section('content')
<div class="av-page">

    {{-- HERO --}}
    <section class="av-hero">
        <div style="max-width:1200px;margin:0 auto;">
            <p style="font-size:.75rem;opacity:.55;margin-bottom:.5rem;">
                <a href="/" style="color:inherit;text-decoration:none;">Home</a> &rsaquo; Awas Vikas Schemes
            </p>
            <h1>
                <i class="fas fa-building" style="margin-right:.45rem;" aria-hidden="true"></i>Awas Vikas Schemes Lucknow 2026 — All UPAVP Housing &amp; Plot Projects
            </h1>
            <p class="hero-sub">
                Complete directory of UP Awas Vikas Parishad (UPAVP) housing schemes in Lucknow — EWS, LIG, MIG &amp; HIG plots, flats &amp; townships.
                Prices, possession dates &amp; availability updated regularly.
            </p>
            <div class="hero-cta-row">
                <a href="/services/property-advisory-lucknow" class="hero-btn-primary">
                    <i class="fas fa-calendar-check" aria-hidden="true"></i> Free Consultation
                </a>
                <a href="https://wa.me/918595002933?text=Hi%2C+I+have+a+query+about+Awas+Vikas+schemes+in+Lucknow"
                   target="_blank" rel="noopener noreferrer" class="hero-btn-wa">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp Us
                </a>
            </div>
            <div class="hero-stats">
                <span class="stat-pill"><i class="fas fa-check-circle" style="margin-right:.3rem;color:#34d399;" aria-hidden="true"></i>{{ $stats['active'] }} Active</span>
                <span class="stat-pill"><i class="fas fa-clock" style="margin-right:.3rem;color:#fbbf24;" aria-hidden="true"></i>{{ $stats['upcoming'] }} Upcoming</span>
                <span class="stat-pill"><i class="fas fa-home" style="margin-right:.3rem;" aria-hidden="true"></i>{{ $stats['total'] }} Total</span>
                <span class="stat-pill" style="opacity:.7;font-size:.72rem;">
                    <i class="fas fa-sync-alt" style="margin-right:.3rem;" aria-hidden="true"></i>Updated: {{ $lastUpdated }}
                </span>
            </div>
        </div>
    </section>

    {{-- CONTROLS --}}
    <div class="av-controls">
        <div class="av-controls-inner">
            <input type="text" id="av-search" class="av-search"
                   placeholder="Search schemes, locations…"
                   autocomplete="off" aria-label="Search Awas Vikas schemes">
            <button class="av-filter-btn active" data-filter="all">All</button>
            <button class="av-filter-btn" data-filter="Active">Active</button>
            <button class="av-filter-btn" data-filter="Upcoming">Upcoming</button>
            <button class="av-filter-btn" data-filter="Completed">Completed</button>
            <select class="av-sort" id="av-sort" aria-label="Sort schemes">
                <option value="default">Default order</option>
                <option value="name">Name A–Z</option>
                <option value="price_asc">Price: Low → High</option>
                <option value="price_desc">Price: High → Low</option>
                <option value="progress">Progress %</option>
            </select>
            <span class="av-count" id="av-count">{{ count($schemes) }} schemes</span>
        </div>
    </div>

    {{-- CARDS GRID --}}
    <div class="av-grid" id="av-grid" aria-label="Awas Vikas scheme listings">

        @forelse ($schemes as $s)
        @php
            $featured     = ($s['featured'] ?? false) ? 'featured' : '';
            $statusKey    = strtolower($s['status'] ?? 'active');
            $schemeAnchor = $s['scheme_id'] ?? 'scheme-'.($loop->index + 1);
            $schemeName   = $s['name'] ?? 'this scheme';
            $waMsg        = urlencode('Hi, I have a query about ' . $schemeName . ' Awas Vikas scheme in Lucknow. Please guide me.');
        @endphp

        <article class="av-card {{ $featured }}"
             id="{{ $schemeAnchor }}"
             data-status="{{ $s['status'] ?? '' }}"
             data-search="{{ strtolower(($s['name'] ?? '') . ' ' . ($s['location'] ?? '') . ' ' . ($s['category'] ?? '')) }}"
             data-price="{{ $s['price_per_sqft'] ?? 0 }}"
             data-progress="{{ $s['progress_pct'] ?? 0 }}"
             data-order="{{ $s['sort_order'] ?? 99 }}">

            <div class="av-card-header">
                <div class="card-id">{{ $s['scheme_id'] ?? '' }} &bull; {{ $s['category'] ?? '' }}</div>
                <h2 class="card-name">{{ $schemeName }}</h2>
                <div class="card-loc">
                    <i class="fas fa-map-marker-alt" style="font-size:.65rem;" aria-hidden="true"></i>
                    {{ $s['location'] ?? '' }}
                </div>
                <span class="av-badge badge-{{ $statusKey }}">{{ $s['status'] ?? '' }}</span>
            </div>

            @if(($s['progress_pct'] ?? 0) > 0)
            <div class="av-progress">
                <div class="prog-label">
                    <span>{{ $s['phase'] ?? '' }}</span>
                    <span>{{ $s['progress_pct'] }}% complete</span>
                </div>
                <div class="prog-bar" role="progressbar" aria-valuenow="{{ $s['progress_pct'] }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="prog-fill" style="width:{{ $s['progress_pct'] }}%"></div>
                </div>
            </div>
            @endif

            <div class="av-meta">
                @if(($s['area_acres'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-ruler-combined" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Area</div>
                    <div class="meta-value">{{ number_format($s['area_acres']) }} Acres</div>
                </div>
                @endif
                @if(($s['total_units'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-layer-group" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Total Units</div>
                    <div class="meta-value">{{ number_format($s['total_units']) }}</div>
                </div>
                @endif
                @if(($s['units_available'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-door-open" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Available</div>
                    <div class="meta-value avail">{{ number_format($s['units_available']) }} Units</div>
                </div>
                @endif
                @if(($s['price_per_sqft'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-rupee-sign" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Rate</div>
                    <div class="meta-value">₹{{ number_format($s['price_per_sqft']) }}/sqft</div>
                </div>
                @endif
                @if(!empty($s['possession_date']) && !in_array($s['possession_date'], ['N/A', '']))
                <div>
                    <div class="meta-label"><i class="fas fa-calendar-check" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Possession</div>
                    <div class="meta-value">{{ $s['possession_date'] }}</div>
                </div>
                @endif
                @if(!empty($s['ballot_date']) && !in_array($s['ballot_date'], ['N/A', '']))
                <div>
                    <div class="meta-label"><i class="fas fa-dice" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Ballot Date</div>
                    <div class="meta-value">{{ $s['ballot_date'] }}</div>
                </div>
                @endif
                @if(!empty($s['allotment_type']) && $s['allotment_type'] !== 'N/A')
                <div>
                    <div class="meta-label"><i class="fas fa-tag" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Allotment</div>
                    <div class="meta-value">{{ $s['allotment_type'] }}</div>
                </div>
                @endif
            </div>

            @if(!empty($s['highlights']) && is_array($s['highlights']))
            <div class="av-tags">
                @foreach($s['highlights'] as $tag)
                    @if(trim($tag))
                    <span class="av-tag">{{ trim($tag) }}</span>
                    @endif
                @endforeach
            </div>
            @endif

            @if(!empty($s['description']))
            <div class="av-desc">{{ $s['description'] }}</div>
            @endif

            <div class="av-card-foot">
                <a href="{{ $s['official_link'] ?? 'https://upavp.in' }}"
                   target="_blank" rel="noopener noreferrer" class="btn-av"
                   aria-label="View {{ $schemeName }} on UPAVP official website">
                    <i class="fas fa-external-link-alt" style="font-size:.62rem;" aria-hidden="true"></i>
                    View on UPAVP
                </a>

                @if(!empty($s['read_more']))
                <a href="{{ $s['read_more'] }}" class="btn-read-more"
                   aria-label="Read detailed article about {{ $schemeName }}">
                    <i class="fas fa-book-open" style="font-size:.62rem;" aria-hidden="true"></i>
                    Read More
                </a>
                @endif

                <a href="https://wa.me/918595002933?text={{ $waMsg }}"
                   target="_blank" rel="noopener noreferrer" class="btn-wa-scheme"
                   aria-label="Send WhatsApp query about {{ $schemeName }}">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    Query
                </a>

                @if(!empty($s['map_link']))
                <a href="{{ $s['map_link'] }}" target="_blank" rel="noopener noreferrer"
                   class="btn-icon" aria-label="View location on map">
                    <i class="fas fa-map" style="font-size:.72rem;" aria-hidden="true"></i>
                </a>
                @endif

                @if(!empty($s['brochure_link']))
                <a href="{{ $s['brochure_link'] }}" target="_blank" rel="noopener noreferrer"
                   class="btn-icon" aria-label="Download brochure">
                    <i class="fas fa-file-pdf" style="font-size:.72rem;" aria-hidden="true"></i>
                </a>
                @endif
            </div>

        </article>
        @empty
        <div class="av-empty">
            <i class="fas fa-folder-open" aria-hidden="true"></i>
            <p>No schemes loaded. Please upload <code>awas_vikas_schemes.json</code> to <code>storage/app/data/</code>.</p>
        </div>
        @endforelse

        <div class="av-empty" id="no-results" style="display:none;" aria-live="polite">
            <i class="fas fa-search" aria-hidden="true"></i>
            <p>No schemes match your search.</p>
        </div>
    </div>

    {{-- Disclaimer --}}
    <div style="max-width:1200px;margin:0 auto;padding:.5rem 1rem 1rem;">
        <p style="font-size:.72rem;color:var(--text-tertiary);line-height:1.6;border-top:1px solid var(--border-color);padding-top:.6rem;">
            <i class="fas fa-info-circle" style="margin-right:.3rem;" aria-hidden="true"></i>
            Data sourced from official UPAVP communications and upavp.in. Prices, availability and dates change — verify directly with UPAVP before any decision.
            Last refresh: {{ $lastUpdated }}.
        </p>
    </div>

    {{-- ABOUT SECTION --}}
    <div class="av-about-section">
        <div class="av-about-inner">
            <h2>
                <i class="fas fa-landmark" style="margin-right:.45rem;color:#008080;" aria-hidden="true"></i>About UP Awas Vikas Parishad (UPAVP) Schemes in Lucknow
            </h2>
            <p>
                <strong>UP Awas Vikas Parishad (UPAVP)</strong> is the state government housing authority of Uttar Pradesh, responsible for developing affordable residential colonies, plots and flats across the state.
                In Lucknow, UPAVP has developed major residential areas including Indira Nagar, Aliganj, Vrindavan Yojna and several colonies on Kanpur Road, Faizabad Road and Sitapur Road.
            </p>
            <p>
                UPAVP schemes cover all income categories — <strong>EWS, LIG, MIG and HIG</strong> — providing housing options from affordable plots to multi-storey flats.
                All properties are government-backed with clear legal titles, making them eligible for bank home loans and PMAY subsidies where applicable.
            </p>
            <p>
                For personalised guidance on eligibility, documentation and home loan assistance for any Awas Vikas scheme, contact DSD Properties for a <strong>free consultation</strong>.
            </p>
            <div class="about-cta-row">
                <a href="/services/property-advisory-lucknow" class="about-btn-primary">
                    <i class="fas fa-calendar-check" aria-hidden="true"></i> Book Free Consultation
                </a>
                <a href="https://wa.me/918595002933?text=Hi%2C+I+need+guidance+on+Awas+Vikas+schemes+in+Lucknow"
                   target="_blank" rel="noopener noreferrer" class="about-btn-wa">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp: 8595002933
                </a>
            </div>
        </div>
    </div>

    {{-- FAQ SECTION --}}
    <div class="av-faq">
        <h2>
            <i class="fas fa-question-circle" style="margin-right:.45rem;color:#008080;" aria-hidden="true"></i>Frequently Asked Questions — Awas Vikas Schemes Lucknow
        </h2>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="av-faq-a1" onclick="toggleFaq(this)">
                What is UP Awas Vikas Parishad (UPAVP)?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="av-faq-a1">
                UP Awas Vikas Parishad (UPAVP) is a government body under the Uttar Pradesh government that develops and allots affordable housing — plots, flats and townships — across UP. In Lucknow, UPAVP has developed several major colonies including Indira Nagar, Aliganj and areas along Kanpur Road. Properties allotted by UPAVP carry clear government-backed titles.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="av-faq-a2" onclick="toggleFaq(this)">
                How do I apply for an Awas Vikas scheme in Lucknow?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="av-faq-a2">
                Applications for active UPAVP schemes can be submitted through the official portal at <a href="https://upavp.in" target="_blank" rel="noopener noreferrer" style="color:#1a3a5c;font-weight:600;">upavp.in</a>. For FCFS schemes, allotment is on a first-come basis. For lottery schemes, submit during the open window and await the draw. <a href="/contact-us" style="color:#1a3a5c;font-weight:600;">Contact DSD Properties</a> for guidance on eligibility and documentation.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="av-faq-a3" onclick="toggleFaq(this)">
                Are home loans available on Awas Vikas properties?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="av-faq-a3">
                Yes. Most nationalised and major private banks offer home loans on UPAVP-allotted properties. You will need your allotment letter, payment receipts, Aadhaar, PAN and address proof. EWS and LIG category buyers may also be eligible for PMAY CLSS interest subsidy. Contact us for documentation support.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="av-faq-a4" onclick="toggleFaq(this)">
                What is the difference between Awas Vikas and LDA schemes?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="av-faq-a4">
                <strong>LDA</strong> (Lucknow Development Authority) focuses on township development within the Lucknow Metropolitan Area. <strong>UPAVP</strong> is a state-level authority developing housing colonies across all districts of UP. Both offer government-backed properties with clear titles, but their schemes, locations and pricing differ. <a href="/lda-schemes" style="color:#1a3a5c;font-weight:600;">View LDA schemes here →</a>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="av-faq-a5" onclick="toggleFaq(this)">
                What income categories does Awas Vikas cover?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="av-faq-a5">
                UPAVP schemes cover all income groups: <strong>EWS</strong> (Economically Weaker Section — annual income up to ₹3L), <strong>LIG</strong> (Lower Income Group — up to ₹6L), <strong>MIG</strong> (Middle Income Group — up to ₹18L) and <strong>HIG</strong> (Higher Income Group — above ₹18L). Eligibility criteria and pricing vary per scheme and category.
            </div>
        </div>
    </div>

    {{-- INTERNAL LINKS --}}
    <div class="av-links-bar">
        <p>
            <strong>Also explore:</strong>
            <a href="/lda-schemes">LDA Schemes Lucknow 2026</a> &middot;
            <a href="/services/property-advisory-lucknow">Free property advisory</a> &middot;
            <a href="/services/property-verification-lucknow">Property verification</a> &middot;
            <a href="/blog">Property guides &amp; articles</a> &middot;
            <a href="/properties">Browse listings</a>
        </p>
    </div>

</div>

<script>
(function () {
    const cards = Array.from(document.querySelectorAll('#av-grid .av-card'));
    const grid  = document.getElementById('av-grid');
    const noRes = document.getElementById('no-results');
    const count = document.getElementById('av-count');
    let filter  = 'all';
    let query   = '';

    function render() {
        let vis = 0;
        cards.forEach(c => {
            const ok = (filter === 'all' || c.dataset.status === filter)
                    && (!query || c.dataset.search.includes(query));
            c.style.display = ok ? '' : 'none';
            if (ok) vis++;
        });
        count.textContent = vis + (vis === 1 ? ' scheme' : ' schemes');
        noRes.style.display = vis === 0 ? 'block' : 'none';
    }

    function sort(by) {
        [...cards].sort((a, b) => {
            if (by === 'name')       return a.dataset.search.localeCompare(b.dataset.search);
            if (by === 'price_asc')  return +a.dataset.price - +b.dataset.price;
            if (by === 'price_desc') return +b.dataset.price - +a.dataset.price;
            if (by === 'progress')   return +b.dataset.progress - +a.dataset.progress;
            return +a.dataset.order - +b.dataset.order;
        }).forEach(c => grid.insertBefore(c, noRes));
    }

    document.querySelectorAll('.av-filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.av-filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filter = this.dataset.filter;
            render();
        });
    });

    document.getElementById('av-search').addEventListener('input', function () {
        query = this.value.toLowerCase().trim();
        render();
    });

    document.getElementById('av-sort').addEventListener('change', function () {
        sort(this.value);
        render();
    });
})();

function toggleFaq(btn) {
    const expanded = btn.getAttribute('aria-expanded') === 'true';
    const answer   = document.getElementById(btn.getAttribute('aria-controls'));
    btn.setAttribute('aria-expanded', String(!expanded));
    answer.classList.toggle('open', !expanded);
}
</script>
@endsection
