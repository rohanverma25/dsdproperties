@extends('layouts.user-app')

@section('title', 'Property Advisor in Lucknow — Free Consultation | Unbiased Expert Advice | DSD Properties')

@section('meta_description', 'Get FREE property advisory in Lucknow. Unbiased investment advice, builder evaluation, negotiation support & legal consultation for buying property in Lucknow. Book free 30-min consultation.')

@section('meta_keywords', 'property advisory lucknow, property consultant lucknow free consultation, unbiased property advice lucknow, real estate advisory services lucknow, property investment advice lucknow, builder evaluation lucknow, property negotiation support lucknow, end to end property advisory lucknow')

@section('canonical', 'https://dsdproperties.in/services/property-advisory-lucknow')

@push('head')
{{-- ── LocalBusiness + Service Schema ── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "name": "DSD Properties — Property Advisory Lucknow",
  "url": "https://dsdproperties.in/services/property-advisory-lucknow",
  "telephone": "+918595002933",
  "email": "dheer@dsdproperties.in",
  "description": "Free property advisory and consulting services in Lucknow. Investment guidance, builder evaluation, negotiation support, legal consultation, and end-to-end advisory for buying property in Lucknow.",
  "areaServed": { "@type": "City", "name": "Lucknow", "addressRegion": "Uttar Pradesh", "addressCountry": "IN" },
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "226025",
    "addressCountry": "IN"
  },
  "priceRange": "FREE – ₹50,000",
  "openingHours": "Mo-Sa 09:00-18:00",
  "founder": {
    "@type": "Person",
    "name": "Dheer Singh",
    "jobTitle": "Founder, DSD Properties"
  },
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Property Advisory Services Lucknow",
    "itemListElement": [
      { "@type": "Offer", "name": "Free Initial Consultation", "price": "0", "priceCurrency": "INR", "description": "30-minute expert property consultation, completely free, no obligation" },
      { "@type": "Offer", "name": "Investment Advisory Lucknow", "price": "5000", "priceCurrency": "INR" },
      { "@type": "Offer", "name": "Builder Evaluation Lucknow", "price": "3000", "priceCurrency": "INR" },
      { "@type": "Offer", "name": "Negotiation Support Lucknow", "price": "5000", "priceCurrency": "INR" },
      { "@type": "Offer", "name": "End-to-End Property Advisory Lucknow", "price": "15000", "priceCurrency": "INR" }
    ]
  }
}
</script>

{{-- ── FAQ Schema ── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is property advisory service in Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "Property advisory in Lucknow is a professional service where an expert guides you through buying, selling, or investing in Lucknow real estate. It includes market analysis, locality comparison, builder evaluation, legal guidance, and negotiation support — helping you make smarter decisions and avoid costly mistakes." }
    },
    {
      "@type": "Question",
      "name": "Is property advisory free in Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "DSD Properties offers a completely free 30-minute initial consultation with no obligation to proceed. You can discuss your requirements, budget, and goals with an expert before deciding if you need deeper paid advisory support." }
    },
    {
      "@type": "Question",
      "name": "How much does property advisory cost in Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "The initial consultation is free. Paid advisory starts at ₹3,000 for specific services like builder evaluation or legal consultation, up to ₹50,000 for complete end-to-end advisory covering property search, site visits, negotiation, and registration guidance." }
    },
    {
      "@type": "Question",
      "name": "Which localities in Lucknow are best for property investment in 2026?",
      "acceptedAnswer": { "@type": "Answer", "text": "Based on current market data, top localities for investment in Lucknow in 2026 are Gomti Nagar Extension (₹7,000–9,500/sqft, high growth), Sultanpur Road (emerging corridor), Sushant Golf City (premium segment), Vrindavan Yojna (mid-segment growth), and Chinhat Highway Belt (infrastructure-driven appreciation)." }
    },
    {
      "@type": "Question",
      "name": "How do I evaluate a builder in Lucknow before booking?",
      "acceptedAnswer": { "@type": "Answer", "text": "Check their RERA registration on the UP RERA portal, verify past project delivery timelines, visit completed projects to assess quality, check for pending legal disputes, and review their financial standing. DSD Properties offers a dedicated builder evaluation service starting at ₹3,000." }
    },
    {
      "@type": "Question",
      "name": "Why hire a property advisor instead of going directly to a broker in Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "A broker earns commission from the seller and is incentivised to close the deal — not to give you unbiased advice. A property advisor works for you, giving independent market analysis, honest locality comparisons, and negotiation support. DSD Properties charges no commission from buyers." }
    },
    {
      "@type": "Question",
      "name": "Can a property advisor help me negotiate the price in Lucknow?",
      "acceptedAnswer": { "@type": "Answer", "text": "Yes. With real market data on actual transaction prices, an advisor can identify how much a seller has inflated the asking price and negotiate effectively. Buyers typically save 5–15% on the purchase price with professional negotiation support in Lucknow." }
    }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Property Advisory in Lucknow",
  "description": "Expert property consulting and advisory for buyers and investors. Free consultation on investment potential, market trends, and RERA compliance.",
  "url": "https://dsdproperties.in/services/property-advisory-lucknow",
  "provider": {
    "@type": "RealEstateAgent",
    "name": "DSD Properties",
    "url": "https://dsdproperties.in",
    "telephone": "+91-8595002933"
  },
  "areaServed": {
    "@type": "City",
    "name": "Lucknow"
  },
  "offers": {
    "@type": "Offer",
    "url": "https://dsdproperties.in/contact-us",
    "price": 0,
    "priceCurrency": "INR",
    "availability": "https://schema.org/InStock"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "How to Get Free Property Advisory in Lucknow",
  "description": "Book a free 30-minute property consultation with DSD Properties in Lucknow. Expert unbiased advice on investment, builder evaluation, negotiation and legal guidance.",
  "totalTime": "PT30M",
  "estimatedCost": { "@type": "MonetaryAmount", "currency": "INR", "value": "0" },
  "step": [
    { "@type": "HowToStep", "position": 1, "name": "WhatsApp or Call to Book", "text": "WhatsApp +91-8595002933 or call during office hours (Mon–Sat, 9 AM–7 PM). Share your requirement — buying, selling, or investment — and we schedule a 30-minute consultation, free of charge.", "url": "https://dsdproperties.in/services/property-advisory-lucknow" },
    { "@type": "HowToStep", "position": 2, "name": "Tell Us Your Budget and Goals", "text": "Share your budget range, preferred localities, timeline, and what you want to achieve — first home, investment, NRI purchase, or resale. The more specific, the better our advice.", "url": "https://dsdproperties.in/services/property-advisory-lucknow" },
    { "@type": "HowToStep", "position": 3, "name": "Receive Unbiased Expert Analysis", "text": "We give you honest locality comparisons, builder evaluations, realistic price expectations, and legal red flags based on current Lucknow market data — with no commission motive from the seller's side.", "url": "https://dsdproperties.in/services/property-advisory-lucknow" },
    { "@type": "HowToStep", "position": 4, "name": "Choose Paid Advisory if Needed", "text": "If deeper support is required — site visits, negotiation, legal consultation, or end-to-end advisory — we offer paid packages starting at ₹3,000. No obligation to proceed beyond the free consultation.", "url": "https://dsdproperties.in/services/property-advisory-lucknow" }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Property Advisor in Lucknow — Free Consultation | Unbiased Expert Advice | DSD Properties",
  "url": "https://dsdproperties.in/services/property-advisory-lucknow",
  "description": "Get free property advisory in Lucknow. Unbiased investment advice, builder evaluation, negotiation support and legal consultation for buying property in Lucknow. Book free 30-min consultation.",
  "speakable": { "@type": "SpeakableSpecification", "cssSelector": [".pa-hero__sub", ".pa-ssub", ".pa-step p", ".pa-faq-a"] },
  "about": {
    "@type": "Service",
    "name": "Property Advisory Service Lucknow",
    "description": "Free property consulting and advisory for buyers and investors in Lucknow. Market analysis, locality comparison, builder evaluation, legal guidance and negotiation support. Free 30-minute initial consultation.",
    "provider": { "@id": "https://dsdproperties.in/#organization" }
  }
}
</script>
@endpush

@section('content')

<style>
/* ── CSS Variables — match verification page ── */
:root {
    --pa-navy:   #011f4b;
    --pa-teal:   #008080;
    --pa-orange: #FF5C00;
    --pa-bg:     var(--bg-primary,  #ffffff);
    --pa-bg2:    var(--bg-secondary, #f3f4f6);
    --pa-card:   var(--card-bg,     #ffffff);
    --pa-border: var(--border-color,#e5e7eb);
    --pa-t1:     var(--text-primary, #111827);
    --pa-t2:     var(--text-secondary,#4b5563);
    --pa-t3:     var(--text-tertiary, #9ca3af);
}

/* ── Base ── */
.pa-wrap { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
.pa-container { max-width: 1100px; margin: 0 auto; padding: 0 24px; }
.pa-section { padding: 88px 0; }

/* ── Animations ── */
@keyframes pa-up    { from { opacity:0; transform:translateY(28px); } to { opacity:1; transform:none; } }
@keyframes pa-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }

/* Scroll reveal — IntersectionObserver */
.pa-rv {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity .6s ease, transform .6s ease;
    transition-delay: var(--rd, 0s);
}
.pa-rv.visible { opacity:1; transform:none; }

/* ── Section label ── */
.pa-slabel {
    font-size: 10px; font-weight: 700; letter-spacing: 3px;
    text-transform: uppercase; color: var(--pa-teal);
    text-align: center; margin-bottom: 10px; display: block;
}

/* ── Section titles ── */
.pa-stitle {
    font-size: clamp(1.6rem, 3.2vw, 2.4rem);
    font-weight: 800; color: var(--pa-t1);
    text-align: center; line-height: 1.15; margin-bottom: 12px;
}
.pa-ssub {
    font-size: .92rem; color: var(--pa-t2); text-align: center;
    max-width: 640px; margin: 0 auto 52px; line-height: 1.75;
}

/* ── Buttons ── */
.pa-btn {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: 'Poppins', sans-serif; font-weight: 600;
    border-radius: 11px; text-decoration: none; cursor: pointer;
    transition: all .22s; border: none; padding: 13px 26px; font-size: .88rem;
}
.pa-btn--primary {
    background: linear-gradient(135deg, #FF5C00, #ff8840);
    color: #fff; box-shadow: 0 5px 20px rgba(255,92,0,.3);
}
.pa-btn--primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(255,92,0,.42);
    color: #fff; text-decoration: none;
}
.pa-btn--ghost {
    background: rgba(255,255,255,.1); color: rgba(255,255,255,.85);
    border: 1px solid rgba(255,255,255,.22);
}
.pa-btn--ghost:hover {
    background: rgba(255,255,255,.18); color: #fff; text-decoration: none;
}

/* ── HERO ── */
.pa-hero {
    position: relative; overflow: hidden; min-height: 92vh;
    background: linear-gradient(135deg, #011f4b 0%, #013870 45%, #005f6b 100%);
    display: flex; align-items: center;
}
.pa-hero__grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size: 50px 50px;
}
.pa-hero__orb {
    position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none;
}
.pa-hero__orb--a {
    width: 500px; height: 500px; background: rgba(0,128,128,.25);
    top: -120px; right: -80px;
    animation: pa-float 9s ease-in-out infinite;
}
.pa-hero__orb--b {
    width: 360px; height: 360px; background: rgba(255,92,0,.14);
    bottom: -60px; left: -60px;
    animation: pa-float 11s ease-in-out infinite 3s;
}
.pa-hero__body {
    position: relative; z-index: 2;
    display: flex; flex-direction: column;
    align-items: center; text-align: center;
    padding-top: 48px; padding-bottom: 72px;
}

.pa-hero__badge {
    display: inline-flex; align-items: center; gap: 9px;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18);
    border-radius: 99px; padding: 7px 16px; margin-bottom: 22px;
    font-size: 11px; font-weight: 500; color: rgba(255,255,255,.82);
    backdrop-filter: blur(8px);
}
.pa-pulse-dot {
    width: 8px; height: 8px; border-radius: 50%; background: #4ade80;
    flex-shrink: 0; animation: paPulse 2.5s infinite; display: inline-block;
}
@keyframes paPulse {
    0%,100%{box-shadow:0 0 0 2px rgba(74,222,128,.3)}
    50%    {box-shadow:0 0 0 6px rgba(74,222,128,.08)}
}
.pa-hero__h1 {
    font-size: clamp(1.9rem, 4vw, 3rem); font-weight: 800; color: #fff;
    line-height: 1.13; margin-bottom: 18px; letter-spacing: -.4px;
}
.pa-hero__h1 em { font-style: normal; color: #FF5C00; }
.pa-hero__sub {
    font-size: .95rem; color: rgba(255,255,255,.72);
    line-height: 1.8; margin-bottom: 28px;
    max-width: 600px; margin-left: auto; margin-right: auto;
}
.pa-hero__cta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 32px; justify-content: center; }
.pa-hero__pills { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
.pa-pill {
    display: flex; align-items: center; gap: 6px;
    padding: 5px 12px;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14);
    border-radius: 8px; font-size: 11px; color: rgba(255,255,255,.6);
}
.pa-pill i { font-size: 10px; color: rgba(255,255,255,.45); }

/* hero wave */
.pa-hero__wave { position: absolute; bottom: 0; left: 0; right: 0; line-height: 0; }
.pa-hero__wave svg { width: 100%; height: 56px; display: block; }

/* ── TRUST BAR ── */
.pa-trust {
    background: var(--pa-card);
    border-bottom: 1px solid var(--pa-border);
    padding: 20px 0;
}
.pa-trust__inner {
    display: flex; align-items: center; gap: 20px;
    flex-wrap: wrap; justify-content: center;
}
.pa-trust__label {
    font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: var(--pa-t3);
}
.pa-trust__items { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; justify-content: center; }
.pa-trust__item {
    display: flex; align-items: center; gap: 7px;
    font-size: .8rem; font-weight: 500; color: var(--pa-t2);
}
.pa-trust__item i { color: var(--pa-teal); font-size: .8rem; }
.pa-trust__sep { width: 1px; height: 16px; background: var(--pa-border); }

/* ── FOUNDER STORY ── */
.pa-founder {
    background: var(--pa-card);
    border: 1px solid var(--pa-border);
    border-radius: 18px;
    padding: 36px 40px;
    max-width: 880px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
}
.pa-founder::before {
    content: ''; position: absolute; top: 0; left: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, var(--pa-teal), var(--pa-orange));
}
.pa-founder__head {
    display: flex; align-items: center; gap: 16px; margin-bottom: 20px;
    padding-bottom: 20px; border-bottom: 1px solid var(--pa-border);
}
.pa-founder__avatar {
    width: 64px; height: 64px; border-radius: 50%;
    background: linear-gradient(135deg, var(--pa-navy), var(--pa-teal));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.4rem; font-weight: 800;
    flex-shrink: 0;
}
.pa-founder__name { font-size: 1.05rem; font-weight: 700; color: var(--pa-t1); margin-bottom: 2px; }
.pa-founder__role { font-size: .82rem; color: var(--pa-t2); }
.pa-founder p {
    font-size: .9rem; color: var(--pa-t2); line-height: 1.85;
    margin-bottom: 14px;
}
.pa-founder p:last-child { margin-bottom: 0; }
.pa-founder strong { color: var(--pa-t1); font-weight: 600; }

/* ── PROSE / ARTICLE BODY ── */
.pa-prose {
    max-width: 820px; margin: 0 auto;
    font-size: .92rem; color: var(--pa-t2); line-height: 1.85;
}
.pa-prose h3 {
    font-size: 1.2rem; font-weight: 700; color: var(--pa-t1);
    margin: 36px 0 14px; line-height: 1.35;
}
.pa-prose h3:first-child { margin-top: 0; }
.pa-prose p { margin-bottom: 16px; }
.pa-prose strong { color: var(--pa-t1); font-weight: 600; }
.pa-prose ul {
    margin: 0 0 18px; padding-left: 0; list-style: none;
}
.pa-prose ul li {
    position: relative; padding-left: 24px; margin-bottom: 10px;
}
.pa-prose ul li::before {
    content: '✓'; position: absolute; left: 0; top: 0;
    color: var(--pa-teal); font-weight: 700;
}
.pa-prose a { color: var(--pa-teal); font-weight: 600; text-decoration: none; }
.pa-prose a:hover { text-decoration: underline; }

/* ── CASE STUDY CARDS ── */
.pa-case-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 18px; max-width: 1000px; margin: 0 auto;
}
.pa-case {
    background: var(--pa-card);
    border: 1px solid var(--pa-border);
    border-radius: 16px;
    padding: 26px 24px;
    position: relative;
    transition: transform .25s, box-shadow .25s;
}
.pa-case:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 40px rgba(0,0,0,.08);
}
.pa-case__tag {
    display: inline-block;
    font-size: .68rem; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: var(--pa-teal);
    background: rgba(0,128,128,.08); padding: 4px 10px;
    border-radius: 4px; margin-bottom: 14px;
}
.pa-case h3 {
    font-size: 1rem; font-weight: 700; color: var(--pa-t1);
    margin-bottom: 12px; line-height: 1.4;
}
.pa-case p {
    font-size: .82rem; color: var(--pa-t2);
    line-height: 1.75; margin-bottom: 16px;
}
.pa-case__result {
    background: linear-gradient(135deg, rgba(255,92,0,.06), rgba(255,92,0,.02));
    border-left: 3px solid var(--pa-orange);
    padding: 12px 14px; border-radius: 0 8px 8px 0;
    font-size: .82rem; color: var(--pa-t1);
}
.pa-case__result strong { color: var(--pa-orange); font-weight: 700; }

/* ── COMPARE TABLE ── */
.pa-compare {
    max-width: 920px; margin: 0 auto;
    background: var(--pa-card);
    border: 1px solid var(--pa-border);
    border-radius: 14px; overflow: hidden;
}
.pa-compare table { width: 100%; border-collapse: collapse; }
.pa-compare thead th {
    background: var(--pa-navy);
    color: #fff; padding: 14px 18px;
    font-size: .82rem; font-weight: 700;
    text-align: left; letter-spacing: .3px;
}
.pa-compare thead th:first-child { width: 32%; }
.pa-compare tbody td {
    padding: 14px 18px;
    border-bottom: 1px solid var(--pa-border);
    font-size: .85rem; color: var(--pa-t2); line-height: 1.6;
    vertical-align: top;
}
.pa-compare tbody tr:last-child td { border-bottom: none; }
.pa-compare tbody td:first-child {
    font-weight: 600; color: var(--pa-t1); background: var(--pa-bg2);
}
.pa-compare .pa-cell-good {
    background: rgba(16,185,129,.06); color: #047857;
}
.pa-compare .pa-cell-bad {
    background: rgba(220,38,38,.04); color: #991b1b;
}

/* ── SERVICE CARDS ── */
.pa-services-grid {
    display: grid; grid-template-columns: repeat(3,1fr); gap: 16px;
}
@media(max-width:820px){ .pa-services-grid { grid-template-columns:1fr 1fr; } }
@media(max-width:520px){ .pa-services-grid { grid-template-columns:1fr; } }

.pa-feat {
    background: var(--pa-card); border: 1px solid var(--pa-border);
    border-radius: 16px; padding: 26px 22px;
    transition: transform .25s, box-shadow .25s, border-color .25s;
    position: relative; overflow: hidden;
}
.pa-feat::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 3px; height: 0;
    background: linear-gradient(to bottom, var(--pa-teal), var(--pa-orange));
    transition: height .3s;
}
.pa-feat:hover::before { height: 100%; }
.pa-feat:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 40px rgba(0,0,0,.08);
    border-color: rgba(0,128,128,.2);
}
.pa-feat__ico {
    width: 46px; height: 46px; border-radius: 11px;
    background: linear-gradient(135deg, rgba(0,128,128,.1), rgba(0,128,128,.05));
    border: 1px solid rgba(0,128,128,.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; margin-bottom: 14px;
    transition: transform .25s;
}
.pa-feat:hover .pa-feat__ico { transform: scale(1.08); }
.pa-feat h3 { font-size: .9rem; font-weight: 700; color: var(--pa-t1); margin-bottom: 7px; }
.pa-feat p  { font-size: .8rem; color: var(--pa-t2); line-height: 1.68; margin: 0 0 12px; }

/* ── RISK CARDS ── */
.pa-risk-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(300px,1fr)); gap: 16px;
    margin-bottom: 32px;
}
.pa-risk-card {
    background: #fef2f2; border: 1.5px solid #fecaca;
    border-radius: 16px; padding: 24px 22px;
    display: flex; gap: 16px; align-items: flex-start;
    transition: transform .25s, box-shadow .25s;
}
.pa-risk-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(220,38,38,.1); }
.pa-risk-icon {
    width: 46px; height: 46px; background: #dc2626;
    border-radius: 11px; display: flex; align-items: center;
    justify-content: center; font-size: 1.3rem; flex-shrink: 0;
}
.pa-risk-title { font-size: .92rem; font-weight: 700; color: #111827; margin-bottom: 6px; }
.pa-risk-text  { font-size: .8rem; color: #4b5563; line-height: 1.65; margin: 0; }

.pa-risk-banner {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    padding: 32px 36px; border-radius: 16px;
    max-width: 860px; margin: 0 auto;
    display: flex; gap: 16px; align-items: flex-start;
}
.pa-risk-banner-icon  { color: #fff; font-size: 1.8rem; flex-shrink: 0; }
.pa-risk-banner-title { color: #fff; font-size: 1.2rem; font-weight: 700; margin-bottom: 8px; }
.pa-risk-banner-text  { color: rgba(255,255,255,.9); font-size: .9rem; line-height: 1.65; }

/* ── PROCESS STEPS ── */
.pa-steps { max-width: 860px; margin: 0 auto; display: flex; flex-direction: column; gap: 14px; }
.pa-step {
    display: flex; gap: 20px; align-items: flex-start;
    background: var(--pa-card); border: 1px solid var(--pa-border);
    border-radius: 14px; padding: 22px 20px;
    transition: transform .25s, box-shadow .25s;
}
.pa-step:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0,0,0,.07);
}
.pa-step__num {
    width: 52px; height: 52px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--pa-navy), #013a6b);
    color: #fff; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; font-weight: 800;
    box-shadow: 0 4px 14px rgba(1,31,75,.28);
    transition: transform .25s, box-shadow .25s;
}
.pa-step:hover .pa-step__num {
    transform: scale(1.08);
    box-shadow: 0 8px 20px rgba(1,31,75,.35);
}
.pa-step h3 { font-size: .9rem; font-weight: 700; color: var(--pa-t1); margin-bottom: 6px; }
.pa-step p  { font-size: .8rem; color: var(--pa-t2); line-height: 1.65; margin: 0; }

/* ── MARKET DATA TABLE ── */
.pa-market {
    max-width: 920px; margin: 0 auto 28px;
    background: var(--pa-card);
    border: 1px solid var(--pa-border);
    border-radius: 14px; overflow: hidden;
}
.pa-market table { width: 100%; border-collapse: collapse; }
.pa-market thead th {
    background: var(--pa-navy);
    color: #fff; padding: 14px 16px;
    font-size: .8rem; font-weight: 700;
    text-align: left; letter-spacing: .3px;
}
.pa-market tbody td {
    padding: 13px 16px;
    border-bottom: 1px solid var(--pa-border);
    font-size: .82rem; color: var(--pa-t2);
}
.pa-market tbody tr:last-child td { border-bottom: none; }
.pa-market tbody tr:hover td { background: var(--pa-bg2); }
.pa-market tbody td:first-child {
    font-weight: 600; color: var(--pa-t1);
}
.pa-market__note {
    max-width: 920px; margin: 0 auto;
    font-size: .76rem; color: var(--pa-t3);
    text-align: center; line-height: 1.6;
}

/* ── CTA SECTION ── */
.pa-cta {
    background: linear-gradient(135deg, #011f4b 0%, #013870 45%, #005f6b 100%);
    padding: 88px 0; position: relative; overflow: hidden;
}
.pa-cta__orb {
    position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none;
    width: 400px; height: 400px; background: rgba(0,128,128,.18);
    top: -100px; right: -80px;
    animation: pa-float 10s ease-in-out infinite;
}
.pa-cta__inner { position: relative; z-index: 2; text-align: center; }
.pa-cta h2 {
    font-size: clamp(1.6rem,3.2vw,2.4rem); font-weight: 800;
    color: #fff; margin-bottom: 14px;
}
.pa-cta p {
    font-size: .95rem; color: rgba(255,255,255,.75);
    max-width: 600px; margin: 0 auto 36px; line-height: 1.75;
}
.pa-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

/* ── FAQ ── */
.pa-faq-item {
    background: var(--pa-card); border: 1px solid var(--pa-border);
    border-radius: 13px; overflow: hidden;
}
.pa-faq-q {
    width: 100%; display: flex; justify-content: space-between; align-items: center;
    padding: 16px 20px; background: none; border: none;
    font-family: 'Poppins', sans-serif; font-size: .88rem; font-weight: 600;
    color: var(--pa-t1); cursor: pointer; text-align: left; gap: 12px;
    transition: background .2s;
}
.pa-faq-q:hover { background: var(--pa-bg2); }
.pa-faq-q i { color: var(--pa-teal); flex-shrink: 0; transition: transform .3s; font-size: .78rem; }
.pa-faq-q.open i { transform: rotate(180deg); }
.pa-faq-a {
    padding: 0 20px; max-height: 0; overflow: hidden;
    font-size: .83rem; color: var(--pa-t2); line-height: 1.75;
    transition: max-height .35s ease, padding .35s ease;
}
.pa-faq-a.open { max-height: 600px; padding: 0 20px 16px; }

/* ── BLOG INTERNAL LINKS ── */
.pa-blog-link {
    display: block; background: var(--pa-card);
    border: 1px solid var(--pa-border); border-radius: 14px;
    padding: 22px 20px; text-decoration: none;
    transition: transform .25s, box-shadow .25s, border-color .25s;
    position: relative; overflow: hidden;
}
.pa-blog-link::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 3px; height: 0;
    background: linear-gradient(to bottom, var(--pa-teal), var(--pa-orange));
    transition: height .3s;
}
.pa-blog-link:hover::before { height: 100%; }
.pa-blog-link:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 40px rgba(0,0,0,.08);
    border-color: rgba(0,128,128,.2);
    text-decoration: none;
}
.pa-blog-link__tag {
    font-size: .68rem; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: var(--pa-teal); margin-bottom: 8px;
}
.pa-blog-link__title {
    font-size: .86rem; font-weight: 600; color: var(--pa-t1);
    line-height: 1.5; margin-bottom: 14px;
}
.pa-blog-link__arrow { font-size: .78rem; font-weight: 700; color: var(--pa-orange); }

/* ── STATS BAR ── */
.pa-stats {
    max-width: 920px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
}
@media(max-width:680px){ .pa-stats { grid-template-columns: repeat(2,1fr); } }
.pa-stat {
    background: var(--pa-card);
    border: 1px solid var(--pa-border);
    border-radius: 12px; padding: 22px 18px;
    text-align: center;
    transition: transform .25s, box-shadow .25s;
}
.pa-stat:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(0,0,0,.06); }
.pa-stat__num {
    font-size: 1.6rem; font-weight: 800;
    background: linear-gradient(135deg, var(--pa-teal), var(--pa-orange));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text; line-height: 1.1;
}
.pa-stat__label {
    font-size: .72rem; color: var(--pa-t2);
    margin-top: 6px; font-weight: 500; line-height: 1.4;
}

/* ── MOBILE STICKY CTA ── */
.pa-mobile-cta {
    display: none;
    position: fixed; bottom: 0; left: 0; right: 0;
    background: var(--pa-card);
    border-top: 3px solid var(--pa-orange);
    padding: 12px 16px;
    z-index: 90;
    box-shadow: 0 -4px 20px rgba(0,0,0,.12);
}
.pa-mobile-cta a {
    display: block; width: 100%; text-align: center;
    background: linear-gradient(135deg, #FF5C00, #ff8840);
    color: #fff; padding: 14px; border-radius: 11px;
    font-family: 'Poppins', sans-serif; font-weight: 700;
    font-size: .9rem; text-decoration: none;
    box-shadow: 0 4px 16px rgba(255,92,0,.28);
}
@media(max-width:1023px){ .pa-mobile-cta { display: block; } }

@media(max-width:860px){
    .pa-section { padding: 64px 0; }
    .pa-hero__body { padding-bottom: 56px; }
    .pa-cta { padding: 64px 0; }
    .pa-founder { padding: 28px 24px; }
    .pa-compare table, .pa-market table { font-size: .78rem; }
    .pa-compare thead th, .pa-compare tbody td,
    .pa-market thead th, .pa-market tbody td { padding: 10px 12px; }
}
@media(max-width:480px){
    .pa-hero__cta { flex-direction: column; }
    .pa-risk-banner { flex-direction: column; gap: 10px; }
    .pa-founder__head { flex-direction: column; text-align: center; }
}
</style>

<div class="pa-wrap">

<!-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ -->
<section class="pa-hero">
    <div class="pa-hero__grid"></div>
    <div class="pa-hero__orb pa-hero__orb--a"></div>
    <div class="pa-hero__orb pa-hero__orb--b"></div>

    <div class="pa-container pa-hero__body">

        <div style="animation: pa-up .6s ease both; max-width: 700px; margin: 0 auto;">
            <div class="pa-hero__badge">
                <span class="pa-pulse-dot"></span>
                Expert Property Advisory · Lucknow
            </div>
            <h1 class="pa-hero__h1">
                Property Advisory &amp;<br>
                Consulting Services —<br>
                <em>Smarter Decisions</em>
            </h1>

            <p class="pa-hero__sub">
                Get FREE expert consultation on buying, selling, or investing in Lucknow real estate.
                Unbiased market insights, legal guidance, and investment strategies tailored to your goals.
            </p>

            <div class="pa-hero__cta">
                <a href="{{ route('contact-us') }}" class="pa-btn pa-btn--primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Book Free Consultation
                </a>
                <a href="https://wa.me/918595002933?text=Hi, I need property advisory services in Lucknow" class="pa-btn pa-btn--ghost">
                    💬 WhatsApp Us
                </a>
            </div>

            <div class="pa-hero__pills">
                <div class="pa-pill"><i class="fas fa-comment-dots"></i> FREE Consultation</div>
                <div class="pa-pill"><i class="fas fa-user-tie"></i> Expert Consultants</div>
                <div class="pa-pill"><i class="fas fa-balance-scale"></i> Unbiased Advice</div>
                <div class="pa-pill"><i class="fas fa-shield-alt"></i> No Obligation</div>
            </div>
        </div>

    </div>

    <div class="pa-hero__wave">
        <svg viewBox="0 0 1440 56" preserveAspectRatio="none">
            <path d="M0,28 C480,56 960,0 1440,28 L1440,56 L0,56 Z" fill="var(--bg-primary,#fff)"/>
        </svg>
    </div>
</section>


<!-- ══════════════════════════════════════
     TRUST BAR
══════════════════════════════════════ -->
<section class="pa-trust">
    <div class="pa-container pa-trust__inner">
        <span class="pa-trust__label">What we stand for</span>
        <div class="pa-trust__items">
            <div class="pa-trust__item"><i class="fas fa-comment-dots"></i> FREE Consultation</div>
            <div class="pa-trust__sep"></div>
            <div class="pa-trust__item"><i class="fas fa-user-tie"></i> Expert Consultants</div>
            <div class="pa-trust__sep"></div>
            <div class="pa-trust__item"><i class="fas fa-balance-scale"></i> Unbiased Advice</div>
            <div class="pa-trust__sep"></div>
            <div class="pa-trust__item"><i class="fas fa-handshake"></i> No Obligation</div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     STATS BAR — credibility
══════════════════════════════════════ -->
<section class="pa-section" style="padding:48px 0; background:var(--bg-primary,#fff);">
    <div class="pa-container">
        <div class="pa-stats">
            <div class="pa-stat pa-rv">
                <div class="pa-stat__num">50+</div>
                <div class="pa-stat__label">Lucknow localities covered</div>
            </div>
            <div class="pa-stat pa-rv" style="--rd:.06s">
                <div class="pa-stat__num">30+</div>
                <div class="pa-stat__label">Builders evaluated independently</div>
            </div>
            <div class="pa-stat pa-rv" style="--rd:.12s">
                <div class="pa-stat__num">₹0</div>
                <div class="pa-stat__label">Commission charged from buyers</div>
            </div>
            <div class="pa-stat pa-rv" style="--rd:.18s">
                <div class="pa-stat__num">48hr</div>
                <div class="pa-stat__label">Verification report turnaround</div>
            </div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     FOUNDER STORY — E-E-A-T
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-secondary,#f3f4f6); padding-top:48px;">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">Why DSD Properties Exists</span>
        <h2 class="pa-stitle pa-rv">Founded by a Buyer Who Got Burned</h2>
        <p class="pa-ssub pa-rv">DSD Properties was not started as a brokerage. It was started because the founder personally lost money on a Lucknow property purchase — and decided no one else should.</p>

        <div class="pa-founder pa-rv">
            <div class="pa-founder__head">
                <div class="pa-founder__avatar">DS</div>
                <div>
                    <div class="pa-founder__name">Dheer Singh</div>
                    <div class="pa-founder__role">Founder, DSD Properties</div>
                </div>
            </div>
            <p>
                In early 2024, I was looking to buy a plot in Lucknow. I spoke to multiple brokers, visited properties on Sultanpur Road and Faizabad Road, and got quotes that varied wildly for similar plots in the same locality. One broker quoted <strong>₹4,200/sqft</strong>. Another, for a plot 800 metres away, quoted <strong>₹2,900/sqft</strong>. Neither could explain the difference beyond vague claims about "premium location" and "registry party."
            </p>
            <p>
                When I dug deeper into the registry data on igrsup.gov.in and cross-checked with actual sale deeds in those areas, I realised the truth: <strong>brokers were quoting whatever they thought I would pay</strong>, not what the plot was worth. The broker working closest with me would have made a 2% commission on the inflated price — about ₹1.4 lakh extra in his pocket, paid by me.
            </p>
            <p>
                That experience is why DSD Properties exists. We are <strong>not a brokerage</strong>. We charge zero commission from buyers. Our advisory is funded by transparent flat fees — so our only incentive is to give you the truth: real circle rates, real recent transaction prices, real builder track records, real risks. If a property is overpriced by ₹5 lakh, we will tell you. If a builder has 18 months of delay history, we will show you the RERA records.
            </p>
            <p>
                I run DSD Properties as a Lucknow-based platform with a verification-first focus. Every advisory engagement is grounded in primary data — IGRSUP registry records, UP RERA filings, LDA scheme documents, and our own physical site visits. No paid rankings, no builder kickbacks, no broker commissions. Just data, and honesty about what it means for you.
            </p>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     SERVICES OVERVIEW
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-primary,#fff)">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">Our Advisory Services</span>
        <h2 class="pa-stitle pa-rv">Complete Property Consulting Solutions</h2>
        <p class="pa-ssub pa-rv">From investment advice to legal consultation, we cover every aspect of your property journey in Lucknow — backed by real data, not sales pitches.</p>

        <div class="pa-services-grid">
            <div class="pa-feat pa-rv">
                <div class="pa-feat__ico">💼</div>
                <h3>Investment Advisory</h3>
                <p>Locality-by-locality investment analysis backed by real circle rates from IGRSUP, 3-year appreciation data, and infrastructure pipeline assessment for Lucknow corridors.</p>
            </div>
            <div class="pa-feat pa-rv" style="--rd:.06s">
                <div class="pa-feat__ico">⚖️</div>
                <h3>Legal Consultation</h3>
                <p>Section 80 conversion checks, title chain verification (15–20 years), RERA compliance, encumbrance certificate review, and Dakhil Kharij guidance.</p>
            </div>
            <div class="pa-feat pa-rv" style="--rd:.12s">
                <div class="pa-feat__ico">📊</div>
                <h3>Market Analysis</h3>
                <p>Real transaction data from registry records (not just listing prices), zone-wise circle rate breakdowns, and honest comparison of Lucknow's emerging vs established areas.</p>
            </div>
            <div class="pa-feat pa-rv" style="--rd:.04s">
                <div class="pa-feat__ico">🏗️</div>
                <h3>Builder Evaluation</h3>
                <p>RERA registration check, past project delivery timelines vs promised dates, complaint history review, financial standing analysis, and physical site visits to completed projects.</p>
            </div>
            <div class="pa-feat pa-rv" style="--rd:.1s">
                <div class="pa-feat__ico">💰</div>
                <h3>Negotiation Support</h3>
                <p>Armed with actual transaction prices for the same locality and project, we identify the seller's inflation margin and negotiate aggressively. Buyers typically save 5–15%.</p>
            </div>
            <div class="pa-feat pa-rv" style="--rd:.16s">
                <div class="pa-feat__ico">📝</div>
                <h3>End-to-End Advisory</h3>
                <p>Complete handholding from shortlisting to registration — site visits, document verification, stamp duty optimisation, registry preparation, and post-purchase Dakhil Kharij.</p>
            </div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     ADVISOR vs BROKER COMPARISON
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">The Real Difference</span>
        <h2 class="pa-stitle pa-rv">Property Advisor vs Broker — Why It Matters</h2>
        <p class="pa-ssub pa-rv">Most Lucknow buyers don't realise their broker is paid by the seller. This single fact changes everything about the advice you receive.</p>

        <div class="pa-compare pa-rv">
            <table>
                <thead>
                    <tr>
                        <th>Factor</th>
                        <th>Typical Broker</th>
                        <th>Property Advisor (DSD)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Who pays them</td>
                        <td class="pa-cell-bad">Seller / builder (1–2% commission)</td>
                        <td class="pa-cell-good">You — flat fee, no commission</td>
                    </tr>
                    <tr>
                        <td>Incentive</td>
                        <td class="pa-cell-bad">Close the deal at highest possible price</td>
                        <td class="pa-cell-good">Help you make the right decision — even if it means walking away</td>
                    </tr>
                    <tr>
                        <td>Price quoted</td>
                        <td class="pa-cell-bad">Listing price (often inflated 10–30%)</td>
                        <td class="pa-cell-good">Actual recent transaction price from registry data</td>
                    </tr>
                    <tr>
                        <td>Builder evaluation</td>
                        <td class="pa-cell-bad">Promotes builders who pay highest commission</td>
                        <td class="pa-cell-good">Independent assessment from RERA records, no kickbacks</td>
                    </tr>
                    <tr>
                        <td>Legal due diligence</td>
                        <td class="pa-cell-bad">Usually skipped — seller's documents accepted at face value</td>
                        <td class="pa-cell-good">Title chain verified 15–20 years, Section 80 status confirmed, EC checked</td>
                    </tr>
                    <tr>
                        <td>Negotiation</td>
                        <td class="pa-cell-bad">Minimal — every rupee saved reduces their commission</td>
                        <td class="pa-cell-good">Aggressive — armed with real market data, typical savings 5–15%</td>
                    </tr>
                    <tr>
                        <td>What happens if you skip the deal</td>
                        <td class="pa-cell-bad">Lose interest, push you toward another (often worse) option</td>
                        <td class="pa-cell-good">Continue to advise — you've already paid for our time, not the deal</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="pa-rv" style="text-align:center; max-width:680px; margin:24px auto 0; font-size:.85rem; color:var(--pa-t2); line-height:1.75;">
            <strong style="color:var(--pa-t1)">The simple test:</strong> Ask any broker, "Should I walk away from this deal?" Watch how they answer. A real advisor will say yes when the data says yes.
        </p>
    </div>
</section>


<!-- ══════════════════════════════════════
     CASE STUDIES — proof of value
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-primary,#fff)">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">Real Case Studies</span>
        <h2 class="pa-stitle pa-rv">What Advisory Actually Saves Buyers</h2>
        <p class="pa-ssub pa-rv">Anonymised but real — these are actual outcomes from our advisory engagements in Lucknow over the past 18 months.</p>

        <div class="pa-case-grid">

            <div class="pa-case pa-rv">
                <div class="pa-case__tag">Gomti Nagar Extension</div>
                <h3>3BHK Apartment — Listed at ₹78L, Bought at ₹66.5L</h3>
                <p>
                    A buyer approached us for a 3BHK apartment in a Gomti Nagar Extension project listed at ₹78 lakh. Our market analysis pulled actual sale deeds from the same project from the previous 6 months — comparable units had registered at ₹64–68 lakh. The "premium" the seller was charging had no basis in real transaction data.
                </p>
                <div class="pa-case__result">
                    <strong>Result:</strong> Final negotiated price ₹66.5L. Saved ₹11.5 lakh. Advisory fee: ₹5,000.
                </div>
            </div>

            <div class="pa-case pa-rv" style="--rd:.06s">
                <div class="pa-case__tag">Sultanpur Road — Section 80</div>
                <h3>1,200 sqft Plot — Walked Away from a Legal Trap</h3>
                <p>
                    A buyer was about to book a plot on Kisan Path at ₹3,800/sqft. Our title verification pulled the Khatauni and revealed the original landowner was from the Scheduled Caste community — meaning the sale required prior District Magistrate permission under the UPZA &amp; LR Act. The seller had no DM permission. Without it, the sale would be legally void at any stage.
                </p>
                <div class="pa-case__result">
                    <strong>Result:</strong> Buyer walked away. Avoided ₹45.6 lakh stuck in unsellable property.
                </div>
            </div>

            <div class="pa-case pa-rv" style="--rd:.12s">
                <div class="pa-case__tag">Builder Evaluation</div>
                <h3>Mid-Tier Builder — Hidden Delay Pattern</h3>
                <p>
                    A first-time buyer was about to book a 2BHK in a project marketed as "ready in 18 months." Our builder evaluation cross-referenced the developer's three previous Lucknow projects on the UP RERA portal — average actual delivery delay was 27 months beyond promised dates. RERA also showed 11 active complaints from past buyers about possession delays.
                </p>
                <div class="pa-case__result">
                    <strong>Result:</strong> Buyer chose a different RERA-registered project. Advisory fee: ₹3,000.
                </div>
            </div>

            <div class="pa-case pa-rv" style="--rd:.18s">
                <div class="pa-case__tag">Stamp Duty Optimisation</div>
                <h3>₹62L Plot — Saved ₹62,000 in Stamp Duty</h3>
                <p>
                    A couple was registering a ₹62 lakh plot in the husband's name. We advised registering it in the wife's name instead — under UP's post-July 2025 women's rebate, female buyers pay 6% stamp duty (with an additional 1% rebate up to ₹1 crore) versus 7% for male buyers. Same property, same buyer family, ₹62,000 saved legally.
                </p>
                <div class="pa-case__result">
                    <strong>Result:</strong> ₹62,000 saved in stamp duty alone. Advisory fee: covered in free initial consultation.
                </div>
            </div>

        </div>

        <p class="pa-rv" style="text-align:center; max-width:680px; margin:32px auto 0; font-size:.78rem; color:var(--pa-t3); line-height:1.7;">
            Names and exact transaction details have been altered to protect client privacy. Locality, savings figures, and methodology are accurate.
        </p>
    </div>
</section>


<!-- ══════════════════════════════════════
     LUCKNOW MARKET BRIEF — substantive content
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">Lucknow Market Briefing 2026</span>
        <h2 class="pa-stitle pa-rv">What Every Lucknow Property Buyer Should Know in 2026</h2>
        <p class="pa-ssub pa-rv">A grounded, data-backed view of where Lucknow's market actually is — beyond the broker hype.</p>

        <div class="pa-prose pa-rv">

            <h3>The Lucknow market is not one market — it is six</h3>
            <p>
                Most generic property advice treats "Lucknow" as a single market. It is not. The city has at least six distinct micro-markets, each with completely different dynamics: <strong>established premium</strong> (Gomti Nagar, Hazratganj, Mahanagar), <strong>high-growth corridors</strong> (Gomti Nagar Extension, Sultanpur Road), <strong>mid-segment value</strong> (Vrindavan Yojna, Indira Nagar, Aliganj), <strong>emerging affordable</strong> (Mohanlalganj, Kisan Path, Banthra), <strong>LDA scheme zones</strong> (Anant Nagar, Atal Nagar, Wellness City), and <strong>rural-urban fringe</strong> (areas converting from agricultural to non-agricultural use under Section 80).
            </p>
            <p>
                Each of these has different price drivers, different legal complexities, and different risk profiles. A "good investment" in one zone may be a disaster in another. Honest advisory begins with knowing which zone you are actually in — and most buyers don't.
            </p>

            <h3>Verified locality price ranges (May 2026)</h3>
            <p>
                These are real per-square-foot ranges based on actual registered transactions from IGRSUP and our internal site-visit data. Listing prices on portals are typically 10–25% higher than what properties actually transact at:
            </p>

        </div>

        <div class="pa-market pa-rv" style="--rd:.06s">
            <table>
                <thead>
                    <tr>
                        <th>Locality / Zone</th>
                        <th>Price Range (₹/sqft)</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gomti Nagar (premium)</td>
                        <td>₹8,500 – ₹15,000</td>
                        <td>End-use, established</td>
                    </tr>
                    <tr>
                        <td>Hazratganj / Mahanagar</td>
                        <td>₹9,000 – ₹14,000</td>
                        <td>Commercial, central</td>
                    </tr>
                    <tr>
                        <td>Gomti Nagar Extension</td>
                        <td>₹7,000 – ₹9,500</td>
                        <td>High-growth investment</td>
                    </tr>
                    <tr>
                        <td>Sultanpur Road (Zone 1 / GNX)</td>
                        <td>₹3,000 – ₹6,900</td>
                        <td>Wellness City impact play</td>
                    </tr>
                    <tr>
                        <td>Sushant Golf City</td>
                        <td>₹6,500 – ₹11,000</td>
                        <td>Premium townships</td>
                    </tr>
                    <tr>
                        <td>Vrindavan Yojna</td>
                        <td>₹4,800 – ₹7,500</td>
                        <td>Mid-segment, rental yield</td>
                    </tr>
                    <tr>
                        <td>Indira Nagar / Aliganj</td>
                        <td>₹5,500 – ₹8,000</td>
                        <td>Established, family</td>
                    </tr>
                    <tr>
                        <td>Faizabad Road belt</td>
                        <td>₹4,500 – ₹7,000</td>
                        <td>Connectivity-driven growth</td>
                    </tr>
                    <tr>
                        <td>Chinhat Highway Belt</td>
                        <td>₹3,800 – ₹6,200</td>
                        <td>Infrastructure appreciation</td>
                    </tr>
                    <tr>
                        <td>Mohanlalganj / Banthra</td>
                        <td>₹2,800 – ₹5,000</td>
                        <td>High risk, high reward</td>
                    </tr>
                    <tr>
                        <td>Kisan Path frontier zone</td>
                        <td>₹900 – ₹1,500</td>
                        <td>Long-horizon speculation</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="pa-market__note pa-rv">
            Sources: IGRSUP registered transaction data, UP RERA project filings, DSD Properties internal site-visit data. Prices reflect Q2 2026 transaction averages, not listing prices. Individual properties may transact above or below these ranges based on title clarity, legal status, and infrastructure proximity.
        </p>

        <div class="pa-prose pa-rv" style="margin-top:36px;">

            <h3>Three structural shifts buyers must understand in 2026</h3>
            <p>
                <strong>1. Section 80 has replaced Section 143.</strong> The old Uttar Pradesh land conversion regime under Section 143 of the UPZA &amp; LR Act has been superseded by Section 80 under the new ordinance. This is the single most expensive thing buyers don't know about — an unconverted plot sells at a 30–40% discount to a properly converted plot in the same locality, but most buyers neither check nor understand this distinction. We routinely see buyers paying "premium plot" prices for what is legally still agricultural land.
            </p>
            <p>
                <strong>2. SC/ST land sale restrictions are not optional.</strong> Land originally owned by individuals from Scheduled Caste or Scheduled Tribe communities cannot be sold to a non-SC/ST buyer without explicit prior District Magistrate permission. Section 80 conversion does <em>not</em> bypass this — both approvals are required independently. In rapidly developing corridors like Kisan Path, Mohanlalganj, and parts of Raebareli Road, a meaningful percentage of original landowners belong to SC/ST communities. Any title chain check that doesn't go back 15–20 years can miss this entirely. This is the legal trap that ruins more Lucknow investments than any other single factor.
            </p>
            <p>
                <strong>3. Stamp duty rules have changed for women buyers.</strong> Post-July 2025, female buyers in UP receive an additional 1% rebate on stamp duty up to ₹1 crore, on top of the existing differential. This means structuring a purchase in a wife's name (or jointly with the wife as primary owner) can legally save tens of thousands to over ₹1 lakh on a single transaction. For blood-relative transfers, stamp duty is now a flat ₹5,000 — a massive shift from the earlier 7% rate. Most buyers and many brokers still operate on the old assumptions and overpay.
            </p>

            <h3>The most expensive mistakes Lucknow buyers make</h3>
            <p>
                After 18+ months of advisory work, the same mistakes repeat. In rough order of frequency and cost:
            </p>
            <ul>
                <li><strong>Trusting listing prices as benchmarks.</strong> Listing prices on portals are aspirational. Actual transaction prices live in the IGRSUP registry. The gap is often ₹3–8 lakh.</li>
                <li><strong>Skipping the title chain.</strong> Looking only at the current sale deed and ignoring the previous 15–20 years. Most legal disputes originate two to three transactions back.</li>
                <li><strong>Booking with builders who paid for top broker placement.</strong> Brokers don't recommend builders by quality — they recommend by commission. RERA records tell a different story.</li>
                <li><strong>Ignoring Dakhil Kharij after registry.</strong> Many buyers complete the sale deed and stop there. Without mutation, the property cannot be resold or used as loan collateral. This is unforced cost — usually ₹500 to ₹2,000 in fees, but skipped routinely.</li>
                <li><strong>Buying "investment plots" in zones with no genuine infrastructure pipeline.</strong> Some peripheral pockets are sold on speculation alone. We cross-reference every "high-growth" claim against actual LDA scheme funding, road development orders, and SEZ notifications.</li>
                <li><strong>Paying circle rate when transaction value is lower.</strong> Stamp duty is calculated on the higher of transaction value or circle rate. Some buyers don't know this and end up paying duty on inflated valuations.</li>
            </ul>

            <h3>What free advisory actually covers</h3>
            <p>
                Our 30-minute free consultation is not a sales call disguised as advice. It is a real working session where we cover three specific things: <strong>(1) your situation and goal</strong> — budget, timeline, end-use vs investment, risk tolerance; <strong>(2) where Lucknow's market data points for someone in your situation</strong> — which 3–4 zones make sense and why, which to rule out and why; and <strong>(3) whether you actually need paid advisory at all</strong>. For some buyers — especially repeat investors who already know their target locality and just need verification — the answer is no, just book the verification service. For first-time buyers entering an unfamiliar zone, deeper advisory typically pays for itself many times over through negotiation savings alone.
            </p>
            <p>
                There is no obligation, no upsell pressure, and no follow-up sales calls. The free consultation exists because we believe property buyers in Lucknow deserve to evaluate an advisor's value before committing — the way most cities have already normalised, and the way Lucknow's market is finally moving toward.
            </p>

        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     WHY ADVISORY MATTERS — risks
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-primary,#fff)">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">Why It Matters</span>
        <h2 class="pa-stitle pa-rv">Common Mistakes That Cost Lakhs</h2>
        <p class="pa-ssub pa-rv">Most property buyers lose money on avoidable mistakes. Professional advisory prevents these costly errors.</p>

        <div class="pa-risk-grid">
            <div class="pa-risk-card pa-rv">
                <div class="pa-risk-icon">⚠️</div>
                <div>
                    <div class="pa-risk-title">Overpaying for Property</div>
                    <p class="pa-risk-text">Buyers often pay 10–30% above market rate due to lack of market knowledge and poor negotiation skills.</p>
                </div>
            </div>
            <div class="pa-risk-card pa-rv" style="--rd:.06s">
                <div class="pa-risk-icon">📉</div>
                <div>
                    <div class="pa-risk-title">Wrong Location Investment</div>
                    <p class="pa-risk-text">Investing in areas with poor growth potential, leading to stagnant or declining property values over time.</p>
                </div>
            </div>
            <div class="pa-risk-card pa-rv" style="--rd:.12s">
                <div class="pa-risk-icon">📜</div>
                <div>
                    <div class="pa-risk-title">Legal Complications</div>
                    <p class="pa-risk-text">Signing unfavorable contracts, missing clauses, or overlooking legal red flags that cause future disputes.</p>
                </div>
            </div>
            <div class="pa-risk-card pa-rv" style="--rd:.18s">
                <div class="pa-risk-icon">🏗️</div>
                <div>
                    <div class="pa-risk-title">Unreliable Builders</div>
                    <p class="pa-risk-text">Booking with builders who have poor track records, leading to delays, quality issues, or project abandonment.</p>
                </div>
            </div>
        </div>

        <div class="pa-risk-banner pa-rv">
            <div class="pa-risk-banner-icon">💡</div>
            <div>
                <div class="pa-risk-banner-title">Real Cost of DIY Property Buying</div>
                <div class="pa-risk-banner-text">₹2–5 lakh overpayment &nbsp;·&nbsp; 6–12 months wasted time &nbsp;·&nbsp; Legal disputes &nbsp;·&nbsp; Poor resale value &nbsp;·&nbsp; Stress &amp; confusion</div>
            </div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     PROCESS
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">How We Work</span>
        <h2 class="pa-stitle pa-rv">Our Advisory Process</h2>
        <p class="pa-ssub pa-rv">Transparent, step-by-step guidance from initial consultation to final decision.</p>

        <div class="pa-steps">
            <div class="pa-step pa-rv">
                <div class="pa-step__num">1</div>
                <div>
                    <h3>Free Initial Consultation (30 mins)</h3>
                    <p>Discuss your requirements, budget, goals, and concerns. We share which 3–4 Lucknow zones fit your profile, and which to rule out. No obligation, no follow-up sales calls.</p>
                </div>
            </div>
            <div class="pa-step pa-rv" style="--rd:.06s">
                <div class="pa-step__num">2</div>
                <div>
                    <h3>Requirement Analysis &amp; Strategy</h3>
                    <p>Deep dive into investment capacity, risk appetite, end-use vs investment intent, and timeline. Output: a written brief specifying target zones, project types, and price ceiling — your buying playbook.</p>
                </div>
            </div>
            <div class="pa-step pa-rv" style="--rd:.12s">
                <div class="pa-step__num">3</div>
                <div>
                    <h3>Market Research &amp; Shortlisting</h3>
                    <p>We pull actual transaction data from IGRSUP, RERA records for shortlisted projects, and verify circle rates. You receive a comparison of 4–6 properties with honest pros, cons, and red flags.</p>
                </div>
            </div>
            <div class="pa-step pa-rv" style="--rd:.18s">
                <div class="pa-step__num">4</div>
                <div>
                    <h3>Site Visits &amp; Legal Due Diligence</h3>
                    <p>Accompanied site visits to assess construction quality, locality reality, and infrastructure claims. Title chain verified 15–20 years, Section 80 status confirmed, encumbrance certificate pulled.</p>
                </div>
            </div>
            <div class="pa-step pa-rv" style="--rd:.24s">
                <div class="pa-step__num">5</div>
                <div>
                    <h3>Negotiation, Registry &amp; Mutation</h3>
                    <p>Professional negotiation backed by transaction data, sale deed review before signing, stamp duty optimisation, registry guidance at the Sub-Registrar's office, and post-purchase Dakhil Kharij filing.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     LOCAL CONTENT — Lucknow specific
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-primary,#fff)">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">Lucknow Market Intelligence</span>
        <h2 class="pa-stitle pa-rv">Where We Advise — Lucknow Locality Coverage</h2>
        <p class="pa-ssub pa-rv">We have deep, data-backed knowledge of every major Lucknow locality — not generic advice, but specific insights on prices, growth potential, and risks.</p>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:16px; margin-bottom:40px;">
            <div class="pa-feat pa-rv">
                <div class="pa-feat__ico">🏆</div>
                <h3>Premium Localities</h3>
                <p>Gomti Nagar, Vibhuti Khand, Hazratganj, Mahanagar — ₹7,000–15,000/sqft. We advise on whether premium pricing is justified and negotiate hard on overpriced listings.</p>
            </div>
            <div class="pa-feat pa-rv" style="--rd:.06s">
                <div class="pa-feat__ico">📈</div>
                <h3>High Growth Corridors</h3>
                <p>Gomti Nagar Extension, Sultanpur Road, Chinhat — ₹5,000–9,500/sqft. Best areas for appreciation-focused investment. We identify which projects have real growth vs hype.</p>
            </div>
            <div class="pa-feat pa-rv" style="--rd:.12s">
                <div class="pa-feat__ico">🏠</div>
                <h3>Mid-Segment Value</h3>
                <p>Vrindavan Yojna, Indira Nagar, Aliganj, Faizabad Road — ₹4,800–7,500/sqft. Strong rental yields, established infrastructure. Good for end-use buyers.</p>
            </div>
            <div class="pa-feat pa-rv" style="--rd:.18s">
                <div class="pa-feat__ico">💡</div>
                <h3>Affordable &amp; Emerging</h3>
                <p>Mohanlalganj, Banthra, Deva Road, Kisan Path Belt — ₹2,800–5,000/sqft. High risk, high reward. We advise on which plots here have clear titles and real infrastructure coming.</p>
            </div>
        </div>

        {{-- Builder coverage --}}
        <div class="pa-rv" style="background:var(--bg-secondary,#f3f4f6); border:1px solid var(--border-color,#e5e7eb); border-radius:16px; padding:28px 32px;">
            <div style="font-size:.75rem; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--pa-teal); margin-bottom:14px;">30+ Builders We Have Evaluated in Lucknow</div>
            <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:16px;">
              @foreach([
                'Eldeco Group',
                'Omaxe Limited',
                'Shalimar Corp',
                'Rishita Developers',
                'Paarth Infrabuild',
                'Ansal API',
                'Rohtas Projects',
                'Emaar India',
                'Experion Developers',
                'RG Group Lucknow',
                'Levana Group',
                'Sahu City Developers',
                'Dream World Infrastructure',
                'MI Builders',
                'Arsha Infra Developers',
                'Omega Developers',
                'Vasundhara Group Lucknow',
                'Sai Kripa Developers',
                'Shree Balaji Construction',
                'Viraj Constructions',
                'Green Infra Developers',
                'Saket Group Lucknow',
                'Surya Infra Heights',
                'Lakshya Infratech',
                'Golden Brick Developers',
                'Urban Axis Developers',
                'Skyline Infra Lucknow',
                'Azea Botanica Developers',
                'Neelkanth Group Lucknow',
                'Amit Group Lucknow'
            ] as $builder)
                <span style="padding:5px 12px; background:var(--bg-primary,#fff); border:1px solid var(--border-color,#e5e7eb); border-radius:99px; font-size:.75rem; font-weight:500; color:var(--pa-t2);">
                    {{ $builder }}
                </span>
            @endforeach
            </div>
            <div style="font-size:.78rem; color:var(--pa-t3); display:flex; align-items:center; gap:6px;">
                <i class="fas fa-info-circle" style="color:var(--pa-teal)"></i>
                Builder evaluations are based on RERA records, past delivery data, and physical site visits — not builder-paid rankings or sponsored placements.
            </div>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     FAQ SECTION
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-secondary,#f3f4f6)">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">FAQs</span>
        <h2 class="pa-stitle pa-rv">Frequently Asked Questions</h2>
        <p class="pa-ssub pa-rv">Honest answers to the most common questions about property advisory in Lucknow.</p>

        <div style="max-width:780px; margin:0 auto; display:flex; flex-direction:column; gap:10px;">

            <div class="pa-faq-item pa-rv">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>What is property advisory service in Lucknow?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    Property advisory is a professional service where an expert guides you through buying, selling, or investing in Lucknow real estate. It includes market analysis, locality comparison, builder evaluation, legal guidance, and negotiation support — helping you make smarter decisions and avoid costly mistakes that most buyers make without expert help.
                </div>
            </div>

            <div class="pa-faq-item pa-rv" style="--rd:.04s">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>Is property advisory really free?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    Yes — the initial 30-minute consultation is completely free with no obligation to proceed. You can discuss your requirements, budget, and goals with our expert before deciding if you want deeper paid advisory. We do this because we believe buyers should be able to assess our value before committing.
                </div>
            </div>

            <div class="pa-faq-item pa-rv" style="--rd:.08s">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>Why hire a property advisor instead of going directly to a broker?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    A broker earns commission from the seller — typically 1–2% of the deal value — and is incentivised to close the sale, not give you honest advice. A property advisor works exclusively for you. At DSD Properties, we charge no commission from buyers and have no financial relationship with any builder or seller. Our only revenue is the flat advisory fee you pay, which means our incentive aligns with telling you the truth — including telling you to walk away from a deal when the data says walk away.
                </div>
            </div>

            <div class="pa-faq-item pa-rv" style="--rd:.12s">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>Which localities in Lucknow are best for investment in 2026?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    Based on current transaction data: Gomti Nagar Extension for high-growth appreciation (₹7,000–9,500/sqft), Sultanpur Road as an emerging corridor with Wellness City and IT City driving demand, Sushant Golf City for premium end-use, Vrindavan Yojna for mid-segment steady returns and rental yield, and Chinhat Highway Belt for infrastructure-driven growth. The right choice depends on your budget, risk appetite, and whether it's for end-use or investment. We map these factors against your profile in the free consultation.
                </div>
            </div>

            <div class="pa-faq-item pa-rv" style="--rd:.16s">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>How do I evaluate a builder in Lucknow before booking?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    Check their RERA registration on the UP RERA portal, verify past project delivery timelines vs promised dates (delays of 18+ months are a serious red flag), physically visit 1–2 completed projects to assess construction quality, check for any pending legal disputes on the RERA complaints section, and review the builder's financial position. DSD Properties offers a dedicated builder evaluation report starting at ₹3,000, which compiles all of this into a single document with a clear go/no-go recommendation.
                </div>
            </div>

            <div class="pa-faq-item pa-rv" style="--rd:.20s">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>Can an advisor help me negotiate a better price in Lucknow?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    Yes — this is one of the highest-value services we provide. With real market data on actual transaction prices (not just listing prices), we can identify exactly how much a seller has inflated the asking price. Buyers typically save 5–15% on the final purchase price with professional negotiation support, which more than covers the advisory fee. On a ₹60 lakh deal, even a conservative 5% saving is ₹3 lakh — versus an advisory fee in the ₹5,000–₹15,000 range.
                </div>
            </div>

            <div class="pa-faq-item pa-rv" style="--rd:.24s">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>How long does the advisory process take?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    It depends on the service. A free initial consultation takes 30 minutes. A specific advisory like builder evaluation or market analysis takes 2–4 days. End-to-end advisory — from property search to registration — typically takes 4–12 weeks depending on how quickly you want to move and the complexity of the transaction. Verification reports are delivered as detailed PDFs within 48 hours.
                </div>
            </div>

            <div class="pa-faq-item pa-rv" style="--rd:.28s">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>Do you take any commission from builders or sellers?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    No. Zero commission, no kickbacks, no referral fees, no sponsored placements. Our entire revenue comes from transparent flat fees paid by the buyer for advisory and verification services. This is structurally different from a brokerage — and it is the reason we can give you genuinely unbiased advice. If a builder offered us a commission to recommend their project, we would lose every future client who later checked our credibility. Our business depends on staying honest.
                </div>
            </div>

            <div class="pa-faq-item pa-rv" style="--rd:.32s">
                <button class="pa-faq-q" onclick="paToggleFaq(this)">
                    <span>What documents should I ask the seller for before paying any token money?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="pa-faq-a">
                    Before any token money, ask for: original sale deed (current and previous 2–3 transactions to trace the title chain), latest Khatauni / Khasra extract for plots, Section 80 conversion certificate if it's a non-agricultural plot, encumbrance certificate (EC) from the sub-registrar showing no liens, RERA registration details for any apartment or new project, and the seller's identity proof matching the registry name. For LDA properties, also ask for the original allotment letter and possession letter. Our verification service compiles and checks all of this for ₹5,000 with a 48-hour PDF deliverable.
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     INTERNAL LINKS — Blog
══════════════════════════════════════ -->
<section class="pa-section" style="background:var(--bg-primary,#fff); padding-top:0;">
    <div class="pa-container">
        <span class="pa-slabel pa-rv">Learn More</span>
        <h2 class="pa-stitle pa-rv">In-Depth Locality Guides — Know Before You Buy</h2>
        <p class="pa-ssub pa-rv">Our data-driven locality guides give you honest price data, investment potential, and risks for Lucknow's top areas — read these before you speak to any agent.</p>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:16px;">
            <a href="/blog/plots-sultanpur-road-lucknow-2026" class="pa-blog-link pa-rv" style="--rd:.04s">
                <div class="pa-blog-link__tag">Sultanpur Road</div>
                <div class="pa-blog-link__title">Plots on Sultanpur Road Lucknow 2026 — Zone-Wise Price Guide &amp; Wellness City Impact</div>
                <div class="pa-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/anant-nagar-yojana-lucknow-lda-2026" class="pa-blog-link pa-rv" style="--rd:.08s">
                <div class="pa-blog-link__tag">LDA Anant Nagar</div>
                <div class="pa-blog-link__title">Anant Nagar Yojana Lucknow 2026 — LDA's 785-Acre Mega Township Phase 4 Open</div>
                <div class="pa-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/transforming-agricultural-land-residential-property-lucknow" class="pa-blog-link pa-rv" style="--rd:.12s">
                <div class="pa-blog-link__tag">Section 80 Conversion</div>
                <div class="pa-blog-link__title">Land Conversion in Lucknow — Section 80 vs 143 &amp; the 2026 Ordinance</div>
                <div class="pa-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/stamp-duty-registration-charges-lucknow-2026" class="pa-blog-link pa-rv" style="--rd:.16s">
                <div class="pa-blog-link__tag">Stamp Duty 2026</div>
                <div class="pa-blog-link__title">Stamp Duty &amp; Registry Charges in Lucknow 2026 — Complete Guide with Worked Examples</div>
                <div class="pa-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/mohanlalganj-plot-lucknow-2026" class="pa-blog-link pa-rv" style="--rd:.20s">
                <div class="pa-blog-link__tag">Mohanlalganj</div>
                <div class="pa-blog-link__title">Mohanlalganj Lucknow — Affordable Plots, Prices &amp; Investment Guide 2026</div>
                <div class="pa-blog-link__arrow">Read Guide →</div>
            </a>
            <a href="/blog/it-city-lucknow-lda-plots-guide-2026" class="pa-blog-link pa-rv" style="--rd:.24s">
                <div class="pa-blog-link__tag">LDA IT City</div>
                <div class="pa-blog-link__title">LDA IT City Lucknow 2026 — Plots, Price &amp; Lottery Guide</div>
                <div class="pa-blog-link__arrow">Read Guide →</div>
            </a>
        </div>
    </div>
</section>


{{-- ═══════════ GOOGLE REVIEWS ═══════════ --}}
@include('components.google-reviews', ['googleReviews' => $googleReviews ?? collect()])

<!-- ══════════════════════════════════════
     FINAL CTA
══════════════════════════════════════ -->
<section class="pa-cta">
    <div class="pa-cta__orb"></div>
    <div class="pa-container pa-cta__inner">
        <h2 class="pa-rv">Ready to Make a Smarter Property Decision?</h2>
        <p class="pa-rv" style="--rd:.08s">
            Book a <strong>FREE 30-minute consultation</strong>. We'll discuss your requirements with zero obligation to proceed.
        </p>
        <div class="pa-cta__btns pa-rv" style="--rd:.16s">
            <a href="{{ route('contact-us') }}" class="pa-btn pa-btn--primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Book Free Consultation
            </a>
            <a href="https://wa.me/918595002933?text=Hi, I need property advisory services in Lucknow" class="pa-btn pa-btn--ghost">
                💬 WhatsApp: 8595002933
            </a>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════
     MOBILE STICKY CTA
══════════════════════════════════════ -->
<div class="pa-mobile-cta" id="pa-mobile-cta" style="display:none;">
    <a href="{{ route('contact-us') }}">📅 Book Free Consultation</a>
</div>

</div><!-- /pa-wrap -->

<script>
(function () {
    /* ── FAQ toggle ── */
    window.paToggleFaq = function(btn) {
        var isOpen = btn.classList.contains('open');
        document.querySelectorAll('.pa-faq-q.open').forEach(function(b) {
            b.classList.remove('open');
            b.nextElementSibling.classList.remove('open');
        });
        if (!isOpen) {
            btn.classList.add('open');
            btn.nextElementSibling.classList.add('open');
        }
    };

    /* ── Scroll reveal via IntersectionObserver ── */
    var rv = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                rv.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });

    document.querySelectorAll('.pa-rv').forEach(function(el) { rv.observe(el); });

    /* ── Mobile sticky CTA ── */
    var mobileCta = document.getElementById('pa-mobile-cta');
    window.addEventListener('scroll', function() {
        if (!mobileCta) return;
        if (window.innerWidth < 1024 && window.scrollY > 500) {
            mobileCta.style.display = 'block';
        } else {
            mobileCta.style.display = 'none';
        }
    }, { passive: true });
})();
</script>

@endsection