@extends('layouts.user-app')
@section('title', 'LDA Demolition Tracker Lucknow 2026 — Is Your Property Safe?')
@section('meta_description', 'Source-linked tracker of LDA demolitions, illegal plotting drives and sealing actions in Lucknow (2024–2026): Kakori, Dubagga, Gosainganj, BKT, Sushant Golf City, Aliganj. Check before you buy.')
@section('meta_keywords', 'LDA demolition Lucknow, illegal colony demolished Lucknow, LDA bulldozer action Lucknow, LDA encroachment Lucknow, property verification Lucknow, illegal plotting Lucknow, LDA demolition tracker 2026, safe property Lucknow, LDA approved plot Lucknow, bulldozer action Lucknow 2026')

@push('head')
<link rel="canonical" href="{{ url('/lda-demolition-tracker') }}">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type":"ListItem","position":1,"name":"Home","item":"{{ url('/') }}"},
    {"@type":"ListItem","position":2,"name":"LDA Demolition Tracker","item":"{{ url('/lda-demolition-tracker') }}"}
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "LDA Demolition Tracker Lucknow 2024–2026",
  "description": "Tracker of {{ count($items) }} LDA demolition, illegal plotting and sealing actions in Lucknow from 2024 to 2026, each linked to its news report.",
  "url": "{{ url('/lda-demolition-tracker') }}",
  "dateModified": "{{ \Carbon\Carbon::parse($items[0]['date'] ?? now())->toDateString() }}",
  "inLanguage": "en-IN",
  "publisher": {
    "@type": "Organization",
    "name": "DSD Properties",
    "url": "{{ url('/') }}",
    "logo": {"@type":"ImageObject","url":"{{ asset('images/logo.webp') }}"}
  }
}
</script>

@php $topItems = array_slice($items, 0, 10); @endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "LDA Demolition Incidents Lucknow 2024–2026",
  "description": "Major LDA demolition and enforcement actions in Lucknow from 2024 to 2026",
  "numberOfItems": {{ count($items) }},
  "itemListElement": [
    @foreach($topItems as $idx => $item)
    {
      "@type": "ListItem",
      "position": {{ $idx + 1 }},
      "name": {!! json_encode($item['headline']) !!},
      "url": {!! json_encode($item['source_url']) !!}
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Which areas in Lucknow have the highest LDA demolition risk?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "In the incidents tracked from 2024 to 2026, LDA's illegal-plotting drives were most frequent in Kakori, Dubagga, BKT, Gosainganj, Chinhat, Sushant Golf City, Sairpur and Mohanlalganj. In 2026, Aliganj also saw large-scale sealing of commercial buildings on residential plots after the June fire. Many of these areas fall inside or next to proposed LDA schemes such as Naimish Nagar and Varun Vihar. Always verify layout approval before buying here."
      }
    },
    {
      "@type": "Question",
      "name": "What happens to buyers if an illegal colony is demolished by LDA in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "When LDA demolishes an unauthorised plotting, it razes the roads, drains, boundary walls and site offices built without layout approval. There is no LDA scheme to compensate plot buyers in such colonies. Their remedy is against the seller, through a police complaint or a civil suit. Compensation is paid only when LDA acquires land for its own scheme, as in the Anant Nagar possession drive."
      }
    },
    {
      "@type": "Question",
      "name": "How can I check if a plot is LDA approved in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "To verify LDA approval: (1) Visit the LDA office at Vipin Khand, Gomti Nagar and ask for a layout approval check on the specific khasra number. (2) Book DSD Properties' property verification (₹5,000 for residential plots and flats). We check LDA records, revenue documents and RERA registration and send a PDF report within 48 hours."
      }
    },
    {
      "@type": "Question",
      "name": "What is an illegal colony and how to identify one in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "An illegal colony is land subdivided and sold as plots without obtaining LDA layout approval. Key warning signs: no LDA approval number on documents, kisan/agricultural land being sold as residential, prices significantly lower than nearby approved areas, developer avoids providing official registry paperwork, and no RERA registration for the project."
      }
    },
    {
      "@type": "Question",
      "name": "Does LDA compensate buyers whose properties are demolished?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No. LDA has no scheme to compensate buyers of unauthorised plotting or construction it demolishes or seals. Liability rests with whoever sold or built without approval. Recovering money from such sellers is slow and uncertain, so checking approval before purchase is the only real protection."
      }
    },
    {
      "@type": "Question",
      "name": "What documents must I verify before buying a plot in Lucknow?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Essential checks before buying any plot in Lucknow: (1) LDA Layout Approval Letter with scheme number, (2) Jamabandi/Khatoni from Revenue Department, (3) Encumbrance Certificate for outstanding loans, (4) RERA registration certificate for ongoing projects, (5) Complete chain of title/sale deeds, (6) Construction NOC from LDA, (7) Land use conversion order if agricultural land is involved."
      }
    },
    {
      "@type": "Question",
      "name": "Is Sushant Golf City safe to buy property in 2026?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "On 15 September 2026 the UP cabinet approved LDA's proposal on 2,747 plots that Ansal sold while they were mortgaged to LDA. LDA says the registries of these plots will not be cancelled, and the takeover still needs NCLT approval. Separately, LDA has repeatedly demolished illegal plotting in villages around the township, such as Bakkas, Mastemau, Malukpur and Sikandarpur Amolia, including 65 bighas on 16 October 2026. Verify which part of the area a plot is in before buying."
      }
    },
    {
      "@type": "Question",
      "name": "How quickly can LDA demolish a property after issuing notice?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "It can take only a few weeks. In the Aliganj fire case, LDA issued a Section 27(1) notice on 23 June 2026 giving 15 days to show the building was legal. The prescribed authority declared it illegal on 10 July and gave the owners 15 days to demolish it themselves. Most illegal-plotting demolitions in this tracker were carried out on orders already passed by the prescribed authority court."
      }
    }
  ]
}
</script>

<style>
/* ── Root ── */
:root {
  --navy: #011f4b;
  --teal: #008080;
  --red:  #dc2626;
  --org:  #ea580c;
  --yel:  #d97706;
  --bg:   #f8f9fb;
  --card: #ffffff;
  --bdr:  #e5e7eb;
  --r:    14px;
}
.demo-page { background: var(--bg); font-family: 'Poppins', sans-serif; }
.demo-page *, .demo-page *::before, .demo-page *::after { box-sizing: border-box; }

/* ── Breadcrumb ── */
.demo-breadcrumb {
  background: #fff; border-bottom: 1px solid var(--bdr);
  padding: 10px 0;
}
.demo-breadcrumb-inner {
  max-width: 1120px; margin: 0 auto; padding: 0 20px;
  display: flex; align-items: center; gap: 6px;
  font-size: 12.5px; color: #6b7280; flex-wrap: wrap;
}
.demo-breadcrumb-inner a { color: var(--teal); text-decoration: none; }
.demo-breadcrumb-inner a:hover { text-decoration: underline; }
.demo-breadcrumb-inner .sep { color: #d1d5db; }
.demo-breadcrumb-inner .current { color: #374151; font-weight: 600; }

/* ── Hero ── */
.demo-hero {
  background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #1a0a0a 100%);
  padding: 70px 20px 56px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.demo-hero::before {
  content: '';
  position: absolute; inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23dc2626' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  pointer-events: none;
}
.demo-hero-badge {
  display: inline-flex; align-items: center; gap: 7px;
  background: rgba(220,38,38,.15); border: 1px solid rgba(220,38,38,.35);
  color: #fca5a5; padding: 6px 16px; border-radius: 99px;
  font-size: 12px; font-weight: 700; letter-spacing: .5px;
  margin-bottom: 22px; text-transform: uppercase;
}
.demo-hero h1 {
  font-size: clamp(26px, 5vw, 42px); font-weight: 900; color: #fff;
  line-height: 1.2; margin: 0 0 16px; max-width: 820px; margin-inline: auto;
}
.demo-hero h1 span { color: #f87171; }
.demo-hero-sub {
  font-size: 16px; color: rgba(255,255,255,.7); max-width: 640px;
  margin: 0 auto 34px; line-height: 1.75;
}

/* Stats row */
.demo-stats {
  display: flex; flex-wrap: wrap; justify-content: center; gap: 14px;
  margin-bottom: 36px;
}
.demo-stat {
  background: rgba(255,255,255,.07); backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,.12); border-radius: 12px;
  padding: 16px 24px; text-align: center; min-width: 120px;
}
.demo-stat-num { font-size: 28px; font-weight: 900; color: #f87171; display: block; line-height: 1; }
.demo-stat-lbl { font-size: 11px; color: rgba(255,255,255,.55); text-transform: uppercase; letter-spacing: .6px; margin-top: 5px; display: block; }
.demo-stat.teal .demo-stat-num { color: #5eead4; }
.demo-stat.org  .demo-stat-num { color: #fdba74; }
.demo-stat.wht  .demo-stat-num { color: #e0e7ff; }

/* Hero CTAs */
.demo-hero-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-hero-primary {
  display: inline-flex; align-items: center; gap: 8px;
  background: #dc2626; color: #fff; padding: 13px 26px; border-radius: 10px;
  font-weight: 700; font-size: 15px; text-decoration: none; transition: background .15s;
}
.btn-hero-primary:hover { background: #b91c1c; color: #fff; }
.btn-hero-secondary {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,.1); color: #fff; border: 1.5px solid rgba(255,255,255,.25);
  padding: 13px 26px; border-radius: 10px; font-weight: 600; font-size: 15px;
  text-decoration: none; transition: all .15s;
}
.btn-hero-secondary:hover { background: rgba(255,255,255,.18); color: #fff; }

/* ── Warning Banner ── */
.demo-warning-bar {
  background: linear-gradient(90deg, #7f1d1d, #991b1b);
  padding: 14px 20px; text-align: center;
  font-size: 13.5px; font-weight: 600; color: #fecaca;
  display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap;
}

/* ── Main wrap ── */
.demo-wrap { max-width: 1120px; margin: 0 auto; padding: 40px 20px 80px; }

/* ── Section H2 ── */
.demo-sec-h2 {
  font-size: 22px; font-weight: 800; color: var(--navy); margin: 0 0 8px;
  display: flex; align-items: center; gap: 10px;
}
.demo-sec-sub {
  font-size: 14px; color: #6b7280; margin: 0 0 28px; line-height: 1.6;
}
.demo-sec-divider {
  width: 48px; height: 3px; background: var(--teal); border-radius: 2px; margin-bottom: 10px;
}

/* ── Filter bar ── */
.demo-filter-bar {
  display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
  background: #fff; border: 1px solid var(--bdr); border-radius: 10px;
  padding: 12px 16px; margin-bottom: 20px;
}
.demo-filter-label { font-size: 12px; font-weight: 700; color: var(--navy); margin-right: 4px; white-space: nowrap; }
.demo-filter-btn {
  font-size: 12px; font-weight: 600; padding: 5px 14px; border-radius: 99px;
  border: 1.5px solid var(--bdr); background: #fff; color: #374151;
  cursor: pointer; transition: all .15s; font-family: 'Poppins', sans-serif;
}
.demo-filter-btn:hover { border-color: var(--teal); color: var(--teal); }
.demo-filter-btn.active { background: var(--navy); border-color: var(--navy); color: #fff; }
.demo-filter-btn.critical.active { background: #dc2626; border-color: #dc2626; }
.demo-filter-btn.high.active    { background: #ea580c; border-color: #ea580c; }
.demo-filter-btn.medium.active  { background: #d97706; border-color: #d97706; }
.demo-filter-sep { width: 1px; height: 20px; background: var(--bdr); margin: 0 4px; }

/* ── Cards grid ── */
.demo-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
@media (max-width: 900px) { .demo-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .demo-grid { grid-template-columns: minmax(0, 1fr); } }
.demo-card-hidden { display: none !important; }

/* ── News card ── */
.demo-card * { min-width: 0; overflow-wrap: break-word; }
.demo-card {
  background: var(--card); border-radius: var(--r); border: 1.5px solid var(--bdr);
  overflow: hidden; display: flex; flex-direction: column;
  box-shadow: 0 2px 12px rgba(1,31,75,.06);
  transition: transform .2s, box-shadow .2s;
  position: relative; min-width: 0; width: 100%;
}
.demo-card:hover { transform: translateY(-4px); box-shadow: 0 10px 32px rgba(1,31,75,.12); }

/* Risk stripe at top */
.demo-card::before {
  content: ''; display: block; height: 4px; width: 100%;
}
.demo-card.risk-critical::before { background: linear-gradient(90deg, #dc2626, #ef4444); }
.demo-card.risk-high::before     { background: linear-gradient(90deg, #ea580c, #f97316); }
.demo-card.risk-medium::before   { background: linear-gradient(90deg, #d97706, #fbbf24); }
.demo-card.risk-low::before      { background: linear-gradient(90deg, #16a34a, #4ade80); }

.demo-card-head { padding: 16px 18px 14px; min-width: 0; overflow: hidden; }

/* Top row: category pill left, risk badge right */
.demo-card-top {
  display: flex; align-items: center; justify-content: space-between; gap: 8px;
  margin-bottom: 10px; flex-wrap: wrap;
}

/* Bottom meta row: location left, date right — single line, no wrap */
.demo-card-meta {
  display: flex; align-items: center; justify-content: space-between; gap: 8px;
  margin-top: 8px; min-width: 0;
}

.demo-date {
  font-size: 11px; font-weight: 600; color: #9ca3af;
  white-space: nowrap; flex-shrink: 0;
}
.demo-cat {
  font-size: 10.5px; font-weight: 700; padding: 3px 10px; border-radius: 99px;
  text-transform: uppercase; letter-spacing: .4px;
}
/* original categories */
.cat-illegal-colony                    { background: #fef2f2; color: #dc2626; }
.cat-illegal-plotting                  { background: #fff7ed; color: #ea580c; }
.cat-residential-demolition            { background: #fff7ed; color: #ea580c; }
.cat-illegal-apartments                { background: #fef2f2; color: #dc2626; }
.cat-floodplain-clearance              { background: #eff6ff; color: #1d4ed8; }
.cat-commercial-sealing,
.cat-commercial-demolition             { background: #f5f3ff; color: #6d28d9; }
.cat-encroachment-removal              { background: #f0fdf4; color: #15803d; }
.cat-mass-demolition                   { background: #fef2f2; color: #dc2626; }
.cat-project-halt                      { background: #1a0a0a; color: #f87171; }
/* new categories */
.cat-mega-demolition-drive             { background: #fef2f2; color: #991b1b; }
.cat-illegal-plotting-sealing          { background: #fff7ed; color: #ea580c; }
.cat-demolition-sealing                { background: #fff7ed; color: #c2410c; }
.cat-civic-demolition-notice           { background: #eff6ff; color: #1e40af; }
.cat-targeted-demolition               { background: #fdf4ff; color: #7e22ce; }
.cat-halted-operation                  { background: #fefce8; color: #854d0e; }
.cat-mass-eviction-order,
.cat-mass-eviction-notice              { background: #fef2f2; color: #b91c1c; }
.cat-demolition-notice                 { background: #fff7ed; color: #9a3412; }
.cat-high-security-demolition          { background: #fef2f2; color: #7f1d1d; }
.cat-commercial-demolition-warning     { background: #f5f3ff; color: #6d28d9; }
.cat-planned-demolition                { background: #f0fdf4; color: #065f46; }
.cat-mega-demolition-land-reclamation,
.cat-legal-clearance-mega-demolition   { background: #fef2f2; color: #991b1b; }
.cat-unauthorized-construction         { background: #fefce8; color: #92400e; }
.cat-construction-ban                  { background: #fef2f2; color: #dc2626; }
.cat-residential-demolition,
.cat-illegal-colony                    { background: #fef2f2; color: #dc2626; }
.cat-fatal-fire                        { background: #1a0a0a; color: #f87171; }
.cat-court-action                      { background: #eff6ff; color: #1e40af; }
.cat-township-takeover                 { background: #f0fdf4; color: #15803d; }
.cat-demolition-list                   { background: #fef2f2; color: #b91c1c; }
.cat-land-transaction-ban              { background: #fefce8; color: #854d0e; }
.cat-legal-clearance-mega-demolition   { background: #fef2f2; color: #991b1b; }

.demo-risk-badge {
  font-size: 10.5px; font-weight: 700;
  padding: 3px 10px; border-radius: 99px; white-space: nowrap; flex-shrink: 0;
}
.risk-badge-critical { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }
.risk-badge-high     { background: #fff7ed; color: #ea580c; border: 1px solid #fdba74; }
.risk-badge-medium   { background: #fefce8; color: #854d0e; border: 1px solid #fde68a; }
.risk-badge-low      { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

.demo-card h3 {
  font-size: 15px; font-weight: 700; color: var(--navy); line-height: 1.45;
  margin: 0; overflow-wrap: break-word;
}
.demo-loc {
  display: flex; align-items: center; gap: 4px;
  font-size: 12px; color: #6b7280;
  flex: 1; min-width: 0; overflow: hidden;
}
.demo-loc span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

.demo-card-body { padding: 0 18px 14px; flex: 1; display: flex; flex-direction: column; gap: 12px; min-width: 0; overflow: hidden; }
.demo-desc { font-size: 13.5px; color: #374151; line-height: 1.7; margin: 0; overflow-wrap: break-word; }
.demo-impact {
  display: flex; align-items: flex-start; gap: 8px;
  background: #fef8f8; border: 1px solid #fecaca;
  padding: 10px 13px; border-radius: 8px;
  font-size: 12.5px; font-weight: 600; color: #b91c1c;
}
.demo-impact svg { flex-shrink: 0; margin-top: 1px; }

.demo-card-foot {
  padding: 11px 18px 14px; border-top: 1px solid var(--bdr);
  display: flex; align-items: center; justify-content: space-between; gap: 10px;
}
.demo-source {
  display: flex; align-items: center; gap: 6px;
  font-size: 11.5px; color: #6b7280; font-weight: 600;
  min-width: 0; overflow: hidden;
}
.demo-source span:last-child { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.demo-source-dot { width: 7px; height: 7px; border-radius: 50%; background: #d1d5db; flex-shrink: 0; }
.source-jagran   .demo-source-dot { background: #dc2626; }
.source-ujala    .demo-source-dot { background: #ea580c; }
.source-bs       .demo-source-dot { background: #1d4ed8; }
.source-other    .demo-source-dot { background: #9ca3af; }

.btn-read-more {
  display: inline-flex; align-items: center; gap: 5px;
  background: transparent; color: var(--teal); border: 1.5px solid var(--teal);
  padding: 7px 14px; border-radius: 8px;
  font-size: 12px; font-weight: 700; text-decoration: none; transition: all .15s;
  white-space: nowrap; flex-shrink: 0;
}
.btn-read-more:hover { background: var(--teal); color: #fff; }
.demo-source-tag {
  font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 99px;
  background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;
  white-space: nowrap;
}

/* ── CTA Banner ── */
.demo-cta-banner {
  background: linear-gradient(135deg, #011f4b 0%, #023372 60%, #014040 100%);
  border-radius: var(--r); padding: 32px 28px; margin: 8px 0;
  display: flex; align-items: center; justify-content: space-between;
  gap: 20px; flex-wrap: wrap; position: relative; overflow: hidden;
}
.demo-cta-banner::before {
  content: '🛡️';
  position: absolute; right: 28px; top: 50%; transform: translateY(-50%);
  font-size: 72px; opacity: .08; pointer-events: none;
}
.demo-cta-left { flex: 1; min-width: 240px; }
.demo-cta-tag {
  display: inline-block; background: rgba(220,38,38,.2); color: #fca5a5;
  font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 99px;
  text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px;
}
.demo-cta-banner h3 {
  font-size: 20px; font-weight: 800; color: #fff; margin: 0 0 8px; line-height: 1.3;
}
.demo-cta-banner p {
  font-size: 13.5px; color: rgba(255,255,255,.7); margin: 0; line-height: 1.6;
}
.demo-cta-btns { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
.btn-cta-verify {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--teal); color: #fff; padding: 12px 22px; border-radius: 10px;
  font-size: 14px; font-weight: 700; text-decoration: none; transition: background .15s;
  white-space: nowrap;
}
.btn-cta-verify:hover { background: #006666; color: #fff; }
.btn-cta-wa {
  display: inline-flex; align-items: center; gap: 8px;
  background: #25D366; color: #fff; padding: 12px 22px; border-radius: 10px;
  font-size: 14px; font-weight: 700; text-decoration: none; transition: background .15s;
  white-space: nowrap;
}
.btn-cta-wa:hover { background: #128c4e; color: #fff; }

/* ── Risk legend ── */
.demo-legend {
  display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
  background: #fff; border: 1px solid var(--bdr); border-radius: 10px;
  padding: 12px 18px; margin-bottom: 20px; font-size: 12.5px;
}
.demo-legend-title { font-weight: 700; color: var(--navy); margin-right: 4px; }
.demo-legend-item { display: flex; align-items: center; gap: 6px; color: #374151; }
.demo-legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

/* ── High-Risk Areas section ── */
.demo-areas-section { margin: 56px 0 40px; }
.demo-areas-grid {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 14px;
}
.demo-area-card {
  background: #fff; border: 1.5px solid var(--bdr); border-radius: 12px;
  padding: 16px 18px; text-decoration: none; transition: all .18s;
  display: flex; flex-direction: column; gap: 6px;
}
.demo-area-card:hover { border-color: var(--teal); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,128,128,.1); }
.demo-area-name { font-size: 14px; font-weight: 700; color: var(--navy); }
.demo-area-count { font-size: 12px; color: #6b7280; }
.demo-area-risk {
  font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 99px;
  display: inline-block; align-self: flex-start; margin-top: 2px;
}
.area-risk-critical { background: #fef2f2; color: #dc2626; }
.area-risk-high     { background: #fff7ed; color: #ea580c; }

/* ── FAQ section ── */
.demo-faq-section { margin: 56px 0 40px; }
.demo-faq-list { display: flex; flex-direction: column; gap: 12px; }
.demo-faq-item {
  background: #fff; border: 1.5px solid var(--bdr); border-radius: 12px; overflow: hidden;
}
.demo-faq-item summary {
  padding: 18px 20px; font-size: 15px; font-weight: 700; color: var(--navy);
  cursor: pointer; display: flex; align-items: center; justify-content: space-between;
  list-style: none; gap: 12px;
}
.demo-faq-item summary::-webkit-details-marker { display: none; }
.demo-faq-item summary::after {
  content: '+'; font-size: 20px; font-weight: 400; color: var(--teal);
  flex-shrink: 0; transition: transform .2s;
}
.demo-faq-item[open] summary::after { content: '−'; }
.demo-faq-item[open] { border-color: var(--teal); }
.demo-faq-item[open] summary { border-bottom: 1px solid var(--bdr); }
.demo-faq-answer {
  padding: 16px 20px; font-size: 14px; color: #374151; line-height: 1.75;
}
.demo-faq-answer a { color: var(--teal); text-decoration: underline; }

/* ── Bottom CTA ── */
.demo-bottom-cta {
  background: linear-gradient(135deg, #0f172a, #1e1b4b);
  border-radius: 20px; padding: 56px 40px; text-align: center; margin-top: 56px;
}
.demo-bottom-cta h2 { font-size: 30px; font-weight: 900; color: #fff; margin: 0 0 14px; }
.demo-bottom-cta p  { font-size: 16px; color: rgba(255,255,255,.7); max-width: 560px; margin: 0 auto 30px; line-height: 1.7; }
.demo-checklist {
  display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-bottom: 32px;
}
.demo-check {
  display: flex; align-items: center; gap: 7px;
  background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15);
  padding: 8px 16px; border-radius: 99px; font-size: 13px; color: #e2e8f0;
}
.demo-check::before { content: '✓'; color: #5eead4; font-weight: 900; }

/* ── No results ── */
.demo-no-results {
  grid-column: 1 / -1; text-align: center; padding: 48px 20px;
  color: #6b7280; font-size: 15px; display: none;
}

/* ── Back to top ── */
#backToTop {
  position: fixed; bottom: 28px; right: 28px; z-index: 999;
  width: 44px; height: 44px; border-radius: 50%;
  background: var(--navy); color: #fff; border: none; cursor: pointer;
  font-size: 18px; box-shadow: 0 4px 16px rgba(0,0,0,.2);
  display: none; align-items: center; justify-content: center;
  transition: background .15s; font-family: 'Poppins', sans-serif;
}
#backToTop:hover { background: var(--teal); }
#backToTop.visible { display: flex; }

/* ── Responsive ── */
@media (max-width: 768px) {
  .demo-hero { padding: 50px 16px 40px; }
  .demo-cta-banner { padding: 24px 20px; }
  .demo-cta-banner::before { display: none; }
  .demo-bottom-cta { padding: 36px 20px; }
  .demo-bottom-cta h2 { font-size: 22px; }
}
@media (max-width: 480px) {
  .demo-grid { grid-template-columns: 1fr; }
  .demo-hero h1 { font-size: 22px; }
  .demo-stat { padding: 12px 16px; }
  .demo-stat-num { font-size: 22px; }
  .demo-faq-item summary { font-size: 14px; }
}
</style>
@endpush

@section('content')
<div class="demo-page">

{{-- ── BREADCRUMB ── --}}
<nav class="demo-breadcrumb" aria-label="Breadcrumb">
  <div class="demo-breadcrumb-inner">
    <a href="/">Home</a>
    <span class="sep">›</span>
    <span class="current">LDA Demolition Tracker</span>
  </div>
</nav>

{{-- ── HERO ── --}}
<div class="demo-hero">
  <div class="demo-hero-badge">
    🚨 Latest incident: {{ \Carbon\Carbon::parse($items[0]['date'])->format('d M Y') }}
  </div>
  <h1>LDA Demolition Tracker<br><span>Lucknow 2024–2026</span></h1>
  <p class="demo-hero-sub">
    Major LDA bulldozer drives, illegal plotting demolitions and sealing actions in Lucknow, each linked to the news report it comes from.
    Know the real risks before you invest in property.
  </p>

  <div class="demo-stats">
    <div class="demo-stat">
      <span class="demo-stat-num">{{ $stats['total'] }}</span>
      <span class="demo-stat-lbl">Incidents Tracked</span>
    </div>
    <div class="demo-stat">
      <span class="demo-stat-num">{{ $stats['critical'] }}</span>
      <span class="demo-stat-lbl">Critical Risk</span>
    </div>
    <div class="demo-stat teal">
      <span class="demo-stat-num">{{ $stats['high'] }}</span>
      <span class="demo-stat-lbl">High Risk</span>
    </div>
    <div class="demo-stat org">
      <span class="demo-stat-num">{{ collect($items)->flatMap(fn($it) => array_map('trim', explode('/', $it['area'])))->unique()->count() }}</span>
      <span class="demo-stat-lbl">Areas Affected</span>
    </div>
    <div class="demo-stat wht">
      <span class="demo-stat-num">1,800+</span>
      <span class="demo-stat-lbl">Akbar Nagar Families Rehoused</span>
    </div>
  </div>

  <div class="demo-hero-btns">
    <a href="{{ url('/services/property-verification-lucknow') }}" class="btn-hero-primary">
      🛡️ Verify Your Property — ₹5,000
    </a>
    <a href="https://wa.me/918595002933?text=Hi%2C+I+want+to+verify+my+property+in+Lucknow+before+buying." target="_blank" rel="noopener" class="btn-hero-secondary">
      💬 Talk to an Expert
    </a>
  </div>
</div>

{{-- ── WARNING BAR ── --}}
<div class="demo-warning-bar" role="alert">
  ⚠️ &nbsp;
  <strong>Important:</strong> Buying an unapproved plot or flat in Lucknow can result in total loss of investment.
  LDA has no scheme to compensate buyers of illegal plotting it demolishes. &nbsp;·&nbsp;
  <a href="{{ url('/services/property-verification-lucknow') }}" style="color:#fff;font-weight:800;text-decoration:underline;">Verify before you buy →</a>
</div>

{{-- ── MAIN CONTENT ── --}}
<div class="demo-wrap">

  {{-- Section heading --}}
  <div class="demo-sec-divider"></div>
  <h2 class="demo-sec-h2">📋 All LDA Demolition & Seizure Incidents in Lucknow</h2>
  <p class="demo-sec-sub">
    {{ count($items) }} incidents from {{ \Carbon\Carbon::parse(end($items)['date'])->format('F Y') }} to {{ \Carbon\Carbon::parse($items[0]['date'])->format('F Y') }}, each checked against its source report ({{ collect($items)->countBy('source_name')->sortDesc()->keys()->take(6)->implode(', ') }} and others).
    This is not a complete list of every LDA action. Filter by risk level to find the incidents most relevant to your area.
  </p>

  {{-- Filter bar --}}
  <div class="demo-filter-bar" role="group" aria-label="Filter by risk level">
    <span class="demo-filter-label">Filter:</span>
    <button class="demo-filter-btn active" data-filter="all">All ({{ count($items) }})</button>
    <span class="demo-filter-sep"></span>
    <button class="demo-filter-btn critical" data-filter="critical">🔴 Critical ({{ $stats['critical'] }})</button>
    <button class="demo-filter-btn high"     data-filter="high">🟠 High ({{ $stats['high'] }})</button>
    <button class="demo-filter-btn medium"   data-filter="medium">🟡 Medium ({{ collect($items)->where('risk_level','medium')->count() }})</button>
  </div>

  {{-- Risk legend --}}
  <div class="demo-legend" aria-label="Risk level legend">
    <span class="demo-legend-title">Risk Level:</span>
    <span class="demo-legend-item"><span class="demo-legend-dot" style="background:#dc2626"></span> Critical — Major demolition, mass displacement, total investment loss</span>
    <span class="demo-legend-item"><span class="demo-legend-dot" style="background:#ea580c"></span> High — Illegal construction, buyers directly affected</span>
    <span class="demo-legend-item"><span class="demo-legend-dot" style="background:#d97706"></span> Medium — Sealing, partial action, or notice stage</span>
    <span class="demo-legend-item"><span class="demo-legend-dot" style="background:#16a34a"></span> Low — Legal notice, court stay, or minor action</span>
  </div>

  {{-- Cards grid --}}
  @php
    $ctaMessages = [
      ['heading' => 'Is Your Plot LDA Approved?', 'body' => 'Every plotting in this tracker was being sold without an approved LDA layout. Check your plot\'s legal status before you pay — PDF report in 48 hours.'],
      ['heading' => 'Are You Buying in a Safe Area?', 'body' => 'Many demolitions happen in areas that look legitimate on paper. Our experts check LDA records, mutation documents, and encumbrance status for you.'],
      ['heading' => 'Builder Showing You LDA Approval? Get It Verified.', 'body' => 'Don\'t rely on a photocopy. We cross-check the layout and map approval against LDA and revenue records before you buy.'],
      ['heading' => 'Stop. Check. Then Buy.', 'body' => 'Property verification costs ₹5,000 for a residential plot or flat — a small fraction of what you stand to lose. Get a legal and encumbrance report from DSD Properties.'],
    ];
    $ctaIdx = 0;
  @endphp

  <div id="demoGrid" class="demo-grid">

    @foreach($items as $i => $item)
    @php
      $riskClass     = 'risk-' . $item['risk_level'];
      $catSlug       = preg_replace('/[^a-z0-9]+/', '-', strtolower($item['category']));
      $catSlug       = trim($catSlug, '-');
      $sourceClass   = str_contains(strtolower($item['source_name']), 'jagran') ? 'source-jagran'
                     : (str_contains(strtolower($item['source_name']), 'ujala') ? 'source-ujala'
                     : (str_contains(strtolower($item['source_name']), 'standard') ? 'source-bs' : 'source-other'));
      $riskLabel     = match($item['risk_level']) {
        'critical' => '🔴 Critical Risk',
        'high'     => '🟠 High Risk',
        'low'      => '🟢 Low Risk',
        default    => '🟡 Medium Risk',
      };
      $riskBadgeClass = 'risk-badge-' . $item['risk_level'];
    @endphp

    {{-- CTA after every 6 cards --}}
    @if($i > 0 && $i % 6 === 0)
    @php $cta = $ctaMessages[$ctaIdx % count($ctaMessages)]; $ctaIdx++; @endphp
    <div class="demo-cta-banner" style="grid-column: 1 / -1;" aria-label="Property verification call to action">
      <div class="demo-cta-left">
        <div class="demo-cta-tag">🛡️ Property Verification · ₹5,000</div>
        <h3>{{ $cta['heading'] }}</h3>
        <p>{{ $cta['body'] }}</p>
      </div>
      <div class="demo-cta-btns">
        <a href="{{ url('/services/property-verification-lucknow') }}" class="btn-cta-verify">
          ✓ Verify My Property
        </a>
        <a href="https://wa.me/918595002933?text=I+want+to+verify+my+property+in+Lucknow+before+buying." target="_blank" rel="noopener" class="btn-cta-wa">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp Expert
        </a>
      </div>
    </div>
    @endif

    <article class="demo-card {{ $riskClass }}" data-risk="{{ $item['risk_level'] }}" data-area="{{ strtolower(str_replace([' ', '/'], '-', $item['area'])) }}">
      <div class="demo-card-head">

        {{-- Row 1: category pill (left) · risk badge (right) --}}
        <div class="demo-card-top">
          <span class="demo-cat cat-{{ $catSlug }}">{{ $item['category'] }}</span>
          <span class="demo-risk-badge {{ $riskBadgeClass }}">{{ $riskLabel }}</span>
        </div>

        {{-- Headline --}}
        <h3>{{ $item['headline'] }}</h3>

        {{-- Row 2: location (left) · date (right) --}}
        <div class="demo-card-meta">
          <div class="demo-loc" title="{{ $item['location'] }}">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>{{ $item['location'] }}</span>
          </div>
          <time class="demo-date" datetime="{{ $item['date'] }}">
            {{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}
          </time>
        </div>

      </div>

      <div class="demo-card-body">
        <p class="demo-desc">{{ $item['description'] }}</p>
        <div class="demo-impact" role="note" aria-label="Impact">
          <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
          <span style="overflow-wrap:break-word;min-width:0;">{{ $item['impact'] }}</span>
        </div>
      </div>

      <div class="demo-card-foot">
        <div class="demo-source {{ $sourceClass }}">
          <span class="demo-source-dot" aria-hidden="true"></span>
          <span>{{ $item['source_name'] }}</span>
        </div>
        <a href="{{ $item['source_url'] }}" target="_blank" rel="noopener noreferrer" class="btn-read-more" aria-label="Read full report on {{ $item['source_name'] }}">
          Read Report →
        </a>
      </div>
    </article>

    @endforeach

    <p class="demo-no-results" id="noResults" role="status">No incidents found for the selected filter.</p>

  </div>{{-- /demoGrid --}}


  {{-- ── HIGH-RISK AREAS SECTION ── --}}
  <section class="demo-areas-section" aria-labelledby="areas-heading">
    <div class="demo-sec-divider"></div>
    <h2 class="demo-sec-h2" id="areas-heading">🗺️ High-Risk Areas for Property Buyers in Lucknow</h2>
    <p class="demo-sec-sub">
      Localities that appear most often in the incidents above (counted from this tracker's data). Exercise extra caution and always verify before buying in any of these localities.
    </p>
    @php
      $areaLinks = [
        'Kakori'            => ['Kakori', '/blog/varun-vihar-yojana-lucknow-lda-plots-guide-2026'],
        'Dubagga'           => ['Dubagga', url('/services/property-verification-lucknow')],
        'Gosainganj'        => ['Gosainganj', '/blog/plots-sultanpur-road-lucknow-2026'],
        'BKT'               => ['BKT', '/blog/bakshi-ka-talab-bkt-lucknow-real-estate-guide-2026'],
        'Sushant Golf City' => ['Golf City', '/blog/sushant-golf-city-lucknow-buyers-guide-2026'],
        'Mohanlalganj'      => ['Mohanlalganj', '/blog/mohanlalganj-plot-verification-lucknow-2026'],
        'Chinhat'           => ['Chinhat', url('/services/property-verification-lucknow')],
        'Sairpur'           => ['Sairpur', '/blog/naimish-nagar-yojana-lucknow-lda-plots-guide-2026'],
        'Aliganj'           => ['Aliganj', url('/services/property-verification-lucknow')],
        'Gudamba'           => ['Gudamba', url('/services/property-verification-lucknow')],
        'Kisan Path'        => ['Kisan Path', '/blog/kisan-path-plot-verification-lucknow-2026'],
      ];
      $areaCounts = collect($areaLinks)->map(function ($cfg) use ($items) {
          return collect($items)->filter(fn($it) => stripos($it['headline'].' '.$it['location'].' '.$it['area'].' '.$it['description'], $cfg[0]) !== false)->count();
      })->filter()->sortDesc()->take(8);
    @endphp
    <div class="demo-areas-grid">
      @foreach($areaCounts as $areaName => $areaCount)
      <a href="{{ $areaLinks[$areaName][1] }}" class="demo-area-card">
        <span class="demo-area-name">{{ $areaName }}</span>
        <span class="demo-area-count">{{ $areaCount }} {{ $areaCount === 1 ? 'incident' : 'incidents' }} tracked</span>
        <span class="demo-area-risk {{ $areaCount >= 8 ? 'area-risk-critical' : 'area-risk-high' }}">{{ $areaCount >= 8 ? 'Critical Risk' : 'High Risk' }}</span>
      </a>
      @endforeach
    </div>
    <p style="font-size:13px;color:#6b7280;margin-top:14px;">
      ⚠️ High-risk area does not mean all properties there are illegal — it means extra due diligence is required.
      <a href="{{ url('/services/property-verification-lucknow') }}" style="color:var(--teal);font-weight:600;text-decoration:none;">Get a verified property report →</a>
    </p>
  </section>


  {{-- ── FAQ SECTION ── --}}
  <section class="demo-faq-section" aria-labelledby="faq-heading">
    <div class="demo-sec-divider"></div>
    <h2 class="demo-sec-h2" id="faq-heading">❓ Frequently Asked Questions About LDA Demolitions in Lucknow</h2>
    <p class="demo-sec-sub">
      Common questions from property buyers in Lucknow about LDA demolition risk, how to verify properties, and what legal protections exist.
    </p>

    <div class="demo-faq-list">

      <details class="demo-faq-item">
        <summary>Which areas in Lucknow have the highest LDA demolition risk?</summary>
        <div class="demo-faq-answer">
          In the incidents tracked from 2024 to 2026, LDA's illegal-plotting drives were most frequent in <strong>Kakori, Dubagga, BKT, Gosainganj, Chinhat, Sushant Golf City, Sairpur</strong> and <strong>Mohanlalganj</strong>. In 2026, <strong>Aliganj</strong> also saw large-scale sealing of commercial buildings on residential plots after the June fire. Many of these areas fall inside or next to proposed LDA schemes such as Naimish Nagar and Varun Vihar. If you are buying in any of them, an independent <a href="{{ url('/services/property-verification-lucknow') }}">property verification</a> is strongly recommended.
        </div>
      </details>

      <details class="demo-faq-item">
        <summary>What happens to buyers if an illegal colony is demolished by LDA?</summary>
        <div class="demo-faq-answer">
          When LDA demolishes an unauthorised plotting, it razes the roads, drains, boundary walls and site offices built without layout approval. There is <strong>no LDA scheme to compensate plot buyers</strong> in such colonies. Their remedy is against the seller, through a police complaint or a civil suit, and recovery is slow and uncertain. Compensation is paid only when LDA acquires land for its own scheme, as in the Anant Nagar possession drive (December 2025).
        </div>
      </details>

      <details class="demo-faq-item">
        <summary>How can I check if a plot or flat is LDA approved in Lucknow?</summary>
        <div class="demo-faq-answer">
          There are two ways: <strong>(1)</strong> Visit the LDA office at Vipin Khand, Gomti Nagar and request a layout approval search for the specific khasra and survey number of the land. <strong>(2)</strong> Book <a href="{{ url('/services/property-verification-lucknow') }}">DSD Properties' property verification</a> (₹5,000 for residential plots and flats). We check LDA records, revenue documents (Khatauni) and RERA registration and send a PDF report within 48 hours.
        </div>
      </details>

      <details class="demo-faq-item">
        <summary>What is an illegal colony and how do I identify one in Lucknow?</summary>
        <div class="demo-faq-answer">
          An illegal colony is land that has been subdivided and sold as residential plots <strong>without obtaining LDA layout approval</strong>. Common warning signs: no LDA approval number on sale documents, agricultural (kisan) land being marketed as residential, prices significantly lower than nearby approved areas, developer avoids providing official registry or shows handwritten agreements, and no RERA registration for the project. Also read our guide on <a href="/blog/lda-illegal-colony-list-lucknow-2026">how to buy LDA-approved plots and avoid scams</a>.
        </div>
      </details>

      <details class="demo-faq-item">
        <summary>Does LDA compensate buyers whose properties are demolished?</summary>
        <div class="demo-faq-answer">
          <strong>No.</strong> LDA has no scheme to compensate buyers of unauthorised plotting or construction it demolishes or seals. Liability rests with whoever sold or built without approval. Recovering money from such sellers is slow and uncertain, so checking approval before purchase is the only real protection.
        </div>
      </details>

      <details class="demo-faq-item">
        <summary>What documents must I verify before buying a plot in Lucknow?</summary>
        <div class="demo-faq-answer">
          Essential document checks before buying any plot in Lucknow:
          <ol style="margin:10px 0 0 18px;line-height:2;">
            <li><strong>LDA Layout Approval Letter</strong> with scheme number</li>
            <li><strong>Jamabandi / Khatoni</strong> from Revenue Department (land record)</li>
            <li><strong>Encumbrance Certificate</strong> to check for outstanding loans or disputes</li>
            <li><strong>RERA registration certificate</strong> for any ongoing project</li>
            <li><strong>Complete chain of title</strong> (all previous sale deeds)</li>
            <li><strong>Approved building map</strong> from LDA if the property is already built</li>
            <li><strong>Land use conversion order</strong> if agricultural land is being sold as residential</li>
          </ol>
          Read our full <a href="/blog/understanding-rera-guide-lucknow-property-buyers-C7ECl">RERA guide for Lucknow buyers</a> for more details.
        </div>
      </details>

      <details class="demo-faq-item">
        <summary>Is Sushant Golf City safe to buy property in 2026?</summary>
        <div class="demo-faq-answer">
          On <strong>15 September 2026</strong> the UP cabinet approved LDA's proposal on 2,747 plots that Ansal sold while they were mortgaged to LDA. LDA says the registries of these plots <strong>will not be cancelled</strong>, and the takeover of the township still needs NCLT approval. Separately, LDA has repeatedly demolished illegal plotting in villages around the township, such as Bakkas, Mastemau, Malukpur and Sikandarpur Amolia, including 65 bighas on 16 October 2026. Verify exactly which part of the area a plot is in before buying. See our <a href="/blog/sushant-golf-city-lucknow-buyers-guide-2026">Sushant Golf City buyer's guide</a>.
        </div>
      </details>

      <details class="demo-faq-item">
        <summary>How quickly can LDA demolish a property after issuing notice?</summary>
        <div class="demo-faq-answer">
          It can take <strong>only a few weeks</strong>. In the Aliganj fire case, LDA issued a Section 27(1) notice on 23 June 2026 giving 15 days to show the building was legal. The prescribed authority declared it illegal on 10 July and gave the owners 15 days to demolish it themselves. Most illegal-plotting demolitions in this tracker were carried out on orders already passed by the prescribed authority court.
        </div>
      </details>

    </div>
  </section>


  {{-- ── BOTTOM CTA ── --}}
  <div class="demo-bottom-cta" aria-labelledby="cta-heading">
    <h2 id="cta-heading">🛡️ Protect Your Investment Before It's Too Late</h2>
    <p>
      None of the plottings in this tracker had an approved LDA layout. A pre-purchase check would have flagged that before money changed hands. We check the papers against LDA, revenue and RERA records.
    </p>
    <div class="demo-checklist">
      <span class="demo-check">LDA Map Approval Check</span>
      <span class="demo-check">Registry &amp; Mutation Verify</span>
      <span class="demo-check">Encumbrance Certificate</span>
      <span class="demo-check">RERA Builder Check</span>
      <span class="demo-check">Floodplain &amp; Zone Status</span>
      <span class="demo-check">PDF Report in 48 Hours</span>
    </div>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ url('/services/property-verification-lucknow') }}" class="btn-cta-verify" style="font-size:16px;padding:15px 30px;">
        🛡️ Book Property Verification — ₹5,000
      </a>
      <a href="https://wa.me/918595002933?text=Hi%2C+I+want+property+verification+in+Lucknow.+Please+help." target="_blank" rel="noopener" class="btn-cta-wa" style="font-size:16px;padding:15px 30px;">
        💬 WhatsApp Us Now
      </a>
    </div>
  </div>

</div>{{-- /demo-wrap --}}
</div>{{-- /demo-page --}}

{{-- Back to top --}}
<button id="backToTop" aria-label="Back to top" title="Back to top">↑</button>

<script>
(function () {
  // ── Filter ──
  var btns   = document.querySelectorAll('.demo-filter-btn');
  var cards  = document.querySelectorAll('#demoGrid .demo-card');
  var noRes  = document.getElementById('noResults');
  var active = 'all';

  btns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      active = this.dataset.filter;
      btns.forEach(function (b) { b.classList.remove('active'); });
      this.classList.add('active');

      var visible = 0;
      cards.forEach(function (card) {
        var match = active === 'all' || card.dataset.risk === active;
        card.style.display = match ? '' : 'none';
        if (match) visible++;
      });
      noRes.style.display = visible === 0 ? 'block' : 'none';
    });
  });

  // ── Back to top ──
  var topBtn = document.getElementById('backToTop');
  window.addEventListener('scroll', function () {
    topBtn.classList.toggle('visible', window.scrollY > 600);
  }, { passive: true });
  topBtn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
})();
</script>
@endsection
