@extends('layouts.user-app')

@section('title', 'About DSD Properties — Transparent Real Estate Platform in Lucknow')
@section('meta_description', 'Founded by Dheer Singh, DSD Properties brings data-driven transparency to Lucknow real estate. Learn how we started from property fraud frustration to helping thousands make informed decisions.')
@section('meta_keywords', 'DSD Properties founder, Dheer Singh real estate, Lucknow property consultant, transparent real estate Lucknow, property fraud prevention, AI property valuation')

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "DSD Properties",
  "image": "{{ asset('images/logo.webp') }}",
  "@id": "{{ url('/') }}",
  "url": "{{ url('/') }}",
  "telephone": "+91-85950-02933",
  "email": "dheer@dsdproperties.in",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "postalCode": "226025",
    "addressRegion": "Uttar Pradesh",
    "addressCountry": "IN"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": 26.8467, "longitude": 80.9462 },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
    "opens": "09:00", "closes": "18:00"
  },
  "sameAs": ["https://www.linkedin.com/in/dheer-singh-416370137/"],
  "founder": {
    "@type": "Person",
    "name": "Dheer Singh",
    "jobTitle": "Founder & Real Estate Consultant",
    "alumniOf": "APJ Abdul Kalam Technological University",
    "knowsAbout": ["Real Estate", "Property Valuation", "Software Development", "Data Analysis"],
    "url": "https://www.linkedin.com/in/dheer-singh-416370137/"
  },
  "areaServed": { "@type": "City", "name": "Lucknow", "sameAs": "https://en.wikipedia.org/wiki/Lucknow" },
  "priceRange": "Free - ₹5000",
  "paymentAccepted": ["Cash", "UPI", "Bank Transfer"],
  "currenciesAccepted": "INR"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "Dheer Singh",
  "jobTitle": "Founder & Real Estate Consultant at DSD Properties",
  "worksFor": { "@type": "Organization", "name": "DSD Properties" },
  "alumniOf": { "@type": "CollegeOrUniversity", "name": "APJ Abdul Kalam Technological University" },
  "knowsAbout": ["Real Estate in Lucknow", "Property Valuation", "RERA Compliance", "LDA Schemes", "Property Documentation"],
  "address": { "@type": "PostalAddress", "addressLocality": "Lucknow", "addressRegion": "Uttar Pradesh", "addressCountry": "IN" },
  "sameAs": "https://www.linkedin.com/in/dheer-singh-416370137/"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home",  "item": "{{ url('/') }}" },
    { "@type": "ListItem", "position": 2, "name": "About", "item": "{{ url('/about') }}" }
  ]
}
</script>
@endpush

@section('content')
<style>
:root {
    --ab-navy:#011f4b; --ab-teal:#008080; --ab-orange:#FF5C00;
    --ab-t1:var(--text-primary,#111827); --ab-t2:var(--text-secondary,#4b5563); --ab-t3:var(--text-tertiary,#9ca3af);
    --ab-card:var(--card-bg,#fff); --ab-border:var(--border-color,#e5e7eb);
    --ab-bg:var(--bg-primary,#fff); --ab-bg2:var(--bg-secondary,#f3f4f6);
    --ab-teal-bg:var(--color-light-teal,#e0f2f1);
}
.ab { font-family:'Poppins',sans-serif; overflow-x:hidden; }
.ab-c { max-width:1100px; margin:0 auto; padding:0 24px; }

/* reveal */
@keyframes ab-up { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:none} }
.ab-rv { opacity:0; transform:translateY(22px); transition:opacity .6s ease, transform .6s ease; transition-delay:var(--rd,0s); }
.ab-rv.visible { opacity:1; transform:none; }

/* ── HERO ── */
.ab-hero {
    position:relative; overflow:hidden;
    background:linear-gradient(135deg,#011f4b 0%,#013870 45%,#005f6b 100%);
    padding:96px 0 0;
}
.ab-hero__grid {
    position:absolute; inset:0;
    background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
                     linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
    background-size:50px 50px;
}
@keyframes ab-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
.ab-orb { position:absolute; border-radius:50%; filter:blur(90px); pointer-events:none; }
.ab-orb--a { width:480px;height:480px;background:rgba(0,128,128,.22);top:-120px;right:-80px;animation:ab-float 9s ease-in-out infinite; }
.ab-orb--b { width:320px;height:320px;background:rgba(255,92,0,.13);bottom:40px;left:-60px;animation:ab-float 11s ease-in-out infinite 3s; }

.ab-hero__inner { position:relative;z-index:2;text-align:center;padding-bottom:64px; }

.ab-hero__badge {
    display:inline-flex;align-items:center;gap:8px;
    background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);
    border-radius:99px;padding:6px 16px;margin-bottom:22px;
    font-size:11px;font-weight:500;color:rgba(255,255,255,.82);backdrop-filter:blur(8px);
}
.ab-hero__badge span { width:7px;height:7px;border-radius:50%;background:#4ade80;display:inline-block; }

.ab-hero__h1 {
    font-size:clamp(1.9rem,4vw,3rem);font-weight:800;color:#fff;
    line-height:1.14;margin-bottom:18px;letter-spacing:-.4px;
}
.ab-hero__h1 em { font-style:normal;color:#FF5C00; }
.ab-hero__sub {
    font-size:.95rem;color:rgba(255,255,255,.68);
    line-height:1.82;max-width:580px;margin:0 auto 36px;
}
.ab-hero__cta { display:flex;gap:12px;justify-content:center;flex-wrap:wrap; }

.ab-btn {
    display:inline-flex;align-items:center;gap:8px;
    font-family:'Poppins',sans-serif;font-weight:600;border-radius:11px;
    text-decoration:none;cursor:pointer;transition:all .22s;border:none;
    padding:13px 26px;font-size:.88rem;
}
.ab-btn--primary { background:linear-gradient(135deg,#FF5C00,#ff8840);color:#fff;box-shadow:0 5px 20px rgba(255,92,0,.3); }
.ab-btn--primary:hover { transform:translateY(-2px);box-shadow:0 8px 28px rgba(255,92,0,.42);color:#fff;text-decoration:none; }
.ab-btn--ghost { background:rgba(255,255,255,.1);color:rgba(255,255,255,.85);border:1px solid rgba(255,255,255,.22); }
.ab-btn--ghost:hover { background:rgba(255,255,255,.18);color:#fff;text-decoration:none; }

.ab-hero__stats {
    display:flex;justify-content:center;gap:40px;flex-wrap:wrap;
    padding:28px 0;border-top:1px solid rgba(255,255,255,.1);
}
.ab-hero__stat-val { font-size:1.6rem;font-weight:800;color:#fff;line-height:1; }
.ab-hero__stat-val em { font-style:normal;color:#FF5C00; }
.ab-hero__stat-lbl { font-size:.7rem;color:rgba(255,255,255,.5);margin-top:4px;text-transform:uppercase;letter-spacing:1px; }

.ab-wave { line-height:0; }
.ab-wave svg { display:block;width:100%; }

/* ── LABELS / HEADINGS ── */
.ab-slabel { font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--ab-teal);margin-bottom:10px; }
.ab-stitle { font-size:clamp(1.45rem,2.8vw,2.1rem);font-weight:800;color:var(--ab-t1);line-height:1.18;margin-bottom:10px; }
.ab-ssub   { font-size:.88rem;color:var(--ab-t2);max-width:540px;margin:0 auto 48px;line-height:1.75; }

/* ── FOUNDER ── */
.ab-founder { display:grid;grid-template-columns:1fr 1.4fr;gap:56px;align-items:center;max-width:960px;margin:0 auto; }
@media(max-width:760px){ .ab-founder{grid-template-columns:1fr;gap:32px} }

.ab-founder__img-wrap { position:relative; }
.ab-founder__img {
    width:100%;border-radius:20px;box-shadow:0 24px 64px rgba(0,0,0,.13);
    display:block;object-fit:cover;
}
.ab-founder__badge {
    position:absolute;bottom:-16px;right:-16px;
    background:var(--ab-card);border:1px solid var(--ab-border);
    border-radius:14px;padding:12px 18px;
    display:flex;align-items:center;gap:10px;
    box-shadow:0 8px 24px rgba(0,0,0,.1);
}
.ab-founder__badge-ico { width:36px;height:36px;border-radius:10px;background:rgba(0,128,128,.1);display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--ab-teal); }
.ab-founder__badge strong { display:block;font-size:.82rem;font-weight:700;color:var(--ab-t1); }
.ab-founder__badge span   { font-size:.72rem;color:var(--ab-t3); }

.ab-founder__body p { font-size:.9rem;color:var(--ab-t2);line-height:1.82;margin-bottom:16px; }
.ab-founder__body p:last-child { margin-bottom:0; }
.ab-founder__name { font-size:1.5rem;font-weight:800;color:var(--ab-t1);margin-bottom:6px; }
.ab-founder__role { font-size:.82rem;color:var(--ab-teal);font-weight:600;letter-spacing:.5px;margin-bottom:20px; }

/* ── TIMELINE CARDS ── */
.ab-timeline { display:flex;flex-direction:column;gap:20px;max-width:800px;margin:0 auto; }
.ab-tl-card {
    display:flex;gap:20px;align-items:flex-start;
    background:var(--ab-card);border:1px solid var(--ab-border);
    border-radius:16px;padding:28px 26px;
    transition:transform .25s,box-shadow .25s,border-color .25s;
    position:relative;overflow:hidden;
}
.ab-tl-card::before {
    content:'';position:absolute;top:0;left:0;width:3px;height:0;
    background:linear-gradient(to bottom,var(--ab-teal),var(--ab-orange));
    transition:height .3s;
}
.ab-tl-card:hover::before { height:100%; }
.ab-tl-card:hover { transform:translateY(-3px);box-shadow:0 12px 36px rgba(0,0,0,.08);border-color:rgba(0,128,128,.22); }

.ab-tl-num {
    width:44px;height:44px;border-radius:50%;flex-shrink:0;
    background:linear-gradient(135deg,var(--ab-navy),var(--ab-teal));
    color:#fff;font-weight:800;font-size:1rem;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 4px 14px rgba(0,128,128,.28);
}
.ab-tl-card h3 { font-size:.97rem;font-weight:700;color:var(--ab-t1);margin-bottom:8px; }
.ab-tl-card p  { font-size:.85rem;color:var(--ab-t2);line-height:1.75;margin:0; }

/* ── FEATURE CARDS ── */
.ab-feat-grid { display:grid;grid-template-columns:1fr 1fr;gap:20px; }
@media(max-width:640px){ .ab-feat-grid{grid-template-columns:1fr} }

.ab-feat {
    background:var(--ab-card);border:1px solid var(--ab-border);
    border-radius:16px;padding:28px 24px;
    transition:transform .25s,box-shadow .25s,border-color .25s;
    position:relative;overflow:hidden;
}
.ab-feat::before {
    content:'';position:absolute;top:0;left:0;width:3px;height:0;
    background:linear-gradient(to bottom,var(--ab-teal),var(--ab-orange));
    transition:height .3s;
}
.ab-feat:hover::before { height:100%; }
.ab-feat:hover { transform:translateY(-4px);box-shadow:0 14px 40px rgba(0,0,0,.08);border-color:rgba(0,128,128,.22); }
.ab-feat__ico {
    width:48px;height:48px;border-radius:12px;
    background:rgba(0,128,128,.1);
    display:flex;align-items:center;justify-content:center;
    font-size:20px;color:var(--ab-teal);margin-bottom:16px;
    transition:transform .25s;
}
.ab-feat:hover .ab-feat__ico { transform:scale(1.1) rotate(-5deg); }
.ab-feat h3 { font-size:.95rem;font-weight:700;color:var(--ab-t1);margin-bottom:8px; }
.ab-feat p  { font-size:.82rem;color:var(--ab-t2);line-height:1.72;margin:0; }

/* ── MISSION / VISION ── */
.ab-mv-grid { display:grid;grid-template-columns:1fr 1fr;gap:22px;max-width:860px;margin:0 auto; }
@media(max-width:620px){ .ab-mv-grid{grid-template-columns:1fr} }

.ab-mv-card {
    border-radius:18px;padding:32px;border:2px solid;background:var(--ab-card);
    transition:transform .25s,box-shadow .25s;
}
.ab-mv-card:hover { transform:translateY(-4px);box-shadow:0 14px 40px rgba(0,0,0,.08); }
.ab-mv-card--mission { border-color:rgba(255,92,0,.2); }
.ab-mv-card--vision  { border-color:rgba(0,128,128,.2); }
.ab-mv-head { display:flex;align-items:center;gap:14px;margin-bottom:16px; }
.ab-mv-ico  { width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0; }
.ab-mv-ico--mission { background:rgba(255,92,0,.1);color:#FF5C00; }
.ab-mv-ico--vision  { background:rgba(0,128,128,.1);color:#008080; }
.ab-mv-card h3 { font-size:1.1rem;font-weight:800;color:var(--ab-t1);margin:0; }
.ab-mv-card p  { font-size:.88rem;color:var(--ab-t2);line-height:1.78;margin:0; }

/* ── WHY CARDS ── */
.ab-why-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:20px;max-width:900px;margin:0 auto; }
@media(max-width:720px){ .ab-why-grid{grid-template-columns:1fr 1fr} }
@media(max-width:480px){ .ab-why-grid{grid-template-columns:1fr} }

.ab-why-card {
    background:var(--ab-card);border:1px solid var(--ab-border);
    border-radius:16px;padding:28px 22px;text-align:center;
    transition:transform .25s,box-shadow .25s,border-color .25s;
}
.ab-why-card:hover { transform:translateY(-4px);box-shadow:0 14px 40px rgba(0,0,0,.08);border-color:rgba(0,128,128,.22); }
.ab-why-ico {
    width:52px;height:52px;border-radius:50%;
    background:linear-gradient(135deg,#FF5C00,#ff8840);
    display:flex;align-items:center;justify-content:center;
    font-size:20px;color:#fff;margin:0 auto 16px;
    box-shadow:0 5px 16px rgba(255,92,0,.28);
}
.ab-why-card h3 { font-size:.9rem;font-weight:700;color:var(--ab-t1);margin-bottom:8px; }
.ab-why-card p  { font-size:.8rem;color:var(--ab-t2);line-height:1.7;margin:0; }

/* ── AREAS ── */
.ab-area-pill {
    padding:8px 18px;background:var(--ab-card);border:1px solid var(--ab-border);
    border-radius:99px;font-size:.8rem;font-weight:500;color:var(--ab-t2);
    transition:all .2s;cursor:default;
}
.ab-area-pill:hover { border-color:var(--ab-teal);color:var(--ab-teal);background:rgba(0,128,128,.05); }

/* ── CTA ── */
.ab-cta {
    position:relative;overflow:hidden;
    background:linear-gradient(135deg,#011f4b 0%,#013870 50%,#005f6b 100%);
    padding:80px 0;text-align:center;
}
.ab-cta__grid {
    position:absolute;inset:0;
    background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
                     linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
    background-size:50px 50px;
}
.ab-cta__inner { position:relative;z-index:2; }
.ab-cta h2 { font-size:clamp(1.5rem,3vw,2.2rem);font-weight:800;color:#fff;margin-bottom:14px; }
.ab-cta h2 em { font-style:normal;color:#FF5C00; }
.ab-cta p  { font-size:.92rem;color:rgba(255,255,255,.68);max-width:520px;margin:0 auto 32px;line-height:1.8; }
</style>

{{-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ --}}
<section class="ab ab-hero">
    <div class="ab-hero__grid"></div>
    <div class="ab-orb ab-orb--a"></div>
    <div class="ab-orb ab-orb--b"></div>

    <div class="ab-c ab-hero__inner">
        <div class="ab-hero__badge">
            <span></span> Est. 2024 — Lucknow's Transparent Property Platform
        </div>

        <h1 class="ab-hero__h1">
            Bringing <em>Transparency</em><br>to Lucknow Real Estate
        </h1>
        <p class="ab-hero__sub">
            Buying property in Lucknow shouldn't feel like a gamble. At DSD Properties, we give you clear, honest, and data-driven information so you can make the right decision — without stress or confusion.
        </p>

        <div class="ab-hero__cta">
            <a href="/" class="ab-btn ab-btn--primary">
                Get Free Property Estimate
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="/contact-us" class="ab-btn ab-btn--ghost">Schedule Consultation</a>
        </div>

        <div class="ab-hero__stats">
            <div>
                <div class="ab-hero__stat-val">1<em>yr</em></div>
                <div class="ab-hero__stat-lbl">In the Market</div>
            </div>
            <div>
                <div class="ab-hero__stat-val">5<em>k+</em></div>
                <div class="ab-hero__stat-lbl">Buyers Helped</div>
            </div>
            <div>
                <div class="ab-hero__stat-val">26<em>+</em></div>
                <div class="ab-hero__stat-lbl">Areas Covered</div>
            </div>
            <div>
                <div class="ab-hero__stat-val">100<em>%</em></div>
                <div class="ab-hero__stat-lbl">Unbiased Advice</div>
            </div>
        </div>
    </div>

    <div class="ab-wave">
        <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 56L1440 56L1440 28C1200 0 960 0 720 28C480 56 240 56 0 28L0 56Z" fill="var(--bg-primary,#fff)"/>
        </svg>
    </div>
</section>

{{-- ════════════════════════════════════════
     FOUNDER
════════════════════════════════════════ --}}
<section class="ab" style="padding:80px 0;background:var(--bg-primary);">
    <div class="ab-c">
        <div class="ab-founder">
            <div class="ab-founder__img-wrap ab-rv" style="--rd:.05s">
                <img src="{{ asset('images/DSDProperties3.webp') }}"
                     alt="Dheer Singh — Founder of DSD Properties"
                     class="ab-founder__img" width="400" height="400" loading="lazy">
                <div class="ab-founder__badge">
                    <div class="ab-founder__badge-ico"><i class="fas fa-code"></i></div>
                    <div>
                        <strong>Software → Real Estate</strong>
                        <span>Senior Dev turned Founder</span>
                    </div>
                </div>
            </div>

            <div class="ab-rv" style="--rd:.15s">
                <p class="ab-slabel">The Founder</p>
                <h2 class="ab-stitle" style="text-align:left;margin-bottom:4px;">Meet Dheer Singh</h2>
                <p class="ab-founder__role">Founder &amp; Real Estate Consultant</p>

                <p class="ab-founder__body" style="font-size:.9rem;color:var(--ab-t2);line-height:1.82;margin-bottom:16px;">
                    Hi, I'm Dheer Singh, founder of DSD Properties. Before this, I worked as a Senior Software Developer, where I built a strong understanding of data, systems, and solving real-world problems.
                </p>
                <p class="ab-founder__body" style="font-size:.9rem;color:var(--ab-t2);line-height:1.82;margin-bottom:16px;">
                    In early 2024, I started looking for a property in Lucknow and experienced first-hand how unstructured the market is. For the same property, I received completely different price quotes from different dealers. Even basic registration costs had no clear explanation.
                </p>
                <p class="ab-founder__body" style="font-size:.9rem;color:var(--ab-t2);line-height:1.82;margin-bottom:28px;">
                    That's when I realized — buyers don't lack options, they lack clarity. DSD Properties started from that realization, with a focus on making property buying more transparent and understandable.
                </p>

                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="/contact-us" class="ab-btn ab-btn--primary" style="font-size:.82rem;padding:11px 20px;">
                        Talk to Dheer
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/in/dheer-singh-416370137/" target="_blank" rel="noopener"
                       style="display:inline-flex;align-items:center;gap:8px;padding:11px 20px;border-radius:11px;border:1.5px solid var(--ab-border);font-size:.82rem;font-weight:600;color:var(--ab-t2);text-decoration:none;transition:all .2s;font-family:'Poppins',sans-serif;">
                        <i class="fab fa-linkedin" style="color:#0077b5;"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     ORIGIN STORY
════════════════════════════════════════ --}}
<section class="ab" style="padding:80px 0;background:var(--color-light-teal,#e0f2f1);">
    <div class="ab-c">
        <div class="text-center mb-12 ab-rv" style="--rd:.05s">
            <p class="ab-slabel">Our Journey</p>
            <h2 class="ab-stitle">How We Started</h2>
            <p class="ab-ssub">Every great business solves a real problem. Here's the one that led to DSD Properties.</p>
        </div>

        <div class="ab-timeline">
            <div class="ab-tl-card ab-rv" style="--rd:.1s">
                <div class="ab-tl-num">1</div>
                <div>
                    <h3>March 2024 — When the Confusion Started</h3>
                    <p>While searching for a plot on Raebareli Road, I noticed something unusual. Similar plots had price differences of 8–12 lakh depending on who I asked. Even registration estimates varied wildly. It became impossible to know what the actual price should be.</p>
                </div>
            </div>

            <div class="ab-tl-card ab-rv" style="--rd:.18s">
                <div class="ab-tl-num">2</div>
                <div>
                    <h3>April–May 2024 — Understanding the Market</h3>
                    <p>Instead of relying on random quotes, I started exploring myself. I visited different areas, spoke to buyers, and tried to understand how pricing actually works. One thing became clear — most people end up overpaying simply because they don't have the right information.</p>
                </div>
            </div>

            <div class="ab-tl-card ab-rv" style="--rd:.26s">
                <div class="ab-tl-num">3</div>
                <div>
                    <h3>June 2024 — Starting DSD Properties</h3>
                    <p>I realized this problem is common for almost every buyer. That's when I decided to build something that could help people get straightforward, unbiased information. DSD Properties started with one aim — making property buying simpler and more transparent for Lucknow buyers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     WHAT WE OFFER
════════════════════════════════════════ --}}
<section class="ab" style="padding:80px 0;background:var(--bg-primary);">
    <div class="ab-c">
        <div class="text-center mb-12 ab-rv" style="--rd:.05s">
            <p class="ab-slabel">Our Services</p>
            <h2 class="ab-stitle">What DSD Properties Offers</h2>
            <p class="ab-ssub">Clear, practical, and honest information to help you make better property decisions — without confusion or pressure.</p>
        </div>

        <div class="ab-feat-grid" style="max-width:880px;margin:0 auto;">
            <div class="ab-feat ab-rv" style="--rd:.1s">
                <div class="ab-feat__ico"><i class="fas fa-calculator"></i></div>
                <h3>AI-Powered Property Valuation</h3>
                <p>Get a realistic idea of property prices based on current market trends in Lucknow — helping you understand whether a deal is fairly priced before you commit.</p>
            </div>

            <div class="ab-feat ab-rv" style="--rd:.17s">
                <div class="ab-feat__ico"><i class="fas fa-shield-alt"></i></div>
                <h3>Property Document Verification</h3>
                <p>We help you check ownership, approvals, and legal status so you can move forward with confidence — missing one document can cause serious problems later.</p>
            </div>

            <div class="ab-feat ab-rv" style="--rd:.24s">
                <div class="ab-feat__ico"><i class="fas fa-newspaper"></i></div>
                <h3>Market Insights &amp; Blog</h3>
                <p>Regular, simple insights about the Lucknow real estate market — covering areas, pricing trends, government schemes, and things every buyer should know.</p>
            </div>

            <div class="ab-feat ab-rv" style="--rd:.31s">
                <div class="ab-feat__ico"><i class="fas fa-handshake"></i></div>
                <h3>Free Expert Consultation</h3>
                <p>Confused about where to invest or what to check? Talk to us directly — we'll guide you based on your needs without pushing you toward any specific property.</p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     MISSION & VISION
════════════════════════════════════════ --}}
<section class="ab" style="padding:80px 0;background:var(--color-light-teal,#e0f2f1);">
    <div class="ab-c">
        <div class="text-center mb-12 ab-rv" style="--rd:.05s">
            <p class="ab-slabel">What Drives Us</p>
            <h2 class="ab-stitle">Mission &amp; Vision</h2>
        </div>

        <div class="ab-mv-grid">
            <div class="ab-mv-card ab-mv-card--mission ab-rv" style="--rd:.1s">
                <div class="ab-mv-head">
                    <div class="ab-mv-ico ab-mv-ico--mission"><i class="fas fa-bullseye"></i></div>
                    <h3>Mission</h3>
                </div>
                <p>To reduce confusion in Lucknow's real estate market by sharing clear, honest, and practical information that actually helps buyers make better decisions — and avoid costly mistakes.</p>
            </div>

            <div class="ab-mv-card ab-mv-card--vision ab-rv" style="--rd:.18s">
                <div class="ab-mv-head">
                    <div class="ab-mv-ico ab-mv-ico--vision"><i class="fas fa-eye"></i></div>
                    <h3>Vision</h3>
                </div>
                <p>To build a platform that people trust when they think about buying property in Lucknow — a place where guidance is honest, simple, and based on real understanding of the market.</p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     WHY TRUST US
════════════════════════════════════════ --}}
<section class="ab" style="padding:80px 0;background:var(--bg-primary);">
    <div class="ab-c">
        <div class="text-center mb-12 ab-rv" style="--rd:.05s">
            <p class="ab-slabel">Why Choose Us</p>
            <h2 class="ab-stitle">Why Buyers Trust DSD Properties</h2>
            <p class="ab-ssub">We're different from traditional real estate agents and brokers.</p>
        </div>

        <div class="ab-why-grid">
            <div class="ab-why-card ab-rv" style="--rd:.1s">
                <div class="ab-why-ico"><i class="fas fa-chart-line"></i></div>
                <h3>Data-Driven Approach</h3>
                <p>Our insights are based on actual market trends and real observations — not guesswork — so you get a clearer picture before deciding.</p>
            </div>

            <div class="ab-why-card ab-rv" style="--rd:.17s">
                <div class="ab-why-ico"><i class="fas fa-ban"></i></div>
                <h3>Zero Agent Bias</h3>
                <p>We don't push properties just to close deals. The focus is on helping you make the right decision, even if that means waiting or exploring more options.</p>
            </div>

            <div class="ab-why-card ab-rv" style="--rd:.24s">
                <div class="ab-why-ico"><i class="fas fa-sync"></i></div>
                <h3>Always Updated</h3>
                <p>The market keeps changing, so we keep updating our content regularly to reflect what's actually happening on the ground in Lucknow.</p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     AREAS WE COVER
════════════════════════════════════════ --}}
<section class="ab" style="padding:80px 0;background:var(--color-light-teal,#e0f2f1);">
    <div class="ab-c">
        <div class="text-center mb-12 ab-rv" style="--rd:.05s">
            <p class="ab-slabel">Coverage</p>
            <h2 class="ab-stitle">Areas We Cover in Lucknow</h2>
            <p class="ab-ssub">We cover major residential and investment areas across Lucknow — helping buyers understand pricing, growth potential, and ground reality.</p>
        </div>

        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:10px;max-width:860px;margin:0 auto;" class="ab-rv" style="--rd:.1s">
            @foreach([
                'Gomti Nagar','Gomti Nagar Extension','Hazratganj','Aliganj','Indira Nagar',
                'Jankipuram','Mahanagar','Ashiyana','Rajajipuram','Chinhat','Faizabad Road',
                'Sultanpur Road','Raebareli Road','Kanpur Road','Sitapur Road',
                'Amar Shaheed Path','Vrindavan Yojna','Sushant Golf City','Mohanlalganj',
                'Bijnor Road','IIM Road','Kursi Road','Dubagga','Hardoi Road','Malhaur','Deva Road'
            ] as $area)
            <span class="ab-area-pill">{{ $area }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     CTA
════════════════════════════════════════ --}}
<section class="ab ab-cta">
    <div class="ab-cta__grid"></div>
    <div class="ab-c ab-cta__inner">
        <div class="ab-rv" style="--rd:.05s">
            <p class="ab-slabel" style="color:rgba(255,255,255,.5);">Take the Next Step</p>
            <h2>Ready to Buy Property <em>with Confidence?</em></h2>
            <p>Get clear property insights and honest guidance for any location in Lucknow. No pressure, no confusing information — just practical help so you can make the right decision.</p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="/" class="ab-btn ab-btn--primary">
                    Get Free Property Estimate
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="/contact-us" class="ab-btn ab-btn--ghost">Schedule Free Consultation</a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.ab-rv').forEach(el => observer.observe(el));
});
</script>
@endsection
