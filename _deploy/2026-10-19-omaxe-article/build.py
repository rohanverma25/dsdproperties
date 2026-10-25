# New article: Omaxe in Lucknow — plain-language guide (EN). 19 Oct 2026.
import json, re

def A(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'
def S(path, text): return f'<a href="https://dsdproperties.in/{path}" style="color:#008080;font-weight:600;">{text}</a>'
WIKI = A('https://kaweah.freedombox.rocks/kiwix/wikipedia_en_all_maxi_2023-10/Omaxe', 'Wikipedia (archived copy)')
FY26 = A('https://scanx.trade/stock-market-news/companies/omaxe-limited-schedules-board-meeting-on-may-15-2026-to-approve-q4-fy26-audited-financial-results/39822974', 'FY26 results report')
Q4 = A('https://www.kotakneo.com/financial-results/omaxe-share-price-q4fy2025-26-results/', 'Q4 FY26 results')
Q1 = A('https://scanx.trade/stock-market-news/companies/omaxe-q1-results-consolidated-net-profit-turns-positive-at-1-30-crore/48085723', 'Q1 FY27 results report, 12 Aug 2026')
LKO = A('https://www.omaxe.com/projects/lucknow', 'Omaxe Lucknow page')
CITY = A('https://www.omaxe.com/residential-property-in-lucknow/omaxe-city-lucknow', 'Omaxe City page')
CAS = A('https://www.nbmcw.com/news/real-estate/omaxe-to-invest-rs-250-cr-in-omaxe-cassia-project-in-lucknow-sees-strong-demand.html', 'NBM&CW, 30 Apr 2026')
CAS_TP = A('https://hindi.theprint.in/india/economy/omaxe-to-invest-rs-250-crore-in-new-residential-project-in-lucknow/964654/', 'ThePrint Hindi / Bhasha, 29 Apr 2026')
R_C1 = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/omaxe-cassia-gh-ii-phase-i/upreraprj344049/07/2024', 'RERA record')
R_C2 = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/omaxe-cassia-gh-ii-phase-ii/upreraprj166763/08/2024', 'RERA record')
NEST = A('https://filingreader.com/news-wire/mumbai/2025-10-14/omaxe-subsidiary-secures-rera-approval-for-lucknow-project', 'stock-exchange filing, 15 Oct 2025')
L_HR = A('https://www.squareyards.com/lucknow-residential-property/omaxe-hazratganj-residency/101607/project', 'listing')
L_HZ = A('https://brokersaathi.com/property/omaxe-hazratganj-gomti-nagar-extension-lucknow-5126', 'listing')
PB = A('https://www.livelawbiz.com/rera/rera/punjab-rera-directs-omaxe-puda-to-refund-entire-principal-amount-received-for-flat-after-10-year-delay-523083', 'LiveLaw')

P = lambda t: f'<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 16px;">{t}</p>'
Pm = lambda t: P(t).replace('margin:0 0 16px', 'margin:0')
H2 = lambda i, t: f'<h2 id="{i}" style="font-size:22px;font-weight:700;color:#011f4b;margin:36px 0 12px;border-left:5px solid #FF5C00;padding-left:14px;">{t}</h2>'
H3 = lambda t: f'<h3 style="font-size:18px;font-weight:700;color:#011f4b;margin:24px 0 8px;">{t}</h3>'
def TABLE(head, rows, minw=560):
    th = ''.join(f'<th style="padding:10px 12px;text-align:left;background:#011f4b;color:#fff;font-size:13.5px;">{h}</th>' for h in head)
    tr = ''.join('<tr>' + ''.join(f'<td style="padding:10px 12px;border:1px solid #e2e8f0;font-size:14px;vertical-align:top;">{c}</td>' for c in r) + '</tr>' for r in rows)
    return f'<div style="overflow-x:auto;margin:16px 0 20px;"><table style="width:100%;border-collapse:collapse;min-width:{minw}px;"><thead><tr>{th}</tr></thead><tbody>{tr}</tbody></table></div>'
BOX = lambda title, inner, c='#008080', bg='#f0fdfa': f'<div style="background:{bg};border:1px solid {c}33;border-left:4px solid {c};border-radius:0 12px 12px 0;padding:16px 20px;margin:18px 0 22px;"><p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>{inner}</div>'
sqft = lambda m: f'{m*10.7639:,.0f}'

FAQ = [
 ('Who owns Omaxe?', f'Omaxe Limited was founded by Rohtas Goel, who started it as a construction and contracting business in 1987; it was incorporated in 1989 as Omaxe Builders Pvt Ltd and listed on the stock market in 2007 ({WIKI}). Mohit Goel is its Managing Director ({CAS}).'),
 ('What are Omaxe\'s projects in Lucknow?', f'Omaxe lists 17 residential and 4 commercial projects in Lucknow ({LKO}). The best known are Omaxe City (140 acres of plots and villas, delivered) and the 690-acre Omaxe Metro City township on Raebareli Road, where Omaxe Cassia is now being built ({CITY}, {CAS}).'),
 ('Is Omaxe financially stable?', f'Omaxe Ltd reported consolidated net losses of ₹685.40 crore in FY 2024-25 and ₹696.80 crore in FY 2025-26 ({FY26}). In April–June 2026 it reported a small consolidated profit of ₹1.30 crore, while the parent company on its own still made a loss ({Q1}). Buyers should judge each project by its RERA progress and construction on site.'),
 ('When will Omaxe Cassia be completed?', f'Both Cassia phases are registered with UP RERA until 8 April 2029 ({R_C1}, {R_C2}). In April 2026 Omaxe said it expected to complete the project in about three years ({CAS}).'),
 ('Who is the RERA promoter of Omaxe Cassia?', f'Omaxe Garv Buildtech Private Limited (formerly Garv Buildtech Private Limited), a wholly owned subsidiary of Omaxe Ltd ({R_C1}, {CAS}). Your agreement should name this company.'),
 ('Where is Omaxe Metro City?', f'On Raebareli Road, Lucknow; Omaxe describes it as a 690-acre township ({CAS}). RERA lists its Cassia phases in Sarojini Nagar tehsil ({R_C1}).'),
]

b = []
b.append('<p style="font-size:13px;color:#6b7280;margin:0 0 24px;padding-bottom:14px;border-bottom:1px solid #e2e8f0;">Sources: Omaxe\'s Lucknow web pages, Omaxe stock-exchange disclosures and results as reported by financial news sites, UP RERA project records (via Aurum PropTech\'s RERA mirror), NBM&amp;CW, ThePrint/Bhasha and listings where marked. Independent guide by DSD Properties — we are not affiliated with Omaxe. <strong>Updated: 19 October 2026.</strong></p>')
b.append('<!-- key-facts -->\n' + BOX('Key Facts (updated 19 October 2026)', '<ul style="margin:0;padding-left:20px;">' + ''.join(f'<li style="margin:5px 0;line-height:1.7;">{x}</li>' for x in [
 f'<strong>Omaxe Ltd</strong> is a New Delhi-based, stock-market-listed developer founded by <strong>Rohtas Goel</strong>; it began as a construction business in 1987 and entered real estate in 2001 ({WIKI}).',
 f'In Lucknow it lists <strong>17 residential and 4 commercial projects</strong>, including <strong>Omaxe City</strong> (140 acres, delivered) and the <strong>690-acre Omaxe Metro City</strong> on Raebareli Road ({LKO}, {CITY}, {CAS}).',
 f'Its newest Lucknow project, <strong>Omaxe Cassia</strong> (8 towers, 360 flats), had about 300 flats sold by April 2026; RERA completion date <strong>8 April 2029</strong> ({CAS}, {R_C1}).',
 f'Omaxe Ltd reported a <strong>₹696.80 crore net loss in FY 2025-26</strong> on revenue of ₹1,253.40 crore, then a small ₹1.30 crore consolidated profit in April–June 2026 ({FY26}, {Q1}).',
 'Its new Lucknow projects are registered on RERA by a <strong>subsidiary</strong>, Omaxe Garv Buildtech Pvt Ltd — make sure your agreement names it.']) + '</ul>'))
b.append(P('You will see the Omaxe name across Lucknow — on Raebareli Road townships, Gomti Nagar Extension apartments and the Omaxe Hazratganj commercial complex. This guide explains, in plain words, who Omaxe is, what it has built and is building in Lucknow, how the company is doing financially, and what to check before you buy. Every fact has a source link; where we rely on a listing, we say so.'))

b.append(H2('who', 'Who is Omaxe? (in simple words)'))
b.append(TABLE(['Item', 'Detail', 'Source'], [
 ['Company', 'Omaxe Limited — listed on the stock market since its 2007 IPO', WIKI],
 ['Founder', 'Rohtas Goel, a civil engineer who started a construction and contracting business in 1987', WIKI],
 ['History', 'Incorporated in 1989 as Omaxe Builders Pvt Ltd; became a limited company in 1999; entered real estate in 2001', WIKI],
 ['Head office', 'New Delhi', WIKI],
 ['Managing Director', 'Mohit Goel', CAS],
 ['Where it builds', 'Several North Indian states, including Uttar Pradesh, Haryana, Punjab, Madhya Pradesh and Rajasthan; townships, homes, malls, offices and hotels', WIKI],
]))
b.append(BOX('What this means for you', Pm('Omaxe is a large, listed company, so its results are public every quarter. But each Lucknow project is registered on RERA by a specific company — for new projects like Cassia and The Nest that is a subsidiary, Omaxe Garv Buildtech. Your agreement must be with the company on your project\'s RERA record.')))

b.append(H2('lucknow', 'Omaxe in Lucknow'))
b.append(P(f'Omaxe\'s Lucknow page lists <strong>17 residential and 4 commercial projects</strong> and says all of them are RERA registered ({LKO}). The main ones:'))
b.append(TABLE(['Project', 'What it is', 'Where', 'Status', 'Source'], [
 ['<strong>Omaxe City</strong>', 'Township of plots and villas, 140 acres', 'Raebareli Road, near Amar Shaheed Path', 'Delivered', CITY],
 ['<strong>Omaxe Metro City</strong>', 'Township, 690 acres', 'Raebareli Road (Kalli Paschim area)', 'Ongoing — new phases being launched', CAS],
 ['<strong>Omaxe Cassia</strong> (in Metro City)', '8 towers of 2 and 3 BHK flats, 360 units', 'Raebareli Road; RERA: Sarojini Nagar tehsil', 'Under construction — RERA completion 8 Apr 2029', f'{CAS}, {R_C1}'],
 ['<strong>The Nest</strong>', 'Residential', 'Sarojini Nagar', 'RERA UPRERAPRJ845286/10/2025, valid to 31 Aug 2027', NEST],
 ['<strong>Omaxe Hazratganj Residency</strong>', '1, 2, 3 BHK and penthouses', 'Sector 7, Gomti Nagar Extension, Amar Shaheed Path', f'RERA UPRERAPRJ2050 (as listed — confirm on up-rera.in)', f'{LKO}, {L_HR}'],
 ['<strong>Omaxe Hazratganj</strong> (Phase I & II)', 'Commercial — shops, service apartments, offices', 'Gomti Nagar Extension', f'Phase I RERA UPRERAPRJ1925 (as listed)', f'{LKO}, {L_HZ}'],
], minw=760))
b.append(P(f'Other names on Omaxe\'s Lucknow page: The Resort, The Legends, Omaxe Residency II, The Palace, Grand Omaxe, Regent, The Lincoln, Kingston, Celestia Grande, Celestia Royale, Celestia Gold, Europia Villa, Omaxe Heights, Omaxe Waterscapes, and the commercial Omaxe Hi Street and Omaxe Front Street ({LKO}). The page does not give a status for each; ask for the RERA number of any of these before you buy.'))

b.append(H3('Omaxe Cassia — the newest launch'))
b.append(P(f'In April 2026, Omaxe told the stock exchanges it would invest about ₹250 crore in Omaxe Cassia, a project of 8 towers with 2 and 3 BHK flats inside Omaxe Metro City on Raebareli Road. About 300 of its 360 units were already sold, and it expected to finish in about three years ({CAS}, {CAS_TP}). The project is registered in two phases:'))
b.append(TABLE(['Phase', 'RERA no.', 'Registered', 'RERA completion', 'Details (RERA)'], [
 [f'Cassia GH II, Phase I ({R_C1})', 'UPRERAPRJ344049/07/2024', '8 Jul 2024', '8 Apr 2029', f'Towers 3–6, ground + 12 floors; 2 BHK 62–85 sq m (about {sqft(62)}–{sqft(85)} sq ft carpet), 3 BHK 106–116 sq m (about {sqft(106)}–{sqft(116)} sq ft carpet)'],
 [f'Cassia GH II, Phase II ({R_C2})', 'UPRERAPRJ166763/08/2024', 'Jul 2024', '8 Apr 2029', 'Second group of towers'],
]))
b.append(P('The RERA promoter for Cassia is <strong>Omaxe Garv Buildtech Private Limited</strong> (formerly Garv Buildtech Private Limited), a wholly owned Omaxe subsidiary.'))

b.append(H2('financials', 'How is Omaxe doing financially?'))
b.append(P('These are Omaxe Ltd\'s consolidated results for the whole company, all cities together — not Lucknow alone.'))
b.append(TABLE(['Period', 'Revenue from operations', 'Net profit / loss', 'Source'], [
 ['FY 2024-25', '₹1,560.99 crore', 'Loss ₹685.40 crore', FY26],
 ['FY 2025-26', '₹1,253.40 crore (down 19.7%)', 'Loss ₹696.80 crore', FY26],
 ['Jan–Mar 2026 quarter', '₹348.52 crore', 'Loss ₹191.42 crore', FY26],
 ['Apr–Jun 2026 quarter', '₹406.17 crore (up 44%)', 'Profit ₹1.30 crore (consolidated); the parent company alone lost ₹31.88 crore', Q1],
]))
b.append(BOX('What this means for buyers', Pm('Omaxe made large losses in the last two financial years and returned to a small profit in the April–June 2026 quarter. Losses at company level do not mean a project will stop — under RERA, 70% of buyers\' money for a project must be kept in that project\'s own bank account. But it makes it more important to buy where construction is visibly moving: read the quarterly progress report on up-rera.in, visit the site, and prefer paying in step with construction.'), c='#FF5C00', bg='#fff7ed'))
b.append(P(f'Outside Uttar Pradesh, the Punjab RERA has ordered Omaxe to refund buyers or pay delay interest in some of its Punjab projects ({PB}). We did not find a comparable UP RERA order for its Lucknow projects in our search, but you should check the complaint history of your project on up-rera.in before booking.'))

b.append(H2('checklist', 'Buying from Omaxe in Lucknow? Check these first'))
b.append('<ol style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:8px 0;line-height:1.75;color:#374151;">{x}</li>' for x in [
 '<strong>RERA number of your exact phase and tower</strong> — search it on up-rera.in and note the promoter (often Omaxe Garv Buildtech for new projects).',
 '<strong>Construction progress</strong> — compare the RERA quarterly report with what you see on site before every big payment.',
 '<strong>Carpet area</strong> — your agreement must state the RERA carpet area; compare prices per sq ft of carpet area.',
 '<strong>Complaints</strong> — check the project\'s complaint history on up-rera.in.',
 '<strong>Older Omaxe colonies and resale</strong> — ask for the seller\'s registered sale deed, the original conveyance from Omaxe, maintenance dues clearance and an ' + S('blog/encumbrance-certificate-lucknow-how-to-apply-online', 'encumbrance certificate') + '; check past registries on ' + S('blog/igrsup-lucknow-property-search-tutorial', 'IGRSUP') + '.',
 '<strong>Plots in Omaxe City or Metro City</strong> — confirm the plot on the approved layout and the township\'s building rules.']) + '</ol>')
b.append(BOX('Want us to check an Omaxe flat, villa or plot for you?', '<p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">We check the RERA record, promoter, completion status, complaints, title chain and encumbrance — <strong>₹5,000 for residential flats and plots, PDF report in 48 hours</strong>. ' + S('services/property-verification-lucknow', 'See what we check →') + '</p><p style="margin:0;">{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}</p>', c='#FF5C00', bg='#fff7ed'))
b.append(P(f'Buying or selling in an Omaxe project? DSD Properties helps with resale purchases and sales across Lucknow. For the corridor, read our {S("blog/plots-raebareli-road-lucknow-2026", "Raebareli Road plots guide")}.'))
b.append('{{CONSULTATION_BUTTON:Buy or Sell an Omaxe Property — Talk to Us}}')

b.append('<section id="FAQs">\n' + H2('faq', '❓ Frequently Asked Questions'))
for q, a in FAQ:
    b.append(f'<h3 style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #008080;padding:14px 18px;border-radius:0 10px 10px 0;cursor:pointer;color:#011f4b;font-size:15px;font-weight:600;margin:14px 0 0;">{q}</h3>')
    b.append(f'<p style="display:none;background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 10px 10px;padding:14px 18px;font-size:14.5px;color:#374151;margin:0 0 10px;line-height:1.85;">{a}</p>')
b.append('</section>')
b.append('<p style="font-size:13px;color:#6b7280;margin-top:30px;padding:14px 18px;background:#f8f8f8;border-left:3px solid #ccc;border-radius:4px;"><strong>Disclaimer:</strong> DSD Properties is an independent advisory and is not affiliated with Omaxe. Facts are from the sources linked above as of 19 October 2026; financial figures are Omaxe Ltd\'s reported consolidated results. RERA records and prices change — confirm every detail on up-rera.in and with the developer before you pay.</p>')
html = '\n'.join(b)

schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
 {"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": re.sub(r'\s+', ' ', re.sub('<[^>]+>', '', a)).strip()}} for q, a in FAQ]}
row = {
 "title": "Omaxe in Lucknow 2026: Company, Financial Health, Projects & Buyer Guide",
 "slug": "omaxe-lucknow-projects-company-guide-2026",
 "meta_description": "Omaxe in Lucknow explained: who Omaxe is, Omaxe City, Metro City and Cassia RERA details, FY26 results, and what to check before you buy.",
 "meta_keywords": "omaxe lucknow, omaxe metro city, omaxe cassia, omaxe city lucknow, omaxe hazratganj, omaxe rera lucknow, omaxe raebareli road, omaxe financials",
 "tag": "Buying Tips",
 "blog_summary": "Plain-language guide to Omaxe in Lucknow: company history since 1987, its 17 residential and 4 commercial Lucknow projects, the 690-acre Omaxe Metro City and the new Omaxe Cassia (RERA, carpet areas, April 2029 completion), FY 2025-26 results and the Q1 FY27 turnaround, and a buyer checklist.",
 "alt": "Omaxe Lucknow projects and company guide 2026",
 "language": "en", "status": "draft", "author_id": 9,
 "featured_image": "https://dsdproperties.in/public/images/blogs/omaxe_lucknow_2026.webp",
 "content_html": html,
 "seo_schema": json.dumps(schema, ensure_ascii=False, indent=2)}
assert len(row['meta_description']) <= 160, len(row['meta_description'])
json.dump(row, open('row.json', 'w', encoding='utf8'), ensure_ascii=False, indent=1)
print('ok', len(html), len(row['meta_description']))
