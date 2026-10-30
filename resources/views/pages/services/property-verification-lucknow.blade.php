@extends('layouts.user-app')

{{-- ═══════════════════════════════════════════════════════════════
     PROPERTY VERIFICATION SERVICE LUCKNOW
     Conversion page for the paid verification. Kept short on purpose:
     hero → sample report → what we check → steps → fees → FAQ.
     The fee appears only in the Fees section and the cost FAQ, and the
     WhatsApp messages carry no price — the fee is confirmed in the chat.
     ═══════════════════════════════════════════════════════════════ --}}

@php
    $pvWa = 'https://wa.me/918595002933?text=';
    $pvSample = asset('downloads/DSD-Property-Verification-Sample-Report-Lucknow.pdf');

    // One list drives both the visible FAQ and the FAQPage schema, so they never drift apart.
    $pvFaqs = [
        ['How much does property verification cost in Lucknow?',
         'A residential plot or flat costs ₹5,000, a commercial property ₹7,000, and the premium package with a detailed site inspection ₹10,000. The fee is fixed and confirmed on WhatsApp before you pay. There are no per-document charges.'],
        ['What exactly do you check?',
         'Six checks on every property: Form 41 (comparative khasra), Form 45 (chakbandi khatauni), the encumbrance certificate and registry index on IGRSUP, court cases in revenue, civil and consolidation courts, a site inspection (muayna), and LDA approval with Master Plan land use. Extra checks such as a 30-year registry chain or Zila Panchayat map approval are available on request.'],
        ['How long does it take?',
         'The report is ready within 48 hours of receiving the property details. The premium package with a detailed site inspection takes 3–5 days.'],
        ['What do I need to share to start?',
         'The property address or khasra/gata number and the seller\'s name are enough to start. If you have papers — registry, khatauni, allotment letter or a map — send them on WhatsApp as well.'],
        ['What happens if you find a problem?',
         'The report shows exactly what was found and where, with the supporting record. You can ask the seller to fix it, renegotiate, or walk away. If the problem is a live dispute, you will need a property lawyer — the report gives them a clear starting point.'],
        ['Do I need a lawyer instead?',
         'Not for checking a property before you buy. Verification tells you whether the records are clean. A lawyer is needed when there is already a dispute or a case to fight.'],
        ['Can NRIs use this service?',
         'Yes. Send the details on WhatsApp from anywhere. We do the checks in Lucknow and send the PDF report. The premium package adds photos and a video of the site, which helps when you cannot visit.'],
        ['Can I check a property online myself?',
         'Partly. You can search registries on <a href="/blog/igrsup-lucknow-property-search-tutorial-hindi">IGRSUP</a>, revenue cases on vaad.up.gov.in, and LDA status on the LDA website. What online portals cannot show is the ground position, consolidation records and cases filed under different names — that is where most problems hide.'],
    ];
@endphp

@section('title', 'Property Verification in Lucknow — ₹5,000, 48-Hour Report | DSD')

@section('meta_description', 'Buying property in Lucknow? We check khasra, khatauni, registry, court cases, site and LDA approval at source. Fixed fee, PDF report in 48 hours.')

@section('meta_keywords', 'property verification service lucknow, property verifier lucknow, property verification cost lucknow, lda plot verification service, property document check service lucknow, plot verification lucknow, registry verification lucknow, encumbrance certificate verification lucknow, property ownership verification lucknow, property litigation search lucknow, property verification charges lucknow, property verification report lucknow')

@section('canonical', 'https://dsdproperties.in/services/property-verification-lucknow')

@push('head')

<meta name="twitter:card" content="summary_large_image">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "RealEstateAgent",
  "@id": "https://dsdproperties.in/#organization",
  "name": "DSD Properties",
  "url": "https://dsdproperties.in",
  "telephone": "+91-8595002933",
  "email": "dheer@dsdproperties.in",
  "image": "https://dsdproperties.in/images/logo.webp",
  "logo": "https://dsdproperties.in/images/logo.webp",
  "priceRange": "₹₹",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "226025",
    "addressCountry": "IN"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": 26.7807, "longitude": 80.9097 },
  "openingHoursSpecification": [{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
    "opens": "09:00", "closes": "19:00"
  }],
  "areaServed": { "@type": "City", "name": "Lucknow" },
  "sameAs": ["https://wa.me/918595002933"]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Property Verification Service",
  "name": "Property Verification Service in Lucknow",
  "description": "Independent property verification in Lucknow: Form 41 and Form 45, encumbrance and registry index, court cases, site inspection, and LDA approval with Master Plan land use. PDF report in 48 hours.",
  "provider": { "@id": "https://dsdproperties.in/#organization" },
  "areaServed": { "@type": "City", "name": "Lucknow", "containedInPlace": { "@type": "State", "name": "Uttar Pradesh" } },
  "offers": [
    { "@type": "Offer", "name": "Residential Plot / Flat Verification", "price": "5000", "priceCurrency": "INR", "description": "Six core checks with a PDF report in 48 hours." },
    { "@type": "Offer", "name": "Commercial Property Verification", "price": "7000", "priceCurrency": "INR" },
    { "@type": "Offer", "name": "Premium Verification with Site Inspection", "price": "10000", "priceCurrency": "INR" }
  ]
}
</script>

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(fn ($f) => [
        '@type' => 'Question',
        'name' => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f[1])],
    ], $pvFaqs),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://dsdproperties.in" },
    { "@type": "ListItem", "position": 2, "name": "Services", "item": "https://dsdproperties.in/services" },
    { "@type": "ListItem", "position": 3, "name": "Property Verification Service Lucknow", "item": "https://dsdproperties.in/services/property-verification-lucknow" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Property Verification Service Lucknow",
  "url": "https://dsdproperties.in/services/property-verification-lucknow",
  "description": "Independent property verification in Lucknow. Land records, registry, court cases, site and LDA approval checked at source. PDF report in 48 hours.",
  "speakable": {
    "@type": "SpeakableSpecification",
    "cssSelector": [".pv-hero__sub", ".pv-ssub", ".pv-step p", ".pv-faq-a"]
  },
  "about": { "@type": "Service", "name": "Property Verification Service Lucknow", "provider": { "@id": "https://dsdproperties.in/#organization" } }
}
</script>

@endpush

@section('content')

<style>
:root {
    --pv-navy:   #011f4b;
    --pv-teal:   #008080;
    --pv-orange: #FF5C00;
    --pv-bg:     var(--bg-primary,  #ffffff);
    --pv-bg2:    var(--bg-secondary, #f3f4f6);
    --pv-card:   var(--card-bg,     #ffffff);
    --pv-border: var(--border-color,#e5e7eb);
    --pv-t1:     var(--text-primary, #111827);
    --pv-t2:     var(--text-secondary,#4b5563);
    --pv-t3:     var(--text-tertiary, #9ca3af);
}

.pv-wrap { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
.pv-container { max-width: 1060px; margin: 0 auto; padding: 0 20px; }
.pv-section { padding: 64px 0; }

.pv-slabel { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--pv-teal); text-align: center; margin-bottom: 8px; display: block; }
.pv-stitle { font-size: clamp(1.45rem, 2.8vw, 2rem); font-weight: 800; color: var(--pv-t1); text-align: center; line-height: 1.2; margin-bottom: 10px; }
.pv-ssub   { font-size: .95rem; color: var(--pv-t2); text-align: center; max-width: 640px; margin: 0 auto 36px; line-height: 1.7; }

.pv-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; border-radius: 10px; text-decoration: none; cursor: pointer; transition: background .2s, transform .2s; border: none; padding: 13px 24px; font-size: .92rem; }
.pv-btn:hover { transform: translateY(-1px); text-decoration: none; }
.pv-btn--primary { background: var(--pv-orange); color: #fff; }
.pv-btn--primary:hover { background: #e65300; color: #fff; }
.pv-btn--ghost { background: rgba(255,255,255,.1); color: #fff; border: 1px solid rgba(255,255,255,.3); }
.pv-btn--ghost:hover { background: rgba(255,255,255,.18); color: #fff; }
.pv-btn--outline { background: transparent; color: var(--pv-navy); border: 1.5px solid var(--pv-navy); }
.pv-btn--outline:hover { background: var(--pv-navy); color: #fff; }
.pv-btn--whatsapp { background: #25D366; color: #fff; }
.pv-btn--whatsapp:hover { background: #1ebe5d; color: #fff; }

/* Hero */
.pv-hero { background: linear-gradient(135deg, #011f4b 0%, #013870 55%, #005f6b 100%); padding: 28px 0 56px; }
.pv-crumbs { display: flex; gap: 8px; list-style: none; margin: 0 0 28px; padding: 0; font-size: 12px; color: rgba(255,255,255,.6); flex-wrap: wrap; }
.pv-crumbs a { color: rgba(255,255,255,.6); text-decoration: none; }
.pv-crumbs li:last-child { color: #fff; }
.pv-hero__body { display: grid; grid-template-columns: 1.3fr 1fr; gap: 48px; align-items: center; }
.pv-hero__h1 { font-size: clamp(1.8rem, 3.6vw, 2.6rem); font-weight: 800; color: #fff; line-height: 1.18; margin: 0 0 16px; }
.pv-hero__sub { font-size: 1rem; color: rgba(255,255,255,.82); line-height: 1.75; margin: 0 0 24px; max-width: 560px; }
.pv-hero__cta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 22px; }
.pv-hero__pills { display: flex; flex-wrap: wrap; gap: 8px 18px; padding: 0; margin: 0; list-style: none; }
.pv-hero__pills li { font-size: .82rem; color: rgba(255,255,255,.78); }
.pv-hero__pills li::before { content: "✓ "; color: #4ade80; font-weight: 700; }
.pv-hero__sample { display: block; text-decoration: none; text-align: center; }
.pv-hero__sample img { width: 100%; max-width: 300px; height: auto; aspect-ratio: 639 / 905; border-radius: 10px; box-shadow: 0 20px 50px rgba(0,0,0,.35); transform: rotate(2deg); transition: transform .25s; }
.pv-hero__sample:hover img { transform: rotate(0); }
.pv-hero__sample span { display: block; margin-top: 16px; font-size: .85rem; font-weight: 600; color: #fff; }
@media (max-width: 860px) {
    .pv-hero__body { grid-template-columns: 1fr; gap: 28px; }
    .pv-hero__sample img { max-width: 180px; }
}
@media (max-width: 480px) { .pv-hero__cta .pv-btn { width: 100%; } }

/* Sample report */
.pv-sample__pages { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; max-width: 820px; margin: 0 auto; }
.pv-sample__page { display: block; text-decoration: none; color: inherit; }
.pv-sample__page img { width: 100%; height: auto; aspect-ratio: 639 / 905; border-radius: 8px; border: 1px solid var(--pv-border); box-shadow: 0 8px 22px rgba(1,31,75,.1); }
.pv-sample__page span { display: block; text-align: center; font-size: .82rem; font-weight: 600; color: var(--pv-t2); margin-top: 8px; }
.pv-sample__btns { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 26px; }
.pv-sample__note { text-align: center; font-size: .8rem; color: var(--pv-t3); margin: 12px 0 0; }
@media (max-width: 640px) {
    .pv-sample__pages { gap: 8px; }
    .pv-sample__page span { font-size: .7rem; }
    .pv-sample__btns .pv-btn { width: 100%; }
}

/* What we check */
.pv-check-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
@media (max-width: 860px) { .pv-check-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 560px) { .pv-check-grid { grid-template-columns: 1fr; } }
.pv-check { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 12px; padding: 20px; }
.pv-check__num { display: inline-flex; width: 28px; height: 28px; border-radius: 8px; background: var(--pv-teal); color: #fff; font-size: .82rem; font-weight: 700; align-items: center; justify-content: center; margin-bottom: 10px; }
.pv-check h3 { font-size: .98rem; font-weight: 700; color: var(--pv-t1); margin: 0 0 6px; }
.pv-check p { font-size: .86rem; color: var(--pv-t2); line-height: 1.65; margin: 0; }
.pv-extra { max-width: 820px; margin: 28px auto 0; text-align: center; }
.pv-extra p { font-size: .88rem; color: var(--pv-t2); margin: 0 0 10px; }
.pv-extra ul { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; list-style: none; padding: 0; margin: 0; }
.pv-extra li { font-size: .8rem; background: var(--pv-bg2); color: var(--pv-t1); border: 1px solid var(--pv-border); border-radius: 99px; padding: 5px 12px; }

/* Steps */
.pv-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
@media (max-width: 860px) { .pv-steps { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 560px) { .pv-steps { grid-template-columns: 1fr; } }
.pv-step { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 12px; padding: 20px; }
.pv-step__num { width: 36px; height: 36px; border-radius: 50%; background: var(--pv-navy); color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
.pv-step h3 { font-size: .95rem; font-weight: 700; color: var(--pv-t1); margin: 0 0 6px; }
.pv-step p  { font-size: .85rem; color: var(--pv-t2); line-height: 1.6; margin: 0; }
.pv-center { text-align: center; margin-top: 28px; }

/* Fees */
.pv-pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; align-items: start; }
@media (max-width: 820px) { .pv-pricing-grid { grid-template-columns: 1fr; max-width: 420px; margin: 0 auto; } }
.pv-price-card { background: var(--pv-card); border: 1.5px solid var(--pv-border); border-radius: 14px; padding: 26px 22px; position: relative; }
.pv-price-card--featured { border-color: var(--pv-orange); box-shadow: 0 10px 30px rgba(255,92,0,.12); }
.pv-price-badge { position: absolute; top: -12px; left: 22px; background: var(--pv-orange); color: #fff; padding: 3px 12px; border-radius: 99px; font-weight: 700; font-size: .72rem; }
.pv-price-name { font-size: 1.05rem; font-weight: 700; color: var(--pv-t1); margin: 0; }
.pv-price-desc { font-size: .8rem; color: var(--pv-t3); margin: 2px 0 12px; }
.pv-price-amount { font-size: 2rem; font-weight: 800; color: var(--pv-navy); margin: 0 0 14px; }
.pv-price-list { list-style: none; padding: 0; margin: 0 0 20px; }
.pv-price-list li { padding: 6px 0; font-size: .85rem; color: var(--pv-t2); }
.pv-price-list li::before { content: "✓  "; color: var(--pv-teal); font-weight: 700; }
.pv-price-card .pv-btn { width: 100%; }

/* Problems */
.pv-risk-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; max-width: 880px; margin: 0 auto; }
@media (max-width: 640px) { .pv-risk-grid { grid-template-columns: 1fr; } }
.pv-risk { background: var(--pv-card); border: 1px solid var(--pv-border); border-left: 4px solid #dc2626; border-radius: 10px; padding: 18px 20px; }
.pv-risk h3 { font-size: .95rem; font-weight: 700; color: var(--pv-t1); margin: 0 0 5px; }
.pv-risk p { font-size: .85rem; color: var(--pv-t2); line-height: 1.6; margin: 0; }

/* FAQ */
.pv-faqs { max-width: 780px; margin: 0 auto; display: flex; flex-direction: column; gap: 10px; }
.pv-faq-item { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 10px; overflow: hidden; }
.pv-faq-q { width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 15px 18px; background: none; border: none; font-family: 'Poppins', sans-serif; font-size: .92rem; font-weight: 600; color: var(--pv-t1); cursor: pointer; text-align: left; gap: 12px; }
.pv-faq-q i { color: var(--pv-teal); flex-shrink: 0; transition: transform .3s; font-size: .78rem; }
.pv-faq-q.open i { transform: rotate(180deg); }
.pv-faq-a { padding: 0 18px; max-height: 0; overflow: hidden; font-size: .88rem; color: var(--pv-t2); line-height: 1.75; transition: max-height .3s ease, padding .3s ease; }
.pv-faq-a.open { max-height: 600px; padding: 0 18px 16px; }
.pv-faq-a a { color: inherit; text-decoration: underline; }
.pv-guides { max-width: 780px; margin: 28px auto 0; font-size: .86rem; color: var(--pv-t2); line-height: 1.9; text-align: center; }
.pv-guides a { color: var(--pv-teal); font-weight: 600; text-decoration: none; white-space: nowrap; }
.pv-guides a:hover { text-decoration: underline; }

/* Final CTA */
.pv-cta { background: var(--pv-navy); padding: 56px 0; text-align: center; }
.pv-cta h2 { font-size: clamp(1.4rem, 3vw, 1.9rem); font-weight: 800; color: #fff; margin: 0 0 10px; }
.pv-cta p  { font-size: .95rem; color: rgba(255,255,255,.8); max-width: 560px; margin: 0 auto 24px; line-height: 1.7; }
.pv-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

.pv-mobile-cta { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: var(--pv-card); border-top: 1px solid var(--pv-border); padding: 10px 14px; z-index: 90; box-shadow: 0 -4px 16px rgba(0,0,0,.1); gap: 8px; }
.pv-mobile-cta.show { display: flex; }
.pv-mobile-cta a { flex: 1; text-align: center; padding: 11px 8px; border-radius: 9px; font-weight: 700; font-size: .85rem; text-decoration: none; }
.pv-mobile-cta a.whatsapp { background: #25D366; color: #fff; }
.pv-mobile-cta a.sample { background: var(--pv-bg2); color: var(--pv-navy); border: 1px solid var(--pv-border); }

@media (max-width: 860px) { .pv-section { padding: 48px 0; } }
</style>

@php
    $waIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>';
    $waVerify = $pvWa . rawurlencode('Hi, I want to get a property verified.');
@endphp

<div class="pv-wrap">

{{-- ═══════════ HERO ═══════════ --}}
<section class="pv-hero">
    <div class="pv-container">
        <nav aria-label="Breadcrumb">
            <ol class="pv-crumbs">
                <li><a href="/">Home</a></li>
                <li>›</li>
                <li><a href="/#services">Services</a></li>
                <li>›</li>
                <li>Property Verification</li>
            </ol>
        </nav>

        <div class="pv-hero__body">
            <div>
                <h1 class="pv-hero__h1">Property Verification in Lucknow</h1>
                <p class="pv-hero__sub">
                    Buying a plot, flat or house? Before you pay token money, we check the land records, registry, court cases, the site and LDA approval — and give you a clear written report in <strong style="color:#fff;">48 hours</strong>.
                </p>

                <div class="pv-hero__cta">
                    <a href="{{ $waVerify }}" class="pv-btn pv-btn--whatsapp">{!! $waIcon !!} Check My Property on WhatsApp</a>
                    <a href="#sample-report" class="pv-btn pv-btn--ghost">See Sample Report ↓</a>
                </div>

                <ul class="pv-hero__pills">
                    <li>Report in 48 hours</li>
                    <li>Independent — no seller ties</li>
                    <li>NRIs welcome</li>
                </ul>
            </div>

            <a href="#sample-report" class="pv-hero__sample">
                <img src="{{ asset('images/verification/sample-report-cover.webp') }}" alt="Cover page of a sample property verification report" width="639" height="905" fetchpriority="high">
                <span>See a real sample report ↓</span>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════ SAMPLE REPORT ═══════════ --}}
{{-- Real 10-page PDF built from actual documents with personal details hidden.
     Opens directly, no form: here trust matters more than capturing the lead. --}}
<section class="pv-section" id="sample-report" style="background:var(--pv-bg)">
    <div class="pv-container">
        <span class="pv-slabel">Sample Report</span>
        <h2 class="pv-stitle">See the Report You'll Get</h2>
        <p class="pv-ssub">A real report made from actual Lucknow land records, with names and personal details hidden. It shows each check, what we found, and what it means for you.</p>

        <div class="pv-sample__pages">
            <a class="pv-sample__page" href="{{ $pvSample }}" target="_blank" rel="noopener">
                <img src="{{ asset('images/verification/sample-report-cover.webp') }}" alt="Sample property verification report Lucknow, cover page" loading="lazy" width="639" height="905">
                <span>Cover &amp; the 6 checks</span>
            </a>
            <a class="pv-sample__page" href="{{ $pvSample }}#page=2" target="_blank" rel="noopener">
                <img src="{{ asset('images/verification/sample-report-summary.webp') }}" alt="Sample report summary page with the result of each check" loading="lazy" width="639" height="905">
                <span>Summary of results</span>
            </a>
            <a class="pv-sample__page" href="{{ $pvSample }}#page=6" target="_blank" rel="noopener">
                <img src="{{ asset('images/verification/sample-report-bhar-mukt.webp') }}" alt="Sample encumbrance certificate and registry index pages" loading="lazy" width="639" height="905">
                <span>Real document samples</span>
            </a>
        </div>

        <div class="pv-sample__btns">
            <a href="{{ $pvSample }}" target="_blank" rel="noopener" class="pv-btn pv-btn--outline">Open Full Sample (PDF)</a>
            <a href="{{ $waVerify }}" class="pv-btn pv-btn--whatsapp">{!! $waIcon !!} Get My Property Checked</a>
        </div>
        <p class="pv-sample__note">10-page PDF in Hindi · Your report is ready in 48 hours</p>
    </div>
</section>

{{-- ═══════════ WHAT WE CHECK ═══════════ --}}
<section class="pv-section" style="background:var(--pv-bg2)">
    <div class="pv-container">
        <span class="pv-slabel">What We Check</span>
        <h2 class="pv-stitle">6 Checks on Every Property</h2>
        <p class="pv-ssub">We go to the source records — tehsil, sub-registrar, courts and LDA — and to the site itself. Not just online portals.</p>

        <div class="pv-check-grid">
            <div class="pv-check">
                <span class="pv-check__num">1</span>
                <h3>Form 41 — Comparative Khasra</h3>
                <p>Matches the old and new khasra numbers after chakbandi, so the plot on paper is the plot on the ground.</p>
            </div>
            <div class="pv-check">
                <span class="pv-check__num">2</span>
                <h3>Form 45 — Chakbandi Khatauni</h3>
                <p>Shows who owned the land after consolidation, so we can follow ownership from there to today's seller.</p>
            </div>
            <div class="pv-check">
                <span class="pv-check__num">3</span>
                <h3>Encumbrance &amp; Registry Index</h3>
                <p>Every registered sale and mortgage on the property from <a href="/blog/igrsup-lucknow-property-search-tutorial-hindi" style="color:inherit;text-decoration:underline;">IGRSUP</a>. Hidden loans and double sales show up here.</p>
            </div>
            <div class="pv-check">
                <span class="pv-check__num">4</span>
                <h3>Court Cases</h3>
                <p>Revenue, civil and consolidation court records searched by khasra number and owner names.</p>
            </div>
            <div class="pv-check">
                <span class="pv-check__num">5</span>
                <h3>Site Inspection (Muayna)</h3>
                <p>We visit the plot to confirm it exists where the papers say, and check its boundaries and who is in possession.</p>
            </div>
            <div class="pv-check">
                <span class="pv-check__num">6</span>
                <h3>LDA Approval &amp; Land Use</h3>
                <p>Is the colony approved, is it on the <a href="/blog/lda-illegal-colony-list-lucknow-2026" style="color:inherit;text-decoration:underline;">LDA illegal colony list</a>, and what does Master Plan 2031 allow on this land.</p>
            </div>
        </div>

        <div class="pv-extra">
            <p>Also available on request:</p>
            <ul>
                <li>30-year registry chain</li>
                <li>Zila Panchayat map approval</li>
                <li>Dakhil kharij status</li>
                <li>Measurement (paimaish)</li>
                <li>RERA &amp; OC/CC for flats</li>
                <li>Allotment letter check</li>
                <li>Power of attorney check</li>
            </ul>
        </div>
    </div>
</section>

{{-- ═══════════ HOW IT WORKS ═══════════ --}}
<section class="pv-section" style="background:var(--pv-bg)">
    <div class="pv-container">
        <span class="pv-slabel">How It Works</span>
        <h2 class="pv-stitle">4 Simple Steps</h2>
        <p class="pv-ssub">You don't visit any office. Send the details, and we do the rest.</p>

        <div class="pv-steps">
            <div class="pv-step">
                <div class="pv-step__num">1</div>
                <h3>Send the details</h3>
                <p>Property address or khasra number, the seller's name, and any papers you have — on WhatsApp.</p>
            </div>
            <div class="pv-step">
                <div class="pv-step__num">2</div>
                <h3>Get the fee confirmed</h3>
                <p>We tell you what needs checking and the fixed fee before you pay anything.</p>
            </div>
            <div class="pv-step">
                <div class="pv-step__num">3</div>
                <h3>We check at source</h3>
                <p>Tehsil, sub-registrar, courts, LDA — and a visit to the site.</p>
            </div>
            <div class="pv-step">
                <div class="pv-step__num">4</div>
                <h3>Report in 48 hours</h3>
                <p>A PDF with each check, what's fine, and what to ask the seller before you pay.</p>
            </div>
        </div>

        <div class="pv-center">
            <a href="{{ $waVerify }}" class="pv-btn pv-btn--whatsapp">{!! $waIcon !!} Start on WhatsApp</a>
        </div>
    </div>
</section>

{{-- ═══════════ FEES — the one place the price is shown ═══════════ --}}
<section class="pv-section" style="background:var(--pv-bg2)" id="pricing">
    <div class="pv-container">
        <span class="pv-slabel">Fees</span>
        <h2 class="pv-stitle">Property Verification Charges in Lucknow</h2>
        <p class="pv-ssub">A fixed fee, confirmed on WhatsApp before you pay. No per-document charges.</p>

        <div class="pv-pricing-grid">
            <div class="pv-price-card">
                <p class="pv-price-name">Plot / Flat</p>
                <p class="pv-price-desc">What most buyers need</p>
                <p class="pv-price-amount">₹5,000</p>
                <ul class="pv-price-list">
                    <li>All 6 checks above</li>
                    <li>Site inspection (muayna)</li>
                    <li>PDF report in 48 hours</li>
                </ul>
                <a href="{{ $waVerify }}" class="pv-btn pv-btn--primary">Choose Plot / Flat</a>
            </div>

            <div class="pv-price-card pv-price-card--featured">
                <span class="pv-price-badge">For NRIs &amp; high-value buys</span>
                <p class="pv-price-name">Premium</p>
                <p class="pv-price-desc">Detailed site inspection</p>
                <p class="pv-price-amount">₹10,000</p>
                <ul class="pv-price-list">
                    <li>Everything in Plot / Flat</li>
                    <li>Boundary measurement</li>
                    <li>Photos + video of the site</li>
                    <li>Neighbour check</li>
                </ul>
                <a href="{{ $pvWa . rawurlencode('Hi, I want the premium property verification with site visit.') }}" class="pv-btn pv-btn--primary">Choose Premium</a>
            </div>

            <div class="pv-price-card">
                <p class="pv-price-name">Commercial</p>
                <p class="pv-price-desc">Shop, office or commercial plot</p>
                <p class="pv-price-amount">₹7,000</p>
                <ul class="pv-price-list">
                    <li>Everything in Plot / Flat</li>
                    <li>Commercial land use check</li>
                    <li>Building map approval check</li>
                </ul>
                <a href="{{ $pvWa . rawurlencode('Hi, I want to verify a commercial property.') }}" class="pv-btn pv-btn--primary">Choose Commercial</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ PROBLEMS WE CATCH ═══════════ --}}
<section class="pv-section" style="background:var(--pv-bg)">
    <div class="pv-container">
        <span class="pv-slabel">Why Check</span>
        <h2 class="pv-stitle">Problems We Find Before You Pay</h2>
        <p class="pv-ssub">These are the most common reasons a Lucknow property deal goes wrong — and every one of them shows up in the records.</p>

        <div class="pv-risk-grid">
            <div class="pv-risk">
                <h3>The seller isn't the only owner</h3>
                <p>Inherited land often has several heirs. One of them selling alone leads to a dispute later.</p>
            </div>
            <div class="pv-risk">
                <h3>A case is already running</h3>
                <p>Revenue or civil cases the seller never mentions. Once you buy, the case becomes your problem.</p>
            </div>
            <div class="pv-risk">
                <h3>A hidden loan or double sale</h3>
                <p>The property is mortgaged to a bank, or already sold to someone else — both show in the registry index.</p>
            </div>
            <div class="pv-risk">
                <h3>Unapproved colony or public land</h3>
                <p>Plots in unapproved layouts, or on gram sabha land, can face demolition and won't get a bank loan.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ FAQ ═══════════ --}}
<section class="pv-section" style="background:var(--pv-bg2)">
    <div class="pv-container">
        <span class="pv-slabel">FAQs</span>
        <h2 class="pv-stitle">Common Questions</h2>
        <p class="pv-ssub">If your question isn't here, just ask on WhatsApp.</p>

        <div class="pv-faqs">
            @foreach ($pvFaqs as [$q, $a])
                <div class="pv-faq-item">
                    <button type="button" class="pv-faq-q" onclick="pvToggleFaq(this)"><span>{{ $q }}</span><i class="fas fa-chevron-down"></i></button>
                    <div class="pv-faq-a">{!! $a !!}</div>
                </div>
            @endforeach
        </div>

        <p class="pv-guides">
            Want to understand the papers first? Read our guides:
            <a href="/blog/check-property-ownership-records-lucknow">Ownership records</a> ·
            <a href="/blog/igrsup-lucknow-property-search-tutorial-hindi">IGRSUP search</a> ·
            <a href="/blog/dakhil-kharij-lucknow-mutation-process-guide">Dakhil kharij</a> ·
            <a href="/blog/encumbrance-certificate-lucknow-how-to-apply-online">Encumbrance certificate</a> ·
            <a href="/blog/how-to-check-lda-approved-map-lucknow-2026">LDA approved map</a> ·
            <a href="/blog/top-10-property-frauds-lucknow-2026-real-cases">Common frauds</a>
        </p>
    </div>
</section>

{{-- ═══════════ GOOGLE REVIEWS ═══════════ --}}
<section class="pv-section" style="background:var(--pv-bg); padding-bottom:0;">
    <div class="pv-container">
        <span class="pv-slabel">Reviews</span>
        <h2 class="pv-stitle">What Buyers Say</h2>
    </div>
</section>
@include('components.google-reviews', ['googleReviews' => $googleReviews])

{{-- ═══════════ FINAL CTA ═══════════ --}}
<section class="pv-cta">
    <div class="pv-container">
        <h2>Buying Soon? Check It First.</h2>
        <p>Send the property details on WhatsApp. We'll tell you what needs checking and how long it takes.</p>
        <div class="pv-cta__btns">
            <a href="{{ $waVerify }}" class="pv-btn pv-btn--whatsapp">{!! $waIcon !!} WhatsApp: +91-8595002933</a>
            <a href="tel:+918595002933" class="pv-btn pv-btn--ghost">📞 Call Now</a>
        </div>
    </div>
</section>

<div class="pv-mobile-cta" id="pv-mobile-cta">
    <a href="{{ $waVerify }}" class="whatsapp">💬 WhatsApp Us</a>
    <a href="#sample-report" class="sample">See Sample Report</a>
</div>

</div>{{-- /pv-wrap --}}

<script>
(function () {
    window.pvToggleFaq = function (btn) {
        var isOpen = btn.classList.contains('open');
        document.querySelectorAll('.pv-faq-q.open').forEach(function (b) {
            b.classList.remove('open');
            b.nextElementSibling.classList.remove('open');
        });
        if (!isOpen) { btn.classList.add('open'); btn.nextElementSibling.classList.add('open'); }
    };

    var mobileCta = document.getElementById('pv-mobile-cta');
    window.addEventListener('scroll', function () {
        mobileCta.classList.toggle('show', window.innerWidth < 1024 && window.scrollY > 500);
    }, { passive: true });
})();
</script>

@endsection
