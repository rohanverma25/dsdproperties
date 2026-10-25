@extends('layouts.user-app')

@section('title', 'Property Verification in Agra — ₹5,000, 48-Hour Report | DSD')
@section('meta_description', 'Buying property in Agra? We check ADA approval, Taj Trapezium Zone limits, flood zone and registry records. ₹5,000 fixed fee, PDF report in 48 hours.')
@section('meta_keywords', 'property verification service agra, property verifier agra, taj trapezium zone property check, ADA agra layout verification, property verification cost agra, cantonment land agra, agra property document check')

@section('canonical', 'https://dsdproperties.in/services/property-verification-agra')

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
  "areaServed": [
    { "@type": "City", "name": "Agra" }
  ],
  "sameAs": ["https://wa.me/918595002933"]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Property Verification Service",
  "name": "Professional Property Verification Service in Agra",
  "description": "Hire an independent property verifier in Agra. We check ADA (Agra Development Authority) layout approvals, Taj Trapezium Zone construction restrictions, Army Cantonment boundaries, Yamuna flood zone status, Supreme Court and NGT orders, Sub-Registrar encumbrance and court records. PDF report in 48 hours.",
  "provider": { "@id": "https://dsdproperties.in/#organization" },
  "areaServed": [
    { "@type": "City", "name": "Agra", "containedInPlace": { "@type": "State", "name": "Uttar Pradesh" } }
  ],
  "offers": [
    { "@type": "Offer", "name": "Residential Plot / Flat Verification", "price": "5000", "priceCurrency": "INR", "description": "ADA layout check, TTZ boundary check, Cantonment boundary, Yamuna flood zone, title chain, encumbrance. PDF in 48 hours." },
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
    { "@type": "Question", "name": "How much does property verification cost in Agra?",
      "acceptedAnswer": { "@type": "Answer", "text": "Property verification in Agra costs ₹5,000 for residential plots and flats, ₹7,000 for commercial properties, and ₹10,000 for the premium package with a physical site visit. PDF report delivered in 48 hours. No hidden charges." } },
    { "@type": "Question", "name": "What is the Taj Trapezium Zone (TTZ) and how does it affect Agra property?",
      "acceptedAnswer": { "@type": "Answer", "text": "The Taj Trapezium Zone is a 10,500 sq km eco-sensitive zone around the Taj Mahal demarcated by the Supreme Court of India to protect the monument from pollution, industrial activity and inappropriate construction. Properties within the TTZ are subject to strict restrictions — certain types of construction, industries and activities are prohibited or require special clearance. If your plot falls within the TTZ, construction approvals and land use are heavily restricted. We check TTZ boundary status for every Agra property verification." } },
    { "@type": "Question", "name": "What is the ASI protected monument zone and how large is the no-construction buffer?",
      "acceptedAnswer": { "@type": "Answer", "text": "Archaeological Survey of India (ASI) rules prohibit any construction within 100 metres of a centrally protected monument and regulate construction within a 200-metre zone. Agra has more centrally protected monuments per square kilometre than almost any other Indian city — the Taj Mahal, Agra Fort, Itmad-ud-Daulah, Akbar's Tomb in Sikandra, Ram Bagh, and several others. We check whether your plot falls within any ASI-protected monument buffer zone — information not available on any property portal." } },
    { "@type": "Question", "name": "Can I buy property inside Agra Cantonment?",
      "acceptedAnswer": { "@type": "Answer", "text": "Agra Cantonment is one of the largest army cantonments in India. Land inside the Cantonment boundary is under the jurisdiction of the Cantonment Board, not ADA. Transfer of cantonment land requires Cantonment Board approval and often Ministry of Defence clearance. Several properties on the Cantonment fringe are sold as civilian properties without disclosing their Cantonment status. We confirm the Cantonment boundary and the applicable jurisdiction before you pay." } },
    { "@type": "Question", "name": "What is ADA (Agra Development Authority) and why do I need to check ADA approval?",
      "acceptedAnswer": { "@type": "Answer", "text": "ADA — Agra Development Authority — is the statutory body that approves layout plans and building plans in Agra's planned areas. Many properties, especially in peripheral areas like Fatehabad Road, Bodla, and Trans Yamuna, are sold on the basis of fake or unauthorised ADA layouts. We verify ADA layout and building plan approval at the ADA office for every plot or flat verification in Agra." } },
    { "@type": "Question", "name": "Is property near the Yamuna in Agra safe to buy?",
      "acceptedAnswer": { "@type": "Answer", "text": "No — not without verification. The Yamuna river bed and flood plain in Agra is frequently encroached. Several colonies on both banks (especially Trans Yamuna areas) sit on land that is technically river bed or low-lying flood zone. NGT and the Allahabad HC have periodically ordered demolition of such encroachments. We check flood zone status, Yamuna master plan boundary and any active NGT or court orders for every Trans Yamuna property." } },
    { "@type": "Question", "name": "Can NRIs use DSD Properties for Agra property verification?",
      "acceptedAnswer": { "@type": "Answer", "text": "Yes. Agra is a significant NRI market — particularly for families with roots in old Agra and for investment in Fatehabad Road corridor properties. You share documents from anywhere via WhatsApp, we physically verify at ADA, Sub-Registrar, ASI boundary and courts, and deliver a PDF report. The ₹10,000 premium package adds a site visit." } },
    { "@type": "Question", "name": "Which areas of Agra do you cover?",
      "acceptedAnswer": { "@type": "Answer", "text": "We cover all of Agra city and district — Fatehabad Road, Kamla Nagar, Civil Lines, Sikandra, Bodla, Kalindi Vihar, Trans Yamuna, Taj Nagri, Dayal Bagh, Shahganj, Sanjay Place, Lohamandi, Vibhav Nagar, Sultanganj, Mathura Road, and all tehsils of Agra district including Fatehabad, Etmadpur, Bah and Fatehpur Sikri. No extra charge." } }
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
    { "@type": "ListItem", "position": 3, "name": "Property Verification Service Agra", "item": "https://dsdproperties.in/services/property-verification-agra" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "How to Get Property Verified in Agra",
  "description": "Hire DSD Properties for independent property verification in Agra. Physical checks at ADA office, Sub-Registrar, ASI boundary, and courts. PDF report in 48 hours at ₹5,000.",
  "totalTime": "PT48H",
  "estimatedCost": { "@type": "MonetaryAmount", "currency": "INR", "value": "5000" },
  "step": [
    { "@type": "HowToStep", "position": 1, "name": "WhatsApp Free Preliminary Check", "text": "Send the property address and seller's name on WhatsApp to +91-8595002933. We do a free preliminary ADA and TTZ boundary check within 2 hours.", "url": "https://dsdproperties.in/services/property-verification-agra" },
    { "@type": "HowToStep", "position": 2, "name": "Share Available Documents", "text": "Share ADA approval letter, sale deed, Khatauni — whatever you have. Even just the property address is enough to start.", "url": "https://dsdproperties.in/services/property-verification-agra" },
    { "@type": "HowToStep", "position": 3, "name": "Pay ₹5,000 Verification Fee", "text": "Pay ₹5,000 for residential plots and flats, ₹7,000 for commercial, or ₹10,000 for the premium package with site visit. UPI or bank transfer. Invoice issued.", "url": "https://dsdproperties.in/services/property-verification-agra" },
    { "@type": "HowToStep", "position": 4, "name": "We Verify at Source in Agra", "text": "Our team physically checks ADA layout approval, Taj Trapezium Zone (TTZ) boundary status, ASI monument buffer zone, Army Cantonment boundaries, Yamuna flood zone classification, Sub-Registrar encumbrance, and court records.", "url": "https://dsdproperties.in/services/property-verification-agra" },
    { "@type": "HowToStep", "position": 5, "name": "Receive Detailed PDF Report in 48 Hours", "text": "A clear PDF report with every check performed, any red flags found, and a final verdict: Safe to Buy or Do Not Proceed. Delivered within 48 hours.", "url": "https://dsdproperties.in/services/property-verification-agra" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Property Verification Service Agra — ADA & TTZ Check ₹5,000",
  "url": "https://dsdproperties.in/services/property-verification-agra",
  "description": "Hire a professional property verifier in Agra. We check ADA layout approval, Taj Trapezium Zone restrictions, ASI monument buffer, Cantonment boundaries, Yamuna flood zone and Sub-Registrar records. PDF report in 48 hours. ₹5,000 fixed fee.",
  "speakable": { "@type": "SpeakableSpecification", "cssSelector": [".pv-hero__sub", ".pv-ssub", ".pv-step p", ".pv-faq-a"] },
  "about": {
    "@type": "Service",
    "name": "Property Verification Service Agra",
    "description": "Independent physical verification of property documents in Agra including ADA approval, Taj Trapezium Zone boundary, ASI monument buffer, Cantonment, Yamuna flood zone, and Sub-Registrar records. PDF report in 48 hours at ₹5,000.",
    "provider": { "@id": "https://dsdproperties.in/#organization" }
  }
}
</script>
@endpush

@section('content')

<style>
:root {
    --ag-dark:   #1a0208;
    --ag-mid:    #9b1535;
    --ag-accent: #f43f5e;
    --ag-amber:  #d97706;
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

@keyframes pv-up    { from { opacity:0; transform:translateY(28px); } to { opacity:1; transform:none; } }
@keyframes pv-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
@keyframes pvPulse  { 0%,100%{box-shadow:0 0 0 2px rgba(244,63,94,.3)} 50%{box-shadow:0 0 0 6px rgba(244,63,94,.08)} }

.pv-rv { opacity:0; transform:translateY(22px); transition: opacity .6s ease, transform .6s ease; transition-delay: var(--rd, 0s); }
.pv-rv.visible { opacity:1; transform:none; }

.pv-slabel { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--ag-accent); text-align: center; margin-bottom: 10px; display: block; }
.pv-stitle { font-size: clamp(1.6rem, 3.2vw, 2.4rem); font-weight: 800; color: var(--pv-t1); text-align: center; line-height: 1.15; margin-bottom: 12px; }
.pv-ssub   { font-size: .92rem; color: var(--pv-t2); text-align: center; max-width: 680px; margin: 0 auto 48px; line-height: 1.75; }

.pv-btn { display: inline-flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; border-radius: 11px; text-decoration: none; cursor: pointer; transition: all .22s; border: none; padding: 13px 26px; font-size: .88rem; }
.pv-btn--primary { background: linear-gradient(135deg, var(--ag-mid), #c01a40); color:#fff; box-shadow: 0 5px 20px rgba(155,21,53,.3); }
.pv-btn--primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(155,21,53,.42); color:#fff; }
.pv-btn--ghost { background: rgba(255,255,255,.1); color: rgba(255,255,255,.9); border: 1px solid rgba(255,255,255,.22); }
.pv-btn--ghost:hover { background: rgba(255,255,255,.18); color:#fff; }
.pv-btn--whatsapp { background: #25D366; color:#fff; box-shadow: 0 5px 20px rgba(37,211,102,.3); }
.pv-btn--whatsapp:hover { background:#1ebe5d; color:#fff; transform: translateY(-2px); }

/* Agra hero — deep maroon/crimson (red sandstone of Agra Fort & Fatehpur Sikri) */
.pv-hero { position: relative; overflow: hidden; min-height: 88vh; background: linear-gradient(135deg, #1a0208 0%, #3d0518 45%, #7b0d2e 100%); display: flex; align-items: center; }
.pv-hero__grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(244,63,94,.04) 1px, transparent 1px), linear-gradient(90deg, rgba(244,63,94,.04) 1px, transparent 1px); background-size: 50px 50px; }
.pv-hero__orb { position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none; }
.pv-hero__orb--a { width: 520px; height: 520px; background: rgba(244,63,94,.16); top: -140px; right: -100px; animation: pv-float 9s ease-in-out infinite; }
.pv-hero__orb--b { width: 380px; height: 380px; background: rgba(217,119,6,.12); bottom: -80px; left: -60px; animation: pv-float 11s ease-in-out infinite 3s; }
.pv-hero__body { position: relative; z-index: 2; padding-top: 60px; padding-bottom: 70px; display:grid; grid-template-columns: 1.15fr 1fr; gap: 50px; align-items: center; }
@media(max-width:900px){ .pv-hero__body { grid-template-columns: 1fr; gap: 30px; padding-top: 80px; } }

.pv-hero__left { animation: pv-up .6s ease both; }
.pv-hero__badge { display: inline-flex; align-items: center; gap: 9px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); border-radius: 99px; padding: 7px 16px; margin-bottom: 22px; font-size: 11px; font-weight: 500; color: rgba(255,255,255,.85); backdrop-filter: blur(8px); }
.pv-pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: #4ade80; flex-shrink: 0; animation: pvPulse 2.5s infinite; display: inline-block; }
.pv-hero__h1 { font-size: clamp(1.85rem, 3.6vw, 2.7rem); font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 18px; letter-spacing: -.4px; }
.pv-hero__h1 em { font-style: normal; color: #fca5a5; }
.pv-hero__sub { font-size: .95rem; color: rgba(255,255,255,.82); line-height: 1.78; margin-bottom: 26px; max-width: 580px; }
.pv-hero__cta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 26px; }
.pv-hero__pills { display: flex; flex-wrap: wrap; gap: 8px; }
.pv-pill { display: flex; align-items: center; gap: 6px; padding: 5px 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); border-radius: 8px; font-size: 11px; color: rgba(255,255,255,.75); }

.pv-hero__card { background: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 28px 72px rgba(0,0,0,.35); animation: pv-up .7s ease .15s both; }
.pv-hero__card-tag { display:inline-block; font-size:10px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color: var(--ag-mid); background:rgba(155,21,53,.08); padding:4px 9px; border-radius:5px; margin-bottom: 12px; }
.pv-hero__card-title { font-size: 1.2rem; font-weight: 800; color: var(--pv-t1); margin-bottom: 6px; line-height: 1.3; }
.pv-hero__card-sub { font-size: .82rem; color: var(--pv-t2); margin-bottom: 18px; line-height: 1.6; }
.pv-hero__card-price { display: flex; align-items: baseline; gap: 8px; margin-bottom: 18px; padding: 14px 16px; background: var(--pv-bg2); border-radius: 10px; border-left: 4px solid var(--ag-mid); }
.pv-hero__card-price-amt { font-size: 1.8rem; font-weight: 900; color: var(--ag-dark); line-height: 1; }
.pv-hero__card-price-lbl { font-size: .78rem; color: var(--pv-t2); }
.pv-hero__card-list { list-style:none; padding:0; margin: 0 0 18px; }
.pv-hero__card-list li { display: flex; align-items: flex-start; gap: 9px; padding: 6px 0; font-size: .82rem; color: var(--pv-t2); }
.pv-hero__card-list li::before { content: "✓"; color: var(--ag-mid); font-weight: 800; flex-shrink: 0; }
.pv-hero__card-btn { display: block; width: 100%; padding: 14px; background: #25D366; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: .92rem; cursor: pointer; font-family: 'Poppins', sans-serif; text-align: center; text-decoration: none; transition: transform .2s, box-shadow .2s; box-shadow: 0 5px 18px rgba(37,211,102,.3); }
.pv-hero__card-btn:hover { transform: translateY(-1px); color:#fff; text-decoration:none; }
.pv-hero__card-note { margin-top: 12px; font-size: .72rem; color: var(--pv-t3); text-align: center; line-height: 1.5; }
.pv-hero__wave { position: absolute; bottom: 0; left: 0; right: 0; line-height: 0; }
.pv-hero__wave svg { width: 100%; height: 56px; display: block; }

.pv-metrics { background: var(--pv-card); border-bottom: 1px solid var(--pv-border); padding: 26px 0; }
.pv-metrics__grid { display:grid; grid-template-columns: repeat(4, 1fr); gap: 16px; text-align: center; }
@media(max-width:680px){ .pv-metrics__grid { grid-template-columns: repeat(2, 1fr); gap: 22px; } }
.pv-metric__num { font-size: 1.6rem; font-weight: 900; color: var(--ag-dark); line-height: 1; margin-bottom: 6px; }
.pv-metric__num span { color: var(--ag-mid); }
.pv-metric__label { font-size: .72rem; color: var(--pv-t2); text-transform: uppercase; letter-spacing: 1.2px; font-weight: 600; }

/* TTZ alert — centrepiece of Agra page */
.pv-ttz-banner { background: linear-gradient(135deg, #1c0e00, #3d2000); border-radius: 16px; padding: 28px 32px; max-width: 920px; margin: 0 auto 36px; display: flex; gap: 18px; align-items: flex-start; border: 1.5px solid rgba(217,119,6,.3); }
.pv-ttz-icon { font-size: 2rem; flex-shrink: 0; }
.pv-ttz-title { font-size: 1.1rem; font-weight: 800; color: #fcd34d; margin-bottom: 8px; }
.pv-ttz-text { font-size: .86rem; color: rgba(255,255,255,.85); line-height: 1.7; }
.pv-ttz-zones { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap: 10px; margin-top: 16px; }
.pv-ttz-zone { background: rgba(255,255,255,.06); border: 1px solid rgba(217,119,6,.2); border-radius: 10px; padding: 12px 14px; }
.pv-ttz-zone-name { font-size: .8rem; font-weight: 700; color: #fcd34d; margin-bottom: 4px; }
.pv-ttz-zone-desc { font-size: .74rem; color: rgba(255,255,255,.75); line-height: 1.5; }

.pv-ag-box { background: linear-gradient(135deg, #fff1f2, #ffe4e6); border: 1.5px solid rgba(244,63,94,.2); border-radius: 16px; padding: 28px 30px; max-width: 920px; margin: 0 auto 40px; }
.pv-ag-box h3 { font-size: 1.05rem; font-weight: 800; color: var(--ag-dark); margin-bottom: 14px; }
.pv-ag-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px; }
.pv-ag-item { display: flex; gap: 10px; align-items: flex-start; background: #fff; border-radius: 10px; padding: 13px 14px; border: 1px solid rgba(244,63,94,.12); }
.pv-ag-item-icon { font-size: 1.2rem; flex-shrink: 0; }
.pv-ag-item-title { font-size: .82rem; font-weight: 700; color: var(--ag-dark); margin-bottom: 3px; }
.pv-ag-item-text  { font-size: .74rem; color: var(--pv-t2); line-height: 1.55; }

.pv-diy-table { max-width: 920px; margin: 0 auto; background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 16px; overflow: hidden; box-shadow: 0 8px 32px rgba(26,2,8,.06); }
.pv-diy-head { display: grid; grid-template-columns: 1.1fr 1fr 1fr; background: linear-gradient(135deg, var(--ag-dark), #4d0a22); color:#fff; }
.pv-diy-head > div { padding: 16px 18px; font-size: .82rem; font-weight: 700; border-right: 1px solid rgba(255,255,255,.1); }
.pv-diy-head > div:last-child { border-right: none; }
.pv-diy-head > div:nth-child(3) { background: rgba(244,63,94,.2); }
.pv-diy-row { display: grid; grid-template-columns: 1.1fr 1fr 1fr; border-top: 1px solid var(--pv-border); }
.pv-diy-row > div { padding: 14px 18px; font-size: .82rem; color: var(--pv-t2); border-right: 1px solid var(--pv-border); line-height: 1.6; }
.pv-diy-row > div:last-child { border-right: none; }
.pv-diy-row > div:first-child { font-weight: 600; color: var(--pv-t1); background: var(--pv-bg2); }
.pv-diy-row > div:nth-child(3) { background: rgba(244,63,94,.03); }
.pv-diy-good { color: #047857 !important; font-weight: 600; }
.pv-diy-bad  { color: #b91c1c !important; }
@media(max-width:680px){
    .pv-diy-head, .pv-diy-row { grid-template-columns: 1fr; }
    .pv-diy-head > div, .pv-diy-row > div { border-right: none; border-bottom: 1px solid rgba(255,255,255,.1); }
    .pv-diy-row > div { border-bottom: 1px solid var(--pv-border); }
    .pv-diy-head > div:nth-child(3), .pv-diy-row > div:nth-child(3) { border-top: 2px solid var(--ag-accent); }
}

.pv-check-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; max-width: 920px; margin: 0 auto; }
@media(max-width:680px){ .pv-check-grid { grid-template-columns: 1fr; } }
.pv-check-card { background: var(--pv-card); border: 1.5px solid var(--pv-border); border-radius: 14px; padding: 22px; display: flex; gap: 16px; align-items: flex-start; transition: transform .25s, box-shadow .25s, border-color .25s; }
.pv-check-card:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(244,63,94,.1); border-color: rgba(244,63,94,.3); }
.pv-check-card__icon { width: 44px; height: 44px; flex-shrink: 0; background: linear-gradient(135deg, var(--ag-mid), #6b0e25); color:#fff; border-radius: 11px; display:flex; align-items:center; justify-content:center; font-size: 1.3rem; }
.pv-check-card__title { font-size: .92rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 5px; }
.pv-check-card__text { font-size: .82rem; color: var(--pv-t2); line-height: 1.65; margin: 0 0 8px; }
.pv-check-card__where { font-size: .72rem; color: var(--ag-mid); font-weight: 600; }
.pv-check-card__where::before { content: "📍 "; }

.pv-risk-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px,1fr)); gap: 16px; margin-bottom: 24px; }
.pv-risk-card { background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 14px; padding: 22px 20px; display: flex; gap: 14px; align-items: flex-start; transition: transform .25s; }
.pv-risk-card:hover { transform: translateY(-3px); }
.pv-risk-icon { width: 42px; height: 42px; background: #dc2626; border-radius: 10px; display:flex; align-items:center; justify-content:center; font-size: 1.2rem; flex-shrink: 0; }
.pv-risk-title { font-size: .9rem; font-weight: 700; color: #111827; margin-bottom: 5px; }
.pv-risk-text  { font-size: .78rem; color: #4b5563; line-height: 1.6; margin: 0; }
.pv-risk-banner { background: linear-gradient(135deg, #78350f, #92400e); padding: 26px 32px; border-radius: 14px; max-width: 860px; margin: 0 auto; display: flex; gap: 16px; align-items: flex-start; }
.pv-risk-banner-icon { color:#fff; font-size: 1.6rem; flex-shrink: 0; }
.pv-risk-banner-title { color:#fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 6px; }
.pv-risk-banner-text  { color: rgba(255,255,255,.9); font-size: .85rem; line-height: 1.6; }

.pv-steps { max-width: 860px; margin: 0 auto; display: flex; flex-direction: column; gap: 14px; }
.pv-step { display: flex; gap: 18px; align-items: flex-start; background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 14px; padding: 20px; transition: transform .25s, box-shadow .25s; }
.pv-step:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,.07); }
.pv-step__num { width: 48px; height: 48px; flex-shrink: 0; background: linear-gradient(135deg, var(--ag-dark), #4d0a22); color:#fff; border-radius: 11px; display:flex; align-items:center; justify-content:center; font-size: 1.25rem; font-weight: 800; }
.pv-step h3 { font-size: .9rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 5px; }
.pv-step p  { font-size: .8rem; color: var(--pv-t2); line-height: 1.6; margin: 0; }

.pv-report { max-width: 880px; margin: 0 auto; background: var(--pv-card); border: 1.5px solid var(--pv-border); border-radius: 18px; overflow: hidden; box-shadow: 0 12px 40px rgba(26,2,8,.08); }
.pv-report__header { background: linear-gradient(135deg, var(--ag-dark), #4d0a22); color:#fff; padding: 24px 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; }
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
.pv-price-card:hover { transform: translateY(-6px); box-shadow: 0 18px 44px rgba(0,0,0,.1); border-color: var(--ag-accent); }
.pv-price-card--featured { background: linear-gradient(135deg, var(--ag-mid), #6b0e25); border-color: var(--ag-mid); box-shadow: 0 12px 36px rgba(155,21,53,.28); }
.pv-price-badge { position: absolute; top: -13px; left: 50%; transform: translateX(-50%); background: #fff; color: var(--ag-mid); padding: 4px 16px; border-radius: 99px; font-weight: 800; font-size: .74rem; box-shadow: 0 4px 12px rgba(0,0,0,.15); border: 2px solid var(--ag-mid); white-space: nowrap; }
.pv-price-tag { display: inline-block; padding: 5px 13px; border-radius: 99px; font-weight: 700; font-size: .72rem; margin-bottom: 12px; background: #f3f4f6; color: #374151; letter-spacing: 1px; }
.pv-price-card--featured .pv-price-tag { background: rgba(255,255,255,.2); color:#fff; }
.pv-price-name { font-size: 1.15rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 10px; }
.pv-price-card--featured .pv-price-name { color:#fff; }
.pv-price-amount { font-size: 2.3rem; font-weight: 900; color: var(--ag-dark); margin: 12px 0 4px; letter-spacing: -.03em; }
.pv-price-card--featured .pv-price-amount { color:#fff; }
.pv-price-desc { font-size: .78rem; color: var(--pv-t3); margin-bottom: 20px; }
.pv-price-card--featured .pv-price-desc { color: rgba(255,255,255,.85); }
.pv-price-list { list-style: none; padding: 0; margin: 0 0 22px; text-align: left; }
.pv-price-list li { padding: 8px 0; display: flex; align-items: flex-start; gap: 9px; font-size: .8rem; color: var(--pv-t2); border-bottom: 1px solid var(--pv-border); }
.pv-price-list li:last-child { border-bottom: none; }
.pv-price-card--featured .pv-price-list li { color: rgba(255,255,255,.92); border-bottom-color: rgba(255,255,255,.15); }
.pv-price-check { color: var(--ag-accent); flex-shrink: 0; margin-top: 1px; font-size: .82rem; }
.pv-price-card--featured .pv-price-check { color:#fca5a5; }
.pv-price-btn { display: block; width: 100%; padding: 12px; border-radius: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .84rem; text-decoration: none; text-align: center; border: none; cursor: pointer; transition: all .22s; background: linear-gradient(135deg, var(--ag-mid), #c01a40); color:#fff; box-shadow: 0 4px 14px rgba(155,21,53,.28); }
.pv-price-btn:hover { transform: translateY(-2px); color:#fff; }
.pv-price-btn--white { background:#fff; color: var(--ag-mid); }
.pv-price-btn--white:hover { background:#fff1f2; color: var(--ag-mid); }

.pv-area-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; max-width: 900px; margin: 0 auto; }
.pv-area-pill { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 10px; padding: 11px 14px; font-size: .8rem; font-weight: 600; color: var(--pv-t1); text-align: center; transition: all .2s; }
.pv-area-pill:hover { border-color: var(--ag-accent); color: var(--ag-mid); background: rgba(244,63,94,.04); }

.pv-cta { background: linear-gradient(135deg, #1a0208 0%, #3d0518 50%, #7b0d2e 100%); padding: 70px 0; position: relative; overflow: hidden; }
.pv-cta__orb { position: absolute; border-radius: 50%; filter: blur(80px); width: 420px; height: 420px; background: rgba(244,63,94,.14); top: -120px; right: -100px; animation: pv-float 10s ease-in-out infinite; }
.pv-cta__inner { position: relative; z-index: 2; text-align: center; }
.pv-cta h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color:#fff; margin-bottom: 12px; }
.pv-cta p  { font-size: .92rem; color: rgba(255,255,255,.78); max-width: 580px; margin: 0 auto 30px; line-height: 1.7; }
.pv-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

.pv-faq-item { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 12px; overflow: hidden; }
.pv-faq-q { width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-family: 'Poppins', sans-serif; font-size: .88rem; font-weight: 600; color: var(--pv-t1); cursor: pointer; text-align: left; gap: 12px; transition: background .2s; }
.pv-faq-q:hover { background: var(--pv-bg2); }
.pv-faq-q i { color: var(--ag-accent); flex-shrink: 0; transition: transform .3s; font-size: .78rem; }
.pv-faq-q.open i { transform: rotate(180deg); }
.pv-faq-a { padding: 0 20px; max-height: 0; overflow: hidden; font-size: .83rem; color: var(--pv-t2); line-height: 1.75; transition: max-height .35s ease, padding .35s ease; }
.pv-faq-a.open { max-height: 800px; padding: 0 20px 16px; }

.pv-mobile-cta { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: var(--pv-card); border-top: 3px solid var(--ag-mid); padding: 10px 14px; z-index: 90; box-shadow: 0 -4px 20px rgba(0,0,0,.12); gap: 8px; }
.pv-mobile-cta.show { display: flex; }
.pv-mobile-cta a { flex: 1; text-align: center; padding: 11px 8px; border-radius: 9px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .8rem; text-decoration: none; }
.pv-mobile-cta a.whatsapp { background: #25D366; color:#fff; }
.pv-mobile-cta a.book { background: linear-gradient(135deg, var(--ag-mid), #c01a40); color:#fff; }

@media(max-width:860px){ .pv-section { padding: 56px 0; } .pv-cta { padding: 56px 0; } }
@media(max-width:480px){ .pv-hero__cta { flex-direction: column; } .pv-ttz-banner { flex-direction: column; gap: 10px; } .pv-risk-banner { flex-direction: column; gap: 10px; } }
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
                <li style="color:#fff; font-weight:500;">Property Verification Agra</li>
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
                Agra's Independent Property Verifier — ADA & TTZ Specialist
            </div>

            <h1 class="pv-hero__h1">
                Professional Property<br>
                Verification <em>Service</em><br>
                in Agra — ₹5,000.
            </h1>

            <p class="pv-hero__sub">
                Agra has a risk that no other UP city has: the <strong style="color:#fca5a5;">Taj Trapezium Zone (TTZ)</strong> — a 10,500 sq km Supreme Court-mandated eco-sensitive zone where construction is strictly restricted. Add ADA layout fraud, Army Cantonment boundaries, Yamuna flood encroachments and old-city ancestral disputes, and Agra is one of the most legally complex property markets in North India. Don't pay ₹50 lakhs without spending ₹5,000 on verification.
            </p>

            <div class="pv-hero__cta">
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20you%20for%20property%20verification%20in%20Agra.%20Property%20address%3A" class="pv-btn pv-btn--whatsapp">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Hire a Verifier — WhatsApp Us
                </a>
                <a href="#pricing" class="pv-btn pv-btn--ghost">See Pricing →</a>
            </div>

            <div class="pv-hero__pills">
                <div class="pv-pill"><i class="fas fa-clock"></i> 48-Hour PDF Report</div>
                <div class="pv-pill"><i class="fas fa-monument"></i> TTZ Boundary Checked</div>
                <div class="pv-pill"><i class="fas fa-globe"></i> NRI-Friendly</div>
            </div>
        </div>

        <div class="pv-hero__card">
            <div class="pv-hero__card-tag">PLOT / FLAT — AGRA & DISTRICT</div>
            <div class="pv-hero__card-title">Hire an Agra Property Verifier</div>
            <div class="pv-hero__card-sub">Trained verifier checks ADA layout approval, TTZ zone status, ASI monument buffer, Cantonment boundary, Yamuna flood zone, title chain and Sub-Registrar encumbrance. PDF in 48 hours.</div>

            <div class="pv-hero__card-price">
                <span class="pv-hero__card-price-amt">₹5,000</span>
                <span class="pv-hero__card-price-lbl">all-inclusive · no hidden fees</span>
            </div>

            <ul class="pv-hero__card-list">
                <li>ADA layout & building plan approval</li>
                <li>Taj Trapezium Zone (TTZ) boundary check</li>
                <li>ASI monument buffer zone check</li>
                <li>Army Cantonment boundary confirmed</li>
                <li>Final verdict: Safe to Buy or Walk Away</li>
            </ul>

            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20book%20the%20%E2%82%B95%2C000%20property%20verification%20in%20Agra.%20Property%20address%3A" class="pv-hero__card-btn">Book ₹5,000 Verification on WhatsApp</a>
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
            <div><div class="pv-metric__num">10,500 <span style="font-size:1rem;">km²</span></div><div class="pv-metric__label">Taj Trapezium Zone Area</div></div>
            <div><div class="pv-metric__num">30 yr</div><div class="pv-metric__label">Title Chain Traced</div></div>
            <div><div class="pv-metric__num">48 hr</div><div class="pv-metric__label">PDF Report Delivery</div></div>
            <div><div class="pv-metric__num">₹5K</div><div class="pv-metric__label">vs ₹50L At Risk</div></div>
        </div>
    </div>
</section>

{{-- ═══════════ TTZ — AGRA'S UNIQUE RISK ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Agra-Only Risk</span>
        <h2 class="pv-stitle pv-rv">The Taj Trapezium Zone — Agra's Unique Property Constraint</h2>
        <p class="pv-ssub pv-rv">No other city in Uttar Pradesh — not Lucknow, not Varanasi, not Noida — has this. The Supreme Court of India has imposed permanent restrictions on construction, industry and certain land uses within a defined zone around the Taj Mahal. This is the first check we do for every Agra property.</p>

        <div class="pv-ttz-banner pv-rv">
            <div class="pv-ttz-icon">🕌</div>
            <div>
                <div class="pv-ttz-title">What Is the Taj Trapezium Zone (TTZ)?</div>
                <div class="pv-ttz-text">The TTZ is a 10,500 sq km trapezoidal eco-sensitive zone demarcated by the Supreme Court of India in the <em>M.C. Mehta v. Union of India</em> case, specifically to protect the Taj Mahal from pollution, visual degradation and inappropriate development. The zone covers Agra and parts of Firozabad, Mathura, Hathras and Bharatpur districts. <strong style="color:#fcd34d;">Within the TTZ, polluting industries are banned, certain construction types require special clearance, and the NGT actively monitors violations.</strong> Several demolition orders have been executed in the TTZ in recent years.</div>
                <div class="pv-ttz-zones">
                    <div class="pv-ttz-zone">
                        <div class="pv-ttz-zone-name">⛔ 500 m Prohibited Zone</div>
                        <div class="pv-ttz-zone-desc">No construction whatsoever within 500 metres of any ASI-protected monument. Taj Mahal, Agra Fort, Itmad-ud-Daulah, Akbar's Tomb, Mehtab Bagh — each has its own 500m buffer.</div>
                    </div>
                    <div class="pv-ttz-zone">
                        <div class="pv-ttz-zone-name">⚠️ 200 m Regulated Zone</div>
                        <div class="pv-ttz-zone-desc">200 m zone around protected monuments is regulated — construction height, density and type must comply with ASI and NMMA guidelines. Commercial and industrial use is prohibited.</div>
                    </div>
                    <div class="pv-ttz-zone">
                        <div class="pv-ttz-zone-name">🔶 Wider TTZ Restriction Belt</div>
                        <div class="pv-ttz-zone-desc">Within the broader TTZ, polluting industries and certain construction activities require prior Supreme Court / Central Empowered Committee clearance. NGT has suo motu powers to order demolition.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pv-ag-box pv-rv">
            <h3>🏛️ Other Agra-Specific Risks We Check</h3>
            <div class="pv-ag-grid">
                <div class="pv-ag-item">
                    <div class="pv-ag-item-icon">🪖</div>
                    <div>
                        <div class="pv-ag-item-title">Army Cantonment Boundary</div>
                        <div class="pv-ag-item-text">Agra Cantonment is one of India's largest military cantonments. Land within Cantonment limits is under the Cantonment Board — not ADA. Civilian purchase requires Cantonment Board approval and is heavily restricted. Many peripheral plots are sold without disclosing their Cantonment status.</div>
                    </div>
                </div>
                <div class="pv-ag-item">
                    <div class="pv-ag-item-icon">🌊</div>
                    <div>
                        <div class="pv-ag-item-title">Yamuna Flood Plain & River Bed Encroachments</div>
                        <div class="pv-ag-item-text">Large portions of Trans Yamuna Agra and areas near the river banks are on encroached flood plain or Yamuna river bed land. NGT and the HC have periodically ordered demolitions. The Yamuna master plan boundary is the definitive check — not the seller's claim.</div>
                    </div>
                </div>
                <div class="pv-ag-item">
                    <div class="pv-ag-item-icon">📋</div>
                    <div>
                        <div class="pv-ag-item-title">Fake ADA Layout Approvals</div>
                        <div class="pv-ag-item-text">Peripheral Agra — Bodla, Fatehabad Road outskirts, Sikandra road areas — has a high incidence of forged or lapsed ADA layout maps being used to sell plots. The ADA office physical check is the only way to confirm whether a layout is genuinely approved and whether the specific plot exists in the approved plan.</div>
                    </div>
                </div>
                <div class="pv-ag-item">
                    <div class="pv-ag-item-icon">🕌</div>
                    <div>
                        <div class="pv-ag-item-title">Waqf Board Properties (Old City)</div>
                        <div class="pv-ag-item-text">Agra's old city — Shahganj, Belanganj, Lohamandi, Manto Road — has significant Waqf Board land. Properties sold as clear freehold in these areas may actually be on Waqf land. We check UP Sunni Waqf Board records for properties in old Agra areas.</div>
                    </div>
                </div>
                <div class="pv-ag-item">
                    <div class="pv-ag-item-icon">🏡</div>
                    <div>
                        <div class="pv-ag-item-title">Old Agra Ancestral Property Disputes</div>
                        <div class="pv-ag-item-text">Agra's densely packed old city has a high concentration of undivided ancestral property (Hindu joint families and Muslim family property). Partial sale by one co-sharer without all heirs' consent is common. We trace the full title chain and flag any co-ownership risk.</div>
                    </div>
                </div>
                <div class="pv-ag-item">
                    <div class="pv-ag-item-icon">🛣️</div>
                    <div>
                        <div class="pv-ag-item-title">Ring Road & Highway Acquisition Corridors</div>
                        <div class="pv-ag-item-text">NHAI and UP Expressways Industrial Development Authority have active acquisition corridors around Agra — the Agra Ring Road and Yamuna Expressway approaches. Plots within these corridors may be subject to ongoing or future acquisition. We check corridor status for peripheral plots.</div>
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
        <h2 class="pv-stitle pv-rv">What You Can Check vs. What We Check in Agra</h2>
        <p class="pv-ssub pv-rv">TTZ boundary, ASI monument buffers, Cantonment limits — none of these are on any property portal. They require physical checks at ADA, ASI and district records.</p>

        <div class="pv-diy-table pv-rv">
            <div class="pv-diy-head">
                <div>What You Check</div>
                <div>Doing It Yourself</div>
                <div>Hiring DSD Properties</div>
            </div>
            <div class="pv-diy-row">
                <div>TTZ zone boundary</div>
                <div class="pv-diy-bad">No public portal — seller will not disclose</div>
                <div class="pv-diy-good">TTZ map checked against plot coordinates</div>
            </div>
            <div class="pv-diy-row">
                <div>ASI monument 100/200 m buffer</div>
                <div class="pv-diy-bad">Approximate — not plot-specific</div>
                <div class="pv-diy-good">ASI buffer boundary checked at ADA / ASI</div>
            </div>
            <div class="pv-diy-row">
                <div>ADA layout approval</div>
                <div class="pv-diy-bad">Seller shows a map — cannot verify authenticity</div>
                <div class="pv-diy-good">Physical check at ADA office — approval confirmed</div>
            </div>
            <div class="pv-diy-row">
                <div>Army Cantonment boundary</div>
                <div class="pv-diy-bad">Not on any property portal</div>
                <div class="pv-diy-good">Cantonment Board boundary confirmed for plot</div>
            </div>
            <div class="pv-diy-row">
                <div>Yamuna flood plain / river bed</div>
                <div class="pv-diy-bad">NGT orders are not plot-level searchable online</div>
                <div class="pv-diy-good">Yamuna master plan boundary + NGT orders checked</div>
            </div>
            <div class="pv-diy-row">
                <div>Waqf Board land (old city)</div>
                <div class="pv-diy-bad">Seller will not volunteer Waqf status</div>
                <div class="pv-diy-good">UP Sunni Waqf Board records checked</div>
            </div>
            <div class="pv-diy-row">
                <div>30-year title chain & encumbrance</div>
                <div class="pv-diy-bad">Sub-Registrar requires physical presence</div>
                <div class="pv-diy-good">Full chain + EC extracted at Sub-Registrar, Agra</div>
            </div>
        </div>

        <div style="text-align:center; margin-top:28px;">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20a%20property%20verifier%20in%20Agra" class="pv-btn pv-btn--primary">Hire Us — Book Verification →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHAT WE CHECK ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What's Included</span>
        <h2 class="pv-stitle pv-rv">What We Check in Agra — For You</h2>
        <p class="pv-ssub pv-rv">Every Agra verification includes TTZ, ASI and Cantonment checks not available anywhere else — plus the full standard title, encumbrance and court review.</p>

        <div class="pv-check-grid">
            <div class="pv-check-card pv-rv">
                <div class="pv-check-card__icon">🕌</div>
                <div>
                    <div class="pv-check-card__title">Taj Trapezium Zone (TTZ) Boundary Check</div>
                    <p class="pv-check-card__text">The check that defines Agra verification. We determine whether your plot falls within the TTZ, and if so, which restriction belt applies — the 500 m prohibited zone, 200 m regulated zone or the broader TTZ eco-sensitive area. We also check for any active NGT orders or directions relating to the specific location. Not available on any portal.</p>
                    <div class="pv-check-card__where">ASI + ADA + NGT records + TTZ master map</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">🏛️</div>
                <div>
                    <div class="pv-check-card__title">ASI Protected Monument Buffer Check</div>
                    <p class="pv-check-card__text">Agra has more centrally protected monuments per sq km than almost any Indian city. We confirm whether the plot falls within 100 m (absolute prohibition) or 200 m (regulated zone) of any ASI-protected site — including the Taj Mahal, Agra Fort, Itmad-ud-Daulah, Akbar's Tomb at Sikandra, Ram Bagh and Chini ka Rauza.</p>
                    <div class="pv-check-card__where">ASI circle office, Agra + monument boundary maps</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.12s">
                <div class="pv-check-card__icon">📋</div>
                <div>
                    <div class="pv-check-card__title">ADA Layout & Building Plan Approval</div>
                    <p class="pv-check-card__text">We verify at the ADA (Agra Development Authority) office that the layout map shown by the seller is genuinely approved, is current (not lapsed), and that the specific plot number exists within the approved plan. We also check if the plot is in a regularised or unregularised colony, which affects registry and loan eligibility.</p>
                    <div class="pv-check-card__where">ADA office, Agra (Sanjay Place / Gwalior Road)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.18s">
                <div class="pv-check-card__icon">🪖</div>
                <div>
                    <div class="pv-check-card__title">Army Cantonment Boundary Confirmation</div>
                    <p class="pv-check-card__title" style="font-size:.82rem; font-weight:400; color:var(--pv-t2); line-height:1.65; margin-bottom:8px;">We confirm whether the property is within Agra Cantonment limits. Cantonment properties require Cantonment Board approval for purchase, are under a different registry regime, and banks treat them differently for home loans. The Cantonment boundary is not marked on Google Maps or any civilian portal — it requires direct checking.</div>
                    <div class="pv-check-card__where">Agra Cantonment Board records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">🌊</div>
                <div>
                    <div class="pv-check-card__title">Yamuna Flood Zone & River Bed Status</div>
                    <p class="pv-check-card__text">For Trans Yamuna properties and any plot within 500 m of the Yamuna, we check the Yamuna master plan boundary, the flood zone status, and any NGT or Allahabad HC orders relating to the specific area or khasra number. River bed and flood plain encroachments are periodically demolished — this check is essential before any Yamuna-adjacent purchase.</p>
                    <div class="pv-check-card__where">Irrigation Department + NGT + Tehsil revenue records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.10s">
                <div class="pv-check-card__icon">📄</div>
                <div>
                    <div class="pv-check-card__title">Sub-Registrar Title Chain & Encumbrance</div>
                    <p class="pv-check-card__text">We trace the complete title chain at the Sub-Registrar, Agra — verifying each successive owner for the last 30 years and extracting a current encumbrance certificate to reveal any existing bank mortgages, registered charges, court attachments or legal claims on the property.</p>
                    <div class="pv-check-card__where">Sub-Registrar office, Agra (multiple locations)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.16s">
                <div class="pv-check-card__icon">🕌</div>
                <div>
                    <div class="pv-check-card__title">Waqf Board Land Check (Old City)</div>
                    <p class="pv-check-card__text">For properties in Agra's old city — Shahganj, Belanganj, Lohamandi, Manto Road, Jama Masjid area — we check UP Sunni and UP Shia Waqf Board records to determine whether the land or any part of it is recorded as Waqf property. Waqf land cannot be freely sold, and transactions on undisclosed Waqf land are voidable.</p>
                    <div class="pv-check-card__where">UP Sunni / Shia Waqf Board district records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.22s">
                <div class="pv-check-card__icon">⚖️</div>
                <div>
                    <div class="pv-check-card__title">Agra District Court & HC Case Search</div>
                    <p class="pv-check-card__text">We search the Agra District Court records and Allahabad HC for any pending litigation, stay order, injunction or attachment relating to the property or its title chain. A court case or stay order can freeze a property indefinitely — but will not appear on any document the seller provides. We check at source.</p>
                    <div class="pv-check-card__where">Agra District Court + Allahabad HC records</div>
                </div>
            </div>
        </div>

        <div style="margin-top:32px; text-align:center;">
            <a href="#pricing" class="pv-btn pv-btn--primary">See ₹5,000 Pricing →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHY IT MATTERS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Why It Matters</span>
        <h2 class="pv-stitle pv-rv">Six Ways Buyers Lose Money in Agra</h2>
        <p class="pv-ssub pv-rv">All six are preventable with a ₹5,000 verification before payment. None are visible on any property portal or from the seller's documents.</p>

        <div class="pv-risk-grid">
            <div class="pv-risk-card pv-rv"><div class="pv-risk-icon">🕌</div><div><div class="pv-risk-title">TTZ Violation — NGT Orders Demolition</div><p class="pv-risk-text">You construct a boundary wall and ground floor on a plot inside the TTZ prohibited zone. NGT issues a show-cause notice. Before you can respond, a demolition squad arrives. Your investment vanishes in hours. This is not hypothetical — it has happened repeatedly in Agra's monument-adjacent areas.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.06s"><div class="pv-risk-icon">🏛️</div><div><div class="pv-risk-title">ASI Buffer Zone Kills Your Building Plan</div><p class="pv-risk-text">You buy a residential plot 180 metres from Agra Fort. ADA refuses to approve your building plan because you are within the 200 m regulated zone. You own a plot you can never build on. ASI restrictions are permanent — no appeal process overrides the SC direction.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.12s"><div class="pv-risk-icon">🪖</div><div><div class="pv-risk-title">Cantonment Land — Registry Is Refused</div><p class="pv-risk-text">You pay full consideration for a plot. Sub-Registrar refuses to register because it falls within Cantonment limits. Transfer requires Cantonment Board NOC that was never obtained. You are left holding an unregistered, unenforceable title with your entire investment locked.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.18s"><div class="pv-risk-icon">🌊</div><div><div class="pv-risk-title">Yamuna Flood Zone — HC Orders Demolition</div><p class="pv-risk-text">You build a house on what the seller called a "clear freehold plot" in Trans Yamuna. Allahabad HC takes up a PIL on Yamuna encroachments and the specific khasra number is in the flood zone list. Your house is demolished as an illegal encroachment.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.24s"><div class="pv-risk-icon">📋</div><div><div class="pv-risk-title">Fake ADA Layout — Plot Doesn't Exist</div><p class="pv-risk-text">You pay ₹30 lakhs for a plot in a Bodla-area "ADA-approved" colony. The ADA office has no record of the layout — the map shown to you was forged. The developer has sold the same plot to three different buyers. You are now one of three people fighting for a plot that legally doesn't exist in any approved plan.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.30s"><div class="pv-risk-icon">🕌</div><div><div class="pv-risk-title">Waqf Land — Title Is Void</div><p class="pv-risk-text">You buy a shop in old Agra's Shahganj area. Years later, the Waqf Board asserts its claim — the land is recorded as Waqf property. Sale of Waqf property without Waqf Board permission is void under the Waqf Act. Your entire investment is at risk in a protracted legal dispute.</p></div></div>
        </div>

        <div class="pv-risk-banner pv-rv">
            <div class="pv-risk-banner-icon">❗</div>
            <div>
                <div class="pv-risk-banner-title">Agra's Risks Are Invisible to Buyers — and to Most Agents</div>
                <div class="pv-risk-banner-text">Most property agents in Agra will show you revenue records, ADA maps and property tax receipts. None of those documents reveal TTZ zone status, ASI monument buffer, Cantonment boundary or Waqf status. These restrictions are imposed by central government bodies and courts — and they override everything the local seller can provide. Only an independent physical check at ADA, ASI, the Cantonment Board and Waqf Board records reveals the true picture.</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ PROCESS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Simple Process</span>
        <h2 class="pv-stitle pv-rv">How to Hire DSD for Agra Property Verification</h2>
        <p class="pv-ssub pv-rv">From first WhatsApp to PDF in 5 steps. Fully remote — you don't need to visit any office.</p>

        <div class="pv-steps">
            <div class="pv-step pv-rv"><div class="pv-step__num">1</div><div><h3>WhatsApp Free Preliminary Check</h3><p>Send the property address and any available documents. We run a quick TTZ zone assessment and basic ADA status check — free, within 2 hours — and tell you whether a full verification is warranted.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.06s"><div class="pv-step__num">2</div><div><h3>Share Available Documents</h3><p>ADA allotment letter, sale deed, layout map, khasra/khatoni — whatever the seller has provided. A property address and plot number is enough to begin.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.12s"><div class="pv-step__num">3</div><div><h3>Pay Verification Fee</h3><p>₹5,000 for residential plots and flats, ₹7,000 for commercial, ₹10,000 for premium with site visit. UPI or bank transfer. Invoice issued immediately.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.18s"><div class="pv-step__num">4</div><div><h3>We Verify at Source in Agra</h3><p>Our team checks ADA records, TTZ zone maps, ASI monument buffers, Cantonment Board limits, Yamuna flood zone records, Waqf Board records, Sub-Registrar encumbrance and Agra District Court — all physically in Agra, not just from online portals.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.24s"><div class="pv-step__num">5</div><div><h3>Detailed PDF Report in 48 Hours</h3><p>Every check documented, all risks flagged, and a clear final verdict: <strong>"Safe to Buy"</strong> or <strong>"Do Not Proceed."</strong> Delivered in 48 hours.</p></div></div>
        </div>
    </div>
</section>

{{-- ═══════════ REPORT PREVIEW ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What You Get</span>
        <h2 class="pv-stitle pv-rv">Inside the ₹5,000 PDF Verification Report</h2>

        <div class="pv-report pv-rv">
            <div class="pv-report__header">
                <div>
                    <h3 class="pv-report__title">Property Verification Report — Sample</h3>
                    <p class="pv-report__subtitle">Plot 42, Kalindi Vihar Colony, Fatehabad Road, Agra · Verified 21 July 2026</p>
                </div>
                <span class="pv-report__verdict">✓ SAFE TO BUY</span>
            </div>
            <div class="pv-report__body">
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>TTZ Zone Status</strong>Plot falls within the broader TTZ eco-sensitive area but outside the 500 m prohibited and 200 m regulated zones of any protected monument. Standard construction restrictions apply — no industrial use. Residential construction permissible.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>ASI Monument Buffer</strong>Nearest protected monument (Taj Mahal) is 4.2 km. Plot is outside all ASI buffer zones. Building plan approval from ADA is unaffected by ASI restrictions.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>ADA Layout Approval</strong>Layout of Kalindi Vihar confirmed approved at ADA office. Plot 42 exists in the approved plan. No lapse or cancellation of layout. Building plan can be submitted.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Cantonment Boundary</strong>Plot is outside Agra Cantonment limits. Cantonment Board confirmed — standard civil registry applicable at Sub-Registrar.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Yamuna Flood Zone</strong>Plot is 3.1 km from Yamuna. Not in flood zone or river bed. No NGT or HC order affecting this khasra number.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Sub-Registrar Title Chain</strong>30-year chain complete and unbroken. Three prior owners, all properly registered. No encumbrance, mortgage or attachment.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Waqf Board Status</strong>Not on Waqf Board records. Fatehabad Road area — this plot's khasra number does not appear in UP Sunni or Shia Waqf Board land register.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Court Orders</strong>No pending litigation, stay order, injunction or attachment at Agra District Court or Allahabad HC on this property or title chain.</div></div>
            </div>
            <div class="pv-report__footer">PDF includes ADA records, TTZ zone map extract, ASI boundary reference, Cantonment Board confirmation, Sub-Registrar encumbrance and court records · Delivered in 48 hours</div>
        </div>
    </div>
</section>

{{-- ═══════════ PRICING ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)" id="pricing">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Transparent Pricing</span>
        <h2 class="pv-stitle pv-rv">Property Verification Cost in Agra</h2>
        <p class="pv-ssub pv-rv">Fixed fee. All Agra-specific checks included — TTZ, ASI, Cantonment, Yamuna, Waqf. No per-check extras.</p>

        <div class="pv-pricing-grid">
            <div class="pv-price-card pv-rv">
                <div class="pv-price-tag">RESIDENTIAL</div>
                <div class="pv-price-name">Standard</div>
                <div class="pv-price-amount">₹5,000</div>
                <div class="pv-price-desc">Plots, builder floors & flats in Agra</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> TTZ zone boundary check</li>
                    <li><span class="pv-price-check">✓</span> ASI monument buffer check</li>
                    <li><span class="pv-price-check">✓</span> ADA layout approval</li>
                    <li><span class="pv-price-check">✓</span> Cantonment boundary</li>
                    <li><span class="pv-price-check">✓</span> 30-yr title chain + encumbrance</li>
                    <li><span class="pv-price-check">✓</span> Court search + Yamuna zone</li>
                    <li><span class="pv-price-check">✓</span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B95%2C000%20Standard%20property%20verification%20in%20Agra.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-price-card--featured pv-rv" style="--rd:.08s">
                <div class="pv-price-badge">⭐ MOST POPULAR</div>
                <div class="pv-price-tag">COMMERCIAL</div>
                <div class="pv-price-name">Commercial</div>
                <div class="pv-price-amount">₹7,000</div>
                <div class="pv-price-desc">Shops, offices & commercial plots in Agra</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Standard</li>
                    <li><span class="pv-price-check">✓</span> Waqf Board check (old city)</li>
                    <li><span class="pv-price-check">✓</span> Commercial zoning & ADA use</li>
                    <li><span class="pv-price-check">✓</span> TTZ industrial use restriction</li>
                    <li><span class="pv-price-check">✓</span> Fire NOC & completion status</li>
                    <li><span class="pv-price-check">✓</span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B97%2C000%20Commercial%20property%20verification%20in%20Agra.%20Property%20address%3A" class="pv-price-btn pv-price-btn--white">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-rv" style="--rd:.16s">
                <div class="pv-price-tag">PREMIUM</div>
                <div class="pv-price-name">Premium + Site Visit</div>
                <div class="pv-price-amount">₹10,000</div>
                <div class="pv-price-desc">Full verification with site inspection</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Commercial</li>
                    <li><span class="pv-price-check">✓</span> Physical site visit</li>
                    <li><span class="pv-price-check">✓</span> GPS-confirmed proximity to monuments</li>
                    <li><span class="pv-price-check">✓</span> Construction progress photos</li>
                    <li><span class="pv-price-check">✓</span> Neighbour boundary disputes noted</li>
                    <li><span class="pv-price-check">✓</span> Report in 3–5 days</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B910%2C000%20Premium%20property%20verification%20with%20site%20visit%20in%20Agra.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ SERVICE AREAS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Service Coverage</span>
        <h2 class="pv-stitle pv-rv">Areas We Cover in Agra</h2>
        <p class="pv-ssub pv-rv">We cover all of Agra city and district — from Fatehabad Road to Trans Yamuna, Sikandra to Fatehpur Sikri. No extra charge for any location within Agra district.</p>

        <div class="pv-area-grid pv-rv">
            <div class="pv-area-pill">Fatehabad Road</div>
            <div class="pv-area-pill">Kamla Nagar</div>
            <div class="pv-area-pill">Civil Lines</div>
            <div class="pv-area-pill">Sikandra</div>
            <div class="pv-area-pill">Bodla</div>
            <div class="pv-area-pill">Kalindi Vihar</div>
            <div class="pv-area-pill">Trans Yamuna</div>
            <div class="pv-area-pill">Dayal Bagh</div>
            <div class="pv-area-pill">Shahganj</div>
            <div class="pv-area-pill">Lohamandi</div>
            <div class="pv-area-pill">Sanjay Place</div>
            <div class="pv-area-pill">Vibhav Nagar</div>
            <div class="pv-area-pill">Taj Nagri</div>
            <div class="pv-area-pill">Mathura Road</div>
            <div class="pv-area-pill">Fatehpur Sikri</div>
            <div class="pv-area-pill">Etmadpur</div>
        </div>

        <div style="text-align:center; margin-top:28px; font-size:.84rem; color:var(--pv-t2);">
            Don't see your area? <a href="https://wa.me/918595002933" style="color:var(--ag-mid); font-weight:600;">WhatsApp us</a> — we cover all of Agra district.
        </div>
    </div>
</section>

{{-- ═══════════ FAQ ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">FAQ</span>
        <h2 class="pv-stitle pv-rv">Property Verification in Agra — Common Questions</h2>

        <div style="max-width:820px; margin:0 auto; display:flex; flex-direction:column; gap:10px;">
            @php
            $faqs = [
                ["How much does property verification cost in Agra?", "Property verification in Agra costs ₹5,000 for residential plots and flats, ₹7,000 for commercial properties, and ₹10,000 for the premium package with a physical site visit and GPS monument proximity confirmation. All Agra-specific checks — TTZ zone, ASI buffer, Cantonment boundary, Yamuna flood zone — are included at no extra charge. PDF report in 48 hours."],
                ["What is the Taj Trapezium Zone (TTZ) and how does it affect property purchases in Agra?", "The TTZ is a 10,500 sq km eco-sensitive zone demarcated by the Supreme Court to protect the Taj Mahal from pollution and inappropriate development. Properties within the TTZ face restrictions on construction types, industrial use and certain activities. Within 500 m of any ASI-protected monument, construction is completely prohibited. Within 200 m it is regulated. The broader TTZ still restricts polluting industries. We check TTZ zone status for every Agra property as the first step of verification."],
                ["My plot is on Fatehabad Road — is it in the TTZ?", "Fatehabad Road runs through the heart of the TTZ. Most plots on or near Fatehabad Road are within the eco-sensitive area, though usually not in the 500 m prohibited zone unless directly adjacent to a protected monument. The exact restriction depends on the specific survey number. We check this precisely — a general area answer is not sufficient for a property purchase decision."],
                ["What is the ASI 100/200 m buffer zone and how many monuments does it cover in Agra?", "ASI rules prohibit construction within 100 m of any centrally protected monument and regulate it within 200 m. In Agra, centrally protected monuments include the Taj Mahal, Agra Fort, Itmad-ud-Daulah (Baby Taj), Akbar's Tomb (Sikandra), Ram Bagh, Chini ka Rauza, Mehtab Bagh, and several others. Agra has one of the highest concentrations of centrally protected monuments in India — which means the buffer zones are substantial and widely distributed across the city."],
                ["Can I buy property near the Army Cantonment in Agra?", "Yes, but with caution. Properties outside the Cantonment boundary follow the normal ADA / Sub-Registrar process. Properties inside the Cantonment require Cantonment Board approval for transfer and are subject to different rules for construction and lease. The Cantonment boundary is not marked on civilian maps or property portals — we confirm it at the Cantonment Board directly. Properties on the boundary fringe are the highest risk as the exact demarcation is often disputed."],
                ["Is property in Dayal Bagh safe to buy?", "Dayal Bagh is a predominantly residential area away from the major monument zones. However, it is within the broader TTZ, and some peripheral areas border Cantonment limits. The Waqf Board risk is lower than old city areas. Standard ADA and title checks apply. We verify the specific plot's status — 'Dayal Bagh' as an area name is not sufficient to confirm safety."],
                ["Can NRIs use DSD Properties for Agra property verification?", "Yes. Agra is a significant NRI investment market, particularly for families from western UP. You share documents from anywhere via WhatsApp, we physically verify at ADA, ASI, Cantonment Board, Sub-Registrar and courts in Agra, and deliver a PDF report. The ₹10,000 premium package adds a site visit with GPS-confirmed proximity to monument boundaries."],
                ["Does the ADA in Agra have the same name as the ADA in Ayodhya?", "Yes — both are abbreviated ADA, but they are completely separate bodies. Agra Development Authority (ADA) governs Agra city and district. Ayodhya Development Authority (ADA) governs Ayodhya. There is no connection. When we refer to ADA in Agra verifications, we mean the Agra Development Authority only."],
            ];
            @endphp
            @foreach($faqs as $i => [$q, $a])
            <div class="pv-faq-item pv-rv">
                <button class="pv-faq-q" onclick="pvFaq(this)">
                    {{ $q }}
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pv-faq-a">{{ $a }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════ CTA ═══════════ --}}
<section class="pv-cta">
    <div class="pv-cta__orb"></div>
    <div class="pv-container pv-cta__inner">
        <h2>Start with a Free TTZ & ADA Preliminary Check</h2>
        <p>Send us the property address and plot number on WhatsApp. We run a quick TTZ zone assessment and basic ADA status check within 2 hours — free — and tell you whether a full ₹5,000 verification is worth doing before you pay anything.</p>
        <div class="pv-cta__btns">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20a%20free%20TTZ%20and%20ADA%20preliminary%20check%20in%20Agra.%20Property%20address%3A" class="pv-btn pv-btn--whatsapp">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                Free TTZ Check — WhatsApp Us
            </a>
            <a href="#pricing" class="pv-btn pv-btn--ghost">View Pricing →</a>
        </div>
        <p style="margin-top:18px; font-size:.8rem; color:rgba(255,255,255,.5);">
            Also serving:
            <a href="/services/property-verification-lucknow" style="color:rgba(255,255,255,.65);text-decoration:underline;">Lucknow</a> ·
            <a href="/services/property-verification-varanasi" style="color:rgba(255,255,255,.65);text-decoration:underline;">Varanasi</a> ·
            <a href="/services/property-verification-noida" style="color:rgba(255,255,255,.65);text-decoration:underline;">Noida</a> ·
            <a href="/services/property-verification-greater-noida" style="color:rgba(255,255,255,.65);text-decoration:underline;">Greater Noida</a> ·
            <a href="/services/property-verification-prayagraj" style="color:rgba(255,255,255,.65);text-decoration:underline;">Prayagraj</a> ·
            <a href="/services/property-verification-ayodhya" style="color:rgba(255,255,255,.65);text-decoration:underline;">Ayodhya</a>
        </p>
    </div>
</section>

</div>{{-- .pv-wrap --}}

<div class="pv-mobile-cta" id="pvMobileCta">
    <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20property%20verification%20in%20Agra" class="whatsapp">WhatsApp</a>
    <a href="#pricing" class="book">₹5,000 →</a>
</div>

<script>
function pvFaq(btn) {
    const ans = btn.nextElementSibling;
    const isOpen = ans.classList.contains('open');
    document.querySelectorAll('.pv-faq-a.open').forEach(a => { a.classList.remove('open'); a.previousElementSibling.classList.remove('open'); });
    if (!isOpen) { ans.classList.add('open'); btn.classList.add('open'); }
}

const pvObserver = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); pvObserver.unobserve(e.target); } });
}, { threshold: 0.1 });
document.querySelectorAll('.pv-rv').forEach(el => pvObserver.observe(el));

window.addEventListener('scroll', () => {
    document.getElementById('pvMobileCta').classList.toggle('show', window.scrollY > 400);
}, { passive: true });
</script>

@endsection
