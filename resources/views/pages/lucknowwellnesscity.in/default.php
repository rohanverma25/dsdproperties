<?php
/*
 * lucknowwellnesscity.in — standalone plot sales page (plain PHP, no Laravel). Redesigned 22 Oct 2026.
 * Independent seller page: never present it as the official LDA site.
 * The user confirmed plots of all six sizes are on offer (22 Oct 2026). Transfers in the notified Phase-1 area
 * need the District Collector's prior written permission, so every card says the permission status comes with the price.
 * To change stock, edit $sizes. 'status' => 'available' | 'hold' | 'sold'.
 */
$site = 'https://lucknowwellnesscity.in/';
$phone = '918595002933';
$phoneShow = '+91 85950 02933';
$updated = '10 November 2026';
$updatedIso = '2026-11-10';   // change both dates whenever $sizes changes
$rate = 54559.17;             // LDA's PROPOSED rate per m² (finance controller's order, 30 June 2026); always call it "proposed"
$geo = [26.80505, 81.06107];

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
$lakh = function ($m) use ($rate) { return number_format($m * $rate / 100000, 1); };   // base cost in ₹ lakh at the proposed rate
$use = [35 => 'Smallest allotment size; fits a compact single-family house', 72 => 'Two floors of about 775 sq ft each on a narrow frontage',
        128 => 'Common family size; space for a ground-plus-one with parking', 162 => 'Wider frontage, room for a front setback and garden',
        200 => 'Suits a four-bedroom home or two independent floors', 288 => 'The largest size in the farmers\' lottery; villa-scale'];

$faq = [
    ['What is the price of a plot in Wellness City Lucknow?', 'LDA\'s finance controller proposed a land rate of ₹54,559.17 per m² (about ₹5,100 per sq ft) in an order of 30 June 2026. That rate is still proposed; on 27 October the LDA secretary said the public rate may be above ₹5,500 per sq ft. Resale asking prices from landowners are set by each seller, so ask us on WhatsApp for the current figure for a size.'],
    ['Which plot sizes did landowners receive?', 'The first land-pooling lottery on 30 June 2026 gave 125 plots to 59 landowners: 86 of 288 m², 4 of 200 m², 5 of 162 m², 9 of 128 m², 7 of 72 m² and 14 of 35 m². These are the sizes on offer here.'],
    ['What is planned in the Wellness City hospital zone?', 'The LDA layout keeps about 150 acres for hospitals. LDA has listed super-speciality hospitals, a medical college, diagnostic centres, yoga, meditation and Vipassana centres, and a plan to move the Aminabad wholesale medicine market here. No hospital operator has been named yet.'],
    ['How big is Wellness City?', 'About 1,474 acres in total across its phases. Phase 1 is 485 ha (about 1,198 acres) in 7 villages of Mohanlalganj tehsil, and the layout for it has roughly 2,000 LDA plots on 76.83 acres, 362.41 acres of group housing and about 200 acres of parks.'],
    ['Can I register a resale plot in Wellness City now?', 'Phase 1 land has been notified under Section 11 since June 2026, so a transfer needs the District Collector\'s prior written permission. We tell you the permission status of each plot with its price; register only after it is in place and the seller\'s LDA allotment letter has been checked.'],
    ['Is this the official LDA website?', 'No. This is an independent resale service, not linked to the Lucknow Development Authority. LDA\'s own schemes and notices are only on ldalucknow.in.'],
];
?><!doctype html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Wellness City Lucknow Plots: Resale Land-Pooling Plots, Rate & Hospital Zone</title>
<meta name="description" content="Resale plots in LDA Wellness City, Lucknow (Sultanpur Road – Kisan Path): <?php echo $list; ?> m² from the June 2026 farmers' lottery. Proposed LDA rate ₹54,559/m², base cost per size, the 150-acre hospital zone and transfer rules. वेलनेस सिटी लखनऊ प्लॉट।">
<meta name="keywords" content="Wellness City Lucknow plots, Wellness City Lucknow plot for sale, LDA Wellness City plot, Wellness City Sultanpur Road, Wellness City Lucknow plot size, Wellness City Lucknow price, वेलनेस सिटी लखनऊ प्लॉट, LDA land pooling plot Lucknow">
<meta name="robots" content="index,follow,max-image-preview:large">
<meta name="theme-color" content="#0f3d36">
<link rel="canonical" href="<?php echo $site; ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Wellness City Lucknow Plots">
<meta property="og:title" content="Wellness City Lucknow resale plots: <?php echo $list; ?> m²">
<meta property="og:description" content="Land-pooling plots next to LDA's planned hospital zone on Sultanpur Road. Proposed rate, base cost by size and transfer rules.">
<meta property="og:url" content="<?php echo $site; ?>">
<meta property="og:image" content="<?php echo $site; ?>og-image.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Wellness City Lucknow plots for sale">
<meta name="twitter:card" content="summary_large_image">
<meta name="geo.region" content="IN-UP">
<meta name="geo.placename" content="Lucknow">
<meta name="geo.position" content="<?php echo $geo[0] . ';' . $geo[1]; ?>">
<meta name="ICBM" content="<?php echo $geo[0] . ', ' . $geo[1]; ?>">
<link rel="alternate" type="text/plain" href="<?php echo $site; ?>llms.txt" title="LLM summary">
<script type="application/ld+json">
<?php
echo json_encode(['@context' => 'https://schema.org', '@graph' => [
  ['@type' => 'WebSite', '@id' => $site . '#website', 'name' => 'Wellness City Lucknow Plots', 'url' => $site, 'inLanguage' => ['en-IN', 'hi-IN']],
  ['@type' => 'WebPage', '@id' => $site . '#webpage', 'url' => $site, 'name' => 'Wellness City Lucknow plots for sale', 'isPartOf' => ['@id' => $site . '#website'],
   'about' => ['@id' => $site . '#place'], 'mainEntity' => ['@id' => $site . '#plots'], 'dateModified' => $updatedIso, 'inLanguage' => 'en-IN', 'primaryImageOfPage' => $site . 'og-image.jpg'],
  ['@type' => 'Place', '@id' => $site . '#place', 'name' => 'Wellness City Lucknow', 'alternateName' => ['LDA Wellness City', 'वेलनेस सिटी लखनऊ'],
   'description' => 'The LDA planned "Medi City" of about 1,474 acres between Sultanpur Road and Kisan Path, Mohanlalganj tehsil, with about 150 acres for hospitals and a medical college; land collected through land pooling.',
   'geo' => ['@type' => 'GeoCoordinates', 'latitude' => $geo[0], 'longitude' => $geo[1]],
   'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Sultanpur Road', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN']],
  ['@type' => 'RealEstateAgent', '@id' => $site . '#agent', 'name' => 'Wellness City Lucknow Plots', 'url' => $site, 'telephone' => '+' . $phone, 'image' => $site . 'og-image.jpg',
   'areaServed' => ['@id' => $site . '#place'], 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN']],
  ['@type' => 'ItemList', '@id' => $site . '#plots', 'name' => 'Plot sizes for sale in Wellness City Lucknow', 'numberOfItems' => count($open),
   'itemListElement' => array_map(function ($s, $i) use ($site, $sqft, $updatedIso) {
       return ['@type' => 'ListItem', 'position' => $i + 1, 'item' => ['@type' => 'Place',
         'name' => $s[0] . ' m² residential plot, Wellness City, Sultanpur Road, Lucknow',
         'description' => $s[0] . ' m² (' . $sqft($s[0]) . ' sq ft) plot from the LDA land-pooling lottery of 30 June 2026 in Wellness City, Lucknow. Transfer needs District Collector permission under Section 11.',
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
/* Layout: "wellness township" — deep pine and soft mint, rounded organic shapes, warm coral for actions; plot cards scale with size */
:root{--navy:#0f3d36;--navy2:#165247;--cyan:#3fb79a;--sky:#e6f4ef;--paper:#fff;--bg:#f3f8f5;--ink:#12302b;--muted:#5a6f69;--line:#d9e7e1;--amber:#f08a5d;--green:#1fa855;--f:'Poppins',system-ui,-apple-system,'Segoe UI',Arial,sans-serif}
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
.hero:before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 85% 20%,rgba(63,183,154,.35) 0,transparent 40%),radial-gradient(circle at 70% 90%,rgba(240,138,93,.22) 0,transparent 35%)}
.hero .wrap{position:relative;display:grid;grid-template-columns:minmax(0,1.25fr) minmax(0,1fr);gap:40px;align-items:center;padding-top:64px;padding-bottom:64px}
.hero h1{font-size:clamp(34px,5.2vw,58px);margin:14px 0 16px}.hero h1 em{font-style:normal;color:#9ce8cf}
.hero .lead{font-size:18px;color:#d5e2f0;max-width:600px;margin:0 0 12px}
.hero .hi{font-size:15px;color:#a9c2dc;margin:0 0 24px}
.hero .acts{display:flex;flex-wrap:wrap;gap:12px}
.hero .btn.ghost{color:#fff;border-color:rgba(255,255,255,.45)}.hero .btn.ghost:hover{background:rgba(255,255,255,.08)}
.stats{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.stat{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.14);border-radius:16px;padding:18px}
.stat b{display:block;font-size:30px;line-height:1.05;color:#9ce8cf;font-variant-numeric:tabular-nums}.stat span{font-size:13.5px;color:#c9d8e8}
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
.size{background:var(--paper);border:1px solid var(--line);border-radius:24px;overflow:hidden;display:flex;flex-direction:column;transition:transform .18s,box-shadow .18s}
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
    <a class="brand" href="#top" aria-label="Wellness City Lucknow Plots, home">
      <i><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ce8cf" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21c-5-3-8-6.5-8-10.5A4.5 4.5 0 0 1 12 7a4.5 4.5 0 0 1 8 3.5C20 14.5 17 18 12 21z"/><path d="M12 10v6M9 13h6"/></svg></i>
      <span>Wellness City Lucknow Plots<small>Sultanpur Road · Kisan Path</small></span>
    </a>
    <nav aria-label="Main">
      <a class="hide" href="#sizes">Sizes & cost</a><a class="hide" href="#plan">Hospital zone</a><a class="hide" href="#location">Location</a><a class="hide" href="#faq">FAQ</a>
      <a class="btn wa" style="padding:9px 14px;font-size:14px" href="<?php echo $e($wa('Hello, please share Wellness City Lucknow plot sizes and prices.')); ?>" target="_blank" rel="noopener">WhatsApp</a>
    </nav>
  </div>
</header>

<section class="hero" id="top">
  <div class="wrap">
    <div>
      <span class="kicker">LDA Wellness City · Sultanpur Road · Lucknow</span>
      <h1>Wellness City Lucknow plots, <em>live close to care.</em></h1>
      <p class="lead">LDA is building Wellness City as Lucknow's "Medi City", with 150 acres set aside for hospitals and a medical college. The farmers who pooled their land got developed plots of <?php echo $list; ?> m² in the June 2026 lottery, and some of them are selling. LDA has not opened its own public scheme yet.</p>
      <p class="hi">वेलनेस सिटी लखनऊ: लैंड पूलिंग लॉटरी में मिले <?php echo $list; ?> वर्ग मीटर के प्लॉट, अस्पताल ज़ोन के पास। कीमत और परमिशन की स्थिति WhatsApp पर।</p>
      <div class="acts">
        <a class="btn" href="#sizes" style="background:#9ce8cf;border-color:#9ce8cf;color:#0f3d36">See plot sizes ↓</a>
        <a class="btn ghost" href="<?php echo $e($wa('Hello, I want to buy a plot in Wellness City Lucknow. Please share sizes and prices.')); ?>" target="_blank" rel="noopener">Ask on WhatsApp</a>
      </div>
    </div>
    <div class="stats" aria-label="Summary">
      <div class="stat"><b>150 ac</b><span>kept for hospitals in the layout</span></div>
      <div class="stat"><b>₹5,100</b><span>per sq ft, LDA's proposed rate</span></div>
      <div class="stat"><b>125</b><span>plots in the first farmers' lottery</span></div>
      <div class="stat"><b>≈ 1,474 ac</b><span>planned area, all phases</span></div>
    </div>
  </div>
</section>
<div class="strip"><div class="wrap">Updated <strong><?php echo $updated; ?></strong>. We are an independent resale service, not LDA. Phase-1 land is notified under Section 11, so every transfer needs the District Collector's written permission first.</div></div>

<main>
<section class="band" id="facts" style="padding:44px 0">
  <div class="wrap">
    <div class="facts">
      <h2>Wellness City in numbers</h2>
      <dl>
        <div><dt>Planned area</dt><dd>About 1,474 acres in total; phase 1 is 485 ha (about 1,198 acres)</dd></div>
        <div><dt>Project cost</dt><dd>₹1,441.26 crore, with 40% of land and development funded by the state government</dd></div>
        <div><dt>Hospitals</dt><dd>About 150 acres for hospitals, a medical college and health facilities</dd></div>
        <div><dt>LDA plots</dt><dd>Roughly 2,000 plots on 76.83 acres in the phase-1 layout, to be sold by LDA later</dd></div>
        <div><dt>Group housing</dt><dd>362.41 acres for flats; about 200 acres of parks and 57 acres of commercial land</dd></div>
        <div><dt>Proposed rate</dt><dd>₹54,559.17 per m² (about ₹5,100 per sq ft), LDA order of 30 June 2026; not final</dd></div>
        <div><dt>Farmers' lottery</dt><dd>30 June 2026: 125 plots to 59 landowners, the source of the plots sold here</dd></div>
        <div><dt>Villages (phase 1)</dt><dd>Bakkas, Malukpur Dhakwa, Chaurahiya, Chaurasi, Dularmau, Noorpur Behta, Mastemau (Mohanlalganj tehsil)</dd></div>
        <div><dt>Section 11</dt><dd>Notified 5 June 2026; transfers need the District Collector's prior written permission</dd></div>
        <div><dt>LDA public scheme</dt><dd>No brochure or registration date as of <?php echo $updated; ?></dd></div>
      </dl>
    </div>
  </div>
</section>

<section class="band" id="sizes">
  <div class="wrap">
    <div class="head"><span class="kicker">Six lottery sizes</span><h2>Plot sizes and what they cost at LDA's rate</h2><p>Each card shows the base land cost at LDA's proposed ₹54,559.17 per m², so you can compare sizes. It leaves out the 12% freehold charge, water and sewer charges and any corner or park-facing premium. A landowner's resale price is their own and can be higher or lower.</p></div>
    <div class="sizes">
      <?php foreach ($open as $k => $s): [$m, $status] = $s;
        $w = 40 + $m / 288 * 170; $h = 22 + $m / 288 * 64;     // drawn to scale against the 288 m² plot
        $msg = "Hello, I'm looking at a $m m² (" . $sqft($m) . " sq ft) Wellness City plot. What is the asking price, the sector and road width, and does it have DM permission?";
      ?>
      <article class="size" id="size-<?php echo $m; ?>">
        <div class="vis" aria-hidden="true">
          <svg viewBox="0 0 300 150" preserveAspectRatio="xMidYMid meet">
            <rect x="<?php echo 150 - 105; ?>" y="<?php echo 75 - 43; ?>" width="210" height="86" rx="4" fill="none" stroke="#b7dccd" stroke-width="1.5" stroke-dasharray="5 5"/>
            <rect x="<?php echo 150 - $w / 2; ?>" y="<?php echo 75 - $h / 2; ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>" rx="4" fill="#fff" stroke="#0f3d36" stroke-width="2.5"/>
            <text x="150" y="<?php echo 75; ?>" text-anchor="middle" dominant-baseline="middle" font-family="Poppins, Arial, sans-serif" font-size="<?php echo $m < 70 ? 11 : 14; ?>" font-weight="700" fill="#0f3d36"><?php echo $m; ?> m²</text>
            <text x="150" y="138" text-anchor="middle" font-family="Poppins, Arial, sans-serif" font-size="10" font-weight="600" fill="#5a6f69">dashed outline = 288 m² for scale</text>
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
            <div><strong>≈ ₹<?php echo $lakh($m); ?> lakh</strong>base cost at LDA's proposed rate</div>
          </div>
        </div>
        <div class="go"><a class="btn wa" href="<?php echo $e($wa($msg)); ?>" target="_blank" rel="noopener">Get price for <?php echo $m; ?> m²</a></div>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="rule"><strong>Check three things before any token money:</strong> the LDA allotment letter from the 30 June lottery in the seller's own name; the plot's sector and number on LDA's layout; and the District Collector's written permission for the transfer, which Section 11 requires in phase 1.
      <a href="https://www.hindustantimes.com/cities/lucknow-news/lda-prohibits-land-deals-in-phase-1-of-it-city-wellness-city-projects-101780758619729.html" target="_blank" rel="noopener" style="color:#7a4d0b;font-weight:700">Read the report ↗</a></div>
    <details class="fulllist">
      <summary>Compare all sizes in one table</summary>
      <div style="overflow-x:auto"><table>
        <caption>Base land cost at LDA's proposed ₹54,559.17/m² (before 12% freehold and other charges), <?php echo $updated; ?></caption>
        <thead><tr><th>Size (m²)</th><th>Sq ft</th><th>Sq yd (gaj)</th><th>Base cost</th><th>Status</th></tr></thead>
        <tbody><?php foreach ($open as $s): ?><tr><td><?php echo $s[0]; ?> m²</td><td><?php echo $sqft($s[0]); ?></td><td><?php echo $sqyd($s[0]); ?></td><td>₹<?php echo $lakh($s[0]); ?> lakh</td><td><?php echo $s[1] === 'hold' ? 'On hold' : 'Available'; ?></td></tr><?php endforeach; ?></tbody>
      </table></div>
    </details>
  </div>
</section>

<section class="band" id="plan">
  <div class="wrap">
    <div class="head"><span class="kicker">The Medi City plan</span><h2>What LDA has planned around these plots</h2><p>Wellness City is the only LDA scheme built around health care. These are the uses in LDA's own layout and statements; none of the buildings has started yet.</p></div>
    <div class="grid3">
      <div class="card"><span class="n">150 ACRES</span><h3>Hospital zone</h3><p>Land for super-speciality hospitals, a medical college and diagnostic centres. No hospital or college operator has been named so far.</p></div>
      <div class="card"><span class="n">WHOLESALE</span><h3>Aminabad medicine market</h3><p>The plan provides separate commercial plots to move Aminabad's wholesale medicine market here. LDA has not given a date for the move.</p></div>
      <div class="card"><span class="n">≈ 200 ACRES</span><h3>Parks, yoga and meditation</h3><p>Large parks plus yoga, meditation and Vipassana centres, in keeping with the wellness theme. Internal roads are planned at 24 to 60 m wide.</p></div>
    </div>
  </div>
</section>

<section class="band" id="how">
  <div class="wrap">
    <div class="head"><span class="kicker">Buying a resale plot</span><h2>From first message to registry</h2></div>
    <div class="grid3">
      <div class="card"><span class="n">STEP 1</span><h3>Ask for a size</h3><p>Use the button on a size card. We reply with the seller's asking price, the sector, the road in front and whether DM permission is already granted.</p></div>
      <div class="card"><span class="n">STEP 2</span><h3>Visit and verify</h3><p>See the plot on site with us. Match the allotment letter, the seller's ID and the plot number against LDA's layout before you agree a price.</p></div>
      <div class="card"><span class="n">STEP 3</span><h3>Permission first</h3><p>The sale deed is signed only after the District Collector's written permission for the transfer. Until then, keep any advance small and in writing.</p></div>
    </div>
  </div>
</section>

<section class="band" id="location">
  <div class="wrap loc">
    <div>
      <span class="kicker">Location</span>
      <h2 style="font-size:clamp(27px,3.6vw,40px);margin:8px 0 12px">Where Wellness City is</h2>
      <p style="color:var(--muted);margin:0">The scheme sits in Mohanlalganj tehsil between Sultanpur Road and Kisan Path (the outer ring road), next to CG City. LDA puts it about 0.5 km from the Purvanchal Expressway. A 6.5 km, 24 m wide Green Corridor road is being built from Shaheed Path to Kisan Path, and four of Wellness City's main roads will join it.</p>
      <ul class="dist"><li>Hazratganj <b>≈ 12.4 km</b></li><li>Charbagh railway station <b>≈ 14.3 km</b></li><li>Lucknow airport <b>≈ 17.8 km</b></li><li>IT City <b>≈ 5.9 km</b></li></ul>
      <p style="font-size:13px;color:var(--muted)">Straight-line distances from the scheme centre; road distances are longer.</p>
      <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:14px">
        <a class="btn" href="https://www.google.com/maps/search/?api=1&query=<?php echo $geo[0] . ',' . $geo[1]; ?>" target="_blank" rel="noopener">Open in Google Maps ↗</a>
        <a class="btn ghost" href="<?php echo $e($wa('Hello, I want to visit Wellness City Lucknow and see plots. Please arrange a site visit.')); ?>" target="_blank" rel="noopener">Book a site visit</a>
      </div>
    </div>
    <div id="itmap" role="region" aria-label="Map of Wellness City Lucknow"></div>
  </div>
</section>

<section class="band" id="hindi" lang="hi">
  <div class="wrap">
    <div class="head"><span class="kicker">हिंदी में</span><h2>वेलनेस सिटी लखनऊ: अस्पताल ज़ोन के पास प्लॉट</h2>
      <p>LDA वेलनेस सिटी को "मेडी सिटी" के रूप में बना रहा है, जिसमें लगभग 150 एकड़ अस्पतालों और मेडिकल कॉलेज के लिए है। 30 जून 2026 की लैंड पूलिंग लॉटरी में 59 किसानों को 125 प्लॉट मिले, और इन्हीं में से <?php echo $list; ?> वर्ग मीटर के प्लॉट बिक्री के लिए हैं। LDA की प्रस्तावित दर ₹54,559.17 प्रति वर्ग मीटर (लगभग ₹5,100 प्रति वर्ग फुट) है, जो अभी अंतिम नहीं है।</p></div>
    <div class="grid3">
      <div class="card"><h3>धारा 11 और DM की अनुमति</h3><p>फेज़-1 की ज़मीन जून 2026 से धारा 11 में अधिसूचित है। हर ट्रांसफ़र से पहले जिलाधिकारी की लिखित अनुमति ज़रूरी है; हर प्लॉट की स्थिति हम कीमत के साथ बताते हैं।</p></div>
      <div class="card"><h3>आवंटन पत्र मिलाएं</h3><p>लॉटरी का आवंटन पत्र विक्रेता के अपने नाम हो, और प्लॉट का सेक्टर व नंबर LDA के लेआउट से मेल खाए, तभी आगे बढ़ें।</p></div>
      <div class="card"><h3>यह LDA की साइट नहीं है</h3><p>हम एक स्वतंत्र रीसेल सेवा हैं। LDA की अपनी योजनाओं और सूचनाओं के लिए सिर्फ ldalucknow.in देखें।</p></div>
    </div>
  </div>
</section>

<section class="band" id="faq">
  <div class="wrap faq">
    <div class="head"><span class="kicker">Questions</span><h2>Wellness City Lucknow: rate, sizes and rules</h2></div>
    <?php foreach ($faq as $q): ?><details><summary><?php echo $e($q[0]); ?></summary><p><?php echo $e($q[1]); ?></p></details><?php endforeach; ?>
  </div>
</section>

<section class="band" style="border-bottom:0">
  <div class="wrap"><div class="cta">
    <div><h2>Want a plot near the hospital zone?</h2><p>Send us the size and your budget. We reply with matching plots, their sector and their DM permission status.</p></div>
    <div class="acts"><a class="btn wa" href="<?php echo $e($wa('Hello, I want a Wellness City plot near the hospital zone. My size and budget:')); ?>" target="_blank" rel="noopener">Send size & budget</a>
      <a class="btn ghost" href="tel:+<?php echo $phone; ?>">Call <?php echo $e($phoneShow); ?></a></div>
  </div></div>
</section>
</main>

<footer class="foot"><div class="wrap">
  <p><strong>Wellness City Lucknow Plots</strong> · <?php echo $e($phoneShow); ?></p>
  <p>We help buyers and landowners with resale plots from the Wellness City land-pooling lottery. We do not work for, or speak for, the Lucknow Development Authority; its schemes, rates and notices are published only on <a href="https://ldalucknow.in/" target="_blank" rel="noopener" style="color:var(--navy2)">ldalucknow.in</a>. Rates on this page are LDA's proposed figures and may change. No transfer in phase 1 should be registered without the District Collector's written permission.</p>
</div></footer>

<div class="sticky-wa"><a class="btn wa" href="<?php echo $e($wa('Hello, please share Wellness City Lucknow plot sizes and prices.')); ?>" target="_blank" rel="noopener">WhatsApp for plot prices</a></div>

<script>
(function () {
  var el = document.getElementById('itmap');
  function go() {
    var map = L.map(el, { scrollWheelZoom: false }).setView([<?php echo $geo[0] . ', ' . $geo[1]; ?>], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);
    L.circle([<?php echo $geo[0] . ', ' . $geo[1]; ?>], { radius: 1500, color: '#3fb79a', weight: 2, dashArray: '6 6', fillColor: '#3fb79a', fillOpacity: .12 }).addTo(map);
    L.circleMarker([<?php echo $geo[0] . ', ' . $geo[1]; ?>], { radius: 9, color: '#fff', weight: 2, fillColor: '#0f3d36', fillOpacity: 1 })
      .addTo(map).bindPopup('<b>Wellness City Lucknow</b><br>Sultanpur Road – Kisan Path (approximate area)').openPopup();
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
