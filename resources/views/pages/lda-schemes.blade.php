@extends('layouts.user-app')

{{-- ═══════════════════════════════════════════════════════════════
     SEO: Title · Meta Description · Keywords  (REWRITTEN 2026-05)
     Strategy: Drop "DSD Properties" from title (no brand pull on these
     queries), lead with "LDA New Scheme 2026" (1000+ impressions),
     hit "Plots / Flats / Ballot Dates" — the three transactional buckets.
     ═══════════════════════════════════════════════════════════════ --}}
@section('title', 'LDA Lucknow Complete Guide 2026 — Schemes, Registration & Latest News')
@section('meta_description', 'LDA new schemes Lucknow 2026: IT City, Wellness City, Anant Nagar, Park View Basant Kunj, Naimish Nagar, Varun Vihar. Live prices ₹2,045–₹4,522/sqft, ballot dates, units available. Updated weekly. Free advisory by DSD Properties.')
@section('meta_keywords', 'LDA new scheme 2026, LDA plot scheme Lucknow, LDA flats Lucknow, LDA new plot scheme 2026, LDA housing scheme, LDA lottery ballot date 2026, LDA online registration last date, LDA FCFS allotment, Lucknow Development Authority plots, Anant Nagar Yojna, IT City Sultanpur Road, Wellness City Lucknow, Park View Basant Kunj, Naimish Nagar Sitapur Road, Varun Vihar Faizabad Road, Atal Nagar Awasiya Yojana Phase II, LDA PMAY flats EWS LIG, LDA upcoming schemes, government plot scheme Lucknow')

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="canonical" href="{{ url()->current() }}" />

{{-- ═══════════════════════════════════════════════════════════════
     STRUCTURED DATA — REWRITTEN
     1. ItemList of RealEstateListing (replaces broken Product/Offer
        markup that was using "DSD Properties" as seller for LDA schemes)
     2. FAQPage — expanded from 6 → 10 questions to capture
        FCFS, registration last date, ballot date, flat prices
     3. Organization + RealEstateAgent retained as-is
     ═══════════════════════════════════════════════════════════════ --}}

{{-- ItemList schema — proper for a directory/listing page --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "LDA New Schemes Lucknow 2026",
  "description": "Active and upcoming Lucknow Development Authority housing, plot and township schemes",
  "numberOfItems": {{ count($schemes) }},
  "itemListElement": [
    @foreach($schemes as $idx => $s)
    {
      "@type": "ListItem",
      "position": {{ $idx + 1 }},
      "url": "{{ url('/lda-schemes#' . ($s['scheme_id'] ?? 'scheme-'.($idx+1))) }}",
      "name": "{{ addslashes($s['name'] ?? '') }}"
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>

{{-- FAQ schema — expanded to 10 questions, mapped to real GSC queries --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How do I apply for an LDA new scheme in Lucknow 2026?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Apply through the official LDA portal at ldalucknow.in. For lottery schemes (Anant Nagar, Wellness City, IT City), submit your application during the open window and await the ballot date. For FCFS (First Come First Serve) schemes, allotment is on a first-come basis. DSD Properties can guide you through eligibility and documentation — contact us on +91-85950-02933 for a free consultation."
      }
    },
    {
      "@type": "Question",
      "name": "When is the next LDA ballot date in 2026?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Confirmed 2026 ballot dates: Park View Apartments Basant Kunj — 25 April 2026 (completed), Anant Nagar Phase 4 — 30 January 2026 (completed), IT City Phase 1 — March 2026 (completed). Wellness City ballot is expected in 2026; Naimish Nagar, Varun Vihar and Atal Nagar Phase II ballot dates are TBA. Check this page weekly for updates."
      }
    },
    {
      "@type": "Question",
      "name": "What is FCFS allotment in LDA?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "FCFS (First Come First Serve) is an LDA allotment method where units are allotted in the exact order applications are received until all units are sold. Unlike lottery schemes where every applicant has an equal chance, in FCFS speed matters — applying within the first hours of opening usually secures allotment. The Vasant Kunj apartments scheme has historically used the FCFS model."
      }
    },
    {
      "@type": "Question",
      "name": "What is the last date for LDA online registration in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Last dates vary per scheme. The current scheme registration windows are listed in the table on this page. Park View Basant Kunj registration closed on 25 April 2026. Anant Nagar Phase 4 registration is open. For the latest cutoff, always verify on ldalucknow.in or send us a query through the form on this page."
      }
    },
    {
      "@type": "Question",
      "name": "What is the LDA lottery ballot process?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "LDA conducts a computerised lottery (ballot) for schemes where demand exceeds supply. All eligible applicants enter the draw and winners are selected randomly. Applicants not selected receive a full refund of the application fee. Ballot dates are announced on ldalucknow.in and reflected on this page once confirmed."
      }
    },
    {
      "@type": "Question",
      "name": "What is the difference between FCFS and lottery allotment in LDA?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "In FCFS (First Come First Serve), units are allotted in the order applications are received until sold out. In lottery allotment, all eligible applicants enter a computerised draw and winners are randomly selected regardless of when they applied. FCFS rewards speed; lottery is purely chance-based with equal opportunity for all eligible applicants."
      }
    },
    {
      "@type": "Question",
      "name": "What are the latest LDA flat prices in Lucknow 2026?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "LDA flat rates in Lucknow currently range from ₹2,045/sqft (PMAY Basant Kunj — EWS/LIG affordable housing, delivered) to ₹4,522/sqft (Park View Apartments Basant Kunj — premium 3BHK). Plot rates range from ₹3,252/sqft (Varun Vihar) to ₹4,180/sqft (IT City). Premium resale schemes like Picadilly Enclave trade at ~₹9,500/sqft."
      }
    },
    {
      "@type": "Question",
      "name": "Are home loans available on LDA scheme plots and flats?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Most nationalised and major private banks provide home loans on LDA-allotted plots and flats, as LDA is a UP government authority. Required documents: LDA allotment letter, payment receipts, PAN, Aadhaar, and address proof. PMAY beneficiaries under Basant Kunj can also avail the CLSS interest subsidy."
      }
    },
    {
      "@type": "Question",
      "name": "What documents are required for LDA scheme allotment?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Typically: Aadhaar card, PAN card, passport-size photographs, income certificate (for income-based schemes like PMAY EWS/LIG), bank account details for application fee deposit, and address proof. Requirements may vary per scheme — always verify the latest checklist on ldalucknow.in before applying."
      }
    },
    {
      "@type": "Question",
      "name": "Which is the most affordable LDA housing scheme in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "PMAY Basant Kunj is the most affordable LDA housing at ₹2,045/sqft for EWS and LIG flats (delivered). Among plotted schemes, Varun Vihar Yojna on Agra Expressway starts at ₹3,252/sqft and Naimish Nagar Yojna on Sitapur Road at ₹3,345/sqft, both targeting middle-income groups."
      }
    }
  ]
}
</script>

{{-- Organization Schema --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "@id": "{{ url('/') }}#organization",
  "name": "DSD Properties",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('images/logo.webp') }}",
  "description": "DSD Properties is Lucknow's premier real estate advisory for LDA schemes, PMAY housing, and property investments",
  "areaServed": {
    "@type": "City",
    "name": "Lucknow",
    "addressCountry": "IN"
  },
  "sameAs": [
    "https://www.facebook.com/dsdproperties",
    "https://www.instagram.com/dsdproperties"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "contactType": "Customer Support",
    "telephone": "+918595002933",
    "email": "dheer@dsdproperties.in",
    "areaServed": "IN",
    "availableLanguage": ["en", "hi"]
  },
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "226025",
    "addressCountry": "IN"
  }
}
</script>

{{-- Real Estate Agent Schema --}}
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
    "LDA new scheme 2026", "LDA housing schemes Lucknow",
    "LDA plot scheme Lucknow 2026", "LDA flats Lucknow",
    "LDA ballot date 2026", "LDA FCFS allotment",
    "government housing scheme Lucknow", "PMAY Lucknow"
  ],
  "sameAs": ["https://dsdproperties.in"]
}
</script>

<style>
/* ─────────────────────────────────────────
   BASE
───────────────────────────────────────── */
.lda-page { background-color: var(--bg-secondary, #f3f4f6); min-height: 100vh; }

/* ─────────────────────────────────────────
   HERO  (matches service page gradient)
───────────────────────────────────────── */
.lda-hero {
    background: linear-gradient(135deg, #011f4b 0%, #013a75 50%, #008080 100%);
    padding: 3rem 1rem 2.5rem;
    color: #fff;
}
.lda-hero h1 {
    font-size: clamp(1.4rem, 3vw, 2.1rem);
    font-weight: 700;
    margin-bottom: .4rem;
}
.lda-hero .hero-sub {
    font-size: .92rem;
    opacity: .85;
    max-width: 680px;
    margin: .4rem 0 0;
    line-height: 1.6;
}
.hero-stats { display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1.25rem; }
.stat-pill {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 50px;
    padding: .3rem .9rem;
    font-size: .78rem;
    font-weight: 500;
}
/* Hero CTA row — mirrors service page */
.hero-cta-row {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    margin-top: 1.5rem;
    align-items: center;
}
.hero-btn-primary {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #fff; color: #011f4b;
    font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s, color .15s;
}
.hero-btn-primary:hover { background: #e0f2f1; color: #011f4b; text-decoration: none; }
.hero-btn-wa {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #25d366; color: #fff;
    font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s;
}
.hero-btn-wa:hover { background: #1ebe5d; color: #fff; text-decoration: none; }

/* ─────────────────────────────────────────
   TOC  (NEW — for jump-to sitelinks + scannability)
───────────────────────────────────────── */
.lda-toc {
    max-width: 1200px; margin: 1rem auto 0;
    padding: .75rem 1rem;
    background: var(--bg-primary, #fff);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 10px;
    display: flex; flex-wrap: wrap; gap: .4rem;
    align-items: center;
}
.lda-toc-label {
    font-size: .72rem; font-weight: 700; letter-spacing: .04em;
    text-transform: uppercase; color: var(--text-tertiary, #6b7280);
    margin-right: .4rem;
}
.lda-toc a {
    font-size: .76rem; padding: .25rem .7rem;
    background: var(--bg-secondary, #f3f4f6);
    color: #011f4b; border-radius: 50px;
    text-decoration: none; font-weight: 500;
    border: 1px solid transparent;
    transition: all .15s;
}
.lda-toc a:hover { background: #011f4b; color: #fff; text-decoration: none; }

/* ─────────────────────────────────────────
   CONTROLS BAR
───────────────────────────────────────── */
.lda-controls {
    background: var(--bg-primary, #fff);
    border-bottom: 1px solid var(--border-color, #e5e7eb);
    padding: .75rem 1rem;
    position: sticky; top: 0; z-index: 40;
}
.lda-controls-inner {
    max-width: 1200px; margin: 0 auto;
    display: flex; flex-wrap: wrap; gap: .5rem; align-items: center;
}
.lda-search {
    flex: 1; min-width: 180px;
    padding: .45rem .8rem;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .85rem; background: var(--input-bg, #fff);
    color: var(--text-primary, #111827); font-family: 'Poppins', sans-serif;
}
.lda-search:focus { outline: none; border-color: #011f4b; box-shadow: 0 0 0 3px rgba(1,31,75,.1); }
.lda-filter-btn {
    padding: .38rem .9rem;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 50px;
    font-size: .78rem; font-weight: 500; cursor: pointer;
    background: var(--bg-primary, #fff); color: var(--text-secondary, #4b5563);
    transition: all .15s; font-family: 'Poppins', sans-serif; white-space: nowrap;
}
.lda-filter-btn:hover, .lda-filter-btn.active { background: #011f4b; color: #fff; border-color: #011f4b; }
.lda-sort {
    padding: .38rem .7rem;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .8rem; background: var(--input-bg, #fff);
    color: var(--text-primary, #111827); font-family: 'Poppins', sans-serif; cursor: pointer;
}
.lda-count { font-size: .8rem; color: var(--text-tertiary, #6b7280); white-space: nowrap; }

/* ─────────────────────────────────────────
   CARDS GRID
───────────────────────────────────────── */
.lda-grid {
    max-width: 1200px; margin: 0 auto;
    padding: 1.25rem 1rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.1rem;
}

/* ─────────────────────────────────────────
   CARD
───────────────────────────────────────── */
/* TOC status colors */
.lda-toc a.toc-active    { background: rgba(5,150,105,.12); color: #065f46; border-color: rgba(5,150,105,.3); }
.lda-toc a.toc-upcoming  { background: rgba(245,158,11,.13); color: #92400e; border-color: rgba(245,158,11,.35); }
.lda-toc a.toc-completed { background: rgba(59,130,246,.12); color: #1e40af; border-color: rgba(59,130,246,.3); }
.lda-toc a.toc-active:hover    { background: #059669; color: #fff; border-color: #059669; text-decoration: none; }
.lda-toc a.toc-upcoming:hover  { background: #d97706; color: #fff; border-color: #d97706; text-decoration: none; }
.lda-toc a.toc-completed:hover { background: #2563eb; color: #fff; border-color: #2563eb; text-decoration: none; }

.lda-card {
    background: var(--card-bg, #fff);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 14px; overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    display: flex; flex-direction: column;
    box-shadow: 0 1px 4px rgba(1,31,75,.06);
    scroll-margin-top: 130px;
}
.lda-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(1,31,75,.12); }
.lda-card.featured { border-color: #008080; border-width: 1.5px; }

.lda-card-header {
    background: linear-gradient(135deg, #011f4b, #013a75);
    padding: .9rem 1rem .75rem; position: relative;
}
.lda-card.auction .lda-card-header { background: linear-gradient(135deg, #6d28d9, #4f46e5); }
.card-id   { font-size: .68rem; color: rgba(255,255,255,.5); letter-spacing: .05em; margin-bottom: .2rem; }
.card-name { font-size: .98rem; font-weight: 600; color: #fff; line-height: 1.35; margin: 0; }
.card-loc  { font-size: .75rem; color: rgba(255,255,255,.68); margin-top: .28rem; display: flex; align-items: center; gap: .25rem; }

.lda-badge {
    position: absolute; top: .85rem; right: .85rem;
    padding: .22rem .65rem; border-radius: 50px;
    font-size: .68rem; font-weight: 600;
    letter-spacing: .04em; text-transform: uppercase;
}
.badge-active    { background: #d1fae5; color: #065f46; }
.badge-upcoming  { background: #fef3c7; color: #92400e; }
.badge-completed { background: #dbeafe; color: #1e40af; }
.badge-paused    { background: #f3f4f6; color: #374151; }

/* Progress */
.lda-progress { padding: .6rem 1rem; border-bottom: 1px solid var(--border-color, #e5e7eb); }
.prog-label   { display: flex; justify-content: space-between; font-size: .7rem; color: var(--text-tertiary, #6b7280); margin-bottom: .28rem; }
.prog-bar     { height: 5px; background: var(--bg-tertiary, #e5e7eb); border-radius: 99px; overflow: hidden; }
.prog-fill    { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #011f4b, #008080); }

/* Meta grid */
.lda-meta { padding: .65rem 1rem; display: grid; grid-template-columns: 1fr 1fr; gap: .45rem; }
.meta-label { font-size: .67rem; color: var(--text-tertiary, #6b7280); text-transform: uppercase; letter-spacing: .04em; }
.meta-value { font-size: .8rem; font-weight: 600; color: var(--text-primary, #111827); margin-top: 1px; }
.meta-value.avail { color: #059669; }

/* Tags */
.lda-tags { padding: 0 1rem .6rem; display: flex; flex-wrap: wrap; gap: .3rem; }
.lda-tag {
    font-size: .67rem; padding: .18rem .55rem;
    background: var(--bg-secondary, #f3f4f6);
    color: var(--text-secondary, #4b5563);
    border-radius: 50px; border: 1px solid var(--border-color, #e5e7eb);
}

/* Description */
.lda-desc { padding: 0 1rem .65rem; font-size: .8rem; color: var(--text-secondary, #4b5563); line-height: 1.6; flex: 1; }

/* ─────────────────────────────────────────
   CARD FOOTER — REORDERED button row
   PRIMARY (teal):  Read More    — keeps users on our site
   SECONDARY (green): WhatsApp   — converts to lead
   TERTIARY (text):  View on LDA — official source link
   btn-icon:         Map / PDF
───────────────────────────────────────── */
.lda-card-foot {
    padding: .7rem 1rem;
    border-top: 1px solid var(--border-color, #e5e7eb);
    display: flex; gap: .4rem; flex-wrap: wrap; align-items: center;
}

/* PRIMARY: Read More — now teal solid (was outline) */
.btn-read-more {
    flex: 1; min-width: 100px;
    padding: .48rem .75rem;
    background: #008080; color: #fff;
    border: 1.5px solid #008080; border-radius: 8px;
    font-size: .76rem; font-weight: 600;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: all .15s;
    display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
    white-space: nowrap;
}
.btn-read-more:hover { background: #006666; border-color: #006666; color: #fff; text-decoration: none; }

/* SECONDARY: WhatsApp Query — green solid */
.btn-wa-scheme {
    padding: .48rem .75rem;
    background: #25d366; color: #fff;
    border: none; border-radius: 8px;
    font-size: .76rem; font-weight: 600;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s; display: inline-flex; align-items: center; gap: .3rem;
    white-space: nowrap;
}
.btn-wa-scheme:hover { background: #1ebe5d; color: #fff; text-decoration: none; }

/* TERTIARY: View on LDA — text-style, low visual weight */
.btn-lda {
    padding: .48rem .6rem;
    background: transparent; color: #6b7280;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .72rem; font-weight: 500; cursor: pointer;
    text-align: center; text-decoration: none;
    font-family: 'Poppins', sans-serif; transition: all .15s;
    display: inline-flex; align-items: center; justify-content: center; gap: .25rem;
}
.btn-lda:hover { background: #f3f4f6; color: #011f4b; border-color: #011f4b; text-decoration: none; }

.btn-icon {
    padding: .48rem .6rem;
    background: transparent; color: #011f4b;
    border: 1px solid var(--border-color, #d1d5db); border-radius: 8px;
    font-size: .76rem; text-decoration: none;
    font-family: 'Poppins', sans-serif; transition: all .15s;
    display: inline-flex; align-items: center;
}
.btn-icon:hover { background: #011f4b; color: #fff; border-color: #011f4b; text-decoration: none; }

/* ─────────────────────────────────────────
   EMPTY STATES
───────────────────────────────────────── */
.lda-empty { grid-column: 1/-1; text-align: center; padding: 4rem 1rem; color: var(--text-tertiary, #6b7280); }
.lda-empty i { font-size: 2.2rem; margin-bottom: .8rem; display: block; }

/* ─────────────────────────────────────────
   FLAT SCHEMES TABLE  (NEW — captures "lda flats", "registration last date")
───────────────────────────────────────── */
.lda-flats-section {
    max-width: 1200px; margin: 0 auto;
    padding: 1.5rem 1rem 0;
}
.lda-flats-section h2 {
    font-size: 1.1rem; font-weight: 700;
    color: var(--text-primary, #111827); margin-bottom: .9rem;
}
.lda-flats-section h2 i { color: #008080; margin-right: .4rem; }
.lda-flats-section .intro {
    font-size: .85rem; color: var(--text-secondary, #4b5563);
    line-height: 1.7; margin-bottom: 1rem;
}
.lda-flats-table-wrap { overflow-x: auto; border-radius: 10px; border: 1px solid var(--border-color, #e5e7eb); }
.lda-flats-table {
    width: 100%; border-collapse: collapse; font-size: .82rem;
    background: var(--card-bg, #fff); min-width: 640px;
}
.lda-flats-table thead th {
    background: linear-gradient(135deg, #011f4b, #013a75); color: #fff;
    text-align: left; padding: .7rem .85rem; font-weight: 600; font-size: .78rem;
    letter-spacing: .02em;
}
.lda-flats-table tbody td {
    padding: .7rem .85rem;
    border-top: 1px solid var(--border-color, #e5e7eb);
    color: var(--text-primary, #111827);
    vertical-align: top;
}
.lda-flats-table tbody tr:hover { background: var(--bg-secondary, #f9fafb); }
.lda-flats-table .scheme-name { font-weight: 600; color: #011f4b; }
.lda-flats-table .status-open    { color: #059669; font-weight: 600; }
.lda-flats-table .status-closed  { color: #dc2626; font-weight: 600; }
.lda-flats-table .status-tba     { color: #92400e; font-weight: 600; }
.lda-flats-table .status-done    { color: #1e40af; font-weight: 600; }

/* ─────────────────────────────────────────
   ABOUT LDA SECTION  (below schemes)
───────────────────────────────────────── */
.lda-about-section {
    background: var(--bg-primary, #fff);
    border-top: 1px solid var(--border-color, #e5e7eb);
    padding: 2.5rem 1rem;
    margin-top: 2rem;
}
.lda-about-inner { max-width: 860px; margin: 0 auto; }
.lda-about-inner h2 {
    font-size: 1.15rem; font-weight: 700;
    color: var(--text-primary, #111827); margin-bottom: .9rem;
}
.lda-about-inner p {
    font-size: .87rem; color: var(--text-secondary, #4b5563);
    line-height: 1.8; margin-bottom: .9rem;
}
.about-cta-row { display: flex; flex-wrap: wrap; gap: .75rem; margin-top: 1.25rem; }
.about-btn-primary {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #011f4b; color: #fff;
    font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s;
}
.about-btn-primary:hover { background: #013a75; color: #fff; text-decoration: none; }
.about-btn-wa {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #25d366; color: #fff;
    font-weight: 700; font-size: .85rem;
    padding: .55rem 1.2rem; border-radius: 8px;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s;
}
.about-btn-wa:hover { background: #1ebe5d; color: #fff; text-decoration: none; }

/* ─────────────────────────────────────────
   FAQ SECTION
───────────────────────────────────────── */
.lda-faq { max-width: 860px; margin: 0 auto; padding: 2.5rem 1rem 0; }
.lda-faq h2 {
    font-size: 1.15rem; font-weight: 700;
    color: var(--text-primary, #111827); margin-bottom: 1.2rem;
}
.faq-item {
    border: 1px solid var(--border-color, #e5e7eb); border-radius: 10px;
    margin-bottom: .6rem; background: var(--card-bg, #fff);
    overflow: hidden; transition: box-shadow .15s;
}
.faq-item:hover { box-shadow: 0 2px 12px rgba(1,31,75,.07); }
.faq-q {
    width: 100%; background: none; border: none; text-align: left;
    padding: .9rem 1rem; font-size: .85rem; font-weight: 600;
    color: var(--text-primary, #111827); font-family: 'Poppins', sans-serif;
    cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: .5rem;
}
.faq-q:hover { background: var(--bg-secondary, #f9fafb); }
.faq-q .faq-icon { font-size: .7rem; color: #008080; transition: transform .2s; flex-shrink: 0; }
.faq-q[aria-expanded="true"] .faq-icon { transform: rotate(180deg); }
.faq-q[aria-expanded="true"] { color: #011f4b; }
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
.lda-links-bar {
    max-width: 1080px; margin: 0 auto;
    padding: 2rem 1rem 3rem;
    border-top: 1px solid var(--border-color, #e5e7eb);
}
.lda-links-title {
    font-size: .7rem; font-weight: 700; letter-spacing: 1.6px;
    text-transform: uppercase; color: #008080;
    margin: 0 0 1.1rem; text-align: center;
}
/* A grid of cards rather than one long middot-separated run-on line —
   each guide is now its own tap target with room to breathe. */
.lda-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: .7rem;
}
.lda-link-card {
    display: flex; align-items: center; gap: .6rem;
    padding: .8rem .95rem;
    background: #fff;
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 12px;
    font-size: .82rem; font-weight: 600; line-height: 1.35;
    color: #011f4b; text-decoration: none;
    transition: border-color .2s, box-shadow .2s, transform .2s;
}
.lda-link-card:hover {
    border-color: rgba(0,128,128,.45);
    box-shadow: 0 6px 18px rgba(1,31,75,.08);
    transform: translateY(-2px);
    text-decoration: none; color: #011f4b;
}
.lda-link-card i {
    color: #008080; font-size: .78rem; flex-shrink: 0;
}
.lda-link-card.is-cta {
    background: linear-gradient(135deg, #011f4b, #023372);
    border-color: transparent; color: #fff;
}
.lda-link-card.is-cta:hover { color: #fff; }
.lda-link-card.is-cta i { color: #FF5C00; }

/* ─────────────────────────────────────────
   DARK MODE
───────────────────────────────────────── */
[data-theme="dark"] .lda-tag { background: #374151; color: #d1d5db; border-color: #4b5563; }
[data-theme="dark"] .lda-card { border-color: #374151; background: #1f2937; }
[data-theme="dark"] .prog-bar { background: #374151; }
[data-theme="dark"] .faq-item { border-color: #374151; background: #1f2937; }
[data-theme="dark"] .faq-q { color: #f3f4f6; }
[data-theme="dark"] .faq-q:hover { background: #374151; }
[data-theme="dark"] .btn-icon { border-color: #4b5563; color: #d1d5db; }
[data-theme="dark"] .btn-lda { border-color: #4b5563; color: #9ca3af; }
[data-theme="dark"] .btn-lda:hover { background: #374151; color: #fff; }
[data-theme="dark"] .lda-about-section { background: #111827; border-color: #374151; }
[data-theme="dark"] .lda-about-inner h2 { color: #f9fafb; }
[data-theme="dark"] .lda-about-inner p { color: #d1d5db; }
[data-theme="dark"] .lda-toc { background: #1f2937; border-color: #374151; }
[data-theme="dark"] .lda-toc a { background: #374151; color: #d1d5db; }
[data-theme="dark"] .lda-flats-table { background: #1f2937; }
[data-theme="dark"] .lda-flats-table tbody td { color: #f3f4f6; border-color: #374151; }
[data-theme="dark"] .lda-flats-table tbody tr:hover { background: #374151; }
[data-theme="dark"] .lda-link-card { background: #1f2937; border-color: #374151; color: #e5e7eb; }
[data-theme="dark"] .lda-link-card:hover { border-color: rgba(0,128,128,.6); color: #fff; }
[data-theme="dark"] .lda-link-card.is-cta { background: linear-gradient(135deg, #023372, #005f6b); border-color: transparent; color: #fff; }

/* ─────────────────────────────────────────
   RESPONSIVE
───────────────────────────────────────── */
@media (max-width: 600px) {
    .lda-grid { grid-template-columns: 1fr; }
    .hero-cta-row { flex-direction: column; align-items: flex-start; }
    .lda-card-foot { gap: .35rem; }
    .lda-hero { padding: 2rem 1rem 1.75rem; }
    .lda-hero .hero-sub { font-size: .85rem; }
    .lda-toc { padding: .6rem .75rem; }
    .lda-toc-label { display: none; }
}

/* ─────────────────────────────────────────
   MAP SECTION
───────────────────────────────────────── */
.lda-map-section { padding: 1.25rem 1rem 0; }
.lda-map-wrap {
    max-width: 1200px; margin: 0 auto;
    background: var(--bg-primary, #fff);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 14px; overflow: hidden;
}
.lda-map-header {
    padding: .9rem 1rem .75rem;
    border-bottom: 1px solid var(--border-color, #e5e7eb);
}
.lda-map-header h2 {
    font-size: 1.05rem; font-weight: 700;
    color: var(--text-primary, #111827); margin: 0 0 .45rem;
}
.lda-map-header h2 i { color: #008080; margin-right: .4rem; }
.lda-map-legend { display: flex; flex-wrap: wrap; gap: .75rem; margin-bottom: .3rem; }
.map-legend-item {
    display: flex; align-items: center; gap: .3rem;
    font-size: .75rem; color: var(--text-secondary, #4b5563); font-weight: 500;
}
.map-dot {
    width: 11px; height: 11px; border-radius: 50%;
    display: inline-block; flex-shrink: 0;
    border: 2px solid #fff; box-shadow: 0 1px 4px rgba(0,0,0,.25);
}
.map-dot-active    { background: #059669; }
.map-dot-upcoming  { background: #f59e0b; }
.map-dot-completed { background: #3b82f6; }
.lda-map-sub { font-size: .76rem; color: var(--text-tertiary, #6b7280); margin: 0; }
#lda-map { height: 420px; }
[data-theme="dark"] .lda-map-wrap { background: #1f2937; border-color: #374151; }
[data-theme="dark"] .lda-map-header { border-color: #374151; }
[data-theme="dark"] .lda-map-header h2 { color: #f9fafb; }
[data-theme="dark"] .map-legend-item { color: #d1d5db; }
@media (max-width: 600px) {
    #lda-map { height: 420px; }
    .lda-map-section { padding: 1rem .75rem 0; }
}
</style>
@endpush

@section('content')
<div class="lda-page">

    {{-- ══════════════════════════════════════════════════════════════
         HERO — H1 rewritten: "LDA New Schemes Lucknow 2026 — Plots, Flats, Ballot Dates & Prices"
         ══════════════════════════════════════════════════════════════ --}}
    <section class="lda-hero">
        <div style="max-width:1200px;margin:0 auto;">
            <p style="font-size:.75rem;opacity:.55;margin-bottom:.5rem;">
                <a href="/" style="color:inherit;text-decoration:none;">Home</a> &rsaquo; LDA Schemes
            </p>

            <h1>
                <i class="fas fa-city" style="margin-right:.45rem;" aria-hidden="true"></i>LDA New Schemes Lucknow 2026 — Plots, Flats, Ballot Dates &amp; Prices
            </h1>

            <p class="hero-sub">
                Live directory of all <strong>Lucknow Development Authority</strong> new plot schemes, flat allotments &amp; townships —
                IT City, Wellness City, Anant Nagar, Park View Basant Kunj, Naimish Nagar &amp; more.
                Prices ₹2,045–₹4,522/sqft · ballot dates · units available · updated weekly.
            </p>

            <div class="hero-cta-row">
                <a href="#lda-enquiry" class="hero-btn-primary js-scheme-query"
                   data-message="Hi, I would like a free consultation about LDA new schemes in Lucknow. Please guide me.">
                    <i class="fas fa-calendar-check" aria-hidden="true"></i> Free Consultation
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

    {{-- ══════════════════════════════════════════════════════════════
         TABLE OF CONTENTS  (NEW — for jump-to sitelinks + scannability)
         ══════════════════════════════════════════════════════════════ --}}
    @if(count($schemes) > 0)
    <nav class="lda-toc" aria-label="Jump to scheme">
        <span class="lda-toc-label">Jump to:</span>
        @foreach($schemes as $s)
            @php
                $anchor   = $s['scheme_id'] ?? 'scheme-'.$loop->index;
                $tocClass = 'toc-' . strtolower($s['status'] ?? 'active');
                $label    = $s['short_name'] ?? $s['name'] ?? '';
            @endphp
            <a href="#{{ $anchor }}" class="{{ $tocClass }}">{{ $label }}</a>
        @endforeach
        <a href="#lda-flats-status">LDA Flats Status</a>
        <a href="#lda-faq">FAQs</a>
    </nav>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         LDA SCHEMES MAP
         ══════════════════════════════════════════════════════════════ --}}
    <section class="lda-map-section" id="lda-map-section" aria-label="LDA schemes map">
        <div class="lda-map-wrap">
            <div class="lda-map-header">
                <h2>
                    <i class="fas fa-map-marked-alt" aria-hidden="true"></i>LDA Schemes on Map — Lucknow
                </h2>
                <div class="lda-map-legend">
                    <span class="map-legend-item"><span class="map-dot map-dot-active"></span>Active</span>
                    <span class="map-legend-item"><span class="map-dot map-dot-upcoming"></span>Upcoming</span>
                    <span class="map-legend-item"><span class="map-dot map-dot-completed"></span>Completed</span>
                </div>
                <p class="lda-map-sub">Click a pin to see scheme details, price &amp; apply link. Scroll or pinch to zoom.</p>
            </div>
            <div id="lda-map" role="application" aria-label="Interactive map of LDA schemes in Lucknow"></div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         CONTROLS BAR
         ══════════════════════════════════════════════════════════════ --}}
    <div class="lda-controls">
        <div class="lda-controls-inner">
            <input type="text" id="lda-search" class="lda-search"
                   placeholder="Search schemes, locations…"
                   autocomplete="off" aria-label="Search LDA schemes">
            <span class="lda-count" id="lda-count">{{ count($schemes) }} schemes</span>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         SCHEME CARDS GRID
         ══════════════════════════════════════════════════════════════ --}}
    <div class="lda-grid" id="lda-grid" aria-label="LDA scheme listings">

        @forelse ($schemes as $s)
        @php
            $isAuction    = ($s['allotment_type'] ?? '') === 'E-Auction';
            $featured     = ($s['featured'] ?? false) ? 'featured' : '';
            $statusKey    = strtolower($s['status'] ?? 'active');
            $schemeAnchor = $s['scheme_id'] ?? 'scheme-'.($loop->index + 1);
            $schemeName   = $s['name'] ?? 'this scheme';
        @endphp

        {{-- ItemList anchor + scroll-margin handles sticky controls bar --}}
        <article class="lda-card {{ $featured }} {{ $isAuction ? 'auction' : '' }}"
             id="{{ $schemeAnchor }}"
             data-status="{{ $s['status']??'' }}"
             data-search="{{ strtolower(($s['name'] ?? '') . ' ' . ($s['location'] ?? '') . ' ' . ($s['category'] ?? '')) }}"
             data-price="{{ $s['price_per_sqft'] ?? 0 }}"
             data-progress="{{ $s['progress_pct'] ?? 0 }}"
             data-order="{{ $s['sort_order'] ?? 99 }}">

            {{-- Card header --}}
            <div class="lda-card-header">
                <div class="card-id">{{ $s['scheme_id'] ?? '' }} &bull; {{ $s['category'] ?? '' }}</div>
                <h2 class="card-name">{{ $schemeName }}</h2>
                <div class="card-loc">
                    <i class="fas fa-map-marker-alt" style="font-size:.65rem;" aria-hidden="true"></i>
                    <span>{{ $s['location'] ?? '' }}</span>
                </div>
            </div>

            {{-- Progress bar --}}
            @if(($s['progress_pct'] ?? 0) > 0)
            <div class="lda-progress">
                <div class="prog-label">
                    <span>{{ $s['phase'] ?? '' }}</span>
                    <span>{{ $s['progress_pct'] }}% complete</span>
                </div>
                <div class="prog-bar"
                     role="progressbar"
                     aria-valuenow="{{ $s['progress_pct'] }}"
                     aria-valuemin="0" aria-valuemax="100">
                    <div class="prog-fill" style="width:{{ $s['progress_pct'] }}%"></div>
                </div>
            </div>
            @endif

            {{-- Meta grid --}}
            <div class="lda-meta">
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

            {{-- Highlight tags --}}
            @if(!empty($s['highlights']) && is_array($s['highlights']))
            <div class="lda-tags" aria-label="Scheme highlights">
                @foreach($s['highlights'] as $tag)
                    @if(trim($tag))
                    <span class="lda-tag">{{ trim($tag) }}</span>
                    @endif
                @endforeach
            </div>
            @endif

            {{-- Description --}}
            @if(!empty($s['description']))
            <div class="lda-desc">{{ $s['description'] }}</div>
            @endif

            {{-- Card footer — REORDERED: Read More (primary teal) → WhatsApp → View on LDA (tertiary) --}}
            <div class="lda-card-foot">

                {{-- PRIMARY: Read More (only if blog article exists; otherwise fall back to LDA link as primary) --}}
                @if(!empty($s['read_more']))
                <a href="{{ $s['read_more'] }}"
                   class="btn-read-more"
                   aria-label="Read detailed article about {{ $schemeName }}">
                    <i class="fas fa-book-open" style="font-size:.62rem;" aria-hidden="true"></i>
                    Read Full Guide
                </a>
                @endif

                {{-- SECONDARY: Query — scrolls to the enquiry form at the bottom
                     and pre-fills the message with this scheme's name. --}}
                <a href="#lda-enquiry"
                   class="btn-wa-scheme js-scheme-query"
                   data-scheme="{{ $schemeName }}"
                   aria-label="Send an enquiry about {{ $schemeName }}">
                    <i class="fas fa-comment-dots" aria-hidden="true"></i>
                    Query
                </a>

                {{-- TERTIARY: View on LDA — text-style, low visual weight (no longer primary) --}}
                <a href="{{ $s['official_link'] ?? 'https://ldalucknow.in' }}"
                   target="_blank" rel="noopener noreferrer"
                   class="btn-lda"
                   aria-label="View {{ $schemeName }} on LDA official website">
                    <i class="fas fa-external-link-alt" style="font-size:.6rem;" aria-hidden="true"></i>
                    LDA site
                </a>

                @if(!empty($s['map_link']))
                <a href="{{ $s['map_link'] }}" target="_blank" rel="noopener noreferrer"
                   class="btn-icon" aria-label="View {{ $schemeName }} location on map">
                    <i class="fas fa-map" style="font-size:.72rem;" aria-hidden="true"></i>
                </a>
                @endif

                @if(!empty($s['brochure_link']))
                <a href="{{ $s['brochure_link'] }}" target="_blank" rel="noopener noreferrer"
                   class="btn-icon" aria-label="Download {{ $schemeName }} brochure">
                    <i class="fas fa-file-pdf" style="font-size:.72rem;" aria-hidden="true"></i>
                </a>
                @endif

            </div>

        </article>
        @empty
        <div class="lda-empty">
            <i class="fas fa-folder-open" aria-hidden="true"></i>
            <p>No schemes loaded. Please upload the JSON data file.</p>
        </div>
        @endforelse

        <div class="lda-empty" id="no-results" style="display:none;" aria-live="polite">
            <i class="fas fa-search" aria-hidden="true"></i>
            <p>No schemes match your search.</p>
        </div>
    </div>

    {{-- Disclaimer --}}
    <div style="max-width:1200px;margin:0 auto;padding:.5rem 1rem 1rem;">
        <p style="font-size:.72rem;color:var(--text-tertiary);line-height:1.6;border-top:1px solid var(--border-color);padding-top:.6rem;">
            <i class="fas fa-info-circle" style="margin-right:.3rem;" aria-hidden="true"></i>
            Data sourced from official LDA communications and ldalucknow.in. Prices, availability and dates change — verify directly with LDA before any decision.
            Last refresh: {{ $lastUpdated }}.
        </p>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         LDA FLATS & REGISTRATION STATUS TABLE  (NEW)
         Captures: lda flats (240 impr), lda flats in lucknow (150),
                   lda flat in lucknow (177), lda flat registration (56),
                   lda online registration last date (33),
                   lda flats in lucknow price list (33)
         Combined: ~700+ impressions/quarter at avg position 7-8.5
         ══════════════════════════════════════════════════════════════ --}}
    <section class="lda-flats-section" id="lda-flats-status">
        <h2>
            <i class="fas fa-building" aria-hidden="true"></i>LDA Flats in Lucknow — Registration Status &amp; Last Dates
        </h2>
        <p class="intro">
            Quick view of all <strong>LDA flats in Lucknow</strong> with current registration status, last dates, ballot outcomes and per-square-foot prices.
            For LDA plot schemes, scroll up to the cards directory above. For full eligibility and document checklists, see our <a href="/blog/atal-nagar-yojana-lda" style="color:#011f4b;font-weight:600;">scheme-wise application guides</a>.
        </p>

        <div class="lda-flats-table-wrap">
<table class="lda-flats-table">
    <thead>
        <tr>
            <th>Scheme</th>
            <th>Type</th>
            <th>Rate (per sqft)</th>
            <th>Registration / Status</th>
            <th>Ballot / Draw</th>
            <th>Possession</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>
                <span class="scheme-name">Park View Apartments — Basant Kunj</span><br>
                <small style="color:#6b7280;">Hardoi Road, 3BHK Premium (Phase I + II)</small>
            </td>
            <td>Flats</td>
            <td>₹4,522</td>
            <td><span class="status-closed">Closed (Phase II: 30 June 2026)</span></td>
            <td>Completed (Phase I & II)</td>
            <td>Dec 2031 (Estimated)</td>
        </tr>

        <tr>
            <td>
                <span class="scheme-name">PMAY Basant Kunj (Sector I & N)</span><br>
                <small style="color:#6b7280;">EWS / LIG Housing</small>
            </td>
            <td>Flats (PMAY)</td>
            <td>Subsidized</td>
            <td><span class="status-done">Completed & Allotted</span></td>
            <td>Completed</td>
            <td>Delivered</td>
        </tr>

        <tr>
            <td>
                <span class="scheme-name">Anant Nagar (Phase 4 & 5)</span><br>
                <small style="color:#6b7280;">Mohan Road (Aashish / Akash / Adarsh Khand)</small>
            </td>
            <td>Plots</td>
            <td>₹3,825</td>
            <td><span class="status-closed">Phase 5 Closed (9 Sept 2026)</span></td>
            <td>Phase 4: 12 June 2026<br>Phase 5: Pending</td>
            <td>March 2027 onwards</td>
        </tr>

        <tr>
            <td>
                <span class="scheme-name">IT City Lucknow</span><br>
                <small style="color:#6b7280;">Sultanpur Road Township</small>
            </td>
            <td>Plots / Township</td>
            <td>₹4,180 (Phase 1)</td>
            <td><span class="status-closed">Farmer Phases Ongoing / Sold Out</span></td>
            <td>Multiple draws completed (2026)</td>
            <td>2030-12</td>
        </tr>

        <tr>
            <td>
                <span class="scheme-name">Wellness City</span><br>
                <small style="color:#6b7280;">Sultanpur Road (1,474 Acres)</small>
            </td>
            <td>Mixed Use</td>
            <td>~₹4,200 (Est.)</td>
            <td><span class="status-open" style="color:#10b981; font-weight:bold;">Land Pooling Active</span></td>
            <td>1st draw: 30 June 2026<br>2nd: Aug–Sep 2026</td>
            <td>2029–2030</td>
        </tr>

        <tr>
            <td>
                <span class="scheme-name">Naimish Nagar Yojna</span><br>
                <small style="color:#6b7280;">Sitapur Road / IIM Road (Model Township)</small>
            </td>
            <td>Township</td>
            <td>~₹3,800 (Est.)</td>
            <td><span class="status-tba" style="color:#3b82f6;">Launching 24 Sept 2026</span></td>
            <td>TBA (after launch)</td>
            <td>2028–2029</td>
        </tr>

        <tr>
            <td>
                <span class="scheme-name">Varun Vihar Yojna</span><br>
                <small style="color:#6b7280;">Agra Expressway</small>
            </td>
            <td>Plots</td>
            <td>~₹2,800 (Est.)</td>
            <td><span class="status-tba" style="color:#3b82f6;">Launching 24 Sept 2026</span></td>
            <td>TBA (after launch)</td>
            <td>TBA</td>
        </tr>

        <tr>
            <td>
                <span class="scheme-name">Atal Nagar Awasiya Yojana Phase II</span><br>
                <small style="color:#6b7280;">Devpur Para, West Lucknow (1BHK / 2BHK)</small>
            </td>
            <td>Flats (1/2 BHK)</td>
            <td>₹9.82L – ₹20.00L</td>
            <td><span class="status-closed">Closed (17 May 2026)</span></td>
            <td>Completed (1 July 2026)</td>
            <td>June 2030 (Est.)</td>
        </tr>

        <tr>
            <td>
                <span class="scheme-name">Lake View Apartments — Viraj Khand</span><br>
                <small style="color:#6b7280;">Gomti Nagar, 3BHK + Servant</small>
            </td>
            <td>Flats</td>
            <td>₹4,822</td>
            <td><span class="status-closed">Closed (18 June 2026)</span></td>
            <td>Completed (13 July 2026)</td>
            <td>Jan 2031 (Estimated)</td>
        </tr>

    </tbody>
</table>
        </div>

        <p style="font-size:.78rem; color:#6b7280; margin-top:.7rem; line-height:1.6;">
            <i class="fas fa-info-circle" style="margin-right:.25rem;" aria-hidden="true"></i>
            Status updated: {{ $lastUpdated }}. Always verify the current registration window on
            <a href="https://ldalucknow.in" target="_blank" rel="noopener noreferrer" style="color:#011f4b;font-weight:600;">ldalucknow.in</a>
            before applying. For real-time guidance,
            <a href="#lda-enquiry" class="js-scheme-query" data-message="Hi, I want to know the latest LDA flats registration status in Lucknow." style="color:#008080;font-weight:600;">send us your query</a>.
        </p>
    </section>

    {{-- About LDA Section --}}
    <div class="lda-about-section">
        <div class="lda-about-inner">
            <h2>
                <i class="fas fa-landmark" style="margin-right:.45rem;color:#008080;" aria-hidden="true"></i>About LDA Housing Schemes in Lucknow
            </h2>
            <p>
                The <strong>Lucknow Development Authority (LDA)</strong> is the premier government body planning and developing residential, commercial, and township projects across Lucknow, Uttar Pradesh.
                LDA new schemes 2026 offer government-backed plots, apartments, and integrated townships at regulated prices — making them one of the safest property investments in the city.
            </p>
            <p>
                Whether you are looking for an <strong>affordable PMAY flat</strong>, a plotted scheme on Sultanpur Road, Sitapur Road, Agra Expressway or Mohan Road, or a ready-to-move apartment in Basant Kunj, this page tracks all active and upcoming LDA schemes in one place.
                All pricing, availability, allotment type (lottery vs FCFS), and <strong>ballot dates</strong> are sourced from official LDA communications and updated regularly.
            </p>
            <p>
                For personalised guidance on applying to any LDA new scheme — including eligibility checks, documentation support, and home loan assistance — reach out to DSD Properties for a <strong>free consultation</strong>.
            </p>
            <div class="about-cta-row">
                <a href="#lda-enquiry" class="about-btn-primary js-scheme-query"
                   data-message="Hi, I would like to book a free consultation about LDA schemes in Lucknow — eligibility, documentation and home loan assistance.">
                    <i class="fas fa-calendar-check" aria-hidden="true"></i> Book Free Consultation
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         SCHEME ENQUIRY FORM — target of every card's "Query" button.
         The card click pre-fills the message with the scheme name.
         ══════════════════════════════════════════════════════════════ --}}
    <style>
    /* Two-column enquiry band: pitch on the left, form on the right.
       A single centred column left large empty gutters on desktop. */
    .lda-enq-wrap {
        display: grid;
        grid-template-columns: 1fr 480px;
        gap: 2.5rem;
        align-items: start;
        max-width: 1080px;
        margin: 3rem auto;
        padding: 2rem;
        background: linear-gradient(135deg, #f8fafc 0%, #eef4f7 100%);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        scroll-margin-top: 110px;
    }
    .lda-enq-form { scroll-margin-top: 110px; }
    .lda-enq-eyebrow {
        display: inline-block;
        font-size: .68rem; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase; color: #008080;
        background: rgba(0,128,128,.09);
        border-radius: 999px; padding: .32rem .8rem; margin-bottom: .9rem;
    }
    .lda-enq-h2 {
        font-size: 1.75rem; font-weight: 800; color: #011f4b;
        line-height: 1.25; margin: 0 0 .75rem;
    }
    .lda-enq-lead { font-size: .92rem; color: #475569; line-height: 1.7; margin: 0 0 1.4rem; }
    .lda-enq-list { list-style: none; padding: 0; margin: 0 0 1.5rem; }
    .lda-enq-list li {
        display: flex; gap: .7rem; align-items: flex-start;
        font-size: .86rem; color: #334155; line-height: 1.6; margin-bottom: .8rem;
    }
    .lda-enq-list i { color: #008080; font-size: .8rem; margin-top: .28rem; flex-shrink: 0; }
    .lda-enq-list strong { color: #011f4b; font-weight: 700; }
    .lda-enq-stats {
        display: flex; flex-wrap: wrap; gap: .6rem;
        padding-top: 1.2rem; border-top: 1px solid #dbe3ea;
    }
    .lda-enq-stat {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 10px;
        padding: .55rem .85rem; min-width: 112px;
    }
    .lda-enq-stat b { display: block; font-size: 1.05rem; font-weight: 800; color: #011f4b; line-height: 1.2; }
    .lda-enq-stat span { font-size: .68rem; color: #64748b; text-transform: uppercase; letter-spacing: .6px; }

    @media (max-width: 980px) {
        .lda-enq-wrap {
            grid-template-columns: 1fr;
            gap: 1.75rem;
            padding: 1.5rem;
            margin: 2rem auto;
        }
        .lda-enq-h2 { font-size: 1.4rem; }
    }
    </style>

    <div id="lda-enquiry" class="lda-enq-wrap">

        {{-- LEFT: what LDA schemes are and where we come in --}}
        <div class="lda-enq-copy">
            <span class="lda-enq-eyebrow">Free LDA Advisory</span>

            <h2 class="lda-enq-h2">Confused About Which LDA Scheme to Apply For?</h2>

            <p class="lda-enq-lead">
                The Lucknow Development Authority releases plots and flats across IT City, Wellness City,
                Anant Nagar, Park View, Naimish Nagar and Varun Vihar &mdash; each with its own registration
                window, ballot date, eligibility rules and payment plan. Missing a cut-off date or picking
                the wrong sector can cost you years of waiting.
            </p>

            <ul class="lda-enq-list">
                <li>
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span><strong>Scheme shortlisting</strong> &mdash; we compare rates, location, possession timeline
                    and appreciation potential so you apply where your budget actually works.</span>
                </li>
                <li>
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span><strong>Registration &amp; ballot support</strong> &mdash; document checklist, online form
                    filling, fee payment and reminders before every last date.</span>
                </li>
                <li>
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span><strong>Eligibility &amp; loan guidance</strong> &mdash; PMAY/EWS-LIG criteria, income
                    certificates and home-loan tie-ups on LDA allotments.</span>
                </li>
                <li>
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span><strong>After allotment</strong> &mdash; allotment letter verification, possession,
                    registry and resale valuation whenever you decide to exit.</span>
                </li>
            </ul>

            <div class="lda-enq-stats">
                <div class="lda-enq-stat"><b>{{ $stats['active'] ?? 0 }}</b><span>Active schemes</span></div>
                <div class="lda-enq-stat"><b>{{ $stats['upcoming'] ?? 0 }}</b><span>Upcoming</span></div>
                <div class="lda-enq-stat"><b>24 hrs</b><span>Response time</span></div>
                <div class="lda-enq-stat"><b>&#8377;0</b><span>Advisory fee</span></div>
            </div>
        </div>

        {{-- RIGHT: the enquiry form (pre-filled by the card "Query" buttons) --}}
        <div class="lda-enq-form">
            @include('components.inquiry-form')
        </div>
    </div>

    {{-- FAQ Section — EXPANDED to 10 questions --}}
<div class="lda-faq" id="lda-faq">
    <h2>
        <i class="fas fa-question-circle" style="margin-right:.45rem;color:#008080;" aria-hidden="true"></i>Frequently Asked Questions — LDA New Scheme 2026 Lucknow
    </h2>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a1" onclick="toggleFaq(this)">
            How do I apply for an LDA new scheme in Lucknow 2026?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a1">
            You can apply only through the official LDA portal at <a href="https://ldalucknow.in" target="_blank" rel="noopener noreferrer" style="color:#011f4b;font-weight:600;">ldalucknow.in</a> or <a href="https://registration.ldalucknow.in" target="_blank" rel="noopener noreferrer" style="color:#011f4b;font-weight:600;">registration.ldalucknow.in</a>. Most current schemes (Lake View, Park View, Atal Nagar Phase II, Anant Nagar Phase 5) have closed registration. New registration windows for <strong>Varun Vihar</strong> and <strong>Naimish Nagar</strong> are expected to open on 24 September 2026 after the CM launch. Always check the live status on the official portal. DSD Properties can guide you through eligibility and documentation — <a href="/contact-us" style="color:#011f4b;font-weight:600;">contact us for a free consultation</a>.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a2" onclick="toggleFaq(this)">
            When is the next LDA ballot date in 2026?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a2">
            Confirmed 2026 ballot dates so far: <strong>Park View Apartments</strong> (Phase I & II) — completed, <strong>Lake View Apartments Viraj Khand</strong> — 13 July 2026 (completed), <strong>Atal Nagar Phase II</strong> — 1 July 2026 (completed), <strong>Anant Nagar Phase 4</strong> — 12 June 2026 (completed), <strong>Wellness City</strong> first draw — 30 June 2026 (completed). Anant Nagar Phase 5 lottery is pending. <strong>Varun Vihar</strong> and <strong>Naimish Nagar</strong> ballots will be announced after their launch on 24 September 2026. This page is refreshed weekly with confirmed dates.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a3" onclick="toggleFaq(this)">
            What is FCFS allotment in LDA?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a3">
            <strong>FCFS (First Come First Serve)</strong> is an LDA allotment method where units are allotted in the exact order applications are received until all units are sold. Unlike lottery schemes where every applicant has an equal chance, in FCFS speed matters — applying within the first hours of opening usually secures allotment. Most current LDA schemes (plots and premium flats) use the transparent computerised lottery system. You can <a href="#lda-enquiry" class="js-scheme-query" data-message="Hi, please alert me about upcoming LDA FCFS schemes in Lucknow." style="color:#008080;font-weight:600;">Send us a query</a> to get alerts on any future FCFS openings.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a4" onclick="toggleFaq(this)">
            What is the last date for LDA online registration in Lucknow?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a4">
            Last dates vary per scheme and are listed in the <a href="#lda-flats-status" style="color:#011f4b;font-weight:600;">LDA Flats Registration Status table</a> above. Key closures: Lake View Apartments (18 June 2026), Atal Nagar Phase II (17 May 2026), Park View Phase II (30 June 2026), Anant Nagar Phase 5 (9 September 2026). Registration for <strong>Varun Vihar</strong> and <strong>Naimish Nagar</strong> is expected to open on 24 September 2026. Always verify the latest cutoff on <a href="https://ldalucknow.in" target="_blank" rel="noopener noreferrer" style="color:#011f4b;font-weight:600;">ldalucknow.in</a> or <a href="#lda-enquiry" class="js-scheme-query" data-message="Hi, I want the latest registration cutoff for an LDA scheme." style="color:#011f4b;font-weight:600;">send us a query</a>.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a5" onclick="toggleFaq(this)">
            What is the LDA lottery ballot process?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a5">
            LDA conducts a computerised lottery (ballot) for schemes where demand exceeds supply. All eligible applicants enter the draw and winners are selected randomly in the presence of applicants (often live-streamed). Successful applicants receive a digitally signed allotment letter downloadable from ldalucknow.in. Unsuccessful applicants get a full refund of the registration amount. Ballot dates and results are published on the official LDA website.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a6" onclick="toggleFaq(this)">
            What is the difference between FCFS and lottery allotment in LDA?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a6">
            In <strong>FCFS (First Come First Serve)</strong>, units are allotted in order of application receipt until sold out — speed matters. In <strong>lottery allotment</strong>, all eligible applicants enter a computerised draw and winners are selected randomly, regardless of application timing. Almost all current LDA residential schemes (Lake View, Park View, Anant Nagar, Atal Nagar, Wellness City, IT City, upcoming Varun Vihar & Naimish Nagar) use the lottery system for transparency.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a7" onclick="toggleFaq(this)">
            What are the latest LDA flat & plot prices in Lucknow 2026?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a7">
            LDA flat rates currently range from <strong>₹2,045/sqft</strong> (PMAY Basant Kunj — EWS/LIG, delivered) to <strong>₹4,822/sqft</strong> (Lake View Apartments Viraj Khand — premium 3BHK + Servant) and <strong>₹4,522/sqft</strong> (Park View Apartments). Plot rates: IT City ~₹4,180/sqft, Anant Nagar ~₹3,825/sqft, Wellness City ~₹4,200/sqft (est.), Naimish Nagar ~₹3,800/sqft (est.), Varun Vihar ~₹2,800/sqft (est.). See the <a href="#lda-flats-status" style="color:#011f4b;font-weight:600;">price comparison table</a> above for the full list.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a8" onclick="toggleFaq(this)">
            Are home loans available on LDA scheme plots and flats?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a8">
            Yes. Most nationalised and major private banks provide home loans on LDA properties, as LDA is a UP government authority. You will need your allotment letter, payment receipts, PAN, Aadhaar, and address proof. PMAY beneficiaries under Basant Kunj can also avail the CLSS interest subsidy. <a href="/contact-us" style="color:#011f4b;font-weight:600;">Contact us</a> for documentation support.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a9" onclick="toggleFaq(this)">
            What documents are required for LDA scheme allotment?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a9">
            Typically: Aadhaar card, PAN card, passport-size photographs, income certificate (for PMAY EWS/LIG), bank details for the application fee, and address proof. Requirements vary by scheme — always verify the latest checklist on <a href="https://ldalucknow.in" target="_blank" rel="noopener noreferrer" style="color:#011f4b;font-weight:600;">ldalucknow.in</a>.
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-q" aria-expanded="false" aria-controls="faq-a10" onclick="toggleFaq(this)">
            Which is the most affordable LDA housing scheme in Lucknow?
            <i class="fas fa-chevron-down faq-icon" aria-hidden="true"></i>
        </button>
        <div class="faq-a" id="faq-a10">
            <strong>PMAY Basant Kunj</strong> remains the most affordable at ₹2,045/sqft for EWS and LIG flats (already delivered). Among ongoing/upcoming plotted schemes, <strong>Varun Vihar Yojna</strong> on Agra Expressway is expected to be the most affordable (~₹2,800/sqft), followed by <strong>Naimish Nagar Yojna</strong> (~₹3,800/sqft). Both are scheduled for launch on 24 September 2026.
        </div>
    </div>

</div>

    {{-- Internal Links --}}
    <div class="lda-links-bar">

        {{-- Scheme guides are driven off the same JSON as the cards above, so a
             scheme added to the directory shows up here without a second edit. --}}
        <p class="lda-links-title">Read Our Detailed Scheme Guides</p>
        <div class="lda-links-grid">
            @foreach ($schemes as $s)
                @if (!empty($s['read_more']))
                <a href="{{ $s['read_more'] }}" class="lda-link-card">
                    <i class="fas fa-map-marked-alt" aria-hidden="true"></i>
                    {{ $s['name'] }}
                </a>
                @endif
            @endforeach
        </div>

        <p class="lda-links-title" style="margin-top:1.8rem;">More LDA &amp; UPAVP Schemes</p>
        <div class="lda-links-grid">
            <a href="/blog/lda-narmada-apartment-gomti-nagar-extension-lucknow" class="lda-link-card">
                <i class="fas fa-building" aria-hidden="true"></i> LDA Narmada Apartment Guide
            </a>
            <a href="/blog/lda-aishbagh-square-mill-road-lucknow" class="lda-link-card">
                <i class="fas fa-building" aria-hidden="true"></i> LDA Aishbagh Square Guide
            </a>
            <a href="/blog/lda-sardar-vallabhbhai-patel-housing-scheme-lucknow" class="lda-link-card">
                <i class="fas fa-building" aria-hidden="true"></i> Sardar Vallabhbhai Patel Housing
            </a>
            <a href="/blog/saumitra-vihar-yojana-lucknow-2026" class="lda-link-card">
                <i class="fas fa-map-marked-alt" aria-hidden="true"></i> Saumitra Vihar Yojna (UPAVP)
            </a>
            <a href="/blog/vrindavan-yojna-lucknow-investment-guide-2026" class="lda-link-card">
                <i class="fas fa-map-marked-alt" aria-hidden="true"></i> Vrindavan Yojna Guide
            </a>
            <a href="/blog/ai-city-lucknow-vrindavan-yojana-2026" class="lda-link-card">
                <i class="fas fa-map-marked-alt" aria-hidden="true"></i> AI City, Vrindavan Sector 15
            </a>
        </div>

        <p class="lda-links-title" style="margin-top:1.8rem;">Location &amp; Investment Guides</p>
        <div class="lda-links-grid">
            <a href="/blog/rise-of-sultanpur-road-lucknow-real-estate-hotspot" class="lda-link-card">
                <i class="fas fa-chart-line" aria-hidden="true"></i> Sultanpur Road Real Estate
            </a>
            <a href="/blog/plots-sultanpur-road-lucknow-2026" class="lda-link-card">
                <i class="fas fa-chart-line" aria-hidden="true"></i> Plots on Sultanpur Road 2026
            </a>
            <a href="/blog/gomti-nagar-extension-lucknow-guide-2026" class="lda-link-card">
                <i class="fas fa-chart-line" aria-hidden="true"></i> Gomti Nagar Extension
            </a>
            <a href="/blog/lucknow-investment-hotspots-2026" class="lda-link-card">
                <i class="fas fa-chart-line" aria-hidden="true"></i> Lucknow Investment Hotspots
            </a>
            <a href="/blog/lda-plot-vs-builder-flat-lucknow-2026" class="lda-link-card">
                <i class="fas fa-balance-scale" aria-hidden="true"></i> LDA Plot vs Builder Flat
            </a>
            <a href="/blog/lda-plot-lottery-winner-guide-lucknow" class="lda-link-card">
                <i class="fas fa-trophy" aria-hidden="true"></i> Won an LDA Plot? Next Steps
            </a>
            <a href="/blog/nri-buying-lda-plots-lucknow-2026" class="lda-link-card">
                <i class="fas fa-globe-asia" aria-hidden="true"></i> NRI Guide to LDA Plots
            </a>
            <a href="/services/property-advisory-lucknow" class="lda-link-card is-cta">
                <i class="fas fa-headset" aria-hidden="true"></i> Free Property Advisory
            </a>
        </div>
    </div>


</div>

<script>
/* Scheme "Query" buttons and the consultation CTAs → scroll to the enquiry form
   (above the FAQs) and pre-fill the message textarea. A button either carries a
   ready-made data-message, or a data-scheme we build the scheme wording from.
   Delegated so it also covers cards rendered later by the filter script below. */
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.js-scheme-query');
    if (!btn) return;

    const wrap = document.getElementById('lda-enquiry');
    const box  = wrap && wrap.querySelector('textarea[name="message"]');
    if (!wrap || !box) return;   // fall through to the plain #anchor jump

    e.preventDefault();
    box.value = btn.dataset.message
        || 'Hi, I have a query about ' + (btn.dataset.scheme || 'an LDA scheme')
           + ' (LDA scheme, Lucknow). Please guide me.';

    // On mobile the pitch column stacks above the form, so scroll straight to
    // the form itself — otherwise the user lands on copy and has to scroll on.
    const target = window.innerWidth < 980
        ? (wrap.querySelector('.lda-enq-form') || wrap)
        : wrap;
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });

    // Focus the name field once scrolling settles, so the user can start typing.
    setTimeout(function () {
        const name = wrap.querySelector('input[name="full_name"]');
        if (name) name.focus({ preventScroll: true });
    }, 600);
});

(function () {
    const cards = Array.from(document.querySelectorAll('#lda-grid .lda-card'));
    const noRes = document.getElementById('no-results');
    const count = document.getElementById('lda-count');
    let query = '';

    function render() {
        let vis = 0;
        cards.forEach(c => {
            const ok = !query || c.dataset.search.includes(query);
            c.style.display = ok ? '' : 'none';
            if (ok) vis++;
        });
        count.textContent = vis + (vis === 1 ? ' scheme' : ' schemes');
        noRes.style.display = vis === 0 ? 'block' : 'none';
    }

    document.getElementById('lda-search').addEventListener('input', function () {
        query = this.value.toLowerCase().trim();
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof L === 'undefined' || !document.getElementById('lda-map')) return;

    (function () {
    const schemes = @json($schemes);
    const STATUS_COLOR = { 'Active': '#059669', 'Upcoming': '#f59e0b', 'Completed': '#3b82f6' };

    const map = L.map('lda-map', { scrollWheelZoom: false })
                 .setView([26.8467, 80.9462], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors',
        maxZoom: 18
    }).addTo(map);

    schemes.forEach(function (s) {
        if (!s.lat || !s.lng) return;

        const color = STATUS_COLOR[s.status] || '#6b7280';

        const icon = L.divIcon({
            className: '',
            html: '<div style="width:16px;height:16px;border-radius:50%;background:' + color + ';border:2.5px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.38);cursor:pointer;"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8],
            popupAnchor: [0, -10]
        });

        const priceHtml = s.price_per_sqft
            ? '<span style="font-size:.74rem;color:#374151;margin-left:.4rem;">&#8377;' + Number(s.price_per_sqft).toLocaleString('en-IN') + '/sqft</span>'
            : '';
        const readBtn  = s.read_more
            ? '<a href="' + s.read_more + '" style="font-size:.72rem;padding:.28rem .65rem;background:#008080;color:#fff;border-radius:6px;text-decoration:none;font-weight:600;white-space:nowrap;">Read Guide</a>'
            : '';
        const anchor   = s.scheme_id
            ? '<a href="#' + s.scheme_id + '" style="font-size:.72rem;padding:.28rem .65rem;background:#f3f4f6;color:#011f4b;border-radius:6px;text-decoration:none;font-weight:600;white-space:nowrap;">View Card &#8595;</a>'
            : '';

        const popup = '<div style="font-family:\'Poppins\',sans-serif;min-width:210px;max-width:255px;">'
            + '<div style="font-weight:700;font-size:.88rem;color:#011f4b;line-height:1.35;margin-bottom:.25rem;">' + s.name + '</div>'
            + '<div style="font-size:.73rem;color:#6b7280;margin-bottom:.38rem;">&#128205; ' + s.location + '</div>'
            + '<div style="display:flex;align-items:center;flex-wrap:wrap;gap:.3rem;margin-bottom:.5rem;">'
            +   '<span style="background:' + color + '22;color:' + color + ';padding:.15rem .55rem;border-radius:50px;font-weight:700;font-size:.68rem;text-transform:uppercase;letter-spacing:.03em;">' + s.status + '</span>'
            +   priceHtml
            + '</div>'
            + '<div style="display:flex;gap:.4rem;flex-wrap:wrap;">'
            +   readBtn
            +   '<a href="#lda-enquiry" class="js-scheme-query" data-scheme="' + s.name.replace(/"/g, '&quot;') + '" style="font-size:.72rem;padding:.28rem .65rem;background:#FF5C00;color:#fff;border-radius:6px;text-decoration:none;font-weight:600;white-space:nowrap;">Query</a>'
            +   anchor
            + '</div>'
            + '</div>';

        L.marker([s.lat, s.lng], { icon })
          .addTo(map)
          .bindPopup(popup, { maxWidth: 270, closeButton: true });
    });
    })();
});
</script>

{{-- Mobile sticky bar, same look as the blog pages' CTA bar, pointing to the LDA plot calculator --}}
<style>
.mob-cta-bar{display:none;position:fixed;bottom:0;left:0;right:0;z-index:9999;padding:10px 14px calc(10px + env(safe-area-inset-bottom,0px));background:#fff;border-top:1px solid #e5e7eb;box-shadow:0 -4px 18px rgba(0,0,0,.12);gap:10px}
@media(max-width:1023px){.mob-cta-bar{display:flex}body{padding-bottom:72px}}
.mob-cta-bar a{flex:1;display:flex;align-items:center;justify-content:center;gap:8px;padding:13px 10px;border-radius:10px;font-family:'Poppins',sans-serif;font-weight:700;font-size:.88rem;text-decoration:none;letter-spacing:.1px;transition:opacity .15s}
.mob-cta-bar a:hover{opacity:.88;text-decoration:none}
.mob-cta-calc{background:linear-gradient(135deg,#FF5C00,#ff8840);color:#fff !important}
</style>
<div class="mob-cta-bar">
    <a href="{{ url('/lda-plot-calculator') }}" class="mob-cta-calc" data-cta-kind="calculator">
        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M8 6h8M8 11h.01M12 11h.01M16 11h.01M8 15h.01M12 15h.01M16 15h.01M8 19h8"/></svg>
        Check Your LDA Plot Price →
    </a>
</div>
@endsection