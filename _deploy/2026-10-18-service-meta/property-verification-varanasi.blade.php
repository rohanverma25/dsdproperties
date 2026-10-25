@extends('layouts.user-app')

{{-- ═══════════════════════════════════════════════════════════════════
     SINGLE SOURCE OF TRUTH FOR FAQ CONTENT
     Both the visible FAQ accordion and the JSON-LD FAQPage schema
     are generated from this array — they can never drift.
     ═══════════════════════════════════════════════════════════════════ --}}
@php
$faqs = [
    [
        "How much does it cost to hire a property verifier in Varanasi?",
        "Property verification in Varanasi starts at ₹5,000 for residential plots and flats, ₹7,000 for commercial properties, and ₹10,000 for the premium package with a physical site visit. All packages include a PDF report within 48 hours. No hidden fees."
    ],
    [
        "Why is property verification especially important in Varanasi?",
        "Varanasi has unique land complexities — centuries-old temple trust (Devasthan) land sold fraudulently, Ganga flood plain restrictions, dense mohalla layouts with disputed boundaries, and ancestral haveli disputes with multiple co-heirs. These risks are invisible on online portals and only surface at the Tehsil and Sub-Registrar offices."
    ],
    [
        "Can NRIs hire DSD Properties for Varanasi property verification from abroad?",
        "Yes. Many NRIs buying ancestral property in Varanasi use our service. You WhatsApp documents from anywhere in the world, we physically verify on the ground in Varanasi, and deliver the PDF report. The ₹10,000 premium package adds a site visit with photos and video."
    ],
    [
        "What is Devasthan land and why is it risky?",
        "Devasthan land is registered under temple trusts — some of it centuries old. It cannot be legally sold or purchased by private parties. Fraudulent sellers present fabricated documents for such land. Our Tehsil-level search explicitly checks for Devasthan classification before you proceed."
    ],
    [
        "How long does property verification take in Varanasi?",
        "Standard verification takes 48 hours from document receipt. The ₹10,000 premium package with physical site visit takes 3-5 days."
    ],
    [
        "What documents do I need to share for Varanasi property verification?",
        "The property address and seller's full name are enough to start. If you have documents — sale deed, Khatauni, RERA number — share them on WhatsApp. We do a free preliminary check before you commit to the ₹5,000 full verification."
    ],
    [
        "Do you cover areas outside central Varanasi?",
        "Yes. We cover all of Varanasi district including Sarnath, Lanka, Sigra, Bhelupur, Shivpur, Ramnagar, Babatpur, Pindra, Rajatalab, Chiraigaon and surrounding tehsils. No extra charge for distance."
    ],
    [
        "What happens if you find problems with my Varanasi property?",
        "If we find red flags — disputed title, temple land, Ganga zone restriction, pending litigation, hidden mortgage — we document everything in the PDF report with evidence. You can show this to the seller, negotiate, walk away, or take it to a property lawyer for further action."
    ],
];
@endphp

@section('title', 'Property Verification Service Varanasi — Hire Registry & Plot Verifier ₹5,000 | DSD')

@section('meta_description', 'Hire a professional property verifier in Varanasi. We check Sub-Registrar, encumbrance, Khatauni, court records & RERA at source. PDF report in 48 hours. ₹5,000 fixed fee.')

@section('meta_keywords', 'property verification service varanasi, property verifier varanasi, property verification cost varanasi, plot verification service varanasi, property document check varanasi banaras')

@section('canonical', 'https://dsdproperties.in/services/property-verification-varanasi')

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
  "areaServed": { "@type": "City", "name": "Varanasi" },
  "sameAs": ["https://wa.me/918595002933"]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Property Verification Service",
  "name": "Professional Property Verification Service in Varanasi",
  "description": "Hire an independent property verifier in Varanasi. We physically check sale deed, registry, encumbrance certificate, court cases, Dakhil Kharij (mutation) and RERA approval at Sub-Registrar, Tehsil and district court records. PDF report delivered in 48 hours.",
  "provider": { "@id": "https://dsdproperties.in/#organization" },
  "areaServed": {
    "@type": "City",
    "name": "Varanasi",
    "containedInPlace": { "@type": "State", "name": "Uttar Pradesh" }
  },
  "serviceArea": {
    "@type": "GeoCircle",
    "geoMidpoint": {
      "@type": "GeoCoordinates",
      "latitude": 25.3176,
      "longitude": 82.9739
    },
    "geoRadius": 30000
  },
  "offers": [
    { "@type": "Offer", "name": "Residential Plot / Flat Verification", "price": "5000", "priceCurrency": "INR", "description": "Sale deed, title chain, encumbrance, mutation and court record check. PDF report in 48 hours." },
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
    { "@type": "ListItem", "position": 3, "name": "Property Verification Service Varanasi", "item": "https://dsdproperties.in/services/property-verification-varanasi" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "How to Get Property Verified in Varanasi",
  "description": "Hire DSD Properties for independent property verification in Varanasi. Physical checks at Sub-Registrar, Tehsil, and courts. PDF report in 48 hours at ₹5,000.",
  "totalTime": "PT48H",
  "estimatedCost": { "@type": "MonetaryAmount", "currency": "INR", "value": "5000" },
  "step": [
    { "@type": "HowToStep", "position": 1, "name": "WhatsApp Free Preliminary Check", "text": "Send the property address and seller's name on WhatsApp to +91-8595002933. We do a free preliminary check within 2 hours and tell you honestly if a full verification is worth doing.", "url": "https://dsdproperties.in/services/property-verification-varanasi" },
    { "@type": "HowToStep", "position": 2, "name": "Share Available Documents", "text": "Share sale deed, registry copy, Khatauni, RERA number — whatever you have. Even just the property address is enough to start.", "url": "https://dsdproperties.in/services/property-verification-varanasi" },
    { "@type": "HowToStep", "position": 3, "name": "Pay ₹5,000 Verification Fee", "text": "Pay ₹5,000 for residential plots and flats, ₹7,000 for commercial, or ₹10,000 for the premium package with site visit. UPI or bank transfer. Invoice issued.", "url": "https://dsdproperties.in/services/property-verification-varanasi" },
    { "@type": "HowToStep", "position": 4, "name": "We Verify at Source in Varanasi", "text": "Our team physically checks documents at Sub-Registrar, Tehsil (including Devasthan land and temple trust classification), Varanasi District Court, and the Allahabad HC Lucknow Bench — not just online portals.", "url": "https://dsdproperties.in/services/property-verification-varanasi" },
    { "@type": "HowToStep", "position": 5, "name": "Receive Detailed PDF Report in 48 Hours", "text": "A clear PDF report with every check performed, any red flags found, and a final verdict: Safe to Buy or Do Not Proceed. Delivered within 48 hours.", "url": "https://dsdproperties.in/services/property-verification-varanasi" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Property Verification Service Varanasi — Hire Registry & Plot Verifier ₹5,000",
  "url": "https://dsdproperties.in/services/property-verification-varanasi",
  "description": "Hire a professional property verifier in Varanasi. We check Sub-Registrar, encumbrance, Khatauni, court records and RERA at source. PDF report in 48 hours. ₹5,000 fixed fee.",
  "speakable": { "@type": "SpeakableSpecification", "cssSelector": [".pv-hero__sub", ".pv-ssub", ".pv-step p", ".pv-faq-a"] },
  "about": {
    "@type": "Service",
    "name": "Property Verification Service Varanasi",
    "description": "Independent physical verification of property documents in Varanasi including Sub-Registrar records, encumbrance, Khatauni, Devasthan land, court records and RERA. PDF report in 48 hours at ₹5,000.",
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

/* ═══════════ HERO — Brand navy gradient (was brown) ═══════════ */
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
.pv-hero__card-btn:hover { transform: translateY(-1px); color:#fff; text-decoration:none; box-shadow: 0 8px 22px rgba(37,211,102,.4); }
.pv-hero__card-note { margin-top: 12px; font-size: .72rem; color: var(--pv-t3); text-align: center; line-height: 1.5; }

.pv-hero__wave { position: absolute; bottom: 0; left: 0; right: 0; line-height: 0; }
.pv-hero__wave svg { width: 100%; height: 56px; display: block; }

.pv-metrics { background: var(--pv-card); border-bottom: 1px solid var(--pv-border); padding: 26px 0; }
.pv-metrics__grid { display:grid; grid-template-columns: repeat(4, 1fr); gap: 16px; text-align: center; }
@media(max-width:680px){ .pv-metrics__grid { grid-template-columns: repeat(2, 1fr); gap: 22px; } }
.pv-metric__num { font-size: 1.6rem; font-weight: 900; color: var(--pv-navy); line-height: 1; margin-bottom: 6px; }
.pv-metric__num span { color: var(--pv-orange); }
.pv-metric__label { font-size: .72rem; color: var(--pv-t2); text-transform: uppercase; letter-spacing: 1.2px; font-weight: 600; }

.pv-local-box { background: linear-gradient(135deg, #fff8f0, #fff1e0); border: 1.5px solid rgba(255,92,0,.2); border-radius: 16px; padding: 28px 30px; max-width: 920px; margin: 0 auto 40px; }
.pv-local-box h3 { font-size: 1.05rem; font-weight: 800; color: var(--pv-navy); margin-bottom: 12px; }
.pv-local-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px; }
.pv-local-item { display: flex; gap: 10px; align-items: flex-start; background: #fff; border-radius: 10px; padding: 13px 14px; border: 1px solid rgba(255,92,0,.15); }
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
/* Featured card now uses brand navy gradient (was solid orange) */
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

/* ═══════════ CTA — Brand navy gradient (was brown) ═══════════ */
.pv-cta { background: var(--pv-brand-gradient); padding: 70px 0; position: relative; overflow: hidden; }
.pv-cta__orb { position: absolute; border-radius: 50%; filter: blur(80px); width: 400px; height: 400px; background: rgba(0,128,128,.18); top: -100px; right: -80px; animation: pv-float 10s ease-in-out infinite; }
.pv-cta__inner { position: relative; z-index: 2; text-align: center; }
.pv-cta h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color:#fff; margin-bottom: 12px; }
.pv-cta p  { font-size: .92rem; color: rgba(255,255,255,.78); max-width: 580px; margin: 0 auto 30px; line-height: 1.7; }
.pv-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

/* ═══════════ FAQ — Native <details> (was custom JS accordion) ═══════════ */
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
@media(max-width:480px){ .pv-hero__cta { flex-direction: column; } .pv-risk-banner { flex-direction: column; gap: 10px; } }

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
                <li style="color:#fff; font-weight:500;">Property Verification Varanasi</li>
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
                Varanasi's Independent Property Verifier
            </div>

            <h1 class="pv-hero__h1">
                Professional Property<br>
                Verification Service in<br>
                Varanasi — <em>₹5,000</em>.
            </h1>

            <p class="pv-hero__sub">
                Buying property in Banaras? Don't pay ₹50 lakhs without spending ₹5,000 on independent verification. We physically check registry, encumbrance, Khatauni, court records and RERA — at source. <strong style="color:#fff;">PDF report in 48 hours.</strong>
            </p>

            <div class="pv-hero__cta">
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20you%20for%20property%20verification%20in%20Varanasi.%20Property%20address%3A" class="pv-btn pv-btn--whatsapp">
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
                    Independent · No Bias
                </div>
                <div class="pv-pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    NRI Verification
                </div>
            </div>
        </div>

        <div class="pv-hero__card">
            <div class="pv-hero__card-tag">RESIDENTIAL PLOT / FLAT — VARANASI</div>
            <div class="pv-hero__card-title">Hire a Varanasi Property Verifier</div>
            <div class="pv-hero__card-sub">Trained verifier physically checks documents at Sub-Registrar, Tehsil and district court records in Varanasi. Detailed PDF report in 48 hours.</div>

            <div class="pv-hero__card-price">
                <span class="pv-hero__card-price-amt">₹5,000</span>
                <span class="pv-hero__card-price-lbl">all-inclusive · no hidden fees</span>
            </div>

            <ul class="pv-hero__card-list">
                <li>Registry & 30-year sale deed title chain</li>
                <li>Encumbrance certificate (Sub-Registrar)</li>
                <li>Khatauni & Dakhil Kharij (mutation)</li>
                <li>Court case search — Varanasi District Court</li>
                <li>Final verdict: Safe to Buy or Walk Away</li>
            </ul>

            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20book%20the%20%E2%82%B95%2C000%20property%20verification%20in%20Varanasi.%20Property%20address%3A" class="pv-hero__card-btn">Book ₹5,000 Verification on WhatsApp</a>
            <div class="pv-hero__card-note">🔒 100% confidential · Free preliminary check first</div>
        </div>
    </div>

    <div class="pv-hero__wave">
        <svg viewBox="0 0 1440 56" preserveAspectRatio="none">
            <path d="M0,28 C480,56 960,0 1440,28 L1440,56 L0,56 Z" fill="var(--bg-primary,#fff)"/>
        </svg>
    </div>
</section>

{{-- ═══════════ METRIC STRIP ═══════════ --}}
<section class="pv-metrics">
    <div class="pv-container">
        <div class="pv-metrics__grid">
            <div><div class="pv-metric__num">5<span>+</span></div><div class="pv-metric__label">Government Offices Checked</div></div>
            <div><div class="pv-metric__num">30 yr</div><div class="pv-metric__label">Title Chain Traced</div></div>
            <div><div class="pv-metric__num">48 hr</div><div class="pv-metric__label">PDF Report Delivery</div></div>
            <div><div class="pv-metric__num">₹5K</div><div class="pv-metric__label">vs ₹50L At Risk</div></div>
        </div>
    </div>
</section>

{{-- ═══════════ VARANASI-SPECIFIC RISKS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Varanasi-Specific</span>
        <h2 class="pv-stitle pv-rv">Why Varanasi Property Needs Extra Caution</h2>
        <p class="pv-ssub pv-rv">Varanasi has land complexities that don't exist anywhere else in UP. These local risks are invisible on IGRSUP or standard online portals — they only surface at the Tehsil and Sub-Registrar offices.</p>

        <div class="pv-local-box pv-rv">
            <h3>🏛️ Varanasi-Specific Land Risks We Check Explicitly</h3>
            <div class="pv-local-grid">
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🛕</div>
                    <div>
                        <div class="pv-local-item-title">Devasthan / Temple Trust Land</div>
                        <div class="pv-local-item-text">Centuries-old temple trust land sold without proper title. Common in the old city, Lanka, and Assi areas.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🌊</div>
                    <div>
                        <div class="pv-local-item-title">Ganga Flood Plain Restrictions</div>
                        <div class="pv-local-item-text">Land within the Ganga flood zone has construction bans. Buyers often don't know until after purchase.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">👨‍👩‍👧‍👦</div>
                    <div>
                        <div class="pv-local-item-title">Ancestral Haveli Disputes</div>
                        <div class="pv-local-item-text">Old havelis with multiple co-heirs — one heir selling without others' consent is a leading fraud pattern in Banaras.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🏘️</div>
                    <div>
                        <div class="pv-local-item-title">Mohalla Boundary Disputes</div>
                        <div class="pv-local-item-text">Dense mohalla layouts in Sigra, Shivpur, and Bhelupur where plot boundaries overlap with neighbours or public lanes.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">📋</div>
                    <div>
                        <div class="pv-local-item-title">Waqf Board Land</div>
                        <div class="pv-local-item-text">Waqf-registered land being sold as private property. Only a Tehsil-level search can confirm the correct classification.</div>
                    </div>
                </div>
                <div class="pv-local-item">
                    <div class="pv-local-item-icon">🛣️</div>
                    <div>
                        <div class="pv-local-item-title">Varanasi Ring Road & Development Disputes</div>
                        <div class="pv-local-item-text">Land acquisition notices for the Ring Road and VDA development corridors that sellers don't always disclose.</div>
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
        <p class="pv-ssub pv-rv">You can check documents yourself. Here's an honest look at what you actually get — and what you miss — without a professional verifier in Varanasi.</p>

        <div class="pv-diy-table pv-rv">
            <div class="pv-diy-head">
                <div>What You Check</div>
                <div>Doing It Yourself</div>
                <div>Hiring DSD Properties</div>
            </div>
            <div class="pv-diy-row">
                <div>Time required</div>
                <div class="pv-diy-bad">2–3 weekends, multiple office visits</div>
                <div class="pv-diy-good">48 hours, hands-off</div>
            </div>
            <div class="pv-diy-row">
                <div>Cost</div>
                <div>Free (your time + travel + fees)</div>
                <div class="pv-diy-good">₹5,000 fixed</div>
            </div>
            <div class="pv-diy-row">
                <div>Sub-Registrar encumbrance</div>
                <div class="pv-diy-bad">Hard to extract 30-year chain</div>
                <div class="pv-diy-good">30-year certificate extracted manually</div>
            </div>
            <div class="pv-diy-row">
                <div>Tehsil Khatauni & mutation</div>
                <div class="pv-diy-bad">Most buyers skip this entirely</div>
                <div class="pv-diy-good">Physically verified at Tehsil</div>
            </div>
            <div class="pv-diy-row">
                <div>Temple trust / Devasthan check</div>
                <div class="pv-diy-bad">Not available online at all</div>
                <div class="pv-diy-good">Checked at Tehsil records</div>
            </div>
            <div class="pv-diy-row">
                <div>Court case search</div>
                <div class="pv-diy-bad">Difficult without legal access</div>
                <div class="pv-diy-good">Varanasi District Court checked</div>
            </div>
            <div class="pv-diy-row">
                <div>Written record if dispute arises</div>
                <div class="pv-diy-bad">None — verbal only</div>
                <div class="pv-diy-good">Detailed PDF documentation you can present</div>
            </div>
        </div>

        <div style="max-width:780px; margin:28px auto 0; padding:18px 22px; background:#f0f9f9; border:1px solid rgba(0,128,128,.2); border-radius:12px; font-size:.86rem; line-height:1.75; color:var(--pv-t2);">
            <strong style="color:var(--pv-t1);">Honest take:</strong> Varanasi's land records are among the most complex in UP. Ancestral disputes, temple land, and Ganga zone restrictions are invisible online. A professional with local knowledge is not a luxury here — it's the cheapest due-diligence you can do.
        </div>

        <div style="text-align:center; margin-top:28px;">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20a%20property%20verifier%20in%20Varanasi" class="pv-btn pv-btn--primary">Hire Us — Book Verification →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHAT WE CHECK ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What's Included</span>
        <h2 class="pv-stitle pv-rv">What We Check in Varanasi — For You</h2>
        <p class="pv-ssub pv-rv">Every verification includes physical document checks across Sub-Registrar, Tehsil, and court records in Varanasi. You don't visit any of them. We do it, we document it, we hand you a PDF.</p>

        <div class="pv-check-grid">
            <div class="pv-check-card pv-rv">
                <div class="pv-check-card__icon">📄</div>
                <div>
                    <div class="pv-check-card__title">Registry & 30-Year Title Chain</div>
                    <p class="pv-check-card__text">Sale deed verified at Varanasi Sub-Registrar and cross-referenced on the IGRSUP portal. We trace ownership back 30 years — the #1 cause of property disputes in Varanasi is a broken title chain in ancestral properties.</p>
                    <div class="pv-check-card__where">Sub-Registrar Office, Varanasi + IGRSUP portal</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">📜</div>
                <div>
                    <div class="pv-check-card__title">Encumbrance Certificate (Bhar Mukt Praman Patra)</div>
                    <p class="pv-check-card__text">A 30-year encumbrance certificate extracted at the Sub-Registrar office reveals any hidden bank loans, mortgages, or registered legal claims against the property — invisible without this check. Critical for old havelis.</p>
                    <div class="pv-check-card__where">Sub-Registrar Office, Varanasi (extracted manually)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.12s">
                <div class="pv-check-card__icon">🗺️</div>
                <div>
                    <div class="pv-check-card__title">Khatauni, Khasra & Mutation</div>
                    <p class="pv-check-card__text">Revenue records cross-checked at the relevant Tehsil. We confirm Dakhil Kharij (mutation) is done in the current seller's name. In Varanasi's dense mohallas, this check also confirms actual plot boundaries.</p>
                    <div class="pv-check-card__where">Tehsil (Varanasi Sadar / Pindra / Rajatalab / Chiraigaon)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.18s">
                <div class="pv-check-card__icon">⚖️</div>
                <div>
                    <div class="pv-check-card__title">Court Case Search</div>
                    <p class="pv-check-card__text">Pending litigation, partition suits and family disputes checked at Varanasi District Court and Allahabad High Court. Sellers in ancestral property disputes rarely disclose active cases — we find them.</p>
                    <div class="pv-check-card__where">Varanasi District Court + Allahabad High Court records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">🏗️</div>
                <div>
                    <div class="pv-check-card__title">VDA / RERA Registration</div>
                    <p class="pv-check-card__text">For builder projects in Varanasi, we verify VDA approval and RERA registration on the official UP-RERA portal — including complaint history and completion timeline. A hoarding RERA number alone is not proof.</p>
                    <div class="pv-check-card__where">VDA Office + UP-RERA portal (up-rera.in)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.10s">
                <div class="pv-check-card__icon">🛕</div>
                <div>
                    <div class="pv-check-card__title">Temple Trust & Waqf Land Check</div>
                    <p class="pv-check-card__text">Varanasi-specific check for Devasthan (temple trust) classification and Waqf Board registration. Land under these categories cannot be sold privately — a fraudulent sale is void from the beginning and puts your entire investment at risk.</p>
                    <div class="pv-check-card__where">Tehsil Revenue Records + Collector Office</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.16s">
                <div class="pv-check-card__icon">📑</div>
                <div>
                    <div class="pv-check-card__title">Chain Deed & Moina (Inspection)</div>
                    <p class="pv-check-card__text">We conduct a manual Moina (inspection of index registers) at the Sub-Registrar office to pull the complete physical ownership history. Every link in the Chain Deed — from original owner to current seller — verified to be legally executed, stamped, and registered.</p>
                    <div class="pv-check-card__where">Sub-Registrar Office Records (Manual Index Search)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.22s">
                <div class="pv-check-card__icon">🌊</div>
                <div>
                    <div class="pv-check-card__title">Ganga Flood Zone & Land Use Check</div>
                    <p class="pv-check-card__text">We verify whether the property falls in the Ganga Flood Plain Zone, where construction is restricted or prohibited. We also check VDA land use zoning to confirm the property can be used for its intended purpose — residential or commercial.</p>
                    <div class="pv-check-card__where">VDA Zoning Records + Revenue Department</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.28s">
                <div class="pv-check-card__icon">⚔️</div>
                <div>
                    <div class="pv-check-card__title">Wad-Vivad Search (Litigation Free)</div>
                    <p class="pv-check-card__text">Comprehensive search against the property's Khasra and Gata numbers across revenue courts to confirm it is free of Wad-Vivad (active litigation). We scan for stay orders, family partition suits, and ceiling disputes that do not appear on standard registry portals.</p>
                    <div class="pv-check-card__where">Board of Revenue, Commissioner Court, Varanasi Revenue Courts</div>
                </div>
            </div>
        </div>

        <div style="margin-top:32px; text-align:center;">
            <p style="font-size:.86rem; color:var(--pv-t2); max-width:660px; margin:0 auto 18px; line-height:1.7;">Every check above requires physical presence and local expertise. We do it all for you in 48 hours.</p>
            <a href="#pricing" class="pv-btn pv-btn--primary">See ₹5,000 Pricing →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHY IT MATTERS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Why It Matters</span>
        <h2 class="pv-stitle pv-rv">Why ₹5,000 Verification Saves You ₹50 Lakhs in Varanasi</h2>
        <p class="pv-ssub pv-rv">Property fraud in Varanasi follows six distinct patterns. A professional verification catches all six — before you pay token money, not after.</p>

        <div class="pv-risk-grid">
            <div class="pv-risk-card pv-rv"><div class="pv-risk-icon">🛕</div><div><div class="pv-risk-title">Temple / Trust Land Fraud</div><p class="pv-risk-text">Devasthan or Waqf-registered land sold as private property. Sale is legally void — your entire investment is lost and unrecoverable.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.06s"><div class="pv-risk-icon">👨‍👩‍👧‍👦</div><div><div class="pv-risk-title">Ancestral Property Heir Disputes</div><p class="pv-risk-text">One co-heir selling without consent of siblings or family members. Common in old Banaras havelis. Leads to court cases lasting decades.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.12s"><div class="pv-risk-icon">⚖️</div><div><div class="pv-risk-title">Undisclosed Court Cases</div><p class="pv-risk-text">Active partition suits or property disputes the seller never disclosed. Once you sign, the case becomes your problem to fight for years.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.18s"><div class="pv-risk-icon">🌊</div><div><div class="pv-risk-title">Flood Zone / No-Construction Zone</div><p class="pv-risk-text">Property inside the Ganga flood zone where construction is banned. Buyers discover this only when VDA demolishes what they built.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.24s"><div class="pv-risk-icon">🚫</div><div><div class="pv-risk-title">Hidden Mortgages</div><p class="pv-risk-text">Bank loans or legal claims registered against the property — invisible without a 30-year encumbrance certificate from the Sub-Registrar.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.30s"><div class="pv-risk-icon">📄</div><div><div class="pv-risk-title">Fake Registry / Forged Sale Deeds</div><p class="pv-risk-text">Fabricated documents, especially in fast-developing areas like Sarnath corridor and Ramnagar. Only a physical Sub-Registrar check confirms authenticity.</p></div></div>
        </div>

        <div class="pv-risk-banner pv-rv">
            <div class="pv-risk-banner-icon">❗</div>
            <div>
                <div class="pv-risk-banner-title">The Real Cost of Skipping Verification in Varanasi</div>
                <div class="pv-risk-banner-text">₹5–10 lakh in legal fees · 5–15 years in court for ancestral disputes · Property becomes unsellable · Total investment at risk · NRI buyers particularly vulnerable from abroad</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ PROCESS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Simple Process</span>
        <h2 class="pv-stitle pv-rv">How to Hire DSD for Varanasi Property Verification — 5 Steps</h2>
        <p class="pv-ssub pv-rv">From first WhatsApp message to PDF report. Transparent at every step. You don't need to visit Varanasi — we handle everything on the ground.</p>

        <div class="pv-steps">
            <div class="pv-step pv-rv"><div class="pv-step__num">1</div><div><h3>WhatsApp Free Preliminary Check</h3><p>Send the property address and seller's name on WhatsApp. We do a free preliminary IGRSUP check within 2 hours and tell you honestly if a full verification is worth proceeding with.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.06s"><div class="pv-step__num">2</div><div><h3>Share Available Documents</h3><p>Sale deed, registry copy, Khatauni, RERA number — whatever you have. Even just the property address and seller's name is enough to start.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.12s"><div class="pv-step__num">3</div><div><h3>Pay Verification Fee</h3><p>₹5,000 for residential plots and flats, ₹7,000 for commercial, ₹10,000 for premium with site visit. UPI or bank transfer. Invoice issued.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.18s"><div class="pv-step__num">4</div><div><h3>We Verify at Source in Varanasi</h3><p>Our team physically checks documents at Sub-Registrar, Tehsil, VDA records, court records and checks for temple land / Waqf classification — not just online portals.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.24s"><div class="pv-step__num">5</div><div><h3>Detailed PDF Report in 48 Hours</h3><p>Every check performed, all red flags documented, and a clear final verdict: <strong>"Safe to Buy"</strong> or <strong>"Do Not Proceed."</strong> Delivered in 48 hours.</p></div></div>
        </div>
    </div>
</section>

{{-- ═══════════ REPORT PREVIEW (with SAMPLE watermark, fictitious address) ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What You Get</span>
        <h2 class="pv-stitle pv-rv">Inside the ₹5,000 PDF Verification Report</h2>
        <p class="pv-ssub pv-rv">A sample of what every Varanasi buyer receives — clear, evidence-backed documentation you can present if a dispute arises.</p>

        <div class="pv-report pv-rv">
            <div class="pv-report__header">
                <div>
                    <h3 class="pv-report__title">Property Verification Report — Sample</h3>
                    <p class="pv-report__subtitle">Plot XX/XX, Sample Locality, Varanasi · Sample dated · Illustrative only</p>
                </div>
                <span class="pv-report__verdict">✓ SAFE TO BUY</span>
            </div>
            <div class="pv-report__body">
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Registry & 30-Year Title Chain</strong>Unbroken chain from original owner to current seller. No forged links found at Sub-Registrar.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Encumbrance Certificate</strong>No bank loans, mortgages or legal claims registered in the last 30 years.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Mutation (Dakhil Kharij)</strong>Current seller's name confirmed in Tehsil revenue records.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Temple Trust / Waqf Check</strong>No Devasthan or Waqf Board classification. Property is private freehold land.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Court Case Search</strong>No active litigation at Varanasi District Court or Allahabad High Court.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Ganga Flood Zone</strong>Property is outside the Ganga flood plain restriction zone. Construction permitted.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>VDA Approval</strong>Layout approved by VDA. No illegal colony classification.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Wad-Vivad Revenue Search</strong>No active revenue court litigation found on this Khasra / Gata number.</div></div>
            </div>
            <div class="pv-report__footer">PDF report includes scanned evidence from Sub-Registrar, Tehsil, court and VDA records · Delivered in 48 hours</div>
        </div>
    </div>
</section>

{{-- ═══════════ PRICING ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)" id="pricing">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Transparent Pricing</span>
        <h2 class="pv-stitle pv-rv">Property Verification Cost in Varanasi</h2>
        <p class="pv-ssub pv-rv">Fixed fee. No per-document charges. No hidden costs. Invoice issued after payment.</p>

        <div class="pv-pricing-grid">
            <div class="pv-price-card pv-rv">
                <div class="pv-price-tag">RESIDENTIAL</div>
                <div class="pv-price-name">Standard</div>
                <div class="pv-price-amount">₹5,000</div>
                <div class="pv-price-desc">Plots, flats & independent houses</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> 30-year title chain</li>
                    <li><span class="pv-price-check">✓</span> Encumbrance certificate</li>
                    <li><span class="pv-price-check">✓</span> Khatauni & mutation</li>
                    <li><span class="pv-price-check">✓</span> Temple / Waqf land check</li>
                    <li><span class="pv-price-check">✓</span> Court case search</li>
                    <li><span class="pv-price-check">✓</span> Ganga flood zone check</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B95%2C000%20Standard%20property%20verification%20in%20Varanasi.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-price-card--featured pv-rv" style="--rd:.08s">
                <div class="pv-price-badge">⭐ MOST POPULAR</div>
                <div class="pv-price-tag">COMMERCIAL</div>
                <div class="pv-price-name">Commercial</div>
                <div class="pv-price-amount">₹7,000</div>
                <div class="pv-price-desc">Shops, offices & mixed-use properties</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Standard</li>
                    <li><span class="pv-price-check">✓</span> VDA commercial use check</li>
                    <li><span class="pv-price-check">✓</span> RERA verification</li>
                    <li><span class="pv-price-check">✓</span> Land use zoning report</li>
                    <li><span class="pv-price-check">✓</span> NOC status check</li>
                    <li><span class="pv-price-check">✓</span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B97%2C000%20Commercial%20property%20verification%20in%20Varanasi.%20Property%20address%3A" class="pv-price-btn pv-price-btn--white">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-rv" style="--rd:.16s">
                <div class="pv-price-tag">PREMIUM</div>
                <div class="pv-price-name">Premium + Site Visit</div>
                <div class="pv-price-amount">₹10,000</div>
                <div class="pv-price-desc">Full verification with physical site inspection</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Commercial</li>
                    <li><span class="pv-price-check">✓</span> Physical site visit</li>
                    <li><span class="pv-price-check">✓</span> Boundary & possession check</li>
                    <li><span class="pv-price-check">✓</span> Photo & video evidence</li>
                    <li><span class="pv-price-check">✓</span> Neighbour encroachment check</li>
                    <li><span class="pv-price-check">✓</span> Report in 3–5 days</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B910%2C000%20Premium%20property%20verification%20with%20site%20visit%20in%20Varanasi.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ SERVICE AREAS — Locality Explorer ═══════════ --}}
<style>
/* ── Top-20 locality cards ── */
.pv-top20-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:10px; margin-bottom:40px; }
.pv-top20-card { background:var(--pv-card); border:1.5px solid rgba(0,128,128,.18); border-radius:12px; padding:12px 14px; display:flex; flex-direction:column; gap:5px; transition:all .2s; }
.pv-top20-card:hover { border-color:var(--pv-teal); box-shadow:0 6px 18px rgba(0,128,128,.1); transform:translateY(-2px); }
.pv-top20-card__name { font-size:.84rem; font-weight:700; color:var(--pv-t1); }
.pv-top20-card__tag  { font-size:.68rem; font-weight:600; color:var(--pv-teal); text-transform:uppercase; letter-spacing:1px; }

/* ── Zone tabs ── */
.pv-zone-tabs { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:24px; }
.pv-zone-tab { padding:9px 20px; border-radius:10px; font-family:'Poppins',sans-serif; font-size:.82rem; font-weight:700; cursor:pointer; border:2px solid var(--pv-border); background:var(--pv-card); color:var(--pv-t2); transition:all .2s; }
.pv-zone-tab.active { background:var(--pv-brand-gradient); color:#fff; border-color:transparent; box-shadow:0 4px 14px rgba(1,31,75,.22); }
.pv-zone-tab:hover:not(.active) { border-color:var(--pv-teal); color:var(--pv-teal); }

.pv-zone-panel { display:none; }
.pv-zone-panel.active { display:block; }

.pv-zone-header { display:flex; align-items:baseline; gap:12px; margin-bottom:16px; flex-wrap:wrap; }
.pv-zone-header h3 { font-size:1.05rem; font-weight:800; color:var(--pv-navy); margin:0; }
.pv-zone-count { font-size:.76rem; font-weight:600; color:var(--pv-teal); background:rgba(0,128,128,.08); border:1px solid rgba(0,128,128,.2); padding:3px 10px; border-radius:99px; }

.pv-zone-pills { display:flex; flex-wrap:wrap; gap:8px; }
.pv-zone-pill { padding:6px 13px; background:var(--pv-card); border:1px solid var(--pv-border); border-radius:8px; font-size:.78rem; color:var(--pv-t1); font-weight:500; transition:all .18s; }
.pv-zone-pill:hover { border-color:var(--pv-teal); color:var(--pv-teal); background:rgba(0,128,128,.04); }
</style>

<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Service Coverage</span>
        <h2 class="pv-stitle pv-rv">Areas We Cover in Varanasi</h2>
        <p class="pv-ssub pv-rv">Property verification across all 241+ localities in Varanasi district. No extra charge for any area, distance, or zone.</p>

        {{-- Top 20 Verified Localities --}}
        <div class="pv-rv">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px; flex-wrap:wrap;">
                <span style="font-size:.82rem; font-weight:800; color:var(--pv-navy); text-transform:uppercase; letter-spacing:1.5px;">⭐ Top 20 Verified Localities</span>
                <span style="font-size:.72rem; color:var(--pv-t3);">Most enquired areas this year</span>
            </div>
            <div class="pv-top20-grid">
                <div class="pv-top20-card"><div class="pv-top20-card__name">Sigra</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Lanka</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Mahmoorganj</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Sunderpur</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Shivpur</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Rohania</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Ramnagar</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Babatpur</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Paharia</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">DLW Colony</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Kabir Nagar</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Manduadih</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Sarnath</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Bhelupura</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Pandeypur</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Harhua</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Chitaipur</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Susuwahi</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Kandwa</div><div class="pv-top20-card__tag">Verified Plots</div></div>
                <div class="pv-top20-card"><div class="pv-top20-card__name">Ashapur</div><div class="pv-top20-card__tag">Verified Plots</div></div>
            </div>
        </div>

        {{-- Zone tabs --}}
        <div class="pv-rv">
            <div style="margin-bottom:10px; font-size:.78rem; font-weight:700; color:var(--pv-t3); text-transform:uppercase; letter-spacing:1.5px;">Browse by zone</div>
            <div class="pv-zone-tabs">
                <button class="pv-zone-tab active" onclick="pvZone(this,'north')">North Varanasi <span style="opacity:.6;font-weight:400;margin-left:4px;">2</span></button>
                <button class="pv-zone-tab" onclick="pvZone(this,'south')">South Varanasi <span style="opacity:.6;font-weight:400;margin-left:4px;">50</span></button>
                <button class="pv-zone-tab" onclick="pvZone(this,'east')">East Varanasi <span style="opacity:.6;font-weight:400;margin-left:4px;">27</span></button>
                <button class="pv-zone-tab" onclick="pvZone(this,'west')">West Varanasi <span style="opacity:.6;font-weight:400;margin-left:4px;">162</span></button>
            </div>

            {{-- North --}}
            <div class="pv-zone-panel active" id="pvz-north">
                <div class="pv-zone-header">
                    <h3>North Varanasi</h3>
                    <span class="pv-zone-count">2 Areas</span>
                </div>
                <div class="pv-zone-pills">
                    <span class="pv-zone-pill">Bada Lalpur</span>
                    <span class="pv-zone-pill">Sarnath</span>
                </div>
            </div>

            {{-- South --}}
            <div class="pv-zone-panel" id="pvz-south">
                <div class="pv-zone-header">
                    <h3>South Varanasi</h3>
                    <span class="pv-zone-count">50 Areas</span>
                </div>
                <div class="pv-zone-pills">
                    <span class="pv-zone-pill">Adampur</span><span class="pv-zone-pill">Akhari</span><span class="pv-zone-pill">Ashapur</span><span class="pv-zone-pill">Ashok Vihar Colony</span><span class="pv-zone-pill">Aurangabad Road</span><span class="pv-zone-pill">Bari Gaibi</span><span class="pv-zone-pill">Bhagwanpur</span><span class="pv-zone-pill">Bhelupura</span><span class="pv-zone-pill">Bhiti</span><span class="pv-zone-pill">Bhojuveer</span><span class="pv-zone-pill">Bhulanpur</span><span class="pv-zone-pill">Birdopur</span><span class="pv-zone-pill">Brahmanand Colony</span><span class="pv-zone-pill">Chhataripur</span><span class="pv-zone-pill">Dafi</span><span class="pv-zone-pill">Daulatpur</span><span class="pv-zone-pill">Durgakund</span><span class="pv-zone-pill">Hiramanpur</span><span class="pv-zone-pill">Hukulganj</span><span class="pv-zone-pill">Hyderabad Gate</span><span class="pv-zone-pill">Jaitpura</span><span class="pv-zone-pill">Kailashpuri Colony</span><span class="pv-zone-pill">Kamaccha</span><span class="pv-zone-pill">Kandwa</span><span class="pv-zone-pill">Kesharipur</span><span class="pv-zone-pill">Khojwa</span><span class="pv-zone-pill">Lahurabir</span><span class="pv-zone-pill">Lanka</span><span class="pv-zone-pill">Ledhupur</span><span class="pv-zone-pill">Lohta</span><span class="pv-zone-pill">Mahamanapuri Colony</span><span class="pv-zone-pill">Maldahia</span><span class="pv-zone-pill">Mirapur Basahi</span><span class="pv-zone-pill">Mirzamurad</span><span class="pv-zone-pill">Nagwa</span><span class="pv-zone-pill">Nagwa Lanka</span><span class="pv-zone-pill">Nirala Nagar</span><span class="pv-zone-pill">Raja Talab</span><span class="pv-zone-pill">Rajatalab</span><span class="pv-zone-pill">Rajendra Vihar Colony</span><span class="pv-zone-pill">Rath Yatra</span><span class="pv-zone-pill">Ravindrapuri Colony</span><span class="pv-zone-pill">Rohania</span><span class="pv-zone-pill">Saket Nagar Colony</span><span class="pv-zone-pill">Samne Ghat</span><span class="pv-zone-pill">Sear Govardhan Dafi</span><span class="pv-zone-pill">Sidhgiribagh</span><span class="pv-zone-pill">Soniabagh</span><span class="pv-zone-pill">Sunderpur</span><span class="pv-zone-pill">Varanasi Ring Road</span>
                </div>
            </div>

            {{-- East --}}
            <div class="pv-zone-panel" id="pvz-east">
                <div class="pv-zone-header">
                    <h3>East Varanasi</h3>
                    <span class="pv-zone-count">27 Areas</span>
                </div>
                <div class="pv-zone-pills">
                    <span class="pv-zone-pill">Ardaly Bazar</span><span class="pv-zone-pill">Bari Bazar</span><span class="pv-zone-pill">Chhittanpura</span><span class="pv-zone-pill">Chhittupur</span><span class="pv-zone-pill">Churamanpur</span><span class="pv-zone-pill">Godaulia</span><span class="pv-zone-pill">Guru Bagh</span><span class="pv-zone-pill">Habib Ganj</span><span class="pv-zone-pill">Kabir Nagar</span><span class="pv-zone-pill">Kabirchaura</span><span class="pv-zone-pill">Kadipur</span><span class="pv-zone-pill">Karaundi</span><span class="pv-zone-pill">Kazi Sarai</span><span class="pv-zone-pill">Mahmoorganj</span><span class="pv-zone-pill">Nadesar</span><span class="pv-zone-pill">Nai Basti</span><span class="pv-zone-pill">Naria</span><span class="pv-zone-pill">Newada</span><span class="pv-zone-pill">Pandeypur</span><span class="pv-zone-pill">Ramnagar</span><span class="pv-zone-pill">Salarpur</span><span class="pv-zone-pill">Shivala</span><span class="pv-zone-pill">Sigra</span><span class="pv-zone-pill">Sudhakar Road</span><span class="pv-zone-pill">Tarna</span><span class="pv-zone-pill">The Mall Road</span><span class="pv-zone-pill">Tulsipur</span>
                </div>
            </div>

            {{-- West --}}
            <div class="pv-zone-panel" id="pvz-west">
                <div class="pv-zone-header">
                    <h3>West Varanasi</h3>
                    <span class="pv-zone-count">162 Areas</span>
                </div>
                <div class="pv-zone-pills">
                    <span class="pv-zone-pill">Adarshnagar Colony</span><span class="pv-zone-pill">Airport Road</span><span class="pv-zone-pill">Akatha</span><span class="pv-zone-pill">Amara Khaira Chak</span><span class="pv-zone-pill">Anandbagh Colony</span><span class="pv-zone-pill">Anaula</span><span class="pv-zone-pill">Ashokpuram</span><span class="pv-zone-pill">Ashokpuram Colony</span><span class="pv-zone-pill">Assi Ghat</span><span class="pv-zone-pill">Awaleshpur</span><span class="pv-zone-pill">Awaleshpur Colony</span><span class="pv-zone-pill">Ay Ar</span><span class="pv-zone-pill">Babatpur</span><span class="pv-zone-pill">Bachchhaon</span><span class="pv-zone-pill">Bachchhaon Colony</span><span class="pv-zone-pill">Bangali Tola</span><span class="pv-zone-pill">Baraipur</span><span class="pv-zone-pill">Basani Bazaar</span><span class="pv-zone-pill">Bazardiha</span><span class="pv-zone-pill">Benares Hindu University</span><span class="pv-zone-pill">Benia Bagh</span><span class="pv-zone-pill">Benia Bagh Colony</span><span class="pv-zone-pill">Bhabha Market</span><span class="pv-zone-pill">Bhabha Market Colony</span><span class="pv-zone-pill">Bhel</span><span class="pv-zone-pill">Bhikhampur</span><span class="pv-zone-pill">Bhikhampur Colony</span><span class="pv-zone-pill">Bhu Campus</span><span class="pv-zone-pill">Birapatti</span><span class="pv-zone-pill">Brij Enclave Colony</span><span class="pv-zone-pill">Bulanala</span><span class="pv-zone-pill">Central Jail Road</span><span class="pv-zone-pill">Chaitganj</span><span class="pv-zone-pill">Chandmari</span><span class="pv-zone-pill">Chandpur Industrial Area</span><span class="pv-zone-pill">Chandpur Industrial Estate</span><span class="pv-zone-pill">Chaukaghat</span><span class="pv-zone-pill">Chaukaghat Colony</span><span class="pv-zone-pill">Chetganj</span><span class="pv-zone-pill">Chitaipur</span><span class="pv-zone-pill">Chowk</span><span class="pv-zone-pill">Daranagar</span><span class="pv-zone-pill">Daranagar Colony</span><span class="pv-zone-pill">Darekhu</span><span class="pv-zone-pill">Dashaswmedh Road</span><span class="pv-zone-pill">Dharma Nagar</span><span class="pv-zone-pill">Dharma Nagar Colony</span><span class="pv-zone-pill">Dhupchandi</span><span class="pv-zone-pill">Dig Colony</span><span class="pv-zone-pill">DLW Colony</span><span class="pv-zone-pill">Dumraon</span><span class="pv-zone-pill">Dumraon Colony</span><span class="pv-zone-pill">Gai Ghat</span><span class="pv-zone-pill">Gai Ghat Colony</span><span class="pv-zone-pill">Gandhi Nagar</span><span class="pv-zone-pill">Ganeshpur</span><span class="pv-zone-pill">Gautam Nagar</span><span class="pv-zone-pill">Gautam Nagar Extension</span><span class="pv-zone-pill">Giri Nagar</span><span class="pv-zone-pill">Gola Purwa</span><span class="pv-zone-pill">Gola Purwa Colony</span><span class="pv-zone-pill">Gopal Vihar</span><span class="pv-zone-pill">Gopal Vihar Colony</span><span class="pv-zone-pill">Guru Nanak Nagar</span><span class="pv-zone-pill">Guru Nanak Nagar Colony</span><span class="pv-zone-pill">Hanumaan Ghat</span><span class="pv-zone-pill">Hanumaan Ghat Colony</span><span class="pv-zone-pill">Harhua</span><span class="pv-zone-pill">Indira Nagar Colony</span><span class="pv-zone-pill">Ishwargangi Pokhra</span><span class="pv-zone-pill">Ishwargangi Pokhra Colony</span><span class="pv-zone-pill">Janki Nagar</span><span class="pv-zone-pill">Jansa Bazar</span><span class="pv-zone-pill">Jansa Bazar Colony</span><span class="pv-zone-pill">Jawahar Nagar</span><span class="pv-zone-pill">Kail Garh</span><span class="pv-zone-pill">Kail Garh Colony</span><span class="pv-zone-pill">Kakarmatta</span><span class="pv-zone-pill">Kandawa Chauraha</span><span class="pv-zone-pill">Kandawa Chauraha Colony</span><span class="pv-zone-pill">Kasturba Nagar</span><span class="pv-zone-pill">Kasturba Nagar Colony</span><span class="pv-zone-pill">Kedar Ghat</span><span class="pv-zone-pill">Kedar Ghat Colony</span><span class="pv-zone-pill">Khajuri Road</span><span class="pv-zone-pill">Khajuri Road Colony</span><span class="pv-zone-pill">Khanna</span><span class="pv-zone-pill">Khanna Colony</span><span class="pv-zone-pill">Kirti Nagar</span><span class="pv-zone-pill">Kotwa Kapildhara</span><span class="pv-zone-pill">Kotwali</span><span class="pv-zone-pill">Lahartara</span><span class="pv-zone-pill">Lamhi</span><span class="pv-zone-pill">Luxa</span><span class="pv-zone-pill">Luxa Road</span><span class="pv-zone-pill">Maheshpur</span><span class="pv-zone-pill">Maheshpur Colony</span><span class="pv-zone-pill">Manas Nagar</span><span class="pv-zone-pill">Manas Nagar Colony</span><span class="pv-zone-pill">Manduadih</span><span class="pv-zone-pill">Maulvibagh</span><span class="pv-zone-pill">Mawaiya</span><span class="pv-zone-pill">Mohansarai</span><span class="pv-zone-pill">Murdaha Bazar</span><span class="pv-zone-pill">Murdaha Bazar Colony</span><span class="pv-zone-pill">Nagwar</span><span class="pv-zone-pill">Nagwar Colony</span><span class="pv-zone-pill">Naipokhari</span><span class="pv-zone-pill">Naipokhari Colony</span><span class="pv-zone-pill">Narayanpur</span><span class="pv-zone-pill">Narayanpur Colony</span><span class="pv-zone-pill">Naya Ghat</span><span class="pv-zone-pill">Naya Ghat Colony</span><span class="pv-zone-pill">New Colony Kakarmatta</span><span class="pv-zone-pill">Om Nagar Colony</span><span class="pv-zone-pill">Paharia</span><span class="pv-zone-pill">Parao</span><span class="pv-zone-pill">Parvatipuri Extension</span><span class="pv-zone-pill">Parvatipuri Extention</span><span class="pv-zone-pill">Parvatipuri Nagar Colony</span><span class="pv-zone-pill">Phulpur</span><span class="pv-zone-pill">Pindra</span><span class="pv-zone-pill">Piyari</span><span class="pv-zone-pill">Piyari Colony</span><span class="pv-zone-pill">Railwayganj Colony</span><span class="pv-zone-pill">Rajpur</span><span class="pv-zone-pill">Rajpur Colony</span><span class="pv-zone-pill">Ramaipatti</span><span class="pv-zone-pill">Ramaipatti Colony</span><span class="pv-zone-pill">Ramapura Luxa</span><span class="pv-zone-pill">Ramapura Luxa Colony</span><span class="pv-zone-pill">Ramdatpur</span><span class="pv-zone-pill">Rameshwar</span><span class="pv-zone-pill">Rameshwar Colony</span><span class="pv-zone-pill">Salhupur</span><span class="pv-zone-pill">Sampoornanand Nagar</span><span class="pv-zone-pill">Sampoornanand Nagar Colony</span><span class="pv-zone-pill">Sant Raghuvar Nagar</span><span class="pv-zone-pill">Sant Raghuvar Nagar Colony</span><span class="pv-zone-pill">Sant Raghuwar Nagar Ext Colony</span><span class="pv-zone-pill">Shivdaspur</span><span class="pv-zone-pill">Shivpur</span><span class="pv-zone-pill">Shivpur Bypass Road</span><span class="pv-zone-pill">Shivraj Nagar</span><span class="pv-zone-pill">Shivraj Nagar Colony</span><span class="pv-zone-pill">Shree Ganesh Dham</span><span class="pv-zone-pill">Shree Ganesh Dham Colony</span><span class="pv-zone-pill">Sikraul</span><span class="pv-zone-pill">Sindhora</span><span class="pv-zone-pill">Sindhora Colony</span><span class="pv-zone-pill">Singhpur</span><span class="pv-zone-pill">Singhpur Colony</span><span class="pv-zone-pill">Susuwahi</span><span class="pv-zone-pill">Tajpur</span><span class="pv-zone-pill">Tajpur Colony</span><span class="pv-zone-pill">Taktakpur</span><span class="pv-zone-pill">Tapovan Ashram</span><span class="pv-zone-pill">Tapovan Colony</span><span class="pv-zone-pill">Varanasi Cantt</span><span class="pv-zone-pill">Vda Colony</span><span class="pv-zone-pill">Vidyapeeth Colony</span><span class="pv-zone-pill">Vidyapeeth Road</span>
                </div>
            </div>
        </div>

        <div style="margin-top:28px; padding:16px 20px; background:rgba(0,128,128,.06); border:1px solid rgba(0,128,128,.18); border-radius:12px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <span style="font-size:.84rem; color:var(--pv-t2);">Don't see your area? We cover <strong style="color:var(--pv-t1);">all of Varanasi district</strong> — no extra charge.</span>
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20need%20property%20verification%20in%20Varanasi.%20My%20locality%20is%3A" style="white-space:nowrap; font-size:.82rem; font-weight:700; color:#fff; background:#25D366; padding:9px 18px; border-radius:9px; text-decoration:none;">WhatsApp Us →</a>
        </div>
    </div>
</section>

<script>
function pvZone(btn, zone) {
    document.querySelectorAll('.pv-zone-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.pv-zone-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('pvz-' + zone).classList.add('active');
}
</script>

{{-- ═══════════ FAQ (Native <details> — rendered from same $faqs used in JSON-LD) ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">FAQ</span>
        <h2 class="pv-stitle pv-rv">Property Verification in Varanasi — Common Questions</h2>

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

{{-- ═══════════ CTA — brand navy gradient ═══════════ --}}
<section class="pv-cta">
    <div class="pv-cta__orb"></div>
    <div class="pv-container pv-cta__inner">
        <h2>Start with a Free Preliminary Check</h2>
        <p>Send us the property address and seller's name on WhatsApp. We check the basics — free, in 2 hours — and tell you honestly if a full ₹5,000 verification is worth doing.</p>
        <div class="pv-cta__btns">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20a%20free%20preliminary%20property%20check%20in%20Varanasi.%20Property%20address%3A" class="pv-btn pv-btn--whatsapp">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                Free Preliminary Check — WhatsApp
            </a>
            <a href="#pricing" class="pv-btn pv-btn--ghost">View Pricing →</a>
        </div>
        <p style="margin-top:18px; font-size:.8rem; color:rgba(255,255,255,.5);">
            Also serving:
            <a href="/services/property-verification-lucknow" style="color:rgba(255,255,255,.65);text-decoration:underline;">Lucknow</a> ·
            <a href="/services/property-verification-ayodhya" style="color:rgba(255,255,255,.65);text-decoration:underline;">Ayodhya</a>
        </p>
    </div>
</section>

</div>{{-- .pv-wrap --}}

{{-- Mobile sticky CTA --}}
<div class="pv-mobile-cta" id="pvMobileCta">
    <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20property%20verification%20in%20Varanasi" class="whatsapp">WhatsApp</a>
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