{{--
    resources/views/news/index.blade.php
    Newsroom layout (redesigned 2026-10-20, restyled 2026-10-31): gradient hero with the top three
    headlines, coloured category chips, lead story, story cards grouped by date, sidebar with the
    plot-sale cards, the verification offer and guides. Page text is English; the Hindi story titles and summaries fall back to Poppins / Hind.
--}}

@extends('layouts.app-article')

@section('seo')
    <title>लखनऊ प्रॉपर्टी न्यूज़: LDA, आवास विकास, RERA की Latestें | Lucknow Property News</title>
    <meta name="description"  content="लखनऊ प्रॉपर्टी की Latestें हिंदी में: LDA योजना, प्लॉट पंजीकरण, आवास विकास, RERA, अवैध निर्माण पर कार्रवाई और रजिस्ट्री। हर खबर मूल रिपोर्ट से जांची हुई। Lucknow property news.">
    <meta name="keywords"     content="Lucknow real estate news, LDA updates, IT City Lucknow, Gomti Nagar property news, Lucknow property prices, RERA Lucknow">
    <link rel="canonical"     href="{{ url('/news') }}">
    <meta name="robots"       content="index, follow">

    <meta property="og:type"        content="website">
    <meta property="og:title"       content="लखनऊ प्रॉपर्टी न्यूज़ | Lucknow Property News">
    <meta property="og:description" content="LDA योजना, आवास विकास, RERA और प्लॉट की Latestें, मूल रिपोर्ट से जांची हुई।">
    <meta property="og:url"         content="{{ url('/news') }}">
    <meta property="og:site_name"   content="DSD Properties">
    <meta property="og:image"       content="{{ asset('images/og-news.png') }}">
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="लखनऊ प्रॉपर्टी न्यूज़ | Lucknow Property News">
    <meta name="twitter:description" content="LDA योजना, आवास विकास, RERA और प्लॉट की Latestें।">
    <meta name="twitter:image"       content="{{ asset('images/og-news.png') }}">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "लखनऊ प्रॉपर्टी न्यूज़ (Lucknow Property News)",
        "inLanguage": "hi",
        "description": "लखनऊ प्रॉपर्टी की Latestें: LDA योजना, आवास विकास, RERA, अवैध निर्माण पर कार्रवाई और नए प्रोजेक्ट।",
        "url": "{{ url('/news') }}",
        "publisher": {
            "@type": "Organization",
            "name": "DSD Properties",
            "url": "{{ url('/') }}",
            "logo": { "@type": "ImageObject", "url": "{{ asset('images/logo.webp') }}" }
        }
    }
    </script>


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Hind:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ─── Tokens ─────────────────────────────────────── */
        .nr {
            --nr-ink:    #0f172a;
            --nr-body:   #334155;
            --nr-muted:  #64748b;
            --nr-faint:  #94a3b8;
            --nr-line:   #e2e8f0;
            --nr-paper:  #ffffff;
            --nr-bg:     #f4f6fb;
            --nr-navy:   #0b1e5b;
            --nr-orange: #FF5C00;
            font-family:'Plus Jakarta Sans','Hind',sans-serif;
            color:var(--nr-body);
            background:var(--nr-bg);
        }
        .nr-hi { font-family:'Plus Jakarta Sans','Hind',sans-serif; }
        .nr-hd { font-family:'Plus Jakarta Sans','Poppins',sans-serif; }
        .nr-c  { max-width:1180px; margin:0 auto; padding:0 16px; }

        /* ─── Hero masthead ──────────────────────────────── */
        .nr-mast {
            position:relative; overflow:hidden; color:#fff; padding:52px 0 92px;
            background:
                radial-gradient(600px 300px at 88% 10%, rgba(255,92,0,.28), transparent 70%),
                radial-gradient(500px 300px at 10% 100%, rgba(20,184,166,.30), transparent 70%),
                linear-gradient(135deg,#0a1a4f 0%,#0d3270 50%,#0b5a6e 100%);
        }
        .nr-mast::before {
            content:''; position:absolute; inset:0; pointer-events:none;
            background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);
            background-size:44px 44px;
            -webkit-mask-image:linear-gradient(180deg,#000 30%,transparent 100%); mask-image:linear-gradient(180deg,#000 30%,transparent 100%);
        }
        .nr-mast__wave { position:absolute; left:0; right:0; bottom:-1px; width:100%; height:56px; display:block; }
        .nr-mast__grid { position:relative; display:grid; grid-template-columns:minmax(0,1.15fr) minmax(0,.85fr); gap:40px; align-items:center; }
        @media (max-width:960px) { .nr-mast__grid { grid-template-columns:minmax(0,1fr); gap:28px; } .nr-mast { padding:36px 0 76px; } }

        .nr-pill {
            display:inline-flex; align-items:center; gap:8px; padding:6px 14px; border-radius:999px;
            background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.18);
            font-family:'Plus Jakarta Sans',sans-serif; font-size:.74rem; font-weight:700; letter-spacing:.04em; color:#e2e8f0;
        }
        .nr-pill__dot { position:relative; width:8px; height:8px; border-radius:50%; background:#22c55e; }
        .nr-pill__dot::after { content:''; position:absolute; inset:-4px; border-radius:50%; border:2px solid #22c55e; opacity:.6; animation:nrPing 1.8s ease-out infinite; }
        @keyframes nrPing { from { transform:scale(.6); opacity:.7; } to { transform:scale(1.6); opacity:0; } }
        @media (prefers-reduced-motion:reduce) { .nr-pill__dot::after { animation:none; } }

        .nr-mast__h1 {
            font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:clamp(2.2rem,5.4vw,3.6rem);
            font-weight:800; line-height:1.15; color:#fff; margin:18px 0 0; letter-spacing:-.01em;
        }
        .nr-mast__h1 span {
            background:linear-gradient(90deg,#ff7a1a,#ffb347); -webkit-background-clip:text; background-clip:text; color:transparent;
        }
        .nr-mast__sub { font-size:1.06rem; color:rgba(255,255,255,.78); margin:14px 0 0; max-width:540px; line-height:1.7; }
        .nr-mast__facts { display:flex; gap:10px; flex-wrap:wrap; margin-top:24px; }
        .nr-fact {
            display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:12px;
            background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(6px);
        }
        .nr-fact__icon { display:flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:8px; flex-shrink:0; }
        .nr-fact__num { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:1rem; font-weight:700; color:#fff; line-height:1.1; display:block; }
        .nr-fact__lbl { font-size:.76rem; color:rgba(255,255,255,.65); line-height:1.2; display:block; }

        /* Headlines card in the hero */
        .nr-top {
            background:rgba(255,255,255,.96); border-radius:18px; padding:20px 20px 8px; color:var(--nr-ink);
            box-shadow:0 24px 50px -20px rgba(0,0,0,.55);
        }
        @media (max-width:700px) { .nr-top { display:none; } }  /* phones go straight to the lead story */
        .nr-top__head { display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; }
        .nr-top__label { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:.98rem; font-weight:700; color:var(--nr-navy); margin:0; }
        .nr-top__live { font-family:'Plus Jakarta Sans',sans-serif; font-size:.64rem; font-weight:800; letter-spacing:.12em; color:#dc2626; background:#fef2f2; border-radius:999px; padding:3px 9px; }
        .nr-top ol { list-style:none; margin:0; padding:0; counter-reset:top; }
        .nr-top li { display:flex; gap:12px; padding:12px 0; border-top:1px solid var(--nr-line); }
        .nr-top li:first-child { border-top:none; }
        .nr-top__n { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:1.3rem; font-weight:800; line-height:1; color:var(--c); min-width:28px; }
        .nr-top a { font-size:.95rem; font-weight:600; line-height:1.45; color:var(--nr-ink); text-decoration:none;
                    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .nr-top a:hover { color:var(--nr-orange); }

        /* ─── Category chips ─────────────────────────────── */
        .nr-tabs { position:sticky; top:68px; z-index:30; background:rgba(244,246,251,.92); backdrop-filter:blur(8px); border-bottom:1px solid var(--nr-line); }
        .nr-tabs__scroll { overflow-x:auto; scrollbar-width:none; }
        .nr-tabs__scroll::-webkit-scrollbar { display:none; }
        .nr-tabs__list { display:flex; gap:8px; width:max-content; padding:12px 0; }
        .nr-tab {
            display:inline-flex; align-items:center; gap:7px; padding:7px 15px; border-radius:999px;
            background:#fff; border:1px solid var(--nr-line); font-size:.9rem; font-weight:600;
            color:var(--nr-body); text-decoration:none; white-space:nowrap; transition:all .15s;
        }
        .nr-tab::before { content:''; width:8px; height:8px; border-radius:50%; background:var(--c); }
        .nr-tab:hover { border-color:var(--c); color:var(--nr-ink); text-decoration:none; }
        .nr-tab--on { background:var(--c); border-color:var(--c); color:#fff !important; box-shadow:0 6px 16px -8px var(--c); }
        .nr-tab--on::before { background:#fff; }

        /* ─── Layout ─────────────────────────────────────── */
        .nr-main { padding:28px 0 72px; }
        .nr-layout { display:grid; grid-template-columns:minmax(0,1fr) 340px; gap:32px; align-items:start; }
        @media (max-width:1020px) { .nr-layout { grid-template-columns:minmax(0,1fr); } }

        /* ─── Category chip + icon tile ──────────────────── */
        .nr-tag {
            display:inline-flex; align-items:center; gap:6px; padding:2px 10px; border-radius:999px;
            font-size:.76rem; font-weight:700; color:var(--c); background:color-mix(in srgb, var(--c) 12%, #fff);
        }
        .nr-hot {
            display:inline-flex; align-items:center; gap:4px; font-size:.72rem; font-weight:700; color:#fff;
            background:linear-gradient(90deg,#ef4444,#f97316); border-radius:999px; padding:2px 9px;
        }
        .nr-meta { display:flex; align-items:center; gap:8px; flex-wrap:wrap; font-size:.8rem; color:var(--nr-faint); }
        .nr-ico {
            display:flex; align-items:center; justify-content:center; flex-shrink:0; width:44px; height:44px; border-radius:12px; color:#fff;
            background:linear-gradient(135deg, var(--c), color-mix(in srgb, var(--c) 60%, #0b1e5b));
            box-shadow:0 8px 18px -10px var(--c);
        }

        /* ─── Lead story ─────────────────────────────────── */
        .nr-lead {
            display:grid; grid-template-columns:200px minmax(0,1fr); background:var(--nr-paper); border-radius:20px; overflow:hidden;
            box-shadow:0 18px 40px -26px rgba(15,31,92,.45); border:1px solid var(--nr-line); margin-bottom:30px;
        }
        @media (max-width:700px) { .nr-lead { grid-template-columns:minmax(0,1fr); } }
        .nr-lead__art {
            position:relative; display:flex; flex-direction:column; justify-content:space-between; gap:16px; padding:22px; color:#fff; overflow:hidden;
            background:linear-gradient(160deg, var(--c), color-mix(in srgb, var(--c) 45%, #0b1e5b));
        }
        .nr-lead__art::after { content:''; position:absolute; width:180px; height:180px; right:-60px; bottom:-60px; border-radius:50%; background:rgba(255,255,255,.12); }
        .nr-lead__art svg { width:46px; height:46px; opacity:.95; }
        .nr-lead__label { font-family:'Plus Jakarta Sans',sans-serif; font-size:.66rem; font-weight:800; letter-spacing:.16em; text-transform:uppercase; opacity:.85; }
        .nr-lead__day  { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:2.6rem; font-weight:800; line-height:1; }
        .nr-lead__mon  { font-size:.95rem; font-weight:600; opacity:.9; }
        @media (max-width:700px) {
            .nr-lead__art { flex-direction:row; align-items:center; padding:16px 18px; }
            .nr-lead__day { font-size:1.8rem; }
        }
        .nr-lead__body { padding:26px 28px 24px; }
        @media (max-width:600px) { .nr-lead__body { padding:18px; } }
        .nr-lead__title {
            display:block; font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:clamp(1.35rem,2.6vw,1.8rem);
            font-weight:700; line-height:1.4; color:var(--nr-ink); text-decoration:none; margin:12px 0 10px;
        }
        .nr-lead__title:hover { color:var(--nr-navy); text-decoration:none; background:linear-gradient(transparent 88%, color-mix(in srgb, var(--c) 35%, transparent) 0); }
        .nr-lead__summary { font-size:1.06rem; line-height:1.75; color:var(--nr-body); margin:0 0 18px; }
        .nr-lead__foot { display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; }
        .nr-btn {
            display:inline-flex; align-items:center; gap:8px; padding:11px 20px; border-radius:10px;
            background:linear-gradient(135deg,#FF5C00,#ff8a3d); color:#fff !important; font-size:.92rem; font-weight:700; text-decoration:none;
            box-shadow:0 10px 20px -10px rgba(255,92,0,.8); transition:transform .15s;
        }
        .nr-btn:hover { transform:translateY(-1px); text-decoration:none; }

        /* ─── Date groups + story cards ──────────────────── */
        .nr-day { margin-bottom:30px; }
        .nr-day__head { display:flex; align-items:center; gap:12px; margin-bottom:14px; }
        .nr-day__date {
            display:inline-flex; align-items:center; gap:8px; margin:0; padding:6px 14px; border-radius:10px;
            background:var(--nr-navy); color:#fff; font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:.95rem; font-weight:600;
        }
        .nr-day__line { flex:1; height:1px; background:linear-gradient(90deg,var(--nr-line),transparent); }
        .nr-day__count { font-size:.8rem; font-weight:600; color:var(--nr-muted); }

        .nr-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
        @media (max-width:700px) { .nr-grid { grid-template-columns:minmax(0,1fr); } }
        .nr-grid > .nr-story:last-child:nth-child(odd) { grid-column:1 / -1; }  /* a lone last card takes the full row */
        .nr-story {
            position:relative; display:flex; flex-direction:column; background:var(--nr-paper); border:1px solid var(--nr-line);
            border-radius:16px; padding:18px 18px 16px; overflow:hidden; transition:transform .18s, box-shadow .18s, border-color .18s;
        }
        .nr-story::before { content:''; position:absolute; left:0; top:0; right:0; height:4px; background:linear-gradient(90deg, var(--c), color-mix(in srgb, var(--c) 40%, #fff)); }
        .nr-story:hover { transform:translateY(-3px); box-shadow:0 16px 30px -20px rgba(15,31,92,.45); border-color:color-mix(in srgb, var(--c) 35%, #fff); }
        .nr-story__top { display:flex; align-items:center; gap:12px; margin-bottom:12px; }
        .nr-story__top .nr-ico { width:38px; height:38px; border-radius:10px; }
        .nr-story__title {
            font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:1.06rem; font-weight:600;
            line-height:1.5; color:var(--nr-ink); text-decoration:none; margin:0 0 8px;
        }
        .nr-story__title::after { content:''; position:absolute; inset:0; }  /* whole card clickable */
        .nr-story:hover .nr-story__title { color:var(--nr-navy); }
        .nr-story__summary {
            font-size:.95rem; line-height:1.65; color:var(--nr-muted); margin:0 0 14px;
            display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;
        }
        .nr-story__foot { margin-top:auto; display:flex; justify-content:space-between; align-items:center; gap:10px; padding-top:12px; border-top:1px dashed var(--nr-line); }
        .nr-more { font-size:.84rem; font-weight:700; color:var(--c); white-space:nowrap; }

        /* ─── Empty state ────────────────────────────────── */
        .nr-empty { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:18px; padding:56px 24px; text-align:center; }
        .nr-empty p { margin:0; }

        /* ─── Sidebar ────────────────────────────────────── */
        .nr-side { display:flex; flex-direction:column; gap:20px; position:sticky; top:132px; }
        @media (max-width:1020px) { .nr-side { position:static; } }
        .nr-mobile-only { display:none; }
        @media (max-width:1020px) { .nr-mobile-only { display:block; } .nr-side .psc { display:none; } }
        .nr-box { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:18px; padding:22px; }
        .nr-box__kicker { display:inline-block; font-family:'Plus Jakarta Sans',sans-serif; font-size:.64rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:var(--nr-orange); margin-bottom:8px; }
        .nr-box__title { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:1.1rem; font-weight:700; color:var(--nr-ink); line-height:1.4; margin-bottom:8px; }
        .nr-box__text { font-size:.9rem; line-height:1.6; color:var(--nr-muted); margin-bottom:14px; }
        .nr-box--verify {
            position:relative; overflow:hidden; border:none; color:#fff;
            background:radial-gradient(260px 160px at 100% 0%, rgba(255,92,0,.45), transparent 70%), linear-gradient(150deg,#0a1a4f,#0d3270 60%,#0b5a6e);
        }
        .nr-box--verify .nr-box__kicker { color:#fdba74; }
        .nr-box--verify .nr-box__title { color:#fff; }
        .nr-price { font-family:'Plus Jakarta Sans','Poppins',sans-serif; font-size:2.1rem; font-weight:800; color:#fff; line-height:1; margin:6px 0 4px; }
        .nr-price small {  font-size:.85rem; font-weight:500; color:rgba(255,255,255,.65); }
        .nr-checks { list-style:none; padding:0; margin:14px 0 18px; }
        .nr-checks li { display:flex; gap:9px; align-items:flex-start; font-size:.9rem; color:rgba(255,255,255,.88); margin-bottom:8px; }
        .nr-checks li::before { content:'✓'; display:flex; align-items:center; justify-content:center; width:18px; height:18px; flex-shrink:0; margin-top:2px;
                                border-radius:50%; background:#22c55e; color:#fff; font-size:.7rem; font-weight:800; }
        .nr-cta {
            display:flex; align-items:center; justify-content:center; gap:8px; width:100%;
            padding:12px 16px; border-radius:10px; font-size:.92rem; font-weight:700; text-decoration:none; transition:transform .15s;
        }
        .nr-cta:hover { transform:translateY(-1px); text-decoration:none; }
        .nr-cta--orange { background:linear-gradient(135deg,#FF5C00,#ff8a3d); color:#fff !important; box-shadow:0 10px 20px -10px rgba(255,92,0,.9); }
        .nr-guides { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:6px; }
        .nr-guides a {
            display:flex; justify-content:space-between; align-items:center; gap:10px; padding:10px 12px; border-radius:10px;
            background:#f8fafc; font-size:.92rem; font-weight:600; color:var(--nr-ink); text-decoration:none; transition:background .15s, color .15s;
        }
        .nr-guides a:hover { background:#fff4ec; color:var(--nr-orange); }
        .nr-guides a span { color:var(--nr-orange); font-weight:700; }

        /* ─── Pagination (news/_pagination.blade.php) ─────── */
        .nr-pg { background:var(--nr-paper); border:1px solid var(--nr-line); border-radius:18px; padding:16px 18px;
                 display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; }
        .nr-pg__info { margin:0; font-size:.88rem; color:var(--nr-muted); }
        .nr-pg__info strong { color:var(--nr-ink); }
        .nr-pg__row { display:flex; align-items:center; gap:8px; }
        .nr-pg__nums { display:flex; align-items:center; gap:6px; }
        .nr-pg__num, .nr-pg__dots {
            display:inline-flex; align-items:center; justify-content:center; min-width:40px; height:40px; padding:0 8px;
            border-radius:12px; font-size:.92rem; font-weight:700; text-decoration:none;
        }
        .nr-pg__num { color:var(--nr-ink); background:#f1f5f9; transition:background .15s, color .15s; }
        .nr-pg__num:hover { background:#fff4ec; color:var(--nr-orange); text-decoration:none; }
        .nr-pg__num.is-on { background:var(--nr-navy); color:#fff; box-shadow:0 8px 18px -10px var(--nr-navy); }
        .nr-pg__dots { color:var(--nr-faint); min-width:24px; }
        .nr-pg__btn {
            display:inline-flex; align-items:center; height:40px; padding:0 16px; border-radius:12px; font-size:.9rem; font-weight:700;
            color:var(--nr-navy); background:#fff; border:1px solid var(--nr-line); text-decoration:none; white-space:nowrap; transition:all .15s;
        }
        .nr-pg__btn:hover { border-color:var(--nr-navy); text-decoration:none; color:var(--nr-navy); }
        .nr-pg__btn--next { background:linear-gradient(135deg,#FF5C00,#ff8a3d); color:#fff !important; border-color:transparent; box-shadow:0 10px 20px -12px rgba(255,92,0,.9); }
        .nr-pg__btn--next:hover { border-color:transparent; transform:translateY(-1px); }
        .nr-pg__btn.is-off { color:var(--nr-faint); background:#f8fafc; box-shadow:none; pointer-events:none; }
        .nr-pg__mob { display:none; font-size:.9rem; font-weight:700; color:var(--nr-ink); }
        @media (max-width:640px) {
            .nr-pg { justify-content:center; text-align:center; }
            .nr-pg__info { width:100%; }
            .nr-pg__row { width:100%; justify-content:space-between; }
            .nr-pg__nums { display:none; }
            .nr-pg__mob { display:inline; }
        }

        /* ─── Mobile buy/sell bar ────────────────────────── */
        .mob-cta-bar{display:none;position:fixed;bottom:0;left:0;right:0;z-index:9999;padding:10px 14px;background:#fff;border-top:1px solid #e5e7eb;box-shadow:0 -4px 18px rgba(0,0,0,.12);gap:10px}
        @media(max-width:1023px){.mob-cta-bar{display:flex}body{padding-bottom:72px}}
        .mob-cta-bar a{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:13px 10px;border-radius:10px;font-weight:700;font-size:.88rem;text-decoration:none;letter-spacing:.1px;transition:opacity .15s}
        .mob-cta-bar a:hover{opacity:.88;text-decoration:none}
        .mob-cta-buy{background:linear-gradient(135deg,#25D366,#128C7E);color:#fff !important}
        .mob-cta-sell{background:linear-gradient(135deg,#011f4b,#013870);color:#fff !important}
    </style>
@endsection

@section('content')

@php
    // Tabs, labels and colours come from NewsArticle::CATEGORIES (the one list to edit).
    $cats      = \App\Models\NewsArticle::CATEGORIES;
    $catLabel  = array_map(fn ($c) => $c['label'], $cats);
    $catColor  = ['all' => '#0b1e5b'] + array_map(fn ($c) => $c['color'], $cats);
    $categories = ['all' => 'All News'] + array_map(fn ($c) => $c['tab'] ?? $c['label'], $cats);
    // Inner SVG paths for each category's icon tile (24×24, stroke). A new category without one gets 'default'.
    $catIcon = [
        'saumitra-vihar' => '<path d="M12 21s-7-6.2-7-11.5a7 7 0 0114 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
        'wellness-city'  => '<path d="M20.8 8.6a5 5 0 00-8.8-3.2 5 5 0 00-8.8 3.2c0 5.4 8.8 11 8.8 11s8.8-5.6 8.8-11z"/><path d="M7 12h3l1.5-2.5 2 5L15 12h2"/>',
        'lda'      => '<path d="M3 21h18M5 21V8l7-4 7 4v13M9 21v-5h6v5M9 11h.01M15 11h.01"/>',
        'it-city'  => '<rect x="6" y="6" width="12" height="12" rx="2"/><path d="M9 2v4M15 2v4M9 18v4M15 18v4M2 9h4M2 15h4M18 9h4M18 15h4"/>',
        'projects' => '<path d="M3 21h18M6 21V10l6-5 6 5v11M10 21v-6h4v6"/><path d="M12 2v3"/>',
        'price'    => '<path d="M7 5h10M7 9h10M13 5c2.5 0 4 1.8 4 4s-1.5 4-4 4H8l7 6"/>',
        'policy'   => '<path d="M12 3v18M5 7h14M7 7l-3 7a3 3 0 006 0L7 7zM17 7l-3 7a3 3 0 006 0l-3-7zM8 21h8"/>',
        'rera'     => '<path d="M12 3l7 3v6c0 4.2-3 7.7-7 9-4-1.3-7-4.8-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/>',
        'default'  => '<path d="M4 5h16v14H4zM8 9h8M8 13h8M8 17h5"/>',
    ];
    $icon = fn ($cat, $size = 20) => '<svg width="'.$size.'" height="'.$size.'" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">'.($catIcon[$cat] ?? $catIcon['default']).'</svg>';
    $activeCategory = $category ?? 'all';

    $allItems  = collect($articles->items());
    $lead      = $articles->onFirstPage() ? $allItems->first() : null;
    $restItems = $lead ? $allItems->slice(1) : $allItems;
    $byDay     = $restItems->groupBy(fn ($a) => $a->created_at->format('Y-m-d'));
    $lastUpdate = $allItems->max('created_at');
    $topThree  = $allItems->take(3);

@endphp

<div class="nr">

{{-- ══ HERO MASTHEAD ════════════════════════════════════ --}}
<header class="nr-mast">
    <div class="nr-c nr-mast__grid">
        <div>
            <span class="nr-pill"><span class="nr-pill__dot"></span> Verified Lucknow Property News</span>
            <h1 class="nr-mast__h1">Lucknow Property <span>News</span></h1>
            <p class="nr-mast__sub nr-hi">
                LDA, Awas Vikas, IT City and RERA updates that matter if you are buying a plot or flat in Lucknow.
            </p>
            <div class="nr-mast__facts nr-hi">
                @if($lastUpdate)
                <div class="nr-fact">
                    <span class="nr-fact__icon" style="background:rgba(255,92,0,.2); color:#ffb37a;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                    </span>
                    <span><span class="nr-fact__num">{{ $lastUpdate->format('j M') }}</span><span class="nr-fact__lbl">Last updated</span></span>
                </div>
                @endif
                <div class="nr-fact">
                    <span class="nr-fact__icon" style="background:rgba(59,130,246,.22); color:#93c5fd;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5h16v14H4zM8 9h8M8 13h8"/></svg>
                    </span>
                    <span><span class="nr-fact__num">{{ $articles->total() }}</span><span class="nr-fact__lbl">Stories</span></span>
                </div>
                <div class="nr-fact">
                    <span class="nr-fact__icon" style="background:rgba(34,197,94,.2); color:#86efac;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.6" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span><span class="nr-fact__num">100%</span><span class="nr-fact__lbl">Source-checked</span></span>
                </div>
            </div>
        </div>

        @if($topThree->isNotEmpty())
        <div class="nr-top nr-hi">
            <div class="nr-top__head">
                <p class="nr-top__label">Top Headlines</p>
                <span class="nr-top__live">LATEST</span>
            </div>
            <ol>
                @foreach($topThree as $i => $t)
                <li style="--c:{{ $catColor[$t->category] ?? '#0b1e5b' }}">
                    <span class="nr-top__n">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <a href="{{ route('news.show', $t->slug) }}">{{ $t->title }}</a>
                </li>
                @endforeach
            </ol>
        </div>
        @endif
    </div>
    <svg class="nr-mast__wave" viewBox="0 0 1440 56" preserveAspectRatio="none" aria-hidden="true"><path d="M0 40 C 360 0, 1080 70, 1440 18 L1440 56 L0 56 Z" fill="#f4f6fb"/></svg>
</header>

{{-- ══ CATEGORY CHIPS ════════════════════════════════════ --}}
<nav class="nr-tabs" aria-label="News categories">
    <div class="nr-c nr-tabs__scroll">
        <div class="nr-tabs__list nr-hi">
            @foreach($categories as $key => $label)
                <a href="{{ $key === 'all' ? route('news.index') : route('news.index', ['category' => $key]) }}"
                   class="nr-tab {{ $activeCategory === $key ? 'nr-tab--on' : '' }}" style="--c:{{ $catColor[$key] }}"
                   @if($activeCategory === $key) aria-current="page" @endif>
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</nav>

{{-- ══ MAIN ══════════════════════════════════════════════ --}}
<div class="nr-main">
<div class="nr-c nr-layout">

    <main>
        @if($articles->isEmpty())
            <div class="nr-empty nr-hi">
                <p class="nr-hd" style="font-size:1.2rem; font-weight:700; color:#0f172a; margin-bottom:6px;">No stories in this category yet</p>
                <p style="font-size:.98rem; color:#64748b; margin-bottom:18px;">See all news or read our guides.</p>
                <a href="{{ route('news.index') }}" class="nr-btn">See all news</a>
            </div>
        @else

            {{-- ── Lead story ─────────────────────────── --}}
            @if($lead)
            @php $lc = $catColor[$lead->category] ?? '#0b1e5b'; $ld = $lead->created_at; @endphp
            <article class="nr-lead nr-hi" style="--c:{{ $lc }}">
                <div class="nr-lead__art">
                    <span class="nr-lead__label">Latest</span>
                    {!! $icon($lead->category, 46) !!}
                    <span>
                        <span class="nr-lead__day" style="display:block;">{{ $ld->format('j') }}</span>
                        <span class="nr-lead__mon">{{ $ld->format('F Y') }}</span>
                    </span>
                </div>
                <div class="nr-lead__body">
                    <div class="nr-meta">
                        <span class="nr-tag" style="--c:{{ $lc }}">{{ $catLabel[$lead->category] ?? 'News' }}</span>
                        @if($lead->is_hot)<span class="nr-hot">🔥 Important</span>@endif
                        <time datetime="{{ $lead->created_at->toIso8601String() }}">{{ $ld->format('j F Y') }}</time>
                    </div>
                    <a href="{{ route('news.show', $lead->slug) }}" class="nr-lead__title">{{ $lead->title }}</a>
                    <p class="nr-lead__summary">{{ $lead->summary }}</p>
                    <div class="nr-lead__foot">
                        <span class="nr-meta">@if($lead->source_name) Source: {{ $lead->source_name }} @endif</span>
                        <a href="{{ route('news.show', $lead->slug) }}" class="nr-btn">
                            Read full story
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            @endif

            {{-- On phones the sidebar sits below every story, so the plot CTA also shows here. --}}
            <div class="nr-mobile-only" style="margin:0 0 28px;">
                @include('components.plot-sale-cta', ['from' => 'news'])
            </div>

            {{-- ── Stories grouped by day ─────────────── --}}
            @foreach($byDay as $day => $items)
            @php $dayDate = \Carbon\Carbon::parse($day); @endphp
            <section class="nr-day nr-hi">
                <div class="nr-day__head">
                    <h2 class="nr-day__date">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                        {{ $dayDate->format('j F Y') }}
                    </h2>
                    <span class="nr-day__line"></span>
                    <span class="nr-day__count">{{ $items->count() }} {{ $items->count() === 1 ? 'story' : 'stories' }}</span>
                </div>
                <div class="nr-grid">
                    @foreach($items as $article)
                    @php $c = $catColor[$article->category] ?? '#64748b'; @endphp
                    <article class="nr-story" style="--c:{{ $c }}">
                        <div class="nr-story__top">
                            <span class="nr-ico">{!! $icon($article->category, 18) !!}</span>
                            <div class="nr-meta">
                                <span class="nr-tag" style="--c:{{ $c }}">{{ $catLabel[$article->category] ?? 'News' }}</span>
                                @if($article->is_hot)<span class="nr-hot">🔥 Important</span>@endif
                            </div>
                        </div>
                        <a href="{{ route('news.show', $article->slug) }}" class="nr-story__title">{{ $article->title }}</a>
                        <p class="nr-story__summary">{{ $article->summary }}</p>
                        <div class="nr-story__foot">
                            <span class="nr-meta">@if($article->source_name) {{ $article->source_name }} @endif</span>
                            <span class="nr-more">Read →</span>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endforeach

            @if($articles->hasPages())
                <div style="margin-top:36px;">
                    {{ $articles->appends($activeCategory !== 'all' ? ['category' => $activeCategory] : [])->links('news._pagination') }}
                </div>
            @endif
        @endif
    </main>

    {{-- ══ SIDEBAR ═══════════════════════════════════════ --}}
    <aside class="nr-side nr-hi">
        {{-- Shown by partials/onesignal only when push works here and this browser isn't subscribed yet. --}}
        <div class="nr-box" data-push-ask hidden>
            <p class="nr-box__kicker">Notifications</p>
            <p class="nr-box__title">Get new stories first</p>
            <p class="nr-box__text">Important LDA, Awas Vikas and RERA news, 1–2 times a week, straight to your phone or browser.</p>
            <button type="button" class="nr-cta nr-cta--orange" style="border:0; cursor:pointer;"
                    onclick="window.dsdPushAsk && window.dsdPushAsk()">🔔 Turn on notifications</button>
        </div>

        @include('components.plot-sale-cta', ['from' => 'news', 'verify' => false])

        <div class="nr-box nr-box--verify">
            <p class="nr-box__kicker">Property Verification</p>
            <p class="nr-box__title">Get the property checked before you buy</p>
            <div class="nr-price">₹5,000 <small>/ plot or flat</small></div>
            <ul class="nr-checks">
                <li>Ownership and khatauni check</li>
                <li>LDA / RERA approval and map</li>
                <li>PDF report in 48 hours</li>
            </ul>
            <a href="{{ url('/services/property-verification-lucknow') }}" class="nr-cta nr-cta--orange"
               data-cta-kind="verify">Book verification →</a>
        </div>

        <div class="nr-box">
            <p class="nr-box__kicker">Guides</p>
            <p class="nr-box__title">Read the guides</p>
            <ul class="nr-guides">
                <li><a href="{{ url('/lda-schemes') }}">All LDA schemes <span>→</span></a></li>
                <li><a href="{{ url('/blog/saumitra-vihar-yojana-lucknow-2026') }}">Saumitra Vihar guide <span>→</span></a></li>
                <li><a href="{{ url('/blog/it-city-lucknow-lda-plots-guide-2026') }}">IT City plots guide <span>→</span></a></li>
                <li><a href="{{ url('/blog/wellness-city-lucknow-lda-plots-guide-2026') }}">Wellness City plots guide <span>→</span></a></li>
                <li><a href="{{ url('/blog/lda-online-property-verification-lucknow-2026') }}">LDA online verification <span>→</span></a></li>
                <li><a href="{{ url('/blog') }}">All guides <span>→</span></a></li>
            </ul>
        </div>
    </aside>

</div>
</div>

</div>

{{-- ══ MOBILE BUY / SELL BAR ════════════════════════════ --}}
@include('components.mobile-cta-bar')

@endsection
