@extends('layouts.user-app')

{{-- ═══════════════════════════════════════════════════════════════════
     SINGLE SOURCE OF TRUTH FOR FAQ CONTENT
     Both the visible FAQ accordion and the JSON-LD FAQPage schema
     are generated from this array — they can never drift.
     ═══════════════════════════════════════════════════════════════════ --}}
@php
$faqs = [
    [
        "How much does property verification cost in Ayodhya?",
        "Property verification in Ayodhya starts at ₹5,000 for residential plots and flats, ₹7,000 for commercial properties, and ₹10,000 for the premium package with a physical site visit. All packages include a PDF report within 48 hours. No hidden fees."
    ],
    [
        "Why is property verification critical in Ayodhya right now?",
        "Since the Ram Mandir consecration in January 2024, Ayodhya land prices have risen up to 300 to 500 percent in prime Ram Mandir corridors. This boom has attracted large-scale land fraud — forged ADA approvals, disputed religious trust land, government acquisition zone sales, and fabricated title chains. A professional verification catches all of these before you pay."
    ],
    [
        "What is ADA approval and why is it important?",
        "ADA stands for Ayodhya Development Authority. Any plotted development in Ayodhya requires ADA layout approval. Unapproved layouts are illegal and can be demolished without compensation. We physically verify the ADA approval record — not the photocopy a seller hands you, which may be forged."
    ],
    [
        "What is the Ram Mandir restricted zone?",
        "The government has notified buffer and acquisition zones around the Ram Mandir complex and along the Ram Path development corridor. Land within these zones faces compulsory acquisition at government circle rates — far below the market price you paid. Our verification explicitly checks this."
    ],
    [
        "Can NRIs use DSD Properties for Ayodhya verification from abroad?",
        "Yes. Many NRIs investing in Ayodhya following the Ram Mandir development use our service. You WhatsApp documents from anywhere, we physically verify on the ground in Ayodhya, and deliver the PDF report. The ₹10,000 premium package adds a site visit with photos and video."
    ],
    [
        "What documents do I need to share for Ayodhya property verification?",
        "The property address and seller's full name are enough to start. If you have documents — ADA approval letter, sale deed, Khatauni, RERA number — share them on WhatsApp. We do a free preliminary check before you commit to the ₹5,000 full verification."
    ],
    [
        "Which areas of Ayodhya do you cover?",
        "We cover all of Ayodhya district — Ram Mandir corridor, Naya Ghat, Ram Path, Saket, Faizabad, Bikapur, Sohawal, Milkipur, Rudauli, Tanda, Airport zone and surrounding areas. No extra charge for any location."
    ],
    [
        "What happens if you find problems with my Ayodhya property?",
        "If we find red flags — forged ADA approval, government acquisition zone, religious trust land, fabricated title chain, flood zone, or pending court case — we document everything in the PDF report. You can show this to the seller, walk away from the deal, or take it to a property lawyer for further action."
    ],
];
@endphp

@section('title', 'Property Verification in Ayodhya — ₹5,000, 48-Hour Report | DSD')
@section('meta_description', 'Buying property in Ayodhya? We check ADA approval, Ram Mandir zone limits, khatauni and court records. ₹5,000 fixed fee, PDF report in 48 hours.')
@section('meta_keywords', 'property verification service ayodhya, property verifier ayodhya, property verification cost ayodhya, plot verification ayodhya, property document check ayodhya faizabad, how to check ada approval online, ayodhya land fraud safe zones, property lawyers in faizabad ayodhya')

@section('canonical', 'https://dsdproperties.in/services/property-verification-ayodhya')

@push('head')

{{-- Faster WhatsApp click-through --}}
<link rel="preconnect" href="https://wa.me">

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
  "priceRange": "₹5000-₹10000",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "226025",
    "addressCountry": "IN"
  },
  "areaServed": { "@type": "City", "name": "Ayodhya" },
  "sameAs": ["https://wa.me/918595002933"]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Property Verification Service",
  "name": "Professional Property Verification Service in Ayodhya",
  "description": "Hire an independent property verifier in Ayodhya. We physically check sale deed, registry, encumbrance certificate, ADA approval, Ram Mandir zone restrictions, court cases and Dakhil Kharij at Sub-Registrar, ADA office, Tehsil and district court. PDF report in 48 hours.",
  "provider": { "@id": "https://dsdproperties.in/#organization" },
  "areaServed": {
    "@type": "City",
    "name": "Ayodhya",
    "containedInPlace": { "@type": "State", "name": "Uttar Pradesh" }
  },
  "serviceArea": {
    "@type": "GeoCircle",
    "geoMidpoint": {
      "@type": "GeoCoordinates",
      "latitude": 26.7922,
      "longitude": 82.1998
    },
    "geoRadius": 30000
  },
  "offers": [
    { "@type": "Offer", "name": "Residential Plot / Flat Verification", "price": "5000", "priceCurrency": "INR", "description": "Sale deed, title chain, encumbrance, ADA approval, mutation and court record check. PDF report in 48 hours." },
    { "@type": "Offer", "name": "Commercial Property Verification", "price": "7000", "priceCurrency": "INR" },
    { "@type": "Offer", "name": "Premium Verification with Site Visit", "price": "10000", "priceCurrency": "INR" }
  ]
}
</script>

{{-- FAQ schema is generated from the same $faqs array used to render the visible accordion.
     Both are always in sync — no more manual drift between schema and page copy. --}}
<script type="application/ld+json">
{!! json_encode([
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => array_map(function($f) {
        return [
            "@type" => "Question",
            "name" => $f[0],
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => $f[1]
            ]
        ];
    }, $faqs)
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://dsdproperties.in" },
    { "@type": "ListItem", "position": 2, "name": "Services", "item": "https://dsdproperties.in/#services" },
    { "@type": "ListItem", "position": 3, "name": "Property Verification Service Ayodhya", "item": "https://dsdproperties.in/services/property-verification-ayodhya" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "How to Get Property Verified in Ayodhya",
  "description": "Hire DSD Properties for independent property verification in Ayodhya. Physical checks at ADA office, Sub-Registrar, Tehsil, and courts. PDF report in 48 hours at ₹5,000.",
  "totalTime": "PT48H",
  "estimatedCost": { "@type": "MonetaryAmount", "currency": "INR", "value": "5000" },
  "step": [
    { "@type": "HowToStep", "position": 1, "name": "WhatsApp Free Preliminary Check", "text": "Send the property address and seller's name on WhatsApp to +91-8595002933. We do a free preliminary check within 2 hours and tell you honestly if a full verification is worth doing.", "url": "https://dsdproperties.in/services/property-verification-ayodhya" },
    { "@type": "HowToStep", "position": 2, "name": "Share Available Documents", "text": "Share ADA approval letter, sale deed, Khatauni, RERA number — whatever you have. Even just the property address is enough to start.", "url": "https://dsdproperties.in/services/property-verification-ayodhya" },
    { "@type": "HowToStep", "position": 3, "name": "Pay ₹5,000 Verification Fee", "text": "Pay ₹5,000 for residential plots and flats, ₹7,000 for commercial, or ₹10,000 for the premium package with site visit. UPI or bank transfer. Invoice issued.", "url": "https://dsdproperties.in/services/property-verification-ayodhya" },
    { "@type": "HowToStep", "position": 4, "name": "We Verify at Source in Ayodhya", "text": "Our team physically checks ADA approval records, Ram Mandir acquisition zone status, Sub-Registrar records, Tehsil Khatauni and revenue classification (including religious trust land), and Ayodhya District Court records.", "url": "https://dsdproperties.in/services/property-verification-ayodhya" },
    { "@type": "HowToStep", "position": 5, "name": "Receive Detailed PDF Report in 48 Hours", "text": "A clear PDF report with every check performed, any red flags found, and a final verdict: Safe to Buy or Do Not Proceed. Delivered within 48 hours.", "url": "https://dsdproperties.in/services/property-verification-ayodhya" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Property Verification Service Ayodhya — Hire Plot & Registry Verifier ₹5,000",
  "url": "https://dsdproperties.in/services/property-verification-ayodhya",
  "description": "Hire a professional property verifier in Ayodhya. We check ADA approval, Ram Mandir zone restrictions, Sub-Registrar, court records and Khatauni at source. PDF report in 48 hours. ₹5,000 fixed fee.",
  "speakable": { "@type": "SpeakableSpecification", "cssSelector": [".pv-hero__sub", ".pv-ssub", ".pv-step p", ".pv-faq-a"] },
  "about": {
    "@type": "Service",
    "name": "Property Verification Service Ayodhya",
    "description": "Independent physical verification of property documents in Ayodhya including ADA approval, Ram Mandir zone, Sub-Registrar records, religious trust land classification, and court records. PDF report in 48 hours at ₹5,000.",
    "provider": { "@id": "https://dsdproperties.in/#organization" }
  }
}
</script>

@endpush

@section('content')

<style>
:root {
    --pv-navy:   #011f4b;
    --pv-navy-2: #013870;
    --pv-navy-3: #01528e;
    --pv-teal:   #008080;
    --pv-orange: #FF5C00;
    --pv-bg:     var(--bg-primary,  #ffffff);
    --pv-bg2:    var(--bg-secondary, #f3f4f6);
    --pv-card:   var(--card-bg,     #ffffff);
    --pv-border: var(--border-color,#e5e7eb);
    --pv-t1:     var(--text-primary, #111827);
    --pv-t2:     var(--text-secondary,#4b5563);
    --pv-t3:     var(--text-tertiary, #9ca3af);
    --pv-brand-gradient: linear-gradient(135deg, #011f4b 0%, #013870 45%, #01528e 100%);
}

.pv-wrap { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
.pv-container { max-width: 1100px; margin: 0 auto; padding: 0 24px; }
.pv-section { padding: 80px 0; }

@keyframes pv-up   { from { opacity:0; transform:translateY(28px); } to { opacity:1; transform:none; } }
@keyframes pv-float{ 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
@keyframes pvPulse { 0%,100%{box-shadow:0 0 0 2px rgba(74,222,128,.3)} 50%{box-shadow:0 0 0 6px rgba(74,222,128,.08)} }

.pv-rv { opacity:0; transform:translateY(22px); transition: opacity .6s ease, transform .6s ease; transition-delay: var(--rd, 0s); }
.pv-rv.visible { opacity:1; transform:none; }

.pv-slabel { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--pv-teal); text-align: center; margin-bottom: 10px; display: block; }
.pv-stitle { font-size: clamp(1.6rem, 3.2vw, 2.4rem); font-weight: 800; color: var(--pv-t1); text-align: center; line-height: 1.15; margin-bottom: 12px; }
.pv-ssub   { font-size: .92rem; color: var(--pv-t2); text-align: center; max-width: 680px; margin: 0 auto 48px; line-height: 1.75; }

.pv-btn { display: inline-flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; border-radius: 11px; text-decoration: none; cursor: pointer; transition: all .22s; border: none; padding: 13px 26px; font-size: .88rem; }
.pv-btn--primary { background: linear-gradient(135deg, #FF5C00, #ff8840); color:#fff; box-shadow: 0 5px 20px rgba(255,92,0,.3); }
.pv-btn--primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(255,92,0,.42); color:#fff; }
.pv-btn--ghost { background: rgba(255,255,255,.1); color: rgba(255,255,255,.9); border: 1px solid rgba(255,255,255,.22); }
.pv-btn--ghost:hover { background: rgba(255,255,255,.18); color:#fff; }
.pv-btn--whatsapp { background: #25D366; color:#fff; box-shadow: 0 5px 20px rgba(37,211,102,.3); }
.pv-btn--whatsapp:hover { background:#1ebe5d; color:#fff; transform: translateY(-2px); }

/* ═══════════ HERO — Brand navy gradient (was brown/saffron) ═══════════ */
.pv-hero { position: relative; overflow: hidden; min-height: 88vh; background: var(--pv-brand-gradient); display: flex; align-items: center; }
.pv-hero__grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px); background-size: 50px 50px; }
.pv-hero__orb { position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none; }
.pv-hero__orb--a { width: 500px; height: 500px; background: rgba(0,128,128,.22); top: -120px; right: -80px; animation: pv-float 9s ease-in-out infinite; }
.pv-hero__orb--b { width: 360px; height: 360px; background: rgba(255,92,0,.18); bottom: -60px; left: -60px; animation: pv-float 11s ease-in-out infinite 3s; }
.pv-hero__body { position: relative; z-index: 2; padding-top: 60px; padding-bottom: 70px; display:grid; grid-template-columns: 1.15fr 1fr; gap: 50px; align-items: center; }
@media(max-width:900px){ .pv-hero__body { grid-template-columns: 1fr; gap: 30px; padding-top: 80px; } }

.pv-hero__left { animation: pv-up .6s ease both; }
.pv-hero__badge { display: inline-flex; align-items: center; gap: 9px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); border-radius: 99px; padding: 7px 16px; margin-bottom: 22px; font-size: 11px; font-weight: 500; color: rgba(255,255,255,.85); backdrop-filter: blur(8px); }
.pv-pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: #4ade80; flex-shrink: 0; animation: pvPulse 2.5s infinite; display: inline-block; }
.pv-hero__h1 { font-size: clamp(1.85rem, 3.6vw, 2.7rem); font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 18px; letter-spacing: -.4px; }
.pv-hero__h1 em { font-style: normal; color: #FFD700; }
.pv-hero__sub { font-size: .95rem; color: rgba(255,255,255,.82); line-height: 1.78; margin-bottom: 26px; max-width: 580px; }
.pv-hero__cta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 26px; }
.pv-hero__pills { display: flex; flex-wrap: wrap; gap: 8px; }
.pv-pill { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); border-radius: 8px; font-size: 11px; color: rgba(255,255,255,.75); }
.pv-pill svg { width: 12px; height: 12px; flex-shrink: 0; }

.pv-hero__card { background: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 28px 72px rgba(0,0,0,.3); animation: pv-up .7s ease .15s both; }
.pv-hero__card-tag { display:inline-block; font-size:10px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--pv-orange); background:rgba(255,92,0,.08); padding:4px 9px; border-radius:5px; margin-bottom: 12px; }
.pv-hero__card-title { font-size: 1.2rem; font-weight: 800; color: var(--pv-t1); margin-bottom: 6px; line-height: 1.3; }
.pv-hero__card-sub { font-size: .82rem; color: var(--pv-t2); margin-bottom: 18px; line-height: 1.6; }
.pv-hero__card-price { display: flex; align-items: baseline; gap: 8px; margin-bottom: 18px; padding: 14px 16px; background: var(--pv-bg2); border-radius: 10px; border-left: 4px solid var(--pv-orange); }
.pv-hero__card-price-amt { font-size: 1.8rem; font-weight: 900; color: var(--pv-navy); line-height: 1; }
.pv-hero__card-price-lbl { font-size: .78rem; color: var(--pv-t2); }
.pv-hero__card-list { list-style:none; padding:0; margin: 0 0 18px; }
.pv-hero__card-list li { display: flex; align-items: flex-start; gap: 9px; padding: 6px 0; font-size: .82rem; color: var(--pv-t2); }
.pv-hero__card-list li::before { content: "✓"; color: var(--pv-teal); font-weight: 800; flex-shrink: 0; }
.pv-hero__card-btn { display: block; width: 100%; padding: 14px; background: #25D366; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: .92rem; cursor: pointer; font-family: 'Poppins', sans-serif; text-align: center; text-decoration: none; transition: transform .2s, box-shadow .2s; box-shadow: 0 5px 18px rgba(37,211,102,.3); }
.pv-hero__card-btn:hover { transform: translateY(-1px); color:#fff; text-decoration:none; }
.pv-hero__card-note { margin-top: 12px; font-size: .72rem; color: var(--pv-t3); text-align: center; line-height: 1.5; }
.pv-hero__wave { position: absolute; bottom: 0; left: 0; right: 0; line-height: 0; }
.pv-hero__wave svg { width: 100%; height: 56px; display: block; }

.pv-metrics { background: var(--pv-card); border-bottom: 1px solid var(--pv-border); padding: 26px 0; }
.pv-metrics__grid { display:grid; grid-template-columns: repeat(4, 1fr); gap: 16px; text-align: center; }
@media(max-width:680px){ .pv-metrics__grid { grid-template-columns: repeat(2, 1fr); gap: 22px; } }
.pv-metric__num { font-size: 1.6rem; font-weight: 900; color: var(--pv-navy); line-height: 1; margin-bottom: 6px; }
.pv-metric__num span { color: var(--pv-orange); }
.pv-metric__label { font-size: .72rem; color: var(--pv-t2); text-transform: uppercase; letter-spacing: 1.2px; font-weight: 600; }

.pv-boom-banner { background: linear-gradient(135deg, #7c2d12, #9a3412); border-radius: 14px; padding: 22px 28px; max-width: 920px; margin: 0 auto 40px; display: flex; gap: 16px; align-items: flex-start; }
.pv-boom-banner-icon { font-size: 1.8rem; flex-shrink: 0; }
.pv-boom-banner-title { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
.pv-boom-banner-text { font-size: .84rem; color: rgba(255,255,255,.88); line-height: 1.65; }

.pv-local-box { background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1.5px solid rgba(217,119,6,.25); border-radius: 16px; padding: 28px 30px; max-width: 920px; margin: 0 auto 40px; }
.pv-local-box h3 { font-size: 1.05rem; font-weight: 800; color: var(--pv-navy); margin-bottom: 14px; }
.pv-local-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px; }
.pv-local-item { display: flex; gap: 10px; align-items: flex-start; background: #fff; border-radius: 10px; padding: 13px 14px; border: 1px solid rgba(217,119,6,.18); }
.pv-local-item-icon { font-size: 1.2rem; flex-shrink: 0; }
.pv-local-item-title { font-size: .82rem; font-weight: 700; color: var(--pv-navy); margin-bottom: 3px; }
.pv-local-item-text  { font-size: .74rem; color: var(--pv-t2); line-height: 1.55; }

.pv-diy-table { max-width: 920px; margin: 0 auto; background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 16px; overflow: hidden; box-shadow: 0 8px 32px rgba(1,31,75,.06); }
.pv-diy-head { display: grid; grid-template-columns: 1.1fr 1fr 1fr; background: var(--pv-brand-gradient); color:#fff; }
.pv-diy-head > div { padding: 16px 18px; font-size: .82rem; font-weight: 700; border-right: 1px solid rgba(255,255,255,.1); }
.pv-diy-head > div:last-child { border-right: none; }
.pv-diy-head > div:nth-child(3) { background: rgba(255,92,0,.18); }
.pv-diy-row { display: grid; grid-template-columns: 1.1fr 1fr 1fr; border-top: 1px solid var(--pv-border); }
.pv-diy-row > div { padding: 14px 18px; font-size: .82rem; color: var(--pv-t2); border-right: 1px solid var(--pv-border); line-height: 1.6; }
.pv-diy-row > div:last-child { border-right: none; }
.pv-diy-row > div:first-child { font-weight: 600; color: var(--pv-t1); background: var(--pv-bg2); }
.pv-diy-row > div:nth-child(3) { background: rgba(255,92,0,.04); }
.pv-diy-good { color: #047857 !important; font-weight: 600; }
.pv-diy-bad  { color: #b91c1c !important; }
@media(max-width:680px){
    .pv-diy-head, .pv-diy-row { grid-template-columns: 1fr; }
    .pv-diy-head > div, .pv-diy-row > div { border-right: none; border-bottom: 1px solid rgba(255,255,255,.1); }
    .pv-diy-row > div { border-bottom: 1px solid var(--pv-border); }
    .pv-diy-head > div:nth-child(3), .pv-diy-row > div:nth-child(3) { border-top: 2px solid var(--pv-orange); }
}

.pv-check-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; max-width: 920px; margin: 0 auto; }
@media(max-width:680px){ .pv-check-grid { grid-template-columns: 1fr; } }
.pv-check-card { background: var(--pv-card); border: 1.5px solid var(--pv-border); border-radius: 14px; padding: 22px; display: flex; gap: 16px; align-items: flex-start; transition: transform .25s, box-shadow .25s, border-color .25s; }
.pv-check-card:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(0,128,128,.1); border-color: rgba(0,128,128,.3); }
.pv-check-card__icon { width: 44px; height: 44px; flex-shrink: 0; background: linear-gradient(135deg, var(--pv-teal), #006666); color:#fff; border-radius: 11px; display:flex; align-items:center; justify-content:center; font-size: 1.3rem; }
.pv-check-card__title { font-size: .92rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 5px; }
.pv-check-card__text { font-size: .82rem; color: var(--pv-t2); line-height: 1.65; margin: 0 0 8px; }
.pv-check-card__where { font-size: .72rem; color: var(--pv-teal); font-weight: 600; }
.pv-check-card__where::before { content: "📍 "; }

.pv-risk-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px,1fr)); gap: 16px; margin-bottom: 24px; }
.pv-risk-card { background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 14px; padding: 22px 20px; display: flex; gap: 14px; align-items: flex-start; transition: transform .25s; }
.pv-risk-card:hover { transform: translateY(-3px); }
.pv-risk-icon { width: 42px; height: 42px; background: #dc2626; border-radius: 10px; display:flex; align-items:center; justify-content:center; font-size: 1.2rem; flex-shrink: 0; }
.pv-risk-title { font-size: .9rem; font-weight: 700; color: #111827; margin-bottom: 5px; }
.pv-risk-text  { font-size: .78rem; color: #4b5563; line-height: 1.6; margin: 0; }
.pv-risk-banner { background: linear-gradient(135deg, #dc2626, #b91c1c); padding: 26px 32px; border-radius: 14px; max-width: 860px; margin: 0 auto; display: flex; gap: 16px; align-items: flex-start; }
.pv-risk-banner-icon { color:#fff; font-size: 1.6rem; flex-shrink: 0; }
.pv-risk-banner-title { color:#fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 6px; }
.pv-risk-banner-text  { color: rgba(255,255,255,.9); font-size: .85rem; line-height: 1.6; }

.pv-steps { max-width: 860px; margin: 0 auto; display: flex; flex-direction: column; gap: 14px; }
.pv-step { display: flex; gap: 18px; align-items: flex-start; background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 14px; padding: 20px; transition: transform .25s, box-shadow .25s; }
.pv-step:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,.07); }
.pv-step__num { width: 48px; height: 48px; flex-shrink: 0; background: var(--pv-brand-gradient); color:#fff; border-radius: 11px; display:flex; align-items:center; justify-content:center; font-size: 1.25rem; font-weight: 800; }
.pv-step h3 { font-size: .9rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 5px; }
.pv-step p  { font-size: .8rem; color: var(--pv-t2); line-height: 1.6; margin: 0; }

/* ═══════════ SAMPLE REPORT — with clear SAMPLE watermark ═══════════ */
.pv-report { max-width: 880px; margin: 0 auto; background: var(--pv-card); border: 1.5px solid var(--pv-border); border-radius: 18px; overflow: hidden; box-shadow: 0 12px 40px rgba(1,31,75,.08); position: relative; }
.pv-report::before {
    content: "SAMPLE";
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) rotate(-28deg);
    font-size: clamp(4rem, 12vw, 8rem);
    font-weight: 900;
    color: rgba(1, 31, 75, 0.06);
    letter-spacing: 12px;
    pointer-events: none;
    z-index: 1;
    white-space: nowrap;
}
.pv-report__header { background: var(--pv-brand-gradient); color:#fff; padding: 24px 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; position: relative; z-index: 2; }
.pv-report__title { font-size: 1.1rem; font-weight: 800; margin: 0; }
.pv-report__subtitle { font-size: .78rem; color: rgba(255,255,255,.75); margin: 4px 0 0; }
.pv-report__verdict { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #047857; color:#fff; border-radius: 99px; font-size: .8rem; font-weight: 700; }
.pv-report__body { padding: 22px 28px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; position: relative; z-index: 2; }
@media(max-width:600px){ .pv-report__body { grid-template-columns: 1fr; } }
.pv-report__item { display: flex; gap: 10px; padding: 12px; background: var(--pv-bg2); border-radius: 10px; align-items: flex-start; }
.pv-report__item-check { color: #047857; font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
.pv-report__item-text { font-size: .8rem; color: var(--pv-t2); line-height: 1.5; }
.pv-report__item-text strong { color: var(--pv-t1); display: block; margin-bottom: 2px; font-size: .82rem; }
.pv-report__footer { padding: 18px 28px; background: var(--pv-bg2); border-top: 1px solid var(--pv-border); font-size: .78rem; color: var(--pv-t3); text-align: center; position: relative; z-index: 2; }

.pv-pricing-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 18px; align-items: start; }
@media(max-width:820px){ .pv-pricing-grid { grid-template-columns:1fr; max-width:440px; margin:0 auto; } }
.pv-price-card { background: var(--pv-card); border: 2px solid var(--pv-border); border-radius: 18px; padding: 32px 28px; text-align: center; transition: transform .3s, box-shadow .3s, border-color .3s; position: relative; }
.pv-price-card:hover { transform: translateY(-6px); box-shadow: 0 18px 44px rgba(0,0,0,.1); border-color: var(--pv-teal); }
/* Featured card now uses brand navy gradient (was brown/saffron) */
.pv-price-card--featured { background: var(--pv-brand-gradient); border-color: var(--pv-orange); box-shadow: 0 12px 36px rgba(1,31,75,.28); }
.pv-price-badge { position: absolute; top: -13px; left: 50%; transform: translateX(-50%); background: #fff; color: var(--pv-orange); padding: 4px 14px; border-radius: 99px; font-weight: 800; font-size: .72rem; box-shadow: 0 4px 12px rgba(0,0,0,.15); border: 2px solid var(--pv-orange); white-space: nowrap; }
.pv-price-tag { display: inline-block; padding: 5px 13px; border-radius: 99px; font-weight: 700; font-size: .72rem; margin-bottom: 12px; background: #f3f4f6; color: #374151; letter-spacing: 1px; }
.pv-price-card--featured .pv-price-tag { background: rgba(255,255,255,.2); color:#fff; }
.pv-price-name { font-size: 1.15rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 10px; }
.pv-price-card--featured .pv-price-name { color:#fff; }
.pv-price-amount { font-size: 2.3rem; font-weight: 900; color: var(--pv-navy); margin: 12px 0 4px; letter-spacing: -.03em; }
.pv-price-card--featured .pv-price-amount { color:#fff; }
.pv-price-desc { font-size: .78rem; color: var(--pv-t3); margin-bottom: 20px; }
.pv-price-card--featured .pv-price-desc { color: rgba(255,255,255,.85); }
.pv-price-list { list-style: none; padding: 0; margin: 0 0 22px; text-align: left; }
.pv-price-list li { padding: 8px 0; display: flex; align-items: flex-start; gap: 9px; font-size: .8rem; color: var(--pv-t2); border-bottom: 1px solid var(--pv-border); }
.pv-price-list li:last-child { border-bottom: none; }
.pv-price-card--featured .pv-price-list li { color: rgba(255,255,255,.92); border-bottom-color: rgba(255,255,255,.15); }
.pv-price-check { color: var(--pv-teal); flex-shrink: 0; margin-top: 1px; font-size: .82rem; }
.pv-price-card--featured .pv-price-check { color:#fff; }
.pv-price-btn { display: block; width: 100%; padding: 12px; border-radius: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .84rem; text-decoration: none; text-align: center; border: none; cursor: pointer; transition: all .22s; background: linear-gradient(135deg, #FF5C00, #ff8840); color:#fff; box-shadow: 0 4px 14px rgba(255,92,0,.28); }
.pv-price-btn:hover { transform: translateY(-2px); color:#fff; }
.pv-price-btn--white { background:#fff; color:var(--pv-orange); }
.pv-price-btn--white:hover { background:#fff8f5; color:var(--pv-orange); }

.pv-area-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; max-width: 860px; margin: 0 auto; }
.pv-area-pill { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 10px; padding: 11px 14px; font-size: .8rem; font-weight: 600; color: var(--pv-t1); text-align: center; transition: all .2s; }
.pv-area-pill:hover { border-color: var(--pv-teal); color: var(--pv-teal); background: rgba(0,128,128,.04); }

/* ═══════════ CTA — Brand navy gradient (was brown/saffron) ═══════════ */
.pv-cta { background: var(--pv-brand-gradient); padding: 70px 0; position: relative; overflow: hidden; }
.pv-cta__orb { position: absolute; border-radius: 50%; filter: blur(80px); width: 400px; height: 400px; background: rgba(0,128,128,.18); top: -100px; right: -80px; animation: pv-float 10s ease-in-out infinite; }
.pv-cta__inner { position: relative; z-index: 2; text-align: center; }
.pv-cta h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color:#fff; margin-bottom: 12px; }
.pv-cta p  { font-size: .92rem; color: rgba(255,255,255,.78); max-width: 580px; margin: 0 auto 30px; line-height: 1.7; }
.pv-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

.pv-faq-item { border: 1px solid var(--pv-border); border-radius: 12px; background: var(--pv-card); overflow: hidden; }
.pv-faq-item[open] summary span.arrow-icon { transform: rotate(180deg); }
.pv-faq-q { width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; font-family: 'Poppins', sans-serif; font-size: .88rem; font-weight: 600; color: var(--pv-t1); cursor: pointer; text-align: left; gap: 12px; transition: background .2s; list-style: none; }
.pv-faq-q::-webkit-details-marker { display: none; }
.pv-faq-q:hover { background: var(--pv-bg2); }
.pv-faq-q span.arrow-icon { color: var(--pv-teal); flex-shrink: 0; transition: transform .3s; font-size: .78rem; display: inline-block; }
.pv-faq-a { padding: 0 20px 16px; font-size: .83rem; color: var(--pv-t2); line-height: 1.75; }

/* ═══════════ DISCLAIMER ═══════════ */
.pv-disclaimer { max-width: 820px; margin: 32px auto 0; padding: 14px 20px; background: var(--pv-bg2); border: 1px solid var(--pv-border); border-radius: 10px; font-size: .74rem; color: var(--pv-t3); line-height: 1.65; text-align: center; }
.pv-disclaimer strong { color: var(--pv-t2); }

.pv-mobile-cta { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: var(--pv-card); border-top: 3px solid var(--pv-orange); padding: 10px 14px; z-index: 90; box-shadow: 0 -4px 20px rgba(0,0,0,.12); gap: 8px; }
.pv-mobile-cta.show { display: flex; }
.pv-mobile-cta a { flex: 1; text-align: center; padding: 11px 8px; border-radius: 9px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .8rem; text-decoration: none; }
.pv-mobile-cta a.whatsapp { background: #25D366; color:#fff; }
.pv-mobile-cta a.book { background: linear-gradient(135deg, #FF5C00, #ff8840); color:#fff; }

/* Clear content behind sticky mobile CTA */
@media (max-width: 768px) {
    .pv-wrap { padding-bottom: 80px; }
}

@media(max-width:860px){ .pv-section { padding: 56px 0; } .pv-cta { padding: 56px 0; } }
@media(max-width:480px){ .pv-hero__cta { flex-direction: column; } .pv-risk-banner { flex-direction: column; gap: 10px; } .pv-boom-banner { flex-direction: column; gap: 10px; } }

/* ═══════════ REDUCED MOTION + LOW-END DEVICE OPTIMIZATION ═══════════ */
@media (prefers-reduced-motion: reduce) {
    .pv-hero__orb--a, .pv-hero__orb--b, .pv-cta__orb { animation: none; }
    .pv-pulse-dot { animation: none; }
    .pv-rv { opacity: 1; transform: none; transition: none; }
    .pv-hero__left, .pv-hero__card { animation: none; }
    .pv-check-card:hover, .pv-price-card:hover, .pv-step:hover, .pv-risk-card:hover { transform: none; }
}
/* Disable heavy blur animations on small screens to protect low-end Android */
@media (max-width: 480px) {
    .pv-hero__orb--a, .pv-hero__orb--b, .pv-cta__orb { animation: none; }
}
</style>

<div class="pv-wrap">

{{-- ═══════════ HERO ═══════════ --}}
<section class="pv-hero">
    <nav aria-label="Breadcrumb" style="position:absolute; top:20px; left:0; right:0; z-index:3;">
        <div class="pv-container">
            <ol style="display:flex; gap:8px; list-style:none; margin:0; padding:0; font-size:12px; color:rgba(255,255,255,0.65); flex-wrap:wrap;">
                <li><a href="/" style="color:rgba(255,255,255,0.65); text-decoration:none;">Home</a></li>
                <li style="color:rgba(255,255,255,0.3);">›</li>
                <li><a href="/#services" style="color:rgba(255,255,255,0.65); text-decoration:none;">Services</a></li>
                <li style="color:rgba(255,255,255,0.3);">›</li>
                <li style="color:#fff; font-weight:500;">Property Verification Ayodhya</li>
            </ol>
        </div>
    </nav>

    <div class="pv-hero__grid"></div>
    <div class="pv-hero__orb pv-hero__orb--a"></div>
    <div class="pv-hero__orb pv-hero__orb--b"></div>

    <div class="pv-container pv-hero__body">
        <div class="pv-hero__left">
            <div class="pv-hero__badge">
                <span class="pv-pulse-dot"></span>
                Ayodhya's Independent Property Verifier
            </div>

            <h1 class="pv-hero__h1">
                Independent Property<br>
                Verification Service in<br>
                Ayodhya — Fixed fee <em>₹5,000</em>.
            </h1>

            <p class="pv-hero__sub">
                Ayodhya's historic land boom has triggered a massive wave of sophisticated property scams. Don't risk your hard-earned savings on a plot that might be illegal. <strong>Before you pay lakhs to a seller, spend ₹5,000 to know the absolute truth.</strong> We physically pull original records from the ADA, Sub-Registrar, and local courts.
                <span style="color:#FFD700; display:block; margin-top:8px; font-weight:600;">🔒 Clear, legally-vetted PDF Report delivered in 48 Hours.</span>
            </p>

            <div class="pv-hero__cta">
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20you%20for%20property%20verification%20in%20Ayodhya.%20Property%20address%3A" class="pv-btn pv-btn--whatsapp">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Hire a Verifier — WhatsApp Us
                </a>
                <a href="#pricing" class="pv-btn pv-btn--ghost">See Pricing →</a>
            </div>

            {{-- Trust pills: SVG icons instead of Font Awesome (removes external dependency) --}}
            <div class="pv-hero__pills">
                <div class="pv-pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    48-Hour PDF Report
                </div>
                <div class="pv-pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    ADA Approval Verified
                </div>
                <div class="pv-pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    NRI Verification
                </div>
            </div>
        </div>

        <div class="pv-hero__card">
            <div class="pv-hero__card-tag">RESIDENTIAL PLOT / FLAT — AYODHYA</div>
            <div class="pv-hero__card-title">Hire an Ayodhya Property Verifier</div>
            <div class="pv-hero__card-sub">Trained verifier physically checks ADA records, Sub-Registrar, Tehsil and district court records in Ayodhya. Detailed PDF report in 48 hours.</div>

            <div class="pv-hero__card-price">
                <span class="pv-hero__card-price-amt">₹5,000</span>
                <span class="pv-hero__card-price-lbl">all-inclusive · no hidden fees</span>
            </div>

            <ul class="pv-hero__card-list">
                <li>ADA layout approval verified at source</li>
                <li>Registry & 30-year sale deed title chain</li>
                <li>Encumbrance certificate (Sub-Registrar)</li>
                <li>Government acquisition zone status check</li>
                <li>Final verdict: Safe to Buy or Walk Away</li>
            </ul>

            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20book%20the%20%E2%82%B95%2C000%20property%20verification%20in%20Ayodhya.%20Property%20address%3A" class="pv-hero__card-btn">Book ₹5,000 Verification on WhatsApp</a>
            <div class="pv-hero__card-note">🔒 100% confidential · Free preliminary check first</div>
        </div>
    </div>

    <div class="pv-hero__wave">
        <svg viewBox="0 0 1440 56" preserveAspectRatio="none">
            <path d="M0,28 C480,56 960,0 1440,28 L1440,56 L0,56 Z" fill="var(--bg-primary,#fff)"/>
        </svg>
    </div>
</section>

{{-- ═══════════ METRICS ═══════════ --}}
<section class="pv-metrics">
    <div class="pv-container">
        <div class="pv-metrics__grid">
            <div><div class="pv-metric__num">300<span>%+</span></div><div class="pv-metric__label">Price Rise (Prime Corridors)</div></div>
            <div><div class="pv-metric__num">30 yr</div><div class="pv-metric__label">Title Chain Traced</div></div>
            <div><div class="pv-metric__num">48 hr</div><div class="pv-metric__label">PDF Report Delivery</div></div>
            <div><div class="pv-metric__num">₹5K</div><div class="pv-metric__label">vs ₹50L At Risk</div></div>
        </div>
    </div>
</section>

{{-- ═══════════ AYODHYA-SPECIFIC RISKS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Ayodhya-Specific</span>
        <h2 class="pv-stitle pv-rv">Why Ayodhya Property Demands Extra Caution Right Now</h2>
        <p class="pv-ssub pv-rv">The Ram Mandir consecration triggered one of UP's fastest property booms — and one of its fastest-growing fraud ecosystems. These risks are unique to Ayodhya and invisible on any online portal.</p>

        <div class="pv-boom-banner pv-rv">
            <div class="pv-boom-banner-icon">⚠️</div>
            <div>
                <div class="pv-boom-banner-title">Crucial Update for Ayodhya Property Buyers</div>
                <div class="pv-boom-banner-text">
                    Following the massive infrastructure development, the local administration and UP Police have flagged hundreds of unauthorized colonies and fraudulent land deeds. Scammers are using high-quality forged letterheads of the <strong>Ayodhya Development Authority (ADA)</strong> and selling government-notified master plan widening zones to unsuspecting buyers. Online portals will not show these restrictions. <strong>If your name isn't successfully cleared in the source records, your registry is legally worthless.</strong>
                </div>
            </div>
        </div>

        <div class="pv-local-box pv-rv">
            <h3>🏛️ Ayodhya-Specific Land Risks We Check Explicitly</h3>
            <div class="pv-local-grid">
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🏗️</div>
                    <div>
                        <div class="pv-local-item-title">Fake / Forged ADA Approvals</div>
                        <div class="pv-local-item-text">Ayodhya Development Authority layout approvals being forged on a large scale. Only a physical visit to ADA records confirms whether a layout is genuinely sanctioned.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🏛️</div>
                    <div>
                        <div class="pv-local-item-title">Ram Mandir Zone Acquisition</div>
                        <div class="pv-local-item-text">Land inside government-notified buffer zones around the Ram Mandir complex is under active or pending acquisition. Sellers don't disclose this — buyers lose both money and land.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🛕</div>
                    <div>
                        <div class="pv-local-item-title">Mahant / Akhara Trust Land</div>
                        <div class="pv-local-item-text">Centuries-old religious trust land (Mahant, Akhara, or temple trust) being sold as private property. Legally void — the entire transaction can be cancelled by a court at any time.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🌊</div>
                    <div>
                        <div class="pv-local-item-title">Saryu River Flood Zone</div>
                        <div class="pv-local-item-text">Land within the Saryu flood plain has permanent construction restrictions. Growing demand is pushing sellers to list flood-zone land without disclosing the restriction.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🛣️</div>
                    <div>
                        <div class="pv-local-item-title">Master Plan Acquisition Corridors</div>
                        <div class="pv-local-item-text">Ayodhya's master plan expansion includes multiple road widening and development corridors where land is earmarked for acquisition. Buyers often discover this only after possession.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">📋</div>
                    <div>
                        <div class="pv-local-item-title">Rapid Title Chain Manipulation</div>
                        <div class="pv-local-item-text">As prices surged, fabricated sale deed chains appeared — especially in areas like Naya Ghat, Ram Path corridor, and Saket Colony. Without a Sub-Registrar manual check, these pass undetected.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ DIY VS HIRE ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Honest Comparison</span>
        <h2 class="pv-stitle pv-rv">Doing It Yourself vs. Hiring DSD Properties</h2>
        <p class="pv-ssub pv-rv">You can check documents yourself. Here's what you actually verify online — and what only a professional physically present in Ayodhya can confirm.</p>

        <div class="pv-diy-table pv-rv">
            <div class="pv-diy-head">
                <div>What You Check</div>
                <div>Doing It Yourself</div>
                <div>Hiring DSD Properties</div>
            </div>
            <div class="pv-diy-row">
                <div>ADA layout approval</div>
                <div class="pv-diy-bad">Cannot verify online — forged copies look real</div>
                <div class="pv-diy-good">Physical check at ADA office records</div>
            </div>
            <div class="pv-diy-row">
                <div>Government acquisition zone</div>
                <div class="pv-diy-bad">Not disclosed online anywhere</div>
                <div class="pv-diy-good">Checked against notified zone maps</div>
            </div>
            <div class="pv-diy-row">
                <div>Sub-Registrar encumbrance</div>
                <div class="pv-diy-bad">Hard to extract 30-year chain manually</div>
                <div class="pv-diy-good">30-year certificate extracted at source</div>
            </div>
            <div class="pv-diy-row">
                <div>Mahant / Trust land check</div>
                <div class="pv-diy-bad">No online record exists</div>
                <div class="pv-diy-good">Tehsil + Collector office check</div>
            </div>
            <div class="pv-diy-row">
                <div>Saryu flood zone status</div>
                <div class="pv-diy-bad">Not visible on any portal</div>
                <div class="pv-diy-good">ADA zoning + revenue records</div>
            </div>
            <div class="pv-diy-row">
                <div>Court case search</div>
                <div class="pv-diy-bad">Difficult without legal access</div>
                <div class="pv-diy-good">Faizabad District Court checked</div>
            </div>
            <div class="pv-diy-row">
                <div>Written record if dispute arises</div>
                <div class="pv-diy-bad">None — no paper trail</div>
                <div class="pv-diy-good">Detailed PDF documentation you can present</div>
            </div>
        </div>

        <div style="max-width:780px; margin:28px auto 0; padding:18px 22px; background:#fefce8; border:1px solid rgba(217,119,6,.25); border-radius:12px; font-size:.86rem; line-height:1.75; color:var(--pv-t2);">
            <strong style="color:var(--pv-t1);">Honest take:</strong> In most cities, DIY verification is possible but time-consuming. In Ayodhya right now, the fraud is sophisticated enough that even experienced buyers are getting deceived. The ADA forged approval problem alone makes professional verification non-negotiable in this market.
        </div>

        <div style="text-align:center; margin-top:28px;">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20a%20property%20verifier%20in%20Ayodhya" class="pv-btn pv-btn--primary">Hire Us — Book Verification →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHAT WE CHECK ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What's Included</span>
        <h2 class="pv-stitle pv-rv">What We Check in Ayodhya — For You</h2>
        <p class="pv-ssub pv-rv">Every verification includes physical document checks across ADA, Sub-Registrar, Tehsil and court records. You don't visit any of them. We do it, we document it, we hand you a PDF.</p>

        <div class="pv-check-grid">
            <div class="pv-check-card pv-rv">
                <div class="pv-check-card__icon">🏗️</div>
                <div>
                    <div class="pv-check-card__title">ADA Layout Approval Verification</div>
                    <p class="pv-check-card__text">We physically check whether the plot's layout is sanctioned by the Ayodhya Development Authority. Forged ADA approval letters are the #1 fraud in Ayodhya right now — we verify the original record at the ADA office, not a photocopy the seller hands you.</p>
                    <div class="pv-check-card__where">Ayodhya Development Authority (ADA) Office</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">📄</div>
                <div>
                    <div class="pv-check-card__title">Registry & 30-Year Title Chain</div>
                    <p class="pv-check-card__text">Sale deed verified at the Sub-Registrar office and cross-referenced on IGRSUP. We trace ownership back 30 years to confirm the chain is unbroken. In Ayodhya's fast-moving market, fabricated title chains are being inserted to flip properties at inflated prices.</p>
                    <div class="pv-check-card__where">Sub-Registrar Office, Ayodhya / Faizabad + IGRSUP portal</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.12s">
                <div class="pv-check-card__icon">📜</div>
                <div>
                    <div class="pv-check-card__title">Encumbrance Certificate (Bhar Mukt Praman Patra)</div>
                    <p class="pv-check-card__text">A 30-year encumbrance certificate extracted at the Sub-Registrar reveals any hidden bank loans, mortgages, or registered legal claims against the property. With prices rising so fast, sellers are mortgaging and reselling the same property multiple times.</p>
                    <div class="pv-check-card__where">Sub-Registrar Office (extracted manually)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.18s">
                <div class="pv-check-card__icon">🏛️</div>
                <div>
                    <div class="pv-check-card__title">Ram Mandir Zone & Acquisition Status</div>
                    <p class="pv-check-card__text">We check whether the property is inside a government-notified acquisition zone or falls within the buffer area of the Ram Mandir master plan. Land in these zones can be acquired compulsorily at government rates — far below the market price you paid.</p>
                    <div class="pv-check-card__where">Collector Office + ADA Notified Zone Records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">🗺️</div>
                <div>
                    <div class="pv-check-card__title">Khatauni, Khasra & Mutation</div>
                    <p class="pv-check-card__text">Revenue records cross-checked at the relevant Tehsil. We confirm Dakhil Kharij (mutation) is complete in the current seller's name. In Ayodhya's rapidly developing areas, revenue records often lag behind — unverified mutation is a serious title risk.</p>
                    <div class="pv-check-card__where">Tehsil (Ayodhya Sadar / Sohawal / Bikapur / Milkipur)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.10s">
                <div class="pv-check-card__icon">⚖️</div>
                <div>
                    <div class="pv-check-card__title">Court Case Search</div>
                    <p class="pv-check-card__text">Pending litigation, family disputes and partition suits searched at Faizabad District Court and Allahabad High Court. Religious and ancestral property disputes are common in Ayodhya — many sellers conceal active cases when selling at peak prices.</p>
                    <div class="pv-check-card__where">Faizabad District Court + Allahabad High Court records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.16s">
                <div class="pv-check-card__icon">🛕</div>
                <div>
                    <div class="pv-check-card__title">Mahant / Akhara / Trust Land Check</div>
                    <p class="pv-check-card__text">Ayodhya-specific check for land registered under Mahant, Akhara, or religious trust ownership. Such land cannot legally be sold to private buyers. We check revenue classification at the Tehsil to confirm the land is genuinely private freehold property.</p>
                    <div class="pv-check-card__where">Tehsil Revenue Records + Collector Office</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.22s">
                <div class="pv-check-card__icon">🌊</div>
                <div>
                    <div class="pv-check-card__title">Saryu Flood Zone & Land Use Check</div>
                    <p class="pv-check-card__text">We verify whether the property falls within the Saryu river flood plain zone, where construction is permanently restricted. We also confirm ADA land use zoning — whether the plot is designated residential, commercial, green belt, or public utility — before you commit.</p>
                    <div class="pv-check-card__where">ADA Zoning Records + Revenue Department</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.28s">
                <div class="pv-check-card__icon">🏗️</div>
                <div>
                    <div class="pv-check-card__title">RERA Registration (Builder Projects)</div>
                    <p class="pv-check-card__text">For any builder project in Ayodhya, we verify RERA registration on UP-RERA portal — including complaint history, project completion status, and any regulatory orders against the builder. Unregistered projects carrying fake RERA numbers are common in the Ayodhya boom.</p>
                    <div class="pv-check-card__where">UP-RERA portal (up-rera.in) + ADA records</div>
                </div>
            </div>
        </div>

        <div style="margin-top:32px; text-align:center;">
            <p style="font-size:.86rem; color:var(--pv-t2); max-width:660px; margin:0 auto 18px; line-height:1.7;">Every check above requires physical presence and local expertise in Ayodhya. We do it all in 48 hours.</p>
            <a href="#pricing" class="pv-btn pv-btn--primary">See ₹5,000 Pricing →</a>
        </div>
    </div>
</section>

{{-- ═══════════ THE DSD ADVANTAGE SECTION ═══════════ --}}
<section class="pv-section" style="background:var(--pv-bg2)">
    <div class="pv-container" style="max-width:860px; text-align:center;">
        <span class="pv-slabel">The DSD Advantage</span>
        <h2 class="pv-stitle">Ground Verifiers + Property Advocates Working For You</h2>
        <p class="pv-ssub" style="margin-bottom:24px;">
            We don't just sit in front of a computer screen. DSD Properties runs a dedicated network of on-the-ground document experts backed by experienced local property advocates in the Lucknow-Ayodhya-Varanasi belt.
        </p>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px; text-align:left; margin-top:32px;">
            <div style="background:var(--pv-card); padding:20px; border-radius:12px; border:1px solid var(--pv-border);">
                <strong style="color:var(--pv-teal); display:block; margin-bottom:6px;">⚡ Direct-from-Source Data</strong>
                We bypass brokers. Our team physically sits with the revenue clerks (Lekhpal) and Sub-Registrar logs to trace the paper trail manually.
            </div>
            <div style="background:var(--pv-card); padding:20px; border-radius:12px; border:1px solid var(--pv-border);">
                <strong style="color:var(--pv-teal); display:block; margin-bottom:6px;">⚖️ Legal Vetting</strong>
                Every red flag we uncover is cross-verified against active dispute lists at the Faizabad District Court.
            </div>
            <div style="background:var(--pv-card); padding:20px; border-radius:12px; border:1px solid var(--pv-border);">
                <strong style="color:var(--pv-teal); display:block; margin-bottom:6px;">🤝 Zero Broker Alliances</strong>
                We do not sell these verified properties. We charge a clean, fixed fee to remain 100% independent and loyal only to you.
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ WHY IT MATTERS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Why It Matters</span>
        <h2 class="pv-stitle pv-rv">Why ₹5,000 Verification Saves You ₹50 Lakhs in Ayodhya</h2>
        <p class="pv-ssub pv-rv">Six fraud patterns dominate the Ayodhya market right now. A professional verification catches all six before you sign anything.</p>

        <div class="pv-risk-grid">
            <div class="pv-risk-card pv-rv"><div class="pv-risk-icon">🏗️</div><div><div class="pv-risk-title">Forged ADA Approval Letters</div><p class="pv-risk-text">Fabricated Ayodhya Development Authority layout approvals — the most common fraud in the current boom. Looks genuine until you check the actual ADA record.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.06s"><div class="pv-risk-icon">🏛️</div><div><div class="pv-risk-title">Government Acquisition Zone Sales</div><p class="pv-risk-text">Plots inside Ram Mandir master plan acquisition corridors sold as clear freehold. Government acquires it later at circle rate — you lose the price premium entirely.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.12s"><div class="pv-risk-icon">🛕</div><div><div class="pv-risk-title">Religious Trust Land Fraud</div><p class="pv-risk-text">Mahant, Akhara, or temple trust land sold as private property. Any such sale is legally void — a court can reverse it at any point leaving you with nothing.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.18s"><div class="pv-risk-icon">📄</div><div><div class="pv-risk-title">Fabricated Title Chains</div><p class="pv-risk-text">With prices tripling in 18 months, fraudsters are creating fake ownership histories to flip plots. Only a manual Sub-Registrar check can detect a fabricated chain deed.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.24s"><div class="pv-risk-icon">🌊</div><div><div class="pv-risk-title">Flood Zone / No-Build Land</div><p class="pv-risk-text">Land in the Saryu flood plain sold without disclosing the permanent construction restriction. Buyers discover it only when ADA issues a demolition or stop-work notice.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.30s"><div class="pv-risk-icon">🚫</div><div><div class="pv-risk-title">Hidden Mortgages</div><p class="pv-risk-text">With values rising fast, sellers are taking bank loans against properties and selling to multiple buyers simultaneously. A 30-year encumbrance certificate is the only defence.</p></div></div>
        </div>

        <div class="pv-risk-banner pv-rv">
            <div class="pv-risk-banner-icon">❗</div>
            <div>
                <div class="pv-risk-banner-title">The Real Cost of Skipping Verification in Ayodhya</div>
                <div class="pv-risk-banner-text">Entire investment lost to government acquisition · Legal fees of ₹5–10 lakh fighting a fraudulent deed · Property in flood zone demolished without compensation · Religious trust claim reverses sale years later · NRI buyers especially at risk without local representation</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ PROCESS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Simple Process</span>
        <h2 class="pv-stitle pv-rv">How to Hire DSD for Ayodhya Property Verification — 5 Steps</h2>
        <p class="pv-ssub pv-rv">From first WhatsApp message to PDF report. Fully remote — you don't need to visit Ayodhya.</p>

        <div class="pv-steps">
            <div class="pv-step pv-rv"><div class="pv-step__num">1</div><div><h3>WhatsApp Free Preliminary Check</h3><p>Send the property address and seller's name on WhatsApp. We do a free preliminary IGRSUP + ADA check within 2 hours and tell you honestly if a full verification is worth doing.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.06s"><div class="pv-step__num">2</div><div><h3>Share Available Documents</h3><p>ADA approval letter, sale deed, Khatauni, RERA number — whatever you have. Even just the property address and seller's name is enough to start.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.12s"><div class="pv-step__num">3</div><div><h3>Pay Verification Fee</h3><p>₹5,000 for residential plots and flats, ₹7,000 for commercial, ₹10,000 for premium with site visit. UPI or bank transfer. Invoice issued.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.18s"><div class="pv-step__num">4</div><div><h3>We Verify at Source in Ayodhya</h3><p>Our team physically checks ADA records, Sub-Registrar, Tehsil, court records, acquisition zone status, and religious trust classification — nothing is relied on from online portals alone.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.24s"><div class="pv-step__num">5</div><div><h3>Detailed PDF Report in 48 Hours</h3><p>Every check performed, all red flags documented, and a clear final verdict: <strong>"Safe to Buy"</strong> or <strong>"Do Not Proceed."</strong> Delivered in 48 hours.</p></div></div>
        </div>
    </div>
</section>

{{-- ═══════════ REPORT PREVIEW (with SAMPLE watermark, fictitious address) ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What You Get</span>
        <h2 class="pv-stitle pv-rv">Inside the ₹5,000 PDF Verification Report</h2>
        <p class="pv-ssub pv-rv">A sample of what every Ayodhya buyer receives — clear, evidence-backed documentation you can present if a dispute arises.</p>

        <div class="pv-report pv-rv">
            <div class="pv-report__header">
                <div>
                    <h3 class="pv-report__title">Property Verification Report — Sample</h3>
                    <p class="pv-report__subtitle">Plot XX/XX, Sample Locality, Ayodhya · Sample dated · Illustrative only</p>
                </div>
                <span class="pv-report__verdict">✓ SAFE TO BUY</span>
            </div>
            <div class="pv-report__body">
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>ADA Layout Approval</strong>Genuine ADA layout map confirmed at ADA office. Layout number matches master approval register — not forged.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Government Acquisition Zone</strong>Property is outside all notified acquisition zones and Ram Mandir master plan corridors.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Registry & 30-Year Title Chain</strong>Unbroken chain from original owner to current seller. No fabricated links found at Sub-Registrar.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Encumbrance Certificate</strong>No bank loans, mortgages or legal claims registered in the last 30 years.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Mahant / Trust Land Check</strong>No religious trust classification. Property is confirmed private freehold land.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Saryu Flood Zone</strong>Property is outside the Saryu flood plain restriction zone. Construction permitted.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Mutation (Dakhil Kharij)</strong>Current seller's name confirmed in Tehsil revenue records.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Court Case Search</strong>No active litigation at Faizabad District Court or Allahabad High Court.</div></div>
            </div>
            <div class="pv-report__footer">PDF report includes evidence from ADA office, Sub-Registrar, Collector, Tehsil and court records · Delivered in 48 hours</div>
        </div>
    </div>
</section>

{{-- ═══════════ PRICING ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)" id="pricing">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Transparent Pricing</span>
        <h2 class="pv-stitle pv-rv">Property Verification Cost in Ayodhya</h2>
        <p class="pv-ssub pv-rv">Fixed fee. No per-document charges. No hidden costs. Invoice issued after payment.</p>

        <div class="pv-pricing-grid">
            <div class="pv-price-card pv-rv">
                <div class="pv-price-tag">RESIDENTIAL</div>
                <div class="pv-price-name">Standard</div>
                <div class="pv-price-amount">₹5,000</div>
                <div class="pv-price-desc">Plots, flats & independent houses</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> ADA layout approval check</li>
                    <li><span class="pv-price-check">✓</span> 30-year title chain</li>
                    <li><span class="pv-price-check">✓</span> Encumbrance certificate</li>
                    <li><span class="pv-price-check">✓</span> Acquisition zone status</li>
                    <li><span class="pv-price-check">✓</span> Mahant / trust land check</li>
                    <li><span class="pv-price-check">✓</span> Court case search</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B95%2C000%20Standard%20property%20verification%20in%20Ayodhya.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-rv">
                <div class="pv-price-tag">COMMERCIAL</div>
                <div class="pv-price-name">Commercial</div>
                <div class="pv-price-amount">₹7,000</div>
                <div class="pv-price-desc">Shops, hotels, offices & mixed-use</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Standard</li>
                    <li><span class="pv-price-check">✓</span> ADA commercial zoning check</li>
                    <li><span class="pv-price-check">✓</span> RERA verification</li>
                    <li><span class="pv-price-check">✓</span> Land use zoning report</li>
                    <li><span class="pv-price-check">✓</span> NOC & tourism zone check</li>
                    <li><span class="pv-price-check">✓</span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B97%2C000%20Commercial%20property%20verification%20in%20Ayodhya.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-price-card--featured pv-rv" style="--rd:.16s">
                <div class="pv-price-badge">⭐ BEST FOR NRIS</div>
                <div class="pv-price-tag">PREMIUM</div>
                <div class="pv-price-name">Premium + Site Visit</div>
                <div class="pv-price-amount">₹10,000</div>
                <div class="pv-price-desc">Full verification with physical inspection</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Commercial</li>
                    <li><span class="pv-price-check">✓</span> Physical site visit</li>
                    <li><span class="pv-price-check">✓</span> Boundary & possession check</li>
                    <li><span class="pv-price-check">✓</span> Photo & video evidence</li>
                    <li><span class="pv-price-check">✓</span> Proximity to restricted zone</li>
                    <li><span class="pv-price-check">✓</span> Report in 3–5 days</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B910%2C000%20Premium%20property%20verification%20with%20site%20visit%20in%20Ayodhya.%20Property%20address%3A" class="pv-price-btn pv-price-btn--white">Book on WhatsApp →</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ SERVICE AREAS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Service Coverage</span>
        <h2 class="pv-stitle pv-rv">Areas We Cover in Ayodhya</h2>
        <p class="pv-ssub pv-rv">We verify property across all of Ayodhya district and surrounding areas. No extra charge for any location.</p>

        <div class="pv-area-grid pv-rv">
            <div class="pv-area-pill">Ram Mandir Corridor</div>
            <div class="pv-area-pill">Naya Ghat</div>
            <div class="pv-area-pill">Saket Colony</div>
            <div class="pv-area-pill">Ram Path</div>
            <div class="pv-area-pill">Faizabad</div>
            <div class="pv-area-pill">Bikapur</div>
            <div class="pv-area-pill">Sohawal</div>
            <div class="pv-area-pill">Milkipur</div>
            <div class="pv-area-pill">Rudauli</div>
            <div class="pv-area-pill">Tanda</div>
            <div class="pv-area-pill">Mavaiya</div>
            <div class="pv-area-pill">Darshan Nagar</div>
            <div class="pv-area-pill">Sugriv Kila</div>
            <div class="pv-area-pill">Ring Road Area</div>
            <div class="pv-area-pill">Airport Zone</div>
            <div class="pv-area-pill">Saryu Bank Area</div>
        </div>

        <div style="text-align:center; margin-top:28px; font-size:.84rem; color:var(--pv-t2);">
            Don't see your area? <a href="https://wa.me/918595002933" style="color:var(--pv-teal); font-weight:600;">WhatsApp us</a> — we cover all of Ayodhya district.
        </div>
    </div>
</section>

{{-- ═══════════ FAQ (Rendered from same $faqs used in JSON-LD) ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">FAQ</span>
        <h2 class="pv-stitle pv-rv">Property Verification in Ayodhya — Common Questions</h2>

        <div style="max-width:820px; margin:0 auto; display:flex; flex-direction:column; gap:12px;">
            @foreach($faqs as $faq)
            <details class="pv-faq-item pv-rv">
                <summary class="pv-faq-q">
                    {{ $faq[0] }}
                    <span class="arrow-icon">▼</span>
                </summary>
                <div class="pv-faq-a">
                    {{ $faq[1] }}
                </div>
            </details>
            @endforeach
        </div>

        {{-- Legal disclaimer --}}
        <div class="pv-disclaimer pv-rv">
            <strong>Disclaimer:</strong> Verification reports are prepared based on records available at the time of check and do not constitute legal advice. For litigation, title transfer, or formal court proceedings, please consult a qualified property advocate.
        </div>
    </div>
</section>

{{-- ═══════════ CTA (LEAD MAGNET) — brand navy gradient ═══════════ --}}
<section class="pv-cta">
    <div class="pv-cta__orb"></div>
    <div class="pv-container pv-cta__inner">
        <h2>Don't Speculate. Get a Free Preliminary Check in 2 Hours.</h2>
        <p>Unsure if the property documents you hold are real or fabricated? Don't pay us yet. Just drop the property location micro-market (e.g., Near Airport Zone, Bypass, Naya Ghat) and the seller's name on our WhatsApp. Our team will perform an initial high-level registry scan completely free of charge. If we find immediate red flags, you save your money instantly.</p>
        <div class="pv-cta__btns">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20a%20free%20preliminary%20property%20check%20in%20Ayodhya.%20Here%20are%20the%20details%3A" class="pv-btn pv-btn--whatsapp">
                💬 Get My Free Preliminary Check on WhatsApp
            </a>
        </div>
        <p style="margin-top:18px; font-size:.8rem; color:rgba(255,255,255,.5);">
            Also serving:
            <a href="/services/property-verification-lucknow" style="color:rgba(255,255,255,.65);text-decoration:underline;">Lucknow</a> ·
            <a href="/services/property-verification-varanasi" style="color:rgba(255,255,255,.65);text-decoration:underline;">Varanasi</a>
        </p>
    </div>
</section>

</div>{{-- .pv-wrap --}}

<div class="pv-mobile-cta" id="pvMobileCta">
    <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20property%20verification%20in%20Ayodhya" class="whatsapp">WhatsApp</a>
    <a href="#pricing" class="book">₹5,000 →</a>
</div>

<script>
// Respect reduced-motion preference for reveal-on-scroll
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (prefersReducedMotion) {
    document.querySelectorAll('.pv-rv').forEach(el => el.classList.add('visible'));
} else {
    const pvObserver = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); pvObserver.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.pv-rv').forEach(el => pvObserver.observe(el));
}

// Optimized scroll handler for sticky mobile CTA
let ticking = false;
window.addEventListener('scroll', () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            document.getElementById('pvMobileCta').classList.toggle('show', window.scrollY > 400);
            ticking = false;
        });
        ticking = true;
    }
}, { passive: true });
</script>

@endsection