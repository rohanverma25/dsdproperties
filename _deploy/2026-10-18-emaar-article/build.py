# New article: Emaar in Lucknow — plain-language guide for ordinary buyers (EN). 18 Oct 2026.
import json, re

def A(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'
def S(path, text): return f'<a href="https://dsdproperties.in/{path}" style="color:#008080;font-weight:600;">{text}</a>'
W_EP = A('https://en.wikipedia.org/wiki/Emaar_Properties', 'Wikipedia: Emaar Properties')
W_EI = A('https://en.wikipedia.org/wiki/Emaar_India', 'Wikipedia: Emaar India')
RT_NS = A('https://therealtytoday.com/news/news/emaar-confirms-no-stake-sale-in-india-eyes-strategic-joint-ventures', 'Realty Today, 21 Sep 2025')
LAUNCH = A('https://realtynmore.com/emaar-india-launches-its-first-premium-high-rise-residential-project-elite-oasis-in-lucknow/', 'launch announcement, 2 Jun 2025')
KS = A('https://www.knocksense.com/lucknow/emaar-india-unveils-400-cr-elite-oasis-a-high-rise-residential-project-in-lucknow/', 'Knocksense, 3 Jun 2025')
FOUND = A('https://realtynmore.com/emaar-india-lays-foundation-for-elite-oasis/', 'Realty n More, 14 Mar 2026')
R_EO = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/elite-oasis/upreraprj944123/02/2025', 'RERA record')
R_GG = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/gomti-greens-integrated-township/upreraprj5635', 'RERA record')
R_HR = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/hridayam-at-emaar-gomti-greens/upreraprj517031', 'RERA record')
R_SM = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/samarth-at-emaar-gomti-greens/upreraprj221843', 'RERA record')

P = lambda t: f'<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 16px;">{t}</p>'
H2 = lambda i, t: f'<h2 id="{i}" style="font-size:22px;font-weight:700;color:#011f4b;margin:36px 0 12px;border-left:5px solid #FF5C00;padding-left:14px;">{t}</h2>'
H3 = lambda t: f'<h3 style="font-size:18px;font-weight:700;color:#011f4b;margin:24px 0 8px;">{t}</h3>'
UL = lambda items: '<ul style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:6px 0;line-height:1.75;color:#374151;">{i}</li>' for i in items) + '</ul>'
def TABLE(head, rows, minw=560):
    th = ''.join(f'<th style="padding:10px 12px;text-align:left;background:#011f4b;color:#fff;font-size:13.5px;">{h}</th>' for h in head)
    tr = ''.join('<tr>' + ''.join(f'<td style="padding:10px 12px;border:1px solid #e2e8f0;font-size:14px;vertical-align:top;">{c}</td>' for c in r) + '</tr>' for r in rows)
    return f'<div style="overflow-x:auto;margin:16px 0 20px;"><table style="width:100%;border-collapse:collapse;min-width:{minw}px;"><thead><tr>{th}</tr></thead><tbody>{tr}</tbody></table></div>'
BOX = lambda title, inner, c='#008080', bg='#f0fdfa': f'<div style="background:{bg};border:1px solid {c}33;border-left:4px solid {c};border-radius:0 12px 12px 0;padding:16px 20px;margin:18px 0 22px;"><p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>{inner}</div>'

sqft = lambda m: f'{m*10.7639:,.0f}'
FAQ = [
 ('Is Emaar in Lucknow the same company that built the Burj Khalifa?',
  f'Emaar India is the Indian arm of Emaar Properties of Dubai, the company that built and owns the Burj Khalifa. Emaar India is a separate Indian company headquartered in Gurugram ({W_EI}); it was called Emaar MGF Land Limited until its joint venture with MGF ended in 2016.'),
 ('What projects does Emaar have in Lucknow?',
  f'Two: the Gomti Greens township, which RERA lists as completed in December 2023, with phases such as Hridayam and Samarth; and Elite Oasis, a 35-floor apartment tower in Gomti Nagar Extension launched in June 2025 and due for completion in November 2029 ({R_GG}, {R_EO}).'),
 ('What is the price of Emaar Elite Oasis?',
  f'At launch in June 2025, reported prices were about ₹2.75–2.90 crore for 3 BHK and ₹3.87–4.15 crore for 4 BHK ({LAUNCH}); another report gave ₹2.95 crore as the starting price ({KS}). Prices change — ask for the current price list and check the carpet area in the RERA record.'),
 ('Why is the RERA area smaller than the advertised flat size?',
  f'Advertised sizes are usually super (saleable) area, which adds walls, lobbies, lifts and common areas. RERA records carpet area — the usable floor inside your flat. For Elite Oasis, the 3 BHK is advertised at about 2,640 sq ft but its RERA carpet area is 138.775 sq m, about {sqft(138.775)} sq ft ({KS}, {R_EO}).'),
 ('Is Emaar India being sold to Adani?',
  f'In 2025 Emaar held sale talks, including with the Adani Group. In September 2025 Emaar told the Dubai Financial Market it has no plans to divest its stake in its Indian entity and is instead exploring partnerships with large Indian groups ({RT_NS}).'),
 ('When will Elite Oasis be completed?',
  f'The RERA completion date is 17 November 2029 ({R_EO}). The foundation was laid on 13 March 2026 ({FOUND}).'),
]

b = []
b.append('<p style="font-size:13px;color:#6b7280;margin:0 0 24px;padding-bottom:14px;border-bottom:1px solid #e2e8f0;">Sources: UP RERA project records (via Aurum PropTech\'s RERA mirror), Emaar India announcements as reported by Realty n More and Knocksense, Realty Today, Wikipedia. Independent guide by DSD Properties — we are not affiliated with Emaar. <strong>Updated: 18 October 2026.</strong></p>')
b.append('<!-- key-facts -->\n' + BOX('Key Facts (updated 18 October 2026)', '<ul style="margin:0;padding-left:20px;">' + ''.join(f'<li style="margin:5px 0;line-height:1.7;">{x}</li>' for x in [
  f'<strong>Emaar India</strong> is the Indian company of Dubai\'s <strong>Emaar Properties</strong> (builder of the Burj Khalifa). It was set up in 2005 as Emaar MGF and has been on its own since 2016 ({W_EI}).',
  f'In Lucknow, Emaar built the <strong>Gomti Greens</strong> township — RERA lists it as <strong>completed on 22 December 2023</strong> ({R_GG}).',
  f'Its new project, <strong>Elite Oasis</strong> in Gomti Nagar Extension, is a <strong>35-floor tower of 3 and 4 BHK flats</strong>, launched on 2 June 2025; RERA no. <strong>UPRERAPRJ944123/02/2025</strong>, completion date <strong>17 November 2029</strong> ({LAUNCH}, {R_EO}).',
  f'Launch prices were about <strong>₹2.75–4.15 crore</strong>; the foundation was laid on <strong>13 March 2026</strong> ({LAUNCH}, {FOUND}).',
  f'In September 2025 Emaar said it has <strong>no plans to sell its stake</strong> in Emaar India ({RT_NS}).']) + '</ul>'))
b.append(P('If you have seen hoardings for Emaar in Lucknow and wondered who they are, this guide explains it in plain words: what Emaar is, how its Indian company works, what it has built in Lucknow, and what to check before you buy an Emaar flat or plot. Every fact has a source link; where two sources disagree, we show both.'))

b.append(H2('what-is-emaar', 'What is Emaar? (in simple words)'))
b.append(P(f'<strong>Emaar Properties</strong> is a large real estate company from Dubai, founded in 1997 by Mohamed Alabbar and listed on the Dubai Financial Market. It built and owns the <strong>Burj Khalifa</strong>, the world\'s tallest building, and built The Dubai Mall and Downtown Dubai ({W_EP}).'))
b.append(P(f'<strong>Emaar India</strong> is its Indian company, headquartered in <strong>Gurugram</strong>. It started in 2005 as a joint venture with the Indian developer MGF, under the name Emaar MGF. That partnership ended on 11 April 2016, and the company is now Emaar India Limited — RERA still shows it as "formerly known as Emaar MGF Land Limited" ({W_EI}, {R_EO}). It builds in Delhi-NCR (mainly Gurugram), Mohali, Lucknow, Indore and other cities.'))
b.append(BOX('What this means for you', P('When you buy an Emaar flat in Lucknow, your agreement is with <strong>Emaar India Limited</strong> — an Indian company governed by Indian law and UP RERA — not with the Dubai company. The Dubai parent\'s fame is a good sign, but your protection comes from the RERA registration of your specific project.').replace('margin:0 0 16px', 'margin:0')))

b.append(H3('Who owns Emaar India now?'))
b.append(P(f'In 2025 Emaar held talks to sell its India business, with the Adani Group named as a leading contender. In September 2025, Emaar told the Dubai Financial Market that it has <strong>no plans to divest its stake in its Indian entity</strong> and is instead exploring partnerships with large Indian groups ({RT_NS}). We have found no later announcement of a sale or joint venture as of 18 October 2026.'))

b.append(H2('lucknow', 'Emaar in Lucknow — the two projects'))
b.append(H3('1. Gomti Greens township (completed)'))
b.append(P(f'Gomti Greens is Emaar\'s integrated township in Lucknow — an "integrated township" means plots, homes, roads, parks and shops planned together by one developer. The main township is registered with UP RERA as <strong>UPRERAPRJ5635</strong>: approval date 1 October 2013, completion date <strong>22 December 2023</strong>, land area 462,766 sq m (about 114 acres), and RERA shows it as fully built ({R_GG}). Property portals often quote bigger figures (over 230 acres) — those are marketing numbers; use the RERA figure for your phase.'))
b.append(P('Inside the township, phases are registered separately:'))
b.append(TABLE(['Phase', 'RERA no.', 'Type (as on RERA)', 'Completion (RERA)', 'Details'], [
 [f'Gomti Greens Integrated Township ({R_GG})', 'UPRERAPRJ5635', 'Residential', '22 Dec 2023 — completed', '462,766 sq m land'],
 [f'Hridayam at Emaar Gomti Greens ({R_HR})', 'UPRERAPRJ517031', 'Residential', '22 Dec 2023 — completed', '32,582 sq m land; unit list not given in the record'],
 [f'Samarth at Emaar Gomti Greens ({R_SM})', 'UPRERAPRJ221843', 'Commercial category', '12 Oct 2025 — completed', '928 one-bedroom flats (about 28–34 sq m carpet) in two towers, plus small shops and units'],
]))
b.append(P(f'RERA lists the township\'s locality as Sarojini Nagar (the tehsil in land records), while Emaar markets the area as Gomti Nagar Extension near Amar Shaheed Path. When you buy here, your sale deed and land records follow the khasra numbers and tehsil shown in the documents.'))

b.append(H3('2. Elite Oasis — Emaar\'s first high-rise in Lucknow (under construction)'))
b.append(TABLE(['Item', 'Detail', 'Source'], [
 ['Location', 'Sector 7, Gomti Nagar Extension, near Amar Shaheed Path; overlooks Gomti Greens and the Gomti river', f'{KS}, {LAUNCH}'],
 ['Launched', '2 June 2025', LAUNCH],
 ['Foundation laid', '13 March 2026', FOUND],
 ['Building', 'One tower, ground + 35 floors, on about 2.923 acres (11,827 sq m)', f'{KS}, {R_EO}'],
 ['Flats', '3 BHK + utility and 4 BHK + utility; 194 residences as announced. The RERA record lists 288 units — ask the developer to explain the difference for your floor.', f'{FOUND}, {R_EO}'],
 ['Carpet area (RERA)', f'3 BHK: 138.775 sq m (about {sqft(138.775)} sq ft). 4 BHK: 201.736 and 206.637 sq m (about {sqft(201.736)} and {sqft(206.637)} sq ft)', R_EO],
 ['Advertised size', '3 BHK about 2,640 sq ft; 4 BHK up to 3,750 sq ft (these are super areas)', KS],
 ['Launch price', '3 BHK ₹2.75–2.90 crore; 4 BHK ₹3.87–4.15 crore (another report: from ₹2.95 crore)', f'{LAUNCH}, {KS}'],
 ['RERA no.', 'UPRERAPRJ944123/02/2025, promoter Emaar India Limited', R_EO],
 ['RERA completion date', '17 November 2029', R_EO],
 ['Investment', '₹400 crore, with expected sales of ₹650 crore', KS],
], minw=520))

b.append(BOX('Carpet area vs super area — the most important thing to understand', P(
 f'The size in an advertisement is usually <strong>super area</strong>: your flat plus a share of walls, lobbies, lifts, staircases and the clubhouse. <strong>Carpet area</strong> is the floor you actually use inside your flat, and it is what RERA records. For Elite Oasis, the 3 BHK is advertised at about 2,640 sq ft, while its RERA carpet area is about {sqft(138.775)} sq ft — the advertised figure is roughly 1.75 times the usable area. This is normal in high-rises, but always compare price per sq ft of carpet area, and make sure your agreement states carpet area as per RERA.').replace('margin:0 0 16px', 'margin:0'), c='#FF5C00', bg='#fff7ed'))

b.append(H2('checklist', 'Buying from Emaar in Lucknow? Check these first'))
b.append('<ol style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:8px 0;line-height:1.75;color:#374151;">{x}</li>' for x in [
 '<strong>RERA number of your exact project or phase</strong> — search it on up-rera.in and check that the promoter is Emaar India Limited.',
 '<strong>Carpet area</strong> — your agreement must state the RERA carpet area; compare price per sq ft of carpet area across projects.',
 '<strong>Completion date</strong> — for Elite Oasis, 17 November 2029. Read the quarterly progress report on up-rera.in before each big payment.',
 '<strong>Payment plan and charges</strong> — ask in writing for parking, club, maintenance deposit and other charges on top of the base price.',
 f'<strong>Resale in Gomti Greens</strong> — ask for the seller\'s registered sale deed, the original allotment or conveyance from Emaar, dues clearance from the maintenance body, and an {S("blog/encumbrance-certificate-lucknow-how-to-apply-online", "encumbrance certificate")}; check past registries on {S("blog/igrsup-lucknow-property-search-tutorial", "IGRSUP")}.',
 '<strong>Plot buyers</strong> — confirm the plot number on the approved layout and whether a house plan has to follow the township\'s building rules.']) + '</ol>')
b.append(BOX('Want us to check an Emaar flat or plot for you?', '<p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">We check the RERA record, promoter, completion status, title chain and encumbrance — <strong>₹5,000 for residential flats and plots, PDF report in 48 hours</strong>. ' + S('services/property-verification-lucknow', 'See what we check →') + '</p><p style="margin:0;">{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}</p>', c='#FF5C00', bg='#fff7ed'))
b.append(P(f'Looking to buy or sell in Gomti Greens or Gomti Nagar Extension? DSD Properties helps with resale purchases and sales in Lucknow. For the area itself, read our {S("blog/gomti-nagar-extension-lucknow-guide-2026", "Gomti Nagar Extension guide")}.'))
b.append('{{CONSULTATION_BUTTON:Buy or Sell in Emaar Gomti Greens — Talk to Us}}')

b.append('<section id="FAQs">\n' + H2('faq', '❓ Frequently Asked Questions'))
for q, a in FAQ:
    b.append(f'<h3 style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #008080;padding:14px 18px;border-radius:0 10px 10px 0;cursor:pointer;color:#011f4b;font-size:15px;font-weight:600;margin:14px 0 0;">{q}</h3>')
    b.append(f'<p style="display:none;background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 10px 10px;padding:14px 18px;font-size:14.5px;color:#374151;margin:0 0 10px;line-height:1.85;">{a}</p>')
b.append('</section>')
b.append('<p style="font-size:13px;color:#6b7280;margin-top:30px;padding:14px 18px;background:#f8f8f8;border-left:3px solid #ccc;border-radius:4px;"><strong>Disclaimer:</strong> DSD Properties is an independent advisory and is not affiliated with Emaar. Facts are from the sources linked above as of 18 October 2026. Prices and RERA records change — confirm every detail on up-rera.in and with the developer before you pay.</p>')
html = '\n'.join(b)

schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
 {"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": re.sub(r'\s+', ' ', re.sub('<[^>]+>', '', a)).strip()}} for q, a in FAQ]}
row = {
 "title": "Emaar in Lucknow 2026: What Is Emaar, Gomti Greens & Elite Oasis Explained",
 "slug": "emaar-india-lucknow-gomti-greens-elite-oasis-guide-2026",
 "meta_description": "Emaar in Lucknow explained simply: who Emaar India is, Gomti Greens township and Elite Oasis — RERA numbers, dates, prices, carpet area and buyer checks.",
 "meta_keywords": "emaar lucknow, emaar india lucknow, emaar elite oasis, emaar gomti greens, elite oasis lucknow price, emaar rera lucknow, gomti nagar extension emaar",
 "tag": "Buying Tips",
 "blog_summary": "Plain-language guide to Emaar in Lucknow: what Emaar Properties and Emaar India are, the September 2025 decision not to sell the India unit, the completed Gomti Greens township and its RERA phases, the Elite Oasis tower (RERA, carpet vs super area, launch prices, Nov 2029 completion) and what to check before buying.",
 "alt": "Emaar India Lucknow guide — Gomti Greens and Elite Oasis 2026",
 "language": "en", "status": "draft", "author_id": 9,
 "featured_image": "https://dsdproperties.in/public/images/blogs/emaar_lucknow_2026.webp",
 "content_html": html,
 "seo_schema": json.dumps(schema, ensure_ascii=False, indent=2)}
assert len(row['meta_description']) <= 160, len(row['meta_description'])
json.dump(row, open('row.json', 'w', encoding='utf8'), ensure_ascii=False, indent=1)
print('ok', len(html), len(row['meta_description']), len(row['title']))
