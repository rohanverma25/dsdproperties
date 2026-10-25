# Fact update of post 138 (Kanpur Road plots, Hindi) — 18 Oct 2026.
# Expressway opened 13 Jul 2026 (post still said "opening delayed"), toll suspended Aug 2026,
# metro terminus fix, Banthra = Banthara (Nagar Panchayat since 2023), unsourced forecasts removed,
# listing prices labelled honestly, circle-rate + BrahMos + Kisan Path updates added.
import json, re, sys

h0 = open('before.html', encoding='utf8', newline='').read()
h = h0.replace('\r\n', '\n')

def rep(old, new, n=1):
    global h
    c = h.count(old)
    if c != n: sys.exit(f'ABORT: expected {n}, found {c}: {old[:100]!r}')
    h = h.replace(old, new)

def A(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'
ETV_TOLL = A('https://www.etvbharat.com/hi/state/toll-to-be-levied-on-the-lucknow-kanpur-expressway-starting-july-14-ups26071307236', 'ईटीवी भारत, 13 जुलाई 2026')
AT_SUSP = A('https://www.aajtak.in/uttar-pradesh/story/kanpur-lucknow-expressway-nhai-stops-toll-collection-after-aaj-tak-report-ntc-dhrj-rpti-2616168-2026-08-05', 'आज तक, 5 अगस्त 2026')
AU_REP = A('https://www.amarujala.com/lucknow/up-lucknow-kanpur-expressway-to-remain-toll-free-until-the-rains-road-to-be-repaired-after-the-rains-2026-09-02', 'अमर उजाला, 2 सितंबर 2026')
AU_KP = A('https://www.amarujala.com/lucknow/up-building-plans-along-kisan-path-to-be-approved-by-lda-paving-the-way-for-new-townships-and-colonies-deci-2026-10-14', 'अमर उजाला, 14 अक्टूबर 2026')
PAT = A('https://www.patrika.com/lucknow-news/circle-rates-doubled-in-332-villages-of-lucknow-ahead-of-expressway-project-20638488', 'पत्रिका, 5 जून 2026')
TRIB = A('https://www.tribuneindia.com/news/defence/brahmos-new-unit-at-lucknow-to-deliver-first-batch-of-cruise-missiles-on-saturday', 'द ट्रिब्यून')
ETV_NP = A('https://www.etvbharat.com/hindi/uttar-pradesh/state/lucknow/municipal-elections-up-civic-elections-mohanlalganj-nagar-panchayat-president/up20230418220259755755879', 'ईटीवी भारत, अप्रैल 2023')
WIKI = A('https://en.wikipedia.org/wiki/Awadh_Expressway', 'Wikipedia')
WIKI_M = A('https://en.wikipedia.org/wiki/Red_Line_(Lucknow_Metro)', 'लखनऊ मेट्रो रेड लाइन')
HOUSING = A('https://housing.com/news/lucknow-kanpur-expressway/', 'Housing.com')
LI = '<li style="margin-bottom: 10px;">→ '

# ── sources strip ─────────────────────────────────────────
rep('<div class="dsd-sources-strip"><strong>स्रोत:</strong> 99acres · Nestoria · Squareyards · 360plot.com · Indiamart · Awadh Expressway स्थिति: Wikipedia/NHAI ट्रैकर (मई 2026) · UP RERA पोर्टल (up-rera.in) · UPAVP · Eldeco Group · ऑफिशियल RERA रजिस्ट्रेशन डेटा। सभी कीमतें सिर्फ plot listings से — apartment averages शामिल नहीं।</div>',
    '<div class="dsd-sources-strip"><strong>स्रोत:</strong> अमर उजाला · ईटीवी भारत · आज तक · पत्रिका · द ट्रिब्यून · Wikipedia (अवध एक्सप्रेसवे, लखनऊ मेट्रो) · UP RERA पोर्टल (up-rera.in) · प्लॉट लिस्टिंग: 99acres, Nestoria, Indiamart, 360plot.com (मई 2026)। <strong>अपडेट: 18 अक्टूबर 2026</strong></div>\n'
    '<!-- key-facts -->\n<div class="dsd-key-facts" style="background:#f0fdfa;border:1px solid rgba(0,128,128,0.25);border-left:4px solid #008080;border-radius:0 12px 12px 0;padding:16px 20px;margin:16px 0 24px;">\n'
    '  <p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">मुख्य बातें (अपडेट: 18 अक्टूबर 2026)</p>\n  <ul style="margin:0;padding-left:20px;">\n'
    f'    <li style="margin:5px 0;line-height:1.7;"><strong>लखनऊ–कानपुर एक्सप्रेसवे</strong> (अवध एक्सप्रेसवे, NE-6) — 63 किमी, 6 लेन — <strong>13 जुलाई 2026 को खुल चुका है</strong>। लखनऊ से कानपुर करीब 35–40 मिनट; कार का टोल ₹275 (एक तरफ) तय हुआ ({ETV_TOLL})।</li>\n'
    f'    <li style="margin:5px 0;line-height:1.7;">सड़क धंसने के बाद <strong>अगस्त 2026 से टोल वसूली रुकी है</strong>; NHAI ने बारिश के बाद ओवरले कर मरम्मत की बात कही ({AU_REP})।</li>\n'
    f'    <li style="margin:5px 0;line-height:1.7;">CCS एयरपोर्ट इसी सड़क पर है, और मेट्रो की रेड लाइन यहीं (CCS Airport स्टेशन) से शुरू होती है — Amausi और Transport Nagar स्टेशन भी इसी पट्टी में ({WIKI_M})।</li>\n'
    f'    <li style="margin:5px 0;line-height:1.7;"><strong>बंथरा 2023 में बनी नगर पंचायत</strong> है (10 गांव) — यहां की कई कॉलोनियां LDA क्षेत्र में नहीं आतीं, इसलिए नक्शा और लोन के नियम अलग हैं ({ETV_NP})।</li>\n'
    f'    <li style="margin:5px 0;line-height:1.7;">जून 2026 में सरोजिनी नगर तहसील के 52 गांवों में खेती की जमीन का सर्किल रेट बढ़ा — कुछ गांवों में ₹80–97 लाख प्रति हेक्टेयर ({PAT})।</li>\n'
    '  </ul>\n</div>')

# ── latest updates box ────────────────────────────────────
i = h.find('<h4 style="color: #011f4b; margin-top: 0;">🔴 ताजा अपडेट — मई 2026</h4>'); j = h.find('</ul>', i)
assert i > 0 and j > i
OLD_EL = '<li style="margin-bottom: 10px;">→ <strong>फरवरी 2026:</strong> Eldeco Imperia (RERA: UPRERAPRJ929056) Phase 1 की possession मार्च 2027 तक — Zone A Sarojini Nagar में चुनिंदा RERA-compliant gated प्रोजेक्ट्स में से एक। (स्रोत: 99acres, UP RERA Portal)</li>'
assert h[i:j].count(OLD_EL) == 1
NEW_UPD = ('<h4 style="color: #011f4b; margin-top: 0;">🔴 ताजा अपडेट — कानपुर रोड (18 अक्टूबर 2026)</h4>\n<ul style="margin: 8px 0 0 0; padding-left: 18px; list-style: none;">\n'
 + LI + f'<strong>14 अक्टूबर 2026:</strong> एलडीए किसान पथ (आउटर रिंग रोड) के किनारे 43 गांवों में पहली बार नक्शे पास करने का प्रस्ताव ला रहा है। किसान पथ कानपुर रोड को भी पार करता है। बोर्ड बैठक टल गई है; फैसला अभी बाकी है। ({AU_KP})</li>\n'
 + LI + f'<strong>2 सितंबर 2026:</strong> NHAI ने कहा कि बारिश खत्म होने तक एक्सप्रेसवे टोल-फ्री रहेगा; सितंबर के आखिरी हफ्ते में ओवरले के बाद टोल फिर शुरू होगा। ({AU_REP})</li>\n'
 + LI + f'<strong>5 अगस्त 2026:</strong> 26 जुलाई को सड़क धंसने के बाद NHAI ने टोल वसूली रोकी और निर्माण कंपनी PNC Infratech पर कार्रवाई की। ({AT_SUSP})</li>\n'
 + LI + f'<strong>13–14 जुलाई 2026:</strong> लखनऊ–कानपुर एक्सप्रेसवे का उद्घाटन; 14 जुलाई से टोल — कार ₹275 एक तरफ, ₹415 आना-जाना (24 घंटे में)। सफर करीब 35–40 मिनट। ({ETV_TOLL})</li>\n'
 + LI + f'<strong>5 जून 2026:</strong> लखनऊ के 332 गांवों में खेती की जमीन का नया सर्किल रेट लागू — इनमें सरोजिनी नगर तहसील के 52 गांव; कुछ गांवों में ₹80–97 लाख प्रति हेक्टेयर। ({PAT})</li>\n'
 + OLD_EL + '\n'
 + '<li style="margin-bottom: 0;">→ ' + f'<strong>18 अक्टूबर 2025:</strong> सरोजिनी नगर के भटगांव में ब्रह्मोस की ₹300 करोड़ की यूनिट (यूपी डिफेंस कॉरिडोर) से मिसाइलों का पहला बैच रवाना हुआ; यूनिट का उद्घाटन 11 मई 2025 को हुआ था। ({TRIB})</li>\n')
h = h[:i] + NEW_UPD + h[j:]

# ── stats bar ─────────────────────────────────────────────
rep('<div style="font-size: 11px; text-transform: uppercase; opacity: .8; letter-spacing: .5px;">प्लॉट रेट रेंज / sqft</div>', '<div style="font-size: 11px; text-transform: uppercase; opacity: .8; letter-spacing: .5px;">लिस्टिंग रेट / sqft (मई 2026)</div>')
rep('<div style="font-size: 26px; font-weight: bold; color: #20b2aa;">2026</div>\n<div style="font-size: 11px; text-transform: uppercase; opacity: .8; letter-spacing: .5px;">अवध एक्सप्रेसवे शुरू</div>',
    '<div style="font-size: 26px; font-weight: bold; color: #20b2aa;">13 जुलाई 2026</div>\n<div style="font-size: 11px; text-transform: uppercase; opacity: .8; letter-spacing: .5px;">एक्सप्रेसवे खुला</div>')
rep('<div style="font-size: 26px; font-weight: bold; color: #20b2aa;">600+</div>\n<div style="font-size: 11px; text-transform: uppercase; opacity: .8; letter-spacing: .5px;">एक्टिव प्लॉट लिस्टिंग</div>',
    '<div style="font-size: 26px; font-weight: bold; color: #20b2aa;">35–40 मिनट</div>\n<div style="font-size: 11px; text-transform: uppercase; opacity: .8; letter-spacing: .5px;">लखनऊ–कानपुर</div>')
rep('एयरपोर्ट · मिड · फ्रंटियर', 'एयरपोर्ट · बंथरा · फ्रंटियर')

# ── why-different box ─────────────────────────────────────
rep('→ <strong>अवध एक्सप्रेसवे (NE-6) 2026 में शुरू होने वाला</strong> — 63 km, 6-lane access-controlled एक्सप्रेसवे लखनऊ से कानपुर तक। एक दशक का सबसे बड़ा infrastructure event।',
    '→ <strong>अवध एक्सप्रेसवे (NE-6) 13 जुलाई 2026 को खुला</strong> — 63 km, 6-lane access-controlled एक्सप्रेसवे लखनऊ से कानपुर तक। अगस्त से टोल रुका है क्योंकि धंसी सड़क की मरम्मत चल रही है।')
rep('→ <strong>लखनऊ का सबसे सस्ता legal प्लॉट</strong> — Banthra की approved societies में ₹850/sqft से entry मिलती है; शहर में और कहीं इस रेट पर मुश्किल।',
    '→ <strong>कम entry price</strong> — मई 2026 की लिस्टिंग में Banthra की gated societies ₹850/sqft से दिखीं। लिस्टिंग रेट मोलभाव से पहले की कीमत है — सौदे से पहले हाल की रजिस्ट्री और सर्किल रेट देखें।')
rep('→ <strong>Defence Corridor employment + Amazon warehousing</strong> — captive rental demand बनती है जो बाकी residential corridors में नहीं।',
    '→ <strong>Defence Corridor</strong> — सरोजिनी नगर के भटगांव में ब्रह्मोस की ₹300 करोड़ की यूनिट मई 2025 से चल रही है; इससे आसपास रोज़गार और किराये की मांग बनती है।')
rep('→ <strong>Metro connectivity</strong> — Transport Nagar metro station (NS corridor का south terminus) से Zone A को public transport मिलता है।',
    '→ <strong>Metro connectivity</strong> — मेट्रो की रेड लाइन CCS Airport स्टेशन से शुरू होती है; Amausi और Transport Nagar स्टेशन भी Zone A में हैं।')

# ── intro ─────────────────────────────────────────────────
rep('तब कानपुर रोड पर approved societies में ₹500/sqft से प्लॉट शुरू होते हैं, international airport इसी रोड पर है, और 63 km का expressway 2026 में खुलने वाला है जो इस कॉरिडोर की valuation बदल देगा।',
    'तब कानपुर रोड पर gated societies की लिस्टिंग ₹850/sqft से दिखती है, international airport इसी रोड पर है, और 63 km का लखनऊ–कानपुर expressway 13 जुलाई 2026 को खुल चुका है।')

# ── triggers box ──────────────────────────────────────────
rep('→ <strong>अवध एक्सप्रेसवे (NE-6) — 2026 में शुरू</strong> — 63 km, 6-lane एक्सप्रेसवे लखनऊ से कानपुर तक, NH-27 के parallel। Amausi से Bani तक elevated sections का काम लगभग पूरा। यह project लखनऊ–कानपुर travel time कम करेगा और Banthra-Bani pockets की land values को unlock करेगा जो 4 साल से इसी trigger का इंतज़ार कर रही हैं।',
    f'→ <strong>अवध एक्सप्रेसवे (NE-6) — 13 जुलाई 2026 को खुला</strong> — 63 km, 6-lane एक्सप्रेसवे लखनऊ से कानपुर तक, NH-27 के parallel; {HOUSING} के अनुसार यह बंथरा और बनी होकर गुजरता है। सफर अब करीब 35–40 मिनट का है। सड़क धंसने के बाद अगस्त से टोल रुका है और मरम्मत चल रही है।')
rep('→ <strong>Defence Corridor + Logistics Anchors</strong> — Sarojini Nagar में UP Defence Corridor की defence manufacturing units हैं। Amazon और बड़े logistics players ने यहाँ warehousing presence बनाई है। यह industrial और logistics employment साल भर consistent housing demand पैदा करता है — recession-proof और बढ़ रहा है।',
    f'→ <strong>Defence Corridor</strong> — UP Defence Corridor के लखनऊ नोड में सरोजिनी नगर के भटगांव में ब्रह्मोस की ₹300 करोड़ की यूनिट है, जिसका उद्घाटन 11 मई 2025 को हुआ और अक्टूबर 2025 में पहला बैच निकला ({TRIB})। ऐसे उद्योग आसपास रोज़गार और किराये की मांग बनाते हैं।')
rep('<p>2026 में कानपुर रोड पर तीन independent demand triggers एक साथ converge हो रहे हैं। हर एक अकेले इस कॉरिडोर पर ध्यान देने का काफी कारण है। तीनों मिलकर इसे अभी लखनऊ का सबसे interesting underpriced plot corridor बनाते हैं।</p>',
    '<p>2026 में कानपुर रोड पर तीन बड़ी चीज़ें एक साथ हैं — नया खुला एक्सप्रेसवे, एयरपोर्ट और डिफेंस कॉरिडोर। नीचे हर एक की स्थिति स्रोत के साथ है।</p>')

# ── corridor comparison table ─────────────────────────────
rep('<th style="padding: 12px; text-align: left;">Expressway 2026</th>', '<th style="padding: 12px; text-align: left;">Expressway</th>')
rep('<td style="padding: 11px; border: 1px solid #ddd;">हाँ — अवध एक्सप्रेसवे</td>', '<td style="padding: 11px; border: 1px solid #ddd;">हाँ — अवध एक्सप्रेसवे (जुलाई 2026 से खुला)</td>')
rep('<td style="padding: 11px; border: 1px solid #ddd;">हाँ — Transport Nagar</td>', '<td style="padding: 11px; border: 1px solid #ddd;">हाँ — CCS Airport, Amausi, Transport Nagar</td>')
rep('<th style="padding: 12px; text-align: left;">सबसे कम Approved Plot Rate</th>', '<th style="padding: 12px; text-align: left;">सबसे कम लिस्टिंग रेट (मई 2026)</th>')
rep('<p>कानपुर रोड लखनऊ का अकेला प्लॉट कॉरिडोर है जहां ₹850/sqft पर approved ज़मीन मिलती है — और साथ ही international airport adjacent है, 6-lane expressway 2026 में खुलने वाला है, और metro station भी है। यह combination शहर में और कहीं नहीं।</p>',
    '<p style="font-size: 13px; color: #6b7280;">रेट मई 2026 में पोर्टलों पर दिखी प्लॉट लिस्टिंग से हैं (DSD Properties का सर्वे) — रजिस्ट्री की असली कीमत नहीं।</p>\n<p>कानपुर रोड पर कम entry price, एयरपोर्ट, मेट्रो और जुलाई 2026 में खुला 6-lane एक्सप्रेसवे — यह combination लखनऊ के दूसरे प्लॉट कॉरिडोर में एक साथ नहीं मिलता।</p>')

# ── zones ─────────────────────────────────────────────────
rep('अवध एक्सप्रेसवे का elevated section इसी zone से होकर गुज़रता है — इसलिए 2026 की opening का primary beneficiary यही है। कई gated societies bank loan facility के साथ। 3–5 साल के investors के लिए अभी best entry point।',
    'जुलाई 2026 में खुला अवध एक्सप्रेसवे इसी पट्टी से होकर गुज़रता है। बंथरा 2023 से नगर पंचायत है, इसलिए यहां की कॉलोनियों में नगर पंचायत की मंज़ूरी देखनी होती है। कई gated societies में bank loan मिलता है — हर प्लॉट के लिए बैंक से अलग पुष्टि करें।')
rep('<div style="font-size: 13px; color: #666; margin-bottom: 12px;">Active · Awadh Expwy Trigger · 2026 की Best Entry</div>', '<div style="font-size: 13px; color: #666; margin-bottom: 12px;">Active · Expressway पर · नगर पंचायत क्षेत्र</div>')
rep('<h3 style="color: #011f4b; margin: 8px 0 6px 0; font-size: 19px;">Banthara से Natkur — The Frontier</h3>', '<h3 style="color: #011f4b; margin: 8px 0 6px 0; font-size: 19px;">Bani के आगे — The Frontier</h3>')
rep('<strong>Approved gated societies: ₹850–₹2,000/sqft</strong> · पूरे कॉरिडोर की best value', '<strong>Gated societies (लिस्टिंग): ₹850–₹2,000/sqft</strong>')
rep('<strong>Approved plots: ₹1,700–₹4,500/sqft</strong> · Airport-adjacent premium ₹8,000+ तक', '<strong>Plots (लिस्टिंग): ₹1,700–₹4,500/sqft</strong>')
rep('<strong>Unapproved: ₹500–₹900/sqft</strong> · Approved societies: ₹900–₹1,300/sqft', '<strong>Unapproved (लिस्टिंग): ₹500–₹900/sqft</strong> · Approved societies: ₹900–₹1,300/sqft')

# ── price table ───────────────────────────────────────────
rep('Verified Plot Price Data 2026</h2>', 'प्लॉट लिस्टिंग रेट 2026 (मई 2026)</h2>')
rep('<p>⚠️ नीचे दी गई सभी कीमतें सिर्फ verified plot listings से हैं — apartment या blended corridor averages से नहीं। स्रोत: 99acres, Nestoria, Indiamart, 360plot.com, actual transaction data।</p>',
    '<p>⚠️ नीचे की कीमतें मई 2026 में 99acres, Nestoria, Indiamart और 360plot.com पर दिखी <strong>प्लॉट लिस्टिंग (विक्रेता की मांगी गई कीमत)</strong> से हैं — रजिस्ट्री में हुई असली बिक्री की कीमत नहीं। सौदे से पहले उसी इलाके की हाल की रजिस्ट्री और सर्किल रेट जरूर देखें।</p>')
rep('<th style="padding: 12px; text-align: left;">Verified Rate (₹/sqft)</th>', '<th style="padding: 12px; text-align: left;">लिस्टिंग रेट (₹/sqft)</th>')
rep('<th style="padding: 12px; text-align: left;">Sample Transaction</th>', '<th style="padding: 12px; text-align: left;">उदाहरण लिस्टिंग</th>')
rep('<td style="padding: 11px; border: 1px solid #ddd;"><strong>Banthara / Natkur — Zone C</strong></td>', '<td style="padding: 11px; border: 1px solid #ddd;"><strong>Bani के आगे — Zone C</strong></td>')
rep('<h3 style="color: #011f4b; font-size: 19px; margin-top: 28px;">आपके बजट में क्या मिलेगा — Zone by Zone</h3>',
    f'<p>सरकारी पैमाना: जून 2026 से लखनऊ के 332 गांवों में खेती की जमीन का नया डीएम सर्किल रेट लागू है — सरोजिनी नगर तहसील के 52 गांव इसमें शामिल हैं और कुछ गांवों में रेट ₹80–97 लाख प्रति हेक्टेयर तक पहुंचा ({PAT})। स्टांप ड्यूटी सर्किल रेट या सौदे की कीमत — जो ज़्यादा हो — उस पर लगती है।</p>\n'
    '<h3 style="color: #011f4b; font-size: 19px; margin-top: 28px;">आपके बजट में क्या मिलेगा — Zone by Zone</h3>')

# ── expressway section ────────────────────────────────────
rep('अवध एक्सप्रेसवे — 2026 का सबसे बड़ा Price Trigger</h2>', 'अवध एक्सप्रेसवे — 13 जुलाई 2026 से खुला</h2>')
rep('यह कानपुर रोड real estate पर एक दशक का सबसे बड़ा infrastructure event है — और 2026 में शुरू हो रहा है। हालांकि <strong>मई 2026 के latest NHAI update के अनुसार Lucknow package में कुछ ramps और toll plazas का काम अभी बाकी है</strong> — इसलिए opening date आगे खिसकी है।',
    f'इसका उद्घाटन <strong>13 जुलाई 2026</strong> को हुआ और 14 जुलाई से टोल शुरू हुआ ({ETV_TOLL})। 26 जुलाई को सड़क धंसने के बाद NHAI ने टोल वसूली रोक दी ({AT_SUSP}); 2 सितंबर को NHAI ने कहा कि बारिश के बाद ओवरले कर मरम्मत होगी और उसके बाद टोल फिर शुरू होगा ({AU_REP})।')
rep('→ <strong>Starting point:</strong> South Lucknow में Amausi के पास Shaheed Path junction — सीधे कानपुर रोड कॉरिडोर पर',
    '→ <strong>शुरुआत और अंत:</strong> दक्षिण लखनऊ में शहीद पथ के पास NH-27 से शुरू होकर कानपुर में आज़ाद मार्ग के पास NH-27 पर खत्म')
rep('→ <strong>Elevated sections:</strong> Amausi और Bani से होकर दो elevated portions (कुल ~12.5 km elevated highway) — Banthra zone में movement काफी बढ़ाएंगे',
    f'→ <strong>Elevated sections:</strong> लखनऊ छोर से 13.0–16.4 किमी और 18.5–27.6 किमी के बीच दो एलिवेटेड हिस्से — कुल करीब 12.5 किमी ({WIKI})')
rep('→ <strong>Construction status (मई 2026):</strong> Concrete girders launched, deck slabbing लगभग पूरी, Scooter India क्रॉसिंग के पास का stretch अंतिम चरण में। Toll plazas का काम बाकी।',
    '→ <strong>स्थिति (अक्टूबर 2026):</strong> एक्सप्रेसवे चालू है; अगस्त से टोल नहीं लिया जा रहा क्योंकि धंसी सड़क की मरम्मत होनी है। टोल फिर शुरू होने की आधिकारिक तारीख अभी सामने नहीं आई।')
rep('→ <strong>Connected to:</strong> Kanpur Ring Road / Udyog Path, और trijunction से Ganga Expressway (594 km) तथा Kanpur–Noida Expressway से',
    '→ <strong>टोल (तय दरें):</strong> कार ₹275 एक तरफ, ₹415 आना-जाना; सालाना FASTag पास ₹3,075; दोपहिया वाहनों को अनुमति नहीं')
rep('→ <strong>Price impact:</strong> Banthra, Unnao और Bani में land values 2019 से significantly बढ़ी हैं और corridor analysis के अनुसार 2027 तक 40–60% और बढ़ सकती हैं',
    '→ <strong>लागत:</strong> करीब ₹4,700 करोड़; निर्माण PNC Infratech ने किया')
rep('<p>तुलना के लिए: जब Purvanchal Expressway खुला, तब Lucknow end के 5 km के अंदर की ज़मीन 18 महीनों में 25–35% appreciate हुई। अवध एक्सप्रेसवे छोटा और ज़्यादा urban है — Banthra और Bani zones पर price impact ज़्यादा concentrated और तेज़ होगा।</p>',
    '<p><strong>कीमत पर असर:</strong> एक्सप्रेसवे से ज़मीन की कीमत कितनी बढ़ेगी, इसका कोई भरोसेमंद आंकड़ा अभी उपलब्ध नहीं है। "एक्सप्रेसवे टच" बताकर ऊंची कीमत मांगने वाले विक्रेताओं से सावधान रहें — खासकर जब तक सड़क की मरम्मत और टोल का मामला सुलझ न जाए।</p>')
rep('→ <strong>Zone B (Banthra):</strong> Maximum beneficiary — elevated section इसी zone से जाता है। Opening से पहले खरीदें — maximum appreciation के लिए।',
    '→ <strong>Zone B (Banthra):</strong> एक्सप्रेसवे इसी पट्टी से गुजरता है, इसलिए कनेक्टिविटी का सबसे सीधा फायदा यहीं है। नगर पंचायत की मंज़ूरी और Khatauni की जांच के बिना न खरीदें।')
rep('→ <strong>Zone C (Banthara/Natkur):</strong> Long-term beneficiary', '→ <strong>Zone C (Bani के आगे):</strong> Long-term beneficiary')

# ── buy / avoid ───────────────────────────────────────────
rep('— अवध एक्सप्रेसवे + RRTS proposal + Airport expansion medium-term value triggers हैं', '— एक्सप्रेसवे खुल चुका है, एयरपोर्ट और डिफेंस कॉरिडोर पास हैं')
rep('— airport staff, Amazon warehouse workers और defence corridor employees से rental demand consistent है', '— airport staff और defence corridor (ब्रह्मोस यूनिट) के कर्मचारियों से किराये की मांग')
rep('— यहाँ verified plots fundamentals के मुक़ाबले genuinely underpriced हैं', '— सही जांच के साथ यहां शहर के दूसरे कॉरिडोर से कम entry price मिलता है')
rep('— Expressway opening expected से देर हो सकती है (May 2026 के latest delay से यह साबित); immediate post-opening liquidity पर भरोसा न करें',
    '— एक्सप्रेसवे खुलने के बाद भी सड़क धंसने और टोल रुकने जैसी दिक्कतें आईं; तुरंत अच्छी resale कीमत पर भरोसा न करें')

# ── projects ──────────────────────────────────────────────
rep('<strong>Location:</strong> Banthara, Kanpur Road<br>', '<strong>Location:</strong> Banthra (Banthara), Kanpur Road<br>')

# ── buyer profiles ────────────────────────────────────────
rep('<strong>क्यों:</strong> अवध एक्सप्रेसवे 2026 में खुलने से पहले खरीदें। Elevated section इसी zone से जाता है। UP real estate history में infrastructure corridors पर post-opening appreciation consistent और well-documented है।',
    '<strong>क्यों:</strong> जुलाई 2026 में खुला एक्सप्रेसवे इसी पट्टी से गुजरता है, जिससे कानपुर और शहर दोनों तक पहुंच आसान हुई है। कीमत कितनी बढ़ेगी इसकी कोई गारंटी नहीं — सिर्फ जांचे हुए, मंज़ूर प्लॉट लें।')
rep('अवध एक्सप्रेसवे + RRTS proposal मिलकर इस price point पर लखनऊ की best long-term rupee-hedged land entry बनाते हैं।', 'एक्सप्रेसवे और एयरपोर्ट की नज़दीकी इसे लंबी अवधि के लिए देखने लायक बनाती है।')
rep('हर बार unapproved Zone C से Banthra को preferred करें।', 'Unapproved Zone C की जगह मंज़ूर Banthra colony चुनें।')

# ── risks + checklist ─────────────────────────────────────
rep('अवध एक्सप्रेसवे alignment ने Banthra–Bani–Banthara belt में', 'अवध एक्सप्रेसवे ने Banthra–Bani belt में')
rep('→ Banthra और Banthara का ज़्यादातर हिस्सा Nagar Panchayat jurisdiction में आता है — LDA में नहीं। यह उस approval category से अलग है जो ज़्यादातर buyers expect करते हैं',
    f'→ बंथरा 2023 में 10 गांवों (रामचौरा, हमीरपुर, किशनपुर कौड़िया, बंथरा, जहानाबाद, लाला खेड़ा, खांडेदेव, पुराही खेड़ा, शिवपुरा, औरावां) को मिलाकर नगर पंचायत बना ({ETV_NP}) — यहां की कई कॉलोनियां LDA क्षेत्र में नहीं आतीं')
rep('कई पुरानी Banthra-area colonies में 6–7.5 metre internal roads हैं। 2026 Compounding Policy के तहत sub-9-metre roads पर plots regularised नहीं हो सकते। Layout map physically check करें।',
    'कई पुरानी Banthra-area colonies में 6–7.5 metre internal roads हैं। संकरी सड़क पर नक्शा पास कराने में दिक्कत आ सकती है — LDA या नगर पंचायत से उस सड़क की न्यूनतम चौड़ाई का नियम पूछें और layout map मौके पर मिलाएं।')

# ── FAQ answers ───────────────────────────────────────────
rep('Zone C (Banthara/Natkur frontier) में approved plots ₹900–₹1,300/sqft और unapproved agricultural ज़मीन ₹500–₹900/sqft।', 'Zone C (Bani के आगे) में approved plots ₹900–₹1,300/sqft और unapproved agricultural ज़मीन ₹500–₹900/sqft। ये मई 2026 के लिस्टिंग रेट हैं, रजिस्ट्री की कीमत नहीं।')
rep('अवध एक्सप्रेसवे (NE-6) 2026 में शुरू होने वाला है और इसका elevated section Zone B से होकर जाता है — यह Banthra-area plots के लिए सालों का सबसे बड़ा single price trigger है।',
    'अवध एक्सप्रेसवे (NE-6) 13 जुलाई 2026 को खुल चुका है और Banthra–Bani पट्टी से होकर गुजरता है। सड़क धंसने के कारण अगस्त से टोल रुका है और मरम्मत बाकी है।')
rep('इसका elevated section Amausi–Bani zone से Kanpur Road पर होकर जाता है। May 2026 के Wikipedia/NHAI tracker के अनुसार Lucknow package में अभी कुछ ramps और toll plazas का काम बाकी है — opening date आगे खिसकी है। Historically, जब UP में major expressway खुलता है, तो Lucknow-end junction के 5 km के अंदर की ज़मीन 18 महीनों में 25–40% appreciate होती है। Banthra और Bani plots इसके primary beneficiaries होंगे।',
    'इसका उद्घाटन 13 जुलाई 2026 को हुआ; कार का टोल ₹275 एक तरफ तय हुआ और सफर करीब 35–40 मिनट का है। 26 जुलाई को सड़क धंसने के बाद NHAI ने टोल वसूली रोकी और मरम्मत की योजना बनाई। Banthra और Bani को कनेक्टिविटी का सीधा फायदा है, लेकिन कीमत कितनी बढ़ेगी इसका कोई भरोसेमंद आंकड़ा नहीं — "expressway touch" के नाम पर ऊंची कीमत से सावधान रहें।')
rep('Transport Nagar metro station शहर भर की connectivity देता है।', 'मेट्रो की रेड लाइन CCS Airport से शुरू होती है; Amausi और Transport Nagar स्टेशन भी यहीं हैं।')
rep('Banthra Sikander Pur की gated societies में ~₹8.5 लाख से शुरू होते हैं — 1,000 sqft (₹850/sqft) के लिए। यह 2026 में लखनऊ में सबसे कम-cost legal plot entry है।',
    'Banthra Sikander Pur की gated societies में मई 2026 की लिस्टिंग के अनुसार ~₹8.5 लाख से दिखते हैं — 1,000 sqft (₹850/sqft) के लिए।')
rep('(2) Banthra और Banthara में unapproved colonies', '(2) Banthra–Bani पट्टी में unapproved colonies')
rep('कानपुर रोड पर Banthra और Banthara में क्या फर्क है?', 'कानपुर रोड पर Banthra और Banthara — क्या ये अलग जगहें हैं?')
rep('Banthra (Zone B) और Banthara (Zone C) दो अलग pockets हैं — हालांकि नाम मिलते-जुलते हैं। Banthra शहर के पास है, Banthra Market और Banthra Sikander Pur मिलाकर, और इसकी ज़्यादातर gated societies Nagar Panchayat approved हैं — bank loan feasible है। Banthara आगे expressway frontier की तरफ है, ज़्यादातर agricultural ज़मीन है जिसका कुछ हिस्सा approved होकर gated societies बना है। कीमत में Banthra ₹850–₹2,000/sqft पर है, Banthara unapproved में ₹500–₹900 और approved में ₹900–₹1,300/sqft। खरीदते समय यह confirm करना ज़रूरी है कि plot exactly किस pocket में है — सिर्फ नाम सुनकर assume न करें।',
    f'नहीं — Banthra और Banthara एक ही जगह (बंथरा) के दो अंग्रेज़ी स्पेलिंग हैं; नगर पंचायत की अपनी वेबसाइट भी "npbanthara" नाम से है। बंथरा 2023 में 10 गांवों को मिलाकर नगर पंचायत बना ({ETV_NP})। असली फर्क स्पेलिंग का नहीं, प्लॉट की कानूनी स्थिति का है — नगर पंचायत की मंज़ूर कॉलोनी है या खेती की ज़मीन। रजिस्ट्री से पहले खसरा नंबर से Khatauni और मंज़ूरी दोनों जांचें।')
rep('Banthra और Banthara (Zone B/C) का ज़्यादातर हिस्सा Nagar Panchayat के अधीन आता है।', 'बंथरा नगर पंचायत (Zone B) और उसके आसपास के कई गांव LDA क्षेत्र में नहीं आते।')
rep('अवध एक्सप्रेसवे + RRTS proposal + Airport expansion मिलकर इसे लखनऊ की best long-term entry बनाते हैं — Gomti Nagar Extension या Raebareli Road जैसे expensive corridors के मुक़ाबले।',
    'खुला हुआ एक्सप्रेसवे और एयरपोर्ट इसे Gomti Nagar Extension या Raebareli Road जैसे महंगे कॉरिडोर के मुक़ाबले कम entry price वाला विकल्प बनाते हैं।')
rep('अवध एक्सप्रेसवे 2026, Defence Corridor + Amazon warehousing employment, और सबसे सस्ता legal plot entry (₹850/sqft Banthra)।', 'जुलाई 2026 में खुला अवध एक्सप्रेसवे, Defence Corridor (ब्रह्मोस यूनिट), और कम entry price (लिस्टिंग ₹850/sqft से, Banthra)।')
rep('2026–28 की horizon पर appreciation expectations: कानपुर रोड का Zone B (Banthra) expressway opening से ज़्यादा upside देगा। ', '')

# ── buttons: no "free verification" promise (the service is ₹5,000) ──
rep('{{CONSULTATION_BUTTON:मेरा Kanpur Road Plot Verify करें — DSD से Free Expert Check}}', '{{CONSULTATION_BUTTON:प्रॉपर्टी वेरिफिकेशन कराएँ — ₹5,000}}')

# ── checks + write ────────────────────────────────────────
t = re.sub('<[^>]+>', ' ', re.sub(r'<script\b.*?</script>', '', h, flags=re.S))
for bad in ['Amazon', 'RRTS', '40–60%', '25–35%', '25–40%', 'Natkur', 'south terminus', 'मई 2026 के latest', 'Compounding Policy', '2026 में शुरू होने वाला', 'खुलने वाला है']:
    if bad in t: sys.exit(f'ABORT stale text left: {bad}')
open('new.html', 'w', encoding='utf8', newline='').write(h.replace('\n', '\r\n'))

faqs = re.findall(r'<div class="faq-q"[^>]*>(.*?)<span class="faq-toggle".*?</div>\s*<div class="faq-a"[^>]*>(.*?)</div>', h, re.S)
assert len(faqs) == 11, len(faqs)
schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
    {"@type": "Question", "name": re.sub('<[^>]+>', '', q).strip(), "acceptedAnswer": {"@type": "Answer", "text": re.sub(r'\s+', ' ', re.sub('<[^>]+>', '', a)).strip()}} for q, a in faqs]}
meta = {
 "title": "कानपुर रोड लखनऊ प्लॉट 2026: एक्सप्रेसवे खुला, बंथरा-सरोजिनी नगर रेट, 3 जोन और लीगल चेकलिस्ट",
 "meta_description": "कानपुर रोड लखनऊ में प्लॉट: लखनऊ–कानपुर एक्सप्रेसवे 13 जुलाई 2026 को खुला। बंथरा, सरोजिनी नगर, बनी के लिस्टिंग रेट, सर्किल रेट और खरीद से पहले की जांच।",
 "blog_summary": "कानपुर रोड (NH-27) लखनऊ का प्लॉट कॉरिडोर जहां CCS एयरपोर्ट है और लखनऊ–कानपुर एक्सप्रेसवे 13 जुलाई 2026 को खुल चुका है (अगस्त से टोल मरम्मत के कारण रुका)। तीनों जोन — एयरपोर्ट बेल्ट, बंथरा नगर पंचायत और बनी के आगे — के लिस्टिंग रेट, सर्किल रेट, RERA प्रोजेक्ट और खरीद से पहले की कानूनी जांच।",
 "seo_schema": json.dumps(schema, ensure_ascii=False, indent=2)}
json.dump(meta, open('newmeta.json', 'w', encoding='utf8'), ensure_ascii=False, indent=1)
print('ok', len(h0), len(h), 'faqs', len(faqs), 'meta', len(meta['meta_description']))
