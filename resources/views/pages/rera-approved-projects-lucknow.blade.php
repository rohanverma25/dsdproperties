@extends('layouts.user-app')

{{-- ═══════════════════════════════════════════════════════════════
     SEO: Title · Meta Description · Keywords
     Optimised for top-volume queries (GSC data, last 90 days):
       • "rera approved projects in lucknow" — 271 impr (#1 specific)
       • "rera lucknow"                       — 485 impr (#1 head)
       • "rera registered projects in lucknow" — 41 impr
       • "lucknow rera approved projects"     — 24 impr
     Target: lift CTR from 2.2% → 5%+ at avg position 6.8.
     ═══════════════════════════════════════════════════════════════ --}}
@section('title', 'RERA Approved Projects in Lucknow 2026 — Verified UPRERA List | DSD Properties')
@section('meta_description', 'Verified directory of RERA approved projects in Lucknow 2026 — apartments, plots & commercial. UPRERAPRJ numbers, prices, possession dates. Free verification by DSD.')
@section('meta_keywords', 'rera approved projects in lucknow, rera lucknow, rera registered projects in lucknow, lucknow rera approved projects, uprera projects lucknow, rera approved flats lucknow, rera approved plots in lucknow, rera approved builders, up rera lucknow, uprera registered projects, rera verified projects lucknow 2026, rera approved residential projects lucknow, rera approved commercial projects lucknow, rera compliant projects gomti nagar, rera approved projects sultanpur road lucknow')

@push('head')

{{-- Canonical & language alternates (prep for Hindi version) --}}
<link rel="canonical" href="https://dsdproperties.in/rera-approved-projects-lucknow" />
<link rel="alternate" hreflang="en-in" href="https://dsdproperties.in/rera-approved-projects-lucknow" />
<link rel="alternate" hreflang="x-default" href="https://dsdproperties.in/rera-approved-projects-lucknow" />

{{-- Open Graph (better social CTR) --}}
<meta property="og:type" content="website" />
<meta property="og:title" content="RERA Approved Projects in Lucknow 2026 — Verified UPRERA List" />
<meta property="og:description" content="Verified directory of RERA approved projects in Lucknow — UPRERAPRJ numbers, prices, possession dates. Free verification by DSD Properties." />
<meta property="og:url" content="https://dsdproperties.in/rera-approved-projects-lucknow" />
<meta property="og:site_name" content="DSD Properties" />
<meta property="og:locale" content="en_IN" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="RERA Approved Projects in Lucknow 2026 — Verified List" />
<meta name="twitter:description" content="Verified directory of UPRERA registered projects in Lucknow with prices, builder details & possession timelines." />

{{-- ═══════════════════════════════════════════════════════════════
     JSON-LD SCHEMA MARKUP
     1. WebPage         – signals freshness via dateModified
     2. BreadcrumbList  – enables breadcrumb SERP rendering
     3. ItemList        – directory listing structured data (biggest CTR win)
     4. FAQPage         – expands SERP listing with Q&A pairs
     5. RealEstateAgent – establishes DSD as local authority
     ═══════════════════════════════════════════════════════════════ --}}

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "https://dsdproperties.in/rera-approved-projects-lucknow#webpage",
  "url": "https://dsdproperties.in/rera-approved-projects-lucknow",
  "name": "RERA Approved Projects in Lucknow 2026 — Verified UPRERA List",
  "description": "Verified directory of RERA approved projects in Lucknow 2026 with UPRERAPRJ numbers, prices, builder details and possession timelines.",
  "inLanguage": "en-IN",
  "isPartOf": { "@type": "WebSite", "url": "https://dsdproperties.in", "name": "DSD Properties" },
  "datePublished": "2026-01-15",
  "dateModified": "{{ \Carbon\Carbon::parse($lastUpdated ?? now())->toDateString() }}",
  "about": { "@type": "Thing", "name": "RERA Approved Projects in Lucknow" }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://dsdproperties.in" },
    { "@type": "ListItem", "position": 2, "name": "RERA Approved Projects Lucknow", "item": "https://dsdproperties.in/rera-approved-projects-lucknow" }
  ]
}
</script>

@if(!empty($projects) && count($projects) > 0)
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "RERA Approved Projects in Lucknow 2026",
  "description": "Verified UPRERA registered residential, commercial and plotted projects in Lucknow.",
  "numberOfItems": {{ count($projects) }},
  "itemListElement": [
    @foreach($projects as $idx => $p)
    {
      "@type": "ListItem",
      "position": {{ $idx + 1 }},
      "item": {
        "@type": "Residence",
        "name": "{{ addslashes($p['name'] ?? '') }}",
        "url": "https://dsdproperties.in/rera-approved-projects-lucknow#{{ $p['project_id'] ?? 'project-'.($idx + 1) }}",
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "{{ addslashes($p['location'] ?? 'Lucknow') }}",
          "addressRegion": "Uttar Pradesh",
          "addressCountry": "IN"
        }@if(!empty($p['builder']) || !empty($p['rera_number'])),
        "additionalProperty": [
          @if(!empty($p['rera_number']))
          { "@type": "PropertyValue", "name": "UPRERA Registration", "value": "{{ addslashes($p['rera_number']) }}" }@if(!empty($p['builder'])),@endif
          @endif
          @if(!empty($p['builder']))
          { "@type": "PropertyValue", "name": "Builder", "value": "{{ addslashes($p['builder']) }}" }
          @endif
        ]@endif
      }
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endif

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How do I check if a project in Lucknow is RERA approved?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Visit the official UP RERA portal at up-rera.in and search by project name, builder name, or RERA registration number. Every RERA registered project in Lucknow will have a unique UPRERAPRJ number. You can also verify any project through DSD Properties — contact us for a free verification check."
      }
    },
    {
      "@type": "Question",
      "name": "What is UPRERA and why is RERA registration important?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "UPRERA (Uttar Pradesh Real Estate Regulatory Authority) is the state body under the RERA Act 2016 that regulates and promotes the real estate sector in UP. RERA registration is mandatory for all residential and commercial projects above 500 sqm or 8 units. It ensures transparency, timely delivery, and protects homebuyers from fraud. Always buy RERA approved projects for legal safety."
      }
    },
    {
      "@type": "Question",
      "name": "Are there RERA approved plots in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Plotted developments above 500 sqm in Lucknow must be RERA registered with a valid UPRERAPRJ number. Major RERA approved plotted townships are available on Sultanpur Road, Raebareli Road, and Mohanlalganj. Always verify the plot's RERA registration on up-rera.in before booking, and check that the layout matches the approved plan. DSD Properties offers plot-specific verification including title check and approved layout cross-verification."
      }
    },
    {
      "@type": "Question",
      "name": "What documents should I verify before buying a RERA registered project in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Key documents to verify include: RERA registration certificate with valid UPRERAPRJ number, approved building plan from the competent authority (LDA/Nagar Nigam), land title documents, encumbrance certificate, NOCs from relevant departments (fire, environment, AAI), and the builder-buyer agreement as per RERA format. DSD Properties offers a comprehensive property verification service."
      }
    },
    {
      "@type": "Question",
      "name": "Can I file a complaint against a RERA registered builder in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. You can file a complaint on the UP RERA portal (up-rera.in) against any registered builder for project delays, quality issues, or agreement violations. UPRERA has a dedicated adjudicating bench in Lucknow. You can also approach the RERA Appellate Tribunal. The filing fee is ₹1,000 for individual homebuyers."
      }
    },
    {
      "@type": "Question",
      "name": "Are home loans easier to get for RERA approved projects?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Banks and NBFCs prefer lending on RERA registered projects as they carry lower risk. RERA compliance ensures the project has valid approvals, a dedicated escrow account, and a defined completion timeline. Most major banks in Lucknow readily approve home loans for UPRERA registered projects."
      }
    },
    {
      "@type": "Question",
      "name": "Which areas in Lucknow have the most RERA approved projects?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "As of 2026, the highest concentration of RERA registered projects in Lucknow is along Sultanpur Road, Shaheed Path, Gomti Nagar Extension, Faizabad Road, Sitapur Road, and Raebareli Road. These corridors are seeing rapid residential and commercial development backed by infrastructure growth like the Lucknow Metro and Outer Ring Road."
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
  "logo": "https://dsdproperties.in/public/images/logo.webp",
  "telephone": "+918595002933",
  "email": "dheer@dsdproperties.in",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "226025",
    "addressCountry": "IN"
  },
  "areaServed": { "@type": "City", "name": "Lucknow" },
  "knowsAbout": [
    "RERA approved projects Lucknow", "UP RERA registered projects",
    "UPRERA projects Lucknow 2026", "RERA verified builders Lucknow",
    "RERA approved plots Lucknow", "property verification Lucknow", "real estate Lucknow"
  ],
  "sameAs": ["https://dsdproperties.in"]
}
</script>

<style>
/* ─────────────────────────────────────────
   BASE
───────────────────────────────────────── */
.rera-page { background-color: var(--bg-secondary, #f3f4f6); min-height: 100vh; }

/* ─────────────────────────────────────────
   HERO  (deep teal-navy gradient — distinct from LDA)
───────────────────────────────────────── */
.rera-hero {
    background: linear-gradient(135deg, #0c2340 0%, #0a4d4d 50%, #137a63 100%);
    padding: 3rem 1rem 2.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.rera-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.rera-hero h1 {
    font-size: clamp(1.4rem, 3vw, 2.1rem);
    font-weight: 700;
    margin-bottom: .4rem;
    position: relative;
}
.rera-hero .hero-sub {
    font-size: .92rem;
    opacity: .85;
    max-width: 700px;
    margin: .4rem 0 0;
    line-height: 1.6;
    position: relative;
}
.hero-stats { display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1.25rem; position: relative; }
.stat-pill {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 50px;
    padding: .3rem .9rem;
    font-size: .78rem;
    font-weight: 500;
}
.hero-cta-row {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    margin-top: 1.5rem;
    align-items: center;
    position: relative;
}
.hero-btn-primary {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #fff; color: #0c2340;
    font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s, color .15s;
}
.hero-btn-primary:hover { background: #e0f2f1; color: #0c2340; text-decoration: none; }
.hero-btn-wa {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #25d366; color: #fff;
    font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s;
}
.hero-btn-wa:hover { background: #1ebe5d; color: #fff; text-decoration: none; }
.hero-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    background: transparent; color: #fff;
    border: 1.5px solid rgba(255,255,255,.45);
    font-weight: 600; font-size: .85rem;
    padding: .5rem 1.1rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: all .15s;
}
.hero-btn-outline:hover { background: rgba(255,255,255,.12); border-color: #fff; color: #fff; text-decoration: none; }

/* ─────────────────────────────────────────
   TRUST BAR (RERA-specific — shows authority)
───────────────────────────────────────── */
.rera-trust-bar {
    background: var(--bg-primary, #fff);
    border-bottom: 1px solid var(--border-color, #e5e7eb);
    padding: .6rem 1rem;
}
.rera-trust-inner {
    max-width: 1200px; margin: 0 auto;
    display: flex; flex-wrap: wrap; gap: 1.2rem; align-items: center;
    justify-content: center;
    font-size: .76rem; color: var(--text-tertiary, #6b7280);
}
.trust-item { display: flex; align-items: center; gap: .35rem; white-space: nowrap; }
.trust-item i { color: #137a63; font-size: .72rem; }

/* ─────────────────────────────────────────
   CONTROLS BAR
───────────────────────────────────────── */
.rera-controls {
    background: var(--bg-primary, #fff);
    border-bottom: 1px solid var(--border-color, #e5e7eb);
    padding: .75rem 1rem;
    position: sticky; top: 0; z-index: 40;
}
.rera-controls-inner {
    max-width: 1200px; margin: 0 auto;
    display: flex; flex-wrap: wrap; gap: .5rem; align-items: center;
}
.rera-search {
    flex: 1; min-width: 180px;
    padding: .45rem .8rem;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .85rem; background: var(--input-bg, #fff);
    color: var(--text-primary, #111827); font-family: 'Poppins', sans-serif;
}
.rera-search:focus { outline: none; border-color: #0c2340; box-shadow: 0 0 0 3px rgba(12,35,64,.1); }
.rera-filter-btn {
    padding: .38rem .9rem;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 50px;
    font-size: .78rem; font-weight: 500; cursor: pointer;
    background: var(--bg-primary, #fff); color: var(--text-secondary, #4b5563);
    transition: all .15s; font-family: 'Poppins', sans-serif; white-space: nowrap;
}
.filter-n {
    display: inline-block; margin-left: .3rem;
    font-size: .68rem; font-weight: 700; opacity: .55;
}
.rera-filter-btn:hover, .rera-filter-btn.active { background: #0c2340; color: #fff; border-color: #0c2340; }
.rera-sort {
    padding: .38rem .7rem;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .8rem; background: var(--input-bg, #fff);
    color: var(--text-primary, #111827); font-family: 'Poppins', sans-serif; cursor: pointer;
}
.rera-count { font-size: .8rem; color: var(--text-tertiary, #6b7280); white-space: nowrap; }

/* ─────────────────────────────────────────
   CARDS GRID
───────────────────────────────────────── */
.rera-grid {
    max-width: 1200px; margin: 0 auto;
    padding: 1.25rem 1rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1.1rem;
}

/* ─────────────────────────────────────────
   CARD
───────────────────────────────────────── */
.rera-card {
    background: var(--card-bg, #fff);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 14px; overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    display: flex; flex-direction: column;
    box-shadow: 0 1px 4px rgba(12,35,64,.06);
}
.rera-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(12,35,64,.12); }
.rera-card.featured { border-color: #137a63; border-width: 1.5px; }

.rera-card-header {
    background: linear-gradient(135deg, #0c2340, #0a4d4d);
    padding: .9rem 1rem .8rem;
}
.rera-card.commercial .rera-card-header { background: linear-gradient(135deg, #4a1d6e, #6d28d9); }
.rera-card.plotted .rera-card-header { background: linear-gradient(135deg, #7c4a14, #b45309); }
.rera-card.mixed-use .rera-card-header { background: linear-gradient(135deg, #0f3d3e, #115e59); }

/* The badge shares a flex row with the builder line instead of being pinned
   over it — a long status used to sit on top of the project name. */
.card-top {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: .5rem; margin-bottom: .3rem;
}
.card-top-left { min-width: 0; }

.card-rera-id {
    font-size: .64rem; color: rgba(255,255,255,.62);
    letter-spacing: .04em; margin-bottom: .15rem;
    font-family: 'Courier New', monospace;
    overflow-wrap: anywhere;
}
.card-builder {
    font-size: .68rem; color: rgba(255,255,255,.62);
    letter-spacing: .04em; line-height: 1.45;
}
.card-name { font-size: 1rem; font-weight: 600; color: #fff; line-height: 1.35; margin: 0; overflow-wrap: anywhere; }
.card-loc  { font-size: .75rem; color: rgba(255,255,255,.72); margin-top: .3rem; display: flex; align-items: flex-start; gap: .3rem; }
.card-loc i { margin-top: .22rem; flex-shrink: 0; }

.rera-badge {
    flex-shrink: 0; max-width: 46%;
    padding: .24rem .6rem; border-radius: 50px;
    font-size: .62rem; font-weight: 700; line-height: 1.3;
    letter-spacing: .03em; text-transform: uppercase; text-align: center;
    /* Fallback colours, so a status we have no rule for is still readable. */
    background: rgba(255,255,255,.16); color: #fff;
}
.badge-active        { background: #d1fae5; color: #065f46; }
.badge-new-launch    { background: #fef3c7; color: #92400e; }
.badge-completed     { background: #dbeafe; color: #1e40af; }
.badge-under-construction { background: #fce7f3; color: #9d174d; }
.badge-nearing-possession { background: #e0e7ff; color: #3730a3; }
.badge-ready-to-move { background: #d1fae5; color: #065f46; }
.badge-partly-ready  { background: #ccfbf1; color: #115e59; }

/* Full status wording + RERA caveat, which the short badge cannot carry */
.rera-statusline {
    padding: 0 1rem .6rem;
    display: flex; flex-direction: column; gap: .18rem;
    font-size: .7rem; color: var(--text-tertiary, #6b7280); line-height: 1.5;
}
.rera-statusline i { width: .8rem; margin-right: .1rem; opacity: .8; }

/* RERA Verified strip */
.rera-verified-strip {
    background: linear-gradient(90deg, #ecfdf5, #f0fdf4);
    padding: .35rem 1rem;
    display: flex; align-items: center; gap: .35rem;
    font-size: .7rem; color: #065f46; font-weight: 600;
    border-bottom: 1px solid #d1fae5;
}
[data-theme="dark"] .rera-verified-strip { background: #064e3b; color: #a7f3d0; border-color: #065f46; }
.rera-verified-strip i { color: #059669; }

/* Progress */
.rera-progress { padding: .6rem 1rem; border-bottom: 1px solid var(--border-color, #e5e7eb); }
.prog-label   { display: flex; justify-content: space-between; font-size: .7rem; color: var(--text-tertiary, #6b7280); margin-bottom: .28rem; }
.prog-bar     { height: 5px; background: var(--bg-tertiary, #e5e7eb); border-radius: 99px; overflow: hidden; }
.prog-fill    { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #0c2340, #137a63); }

/* Meta grid */
.rera-meta {
    padding: .7rem 1rem .6rem;
    display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: .55rem .75rem;
    align-items: start;
}
.meta-label { font-size: .64rem; color: var(--text-tertiary, #6b7280); text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; }
.meta-value { font-size: .8rem; font-weight: 600; color: var(--text-primary, #111827); margin-top: 2px; line-height: 1.4; overflow-wrap: anywhere; }
.meta-value.price-highlight { color: #059669; }

/* Tags */
.rera-tags { padding: 0 1rem .7rem; display: flex; flex-wrap: wrap; gap: .3rem; }
.rera-tag {
    font-size: .67rem; padding: .18rem .55rem;
    background: var(--bg-secondary, #f3f4f6);
    color: var(--text-secondary, #4b5563);
    border-radius: 50px; border: 1px solid var(--border-color, #e5e7eb);
}

/* Description */
.rera-desc { padding: 0 1rem .65rem; font-size: .8rem; color: var(--text-secondary, #4b5563); line-height: 1.6; flex: 1; }

/* ─────────────────────────────────────────
   CARD FOOTER
───────────────────────────────────────── */
.rera-card-foot {
    padding: .7rem 1rem;
    border-top: 1px solid var(--border-color, #e5e7eb);
    display: flex; gap: .4rem; flex-wrap: wrap; align-items: center;
    margin-top: auto;   /* keeps the buttons on the bottom edge of every card */
}
.btn-rera {
    flex: 1; min-width: 90px;
    padding: .48rem .7rem; background: #0c2340; color: #fff;
    border: none; border-radius: 8px;
    font-size: .76rem; font-weight: 600; cursor: pointer;
    text-align: center; text-decoration: none;
    font-family: 'Poppins', sans-serif; transition: background .15s;
    display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
}
.btn-rera:hover { background: #0a4d4d; color: #fff; text-decoration: none; }

.btn-read-more {
    padding: .48rem .75rem;
    background: transparent; color: #137a63;
    border: 1.5px solid #137a63; border-radius: 8px;
    font-size: .76rem; font-weight: 600;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: all .15s; display: inline-flex; align-items: center; gap: .3rem;
    white-space: nowrap;
}
.btn-read-more:hover { background: #137a63; color: #fff; text-decoration: none; }

.btn-wa-project {
    padding: .48rem .75rem;
    background: #25d366; color: #fff;
    border: none; border-radius: 8px;
    font-size: .76rem; font-weight: 600;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s; display: inline-flex; align-items: center; gap: .3rem;
    white-space: nowrap;
}
.btn-wa-project:hover { background: #1ebe5d; color: #fff; text-decoration: none; }

.btn-icon {
    padding: .48rem .6rem;
    background: transparent; color: #0c2340;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .76rem; text-decoration: none;
    font-family: 'Poppins', sans-serif; transition: all .15s;
    display: inline-flex; align-items: center;
}
.btn-icon:hover { background: #0c2340; color: #fff; border-color: #0c2340; text-decoration: none; }

/* ─────────────────────────────────────────
   EMPTY STATES
───────────────────────────────────────── */
.rera-empty { grid-column: 1/-1; text-align: center; padding: 4rem 1rem; color: var(--text-tertiary, #6b7280); }
.rera-empty i { font-size: 2.2rem; margin-bottom: .8rem; display: block; }

/* ─────────────────────────────────────────
   ABOUT RERA SECTION
───────────────────────────────────────── */
.rera-about-section {
    background: var(--bg-primary, #fff);
    border-top: 1px solid var(--border-color, #e5e7eb);
    padding: 2.5rem 1rem;
}
.rera-about-inner { max-width: 860px; margin: 0 auto; }
.rera-about-inner h2,
.rera-about-inner h3 {
    font-size: 1.15rem; font-weight: 700;
    color: var(--text-primary, #111827); margin-bottom: .9rem;
}
.rera-about-inner h3 { font-size: 1rem; margin-top: 1.6rem; }
.rera-about-inner p {
    font-size: .87rem; color: var(--text-secondary, #4b5563);
    line-height: 1.8; margin-bottom: .9rem;
}
.about-cta-row { display: flex; flex-wrap: wrap; gap: .75rem; margin-top: 1.25rem; }
.about-btn-primary {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #0c2340; color: #fff;
    font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s;
}
.about-btn-primary:hover { background: #0a4d4d; color: #fff; text-decoration: none; }
.about-btn-wa {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #25d366; color: #fff;
    font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s;
}
.about-btn-wa:hover { background: #1ebe5d; color: #fff; text-decoration: none; }

/* Builders chip grid (new SEO section) */
.rera-builders-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: .55rem; margin: .9rem 0 1.2rem;
}
.rera-builder-chip {
    background: var(--bg-secondary, #f9fafb);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 8px;
    padding: .55rem .75rem;
    font-size: .8rem;
    color: var(--text-primary, #111827);
    display: flex; align-items: center; gap: .4rem;
    transition: all .15s;
}
.rera-builder-chip:hover { border-color: #137a63; background: #ecfdf5; }
.rera-builder-chip i { color: #137a63; font-size: .7rem; }
[data-theme="dark"] .rera-builder-chip { background: #1f2937; border-color: #374151; color: #f3f4f6; }
[data-theme="dark"] .rera-builder-chip:hover { background: #064e3b; border-color: #34d399; }

/* Locality chip grid */
.rera-loc-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: .5rem; margin: .9rem 0 .5rem;
}
.rera-loc-chip {
    background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
    border: 1px solid #d1fae5;
    border-radius: 8px; padding: .5rem .7rem;
    font-size: .78rem; font-weight: 500; color: #065f46;
    text-decoration: none;
    display: flex; align-items: center; gap: .4rem;
    transition: all .15s;
}
.rera-loc-chip:hover { background: #137a63; color: #fff; border-color: #137a63; text-decoration: none; }
[data-theme="dark"] .rera-loc-chip { background: #064e3b; border-color: #065f46; color: #a7f3d0; }

/* ─────────────────────────────────────────
   FAQ SECTION
───────────────────────────────────────── */
.rera-faq { max-width: 860px; margin: 0 auto; padding: 2.5rem 1rem 0; }
.rera-faq h2 {
    font-size: 1.15rem; font-weight: 700;
    color: var(--text-primary, #111827); margin-bottom: 1.2rem;
}
.faq-item {
    border: 1px solid var(--border-color, #e5e7eb); border-radius: 10px;
    margin-bottom: .6rem; background: var(--card-bg, #fff);
    overflow: hidden; transition: box-shadow .15s;
}
.faq-item:hover { box-shadow: 0 2px 12px rgba(12,35,64,.07); }
.faq-q {
    width: 100%; background: none; border: none; text-align: left;
    padding: .9rem 1rem; font-size: .85rem; font-weight: 600;
    color: var(--text-primary, #111827); font-family: 'Poppins', sans-serif;
    cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: .5rem;
}
.faq-q:hover { background: var(--bg-secondary, #f9fafb); }
.faq-q .faq-icon { font-size: .7rem; color: #137a63; transition: transform .2s; flex-shrink: 0; }
.faq-q[aria-expanded="true"] .faq-icon { transform: rotate(180deg); }
.faq-q[aria-expanded="true"] { color: #0c2340; }
.faq-a {
    display: none;
    padding: .85rem 1rem .95rem;
    font-size: .83rem; color: var(--text-secondary, #4b5563);
    line-height: 1.75; border-top: 1px solid var(--border-color, #e5e7eb);
}
.faq-a.open { display: block; }

/* ─────────────────────────────────────────
   INTERNAL LINKS BAR
───────────────────────────────────────── */
.rera-links-bar {
    max-width: 860px; margin: 0 auto;
    padding: 1.5rem 1rem 2.5rem;
    border-top: 1px solid var(--border-color, #e5e7eb);
}
.rera-links-bar p { font-size: .8rem; color: var(--text-secondary, #4b5563); line-height: 1.9; }
.rera-links-bar a { color: #0c2340; font-weight: 500; text-decoration: none; }
.rera-links-bar a:hover { text-decoration: underline; }

/* ─────────────────────────────────────────
   DARK MODE
───────────────────────────────────────── */
[data-theme="dark"] .rera-tag { background: #374151; color: #d1d5db; border-color: #4b5563; }
[data-theme="dark"] .rera-card { border-color: #374151; background: #1f2937; }
[data-theme="dark"] .prog-bar { background: #374151; }
[data-theme="dark"] .faq-item { border-color: #374151; background: #1f2937; }
[data-theme="dark"] .faq-q { color: #f3f4f6; }
[data-theme="dark"] .faq-q:hover { background: #374151; }
[data-theme="dark"] .btn-icon { border-color: #4b5563; color: #d1d5db; }
[data-theme="dark"] .rera-about-section { background: #111827; border-color: #374151; }
[data-theme="dark"] .rera-about-inner h2,
[data-theme="dark"] .rera-about-inner h3 { color: #f9fafb; }
[data-theme="dark"] .rera-about-inner p { color: #d1d5db; }
[data-theme="dark"] .rera-trust-bar { background: #1f2937; border-color: #374151; }
[data-theme="dark"] .trust-item { color: #d1d5db; }
[data-theme="dark"] .trust-item i { color: #34d399; }

/* ─────────────────────────────────────────
   RESPONSIVE
───────────────────────────────────────── */
@media (max-width: 600px) {
    .rera-grid { grid-template-columns: 1fr; }
    .hero-cta-row { flex-direction: column; align-items: flex-start; }
    .rera-card-foot { gap: .35rem; }
    .rera-trust-inner { justify-content: flex-start; gap: .8rem; }
}
</style>
@endpush

@section('content')
@php
    // Pre-compute SEO-friendly counts for hero / H1
    $totalProjects = $stats['total'] ?? (isset($projects) ? count($projects) : 0);
    $resCount      = $stats['residential'] ?? 0;
    $comCount      = $stats['commercial'] ?? 0;
    $plotCount     = $stats['plotted'] ?? 0;

    // Unique builder list for "Top RERA Approved Builders" SEO section
    $builderList = collect($projects ?? [])
        ->pluck('builder')
        ->filter()
        ->unique()
        ->values();

    // Plotted-only filter for "RERA Approved Plots in Lucknow" SEO section
    $plottedProjects = collect($projects ?? [])
        ->filter(fn($p) => strtolower($p['category'] ?? '') === 'plotted')
        ->values();

    // Localities derived from projects for internal linking density
    $localities = collect($projects ?? [])
        ->pluck('location')
        ->filter()
        ->map(fn($l) => trim(explode(',', $l)[0]))
        ->unique()
        ->values();
@endphp

<div class="rera-page">

    {{-- ══════════════════════════════════════════════════════════════
         HERO
         ══════════════════════════════════════════════════════════════ --}}
    <section class="rera-hero">
        <div style="max-width:1200px;margin:0 auto;">
            <p style="font-size:.75rem;opacity:.55;margin-bottom:.5rem;">
                <a href="/" style="color:inherit;text-decoration:none;">Home</a> &rsaquo; RERA Approved Projects
            </p>

            <h1>
                <i class="fas fa-shield-alt" style="margin-right:.45rem;" aria-hidden="true"></i>RERA Approved Projects in Lucknow 2026 — {{ $totalProjects }} Verified UPRERA List
            </h1>

            <p class="hero-sub">
                Verified directory of <strong>{{ $totalProjects }} RERA approved projects in Lucknow</strong> — apartments, plots, villas &amp; commercial spaces.
                Every listing carries its UPRERAPRJ registration number, builder details, prices and possession dates, cross-checked against the official UP RERA portal.
            </p>

            <div class="hero-cta-row">
                <a href="/services/property-verification-lucknow" class="hero-btn-primary">
                    <i class="fas fa-check-double" aria-hidden="true"></i> Verify a Project (₹5,000)
                </a>
                <a href="https://www.up-rera.in/projects" target="_blank" rel="noopener noreferrer" class="hero-btn-outline">
                    <i class="fas fa-external-link-alt" style="font-size:.7rem;" aria-hidden="true"></i> UP RERA Portal
                </a>
            </div>

            <div class="hero-stats">
                <span class="stat-pill"><i class="fas fa-building" style="margin-right:.3rem;color:#34d399;" aria-hidden="true"></i>{{ $resCount }} Residential</span>
                <span class="stat-pill"><i class="fas fa-store" style="margin-right:.3rem;color:#fbbf24;" aria-hidden="true"></i>{{ $comCount }} Commercial</span>
                <span class="stat-pill"><i class="fas fa-th-large" style="margin-right:.3rem;color:#a78bfa;" aria-hidden="true"></i>{{ $plotCount }} Plotted</span>
                <span class="stat-pill"><i class="fas fa-check-circle" style="margin-right:.3rem;" aria-hidden="true"></i>{{ $totalProjects }} Total</span>
                <span class="stat-pill" style="opacity:.7;font-size:.72rem;">
                    <i class="fas fa-sync-alt" style="margin-right:.3rem;" aria-hidden="true"></i>Updated: {{ $lastUpdated }}
                </span>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         TRUST BAR — establishes RERA authority signals
         ══════════════════════════════════════════════════════════════ --}}
    <div class="rera-trust-bar">
        <div class="rera-trust-inner">
            <span class="trust-item"><i class="fas fa-shield-alt" aria-hidden="true"></i> UPRERA Verified</span>
            <span class="trust-item"><i class="fas fa-file-contract" aria-hidden="true"></i> Builder-Buyer Agreement</span>
            <span class="trust-item"><i class="fas fa-university" aria-hidden="true"></i> Escrow Account Protected</span>
            <span class="trust-item"><i class="fas fa-balance-scale" aria-hidden="true"></i> Complaint Mechanism</span>
            <span class="trust-item"><i class="fas fa-clock" aria-hidden="true"></i> Timely Delivery Mandate</span>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         CONTROLS BAR
         ══════════════════════════════════════════════════════════════ --}}
    <div class="rera-controls">
        <div class="rera-controls-inner">
            <input type="text" id="rera-search" class="rera-search"
                   placeholder="Search projects, builders, locations, RERA ID…"
                   autocomplete="off" aria-label="Search RERA projects">
            <button class="rera-filter-btn active" data-filter="all">All <span class="filter-n">{{ $stats['total'] }}</span></button>
            @if($stats['residential'])
            <button class="rera-filter-btn" data-filter="residential">Residential <span class="filter-n">{{ $stats['residential'] }}</span></button>
            @endif
            @if($stats['commercial'])
            <button class="rera-filter-btn" data-filter="commercial">Commercial <span class="filter-n">{{ $stats['commercial'] }}</span></button>
            @endif
            @if($stats['plotted'])
            <button class="rera-filter-btn" data-filter="plotted">Plotted <span class="filter-n">{{ $stats['plotted'] }}</span></button>
            @endif
            @if($stats['mixed_use'])
            <button class="rera-filter-btn" data-filter="mixed-use">Mixed Use <span class="filter-n">{{ $stats['mixed_use'] }}</span></button>
            @endif
            <select class="rera-sort" id="rera-sort" aria-label="Sort projects">
                <option value="default">Default order</option>
                <option value="name">Name A–Z</option>
                <option value="price_asc">Price: Low → High</option>
                <option value="price_desc">Price: High → Low</option>
                <option value="progress">Progress %</option>
            </select>
            <span class="rera-count" id="rera-count">{{ count($projects) }} projects</span>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         PROJECT CARDS GRID
         ══════════════════════════════════════════════════════════════ --}}
    <div class="rera-grid" id="rera-grid" aria-label="RERA project listings">

        @forelse ($projects as $p)
        @php
            $categorySlug  = strtolower(str_replace(' ', '-', $p['category'] ?? 'residential'));
            $featured       = ($p['featured'] ?? false) ? 'featured' : '';
            // Worked out in ReraProjectController so the badge, the filter buttons
            // and the counts can never disagree. Fallbacks keep the partial
            // usable if it is ever rendered with raw JSON.
            $statusKey      = $p['status_key'] ?? 'active';
            $statusLabel    = $p['status_label'] ?? ($p['status'] ?? 'Registered');
            $filterGroup    = $p['filter_group'] ?? 'residential';
            $projectAnchor  = $p['project_id'] ?? 'project-'.($loop->index + 1);
            $projectName    = $p['name'] ?? 'this project';
            $builderName    = $p['builder'] ?? '';
            $reraNumber     = $p['rera_number'] ?? '';
            $waMsg          = urlencode('Hi, I want to know about ' . $projectName . ' (RERA: ' . $reraNumber . ') in Lucknow. Please share details.');

            // Differentiate "Verified" strip per project — avoid duplicate-content signal
            $verifiedStripVariants = [
                "UPRERAPRJ verified · Listed on UP RERA portal",
                "RERA Registered · Cross-checked with UP RERA records",
                "✅ UPRERA registration active · Escrow protected",
                "Verified UPRERAPRJ · Builder details on UP RERA portal",
                "RERA approved · Open for buyer due-diligence",
            ];
            $verifiedStrip = $verifiedStripVariants[$loop->index % count($verifiedStripVariants)];

            // Build deep RERA link if specific URL not provided — pre-fills search
            $defaultReraLink = $reraNumber
                ? 'https://www.up-rera.in/projects?regNo=' . urlencode($reraNumber)
                : 'https://www.up-rera.in/projects';
            $reraDeepLink = $p['rera_link'] ?? $defaultReraLink;
        @endphp

        <article class="rera-card {{ $featured }} {{ $filterGroup }}"
             id="{{ $projectAnchor }}"
             data-status="{{ $filterGroup }}"
             data-search="{{ strtolower(($p['name'] ?? '') . ' ' . ($p['builder'] ?? '') . ' ' . ($p['location'] ?? '') . ' ' . ($p['category'] ?? '') . ' ' . ($p['rera_number'] ?? '')) }}"
             data-price="{{ $p['price_per_sqft'] ?? 0 }}"
             data-progress="{{ $p['progress_pct'] ?? 0 }}"
             data-order="{{ $p['sort_order'] ?? 99 }}">

            {{-- Card header --}}
            <div class="rera-card-header">
                <div class="card-top">
                    <div class="card-top-left">
                        @if(!empty($reraNumber))
                            <div class="card-rera-id"><i class="fas fa-shield-alt" style="font-size:.55rem;margin-right:.25rem;" aria-hidden="true"></i>{{ $reraNumber }}</div>
                        @elseif(!empty($p['rera_note']))
                            <div class="card-rera-id"><i class="fas fa-shield-alt" style="font-size:.55rem;margin-right:.25rem;" aria-hidden="true"></i>Multiple RERA IDs</div>
                        @endif
                        <div class="card-builder">{{ $builderName }} &bull; {{ $p['category'] ?? '' }}</div>
                    </div>
                    {{-- Short label, not the raw status: the full wording goes in the body. --}}
                    <span class="rera-badge badge-{{ $statusKey }}">{{ $statusLabel }}</span>
                </div>
                <h2 class="card-name">{{ $projectName }}</h2>
                <div class="card-loc">
                    <i class="fas fa-map-marker-alt" style="font-size:.65rem;" aria-hidden="true"></i>
                    <span>{{ $p['location'] ?? '' }}</span>
                </div>
            </div>

            {{-- RERA Verified strip (varied per project to avoid duplicate-content signal) --}}
            @if(!empty($reraNumber))
            <div class="rera-verified-strip">
                <i class="fas fa-check-circle" aria-hidden="true"></i>
                {{ $verifiedStrip }}
            </div>
            @endif

            {{-- Progress bar --}}
            @if(($p['progress_pct'] ?? 0) > 0)
            <div class="rera-progress">
                <div class="prog-label">
                    <span>{{ $p['construction_phase'] ?? $p['status'] ?? '' }}</span>
                    <span>{{ $p['progress_pct'] }}% complete</span>
                </div>
                <div class="prog-bar"
                     role="progressbar"
                     aria-valuenow="{{ $p['progress_pct'] }}"
                     aria-valuemin="0" aria-valuemax="100">
                    <div class="prog-fill" style="width:{{ $p['progress_pct'] }}%"></div>
                </div>
            </div>
            @endif

            {{-- Meta grid --}}
            <div class="rera-meta">
                @if(!empty($p['unit_types']))
                <div>
                    <div class="meta-label"><i class="fas fa-bed" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Configuration</div>
                    <div class="meta-value">
                        @if(is_array($p['unit_types']))
                            {{ implode(', ', $p['unit_types']) }}
                        @else
                            {{ $p['unit_types'] }}
                        @endif
                    </div>
                </div>
                @endif
                @if(($p['total_units'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-layer-group" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Total Units</div>
                    <div class="meta-value">{{ number_format($p['total_units']) }}</div>
                </div>
                @endif
                @if(($p['area_sqft_min'] ?? 0) > 0 || !empty($p['area_sqft_range']))
                <div>
                    <div class="meta-label"><i class="fas fa-ruler-combined" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Sizes</div>
                    <div class="meta-value">
                        @if(($p['area_sqft_min'] ?? 0) > 0)
                            {{ number_format($p['area_sqft_min']) }}–{{ number_format($p['area_sqft_max'] ?? $p['area_sqft_min']) }} sqft
                        @else
                            {{ $p['area_sqft_range'] }}
                        @endif
                    </div>
                </div>
                @endif
                @if(($p['price_per_sqft'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-rupee-sign" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Rate</div>
                    <div class="meta-value price-highlight">₹{{ number_format($p['price_per_sqft']) }}/sqft</div>
                </div>
                @endif
                @if(!empty($p['price_range']))
                <div>
                    <div class="meta-label"><i class="fas fa-tag" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Price Range</div>
                    <div class="meta-value">{{ $p['price_range'] }}</div>
                </div>
                @endif
                @php $possession = $p['possession_date'] ?? $p['possession'] ?? null; @endphp
                @if(!empty($possession) && $possession !== 'N/A')
                <div>
                    <div class="meta-label"><i class="fas fa-calendar-check" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Possession</div>
                    <div class="meta-value">{{ $possession }}</div>
                </div>
                @endif
                @if(!empty($p['sanctioning_authority']))
                <div>
                    <div class="meta-label"><i class="fas fa-landmark" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Approved By</div>
                    <div class="meta-value">{{ $p['sanctioning_authority'] }}</div>
                </div>
                @endif
                @if(!empty($p['project_area_acres']) && $p['project_area_acres'] > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-expand" style="font-size:.62rem;margin-right:.2rem;" aria-hidden="true"></i>Project Area</div>
                    <div class="meta-value">{{ $p['project_area_acres'] }} Acres</div>
                </div>
                @endif
            </div>

            {{-- Full status wording and any RERA caveat, which the short badge drops --}}
            @if(!empty($p['status']) || !empty($p['rera_note']))
            <div class="rera-statusline">
                @if(!empty($p['status']))
                    <span><i class="fas fa-hard-hat" aria-hidden="true"></i> {{ $p['status'] }}</span>
                @endif
                @if(!empty($p['rera_note']))
                    <span><i class="fas fa-file-contract" aria-hidden="true"></i> {{ $p['rera_note'] }}</span>
                @endif
            </div>
            @endif

            {{-- Highlight tags --}}
            @if(!empty($p['highlights']) && is_array($p['highlights']))
            <div class="rera-tags" aria-label="Project highlights">
                @foreach($p['highlights'] as $tag)
                    @if(trim($tag))
                    <span class="rera-tag">{{ trim($tag) }}</span>
                    @endif
                @endforeach
            </div>
            @endif

            {{-- Description --}}
            @if(!empty($p['description']))
            <div class="rera-desc">{{ $p['description'] }}</div>
            @endif

            {{-- Card footer --}}
            <div class="rera-card-foot">

                <a href="{{ $reraDeepLink }}"
                   target="_blank" rel="noopener noreferrer"
                   class="btn-rera"
                   aria-label="View {{ $projectName }} on UP RERA portal">
                    <i class="fas fa-shield-alt" style="font-size:.62rem;" aria-hidden="true"></i>
                    View on RERA
                </a>

                @if(!empty($p['read_more']))
                <a href="{{ $p['read_more'] }}"
                   class="btn-read-more"
                   aria-label="Read detailed review of {{ $projectName }}">
                    <i class="fas fa-book-open" style="font-size:.62rem;" aria-hidden="true"></i>
                    Read More
                </a>
                @endif

                <a href="https://wa.me/918595002933?text={{ $waMsg }}"
                   target="_blank" rel="noopener noreferrer"
                   class="btn-wa-project"
                   aria-label="Send WhatsApp query about {{ $projectName }}">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    Query
                </a>

                @if(!empty($p['map_link']))
                <a href="{{ $p['map_link'] }}" target="_blank" rel="noopener noreferrer"
                   class="btn-icon" aria-label="View {{ $projectName }} location on map">
                    <i class="fas fa-map" style="font-size:.72rem;" aria-hidden="true"></i>
                </a>
                @endif

                @if(!empty($p['brochure_link']))
                <a href="{{ $p['brochure_link'] }}" target="_blank" rel="noopener noreferrer"
                   class="btn-icon" aria-label="Download {{ $projectName }} brochure">
                    <i class="fas fa-file-pdf" style="font-size:.72rem;" aria-hidden="true"></i>
                </a>
                @endif

            </div>

        </article>
        @empty
        <div class="rera-empty">
            <i class="fas fa-folder-open" aria-hidden="true"></i>
            <p>No projects loaded. Please upload the JSON data file.</p>
        </div>
        @endforelse

        <div class="rera-empty" id="no-results" style="display:none;" aria-live="polite">
            <i class="fas fa-search" aria-hidden="true"></i>
            <p>No projects match your search.</p>
        </div>
    </div>

    {{-- Disclaimer --}}
    <div style="max-width:1200px;margin:0 auto;padding:.5rem 1rem 1rem;">
        <p style="font-size:.72rem;color:var(--text-tertiary);line-height:1.6;border-top:1px solid var(--border-color);padding-top:.6rem;">
            <i class="fas fa-info-circle" style="margin-right:.3rem;" aria-hidden="true"></i>
            Data sourced from UP RERA portal (up-rera.in) and builder communications. Prices, availability and dates are subject to change — verify directly with the builder and UP RERA before any purchase decision.
            Last refresh: {{ $lastUpdated }}.
        </p>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ABOUT RERA SECTION  (+ adjacent-keyword H3 sections)
         ══════════════════════════════════════════════════════════════ --}}
    <div class="rera-about-section">
        <div class="rera-about-inner">
            <h2>
                <i class="fas fa-shield-alt" style="margin-right:.45rem;color:#137a63;" aria-hidden="true"></i>About RERA Approved Projects in Lucknow
            </h2>
            <p>
                The <strong>Uttar Pradesh Real Estate Regulatory Authority (UPRERA)</strong> is the state body established under the RERA Act 2016 to regulate and promote transparency in real estate transactions across Uttar Pradesh.
                Every residential and commercial project above 500 sqm or 8 units must be registered with UPRERA before advertising or selling.
            </p>
            <p>
                Buying a <strong>RERA registered project in Lucknow</strong> ensures you are protected by law — builders must maintain an escrow account, deliver on time, and follow the approved plan.
                Lucknow recorded <strong>67 RERA registered projects</strong> with over ₹9,398 crore investment in 2025 alone, making it one of the most active real estate markets in Uttar Pradesh outside NCR.
            </p>
            <p>
                This page tracks all active RERA approved projects across Lucknow — from Gomti Nagar Extension and Sultanpur Road to Shaheed Path, Faizabad Road and Sitapur Road.
                For personalised guidance on verifying any project, checking builder track records, and securing the best deal — reach out to DSD Properties for a <strong>free consultation</strong>.
            </p>

            {{-- ─────── New SEO H3: Top RERA Approved Builders ─────── --}}
            @if($builderList->isNotEmpty())
            <h3 id="rera-approved-builders-lucknow">
                <i class="fas fa-hard-hat" style="margin-right:.45rem;color:#137a63;" aria-hidden="true"></i>Top RERA Approved Builders in Lucknow
            </h3>
            <p>
                The following <strong>RERA approved builders in Lucknow</strong> have active UPRERA registered projects in our directory. Each builder's RERA registration can be cross-verified on the UP RERA portal using the project's UPRERAPRJ number — a critical step before any booking.
            </p>
            <div class="rera-builders-grid">
                @foreach($builderList as $builder)
                <div class="rera-builder-chip">
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span>{{ $builder }}</span>
                </div>
                @endforeach
            </div>
            <p style="font-size:.78rem;color:var(--text-tertiary);">
                Looking for a builder not listed here? Use our <a href="/services/property-verification-lucknow" style="color:#137a63;font-weight:600;">RERA verification service</a> to check any Lucknow builder's registration status, project history, and UPRERA compliance record.
            </p>
            @endif

            {{-- ─────── New SEO H3: RERA Approved Plots in Lucknow ─────── --}}
            <h3 id="rera-approved-plots-lucknow">
                <i class="fas fa-th-large" style="margin-right:.45rem;color:#137a63;" aria-hidden="true"></i>RERA Approved Plots in Lucknow
            </h3>
            <p>
                <strong>RERA approved plots in Lucknow</strong> are plotted developments above 500 sqm registered under UPRERA. These offer the strongest legal protection for plot buyers — registered layout, escrow-protected payments, and a binding possession timeline. Major plotted RERA registered townships are concentrated along <strong>Sultanpur Road</strong>, <strong>Raebareli Road</strong>, and <strong>Mohanlalganj</strong>.
            </p>
            @if($plottedProjects->isNotEmpty())
            <p>
                Currently tracked plotted projects in our directory:
                @foreach($plottedProjects as $i => $pp)
                    <a href="#{{ $pp['project_id'] ?? 'project' }}" style="color:#137a63;font-weight:600;">{{ $pp['name'] ?? 'Unnamed' }}</a>@if(!$loop->last), @endif
                @endforeach.
            </p>
            @endif
            <p style="font-size:.83rem;">
                Before booking any plot — RERA registered or not — verify (1) the exact plot is part of the approved layout, (2) the seller has registered title, (3) there are no existing encumbrances, and (4) the plot complies with LDA / local authority approval.
                <a href="/services/property-verification-lucknow" style="color:#137a63;font-weight:600;">DSD's plot verification</a> covers all four checks in 48 hours.
            </p>

            {{-- ─────── Locality chip cluster (internal linking + locality keyword density) ─────── --}}
            @if($localities->isNotEmpty())
            <h3 id="rera-projects-by-locality">
                <i class="fas fa-map-marked-alt" style="margin-right:.45rem;color:#137a63;" aria-hidden="true"></i>RERA Projects by Locality
            </h3>
            <p>Browse RERA approved projects by Lucknow locality:</p>
            <div class="rera-loc-grid">
                @foreach($localities as $loc)
                <a href="#" onclick="filterByLoc('{{ addslashes($loc) }}'); return false;" class="rera-loc-chip">
                    <i class="fas fa-map-pin" aria-hidden="true"></i>{{ $loc }}
                </a>
                @endforeach
            </div>
            @endif

            <div class="about-cta-row">
                <a href="/services/property-verification-lucknow" class="about-btn-primary">
                    <i class="fas fa-check-double" aria-hidden="true"></i> Verify a Property (₹5,000)
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         FAQ SECTION  (now with RERA approved plots Q to capture that query)
         ══════════════════════════════════════════════════════════════ --}}
    <div class="rera-faq">
        <h2>
            <i class="fas fa-question-circle" style="margin-right:.45rem;color:#137a63;" aria-hidden="true"></i>Frequently Asked Questions — RERA Projects Lucknow
        </h2>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="rfaq-a1" onclick="toggleReraFaq(this)">
                How do I check if a project in Lucknow is RERA approved?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="rfaq-a1">
                Visit the official UP RERA portal at <a href="https://www.up-rera.in/projects" target="_blank" rel="noopener noreferrer" style="color:#0c2340;font-weight:600;">up-rera.in</a> and search by project name, builder name, or RERA registration number (UPRERAPRJ number). Every registered project's details — including approved plan, timeline, and financial disclosures — are available publicly. DSD Properties also offers <a href="/services/property-verification-lucknow" style="color:#0c2340;font-weight:600;">property verification services</a> for thorough due diligence.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="rfaq-a2" onclick="toggleReraFaq(this)">
                What is UPRERA and why is RERA registration important?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="rfaq-a2">
                <strong>UPRERA</strong> (Uttar Pradesh Real Estate Regulatory Authority) is the state regulatory body under the RERA Act 2016. RERA registration is mandatory for all residential and commercial projects above 500 sqm or 8 units. It ensures transparency through public disclosure, protects buyers with mandatory escrow accounts, mandates timely delivery, and provides a grievance redressal mechanism. <strong>Always buy only RERA registered projects</strong> for legal safety and financial protection.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="rfaq-a-plots" onclick="toggleReraFaq(this)">
                Are there RERA approved plots in Lucknow?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="rfaq-a-plots">
                Yes. Plotted developments above 500 sqm in Lucknow must be RERA registered with a valid UPRERAPRJ number. Major <strong>RERA approved plotted townships</strong> are available on Sultanpur Road, Raebareli Road, and Mohanlalganj. Always verify the plot's RERA registration on <a href="https://www.up-rera.in/projects" target="_blank" rel="noopener noreferrer" style="color:#0c2340;font-weight:600;">up-rera.in</a> before booking, and check that the layout matches the approved plan. DSD Properties offers plot-specific verification including <a href="/services/property-verification-lucknow" style="color:#0c2340;font-weight:600;">title check and approved layout cross-verification</a>.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="rfaq-a3" onclick="toggleReraFaq(this)">
                What documents should I verify before buying a RERA registered project?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="rfaq-a3">
                Key documents to verify include: RERA registration certificate with valid UPRERAPRJ number, approved building plan from the competent authority (LDA or Nagar Nigam), land title and ownership documents, encumbrance certificate, NOCs from relevant departments (fire, environment, AAI if applicable), and the builder-buyer agreement in RERA-compliant format. DSD Properties offers a comprehensive <a href="/services/property-verification-lucknow" style="color:#0c2340;font-weight:600;">property verification service</a> covering all these checks.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="rfaq-a4" onclick="toggleReraFaq(this)">
                Can I file a complaint against a RERA registered builder in Lucknow?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="rfaq-a4">
                Yes. Homebuyers can file complaints on the <a href="https://www.up-rera.in" target="_blank" rel="noopener noreferrer" style="color:#0c2340;font-weight:600;">UP RERA portal</a> against any registered builder for issues like project delays, quality defects, deviation from approved plan, or agreement violations. UPRERA has a dedicated adjudicating bench in Lucknow. The filing fee is ₹1,000 for individual homebuyers. You can also approach the RERA Appellate Tribunal for further relief.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="rfaq-a5" onclick="toggleReraFaq(this)">
                Are home loans easier to get for RERA approved projects?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="rfaq-a5">
                Yes. Banks and NBFCs prefer lending on RERA registered projects because they carry lower risk — the project has valid government approvals, a dedicated escrow account for buyer funds, and a legally mandated completion timeline. Most major banks in Lucknow (SBI, HDFC, ICICI, PNB, Bank of Baroda) readily approve home loans for UPRERA registered projects, often at preferred interest rates.
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-q" aria-expanded="false" aria-controls="rfaq-a6" onclick="toggleReraFaq(this)">
                Which areas in Lucknow have the most RERA approved projects?
                <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
            </button>
            <div class="faq-a" id="rfaq-a6">
                As of 2026, the highest concentration of RERA registered projects in Lucknow is along <strong>Sultanpur Road</strong>, <strong>Shaheed Path</strong>, <strong>Gomti Nagar Extension</strong>, <strong>Faizabad Road</strong>, <strong>Sitapur Road</strong>, and <strong>Raebareli Road</strong>. These corridors are seeing rapid residential and commercial development, backed by infrastructure like the Lucknow Metro extension and Outer Ring Road connectivity.
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         INTERNAL LINKS
         ══════════════════════════════════════════════════════════════ --}}
    <div class="rera-links-bar">
        <p>
            <strong>Explore more:</strong>
            <a href="/lda-schemes">LDA Schemes Lucknow</a> &middot;
            <a href="/blog/it-city-lucknow-lda-plots-guide-2026">CG City / IT City guide</a> &middot;
            <a href="/blog/gomti-nagar-extension-lucknow-guide-2026">Gomti Nagar Extension</a> &middot;
            <a href="/blog/rise-of-sultanpur-road-lucknow-real-estate-hotspot">Sultanpur Road</a> &middot;
            <a href="/blog/vrindavan-yojna-lucknow-investment-guide-2026">Vrindavan Yojna</a> &middot;
            <a href="/blog/understanding-rera-guide-lucknow-property-buyers-C7ECl">RERA Buyer's Guide</a> &middot;
            <a href="/blog/buy-lda-approved-plots-lucknow-avoid-scams-3W95Z">LDA Plot Guide</a> &middot;
            <a href="/services/property-verification-lucknow">Property Verification Service</a> &middot;
            <a href="/services/property-advisory-lucknow">Free Property Advisory</a>
        </p>
    </div>

</div>

<script>
(function () {
    const cards = Array.from(document.querySelectorAll('#rera-grid .rera-card'));
    const grid  = document.getElementById('rera-grid');
    const noRes = document.getElementById('no-results');
    const count = document.getElementById('rera-count');
    const searchEl = document.getElementById('rera-search');
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
        count.textContent = vis + (vis === 1 ? ' project' : ' projects');
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

    document.querySelectorAll('.rera-filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.rera-filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filter = this.dataset.filter;
            render();
        });
    });

    searchEl.addEventListener('input', function () {
        query = this.value.toLowerCase().trim();
        render();
    });

    document.getElementById('rera-sort').addEventListener('change', function () {
        sort(this.value);
        render();
    });

    // Locality chip → pre-fill search box and scroll to grid
    window.filterByLoc = function (loc) {
        searchEl.value = loc;
        query = loc.toLowerCase().trim();
        render();
        document.getElementById('rera-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
    };
})();

function toggleReraFaq(btn) {
    const expanded = btn.getAttribute('aria-expanded') === 'true';
    const answer   = document.getElementById(btn.getAttribute('aria-controls'));
    btn.setAttribute('aria-expanded', String(!expanded));
    answer.classList.toggle('open', !expanded);
}
</script>
@endsection