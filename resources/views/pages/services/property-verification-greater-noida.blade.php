@extends('layouts.user-app')

@section('title', 'Property Verification in Greater Noida — ₹5,000, 48-Hour Report | DSD')
@section('meta_description', 'Buying in Greater Noida? We check GNIDA builder dues, OC, farmer land disputes and registry records. ₹5,000 fixed fee, PDF report in 48 hours.')
@section('meta_keywords', 'property verification service greater noida, property verifier greater noida, flat verification greater noida west noida extension, property document check greater noida, GNIDA builder dues verification, property verification cost greater noida')

@section('canonical', 'https://dsdproperties.in/services/property-verification-greater-noida')

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
    { "@type": "City", "name": "Greater Noida" },
    { "@type": "Place", "name": "Greater Noida West" }
  ],
  "sameAs": ["https://wa.me/918595002933"]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Property Verification Service",
  "name": "Professional Property Verification Service in Greater Noida & Noida Extension",
  "description": "Hire an independent property verifier in Greater Noida. We check GNIDA builder dues, Occupation Certificate status, farmer land dispute records, abadi / village plot authorization, RERA complaint history, Sub-Registrar encumbrance and court orders. PDF report in 48 hours.",
  "provider": { "@id": "https://dsdproperties.in/#organization" },
  "areaServed": [
    { "@type": "City", "name": "Greater Noida", "containedInPlace": { "@type": "State", "name": "Uttar Pradesh" } },
    { "@type": "Place", "name": "Greater Noida West" }
  ],
  "offers": [
    { "@type": "Offer", "name": "Flat / Builder Floor Verification", "price": "5000", "priceCurrency": "INR", "description": "GNIDA dues check, OC status, RERA complaint history, title chain, encumbrance, farmer land check. PDF in 48 hours." },
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
    { "@type": "Question", "name": "How much does property verification cost in Greater Noida?",
      "acceptedAnswer": { "@type": "Answer", "text": "Property verification in Greater Noida and Greater Noida West (Noida Extension) costs ₹5,000 for residential flats and plots, ₹7,000 for commercial properties, and ₹10,000 for the premium package with a physical site visit and construction progress photos. PDF report delivered in 48 hours. No hidden charges." } },
    { "@type": "Question", "name": "What is GNIDA and why are its dues so important for Greater Noida flats?",
      "acceptedAnswer": { "@type": "Answer", "text": "GNIDA stands for Greater Noida Industrial Development Authority — the statutory body that owns the land and leases it to builders under sub-lease agreements. Builders must pay land premium, interest dues, and other charges to GNIDA before they can facilitate registry of individual flats. If a builder has unpaid GNIDA dues, no flat in that project can be registered — the buyer is stuck indefinitely. Our verification physically checks GNIDA dues status for the specific project before you pay." } },
    { "@type": "Question", "name": "What is Greater Noida West (Noida Extension) and is it safe to buy there?",
      "acceptedAnswer": { "@type": "Answer", "text": "Greater Noida West, commonly called Noida Extension, is a massive residential zone under GNIDA jurisdiction to the west of the main Greater Noida sectors. It became infamous after the 2011 farmer protests forced a Supreme Court stay on construction, resulting in thousands of stuck flats. Many projects resumed later but some remain unresolved. Safety depends entirely on the specific project — GNIDA dues status, OC availability, and RERA complaint history must be individually checked. We do this for ₹5,000." } },
    { "@type": "Question", "name": "What is a village abadi plot in Greater Noida and is it legal?",
      "acceptedAnswer": { "@type": "Answer", "text": "Village abadi (inhabited area) plots are land parcels within original village settlement boundaries that were excluded from GNIDA's master plan acquisition. Builder floors and independent houses on abadi land fall under gram sabha (village panchayat) jurisdiction rather than GNIDA. They cannot be registered under the normal Authority process, and bank loans are generally not available. Many buyers purchase these without realising the title limitations. We identify abadi status and flag it clearly in the report." } },
    { "@type": "Question", "name": "What is the farmer land dispute issue in Greater Noida?",
      "acceptedAnswer": { "@type": "Answer", "text": "Greater Noida was carved from agricultural land acquired from farmers — many of whom challenged the acquisition in court. The 2011 Allahabad High Court order quashing some Greater Noida West acquisitions led to the Supreme Court stay that halted thousands of projects. Some sectors still have unresolved farmer claims at the Collector's office and courts. We check the acquisition status of the specific land parcel as part of every verification." } },
    { "@type": "Question", "name": "How do I know if my Greater Noida builder project has an Occupation Certificate?",
      "acceptedAnswer": { "@type": "Answer", "text": "The Occupation Certificate is issued by GNIDA after verifying that construction complies with the approved building plan. Many completed buildings in Greater Noida lack an OC — often because builders made unauthorised deviations from the sanctioned plan. Without OC, the flat cannot be legally registered, and banks will not give a home loan against it. We physically confirm OC status at the GNIDA office, including which towers and phases have received it." } },
    { "@type": "Question", "name": "Can NRIs use DSD Properties for Greater Noida property verification?",
      "acceptedAnswer": { "@type": "Answer", "text": "Yes. Greater Noida is a major NRI investment destination and also carries significant risk given the builder dues history. You share documents from anywhere via WhatsApp, we physically verify at GNIDA offices, Sub-Registrar and courts, and deliver a PDF report. The ₹10,000 premium package includes a site visit with construction progress photos." } },
    { "@type": "Question", "name": "What areas of Greater Noida do you cover?",
      "acceptedAnswer": { "@type": "Answer", "text": "We cover all of Greater Noida — Alpha, Beta, Gamma, Delta, Zeta, Omicron, Pi, Sigma, Eta, Theta, Mu, Chi, Ecotech zones — plus all of Greater Noida West (Noida Extension) including Sector 1–16, Gaur City, Ajnara Integrity area, and Techzone 4. No extra charge for any location within Gautam Buddha Nagar district." } }
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
    { "@type": "ListItem", "position": 3, "name": "Property Verification Service Greater Noida", "item": "https://dsdproperties.in/services/property-verification-greater-noida" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "How to Get Property Verified in Greater Noida",
  "description": "Hire DSD Properties for independent property verification in Greater Noida and Noida Extension. Physical checks at GNIDA office, Sub-Registrar, and courts. PDF report in 48 hours at ₹5,000.",
  "totalTime": "PT48H",
  "estimatedCost": { "@type": "MonetaryAmount", "currency": "INR", "value": "5000" },
  "step": [
    { "@type": "HowToStep", "position": 1, "name": "WhatsApp Free Preliminary Check", "text": "Send the property address, builder name and project name on WhatsApp to +91-8595002933. We do a free preliminary RERA and GNIDA dues check within 2 hours.", "url": "https://dsdproperties.in/services/property-verification-greater-noida" },
    { "@type": "HowToStep", "position": 2, "name": "Share Available Documents", "text": "Share builder-buyer agreement, allotment letter, RERA number, project name — whatever you have. Even just the project address is enough to start.", "url": "https://dsdproperties.in/services/property-verification-greater-noida" },
    { "@type": "HowToStep", "position": 3, "name": "Pay ₹5,000 Verification Fee", "text": "Pay ₹5,000 for residential flats and plots, ₹7,000 for commercial, or ₹10,000 for the premium package with site visit. UPI or bank transfer. Invoice issued.", "url": "https://dsdproperties.in/services/property-verification-greater-noida" },
    { "@type": "HowToStep", "position": 4, "name": "We Verify at Source in Greater Noida", "text": "Our team physically checks GNIDA builder dues, Occupation Certificate status, farmer land dispute records, abadi plot authorization, RERA complaint history, Sub-Registrar encumbrance, and court orders.", "url": "https://dsdproperties.in/services/property-verification-greater-noida" },
    { "@type": "HowToStep", "position": 5, "name": "Receive Detailed PDF Report in 48 Hours", "text": "A clear PDF report with every check performed, any red flags found, and a final verdict: Safe to Buy or Do Not Proceed. Delivered within 48 hours.", "url": "https://dsdproperties.in/services/property-verification-greater-noida" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Property Verification Service Greater Noida — Flat & Plot Verifier ₹5,000",
  "url": "https://dsdproperties.in/services/property-verification-greater-noida",
  "description": "Hire a professional property verifier in Greater Noida. We check GNIDA builder dues, OC status, farmer land disputes, stuck project orders and Sub-Registrar records. PDF report in 48 hours. ₹5,000 fixed fee.",
  "speakable": { "@type": "SpeakableSpecification", "cssSelector": [".pv-hero__sub", ".pv-ssub", ".pv-step p", ".pv-faq-a"] },
  "about": {
    "@type": "Service",
    "name": "Property Verification Service Greater Noida",
    "description": "Independent physical verification of property documents in Greater Noida including GNIDA builder dues, OC status, farmer land disputes, abadi plots, and RERA compliance. PDF report in 48 hours at ₹5,000.",
    "provider": { "@id": "https://dsdproperties.in/#organization" }
  }
}
</script>
@endpush

@section('content')

<style>
:root {
    --gn-dark:   #021a0e;
    --gn-mid:    #076b35;
    --gn-accent: #10b981;
    --gn-orange: #f59e0b;
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
@keyframes pvPulse  { 0%,100%{box-shadow:0 0 0 2px rgba(16,185,129,.3)} 50%{box-shadow:0 0 0 6px rgba(16,185,129,.08)} }

.pv-rv { opacity:0; transform:translateY(22px); transition: opacity .6s ease, transform .6s ease; transition-delay: var(--rd, 0s); }
.pv-rv.visible { opacity:1; transform:none; }

.pv-slabel { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gn-accent); text-align: center; margin-bottom: 10px; display: block; }
.pv-stitle { font-size: clamp(1.6rem, 3.2vw, 2.4rem); font-weight: 800; color: var(--pv-t1); text-align: center; line-height: 1.15; margin-bottom: 12px; }
.pv-ssub   { font-size: .92rem; color: var(--pv-t2); text-align: center; max-width: 680px; margin: 0 auto 48px; line-height: 1.75; }

.pv-btn { display: inline-flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; border-radius: 11px; text-decoration: none; cursor: pointer; transition: all .22s; border: none; padding: 13px 26px; font-size: .88rem; }
.pv-btn--primary { background: linear-gradient(135deg, var(--gn-mid), #05924a); color:#fff; box-shadow: 0 5px 20px rgba(7,107,53,.3); }
.pv-btn--primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(7,107,53,.42); color:#fff; }
.pv-btn--ghost { background: rgba(255,255,255,.1); color: rgba(255,255,255,.9); border: 1px solid rgba(255,255,255,.22); }
.pv-btn--ghost:hover { background: rgba(255,255,255,.18); color:#fff; }
.pv-btn--whatsapp { background: #25D366; color:#fff; box-shadow: 0 5px 20px rgba(37,211,102,.3); }
.pv-btn--whatsapp:hover { background:#1ebe5d; color:#fff; transform: translateY(-2px); }

/* Greater Noida hero — deep emerald green (planned green city) */
.pv-hero { position: relative; overflow: hidden; min-height: 88vh; background: linear-gradient(135deg, #021a0e 0%, #043d1f 45%, #076b35 100%); display: flex; align-items: center; }
.pv-hero__grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(16,185,129,.05) 1px, transparent 1px), linear-gradient(90deg, rgba(16,185,129,.05) 1px, transparent 1px); background-size: 50px 50px; }
.pv-hero__orb { position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none; }
.pv-hero__orb--a { width: 520px; height: 520px; background: rgba(16,185,129,.18); top: -140px; right: -100px; animation: pv-float 9s ease-in-out infinite; }
.pv-hero__orb--b { width: 380px; height: 380px; background: rgba(245,158,11,.1); bottom: -80px; left: -60px; animation: pv-float 11s ease-in-out infinite 3s; }
.pv-hero__body { position: relative; z-index: 2; padding-top: 60px; padding-bottom: 70px; display:grid; grid-template-columns: 1.15fr 1fr; gap: 50px; align-items: center; }
@media(max-width:900px){ .pv-hero__body { grid-template-columns: 1fr; gap: 30px; padding-top: 80px; } }

.pv-hero__left { animation: pv-up .6s ease both; }
.pv-hero__badge { display: inline-flex; align-items: center; gap: 9px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); border-radius: 99px; padding: 7px 16px; margin-bottom: 22px; font-size: 11px; font-weight: 500; color: rgba(255,255,255,.85); backdrop-filter: blur(8px); }
.pv-pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: #4ade80; flex-shrink: 0; animation: pvPulse 2.5s infinite; display: inline-block; }
.pv-hero__h1 { font-size: clamp(1.85rem, 3.6vw, 2.7rem); font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 18px; letter-spacing: -.4px; }
.pv-hero__h1 em { font-style: normal; color: #6ee7b7; }
.pv-hero__sub { font-size: .95rem; color: rgba(255,255,255,.82); line-height: 1.78; margin-bottom: 26px; max-width: 580px; }
.pv-hero__cta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 26px; }
.pv-hero__pills { display: flex; flex-wrap: wrap; gap: 8px; }
.pv-pill { display: flex; align-items: center; gap: 6px; padding: 5px 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); border-radius: 8px; font-size: 11px; color: rgba(255,255,255,.75); }

.pv-hero__card { background: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 28px 72px rgba(0,0,0,.35); animation: pv-up .7s ease .15s both; }
.pv-hero__card-tag { display:inline-block; font-size:10px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color: var(--gn-mid); background:rgba(7,107,53,.08); padding:4px 9px; border-radius:5px; margin-bottom: 12px; }
.pv-hero__card-title { font-size: 1.2rem; font-weight: 800; color: var(--pv-t1); margin-bottom: 6px; line-height: 1.3; }
.pv-hero__card-sub { font-size: .82rem; color: var(--pv-t2); margin-bottom: 18px; line-height: 1.6; }
.pv-hero__card-price { display: flex; align-items: baseline; gap: 8px; margin-bottom: 18px; padding: 14px 16px; background: var(--pv-bg2); border-radius: 10px; border-left: 4px solid var(--gn-mid); }
.pv-hero__card-price-amt { font-size: 1.8rem; font-weight: 900; color: var(--gn-dark); line-height: 1; }
.pv-hero__card-price-lbl { font-size: .78rem; color: var(--pv-t2); }
.pv-hero__card-list { list-style:none; padding:0; margin: 0 0 18px; }
.pv-hero__card-list li { display: flex; align-items: flex-start; gap: 9px; padding: 6px 0; font-size: .82rem; color: var(--pv-t2); }
.pv-hero__card-list li::before { content: "✓"; color: var(--gn-accent); font-weight: 800; flex-shrink: 0; }
.pv-hero__card-btn { display: block; width: 100%; padding: 14px; background: #25D366; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: .92rem; cursor: pointer; font-family: 'Poppins', sans-serif; text-align: center; text-decoration: none; transition: transform .2s, box-shadow .2s; box-shadow: 0 5px 18px rgba(37,211,102,.3); }
.pv-hero__card-btn:hover { transform: translateY(-1px); color:#fff; text-decoration:none; }
.pv-hero__card-note { margin-top: 12px; font-size: .72rem; color: var(--pv-t3); text-align: center; line-height: 1.5; }
.pv-hero__wave { position: absolute; bottom: 0; left: 0; right: 0; line-height: 0; }
.pv-hero__wave svg { width: 100%; height: 56px; display: block; }

.pv-metrics { background: var(--pv-card); border-bottom: 1px solid var(--pv-border); padding: 26px 0; }
.pv-metrics__grid { display:grid; grid-template-columns: repeat(4, 1fr); gap: 16px; text-align: center; }
@media(max-width:680px){ .pv-metrics__grid { grid-template-columns: repeat(2, 1fr); gap: 22px; } }
.pv-metric__num { font-size: 1.6rem; font-weight: 900; color: var(--gn-dark); line-height: 1; margin-bottom: 6px; }
.pv-metric__num span { color: var(--gn-mid); }
.pv-metric__label { font-size: .72rem; color: var(--pv-t2); text-transform: uppercase; letter-spacing: 1.2px; font-weight: 600; }

/* GN Extension alert */
.pv-gnw-banner { background: linear-gradient(135deg, #78350f, #92400e); border-radius: 14px; padding: 24px 28px; max-width: 920px; margin: 0 auto 36px; display: flex; gap: 16px; align-items: flex-start; border: 1px solid rgba(245,158,11,.25); }
.pv-gnw-icon { font-size: 1.8rem; flex-shrink: 0; }
.pv-gnw-title { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
.pv-gnw-text { font-size: .84rem; color: rgba(255,255,255,.85); line-height: 1.65; }

.pv-gn-box { background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1.5px solid rgba(16,185,129,.2); border-radius: 16px; padding: 28px 30px; max-width: 920px; margin: 0 auto 40px; }
.pv-gn-box h3 { font-size: 1.05rem; font-weight: 800; color: var(--gn-dark); margin-bottom: 14px; }
.pv-gn-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px; }
.pv-gn-item { display: flex; gap: 10px; align-items: flex-start; background: #fff; border-radius: 10px; padding: 13px 14px; border: 1px solid rgba(16,185,129,.15); }
.pv-gn-item-icon { font-size: 1.2rem; flex-shrink: 0; }
.pv-gn-item-title { font-size: .82rem; font-weight: 700; color: var(--gn-dark); margin-bottom: 3px; }
.pv-gn-item-text  { font-size: .74rem; color: var(--pv-t2); line-height: 1.55; }

/* Zone table */
.pv-zone-table { max-width: 860px; margin: 0 auto 40px; border-radius: 14px; overflow: hidden; border: 1px solid var(--pv-border); box-shadow: 0 4px 16px rgba(0,0,0,.06); }
.pv-zone-head { display: grid; grid-template-columns: 1fr 1.1fr 1fr; background: linear-gradient(135deg, var(--gn-dark), #054d28); color:#fff; }
.pv-zone-head > div { padding: 14px 16px; font-size: .8rem; font-weight: 700; border-right: 1px solid rgba(255,255,255,.1); }
.pv-zone-head > div:last-child { border-right: none; }
.pv-zone-row { display: grid; grid-template-columns: 1fr 1.1fr 1fr; border-top: 1px solid var(--pv-border); }
.pv-zone-row > div { padding: 12px 16px; font-size: .8rem; color: var(--pv-t2); border-right: 1px solid var(--pv-border); line-height: 1.5; }
.pv-zone-row > div:last-child { border-right: none; }
.pv-zone-row > div:first-child { font-weight: 700; color: var(--pv-t1); background: var(--pv-bg2); }
.pv-zone-tag { display:inline-block; font-size:9px; font-weight:700; padding:2px 6px; border-radius:4px; margin-left:4px; }
.pv-zone-tag--warn { background:#fef3c7; color:#92400e; }
.pv-zone-tag--ok   { background:#d1fae5; color:#065f46; }
@media(max-width:600px){ .pv-zone-head, .pv-zone-row { grid-template-columns: 1fr; } .pv-zone-head > div, .pv-zone-row > div { border-right: none; border-bottom: 1px solid rgba(255,255,255,.1); } .pv-zone-row > div { border-bottom: 1px solid var(--pv-border); } }

.pv-diy-table { max-width: 920px; margin: 0 auto; background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 16px; overflow: hidden; box-shadow: 0 8px 32px rgba(2,26,14,.06); }
.pv-diy-head { display: grid; grid-template-columns: 1.1fr 1fr 1fr; background: linear-gradient(135deg, var(--gn-dark), #054d28); color:#fff; }
.pv-diy-head > div { padding: 16px 18px; font-size: .82rem; font-weight: 700; border-right: 1px solid rgba(255,255,255,.1); }
.pv-diy-head > div:last-child { border-right: none; }
.pv-diy-head > div:nth-child(3) { background: rgba(16,185,129,.18); }
.pv-diy-row { display: grid; grid-template-columns: 1.1fr 1fr 1fr; border-top: 1px solid var(--pv-border); }
.pv-diy-row > div { padding: 14px 18px; font-size: .82rem; color: var(--pv-t2); border-right: 1px solid var(--pv-border); line-height: 1.6; }
.pv-diy-row > div:last-child { border-right: none; }
.pv-diy-row > div:first-child { font-weight: 600; color: var(--pv-t1); background: var(--pv-bg2); }
.pv-diy-row > div:nth-child(3) { background: rgba(16,185,129,.04); }
.pv-diy-good { color: #047857 !important; font-weight: 600; }
.pv-diy-bad  { color: #b91c1c !important; }
@media(max-width:680px){
    .pv-diy-head, .pv-diy-row { grid-template-columns: 1fr; }
    .pv-diy-head > div, .pv-diy-row > div { border-right: none; border-bottom: 1px solid rgba(255,255,255,.1); }
    .pv-diy-row > div { border-bottom: 1px solid var(--pv-border); }
    .pv-diy-head > div:nth-child(3), .pv-diy-row > div:nth-child(3) { border-top: 2px solid var(--gn-accent); }
}

.pv-check-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; max-width: 920px; margin: 0 auto; }
@media(max-width:680px){ .pv-check-grid { grid-template-columns: 1fr; } }
.pv-check-card { background: var(--pv-card); border: 1.5px solid var(--pv-border); border-radius: 14px; padding: 22px; display: flex; gap: 16px; align-items: flex-start; transition: transform .25s, box-shadow .25s, border-color .25s; }
.pv-check-card:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(16,185,129,.1); border-color: rgba(16,185,129,.35); }
.pv-check-card__icon { width: 44px; height: 44px; flex-shrink: 0; background: linear-gradient(135deg, var(--gn-mid), #054d28); color:#fff; border-radius: 11px; display:flex; align-items:center; justify-content:center; font-size: 1.3rem; }
.pv-check-card__title { font-size: .92rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 5px; }
.pv-check-card__text { font-size: .82rem; color: var(--pv-t2); line-height: 1.65; margin: 0 0 8px; }
.pv-check-card__where { font-size: .72rem; color: var(--gn-mid); font-weight: 600; }
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
.pv-step__num { width: 48px; height: 48px; flex-shrink: 0; background: linear-gradient(135deg, var(--gn-dark), #054d28); color:#fff; border-radius: 11px; display:flex; align-items:center; justify-content:center; font-size: 1.25rem; font-weight: 800; }
.pv-step h3 { font-size: .9rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 5px; }
.pv-step p  { font-size: .8rem; color: var(--pv-t2); line-height: 1.6; margin: 0; }

.pv-report { max-width: 880px; margin: 0 auto; background: var(--pv-card); border: 1.5px solid var(--pv-border); border-radius: 18px; overflow: hidden; box-shadow: 0 12px 40px rgba(2,26,14,.08); }
.pv-report__header { background: linear-gradient(135deg, var(--gn-dark), #054d28); color:#fff; padding: 24px 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; }
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
.pv-price-card:hover { transform: translateY(-6px); box-shadow: 0 18px 44px rgba(0,0,0,.1); border-color: var(--gn-accent); }
.pv-price-card--featured { background: linear-gradient(135deg, var(--gn-mid), #054d28); border-color: var(--gn-mid); box-shadow: 0 12px 36px rgba(7,107,53,.28); }
.pv-price-badge { position: absolute; top: -13px; left: 50%; transform: translateX(-50%); background: #fff; color: var(--gn-mid); padding: 4px 16px; border-radius: 99px; font-weight: 800; font-size: .74rem; box-shadow: 0 4px 12px rgba(0,0,0,.15); border: 2px solid var(--gn-mid); white-space: nowrap; }
.pv-price-tag { display: inline-block; padding: 5px 13px; border-radius: 99px; font-weight: 700; font-size: .72rem; margin-bottom: 12px; background: #f3f4f6; color: #374151; letter-spacing: 1px; }
.pv-price-card--featured .pv-price-tag { background: rgba(255,255,255,.2); color:#fff; }
.pv-price-name { font-size: 1.15rem; font-weight: 700; color: var(--pv-t1); margin-bottom: 10px; }
.pv-price-card--featured .pv-price-name { color:#fff; }
.pv-price-amount { font-size: 2.3rem; font-weight: 900; color: var(--gn-dark); margin: 12px 0 4px; letter-spacing: -.03em; }
.pv-price-card--featured .pv-price-amount { color:#fff; }
.pv-price-desc { font-size: .78rem; color: var(--pv-t3); margin-bottom: 20px; }
.pv-price-card--featured .pv-price-desc { color: rgba(255,255,255,.85); }
.pv-price-list { list-style: none; padding: 0; margin: 0 0 22px; text-align: left; }
.pv-price-list li { padding: 8px 0; display: flex; align-items: flex-start; gap: 9px; font-size: .8rem; color: var(--pv-t2); border-bottom: 1px solid var(--pv-border); }
.pv-price-list li:last-child { border-bottom: none; }
.pv-price-card--featured .pv-price-list li { color: rgba(255,255,255,.92); border-bottom-color: rgba(255,255,255,.15); }
.pv-price-check { color: var(--gn-accent); flex-shrink: 0; margin-top: 1px; font-size: .82rem; }
.pv-price-card--featured .pv-price-check { color:#a7f3d0; }
.pv-price-btn { display: block; width: 100%; padding: 12px; border-radius: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .84rem; text-decoration: none; text-align: center; border: none; cursor: pointer; transition: all .22s; background: linear-gradient(135deg, var(--gn-mid), #05924a); color:#fff; box-shadow: 0 4px 14px rgba(7,107,53,.28); }
.pv-price-btn:hover { transform: translateY(-2px); color:#fff; }
.pv-price-btn--white { background:#fff; color: var(--gn-mid); }
.pv-price-btn--white:hover { background:#f0fdf4; color: var(--gn-mid); }

.pv-area-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; max-width: 900px; margin: 0 auto; }
.pv-area-pill { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 10px; padding: 11px 14px; font-size: .8rem; font-weight: 600; color: var(--pv-t1); text-align: center; transition: all .2s; }
.pv-area-pill:hover { border-color: var(--gn-accent); color: var(--gn-mid); background: rgba(16,185,129,.04); }

.pv-cta { background: linear-gradient(135deg, #021a0e 0%, #043d1f 50%, #076b35 100%); padding: 70px 0; position: relative; overflow: hidden; }
.pv-cta__orb { position: absolute; border-radius: 50%; filter: blur(80px); width: 420px; height: 420px; background: rgba(16,185,129,.15); top: -120px; right: -100px; animation: pv-float 10s ease-in-out infinite; }
.pv-cta__inner { position: relative; z-index: 2; text-align: center; }
.pv-cta h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color:#fff; margin-bottom: 12px; }
.pv-cta p  { font-size: .92rem; color: rgba(255,255,255,.78); max-width: 580px; margin: 0 auto 30px; line-height: 1.7; }
.pv-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

.pv-faq-item { background: var(--pv-card); border: 1px solid var(--pv-border); border-radius: 12px; overflow: hidden; }
.pv-faq-q { width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-family: 'Poppins', sans-serif; font-size: .88rem; font-weight: 600; color: var(--pv-t1); cursor: pointer; text-align: left; gap: 12px; transition: background .2s; }
.pv-faq-q:hover { background: var(--pv-bg2); }
.pv-faq-q i { color: var(--gn-accent); flex-shrink: 0; transition: transform .3s; font-size: .78rem; }
.pv-faq-q.open i { transform: rotate(180deg); }
.pv-faq-a { padding: 0 20px; max-height: 0; overflow: hidden; font-size: .83rem; color: var(--pv-t2); line-height: 1.75; transition: max-height .35s ease, padding .35s ease; }
.pv-faq-a.open { max-height: 800px; padding: 0 20px 16px; }

.pv-mobile-cta { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: var(--pv-card); border-top: 3px solid var(--gn-mid); padding: 10px 14px; z-index: 90; box-shadow: 0 -4px 20px rgba(0,0,0,.12); gap: 8px; }
.pv-mobile-cta.show { display: flex; }
.pv-mobile-cta a { flex: 1; text-align: center; padding: 11px 8px; border-radius: 9px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .8rem; text-decoration: none; }
.pv-mobile-cta a.whatsapp { background: #25D366; color:#fff; }
.pv-mobile-cta a.book { background: linear-gradient(135deg, var(--gn-mid), #05924a); color:#fff; }

@media(max-width:860px){ .pv-section { padding: 56px 0; } .pv-cta { padding: 56px 0; } }
@media(max-width:480px){ .pv-hero__cta { flex-direction: column; } .pv-risk-banner { flex-direction: column; gap: 10px; } .pv-gnw-banner { flex-direction: column; gap: 10px; } }
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
                <li style="color:#fff; font-weight:500;">Property Verification Greater Noida</li>
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
                Greater Noida & GN West — Independent Property Verifier
            </div>

            <h1 class="pv-hero__h1">
                Professional Property<br>
                Verification <em>Service</em> in<br>
                Greater Noida — ₹5,000.
            </h1>

            <p class="pv-hero__sub">
                Greater Noida West (Noida Extension) has more stuck flats per square kilometre than almost anywhere in India. GNIDA builder dues, missing OC, farmer land disputes and village abadi plots trap buyers every year. Don't pay ₹70 lakhs without spending ₹5,000 on independent verification. <strong style="color:#6ee7b7;">PDF report in 48 hours.</strong>
            </p>

            <div class="pv-hero__cta">
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20you%20for%20property%20verification%20in%20Greater%20Noida.%20Property%20address%3A" class="pv-btn pv-btn--whatsapp">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Hire a Verifier — WhatsApp Us
                </a>
                <a href="#pricing" class="pv-btn pv-btn--ghost">See Pricing →</a>
            </div>

            <div class="pv-hero__pills">
                <div class="pv-pill"><i class="fas fa-clock"></i> 48-Hour PDF Report</div>
                <div class="pv-pill"><i class="fas fa-building"></i> GNIDA Dues Checked</div>
                <div class="pv-pill"><i class="fas fa-globe"></i> NRI-Friendly</div>
            </div>
        </div>

        <div class="pv-hero__card">
            <div class="pv-hero__card-tag">FLAT / PLOT — GREATER NOIDA & GN WEST</div>
            <div class="pv-hero__card-title">Hire a Greater Noida Property Verifier</div>
            <div class="pv-hero__card-sub">Trained verifier checks GNIDA dues, OC status, RERA complaint history, farmer land disputes, abadi plot status, Sub-Registrar encumbrance and court orders. PDF in 48 hours.</div>

            <div class="pv-hero__card-price">
                <span class="pv-hero__card-price-amt">₹5,000</span>
                <span class="pv-hero__card-price-lbl">all-inclusive · no hidden fees</span>
            </div>

            <ul class="pv-hero__card-list">
                <li>GNIDA builder dues checked at Authority office</li>
                <li>Occupation Certificate (OC) status confirmed</li>
                <li>RERA registration & complaint history</li>
                <li>Farmer land dispute & abadi plot check</li>
                <li>Final verdict: Safe to Buy or Walk Away</li>
            </ul>

            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20book%20the%20%E2%82%B95%2C000%20property%20verification%20in%20Greater%20Noida.%20Property%20address%3A" class="pv-hero__card-btn">Book ₹5,000 Verification on WhatsApp</a>
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
            <div><div class="pv-metric__num">50<span>K+</span></div><div class="pv-metric__label">Stuck Flats in GN West</div></div>
            <div><div class="pv-metric__num">30 yr</div><div class="pv-metric__label">Title Chain Traced</div></div>
            <div><div class="pv-metric__num">48 hr</div><div class="pv-metric__label">PDF Report Delivery</div></div>
            <div><div class="pv-metric__num">₹5K</div><div class="pv-metric__label">vs ₹70L At Risk</div></div>
        </div>
    </div>
</section>

{{-- ═══════════ GN-SPECIFIC RISKS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Greater Noida — Specific</span>
        <h2 class="pv-stitle pv-rv">Why Greater Noida Property Verification Is a Distinct Category</h2>
        <p class="pv-ssub pv-rv">Greater Noida's risks centre on one thing: the GNIDA dues crisis and its downstream effects on OC and registry. Unlike Lucknow or Varanasi where title fraud is the primary risk, here the danger is buying a completed flat that can never be legally registered — because your builder owes hundreds of crores to the Authority.</p>

        <div class="pv-gnw-banner pv-rv">
            <div class="pv-gnw-icon">🏗️</div>
            <div>
                <div class="pv-gnw-title">Greater Noida West: The Most Concentrated Stuck-Flat Problem in North India</div>
                <div class="pv-gnw-text">After the 2011 Allahabad HC order and Supreme Court stay halted construction across Greater Noida West, thousands of flats were frozen mid-build. Many projects resumed — but builder dues to GNIDA accumulated. Today, resale buyers in projects with unpaid dues cannot register their flats. <strong style="color:#fcd34d;">RERA registration does not reveal dues status. Only a physical GNIDA office check does.</strong></div>
            </div>
        </div>

        <div class="pv-gn-box pv-rv">
            <h3>🌆 Greater Noida–Specific Risks We Check Explicitly</h3>
            <div class="pv-gn-grid">
                <div class="pv-gn-item">
                    <div class="pv-gn-item-icon">🏦</div>
                    <div>
                        <div class="pv-gn-item-title">GNIDA Builder Dues — The Core Risk</div>
                        <div class="pv-gn-item-text">Unpaid land premium and dues to GNIDA block individual flat registry indefinitely. We physically visit the GNIDA office in Greater Noida and check the specific project's dues ledger — the single most critical check for any GN West flat.</div>
                    </div>
                </div>
                <div class="pv-gn-item">
                    <div class="pv-gn-item-icon">🔑</div>
                    <div>
                        <div class="pv-gn-item-title">Occupation Certificate (OC) per Tower</div>
                        <div class="pv-gn-item-text">Many completed buildings in Greater Noida lack an OC because builders made unauthorised deviations. OC is required for legal registry and bank loans. We confirm OC status per tower and phase at the GNIDA records office — not from the builder's word.</div>
                    </div>
                </div>
                <div class="pv-gn-item">
                    <div class="pv-gn-item-icon">🧑‍🌾</div>
                    <div>
                        <div class="pv-gn-item-title">Farmer Land Acquisition Dispute</div>
                        <div class="pv-gn-item-text">The 2011 farmer protests and subsequent court orders arose from disputed acquisition of agricultural land. Some sectors still have unresolved Allahabad HC or SC orders on acquisition status. We check the specific land parcel at the Collector office and courts.</div>
                    </div>
                </div>
                <div class="pv-gn-item">
                    <div class="pv-gn-item-icon">🏘️</div>
                    <div>
                        <div class="pv-gn-item-title">Village Abadi / Gram Sabha Land</div>
                        <div class="pv-gn-item-text">Builder floors and independent houses within original village boundaries (abadi land) are outside GNIDA's authority. They cannot be registered through the Authority process, and most banks refuse home loans. Many buyers are unaware of this distinction until after purchase.</div>
                    </div>
                </div>
                <div class="pv-gn-item">
                    <div class="pv-gn-item-icon">🏛️</div>
                    <div>
                        <div class="pv-gn-item-title">NCLT / Insolvency Proceedings</div>
                        <div class="pv-gn-item-text">Several Greater Noida builders are under NCLT insolvency or resolution process. Buying a resale flat in a project under insolvency means your rights as a homebuyer may need to be asserted through the NCLT — a multi-year process. We check NCLT status for the specific builder.</div>
                    </div>
                </div>
                <div class="pv-gn-item">
                    <div class="pv-gn-item-icon">📐</div>
                    <div>
                        <div class="pv-gn-item-title">Sanctioned Plan vs. Actual Construction</div>
                        <div class="pv-gn-item-text">Deviations from GNIDA's sanctioned building plan are common — extra floors, changed unit configurations, altered common areas. These deviations prevent OC issuance and can lead to demolition orders. The premium site visit package documents construction compliance.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Zone table --}}
        <span class="pv-slabel pv-rv" style="margin-top:8px;">Zone Guide</span>
        <h3 class="pv-stitle pv-rv" style="font-size:1.4rem; margin-bottom:8px;">Risk Profile by Zone in Greater Noida</h3>
        <p class="pv-ssub pv-rv" style="margin-bottom:24px;">Not all Greater Noida zones carry equal risk. Here is a quick guide to what we prioritise in each zone.</p>

        <div class="pv-zone-table pv-rv">
            <div class="pv-zone-head">
                <div>Zone</div>
                <div>Primary Risk</div>
                <div>Top Checks</div>
            </div>
            <div class="pv-zone-row">
                <div>GN West / Noida Extension <span class="pv-zone-tag pv-zone-tag--warn">High Risk</span></div>
                <div>GNIDA dues, OC missing, farmer land disputes from 2011 SC stay</div>
                <div>GNIDA dues ledger, OC per tower, NCLT status, acquisition status</div>
            </div>
            <div class="pv-zone-row">
                <div>Alpha, Beta, Gamma Sectors <span class="pv-zone-tag pv-zone-tag--ok">Moderate</span></div>
                <div>Older resale flats — hidden encumbrances, builder floor title issues</div>
                <div>Sub-Registrar encumbrance, 30yr title chain, OC confirmation</div>
            </div>
            <div class="pv-zone-row">
                <div>Omicron / Zeta / Ecotech <span class="pv-zone-tag pv-zone-tag--warn">Watch</span></div>
                <div>Mixed industrial-residential zoning, conversion dues, builder delays</div>
                <div>GNIDA zoning confirmation, conversion dues, RERA complaint status</div>
            </div>
            <div class="pv-zone-row">
                <div>Knowledge Park / Institutional <span class="pv-zone-tag pv-zone-tag--ok">Lower</span></div>
                <div>Leasehold transfer conditions, institutional to residential conversion</div>
                <div>GNIDA lease status, transfer conditions, encumbrance</div>
            </div>
            <div class="pv-zone-row">
                <div>Village Abadi Pockets <span class="pv-zone-tag pv-zone-tag--warn">High Risk</span></div>
                <div>No GNIDA registry path, gram sabha land, bank loans unavailable</div>
                <div>Abadi boundary confirmation, gram sabha records, khasra</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ DIY VS HIRE ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Honest Comparison</span>
        <h2 class="pv-stitle pv-rv">What You Can Check vs. What We Check in Greater Noida</h2>
        <p class="pv-ssub pv-rv">Most of the information that matters for Greater Noida property — GNIDA dues, OC status, actual RERA complaint depth — is not publicly accessible online. It requires physical presence at the GNIDA office.</p>

        <div class="pv-diy-table pv-rv">
            <div class="pv-diy-head">
                <div>What You Check</div>
                <div>Doing It Yourself</div>
                <div>Hiring DSD Properties</div>
            </div>
            <div class="pv-diy-row">
                <div>GNIDA builder dues</div>
                <div class="pv-diy-bad">Cannot check online — not publicly listed</div>
                <div class="pv-diy-good">Physical check at GNIDA office, Greater Noida</div>
            </div>
            <div class="pv-diy-row">
                <div>Occupation Certificate (OC)</div>
                <div class="pv-diy-bad">Builder claims OC received — cannot verify</div>
                <div class="pv-diy-good">OC status confirmed per tower at GNIDA records</div>
            </div>
            <div class="pv-diy-row">
                <div>RERA complaint depth</div>
                <div class="pv-diy-bad">RERA shows registration, not full order history</div>
                <div class="pv-diy-good">Full UP-RERA complaint & order history checked</div>
            </div>
            <div class="pv-diy-row">
                <div>Farmer land / 2011 acquisition status</div>
                <div class="pv-diy-bad">Not visible on any portal</div>
                <div class="pv-diy-good">Collector + HC / SC records checked</div>
            </div>
            <div class="pv-diy-row">
                <div>Village abadi / gram sabha land</div>
                <div class="pv-diy-bad">Seller will not volunteer this</div>
                <div class="pv-diy-good">Abadi boundary checked against GNIDA master plan</div>
            </div>
            <div class="pv-diy-row">
                <div>NCLT / insolvency status</div>
                <div class="pv-diy-bad">Difficult to track builder-level NCLT proceedings</div>
                <div class="pv-diy-good">NCLT case search for the specific builder</div>
            </div>
            <div class="pv-diy-row">
                <div>Hidden bank mortgage on resale flat</div>
                <div class="pv-diy-bad">Seller may not disclose</div>
                <div class="pv-diy-good">Sub-Registrar encumbrance extracted</div>
            </div>
        </div>

        <div style="text-align:center; margin-top:28px;">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20to%20hire%20a%20property%20verifier%20in%20Greater%20Noida" class="pv-btn pv-btn--primary">Hire Us — Book Verification →</a>
        </div>
    </div>
</section>

{{-- ═══════════ WHAT WE CHECK ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What's Included</span>
        <h2 class="pv-stitle pv-rv">What We Check in Greater Noida — For You</h2>
        <p class="pv-ssub pv-rv">Every Greater Noida verification is anchored on GNIDA-level checks unavailable online, plus the full standard title, court and encumbrance review.</p>

        <div class="pv-check-grid">
            <div class="pv-check-card pv-rv">
                <div class="pv-check-card__icon">🏦</div>
                <div>
                    <div class="pv-check-card__title">GNIDA Builder Dues — Physical Office Check</div>
                    <p class="pv-check-card__text">The single most important check for any Greater Noida or GN West flat. We physically visit the GNIDA office (Knowledge Park III, Greater Noida) and check the builder project's dues ledger — land premium, interest, penalty charges. NIL dues is required before any flat in the project can be registered. This check cannot be done online.</p>
                    <div class="pv-check-card__where">GNIDA Office, Greater Noida (Knowledge Park III)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">🔑</div>
                <div>
                    <div class="pv-check-card__title">Occupation Certificate per Tower & Phase</div>
                    <p class="pv-check-card__text">We confirm OC status at GNIDA records — which towers have received OC, which haven't, and whether the builder has even applied. Bought a flat in Tower A of a project where only Tower C has OC? We catch this. An OC-less flat cannot be registered and most banks won't finance it.</p>
                    <div class="pv-check-card__where">GNIDA Building Department Records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.12s">
                <div class="pv-check-card__icon">📋</div>
                <div>
                    <div class="pv-check-card__title">RERA Registration & Full Complaint History</div>
                    <p class="pv-check-card__text">Beyond confirming RERA registration, we extract the project's full complaint and order history from UP-RERA — penalty orders, refund directions, repeated delays flagged by multiple buyers. A project with 50 unresolved RERA complaints is a different risk than one with none, even if both are "RERA registered."</p>
                    <div class="pv-check-card__where">UP-RERA portal + GNIDA records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.18s">
                <div class="pv-check-card__icon">📄</div>
                <div>
                    <div class="pv-check-card__title">Sub-Registrar Title Chain & Encumbrance</div>
                    <p class="pv-check-card__text">For resale flats, we trace the full title chain at the Sub-Registrar (Dadri) and extract a 30-year encumbrance certificate to expose any bank mortgages, registered charges or legal claims. A clean encumbrance certificate is mandatory before payment. We also confirm the seller has a valid registered prior deed.</p>
                    <div class="pv-check-card__where">Sub-Registrar, Dadri (Gautam Buddha Nagar)</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.06s">
                <div class="pv-check-card__icon">🧑‍🌾</div>
                <div>
                    <div class="pv-check-card__title">Farmer Land & 2011 Acquisition Status</div>
                    <p class="pv-check-card__text">For GN West projects especially, we check whether the underlying land acquisition was subject to the 2011 HC / SC orders, and whether the specific survey number is fully cleared. We check the Collector's records and relevant HC / SC case status to confirm the acquisition is clean and not under any revival of farmer claims.</p>
                    <div class="pv-check-card__where">Collector Office + Allahabad HC / SC records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.10s">
                <div class="pv-check-card__icon">🏘️</div>
                <div>
                    <div class="pv-check-card__title">Village Abadi & Gram Sabha Land Check</div>
                    <p class="pv-check-card__text">We confirm whether the property falls within the GNIDA-allotted area or within a village abadi boundary. Abadi land is exempt from GNIDA acquisition and follows gram sabha / revenue department rules — a completely different and more restricted title regime. This distinction is invisible without checking the GNIDA master plan boundary.</p>
                    <div class="pv-check-card__where">GNIDA master plan + Revenue Department records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.16s">
                <div class="pv-check-card__icon">🏛️</div>
                <div>
                    <div class="pv-check-card__title">NCLT / Insolvency & Court Order Search</div>
                    <p class="pv-check-card__text">We check whether the builder is under NCLT insolvency resolution, and whether any SC, HC or District Court orders affect the project or builder. Projects where an Interim Resolution Professional (IRP) has been appointed require buyers to register their claims through NCLT — not with the builder.</p>
                    <div class="pv-check-card__where">NCLT, Allahabad HC, District Court records</div>
                </div>
            </div>
            <div class="pv-check-card pv-rv" style="--rd:.22s">
                <div class="pv-check-card__icon">🗺️</div>
                <div>
                    <div class="pv-check-card__title">Khatauni & Khasra (Independent Plots)</div>
                    <p class="pv-check-card__text">For independent plots and builder floors in Greater Noida's village pockets or areas outside GNIDA-allotted zones, we verify the revenue record — Khatauni, Khasra number, Dakhil Kharij at the relevant Tehsil. This establishes agricultural or abadi land status and mutation history.</p>
                    <div class="pv-check-card__where">Tehsil Dadri / Sadar / Bisrakh</div>
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
        <h2 class="pv-stitle pv-rv">Six Ways Buyers Lose Money in Greater Noida</h2>
        <p class="pv-ssub pv-rv">All six scenarios are preventable with a verification done before payment. Not one of them is visible on RERA or any online portal.</p>

        <div class="pv-risk-grid">
            <div class="pv-risk-card pv-rv"><div class="pv-risk-icon">🏦</div><div><div class="pv-risk-title">GNIDA Dues Block Registry Indefinitely</div><p class="pv-risk-text">You pay ₹65 lakhs for a resale flat. Builder owes ₹80 crore to GNIDA. No flat in the project can be registered. You own a flat that exists physically but has no legal title you can transfer or mortgage. Thousands of buyers are in this situation today.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.06s"><div class="pv-risk-icon">🔑</div><div><div class="pv-risk-title">No OC — No Registry, No Bank Loan</div><p class="pv-risk-text">Builder made three extra floors without GNIDA approval. GNIDA refuses to issue OC. The entire building — including your flat — cannot be registered. The bank that pre-approved your home loan withdraws the sanction. You're stuck with an unregistered flat.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.12s"><div class="pv-risk-icon">🏛️</div><div><div class="pv-risk-title">Builder Under NCLT — Money Frozen</div><p class="pv-risk-text">You buy resale in a project whose original builder is under NCLT insolvency. The IRP is managing the project. Your payment goes to the seller — but the project's completion depends on the NCLT resolution plan timeline. You wait 5 years for possession.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.18s"><div class="pv-risk-icon">🧑‍🌾</div><div><div class="pv-risk-title">Farmer Dispute Invalidates Title</div><p class="pv-risk-text">HC rules in a farmer's favour on a GN West sector. Acquisition is declared invalid for specific survey numbers. Your builder's lease on that land is challenged. Legal battle stretches years — you cannot sell, mortgage or freely occupy your flat while it continues.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.24s"><div class="pv-risk-icon">🏘️</div><div><div class="pv-risk-title">Abadi Land — No Registry Path Exists</div><p class="pv-risk-text">You buy a "builder floor" in what turns out to be a village abadi plot. No GNIDA registry process exists for it. No bank will give a loan. Your only exit is to sell to another buyer who also doesn't know — which is getting harder as awareness grows.</p></div></div>
            <div class="pv-risk-card pv-rv" style="--rd:.30s"><div class="pv-risk-icon">📄</div><div><div class="pv-risk-title">Hidden Bank Mortgage on Resale Flat</div><p class="pv-risk-text">Seller took a ₹40 lakh bank loan against the flat without disclosing it. Bank has first charge. You pay the seller ₹65 lakhs — bank attaches the property. You lose the flat and must recover ₹65 lakhs from the seller through civil court.</p></div></div>
        </div>

        <div class="pv-risk-banner pv-rv">
            <div class="pv-risk-banner-icon">❗</div>
            <div>
                <div class="pv-risk-banner-title">The 2011 SC Stay Was Resolved — But Its Effects Are Not</div>
                <div class="pv-risk-banner-text">The Supreme Court ultimately allowed most Greater Noida West construction to proceed, and many projects have delivered. But the dues accumulated during the stay period are still outstanding in numerous projects. The original crisis is over — the financial liability it created is not. Every resale purchase in GN West needs a GNIDA dues check as the first step.</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ PROCESS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Simple Process</span>
        <h2 class="pv-stitle pv-rv">How to Hire DSD for Greater Noida Property Verification</h2>
        <p class="pv-ssub pv-rv">From first WhatsApp to PDF report in 5 steps. Fully remote — you don't need to visit any office.</p>

        <div class="pv-steps">
            <div class="pv-step pv-rv"><div class="pv-step__num">1</div><div><h3>WhatsApp Free Preliminary Check</h3><p>Send the project name, tower number and builder name. We check RERA registration and GNIDA signals within 2 hours — free — and tell you honestly if a full verification is worth doing.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.06s"><div class="pv-step__num">2</div><div><h3>Share Available Documents</h3><p>Allotment letter, flat number, builder-buyer agreement, RERA number — whatever you have. The project name and sector is enough to begin the process.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.12s"><div class="pv-step__num">3</div><div><h3>Pay Verification Fee</h3><p>₹5,000 for residential flats and plots, ₹7,000 for commercial, ₹10,000 for premium with site visit. UPI or bank transfer. Invoice issued immediately.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.18s"><div class="pv-step__num">4</div><div><h3>We Verify at Source in Greater Noida</h3><p>Our team physically checks GNIDA dues, OC status, UP-RERA complaint history, farmer land and abadi status, Sub-Registrar encumbrance and NCLT / court orders — at source in Greater Noida, not via online portals alone.</p></div></div>
            <div class="pv-step pv-rv" style="--rd:.24s"><div class="pv-step__num">5</div><div><h3>Detailed PDF Report in 48 Hours</h3><p>Every check documented, all risks flagged, clear final verdict: <strong>"Safe to Buy"</strong> or <strong>"Do Not Proceed."</strong> Delivered in 48 hours.</p></div></div>
        </div>
    </div>
</section>

{{-- ═══════════ REPORT PREVIEW ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">What You Get</span>
        <h2 class="pv-stitle pv-rv">Inside the ₹5,000 PDF Verification Report</h2>
        <p class="pv-ssub pv-rv">A sample of what every Greater Noida buyer receives — clear, evidence-backed, and admissible if a dispute arises later.</p>

        <div class="pv-report pv-rv">
            <div class="pv-report__header">
                <div>
                    <h3 class="pv-report__title">Property Verification Report — Sample</h3>
                    <p class="pv-report__subtitle">Flat 804, Tower B, Sector 1 Greater Noida West · Verified 21 July 2026</p>
                </div>
                <span class="pv-report__verdict">✓ SAFE TO BUY</span>
            </div>
            <div class="pv-report__body">
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>GNIDA Builder Dues</strong>NIL outstanding dues confirmed at GNIDA office. Project cleared — registry not blocked on Authority account. Confirmed via GNIDA dues register reference number.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Occupation Certificate</strong>OC issued for Tower B on 8 September 2024. Reference confirmed at GNIDA Building Department. Tower A OC still pending — buyer is purchasing in Tower B only.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>RERA Complaint History</strong>Project RERA-registered. 4 resolved complaints — all possession delay, all closed. No penalty orders or refund directions issued.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Sub-Registrar Encumbrance</strong>No bank mortgage, charge or legal claim on this flat. Prior registered deed of seller confirmed at Sub-Registrar, Dadri.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Farmer Land / Acquisition Status</strong>Sector 1 GNW acquisition not under active farmer dispute. HC / SC records checked — no revival of acquisition challenge on this survey number.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Abadi Boundary Check</strong>Property falls within GNIDA allotted area — not in village abadi. GNIDA master plan boundary confirmed. Normal GNIDA registry process applicable.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>NCLT / Court Orders</strong>Builder not under NCLT insolvency. No active HC or District Court injunction on the project. SC cause list checked — no active matter.</div></div>
                <div class="pv-report__item"><span class="pv-report__item-check">✓</span><div class="pv-report__item-text"><strong>Title Chain (Resale)</strong>Clear: GNIDA → Builder → Previous Owner → You. 30-year chain unbroken. Previous owner's registered deed clean.</div></div>
            </div>
            <div class="pv-report__footer">PDF report includes evidence from GNIDA office, Sub-Registrar Dadri, UP-RERA, NCLT and Allahabad HC records · Delivered in 48 hours</div>
        </div>
    </div>
</section>

{{-- ═══════════ PRICING ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)" id="pricing">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Transparent Pricing</span>
        <h2 class="pv-stitle pv-rv">Property Verification Cost in Greater Noida & GN West</h2>
        <p class="pv-ssub pv-rv">Fixed fee. No per-document charges. No hidden costs. Invoice issued after payment.</p>

        <div class="pv-pricing-grid">
            <div class="pv-price-card pv-rv">
                <div class="pv-price-tag">RESIDENTIAL</div>
                <div class="pv-price-name">Standard</div>
                <div class="pv-price-amount">₹5,000</div>
                <div class="pv-price-desc">Flats, builder floors & residential plots</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> GNIDA builder dues check</li>
                    <li><span class="pv-price-check">✓</span> OC status per tower</li>
                    <li><span class="pv-price-check">✓</span> RERA complaint history</li>
                    <li><span class="pv-price-check">✓</span> Encumbrance certificate</li>
                    <li><span class="pv-price-check">✓</span> Farmer land / abadi check</li>
                    <li><span class="pv-price-check">✓</span> NCLT / court order search</li>
                    <li><span class="pv-price-check">✓</span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B95%2C000%20Standard%20property%20verification%20in%20Greater%20Noida.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>

            <div class="pv-price-card pv-price-card--featured pv-rv" style="--rd:.08s">
                <div class="pv-price-badge">⭐ MOST POPULAR</div>
                <div class="pv-price-tag">COMMERCIAL</div>
                <div class="pv-price-name">Commercial</div>
                <div class="pv-price-amount">₹7,000</div>
                <div class="pv-price-desc">Shops, offices, Ecotech commercial units</div>
                <ul class="pv-price-list">
                    <li><span class="pv-price-check">✓</span> Everything in Standard</li>
                    <li><span class="pv-price-check">✓</span> GNIDA commercial zoning check</li>
                    <li><span class="pv-price-check">✓</span> Ecotech zone classification</li>
                    <li><span class="pv-price-check">✓</span> Fire NOC & completion status</li>
                    <li><span class="pv-price-check">✓</span> Lease conversion dues</li>
                    <li><span class="pv-price-check">✓</span> PDF report in 48 hours</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B97%2C000%20Commercial%20property%20verification%20in%20Greater%20Noida.%20Property%20address%3A" class="pv-price-btn pv-price-btn--white">Book on WhatsApp →</a>
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
                    <li><span class="pv-price-check">✓</span> Common area & amenity check</li>
                    <li><span class="pv-price-check">✓</span> Sanctioned plan deviation check</li>
                    <li><span class="pv-price-check">✓</span> Report in 3–5 days</li>
                </ul>
                <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20the%20%E2%82%B910%2C000%20Premium%20property%20verification%20with%20site%20visit%20in%20Greater%20Noida.%20Property%20address%3A" class="pv-price-btn">Book on WhatsApp →</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ SERVICE AREAS ═══════════ --}}
<section class="pv-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">Service Coverage</span>
        <h2 class="pv-stitle pv-rv">Areas We Cover in Greater Noida</h2>
        <p class="pv-ssub pv-rv">We cover all of Greater Noida — every sector, every zone, Greater Noida West, and surrounding Gautam Buddha Nagar villages. No extra charge.</p>

        <div class="pv-area-grid pv-rv">
            <div class="pv-area-pill">Alpha 1 & 2</div>
            <div class="pv-area-pill">Beta 1 & 2</div>
            <div class="pv-area-pill">Gamma 1 & 2</div>
            <div class="pv-area-pill">Delta</div>
            <div class="pv-area-pill">Zeta 1 & 2</div>
            <div class="pv-area-pill">Omicron 1, 2 & 3</div>
            <div class="pv-area-pill">Pi 1 & 2</div>
            <div class="pv-area-pill">Sigma</div>
            <div class="pv-area-pill">Eta</div>
            <div class="pv-area-pill">Ecotech 1–12</div>
            <div class="pv-area-pill">Knowledge Park 1–5</div>
            <div class="pv-area-pill">GN West Sector 1–16</div>
            <div class="pv-area-pill">Techzone 4</div>
            <div class="pv-area-pill">Gaur City</div>
            <div class="pv-area-pill">Bisrakh</div>
            <div class="pv-area-pill">Surajpur</div>
        </div>

        <div style="text-align:center; margin-top:28px; font-size:.84rem; color:var(--pv-t2);">
            Don't see your area? <a href="https://wa.me/918595002933" style="color:var(--gn-mid); font-weight:600;">WhatsApp us</a> — we cover all of Gautam Buddha Nagar district.
        </div>
    </div>
</section>

{{-- ═══════════ FAQ ═══════════ --}}
<section class="pv-section" style="background:var(--bg-primary,#fff)">
    <div class="pv-container">
        <span class="pv-slabel pv-rv">FAQ</span>
        <h2 class="pv-stitle pv-rv">Property Verification in Greater Noida — Common Questions</h2>

        <div style="max-width:820px; margin:0 auto; display:flex; flex-direction:column; gap:10px;">
            @php
            $faqs = [
                ["How much does property verification cost in Greater Noida?", "Property verification in Greater Noida and Greater Noida West costs ₹5,000 for residential flats and plots, ₹7,000 for commercial, and ₹10,000 for the premium package with a physical site visit. PDF report delivered in 48 hours. No hidden charges."],
                ["What is GNIDA and why are its dues so critical for Greater Noida flats?", "GNIDA — Greater Noida Industrial Development Authority — owns the land and sub-leases it to builders. Builders must pay land premium and dues to GNIDA before individual flat registry is possible. Unpaid dues block the entire project's registry indefinitely. RERA does not show dues status. Only a physical check at the GNIDA office (Knowledge Park III, Greater Noida) reveals this — and we do it as the first step of every verification."],
                ["My flat is in Greater Noida West (Noida Extension). Is it still a problem?", "Greater Noida West projects vary significantly. Many have fully delivered and have clear dues and OC status. Others still have pending GNIDA dues or missing OC on specific towers. The only way to know your specific flat's status is to check — the project and tower matter, not just the general area. We check the specific project for ₹5,000."],
                ["What is village abadi land in Greater Noida and should I avoid it?", "Village abadi (inhabited settlement) plots are land inside original village boundaries that was excluded from GNIDA's acquisition. They follow gram sabha / revenue department rules, not GNIDA's. They cannot be registered through the GNIDA process, and banks generally won't give home loans on them. We identify whether your property falls within abadi boundaries or within GNIDA allotted land — a distinction that is not visible without checking the GNIDA master plan."],
                ["What was the 2011 Greater Noida West farmer dispute and is it resolved?", "In 2011, farmers who had their agricultural land acquired for Greater Noida West development successfully challenged the acquisition in the Allahabad High Court. The HC order quashed some acquisitions, leading to a Supreme Court stay on construction. The SC ultimately allowed most projects to proceed, but the dues accumulated during the stay remain unpaid in many projects. Some individual farmer cases are still unresolved at the district and HC level. We check the specific land parcel's acquisition status — not just the general area."],
                ["How do I confirm if my Greater Noida builder project has an OC?", "The Occupation Certificate must be confirmed at the GNIDA Building Department office — not from the builder's claim or any online portal. Many completed buildings in Greater Noida lack OC due to unauthorised construction deviations. We physically confirm OC status per tower and phase at GNIDA — included in every ₹5,000 verification."],
                ["What is an NCLT proceeding and how does it affect my flat purchase?", "NCLT (National Company Law Tribunal) insolvency proceedings are initiated when a builder defaults on loans and creditors file for resolution. An Interim Resolution Professional (IRP) takes control of the builder's assets. Homebuyers must register their claims through the NCLT process to receive their flat or refund — often taking 3-7 years. We check whether your builder or their parent entity is under NCLT proceedings before you pay."],
                ["Do you cover Greater Noida sectors like Alpha, Beta, Gamma as well as GN West?", "Yes. We cover all of Greater Noida — the older established sectors (Alpha 1&2, Beta 1&2, Gamma 1&2, Delta, Zeta, Omicron, Pi), all Ecotech and Knowledge Park zones, and all of Greater Noida West (Sectors 1-16, Gaur City, Techzone 4). Same ₹5,000 fee regardless of location within Gautam Buddha Nagar district."],
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
        <p>Send us the project name, tower number and builder name on WhatsApp. We check GNIDA signals and RERA registration free, in 2 hours — and tell you honestly whether a full ₹5,000 verification is worth doing before you pay anything.</p>
        <div class="pv-cta__btns">
            <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20a%20free%20preliminary%20property%20check%20in%20Greater%20Noida.%20Project%20name%20and%20details%3A" class="pv-btn pv-btn--whatsapp">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                Free Preliminary Check — WhatsApp
            </a>
            <a href="#pricing" class="pv-btn pv-btn--ghost">View Pricing →</a>
        </div>
        <p style="margin-top:18px; font-size:.8rem; color:rgba(255,255,255,.5);">
            Also serving:
            <a href="/services/property-verification-noida" style="color:rgba(255,255,255,.65);text-decoration:underline;">Noida</a> ·
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
    <a href="https://wa.me/918595002933?text=Hi%2C%20I%20want%20property%20verification%20in%20Greater%20Noida" class="whatsapp">WhatsApp</a>
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
