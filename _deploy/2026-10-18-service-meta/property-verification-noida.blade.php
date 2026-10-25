@extends('layouts.user-app')

@section('title', 'Property Verification Service Noida — Hire Flat & Plot Verifier ₹5,000 | DSD')

@section('meta_description', 'Hire a professional property verifier in Noida & Greater Noida. We check builder registry dues, Noida Authority lease status, farmer land disputes, RERA compliance & Sub-Registrar records at source. PDF report in 48 hours. ₹5,000 fixed fee.')

@section('meta_keywords', 'property verification service noida, property verifier noida, property verification cost noida, flat verification noida, property document check noida greater noida, noida authority lease verification')

@section('canonical', 'https://dsdproperties.in/services/property-verification-noida')

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
    { "@type": "City", "name": "Noida" },
    { "@type": "City", "name": "Greater Noida" }
  ],
  "sameAs": ["https://wa.me/918595002933"]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Property Verification Service",
  "name": "Professional Property Verification Service in Noida & Greater Noida",
  "description": "Hire an independent property verifier in Noida. We check builder registry dues to Noida Authority, lease vs freehold status, RERA registration and compliance, farmer land dispute status, stuck project recovery timeline, Sub-Registrar records and court orders. PDF report in 48 hours.",
  "provider": { "@id": "https://dsdproperties.in/#organization" },
  "areaServed": [
    { "@type": "City", "name": "Noida", "containedInPlace": { "@type": "State", "name": "Uttar Pradesh" } },
    { "@type": "City", "name": "Greater Noida", "containedInPlace": { "@type": "State", "name": "Uttar Pradesh" } }
  ],
  "offers": [
    { "@type": "Offer", "name": "Flat / Builder Floor Verification", "price": "5000", "priceCurrency": "INR", "description": "Builder dues check, RERA compliance, title chain, registry status, Noida Authority lease verification. PDF in 48 hours." },
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
    { "@type": "Question", "name": "How much does property verification cost in Noida?",
      "acceptedAnswer": { "@type": "Answer", "text": "Property verification in Noida and Greater Noida starts at ₹5,000 for residential flats and plots, ₹7,000 for commercial properties, and ₹10,000 for the premium package with a physical site visit. All packages include a PDF report within 48 hours. No hidden charges." } },
    { "@type": "Question", "name": "Is Noida property freehold or leasehold?",
      "acceptedAnswer": { "@type": "Answer", "text": "Most land in Noida is leasehold — originally allotted by the Noida Authority (GNIDA) on 90-year or 99-year lease terms. This means the ultimate ownership stays with the Authority, and any transfer must be compliant with lease conditions. When you buy a flat in Noida, you are buying the leasehold rights. We verify the exact lease status, outstanding dues to the Authority, and whether the builder's lease is in good standing before you pay." } },
    { "@type": "Question", "name": "What are builder dues to Noida Authority and why do they matter?",
      "acceptedAnswer": { "@type": "Answer", "text": "Builders in Noida must pay land premium, interest dues and other charges to the Noida Authority before they can apply for registry of individual flats. If a builder has unpaid dues, no flat in that project can be registered — the buyer is stuck in legal limbo. This is the most common property trap in Noida. Our verification checks the exact dues status of your builder's project before you pay the full amount." } },
    { "@type": "Question", "name": "What is farmer land (kisan bhoomi) dispute in Noida?",
      "acceptedAnswer": { "@type": "Answer", "text": "Noida was built on agricultural land acquired from farmers in the 1970s-80s. Many farmers challenged their acquisition in court, arguing inadequate compensation. Some cases resulted in court orders requiring re-acquisition or additional payment. If your plot falls on land where acquisition is disputed or stayed, the title is not clear. We check farmer dispute status at the Collector office and relevant court records for every plot verification." } },
    { "@type": "Question", "name": "What is the difference between Noida Authority, Greater Noida Authority and YEIDA?",
      "acceptedAnswer": { "@type": "Answer", "text": "Noida Authority (GNIDA) governs Noida sectors 1-168. Greater Noida Authority (GNIDA) governs Greater Noida, Noida Extension (Greater Noida West), and the Knowledge Park areas. YEIDA (Yamuna Expressway Industrial Development Authority) governs the Yamuna Expressway corridor including Jewar. Each has different lease terms, dues structures and approval processes. Our verification identifies which authority governs your property and checks the appropriate records." } },
    { "@type": "Question", "name": "How do I know if my Noida builder project is stuck?",
      "acceptedAnswer": { "@type": "Answer", "text": "Checking RERA registration tells you if a project is registered, but it does not tell you if construction has actually progressed or if there are pending builder dues to the Authority that will block registry. Our verification checks RERA registration and complaint history, actual construction status from site visit (premium package), builder's dues position with Noida/Greater Noida Authority, and any Supreme Court or Allahabad HC orders on the project." } },
    { "@type": "Question", "name": "Can NRIs use DSD Properties for Noida property verification?",
      "acceptedAnswer": { "@type": "Answer", "text": "Yes. Noida is one of the most popular NRI investment destinations in North India, and also one of the most fraud-prone given the builder crisis history. You WhatsApp documents from anywhere, we physically verify at Noida Authority offices, Sub-Registrar and courts, and deliver a PDF report. The ₹10,000 premium package adds a site visit with construction progress photos." } },
    { "@type": "Question", "name": "Which areas of Noida do you cover?",
      "acceptedAnswer": { "@type": "Answer", "text": "We cover all of Noida (all sectors), Greater Noida, Greater Noida West (Noida Extension), Yamuna Expressway corridor, and Dadri. No extra charge for any location within Gautam Buddha Nagar district." } }
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
    { "@type": "ListItem", "position": 3, "name": "Property Verification Service Noida", "item": "https://dsdproperties.in/services/property-verification-noida" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "How to Get Property Verified in Noida",
  "description": "Hire DSD Properties for independent property verification in Noida and Greater Noida. Physical checks at Noida Authority, Sub-Registrar, and courts. PDF report in 48 hours at ₹5,000.",
  "totalTime": "PT48H",
  "estimatedCost": { "@type": "MonetaryAmount", "currency": "INR", "value": "5000" },
  "step": [
    { "@type": "HowToStep", "position": 1, "name": "WhatsApp Free Preliminary Check", "text": "Send the property address, builder name and project on WhatsApp to +91-8595002933. We do a free preliminary RERA and Noida Authority dues check within 2 hours.", "url": "https://dsdproperties.in/services/property-verification-noida" },
    { "@type": "HowToStep", "position": 2, "name": "Share Available Documents", "text": "Share builder-buyer agreement, allotment letter, RERA number — whatever you have. Even just the project address is enough to start.", "url": "https://dsdproperties.in/services/property-verification-noida" },
    { "@type": "HowToStep", "position": 3, "name": "Pay ₹5,000 Verification Fee", "text": "Pay ₹5,000 for residential flats and plots, ₹7,000 for commercial, or ₹10,000 for the premium package with site visit. UPI or bank transfer. Invoice issued.", "url": "https://dsdproperties.in/services/property-verification-noida" },
    { "@type": "HowToStep", "position": 4, "name": "We Verify at Source in Noida", "text": "Our team physically checks builder dues to Noida Authority, lease status, RERA registration and complaint history, farmer land dispute status, Sub-Registrar encumbrance, and Allahabad HC / district court orders.", "url": "https://dsdproperties.in/services/property-verification-noida" },
    { "@type": "HowToStep", "position": 5, "name": "Receive Detailed PDF Report in 48 Hours", "text": "A clear PDF report with every check performed, any red flags found, and a final verdict: Safe to Buy or Do Not Proceed. Delivered within 48 hours.", "url": "https://dsdproperties.in/services/property-verification-noida" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Property Verification Service Noida — Hire Flat & Plot Verifier ₹5,000",
  "url": "https://dsdproperties.in/services/property-verification-noida",
  "description": "Hire a professional property verifier in Noida. We check builder registry dues, Noida Authority lease status, farmer land disputes, RERA compliance and Sub-Registrar records at source. PDF report in 48 hours. ₹5,000 fixed fee.",
  "speakable": { "@type": "SpeakableSpecification", "cssSelector": [".pv-hero__sub", ".pv-ssub", ".pv-step p", ".pv-faq-a"] },
  "about": {
    "@type": "Service",
    "name": "Property Verification Service Noida",
    "description": "Independent physical verification of property documents in Noida including builder dues to Noida Authority, lease status, RERA compliance, farmer land disputes, and court records. PDF report in 48 hours at ₹5,000.",
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

/* Noida hero — dark steel blue / tech city */
.pv-hero { position: relative; overflow: hidden; min-height: 88vh; background: linear-gradient(135deg, #020b1a 0%, #061833 45%, #0a2847 100%); display: flex; align-items: center; }
.pv-hero__grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(0,180,255,.04) 1px, transparent 1px), linear-gradient(90deg, rgba(0,180,255,.04) 1px, transparent 1px); background-size: 50px 50px; }
.pv-hero__orb { position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none; }
.pv-hero__orb--a { width: 520px; height: 520px; background: rgba(0,140,255,.16); top: -140px; right: -100px; animation: pv-float 9s ease-in-out infinite; }
.pv-hero__orb--b { width: 380px; height: 380px; background: rgba(255,92,0,.1); bottom: -80px; left: -60px; animation: pv-float 11s ease-in-out infinite 3s; }
.pv-hero__body { position: relative; z-index: 2; padding-top: 60px; padding-bottom: 70px; display:grid; grid-template-columns: 1.15fr 1fr; gap: 50px; align-items: center; }
@media(max-width:900px){ .pv-hero__body { grid-template-columns: 1fr; gap: 30px; padding-top: 80px; } }

.pv-hero__left { animation: pv-up .6s ease both; }
.pv-hero__badge { display: inline-flex; align-items: center; gap: 9px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); border-radius: 99px; padding: 7px 16px; margin-bottom: 22px; font-size: 11px; font-weight: 500; color: rgba(255,255,255,.85); backdrop-filter: blur(8px); }
.pv-pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: #4ade80; flex-shrink: 0; animation: pvPulse 2.5s infinite; display: inline-block; }
.pv-hero__h1 { font-size: clamp(1.85rem, 3.6vw, 2.7rem); font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 18px; letter-spacing: -.4px; }
.pv-hero__h1 em { font-style: normal; color: #38bdf8; }
.pv-hero__sub { font-size: .95rem; color: rgba(255,255,255,.82); line-height: 1.78; margin-bottom: 26px; max-width: 580px; }
.pv-hero__cta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 26px; }
.pv-hero__pills { display: flex; flex-wrap: wrap; gap: 8px; }
.pv-pill { display: flex; align-items: center; gap: 6px; padding: 5px 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); border-radius: 8px; font-size: 11px; color: rgba(255,255,255,.75); }

.pv-hero__card { background: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 28px 72px rgba(0,0,0,.35); animation: pv-up .7s ease .15s both; }
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

/* Noida crisis alert */
.pv-crisis-banner { background: linear-gradient(135deg, #1e1b4b, #312e81); border-radius: 14px; padding: 24px 28px; max-width: 920px; margin: 0 auto 36px; display: flex; gap: 16px; align-items: flex-start; border: 1px solid rgba(99,102,241,.25); }
.pv-crisis-icon { font-size: 1.8rem; flex-shrink: 0; }
.pv-crisis-title { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
.pv-crisis-text { font-size: .84rem; color: rgba(255,255,255,.8); line-height: 1.65; }

.pv-noida-box { background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1.5px solid rgba(37,99,235,.18); border-radius: 16px; padding: 28px 30px; max-width: 920px; margin: 0 auto 40px; }
.pv-noida-box h3 { font-size: 1.05rem; font-weight: 800; color: var(--pv-navy); margin-bottom: 14px; }
.pv-noida-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px; }
.pv-noida-item { display: flex; gap: 10px; align-items: flex-start; background: #fff; border-radius: 10px; padding: 13px 14px; border: 1px solid rgba(37,99,235,.12); }
.pv-noida-item-icon { font-size: 1.2rem; flex-shrink: 0; }
.pv-noida-item-title { font-size: .82rem; font-weight: 700; color: var(--pv-navy); margin-bottom: 3px; }
.pv-noida-item-text  { font-size: .74rem; color: var(--pv-t2); line-height: 1.55; }

/* Authority zone table */
.pv-authority-table { max-width: 860px; margin: 0 auto 40px; border-radius: 14px; overflow: hidden; border: 1px solid var(--pv-border); box-shadow: 0 4px 16px rgba(0,0,0,.06); }
.pv-authority-head { display: grid; grid-template-columns: 1fr 1fr 1fr; background: linear-gradient(135deg, var(--pv-navy), #013870); color:#fff; }
.pv-authority-head > div { padding: 14px 16px; font-size: .8rem; font-weight: 700; border-right: 1px solid rgba(255,255,255,.1); }
.pv-authority-head > div:last-child { border-right: none; }
.pv-authority-row { display: grid; grid-template-columns: 1fr 1fr 1fr; border-top: 1px solid var(--pv-border); }
.pv-authority-row > div { padding: 12px 16px; font-size: .8rem; color: var(--pv-t2); border-right: 1px solid var(--pv-border); line-height: 1.5; }
.pv-authority-row > div:last-child { border-right: none; }
.pv-authority-row > div:first-child { font-weight: 700; color: var(--pv-t1); background: var(--pv-bg2); }
@media(max-width:600px){ .pv-authority-head, .pv-authority-row { grid-template-columns: 1fr; } .pv-authority-head > div, .pv-authority-row > div { border-right: none; border-bottom: 1px solid rgba(255,255,255,.1); } .pv-authority-row > div { border-bottom: 1px solid var(--pv-border); } }

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

.pv-area-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; max-width: 900px; margin: 0 auto; }
.pv-area-pill { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 10px; padding: 11px 14px; font-size: .8rem; font-weight: 600; color: var(--pv-t1); text-align: center; transition: all .2s; }
.pv-area-pill:hover { border-color: var(--pv-teal); color: var(--pv-teal); background: rgba(0,128,128,.04); }

.pv-cta { background: linear-gradient(135deg, #020b1a 0%, #061833 45%, #0a2847 100%); padding: 70px 0; position: relative; overflow: hidden; }
.pv-cta__orb { position: absolute; border-radius: 50%; filter: blur(80px); width: 420px; height: 420px; background: rgba(0,140,255,.12); top: -120px; right: -100px; animation: pv-float 10s ease-in-out infinite; }
.pv-cta__inner { position: relative; z-index: 2; text-align: center; }
.pv-cta h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color:#fff; margin-bottom: 12px; }
.pv-cta p  { font-size: .92rem; color: rgba(255,255,255,.78); max-width: 580px; margin: 0 auto 30px; line-height: 1.7; }
.pv-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

.pv-faq-item { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 12px; overflow: hidden; }
.pv-faq-q { width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-family: 'Poppins', sans-serif; font-size: .88rem; font-weight: 600; color: var(--pv-t1); cursor: pointer; text-align: left; gap: 12px; transition: background .2s; }
.pv-faq-q:hover { background: var(--pv-bg2); }
.pv-faq-q i { color: var(--pv-teal); flex-shrink: 0; transition: transform .3s; font-size: .78rem; }
.pv-faq-q.open i { transform: rotate(180deg); }
.pv-faq-a { padding: 0 20px; max-height: 0; overflow: hidden; font-size: .83rem; color: var(--pv-t2); line-height: 1.75; transition: max-height .35s ease, padding .35s ease; }
.pv-faq-a.open { max-height: 800px; padding: 0 20px 16px; }

.pv-mobile-cta { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: var(--pv-card); border-top: 3px solid var(--pv-orange); padding: 10px 14px; z-index: 90; box-shadow: 0 -4px 20px rgba(0,0,0,.12); gap: 8px; }
.pv-mobile-cta.show { display: flex; }
.pv-mobile-cta a { flex: 1; text-align: center; padding: 11px 8px; border-radius: 9px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .8rem; text-decoration: none; }
.pv-mobile-cta a.whatsapp { background: #25D366; color:#fff; }
.pv-mobile-cta a.book { background: linear-gradient(135deg, #FF5C00, #ff8840); color:#fff; }

@media(max-width:860px){ .pv-section { padding: 56px 0; } .pv-cta { padding: 56px 0; } }
@media(max-width:480px){ .pv-hero__cta { flex-direction: column; } .pv-risk-banner { flex-direction: column; gap: 10px; } .pv-crisis-banner { flex-direction: column; gap: 10px; } }
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
                <li style="color:#fff; font-weight:500;">Property Verification Noida</li>
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
                Noida & Greater Noida's Independent Property Verifier
            </div>

            <h1 class="pv-hero__h1">
                Professional Property<br>
                Verification <em>Service</em> in<br>
                Noida — ₹5,000.
            </h1>

            <p class="pv-hero__sub">
                Noida's builder crisis proved that RERA registration alone is not enough. Unpaid Authority dues blocking registry, stuck possession, farmer land disputes, and leasehold title issues trap buyers every year. Don't pay ₹80 lakhs without spending ₹5,000 on independent verification. <strong style="color:#38bdf8;">PDF report in 48 hours.</strong>
            </p>

            <div class="pv-hero__cta">
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20you%20for%20property%20verification%20in%20Noida.%20Property%20address%3A" class="pv-btn pv-btn--whatsapp">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Hire a Verifier — WhatsApp Us
                </a>
                <a href="#pricing" class="pv-btn pv-btn--ghost">See Pricing →</a>
            </div>

            <div class="pv-hero__pills">
                <div class="pv-pill"><i class="fas fa-clock"></i> 48-Hour PDF Report</div>
                <div class="pv-pill"><i class="fas fa-building"></i> Builder Dues Checked</div>
                <div class="pv-pill"><i class="fas fa-globe"></i> NRI-Friendly</div>
            </div>
        </div>

        <div class="pv-hero__card">
            <div class="pv-hero__card-tag">FLAT / PLOT — NOIDA & GREATER NOIDA</div>
            <div class="pv-hero__card-title">Hire a Noida Property Verifier</div>
            <div class="pv-hero__card-sub">Trained verifier checks Noida Authority dues, builder RERA status, Sub-Registrar title chain, farmer land disputes and court orders. PDF report in 48 hours.</div>

            <div class="pv-hero__card-price">
                <span class="pv-hero__card-price-amt">₹5,000</span>
                <span class="pv-hero__card-price-lbl">all-inclusive · no hidden fees</span>
            </div>

            <ul class="pv-hero__card-list">
                <li>Builder dues to Noida Authority checked</li>
                <li>RERA registration & complaint history</li>
                <li>Registry & leasehold title chain</li>
                <li>Farmer land dispute status check</li>
                <li>Final verdict: Safe to Buy or Walk Away</li>
            </ul>

            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20book%20the%20%E2%82%B95%2C000%20property%20verification%20in%20Noida.%20Property%20address%3A" class="pv-hero__card-btn">Book ₹5,000 Verification on WhatsApp</a>
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
            <div><div class="pv-metric__num">1<span>L+</span></div><div class="pv-metric__label">Stuck Flats in NCR Region</div></div>
            <div><div class="pv-metric__num">30 yr</div><div class="pv-metric__label">Title Chain Traced</div></div>
            <div><div class="pv-metric__num">48 hr</div><div class="pv-metric__label">PDF Report Delivery</div></div>
            <div><div class="pv-metric__num">₹5K</div><div class="pv-metric__label">vs ₹80L At Risk</div></div>
        </div>
    </div>
</section>

{{-- ═══════════ NOIDA-SPECIFIC RISKS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Noida-Specific</span>
        <h2 class="pv-stitle pv-rv">Why Noida Property Verification Is Completely Different</h2>
        <p class="pv-ssub pv-rv">Noida risks are urban and builder-driven — not the land-record and flood-zone issues of other UP cities. The Amrapali and Supertech crises showed that even Supreme Court intervention doesn't guarantee your money back. The only real protection is verification before you pay.</p>

        <div class="pv-crisis-banner pv-rv">
            <div class="pv-crisis-icon">🏗️</div>
            <div>
                <div class="pv-crisis-title">The Noida Builder Crisis Is Not Over</div>
                <div class="pv-crisis-text">Over 1 lakh flats across Noida and Greater Noida remain stuck — built partially or fully but unable to offer registry because builders owe hundreds of crores to the Noida Authority and Greater Noida Authority. <strong style="color:#a5b4fc;">Buying a resale flat in a project with pending dues means you inherit the problem.</strong> RERA shows registration — it does not show dues status. Only a physical check at the Authority office reveals this.</div>
            </div>
        </div>

        <div class="pv-noida-box pv-rv">
            <h3>🏙️ Noida-Specific Risks We Check Explicitly</h3>
            <div class="pv-noida-grid">
                <div class="pv-noida-item">
                    <div class="pv-noida-item-icon">🏦</div>
                    <div>
                        <div class="pv-noida-item-title">Builder Dues to Noida / Greater Noida Authority</div>
                        <div class="pv-noida-item-text">Unpaid land premium and interest dues to the Authority block registry of individual flats. We check the builder's dues status directly at the Authority office — the single most important check for any Noida flat purchase.</div>
                    </div>
                </div>
                <div class="pv-noida-item">
                    <div class="pv-noida-item-icon">📋</div>
                    <div>
                        <div class="pv-noida-item-title">Leasehold vs Freehold Status</div>
                        <div class="pv-noida-item-text">Most Noida land is leasehold from the Authority — not freehold. Lease terms, transfer conditions and outstanding lease dues must be checked before any purchase. Many buyers don't realise this affects resale rights and bank mortgage eligibility.</div>
                    </div>
                </div>
                <div class="pv-noida-item">
                    <div class="pv-noida-item-icon">🧑‍🌾</div>
                    <div>
                        <div class="pv-noida-item-title">Farmer Land (Kisan Bhoomi) Disputes</div>
                        <div class="pv-noida-item-text">Noida was carved from agricultural land acquired from farmers in the 1970s-2000s. Many farmers challenged acquisition in court — some cases resulted in stay orders or re-acquisition requirements. Plots on disputed farmer land carry unresolved title risk.</div>
                    </div>
                </div>
                <div class="pv-noida-item">
                    <div class="pv-noida-item-icon">🏛️</div>
                    <div>
                        <div class="pv-noida-item-title">Supreme Court / HC Orders on Projects</div>
                        <div class="pv-noida-item-text">Several Noida projects have active Supreme Court or Allahabad HC orders — receivership, demolition stay, or insolvency proceedings. Buying in a project under such orders locks your money indefinitely. We check for active court orders on the specific project.</div>
                    </div>
                </div>
                <div class="pv-noida-item">
                    <div class="pv-noida-item-icon">🔑</div>
                    <div>
                        <div class="pv-noida-item-title">Registry / Occupation Certificate Status</div>
                        <div class="pv-noida-item-text">A flat without an Occupation Certificate (OC) from the Authority cannot be legally registered or sold. Many completed buildings in Noida lack OC due to builder violations. We check OC status and registry readiness before you pay resale price.</div>
                    </div>
                </div>
                <div class="pv-noida-item">
                    <div class="pv-noida-item-icon">⚖️</div>
                    <div>
                        <div class="pv-noida-item-title">Resale Flat Hidden Mortgage / Legal Dispute</div>
                        <div class="pv-noida-item-text">Resale flats in Noida are frequently mortgaged with banks — sometimes without the seller disclosing it. Bank charges on the property block transfer. We check the Sub-Registrar records and Noida Authority for any registered encumbrance on the flat.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Authority zone table --}}
        <span class="pv-slabel pv-rv" style="margin-top:8px;">Understanding Jurisdiction</span>
        <h3 class="pv-stitle pv-rv" style="font-size:1.4rem; margin-bottom:8px;">Which Authority Governs Your Noida Property?</h3>
        <p class="pv-ssub pv-rv" style="margin-bottom:24px;">The rules, dues structure and approval process differ by authority. Knowing which governs your plot determines which records we check.</p>

        <div class="pv-authority-table pv-rv">
            <div class="pv-authority-head">
                <div>Zone</div>
                <div>Governing Authority</div>
                <div>Key Record to Check</div>
            </div>
            <div class="pv-authority-row">
                <div>Noida Sectors 1–168</div>
                <div>GNIDA (Noida Authority)</div>
                <div>Lease deed, builder dues, OC status</div>
            </div>
            <div class="pv-authority-row">
                <div>Greater Noida & Noida Extension (GN West)</div>
                <div>Greater Noida Authority (GNIDA)</div>
                <div>Builder dues, OC, plot allotment letter</div>
            </div>
            <div class="pv-authority-row">
                <div>Yamuna Expressway Sectors</div>
                <div>YEIDA</div>
                <div>YEIDA allotment, lease status, acquisition clarity</div>
            </div>
            <div class="pv-authority-row">
                <div>Dadri / Rural Pockets</div>
                <div>Tehsil (revenue records)</div>
                <div>Khatauni, khasra, mutation, farmer dispute</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ DIY VS HIRE ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Honest Comparison</span>
        <h2 class="pv-stitle pv-rv">Doing It Yourself vs. Hiring DSD Properties</h2>
        <p class="pv-ssub pv-rv">RERA shows registration. It does not show dues status, OC status, court orders, or hidden mortgages. Here's what you can verify online — and what requires physical presence at Noida Authority offices.</p>

        <div class="pv-diy-table pv-rv">
            <div class="pv-diy-head">
                <div>What You Check</div>
                <div>Doing It Yourself</div>
                <div>Hiring DSD Properties</div>
            </div>
            <div class="pv-diy-row">
                <div>Builder dues to Authority</div>
                <div class="pv-diy-bad">Cannot check online — not publicly listed</div>
                <div class="pv-diy-good">Physical check at Noida / GN Authority office</div>
            </div>
            <div class="pv-diy-row">
                <div>Occupation Certificate (OC)</div>
                <div class="pv-diy-bad">Seller says "OC received" — cannot verify</div>
                <div class="pv-diy-good">OC status confirmed at Authority records</div>
            </div>
            <div class="pv-diy-row">
                <div>RERA complaint history</div>
                <div class="pv-diy-bad">RERA shows registration, not full dispute history</div>
                <div class="pv-diy-good">Full complaint & order history checked</div>
            </div>
            <div class="pv-diy-row">
                <div>Farmer land dispute</div>
                <div class="pv-diy-bad">Not visible on any portal</div>
                <div class="pv-diy-good">Collector + court records checked</div>
            </div>
            <div class="pv-diy-row">
                <div>Hidden bank mortgage on resale flat</div>
                <div class="pv-diy-bad">Seller may not disclose</div>
                <div class="pv-diy-good">Sub-Registrar encumbrance extracted</div>
            </div>
            <div class="pv-diy-row">
                <div>Supreme Court / HC orders on project</div>
                <div class="pv-diy-bad">Difficult to track without legal access</div>
                <div class="pv-diy-good">Active court orders searched at source</div>
            </div>
            <div class="pv-diy-row">
                <div>Written evidence if dispute arises</div>
                <div class="pv-diy-bad">None</div>
                <div class="pv-diy-good">PDF report admissible as evidence</div>
            </div>
        </div>

        <div style="text-align:center; margin-top:28px;">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20a%20property%20verifier%20in%20Noida" class="pv-btn pv-btn--primary">Hire Us — Book Verification →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHAT WE CHECK ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What's Included</span>
        <h2 class="pv-stitle pv-rv">What We Check in Noida — For You</h2>
        <p class="pv-ssub pv-rv">Every Noida verification covers builder-specific checks not available in any other city — Authority dues, OC status, RERA complaint depth, and farmer land title — plus the standard title and court checks.</p>

        <div class="pv-check-grid">
            <div class="pv-check-card pv-rv">
                <div class="pv-check-card__icon">🏦</div>
                <div>
                    <div class="pv-check-card__title">Builder Dues to Noida / Greater Noida Authority</div>
                    <p class="pv-check-card__text">The #1 Noida-specific check. We physically visit the relevant Authority office (Noida, Greater Noida, or YEIDA) and check whether the builder's project has outstanding dues. Even a single rupee of unpaid dues can block the entire project's registry. This check alone is worth more than the ₹5,000 fee.</p>
                    <div class="pv-check-card__where">Noida Authority / Greater Noida Authority / YEIDA Office</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">🔑</div>
                <div>
                    <div class="pv-check-card__title">Occupation Certificate & Registry Status</div>
                    <p class="pv-check-card__text">We confirm whether the Occupation Certificate has been issued by the Authority for the specific building/tower. Without OC, the flat cannot be legally registered or used as a bank mortgage. We also check whether the builder has applied for registry and whether it is currently blocked.</p>
                    <div class="pv-check-card__where">Noida / Greater Noida Authority Records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.12s">
                <div class="pv-check-card__icon">📋</div>
                <div>
                    <div class="pv-check-card__title">RERA Registration & Full Complaint History</div>
                    <p class="pv-check-card__text">Beyond basic RERA registration status, we check the project's full complaint and order history on UP-RERA. Repeated complaints, penalty orders, or directions to refund are warning signs that a project may not deliver. We report the complete picture, not just the registration number.</p>
                    <div class="pv-check-card__where">UP-RERA portal + Authority records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.18s">
                <div class="pv-check-card__icon">📄</div>
                <div>
                    <div class="pv-check-card__title">Sub-Registrar Title Chain & Encumbrance</div>
                    <p class="pv-check-card__text">For resale flats, we verify the full title chain at the Sub-Registrar (Dadri) and extract a 30-year encumbrance certificate to reveal any existing bank mortgages, registered charges, or legal claims on the flat. A clean encumbrance certificate is mandatory before any resale purchase.</p>
                    <div class="pv-check-card__where">Sub-Registrar, Gautam Buddha Nagar (Dadri)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">📋</div>
                <div>
                    <div class="pv-check-card__title">Leasehold Tenure & Transfer Conditions</div>
                    <p class="pv-check-card__text">We verify the exact lease terms of the land — 90 years or 99 years, remaining term, any sub-lease conditions, and whether the lease is in default. For plots directly allotted by the Authority, we check allotment letter status, cancellation risk and transfer fee dues.</p>
                    <div class="pv-check-card__where">Noida / Greater Noida Authority lease records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.10s">
                <div class="pv-check-card__icon">🧑‍🌾</div>
                <div>
                    <div class="pv-check-card__title">Farmer Land Acquisition Dispute Check</div>
                    <p class="pv-check-card__text">For plots in areas developed after 2000 — particularly in Greater Noida West and Yamuna Expressway sectors — we check whether the underlying land acquisition was challenged by farmers in court, and whether any stay order or re-acquisition direction is active on the specific survey number.</p>
                    <div class="pv-check-card__where">Collector Office + Allahabad HC / District Court</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.16s">
                <div class="pv-check-card__icon">🏛️</div>
                <div>
                    <div class="pv-check-card__title">Supreme Court / High Court Order Search</div>
                    <p class="pv-check-card__text">We check for any active Supreme Court orders (via cause list and judgment search) and Allahabad HC orders on the builder project or the specific tower/phase. Projects under receivership, NCLT/IBC proceedings, or SC-directed escrow are identified and flagged clearly.</p>
                    <div class="pv-check-card__where">Supreme Court cause list + Allahabad HC records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.22s">
                <div class="pv-check-card__icon">🗺️</div>
                <div>
                    <div class="pv-check-card__title">Khatauni & Revenue Records (Plots)</div>
                    <p class="pv-check-card__text">For independent plots and builder floors in Noida's village pockets (abadi land) or Dadri tehsil areas outside Authority jurisdiction, we verify Khatauni, Khasra and Dakhil Kharij at the relevant Tehsil — the same rigorous revenue check we apply in other UP cities.</p>
                    <div class="pv-check-card__where">Tehsil Sadar / Dadri / Jewar</div>
                </div>
            </div>
        </div>

        <div style="margin-top:32px; text-align:center;">
            <p style="font-size:.86rem; color:var(--pv-t2); max-width:660px; margin:0 auto 18px; line-height:1.7;">Every check above requires physical presence at Noida Authority offices and courts. We do it all in 48 hours.</p>
            <a href="#pricing" class="pv-btn pv-btn--primary">See ₹5,000 Pricing →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHY IT MATTERS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Why It Matters</span>
        <h2 class="pv-stitle pv-rv">Why ₹5,000 Verification Saves You ₹80 Lakhs in Noida</h2>
        <p class="pv-ssub pv-rv">Six scenarios trap Noida buyers every year. All are preventable with a verification done before payment.</p>

        <div class="pv-risk-grid">
            <div class="pv-risk-card pv-rv"><div class="pv-risk-icon">🏦</div><div><div class="pv-risk-title">Builder Dues Block Your Registry Forever</div><p class="pv-risk-text">You buy a resale flat at ₹80 lakhs. Builder owes ₹40 crore to the Authority. Registry is blocked indefinitely. You own nothing you can legally transfer or mortgage. This happens today in multiple Noida projects.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.06s"><div class="pv-risk-icon">🔑</div><div><div class="pv-risk-title">No OC Means No Registry & No Bank Loan</div><p class="pv-risk-text">You pay full amount for a completed flat. No Occupation Certificate exists — builder violated construction norms. You cannot register. No bank will give a home loan against it. You're stuck in legal limbo indefinitely.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.12s"><div class="pv-risk-icon">🏛️</div><div><div class="pv-risk-title">Project Under SC / NCLT Order</div><p class="pv-risk-text">Project under NCLT insolvency or SC-directed receivership — money goes into escrow, delivery timeline becomes entirely uncertain, resale value drops to near zero. Buyers have waited 10+ years in some Noida cases.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.18s"><div class="pv-risk-icon">🧑‍🌾</div><div><div class="pv-risk-title">Farmer Dispute Invalidates Your Title</div><p class="pv-risk-text">High Court rules in favour of farmers challenging acquisition in the sector your plot is in. Government must re-acquire. Your developer's title is challenged. Legal battle lasts years — your money is frozen throughout.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.24s"><div class="pv-risk-icon">📄</div><div><div class="pv-risk-title">Hidden Mortgage on Resale Flat</div><p class="pv-risk-text">Seller took a bank loan against the flat without disclosing it. Bank has first charge. You pay the seller, bank attaches the property. You lose the flat and must sue the seller — a multi-year legal exercise.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.30s"><div class="pv-risk-icon">📋</div><div><div class="pv-risk-title">Lease Violation Cancels Your Allotment</div><p class="pv-risk-text">Builder violated sub-lease terms — unauthorised construction, unpaid conversion charges, or non-compliance with Authority conditions. Authority cancels the lease. Your flat's entire legal basis disappears.</p></div></div>
        </div>

        <div class="pv-risk-banner pv-rv">
            <div class="pv-risk-banner-icon">❗</div>
            <div>
                <div class="pv-risk-banner-title">RERA Registration Is Not Enough — Never Was</div>
                <div class="pv-risk-banner-text">Amrapali was RERA-registered. Unitech projects were RERA-registered. Supertech's towers were RERA-registered — and then demolished. RERA tells you a project exists. It does not tell you the builder's dues status, OC availability, or whether a court order has frozen the project. Only a physical Authority-level check does that.</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ PROCESS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Simple Process</span>
        <h2 class="pv-stitle pv-rv">How to Hire DSD for Noida Property Verification</h2>
        <p class="pv-ssub pv-rv">From first WhatsApp to PDF report in 5 steps. Fully remote — you don't need to visit the Authority offices.</p>

        <div class="pv-steps">
            <div class="pv-step pv-rv"><div class="pv-step__num">1</div><div><h3>WhatsApp Free Preliminary Check</h3><p>Send the project name, tower/flat number and builder name. We check RERA registration and basic IGRS records within 2 hours — free — and tell you if a full verification is worth doing.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.06s"><div class="pv-step__num">2</div><div><h3>Share Available Documents</h3><p>Allotment letter, flat number, builder agreement, RERA number — whatever you have. The project name and sector number is enough to begin.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.12s"><div class="pv-step__num">3</div><div><h3>Pay Verification Fee</h3><p>₹5,000 for residential flats and plots, ₹7,000 for commercial, ₹10,000 for premium with site visit and construction photos. UPI or bank transfer. Invoice issued immediately.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.18s"><div class="pv-step__num">4</div><div><h3>We Verify at Source in Noida</h3><p>Our team physically checks Noida Authority / Greater Noida Authority / YEIDA dues, OC status, Sub-Registrar encumbrance, RERA complaint history, farmer land disputes and court orders — at source, not via online portals alone.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.24s"><div class="pv-step__num">5</div><div><h3>Detailed PDF Report in 48 Hours</h3><p>Every check documented, all risks flagged, and a clear final verdict: <strong>"Safe to Buy"</strong> or <strong>"Do Not Proceed."</strong> Delivered in 48 hours.</p></div></div>
        </div>
    </div>
</section>

{{-- ═══════════ REPORT PREVIEW ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What You Get</span>
        <h2 class="pv-stitle pv-rv">Inside the ₹5,000 PDF Verification Report</h2>
        <p class="pv-ssub pv-rv">A sample of what every Noida buyer receives — clear, evidence-backed, and admissible if a dispute arises later.</p>

        <div class="pv-report pv-rv">
            <div class="pv-report__header">
                <div>
                    <h3 class="pv-report__title">Property Verification Report — Sample</h3>
                    <p class="pv-report__subtitle">Flat 1204, Tower C, Sector 137 Noida · Verified 21 July 2026</p>
                </div>
                <span class="pv-report__verdict">✓ SAFE TO BUY</span>
            </div>
            <div class="pv-report__body">
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Builder Dues to Noida Authority</strong>NIL outstanding dues confirmed at Noida Authority office. Project is dues-cleared — registry not blocked on Authority account.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Occupation Certificate</strong>OC issued for Tower C on 14 March 2025. Copy of OC reference number confirmed at Authority records.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>RERA Complaint History</strong>RERA registration active. No penalty orders or refund directions issued against this project. 2 resolved complaints — both possession delay, both closed.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Encumbrance Certificate</strong>No bank mortgage, registered charge or legal claim on this flat at Sub-Registrar records.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Leasehold Lease Status</strong>Noida Authority lease in builder's name is valid. No cancellation proceedings initiated. Transfer fee structure confirmed.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Court Orders (SC + HC)</strong>No active Supreme Court or Allahabad HC orders found on this builder or project. Not under NCLT/IBC proceedings.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Farmer Land Dispute</strong>Land acquisition in Sector 137 not under active farmer dispute. Acquisition status confirmed clear.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Title Chain (Resale)</strong>Previous owner's registry confirmed at Sub-Registrar. Chain: Authority → Builder → Previous Owner → You.</div></div>
            </div>
            <div class="pv-report__footer">PDF report includes evidence from Noida Authority, Sub-Registrar, UP-RERA, SC cause list and Allahabad HC records · Delivered in 48 hours</div>
        </div>
    </div>
</section>

{{-- ═══════════ PRICING ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)" id="pricing">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Transparent Pricing</span>
        <h2 class="pv-stitle pv-rv">Property Verification Cost in Noida & Greater Noida</h2>
        <p class="pv-ssub pv-rv">Fixed fee. No per-document charges. No hidden costs. Invoice issued after payment.</p>

        <div class="pv-pricing-grid">
            <div class="pv-price-card pv-rv">
                <div class="pv-price-tag">RESIDENTIAL</div>
                <div class="pv-price-name">Standard</div>
                <div class="pv-price-amount">₹5,000</div>
                <div class="pv-price-desc">Flats, builder floors & residential plots</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Builder dues to Authority</li>
                    <li><span class="pv-price-check">✓</span> OC & registry status</li>
                    <li><span class="pv-price-check">✓</span> RERA complaint history</li>
                    <li><span class="pv-price-check">✓</span> Encumbrance certificate</li>
                    <li><span class="pv-price-check">✓</span> SC / HC order search</li>
                    <li><span class="pv-price-check">✓</span> Farmer land dispute check</li>
                    <li><span class="pv-price-check">✓</span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B95%2C000%20Standard%20property%20verification%20in%20Noida.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-price-card--featured pv-rv" style="--rd:.08s">
                <div class="pv-price-badge">⭐ MOST POPULAR</div>
                <div class="pv-price-tag">COMMERCIAL</div>
                <div class="pv-price-name">Commercial</div>
                <div class="pv-price-amount">₹7,000</div>
                <div class="pv-price-desc">Shops, offices, IT space & commercial plots</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Standard</li>
                    <li><span class="pv-price-check">✓</span> Authority commercial zoning check</li>
                    <li><span class="pv-price-check">✓</span> Fire NOC & completion status</li>
                    <li><span class="pv-price-check">✓</span> YEIDA / GNIDA zone check</li>
                    <li><span class="pv-price-check">✓</span> Lease conversion dues</li>
                    <li><span class="pv-price-check">✓</span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B97%2C000%20Commercial%20property%20verification%20in%20Noida.%20Property%20address%3A" class="pv-price-btn pv-price-btn--white">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-rv" style="--rd:.16s">
                <div class="pv-price-tag">PREMIUM</div>
                <div class="pv-price-name">Premium + Site Visit</div>
                <div class="pv-price-amount">₹10,000</div>
                <div class="pv-price-desc">Full verification with site inspection</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Commercial</li>
                    <li><span class="pv-price-check">✓</span> Physical site visit</li>
                    <li><span class="pv-price-check">✓</span> Construction progress photos</li>
                    <li><span class="pv-price-check">✓</span> Common area completion check</li>
                    <li><span class="pv-price-check">✓</span> Possession readiness report</li>
                    <li><span class="pv-price-check">✓</span> Report in 3–5 days</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B910%2C000%20Premium%20property%20verification%20with%20site%20visit%20in%20Noida.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ SERVICE AREAS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Service Coverage</span>
        <h2 class="pv-stitle pv-rv">Areas We Cover in Noida & Greater Noida</h2>
        <p class="pv-ssub pv-rv">We cover all of Gautam Buddha Nagar district — Noida sectors, Greater Noida, Noida Extension and Yamuna Expressway corridor. No extra charge.</p>

        <div class="pv-area-grid pv-rv">
            <div class="pv-area-pill">Sector 137</div>
            <div class="pv-area-pill">Sector 150</div>
            <div class="pv-area-pill">Sector 168</div>
            <div class="pv-area-pill">Sector 75–78</div>
            <div class="pv-area-pill">Sector 50</div>
            <div class="pv-area-pill">Sector 62</div>
            <div class="pv-area-pill">GN West / Noida Ext.</div>
            <div class="pv-area-pill">Knowledge Park</div>
            <div class="pv-area-pill">Alpha, Beta, Gamma</div>
            <div class="pv-area-pill">Techzone 4</div>
            <div class="pv-area-pill">Yamuna Expressway</div>
            <div class="pv-area-pill">Dadri</div>
            <div class="pv-area-pill">Jewar</div>
            <div class="pv-area-pill">Rabupura</div>
            <div class="pv-area-pill">Bisrakh</div>
            <div class="pv-area-pill">Surajpur</div>
        </div>

        <div style="text-align:center; margin-top:28px; font-size:.84rem; color:var(--pv-t2);">
            Don't see your sector? <a href="https://wa.me/918595002933" style="color:var(--pv-teal); font-weight:600;">WhatsApp us</a> — we cover all of Gautam Buddha Nagar district.
        </div>
    </div>
</section>

{{-- ═══════════ FAQ ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">FAQ</span>
        <h2 class="pv-stitle pv-rv">Property Verification in Noida — Common Questions</h2>

        <div style="max-width:820px; margin:0 auto; display:flex; flex-direction:column; gap:10px;">
            @php
            $faqs = [
                ["How much does property verification cost in Noida?", "Property verification in Noida and Greater Noida starts at ₹5,000 for residential flats and plots, ₹7,000 for commercial properties, and ₹10,000 for the premium package with a physical site visit and construction progress photos. All packages include a PDF report within 48 hours. No hidden fees."],
                ["Is Noida property freehold or leasehold?", "Most land in Noida is leasehold — originally allotted by the Noida Authority (GNIDA) on 90 or 99-year lease terms. This means the Authority retains ultimate ownership. Any transfer must comply with lease conditions, and outstanding transfer fees must be paid. We verify the exact lease status, remaining term, and any outstanding dues as part of every verification."],
                ["What are builder dues to Noida Authority and why do they matter?", "Builders must pay land premium and interest to the Noida or Greater Noida Authority before individual flat registry becomes possible. If a builder has unpaid dues — which is extremely common after the builder crisis — no flat in that project can be registered. RERA does not show dues status. Only a physical check at the Authority office reveals this, and it is the single most important check for any Noida flat purchase."],
                ["My builder says OC has been received. How do I confirm?", "You cannot confirm this from the builder's word or from any online portal. We physically check the Occupation Certificate status at the Noida or Greater Noida Authority office — confirming the OC reference number, date of issue, and whether it covers your specific tower and phase. This is included in every ₹5,000 verification."],
                ["What is farmer land dispute in Noida and how does it affect my property?", "Noida was built on agricultural land acquired from farmers starting in the 1970s. Many farmers challenged their acquisition in Allahabad High Court and the Supreme Court. Some sectors have active or historical court orders related to disputed acquisition. If your plot is on disputed farmer land, the title is not fully clear. We check farmer dispute status at the Collector office and relevant court records."],
                ["The project is RERA-registered. Isn't that enough?", "No. Amrapali, Unitech and Supertech projects were all RERA-registered. RERA registration tells you the project exists. It does not tell you the builder's dues status with the Authority, whether an OC has been issued, whether a court has passed orders on the project, or whether a resale flat has a bank mortgage. Our verification checks all of these — at source."],
                ["Can NRIs use DSD Properties for Noida property verification?", "Yes. Noida is one of the most popular NRI investment markets in North India and also one of the riskiest given the builder crisis history. You share documents from anywhere via WhatsApp, we physically verify at Authority offices and the Sub-Registrar, and deliver a PDF report. The ₹10,000 premium package adds a site visit with construction progress photos."],
                ["Do you cover Greater Noida West (Noida Extension)?", "Yes. Greater Noida West — commonly called Noida Extension — is under Greater Noida Authority (GNIDA) jurisdiction. It has a separate dues structure and approval process. We cover all sectors in Greater Noida West at the same ₹5,000 fee, with verification done at the Greater Noida Authority office rather than the Noida Authority office."],
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
        <h2>Start with a Free Preliminary Check</h2>
        <p>Send us the project name, tower number and builder name on WhatsApp. We check RERA registration and basic dues signals — free, in 2 hours — and tell you honestly if a full ₹5,000 verification is worth doing before you pay anything in Noida.</p>
        <div class="pv-cta__btns">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20a%20free%20preliminary%20property%20check%20in%20Noida.%20Project%20name%20and%20flat%20details%3A" class="pv-btn pv-btn--whatsapp">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                Free Preliminary Check — WhatsApp
            </a>
            <a href="#pricing" class="pv-btn pv-btn--ghost">View Pricing →</a>
        </div>
        <p style="margin-top:18px; font-size:.8rem; color:rgba(255,255,255,.5);">
            Also serving:
            <a href="/services/property-verification-lucknow" style="color:rgba(255,255,255,.65);text-decoration:underline;">Lucknow</a> ·
            <a href="/services/property-verification-varanasi" style="color:rgba(255,255,255,.65);text-decoration:underline;">Varanasi</a> ·
            <a href="/services/property-verification-ayodhya" style="color:rgba(255,255,255,.65);text-decoration:underline;">Ayodhya</a> ·
            <a href="/services/property-verification-gorakhpur" style="color:rgba(255,255,255,.65);text-decoration:underline;">Gorakhpur</a> ·
            <a href="/services/property-verification-prayagraj" style="color:rgba(255,255,255,.65);text-decoration:underline;">Prayagraj</a>
        </p>
    </div>
</section>

</div>{{-- .pv-wrap --}}

<div class="pv-mobile-cta" id="pvMobileCta">
    <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20property%20verification%20in%20Noida" class="whatsapp">WhatsApp</a>
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
