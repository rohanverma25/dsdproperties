<style>
:root{--rg-navy:#011f4b;--rg-teal:#008080;--rg-orange:#FF5C00;--rg-green:#25D366;--rg-bg:var(--bg-primary,#f9fafb);--rg-bg2:var(--bg-secondary,#ffffff);--rg-card:var(--card-bg,#ffffff);--rg-border:var(--border-color,#e2e8f0);--rg-t1:var(--text-primary,#111827);--rg-t2:var(--text-secondary,#4b5563);--rg-t3:var(--text-tertiary,#9ca3af);--rg-radius:14px;--rg-shadow:0 4px 20px rgba(1,31,75,.08);--rg-gradient:linear-gradient(135deg,#011f4b 0%,#013d6b 50%,#005f6b 100%)}
.rg-wrap{font-family:'Poppins',system-ui,sans-serif;color:var(--rg-t1);background:var(--rg-bg);line-height:1.7;overflow-x:hidden}
.rg-container{max-width:1140px;margin:0 auto;padding:0 24px}
.rg-section{padding:72px 0}
.rg-section--alt{background:var(--rg-bg2)}
.rg-label{font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--rg-teal);display:block;margin-bottom:8px}
.rg-h2{font-size:clamp(1.5rem,3.2vw,2.1rem);font-weight:800;color:var(--rg-navy);line-height:1.2;margin:0 0 12px}
.rg-lede{color:var(--rg-t2);max-width:68ch;margin:0 0 36px;font-size:.95rem;line-height:1.75}
.rg-btn{display:inline-flex;align-items:center;gap:9px;font-family:'Poppins',sans-serif;font-weight:600;font-size:.88rem;padding:13px 24px;border-radius:11px;text-decoration:none;border:none;cursor:pointer;transition:transform .2s,box-shadow .2s}
.rg-btn:hover{transform:translateY(-2px)}
.rg-btn--wa{background:var(--rg-green);color:#fff;box-shadow:0 6px 18px rgba(37,211,102,.3)}
.rg-btn--wa:hover{background:#1ebe5d;color:#fff;box-shadow:0 10px 24px rgba(37,211,102,.4)}
.rg-btn--ghost{background:rgba(255,255,255,.1);color:#fff;border:1.5px solid rgba(255,255,255,.35)}
.rg-btn--ghost:hover{background:rgba(255,255,255,.2);color:#fff}
.rg-btn-row{display:flex;gap:12px;flex-wrap:wrap}
.rg-crumb{font-size:.8rem;color:var(--rg-t3);padding:14px 0 0}
.rg-crumb a{color:var(--rg-teal);text-decoration:none}
.rg-crumb a:hover{text-decoration:underline}
.rg-hero{position:relative;overflow:hidden;background:var(--rg-gradient);min-height:86vh;display:flex;align-items:center}
.rg-hero__grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:52px 52px}
.rg-hero__orb{position:absolute;border-radius:50%;filter:blur(90px);pointer-events:none}
.rg-hero__orb--a{width:480px;height:480px;background:rgba(0,128,128,.22);top:-120px;right:-80px;animation:rg-float 10s ease-in-out infinite}
.rg-hero__orb--b{width:340px;height:340px;background:rgba(255,92,0,.12);bottom:-60px;left:-60px;animation:rg-float 12s ease-in-out infinite 3s}
@keyframes rg-float{0%,100%{transform:translateY(0)}50%{transform:translateY(-16px)}}
@keyframes rg-up{from{opacity:0;transform:translateY(26px)}to{opacity:1;transform:none}}
@keyframes rg-pulse{0%,100%{box-shadow:0 0 0 2px rgba(74,222,128,.35)}50%{box-shadow:0 0 0 7px rgba(74,222,128,.07)}}
.rg-hero__body{position:relative;z-index:2;padding:80px 0 72px;display:grid;grid-template-columns:1.1fr 1fr;gap:52px;align-items:center}
@media(max-width:900px){.rg-hero__body{grid-template-columns:1fr;gap:32px;padding:80px 0 56px}}
.rg-hero__badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.2);border-radius:99px;padding:7px 16px;margin-bottom:20px;font-size:11px;font-weight:500;color:rgba(255,255,255,.85)}
.rg-pulse{width:8px;height:8px;border-radius:50%;background:#4ade80;flex-shrink:0;animation:rg-pulse 2.5s infinite}
.rg-hero__h1{font-size:clamp(1.8rem,3.8vw,2.7rem);font-weight:800;color:#fff;line-height:1.14;margin:0 0 18px;letter-spacing:-.3px}
.rg-hero__h1 em{font-style:normal;color:#FF5C00}
.rg-hero__sub{font-size:.95rem;color:rgba(255,255,255,.78);line-height:1.78;margin:0 0 26px;max-width:56ch}
.rg-hero__pills{display:flex;flex-wrap:wrap;gap:8px;margin-top:20px}
.rg-pill{display:flex;align-items:center;gap:6px;padding:5px 13px;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.16);border-radius:8px;font-size:11px;color:rgba(255,255,255,.72)}
.rg-hero__card{background:var(--rg-card);border-radius:18px;padding:28px;box-shadow:0 30px 70px rgba(0,0,0,.28);animation:rg-up .7s ease .1s both}
.rg-hero__card-tag{display:inline-block;font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--rg-orange);background:rgba(255,92,0,.08);padding:4px 10px;border-radius:5px;margin-bottom:12px}
.rg-hero__card-title{font-size:1.15rem;font-weight:800;color:var(--rg-navy);margin-bottom:4px;line-height:1.3}
.rg-hero__card-sub{font-size:.81rem;color:var(--rg-t2);margin-bottom:18px;line-height:1.6}
.rg-hero__card-list{list-style:none;padding:0;margin:0 0 20px}
.rg-hero__card-list li{display:flex;align-items:flex-start;gap:8px;padding:7px 0;font-size:.82rem;color:var(--rg-t2);border-bottom:1px solid var(--rg-border)}
.rg-hero__card-list li:last-child{border-bottom:none}
.rg-hero__card-list li::before{content:"✓";color:var(--rg-teal);font-weight:800;flex-shrink:0;margin-top:1px}
.rg-hero__card-btn{display:block;width:100%;padding:14px;background:var(--rg-green);color:#fff;border:none;border-radius:10px;font-weight:700;font-size:.9rem;cursor:pointer;font-family:'Poppins',sans-serif;text-align:center;text-decoration:none;transition:transform .2s,box-shadow .2s;box-shadow:0 5px 18px rgba(37,211,102,.3)}
.rg-hero__card-btn:hover{transform:translateY(-1px);color:#fff;box-shadow:0 8px 22px rgba(37,211,102,.42)}
.rg-hero__card-note{margin-top:11px;font-size:.72rem;color:var(--rg-t3);text-align:center;line-height:1.5}
.rg-hero__wave{position:absolute;bottom:0;left:0;right:0;line-height:0}
.rg-hero__wave svg{width:100%;height:52px;display:block}
.rg-metrics{background:var(--rg-bg2);border-bottom:1px solid var(--rg-border);padding:28px 0}
.rg-metrics__grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;text-align:center}
@media(max-width:680px){.rg-metrics__grid{grid-template-columns:repeat(2,1fr);gap:22px}}
.rg-metric__num{font-size:1.6rem;font-weight:900;color:var(--rg-navy);line-height:1;margin-bottom:5px}
.rg-metric__num span{color:var(--rg-orange)}
.rg-metric__lbl{font-size:.71rem;color:var(--rg-t2);text-transform:uppercase;letter-spacing:1.2px;font-weight:600}
.rg-rv{opacity:0;transform:translateY(22px);transition:opacity .55s ease,transform .55s ease;transition-delay:var(--rd,0s)}
.rg-rv.visible{opacity:1;transform:none}
.rg-flags{display:grid;gap:18px}
.rg-flag{background:var(--rg-card);border:1.5px solid #fecaca;border-radius:var(--rg-radius);padding:24px;display:flex;gap:18px;align-items:flex-start;transition:transform .25s,box-shadow .25s}
.rg-flag:hover{transform:translateY(-3px);box-shadow:0 12px 32px rgba(220,38,38,.1)}
.rg-flag__icon{width:44px;height:44px;flex-shrink:0;background:linear-gradient(135deg,#dc2626,#b91c1c);border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:1.3rem}
.rg-flag__title{font-size:.95rem;font-weight:700;color:#991b1b;margin:0 0 6px}
.rg-flag__body{font-size:.86rem;color:var(--rg-t2);margin:0;line-height:1.7}
.rg-deed-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(270px,1fr));gap:18px}
.rg-deed-card{background:var(--rg-card);border:1.5px solid var(--rg-border);border-radius:var(--rg-radius);padding:24px;display:flex;gap:16px;align-items:flex-start;transition:transform .25s,box-shadow .25s,border-color .25s}
.rg-deed-card:hover{transform:translateY(-3px);box-shadow:var(--rg-shadow);border-color:rgba(0,128,128,.3)}
.rg-deed-icon{width:46px;height:46px;flex-shrink:0;background:linear-gradient(135deg,var(--rg-teal),#006666);color:#fff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem}
.rg-deed-title{font-size:.93rem;font-weight:700;color:var(--rg-navy);margin:0 0 6px}
.rg-deed-body{font-size:.83rem;color:var(--rg-t2);margin:0;line-height:1.68}
.rg-info{background:linear-gradient(135deg,#fff7ed,#fff1e0);border:1.5px solid rgba(255,92,0,.2);border-radius:var(--rg-radius);padding:28px 30px}
.rg-info h3{color:var(--rg-navy);font-size:1.05rem;font-weight:700;margin:0 0 14px}
.rg-info ul{margin:0;padding-left:0;list-style:none}
.rg-info li{display:flex;align-items:flex-start;gap:10px;padding:9px 0;border-bottom:1px solid rgba(255,92,0,.1);font-size:.87rem;color:var(--rg-t2);line-height:1.65}
.rg-info li:last-child{border-bottom:none}
.rg-info li::before{content:"✓";color:var(--rg-orange);font-weight:800;flex-shrink:0;margin-top:2px}
.rg-info-note{font-size:.8rem;color:var(--rg-t3);margin-top:14px;font-style:italic;line-height:1.6}
.rg-sro-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px}
.rg-sro-card{background:var(--rg-card);border:1.5px solid var(--rg-border);border-radius:var(--rg-radius);padding:22px;display:flex;gap:14px;align-items:flex-start;transition:transform .25s,border-color .25s}
.rg-sro-card:hover{transform:translateY(-2px);border-color:rgba(0,128,128,.3)}
.rg-sro-icon{width:40px;height:40px;flex-shrink:0;background:linear-gradient(135deg,var(--rg-teal),#006666);color:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem}
.rg-sro-name{font-size:.92rem;font-weight:700;color:var(--rg-teal);margin:0 0 5px}
.rg-sro-covers{font-size:.82rem;color:var(--rg-t2);margin:0;line-height:1.6}
.rg-steps{display:flex;flex-direction:column;gap:16px;max-width:860px;margin:0 auto}
.rg-step{background:var(--rg-card);border:1px solid var(--rg-border);border-radius:var(--rg-radius);padding:22px;display:flex;gap:18px;align-items:flex-start;transition:transform .25s,box-shadow .25s}
.rg-step:hover{transform:translateY(-3px);box-shadow:var(--rg-shadow)}
.rg-step__num{width:48px;height:48px;flex-shrink:0;background:linear-gradient(135deg,var(--rg-navy),#013870);color:#fff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;font-weight:800}
.rg-step__label{display:inline-block;background:rgba(0,128,128,.1);color:#04635f;font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:99px;margin-bottom:6px}
.rg-step__title{font-size:.95rem;font-weight:700;color:var(--rg-navy);margin:0 0 6px}
.rg-step__body{font-size:.84rem;color:var(--rg-t2);margin:0;line-height:1.7}
.rg-midcta{background:var(--rg-gradient);border-radius:var(--rg-radius);padding:44px 36px;color:#fff;text-align:center;position:relative;overflow:hidden}
.rg-midcta::before{content:'';position:absolute;width:360px;height:360px;border-radius:50%;background:rgba(255,255,255,.05);top:-120px;right:-80px}
.rg-midcta h2{color:#fff;font-size:clamp(1.2rem,2.5vw,1.7rem);font-weight:800;margin:0 0 10px;position:relative}
.rg-midcta p{color:rgba(255,255,255,.78);margin:0 0 26px;font-size:.93rem;max-width:56ch;margin-left:auto;margin-right:auto;position:relative}
.rg-midcta .rg-btn-row{justify-content:center;position:relative}
.rg-table-wrap{overflow-x:auto;border-radius:var(--rg-radius);border:1px solid var(--rg-border);box-shadow:var(--rg-shadow)}
.rg-table{width:100%;border-collapse:collapse;min-width:700px;font-size:.88rem;background:var(--rg-card)}
.rg-table th,.rg-table td{padding:14px 18px;text-align:left;border-bottom:1px solid var(--rg-border);vertical-align:top;line-height:1.55}
.rg-table thead th{background:var(--rg-navy);color:#fff;font-weight:600;font-size:.84rem}
.rg-table thead th:last-child{background:var(--rg-teal)}
.rg-table tbody th{font-weight:600;color:var(--rg-navy);background:#f8fafc;white-space:nowrap}
.rg-table td{color:var(--rg-t2)}
.rg-table td:last-child{background:#f0fbfa;color:#047857;font-weight:600}
.rg-table tr:last-child th,.rg-table tr:last-child td{border-bottom:none}
.rg-fees-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(270px,1fr));gap:18px;margin-bottom:24px}
.rg-fee-card{background:var(--rg-card);border:1.5px solid var(--rg-border);border-radius:var(--rg-radius);padding:24px;display:flex;flex-direction:column;gap:10px;transition:transform .25s,border-color .25s}
.rg-fee-card:hover{transform:translateY(-2px);border-color:rgba(0,128,128,.3)}
.rg-fee-title{font-size:.93rem;font-weight:700;color:var(--rg-navy)}
.rg-fee-note{font-size:.8rem;color:var(--rg-t3)}
.rg-fee-cta{display:inline-flex;align-items:center;gap:7px;margin-top:auto;font-size:.82rem;font-weight:700;color:var(--rg-green);text-decoration:none}
.rg-fee-cta:hover{text-decoration:underline;color:var(--rg-green)}
.rg-fees-note{background:rgba(0,128,128,.06);border:1px solid rgba(0,128,128,.15);border-radius:10px;padding:16px 20px;font-size:.85rem;color:var(--rg-t2);text-align:center;line-height:1.6}
.rg-fees-note a{color:var(--rg-orange);font-weight:600;text-decoration:none}
.rg-fees-note a:hover{text-decoration:underline}
.rg-faq{border:1px solid var(--rg-border);border-radius:var(--rg-radius);overflow:hidden;background:var(--rg-card)}
.rg-faq-item{border-bottom:1px solid var(--rg-border)}
.rg-faq-item:last-child{border-bottom:none}
.rg-faq-btn{width:100%;display:flex;justify-content:space-between;align-items:center;padding:18px 22px;background:none;border:none;font-family:'Poppins',sans-serif;font-size:.9rem;font-weight:600;color:var(--rg-navy);cursor:pointer;text-align:left;gap:14px;transition:background .2s}
.rg-faq-btn:hover{background:var(--rg-bg)}
.rg-faq-chevron{color:var(--rg-teal);font-size:.8rem;flex-shrink:0;transition:transform .3s}
.rg-faq-btn.open .rg-faq-chevron{transform:rotate(180deg)}
.rg-faq-body{padding:0 22px;max-height:0;overflow:hidden;font-size:.87rem;color:var(--rg-t2);line-height:1.75;transition:max-height .35s ease,padding .35s ease}
.rg-faq-body.open{max-height:700px;padding:0 22px 18px}
.rg-related{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:16px}
.rg-related-link{display:block;background:var(--rg-card);border:1.5px solid var(--rg-border);border-radius:var(--rg-radius);padding:20px;text-decoration:none;transition:transform .25s,box-shadow .25s,border-color .25s;position:relative;overflow:hidden}
.rg-related-link::before{content:'';position:absolute;top:0;left:0;width:3px;height:0;background:linear-gradient(to bottom,var(--rg-teal),var(--rg-orange));transition:height .3s}
.rg-related-link:hover::before{height:100%}
.rg-related-link:hover{transform:translateY(-3px);box-shadow:var(--rg-shadow);border-color:rgba(0,128,128,.2)}
.rg-related-tag{font-size:.68rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--rg-orange);margin-bottom:7px;display:block}
.rg-related-title{font-size:.88rem;font-weight:600;color:var(--rg-navy);line-height:1.5;display:block}
.rg-related-arrow{font-size:.76rem;font-weight:700;color:var(--rg-teal);margin-top:10px;display:block}
.rg-disclaimer{font-size:.78rem;color:var(--rg-t3);background:var(--rg-bg);border:1px dashed var(--rg-border);border-radius:10px;padding:18px 20px;margin-top:32px;line-height:1.65}
.rg-mob-cta{display:none;position:fixed;bottom:0;left:0;right:0;background:var(--rg-card);border-top:3px solid var(--rg-orange);padding:10px 14px;z-index:90;box-shadow:0 -4px 20px rgba(0,0,0,.12);gap:8px}
.rg-mob-cta.show{display:flex}
.rg-mob-cta a{flex:1;text-align:center;padding:11px 8px;border-radius:9px;font-family:'Poppins',sans-serif;font-weight:700;font-size:.8rem;text-decoration:none}
.rg-mob-cta a.whatsapp{background:var(--rg-green);color:#fff}
.rg-mob-cta a.call{background:linear-gradient(135deg,var(--rg-orange),#ff8840);color:#fff}
@media(max-width:680px){.rg-section{padding:52px 0}.rg-step{flex-direction:column;gap:12px}.rg-step__num{width:40px;height:40px;font-size:1rem}.rg-flag{flex-direction:column;gap:12px}}
@media(prefers-reduced-motion:reduce){.rg-hero__orb{animation:none}.rg-btn,.rg-deed-card,.rg-step,.rg-related-link{transition:none}}
</style>

@php $sroCount = count($sros); $deedIcons = ['📝','🏠','🎁','📋']; @endphp

<div class="rg-wrap">

<div style="background:var(--rg-bg2);border-bottom:1px solid var(--rg-border);">
    <div class="rg-container">
        <nav class="rg-crumb" aria-label="Breadcrumb">
            <a href="/">Home</a> &rsaquo; <a href="/services">Services</a> &rsaquo; Property Registry Assistance in {{ $city }}
        </nav>
    </div>
</div>

<section class="rg-hero">
    <div class="rg-hero__grid"></div>
    <div class="rg-hero__orb rg-hero__orb--a"></div>
    <div class="rg-hero__orb rg-hero__orb--b"></div>

    <div class="rg-container rg-hero__body">
        <div style="animation:rg-up .6s ease both;">
            <div class="rg-hero__badge">
                <span class="rg-pulse"></span>
                {{ $city }} Property Registry Specialists
            </div>
            <h1 class="rg-hero__h1">
                Property Registry Advocate<br>
                in {{ $city }} — <em>Deed Drafting</em><br>
                &amp; Sub-Registrar Support
            </h1>
            <p class="rg-hero__sub">Most registry trouble is written into the deed on the day it is signed, not discovered later. We get the clauses, the circle rate and the correct office right the first time — and an advocate from our side stands with you at the counter.</p>
            <div class="rg-btn-row">
                <a class="rg-btn rg-btn--wa" href="https://wa.me/{{ ltrim($phone,'+') }}?text={{ $waText }}" rel="nofollow noopener" target="_blank">
                    <svg width="17" height="17" viewBox="0 0 32 32" fill="currentColor"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 1 0 16 3zm5.8 18.7c-.3-.2-1.9-.9-2.2-1s-.5-.2-.7.2-.8 1-1 1.2-.4.2-.7.1a8.7 8.7 0 0 1-4.3-3.7c-.3-.6.3-.5.9-1.7.1-.2 0-.4 0-.6l-1-2.3c-.2-.6-.5-.5-.7-.5h-.6a1.2 1.2 0 0 0-.8.4 3.5 3.5 0 0 0-1.1 2.6 6.1 6.1 0 0 0 1.3 3.2 13.9 13.9 0 0 0 5.3 4.7c2 .8 2.7.9 3.7.7a3.1 3.1 0 0 0 2-1.4 2.5 2.5 0 0 0 .2-1.4c-.1-.2-.3-.3-.6-.4z"/></svg>
                    WhatsApp Us
                </a>
                <a class="rg-btn rg-btn--ghost" href="tel:{{ $phone }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1z"/></svg>
                    Call {{ $phoneDisp }}
                </a>
            </div>
            <div class="rg-hero__pills">
                @foreach ($badges as $b)
                    <div class="rg-pill">
                        <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0z"/></svg>
                        {{ $b }}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rg-hero__card">
            <div class="rg-hero__card-tag">REGISTRY ASSISTANCE</div>
            <div class="rg-hero__card-title">End-to-end registry support</div>
            <div class="rg-hero__card-sub">From parent deed review to the endorsed receipt — we handle the paperwork, the office, and the day.</div>
            <ul class="rg-hero__card-list">
                <li>Advocate-drafted sale deed / ATS</li>
                <li>Ward-level circle rate verified on IGRSUP</li>
                <li>Women buyer &amp; blood-relative concessions checked</li>
                <li>Attendance at {{ $sroCount }} {{ $city }} Sub-Registrar offices</li>
                <li>Dakhil kharij roadmap handed over post-registry</li>
            </ul>
            <a href="https://wa.me/{{ ltrim($phone,'+') }}?text={{ $waText }}" class="rg-hero__card-btn" target="_blank" rel="nofollow noopener">Get a Quote on WhatsApp →</a>
            <div class="rg-hero__card-note">🔒 Fee quoted in writing before work starts</div>
        </div>
    </div>

    <div class="rg-hero__wave">
        <svg viewBox="0 0 1440 52" preserveAspectRatio="none"><path d="M0,26 C480,52 960,0 1440,26 L1440,52 L0,52 Z" fill="var(--bg-primary,#f9fafb)"/></svg>
    </div>
</section>

<section class="rg-metrics">
    <div class="rg-container">
        <div class="rg-metrics__grid">
            <div><div class="rg-metric__num">{{ $sroCount }}<span>+</span></div><div class="rg-metric__lbl">Sub-Registrar Offices Covered</div></div>
            <div><div class="rg-metric__num">24 hr</div><div class="rg-metric__lbl">First Document Review</div></div>
            <div><div class="rg-metric__num">₹0</div><div class="rg-metric__lbl">Funds Routed Through Us</div></div>
            <div><div class="rg-metric__num">100<span>%</span></div><div class="rg-metric__lbl">Fixed Fee, No % of Deal</div></div>
        </div>
    </div>
</section>

<section class="rg-section">
    <div class="rg-container">
        <span class="rg-label rg-rv">Where It Goes Wrong</span>
        <h2 class="rg-h2 rg-rv">Where registries go wrong in {{ $city }}</h2>
        <p class="rg-lede rg-rv">None of these show up on the day of registration. They appear when you try to sell, mortgage, or defend the property — usually years later, when the other side has moved on.</p>
        <div class="rg-flags">
            @foreach ($problems as $i => $prob)
                <div class="rg-flag rg-rv" @if($i) style="--rd:{{ $i * 0.06 }}s" @endif>
                    <div class="rg-flag__icon">{{ $prob['icon'] }}</div>
                    <div>
                        <div class="rg-flag__title">{{ $prob['title'] }}</div>
                        <p class="rg-flag__body">{{ $prob['body'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="rg-section rg-section--alt">
    <div class="rg-container">
        <span class="rg-label rg-rv">Deed Drafting</span>
        <h2 class="rg-h2 rg-rv">What we draft</h2>
        <p class="rg-lede rg-rv">Every instrument below is drafted or vetted by an advocate on our team, against your actual parent deed and revenue record — not filled into a stock format.</p>
        <div class="rg-deed-grid">
            @foreach ($deeds as $i => $deed)
                <article class="rg-deed-card rg-rv" style="--rd:{{ $i * 0.06 }}s">
                    <div class="rg-deed-icon">{{ $deedIcons[$i] ?? '📄' }}</div>
                    <div>
                        <div class="rg-deed-title">{{ $deed['title'] }}</div>
                        <p class="rg-deed-body">{{ $deed['body'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="rg-section">
    <div class="rg-container">
        <span class="rg-label rg-rv">Stamp Duty &amp; Savings</span>
        <h2 class="rg-h2 rg-rv">Stamp duty and circle rate</h2>
        <p class="rg-lede rg-rv">Duty is charged on the higher of the circle rate and the agreed consideration. Two concessions are worth checking before the deed is drafted — neither can be applied retrospectively.</p>
        <div class="rg-info rg-rv">
            <h3>Concessions we check for eligibility</h3>
            <ul>
                <li><strong>Women buyers:</strong> UP allows a 1% concession on stamp duty. The Cabinet raised the value ceiling to ₹1 crore — lifting the maximum benefit from ₹10,000 to ₹1 lakh. Joint ownership needs the deed framed correctly to qualify.</li>
                <li><strong>Transfers between blood relatives:</strong> A concessional flat stamp duty applies to gift and partition instruments between specified relatives instead of the full 6–7%. Relationship evidence must be attached in the form the Sub-Registrar accepts.</li>
                <li><strong>Ward-level circle rate:</strong> Pulled from the current district schedule for your specific ward or village, not estimated from the colony name.</li>
            </ul>
            <p class="rg-info-note">Rates, ceilings and concessions change by government notification. We verify on IGRSUP for your specific transaction before the e-Stamp is generated. The e-Stamp is purchased in the buyer's own name and paid directly — we prepare the application, we do not handle your funds.</p>
        </div>
    </div>
</section>

<section class="rg-section rg-section--alt">
    <div class="rg-container">
        <span class="rg-label rg-rv">Coverage</span>
        <h2 class="rg-h2 rg-rv">Which Sub-Registrar office covers your property</h2>
        <p class="rg-lede rg-rv">Jurisdiction follows the property, not your address. Presenting a deed at the wrong office wastes a slot and a day — we confirm the correct office before anything is booked.</p>
        <div class="rg-sro-grid">
            @foreach ($sros as $i => $sro)
                <div class="rg-sro-card rg-rv" style="--rd:{{ $i * 0.06 }}s">
                    <div class="rg-sro-icon">📍</div>
                    <div>
                        <div class="rg-sro-name">{{ $sro['name'] }}</div>
                        <p class="rg-sro-covers">{{ $sro['covers'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="rg-section">
    <div class="rg-container">
        <span class="rg-label rg-rv">Simple Process</span>
        <h2 class="rg-h2 rg-rv">How the work runs — 4 steps</h2>
        <p class="rg-lede rg-rv">You approve the draft before anything is stamped, and you know the total cost before step 3.</p>
        <div class="rg-steps">
            @foreach ($steps as $i => $step)
                <article class="rg-step rg-rv" style="--rd:{{ $i * 0.06 }}s">
                    <div class="rg-step__num">{{ $i + 1 }}</div>
                    <div>
                        <span class="rg-step__label">{{ $step['label'] }}</span>
                        <div class="rg-step__title">{{ $step['title'] }}</div>
                        <p class="rg-step__body">{{ $step['body'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="rg-section rg-section--alt">
    <div class="rg-container">
        <div class="rg-midcta rg-rv">
            <h2>Send us the parent deed first</h2>
            <p>Most problems are already visible in the previous title document. Share it on WhatsApp — we will tell you what needs fixing before you pay a token. No charge for the initial review.</p>
            <div class="rg-btn-row">
                <a class="rg-btn rg-btn--wa" href="https://wa.me/{{ ltrim($phone,'+') }}?text={{ $waText }}" rel="nofollow noopener" target="_blank">
                    <svg width="16" height="16" viewBox="0 0 32 32" fill="currentColor"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 1 0 16 3zm5.8 18.7c-.3-.2-1.9-.9-2.2-1s-.5-.2-.7.2-.8 1-1 1.2-.4.2-.7.1a8.7 8.7 0 0 1-4.3-3.7c-.3-.6.3-.5.9-1.7.1-.2 0-.4 0-.6l-1-2.3c-.2-.6-.5-.5-.7-.5h-.6a1.2 1.2 0 0 0-.8.4 3.5 3.5 0 0 0-1.1 2.6 6.1 6.1 0 0 0 1.3 3.2 13.9 13.9 0 0 0 5.3 4.7c2 .8 2.7.9 3.7.7a3.1 3.1 0 0 0 2-1.4 2.5 2.5 0 0 0 .2-1.4c-.1-.2-.3-.3-.6-.4z"/></svg>
                    Send Documents on WhatsApp
                </a>
                <a class="rg-btn rg-btn--ghost" href="tel:{{ $phone }}">Call {{ $phoneDisp }}</a>
            </div>
        </div>
    </div>
</section>

<section class="rg-section">
    <div class="rg-container">
        <span class="rg-label rg-rv">Why It Matters</span>
        <h2 class="rg-h2 rg-rv">What changes when a professional handles it</h2>
        <p class="rg-lede rg-rv">A plain comparison of how the same registry runs three different ways.</p>
        <div class="rg-table-wrap rg-rv">
            <table class="rg-table">
                <caption class="sr-only">Comparison: broker-arranged vs self-managed vs DSD Registry Assistance</caption>
                <thead>
                    <tr>
                        <th scope="col">Stage</th>
                        <th scope="col">Broker-arranged</th>
                        <th scope="col">Self-managed</th>
                        <th scope="col">DSD Registry Assistance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comparison as $row)
                        <tr>
                            <th scope="row">{{ $row['feature'] }}</th>
                            <td>{{ $row['broker'] }}</td>
                            <td>{{ $row['self'] }}</td>
                            <td>{{ $row['dsd'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="rg-section rg-section--alt">
    <div class="rg-container">
        <span class="rg-label rg-rv">Transparent Pricing</span>
        <h2 class="rg-h2 rg-rv">Fees</h2>
        <p class="rg-lede rg-rv">Fixed, quoted in writing before work starts. Government stamp duty and registration fee are statutory charges you pay directly to the state — they never route through us.</p>
        <div class="rg-fees-grid">
            @foreach ($pricing as $p)
                <div class="rg-fee-card rg-rv">
                    <div class="rg-fee-title">{{ $p['item'] }}</div>
                    <div class="rg-fee-note">{{ $p['note'] }}</div>
                    <a href="https://wa.me/{{ ltrim($phone,'+') }}?text={{ $waText }}" class="rg-fee-cta" target="_blank" rel="nofollow noopener">
                        <svg width="15" height="15" viewBox="0 0 32 32" fill="currentColor"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 1 0 16 3zm5.8 18.7c-.3-.2-1.9-.9-2.2-1s-.5-.2-.7.2-.8 1-1 1.2-.4.2-.7.1a8.7 8.7 0 0 1-4.3-3.7c-.3-.6.3-.5.9-1.7.1-.2 0-.4 0-.6l-1-2.3c-.2-.6-.5-.5-.7-.5h-.6a1.2 1.2 0 0 0-.8.4 3.5 3.5 0 0 0-1.1 2.6 6.1 6.1 0 0 0 1.3 3.2 13.9 13.9 0 0 0 5.3 4.7c2 .8 2.7.9 3.7.7a3.1 3.1 0 0 0 2-1.4 2.5 2.5 0 0 0 .2-1.4c-.1-.2-.3-.3-.6-.4z"/></svg>
                        WhatsApp for fee →
                    </a>
                </div>
            @endforeach
        </div>
        <div class="rg-fees-note rg-rv">
            Fees confirmed in writing before any work starts. WhatsApp us at
            <a href="https://wa.me/{{ ltrim($phone,'+') }}?text={{ $waText }}" target="_blank" rel="nofollow noopener">{{ $phoneDisp }}</a>
            with the deed type and property details for a quote.
        </div>
    </div>
</section>

<section class="rg-section" id="FAQs">
    <div class="rg-container">
        <span class="rg-label rg-rv">FAQs</span>
        <h2 class="rg-h2 rg-rv">Frequently asked questions</h2>
        <p class="rg-lede rg-rv">Answers to what buyers ask before a {{ $city }} registry.</p>
        <div class="rg-faq rg-rv">
            @foreach ($faqs as $faq)
                <div class="rg-faq-item">
                    <button class="rg-faq-btn{{ $loop->first ? ' open' : '' }}" type="button" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $faq['q'] }}
                        <svg class="rg-faq-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="rg-faq-body{{ $loop->first ? ' open' : '' }}">{{ $faq['a'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="rg-section rg-section--alt">
    <div class="rg-container">
        <span class="rg-label rg-rv">Read Before You Register</span>
        <h2 class="rg-h2 rg-rv">Useful resources</h2>
        <div class="rg-related">
            @foreach ($relatedLinks as $i => $rl)
                <a href="{{ $rl['href'] }}" class="rg-related-link rg-rv" @if($i) style="--rd:{{ $i * 0.06 }}s" @endif>
                    <span class="rg-related-tag">{{ $rl['tag'] }}</span>
                    <strong class="rg-related-title">{!! $rl['title'] !!}</strong>
                    <span class="rg-related-arrow">{{ $rl['arrow'] ?? 'Read →' }}</span>
                </a>
            @endforeach
        </div>
        <p class="rg-disclaimer">Deed drafting and Sub-Registrar attendance are carried out by advocates enrolled with the Bar Council, acting in their professional capacity. DSD Properties is a property services company and does not itself practise law or represent clients in court. Stamp duty rates, circle rates and concessions are set by the Government of Uttar Pradesh and change by notification — figures on this page are indicative and are verified against IGRSUP for each transaction. Nothing here is legal advice.</p>
    </div>
</section>

<div class="rg-mob-cta" id="rgMobCta">
    <a href="https://wa.me/{{ ltrim($phone,'+') }}?text={{ $waText }}" class="whatsapp" target="_blank" rel="nofollow noopener">
        <svg width="15" height="15" viewBox="0 0 32 32" fill="currentColor" style="vertical-align:-2px;margin-right:4px"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 1 0 16 3zm5.8 18.7c-.3-.2-1.9-.9-2.2-1s-.5-.2-.7.2-.8 1-1 1.2-.4.2-.7.1a8.7 8.7 0 0 1-4.3-3.7c-.3-.6.3-.5.9-1.7.1-.2 0-.4 0-.6l-1-2.3c-.2-.6-.5-.5-.7-.5h-.6a1.2 1.2 0 0 0-.8.4 3.5 3.5 0 0 0-1.1 2.6 6.1 6.1 0 0 0 1.3 3.2 13.9 13.9 0 0 0 5.3 4.7c2 .8 2.7.9 3.7.7a3.1 3.1 0 0 0 2-1.4 2.5 2.5 0 0 0 .2-1.4c-.1-.2-.3-.3-.6-.4z"/></svg>
        WhatsApp
    </a>
    <a href="tel:{{ $phone }}" class="call">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:4px"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1z"/></svg>
        Call Us
    </a>
</div>

</div>

<script>
(function(){
    var els=document.querySelectorAll('.rg-rv');
    if('IntersectionObserver' in window){var io=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('visible');io.unobserve(e.target)}})},{threshold:.12});els.forEach(function(el){io.observe(el)})}else{els.forEach(function(el){el.classList.add('visible')})}
    document.querySelectorAll('.rg-faq-btn').forEach(function(btn){btn.addEventListener('click',function(){var body=this.nextElementSibling;var isOpen=this.classList.contains('open');document.querySelectorAll('.rg-faq-btn').forEach(function(b){b.classList.remove('open');b.setAttribute('aria-expanded','false')});document.querySelectorAll('.rg-faq-body').forEach(function(b){b.classList.remove('open')});if(!isOpen){this.classList.add('open');this.setAttribute('aria-expanded','true');body.classList.add('open')}})});
    var cta=document.getElementById('rgMobCta');if(cta&&window.innerWidth<900){window.addEventListener('scroll',function(){if(window.scrollY>400){cta.classList.add('show')}else{cta.classList.remove('show')}},{passive:true})}
})();
</script>
