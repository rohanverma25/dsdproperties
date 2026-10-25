<?php
/*
 * saumitraviharlucknow.in — standalone resale-plot page (plain PHP, no Laravel). Redesigned 22 Oct 2026.
 * Independent seller page: never present it as the official UPAVP site.
 * To update stock, edit $plots below. 'status' => 'available' | 'hold' | 'sold'. Plot numbers stay private:
 * they go only into the WhatsApp message, so buyers enquire with us first.
 */
$site  = 'https://saumitraviharlucknow.in/';
$phone = '918595002933';
$phoneShow = '+91 85950 02933';
$updated = '22 October 2026';
$updatedIso = '2026-10-22';   // change both dates whenever $plots changes
$geo = [26.7243945, 81.0689648];
$sqft = function ($m) { return number_format($m * 10.7639); };

$plots = [
    // size m², sector, plot no., facing, road (m), location note, status
    [75,     '1A', '61',  'East',  6,  '',       'available'],
    [200,    '3B', '346', 'East',  9,  '',       'available'],
    [200,    '3B', '354', 'East',  9,  'Park',   'available'],
    [200,    '3C', '83',  'East',  24, '',       'available'],
    [122.23, '3C', '155', 'East',  9,  '',       'available'],
    [200,    '3B', '272', 'North', 9,  '',       'available'],
    [200,    '4B', '27',  'West',  9,  'Park',   'available'],
    [122.23, '3C', '158', 'East',  9,  '',       'available'],
    [122.23, '1C', '81',  'West',  18, '',       'available'],
    [122.23, '3C', '111', 'North', 9,  '',       'available'],
    [200,    '3B', '348', 'East',  9,  '',       'available'],
    [200,    '3B', '389', 'East',  9,  '',       'available'],
    [122.23, '1C', '79',  'West',  18, '',       'available'],
    [122.23, '5C', '9',   'West',  18, 'Corner', 'available'],
    [122.23, '3C', '363', 'East',  9,  '',       'available'],
    [122.23, '3C', '193', 'East',  9,  'Park',   'available'],
    [75,     '1A', '130', 'West',  9,  '',       'available'],
];
$e  = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$wa = function ($msg) use ($phone) { return 'https://wa.me/' . $phone . '?text=' . rawurlencode($msg); };
$fmt = function ($m) { return rtrim(rtrim(number_format($m, 2), '0'), '.'); };

$open   = array_filter($plots, function ($p) { return $p[6] !== 'sold'; });
$sizes  = array_values(array_unique(array_map(function ($p) { return $p[0]; }, $open))); sort($sizes);
$counts = [];
foreach ($open as $p) { $k = (string) $p[0]; $counts[$k] = ($counts[$k] ?? 0) + 1; }

$faq = [
    ['Are these Saumitra Vihar plots available right now?', 'Yes. The ' . count($open) . ' plots listed on this page were on offer for resale on ' . $updated . '. Resale plots sell quickly, so message us on WhatsApp to confirm a plot before you visit.'],
    ['What plot sizes are available in Saumitra Vihar?', 'This page lists resale plots of ' . implode(', ', array_map(function ($s) use ($fmt) { return $fmt($s) . ' m²'; }, $sizes)) . ', in sectors 1A, 1C, 3B, 3C, 4B and 5C. Each listing shows the facing, road width and whether it is park-facing or a corner plot.'],
    ['Why is the price not shown?', 'Each plot has its own asking price, which depends on size, road width, facing and park or corner position. Message us the plot reference and we will share the current price.'],
    ['Who is selling these plots?', 'These are resale plots from landowners who received developed plots in Saumitra Vihar under the land-pooling arrangement. You buy from the individual owner, and we help you check the papers before you pay.'],
    ['Is this the official Awas Vikas (UPAVP) website?', 'No. This is an independent resale plot service and is not linked to UP Awas Evam Vikas Parishad. Apply for any new UPAVP scheme only on upavp.in.'],
    ['What should I check before buying a resale plot here?', 'Ask for the allotment letter in the seller\'s name, the plot number on the layout, payment receipts, any dues to the Parishad, and the transfer rules that apply. Keep copies of everything before you pay any money.'],
];
?><!doctype html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Saumitra Vihar Plots for Sale, Lucknow | <?php echo count($open); ?> Resale Plots · 75, 122 & 200 m²</title>
<meta name="description" content="<?php echo count($open); ?> resale plots for sale in Saumitra Vihar Yojna, Lucknow: 75, 122.23 and 200 m², park-facing and corner plots, 9 to 24 m roads. See sector, facing and road width, then enquire on WhatsApp. सौमित्र विहार प्लॉट।">
<meta name="keywords" content="Saumitra Vihar plots, Saumitra Vihar plot for sale, Saumitra Vihar Lucknow, Saumitra Vihar Yojna resale plot, Soumitra Vihar plot, सौमित्र विहार प्लॉट, Awas Vikas plot Lucknow, plot near New Jail Road Lucknow">
<meta name="robots" content="index,follow,max-image-preview:large">
<meta name="theme-color" content="#173a2e">
<link rel="canonical" href="<?php echo $site; ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="Saumitra Vihar Plots Lucknow">
<meta property="og:title" content="Saumitra Vihar Plots for Sale, Lucknow | <?php echo count($open); ?> Resale Plots">
<meta property="og:description" content="75, 122.23 and 200 m² resale plots in Saumitra Vihar, Lucknow. Park-facing and corner options. Enquire on WhatsApp.">
<meta property="og:url" content="<?php echo $site; ?>">
<meta property="og:image" content="<?php echo $site; ?>og-image.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Saumitra Vihar resale plots for sale, Lucknow">
<meta name="twitter:card" content="summary_large_image">
<meta name="geo.region" content="IN-UP">
<meta name="geo.placename" content="Lucknow">
<meta name="geo.position" content="<?php echo $geo[0] . ';' . $geo[1]; ?>">
<meta name="ICBM" content="<?php echo $geo[0] . ', ' . $geo[1]; ?>">
<link rel="alternate" type="text/plain" href="<?php echo $site; ?>llms.txt" title="LLM summary">
<script type="application/ld+json">
<?php
$ld = [
  '@context' => 'https://schema.org',
  '@graph' => [
    ['@type' => 'WebSite', '@id' => $site . '#website', 'name' => 'Saumitra Vihar Plots Lucknow', 'url' => $site, 'inLanguage' => ['en-IN', 'hi-IN']],
    ['@type' => 'WebPage', '@id' => $site . '#webpage', 'url' => $site, 'name' => 'Saumitra Vihar plots for sale, Lucknow',
     'isPartOf' => ['@id' => $site . '#website'], 'about' => ['@id' => $site . '#place'], 'mainEntity' => ['@id' => $site . '#plots'],
     'dateModified' => $updatedIso, 'inLanguage' => 'en-IN', 'primaryImageOfPage' => $site . 'og-image.jpg'],
    ['@type' => 'Place', '@id' => $site . '#place', 'name' => 'Saumitra Vihar Yojna', 'alternateName' => ['Soumitra Vihar', 'सौमित्र विहार'],
     'description' => 'Residential plotted scheme of UP Awas Evam Vikas Parishad off New Jail Road (NH-230), Lucknow.',
     'geo' => ['@type' => 'GeoCoordinates', 'latitude' => $geo[0], 'longitude' => $geo[1]],
     'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'New Jail Road (NH-230)', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN']],
    ['@type' => 'RealEstateAgent', '@id' => $site . '#agent', 'name' => 'Saumitra Vihar Plots Lucknow', 'url' => $site, 'telephone' => '+' . $phone,
     'image' => $site . 'og-image.jpg', 'areaServed' => ['@id' => $site . '#place'],
     'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN']],
    ['@type' => 'ItemList', '@id' => $site . '#plots', 'name' => 'Resale plots in Saumitra Vihar, Lucknow', 'numberOfItems' => count($open),
     'itemListElement' => array_values(array_map(function ($p, $i) use ($fmt, $site, $sqft, $updatedIso) {
        return ['@type' => 'ListItem', 'position' => $i + 1, 'item' => ['@type' => 'Product',
          'name' => $fmt($p[0]) . ' m² ' . $p[3] . '-facing plot, Sector ' . $p[1] . ', Saumitra Vihar, Lucknow',
          'description' => $fmt($p[0]) . ' m² (' . $sqft($p[0]) . ' sq ft) residential resale plot in Sector ' . $p[1] . ', ' . $p[3] . '-facing, on a ' . $p[4] . ' m road' . ($p[5] ? ', ' . strtolower($p[5] === 'Park' ? 'park-facing' : $p[5]) : '') . '.',
          'category' => 'Residential plot', 'url' => $site . '#plot-' . ($i + 1),
          'offers' => ['@type' => 'Offer', 'availability' => $p[6] === 'hold' ? 'https://schema.org/LimitedAvailability' : 'https://schema.org/InStock',
                       'priceCurrency' => 'INR', 'validFrom' => $updatedIso, 'seller' => ['@id' => $site . '#agent'], 'areaServed' => ['@id' => $site . '#place']],
          'additionalProperty' => [
            ['@type' => 'PropertyValue', 'name' => 'Plot area', 'value' => $p[0], 'unitCode' => 'MTK'],
            ['@type' => 'PropertyValue', 'name' => 'Sector', 'value' => $p[1]],
            ['@type' => 'PropertyValue', 'name' => 'Facing', 'value' => $p[3]],
            ['@type' => 'PropertyValue', 'name' => 'Road width', 'value' => $p[4] . ' m']]]];
     }, array_values($open), array_keys(array_values($open))))],
    ['@type' => 'FAQPage', 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, $faq)],
  ],
];
echo json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Layout: a calm "land registry" feel — forest green, survey-paper cream, brass accents; listings read like plot cards on a site map */
:root{--forest:#173a2e;--forest2:#215240;--leaf:#2f7a5b;--cream:#f7f4ec;--paper:#fffdf8;--ink:#1d2621;--muted:#5f6b63;--line:#e4e0d4;--brass:#b9852f;--brass-soft:#f6ecd8;--park:#2f7a5b;--corner:#b9852f;--wide:#2563eb;--disp:'Poppins',system-ui,-apple-system,'Segoe UI',Arial,sans-serif;--body:'Poppins',system-ui,-apple-system,'Segoe UI',Arial,sans-serif}
*{box-sizing:border-box}html{scroll-behavior:smooth;scroll-padding-top:76px}
body{margin:0;background:var(--cream);color:var(--ink);font:16px/1.65 var(--body);-webkit-font-smoothing:antialiased}
a{color:inherit}img{max-width:100%}
.wrap{width:min(1160px,100%);margin:0 auto;padding-left:max(18px,env(safe-area-inset-left,0px));padding-right:max(18px,env(safe-area-inset-right,0px))}
h1,h2,h3{font-family:var(--disp);font-weight:700;letter-spacing:-.01em;line-height:1.12;text-wrap:balance;margin:0}
.kicker{font-size:12px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--brass)}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 20px;border-radius:12px;border:1.5px solid var(--forest);background:var(--forest);color:#fff;font-weight:700;font-size:15px;text-decoration:none;cursor:pointer;transition:transform .15s,background .15s}
.btn:hover{background:var(--forest2);transform:translateY(-1px)}
.btn.ghost{background:transparent;color:var(--forest)}.btn.ghost:hover{background:#ebefe8}
.btn.wa{background:#1fa855;border-color:#1fa855}.btn.wa:hover{background:#178a45}
.btn svg{flex:none}
:focus-visible{outline:3px solid var(--brass);outline-offset:3px}

/* top bar */
.top{position:sticky;top:0;z-index:20;background:rgba(247,244,236,.92);backdrop-filter:blur(10px);border-bottom:1px solid var(--line)}
.top .wrap{display:flex;align-items:center;justify-content:space-between;gap:16px;min-height:66px}
.brand{display:flex;align-items:center;gap:10px;text-decoration:none;font-weight:800;color:var(--forest)}
.brand i{width:34px;height:34px;border-radius:10px;background:var(--forest);display:grid;place-items:center}
.brand small{display:block;font-weight:600;font-size:11.5px;color:var(--muted);letter-spacing:.02em}
.top nav{display:flex;gap:22px;align-items:center;font-size:14.5px;font-weight:600}
.top nav a{text-decoration:none}.top nav a:hover{color:var(--leaf)}
@media(max-width:820px){.top nav a.hide{display:none}}

/* hero */
.hero{position:relative;overflow:hidden;background:var(--forest);color:#fff}
.hero:before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.06) 1px,transparent 1px);background-size:44px 44px;mask-image:linear-gradient(90deg,transparent,#000 60%)}
.hero .wrap{position:relative;display:grid;grid-template-columns:minmax(0,1.25fr) minmax(0,1fr);gap:40px;align-items:center;padding-top:64px;padding-bottom:64px}
.hero h1{font-size:clamp(36px,5.4vw,62px);margin:14px 0 16px}
.hero h1 em{font-style:normal;color:#f2d29b}
.hero p.lead{font-size:18px;color:#d9e6de;max-width:600px;margin:0 0 26px}
.hero .hi{font-size:15px;color:#b9d0c2;margin:-14px 0 24px}
.hero .acts{display:flex;flex-wrap:wrap;gap:12px}
.hero .btn.ghost{color:#fff;border-color:rgba(255,255,255,.45)}.hero .btn.ghost:hover{background:rgba(255,255,255,.08)}
.stats{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.stat{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.14);border-radius:16px;padding:18px}
.stat b{display:block;font-family:var(--disp);font-size:34px;line-height:1;color:#f2d29b;font-variant-numeric:tabular-nums}
.stat span{font-size:13.5px;color:#d0dfd5}
.note-strip{background:var(--brass-soft);border-bottom:1px solid #ead9b5;color:#6b4f1d;font-size:13.5px}
.note-strip .wrap{padding-top:10px;padding-bottom:10px}
@media(max-width:860px){.hero .wrap{grid-template-columns:1fr;padding-top:44px;padding-bottom:44px}}

/* sections */
section.band{padding:64px 0;border-bottom:1px solid var(--line)}
.head{max-width:720px;margin-bottom:26px}.head h2{font-size:clamp(28px,3.8vw,42px);margin:8px 0 10px}.head p{color:var(--muted);margin:0}

/* filters */
.filters{position:sticky;top:66px;z-index:10;background:var(--cream);padding:12px 0;margin-bottom:16px;border-bottom:1px solid var(--line);display:flex;flex-wrap:wrap;gap:16px;align-items:center}
.fgroup{display:flex;flex-wrap:wrap;gap:6px;align-items:center}
.fgroup > span{font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-right:4px}
.chip{border:1.5px solid var(--line);background:var(--paper);border-radius:999px;padding:7px 13px;font:600 13.5px var(--body);color:#3b463f;cursor:pointer}
.chip.on{background:var(--forest);border-color:var(--forest);color:#fff}
.count{margin-left:auto;font-size:14px;color:var(--muted)}.count b{color:var(--forest)}
@media(max-width:700px){.filters{position:static;gap:10px}.count{margin-left:0;width:100%}}

/* plot cards */
.plots{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px}
.plot{position:relative;background:var(--paper);border:1px solid var(--line);border-radius:18px;overflow:hidden;display:flex;flex-direction:column;transition:transform .18s,box-shadow .18s}
.plot:hover{transform:translateY(-3px);box-shadow:0 14px 34px rgba(23,58,46,.12)}
.plot .sketch{background:#eef1e8;border-bottom:1px solid var(--line);aspect-ratio:2/1;max-width:100%}
.plot .sketch svg{display:block;width:100%;height:100%}.plot .sketch .rt{font:700 11px var(--body);fill:#4b4535;letter-spacing:.06em}.plot .sketch .st{font:700 15px var(--body);fill:#173a2e}.plot .sketch .pt{font:800 10px var(--body);fill:#2f6b46;letter-spacing:.1em}.plot .sketch .nt{font:800 7px var(--body);fill:#173a2e}
.plot .badges{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:10px}.plot .ref{font-size:11.5px;font-weight:800;letter-spacing:.08em;background:var(--cream);border:1px solid var(--line);border-radius:999px;padding:3px 10px;color:var(--forest)}
.tag{display:inline-flex;align-items:center}
.tag{font-size:11px;font-weight:800;letter-spacing:.04em;text-transform:uppercase;color:#fff;border-radius:6px;padding:3px 7px}
.tag.park{background:var(--park)}.tag.corner{background:var(--corner)}.tag.wide{background:var(--wide)}.tag.hold{background:#9a3412}
.plot .body{padding:16px 16px 6px}
.plot h3{font-size:28px;color:var(--forest);display:flex;align-items:baseline;gap:8px}
.plot h3 small{font-family:var(--body);font-size:14px;font-weight:600;color:var(--muted);letter-spacing:0}
.specs{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:14px 0 4px}
.specs div{background:var(--cream);border-radius:10px;padding:8px 10px;font-size:12px;color:var(--muted);line-height:1.3}
.specs strong{display:block;font-size:15px;color:var(--ink)}
.plot .go{padding:12px 16px 16px;margin-top:auto}
.plot .go .btn{width:100%;padding:12px}
.empty{display:none;background:var(--paper);border:1px dashed var(--line);border-radius:16px;padding:26px;text-align:center;color:var(--muted)}

/* facts box + table */
.facts{background:var(--paper);border:1px solid var(--line);border-radius:18px;padding:24px}
.facts h2{font-size:clamp(22px,3vw,28px);margin:0 0 14px;color:var(--forest)}
.facts dl{margin:0;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0 28px}
.facts dl div{display:grid;grid-template-columns:150px minmax(0,1fr);gap:12px;padding:10px 0;border-bottom:1px solid var(--line)}
.facts dt{font-size:13px;font-weight:700;color:var(--muted)}.facts dd{margin:0;font-size:14.5px}
@media(max-width:820px){.facts dl{grid-template-columns:1fr}.facts dl div{grid-template-columns:120px minmax(0,1fr)}}
.fulllist{margin-top:18px;background:var(--paper);border:1px solid var(--line);border-radius:14px;padding:4px 16px}
.fulllist summary{cursor:pointer;font-weight:700;padding:12px 0;color:var(--forest)}
.fulllist table{width:100%;border-collapse:collapse;min-width:560px;font-size:14px;margin-bottom:14px}
.fulllist caption{text-align:left;font-size:13px;color:var(--muted);padding-bottom:8px}
.fulllist th{text-align:left;background:var(--forest);color:#fff;padding:9px 10px}
.fulllist td{padding:9px 10px;border-bottom:1px solid var(--line);font-variant-numeric:tabular-nums}

/* why / steps */
.grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
@media(max-width:820px){.grid3{grid-template-columns:1fr}}
.card{background:var(--paper);border:1px solid var(--line);border-radius:16px;padding:22px}
.card h3{font-size:21px;margin:8px 0 8px;color:var(--forest)}.card p{margin:0;color:var(--muted);font-size:15px}
.card .n{font:800 12px var(--body);letter-spacing:.12em;color:var(--brass)}

/* location */
.loc{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:28px;align-items:start}
@media(max-width:860px){.loc{grid-template-columns:1fr}}
#svmap{height:360px;border-radius:16px;border:1px solid var(--line);background:#e7ece3}
.dist{list-style:none;padding:0;margin:16px 0 0}.dist li{display:flex;justify-content:space-between;padding:11px 0;border-bottom:1px solid var(--line);font-size:15px}.dist b{font-variant-numeric:tabular-nums}

/* faq */
.faq{max-width:840px}.faq details{background:var(--paper);border:1px solid var(--line);border-radius:14px;padding:4px 18px;margin-bottom:10px}
.faq summary{cursor:pointer;font-weight:700;padding:14px 0;list-style:none;display:flex;justify-content:space-between;gap:12px}
.faq summary::-webkit-details-marker{display:none}.faq summary:after{content:"+";font-size:20px;color:var(--brass)}.faq details[open] summary:after{content:"–"}
.faq details p{margin:0 0 14px;color:var(--muted)}

/* cta + footer */
.cta{background:var(--forest);color:#fff;border-radius:22px;padding:34px;display:flex;flex-wrap:wrap;gap:20px;justify-content:space-between;align-items:center}
.cta h2{font-size:clamp(26px,3.4vw,36px)}.cta p{margin:6px 0 0;color:#cfe0d6}
.cta .acts{display:flex;flex-wrap:wrap;gap:10px}
.cta .btn.ghost{color:#fff;border-color:rgba(255,255,255,.45)}
.foot{padding:34px 0 110px;color:var(--muted);font-size:13.5px}.foot p{margin:6px 0}
.sticky-wa{position:fixed;left:0;right:0;bottom:0;z-index:30;display:none;padding:10px max(14px,env(safe-area-inset-right,0px)) calc(10px + env(safe-area-inset-bottom,0px)) max(14px,env(safe-area-inset-left,0px));background:#fff;border-top:1px solid var(--line);box-shadow:0 -6px 18px rgba(0,0,0,.08)}
.sticky-wa .btn{width:100%}
@media(max-width:820px){.sticky-wa{display:block}}
@media(prefers-reduced-motion:reduce){*{transition:none!important;scroll-behavior:auto!important}}
</style>
</head>
<body>

<header class="top">
  <div class="wrap">
    <a class="brand" href="#top" aria-label="Saumitra Vihar Plots Lucknow, home">
      <i><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f2d29b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V9l7-5 7 5v12"/><path d="M9 21v-6h6v6"/></svg></i>
      <span>Saumitra Vihar Plots<small>Resale plots · Lucknow</small></span>
    </a>
    <nav aria-label="Main">
      <a class="hide" href="#plots">Plots</a>
      <a class="hide" href="#location">Location</a>
      <a class="hide" href="#faq">FAQ</a>
      <a class="btn wa" style="padding:9px 14px;font-size:14px" href="<?php echo $e($wa('Hello, please share the available Saumitra Vihar resale plots and prices.')); ?>" target="_blank" rel="noopener">WhatsApp</a>
    </nav>
  </div>
</header>

<section class="hero" id="top">
  <div class="wrap">
    <div>
      <span class="kicker">Saumitra Vihar Yojna · Lucknow</span>
      <h1>Saumitra Vihar plots for sale, <em>ready to choose.</em></h1>
      <p class="lead"><?php echo count($open); ?> resale plots of <?php echo implode(', ', array_map(function ($s) use ($fmt) { return $fmt($s); }, $sizes)); ?> m², with the sector, facing and road width shown for each. Pick a plot you like and get its price on WhatsApp.</p>
      <p class="hi">सौमित्र विहार में रीसेल प्लॉट — साइज़, सेक्टर, फेसिंग और सड़क की चौड़ाई के साथ।</p>
      <div class="acts">
        <a class="btn" href="#plots" style="background:#f2d29b;border-color:#f2d29b;color:#173a2e">See all <?php echo count($open); ?> plots ↓</a>
        <a class="btn ghost" href="<?php echo $e($wa('Hello, I want to buy a plot in Saumitra Vihar. Please share options and prices.')); ?>" target="_blank" rel="noopener">Ask on WhatsApp</a>
      </div>
    </div>
    <div class="stats" aria-label="Listing summary">
      <div class="stat"><b><?php echo count($open); ?></b><span>plots on offer now</span></div>
      <div class="stat"><b><?php echo count(array_filter($open, function ($p) { return $p[5] !== ''; })); ?></b><span>park-facing or corner</span></div>
      <div class="stat"><b><?php echo $fmt(min($sizes)); ?>–<?php echo $fmt(max($sizes)); ?></b><span>m² plot sizes</span></div>
      <div class="stat"><b><?php echo min(array_column($open, 4)); ?>–<?php echo max(array_column($open, 4)); ?> m</b><span>road widths</span></div>
    </div>
  </div>
</section>
<div class="note-strip"><div class="wrap">Listing updated <strong><?php echo $updated; ?></strong>. This is an independent resale service and is not the official Awas Vikas (UPAVP) website.</div></div>

<main>
<?php /* Plain, quotable facts: search engines and AI answer engines lift sentences like these directly. */ ?>
<section class="band" id="facts" style="padding:44px 0">
  <div class="wrap">
    <div class="facts">
      <h2>Saumitra Vihar plots at a glance</h2>
      <dl>
        <div><dt>Scheme</dt><dd>Saumitra Vihar Yojna, a residential plotted scheme of UP Awas Evam Vikas Parishad (UPAVP)</dd></div>
        <div><dt>Location</dt><dd>Off New Jail Road (NH-230), south-east Lucknow, about 18 km from Hazratganj</dd></div>
        <div><dt>Resale plots on offer</dt><dd><?php echo count($open); ?> plots as of <?php echo $updated; ?></dd></div>
        <div><dt>Plot sizes</dt><dd><?php echo implode(' · ', array_map(function ($s) use ($fmt, $sqft, $counts) { return $fmt($s) . ' m² (' . $sqft($s) . ' sq ft): ' . $counts[(string) $s] . ' plots'; }, $sizes)); ?></dd></div>
        <div><dt>Sectors</dt><dd><?php echo implode(', ', array_values(array_unique(array_column($open, 1)))); ?></dd></div>
        <div><dt>Road widths</dt><dd><?php echo implode(', ', array_map(function ($r) { return $r . ' m'; }, (function ($r) { sort($r); return $r; })(array_values(array_unique(array_column($open, 4)))))); ?></dd></div>
        <div><dt>Special plots</dt><dd><?php echo count(array_filter($open, function ($p) { return $p[5] === 'Park'; })); ?> park-facing, <?php echo count(array_filter($open, function ($p) { return $p[5] === 'Corner'; })); ?> corner, <?php echo count(array_filter($open, function ($p) { return $p[4] >= 18; })); ?> on 18–24 m roads</dd></div>
        <div><dt>Type of sale</dt><dd>Resale by landowners who received developed plots under land pooling; price shared on enquiry</dd></div>
      </dl>
    </div>
  </div>
</section>
<section class="band" id="plots">
  <div class="wrap">
    <div class="head">
      <span class="kicker">Available now</span>
      <h2>Choose your plot</h2>
      <p>Filter by size, facing or position. Each plot card has its own WhatsApp button, so we know exactly which one you mean.</p>
    </div>

    <div class="filters" role="group" aria-label="Filter plots">
      <div class="fgroup" data-f="size"><span>Size</span>
        <button type="button" class="chip on" data-v="all">All</button>
        <?php foreach ($sizes as $s): ?><button type="button" class="chip" data-v="<?php echo $e($s); ?>"><?php echo $fmt($s); ?> m² (<?php echo $counts[(string) $s]; ?>)</button><?php endforeach; ?>
      </div>
      <div class="fgroup" data-f="face"><span>Facing</span>
        <button type="button" class="chip on" data-v="all">All</button>
        <?php foreach (array_values(array_unique(array_column($open, 3))) as $f): ?><button type="button" class="chip" data-v="<?php echo $e($f); ?>"><?php echo $e($f); ?></button><?php endforeach; ?>
      </div>
      <div class="fgroup" data-f="pos"><span>Position</span>
        <button type="button" class="chip on" data-v="all">All</button>
        <button type="button" class="chip" data-v="Park">Park-facing</button>
        <button type="button" class="chip" data-v="Corner">Corner</button>
        <button type="button" class="chip" data-v="wide">18 m+ road</button>
      </div>
      <div class="count" aria-live="polite"><b id="shown"><?php echo count($open); ?></b> plots shown</div>
    </div>

    <div class="plots" id="plotgrid">
      <?php $i = 0; foreach ($plots as $p): if ($p[6] === 'sold') continue; $i++;
        [$size, $sector, $no, $face, $road, $note, $status] = $p;
        $ref = 'SV-' . str_pad($i, 2, '0', STR_PAD_LEFT);
        $msg = "Hello, I'm interested in plot $ref in Saumitra Vihar: " . $fmt($size) . " m² (" . $sqft($size) . " sq ft), Sector $sector, plot no. $no, $face-facing, $road m road" . ($note ? ", $note" : '') . ". Please share the price and documents.";
        // Site sketch (300×150, never cropped): the road runs along the facing side with its width written on it;
        // a park sits on the far side; a corner plot gets a second road along the bottom; N marks north.
        $sk = (function ($face, $road, $note, $sizeLabel) {
            $W = 300; $H = 150; $R = 34;               // road strip thickness
            $px = 14; $py = 14; $pw = $W - 28; $ph = $H - 28;   // free area for the plot
            $out = '';
            $roadTxt = $road . ' m ROAD';
            $strip = function ($side) use ($W, $H, $R, $roadTxt) {
                $fill = '#d8d3c4'; $dash = '#ffffff';
                if ($side === 'right')  return "<rect x='" . ($W - $R) . "' y='0' width='$R' height='$H' fill='$fill'/><line x1='" . ($W - $R / 2) . "' y1='8' x2='" . ($W - $R / 2) . "' y2='" . ($H - 8) . "' stroke='$dash' stroke-width='2' stroke-dasharray='9 8'/><text x='" . ($W - $R / 2) . "' y='" . ($H / 2) . "' transform='rotate(90 " . ($W - $R / 2) . " " . ($H / 2) . ")' text-anchor='middle' dominant-baseline='middle' class='rt'>$roadTxt</text>";
                if ($side === 'left')   return "<rect x='0' y='0' width='$R' height='$H' fill='$fill'/><line x1='" . ($R / 2) . "' y1='8' x2='" . ($R / 2) . "' y2='" . ($H - 8) . "' stroke='$dash' stroke-width='2' stroke-dasharray='9 8'/><text x='" . ($R / 2) . "' y='" . ($H / 2) . "' transform='rotate(-90 " . ($R / 2) . " " . ($H / 2) . ")' text-anchor='middle' dominant-baseline='middle' class='rt'>$roadTxt</text>";
                if ($side === 'top')    return "<rect x='0' y='0' width='$W' height='$R' fill='$fill'/><line x1='8' y1='" . ($R / 2) . "' x2='" . ($W - 8) . "' y2='" . ($R / 2) . "' stroke='$dash' stroke-width='2' stroke-dasharray='9 8'/><text x='" . ($W / 2) . "' y='" . ($R / 2) . "' text-anchor='middle' dominant-baseline='middle' class='rt' style='paint-order:stroke' stroke='#d8d3c4' stroke-width='6'>$roadTxt</text>";
                return "<rect x='0' y='" . ($H - $R) . "' width='$W' height='$R' fill='$fill'/><text x='" . ($W / 2) . "' y='" . ($H - $R / 2) . "' text-anchor='middle' dominant-baseline='middle' class='rt'>ROAD</text>";
            };
            $side = ['East' => 'right', 'West' => 'left', 'North' => 'top', 'South' => 'bottom'][$face] ?? 'bottom';
            // park on the opposite side
            if ($note === 'Park') {
                $opp = ['right' => 'left', 'left' => 'right', 'top' => 'bottom', 'bottom' => 'top'][$side];
                $pk = ['left' => [0, 0, 70, $H], 'right' => [$W - 70, 0, 70, $H], 'top' => [0, 0, $W, 42], 'bottom' => [0, $H - 42, $W, 42]][$opp];
                $out .= "<rect x='{$pk[0]}' y='{$pk[1]}' width='{$pk[2]}' height='{$pk[3]}' fill='#cfe5c4'/>";
                $cx = $pk[0] + $pk[2] / 2; $cy = $pk[1] + $pk[3] / 2;
                $out .= "<circle cx='" . ($cx - 14) . "' cy='" . ($cy - 10) . "' r='9' fill='#8cc08a'/><circle cx='" . ($cx + 12) . "' cy='" . ($cy + 8) . "' r='11' fill='#7db57c'/>";
                $out .= "<text x='$cx' y='" . ($pk[1] + $pk[3] - 8) . "' text-anchor='middle' class='pt'>PARK</text>";
                if ($opp === 'left')   { $px += 70; $pw -= 70; }
                if ($opp === 'right')  { $pw -= 70; }
                if ($opp === 'top')    { $py += 42; $ph -= 42; }
                if ($opp === 'bottom') { $ph -= 42; }
            }
            $out .= $strip($side);
            if ($side === 'right') $pw -= $R; if ($side === 'left') { $px += $R; $pw -= $R; }
            if ($side === 'top') { $py += $R; $ph -= $R; } if ($side === 'bottom') $ph -= $R;
            if ($note === 'Corner') { $out .= $strip('bottom'); $ph -= $R; }
            // plot box, centred in the free area
            $bw = min($pw - 16, 140); $bh = min($ph - 16, 74);
            $bx = $px + ($pw - $bw) / 2; $by = $py + ($ph - $bh) / 2;
            $out .= "<rect x='$bx' y='$by' width='$bw' height='$bh' rx='4' fill='#fffdf8' stroke='#173a2e' stroke-width='2.5'/>";
            $out .= "<text x='" . ($bx + $bw / 2) . "' y='" . ($by + $bh / 2) . "' text-anchor='middle' dominant-baseline='middle' class='st'>$sizeLabel</text>";
            // "front" tick on the road side of the plot
            $f = ['right' => [$bx + $bw, $by + 12, $bx + $bw, $by + $bh - 12], 'left' => [$bx, $by + 12, $bx, $by + $bh - 12],
                  'top' => [$bx + 12, $by, $bx + $bw - 12, $by], 'bottom' => [$bx + 12, $by + $bh, $bx + $bw - 12, $by + $bh]][$side];
            $out .= "<line x1='{$f[0]}' y1='{$f[1]}' x2='{$f[2]}' y2='{$f[3]}' stroke='#b9852f' stroke-width='5' stroke-linecap='round'/>";
            // north arrow, placed in a corner that is free
            $nx = $side === 'left' ? $W - 22 : ($note === 'Park' && $side === 'right' ? $W - $R - 18 : 22);
            if ($note === 'Park' && $side === 'right') $nx = 82;
            $ny = $side === 'top' ? $R + 18 : 22;
            if ($note === 'Park' && $side === 'bottom') $ny = 58;
            $out .= "<g transform='translate($nx $ny)'><circle r='12' fill='#fffdf8' stroke='#cfc9b8'/><path d='M0 -8 L4 3 L0 0 L-4 3 Z' fill='#173a2e'/><text y='8.5' text-anchor='middle' class='nt'>N</text></g>";
            return "<svg viewBox='0 0 $W $H' preserveAspectRatio='xMidYMid meet' role='img'>$out</svg>";
        })($face, (int) $road, $note, $fmt($size) . ' m²');
      ?>
      <article class="plot" id="plot-<?php echo $i; ?>" data-size="<?php echo $e($size); ?>" data-face="<?php echo $e($face); ?>" data-pos="<?php echo $e($note); ?>" data-road="<?php echo (int) $road; ?>">
        <div class="sketch" aria-hidden="true"><?php echo $sk; ?></div>
        <div class="body">
          <div class="badges">
            <span class="ref"><?php echo $ref; ?></span>
            <?php if ($note === 'Park'): ?><span class="tag park">Park-facing</span><?php endif; ?>
            <?php if ($note === 'Corner'): ?><span class="tag corner">Corner</span><?php endif; ?>
            <?php if ($road >= 18): ?><span class="tag wide"><?php echo (int) $road; ?> m wide road</span><?php endif; ?>
            <?php if ($status === 'hold'): ?><span class="tag hold">On hold</span><?php endif; ?>
          </div>
          <h3><?php echo $fmt($size); ?> m² <small><?php echo $sqft($size); ?> sq ft</small></h3>
          <div class="specs">
            <div><strong><?php echo $e($sector); ?></strong>sector</div>
            <div><strong><?php echo $e($face); ?></strong>facing</div>
            <div><strong><?php echo (int) $road; ?> m</strong>road</div>
          </div>
        </div>
        <div class="go"><a class="btn wa" href="<?php echo $e($wa($msg)); ?>" target="_blank" rel="noopener"><svg width="17" height="17" viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.3 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.4-.7-2.8-1.1-4.6-4-4.8-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2.1 1-2.4c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .6l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.3 2.4 1.5.3.1.5.1.7-.1l.9-1.1c.2-.3.4-.2.7-.1l2 1c.3.1.5.2.6.3.1.2.1.7-.1 1.3z"/></svg>Get price for <?php echo $ref; ?></a></div>
      </article>
      <?php endforeach; ?>
    </div>
    <details class="fulllist">
      <summary>See all <?php echo count($open); ?> plots as a table</summary>
      <div style="overflow-x:auto">
        <table>
          <caption>Saumitra Vihar resale plots available on <?php echo $updated; ?></caption>
          <thead><tr><th>Ref</th><th>Size</th><th>Sector</th><th>Facing</th><th>Road</th><th>Position</th></tr></thead>
          <tbody>
          <?php $j = 0; foreach ($plots as $p): if ($p[6] === 'sold') continue; $j++; ?>
            <tr><td>SV-<?php echo str_pad($j, 2, '0', STR_PAD_LEFT); ?></td><td><?php echo $fmt($p[0]); ?> m² (<?php echo $sqft($p[0]); ?> sq ft)</td><td><?php echo $e($p[1]); ?></td><td><?php echo $e($p[3]); ?></td><td><?php echo (int) $p[4]; ?> m</td><td><?php echo $p[5] ? $e($p[5] === 'Park' ? 'Park-facing' : $p[5]) : '—'; ?></td></tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </details>
    <div class="empty" id="empty">No plot matches these filters. <a href="<?php echo $e($wa('Hello, I am looking for a Saumitra Vihar plot that is not on your list. My requirement:')); ?>" target="_blank" rel="noopener" style="color:var(--leaf);font-weight:700">Tell us what you need on WhatsApp →</a></div>
  </div>
</section>

<section class="band" id="why">
  <div class="wrap">
    <div class="head"><span class="kicker">Buying a resale plot</span><h2>How it works</h2><p>These plots belong to landowners who received developed plots in Saumitra Vihar under land pooling. You buy from the owner; we handle the search, the paperwork check and the coordination.</p></div>
    <div class="grid3">
      <div class="card"><span class="n">STEP 1</span><h3>Pick a plot</h3><p>Choose by size, facing, road width and position. Tap "Get price" and we reply with the asking price.</p></div>
      <div class="card"><span class="n">STEP 2</span><h3>See it and its papers</h3><p>We arrange a site visit and share the allotment letter, layout position and payment receipts for that plot.</p></div>
      <div class="card"><span class="n">STEP 3</span><h3>Check, then pay</h3><p>Pay only after the papers match the plot and the transfer rules are clear. Keep copies of everything.</p></div>
    </div>
  </div>
</section>

<section class="band" id="location">
  <div class="wrap loc">
    <div>
      <span class="kicker">Location</span>
      <h2 style="font-size:clamp(28px,3.8vw,42px);margin:8px 0 12px">Where Saumitra Vihar is</h2>
      <p style="color:var(--muted);margin:0">Saumitra Vihar is UP Awas Evam Vikas Parishad's residential scheme off New Jail Road (NH-230) in south-east Lucknow, near the Sharda canal. The scheme plan has internal roads of 9, 12, 18 and 24 m.</p>
      <ul class="dist">
        <li>Hazratganj <b>≈ 18.3 km</b></li>
        <li>Charbagh railway station <b>≈ 18.5 km</b></li>
        <li>Lucknow airport <b>≈ 17.9 km</b></li>
      </ul>
      <p style="font-size:13px;color:var(--muted)">Straight-line distances from the scheme centre; road distances are longer.</p>
      <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:14px">
        <a class="btn" href="https://www.google.com/maps/search/?api=1&query=26.7243945,81.0689648" target="_blank" rel="noopener">Open in Google Maps ↗</a>
        <a class="btn ghost" href="<?php echo $e($wa('Hello, I want to visit Saumitra Vihar and see the available plots. Please arrange a site visit.')); ?>" target="_blank" rel="noopener">Book a site visit</a>
      </div>
    </div>
    <div id="svmap" role="region" aria-label="Map of Saumitra Vihar"></div>
  </div>
</section>

<section class="band" id="hindi" lang="hi">
  <div class="wrap">
    <div class="head"><span class="kicker">हिंदी में</span><h2>सौमित्र विहार, लखनऊ में प्लॉट खरीदें</h2>
      <p>सौमित्र विहार योजना (उत्तर प्रदेश आवास एवं विकास परिषद) में <?php echo count($open); ?> रीसेल प्लॉट उपलब्ध हैं: <?php echo implode(', ', array_map(function ($s) use ($fmt) { return $fmt($s); }, $sizes)); ?> वर्ग मीटर। हर प्लॉट का सेक्टर, फेसिंग और सड़क की चौड़ाई (<?php echo min(array_column($open, 4)); ?> से <?php echo max(array_column($open, 4)); ?> मीटर) ऊपर दी गई है। पार्क फेसिंग और कॉर्नर प्लॉट भी हैं। कीमत के लिए प्लॉट का रेफरेंस (जैसे SV-03) WhatsApp पर भेजें।</p>
    </div>
    <div class="grid3">
      <div class="card"><h3>कौन बेच रहा है?</h3><p>ये प्लॉट उन भू-स्वामियों के हैं जिन्हें लैंड पूलिंग में विकसित प्लॉट मिले हैं। खरीद सीधे प्लॉट मालिक से होती है।</p></div>
      <div class="card"><h3>पैसे देने से पहले</h3><p>विक्रेता के नाम आवंटन पत्र, लेआउट में प्लॉट नंबर, भुगतान रसीदें और परिषद के बकाया की जांच करें।</p></div>
      <div class="card"><h3>क्या यह सरकारी साइट है?</h3><p>नहीं। यह एक स्वतंत्र रीसेल सेवा है। नई योजना में आवेदन सिर्फ upavp.in पर होता है।</p></div>
    </div>
  </div>
</section>

<section class="band" id="faq">
  <div class="wrap faq">
    <div class="head"><span class="kicker">Questions</span><h2>Saumitra Vihar plots: common questions</h2></div>
    <?php foreach ($faq as $q): ?><details><summary><?php echo $e($q[0]); ?></summary><p><?php echo $e($q[1]); ?></p></details><?php endforeach; ?>
  </div>
</section>

<section class="band" style="border-bottom:0">
  <div class="wrap">
    <div class="cta">
      <div><h2>Found a plot you like?</h2><p>Send us its reference (like SV-03) and get the price, papers and a site visit.</p></div>
      <div class="acts">
        <a class="btn wa" href="<?php echo $e($wa('Hello, I want to buy a plot in Saumitra Vihar. Please share options and prices.')); ?>" target="_blank" rel="noopener">WhatsApp us</a>
        <a class="btn ghost" href="tel:+<?php echo $phone; ?>">Call <?php echo $e($phoneShow); ?></a>
      </div>
    </div>
  </div>
</section>
</main>

<footer class="foot">
  <div class="wrap">
    <p><strong>Saumitra Vihar Plots · Lucknow</strong> · <?php echo $e($phoneShow); ?></p>
    <p>An independent resale plot service. Not affiliated with, or endorsed by, UP Awas Evam Vikas Parishad (UPAVP). New scheme registration and allotment are handled only by UPAVP on <a href="https://upavp.in/" target="_blank" rel="noopener" style="color:var(--leaf)">upavp.in</a>. Availability and prices change; confirm the plot, seller records and transfer terms before paying.</p>
  </div>
</footer>

<div class="sticky-wa"><a class="btn wa" href="<?php echo $e($wa('Hello, please share the available Saumitra Vihar resale plots and prices.')); ?>" target="_blank" rel="noopener">WhatsApp for plot prices</a></div>

<script>
(function () {
  // Filters
  var state = { size: 'all', face: 'all', pos: 'all' };
  var cards = document.querySelectorAll('.plot'), shown = document.getElementById('shown'), empty = document.getElementById('empty');
  function apply() {
    var n = 0;
    cards.forEach(function (c) {
      var ok = (state.size === 'all' || c.dataset.size === state.size)
        && (state.face === 'all' || c.dataset.face === state.face)
        && (state.pos === 'all' || (state.pos === 'wide' ? +c.dataset.road >= 18 : c.dataset.pos === state.pos));
      c.hidden = !ok; if (ok) n++;
    });
    shown.textContent = n; empty.style.display = n ? 'none' : 'block';
  }
  document.querySelectorAll('.fgroup').forEach(function (g) {
    g.querySelectorAll('.chip').forEach(function (b) {
      b.addEventListener('click', function () {
        g.querySelectorAll('.chip').forEach(function (x) { x.classList.remove('on'); });
        b.classList.add('on'); state[g.dataset.f] = b.dataset.v; apply();
      });
    });
  });

  // Location map (Leaflet, loaded only when scrolled near)
  var el = document.getElementById('svmap');
  function go() {
    var map = L.map(el, { scrollWheelZoom: false }).setView([26.7243945, 81.0689648], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);
    L.circle([26.7243945, 81.0689648], { radius: 900, color: '#b9852f', weight: 2, dashArray: '6 6', fillColor: '#2f7a5b', fillOpacity: .12 }).addTo(map);
    L.circleMarker([26.7243945, 81.0689648], { radius: 9, color: '#fff', weight: 2, fillColor: '#173a2e', fillOpacity: 1 })
      .addTo(map).bindPopup('<b>Saumitra Vihar Yojna</b><br>Approximate scheme area').openPopup();
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
