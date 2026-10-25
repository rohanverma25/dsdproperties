@extends('layouts.user-app')
@section('title', 'DSD Properties Lucknow — Buy, Sell & Verify Property')
@section('meta_description', 'Trusted property platform in Lucknow. Browse reviewed listings, get free property valuation, legal verification, and expert advisory. 5-star rated.')

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "RealEstateAgent",
  "name": "DSD Properties",
  "image": "{{ asset('images/logo.webp') }}",
  "description": "Trusted property platform in Lucknow. Buy, sell, verify and get expert advisory on residential and commercial property.",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
    "addressLocality": "Lucknow",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "226025",
    "addressCountry": "IN"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": 26.7591633, "longitude": 80.9514628 },
  "openingHoursSpecification": [{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
    "opens": "09:00", "closes": "18:00"
  }],
  "areaServed": { "@type": "City", "name": "Lucknow" },
  "telephone": "+91-8595002933",
  "url": "{{ url('/') }}",
  "sameAs": [
    "https://www.google.com/maps?cid=14659186425526983202",
    "https://www.linkedin.com/in/dheer-singh-416370137/"
  ]
}
</script>
<noscript><style>.rv{opacity:1!important;transform:none!important}</style></noscript>
<style>
/* ── Tokens ─────────────────────────────────────────── */
.hp{
  --ink:#0b1b33; --ink-2:#4a5568; --ink-3:#8a94a6;
  --line:#e7e9ee; --surface:#fff; --canvas:#f6f7f9; --raised:#fff;
  --navy:#011f4b; --navy-2:#0a2d63;
  --teal:#008080; --teal-soft:#e6f3f2;
  --accent:#ff5c00; --accent-hover:#e65300; --accent-soft:#fff1e8;
  --star:#f5a524;
  --r-lg:22px; --r-md:16px; --r-sm:12px;
  --shadow-sm:0 1px 2px rgba(11,27,51,.05),0 2px 8px rgba(11,27,51,.04);
  --shadow-md:0 2px 4px rgba(11,27,51,.04),0 12px 32px rgba(11,27,51,.08);
  --shadow-lg:0 24px 64px rgba(11,27,51,.16);
  font-family:'Poppins',system-ui,sans-serif; color:var(--ink); background:var(--surface);
  overflow-x:hidden; -webkit-font-smoothing:antialiased;
}
[data-theme="dark"] .hp{
  --ink:#eef2f7; --ink-2:#b4bfcf; --ink-3:#7f8ba0;
  --line:#26324a; --surface:#0d1626; --canvas:#111c2f; --raised:#16223a;
  --navy:#0a1a33; --navy-2:#132a50;
  --teal:#2cc4b4; --teal-soft:rgba(44,196,180,.12);
  --accent-soft:rgba(255,92,0,.14);
  --shadow-sm:0 1px 2px rgba(0,0,0,.3); --shadow-md:0 12px 32px rgba(0,0,0,.35); --shadow-lg:0 24px 64px rgba(0,0,0,.5);
}
.hp *,.hp *::before,.hp *::after{box-sizing:border-box}
.hp a{color:inherit;text-decoration:none}
.hp svg{flex-shrink:0}
.wrap{max-width:1200px;margin:0 auto;padding:0 24px}
@media(max-width:640px){.wrap{padding:0 16px}}
.section{padding:96px 0}
.section--canvas{background:var(--canvas)}
@media(max-width:760px){.section{padding:64px 0}}

/* ── Type ───────────────────────────────────────────── */
.eyebrow{display:inline-flex;align-items:center;gap:8px;font-size:.75rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--teal);margin-bottom:14px}
.eyebrow::before{content:'';width:18px;height:2px;border-radius:2px;background:currentColor}
.h2{font-size:clamp(1.6rem,3.2vw,2.35rem);line-height:1.15;font-weight:700;letter-spacing:-.025em;margin:0 0 12px}
.lead{font-size:1rem;line-height:1.7;color:var(--ink-2);margin:0;max-width:560px}
.sec-head{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;flex-wrap:wrap;margin-bottom:44px}
.sec-head--center{flex-direction:column;align-items:center;text-align:center}
.sec-head--center .lead{margin:0 auto}

/* ── Buttons ────────────────────────────────────────── */
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;font:600 .9rem/1 'Poppins',sans-serif;padding:14px 22px;border-radius:999px;border:1.5px solid transparent;cursor:pointer;transition:background .2s,border-color .2s,color .2s,transform .2s,box-shadow .2s;white-space:nowrap}
.btn:focus-visible{outline:3px solid rgba(0,128,128,.35);outline-offset:2px}
.btn-accent{background:var(--accent);color:#fff!important}
.btn-accent:hover{background:var(--accent-hover);transform:translateY(-1px);box-shadow:0 8px 20px rgba(255,92,0,.28)}
.btn-dark{background:var(--ink);color:var(--surface)!important}
.btn-dark:hover{transform:translateY(-1px);box-shadow:var(--shadow-md)}
.btn-line{background:transparent;border-color:var(--line);color:var(--ink)!important}
.btn-line:hover{border-color:var(--ink);}
.btn-white{background:#fff;color:#011f4b!important}
.btn-white:hover{transform:translateY(-1px)}
.btn-ghost-w{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.22);color:#fff!important}
.btn-ghost-w:hover{background:rgba(255,255,255,.16)}
.link-arrow{display:inline-flex;align-items:center;gap:6px;font-size:.88rem;font-weight:600;color:var(--teal)}
.link-arrow svg{transition:transform .2s}
.link-arrow:hover svg{transform:translateX(3px)}

/* ── Reveal ─────────────────────────────────────────── */
.rv{opacity:0;transform:translateY(16px);transition:opacity .6s cubic-bezier(.2,.7,.2,1),transform .6s cubic-bezier(.2,.7,.2,1);transition-delay:var(--d,0s)}
.rv.in{opacity:1;transform:none}
@media(prefers-reduced-motion:reduce){.rv{opacity:1;transform:none;transition:none}.hp *{scroll-behavior:auto!important}}

/* ── Hero ───────────────────────────────────────────── */
.hero{position:relative;background:var(--canvas);padding:72px 0 88px;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background:radial-gradient(60% 70% at 85% 10%,var(--teal-soft),transparent 70%);pointer-events:none}
.hero__grid{position:relative;display:grid;grid-template-columns:1.08fr .92fr;gap:56px;align-items:center}
@media(max-width:980px){.hero__grid{grid-template-columns:1fr;gap:48px}.hero{padding:48px 0 64px}}
.rating-pill{display:inline-flex;align-items:center;gap:10px;padding:7px 14px 7px 8px;background:var(--raised);border:1px solid var(--line);border-radius:999px;font-size:.8rem;color:var(--ink-2);box-shadow:var(--shadow-sm);margin-bottom:24px}
.rating-pill__g{width:24px;height:24px;border-radius:50%;background:var(--surface);display:grid;place-items:center;border:1px solid var(--line)}
.rating-pill strong{color:var(--ink);font-weight:600}
.stars{color:var(--star);letter-spacing:1px}
.hero h1{font-size:clamp(2.2rem,5vw,3.6rem);line-height:1.06;font-weight:700;letter-spacing:-.035em;margin:0 0 20px}
.hero h1 span{color:var(--teal)}
.hero__sub{font-size:1.08rem;line-height:1.7;color:var(--ink-2);margin:0 0 32px;max-width:520px}

/* Search */
.search{display:grid;grid-template-columns:1.3fr 1fr 1fr auto;background:var(--raised);border:1px solid var(--line);border-radius:20px;padding:8px;box-shadow:var(--shadow-md);gap:4px}
.search__field{display:flex;flex-direction:column;justify-content:center;padding:8px 16px;border-radius:14px;min-width:0;transition:background .2s}
.search__field + .search__field{border-left:1px solid var(--line)}
.search__field:focus-within{background:var(--canvas)}
.search__field label{font-size:.68rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-3);margin-bottom:3px}
.search__field input,.search__field select{border:0;background:transparent;font:500 .92rem 'Poppins',sans-serif;color:var(--ink);padding:0;outline:none;width:100%;appearance:none;-webkit-appearance:none;cursor:pointer;text-overflow:ellipsis}
.search__field input{cursor:text}
.search__field input::placeholder{color:var(--ink-3);font-weight:400}
.search__field select option{color:#111}
.search__btn{border-radius:14px;padding:0 26px}
@media(max-width:760px){
  .search{grid-template-columns:1fr 1fr;padding:10px;gap:6px}
  .search__field{border:1px solid var(--line)!important;border-radius:12px;padding:10px 14px}
  .search__field:first-child{grid-column:1/-1}
  .search__btn{grid-column:1/-1;padding:15px}
}
.quick{display:flex;align-items:center;flex-wrap:wrap;gap:8px;margin-top:20px;font-size:.82rem;color:var(--ink-3)}
.chip{display:inline-flex;align-items:center;padding:7px 14px;border-radius:999px;background:var(--raised);border:1px solid var(--line);font-size:.8rem;font-weight:500;color:var(--ink-2)!important;transition:border-color .2s,color .2s}
.chip:hover{border-color:var(--teal);color:var(--teal)!important}

/* Hero visual */
.hero__visual{position:relative;max-width:480px;width:100%;justify-self:end}
@media(max-width:980px){.hero__visual{justify-self:center}}
.feature{position:relative;display:block;border-radius:28px;overflow:hidden;aspect-ratio:4/4.6;background:var(--line);box-shadow:var(--shadow-lg)}
.feature img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .8s}
.feature:hover img{transform:scale(1.04)}
.feature__shade{position:absolute;inset:0;background:linear-gradient(180deg,transparent 45%,rgba(1,15,38,.85))}
.feature__tag{position:absolute;top:18px;left:18px;font-size:.72rem;font-weight:600;color:#fff;background:rgba(1,15,38,.5);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);padding:6px 12px;border-radius:999px}
.feature__info{position:absolute;left:22px;right:22px;bottom:22px;color:#fff}
.feature__price{font-size:1.5rem;font-weight:700;letter-spacing:-.02em}
.feature__title{font-size:.92rem;opacity:.92;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.feature__loc{display:flex;align-items:center;gap:5px;font-size:.8rem;opacity:.75;margin-top:6px}
.float{position:absolute;background:var(--raised);border:1px solid var(--line);border-radius:18px;box-shadow:var(--shadow-lg);padding:14px 16px}
.float--val{left:-36px;bottom:110px;width:250px}
.float--val h4{margin:0 0 4px;font-size:.92rem;font-weight:600;color:var(--ink)}
.float--val p{margin:0 0 12px;font-size:.78rem;line-height:1.5;color:var(--ink-2)}
.float--val .btn{padding:10px 16px;font-size:.8rem;width:100%}
.float--ok{right:-20px;top:36px;display:flex;align-items:center;gap:10px;font-size:.8rem;color:var(--ink-2)}
.float--ok strong{display:block;color:var(--ink);font-size:.86rem}
.ico-badge{width:38px;height:38px;border-radius:12px;display:grid;place-items:center;background:var(--teal-soft);color:var(--teal)}
@media(max-width:560px){.float--val{left:12px;bottom:-28px;width:calc(100% - 24px);display:flex;align-items:center;gap:12px}.float--val p{display:none}.float--val h4{flex:1;margin:0}.float--val .btn{width:auto}.float--ok{right:12px;top:12px}.hero__visual{margin-bottom:28px}}
.checklist-panel{background:var(--navy);color:#fff;border-radius:28px;padding:44px 36px 96px;box-shadow:var(--shadow-lg)}
.is-panel .float--val{bottom:-36px;left:auto;right:-20px}
.is-panel .float--ok{top:-24px;right:auto;left:-28px}
@media(max-width:560px){.is-panel .float--val{left:12px;right:auto;bottom:-28px}.is-panel .float--ok{display:none}}

/* ── Stats ──────────────────────────────────────────── */
.stats{display:grid;grid-template-columns:repeat(4,1fr);background:var(--raised);border:1px solid var(--line);border-radius:var(--r-lg);box-shadow:var(--shadow-sm);margin-top:48px;position:relative;z-index:2}
.stat{padding:26px 28px;display:flex;align-items:center;gap:14px}
.stat + .stat{border-left:1px solid var(--line)}
.stat__val{font-size:1.55rem;font-weight:700;letter-spacing:-.02em;line-height:1}
.stat__lbl{font-size:.8rem;color:var(--ink-3);margin-top:5px}
@media(max-width:860px){.stats{grid-template-columns:1fr 1fr}.stat:nth-child(3){border-left:0}.stat:nth-child(n+3){border-top:1px solid var(--line)}.stat{padding:20px}}

/* ── Property cards ─────────────────────────────────── */
.props{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
@media(max-width:980px){.props{grid-template-columns:repeat(2,1fr)}}
@media(max-width:640px){.props{display:flex;overflow-x:auto;scroll-snap-type:x mandatory;gap:14px;margin:0 -16px;padding:4px 16px 12px;scrollbar-width:none}.props::-webkit-scrollbar{display:none}.pcard{flex:0 0 84%;scroll-snap-align:start}}
.pcard{background:var(--raised);border:1px solid var(--line);border-radius:var(--r-lg);overflow:hidden;display:flex;flex-direction:column;transition:transform .25s,box-shadow .25s,border-color .25s}
.pcard:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:transparent}
.pcard__img{position:relative;aspect-ratio:4/3;background:var(--canvas);overflow:hidden}
.pcard__img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s}
.pcard:hover .pcard__img img{transform:scale(1.05)}
.pcard__ph{width:100%;height:100%;display:grid;place-items:center;color:var(--ink-3)}
.pcard__tags{position:absolute;top:14px;left:14px;right:14px;display:flex;justify-content:space-between;gap:8px}
.tag{font-size:.7rem;font-weight:600;padding:5px 11px;border-radius:999px;background:rgba(255,255,255,.94);color:#0b1b33}
.pcard__body{padding:20px 20px 18px;display:flex;flex-direction:column;flex:1}
.pcard__price{font-size:1.28rem;font-weight:700;letter-spacing:-.02em}
.pcard__title{font-size:.92rem;font-weight:500;color:var(--ink);margin:4px 0 6px;line-height:1.45;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.pcard__loc{display:flex;align-items:center;gap:6px;font-size:.8rem;color:var(--ink-3)}
.pcard__specs{display:flex;flex-wrap:wrap;gap:6px;margin-top:14px}
.spec{font-size:.75rem;font-weight:500;color:var(--ink-2);background:var(--canvas);border-radius:8px;padding:5px 10px}
.pcard__foot{display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:16px;border-top:1px solid var(--line);margin-top:18px}
.icon-btn{width:36px;height:36px;border-radius:50%;display:grid;place-items:center;border:1px solid var(--line);color:var(--ink-2)!important;transition:border-color .2s,color .2s}
.icon-btn:hover{border-color:var(--teal);color:var(--teal)!important}
.empty{text-align:center;padding:56px 24px;border:1.5px dashed var(--line);border-radius:var(--r-lg);color:var(--ink-2)}

/* ── Services bento ─────────────────────────────────── */
.bento{display:grid;grid-template-columns:1.25fr 1fr 1fr;grid-auto-rows:minmax(220px,auto);gap:20px}
@media(max-width:980px){.bento{grid-template-columns:1fr 1fr}.bento__hero{grid-column:1/-1}}
@media(max-width:600px){.bento{grid-template-columns:1fr}}
.tile{position:relative;background:var(--raised);border:1px solid var(--line);border-radius:var(--r-lg);padding:28px;display:flex;flex-direction:column;text-align:left;font:inherit;color:inherit;cursor:pointer;width:100%;transition:transform .25s,box-shadow .25s,border-color .25s}
.tile:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:transparent}
.tile h3{font-size:1.08rem;font-weight:600;letter-spacing:-.01em;margin:18px 0 8px}
.tile p{font-size:.86rem;line-height:1.65;color:var(--ink-2);margin:0 0 18px}
.tile .link-arrow{margin-top:auto}
.tile__ico{width:46px;height:46px;border-radius:14px;display:grid;place-items:center}
.bento__hero{grid-row:span 2;background:var(--navy);border-color:var(--navy);color:#fff;padding:36px;overflow:hidden}
.bento__hero::after{content:'';position:absolute;right:-80px;bottom:-80px;width:260px;height:260px;border-radius:50%;border:48px solid rgba(255,255,255,.04);pointer-events:none}
.tile.bento__hero h3{font-size:1.5rem;font-weight:700;margin-top:22px;color:#fff}
.tile h3,.step h3,.xcol h3,.news h3,.cta__talk h3,.float--val h4{color:var(--ink)}
.bento__hero p{color:rgba(255,255,255,.72)}
.bento__hero .link-arrow{color:#fff}
.price-from{display:inline-flex;align-items:baseline;gap:6px;font-size:.8rem;color:rgba(255,255,255,.6);margin-bottom:18px}
.price-from strong{font-size:1.6rem;color:#fff;font-weight:700;letter-spacing:-.02em}
.ticks{list-style:none;margin:0 0 26px;padding:0;display:grid;gap:10px}
.ticks li{display:flex;align-items:flex-start;gap:10px;font-size:.88rem;color:rgba(255,255,255,.88)}
.ticks svg{color:#4fd1c5;margin-top:3px}

/* ── Steps ──────────────────────────────────────────── */
.steps{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;counter-reset:step}
@media(max-width:860px){.steps{grid-template-columns:1fr}}
.step{position:relative;padding:28px;border-radius:var(--r-lg);background:var(--raised);border:1px solid var(--line)}
.step__num{font-size:.75rem;font-weight:700;color:var(--accent);background:var(--accent-soft);width:34px;height:34px;border-radius:50%;display:grid;place-items:center;margin-bottom:18px}
.step h3{font-size:1.02rem;font-weight:600;margin:0 0 8px}
.step p{font-size:.86rem;line-height:1.65;color:var(--ink-2);margin:0}

/* ── Reviews ────────────────────────────────────────── */
.rev-head{display:grid;grid-template-columns:1fr auto;gap:24px;align-items:end;margin-bottom:36px}
@media(max-width:760px){.rev-head{grid-template-columns:1fr}}
.score{display:flex;align-items:center;gap:16px}
.score__num{font-size:3rem;font-weight:700;letter-spacing:-.04em;line-height:1}
.score__meta{font-size:.82rem;color:var(--ink-2)}
.score__meta .stars{font-size:1.05rem}
.rev-track{display:flex;gap:20px;overflow-x:auto;scroll-snap-type:x mandatory;scroll-behavior:smooth;padding:4px 2px 18px;scrollbar-width:none}
.rev-track::-webkit-scrollbar{display:none}
.rcard{flex:0 0 calc((100% - 40px)/3);scroll-snap-align:start;background:var(--raised);border:1px solid var(--line);border-radius:var(--r-lg);padding:26px;display:flex;flex-direction:column}
@media(max-width:980px){.rcard{flex-basis:calc((100% - 20px)/2)}}
@media(max-width:640px){.rcard{flex-basis:86%}}
.rcard__q{color:var(--teal);opacity:.35;margin-bottom:8px}
.rcard__text{font-size:.9rem;line-height:1.75;color:var(--ink);margin:10px 0 22px;flex:1}
.rcard__who{display:flex;align-items:center;gap:12px;padding-top:18px;border-top:1px solid var(--line)}
.avatar{width:40px;height:40px;border-radius:50%;display:grid;place-items:center;font-weight:600;font-size:.95rem;color:#fff}
.rcard__name{font-size:.88rem;font-weight:600}
.rcard__via{font-size:.74rem;color:var(--ink-3);display:flex;align-items:center;gap:5px}
.rev-foot{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-top:12px}
.rev-nav{display:flex;gap:8px}
.rev-nav button{width:44px;height:44px;border-radius:50%;border:1px solid var(--line);background:var(--raised);color:var(--ink);display:grid;place-items:center;cursor:pointer;transition:border-color .2s,background .2s}
.rev-nav button:hover{border-color:var(--ink)}
.rev-links{display:flex;gap:10px;flex-wrap:wrap}

/* ── Explore ────────────────────────────────────────── */
.explore{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
@media(max-width:900px){.explore{grid-template-columns:1fr}}
.xcol{background:var(--raised);border:1px solid var(--line);border-radius:var(--r-lg);padding:26px}
.xcol h3{display:flex;align-items:center;gap:10px;font-size:.98rem;font-weight:600;margin:0 0 16px}
.xlist{list-style:none;margin:0;padding:0}
.xlist a{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:11px 0;font-size:.87rem;color:var(--ink-2)!important;border-top:1px solid var(--line);transition:color .2s}
.xlist li:first-child a{border-top:0}
.xlist a:hover{color:var(--teal)!important}
.xlist a svg{opacity:.4;transition:opacity .2s,transform .2s}
.xlist a:hover svg{opacity:1;transform:translateX(3px)}

/* ── Insights ───────────────────────────────────────── */
.insights{display:grid;grid-template-columns:1.6fr 1fr;gap:28px}
@media(max-width:900px){.insights{grid-template-columns:1fr}}
.articles{display:grid;grid-template-columns:1.15fr 1fr;gap:20px}
@media(max-width:640px){.articles{grid-template-columns:1fr}}
.acard{display:flex;flex-direction:column;gap:12px}
.acard__img{border-radius:var(--r-md);overflow:hidden;aspect-ratio:1200/630;background:var(--canvas)}
.acard__img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s}
.acard:hover .acard__img img{transform:scale(1.04)}
.acard__cat{font-size:.7rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--teal)}
.acard__title{font-size:1.02rem;font-weight:600;line-height:1.4;letter-spacing:-.01em;transition:color .2s}
.acard:hover .acard__title{color:var(--teal)}
.acard__date{font-size:.76rem;color:var(--ink-3)}
.acard--big .acard__title{font-size:1.2rem}
.astack{display:flex;flex-direction:column;gap:20px}
.astack .acard{flex-direction:row;align-items:flex-start}
.astack .acard__img{flex:0 0 150px;aspect-ratio:1200/630;border-radius:var(--r-sm)}
.news{background:var(--canvas);border-radius:var(--r-lg);padding:26px}
.section--canvas .news{background:var(--raised);border:1px solid var(--line)}
.news h3{display:flex;align-items:center;justify-content:space-between;font-size:1rem;font-weight:600;margin:0 0 8px}
.nitem{display:block;padding:16px 0;border-top:1px solid var(--line)}
.nitem:first-of-type{border-top:0}
.nitem__title{font-size:.9rem;font-weight:500;line-height:1.5;transition:color .2s;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.nitem:hover .nitem__title{color:var(--teal)}
.nitem__meta{font-size:.74rem;color:var(--ink-3);margin-top:6px}

/* ── CTA ────────────────────────────────────────────── */
.cta{display:grid;grid-template-columns:1.4fr 1fr;gap:20px}
@media(max-width:860px){.cta{grid-template-columns:1fr}}
.cta__sell{position:relative;overflow:hidden;background:linear-gradient(135deg,var(--navy) 0%,var(--navy-2) 60%,#005b63 130%);color:#fff;border-radius:28px;padding:48px}
.cta__sell::after{content:'';position:absolute;right:-60px;top:-60px;width:240px;height:240px;border-radius:50%;background:rgba(255,92,0,.18);filter:blur(60px)}
.cta__sell h2{font-size:clamp(1.5rem,2.8vw,2rem);font-weight:700;letter-spacing:-.025em;margin:0 0 12px;position:relative}
.cta__sell p{color:rgba(255,255,255,.72);font-size:.95rem;line-height:1.7;margin:0 0 28px;max-width:440px;position:relative}
.cta__btns{display:flex;gap:12px;flex-wrap:wrap;position:relative}
.cta__talk{background:var(--raised);border:1px solid var(--line);border-radius:28px;padding:40px;display:flex;flex-direction:column}
.cta__talk h3{font-size:1.3rem;font-weight:700;letter-spacing:-.02em;margin:0 0 8px}
.cta__talk p{font-size:.88rem;line-height:1.65;color:var(--ink-2);margin:0 0 24px}
.cta__talk .btn{width:100%;margin-bottom:10px}
.addr{display:flex;gap:10px;font-size:.8rem;line-height:1.55;color:var(--ink-3);margin-top:auto;padding-top:14px}
@media(max-width:560px){.cta__sell,.cta__talk{padding:30px 24px}}
/* ── Original hero (restored) ── */
.hp a.obtn-primary,.hp a.obtn-navy{color:#fff}
/* Buttons */
.obtn{display:inline-flex;align-items:center;gap:8px;font-family:'Poppins',sans-serif;font-weight:600;border-radius:10px;text-decoration:none;cursor:pointer;transition:all .2s;border:none;padding:11px 24px;font-size:.88rem}
.obtn-primary{background:linear-gradient(135deg,#FF5C00,#ff8840);color:#fff;box-shadow:0 4px 16px rgba(255,92,0,.28)}
.obtn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(255,92,0,.4);color:#fff;text-decoration:none}
.obtn-navy{background:#011f4b;color:#fff}
.obtn-navy:hover{background:#023372;color:#fff;text-decoration:none;transform:translateY(-2px)}
.obtn-ghost{background:rgba(255,255,255,.1);color:rgba(255,255,255,.88);border:1.5px solid rgba(255,255,255,.25)}
.obtn-ghost:hover{background:rgba(255,255,255,.2);color:#fff;text-decoration:none}
.obtn-outline{background:#fff;color:#008080;border:2px solid #008080}
.obtn-outline:hover{background:#008080;color:#fff;text-decoration:none}
.obtn-lg{padding:14px 32px;font-size:.95rem;border-radius:12px}

/* ── HERO ── */
.ohero{background:linear-gradient(135deg,#011f4b 0%,#013870 50%,#005f6b 100%);padding:84px 0 110px;position:relative;overflow:hidden}
.ohero__orb{position:absolute;border-radius:50%;filter:blur(90px);pointer-events:none}
.ohero__orb-a{width:560px;height:560px;background:rgba(0,128,128,.22);top:-140px;right:-100px;animation:float 9s ease-in-out infinite}
.ohero__orb-b{width:360px;height:360px;background:rgba(255,92,0,.14);bottom:-80px;left:-60px;animation:float 11s ease-in-out infinite 3s}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-16px)}}
.ohero__grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:52px 52px}
.ohero__inner{position:relative;z-index:2;display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center}
.ohero__badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.2);border-radius:99px;padding:7px 18px;margin-bottom:22px;font-size:11px;font-weight:600;color:rgba(255,255,255,.85);letter-spacing:.3px}
.ohero__dot{width:7px;height:7px;border-radius:50%;background:#4ade80;flex-shrink:0;animation:pulse-dot 2.5s infinite}
@keyframes pulse-dot{0%,100%{box-shadow:0 0 0 2px rgba(74,222,128,.3)}50%{box-shadow:0 0 0 6px rgba(74,222,128,.08)}}
.ohero__h1{font-size:clamp(2rem,4.2vw,3.2rem);font-weight:800;color:#fff;line-height:1.12;margin-bottom:18px;letter-spacing:-.4px}
.ohero__h1 em{font-style:normal;color:#FF5C00}
.ohero__sub{font-size:.95rem;color:rgba(255,255,255,.68);line-height:1.82;margin-bottom:28px;max-width:460px}
.ohero__cta{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:32px}
.ohero__stats{display:flex;gap:0;flex-wrap:wrap;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:14px;padding:16px 0;overflow:hidden}
.ohero__stat{flex:1;padding:0 22px;text-align:center;min-width:90px}
.ohero__stat+.ohero__stat{border-left:1px solid rgba(255,255,255,.12)}
.ohero__stat-val{font-size:1.5rem;font-weight:800;color:#fff;line-height:1}
.ohero__stat-lbl{font-size:.7rem;color:rgba(255,255,255,.45);margin-top:5px;text-transform:uppercase;letter-spacing:.5px}

/* Valuation card (ohero right) */
.hv-card{background:#fff;border-radius:20px;padding:24px;box-shadow:0 28px 72px rgba(0,0,0,.24)}
.hv-card-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
.hv-live{display:flex;align-items:center;gap:7px;font-size:11px;font-weight:600;color:#64748b}
.hv-beta{font-size:10px;font-weight:700;letter-spacing:.5px;background:rgba(255,92,0,.1);color:#FF5C00;padding:3px 9px;border-radius:5px;border:1px solid rgba(255,92,0,.2)}
.hv-locality{font-size:1rem;font-weight:700;color:#011f4b}
.hv-type{font-size:.75rem;color:#94a3b8;margin-bottom:16px}
.hv-price-row{margin-bottom:18px;padding-bottom:16px;border-bottom:1px solid #f1f5f9}
.hv-plabel{font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:4px}
.hv-price{font-size:1.3rem;font-weight:800;color:#008080;margin-bottom:3px}
.hv-psub{font-size:.7rem;color:#94a3b8}
.hv-factors{display:flex;flex-direction:column;gap:10px;margin-bottom:16px}
.hv-factor{display:flex;align-items:center;gap:9px;font-size:.74rem;color:#4b5563}
.hv-factor span{width:108px;flex-shrink:0}
.hv-bar{flex:1;height:5px;background:#f1f5f9;border-radius:99px;overflow:hidden}
.hv-bar div{height:100%;background:linear-gradient(90deg,#008080,#2eb8b8);border-radius:99px;animation:bar-in 1.3s ease forwards}
@keyframes bar-in{from{width:0}}
.hv-factor b{font-size:.74rem;color:#011f4b;width:44px;text-align:right;flex-shrink:0}
.hv-notice{font-size:.7rem;color:#94a3b8;line-height:1.6;display:flex;align-items:flex-start;gap:7px;background:#f8fafc;padding:10px 12px;border-radius:9px}
.hv-notice i{color:#d97706;flex-shrink:0;margin-top:2px}

/* floating badges */
.hv-badge{position:absolute;background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:9px 14px;display:flex;align-items:center;gap:9px;box-shadow:0 6px 22px rgba(0,0,0,.1);font-size:.78rem}
.hv-badge strong{display:block;font-weight:700;color:#011f4b;font-size:.78rem}
.hv-badge span{font-size:.68rem;color:#94a3b8}
.hv-badge-tl{top:-16px;left:-16px;animation:float 7s ease-in-out infinite}
.hv-badge-br{bottom:-14px;right:-10px;animation:float 9s ease-in-out infinite 2s}
.ohero__right-wrap{position:relative}
@media(max-width:600px){.hv-badge{display:none}}

.ohero__wave{position:absolute;bottom:0;left:0;right:0;line-height:0;color:var(--surface)}
.ohero__wave svg{width:100%;height:56px;display:block}
@media(max-width:820px){.ohero__inner{grid-template-columns:1fr;gap:36px}.ohero{padding:64px 0 88px}}
@media(max-width:480px){.ohero__cta{flex-direction:column}.ohero__stats{gap:0}}
</style>
@endpush

@section('content')
@php
    $propImage = function ($p) {
        if ($p->featured_image && file_exists(public_path($p->featured_image))) return asset($p->featured_image);
        $first = $p->images->first();
        return $first && file_exists(public_path($first->image_path)) ? asset($first->image_path) : null;
    };
    $heroProp = $properties->first(fn ($p) => $propImage($p));
    $avatarColors = ['#0f766e', '#1d4ed8', '#c2410c', '#7c3aed', '#be185d', '#0369a1'];
    $gLogo = '<svg width="14" height="14" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>';
    $arrow = '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
    $pin = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>';
    $tick = '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>';
@endphp
<div class="hp">

{{-- ═════════════ HERO (original design) ═════════════ --}}
<section class="ohero">
    <div class="ohero__grid"></div>
    <div class="ohero__orb ohero__orb-a"></div>
    <div class="ohero__orb ohero__orb-b"></div>
    <div class="wrap ohero__inner">
        <div>
            <div class="ohero__badge">
                <span class="ohero__dot"></span>
                Lucknow's Trusted Property Platform
            </div>
            <h1 class="ohero__h1">
                Buy, Sell & Verify<br>
                Property in Lucknow<br>
                <em>With Confidence</em>
            </h1>
            <p class="ohero__sub">
                Verified listings, free property valuation, legal document checks, and expert advisory — everything you need in one place.
            </p>
            <div class="ohero__cta">
                <a href="/properties" class="obtn obtn-primary obtn-lg">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Browse Properties
                </a>
                <button onclick="ValuationComponent.open()" class="obtn obtn-ghost obtn-lg">Free Valuation →</button>
            </div>
            <div class="ohero__stats">
                <div class="ohero__stat">
                    <div class="ohero__stat-val" style="display:flex;align-items:center;justify-content:center;gap:6px;">
                        <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        {{ $reviewAvg }} ★
                    </div>
                    <div class="ohero__stat-lbl">Google Rating</div>
                </div>
                <div class="ohero__stat">
                    <div class="ohero__stat-val">50+</div>
                    <div class="ohero__stat-lbl">Localities Covered</div>
                </div>
                <div class="ohero__stat">
                    <div class="ohero__stat-val">{{ $reviewCount }}+</div>
                    <div class="ohero__stat-lbl">Google Reviews</div>
                </div>
            </div>
        </div>

        <div class="ohero__right-wrap rv" style="--d:.2s">
            <div class="hv-badge hv-badge-tl">
                <svg width="22" height="22" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                <div>
                    <strong>{{ $reviewAvg }} ★ Rated</strong>
                    <span>{{ $reviewCount }} Google Reviews</span>
                </div>
            </div>
            <div class="hv-card">
                <div class="hv-card-top">
                    <div class="hv-live">
                        <span style="width:8px;height:8px;border-radius:50%;background:#10b981;display:inline-block;flex-shrink:0;animation:pulse-dot 2.5s infinite;"></span>
                        Illustrative Example
                    </div>
                    <span class="hv-beta">BETA</span>
                </div>
                <div class="hv-locality">Vibhuti Khand, Lucknow</div>
                <div class="hv-type">3BHK Flat · ~1,200 sqft</div>
                <div class="hv-price-row">
                    <div class="hv-plabel">Estimated Price Band</div>
                    <div class="hv-price">₹68L – ₹82L</div>
                    <div class="hv-psub">₹5,700 – ₹6,800 per sq.ft</div>
                </div>
                <div class="hv-factors">
                    <div class="hv-factor">
                        <span>Location Score</span>
                        <div class="hv-bar"><div style="width:82%"></div></div>
                        <b>8.2/10</b>
                    </div>
                    <div class="hv-factor">
                        <span>Market Demand</span>
                        <div class="hv-bar"><div style="width:75%"></div></div>
                        <b>High</b>
                    </div>
                    <div class="hv-factor">
                        <span>Connectivity</span>
                        <div class="hv-bar"><div style="width:68%"></div></div>
                        <b>Good</b>
                    </div>
                </div>
                <div class="hv-notice">
                    <i class="fas fa-info-circle"></i>
                    <span>Example figures for illustration only — not a live valuation. Get a free expert valuation for your property's actual price.</span>
                </div>
                <button onclick="ValuationComponent.open()" class="obtn obtn-navy" style="width:100%;justify-content:center;margin-top:14px;">
                    Get Free Expert Valuation →
                </button>
            </div>
            <div class="hv-badge hv-badge-br">
                <span style="font-size:18px">📍</span>
                <div>
                    <strong>50+ Localities</strong>
                    <span>Price data available</span>
                </div>
            </div>
        </div>
    </div>
    <div class="ohero__wave">
        <svg viewBox="0 0 1440 52" preserveAspectRatio="none"><path d="M0,26 C480,52 960,0 1440,26 L1440,52 L0,52 Z" fill="currentColor"/></svg>
    </div>
</section>

{{-- ═════════════ STATS ═════════════ --}}
<div class="wrap">
    <div class="stats rv">
        <div class="stat">
            <span class="ico-badge" style="background:#fff7e6;color:var(--star)"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/></svg></span>
            <div><div class="stat__val">{{ $reviewAvg }}</div><div class="stat__lbl">Google rating</div></div>
        </div>
        <div class="stat">
            <span class="ico-badge"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
            <div><div class="stat__val">{{ $reviewCount }}+</div><div class="stat__lbl">Client reviews</div></div>
        </div>
        <div class="stat">
            <span class="ico-badge" style="background:var(--accent-soft);color:var(--accent)">{!! str_replace('width="14" height="14"', 'width="18" height="18"', $pin) !!}</span>
            <div><div class="stat__val">50+</div><div class="stat__lbl">Localities price-mapped</div></div>
        </div>
        <div class="stat">
            <span class="ico-badge" style="background:#eef2ff;color:#4f46e5"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 5-6"/></svg></span>
            <div><div class="stat__val">₹0</div><div class="stat__lbl">Valuation fee</div></div>
        </div>
    </div>
</div>

{{-- ═════════════ PROPERTIES ═════════════ --}}
<section class="section">
    <div class="wrap">
        <div class="sec-head">
            <div>
                <div class="eyebrow rv">Latest listings</div>
                <h2 class="h2 rv" style="--d:.05s">Properties in Lucknow</h2>
                <p class="lead rv" style="--d:.1s">Flats, houses, plots and commercial spaces — every listing reviewed before it goes live.</p>
            </div>
            <a href="{{ route('properties.index') }}" class="btn btn-line rv">View all properties {!! $arrow !!}</a>
        </div>

        @if($properties->isEmpty())
            <div class="empty rv">
                <h3 style="margin:0 0 6px;font-size:1.05rem">New listings coming soon</h3>
                <p style="margin:0;font-size:.9rem">Own a property in Lucknow? <a href="/seller/register" style="color:var(--teal);font-weight:600">List it free</a>.</p>
            </div>
        @else
            <div class="props">
                @foreach($properties as $p)
                @php $img = $propImage($p); @endphp
                <article class="pcard rv" style="--d:{{ ($loop->index % 3) * 0.07 }}s">
                    <a href="{{ route('properties.show', $p->slug) }}" class="pcard__img" tabindex="-1" aria-hidden="true">
                        @if($img)
                            <img src="{{ $img }}" alt="" width="400" height="300" loading="lazy" decoding="async">
                        @else
                            <span class="pcard__ph"><svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 10 12 3l9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></svg></span>
                        @endif
                        <span class="pcard__tags">
                            <span class="tag">{{ $p->getTypeLabel() }}</span>
                        </span>
                    </a>
                    <div class="pcard__body">
                        <div class="pcard__price">{{ $p->getPriceDisplay() }}</div>
                        <h3 class="pcard__title"><a href="{{ route('properties.show', $p->slug) }}">{{ $p->title }}</a></h3>
                        <div class="pcard__loc">{!! $pin !!} {{ $p->locality }}, Lucknow</div>
                        @if($p->bedrooms > 0 || $p->bathrooms || $p->area)
                        <div class="pcard__specs">
                            @if($p->bedrooms > 0)<span class="spec">{{ $p->bedrooms }} BHK</span>@endif
                            @if($p->bathrooms)<span class="spec">{{ $p->bathrooms }} Bath</span>@endif
                            @if($p->area)<span class="spec">{{ number_format($p->area, 0) }} {{ $p->getAreaUnitLabel() }}</span>@endif
                        </div>
                        @endif
                        <div class="pcard__foot">
                            <a href="{{ route('properties.show', $p->slug) }}" class="link-arrow">View details {!! $arrow !!}</a>
                            @if($p->lat && $p->lng)
                            <a href="https://www.google.com/maps?q={{ $p->lat }},{{ $p->lng }}" target="_blank" rel="noopener" class="icon-btn" title="Open location in Google Maps" aria-label="Open location in Google Maps">{!! $pin !!}</a>
                            @endif
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ═════════════ SERVICES ═════════════ --}}
<section class="section section--canvas">
    <div class="wrap">
        <div class="sec-head">
            <div>
                <div class="eyebrow rv">What we do</div>
                <h2 class="h2 rv" style="--d:.05s">Everything you need, one trusted team</h2>
                <p class="lead rv" style="--d:.1s">From the first site visit to the registry office — expert help at every step of your property journey.</p>
            </div>
        </div>

        <div class="bento">
            <a href="/services/property-verification-lucknow" class="tile bento__hero rv">
                <span class="tile__ico" style="background:rgba(79,209,197,.14);color:#4fd1c5">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                </span>
                <h3>Property Verification</h3>
                <p>Know exactly what you're buying. We physically check records at LDA, Sub-Registrar, Tehsil and court offices — not just photocopies.</p>
                <span class="price-from">from <strong>₹5,000</strong></span>
                <ul class="ticks">
                    <li>{!! $tick !!} Title chain &amp; ownership history</li>
                    <li>{!! $tick !!} Encumbrance &amp; loan search</li>
                    <li>{!! $tick !!} LDA approval &amp; map check</li>
                    <li>{!! $tick !!} Written PDF report</li>
                </ul>
                <span class="link-arrow">Explore verification {!! $arrow !!}</span>
            </a>

            <a href="/services/property-advisory-lucknow" class="tile rv" style="--d:.06s">
                <span class="tile__ico" style="background:var(--accent-soft);color:var(--accent)"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></span>
                <h3>Property Advisory</h3>
                <p>Unbiased guidance on buying, selling or investing. First consultation is free.</p>
                <span class="link-arrow">Learn more {!! $arrow !!}</span>
            </a>

            <a href="/services/property-registry-lucknow" class="tile rv" style="--d:.12s">
                <span class="tile__ico" style="background:#eef2ff;color:#4f46e5"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 15l2 2 4-4"/></svg></span>
                <h3>Registry Assistance</h3>
                <p>Sale deed drafting, stamp duty checks and Sub-Registrar support. Fixed fee, quoted upfront.</p>
                <span class="link-arrow">Learn more {!! $arrow !!}</span>
            </a>

            <button type="button" onclick="ValuationComponent.open()" class="tile rv" style="--d:.06s">
                <span class="tile__ico" style="background:var(--teal-soft);color:var(--teal)"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 5-6"/></svg></span>
                <h3>Free Valuation</h3>
                <p>A data-backed price estimate for any flat, house or plot in Lucknow — no obligation.</p>
                <span class="link-arrow">Get my estimate {!! $arrow !!}</span>
            </button>

            <a href="/seller/register" class="tile rv" style="--d:.12s">
                <span class="tile__ico" style="background:#fdf2f8;color:#db2777"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20.59 13.41 13.42 20.6a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5"/></svg></span>
                <h3>Sell Your Property</h3>
                <p>List free and get direct inquiries from genuine buyers across Lucknow.</p>
                <span class="link-arrow">List for free {!! $arrow !!}</span>
            </a>
        </div>
    </div>
</section>

{{-- ═════════════ HOW IT WORKS ═════════════ --}}
<section class="section">
    <div class="wrap">
        <div class="sec-head sec-head--center">
            <div class="eyebrow rv">How it works</div>
            <h2 class="h2 rv" style="--d:.05s">Clear advice in three simple steps</h2>
        </div>
        <div class="steps">
            <div class="step rv">
                <div class="step__num">01</div>
                <h3>Tell us what you need</h3>
                <p>Call, WhatsApp or search online. Share your budget, preferred areas or the property you're considering.</p>
            </div>
            <div class="step rv" style="--d:.08s">
                <div class="step__num">02</div>
                <h3>We research &amp; verify</h3>
                <p>We compare locality prices, check documents at the source offices and flag anything that doesn't add up.</p>
            </div>
            <div class="step rv" style="--d:.16s">
                <div class="step__num">03</div>
                <h3>Decide with confidence</h3>
                <p>Get a clear recommendation, then our team helps you through negotiation, paperwork and registry.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═════════════ PRICE MAP ═════════════ --}}
<section class="section section--canvas" id="price-map">
    <div class="wrap rv">
        <x-price-map/>
    </div>
</section>

{{-- ═════════════ REVIEWS ═════════════ --}}
@if($reviews->isNotEmpty())
<section class="section">
    <div class="wrap">
        <div class="rev-head">
            <div>
                <div class="eyebrow rv">Client stories</div>
                <h2 class="h2 rv" style="--d:.05s">Trusted by buyers, sellers &amp; investors</h2>
            </div>
            <div class="score rv" style="--d:.1s">
                <div class="score__num">{{ $reviewAvg }}</div>
                <div class="score__meta">
                    <div class="stars" aria-label="{{ $reviewAvg }} out of 5 stars">★★★★★</div>
                    <div style="display:flex;align-items:center;gap:6px">{!! $gLogo !!} Based on {{ $reviewCount }}+ Google reviews</div>
                </div>
            </div>
        </div>

        <div class="rev-track" id="revTrack">
            @foreach($reviews as $r)
            <figure class="rcard" style="margin:0">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span class="stars" aria-label="{{ $r->rating }} out of 5 stars">{{ str_repeat('★', $r->rating) }}</span>
                    <svg class="rcard__q" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7.17 17q-1.37 0-2.27-.95Q4 15.1 4 13.6q0-1.52.6-3.03.6-1.52 1.7-2.8Q7.4 6.5 8.85 5.7l1.08 1.4q-1.08.7-1.9 1.73-.82 1.02-1 2.22.18-.05.42-.05h.34q1.2 0 2.03.86.83.86.83 2.11 0 1.3-.88 2.16-.88.87-2.4.87Zm9 0q-1.37 0-2.27-.95-.9-.95-.9-2.45 0-1.52.6-3.03.6-1.52 1.7-2.8 1.1-1.27 2.55-2.07l1.08 1.4q-1.08.7-1.9 1.73-.82 1.02-1 2.22.18-.05.42-.05h.34q1.2 0 2.03.86.83.86.83 2.11 0 1.3-.88 2.16-.88.87-2.4.87Z"/></svg>
                </div>
                <blockquote class="rcard__text" style="margin-left:0;margin-right:0">{{ Str::limit($r->review_text, 260) }}</blockquote>
                <figcaption class="rcard__who">
                    <span class="avatar" style="background:{{ $avatarColors[$loop->index % count($avatarColors)] }}">{{ Str::upper(Str::substr($r->reviewer_name, 0, 1)) }}</span>
                    <span>
                        <span class="rcard__name" style="display:block">{{ $r->reviewer_name }}</span>
                        <span class="rcard__via">{!! $gLogo !!} Google · {{ $r->review_date->diffForHumans() }}</span>
                    </span>
                </figcaption>
            </figure>
            @endforeach
        </div>

        <div class="rev-foot">
            <div class="rev-links">
                <a href="https://www.google.com/maps?cid=14659186425526983202" target="_blank" rel="noopener" class="btn btn-line">Read all reviews on Google</a>
                <a href="https://g.page/r/CSKaw-Vi5G_LEBM/review" target="_blank" rel="noopener" class="btn btn-line">Write a review</a>
            </div>
            <div class="rev-nav">
                <button type="button" data-rev="-1" aria-label="Previous reviews"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg></button>
                <button type="button" data-rev="1" aria-label="Next reviews"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg></button>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═════════════ EXPLORE ═════════════ --}}
<section class="section section--canvas">
    <div class="wrap">
        <div class="sec-head">
            <div>
                <div class="eyebrow rv">Research hub</div>
                <h2 class="h2 rv" style="--d:.05s">Explore Lucknow real estate</h2>
                <p class="lead rv" style="--d:.1s">Government schemes, area guides and free tools to help you decide.</p>
            </div>
        </div>
        <div class="explore">
            <div class="xcol rv">
                <h3><span class="ico-badge">{!! $tick !!}</span> Schemes &amp; projects</h3>
                <ul class="xlist">
                    <li><a href="/lda-schemes">LDA Schemes Lucknow {!! $arrow !!}</a></li>
                    <li><a href="/awas-vikas-schemes">Awas Vikas Schemes {!! $arrow !!}</a></li>
                    <li><a href="/rera-approved-projects-lucknow">RERA Approved Projects {!! $arrow !!}</a></li>
                    <li><a href="/lda-demolition-tracker">LDA Demolition Tracker {!! $arrow !!}</a></li>
                    <li><a href="/blog/it-city-lucknow-lda-plots-guide-2026">IT City LDA Plots {!! $arrow !!}</a></li>
                </ul>
            </div>
            <div class="xcol rv" style="--d:.06s">
                <h3><span class="ico-badge" style="background:var(--accent-soft);color:var(--accent)">{!! $pin !!}</span> Popular areas</h3>
                <ul class="xlist">
                    <li><a href="/blog/gomti-nagar-extension-lucknow-guide-2026">Gomti Nagar Extension {!! $arrow !!}</a></li>
                    <li><a href="/blog/rise-of-sultanpur-road-lucknow-real-estate-hotspot">Sultanpur Road {!! $arrow !!}</a></li>
                    <li><a href="/blog/vrindavan-yojna-lucknow-investment-guide-2026">Vrindavan Yojna {!! $arrow !!}</a></li>
                    <li><a href="/blog/mohanlalganj-lucknow-real-estate-guide-2026">Mohanlalganj {!! $arrow !!}</a></li>
                    <li><a href="/blog/fastest-growing-residential-areas-lucknow-2026">Fastest-growing areas {!! $arrow !!}</a></li>
                </ul>
            </div>
            <div class="xcol rv" style="--d:.12s">
                <h3><span class="ico-badge" style="background:#eef2ff;color:#4f46e5"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M8 6h8M8 10h2M14 10h2M8 14h2M14 14h2M8 18h8"/></svg></span> Free tools</h3>
                <ul class="xlist">
                    <li><a href="/tools/stamp-duty-calculator-lucknow">Stamp Duty Calculator {!! $arrow !!}</a></li>
                    <li><a href="#price-map">Locality Price Map {!! $arrow !!}</a></li>
                    <li><a href="/how-property-prices-are-calculated-in-lucknow">How prices are calculated {!! $arrow !!}</a></li>
                    <li><a href="javascript:void(0)" onclick="ValuationComponent.open()">Free Property Valuation {!! $arrow !!}</a></li>
                    <li><a href="/reviews">Client Reviews {!! $arrow !!}</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═════════════ INSIGHTS ═════════════ --}}
@if($blogs->isNotEmpty() || $news->isNotEmpty())
<section class="section">
    <div class="wrap">
        <div class="sec-head">
            <div>
                <div class="eyebrow rv">Insights</div>
                <h2 class="h2 rv" style="--d:.05s">Guides &amp; market updates</h2>
                <p class="lead rv" style="--d:.1s">Expert guides on buying, RERA, loans and the latest from Lucknow's property market.</p>
            </div>
            <a href="/blog" class="btn btn-line rv">All articles {!! $arrow !!}</a>
        </div>

        <div class="insights">
            @if($blogs->isNotEmpty())
            <div class="articles">
                @php $lead = $blogs->first(); $rest = $blogs->slice(1); @endphp
                <a href="/blog/{{ $lead->slug }}" class="acard acard--big rv">
                    <div class="acard__img"><img src="{{ asset($lead->featured_image ?? $lead->image) }}" alt="{{ $lead->title }}" width="600" height="315" loading="lazy" decoding="async"></div>
                    <span class="acard__cat">{{ $lead->category ?? 'Real Estate' }}</span>
                    <span class="acard__title">{{ $lead->title }}</span>
                    <span class="acard__date">{{ \Carbon\Carbon::parse($lead->created_at)->format('d M Y') }}</span>
                </a>
                <div class="astack">
                    @foreach($rest as $blog)
                    <a href="/blog/{{ $blog->slug }}" class="acard rv" style="--d:{{ $loop->iteration * 0.06 }}s">
                        <div class="acard__img"><img src="{{ asset($blog->featured_image ?? $blog->image) }}" alt="{{ $blog->title }}" width="150" height="79" loading="lazy" decoding="async"></div>
                        <span style="display:flex;flex-direction:column;gap:6px;min-width:0">
                            <span class="acard__cat">{{ $blog->category ?? 'Real Estate' }}</span>
                            <span class="acard__title" style="font-size:.95rem">{{ $blog->title }}</span>
                            <span class="acard__date">{{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</span>
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if($news->isNotEmpty())
            <div class="news rv" style="--d:.1s">
                <h3>Market updates <a href="{{ route('news.index') }}" class="link-arrow" style="font-size:.8rem">All news {!! $arrow !!}</a></h3>
                @foreach($news as $article)
                <a href="{{ $article->slug ? route('news.show', $article->slug) : route('news.index') }}" class="nitem">
                    <div class="nitem__title">{{ $article->title }}</div>
                    <div class="nitem__meta">{{ $article->source_name ?? 'Lucknow Property News' }} · {{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- ═════════════ CTA ═════════════ --}}
<section class="section section--canvas" style="padding-top:0;background:linear-gradient(var(--surface) 50%,var(--canvas) 50%)">
    <div class="wrap">
        <div class="cta">
            <div class="cta__sell rv">
                <div class="eyebrow" style="color:#ffb98a">For owners</div>
                <h2>Ready to sell your property?</h2>
                <p>List for free and reach genuine buyers across Lucknow. No listing fees — inquiries come straight to your phone.</p>
                <div class="cta__btns">
                    <a href="/seller/register" class="btn btn-accent">List your property free</a>
                    <button type="button" onclick="ValuationComponent.open()" class="btn btn-ghost-w">Know its value first</button>
                </div>
            </div>
            <div class="cta__talk rv" style="--d:.08s">
                <h3>Talk to an expert</h3>
                <p>Questions about a property, a scheme or the paperwork? Speak to our Lucknow team directly.</p>
                <a href="https://wa.me/918595002933?text=Hello%2C+I+have+a+query+about+a+property." target="_blank" rel="noopener" class="btn btn-dark">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.27.49 1.7.63.71.23 1.36.2 1.88.12.57-.09 1.75-.72 2-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35M12.05 21.5h-.01a9.4 9.4 0 0 1-4.8-1.31l-.34-.2-3.56.93.95-3.47-.22-.36a9.4 9.4 0 0 1-1.44-5.01c0-5.2 4.23-9.43 9.43-9.43a9.37 9.37 0 0 1 9.42 9.44c0 5.2-4.23 9.42-9.43 9.42m8.02-17.44A11.27 11.27 0 0 0 12.05.75C5.8.75.7 5.84.7 12.1c0 2 .52 3.95 1.52 5.67L.6 23.65l6.02-1.58a11.33 11.33 0 0 0 5.42 1.38h.01c6.25 0 11.35-5.09 11.35-11.35 0-3.03-1.18-5.88-3.32-8.03"/></svg>
                    Chat on WhatsApp
                </a>
                <a href="tel:+918595002933" class="btn btn-line">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    +91 85950 02933
                </a>
                <a href="/contact-us" class="addr">{!! $pin !!} <span>128/LGE Sanjar Gold Complex, Vrindavan Sector 2, Lucknow</span></a>
            </div>
        </div>
    </div>
</section>

{{-- ═════════════ NEWSLETTER ═════════════ --}}
<x-newsletter
    title="Stay Ahead of Lucknow's Property Market"
    description="Weekly price updates, market news, and property tips — no spam, unsubscribe anytime."
/>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var items = document.querySelectorAll('.hp .rv');
    if (!('IntersectionObserver' in window)) {
        items.forEach(function (el) { el.classList.add('in'); });
    } else {
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('in'); obs.unobserve(e.target); }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        items.forEach(function (el) { obs.observe(el); });
    }

    var track = document.getElementById('revTrack');
    if (track) {
        document.querySelectorAll('[data-rev]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var card = track.querySelector('.rcard');
                var step = card ? card.getBoundingClientRect().width + 20 : track.clientWidth;
                track.scrollBy({ left: step * parseInt(btn.dataset.rev, 10), behavior: 'smooth' });
            });
        });
    }
});
</script>
@include('components.valuation-modal')
@endsection
