<?php
/*
 * lucknowitcity.in — standalone plot sales page (plain PHP, no Laravel). Redesigned 22 Oct 2026.
 * Independent seller page: never present it as the official LDA site.
 * The user confirmed plots of all six sizes are on offer (22 Oct 2026). Transfers in the notified Phase-1 area
 * need the District Collector's prior written permission, so every card says the permission status comes with the price.
 * To change stock, edit $sizes. 'status' => 'available' | 'hold' | 'sold'.
 */
$site = 'https://lucknowitcity.in/';
$phone = '918595002933';
$phoneShow = '+91 85950 02933';
$updated = '10 November 2026';
$updatedIso = '2026-11-10';   // change both dates whenever $sizes changes
$rateSqft = 4200;             // REPORTED proposed rate per sq ft (Amar Ujala, 4 Nov 2026; HT 27 Oct said about 4,000). Not notified; always say "reported"
$geo = [26.752822, 81.052238];

$sizes = [
    // m², status
    [35,  'available'],
    [72,  'available'],
    [128, 'available'],
    [162, 'available'],
    [200, 'available'],
    [288, 'available'],
];
$e    = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$wa   = function ($msg) use ($phone) { return 'https://wa.me/' . $phone . '?text=' . rawurlencode($msg); };
$sqft = function ($m) { return number_format($m * 10.7639); };
$sqyd = function ($m) { return number_format($m * 1.19599); };
$open = array_values(array_filter($sizes, function ($s) { return $s[1] !== 'sold'; }));
$list = implode(', ', array_map(function ($s) { return $s[0]; }, $open));
$lakh = function ($m) use ($rateSqft) { return number_format($m * 10.7639 * $rateSqft / 100000, 1); };
$use = [35 => 'Entry size; a small house on about 377 sq ft of land', 72 => 'Ground-plus-one family house, about 775 sq ft per floor',
        128 => 'Three bedrooms with car parking on a 1,378 sq ft plot', 162 => 'Room for a home office or rental floor alongside the family home',
        200 => 'Independent-floor potential on about 2,150 sq ft', 288 => 'Biggest farmer-allotment size, about 3,100 sq ft'];

$faq = [
    ['When does LDA open IT City plots for the public?', 'According to Hindustan (4 November 2026), the Chief Minister and the Defence Minister will launch IT City together with Saumitra Vihar on 23 November 2026, and plot registration for the general public will open then. The number of plots, sizes, rate and last date had not been published as of ' . $updated . '.'],
    ['What is the expected rate for IT City plots?', 'No rate has been notified. On 27 October the LDA secretary said about ₹4,000 per sq ft, and a 4 November report put the proposed rate at about ₹4,200 per sq ft. The base costs on this page use ₹4,200 per sq ft only to compare sizes.'],
    ['How is the 1,054-hectare IT City land being assembled?', 'About 500 ha came through land pooling, about 200 ha is gram samaj land still in legal process, and LDA plans to acquire the remaining 300 ha from farmers who did not join pooling, at four times the circle rate in rural areas (Amar Ujala, 6 October 2026).'],
    ['Who is selling these IT City plots?', 'Farmers who gave land through land pooling and got 25% of it back as developed plots. By mid-October 2026, three lotteries had allotted 2,197 plots to 1,465 farmers in sectors 9, 15, 16, 17, 18 and 30.'],
    ['Do I need permission to buy a farmer\'s plot in IT City?', 'Yes. The phase-1 area is notified, so a transfer needs the District Collector\'s prior written permission. We give each plot\'s permission status with its price. Register only after the permission and the seller\'s allotment letter have been checked.'],
    ['Is this the official LDA website?', 'No. We are an independent resale service with no link to the Lucknow Development Authority. LDA publishes its own schemes and notices only on ldalucknow.in.'],
];
?><!doctype html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>IT City Lucknow Plots: 23 Nov Launch, Expected Rate & Farmer Resale Plots</title>
<meta name="description" content="LDA IT City, Sultanpur Road: public registration opens with the 23 November launch. Expected rate about ₹4,000–4,200/sq ft, cost by plot size, 11 villages, and farmers' resale plots of <?php echo $list; ?> m² available now. आईटी सिटी लखनऊ प्लॉट।">
<meta name="keywords" content="IT City Lucknow plots, IT City Lucknow plot for sale, LDA IT City plot, IT City Sultanpur Road, IT City Lucknow plot size, IT City Lucknow price, आईटी सिटी लखनऊ प्लॉट, LDA land pooling plot Lucknow">
<meta name="robots" content="index,follow,max-image-preview:large">
<meta name="theme-color" content="#0b2545">
<link rel="canonical" href="<?php echo $site; ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="IT City Lucknow Plots">
<meta property="og:title" content="IT City Lucknow: launch on 23 Nov, resale plots now">
<meta property="og:description" content="Expected rate, cost for each plot size, and farmers' allotted plots you can buy before the public lottery.">
<meta property="og:url" content="<?php echo $site; ?>">
<meta property="og:image" content="<?php echo $site; ?>og-image.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="IT City Lucknow plots for sale">
<meta name="twitter:card" content="summary_large_image">
<meta name="geo.region" content="IN-UP">
<meta name="geo.placename" content="Lucknow">
<meta name="geo.position" content="<?php echo $geo[0] . ';' . $geo[1]; ?>">
<meta name="ICBM" content="<?php echo $geo[0] . ', ' . $geo[1]; ?>">
<link rel="alternate" type="text/plain" href="<?php echo $site; ?>llms.txt" title="LLM summary">
<script type="application/ld+json">
<?php
echo json_encode(['@context' => 'https://schema.org', '@graph' => [
  ['@type' => 'WebSite', '@id' => $site . '#website', 'name' => 'IT City Lucknow Plots', 'url' => $site, 'inLanguage' => ['en-IN', 'hi-IN']],
  ['@type' => 'WebPage', '@id' => $site . '#webpage', 'url' => $site, 'name' => 'IT City Lucknow plots for sale', 'isPartOf' => ['@id' => $site . '#website'],
   'about' => ['@id' => $site . '#place'], 'mainEntity' => ['@id' => $site . '#plots'], 'dateModified' => $updatedIso, 'inLanguage' => 'en-IN', 'primaryImageOfPage' => $site . 'og-image.jpg'],
  ['@type' => 'Place', '@id' => $site . '#place', 'name' => 'IT City Lucknow', 'alternateName' => ['LDA IT City', 'आईटी सिटी लखनऊ'],
   'description' => 'Lucknow Development Authority scheme of about 1,054 hectares on Sultanpur Road, linked to Kisan Path, spread over 11 villages of Mohanlalganj; land assembled mainly through land pooling.',
   'geo' => ['@type' => 'GeoCoordinates', 'latitude' => $geo[0], 'longitude' => $geo[1]],
   'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Sultanpur Road', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN']],
  ['@type' => 'RealEstateAgent', '@id' => $site . '#agent', 'name' => 'IT City Lucknow Plots', 'url' => $site, 'telephone' => '+' . $phone, 'image' => $site . 'og-image.jpg',
   'areaServed' => ['@id' => $site . '#place'], 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN']],
  ['@type' => 'ItemList', '@id' => $site . '#plots', 'name' => 'Plot sizes for sale in IT City Lucknow', 'numberOfItems' => count($open),
   'itemListElement' => array_map(function ($s, $i) use ($site, $sqft, $updatedIso) {
       return ['@type' => 'ListItem', 'position' => $i + 1, 'item' => ['@type' => 'Place',
         'name' => $s[0] . ' m² residential plot, IT City, Sultanpur Road, Lucknow',
         'description' => $s[0] . ' m² (' . $sqft($s[0]) . ' sq ft) plot allotted to a land-pooling farmer in IT City, Lucknow; resale needs the District Collector\'s written permission.',
         'url' => $site . '#size-' . $s[0],
         'additionalProperty' => [['@type' => 'PropertyValue', 'name' => 'Plot area', 'value' => $s[0], 'unitCode' => 'MTK']]]];
   }, $open, array_keys($open))],
  ['@type' => 'FAQPage', 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, $faq)],
]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Layout: "tech township" — deep navy with a cyan grid, clean white plot cards that scale with plot size */
:root{--navy:#0b2545;--navy2:#13315c;--cyan:#22b5c9;--sky:#e8f4f8;--paper:#fff;--bg:#f4f7fb;--ink:#14213d;--muted:#5b6b82;--line:#dde5ef;--amber:#f2a541;--green:#1fa855;--f:'Poppins',system-ui,-apple-system,'Segoe UI',Arial,sans-serif}
*{box-sizing:border-box}html{scroll-behavior:smooth;scroll-padding-top:76px}
body{margin:0;background:var(--bg);color:var(--ink);font:16px/1.65 var(--f);-webkit-font-smoothing:antialiased}
a{color:inherit}img{max-width:100%}
.wrap{width:min(1160px,100%);margin:0 auto;padding-left:max(18px,env(safe-area-inset-left,0px));padding-right:max(18px,env(safe-area-inset-right,0px))}
h1,h2,h3{font-family:var(--f);font-weight:700;letter-spacing:-.01em;line-height:1.15;text-wrap:balance;margin:0}
.kicker{font-size:12px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--cyan)}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 20px;border-radius:12px;border:1.5px solid var(--navy);background:var(--navy);color:#fff;font-weight:700;font-size:15px;text-decoration:none;cursor:pointer;transition:transform .15s,background .15s}
.btn:hover{background:var(--navy2);transform:translateY(-1px)}
.btn.ghost{background:transparent;color:var(--navy)}.btn.ghost:hover{background:#e9eef5}
.btn.wa{background:var(--green);border-color:var(--green)}.btn.wa:hover{background:#178a45}
:focus-visible{outline:3px solid var(--amber);outline-offset:3px}
.top{position:sticky;top:0;z-index:20;background:rgba(244,247,251,.93);backdrop-filter:blur(10px);border-bottom:1px solid var(--line)}
.top .wrap{display:flex;align-items:center;justify-content:space-between;gap:16px;min-height:66px}
.brand{display:flex;align-items:center;gap:10px;text-decoration:none;font-weight:800;color:var(--navy)}
.brand i{width:34px;height:34px;border-radius:10px;background:var(--navy);display:grid;place-items:center}
.brand small{display:block;font-weight:600;font-size:11.5px;color:var(--muted)}
.top nav{display:flex;gap:22px;align-items:center;font-size:14.5px;font-weight:600}.top nav a{text-decoration:none}
@media(max-width:820px){.top nav a.hide{display:none}}
.hero{position:relative;overflow:hidden;background:var(--navy);color:#fff}
.hero:before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(34,181,201,.12) 1px,transparent 1px),linear-gradient(90deg,rgba(34,181,201,.12) 1px,transparent 1px);background-size:40px 40px;mask-image:linear-gradient(90deg,transparent,#000 65%)}
.hero .wrap{position:relative;display:grid;grid-template-columns:minmax(0,1.25fr) minmax(0,1fr);gap:40px;align-items:center;padding-top:64px;padding-bottom:64px}
.hero h1{font-size:clamp(34px,5.2vw,58px);margin:14px 0 16px}.hero h1 em{font-style:normal;color:#7fe0ec}
.hero .lead{font-size:18px;color:#d5e2f0;max-width:600px;margin:0 0 12px}
.hero .hi{font-size:15px;color:#a9c2dc;margin:0 0 24px}
.hero .acts{display:flex;flex-wrap:wrap;gap:12px}
.hero .btn.ghost{color:#fff;border-color:rgba(255,255,255,.45)}.hero .btn.ghost:hover{background:rgba(255,255,255,.08)}
.stats{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.stat{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.14);border-radius:16px;padding:18px}
.stat b{display:block;font-size:30px;line-height:1.05;color:#7fe0ec;font-variant-numeric:tabular-nums}.stat span{font-size:13.5px;color:#c9d8e8}
@media(max-width:860px){.hero .wrap{grid-template-columns:1fr;padding-top:44px;padding-bottom:44px}}
.strip{background:#fff4e2;border-bottom:1px solid #f1d9ad;color:#7a4d0b;font-size:13.5px}.strip .wrap{padding-top:10px;padding-bottom:10px}
section.band{padding:60px 0;border-bottom:1px solid var(--line)}
.head{max-width:740px;margin-bottom:26px}.head h2{font-size:clamp(27px,3.6vw,40px);margin:8px 0 10px}.head p{color:var(--muted);margin:0}
.facts{background:var(--paper);border:1px solid var(--line);border-radius:18px;padding:24px}
.facts h2{font-size:clamp(22px,3vw,28px);margin:0 0 14px;color:var(--navy)}
.facts dl{margin:0;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0 28px}
.facts dl div{display:grid;grid-template-columns:150px minmax(0,1fr);gap:12px;padding:10px 0;border-bottom:1px solid var(--line)}
.facts dt{font-size:13px;font-weight:700;color:var(--muted)}.facts dd{margin:0;font-size:14.5px}
@media(max-width:820px){.facts dl{grid-template-columns:1fr}.facts dl div{grid-template-columns:120px minmax(0,1fr)}}
.sizes{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}@media(max-width:900px){.sizes{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:560px){.sizes{grid-template-columns:1fr}}
.size{background:var(--paper);border:1px solid var(--line);border-radius:18px;overflow:hidden;display:flex;flex-direction:column;transition:transform .18s,box-shadow .18s}
.size:hover{transform:translateY(-3px);box-shadow:0 14px 34px rgba(11,37,69,.12)}
.size .vis{position:relative;aspect-ratio:2/1;background:var(--sky);border-bottom:1px solid var(--line);display:grid;place-items:center}
.size .vis svg{display:block;width:100%;height:100%}
.size .body{padding:16px 16px 6px}
.badges{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:10px}
.badge{font-size:11px;font-weight:800;letter-spacing:.05em;text-transform:uppercase;border-radius:6px;padding:3px 8px}
.badge.ok{background:#e3f6ea;color:#11743b}.badge.hold{background:#fde8d8;color:#9a3412}.badge.perm{background:#fff1da;color:#8a5a0b}
.size h3{font-size:30px;color:var(--navy);display:flex;align-items:baseline;gap:8px}
.size h3 small{font-size:14px;font-weight:600;color:var(--muted)}
.size .use{margin:6px 0 10px;font-size:14px;color:var(--muted)}
.specs{display:grid;grid-template-columns:1fr;gap:8px}
.specs div{background:var(--bg);border-radius:10px;padding:8px 10px;font-size:12px;color:var(--muted);line-height:1.3}.specs strong{display:block;font-size:15px;color:var(--ink)}
.size .go{padding:12px 16px 16px;margin-top:auto}.size .go .btn{width:100%;padding:12px}
.rule{margin-top:18px;background:var(--paper);border:1px solid #f1d9ad;border-left:4px solid var(--amber);border-radius:12px;padding:16px 18px;font-size:14.5px;color:#4a3a1e}
.rule strong{color:#7a4d0b}
.fulllist{margin-top:14px;background:var(--paper);border:1px solid var(--line);border-radius:14px;padding:4px 16px}
.fulllist summary{cursor:pointer;font-weight:700;padding:12px 0;color:var(--navy)}
.fulllist table{width:100%;border-collapse:collapse;min-width:520px;font-size:14px;margin-bottom:14px}
.fulllist caption{text-align:left;font-size:13px;color:var(--muted);padding-bottom:8px}
.fulllist th{text-align:left;background:var(--navy);color:#fff;padding:9px 10px}.fulllist td{padding:9px 10px;border-bottom:1px solid var(--line);font-variant-numeric:tabular-nums}
.grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}@media(max-width:820px){.grid3{grid-template-columns:1fr}}
.card{background:var(--paper);border:1px solid var(--line);border-radius:16px;padding:22px}
.card h3{font-size:20px;margin:8px 0;color:var(--navy)}.card p{margin:0;color:var(--muted);font-size:15px}.card .n{font:800 12px var(--f);letter-spacing:.12em;color:var(--cyan)}
.loc{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:28px;align-items:start}@media(max-width:860px){.loc{grid-template-columns:1fr}}
#itmap{height:360px;border-radius:16px;border:1px solid var(--line);background:#e6edf5}
.dist{list-style:none;padding:0;margin:16px 0 0}.dist li{display:flex;justify-content:space-between;padding:11px 0;border-bottom:1px solid var(--line);font-size:15px}.dist b{font-variant-numeric:tabular-nums}
.faq{max-width:840px}.faq details{background:var(--paper);border:1px solid var(--line);border-radius:14px;padding:4px 18px;margin-bottom:10px}
.faq summary{cursor:pointer;font-weight:700;padding:14px 0;list-style:none;display:flex;justify-content:space-between;gap:12px}
.faq summary::-webkit-details-marker{display:none}.faq summary:after{content:"+";font-size:20px;color:var(--cyan)}.faq details[open] summary:after{content:"–"}
.faq details p{margin:0 0 14px;color:var(--muted)}
.cta{background:var(--navy);color:#fff;border-radius:22px;padding:34px;display:flex;flex-wrap:wrap;gap:20px;justify-content:space-between;align-items:center}
.cta h2{font-size:clamp(25px,3.2vw,34px)}.cta p{margin:6px 0 0;color:#c9d8e8}.cta .acts{display:flex;flex-wrap:wrap;gap:10px}.cta .btn.ghost{color:#fff;border-color:rgba(255,255,255,.45)}
.foot{padding:34px 0 110px;color:var(--muted);font-size:13.5px}.foot p{margin:6px 0}
.sticky-wa{position:fixed;left:0;right:0;bottom:0;z-index:30;display:none;padding:10px max(14px,env(safe-area-inset-right,0px)) calc(10px + env(safe-area-inset-bottom,0px)) max(14px,env(safe-area-inset-left,0px));background:#fff;border-top:1px solid var(--line);box-shadow:0 -6px 18px rgba(0,0,0,.08)}
.sticky-wa .btn{width:100%}@media(max-width:820px){.sticky-wa{display:block}}
@media(prefers-reduced-motion:reduce){*{transition:none!important;scroll-behavior:auto!important}}
</style>
</head>
<body>

<header class="top">
  <div class="wrap">
    <a class="brand" href="#top" aria-label="IT City Lucknow Plots, home">
      <i><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7fe0ec" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="7" height="18" rx="1"/><rect x="13" y="8" width="7" height="13" rx="1"/><path d="M7 7h1M7 11h1M7 15h1M16 12h1M16 16h1"/></svg></i>
      <span>IT City Lucknow Plots<small>Sultanpur Road · Lucknow</small></span>
    </a>
    <nav aria-label="Main">
      <a class="hide" href="#launch">23 Nov launch</a><a class="hide" href="#sizes">Sizes & cost</a><a class="hide" href="#location">Location</a><a class="hide" href="#faq">FAQ</a>
      <a class="btn wa" style="padding:9px 14px;font-size:14px" href="<?php echo $e($wa('Hello, please share IT City Lucknow plot sizes and prices.')); ?>" target="_blank" rel="noopener">WhatsApp</a>
    </nav>
  </div>
</header>

<section class="hero" id="top">
  <div class="wrap">
    <div>
      <span class="kicker">LDA IT City · Sultanpur Road · Lucknow</span>
      <h1>IT City Lucknow plots, <em>before and after the launch.</em></h1>
      <p class="lead">LDA opens IT City to the public on 23 November 2026, when registration starts for its own plots. Until the lottery result, the only plots you can actually buy are the ones already allotted to land-pooling farmers, in sizes of <?php echo $list; ?> m².</p>
      <p class="hi">आईटी सिटी का शुभारंभ 23 नवंबर को। लॉटरी से पहले खरीदने के लिए किसानों को आवंटित <?php echo $list; ?> वर्ग मीटर के प्लॉट उपलब्ध।</p>
      <div class="acts">
        <a class="btn" href="#sizes" style="background:#7fe0ec;border-color:#7fe0ec;color:#0b2545">See plot sizes ↓</a>
        <a class="btn ghost" href="<?php echo $e($wa('Hello, I want to buy a plot in IT City Lucknow. Please share sizes and prices.')); ?>" target="_blank" rel="noopener">Ask on WhatsApp</a>
      </div>
    </div>
    <div class="stats" aria-label="Summary">
      <div class="stat"><b>23 Nov</b><span>public launch and registration</span></div>
      <div class="stat"><b>₹4,000–4,200</b><span>per sq ft, reported proposed rate</span></div>
      <div class="stat"><b>2,197</b><span>plots allotted to farmers so far</span></div>
      <div class="stat"><b>≈ 1,054 ha</b><span>scheme area in 11 villages</span></div>
    </div>
  </div>
</section>
<div class="strip"><div class="wrap">Updated <strong><?php echo $updated; ?></strong>. Independent resale service, not LDA. Farmer plots in the notified phase-1 area change hands only with the District Collector's written permission.</div></div>

<main>
<section class="band" id="facts" style="padding:44px 0">
  <div class="wrap">
    <div class="facts">
      <h2>IT City facts that matter to a buyer</h2>
      <dl>
        <div><dt>Scheme area</dt><dd>About 1,054 ha (about 2,604 acres) on Sultanpur Road, connected to Kisan Path</dd></div>
        <div><dt>How land came in</dt><dd>~500 ha by land pooling, ~200 ha gram samaj land, ~300 ha to be acquired at 4× circle rate (rural)</dd></div>
        <div><dt>Villages</dt><dd>Bakkas, Sikandarpur Amoliya, Siddhpura, Parehta, Rakibabad, Mohari Khurd, Mohari Kalan, Khujauli, Bhatwara, Sonai Kanjehra, Pahadnagar Tikariya</dd></div>
        <div><dt>Farmer plots</dt><dd>2,197 plots to 1,465 farmers in three 2026 lotteries, sectors 9, 15, 16, 17, 18 and 30</dd></div>
        <div><dt>Public launch</dt><dd>23 November 2026 with Saumitra Vihar; public plot registration opens; farmers get allotment letters</dd></div>
        <div><dt>Expected rate</dt><dd>About ₹4,000 per sq ft (LDA secretary, 27 Oct) to ₹4,200 (4 Nov report); not notified</dd></div>
        <div><dt>For companies</dt><dd>LDA board proposal (2 Nov): land for companies and institutions at about 40% below the residential rate</dd></div>
        <div><dt>Transfers</dt><dd>Phase-1 land is notified; a farmer plot is sold only with the District Collector's prior written permission</dd></div>
      </dl>
    </div>
  </div>
</section>

<section class="band" id="launch">
  <div class="wrap">
    <div class="head"><span class="kicker">Lottery or resale?</span><h2>Two ways into IT City after 23 November</h2><p>The launch opens a public lottery for LDA's own plots, but registering is not the same as getting a plot. Here is how the two routes compare.</p></div>
    <div class="grid3">
      <div class="card"><span class="n">ROUTE A</span><h3>Apply in LDA's lottery</h3><p>You pay at LDA's notified rate, but only if your name comes out in the draw. Plot counts, sizes and the last date were not published as of <?php echo $updated; ?>.</p></div>
      <div class="card"><span class="n">ROUTE B</span><h3>Buy a farmer's allotted plot</h3><p>The plot, its sector and its size are known today. The price is agreed with the farmer, and the transfer needs the District Collector's permission.</p></div>
      <div class="card"><span class="n">BOTH</span><h3>Check before paying</h3><p>For a lottery, use only LDA's own portal. For resale, match the allotment letter, the seller's ID and the plot number on LDA's layout.</p></div>
    </div>
  </div>
</section>

<section class="band" id="sizes">
  <div class="wrap">
    <div class="head"><span class="kicker">Farmer plot sizes</span><h2>What each size would cost at the expected rate</h2><p>Every card works out the land cost at ₹<?php echo number_format($rateSqft); ?> per sq ft, the rate reported for LDA's public launch, so you can weigh a resale price against it. The rate is not notified yet and excludes LDA's other charges.</p></div>
    <div class="sizes">
      <?php foreach ($open as $k => $s): [$m, $status] = $s;
        $w = 40 + $m / 288 * 170; $h = 22 + $m / 288 * 64;     // drawn to scale against the 288 m² plot
        $msg = "Hello, I want an IT City farmer plot of $m m² (" . $sqft($m) . " sq ft). Which sector is it in, what is the asking price, and is DM permission granted?";
      ?>
      <article class="size" id="size-<?php echo $m; ?>">
        <div class="vis" aria-hidden="true">
          <svg viewBox="0 0 300 150" preserveAspectRatio="xMidYMid meet">
            <rect x="<?php echo 150 - 105; ?>" y="<?php echo 75 - 43; ?>" width="210" height="86" rx="4" fill="none" stroke="#b9d3e3" stroke-width="1.5" stroke-dasharray="5 5"/>
            <rect x="<?php echo 150 - $w / 2; ?>" y="<?php echo 75 - $h / 2; ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>" rx="4" fill="#fff" stroke="#0b2545" stroke-width="2.5"/>
            <text x="150" y="<?php echo 75; ?>" text-anchor="middle" dominant-baseline="middle" font-family="Poppins, Arial, sans-serif" font-size="<?php echo $m < 70 ? 11 : 14; ?>" font-weight="700" fill="#0b2545"><?php echo $m; ?> m²</text>
            <text x="150" y="138" text-anchor="middle" font-family="Poppins, Arial, sans-serif" font-size="10" font-weight="600" fill="#5b6b82">dashed outline = 288 m² for scale</text>
          </svg>
        </div>
        <div class="body">
          <div class="badges">
            <?php if ($status === 'hold'): ?><span class="badge hold">On hold</span><?php else: ?><span class="badge ok">Available</span><?php endif; ?>
            <span class="badge perm">DM permission: ask us</span>
          </div>
          <h3><?php echo $m; ?> m² <small><?php echo $sqft($m); ?> sq ft</small></h3>
          <p class="use"><?php echo $e($use[$m] ?? 'Residential plot'); ?></p>
          <div class="specs">
            <div><strong><?php echo $sqyd($m); ?></strong>sq yd (gaj)</div>
            <div><strong>≈ ₹<?php echo $lakh($m); ?> lakh</strong>at ₹<?php echo number_format($rateSqft); ?>/sq ft expected rate</div>
          </div>
        </div>
        <div class="go"><a class="btn wa" href="<?php echo $e($wa($msg)); ?>" target="_blank" rel="noopener">Get price for <?php echo $m; ?> m²</a></div>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="rule"><strong>Farmer plots need a permission step:</strong> the phase-1 area is notified, so no sale deed should be signed until the District Collector has given written permission for that plot. Ask the seller for the lottery allotment letter in their own name; farmers are due to receive letters at the 23 November event.
      <a href="https://www.hindustantimes.com/cities/lucknow-news/lda-prohibits-land-deals-in-phase-1-of-it-city-wellness-city-projects-101780758619729.html" target="_blank" rel="noopener" style="color:#7a4d0b;font-weight:700">Read the report ↗</a></div>
    <details class="fulllist">
      <summary>All sizes and costs in a table</summary>
      <div style="overflow-x:auto"><table>
        <caption>Land cost at the reported ₹<?php echo number_format($rateSqft); ?>/sq ft (not notified; LDA charges extra), <?php echo $updated; ?></caption>
        <thead><tr><th>Size (m²)</th><th>Sq ft</th><th>Sq yd (gaj)</th><th>At expected rate</th><th>Status</th></tr></thead>
        <tbody><?php foreach ($open as $s): ?><tr><td><?php echo $s[0]; ?> m²</td><td><?php echo $sqft($s[0]); ?></td><td><?php echo $sqyd($s[0]); ?></td><td>₹<?php echo $lakh($s[0]); ?> lakh</td><td><?php echo $s[1] === 'hold' ? 'On hold' : 'Available'; ?></td></tr><?php endforeach; ?></tbody>
      </table></div>
    </details>
  </div>
</section>

<section class="band" id="how">
  <div class="wrap">
    <div class="head"><span class="kicker">Resale, in practice</span><h2>How a farmer-plot purchase goes</h2></div>
    <div class="grid3">
      <div class="card"><span class="n">1 · MATCH</span><h3>Tell us size and sector</h3><p>We check which allotted plots in sectors 9, 15, 16, 17, 18 or 30 fit your size and budget, and send the asking price for each.</p></div>
      <div class="card"><span class="n">2 · INSPECT</span><h3>Walk the plot</h3><p>Visit the sector with us, see the road in front and the neighbouring plots, and go through the farmer's allotment papers.</p></div>
      <div class="card"><span class="n">3 · TRANSFER</span><h3>Permission, then deed</h3><p>Once the District Collector's written permission is issued for the plot, the sale deed is registered. Not before.</p></div>
    </div>
  </div>
</section>

<section class="band" id="location">
  <div class="wrap loc">
    <div>
      <span class="kicker">Location</span>
      <h2 style="font-size:clamp(27px,3.6vw,40px);margin:8px 0 12px">Where IT City is</h2>
      <p style="color:var(--muted);margin:0">IT City lies along Sultanpur Road in Mohanlalganj tehsil and connects to Kisan Path, the outer ring road. Its 11 villages run from Bakkas and Parehta to Sonai Kanjehra and Pahadnagar Tikariya. Wellness City, the other LDA land-pooling scheme in this belt, is next door.</p>
      <ul class="dist"><li>Hazratganj <b>≈ 15.1 km</b></li><li>Charbagh railway station <b>≈ 15.8 km</b></li><li>Lucknow airport <b>≈ 16.2 km</b></li></ul>
      <p style="font-size:13px;color:var(--muted)">Straight-line distances from the scheme centre; road distances are longer.</p>
      <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:14px">
        <a class="btn" href="https://www.google.com/maps/search/?api=1&query=<?php echo $geo[0] . ',' . $geo[1]; ?>" target="_blank" rel="noopener">Open in Google Maps ↗</a>
        <a class="btn ghost" href="<?php echo $e($wa('Hello, I want to visit IT City Lucknow and see plots. Please arrange a site visit.')); ?>" target="_blank" rel="noopener">Book a site visit</a>
      </div>
    </div>
    <div id="itmap" role="region" aria-label="Map of IT City Lucknow"></div>
  </div>
</section>

<section class="band" id="hindi" lang="hi">
  <div class="wrap">
    <div class="head"><span class="kicker">हिंदी में</span><h2>आईटी सिटी लखनऊ: 23 नवंबर को शुभारंभ</h2>
      <p>मुख्यमंत्री और रक्षामंत्री 23 नवंबर 2026 को आईटी सिटी का शुभारंभ करेंगे और आम लोगों के लिए प्लॉट पंजीकरण खुलेगा। प्रस्तावित दर करीब ₹4,000 से ₹4,200 प्रति वर्गफुट बताई गई है, जो अभी अधिसूचित नहीं है। लॉटरी से पहले खरीदना हो तो लैंड पूलिंग वाले किसानों को आवंटित <?php echo $list; ?> वर्ग मीटर के प्लॉट मिल सकते हैं।</p></div>
    <div class="grid3">
      <div class="card"><h3>11 गांव, 1,054 हेक्टेयर</h3><p>बक्कास, सिकंदरपुर अमोलिया, सिद्धपुरा, परेहटा, रकीबाबाद, मोहारी खुर्द, मोहारी कलां, खुजौली, भटवारा, सोनई कंजेहरा और पहाड़नगर टिकरिया।</p></div>
      <div class="card"><h3>किसानों के प्लॉट</h3><p>तीन लॉटरी में 1,465 किसानों को 2,197 प्लॉट मिले। इन्हें बेचने से पहले जिलाधिकारी की लिखित अनुमति ज़रूरी है; हर प्लॉट की स्थिति हम कीमत के साथ बताते हैं।</p></div>
      <div class="card"><h3>LDA की साइट नहीं</h3><p>हम एक स्वतंत्र रीसेल सेवा हैं। लॉटरी का पंजीकरण सिर्फ LDA के अपने पोर्टल ldalucknow.in से करें।</p></div>
    </div>
  </div>
</section>

<section class="band" id="faq">
  <div class="wrap faq">
    <div class="head"><span class="kicker">Questions</span><h2>IT City Lucknow: launch, rate and resale questions</h2></div>
    <?php foreach ($faq as $q): ?><details><summary><?php echo $e($q[0]); ?></summary><p><?php echo $e($q[1]); ?></p></details><?php endforeach; ?>
  </div>
</section>

<section class="band" style="border-bottom:0">
  <div class="wrap"><div class="cta">
    <div><h2>Don't want to wait for the lottery draw?</h2><p>Tell us your size and sector. We send farmer plots that match, with price and permission status.</p></div>
    <div class="acts"><a class="btn wa" href="<?php echo $e($wa('Hello, I want an IT City plot without waiting for the lottery. My size, sector and budget:')); ?>" target="_blank" rel="noopener">Find me a plot</a>
      <a class="btn ghost" href="tel:+<?php echo $phone; ?>">Call <?php echo $e($phoneShow); ?></a></div>
  </div></div>
</section>
</main>

<footer class="foot"><div class="wrap">
  <p><strong>IT City Lucknow Plots</strong> · <?php echo $e($phoneShow); ?></p>
  <p>We arrange resale of plots that LDA allotted to IT City's land-pooling farmers. We have no connection with the Lucknow Development Authority, and we do not take lottery applications; those go only through <a href="https://ldalucknow.in/" target="_blank" rel="noopener" style="color:var(--navy2)">ldalucknow.in</a>. Rates quoted here are reported, not notified. Every farmer-plot sale in phase 1 needs the District Collector's written permission before the deed.</p>
</div></footer>

<div class="sticky-wa"><a class="btn wa" href="<?php echo $e($wa('Hello, please share IT City Lucknow plot sizes and prices.')); ?>" target="_blank" rel="noopener">WhatsApp for plot prices</a></div>

<script>
(function () {
  var el = document.getElementById('itmap');
  function go() {
    var map = L.map(el, { scrollWheelZoom: false }).setView([<?php echo $geo[0] . ', ' . $geo[1]; ?>], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);
    L.circle([<?php echo $geo[0] . ', ' . $geo[1]; ?>], { radius: 2200, color: '#22b5c9', weight: 2, dashArray: '6 6', fillColor: '#22b5c9', fillOpacity: .1 }).addTo(map);
    L.circleMarker([<?php echo $geo[0] . ', ' . $geo[1]; ?>], { radius: 9, color: '#fff', weight: 2, fillColor: '#0b2545', fillOpacity: 1 })
      .addTo(map).bindPopup('<b>IT City Lucknow</b><br>Sultanpur Road (approximate area)').openPopup();
  }
  function load() {
    var c = document.createElement('link'); c.rel = 'stylesheet'; c.href = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css'; document.head.appendChild(c);
    var s = document.createElement('script'); s.src = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js'; s.onload = go; document.head.appendChild(s);
  }
  if ('IntersectionObserver' in window) { var io = new IntersectionObserver(function (e) { if (e[0].isIntersecting) { io.disconnect(); load(); } }, { rootMargin: '300px' }); io.observe(el); } else { load(); }
})();
</script>
</body>
</html>
