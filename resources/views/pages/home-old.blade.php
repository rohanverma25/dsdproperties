@extends('layouts.user-app')
@section('title', 'DSD Properties — AI Property Valuation for Lucknow')
@section('meta_description', 'Get an honest, data-driven estimate of any property in Lucknow. Free. No agents. No bias. Built on real listing data.')

@section('content')
@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "DSD Properties",
  "image": "https://dsdproperties.in/public/images/logo.webp",
  "description": "Honest data-driven property intelligence for Lucknow buyers. AI Property Valuation, Legal Verification, and Expert Advisory.",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "226025",
    "addressCountry": "IN"
  },
  "telephone": "+91-8595002933",
  "url": "https://dsdproperties.in",
  "email": "dheer@dsdproperties.in",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5.0",
    "bestRating": "5",
    "worstRating": "4",
    "ratingCount": "22"
  },
  "sameAs": [
    "https://www.google.com/maps/place/DSD+Properties/@26.819812,80.7865536",
    "https://wa.me/918595002933"
  ]
}
</script>
@endpush
{{-- ====================================================
     STYLES
==================================================== --}}
<style>
:root {
    --hp-navy:#011f4b; --hp-teal:#008080; --hp-orange:#FF5C00;
    --hp-bg:var(--bg-primary,#fff); --hp-bg2:var(--bg-secondary,#f3f4f6);
    --hp-card:var(--card-bg,#fff); --hp-border:var(--border-color,#e5e7eb);
    --hp-t1:var(--text-primary,#111827); --hp-t2:var(--text-secondary,#4b5563);
    --hp-t3:var(--text-tertiary,#9ca3af); --hp-teal-bg:var(--color-light-teal,#e0f2f1);
}
.hp{font-family:'Poppins',sans-serif;overflow-x:hidden}
.hp-c{max-width:1100px;margin:0 auto;padding:0 24px}
.hp-section{padding:88px 0}

/* animations */
@keyframes hp-up{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:none}}
@keyframes hp-from-right{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:none}}
@keyframes hp-float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
@keyframes hp-pulse-dot{0%,100%{box-shadow:0 0 0 3px rgba(74,222,128,.3)}50%{box-shadow:0 0 0 7px rgba(74,222,128,.08)}}
@keyframes hp-bar-in{from{width:0}}

.hp-a{opacity:0;animation:hp-up .6s ease forwards;animation-delay:var(--d,0s)}
.hp-rv{opacity:0;transform:translateY(22px);transition:opacity .6s ease,transform .6s ease;transition-delay:var(--rd,0s)}
.hp-rv.visible{opacity:1;transform:none}

.hp-pulse-dot{width:8px;height:8px;border-radius:50%;background:#4ade80;flex-shrink:0;animation:hp-pulse-dot 2.5s infinite;display:inline-block}

/* buttons */
.hp-btn{display:inline-flex;align-items:center;gap:8px;font-family:'Poppins',sans-serif;font-weight:600;border-radius:11px;text-decoration:none;cursor:pointer;transition:all .22s;border:none;padding:12px 24px;font-size:.88rem}
.hp-btn--primary{background:linear-gradient(135deg,#FF5C00,#ff8840);color:#fff;box-shadow:0 5px 20px rgba(255,92,0,.3)}
.hp-btn--primary:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(255,92,0,.42);color:#fff;text-decoration:none}
.hp-btn--ghost{background:rgba(255,255,255,.1);color:rgba(255,255,255,.85);border:1px solid rgba(255,255,255,.22)}
.hp-btn--ghost:hover{background:rgba(255,255,255,.18);color:#fff;text-decoration:none}
.hp-btn--outline{background:transparent;color:var(--hp-teal);border:2px solid var(--hp-teal)}
.hp-btn--outline:hover{background:var(--hp-teal);color:#fff;text-decoration:none}
.hp-btn--lg{padding:15px 34px;font-size:.96rem;border-radius:13px}

/* section labels */
.hp-slabel{font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--hp-teal);margin-bottom:10px;text-align:center}
.hp-stitle{font-size:clamp(1.6rem,3.2vw,2.4rem);font-weight:800;color:var(--hp-t1);line-height:1.15;text-align:center;margin-bottom:12px}
.hp-ssub{font-size:.92rem;color:var(--hp-t2);text-align:center;max-width:570px;margin:0 auto 52px;line-height:1.75}

/* ── HERO ── */
.hp-hero{position:relative;overflow:hidden;min-height:100vh;background:linear-gradient(135deg,#011f4b 0%,#013870 45%,#005f6b 100%);display:flex;align-items:center}
.hp-hero__grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:50px 50px}
.hp-hero__orb{position:absolute;border-radius:50%;filter:blur(90px);pointer-events:none}
.hp-hero__orb--a{width:560px;height:560px;background:rgba(0,128,128,.25);top:-140px;right:-100px;animation:hp-float 9s ease-in-out infinite}
.hp-hero__orb--b{width:380px;height:380px;background:rgba(255,92,0,.14);bottom:-80px;left:-60px;animation:hp-float 11s ease-in-out infinite 3s}

.hp-hero__body{position:relative;z-index:2;display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center;padding-top:50px;padding-bottom:72px}
@media(max-width:860px){.hp-hero__body{grid-template-columns:1fr;gap:40px}}

.hp-hero__badge{display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);border-radius:99px;padding:7px 16px;margin-bottom:22px;font-size:11px;font-weight:500;color:rgba(255,255,255,.82);backdrop-filter:blur(8px)}
.hp-hero__h1{font-size:clamp(1.9rem,4.2vw,3.2rem);font-weight:800;color:#fff;line-height:1.13;margin-bottom:20px;letter-spacing:-.4px}
.hp-hero__h1 em{font-style:normal;color:#FF5C00}
.hp-hero__sub{font-size:.95rem;color:rgba(255,255,255,.7);line-height:1.82;margin-bottom:18px;max-width:480px}

.hp-hero__disclaimer{display:flex;align-items:flex-start;gap:9px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.15);border-radius:10px;padding:12px 14px;margin-bottom:28px;font-size:.78rem;color:rgba(255,255,255,.65);line-height:1.55;max-width:480px}
.hp-hero__disclaimer i{color:#fbbf24;flex-shrink:0;margin-top:2px}

.hp-hero__cta{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px}
.hp-hero__tags{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:28px}
.hp-hero__tags>span{font-size:11px;color:rgba(255,255,255,.4)}
.hp-tag{padding:5px 13px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);border-radius:99px;color:rgba(255,255,255,.78);font-size:11px;font-family:'Poppins',sans-serif;cursor:pointer;transition:background .2s}
.hp-tag:hover{background:rgba(255,255,255,.2)}

.hp-hero__pills{display:flex;flex-wrap:wrap;gap:8px}
.hp-pill{display:flex;align-items:center;gap:6px;padding:5px 12px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.14);border-radius:8px;font-size:11px;color:rgba(255,255,255,.6)}
.hp-pill i{font-size:10px;color:rgba(255,255,255,.45)}

/* hero card */
.hp-hero__right{position:relative}
.hp-hero__card{background:var(--hp-card);border-radius:20px;padding:22px;box-shadow:0 28px 72px rgba(0,0,0,.22);border:1px solid rgba(255,255,255,.07)}
.hp-hero__card-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
.hp-hero__card-live{display:flex;align-items:center;gap:7px;font-size:11px;font-weight:600;color:var(--hp-t2)}
.hp-hero__card-beta{font-size:10px;font-weight:700;letter-spacing:.5px;background:rgba(255,92,0,.1);color:#FF5C00;padding:3px 9px;border-radius:5px;border:1px solid rgba(255,92,0,.25)}
.hp-hero__card-locality{font-size:.95rem;font-weight:700;color:var(--hp-t1)}
.hp-hero__card-type{font-size:.75rem;color:var(--hp-t3);margin-bottom:16px}
.hp-hero__card-price-row{margin-bottom:18px;padding-bottom:16px;border-bottom:1px solid var(--hp-border)}
.hp-hero__card-plabel{font-size:.68rem;text-transform:uppercase;letter-spacing:.5px;color:var(--hp-t3);margin-bottom:4px}
.hp-hero__card-price{font-size:1.25rem;font-weight:800;color:var(--hp-teal);margin-bottom:3px}
.hp-hero__card-psub{font-size:.7rem;color:var(--hp-t3)}
.hp-hero__card-factors{display:flex;flex-direction:column;gap:9px;margin-bottom:16px}
.hp-hero__card-factor{display:flex;align-items:center;gap:9px;font-size:.74rem;color:var(--hp-t2)}
.hp-hero__card-factor span{width:110px;flex-shrink:0}
.hp-bar{flex:1;height:5px;background:var(--hp-bg2);border-radius:99px;overflow:hidden}
.hp-bar div{height:100%;background:linear-gradient(90deg,var(--hp-teal),#2eb8b8);border-radius:99px;animation:hp-bar-in 1.2s ease forwards}
.hp-hero__card-factor b{font-size:.74rem;color:var(--hp-t1);width:44px;text-align:right;flex-shrink:0}
.hp-hero__card-notice{font-size:.7rem;color:var(--hp-t3);line-height:1.55;display:flex;align-items:flex-start;gap:7px;background:var(--hp-bg2);padding:10px 12px;border-radius:8px}
.hp-hero__card-notice i{color:#d97706;flex-shrink:0;margin-top:2px}

.hp-fbadge{position:absolute;background:var(--hp-card);border:1px solid var(--hp-border);border-radius:11px;padding:9px 13px;display:flex;align-items:center;gap:9px;box-shadow:0 6px 20px rgba(0,0,0,.1);font-size:.78rem}
.hp-fbadge i{font-size:15px}
.hp-fbadge div strong{display:block;font-weight:700;color:var(--hp-t1);font-size:.78rem}
.hp-fbadge div span{font-size:.68rem;color:var(--hp-t3)}
.hp-fbadge--tl{top:-16px;left:-16px;animation:hp-float 7s ease-in-out infinite}
.hp-fbadge--br{bottom:-16px;right:-8px;animation:hp-float 9s ease-in-out infinite 2s}
@media(max-width:600px){.hp-fbadge{display:none}}

.hp-hero__wave{position:absolute;bottom:0;left:0;right:0;line-height:0}
.hp-hero__wave svg{width:100%;height:56px;display:block}

/* ── TRUST ── */
.hp-trust{background:var(--hp-card);border-bottom:1px solid var(--hp-border);padding:18px 0;display:block!important;opacity:1!important;transform:none!important}
.hp-trust__inner{display:flex;align-items:center;gap:20px;flex-wrap:wrap;justify-content:center}
.hp-trust__label{font-size:11px;text-transform:uppercase;letter-spacing:2px;color:var(--hp-t3)}
.hp-trust__items{display:flex;align-items:center;gap:10px;flex-wrap:wrap;justify-content:center}
.hp-trust__item{display:flex;align-items:center;gap:7px;font-size:.8rem;font-weight:500;color:var(--hp-t2)}
.hp-trust__item i{color:var(--hp-teal);font-size:.8rem}
.hp-trust__sep{width:1px;height:16px;background:var(--hp-border)}

/* ── COMPARE ── */
.hp-compare{background:var(--hp-bg)}
.hp-compare__grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:820px;margin:0 auto}
@media(max-width:620px){.hp-compare__grid{grid-template-columns:1fr}}
.hp-compare__card{border-radius:18px;padding:28px;border:2px solid;background:var(--hp-card)}
.hp-compare__card--bad{border-color:rgba(220,38,38,.2)}
.hp-compare__card--good{border-color:rgba(22,163,74,.2)}
.hp-compare__head{display:flex;align-items:center;gap:12px;margin-bottom:22px}
.hp-compare__ico{width:36px;height:36px;border-radius:99px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.hp-compare__ico--bad{background:rgba(220,38,38,.1);color:#dc2626}
.hp-compare__ico--good{background:rgba(22,163,74,.1);color:#16a34a}
.hp-compare__head h3{font-size:1rem;font-weight:700;color:var(--hp-t1);margin:0}
.hp-compare__card ul{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px}
.hp-compare__card li{display:flex;align-items:flex-start;gap:10px;font-size:.85rem;color:var(--hp-t2);line-height:1.5}
.hp-compare__card--bad  li i{color:#dc2626;flex-shrink:0;margin-top:2px}
.hp-compare__card--good li i{color:#16a34a;flex-shrink:0;margin-top:2px}

/* ── FEATURES ── */
.hp-feats__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
@media(max-width:820px){.hp-feats__grid{grid-template-columns:1fr 1fr}}
@media(max-width:520px){.hp-feats__grid{grid-template-columns:1fr}}
.hp-feat{background:var(--hp-card);border:1px solid var(--hp-border);border-radius:16px;padding:26px 22px;transition:transform .25s,box-shadow .25s,border-color .25s;position:relative;overflow:hidden}
.hp-feat::before{content:'';position:absolute;top:0;left:0;width:3px;height:0;background:linear-gradient(to bottom,var(--hp-teal),var(--hp-orange));transition:height .3s}
.hp-feat:hover::before{height:100%}
.hp-feat:hover{transform:translateY(-4px);box-shadow:0 14px 40px rgba(0,0,0,.08);border-color:rgba(0,128,128,.2)}
.hp-feat__ico{width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:14px;transition:transform .25s}
.hp-feat:hover .hp-feat__ico{transform:scale(1.1) rotate(-5deg)}
.hp-feat h3{font-size:.9rem;font-weight:700;color:var(--hp-t1);margin-bottom:7px}
.hp-feat p{font-size:.8rem;color:var(--hp-t2);line-height:1.68;margin:0}

/* ── HOW IT WORKS ── */
.hp-hiw{background:var(--hp-bg)}
.hp-hiw__steps{display:grid!important;grid-template-columns:1fr auto 1fr auto 1fr;align-items:center;gap:10px;max-width:880px;margin:0 auto 44px;width:100%}
@media(max-width:680px){.hp-hiw__steps{grid-template-columns:1fr;gap:16px}.hp-hiw__arrow{display:none}}
.hp-hiw__step{background:var(--hp-card);border:1px solid var(--hp-border);border-radius:16px;padding:26px 20px;text-align:center;transition:transform .25s,box-shadow .25s}
.hp-hiw__step:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(0,0,0,.07)}
.hp-hiw__num{width:48px;height:48px;border-radius:50%;margin:0 auto 14px;background:linear-gradient(135deg,var(--hp-navy),var(--hp-teal));color:#fff;font-weight:800;font-size:1rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(0,128,128,.28)}
.hp-hiw__step h3{font-size:.9rem;font-weight:700;color:var(--hp-t1);margin-bottom:7px}
.hp-hiw__step p{font-size:.78rem;color:var(--hp-t2);line-height:1.62;margin:0}
.hp-hiw__arrow{font-size:1.3rem;color:var(--hp-t3);text-align:center}
.hp-hiw__cta{text-align:center}

/* ── TABLE ── */
.hp-table-sec{background:var(--hp-bg)}
.hp-tbl-controls{display:flex;gap:14px;flex-wrap:wrap;align-items:center;margin-bottom:20px}
.hp-tbl-search{position:relative;flex:1;min-width:220px}
.hp-tbl-search i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--hp-t3);font-size:.85rem}
.hp-tbl-search input{width:100%;padding:10px 14px 10px 38px;border-radius:10px;border:1.5px solid var(--hp-border);background:var(--hp-card);font-family:'Poppins',sans-serif;font-size:.85rem;color:var(--hp-t1);transition:border-color .2s}
.hp-tbl-search input:focus{outline:none;border-color:var(--hp-teal)}

.hp-tbl-filters{display:flex;gap:6px;flex-wrap:wrap}
.hp-tbl-filter{padding:7px 14px;border-radius:99px;border:1.5px solid var(--hp-border);background:var(--hp-card);color:var(--hp-t2);font-family:'Poppins',sans-serif;font-size:.75rem;font-weight:600;cursor:pointer;transition:all .2s}
.hp-tbl-filter:hover{border-color:var(--hp-teal);color:var(--hp-teal)}
.hp-tbl-filter.active{background:var(--hp-teal);border-color:var(--hp-teal);color:#fff}

.hp-tbl-wrap{background:var(--hp-card);border:1px solid var(--hp-border);border-radius:18px;overflow:hidden;box-shadow:0 6px 32px rgba(0,0,0,.06)}
.hp-tbl-meta{display:flex;justify-content:space-between;align-items:center;padding:14px 20px;border-bottom:1px solid var(--hp-border);font-size:.78rem}
#tblCount{color:var(--hp-t2);font-weight:600}
.hp-tbl-updated{color:var(--hp-t3);display:flex;align-items:center;gap:5px}
.hp-tbl-scroll{overflow-x:auto}

.hp-tbl{width:100%;border-collapse:collapse;font-size:.84rem}
.hp-tbl thead tr{background:var(--hp-bg2)}
.hp-th-sort{padding:12px 18px;text-align:left;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--hp-t2);white-space:nowrap;cursor:pointer;user-select:none;transition:background .2s}
.hp-th-sort:hover{background:rgba(0,128,128,.06);color:var(--hp-teal)}
.hp-th-sort.asc .hp-sort-icon::after{content:'↑';color:var(--hp-teal)}
.hp-th-sort.desc .hp-sort-icon::after{content:'↓';color:var(--hp-teal)}
.hp-sort-icon{margin-left:4px;color:var(--hp-t3);font-style:normal;font-size:.75rem}
.hp-th-sort.asc .hp-sort-icon, .hp-th-sort.desc .hp-sort-icon{color:var(--hp-teal)}

.hp-tbl-more-wrap{text-align:center;padding:18px 0 4px}
.hp-tbl-more{display:inline-flex;align-items:center;gap:8px;padding:10px 28px;background:none;border:2px solid var(--hp-teal);border-radius:99px;font-family:'Poppins',sans-serif;font-size:.82rem;font-weight:600;color:var(--hp-teal);cursor:pointer;transition:background .2s,color .2s}
.hp-tbl-more:hover{background:var(--hp-teal);color:#fff}
.hp-tbl-more[style*="none"]{display:none!important}
.hp-tbl-row{border-top:1px solid var(--hp-border);transition:background .15s}
.hp-tbl-row:hover{background:var(--hp-bg2)}
.hp-tbl td{padding:13px 18px;vertical-align:middle}

.hp-td-num{font-size:.72rem;color:var(--hp-t3);font-weight:600;width:32px}
.hp-td-name{font-weight:600;color:var(--hp-t1);font-size:.86rem}
.hp-td-area{font-size:.78rem;color:var(--hp-t3)}
.hp-td-price{font-family:'Courier New',monospace;font-weight:700;color:var(--hp-t1);font-size:.83rem;white-space:nowrap}

.hp-seg-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:99px;font-size:.72rem;font-weight:700;white-space:nowrap}
.hp-seg-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
.hp-quality-badge{display:inline-flex;align-items:center;gap:6px;font-size:.75rem;font-weight:600}
.hp-quality-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}

.hp-tbl-empty{text-align:center;padding:48px 24px;color:var(--hp-t3)}
.hp-tbl-empty i{font-size:2rem;margin-bottom:12px;display:block;opacity:.4}
.hp-tbl-empty p{font-size:.88rem;margin:0}
.hp-tbl-footer{padding:14px 20px;background:var(--hp-bg2);border-top:1px solid var(--hp-border);font-size:.74rem;color:var(--hp-t3);line-height:1.6}
.hp-tbl-footer a{color:var(--hp-teal)}

@media(max-width:600px){.hp-hide-sm{display:none}}

/* ── METHODOLOGY ── */
.hp-meth__steps{display:grid!important;grid-template-columns:1fr auto 1fr auto 1fr;align-items:center;gap:10px;max-width:820px;margin:0 auto 24px;width:100%}
@media(max-width:640px){.hp-meth__steps{grid-template-columns:1fr;gap:14px}.hp-meth__arrow{display:none}}
.hp-meth__step{background:var(--hp-card);border:1px solid var(--hp-border);border-radius:14px;padding:22px 18px;text-align:center;position:relative}
.hp-meth__ico{width:40px;height:40px;border-radius:99px;background:var(--hp-teal-bg);color:var(--hp-teal);display:flex;align-items:center;justify-content:center;font-size:16px;margin:0 auto 10px}
.hp-meth__n{position:absolute;top:-9px;left:50%;transform:translateX(-50%);background:var(--hp-teal);color:#fff;width:20px;height:20px;border-radius:50%;font-size:.65rem;font-weight:700;display:flex;align-items:center;justify-content:center}
.hp-meth__step h4{font-size:.85rem;font-weight:700;color:var(--hp-t1);margin-bottom:5px}
.hp-meth__step p{font-size:.77rem;color:var(--hp-t2);line-height:1.6;margin:0}
.hp-meth__arrow{font-size:1.2rem;color:var(--hp-t3);text-align:center}
.hp-meth__note{display:flex;align-items:flex-start;gap:12px;background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.3);border-radius:12px;padding:16px 20px;max-width:700px;margin:0 auto 28px;font-size:.82rem;color:var(--hp-t2);line-height:1.65}
.hp-meth__note i{color:#d97706;flex-shrink:0;margin-top:2px}
.hp-meth__note p{margin:0}
.hp-meth__cta{text-align:center}

/* ── FAQ ── */
.hp-faq{background:var(--hp-bg2)}
.hp-faq__list{max-width:700px;margin:0 auto;display:flex;flex-direction:column;gap:10px}
.hp-faq__item{background:var(--hp-card);border:1px solid var(--hp-border);border-radius:13px;overflow:hidden}
.hp-faq__q{width:100%;display:flex;justify-content:space-between;align-items:center;padding:16px 20px;background:none;border:none;font-family:'Poppins',sans-serif;font-size:.88rem;font-weight:600;color:var(--hp-t1);cursor:pointer;text-align:left;gap:12px;transition:background .2s}
.hp-faq__q:hover{background:var(--hp-bg2)}
.hp-faq__q i{color:var(--hp-teal);flex-shrink:0;transition:transform .3s;font-size:.78rem}
.hp-faq__q.open i{transform:rotate(180deg)}
.hp-faq__a{padding:0 20px;max-height:0;overflow:hidden;font-size:.83rem;color:var(--hp-t2);line-height:1.75;transition:max-height .35s ease,padding .35s ease}
.hp-faq__a.open{max-height:220px;padding:0 20px 16px}

@media(max-width:860px){.hp-section{padding:64px 0}}
@media(max-width:480px){.hp-hero__cta{flex-direction:column}}
</style>
<div class="hp">

{{-- ====================================================
     HERO
==================================================== --}}
<section class="hp-hero">
    <div class="hp-hero__grid"></div>
    <div class="hp-hero__orb hp-hero__orb--a"></div>
    <div class="hp-hero__orb hp-hero__orb--b"></div>

    <div class="hp-c hp-hero__body">

        {{-- Left --}}
        <div class="hp-hero__left">

            <div class="hp-hero__badge hp-a" style="--d:0s">
                <span class="hp-pulse-dot"></span>
                Currently in Beta · Lucknow Real Estate Intelligence
            </div>

            <h1 class="hp-hero__h1 hp-a" style="--d:.1s">
                Find Out What Any<br>
                Property in Lucknow<br>
                <em>Is Actually Worth</em>
            </h1>

            <p class="hp-hero__sub hp-a" style="--d:.2s">
                We built DSD Properties because property buyers in Lucknow deserve honest data —
                not inflated agent quotes. Enter your property details and get a free, data-driven
                price estimate in seconds.
            </p>

            <div class="hp-hero__disclaimer hp-a" style="--d:.25s">
                <i class="fas fa-info-circle"></i>
                We're currently in beta. Our estimates are based on real listing data from Lucknow —
                not AI guesses. We'll be transparent about what we know and what we don't.
            </div>

            <div class="hp-hero__cta hp-a" style="--d:.3s">
                <button onclick="ValuationComponent.open()" class="hp-btn hp-btn--primary">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    Get Free Property Estimate
                </button>
                <a href="/how-property-prices-are-calculated-in-lucknow" class="hp-btn hp-btn--ghost">See How It Works →</a>
            </div>

            <!-- <div class="hp-hero__tags hp-a" style="--d:.38s">
                <span>Popular:</span>
                <button onclick="ValuationComponent.open()" class="hp-tag">Gomti Nagar</button>
                <button onclick="ValuationComponent.open()" class="hp-tag">Hazratganj</button>
                <button onclick="ValuationComponent.open()" class="hp-tag">Aliganj</button>
                <button onclick="ValuationComponent.open()" class="hp-tag">Shaheed Path</button>
            </div> -->

            <div class="hp-hero__pills hp-a" style="--d:.46s">
                <div class="hp-pill"><i class="fas fa-map-marker-alt"></i> 50+ Localities</div>
                <div class="hp-pill"><i class="fas fa-user-slash"></i> Zero Agent Bias</div>
                <div class="hp-pill"><i class="fas fa-lock-open"></i> 100% Free</div>
                <div class="hp-pill"><i class="fas fa-flask"></i> Beta Stage</div>
            </div>
        </div>

        {{-- Right — valuation card --}}
        <div class="hp-hero__right hp-a" style="--d:.2s;animation-name:hp-from-right">
            <div class="hp-hero__card">
                <div class="hp-hero__card-top">
                    <div class="hp-hero__card-live">
                        <span class="hp-pulse-dot"></span> Sample Estimate
                    </div>
                    <span class="hp-hero__card-beta">BETA</span>
                </div>

                <div class="hp-hero__card-locality">Vibhuti Khand, Lucknow</div>
                <div class="hp-hero__card-type">3BHK Flat · ~1,200 sqft</div>

                <div class="hp-hero__card-price-row">
                    <div>
                        <div class="hp-hero__card-plabel">Estimated Price Band</div>
                        <div class="hp-hero__card-price">₹96L – ₹1.32 Cr</div>
                        <div class="hp-hero__card-psub">Based on ₹8,000–11,000/sqft market data</div>
                    </div>
                </div>

                <div class="hp-hero__card-factors">
                    <div class="hp-hero__card-factor">
                        <span>Avg. Listing Rate</span>
                        <div class="hp-bar"><div style="width:82%"></div></div>
                        <b>₹9.5k</b>
                    </div>
                    <div class="hp-hero__card-factor">
                        <span>Data Coverage</span>
                        <div class="hp-bar"><div style="width:68%"></div></div>
                        <b>Good</b>
                    </div>
                    <div class="hp-hero__card-factor">
                        <span>Locality Segment</span>
                        <div class="hp-bar" style="background:rgba(124,58,237,.1)"><div style="width:92%;background:linear-gradient(90deg,#7c3aed,#a855f7)"></div></div>
                        <b>Premium</b>
                    </div>
                </div>

                <div class="hp-hero__card-notice">
                    <i class="fas fa-exclamation-circle"></i>
                    This is a data-based estimate, not a certified appraisal. Actual price depends on property condition, floor, negotiation, and market timing.
                </div>
            </div>

            <div class="hp-fbadge hp-fbadge--tl">
                <i class="fas fa-database" style="color:#008080"></i>
                <div><strong>Real Data</strong><span>Listing-based</span></div>
            </div>
            <div class="hp-fbadge hp-fbadge--br">
                <i class="fas fa-hand-holding-usd" style="color:#16a34a"></i>
                <div><strong>Free Forever</strong><span>No hidden cost</span></div>
            </div>
        </div>

    </div>

    <div class="hp-hero__wave">
        <svg viewBox="0 0 1440 56" preserveAspectRatio="none"><path d="M0,28 C480,56 960,0 1440,28 L1440,56 L0,56 Z" fill="var(--hp-bg)"/></svg>
    </div>
</section>

{{-- ====================================================
     TRUST BAR
==================================================== --}}
<section class="hp-trust">
    <div class="hp-c hp-trust__inner">
        <span class="hp-trust__label">What we stand for</span>
        <div class="hp-trust__items">
            <div class="hp-trust__item"><i class="fas fa-map-marker-alt"></i> 50+ Lucknow Localities</div>
            <div class="hp-trust__sep"></div>
            <div class="hp-trust__item"><i class="fas fa-database"></i> Real Listing Data</div>
            <div class="hp-trust__sep"></div>
            <div class="hp-trust__item"><i class="fas fa-user-slash"></i> No Agent Influence</div>
            <div class="hp-trust__sep"></div>
            <div class="hp-trust__item"><i class="fas fa-flask"></i> Honest Beta Product</div>
        </div>
    </div>
</section>

{{-- ====================================================
     PROBLEM vs SOLUTION
==================================================== --}}
<section class="hp-section hp-compare">
    <div class="hp-c">
        <div class="hp-slabel hp-rv">Why We Built This</div>
        <h2 class="hp-stitle hp-rv">The Problem With Property<br>Pricing in Lucknow</h2>
        <p class="hp-ssub hp-rv">Most people overpay — not because they're careless, but because they had no honest reference point.</p>

        <div class="hp-compare__grid hp-rv">
            <div class="hp-compare__card hp-compare__card--bad">
                <div class="hp-compare__head">
                    <div class="hp-compare__ico hp-compare__ico--bad"><i class="fas fa-times"></i></div>
                    <h3>The Old Way</h3>
                </div>
                <ul>
                    <li><i class="fas fa-times-circle"></i> Ask an agent — who earns more if price is higher</li>
                    <li><i class="fas fa-times-circle"></i> Check portals — with inflated, months-old listings</li>
                    <li><i class="fas fa-times-circle"></i> Pay ₹5,000–20,000 for a formal appraisal</li>
                    <li><i class="fas fa-times-circle"></i> Wait days for a response, then guess anyway</li>
                    <li><i class="fas fa-times-circle"></i> End up overpaying without realising it</li>
                </ul>
            </div>
            <div class="hp-compare__card hp-compare__card--good">
                <div class="hp-compare__head">
                    <div class="hp-compare__ico hp-compare__ico--good"><i class="fas fa-check"></i></div>
                    <h3>The DSD Way</h3>
                </div>
                <ul>
                    <li><i class="fas fa-check-circle"></i> Real listing data — no agent in the loop</li>
                    <li><i class="fas fa-check-circle"></i> Transparent price bands, not single guesses</li>
                    <li><i class="fas fa-check-circle"></i> Free — no fees, no registration required</li>
                    <li><i class="fas fa-check-circle"></i> Instant estimate in seconds</li>
                    <li><i class="fas fa-check-circle"></i> Honest about what we know and don't know</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ====================================================
     FEATURES
==================================================== --}}
<section class="hp-section hp-feats" style="background:var(--hp-bg2)">
    <div class="hp-c">
        <div class="hp-slabel hp-rv">What We Offer</div>
        <h2 class="hp-stitle hp-rv">Built for Lucknow Property Buyers</h2>
        <p class="hp-ssub hp-rv">We focus on one city, done properly — rather than a generic tool that works nowhere well.</p>

        <div class="hp-feats__grid">
            <div class="hp-feat hp-rv">
                <div class="hp-feat__ico" style="background:rgba(0,128,128,.1);color:#008080"><i class="fas fa-map-marked-alt"></i></div>
                <h3>Hyperlocal Coverage</h3>
                <p>50+ Lucknow localities mapped with real price bands — from Hazratganj to Malihabad.</p>
            </div>
            <div class="hp-feat hp-rv" style="--rd:.08s">
                <div class="hp-feat__ico" style="background:rgba(255,92,0,.1);color:#FF5C00"><i class="fas fa-search-dollar"></i></div>
                <h3>Price Band Estimates</h3>
                <p>We show a realistic min–max range based on actual listings — not a single misleading number.</p>
            </div>
            <div class="hp-feat hp-rv" style="--rd:.16s">
                <div class="hp-feat__ico" style="background:rgba(37,99,235,.1);color:#2563eb"><i class="fas fa-layer-group"></i></div>
                <h3>Segment Intelligence</h3>
                <p>Every locality is classified by segment — Premium, Upper Mid, Mid, Affordable, or Budget.</p>
            </div>
            <div class="hp-feat hp-rv" style="--rd:.04s">
                <div class="hp-feat__ico" style="background:rgba(22,163,74,.1);color:#16a34a"><i class="fas fa-bolt"></i></div>
                <h3>Instant &amp; Free</h3>
                <p>No forms, no fees, no agents. Enter your property details and get an estimate immediately.</p>
            </div>
            <div class="hp-feat hp-rv" style="--rd:.12s">
                <div class="hp-feat__ico" style="background:rgba(168,85,247,.1);color:#a855f7"><i class="fas fa-eye"></i></div>
                <h3>Full Transparency</h3>
                <p>We publish exactly how our estimates are made. No black box — see the full methodology.</p>
            </div>
            <div class="hp-feat hp-rv" style="--rd:.2s">
                <div class="hp-feat__ico" style="background:rgba(220,38,38,.1);color:#dc2626"><i class="fas fa-sync-alt"></i></div>
                <h3>Regularly Updated</h3>
                <p>Price data is reviewed and refreshed as the market changes — we flag when data is stale.</p>
            </div>
        </div>
    </div>
</section>

{{-- ====================================================
     HOW IT WORKS
==================================================== --}}
<section class="hp-section hp-hiw">
    <div class="hp-c">
        <div class="hp-slabel hp-rv">Simple Process</div>
        <h2 class="hp-stitle hp-rv">How to Get Your Estimate</h2>

        <div class="hp-hiw__steps">
            <div class="hp-hiw__step hp-rv">
                <div class="hp-hiw__num">01</div>
                <h3>Enter Property Details</h3>
                <p>Location, property type, and approximate size. Takes under a minute.</p>
            </div>
            <div class="hp-hiw__arrow hp-rv">→</div>
            <div class="hp-hiw__step hp-rv" style="--rd:.1s">
                <div class="hp-hiw__num">02</div>
                <h3>We Match Your Data</h3>
                <p>We match your property to our locality price bands and listing database.</p>
            </div>
            <div class="hp-hiw__arrow hp-rv" style="--rd:.1s">→</div>
            <div class="hp-hiw__step hp-rv" style="--rd:.2s">
                <div class="hp-hiw__num">03</div>
                <h3>Get Honest Estimate</h3>
                <p>You receive a price range with clear context on what it's based on — and its limits.</p>
            </div>
        </div>

        <div class="hp-hiw__cta hp-rv">
            <button onclick="ValuationComponent.open()" class="hp-btn hp-btn--primary hp-btn--lg">
                <i class="fas fa-home"></i> Check My Property Value
            </button>
        </div>
    </div>
</section>

{{-- ====================================================
     MAP
==================================================== --}}
<section class="hp-section hp-map-wrap" style="background:var(--hp-bg2);padding-bottom:0">
    <div class="hp-c">
        <div class="hp-slabel hp-rv">Interactive Map</div>
        <h2 class="hp-stitle hp-rv">Explore Lucknow Property Prices</h2>
        <p class="hp-ssub hp-rv">Browse price segments across 50+ localities. Click any dot to see the price band for that area.</p>
    </div>
    <x-price-map/>
</section>

{{-- ====================================================
     LOCALITY PRICE TABLE  (sortable + searchable)
==================================================== --}}
<section class="hp-section hp-table-sec">
    <div class="hp-c">
        <div class="hp-slabel hp-rv">Market Data</div>
        <h2 class="hp-stitle hp-rv">Lucknow Locality Price Directory</h2>
        <p class="hp-ssub hp-rv">50 localities. Real listing-based price bands. Updated regularly. Click any column header to sort.</p>

        {{-- Controls --}}
        <div class="hp-tbl-controls hp-rv">
            <div class="hp-tbl-search">
                <i class="fas fa-search"></i>
                <input type="text" id="tblSearch" placeholder="Search locality, area, segment…" autocomplete="off">
            </div>
            <div class="hp-tbl-filters" id="tblSegFilter">
                <button class="hp-tbl-filter active" data-seg="All">All</button>
                <button class="hp-tbl-filter" data-seg="Premium">🔴 Premium</button>
                <button class="hp-tbl-filter" data-seg="Upper Mid">🟠 Upper Mid</button>
                <button class="hp-tbl-filter" data-seg="Mid">🟢 Mid</button>
                <button class="hp-tbl-filter" data-seg="Affordable">🔵 Affordable</button>
                <button class="hp-tbl-filter" data-seg="Budget">⚫ Budget</button>
            </div>
        </div>

        <div class="hp-tbl-wrap hp-rv">
            <div class="hp-tbl-meta">
                <span id="tblCount">Showing 50 localities</span>
                <span class="hp-tbl-updated"><i class="fas fa-clock"></i> Updated: {{ date('F Y') }}</span>
            </div>

            <div class="hp-tbl-scroll">
                <table class="hp-tbl" id="localityTable">
                    <thead>
                        <tr>
                            <th class="hp-th-sort" data-col="0" data-type="str">#<span class="hp-sort-icon">⇅</span></th>
                            <th class="hp-th-sort" data-col="1" data-type="str">Locality <span class="hp-sort-icon">⇅</span></th>
                            <th class="hp-th-sort hp-hide-sm" data-col="2" data-type="str">Area <span class="hp-sort-icon">⇅</span></th>
                            <th class="hp-th-sort" data-col="3" data-type="str">Segment <span class="hp-sort-icon">⇅</span></th>
                            <th class="hp-th-sort" data-col="4" data-type="price">Price / sqft <span class="hp-sort-icon">⇅</span></th>
                            <th class="hp-th-sort hp-hide-sm" data-col="5" data-type="str">Data Quality <span class="hp-sort-icon">⇅</span></th>
                        </tr>
                    </thead>
                    <tbody id="tblBody">
                    @php
                    $localities = [
                        ["Hazratganj","Central Lucknow","Premium","₹9,000 – ₹14,000","High",9000],
                        ["Butler Colony","Old Lucknow","Premium","₹10,000 – ₹15,000","High",10000],
                        ["Vibhuti Khand","Gomti Nagar Ext.","Premium","₹8,000 – ₹11,000","High",8000],
                        ["Gomti Nagar (Central)","Central","Premium","₹8,000 – ₹12,000","High",8000],
                        ["Gomti Nagar Extension","East","Premium","₹7,000 – ₹9,500","High",7000],
                        ["Mahanagar","North","Premium","₹7,500 – ₹10,000","High",7500],
                        ["Nirala Nagar","North","Premium","₹7,000 – ₹9,500","Good",7000],
                        ["New Hyderabad","Central","Premium","₹7,000 – ₹9,000","Good",7000],
                        ["Sushant Golf City","South","Premium","₹6,500 – ₹8,500","Good",6500],
                        ["Ashiyana (Sector I–M)","West","Premium","₹6,500 – ₹9,000","Good",6500],
                        ["Aliganj","North","Upper Mid","₹5,500 – ₹7,500","Good",5500],
                        ["Vrindavan Yojna","South","Upper Mid","₹5,000 – ₹7,000","Good",5000],
                        ["Amar Shaheed Path","Corridor","Upper Mid","₹5,500 – ₹7,500","Good",5500],
                        ["Faizabad Road","Northeast","Upper Mid","₹5,000 – ₹7,000","Good",5000],
                        ["Raebareli Road (PGI Belt)","South","Upper Mid","₹4,800 – ₹6,800","Good",4800],
                        ["Kursi Road","North","Upper Mid","₹4,800 – ₹6,500","Moderate",4800],
                        ["Indira Nagar (A–Block)","Northeast","Upper Mid","₹5,000 – ₹7,000","Good",5000],
                        ["Krishna Nagar","West","Upper Mid","₹4,800 – ₹6,800","Good",4800],
                        ["Telibagh","Central","Upper Mid","₹4,800 – ₹6,500","Good",4800],
                        ["Chinhat (Highway Belt)","East","Upper Mid","₹5,000 – ₹7,200","Good",5000],
                        ["IIM Road","Northwest","Mid","₹4,200 – ₹6,200","Good",4200],
                        ["Jankipuram Extension","North","Mid","₹4,000 – ₹5,800","Good",4000],
                        ["Sitapur Road","North","Mid","₹4,000 – ₹5,500","Moderate",4000],
                        ["Balaganj","West","Mid","₹3,800 – ₹5,200","Moderate",3800],
                        ["Thakurganj","West","Mid","₹4,000 – ₹5,800","Moderate",4000],
                        ["Rajajipuram (Main Blocks)","West","Mid","₹4,000 – ₹5,500","Moderate",4000],
                        ["Para","West","Mid","₹3,800 – ₹5,200","Moderate",3800],
                        ["Matiyari","East","Mid","₹4,200 – ₹5,800","Moderate",4200],
                        ["South City","South","Mid","₹4,500 – ₹6,000","Good",4500],
                        ["Engineering College Road","North","Mid","₹4,800 – ₹6,500","Good",4800],
                        ["Sarojini Nagar","Southwest","Affordable","₹3,500 – ₹5,000","Moderate",3500],
                        ["Alambagh (Interior)","Southwest","Affordable","₹3,800 – ₹5,200","Moderate",3800],
                        ["Kakori Road","West","Affordable","₹3,000 – ₹4,500","Moderate",3000],
                        ["Dubagga","West","Affordable","₹3,000 – ₹4,800","Moderate",3000],
                        ["Bijnor Road","South","Affordable","₹3,200 – ₹4,800","Moderate",3200],
                        ["Kisan Path Belt","East","Affordable","₹3,000 – ₹4,800","Moderate",3000],
                        ["Kamta","East","Affordable","₹4,000 – ₹5,500","Moderate",4000],
                        ["Deva Road","Northeast","Affordable","₹3,500 – ₹5,200","Moderate",3500],
                        ["LDA Colony (Kanpur Road)","Southwest","Affordable","₹3,800 – ₹5,500","Moderate",3800],
                        ["Transport Nagar Extension","West","Affordable","₹3,500 – ₹5,000","Moderate",3500],
                        ["Mohanlalganj","South Outer","Budget","₹2,800 – ₹4,200","Moderate",2800],
                        ["Gosainganj","Southeast Outer","Budget","₹2,500 – ₹3,800","Low",2500],
                        ["Banthra (Airport Belt)","Southwest","Budget","₹2,800 – ₹4,000","Moderate",2800],
                        ["Malihabad","West Outer","Budget","₹2,500 – ₹3,500","Low",2500],
                        ["Barabanki Road Fringe","Northeast","Budget","₹2,800 – ₹4,000","Moderate",2800],
                        ["Kisan Path Outer Zone","East Outer","Budget","₹2,800 – ₹4,200","Moderate",2800],
                        ["Outer Ring Road West","West Outer","Budget","₹3,000 – ₹4,500","Moderate",3000],
                        ["Hardoi Road Fringe","Northwest","Budget","₹2,800 – ₹4,000","Low",2800],
                        ["Raebareli Road Outer","South Outer","Budget","₹2,800 – ₹4,200","Moderate",2800],
                        ["Sultanpur Road Outer","Southeast","Budget","₹3,000 – ₹4,500","Moderate",3000],
                    ];
                    $segCfg = [
                        "Premium"    => ["bg"=>"#f3e8ff","text"=>"#7c3aed","dot"=>"#ef4444"],
                        "Upper Mid"  => ["bg"=>"#eff6ff","text"=>"#1d4ed8","dot"=>"#f97316"],
                        "Mid"        => ["bg"=>"#f0fdf4","text"=>"#15803d","dot"=>"#22c55e"],
                        "Affordable" => ["bg"=>"#eff6ff","text"=>"#1e40af","dot"=>"#3b82f6"],
                        "Budget"     => ["bg"=>"#f9fafb","text"=>"#374151","dot"=>"#6b7280"],
                    ];
                    $qCfg = ["High"=>"#16a34a","Good"=>"#2563eb","Moderate"=>"#d97706","Low"=>"#dc2626"];
                    @endphp
                    @foreach($localities as $i => $loc)
                    @php $s=$loc[2]; $sc=$segCfg[$s]; $q=$loc[4]; $qc=$qCfg[$q]; @endphp
                    <tr class="hp-tbl-row"
                        data-seg="{{ $s }}"
                        data-name="{{ strtolower($loc[0]) }}"
                        data-area="{{ strtolower($loc[1]) }}"
                        data-price="{{ $loc[5] }}">
                        <td class="hp-td-num">{{ $i+1 }}</td>
                        <td>
                            <div class="hp-td-name">{{ $loc[0] }}</div>
                        </td>
                        <td class="hp-hide-sm">
                            <div class="hp-td-area">{{ $loc[1] }}</div>
                        </td>
                        <td>
                            <span class="hp-seg-badge" style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }}">
                                <span class="hp-seg-dot" style="background:{{ $sc['dot'] }}"></span>
                                {{ $s }}
                            </span>
                        </td>
                        <td class="hp-td-price">{{ $loc[3] }}</td>
                        <td class="hp-hide-sm">
                            <span class="hp-quality-badge" style="color:{{ $qc }}">
                                <span class="hp-quality-dot" style="background:{{ $qc }}"></span>
                                {{ $q }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="hp-tbl-more-wrap">
                <button id="tblShowMore" class="hp-tbl-more">Show 10 More ↓</button>
            </div>

            <div class="hp-tbl-empty hidden" id="tblEmpty">
                <i class="fas fa-search"></i>
                <p>No localities match your search. Try a different keyword.</p>
            </div>

            <div class="hp-tbl-footer">
                <p>⚠️ These are indicative price bands based on listing data — not certified valuations. Actual transaction prices vary based on property condition, floor, negotiation, and timing. <a href="/how-property-prices-are-calculated-in-lucknow">Learn how we calculate these →</a></p>
            </div>
        </div>
    </div>
</section>

{{-- ====================================================
     METHODOLOGY (lightweight)
==================================================== --}}
<section class="hp-section" style="background:var(--hp-bg2)">
    <div class="hp-c">
        <div class="hp-slabel hp-rv">Transparent by Design</div>
        <h2 class="hp-stitle hp-rv">How We Generate These Estimates</h2>
        <p class="hp-ssub hp-rv">We don't hide behind "AI magic." Here's exactly how the numbers are made.</p>

        <div class="hp-meth__steps hp-rv">
            <div class="hp-meth__step">
                <div class="hp-meth__ico"><i class="fas fa-globe"></i></div>
                <div class="hp-meth__n">1</div>
                <h4>Collect Listing Data</h4>
                <p>We aggregate asking prices from major property portals across Lucknow localities.</p>
            </div>
            <div class="hp-meth__arrow">→</div>
            <div class="hp-meth__step">
                <div class="hp-meth__ico"><i class="fas fa-filter"></i></div>
                <div class="hp-meth__n">2</div>
                <h4>Remove Outliers</h4>
                <p>We filter unusually high or low prices that would distort the real market rate.</p>
            </div>
            <div class="hp-meth__arrow">→</div>
            <div class="hp-meth__step">
                <div class="hp-meth__ico"><i class="fas fa-chart-bar"></i></div>
                <div class="hp-meth__n">3</div>
                <h4>Build Price Bands</h4>
                <p>Remaining data is normalised into a min–max range — the realistic market window.</p>
            </div>
        </div>

        <div class="hp-meth__note hp-rv">
            <i class="fas fa-exclamation-triangle"></i>
            <p>Listing prices ≠ transaction prices. Sellers often ask more than what properties actually sell for. Our estimates reflect the listing market — real transaction data will improve our accuracy as we grow.</p>
        </div>

        <div class="hp-meth__cta hp-rv">
            <a href="/how-property-prices-are-calculated-in-lucknow" class="hp-btn hp-btn--outline">See the Full 9-Step Methodology →</a>
        </div>
    </div>
</section>

{{-- ====================================================
     FAQ
==================================================== --}}
<section class="hp-section hp-faq">
    <div class="hp-c">
        <div class="hp-slabel hp-rv">Questions?</div>
        <h2 class="hp-stitle hp-rv">Frequently Asked Questions</h2>

        <div class="hp-faq__list">
            @php
            $faqs = [
                ["How accurate are your estimates?", "Our estimates are based on real listing data from Lucknow — not AI guesses. That said, listing prices can differ from actual transaction prices by 5–20% depending on market conditions. We're building toward better accuracy as we gather more data. We'll always be upfront about this."],
                ["Is this service really free?", "Yes — fully free, no registration required, no hidden plans. We believe property buyers deserve access to honest market data without paying for it."],
                ["What data are estimates based on?", "We aggregate asking prices from major property portals, filter out outliers, and build a realistic price band per locality. We also factor in the locality segment and infrastructure context. Full details on our case study page."],
                ["Why do you show a price range instead of a single number?", "Because a single number would be misleading. Property prices vary based on floor, property condition, construction quality, and negotiation. A range is more honest and more useful."],
                ["Which areas in Lucknow are covered?", "Currently 50+ localities — from Premium zones like Hazratganj and Gomti Nagar to Budget areas like Malihabad and Banthra. We're adding more regularly."],
            ];
            @endphp
            @foreach($faqs as $fi => $faq)
            <div class="hp-faq__item hp-rv" style="--rd:{{ $fi * 0.06 }}s">
                <button class="hp-faq__q" onclick="hpToggleFaq(this)">
                    <span>{{ $faq[0] }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="hp-faq__a">{{ $faq[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ====================================================
     NEWSLETTER
==================================================== --}}
<x-newsletter
    title="Stay Ahead of Lucknow's Property Market"
    description="Get honest weekly price updates, market insights, and tips — no spam, unsubscribe anytime."
/>

</div>{{-- /hp --}}

{{-- ====================================================
     SCRIPTS
==================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Scroll reveal ── */
    const rv = new IntersectionObserver(es => {
        es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); rv.unobserve(e.target); } });
    }, { threshold: 0.08 });
    document.querySelectorAll('.hp-rv').forEach(el => rv.observe(el));

    /* ── FAQ ── */
    window.hpToggleFaq = function (btn) {
        const open = btn.classList.contains('open');
        document.querySelectorAll('.hp-faq__q.open').forEach(b => {
            b.classList.remove('open');
            b.nextElementSibling.classList.remove('open');
        });
        if (!open) { btn.classList.add('open'); btn.nextElementSibling.classList.add('open'); }
    };

    /* ── TABLE: data store ── */
    const rows    = Array.from(document.querySelectorAll('#tblBody .hp-tbl-row'));
    const tblBody = document.getElementById('tblBody');
    const counter = document.getElementById('tblCount');
    const empty   = document.getElementById('tblEmpty');
    let sortCol   = -1, sortDir = 1, activeSeg = 'All', searchVal = '';

    function getVal(row, col) {
        switch(col) {
            case 0: return parseInt(row.cells[0].textContent);
            case 1: return row.querySelector('.hp-td-name').textContent.trim().toLowerCase();
            case 2: return (row.querySelector('.hp-td-area') || {textContent:''}).textContent.trim().toLowerCase();
            case 3: return row.dataset.seg.toLowerCase();
            case 4: return parseInt(row.dataset.price);
            case 5: return (row.cells[5] ? row.cells[5].textContent.trim().toLowerCase() : '');
        }
        return '';
    }

    const ROWS_PAGE = 10;
    let visibleCount = ROWS_PAGE;

    function render(resetPagination) {
        if (resetPagination) visibleCount = ROWS_PAGE;
        const s = searchVal.toLowerCase();
        const filtered = rows.filter(r => {
            const segMatch = activeSeg === 'All' || r.dataset.seg === activeSeg;
            const txtMatch = !s || r.dataset.name.includes(s) || r.dataset.area.includes(s) || r.dataset.seg.toLowerCase().includes(s);
            return segMatch && txtMatch;
        });

        if (sortCol >= 0) {
            filtered.sort((a, b) => {
                const av = getVal(a, sortCol), bv = getVal(b, sortCol);
                if (typeof av === 'number') return (av - bv) * sortDir;
                return av.localeCompare(bv) * sortDir;
            });
        }

        rows.forEach(r => r.style.display = 'none');
        const visible = filtered.slice(0, visibleCount);
        visible.forEach((r, i) => {
            r.querySelector('.hp-td-num').textContent = i + 1;
            r.style.display = '';
            tblBody.appendChild(r);
        });

        /* counter */
        const showing = Math.min(visibleCount, filtered.length);
        counter.textContent = `Showing ${showing} of ${filtered.length} localities`;

        /* show more button */
        const btn = document.getElementById('tblShowMore');
        if (btn) {
            const remaining = filtered.length - visibleCount;
            if (remaining > 0) {
                btn.style.display = '';
                btn.textContent = `Show ${Math.min(remaining, ROWS_PAGE)} More  ↓  (${remaining} remaining)`;
            } else {
                btn.style.display = 'none';
            }
        }

        /* empty state */
        if (filtered.length === 0) { empty.classList.remove('hidden'); } else { empty.classList.add('hidden'); }
    }

    /* Sort headers */
    document.querySelectorAll('.hp-th-sort').forEach(th => {
        th.addEventListener('click', function () {
            const col = parseInt(this.dataset.col);
            if (sortCol === col) { sortDir *= -1; }
            else { sortCol = col; sortDir = 1; }
            document.querySelectorAll('.hp-th-sort').forEach(t => t.classList.remove('asc','desc'));
            this.classList.add(sortDir === 1 ? 'asc' : 'desc');
            render(true);
        });
    });

    /* Search */
    document.getElementById('tblSearch').addEventListener('input', function () {
        searchVal = this.value;
        render(true);
    });

    /* Segment filter */
    document.querySelectorAll('.hp-tbl-filter').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.hp-tbl-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeSeg = this.dataset.seg;
            render(true);
        });
    });

    /* Show More listener */
    const showMoreBtn = document.getElementById('tblShowMore');
    if (showMoreBtn) {
        showMoreBtn.addEventListener('hp-show-more', function() {
            visibleCount += ROWS_PAGE;
            render();
        });
        showMoreBtn.addEventListener('click', function() {
            visibleCount += ROWS_PAGE;
            render();
        });
    }

    render(true); /* initial render */
});
</script>
@include('components.valuation-modal')
@endsection