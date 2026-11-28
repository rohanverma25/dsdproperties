<?php
/*
 * itcitylucknow.com — standalone sales page (plain PHP, no Laravel). Built 24 Nov 2026.
 * Sells two things in LDA's IT City (Sultanpur Road): (A) developed plots already allotted to land-pooling farmers (resale),
 * (B) farm land inside the scheme villages that goes into land pooling (buyer files the land-pooling affidavit).
 * Independent seller page: never present it as the official LDA site, never mention any other brand.
 * lucknowitcity.in was merged into this site on 28 Nov 2026 (301 redirect via its .htaccess): this is the only IT City sales domain.
 * Keep it on BUYING queries (plots for sale, resale, farmer plot, land pooling land). Launch-date / registration / rate guides
 * belong to dsdproperties.in post 87: do not add them here, so the two sites do not compete (user's first goal, 28 Nov 2026).
 * The operator (DSD Properties) is named in the footer, the FAQ and the schema since 28 Nov 2026.
 * To change stock: edit $sizes ('available' | 'hold' | 'sold'). Change $updated + $updatedIso + sitemap lastmod + llms.txt together.
 */
$site = 'https://itcitylucknow.com/';
$phone = '919554102933';        // sales-domain number (main site uses 8595002933)
$phoneShow = '+91 95541 02933';
// Who runs this page (named in the footer + schema since 28 Nov 2026)
$opName = 'DSD Properties';
$opUrl  = 'https://dsdproperties.in/';
$opAbout = 'https://dsdproperties.in/about';
$opStreet = '128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2';
$opPin = '226025';
$updated = '28 November 2026';
$updatedIso = '2026-11-28';
$rateSqft = 4200;              // REPORTED proposed LDA rate per sq ft (Amar Ujala / Bhaskar, 4 Nov 2026; ~4,000 on 27 Oct). Not notified: always say "proposed".
$geo = [26.752822, 81.052238];

$sizes = [
    // m², status, what the size suits
    [35,  'available', 'Compact single-storey home or a starter investment'],
    [72,  'available', 'Two-storey family home with a small front setback'],
    [128, 'available', 'Three-bedroom house with space for a car'],
    [162, 'available', 'Family home plus a separate floor to rent out'],
    [200, 'available', 'Independent floors or a larger bungalow-style home'],
    [288, 'available', 'The largest farmer-allotment size in the scheme'],
];
$villages = ['Bakkas', 'Sikandarpur Amoliya', 'Siddhpura', 'Parehta', 'Rakibabad', 'Mohari Khurd', 'Mohari Kalan', 'Khujauli', 'Bhatwara', 'Sonai Kanjehra', 'Pahadnagar Tikariya'];
$villagesHi = ['बक्कास', 'सिकंदरपुर अमोलिया', 'सिद्धपुरा', 'परेहटा', 'रकीबाबाद', 'मोहारी खुर्द', 'मोहारी कलां', 'खुजौली', 'भटवारा', 'सोनई कंजेहरा', 'पहाड़नगर टिकरिया'];

$e    = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$wa   = function ($msg) use ($phone) { return 'https://wa.me/' . $phone . '?text=' . rawurlencode($msg); };
$sqft = function ($m) { return number_format($m * 10.7639); };
$sqyd = function ($m) { return number_format($m * 1.19599); };
$open = array_values(array_filter($sizes, function ($s) { return $s[1] !== 'sold'; }));
$list = implode(', ', array_map(function ($s) { return $s[0]; }, $open));
$lakh = function ($m) use ($rateSqft) { return number_format($m * 10.7639 * $rateSqft / 100000, 1); };

$faq = [
    ['Can I buy a plot that LDA has allotted to a farmer in IT City?',
     'Yes, a farmer who received a developed plot under land pooling can sell it, but the phase-1 land of IT City is notified, so the sale needs the District Collector\'s prior written permission. We tell you the permission status of each plot along with its price, and the registry is done only after the permission and the farmer\'s allotment letter have been checked.'],
    ['What does buying "land-pooling land" in IT City mean?',
     'It means buying farm land inside one of the IT City villages that has not yet been handed to LDA. Since 28 October 2026 such land can be bought only if the buyer files an affidavit that it will go into the scheme through land pooling, and the sale deed has to say so. You are buying the right to a developed plot later, not a plot you can build on today.'],
    ['How much land comes back in land pooling?',
     'In the allotments made so far, farmers have received about 25% of the land they gave as developed plots. On 2 November 2026 the LDA board decided that owners who pool 10 acres or more will get 50% of it back as land in the scheme. The exact share and conditions are written in the consent papers you sign with LDA.'],
    ['Which is better: an allotted plot or land-pooling land?',
     'An allotted plot is ready sooner: it already has a plot number and size in a sector, and only the transfer paperwork is left. Land-pooling land usually costs less per square foot of farm land, but you wait for the scheme to be developed and you get back only a share of the area as a plot. If you want to build in the next few years, the allotted plot is the safer choice.'],
    ['What papers should the seller of an allotted plot show?',
     'The LDA allotment letter in the farmer\'s name, the lottery result showing the plot, the khatauni of the land that was pooled, the farmer\'s ID, and — before registry — the District Collector\'s permission for the transfer. We check these with you before any payment.'],
    ['Should I wait for LDA\'s public lottery instead?',
     'You can apply in LDA\'s public lottery as well; registration for the general public has not opened yet and the launch planned for 23 November 2026 did not take place. A lottery is a chance, not a sure plot, while a farmer\'s allotted plot is a known plot in a known sector that you can buy now. Many buyers do both.'],
    ['Is this the official IT City or LDA website?',
     'No. This page is run by ' . $opName . ', an independent property consultancy at Vrindavan Sector 2, Lucknow, with no connection to the Lucknow Development Authority. LDA\'s schemes, lotteries and notices are published only on ldalucknow.in.'],
];
$faqHi = [
    ['क्या आईटी सिटी में किसान को मिला प्लॉट खरीदा जा सकता है?', 'हां, लेकिन फेज-1 की जमीन अधिसूचित है, इसलिए बिक्री से पहले जिलाधिकारी की लिखित अनुमति जरूरी है। हर प्लॉट की कीमत के साथ हम उसकी अनुमति की स्थिति भी बताते हैं।'],
    ['लैंड पूलिंग वाली जमीन खरीदने का क्या मतलब है?', '28 अक्टूबर 2026 के नियम के मुताबिक खरीदार को शपथ पत्र देना होता है कि जमीन लैंड पूलिंग से योजना में जाएगी, और बैनामे में भी यह लिखा जाता है। इसमें आपको आज प्लॉट नहीं, बल्कि आगे चलकर विकसित प्लॉट का हिस्सा मिलता है।'],
];
?><!doctype html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>IT City Lucknow Plots for Sale: Farmer Plots &amp; Land Pooling Land</title>
<meta name="description" content="Buy in LDA IT City, Sultanpur Road: plots allotted to land-pooling farmers (35–288 m²) and land under land pooling. Cost by size, DM permission and affidavit explained.">
<meta name="keywords" content="IT City Lucknow plot for sale, IT City Lucknow land pooling, IT City Lucknow farmer plot, LDA IT City resale plot, IT City Sultanpur Road plot, land pooling Lucknow, आईटी सिटी लखनऊ प्लॉट, आईटी सिटी लैंड पूलिंग">
<meta name="robots" content="index,follow,max-image-preview:large">
<meta name="theme-color" content="#0e3b2e">
<link rel="canonical" href="<?php echo $site; ?>">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%230e3b2e'/%3E%3Cpath d='M7 23V12l9-5 9 5v11' fill='none' stroke='%23e8b13a' stroke-width='2.6'/%3E%3Crect x='13' y='16' width='6' height='7' fill='%23e8b13a'/%3E%3C/svg%3E">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_IN">
<meta property="og:site_name" content="IT City Lucknow">
<meta property="og:title" content="IT City Lucknow: farmer-allotted plots and land-pooling land">
<meta property="og:description" content="Plots of <?php echo $list; ?> m² from land-pooling farmers, plus land in the scheme villages. Permission and paperwork handled step by step.">
<meta property="og:url" content="<?php echo $site; ?>">
<meta property="og:image" content="<?php echo $site; ?>og-image.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="IT City Lucknow plots and land pooling land">
<meta name="twitter:card" content="summary_large_image">
<meta name="geo.region" content="IN-UP">
<meta name="geo.placename" content="Lucknow">
<meta name="geo.position" content="<?php echo $geo[0] . ';' . $geo[1]; ?>">
<meta name="ICBM" content="<?php echo $geo[0] . ', ' . $geo[1]; ?>">
<link rel="alternate" type="text/plain" href="<?php echo $site; ?>llms.txt" title="LLM summary">
<script type="application/ld+json">
<?php
echo json_encode(['@context' => 'https://schema.org', '@graph' => [
  ['@type' => 'WebSite', '@id' => $site . '#website', 'name' => 'IT City Lucknow', 'url' => $site, 'inLanguage' => ['en-IN', 'hi-IN']],
  ['@type' => 'WebPage', '@id' => $site . '#webpage', 'url' => $site, 'name' => 'IT City Lucknow plots for sale: farmer-allotted plots and land pooling land',
   'isPartOf' => ['@id' => $site . '#website'], 'about' => ['@id' => $site . '#place'], 'mainEntity' => ['@id' => $site . '#plots'],
   'dateModified' => $updatedIso, 'inLanguage' => 'en-IN', 'primaryImageOfPage' => $site . 'og-image.jpg'],
  ['@type' => 'Place', '@id' => $site . '#place', 'name' => 'IT City Lucknow', 'alternateName' => ['LDA IT City', 'IT City Sultanpur Road', 'आईटी सिटी लखनऊ'],
   'description' => 'Lucknow Development Authority township of about 1,054 hectares on Sultanpur Road near Kisan Path, across 11 villages of Mohanlalganj tehsil, assembled mainly through land pooling.',
   'geo' => ['@type' => 'GeoCoordinates', 'latitude' => $geo[0], 'longitude' => $geo[1]],
   'containsPlace' => array_map(function ($v) { return ['@type' => 'Place', 'name' => $v . ', Lucknow']; }, $villages),
   'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Sultanpur Road', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN']],
  ['@type' => 'RealEstateAgent', '@id' => $site . '#agent', 'name' => 'IT City Lucknow', 'url' => $site, 'telephone' => '+' . $phone, 'image' => $site . 'og-image.jpg',
   'description' => 'Independent resale service for IT City Lucknow farmer-allotted plots and land-pooling land, run by ' . $opName . '. Not affiliated with LDA.',
   'areaServed' => ['@id' => $site . '#place'], 'knowsLanguage' => ['en', 'hi'],
   'parentOrganization' => ['@type' => 'Organization', 'name' => $opName, 'url' => $opUrl],
   'address' => ['@type' => 'PostalAddress', 'streetAddress' => $opStreet, 'addressLocality' => 'Lucknow', 'postalCode' => $opPin, 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN']],
  ['@type' => 'ItemList', '@id' => $site . '#plots', 'name' => 'Farmer-allotted plot sizes for sale in IT City Lucknow', 'numberOfItems' => count($open),
   'itemListElement' => array_map(function ($s, $i) use ($site, $sqft) {
       return ['@type' => 'ListItem', 'position' => $i + 1, 'item' => ['@type' => 'Place',
         'name' => $s[0] . ' m² farmer-allotted plot, IT City, Sultanpur Road, Lucknow',
         'description' => $s[0] . ' m² (' . $sqft($s[0]) . ' sq ft) developed plot allotted to a land-pooling farmer; transfer needs the District Collector\'s written permission.',
         'url' => $site . '#plot-' . $s[0],
         'additionalProperty' => [['@type' => 'PropertyValue', 'name' => 'Plot area', 'value' => $s[0], 'unitCode' => 'MTK']]]];
   }, $open, array_keys($open))],
  ['@type' => 'FAQPage', '@id' => $site . '#faq', 'mainEntity' => array_map(function ($q) { return ['@type' => 'Question', 'name' => $q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]]; }, array_merge($faq, $faqHi))],
]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
</script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Mukta:wght@400;600;700&display=swap" rel="stylesheet">
<style>
/* "Land and title deed" look: forest green, field-gold accents, warm paper background. Different from lucknowitcity.in on purpose. */
:root{--forest:#0e3b2e;--forest2:#165440;--gold:#e8b13a;--gold2:#c9921c;--paper:#fffdf7;--bg:#f6f3ea;--ink:#1c2a24;--muted:#5e6b63;--line:#e4ddcb;--leaf:#2f9e5b;--wa:#1fa855;
 --f:'Poppins','Mukta',system-ui,-apple-system,'Segoe UI',Arial,sans-serif;--fh:'Mukta','Poppins',system-ui,sans-serif}
*{box-sizing:border-box}html{scroll-behavior:smooth;scroll-padding-top:74px}
body{margin:0;background:var(--bg);color:var(--ink);font:16px/1.65 var(--f);-webkit-font-smoothing:antialiased;padding-bottom:76px}
@media(min-width:900px){body{padding-bottom:0}}
a{color:inherit}img{max-width:100%}
.wrap{width:min(1140px,100%);margin:0 auto;padding-left:max(18px,env(safe-area-inset-left,0px));padding-right:max(18px,env(safe-area-inset-right,0px))}
h1,h2,h3{font-weight:700;letter-spacing:-.01em;line-height:1.18;text-wrap:balance;margin:0}
.hi-text{font-family:var(--fh)}
.tag{display:inline-block;font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--gold2)}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 20px;border-radius:12px;border:1.5px solid var(--forest);background:var(--forest);color:#fff;font:700 15px var(--f);text-decoration:none;cursor:pointer;transition:transform .15s,background .15s}
.btn:hover{background:var(--forest2);transform:translateY(-1px)}
.btn.wa{background:var(--wa);border-color:var(--wa)}.btn.wa:hover{background:#178a45}
.btn.line{background:transparent;color:var(--forest)}.btn.line:hover{background:#efe9d8}
.btn.gold{background:var(--gold);border-color:var(--gold);color:#2a1d00}.btn.gold:hover{background:#f3c25a}
:focus-visible{outline:3px solid var(--gold);outline-offset:3px}
svg.i{width:18px;height:18px;flex:none}

.top{position:sticky;top:0;z-index:30;background:rgba(246,243,234,.94);backdrop-filter:blur(10px);border-bottom:1px solid var(--line)}
.top .wrap{display:flex;align-items:center;justify-content:space-between;gap:14px;min-height:64px}
.brand{display:flex;align-items:center;gap:10px;text-decoration:none;font-weight:800;color:var(--forest);font-size:17px;line-height:1.15}
.brand i{width:36px;height:36px;border-radius:10px;background:var(--forest);display:grid;place-items:center;flex:none}
.brand small{display:block;font-weight:600;font-size:11.5px;color:var(--muted)}
.top nav{display:flex;gap:20px;align-items:center;font-size:14.5px;font-weight:600}.top nav a{text-decoration:none}.top nav a:hover{color:var(--gold2)}
@media(max-width:900px){.top nav a.n{display:none}.top .btn{padding:10px 14px;font-size:14px}}

.hero{background:var(--forest);color:#fff;position:relative;overflow:hidden}
.hero .wrap{position:relative;padding-top:50px;padding-bottom:54px}
.hero-top{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(0,.65fr);gap:36px;align-items:center;margin-bottom:30px}
.plan{margin:0;background:#fff;border-radius:16px;padding:8px;box-shadow:0 18px 40px rgba(0,0,0,.25);transform:rotate(1.2deg)}
.plan img{display:block;width:100%;height:auto;border-radius:10px;aspect-ratio:765/1000;object-fit:cover}
.plan figcaption{font-size:12.5px;color:#4b574f;padding:8px 6px 2px;line-height:1.4}
@media(max-width:860px){.hero-top{grid-template-columns:1fr}.plan{max-width:420px;transform:none}}
.hero h1{font-size:clamp(31px,4.8vw,54px);margin:12px 0 14px;max-width:900px}.hero h1 em{font-style:normal;color:var(--gold)}
.hero .lead{font-size:18px;color:#dbe8e0;max-width:720px;margin:0 0 8px}
.hero .hl{font-family:var(--fh);font-size:17px;color:#bcd3c6;margin:0 0 28px}
.paths{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;max-width:980px}
.path{background:var(--paper);color:var(--ink);border-radius:18px;padding:22px 22px 20px;border-top:6px solid var(--gold);display:flex;flex-direction:column;gap:10px}
.path.b{border-top-color:var(--leaf)}
.path .tag{color:var(--gold2)}.path.b .tag{color:var(--leaf)}
.path h2{font-size:22px;color:var(--forest)}
.path p{margin:0;color:var(--muted);font-size:15px}
.path ul{margin:2px 0 6px;padding-left:18px;font-size:14.5px}.path li{margin:3px 0}
.path .acts{display:flex;flex-wrap:wrap;gap:10px;margin-top:auto;padding-top:6px}
@media(max-width:760px){.paths{grid-template-columns:1fr}.hero .wrap{padding-top:40px;padding-bottom:40px}}

.status{background:#fff6df;border-bottom:1px solid #efd9a2;color:#6b4a06;font-size:14px}
.status .wrap{padding-top:11px;padding-bottom:11px;display:flex;gap:10px;align-items:flex-start}
.status b{white-space:nowrap}
@media(max-width:640px){.status .wrap{display:block}.status b{display:block;margin-bottom:2px}}

section.band{padding:58px 0;border-bottom:1px solid var(--line)}
section.band.alt{background:var(--paper)}
.head{max-width:760px;margin-bottom:26px}.head h2{font-size:clamp(26px,3.4vw,38px);margin:8px 0 10px;color:var(--forest)}.head p{color:var(--muted);margin:0}

.glance{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
.g{background:var(--paper);border:1px solid var(--line);border-radius:16px;padding:18px}
section.alt .g{background:var(--bg)}
.g b{display:block;font-size:28px;color:var(--forest);line-height:1.05;font-variant-numeric:tabular-nums}.g span{font-size:13.5px;color:var(--muted)}
@media(max-width:820px){.glance{grid-template-columns:repeat(2,minmax(0,1fr))}}

.plots{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
.plot{background:var(--paper);border:1px solid var(--line);border-radius:18px;padding:20px;display:flex;flex-direction:column;gap:8px;position:relative}
.plot .sz{font-size:38px;font-weight:800;color:var(--forest);line-height:1}.plot .sz small{font-size:16px;font-weight:600;color:var(--muted);margin-left:4px}
.plot .conv{font-size:14px;color:var(--muted)}
.plot .use{font-size:14.5px;margin:2px 0}
.plot .pill{position:absolute;top:16px;right:16px;font-size:12px;font-weight:700;border-radius:999px;padding:4px 10px;background:#e4f4ea;color:#1d6b3c}
.plot .pill.hold{background:#fff1d6;color:#8a5a00}.plot .pill.sold{background:#eee;color:#666}
.plot .perm{font-size:13px;background:#f6f1e3;border-radius:10px;padding:8px 10px;color:#5b4a1f}
.plot .btn{margin-top:auto}
.bar{height:8px;border-radius:9px;background:#efe8d4;overflow:hidden}.bar i{display:block;height:100%;background:linear-gradient(90deg,var(--gold),var(--leaf))}
@media(max-width:900px){.plots{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:560px){.plots{grid-template-columns:1fr}}

.two{display:grid;grid-template-columns:minmax(0,1.1fr) minmax(0,.9fr);gap:28px;align-items:start}
@media(max-width:860px){.two{grid-template-columns:1fr}}
.prose p{margin:0 0 14px}.prose h3{font-size:20px;color:var(--forest);margin:22px 0 8px}
.note{border-left:5px solid var(--gold);background:#fff8e6;border-radius:0 14px 14px 0;padding:14px 16px;font-size:15px;margin:16px 0}
.note.green{border-left-color:var(--leaf);background:#eef8f1}
table{width:100%;border-collapse:collapse;font-size:14.5px;background:var(--paper);border-radius:14px;overflow:hidden;border:1px solid var(--line)}
th,td{padding:11px 12px;text-align:left;border-bottom:1px solid var(--line);vertical-align:top}
th{background:var(--forest);color:#fff;font-weight:600}
tr:last-child td{border-bottom:none}
.tw{overflow-x:auto;-webkit-overflow-scrolling:touch}

.steps{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:14px;counter-reset:s}
.steps li{background:var(--paper);border:1px solid var(--line);border-radius:16px;padding:18px;counter-increment:s;position:relative}
section.alt .steps li{background:var(--bg)}
.steps li:before{content:counter(s);display:grid;place-items:center;width:34px;height:34px;border-radius:50%;background:var(--gold);color:#2a1d00;font-weight:800;margin-bottom:10px}
.steps b{display:block;color:var(--forest);margin-bottom:4px}.steps span{font-size:14px;color:var(--muted)}
@media(max-width:980px){.steps{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:560px){.steps{grid-template-columns:1fr}}

.chips{display:flex;flex-wrap:wrap;gap:8px;margin:10px 0 0}
.chips span{background:var(--paper);border:1px solid var(--line);border-radius:999px;padding:6px 12px;font-size:14px}
.map{border-radius:18px;overflow:hidden;border:1px solid var(--line);background:#dfe9e1;aspect-ratio:4/3;position:relative;z-index:1}
.mapcap{font-size:12.5px;color:var(--muted);margin:8px 2px 0}
.fullplan{margin:26px 0 0;display:grid;grid-template-columns:minmax(0,.8fr) minmax(0,1.2fr);gap:24px;align-items:center}
.fullplan img{width:100%;height:auto;border-radius:14px;border:1px solid var(--line);background:#fff}
@media(max-width:760px){.fullplan{grid-template-columns:1fr}}

.sub{margin-top:34px}.sub h3{font-size:22px;color:var(--forest);margin:0 0 8px}.sub>p{color:var(--muted);margin:0 0 14px;max-width:780px}
caption{caption-side:bottom;text-align:left;font-size:13px;color:var(--muted);padding:10px 2px 0}
td.num{font-variant-numeric:tabular-nums;white-space:nowrap}
.updates{list-style:none;margin:0;padding:0;border-left:3px solid var(--line)}
.updates li{position:relative;padding:0 0 18px 20px}
.updates li:before{content:"";position:absolute;left:-8px;top:6px;width:13px;height:13px;border-radius:50%;background:var(--gold);border:3px solid var(--bg)}
.updates time{display:block;font-size:13px;font-weight:700;color:var(--gold2)}

.hi-sec{font-family:var(--fh);font-size:17.5px;line-height:1.75}
.hi-sec h2,.hi-sec h3{font-family:var(--fh)}
.hi-sec h3{font-size:22px;color:var(--forest);margin:22px 0 8px}

details{background:var(--paper);border:1px solid var(--line);border-radius:14px;margin:0 0 10px}
section.alt details{background:var(--bg)}
summary{cursor:pointer;list-style:none;padding:16px 18px;font-weight:600;display:flex;justify-content:space-between;gap:12px}
summary::-webkit-details-marker{display:none}
summary:after{content:"+";font-size:22px;line-height:1;color:var(--gold2)}details[open] summary:after{content:"–"}
details p{margin:0;padding:0 18px 16px;color:#3c4a42}

.cta{background:var(--forest);color:#fff;border-radius:22px;padding:30px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:18px}
.cta h2{font-size:clamp(22px,3vw,30px)}.cta p{margin:6px 0 0;color:#cfe0d6}
footer{padding:34px 0 40px;font-size:13.5px;color:var(--muted)}
footer p{margin:0 0 8px}

/* phone: always-visible WhatsApp + call bar (never hidden) */
.mbar{position:fixed;left:0;right:0;bottom:0;z-index:40;display:flex;gap:10px;padding:10px max(12px,env(safe-area-inset-left,0px)) calc(10px + env(safe-area-inset-bottom,0px));background:#fff;border-top:1px solid var(--line);box-shadow:0 -6px 20px rgba(0,0,0,.08)}
.mbar .btn{flex:1;padding:12px 10px}
@media(min-width:900px){.mbar{display:none}}
</style>
</head>
<body>

<header class="top">
 <div class="wrap">
  <a class="brand" href="<?php echo $site; ?>"><i><svg class="i" viewBox="0 0 24 24" fill="none" stroke="#e8b13a" stroke-width="2.4"><path d="M4 20V9l8-5 8 5v11"/><path d="M9 20v-6h6v6"/></svg></i><span>IT City Lucknow<small>Farmer plots · Land pooling land</small></span></a>
  <nav>
   <a class="n" href="#plots">Plots</a>
   <a class="n" href="#price">Price</a>
   <a class="n" href="#land-pooling">Land pooling</a>
   <a class="n" href="#how-to-buy">How to buy</a>
   <a class="n" href="#faq">FAQ</a>
   <a class="btn wa" href="<?php echo $e($wa('Hi, I want to buy in IT City Lucknow. Please share available plots / land.')); ?>" target="_blank" rel="noopener"><svg class="i" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm5.4 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .6l-.4.6-.4.5c-.1.1-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.2 1.4 2.5 1.5.3.1.5.1.7-.1l.9-1.1c.2-.3.4-.2.7-.1l2 .9c.3.2.5.2.6.4.1.1.1.7-.1 1.2Z"/></svg>WhatsApp</a>
  </nav>
 </div>
</header>

<main>
<section class="hero">
 <div class="wrap">
  <div class="hero-top">
   <div>
    <span class="tag" style="color:#e8b13a">LDA IT City · Sultanpur Road, Lucknow</span>
    <h1>IT City Lucknow plots for sale: <em>farmer-allotted plots</em> and land-pooling land</h1>
    <p class="lead">Two ways to own land in IT City before the public lottery: buy a developed plot that LDA has already allotted to a land-pooling farmer, or buy farm land in one of the 11 scheme villages that goes into land pooling. We show you the papers, the permission and the risks of each.</p>
    <p class="hl hi-text" style="margin-bottom:0">आईटी सिटी लखनऊ में किसानों को मिले प्लॉट और लैंड पूलिंग वाली जमीन — कागजात और अनुमति की पूरी जांच के साथ।</p>
   </div>
   <figure class="plan"><img src="it-city-layout-crop.webp" width="765" height="1000" alt="Part of LDA's IT City layout plan showing sectors, plotting areas and roads along the Indira Canal, Sultanpur Road, Lucknow" fetchpriority="high"><figcaption>Part of LDA's IT City layout plan: plotting sectors, group housing and the Indira Canal on the east.</figcaption></figure>
  </div>
  <div class="paths">
   <div class="path" id="option-a">
    <span class="tag">Option A · Ready plot</span>
    <h2>Plot already allotted to a farmer</h2>
    <p>A numbered plot in a developed sector, allotted by LDA lottery to a farmer who gave land.</p>
    <ul><li>Sizes: <?php echo $list; ?> m²</li><li>Needs the District Collector's permission to transfer</li><li>Plot number and sector known before you pay</li></ul>
    <div class="acts"><a class="btn wa" href="<?php echo $e($wa('Hi, I want an allotted farmer plot in IT City Lucknow. Please share sizes, prices and permission status.')); ?>" target="_blank" rel="noopener">Ask for plots</a><a class="btn line" href="#plots">See sizes</a></div>
   </div>
   <div class="path b" id="option-b">
    <span class="tag">Option B · Land pooling land</span>
    <h2>Farm land that goes into land pooling</h2>
    <p>Land inside the scheme villages, bought with an affidavit that it will join IT City through land pooling.</p>
    <ul><li>Lower entry price per sq ft of farm land</li><li>You get back a share of it as a developed plot later</li><li>Affidavit and sale-deed condition apply</li></ul>
    <div class="acts"><a class="btn wa" href="<?php echo $e($wa('Hi, I want land-pooling land in IT City Lucknow. Please share village, area and price.')); ?>" target="_blank" rel="noopener">Ask for land</a><a class="btn line" href="#land-pooling">How it works</a></div>
   </div>
  </div>
 </div>
</section>

<div class="status"><div class="wrap"><b>Status, <?php echo $e($updated); ?>:</b><span>LDA's public launch planned for 23 November 2026 did not take place, and the farmers' allotment letters due that day were not handed over; December is now expected, with no official date. Public registration has not opened.</span></div></div>

<section class="band">
 <div class="wrap">
  <div class="head"><span class="tag">IT City at a glance</span><h2>The scheme in numbers</h2><p>Figures reported from LDA statements in October and November 2026.</p></div>
  <div class="glance">
   <div class="g"><b>1,054 ha</b><span>about 2,604 acres on Sultanpur Road, near Kisan Path</span></div>
   <div class="g"><b>11</b><span>villages of Mohanlalganj tehsil inside the scheme</span></div>
   <div class="g"><b>2,197</b><span>plots allotted to 1,465 land-pooling farmers in three 2026 lotteries</span></div>
   <div class="g"><b>25%</b><span>of pooled land returned as developed plots so far; 50% for 10+ acres (board, 2 Nov)</span></div>
  </div>
 </div>
</section>

<section class="band alt" id="plots">
 <div class="wrap">
  <div class="head"><span class="tag">Option A</span><h2>Farmer-allotted plot sizes available now</h2>
   <p>These plots sit in the sectors where the 2026 farmer lotteries were held (sectors 9, 15, 16, 17, 18 and 30). Price and plot number are shared on WhatsApp, with the transfer permission status of that exact plot.</p></div>
  <div class="plots">
<?php $max = max(array_map(function ($s) { return $s[0]; }, $sizes)); foreach ($sizes as $s): [$m, $st, $use] = $s; ?>
   <article class="plot" id="plot-<?php echo $m; ?>">
    <span class="pill <?php echo $st === 'available' ? '' : $e($st); ?>"><?php echo $st === 'available' ? 'Available' : ($st === 'hold' ? 'On hold' : 'Sold'); ?></span>
    <div class="sz"><?php echo $m; ?><small>m²</small></div>
    <div class="conv"><?php echo $sqft($m); ?> sq ft · <?php echo $sqyd($m); ?> sq yd</div>
    <div class="bar" aria-hidden="true"><i style="width:<?php echo round($m / $max * 100); ?>%"></i></div>
    <p class="use"><?php echo $e($use); ?></p>
    <div class="perm">Transfer needs DM permission — status given with the price</div>
<?php if ($st !== 'sold'): ?>
    <a class="btn wa" href="<?php echo $e($wa('Hi, I am interested in a ' . $m . ' sq m farmer-allotted plot in IT City Lucknow. Please share price, sector and permission status.')); ?>" target="_blank" rel="noopener">Price for <?php echo $m; ?> m²</a>
<?php endif; ?>
   </article>
<?php endforeach; ?>
  </div>
  <div class="sub" id="price">
   <h3>IT City plot price by size at LDA's proposed rate</h3>
   <p>This table works out the land cost of each size at the proposed ₹<?php echo number_format($rateSqft); ?> per sq ft, so you can compare a resale price with what LDA is expected to charge. The rate is not notified, and LDA's own charges come on top.</p>
   <div class="tw"><table>
    <caption>Land cost only, at the proposed ₹<?php echo number_format($rateSqft); ?>/sq ft (not notified), <?php echo $e($updated); ?>. Resale prices of farmer plots are quoted per plot on WhatsApp.</caption>
    <thead><tr><th>Plot size</th><th>Sq ft</th><th>Sq yd</th><th>Cost at ₹<?php echo number_format($rateSqft); ?>/sq ft</th></tr></thead>
    <tbody><?php foreach ($open as $s): ?><tr><td><b><?php echo $s[0]; ?> m²</b></td><td class="num"><?php echo $sqft($s[0]); ?></td><td class="num"><?php echo $sqyd($s[0]); ?></td><td class="num">≈ ₹<?php echo $lakh($s[0]); ?> lakh</td></tr><?php endforeach; ?></tbody>
   </table></div>
  </div>
  <div class="fullplan">
   <a href="it-city-layout-plan.webp" target="_blank" rel="noopener"><img src="it-city-layout-plan.webp" width="1100" height="1555" loading="lazy" alt="LDA IT City layout plan, Lucknow, with sectors, road widths and land-use legend"></a>
   <div class="prose"><h3 style="margin-top:0">Where the farmer plots are on the plan</h3><p>This is LDA's layout plan for IT City. The farmer lotteries of 2026 allotted plots in sectors 9, 15, 16, 17, 18 and 30, mostly in the plotting areas shown in yellow and orange. Ask us to mark the exact plot on this plan before you visit the site.</p><p><a class="btn line" href="it-city-layout-plan.webp" target="_blank" rel="noopener">Open the full plan</a></p></div>
  </div>
  <p class="note">Sizes are the standard farmer-allotment sizes in IT City. A plot is booked only after you have seen the allotment letter and the District Collector's permission; we do not take money for a plot whose papers you have not checked.</p>
 </div>
</section>

<section class="band" id="land-pooling">
 <div class="wrap two">
  <div class="prose">
   <span class="tag">Option B</span>
   <div class="head" style="margin-bottom:12px"><h2>Buying land-pooling land in IT City</h2></div>
   <p>In land pooling, owners hand their farm land to LDA and receive part of it back as developed plots once roads, drains and power are built. LDA prefers this to compulsory acquisition, and most of IT City has been put together this way: about 500 hectares came through pooling by October 2026.</p>
   <p>Since 28 October 2026, land in the notified IT City villages can be sold to a new buyer on one condition: <strong>the buyer files an affidavit that the land will go into the scheme through land pooling, and the sale deed says so</strong>. So when you buy, you are buying the farmer's place in the pooling queue, not a plot you can fence and build on.</p>
   <h3>What you get back</h3>
   <p>In the allotments so far, farmers received about 25% of their pooled area as developed plots. On 2 November 2026 the LDA board approved that owners who pool 10 acres or more get 50% back as land in the scheme, and it approved the land-pooling SOP. The final share and conditions are in the consent documents you sign with LDA, so read them before paying.</p>
   <h3>What happens to land that is not pooled</h3>
   <p>LDA has said it will acquire the land of owners who stay out, at four times the circle rate in rural areas (about 300 hectares in IT City as of October 2026). That is why owners inside the villages are selling into pooling now.</p>
   <div class="note green">Before buying, match the gata (khasra) number with the khatauni and with the village list in the notification, and make sure the land is not under a dispute or a bank charge. We arrange this check before any token money.</div>
  </div>
  <div>
   <div class="tw"><table>
    <thead><tr><th></th><th>Option A: allotted plot</th><th>Option B: pooling land</th></tr></thead>
    <tbody>
     <tr><td><b>What you buy</b></td><td>A numbered developed plot</td><td>Farm land that joins land pooling</td></tr>
     <tr><td><b>When you can build</b></td><td>Once the sector is developed and transfer is done</td><td>After the scheme is developed and your plot is allotted</td></tr>
     <tr><td><b>Area you end with</b></td><td>The full plot area</td><td>About 25% of the land (50% for 10+ acres)</td></tr>
     <tr><td><b>Key paper</b></td><td>LDA allotment letter + DM permission</td><td>Khatauni + land-pooling affidavit in the sale deed</td></tr>
     <tr><td><b>Main risk</b></td><td>Permission delays</td><td>Long wait; plot location decided later</td></tr>
     <tr><td><b>Suits</b></td><td>Buyers who want to build</td><td>Long-term investors</td></tr>
    </tbody>
   </table></div>
   <p style="margin:14px 0 0"><a class="btn wa" href="<?php echo $e($wa('Hi, please explain land-pooling land in IT City Lucknow and share what is available.')); ?>" target="_blank" rel="noopener">Talk about pooling land</a></p>
  </div>
 </div>
</section>

<section class="band alt" id="how-to-buy">
 <div class="wrap">
  <div class="head"><span class="tag">Process</span><h2>How a purchase works, step by step</h2><p>We help you through the whole process. No payment is asked for before the papers are in front of you.</p></div>
  <ol class="steps">
   <li><b>Shortlist</b><span>Tell us the size or land area and budget; we share matching plots or land with sector or village.</span></li>
   <li><b>Check papers</b><span>Allotment letter or khatauni, seller ID, and that the land or plot is free of disputes and loans.</span></li>
   <li><b>Permission / affidavit</b><span>DM permission for an allotted plot; the land-pooling affidavit for pooling land.</span></li>
   <li><b>Agreement &amp; payment</b><span>Written agreement, payments only by bank transfer or cheque, with receipts.</span></li>
   <li><b>Registry &amp; records</b><span>Sale deed at the sub-registrar office, then the name change in LDA and revenue records.</span></li>
  </ol>
 </div>
</section>

<section class="band" id="location">
 <div class="wrap two">
  <div>
   <span class="tag">Location</span>
   <div class="head" style="margin-bottom:10px"><h2>Where IT City is</h2></div>
   <p>IT City lies on Sultanpur Road in Mohanlalganj tehsil, south-east Lucknow, connected to Kisan Path, the city's outer ring road. LDA is building it as a planned township with an IT zone, residential sectors and services. The scheme covers these 11 villages:</p>
   <div class="chips"><?php foreach ($villages as $v) echo '<span>' . $e($v) . '</span>'; ?></div>
   <p class="note">LDA has decided to bring good soil from outside for the roads in IT City instead of the local black clay, after the road agency warned the clay could make roads sink (reported 23 November 2026).</p>
  </div>
  <div>
   <div class="map" id="satmap" role="img" aria-label="Satellite view of the IT City area, Sultanpur Road, Lucknow"></div>
   <p class="mapcap">Satellite view of the IT City area between Kisan Path and Sultanpur Road. Switch to the street map with the layer button.</p>
  </div>
 </div>
</section>

<section class="band alt" id="updates">
 <div class="wrap two">
  <div>
   <span class="tag">Latest</span>
   <div class="head" style="margin-bottom:16px"><h2>IT City updates</h2></div>
   <ul class="updates">
    <li><time datetime="2026-11-23">23 November 2026</time>The planned launch with the farmers' allotment letters did not happen; December is expected, no date announced.</li>
    <li><time datetime="2026-11-23">23 November 2026</time>Roads in IT City will be built with soil brought from outside, not the local black clay.</li>
    <li><time datetime="2026-11-04">4 November 2026</time>Proposed rate for LDA's own IT City plots reported at about ₹<?php echo number_format($rateSqft); ?> per sq ft (about ₹4,000 per LDA's secretary on 27 October); not notified.</li>
    <li><time datetime="2026-11-02">2 November 2026</time>LDA board: owners pooling 10+ acres get 50% back as land in the scheme; land-pooling SOP approved.</li>
    <li><time datetime="2026-10-28">28 October 2026</time>Notified IT City land may be sold if the buyer files a land-pooling affidavit and the sale deed records it.</li>
    <li><time datetime="2026-10-06">6 October 2026</time>Land position: about 500 ha pooled, about 200 ha gram samaj land in legal process, about 300 ha to be acquired.</li>
   </ul>
  </div>
  <div class="hi-sec" lang="hi">
   <span class="tag">हिंदी में</span>
   <h2 style="font-size:clamp(24px,3.2vw,34px);color:var(--forest);margin:8px 0 10px">आईटी सिटी लखनऊ: किसानों के प्लॉट और लैंड पूलिंग जमीन</h2>
   <p>एलडीए की आईटी सिटी सुल्तानपुर रोड पर करीब 1,054 हेक्टेयर में बन रही है और इसकी ज्यादातर जमीन लैंड पूलिंग से आई है। जिन किसानों ने जमीन दी, उन्हें लॉटरी से विकसित प्लॉट मिले हैं, और 2026 की तीन लॉटरी में 1,465 किसानों को 2,197 प्लॉट आवंटित हुए हैं।</p>
   <h3>किसान का प्लॉट खरीदना</h3>
   <p>हमारे पास <?php echo $list; ?> वर्ग मीटर के प्लॉट हैं। फेज-1 की जमीन अधिसूचित है, इसलिए हर बिक्री में जिलाधिकारी की लिखित अनुमति लगती है, और हम हर प्लॉट की कीमत के साथ उसकी अनुमति की स्थिति भी बताते हैं।</p>
   <h3>लैंड पूलिंग वाली जमीन</h3>
   <p>गांवों की जो जमीन अभी योजना में जानी है, उसे खरीदा जा सकता है, बशर्ते खरीदार शपथ पत्र दे कि जमीन लैंड पूलिंग से योजना में जाएगी और बैनामे में भी यह लिखा हो। अब तक किसानों को करीब 25% जमीन विकसित प्लॉट के रूप में मिली है, और 10 एकड़ या उससे ज्यादा जमीन देने वालों को 50% वापस मिलेगी।</p>
   <p><a class="btn wa" href="<?php echo $e($wa('नमस्ते, मुझे आईटी सिटी लखनऊ में प्लॉट / लैंड पूलिंग जमीन चाहिए। जानकारी भेजें।')); ?>" target="_blank" rel="noopener">WhatsApp पर पूछें</a></p>
  </div>
 </div>
</section>

<section class="band" id="faq">
 <div class="wrap">
  <div class="head"><span class="tag">Questions</span><h2>IT City plots and land pooling: FAQ</h2></div>
<?php foreach ($faq as $q): ?>
  <details><summary><?php echo $e($q[0]); ?></summary><p><?php echo $e($q[1]); ?></p></details>
<?php endforeach; ?>
<?php foreach ($faqHi as $q): ?>
  <details lang="hi" class="hi-text"><summary><?php echo $e($q[0]); ?></summary><p><?php echo $e($q[1]); ?></p></details>
<?php endforeach; ?>
 </div>
</section>

<section class="band alt" style="border-bottom:0">
 <div class="wrap">
  <div class="cta">
   <div><h2>Want a plot or land in IT City?</h2><p>Tell us the size or area and your budget. Call or WhatsApp <?php echo $e($phoneShow); ?>.</p></div>
   <div style="display:flex;gap:10px;flex-wrap:wrap"><a class="btn gold" href="tel:+<?php echo $phone; ?>">Call <?php echo $e($phoneShow); ?></a><a class="btn wa" href="<?php echo $e($wa('Hi, I want to buy in IT City Lucknow. Please share available plots / land.')); ?>" target="_blank" rel="noopener">WhatsApp</a></div>
  </div>
 </div>
</section>
</main>

<footer>
 <div class="wrap">
  <p><strong>IT City Lucknow</strong> is an independent property resale service for farmer-allotted plots and land-pooling land in IT City, Sultanpur Road, Lucknow. We are not the Lucknow Development Authority and are not connected to it; LDA's schemes, lotteries and notices are published only on ldalucknow.in.</p>
  <p>Scheme facts on this page come from published newspaper reports of LDA statements (October–November 2026) and may change. Every transfer depends on the District Collector's permission or the land-pooling affidavit, as applicable. Last updated <?php echo $e($updated); ?>.</p>
  <p>Contact: <a href="tel:+<?php echo $phone; ?>"><?php echo $e($phoneShow); ?></a> (call / WhatsApp)</p>
  <p>Listed and managed by <strong><?php echo $e($opName); ?></strong>, property consultants in Lucknow · <?php echo $e($opStreet); ?>, Lucknow <?php echo $e($opPin); ?> · <a href="<?php echo $e($opAbout); ?>">About us</a></p>
 </div>
</footer>

<div class="mbar">
 <a class="btn gold" href="tel:+<?php echo $phone; ?>">Call</a>
 <a class="btn wa" href="<?php echo $e($wa('Hi, I want to buy in IT City Lucknow. Please share available plots / land.')); ?>" target="_blank" rel="noopener">WhatsApp</a>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script>
window.addEventListener('load', function () {
  if (!window.L || !document.getElementById('satmap')) return;
  var sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {maxZoom: 18, attribution: 'Imagery &copy; Esri, Maxar, Earthstar Geographics'});
  var road = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'});
  var m = L.map('satmap', {layers: [sat], scrollWheelZoom: false}).setView([<?php echo $geo[0] . ', ' . $geo[1]; ?>], 13);
  L.control.layers({'Satellite': sat, 'Street map': road}).addTo(m);
  L.marker([<?php echo $geo[0] . ', ' . $geo[1]; ?>]).addTo(m).bindPopup('IT City, Sultanpur Road, Lucknow');
});
</script>
</body>
</html>
