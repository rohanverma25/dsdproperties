# Fact update of post 100 (Plots on Raebareli Road, EN) — 18 Oct 2026.
import json, re, sys

h0 = open('before.html', encoding='utf8', newline='').read()
h = h0.replace('\r\n', '\n')

def rep(old, new, n=1):
    global h
    c = h.count(old)
    if c != n: sys.exit(f'ABORT: expected {n}, found {c}: {old[:100]!r}')
    h = h.replace(old, new)

def A(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'
PGI_FLY = A('https://www.amritvichar.com/article/594143/4-lane-flyover-built-opposite-lucknow-pgi', 'Amrit Vichar, 24 Sep 2026')
TELI = A('https://www.thesandeshwahak.com/lucknow-telibagh-four-lane-flyover-approved-145-crore-project/', 'Sandesh Wahak, 29 Sep 2026')
PGI_JOBS = A('https://www.patrika.com/lucknow-news/lucknow-pgi-approves-2314-recruitments-including-614-doctors-to-boost-healthcare-services-20457384', 'Patrika, 28 Mar 2026')
PGI_PED = A('https://www.etvbharat.com/hi/state/advanced-pediatric-center-with-573-beds-will-be-built-sgpgi-uttar-pradesh-news-ups26032706055', 'ETV Bharat, 27 Mar 2026')
VIG = A('https://www.amritvichar.com/article/558464/span-classt-redlucknow-%C2%A0span-250-km-long-vigyan-path-will-connect', 'Amrit Vichar, 3 Nov 2025')
SKY = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/skyom-city/upreraprj600292/06/2025', 'UP RERA record')
PAT = A('https://www.patrika.com/lucknow-news/circle-rates-doubled-in-332-villages-of-lucknow-ahead-of-expressway-project-20638488', 'Patrika, 5 Jun 2026')
MLG = A('https://www.amarujala.com/lucknow/lucknow-news-lucknow-news-c-13-1-lko1069-1954421-2026-10-06', 'Amar Ujala, 6 Oct 2026')
KP = A('https://www.amarujala.com/lucknow/up-building-plans-along-kisan-path-to-be-approved-by-lda-paving-the-way-for-new-townships-and-colonies-deci-2026-10-14', 'Amar Ujala, 14 Oct 2026')
LI = '<li style="margin-bottom: 12px;">'

# ── sources line + key facts ─────────────────────────────
rep('<p style="font-size: 13px; color: #6b7280; margin: 0 0 28px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0;">Sources: Actual plot listings from 99acres, Nestoria, Squareyards, 360plot.com, Regrob (plot-specific transactions only — no apartment or flat data used). Verified April 2026.</p>',
    '<p style="font-size: 13px; color: #6b7280; margin: 0 0 28px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0;">Sources: Amar Ujala, Amrit Vichar, Patrika, ETV Bharat, Sandesh Wahak, UP RERA records. Plot rates: listings on 99acres, Nestoria, Squareyards, 360plot.com and Regrob (April 2026, asking prices). <strong>Updated: 18 October 2026.</strong></p>\n'
    '<!-- key-facts -->\n<div class="dsd-key-facts" style="background:#f0fdfa;border:1px solid rgba(0,128,128,0.25);border-left:4px solid #008080;border-radius:0 12px 12px 0;padding:16px 20px;margin:0 0 24px;">\n'
    '  <p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">Key Facts (updated 18 October 2026)</p>\n  <ul style="margin:0;padding-left:20px;">\n'
    f'    <li style="margin:5px 0;line-height:1.7;">A <strong>1.5 km, 4-lane flyover opposite SGPGI</strong> on Raebareli Road was approved in September 2026 at ₹192.79 crore ({PGI_FLY}). A separate 858 m flyover at <strong>Telibagh crossing</strong> (₹145.99 crore) is approved and waiting for funds ({TELI}).</li>\n'
    f'    <li style="margin:5px 0;line-height:1.7;"><strong>SGPGI</strong> approved 2,314 new posts, including 614 doctors, in March 2026 ({PGI_JOBS}), plus a <strong>573-bed advanced paediatric centre</strong> ({PGI_PED}).</li>\n'
    f'    <li style="margin:5px 0;line-height:1.7;">The 250 km, 6-lane <strong>Vigyan Path</strong> ring road linking Lucknow with five districts, including Raebareli, has state approval; LDA is preparing the project report and the exact route is not yet public ({VIG}).</li>\n'
    f'    <li style="margin:5px 0;line-height:1.7;"><strong>Skyom City</strong> (Mohanlalganj) got RERA registration UPRERAPRJ600292 on 1 June 2025: 659 plots, completion date 31 May 2029 ({SKY}).</li>\n'
    f'    <li style="margin:5px 0;line-height:1.7;">From June 2026, farmland circle rates rose in <strong>161 villages of Mohanlalganj tehsil</strong>, part of a 332-village revision ({PAT}).</li>\n'
    '  </ul>\n</div>')

# ── stats bar ─────────────────────────────────────────────
rep('<span class="dsd-stat-label">Plot Rate Range / sqft</span>', '<span class="dsd-stat-label">Listing Rate Range / sqft</span>')
rep('<div class="dsd-stat-item"><span class="dsd-stat-num">500+</span><span class="dsd-stat-label">Active Plot Listings</span></div>',
    '<div class="dsd-stat-item"><span class="dsd-stat-num">₹192.79 Cr</span><span class="dsd-stat-label">PGI Flyover Approved</span></div>')
rep('<div class="dsd-stat-item"><span class="dsd-stat-num">~1 km</span><span class="dsd-stat-label">Nearest Plot to SGPGI</span></div>',
    '<div class="dsd-stat-item"><span class="dsd-stat-num">2,314</span><span class="dsd-stat-label">New SGPGI Posts</span></div>')

# ── latest updates ────────────────────────────────────────
rep('<span style="font-size: 20px;">📰</span> Latest Market Updates</h4>', '<span style="font-size: 20px;">📰</span> Latest Updates — Raebareli Road (18 October 2026)</h4>')
rep('<li style="margin-bottom: 12px;"><strong>April 2026:</strong> SGPGI Phase 3 expansion announced — 500+ new positions expected by Q4 2027, driving rental demand in Zone A</li>\n'
    '<li style="margin-bottom: 12px;"><strong>March 2026:</strong> SCR Vigyan Path alignment confirmed at Kalli Pashchim intersection — Zone B plots seeing 8-12% inquiry spike</li>\n'
    '<li style="margin-bottom: 0;"><strong>February 2026:</strong> Skyom City receives RERA approval (UPRERAPRJ600292) — first premium gated community in Zone C with May 2029 possession</li>',
    LI + f'<strong>14 October 2026:</strong> LDA is preparing a policy to approve building maps along Kisan Path for the first time (43 villages). The board meeting that was to decide it has been postponed. ({KP})</li>\n'
  + LI + f'<strong>6 October 2026:</strong> LDA demolished four illegal plotting sites on about 15 bigha in the Mohanlalganj area (Devha village, Ranikheda and Maurawan Road). ({MLG})</li>\n'
  + LI + f'<strong>29 September 2026:</strong> An 858 m, 4-lane flyover at Telibagh crossing (₹145.99 crore, Setu Nigam) cleared the Expenditure Finance Committee; tender after funds are released, about 1.5–2 years to build. ({TELI})</li>\n'
  + LI + f'<strong>24 September 2026:</strong> A 1.5 km, 4-lane flyover opposite SGPGI on the Lucknow–Raebareli highway was approved at ₹192.79 crore by the Chief Secretary\'s committee. ({PGI_FLY})</li>\n'
  + LI + f'<strong>5 June 2026:</strong> New DM circle rates for farmland took effect in 332 villages of Lucknow — 161 of them in Mohanlalganj tehsil. ({PAT})</li>\n'
  + LI + f'<strong>27–28 March 2026:</strong> SGPGI\'s governing body approved a 573-bed advanced paediatric centre and 2,314 posts, including 614 doctors and 1,540 nursing and technician posts. ({PGI_PED}, {PGI_JOBS})</li>\n'
  + '<li style="margin-bottom: 0;">' + f'<strong>1 June 2025:</strong> Skyom City (Mohanlalganj, Bihani Construction) registered with UP RERA as UPRERAPRJ600292 — 659 plots, completion due 31 May 2029. ({SKY})</li>')

# ── opportunities box ─────────────────────────────────────
rep('<li style="margin-bottom: 12px;">Omaxe Metro City 1 km from SGPGI — strong rental income potential</li>', '<li style="margin-bottom: 12px;">Omaxe Metro City (Kalli Pashchim) — developer township with smaller plot sizes</li>')
rep('<span style="font-size: 20px;">✅</span> Verified Opportunities</h4>', '<span style="font-size: 20px;">✅</span> Opportunities to Look At</h4>')
rep('<li style="margin-bottom: 12px;">DLF Garden City plots at ₹2,100/sqft — 50% discount vs', '<li style="margin-bottom: 12px;">DLF Garden City plots listed from ₹2,100/sqft — well below')

# ── intro ─────────────────────────────────────────────────
rep('giving buyers across budgets a genuine entry on a corridor with four confirmed infrastructure triggers.', 'giving buyers across budgets an entry on a corridor with new road projects now approved.')
rep('and <strong>Kisan Path</strong> at the southern end, which now links the corridor to every major road in Lucknow.', 'and <strong>Kisan Path</strong>, the outer ring road that crosses it at the southern end and links it to every major road in Lucknow.')

# ── why 2026 ──────────────────────────────────────────────
rep('<p>Four convergence triggers are simultaneously active on this corridor. When multiple demand catalysts align on a single corridor, appreciation is faster and more durable than single-driver zones.</p>',
    '<p>Four things are driving demand on this corridor. Here is where each one actually stands, with sources.</p>')
rep('<h4>📍 The 4 Convergence Triggers</h4>', '<h4>📍 The 4 Demand Drivers</h4>')
rep('<li><strong>SGPGI Medical Hub</strong> — Directly on the highway. One of India\'s top postgraduate medical institutions, employing thousands. Phase 3 expansion adds 500+ staff by 2027. Medical institution proximity = permanent, recession-proof rental demand within 5 km</li>',
    f'<li><strong>SGPGI Medical Hub</strong> — Directly on the highway. In March 2026 its governing body approved 2,314 new posts, including 614 doctors ({PGI_JOBS}), and a 573-bed paediatric centre ({PGI_PED}). More staff means steady rental demand nearby.</li>')
rep('<li><strong>Kisan Path Outer Ring Road</strong> — Raebareli Road terminates at the 104 km ring road, connecting this corridor to Sultanpur Road (IT City), Faizabad Road (Juggaur), and Kanpur Road. A full-city connectivity unlock that completed in 2024</li>',
    f'<li><strong>Kisan Path Outer Ring Road</strong> — The ring road crosses Raebareli Road at the southern end and connects it to Sultanpur Road (IT City), Faizabad Road and Kanpur Road. In October 2026 LDA proposed approving building maps along Kisan Path for the first time ({KP}).</li>')
rep('<li><strong>SCR Vigyan Path</strong> — Confirmed alignment intersects Raebareli Road at Kalli Pashchim. Connects the Defence Corridor, Ordnance Factory zone, and Raebareli highway in a direct high-speed link — major Zone B value driver</li>',
    f'<li><strong>Vigyan Path</strong> — A 250 km, 6-lane road linking Lucknow with Sitapur, Unnao, Hardoi, Barabanki and Raebareli, approved by the state. LDA is preparing the project report; the exact route and where it crosses Raebareli Road are not public yet ({VIG}).</li>')
rep('A 50–75% entry discount for a corridor with confirmed infrastructure investment — a gap that historically closes as infrastructure matures</li>', 'A much lower entry price than the premium corridors, based on April 2026 listings.</li>')
rep('<li><strong>Price gap vs premium corridors</strong> — DLF Garden City plots at ₹2,100–₹2,500/sqft', '<li><strong>Price gap vs premium corridors</strong> — DLF Garden City plots listed at ₹2,100–₹2,500/sqft')

# ── zones ─────────────────────────────────────────────────
rep('SCR Vigyan Path confirmed alignment will directly impact this belt. Multiple LDA-approved layouts active. This is the sweet spot in 2026 — infrastructure incoming but not yet fully priced in. Best for 3–5 year investors.',
    'Multiple LDA-approved layouts are active. The approved PGI and Telibagh flyovers should ease the drive into the city once built. Suits 3–5 year buyers who verify every plot.')
rep('<div class="dsd-zone-tag">Active Development · Best 2026 Entry</div>', '<div class="dsd-zone-tag">Active Development · Established Townships</div>')
rep('Mohanlalganj\'s strong appreciation is spilling into this belt. Skyom City is the first premium RERA project here.',
    'Farmland circle rates in Mohanlalganj tehsil were revised upward in June 2026, and LDA demolished illegal plotting here in October 2026. Skyom City (RERA, 2025) is a gated project at this end.')
rep('<div class="dsd-zone-tag">Affordable · Highest Upside · Verify Everything</div>', '<div class="dsd-zone-tag">Affordable · Highest Legal Risk · Verify Everything</div>')

# ── prices ────────────────────────────────────────────────
rep('<h2 id="prices">Verified Plot Price Data 2026 — Zone by Zone</h2>', '<h2 id="prices">Plot Listing Rates 2026 — Zone by Zone</h2>')
rep('<li><a href="#prices">Verified Plot Price Data 2026</a></li>', '<li><a href="#prices">Plot Listing Rates 2026</a></li>')
rep('⚠️ <strong>Data note:</strong> All prices below are from actual plot listings on 99acres, Nestoria, Squareyards, 360plot.com, and confirmed developer BSP rates — not blended portal averages. Apartment/flat rates have been excluded entirely.',
    f'⚠️ <strong>Data note:</strong> Prices below are <strong>asking prices</strong> from plot listings on 99acres, Nestoria, Squareyards and 360plot.com, plus developer BSP rates, as seen in April 2026 — not registered sale prices. Apartment rates are excluded. Before you agree a price, check recent registries in the same colony and the DM circle rate (revised for Mohanlalganj farmland in June 2026 — {PAT}).')
rep('<th>Verified Rate (₹/sqft)</th>', '<th>Listing Rate (₹/sqft)</th>')
rep('<th>Sample Transaction</th>', '<th>Sample Listing</th>')
rep('<li><a href="#projects">Top RERA-Verified Projects</a></li>', '<li><a href="#projects">Main Projects and RERA Status</a></li>')

# ── buy / avoid ───────────────────────────────────────────
rep('— SGPGI expansion, SCR Vigyan Path, and RRTS take time to price in</li>', '— the SGPGI and Telibagh flyovers and Vigyan Path are approved but still years from completion</li>')
rep('— strong rental demand, RERA verification easy, proven appreciation</li>', '— rental demand from SGPGI staff, and RERA records are easy to check online</li>')
rep('— verified plots here are genuinely underpriced vs premium corridors</li>', '— properly checked plots here cost less than in the premium corridors</li>')

# ── projects ──────────────────────────────────────────────
rep('<h2 id="projects">Top RERA-Verified Projects on Raebareli Road 2026</h2>', '<h2 id="projects">Main Projects on Raebareli Road and Their RERA Status</h2>')
rep('<br><strong>Distance:</strong> ~1 km from SGPGI<br>', '<br>')
rep('<div class="dsd-project-detail"><strong>Location:</strong> Mohanlalganj, Zone C<br><strong>Plot sizes:</strong> 1,467–2,205 sqft<br><strong>Possession:</strong> May 2029<br><strong>Type:</strong> Premium plots + villas — first RERA gated community at this end of corridor<br><strong>Amenities:</strong> Pool, gym, clubhouse</div>',
    f'<div class="dsd-project-detail"><strong>Location:</strong> Mohanlalganj, Zone C<br><strong>Developer:</strong> Bihani Construction Pvt Ltd<br><strong>RERA:</strong> registered 1 June 2025; 659 plots; completion date 31 May 2029 ({SKY})<br><strong>Plot sizes:</strong> 1,467–2,205 sqft<br><strong>Amenities:</strong> Pool, gym, clubhouse</div>')

# ── buyer profiles ────────────────────────────────────────
rep('<strong>Why:</strong> SCR Vigyan Path + Kisan Path = upcoming value unlock. Buy RERA-approved plots before infrastructure premium reflects in price. Skyom City and Suraksha Enclave new launches are the target.',
    '<strong>Why:</strong> Kisan Path is open, and the PGI flyover, Telibagh flyover and Vigyan Path are approved. Stick to RERA-registered or LDA-approved plots — Skyom City and Suraksha Enclave are examples to check.')
rep('Rental demand from SGPGI is year-round, recession-proof, and growing with Phase 3 expansion.', 'SGPGI approved 2,314 new posts and a 573-bed paediatric centre in March 2026, which supports year-round rental demand.')

# ── infrastructure ────────────────────────────────────────
rep('<h4>🏗️ Confirmed Infrastructure Triggers</h4>', '<h4>🏗️ Infrastructure — Status as of October 2026</h4>')
rep('<li><strong>Kisan Path (Outer Ring Road)</strong> — 104 km fully operational. Raebareli Road terminates at the ring road, unlocking connectivity to every major highway corridor in Lucknow. Permanent commercial and residential value driver</li>',
    f'<li><strong>Kisan Path (Outer Ring Road)</strong> — Operational, and crosses Raebareli Road at the southern end, linking it to every major highway out of Lucknow. LDA has proposed approving building maps along it for the first time; the board has not yet decided ({KP}).</li>')
rep('<li><strong>SCR Vigyan Path</strong> — Confirmed alignment intersects at Kalli Pashchim. Direct link to Defence Corridor and Ordnance Factory zone. Expected to drive 15–25% Zone B appreciation over 18 months post-completion</li>',
    f'<li><strong>PGI flyover</strong> — 1.5 km, 4-lane, opposite SGPGI on the Lucknow–Raebareli highway; approved at ₹192.79 crore in September 2026, construction start date not announced ({PGI_FLY}).</li>\n'
    f'<li><strong>Telibagh flyover</strong> — 858 m, 4-lane, at Telibagh crossing; ₹145.99 crore, cleared by the Expenditure Finance Committee, tender after funds are released ({TELI}).</li>\n'
    f'<li><strong>Vigyan Path</strong> — 250 km, 6-lane road to five districts including Raebareli; state-approved, project report being prepared, route not yet public ({VIG}).</li>')
rep('<li><strong>SGPGI Phase 3 Expansion</strong> — 500+ new staff positions by 2027. Already one of Lucknow\'s top 5 employers. More staff = more housing demand within 5 km radius — directly benefiting Zone A and Zone B</li>',
    f'<li><strong>SGPGI expansion</strong> — 2,314 posts (614 doctors) and a 573-bed paediatric centre approved in March 2026 ({PGI_JOBS}). More staff means more housing demand nearby, mainly in Zone A.</li>')
rep('<li><strong>Lucknow–Raebareli RRTS</strong> — Proposed Rapid Rail Transit corridor along this highway alignment. Still in planning stage but RRTS station announcements historically drive 30–50% price appreciation within 2 km within 2 years of announcement. Worth monitoring closely</li>\n', '')
rep('<li><strong>Defence Corridor spillover</strong> — Ordnance Factory and defence manufacturing on the Vigyan Path–Raebareli axis generating industrial employment and housing demand from contractor and defence worker communities</li>\n', '')

# ── mistakes / checklist (no unsourced policy) ────────────
rep('Under 2026 Compounding Policy, plots without 9-metre confirmed road access cannot get building plan approval.', 'Without legal road access of adequate width, a building plan may not be approved — ask LDA for the minimum road width that applies to the plot.')
rep('Check road widths — minimum 9 metres required under 2026 Compounding Policy.', 'Check road widths against the approved layout and ask LDA for the minimum width that applies.')
rep('<li>LDA has blacklisted 241+ colonies in Lucknow — many are in this corridor belt</li>', f'<li>LDA has listed 241 illegal colonies in Lucknow and keeps demolishing illegal plotting — including in Mohanlalganj in October 2026 ({MLG})</li>')

# ── FAQ answers ───────────────────────────────────────────
rep('DLF entry plots at ₹2,100/sqft against GNE plots at ₹5,000–₹10,000/sqft represents a 50–75% entry discount on a corridor with confirmed infrastructure (SGPGI expansion, SCR Vigyan Path, Kisan Path connectivity). The RRTS proposal adds further upside.',
    'DLF entry plots are listed at ₹2,100/sqft against ₹5,000–₹10,000/sqft in Gomti Nagar Extension. Kisan Path is open; the PGI and Telibagh flyovers and Vigyan Path are approved but not yet built, and SGPGI is expanding.')
rep('Omaxe Metro City is closer to SGPGI (~1 km vs ~5 km for DLF) and offers smaller plot sizes from 1,200 sqft', 'Omaxe Metro City (Kalli Pashchim) offers smaller plot sizes from 1,200 sqft')
rep('For rental income: Omaxe wins on proximity to SGPGI. For long-term land appreciation: DLF wins on size and established township status.', 'Visit both and compare distance to your workplace — for SGPGI staff, Zone A plots in Vrindavan Yojna are closest. DLF suits buyers who want larger plots in an established township.')
rep('Both are LDA and RERA approved.', 'Check the RERA number of the exact phase you are buying on up-rera.in.')

# ── buttons: verification is paid (₹5,000) ───────────────
rep('{{CONSULTATION_BUTTON:Verify My Raebareli Road Plot — Free Expert Check by DSD}}', '{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}')

# ── stale-text guard ──────────────────────────────────────
t = re.sub('<[^>]+>', ' ', re.sub(r'<(style|script)\b.*?</\1>', '', h, flags=re.S))
for bad in ['RRTS', 'Phase 3', 'Kalli Pashchim intersection', 'Confirmed alignment', 'Ordnance', 'Compounding Policy', '15–25%', '30–50%', '8-12%', '~1 km', 'terminates']:
    if bad in t: sys.exit(f'ABORT stale text left: {bad}')
open('new.html', 'w', encoding='utf8', newline='').write(h)

faqs = re.findall(r'<h3>(.*?)</h3>\s*<p>(.*?)</p>', h[h.find('id="FAQs"'):], re.S)
assert len(faqs) == 7, len(faqs)
schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
    {"@type": "Question", "name": re.sub('<[^>]+>', '', q).strip(), "acceptedAnswer": {"@type": "Answer", "text": re.sub(r'\s+', ' ', re.sub('<[^>]+>', '', a)).strip()}} for q, a in faqs]}
meta = {
 "title": "Plots on Raebareli Road Lucknow 2026 — Prices, PGI Flyover & Buyer Guide",
 "meta_description": "Plots on Raebareli Road, Lucknow: zone-wise listing rates, DLF, Omaxe, Skyom City RERA status, the new ₹192 cr PGI flyover, SGPGI expansion and a legal checklist.",
 "blog_summary": "Raebareli Road plot guide, updated 18 October 2026: zone-wise listing rates from Vrindavan Yojna to Mohanlalganj, RERA status of DLF Garden City, Omaxe Metro City, Suraksha Enclave and Skyom City, the approved PGI and Telibagh flyovers, SGPGI's expansion, Vigyan Path's real status and a pre-payment legal checklist.",
 "seo_schema": json.dumps(schema, ensure_ascii=False, indent=2)}
json.dump(meta, open('newmeta.json', 'w', encoding='utf8'), ensure_ascii=False, indent=1)
print('ok', len(h0), len(h), 'faqs', len(faqs), 'meta', len(meta['meta_description']), len(meta['title']))
