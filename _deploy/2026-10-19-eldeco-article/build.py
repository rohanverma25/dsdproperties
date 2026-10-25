# New article: Eldeco in Lucknow — detailed, plain-language guide (EN). 19 Oct 2026.
import json, re

def A(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'
def S(path, text): return f'<a href="https://dsdproperties.in/{path}" style="color:#008080;font-weight:600;">{text}</a>'
IIFL = A('https://www.indiainfoline.com/company/eldeco-housing-industries-ltd/summary', 'IIFL company profile')
HDFC = A('https://cxotoday.com/press-release/hdfc-capital-creates-rs-1500-cr-platform-with-eldeco-group-to-target-revenue-of-rs-11000-cr-across-18-projects-in-tier-2-tier-3-towns/', 'HDFC Capital–Eldeco announcement, 14 Apr 2025')
CALL = A('https://alphastreet.com/india/eldeco-housing-industries-ltd-eldehsg-q3-2026-earnings-call-transcript', 'Eldeco investor call, 11 Feb 2026')
FY26 = A('https://www.multibagg.ai/market-pulse/articles/eldeco-fy26-94886', 'FY26 results summary, 25 May 2026')
BSE = A('https://www.bseindia.com/xml-data/corpfiling/Attachhis/cc79ba0a-73f8-4aa3-bed1-c3a8af9ac4c4.pdf', 'stock exchange filing')
R_TR = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/eldeco-trinity/upreraprj787868', 'RERA record')
R_SW = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/eldeco-skywalk/upreraprj859279/04/2025', 'RERA record')
R_EE = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/eldeco-east-end-at-shaurya/upreraprj513776', 'RERA record')
L_SO = A('https://brokersaathi.com/property/eldeco-solano-gardens-new-jail-road-lucknow-5073', 'listing')
L_SW = A('https://www.propertypistol.com/projects/eldeco-skywalk-iim-road-pid-20540', 'listing')
L_TR = A('https://www.propertypistol.com/projects/eldeco-trinity-gomti-nagar-extension-pid-17998', 'listing')

P = lambda t: f'<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 16px;">{t}</p>'
H2 = lambda i, t: f'<h2 id="{i}" style="font-size:22px;font-weight:700;color:#011f4b;margin:36px 0 12px;border-left:5px solid #FF5C00;padding-left:14px;">{t}</h2>'
H3 = lambda t: f'<h3 style="font-size:18px;font-weight:700;color:#011f4b;margin:24px 0 8px;">{t}</h3>'
UL = lambda items: '<ul style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:6px 0;line-height:1.75;color:#374151;">{i}</li>' for i in items) + '</ul>'
def TABLE(head, rows, minw=560):
    th = ''.join(f'<th style="padding:10px 12px;text-align:left;background:#011f4b;color:#fff;font-size:13.5px;">{h}</th>' for h in head)
    tr = ''.join('<tr>' + ''.join(f'<td style="padding:10px 12px;border:1px solid #e2e8f0;font-size:14px;vertical-align:top;">{c}</td>' for c in r) + '</tr>' for r in rows)
    return f'<div style="overflow-x:auto;margin:16px 0 20px;"><table style="width:100%;border-collapse:collapse;min-width:{minw}px;"><thead><tr>{th}</tr></thead><tbody>{tr}</tbody></table></div>'
BOX = lambda title, inner, c='#008080', bg='#f0fdfa': f'<div style="background:{bg};border:1px solid {c}33;border-left:4px solid {c};border-radius:0 12px 12px 0;padding:16px 20px;margin:18px 0 22px;"><p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>{inner}</div>'
Pm = lambda t: P(t).replace('margin:0 0 16px', 'margin:0')
sqft = lambda m: f'{m*10.7639:,.0f}'

FAQ = [
 ('Is Eldeco a Lucknow company?',
  f'Eldeco Housing & Industries Ltd, the listed company that runs the Eldeco business in Lucknow, is a Lucknow real estate developer listed on the BSE and NSE ({IIFL}). The Eldeco name goes back to 1975, when Eldeco Construction Pvt Ltd was set up ({IIFL}).'),
 ('Who owns Eldeco?',
  f'Pankaj Bajaj is the Chairman and Managing Director of Eldeco Housing & Industries Ltd ({CALL}) and of the Eldeco Group ({HDFC}). As a listed company, its shareholding pattern is published on the BSE and NSE.'),
 ('What are Eldeco\'s current projects in Lucknow?',
  f'Under construction: Eldeco Trinity (Gomti Nagar Extension, due Sep 2028) and Eldeco Skywalk (IIM Road area, due Oct 2029). Launched in January 2026: Eldeco Solano Gardens (villas, plots and group housing). Recently completed: Eldeco East End at Shaurya (RERA completion 15 Mar 2026) and Eldeco Imperia Phase 2 on Kanpur Road (completion certificate in FY26) ({R_TR}, {R_SW}, {CALL}, {R_EE}, {FY26}).'),
 ('Is Eldeco Trinity built by Eldeco Housing & Industries?',
  f'The RERA promoter of Eldeco Trinity is Eldeco Inception Buildtech Private Limited ({R_TR}). Make sure your agreement and payment receipts name the same company as the RERA record.'),
 ('What is the price of plots in Eldeco Solano Gardens?',
  f'In its February 2026 investor call, Eldeco said plots there were priced at about ₹6,000 per sq ft ({CALL}). Prices change — ask for the current price list and the RERA record before booking.'),
 ('Is Eldeco financially stable?',
  f'Its own reported numbers for FY 2025-26: bookings of ₹743.9 crore, collections of ₹352.1 crore and net profit of ₹24.3 crore ({FY26}). In February 2026 it reported about ₹180 crore of cash against about ₹106 crore of debt, with much of the cash held in RERA project accounts ({CALL}). Financial health helps, but always check your own project\'s RERA progress.'),
]

b = []
b.append('<p style="font-size:13px;color:#6b7280;margin:0 0 24px;padding-bottom:14px;border-bottom:1px solid #e2e8f0;">Sources: Eldeco Housing & Industries stock-exchange filings and investor call, UP RERA project records (via Aurum PropTech\'s RERA mirror), HDFC Capital–Eldeco announcement, IIFL company profile, and project listings where marked. Independent guide by DSD Properties — we are not affiliated with Eldeco. <strong>Updated: 19 October 2026.</strong></p>')
b.append('<!-- key-facts -->\n' + BOX('Key Facts (updated 19 October 2026)', '<ul style="margin:0;padding-left:20px;">' + ''.join(f'<li style="margin:5px 0;line-height:1.7;">{x}</li>' for x in [
  f'<strong>Eldeco</strong> started in <strong>1975</strong> as Eldeco Construction Pvt Ltd. Its Lucknow business is run by <strong>Eldeco Housing & Industries Ltd</strong>, incorporated in 1985 and listed on the BSE and NSE ({IIFL}).',
  f'<strong>Chairman & MD: Pankaj Bajaj</strong> ({CALL}).',
  f'FY 2025-26 (company-reported): <strong>bookings ₹743.9 crore</strong>, up 120% on the previous year; net profit ₹24.3 crore ({FY26}).',
  f'Current Lucknow projects: <strong>Trinity</strong> (Gomti Nagar Extension, RERA due Sep 2028), <strong>Skywalk</strong> (due Oct 2029) and <strong>Solano Gardens</strong> (launched Jan 2026) ({R_TR}, {R_SW}, {CALL}).',
  f'Some projects are registered by a <strong>project company</strong>, not the listed firm — Trinity\'s RERA promoter is Eldeco Inception Buildtech Pvt Ltd ({R_TR}).']) + '</ul>'))
b.append(P('Eldeco is one of the oldest developer names in Lucknow — you will see it on townships, apartments and plotted colonies across the city, from Gomti Nagar Extension to Kanpur Road. This guide explains, in simple words, who Eldeco is, how its companies are organised, how it is doing financially, what it is building in Lucknow right now, and what you should check before you buy. Every fact links to its source; where we rely on a listing or on the company\'s own claim, we say so.'))

b.append(H2('who', 'Who is Eldeco? (in simple words)'))
b.append(P(f'The Eldeco Group was started in <strong>1975</strong> as Eldeco Construction Pvt Ltd, founded by S K Garg, a civil-engineering lecturer turned businessman ({IIFL}). The listed company, Eldeco Housing & Industries Ltd, was incorporated in 1985 and is described as a leading real estate developer in Lucknow, building townships, homes, commercial property and developed plots ({IIFL}).'))
b.append(P('Today, two companies carry the Eldeco name, and it helps to know the difference:'))
b.append(TABLE(['Company', 'What it is', 'Where it works', 'Source'], [
 ['<strong>Eldeco Housing & Industries Ltd</strong>', 'Listed on the BSE and NSE; incorporated in 1985', 'Lucknow — this is the company behind most Eldeco projects you see in the city', IIFL],
 ['<strong>Eldeco Infrastructure & Properties Ltd</strong>', 'Unlisted group company', 'Other North Indian cities; in April 2025 it set up a ₹1,500 crore platform with HDFC Capital for 18 projects in Panipat, Sonipat, Rudrapur, Ludhiana, Kasauli and Rishikesh', HDFC],
]))
b.append(P(f'Both are led by <strong>Pankaj Bajaj</strong>, Chairman & Managing Director ({CALL}, {HDFC}). The group says it has delivered over 200 projects; in April 2025 it put its delivered area at over 60 million sq ft ({HDFC}). These are the group\'s own figures.'))
b.append(BOX('What this means for you', Pm('A listed company has to publish its accounts and results every quarter, so you can see how Eldeco Housing is doing. But each project is registered on RERA by a specific company — sometimes the listed firm, sometimes a separate project company. Your agreement must be with the company named on your project\'s RERA record.')))

b.append(H2('financials', 'How is Eldeco doing financially?'))
b.append(P('These are Eldeco Housing & Industries\' own reported figures. They describe the listed company\'s business, which is mostly Lucknow.'))
b.append(TABLE(['Measure', 'Figure', 'Source'], [
 ['Bookings (sales value), FY 2025-26', '₹743.9 crore — up 120.4% on FY25', FY26],
 ['Collections, FY 2025-26', '₹352.1 crore — up 38.7%', FY26],
 ['Total income, FY 2025-26', '₹175.7 crore (FY25: ₹143.7 crore)', FY26],
 ['Net profit, FY 2025-26', '₹24.3 crore', FY26],
 ['Cash vs debt (Feb 2026)', 'About ₹180 crore cash vs about ₹106 crore debt; much of the cash sits in RERA project accounts', CALL],
 ['Homes delivered, Apr–Dec 2025', '254 homes (2.6 lakh sq ft)', CALL],
 ['Pipeline', 'Three new Lucknow land parcels with a gross development value of nearly ₹2,000 crore; total unsold pipeline about ₹4,000 crore', FY26],
]))
b.append(P(f'In the February 2026 call, Pankaj Bajaj described Lucknow as "an under penetrated market" in "a multi year upcycle", and said the company had won several LDA land auctions ({CALL}).'))

b.append(H2('projects', 'Eldeco\'s current projects in Lucknow'))
b.append(P('"RERA completion date" is the date the promoter committed to in its registration; it can be extended, so always check the live record on up-rera.in.'))
b.append(TABLE(['Project', 'Where', 'RERA no. / promoter', 'Registered', 'RERA completion', 'What it is'], [
 [f'<strong>Eldeco Trinity</strong> ({R_TR})', f'Gomti Nagar Extension, off Shaheed Path ({L_TR}); RERA: Sarojini Nagar tehsil', 'UPRERAPRJ787868 — Eldeco Inception Buildtech Pvt Ltd', '1 Dec 2023', '20 Sep 2028 — under construction', '3 towers (Faith, Wisdom, Harmony) up to 25 floors; 2, 3, 4 BHK and penthouses'],
 [f'<strong>Eldeco Skywalk</strong> ({R_SW})', f'IIM Road area ({L_SW}); RERA: Bakshi Ka Talab tehsil', 'UPRERAPRJ859279/04/2025 — Eldeco Housing & Industries Ltd', '1 Apr 2025', '16 Oct 2029 — under construction', '4 towers (Verve, Life 1–3), 14 floors each; 2 and 3 BHK'],
 [f'<strong>Eldeco Solano Gardens</strong>', f'New Jail Road ({L_SO})', f'UPRERAPRJ416310/01/2026 (as listed — confirm on up-rera.in)', 'Launched Jan 2026', 'Phased over about 5 years', f'Villas, plots and group housing; overall value over ₹1,000 crore ({CALL})'],
 [f'<strong>Eldeco East End at Shaurya</strong> ({R_EE})', 'Lucknow; RERA: Sarojini Nagar tehsil', 'UPRERAPRJ513776 — Eldeco Housing & Industries Ltd', '15 Jun 2021', '15 Mar 2026 — shown as completed', 'Residential, 12,180 sq m'],
 ['<strong>Eldeco Imperia Phase 2</strong>', 'Kanpur Road', '—', '—', 'Completion certificate received in FY26', f'Apartments ({FY26})'],
], minw=760))
b.append(P(f'Eldeco also names <strong>Eldeco Regalia</strong>, <strong>Eldeco Udyan</strong> and <strong>Eldeco Saubhagyam</strong> among its ongoing Lucknow projects, and two commercial projects that were awaiting approval in February 2026: <strong>Eldeco City Courtyard</strong> (1.68 acres, about 37,000 sq ft saleable) and <strong>Eldeco Imperial Avenue</strong> (about 25,000 sq ft) ({CALL}).'))

b.append(H3('Eldeco Solano Gardens — the newest launch'))
b.append(P(f'Launched in January 2026, Solano Gardens is a phased development of villas, plots and group housing that Eldeco values at over ₹1,000 crore. In the February 2026 call it reported about ₹350 crore booked in the first phase and plot prices of about ₹6,000 per sq ft ({CALL}). By the end of FY26 it reported 343 of the 433 launched units sold, worth about ₹384.5 crore ({FY26}). A property listing puts it on New Jail Road, on about 52 acres ({L_SO}) — confirm the land area and RERA details for your phase on up-rera.in.'))

b.append(H3('Eldeco Trinity and Skywalk — what the RERA carpet areas say'))
b.append(P(f'RERA records carpet area — the usable floor inside the flat. For Trinity, a 4 BHK is 181.53 sq m (about {sqft(181.53)} sq ft) and 3 BHKs range from 120.12 to 150.04 sq m (about {sqft(120.12)}–{sqft(150.04)} sq ft) ({R_TR}). For Skywalk, 3 BHKs are about 119.6 sq m (about {sqft(119.55)} sq ft) and 2 BHKs 67.41–87.90 sq m (about {sqft(67.41)}–{sqft(87.90)} sq ft) ({R_SW}). Advertised sizes are usually super area and will be larger — compare prices on carpet area.'))

b.append(H2('record', 'Eldeco\'s record — strengths and what to check'))
b.append('<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px;margin:10px 0 18px;">' + ''.join(
 f'<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px 16px;"><div style="font-size:15px;font-weight:700;color:#166534;margin-bottom:4px;">✓ {t}</div><div style="font-size:14px;color:#374151;line-height:1.7;">{d}</div></div>' for t, d in [
  ('Five decades in the business', f'The group dates to 1975; the listed company was incorporated in 1985 ({IIFL}).'),
  ('Listed and audited', f'Eldeco Housing & Industries publishes quarterly results and holds investor calls ({CALL}).'),
  ('Recent completions', f'East End at Shaurya is listed as completed on RERA (15 Mar 2026) and Imperia Phase 2 received its completion certificate in FY26 ({R_EE}, {FY26}).'),
  ('More cash than debt', f'About ₹180 crore cash against about ₹106 crore debt in February 2026 ({CALL}).')]) + '</div>')
b.append(BOX('Check before you pay', '<ul style="margin:0;padding-left:20px;">' + ''.join(f'<li style="margin:5px 0;line-height:1.7;color:#374151;">{x}</li>' for x in [
  'Which company is the RERA promoter of your project — the listed firm or a project company such as Eldeco Inception Buildtech.',
  'The RERA completion date of your tower or phase, and the latest quarterly progress report.',
  'For Solano Gardens: the RERA number and land area of your phase; plots and villas may be registered separately from group housing.',
  'Group-level figures (200+ projects, 60 million sq ft) are the company\'s own; judge your project by its own record.']) + '</ul>', c='#FF5C00', bg='#fff7ed'))

b.append(H2('checklist', 'Buying from Eldeco in Lucknow? Check these first'))
b.append('<ol style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:8px 0;line-height:1.75;color:#374151;">{x}</li>' for x in [
 '<strong>RERA number of your exact tower or phase</strong> — search it on up-rera.in and note the promoter name.',
 '<strong>Agreement and receipts</strong> — must be in the name of the RERA promoter.',
 '<strong>Carpet area</strong> — your agreement must state RERA carpet area; compare price per sq ft of carpet area.',
 '<strong>Completion date and progress</strong> — check the quarterly progress report before each large instalment.',
 '<strong>Plots</strong> — confirm the plot number on the approved layout and the building rules for your colony.',
 f'<strong>Resale in older Eldeco colonies</strong> — ask for the seller\'s registered sale deed, the original allotment or sale deed from Eldeco, society/maintenance dues clearance and an {S("blog/encumbrance-certificate-lucknow-how-to-apply-online", "encumbrance certificate")}; check past registries on {S("blog/igrsup-lucknow-property-search-tutorial", "IGRSUP")}.']) + '</ol>')
b.append(BOX('Want us to check an Eldeco flat, villa or plot for you?', '<p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">We check the RERA record, promoter, completion status, title chain and encumbrance — <strong>₹5,000 for residential flats and plots, PDF report in 48 hours</strong>. ' + S('services/property-verification-lucknow', 'See what we check →') + '</p><p style="margin:0;">{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}</p>', c='#FF5C00', bg='#fff7ed'))
b.append(P(f'Want to buy or sell in an Eldeco project? DSD Properties helps with resale purchases and sales across Lucknow. For the areas, read our {S("blog/gomti-nagar-extension-lucknow-guide-2026", "Gomti Nagar Extension guide")} and {S("blog/plots-kanpur-road-lucknow-2026", "Kanpur Road plots guide")}.'))
b.append('{{CONSULTATION_BUTTON:Buy or Sell an Eldeco Property — Talk to Us}}')

b.append('<section id="FAQs">\n' + H2('faq', '❓ Frequently Asked Questions'))
for q, a in FAQ:
    b.append(f'<h3 style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #008080;padding:14px 18px;border-radius:0 10px 10px 0;cursor:pointer;color:#011f4b;font-size:15px;font-weight:600;margin:14px 0 0;">{q}</h3>')
    b.append(f'<p style="display:none;background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 10px 10px;padding:14px 18px;font-size:14.5px;color:#374151;margin:0 0 10px;line-height:1.85;">{a}</p>')
b.append('</section>')
b.append('<p style="font-size:13px;color:#6b7280;margin-top:30px;padding:14px 18px;background:#f8f8f8;border-left:3px solid #ccc;border-radius:4px;"><strong>Disclaimer:</strong> DSD Properties is an independent advisory and is not affiliated with Eldeco. Facts are from the sources linked above as of 19 October 2026; financial figures are the company\'s own reported numbers. Prices and RERA records change — confirm every detail on up-rera.in and with the developer before you pay.</p>')
html = '\n'.join(b)

schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
 {"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": re.sub(r'\s+', ' ', re.sub('<[^>]+>', '', a)).strip()}} for q, a in FAQ]}
row = {
 "title": "Eldeco in Lucknow 2026: Company, Financials, Projects & Buyer Guide",
 "slug": "eldeco-lucknow-projects-company-guide-2026",
 "meta_description": "Eldeco in Lucknow explained: who runs it, FY26 results, Trinity, Skywalk and Solano Gardens RERA details and dates, and what to check before you buy.",
 "meta_keywords": "eldeco lucknow, eldeco housing and industries, eldeco trinity, eldeco skywalk, eldeco solano gardens, eldeco imperia, eldeco projects lucknow, eldeco rera",
 "tag": "Buying Tips",
 "blog_summary": "Detailed plain-language guide to Eldeco in Lucknow: the group's history since 1975, the listed Eldeco Housing & Industries vs Eldeco Infrastructure & Properties, FY 2025-26 results, current projects (Trinity, Skywalk, Solano Gardens, East End, Imperia Phase 2) with RERA numbers and dates, and a buyer checklist.",
 "alt": "Eldeco Lucknow projects and company guide 2026",
 "language": "en", "status": "draft", "author_id": 9,
 "featured_image": "https://dsdproperties.in/public/images/blogs/eldeco_lucknow_2026.webp",
 "content_html": html,
 "seo_schema": json.dumps(schema, ensure_ascii=False, indent=2)}
assert len(row['meta_description']) <= 160, len(row['meta_description'])
json.dump(row, open('row.json', 'w', encoding='utf8'), ensure_ascii=False, indent=1)
print('ok', len(html), len(row['meta_description']), len(row['title']))
