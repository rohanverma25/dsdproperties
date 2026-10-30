@extends('layouts.user-app')

{{-- ═══════════════════════════════════════════════════════════════
     PROPERTY VERIFICATION SERVICE LUCKNOW — HUB VERSION
     Strategy: Service page is the conversion HUB. Blogs are spokes.
     Service page targets TRANSACTIONAL queries only.
     Informational queries (LDA search, IGRSUP, ownership records)
     stay owned by the Ownership Records blog & IGRSUP Hindi blog.
     ═══════════════════════════════════════════════════════════════ --}}

@section('title', 'Property Verification in Lucknow — ₹5,000, 48-Hour Report | DSD')

@section('meta_description', 'Buying property in Lucknow? We verify LDA, registry, khatauni, encumbrance and court records at source. ₹5,000 fixed fee, PDF report in 48 hours.')

@section('meta_keywords', 'property verification service lucknow, property verifier lucknow, property verification cost lucknow, lda plot verification service, property document check service lucknow, how to verify property documents online, property verification lawyer, house verification, property verification online, verify property documents, property legal verification, property paper verification, land document verification, plot verification lucknow, registry verification lucknow, encumbrance certificate verification lucknow, dakhil kharij verification lucknow, property ownership verification lucknow, property litigation search lucknow, zila panchayat approval verification lucknow, property verification charges lucknow, property due diligence report, property valuation services near me, property verification report lucknow, property authenticity check lucknow, property verification online lucknow')

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
  "name": "Professional Property Verification Service in Lucknow",
  "description": "Hire an independent property verifier in Lucknow. We physically check LDA allotment, sale deed, registry, encumbrance certificate, court cases, Dakhil Kharij (mutation) and RERA approval at LDA office, Sub-Registrar, Tehsil and court records. PDF report delivered in 48 hours.",
  "provider": { "@id": "https://dsdproperties.in/#organization" },
  "areaServed": { "@type": "City", "name": "Lucknow", "containedInPlace": { "@type": "State", "name": "Uttar Pradesh" } },
  "offers": [
    { "@type": "Offer", "name": "Residential Plot / Flat Verification", "price": "5000", "priceCurrency": "INR", "description": "Sale deed, title chain, encumbrance, LDA, RERA and mutation check. PDF report in 48 hours." },
    { "@type": "Offer", "name": "Commercial Property Verification", "price": "7000", "priceCurrency": "INR" },
    { "@type": "Offer", "name": "Premium Verification with Site Visit", "price": "10000", "priceCurrency": "INR" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    { "@type": "Question", "name": "How Much Do Property Legal Verification Services Cost?",
      "acceptedAnswer": { "@type": "Answer", "text": "Property verification in Lucknow starts at ₹5,000 for residential plots and flats, ₹7,000 for commercial properties, and ₹10,000 for the premium package with physical site inspection. All packages include a PDF report within 48 hours. There are no per-document charges or hidden fees." } },
    { "@type": "Question", "name": "Why should I hire a property verifier instead of checking documents myself?",
      "acceptedAnswer": { "@type": "Answer", "text": "Doing it yourself is free but takes 2-3 weekends and only covers online portals. A professional verifier physically visits the LDA office, Sub-Registrar, Tehsil and district court — the places where fraud is actually caught. You also get a written PDF report admissible as evidence, and a trained eye that has seen the patterns most buyers miss." } },
    { "@type": "Question", "name": "What is the verification process for Lucknow property?",
      "acceptedAnswer": { "@type": "Answer", "text": "Five steps: (1) Free preliminary consultation on WhatsApp, (2) Share property address and any documents, (3) Pay ₹5,000 verification fee via UPI or bank transfer, (4) We physically verify documents at LDA, Sub-Registrar, Tehsil and court records over 48 hours, (5) You receive a detailed PDF report with a clear verdict — Safe to Buy or Red Flags Found." } },
    { "@type": "Question", "name": "How long does property verification take in Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "Standard verification takes 48 hours from document receipt. You get a PDF report with every check performed and a clear verdict. The premium ₹10,000 package with site visit takes 3-5 days because of the physical inspection and video walkthrough." } },
    { "@type": "Question", "name": "What's Included in a Property Due Diligence Report?",
      "acceptedAnswer": { "@type": "Answer", "text": "The PDF report includes: LDA allotment status, 30-year sale deed chain, encumbrance certificate, Khatauni and revenue records, Dakhil Kharij confirmation, RERA registration check, court case search at District Court and HC Lucknow Bench, LDA Illegal Colony List check, and a final verdict with specific reasons." } },
    { "@type": "Question", "name": "Can NRIs hire DSD Properties for verification from abroad?",
      "acceptedAnswer": { "@type": "Answer", "text": "Yes. NRI verifications are routine. You WhatsApp documents from anywhere, we physically verify at LDA, Sub-Registrar, Tehsil and court records in Lucknow, and send the PDF report. The ₹10,000 premium package adds a site visit with photo evidence and a video walkthrough." } },
    { "@type": "Question", "name": "Should I hire a property lawyer or a verification service?",
      "acceptedAnswer": { "@type": "Answer", "text": "For pre-purchase due diligence, a verification service is faster and cheaper — ₹5,000 with a 48-hour PDF report. Hire a property lawyer when you have an active dispute, partition case, or need court representation. Most buyers need verification, not litigation." } },
    { "@type": "Question", "name": "What documents do I need to share to start verification?",
      "acceptedAnswer": { "@type": "Answer", "text": "The property address and seller's full name are enough to start. If you have documents — sale deed, registry, allotment letter, Khatauni, RERA number — share them on WhatsApp at +91-8595002933. We do a free preliminary check before you commit to the ₹5,000 full verification." } },
    { "@type": "Question", "name": "Do you offer property verification for areas outside central Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "Yes. We cover all of Lucknow district — Sultanpur Road, Kisan Path, Mohanlalganj, Kanpur Road, Faizabad Road, Raebareli Road, Bakshi Ka Talab, Malihabad and surrounding areas. Tehsil verification is done at the relevant local Tehsil. No extra charge for distance." } },
    { "@type": "Question", "name": "What happens if you find problems with my property?",
      "acceptedAnswer": { "@type": "Answer", "text": "If we find red flags — disputed title, pending litigation, hidden mortgage, fake LDA letter, missing mutation — we document everything in the PDF report with evidence. You can show this to the seller, walk away from the deal, or take it to a property lawyer for further action." } },
    { "@type": "Question", "name": "How to Verify Property Documents Online in Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "Start with the free government portals — IGRSUP for registry search and the LDA website for allotment status. This covers basic ownership, but a 30-year encumbrance certificate and court case search usually need an in-person visit or an advocate's access, which is what makes purely online verification incomplete. DSD Properties does both — the online checks and the in-person ones — and sends a PDF report in 48 hours." } },
    { "@type": "Question", "name": "What's the difference between house verification and land document verification?",
      "acceptedAnswer": { "@type": "Answer", "text": "House verification (for a flat or built-up property) additionally checks RERA registration, occupancy certificate, and builder dues. Land document verification (for a plot) focuses more heavily on Khatauni, Khasra records, and mutation (Dakhil Kharij) at the Tehsil. Both share the same core: 30-year title chain, encumbrance certificate, and court case search. Our ₹5,000 verification covers both." } },
    { "@type": "Question", "name": "Do I Need a Property Verification Lawyer in Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "For pre-purchase property legal verification — checking title, encumbrance, mutation and court records — a verification service is faster and cheaper than hiring a lawyer directly, and our reports are prepared with advocate input. You'd need a separate property lawyer only if a dispute is already active or you need court representation, not for standard due diligence before buying." } }
  ]
}
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
  "@type": "HowTo",
  "name": "How to Get Property Verified in Lucknow",
  "description": "Hire DSD Properties for independent property verification in Lucknow. Physical checks at LDA, Sub-Registrar, Tehsil, and courts. PDF report in 48 hours at ₹5,000.",
  "totalTime": "PT48H",
  "estimatedCost": {
    "@type": "MonetaryAmount",
    "currency": "INR",
    "value": "5000"
  },
  "step": [
    {
      "@type": "HowToStep",
      "position": 1,
      "name": "WhatsApp Free Preliminary Check",
      "text": "Send the property address and seller's name on WhatsApp to +91-8595002933. We do a free preliminary LDA and IGRSUP check within 2 hours and tell you honestly if a full verification is worth doing.",
      "url": "https://dsdproperties.in/services/property-verification-lucknow"
    },
    {
      "@type": "HowToStep",
      "position": 2,
      "name": "Share Available Documents",
      "text": "Share sale deed, registry copy, allotment letter, Khatauni, RERA number — whatever you have. Even just the property address is enough to start.",
      "url": "https://dsdproperties.in/services/property-verification-lucknow"
    },
    {
      "@type": "HowToStep",
      "position": 3,
      "name": "Pay ₹5,000 Verification Fee",
      "text": "Pay ₹5,000 for residential plots and flats, ₹7,000 for commercial properties, or ₹10,000 for the premium package with site visit. Payment via UPI or bank transfer. Invoice issued.",
      "url": "https://dsdproperties.in/services/property-verification-lucknow"
    },
    {
      "@type": "HowToStep",
      "position": 4,
      "name": "We Verify at Source",
      "text": "Our team physically checks documents at the LDA office (Gomti Nagar), Sub-Registrar, relevant Tehsil, court records at Lucknow District Court and Allahabad HC Lucknow Bench, and the LDA Illegal Colony List — not just online portals.",
      "url": "https://dsdproperties.in/services/property-verification-lucknow"
    },
    {
      "@type": "HowToStep",
      "position": 5,
      "name": "Receive Detailed PDF Report in 48 Hours",
      "text": "A clear PDF report with every check performed, any red flags found, and a final verdict: Safe to Buy or Do Not Proceed. Delivered within 48 hours of document receipt.",
      "url": "https://dsdproperties.in/services/property-verification-lucknow"
    }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Property Verification Service Lucknow — Hire LDA, Registry & Plot Verifier ₹5,000",
  "url": "https://dsdproperties.in/services/property-verification-lucknow",
  "description": "Hire a professional property verifier in Lucknow. We check LDA, registry, encumbrance, RERA, mutation and court records at source. PDF report in 48 hours. ₹5,000 fixed fee.",
  "speakable": {
    "@type": "SpeakableSpecification",
    "cssSelector": [".pv-hero__sub", ".pv-ssub", ".pv-step p", ".pv-faq-a"]
  },
  "about": {
    "@type": "Service",
    "name": "Property Verification Service Lucknow",
    "description": "Independent physical verification of property documents in Lucknow including LDA allotment, registry, encumbrance, RERA, mutation, and court records. PDF report in 48 hours at ₹5,000.",
    "provider": { "@id": "https://dsdproperties.in/#organization" }
  }
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

.pv-hero { position: relative; overflow: hidden; min-height: 88vh; background: linear-gradient(135deg, #011f4b 0%, #013870 45%, #005f6b 100%); display: flex; align-items: center; }
.pv-hero__grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px); background-size: 50px 50px; }
.pv-hero__orb { position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none; }
.pv-hero__orb--a { width: 500px; height: 500px; background: rgba(0,128,128,.25); top: -120px; right: -80px; animation: pv-float 9s ease-in-out infinite; }
.pv-hero__orb--b { width: 360px; height: 360px; background: rgba(255,92,0,.14); bottom: -60px; left: -60px; animation: pv-float 11s ease-in-out infinite 3s; }
.pv-hero__body { position: relative; z-index: 2; padding-top: 60px; padding-bottom: 70px; display:grid; grid-template-columns: 1.15fr 1fr; gap: 50px; align-items: center; }
@media(max-width:900px){ .pv-hero__body { grid-template-columns: 1fr; gap: 30px; padding-top: 80px; } }

.pv-hero__left { animation: pv-up .6s ease both; }
.pv-hero__badge { display: inline-flex; align-items: center; gap: 9px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); border-radius: 99px; padding: 7px 16px; margin-bottom: 22px; font-size: 11px; font-weight: 500; color: rgba(255,255,255,.82); backdrop-filter: blur(8px); }
.pv-pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: #4ade80; flex-shrink: 0; animation: pvPulse 2.5s infinite; display: inline-block; }
.pv-hero__h1 { font-size: clamp(1.85rem, 3.6vw, 2.7rem); font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 18px; letter-spacing: -.4px; }
.pv-hero__h1 em { font-style: normal; color: #FF5C00; }
.pv-hero__sub { font-size: .95rem; color: rgba(255,255,255,.78); line-height: 1.78; margin-bottom: 26px; max-width: 580px; }
.pv-hero__cta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 26px; }
.pv-hero__pills { display: flex; flex-wrap: wrap; gap: 8px; }
.pv-pill { display: flex; align-items: center; gap: 6px; padding: 5px 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); border-radius: 8px; font-size: 11px; color: rgba(255,255,255,.7); }
.pv-pill i { font-size: 10px; color: rgba(255,255,255,.5); }

.pv-hero__card { background: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 28px 72px rgba(0,0,0,.28); animation: pv-up .7s ease .15s both; }
.pv-hero__card-tag { display:inline-block; font-size:10px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--pv-orange); background:rgba(255,92,0,.08); padding:4px 9px; border-radius:5px; margin-bottom: 12px; }
.pv-hero__card-title { font-size: 1.2rem; font-weight: 800; color: var(--pv-t1); margin-bottom: 6px; line-height: 1.3; }
.pv-hero__card-sub { font-size: .82rem; color: var(--pv-t2); margin-bottom: 18px; line-height: 1.6; }
.pv-hero__card-price { display: flex; align-items: baseline; gap: 8px; margin-bottom: 18px; padding: 14px 16px; background: var(--pv-bg2); border-radius: 10px; border-left: 4px solid var(--pv-orange); }
.pv-hero__card-price-amt { font-size: 1.8rem; font-weight: 900; color: var(--pv-navy); line-height: 1; }
.pv-hero__card-price-lbl { font-size: .78rem; color: var(--pv-t2); }
.pv-hero__card-list { list-style:none; padding:0; margin: 0 0 18px; }
.pv-hero__card-list li { display: flex; align-items: flex-start; gap: 9px; padding: 6px 0; font-size: .82rem; color: var(--pv-t2); }
.pv-hero__card-list li::before { content: "✓"; color: var(--pv-teal); font-weight: 800; flex-shrink: 0; }
.pv-hero__card-btn { display: block; padding: 14px; background: #25D366; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: .92rem; cursor: pointer; font-family: 'Poppins', sans-serif; text-align: center; text-decoration: none; transition: transform .2s, box-shadow .2s; box-shadow: 0 5px 18px rgba(37,211,102,.3); }
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

.pv-diy-table { max-width: 920px; margin: 0 auto; background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 16px; overflow: hidden; box-shadow: 0 8px 32px rgba(1,31,75,.06); }
.pv-diy-head { display: grid; grid-template-columns: 1.1fr 1fr 1fr; background: linear-gradient(135deg, var(--pv-navy), #013870); color:#fff; }
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
.pv-check-card__title { font-size: .92rem; font-weight: 700; color: var(--pv-t1); margin:0 0 5px; }
.pv-check-card__text { font-size: .82rem; color: var(--pv-t2); line-height: 1.65; margin: 0 0 8px; }
.pv-check-card__where { font-size: .72rem; color: var(--pv-teal); font-weight: 600; }
.pv-check-card__where::before { content: "📍 "; }

.pv-doc-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px; }
.pv-doc-item { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 13px; padding: 18px 20px; display: flex; gap: 14px; align-items: flex-start; transition: transform .25s, box-shadow .25s, border-color .25s; }
.pv-doc-item:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,128,128,.1); border-color: rgba(0,128,128,.3); }
.pv-doc-num { width: 32px; height: 32px; flex-shrink: 0; background: linear-gradient(135deg, var(--pv-teal), #006666); color:#fff; border-radius: 8px; display:flex; align-items:center; justify-content:center; font-size: .85rem; font-weight: 800; }
.pv-doc-title { font-size: .87rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 4px; }
.pv-doc-desc  { font-size: .76rem; color: var(--pv-t2); line-height: 1.6; margin: 0; }

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
.pv-step__num { width: 48px; height: 48px; flex-shrink: 0; background: linear-gradient(135deg, var(--pv-navy), #013a6b); color:#fff; border-radius: 11px; display:flex; align-items:center; justify-content:center; font-size: 1.25rem; font-weight: 800; }
.pv-step h3 { font-size: .9rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 5px; }
.pv-step p  { font-size: .8rem; color: var(--pv-t2); line-height: 1.6; margin: 0; }

.pv-report { max-width: 880px; margin: 0 auto; background: var(--pv-card); border: 1.5px solid var(--pv-border); border-radius: 18px; overflow: hidden; box-shadow: 0 12px 40px rgba(1,31,75,.08); }
.pv-report__header { background: linear-gradient(135deg, var(--pv-navy), #013870); color:#fff; padding: 24px 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; }
.pv-report__title { font-size: 1.1rem; font-weight: 800; margin: 0; }
.pv-report__subtitle { font-size: .78rem; color: rgba(255,255,255,.75); margin: 4px 0 0; }
.pv-report__verdict { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #047857; color:#fff; border-radius: 99px; font-size: .8rem; font-weight: 700; }
.pv-report__body { padding: 22px 28px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
@media(max-width:600px){ .pv-report__body { grid-template-columns: 1fr; } }
.pv-report__item { display: flex; gap: 10px; padding: 12px; background: var(--pv-bg2); border-radius: 10px; align-items: flex-start; }
.pv-report__item-check { color: #047857; font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
.pv-report__item-text { font-size: .8rem; color: var(--pv-t2); line-height: 1.5; }
.pv-report__item-text strong { color: var(--pv-t1); display: block; margin-bottom: 2px; font-size: .82rem; }
.pv-report__footer { padding: 18px 28px; background: var(--pv-bg2); border-top: 1px solid var(--pv-border); font-size: .78rem; color: var(--pv-t3); text-align: center; }

.pv-pricing-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 18px; align-items: start; }
@media(max-width:820px){ .pv-pricing-grid { grid-template-columns:1fr; max-width:440px; margin:0 auto; } }
.pv-price-card { background: var(--pv-card); border: 2px solid var(--pv-border); border-radius: 18px; padding: 32px 28px; text-align: center; transition: transform .3s, box-shadow .3s, border-color .3s; position: relative; }
.pv-price-card:hover { transform: translateY(-6px); box-shadow: 0 18px 44px rgba(0,0,0,.1); border-color: var(--pv-teal); }
.pv-price-card--featured { background: linear-gradient(135deg, #FF5C00, #e54f00); border-color: #FF5C00; box-shadow: 0 12px 36px rgba(255,92,0,.28); }
.pv-price-badge { position: absolute; top: -13px; left: 50%; transform: translateX(-50%); background: #fff; color: #FF5C00; padding: 4px 16px; border-radius: 99px; font-weight: 800; font-size: .74rem; box-shadow: 0 4px 12px rgba(0,0,0,.15); border: 2px solid #FF5C00; white-space: nowrap; }
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
.pv-price-btn--white { background:#fff; color:#FF5C00; }
.pv-price-btn--white:hover { background:#fff8f5; color:#FF5C00; }

.pv-cta { background: linear-gradient(135deg, #011f4b 0%, #013870 45%, #005f6b 100%); padding: 70px 0; position: relative; overflow: hidden; }
.pv-cta__orb { position: absolute; border-radius: 50%; filter: blur(80px); width: 400px; height: 400px; background: rgba(0,128,128,.18); top: -100px; right: -80px; animation: pv-float 10s ease-in-out infinite; }
.pv-cta__inner { position: relative; z-index: 2; text-align: center; }
.pv-cta h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color:#fff; margin-bottom: 12px; }
.pv-cta p  { font-size: .92rem; color: rgba(255,255,255,.78); max-width: 580px; margin: 0 auto 30px; line-height: 1.7; }
.pv-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

.pv-hindi { background: linear-gradient(135deg, #fff8f0 0%, #fff1e0 100%); border: 1.5px solid rgba(255,92,0,.2); border-radius: 16px; padding: 32px 30px; max-width: 900px; margin: 0 auto; }
.pv-hindi h3 { font-size: 1.2rem; font-weight: 800; color: var(--pv-navy); margin-bottom: 12px; line-height: 1.4; }
.pv-hindi p { font-size: .92rem; color: #374151; line-height: 1.8; margin: 0 0 12px; }
.pv-hindi strong { color: var(--pv-navy); }
.pv-hindi__cta { margin-top: 16px; }

.pv-faq-item { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 12px; overflow: hidden; }
.pv-faq-q { width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-family: 'Poppins', sans-serif; font-size: .88rem; font-weight: 600; color: var(--pv-t1); cursor: pointer; text-align: left; gap: 12px; transition: background .2s; }
.pv-faq-q:hover { background: var(--pv-bg2); }
.pv-faq-q i { color: var(--pv-teal); flex-shrink: 0; transition: transform .3s; font-size: .78rem; }
.pv-faq-q.open i { transform: rotate(180deg); }
.pv-faq-a { padding: 0 20px; max-height: 0; overflow: hidden; font-size: .83rem; color: var(--pv-t2); line-height: 1.75; transition: max-height .35s ease, padding .35s ease; }
.pv-faq-a.open { max-height: 700px; padding: 0 20px 16px; }

.pv-blog-link { display: block; background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 13px; padding: 20px; text-decoration: none; transition: transform .25s, box-shadow .25s, border-color .25s; position: relative; overflow: hidden; }
.pv-blog-link::before { content:''; position: absolute; top:0; left:0; width: 3px; height:0; background: linear-gradient(to bottom, var(--pv-teal), var(--pv-orange)); transition: height .3s; }
.pv-blog-link:hover::before { height: 100%; }
.pv-blog-link:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,.08); border-color: rgba(0,128,128,.2); text-decoration: none; }
.pv-blog-link__tag { font-size: .66rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--pv-teal); margin-bottom: 8px; }
.pv-blog-link__title { font-size: .85rem; font-weight: 600; color: var(--pv-t1); line-height: 1.5; margin-bottom: 12px; }
.pv-blog-link__arrow { font-size: .76rem; font-weight: 700; color: var(--pv-orange); }

.pv-mobile-cta { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: var(--pv-card); border-top: 3px solid var(--pv-orange); padding: 10px 14px; z-index: 90; box-shadow: 0 -4px 20px rgba(0,0,0,.12); gap: 8px; }
.pv-mobile-cta.show { display: flex; }
.pv-mobile-cta a { flex: 1; text-align: center; padding: 11px 8px; border-radius: 9px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .8rem; text-decoration: none; }
.pv-mobile-cta a.whatsapp { background: #25D366; color:#fff; }
.pv-mobile-cta a.book { background: linear-gradient(135deg, #FF5C00, #ff8840); color:#fff; }

@media(max-width:860px){ .pv-section { padding: 56px 0; } .pv-cta { padding: 56px 0; } }
@media(max-width:480px){ .pv-hero__cta { flex-direction: column; } .pv-risk-banner { flex-direction: column; gap: 10px; } }
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
                <li style="color:#fff; font-weight:500;">Property Verification Service</li>
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
                Hire Lucknow's Independent Property Verifier
            </div>

            <h1 class="pv-hero__h1">
                Property Verification in<br>
                Lucknow – <em>LDA, Registry</em><br>
                &amp; RERA Checked
            </h1>

            <p class="pv-hero__sub">
                Don't pay ₹50 lakhs without spending ₹5,000 on independent verification. We physically check LDA allotment, registry, encumbrance, RERA, mutation and court records — at source, not just online. <strong style="color:#fff;">PDF report in 48 hours.</strong>
            </p>

            <div class="pv-hero__cta">
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B95%2C000%20property%20verification." class="pv-btn pv-btn--whatsapp">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Hire a Verifier — WhatsApp Us
                </a>
                <a href="#pricing" class="pv-btn pv-btn--ghost">See Pricing →</a>
            </div>

            <div class="pv-hero__pills">
                <div class="pv-pill"><i class="fas fa-clock"></i> 48-Hour PDF Report</div>
                <div class="pv-pill"><i class="fas fa-shield-alt"></i> Independent · No Bias</div>
                <div class="pv-pill"><i class="fas fa-globe"></i> NRI Verification</div>
            </div>
        </div>

        <div class="pv-hero__card">
            <div class="pv-hero__card-tag">RESIDENTIAL PLOT / FLAT</div>
            <div class="pv-hero__card-title">Hire a Lucknow Property Verifier</div>
            <div class="pv-hero__card-sub">Trained verifier physically checks documents at LDA, Sub-Registrar, Tehsil and court records. Detailed PDF report in 48 hours.</div>

            <div class="pv-hero__card-price">
                <span class="pv-hero__card-price-amt">₹5,000</span>
                <span class="pv-hero__card-price-lbl">all-inclusive · no hidden fees</span>
            </div>

            <ul class="pv-hero__card-list">
                <li>LDA allotment + registry cross-check</li>
                <li>30-year encumbrance certificate</li>
                <li>RERA + court case search</li>
                <li>Dakhil Kharij (mutation) verified</li>
                <li>Final verdict: Safe to Buy or Walk Away</li>
            </ul>

            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B95%2C000%20property%20verification." class="pv-hero__card-btn">Book ₹5,000 Verification on WhatsApp</a>
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

{{-- ═══════════ DIY VS HIRE ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Honest Comparison</span>
        <h2 class="pv-stitle pv-rv">Doing It Yourself vs. Hiring DSD Properties</h2>
        <p class="pv-ssub pv-rv">You can verify property documents yourself — many buyers try. Here's an honest look at what you save by hiring us, and what you risk if you don't.</p>

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
                <div>LDA office verification</div>
                <div class="pv-diy-bad">Online portal only</div>
                <div class="pv-diy-good">Physical visit, Gomti Nagar</div>
            </div>
            <div class="pv-diy-row">
                <div>Sub-Registrar encumbrance</div>
                <div class="pv-diy-bad">Hard to extract for 30 years</div>
                <div class="pv-diy-good">30-year certificate included</div>
            </div>
            <div class="pv-diy-row">
                <div>Tehsil mutation (Dakhil Kharij)</div>
                <div class="pv-diy-bad">Most buyers skip this</div>
                <div class="pv-diy-good">Physically verified at Tehsil</div>
            </div>
            <div class="pv-diy-row">
                <div>Court case search</div>
                <div class="pv-diy-bad">Difficult without legal access</div>
                <div class="pv-diy-good">District Court + HC Lucknow Bench</div>
            </div>
            <div class="pv-diy-row">
                <div>Trained eye for fraud patterns</div>
                <div class="pv-diy-bad">First-time buyer = blind spot</div>
                <div class="pv-diy-good">Pattern recognition across cases</div>
            </div>
            <div class="pv-diy-row">
                <div>Written evidence if dispute arises</div>
                <div class="pv-diy-bad">None — verbal only</div>
                <div class="pv-diy-good">PDF report admissible as evidence</div>
            </div>
        </div>

        <div style="max-width:780px; margin:28px auto 0; padding:18px 22px; background:#f0f9f9; border:1px solid rgba(0,128,128,.2); border-radius:12px; font-size:.86rem; line-height:1.75; color:var(--pv-t2);">
            <strong style="color:var(--pv-t1);">Honest take:</strong> If you have weekends to spare, legal connections, and have done this before — DIY is fine. For everyone else, ₹5,000 is the cheapest insurance you'll ever buy against a ₹50 lakh mistake.
        </div>

        <div style="text-align:center; margin-top:28px;">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B95%2C000%20property%20verification." class="pv-btn pv-btn--primary">Hire Us — Book Verification →</a>
        </div>
    </div>
</section>

{{-- ═══════════ HOW TO VERIFY PROPERTY DOCUMENTS ONLINE ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">DIY Guide</span>
        <h2 class="pv-stitle pv-rv">How We Verify Property Documents</h2>
        <p class="pv-ssub pv-rv">Whether you call it house verification, land document verification, or property paper verification — every property purchase needs the same checks before you pay token money. Here's how property verification online in Lucknow works, step by step, and where a property verification lawyer or verifier actually earns their fee.</p>

        <div class="pv-steps">
            <div class="pv-step pv-rv">
                <div class="pv-step__num">1</div>
                <div><h3>LDA Property Search by Address</h3><p>The first step is the free government portals — IGRSUP for registry search by the seller's name, the LDA website for allotment status by address. This confirms the basic ownership claim but won't reveal court cases, mortgages, or forged documents.</p></div>
            </div>
            <div class="pv-step pv-rv" style="--rd:.06s">
                <div class="pv-step__num">2</div>
                <div><h3>Lucknow Land Records & Khatauni Check</h3><p>Khatauni and Khasra records at the relevant Tehsil confirm plot dimensions and the current registered owner, and reveal whether mutation (Dakhil Kharij) has been done in the seller's name — the record most buyers never check.</p></div>
            </div>
            <div class="pv-step pv-rv" style="--rd:.12s">
                <div class="pv-step__num">3</div>
                <div><h3>Property Paper Check & Authenticity Verification</h3><p>Trace the sale deed chain back 30 years and pull a 30-year encumbrance certificate at the Sub-Registrar office. This property authenticity check Lucknow buyers rely on is what actually confirms the papers are genuine and the property carries no hidden mortgage or legal claim. A single missing or unregistered transfer anywhere in the chain can void the current owner's title.</p></div>
            </div>
            <div class="pv-step pv-rv" style="--rd:.18s">
                <div class="pv-step__num">4</div>
                <div><h3>Property Verification Online in Lucknow — Where It Falls Short</h3><p>Property verification online Lucknow portals cover ownership and allotment status, but a 30-year encumbrance certificate and a court case search at District Court and the HC Lucknow Bench usually need an in-person visit or an advocate's access — the gap that makes purely online verification incomplete.</p></div>
            </div>
        </div>

        <div style="max-width:780px; margin:28px auto 0; padding:18px 22px; background:#f0f9f9; border:1px solid rgba(0,128,128,.2); border-radius:12px; font-size:.86rem; line-height:1.75; color:var(--pv-t2);">
            <strong style="color:var(--pv-t1);">Where a property verification lawyer or verifier earns their ₹5,000:</strong> Steps 3 and 4 are hard to do purely online — encumbrance certificates and court case searches usually need an in-person visit or an advocate's access. That's the gap DSD Properties fills: everything above, done for you, physically verified, PDF report in 48 hours.
        </div>

        <div style="text-align:center; margin-top:28px;">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B95%2C000%20property%20verification." class="pv-btn pv-btn--primary">Get Your Documents Verified →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHAT WE CHECK FOR YOU ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What's Included</span>
        <h2 class="pv-stitle pv-rv">Our Verification Services</h2>
        <p class="pv-ssub pv-rv">Every verification includes physical document checks across multiple government offices — LDA, Sub-Registrar, Tehsil, Zila Panchayat, Revenue Courts, and more. You don't visit any of them. We do it, we document it, we hand you a PDF.</p>

        <div class="pv-check-grid">
            <div class="pv-check-card pv-rv">
                <div class="pv-check-card__icon">📐</div>
                <div>
                    <h2 class="pv-check-card__title">Plot Verification in Lucknow</h2>
                    <p class="pv-check-card__text">End-to-end plot verification — boundaries, khasra/gata number, physical possession, and cross-checks against LDA and Tehsil records so the plot on paper matches the plot on the ground.</p>
                    <div class="pv-check-card__where">LDA office + relevant Tehsil</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.03s">
                <div class="pv-check-card__icon">🏛️</div>
                <div>
                    <h2 class="pv-check-card__title">Property Ownership Verification Lucknow</h2>
                    <p class="pv-check-card__text">We physically check whether the seller's name matches <a href="/lda-schemes" style="color:inherit;text-decoration:underline;">LDA records</a>, whether the allotment is genuine, EMI status is clear, and the plot or flat has no cancellation notice against it.</p>
                    <div class="pv-check-card__where">LDA office, Gomti Nagar (verified in person)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">📄</div>
                <div>
                    <h2 class="pv-check-card__title">Registry Verification Lucknow Property</h2>
                    <p class="pv-check-card__text">Sale deed verified at Sub-Registrar and cross-referenced on the <a href="/blog/igrsup-lucknow-property-search-tutorial-hindi" style="color:inherit;text-decoration:underline;">IGRSUP portal</a>. We trace ownership back 30 years to ensure the chain is unbroken — the #1 cause of property disputes in Lucknow.</p>
                    <div class="pv-check-card__where">Sub-Registrar Office + IGRSUP portal</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.12s">
                <div class="pv-check-card__icon">📜</div>
                <div>
                    <h2 class="pv-check-card__title">Encumbrance Certificate Verification Lucknow</h2>
                    <p class="pv-check-card__text">A 30-year <a href="/blog/encumbrance-certificate-lucknow-how-to-apply-online" style="color:inherit;text-decoration:underline;">encumbrance certificate</a> extracted at the Sub-Registrar office reveals any hidden bank loans, mortgages, or registered legal claims against the property — invisible without this check.</p>
                    <div class="pv-check-card__where">Sub-Registrar Office (extracted manually)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.18s">
                <div class="pv-check-card__icon">🗺️</div>
                <div>
                    <h2 class="pv-check-card__title">Dakhil Kharij (Mutation) Verification Lucknow</h2>
                    <p class="pv-check-card__text">Khatauni and Khasra revenue records cross-checked at the relevant Tehsil. Most importantly — we confirm <a href="/blog/dakhil-kharij-lucknow-mutation-process-guide" style="color:inherit;text-decoration:underline;">Dakhil Kharij (mutation)</a> is done in the current seller's name. Skip this and the property becomes unsellable.</p>
                    <div class="pv-check-card__where">Tehsil (Sadar / BKT / Mohanlalganj / Malihabad)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.04s">
                <div class="pv-check-card__icon">🏗️</div>
                <div>
                    <h2 class="pv-check-card__title">RERA Registration Verification Lucknow</h2>
                    <p class="pv-check-card__text">For any builder project, we verify the RERA registration on the official UP-RERA portal — including complaint history, completion timeline, and any orders against the builder. A hoarding RERA number is not proof. <a href="/blog/up-rera-complaint-process-lucknow-2026" style="color:inherit;text-decoration:underline;">How to file a UP-RERA complaint →</a></p>
                    <div class="pv-check-card__where">UP-RERA portal (up-rera.in)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.08s">
                <div class="pv-check-card__icon">🏘️</div>
                <div>
                    <h2 class="pv-check-card__title">Zila Panchayat Approval Verification Lucknow</h2>
                    <p class="pv-check-card__text">For plots outside LDA jurisdiction, we confirm the layout is approved by the Zila Panchayat, not just a private colonizer's map — a distinction that determines whether you can legally get a building permit or a bank loan later.</p>
                    <div class="pv-check-card__where">Zila Panchayat office (relevant block)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.10s">
                <div class="pv-check-card__icon">⚖️</div>
                <div>
                    <h2 class="pv-check-card__title">Property Litigation Search Lucknow</h2>
                    <p class="pv-check-card__text">Pending litigation, partition suits, and historical disputes checked at Lucknow District Court and Allahabad High Court Lucknow Bench. Sellers don't always disclose active cases — we find them.</p>
                    <div class="pv-check-card__where">District Court + HC Lucknow Bench</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.16s">
                <div class="pv-check-card__icon">📑</div>
                <div>
                    <h2 class="pv-check-card__title">Form 41 & Form 45 (CH-41 & CH-45) Verification</h2>
                    <p class="pv-check-card__text">We extract and verify Form CH-41 (Consolidation Map) and Form CH-45 (Final Consolidation Scheme) to confirm the exact boundaries, physical shape, and original ownership of the plot post-consolidation (Chakbandi). This prevents buying land that exists only on paper but overlaps with public land on the ground.</p>
                    <div class="pv-check-card__where">Relevant Tehsil Office & Consolidation Officer (CO) Records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.22s">
                <div class="pv-check-card__icon">🔗</div>
                <div>
                    <h2 class="pv-check-card__title">Chain Deed & Moina (Inspection)</h2>
                    <p class="pv-check-card__text">We conduct a manual Moina (inspection of index registers) at the Sub-Registrar office to pull the complete physical history of the property. We verify every single link in the Chain Deed — from the original allottee to the current seller — ensuring that every transfer was legally executed, stamped, and registered.</p>
                    <div class="pv-check-card__where">Sub-Registrar Office Records (Manual Index Search)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.34s">
                <div class="pv-check-card__icon">🏛️</div>
                <div>
                    <h2 class="pv-check-card__title">Wad-Vivad Search (Litigation Free)</h2>
                    <p class="pv-check-card__text">We run a comprehensive search against the property's specific Khasra and Gata numbers across revenue courts to ensure it is completely free of Wad-Vivad (active litigation). We scan for pending stay orders, family partition suits, or land ceiling disputes that do not show up on standard registry portals.</p>
                    <div class="pv-check-card__where">Board of Revenue, Commissioner Court, and Lucknow Tehsil Revenue Courts</div>
                </div>
            </div>
        </div>

        <div style="margin-top:32px; text-align:center;">
            <p style="font-size:.86rem; color:var(--pv-t2); max-width:660px; margin:0 auto 18px; line-height:1.7;">Every check above takes time, expertise, and physical presence. We do it for you in 48 hours flat.</p>
            <a href="#pricing" class="pv-btn pv-btn--primary">See ₹5,000 Pricing →</a>
        </div>
    </div>
</section>

{{-- ═══════════ DOCUMENT CHECKLIST ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)" id="checklist">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Buyer's Checklist</span>
        <h2 class="pv-stitle pv-rv">8 Documents Every Lucknow Buyer Must Verify</h2>
        <p class="pv-ssub pv-rv">Whether it's an LDA allotment, a builder flat, or a private plot — these are the eight checks that separate a safe deal from a future court case. We cover all eight in the ₹5,000 verification.</p>

        <div class="pv-doc-grid">
            <div class="pv-doc-item pv-rv"><div class="pv-doc-num">1</div><div><div class="pv-doc-title">Sale Deed & 30-Year Title Chain</div><p class="pv-doc-desc">Trace ownership back to the original land holder. A broken chain is the #1 cause of disputes in Lucknow.</p></div></div>
            <div class="pv-doc-item pv-rv" style="--rd:.04s"><div class="pv-doc-num">2</div><div><div class="pv-doc-title">Encumbrance Certificate</div><p class="pv-doc-desc">Confirms no bank loan, mortgage, or registered legal claim against the property.</p></div></div>
            <div class="pv-doc-item pv-rv" style="--rd:.08s"><div class="pv-doc-num">3</div><div><div class="pv-doc-title">Khatauni & Khasra Records</div><p class="pv-doc-desc">Plot number, dimensions and current owner verified at Tehsil land records.</p></div></div>
            <div class="pv-doc-item pv-rv" style="--rd:.12s"><div class="pv-doc-num">4</div><div><div class="pv-doc-title">LDA Allotment / Approval</div><p class="pv-doc-desc">Cross-checked at LDA office — not just a photocopy of an allotment letter.</p></div></div>
            <div class="pv-doc-item pv-rv" style="--rd:.16s"><div class="pv-doc-num">5</div><div><div class="pv-doc-title">RERA Registration</div><p class="pv-doc-desc">Mandatory for all builder projects. Verified directly on up-rera.in — hoardings don't count.</p></div></div>
            <div class="pv-doc-item pv-rv" style="--rd:.20s"><div class="pv-doc-num">6</div><div><div class="pv-doc-title">Dakhil Kharij (Mutation)</div><p class="pv-doc-desc">Confirms the seller is the registered owner in revenue records. Skip this and resale becomes impossible.</p></div></div>
            <div class="pv-doc-item pv-rv" style="--rd:.24s"><div class="pv-doc-num">7</div><div><div class="pv-doc-title">Court Case Search</div><p class="pv-doc-desc">Pending litigation checked at Lucknow District Court and the Allahabad HC Lucknow Bench.</p></div></div>
            <div class="pv-doc-item pv-rv" style="--rd:.28s"><div class="pv-doc-num">8</div><div><div class="pv-doc-title">Property Tax & NOC</div><p class="pv-doc-desc">Tax receipts up to date, plus society/builder/co-owner NOCs as applicable.</p></div></div>
        </div>
    </div>
</section>

{{-- ═══════════ WHY ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Why It Matters</span>
        <h2 class="pv-stitle pv-rv">Why Property Verification Matters</h2>
        <p class="pv-ssub pv-rv">Property fraud in Lucknow follows four patterns. A professional verification catches all four — before you pay token money, not after.</p>

        <h3 style="text-align:center; font-size:1.1rem; font-weight:700; color:var(--pv-t1); margin-bottom:20px;">Prevent Property Fraud in Lucknow</h3>
        <div class="pv-risk-grid">
            <div class="pv-risk-card pv-rv"><div class="pv-risk-icon">⚠️</div><div><div class="pv-risk-title">Ownership Disputes</div><p class="pv-risk-text">Plot sold by someone who doesn't legally own it — common in inherited properties with multiple heir claims.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.06s"><div class="pv-risk-icon">⚖️</div><div><div class="pv-risk-title">Pending Court Cases</div><p class="pv-risk-text">Active litigation the seller never disclosed. Once you sign, the case becomes yours to fight for 5–10 years.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.12s"><div class="pv-risk-icon">📄</div><div><div class="pv-risk-title">Fake Registry & Forged LDA Letters</div><p class="pv-risk-text">Fabricated sale deeds and fake LDA clearance certificates — common in fast-growing corridors like <a href="/blog/plots-sultanpur-road-lucknow-2026" style="color:inherit;text-decoration:underline;">Sultanpur Road</a> and <a href="/blog/mohanlalganj-plot-verification-lucknow-2026" style="color:inherit;text-decoration:underline;">Mohanlalganj</a>.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.18s"><div class="pv-risk-icon">🚫</div><div><div class="pv-risk-title">Hidden Mortgages</div><p class="pv-risk-text">Bank loans or legal claims registered against the property — invisible without a 30-year encumbrance certificate.</p></div></div>
        </div>

        <h3 style="text-align:center; font-size:1.1rem; font-weight:700; color:var(--pv-t1); margin:32px 0 20px;">Safe Property Purchase with Legal Verification</h3>
        <div class="pv-risk-banner pv-rv">
            <div class="pv-risk-banner-icon">❗</div>
            <div>
                <div class="pv-risk-banner-title">The Real Cost of Skipping Verification</div>
                <div class="pv-risk-banner-text">₹5–10 lakh in legal fees · 2–5 years in court · Property becomes unsellable · Total investment at risk · Mental and family stress that never goes away</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ PROCESS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Simple Process</span>
        <h2 class="pv-stitle pv-rv">How to Hire DSD for Property Verification — 5 Steps, 48 Hours</h2>
        <p class="pv-ssub pv-rv">From first WhatsApp message to PDF report. Transparent at every step.</p>

        <div class="pv-steps">
            <div class="pv-step pv-rv"><div class="pv-step__num">1</div><div><h3>WhatsApp Free Preliminary Check</h3><p>Send the property address and seller's name on WhatsApp. We do a free preliminary LDA + IGRSUP check within 2 hours and tell you honestly if a full verification is worth doing.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.06s"><div class="pv-step__num">2</div><div><h3>Share Available Documents</h3><p>Sale deed, registry copy, allotment letter, Khatauni, RERA number — whatever you have. Even just the address is enough to start.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.12s"><div class="pv-step__num">3</div><div><h3>Pay Verification Fee</h3><p>₹5,000 for residential plots and flats, ₹7,000 for commercial, ₹10,000 for premium with site visit. UPI or bank transfer. Invoice issued.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.18s"><div class="pv-step__num">4</div><div><h3>We Verify at Source</h3><p>Our team physically checks documents at LDA office, Sub-Registrar, Tehsil, court records and the LDA Illegal Colony List — not just online portals.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.24s"><div class="pv-step__num">5</div><div><h3>Detailed PDF Report</h3><p>A clear report with every check performed, any red flags found, and a verdict: <strong>"Safe to Buy"</strong> or <strong>"Do Not Proceed."</strong> Delivered in 48 hours.</p></div></div>
        </div>
    </div>
</section>

{{-- ═══════════ REPORT PREVIEW ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What You Get</span>
        <h2 class="pv-stitle pv-rv">Property Verification Report – Delivered in 48 Hours</h2>
        <p class="pv-ssub pv-rv">A sample property verification report Lucknow buyers receive from us — clear, evidence-backed, and admissible if a dispute arises later.</p>

        <div class="pv-report pv-rv">
            <div class="pv-report__header">
                <div>
                    <h3 class="pv-report__title">Property Verification Report — Sample</h3>
                    <p class="pv-report__subtitle">Plot 247, Sector 6, Vrindavan Yojna · LDA-allotted · Verified 12 May 2026</p>
                </div>
                <span class="pv-report__verdict">✓ SAFE TO BUY</span>
            </div>
            <div class="pv-report__body">
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>LDA Allotment</strong>Seller's name matches LDA records. EMI cleared. No cancellation notice.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>30-Year Title Chain</strong>Unbroken chain from original allotment (1998) to current owner (2024).</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Encumbrance (30-year)</strong>No mortgage, no bank loan, no legal claim registered.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Khatauni & Mutation</strong>Plot dimensions match. Dakhil Kharij done in current seller's name.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Court Cases</strong>No pending litigation at District Court or HC Lucknow Bench.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Illegal Colony List</strong>Not on LDA's 241-colony blacklist. Property tax current.</div></div>
            </div>
            <div class="pv-report__footer">Sample report — actual reports include scanned evidence, registry copies, and verifier signature.</div>
        </div>

        {{-- Real sample report (10-page PDF built from actual documents with personal details hidden).
             Opens directly, no form: on this page trust matters more than capturing the lead. --}}
        @php $pvSample = asset('downloads/DSD-Property-Verification-Sample-Report-Lucknow.pdf'); @endphp
        <style>
            .pv-sample { max-width: 980px; margin: 40px auto 0; background: #fff; border: 1px solid var(--pv-border, #e5e7eb); border-radius: 18px; padding: 28px 26px; }
            .pv-sample__head { text-align: center; max-width: 640px; margin: 0 auto 22px; }
            .pv-sample__head h3 { font-size: 1.45rem; font-weight: 800; color: var(--pv-t1, #011f4b); margin: 0 0 8px; }
            .pv-sample__head p { font-size: .95rem; color: var(--pv-t2, #4b5563); line-height: 1.7; margin: 0; }
            .pv-sample__pages { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
            .pv-sample__page { display: block; text-decoration: none; color: inherit; }
            .pv-sample__page img { width: 100%; height: auto; aspect-ratio: 639 / 905; border-radius: 10px; border: 1px solid #e5e7eb; box-shadow: 0 10px 26px rgba(1,31,75,.12); transition: transform .2s, box-shadow .2s; }
            .pv-sample__page:hover img { transform: translateY(-4px); box-shadow: 0 16px 34px rgba(1,31,75,.18); }
            .pv-sample__page span { display: block; text-align: center; font-size: .85rem; font-weight: 600; color: var(--pv-t2, #4b5563); margin-top: 10px; }
            .pv-sample__list { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin: 22px 0 0; padding: 0; list-style: none; }
            .pv-sample__list li { font-size: .82rem; font-weight: 600; background: #effaf9; color: #036b6b; border-radius: 999px; padding: 6px 12px; }
            .pv-sample__btns { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 22px; }
            .pv-sample__note { text-align: center; font-size: .78rem; color: var(--pv-t2, #6b7280); margin: 14px 0 0; }
            @media (max-width: 640px) {
                .pv-sample { padding: 22px 16px; }
                .pv-sample__pages { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px; }
                .pv-sample__page span { font-size: .72rem; }
                .pv-sample__btns .pv-btn { width: 100%; justify-content: center; }
            }
        </style>
        <div class="pv-sample pv-rv" id="sample-report">
            <div class="pv-sample__head">
                <h3>See the report you'll get</h3>
                <p>A real sample of our verification report, made from actual Lucknow land records with names and personal details hidden. It shows each of the 6 checks we run, what we look for, and how the result is written.</p>
            </div>
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
            <ul class="pv-sample__list">
                <li>Form 41 (comparative khasra)</li>
                <li>Form 45 (ownership record)</li>
                <li>Encumbrance certificate &amp; registry index</li>
                <li>Court case search</li>
                <li>Map &amp; revenue record check</li>
                <li>LDA approval</li>
            </ul>
            <div class="pv-sample__btns">
                <a href="{{ $pvSample }}" target="_blank" rel="noopener" class="pv-btn pv-btn--primary">View sample report (PDF)</a>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B95%2C000%20property%20verification." target="_blank" rel="noopener" class="pv-btn pv-btn--whatsapp">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    Start verification on WhatsApp
                </a>
            </div>
            <p class="pv-sample__note">10-page PDF in Hindi · ₹5,000 for residential plots and flats · report in 48 hours</p>
        </div>

        <div style="max-width:780px; margin:32px auto 0; padding:22px 24px; background:var(--pv-bg2); border:1px solid var(--pv-border); border-radius:14px;">
            <h3 style="font-size:1rem; font-weight:700; color:var(--pv-t1); margin:0 0 8px;">Property Valuation Services Near Me (Lucknow)</h3>
            <p style="font-size:.85rem; color:var(--pv-t2); line-height:1.7; margin:0 0 14px;">Need to know what a Lucknow plot or flat is actually worth before you negotiate — not just what the seller is asking? We provide a data-backed valuation alongside verification, using the same ward-level circle rates and recent registry data we pull during document checks.</p>
            <a href="/" class="pv-btn pv-btn--primary" style="font-size:.8rem; padding:10px 20px;">Get a Free Property Valuation →</a>
        </div>

        {{-- <div style="text-align:center; margin-top:32px;">
            <a href="https://wa.me/918595002933?text=Hi%2C%20please%20send%20the%20sample%20report." class="pv-btn pv-btn--whatsapp">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                Request Full Sample Report
            </a>
        </div> --}}
    </div>
</section>

{{-- ═══════════ HINDI BLOCK ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">हिंदी में</span>
        <h2 class="pv-stitle pv-rv">लखनऊ में प्रॉपर्टी सत्यापन सेवा — हिंदी में</h2>
        <p class="pv-ssub pv-rv">अगर आप लखनऊ में प्लॉट या फ्लैट खरीद रहे हैं, तो टोकन देने से पहले ये पढ़ें।</p>

        <div class="pv-hindi pv-rv">
            <h3>क्या आप LDA प्लॉट या रजिस्ट्री खरीदने जा रहे हैं?</h3>
            <p>लखनऊ में हर महीने सैकड़ों खरीदार बिना सत्यापन के प्रॉपर्टी खरीदते हैं — और बाद में पता चलता है कि <strong>बैनामा नकली था</strong>, <strong>रजिस्ट्री में नाम अलग है</strong>, या <strong>दाखिल खारिज नहीं हुआ</strong>। नतीजा: 5–10 साल की कोर्ट लड़ाई, ₹5–10 लाख का वकील खर्च, और प्रॉपर्टी बेच भी नहीं सकते।</p>
            <p><strong>DSD Properties क्या करता है?</strong> सिर्फ <strong>₹5,000</strong> में हम आपकी प्रॉपर्टी के पूरे कागज जांचते हैं — LDA दफ्तर जाकर, सब-रजिस्ट्रार ऑफिस में बैनामा देखकर, तहसील में खतौनी और दाखिल खारिज की जांच करके। 48 घंटे में आपको पूरी PDF रिपोर्ट मिलती है — "खरीदना सुरक्षित है" या "मत खरीदिए"।</p>
            <p><strong>NRI हैं?</strong> कोई बात नहीं — हम विदेश से भी काम करते हैं। आप WhatsApp पर कागज भेजिए, हम लखनऊ में जाकर सब कुछ चेक करते हैं।</p>
            <div class="pv-hindi__cta">
                <a href="https://wa.me/918595002933?text=Namaste%2C%20property%20verification%20karwana%20hai." class="pv-btn pv-btn--whatsapp">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    हिंदी में WhatsApp करें
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ PRICING ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)" id="pricing">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Cost &amp; Reports</span>
        <h2 class="pv-stitle pv-rv">Property Verification Charges in Lucknow</h2>
        <p class="pv-ssub pv-rv">Fixed pricing. No per-document charges. No hidden fees. Free preliminary check before you commit.</p>

        <div class="pv-pricing-grid">
            <div class="pv-price-card pv-rv">
                <div class="pv-price-tag">RESIDENTIAL</div>
                <div class="pv-price-name">Plot / Flat</div>
                <div class="pv-price-amount">₹5,000</div>
                <div class="pv-price-desc">What most buyers need</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check fas fa-check"></span> LDA + IGRSUP + Tehsil check</li>
                    <li><span class="pv-price-check fas fa-check"></span> 30-year title chain</li>
                    <li><span class="pv-price-check fas fa-check"></span> Encumbrance certificate</li>
                    <li><span class="pv-price-check fas fa-check"></span> Court case search</li>
                    <li><span class="pv-price-check fas fa-check"></span> Dakhil Kharij verification</li>
                    <li><span class="pv-price-check fas fa-check"></span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B95%2C000%20property%20verification." class="pv-price-btn">Book ₹5,000 →</a>
            </div>

            <div class="pv-price-card pv-price-card--featured pv-rv" style="--rd:.08s">
                <div class="pv-price-badge">PREMIUM</div>
                <div class="pv-price-tag">SITE VISIT</div>
                <div class="pv-price-name">Full Site Inspection</div>
                <div class="pv-price-amount">₹10,000</div>
                <div class="pv-price-desc">For NRIs & high-value plots</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check fas fa-check"></span> Everything in Residential</li>
                    <li><span class="pv-price-check fas fa-check"></span> Physical site inspection</li>
                    <li><span class="pv-price-check fas fa-check"></span> Boundary measurement</li>
                    <li><span class="pv-price-check fas fa-check"></span> Photo + video evidence</li>
                    <li><span class="pv-price-check fas fa-check"></span> Neighbour verification</li>
                    <li><span class="pv-price-check fas fa-check"></span> Priority 48-hour delivery</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B910%2C000%20premium%20verification." class="pv-price-btn pv-price-btn--white">Book Premium →</a>
            </div>

            <div class="pv-price-card pv-rv" style="--rd:.16s">
                <div class="pv-price-tag">COMMERCIAL</div>
                <div class="pv-price-name">Shop / Office / Plot</div>
                <div class="pv-price-amount">₹7,000</div>
                <div class="pv-price-desc">For commercial buyers</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check fas fa-check"></span> Everything in Residential</li>
                    <li><span class="pv-price-check fas fa-check"></span> Land-use & zoning check</li>
                    <li><span class="pv-price-check fas fa-check"></span> Commercial clearances</li>
                    <li><span class="pv-price-check fas fa-check"></span> GST/trade licence check</li>
                    <li><span class="pv-price-check fas fa-check"></span> Master Plan compliance</li>
                    <li><span class="pv-price-check fas fa-check"></span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B97%2C000%20commercial%20verification." class="pv-price-btn">Book ₹7,000 →</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ INTERNAL BLOG LINKS — spoke layer ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Learn More</span>
        <h2 class="pv-stitle pv-rv">Want to Understand Before You Buy?</h2>
        <p class="pv-ssub pv-rv">Read our detailed guides on each verification step. These are the same documents we check inside the ₹5,000 service.</p>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:16px;">
            <a href="/blog/check-property-ownership-records-lucknow" class="pv-blog-link pv-rv">
                <div class="pv-blog-link__tag">LDA Search Guide</div>
                <div class="pv-blog-link__title">LDA Property Search by Name Lucknow — Complete Guide</div>
                <div class="pv-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/igrsup-lucknow-property-search-tutorial-hindi" class="pv-blog-link pv-rv" style="--rd:.04s">
                <div class="pv-blog-link__tag">IGRSUP Hindi</div>
                <div class="pv-blog-link__title">IGRSUP सम्पत्ति खोजें — विक्रेता के नाम से रजिस्ट्री देखें</div>
                <div class="pv-blog-link__arrow">पढ़ें →</div>
            </a>
            <a href="/blog/bainama-vs-registry-vs-power-of-attorney-lucknow-2026" class="pv-blog-link pv-rv" style="--rd:.08s">
                <div class="pv-blog-link__tag">Document Types</div>
                <div class="pv-blog-link__title">Bainama vs Registry vs Power of Attorney — Which Is Legal?</div>
                <div class="pv-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/encumbrance-certificate-lucknow-how-to-apply-online" class="pv-blog-link pv-rv" style="--rd:.12s">
                <div class="pv-blog-link__tag">Encumbrance</div>
                <div class="pv-blog-link__title">Encumbrance Certificate Lucknow — How to Apply Online</div>
                <div class="pv-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/dakhil-kharij-lucknow-mutation-process-guide" class="pv-blog-link pv-rv" style="--rd:.16s">
                <div class="pv-blog-link__tag">Mutation</div>
                <div class="pv-blog-link__title">Dakhil Kharij Lucknow — Mutation Process Guide</div>
                <div class="pv-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/how-to-check-lda-approved-map-lucknow-2026" class="pv-blog-link pv-rv" style="--rd:.20s">
                <div class="pv-blog-link__tag">LDA Map Check</div>
                <div class="pv-blog-link__title">How to Check LDA Approved Map in Lucknow 2026</div>
                <div class="pv-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/lda-illegal-colony-list-lucknow-2026" class="pv-blog-link pv-rv" style="--rd:.24s">
                <div class="pv-blog-link__tag">Illegal Colonies</div>
                <div class="pv-blog-link__title">241 Illegal Colonies in Lucknow — Full LDA List</div>
                <div class="pv-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/top-10-property-frauds-lucknow-2026-real-cases" class="pv-blog-link pv-rv" style="--rd:.28s">
                <div class="pv-blog-link__tag">Fraud Cases</div>
                <div class="pv-blog-link__title">Top 10 Property Frauds in Lucknow — Real Cases & Red Flags</div>
                <div class="pv-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/lda-online-property-verification-lucknow-2026" class="pv-blog-link pv-rv" style="--rd:.32s">
                <div class="pv-blog-link__tag">LDA Verification</div>
                <div class="pv-blog-link__title">LDA Online Property Verification Lucknow — Step-by-Step</div>
                <div class="pv-blog-link__arrow">Read Guide →</div>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════ SERVICE AREAS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Coverage</span>
        <h2 class="pv-stitle pv-rv">Property Verification Across All Lucknow Areas</h2>
        <p class="pv-ssub pv-rv">Property verification services in Sultanpur Road, Shaheed Path, Gomti Nagar Extension, IT City, Vrindavan Yojna, and every other Lucknow locality — from central areas to emerging corridors on the city's outskirts. Tehsil verification done at the relevant local office.</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-top:8px;">
            <a href="/blog/plots-sultanpur-road-lucknow-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Sultanpur Road
            </a>
            <a href="/blog/plots-kanpur-road-lucknow-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Kanpur Road
            </a>
            <a href="/blog/plots-raebareli-road-lucknow-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Raebareli Road
            </a>
            <a href="/blog/kisan-path-lucknow-investment-map-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Kisan Path
            </a>
            <a href="/blog/gomti-nagar-extension-lucknow-guide-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Gomti Nagar Extension
            </a>
            <a href="/blog/vrindavan-yojna-lucknow-investment-guide-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Vrindavan Yojna
            </a>
            <a href="/blog/it-city-lucknow-lda-plots-guide-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> IT City
            </a>
            <a href="/blog/why-invest-in-vibhuti-khand-lucknow-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Vibhuti Khand
            </a>
            <a href="/blog/mohanlalganj-plot-verification-lucknow-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Mohanlalganj
            </a>
            <a href="/blog/kisan-path-plot-verification-lucknow-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Kisan Path (Verification)
            </a>
            <a href="/blog/kanpur-road-plot-documents-lucknow-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Kanpur Road (Documents)
            </a>
            <a href="/blog/raebareli-road-plot-documents-lucknow-2026" style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#1e293b;font-size:.86rem;font-weight:600;transition:border-color .2s;" onmouseover="this.style.borderColor='#011f4b'" onmouseout="this.style.borderColor='#e2e8f0'">
                <span style="font-size:1.1rem;">📍</span> Raebareli Road (Documents)
            </a>
        </div>
    </div>
</section>

{{-- ═══════════ FAQ ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">FAQs</span>
        <h2 class="pv-stitle pv-rv">Property Verification FAQs in Lucknow – Cost, Process &amp; Lawyer Guide</h2>
        <p class="pv-ssub pv-rv">Real questions buyers ask before hiring us. If yours isn't here, just WhatsApp.</p>

        <div style="max-width:780px; margin:0 auto; display:flex; flex-direction:column; gap:10px;">
            <div class="pv-faq-item pv-rv"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>How Much Do Property Legal Verification Services Cost?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">₹5,000 for residential plots and flats, ₹7,000 for commercial properties, ₹10,000 for the premium package with physical site inspection. All packages include a PDF report within 48 hours. No per-document charges or hidden fees.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.04s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>Why should I hire a verifier instead of doing it myself?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">Doing it yourself is free but takes 2-3 weekends and only covers online portals. A professional verifier physically visits the LDA office, Sub-Registrar, Tehsil and district court — where fraud is actually caught. You also get a written PDF report admissible as evidence, and a trained eye that has seen the patterns most first-time buyers miss.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.08s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>What is the verification process?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">Five steps: (1) Free preliminary consultation on WhatsApp within 2 hours, (2) Share property address and any documents, (3) Pay ₹5,000 verification fee via UPI or bank transfer, (4) We physically verify documents at LDA, Sub-Registrar, Tehsil and court records over 48 hours, (5) You receive a detailed PDF report with a clear verdict — Safe to Buy or Red Flags Found.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.12s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>How long does verification take?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">Standard verification takes 48 hours from document receipt. The premium ₹10,000 package with site visit takes 3-5 days because of the physical inspection and video walkthrough. Preliminary WhatsApp check is free and replies within 2 hours.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.16s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>What's Included in a Property Due Diligence Report?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">LDA allotment status, 30-year sale deed chain, <a href="/blog/encumbrance-certificate-lucknow-how-to-apply-online" style="color:inherit;text-decoration:underline;">encumbrance certificate</a>, Khatauni and revenue records, <a href="/blog/dakhil-kharij-lucknow-mutation-process-guide" style="color:inherit;text-decoration:underline;">Dakhil Kharij confirmation</a>, RERA registration check (for builder projects), court case search at District Court and HC Lucknow Bench, LDA Illegal Colony List check, and a final verdict — Safe to Buy or Red Flags Found — with specific reasons.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.20s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>Can NRIs hire DSD from abroad?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">Yes. NRI verifications are routine. You WhatsApp documents from anywhere in the world, we physically verify in Lucknow, and send the PDF report. The ₹10,000 premium package adds a site visit with photo evidence and a video walkthrough — useful when you can't visit Lucknow yourself.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.24s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>Should I hire a property lawyer or a verification service?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">For pre-purchase due diligence, a verification service is faster and cheaper — ₹5,000 with a 48-hour PDF report. Hire a property lawyer when you have an active dispute, partition case, or need court representation. Most buyers need verification, not litigation. Many use verification first and only consult a lawyer if red flags are found.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.28s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>What documents do I need to share to start?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">The property address and seller's full name are enough to start. If you have documents — sale deed, registry, allotment letter, Khatauni, RERA number — share them on WhatsApp at +91-8595002933. We do a free preliminary check before you commit to the ₹5,000 full verification.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.32s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>Do you cover areas outside central Lucknow?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">Yes. We cover all of Lucknow district — <a href="/blog/plots-sultanpur-road-lucknow-2026">Sultanpur Road</a>, <a href="/blog/kisan-path-lucknow-investment-map-2026">Kisan Path</a>, <a href="/blog/mohanlalganj-plot-verification-lucknow-2026">Mohanlalganj</a>, <a href="/blog/plots-kanpur-road-lucknow-2026">Kanpur Road</a>, Faizabad Road, <a href="/blog/plots-raebareli-road-lucknow-2026">Raebareli Road</a>, Bakshi Ka Talab, Malihabad and surrounding areas. Tehsil verification is done at the relevant local Tehsil. No extra charge for distance within Lucknow district.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.36s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>What if you find problems with my property?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">If we find red flags — disputed title, pending litigation, hidden mortgage, fake LDA letter, missing mutation — we document everything in the PDF report with evidence (registry copies, court case numbers, encumbrance certificate). You can show this to the seller, walk away from the deal, or take it to a property lawyer for further action.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.40s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>How to Verify Property Documents Online in Lucknow?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">Start with the free government portals — <a href="/blog/igrsup-lucknow-property-search-tutorial-hindi" style="color:inherit;text-decoration:underline;">IGRSUP</a> for registry search and the LDA website for allotment status. This covers basic ownership, but a 30-year <a href="/blog/encumbrance-certificate-lucknow-how-to-apply-online" style="color:inherit;text-decoration:underline;">encumbrance certificate</a> and court case search usually need an in-person visit or an advocate's access, which is what makes purely online verification incomplete. DSD Properties does both — the online checks and the in-person ones — and sends a PDF report in 48 hours.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.44s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>What's the difference between house verification and land document verification?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">House verification (for a flat or built-up property) additionally checks RERA registration, occupancy certificate, and builder dues. Land document verification (for a plot) focuses more heavily on Khatauni, Khasra records, and mutation (Dakhil Kharij) at the Tehsil. Both share the same core: 30-year title chain, encumbrance certificate, and court case search. Our ₹5,000 verification covers both.</div></div>

            <div class="pv-faq-item pv-rv" style="--rd:.48s"><button class="pv-faq-q" onclick="pvToggleFaq(this)"><span>Do I Need a Property Verification Lawyer in Lucknow?</span><i class="fas fa-chevron-down"></i></button><div class="pv-faq-a">For pre-purchase property legal verification — checking title, encumbrance, mutation and court records — a verification service is faster and cheaper than hiring a lawyer directly, and our reports are prepared with advocate input. You'd need a separate property lawyer only if a dispute is already active or you need court representation, not for standard due diligence before buying.</div></div>
        </div>
    </div>
</section>

{{-- ═══════════ GOOGLE REVIEWS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff); padding-bottom:0;">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Reviews &amp; Trust</span>
        <h2 class="pv-stitle pv-rv">Verified by Buyers in Lucknow</h2>
        <p class="pv-ssub pv-rv">Transparent property verification service — real reviews from buyers who booked before signing.</p>
    </div>
</section>
@include('components.google-reviews', ['googleReviews' => $googleReviews])

{{-- ═══════════ FINAL CTA ═══════════ --}}
<section class="pv-cta">
    <div class="pv-cta__orb"></div>
    <div class="pv-container pv-cta__inner">
        <h2 class="pv-rv">Hire a Lucknow Property Verifier Today</h2>
        <p class="pv-rv" style="--rd:.08s">Free preliminary WhatsApp check first. Pay ₹5,000 only if you want the full PDF verification. Most buyers convert within an hour of seeing our reply.</p>
        <div class="pv-cta__btns pv-rv" style="--rd:.16s">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B95%2C000%20property%20verification." class="pv-btn pv-btn--whatsapp">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                WhatsApp: +91-8595002933
            </a>
            <a href="tel:+918595002933" class="pv-btn pv-btn--ghost">📞 Call Now</a>
        </div>
    </div>
</section>

<div class="pv-mobile-cta" id="pv-mobile-cta">
    <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20%E2%82%B95%2C000%20property%20verification." class="whatsapp">💬 Hire on WhatsApp</a>
    <a href="#pricing" class="book">Book ₹5,000 →</a>
</div>

</div>{{-- /pv-wrap --}}

<script>
(function () {
    window.pvToggleFaq = function(btn) {
        var isOpen = btn.classList.contains('open');
        document.querySelectorAll('.pv-faq-q.open').forEach(function(b) {
            b.classList.remove('open');
            b.nextElementSibling.classList.remove('open');
        });
        if (!isOpen) { btn.classList.add('open'); btn.nextElementSibling.classList.add('open'); }
    };

    var rv = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) { e.target.classList.add('visible'); rv.unobserve(e.target); }
        });
    }, { threshold: 0.08 });
    document.querySelectorAll('.pv-rv').forEach(function(el) { rv.observe(el); });

    var mobileCta = document.getElementById('pv-mobile-cta');
    window.addEventListener('scroll', function() {
        if (window.innerWidth < 1024 && window.scrollY > 500) {
            mobileCta.classList.add('show');
        } else {
            mobileCta.classList.remove('show');
        }
    }, { passive: true });
})();
</script>

@endsection