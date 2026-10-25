# New article: Shalimar Corp Lucknow — projects, RERA records, buyer checklist (EN). 18 Oct 2026.
# Every fact below is tied to a source fetched on 18 Oct 2026; listing-only data is labelled as such.
import json, re

def A(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'
def S(path, text): return f'<a href="https://dsdproperties.in/{path}" style="color:#008080;font-weight:600;">{text}</a>'
WEB = A('https://www.shalimarcorp.com/', 'Shalimar Corp website')
HDFC = A('https://therealtytoday.com/news/residential/hdfc-capital-shalimar-corp-create-750-crore-platform-for-housing-in-lucknow-varanasi-kanpur', 'Realty Today, 1 Oct 2026')
VNS = A('https://theprint.in/ani-press-releases/shalimar-corp-limited-brings-four-decades-of-trusted-excellence-to-varanasi-marking-its-grand-entry-into-purvanchal/2985806/', 'ThePrint / ANI, 14 Jul 2026')
R_GW = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/shalimar-gallant-west/upreraprj569037', 'RERA record')
R_SG = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/shalimar-sky-garden/upreraprj160941', 'RERA record')
R_WW = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/whispering-woods-gh-14-integrated-township/upreraprj380751', 'RERA record')
R_MN = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/barabanki/sheres-shalimar-mannat-phase-1/upreraprj8345', 'RERA record')
R_PD = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/barabanki/shalimar-paradise-phase-1/upreraprj9777', 'RERA record')
R_IR = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/iridium/upreraprj17421', 'RERA record')
OW = A('https://realtydoctors.in/project/shalimar-oneworld-lucknow', 'Realty Doctors')
EH = A('https://www.addressofchoice.com/shalimar-evara-heights-mohammadpur-chauki-lucknow-p84701', 'listing')
EV = A('https://brokersaathi.com/property/shalimar-evara-faizabad-road-lucknow-5083', 'listing')

P = lambda t: f'<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 16px;">{t}</p>'
H2 = lambda i, t: f'<h2 id="{i}" style="font-size:22px;font-weight:700;color:#011f4b;margin:36px 0 12px;border-left:5px solid #FF5C00;padding-left:14px;">{t}</h2>'
H3 = lambda t: f'<h3 style="font-size:18px;font-weight:700;color:#011f4b;margin:24px 0 8px;">{t}</h3>'
UL = lambda items: '<ul style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:6px 0;line-height:1.75;color:#374151;">{i}</li>' for i in items) + '</ul>'
def TABLE(head, rows):
    th = ''.join(f'<th style="padding:10px 12px;text-align:left;background:#011f4b;color:#fff;font-size:13.5px;">{h}</th>' for h in head)
    tr = ''.join('<tr>' + ''.join(f'<td style="padding:10px 12px;border:1px solid #e2e8f0;font-size:14px;vertical-align:top;">{c}</td>' for c in r) + '</tr>' for r in rows)
    return f'<div style="overflow-x:auto;margin:16px 0 20px;"><table style="width:100%;border-collapse:collapse;min-width:620px;"><thead><tr>{th}</tr></thead><tbody>{tr}</tbody></table></div>'

FAQ = [
 ('When was Shalimar Corp founded and who runs it?',
  f'Shalimar Corp Limited was established in 1988 and is headquartered at Shalimar Titanium, Vibhuti Khand, Gomti Nagar, Lucknow ({WEB}). Khalid Masood is its Managing Director ({HDFC}) and Kunal Seth is a Director ({VNS}).'),
 ('Where is Shalimar OneWorld?',
  f'Shalimar OneWorld is an integrated township at Village Baghamau, Gomti Nagar Extension, near Amar Shaheed Path ({OW}). It is registered with UP RERA phase by phase, so each tower or block has its own RERA number.'),
 ('Is Shalimar Mannat in Lucknow or Barabanki?',
  f'Shalimar Mannat is marketed on Faizabad Road, Lucknow, but UP RERA lists Mannat Phase-1 (UPRERAPRJ8345) in Barabanki district, Nawabganj tehsil ({R_MN}). Property is registered at the sub-registrar office of the district where it lies.'),
 ('Is Shalimar Gallant West RERA registered?',
  f'Yes. Shalimar Gallant West is registered as UPRERAPRJ569037, approved on 20 October 2022, with 69 apartments and a completion date of 20 October 2026 in the RERA record ({R_GW}). Check up-rera.in for any extension before you book.'),
 ('How do I check the RERA status of a Shalimar project?',
  'Go to up-rera.in, search the project by its RERA number, and check four things: the promoter name, the completion date and any extension, the latest quarterly progress report, and the carpet area of your unit type. All four must match your agreement.'),
 ('Who is the promoter of Shalimar OneWorld phases on RERA?',
  f'It varies by phase. For example, Whispering Woods (GH-14) is registered by M/s Shalimar Lakecity Private Limited (formerly M/s ANS Developers Private Limited) as UPRERAPRJ380751 ({R_WW}), while Gallant West is registered by M/s Shalimar Corp Ltd. Your agreement should name the same company as the RERA record.'),
]

body = []
body.append('<p style="font-size:13px;color:#6b7280;margin:0 0 24px;padding-bottom:14px;border-bottom:1px solid #e2e8f0;">Sources: Shalimar Corp website, UP RERA project records (via Aurum PropTech\'s RERA mirror), Realty Today, ThePrint/ANI and project listings where marked. Independent guide by DSD Properties — we are not affiliated with Shalimar Corp. <strong>Updated: 18 October 2026.</strong></p>')
body.append('<!-- key-facts -->\n<div class="dsd-key-facts" style="background:#f0fdfa;border:1px solid rgba(0,128,128,0.25);border-left:4px solid #008080;border-radius:0 12px 12px 0;padding:16px 20px;margin:0 0 24px;">\n'
 '<p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">Key Facts (updated 18 October 2026)</p>\n<ul style="margin:0;padding-left:20px;">'
 + ''.join(f'<li style="margin:5px 0;line-height:1.7;">{x}</li>' for x in [
   f'<strong>Shalimar Corp Limited</strong> is a Lucknow real estate developer established in <strong>1988</strong>, headquartered at Shalimar Titanium, Vibhuti Khand, Gomti Nagar ({WEB}).',
   f'On <strong>1 October 2026</strong>, HDFC Capital and Shalimar Corp announced a <strong>₹750 crore platform</strong> for housing in Lucknow, Varanasi and Kanpur — over 5 million sq ft and about 3,000 homes ({HDFC}).',
   f'Its largest Lucknow development, <strong>Shalimar OneWorld</strong> in Gomti Nagar Extension, is registered with UP RERA <strong>phase by phase</strong>, and some phases are registered by a group company, not Shalimar Corp itself ({R_WW}).',
   f'<strong>Shalimar Gallant West</strong> (UPRERAPRJ569037, 69 flats) has a RERA completion date of <strong>20 October 2026</strong>; <strong>Shalimar Sky Garden</strong> (UPRERAPRJ160941) is due on 25 October 2028 ({R_GW}, {R_SG}).',
   f'Shalimar <strong>Mannat</strong> and <strong>Paradise</strong>, marketed on Faizabad Road, are registered with RERA in <strong>Barabanki district</strong> ({R_MN}, {R_PD}).'])
 + '</ul>\n</div>')
body.append(P('Shalimar is one of the most visible developer names in Lucknow — on Gomti Nagar Extension, in Mahanagar, on Faizabad Road and in Vibhuti Khand. This guide sets out what can be checked about the company and its projects from official records: who the company is, which projects are registered with UP RERA, their registration and completion dates, and what a buyer should verify before paying a booking amount. Where a figure comes only from a property listing, we say so.'))
body.append(H2('company', 'Shalimar Corp — company profile'))
body.append(TABLE(['Item', 'Detail', 'Source'], [
 ['Legal name', 'Shalimar Corp Limited', WEB],
 ['Established', '1988 (CIN U70100DL1988PLC390006)', WEB],
 ['Head office', '11th Floor, Shalimar Titanium, Vibhuti Khand, Gomti Nagar, Lucknow 226010', WEB],
 ['Managing Director', 'Khalid Masood', HDFC],
 ['Director', 'Kunal Seth', VNS],
 ['Businesses', 'Real estate, property management, highway infrastructure, civil construction, glass processing', WEB],
 ['Track record (company\'s own figures)', 'Website: 70+ projects, 25 million+ sq ft, 8,000+ families. July 2026 press release: 60+ projects delivered, 21 million+ sq ft, 8,500+ customers.', f'{WEB}; {VNS}'],
 ['Recent launches', '₹6,000 crore of projects launched in the last three years; ₹4,000 crore planned for FY27', HDFC],
]))
body.append(P('The company\'s two published track-record figures differ (60+ vs 70+ projects, 21 vs 25 million sq ft). Both are the company\'s own claims; we have not found an independent count.'))

body.append(H2('news', 'Latest news'))
body.append(UL([
 f'<strong>1 October 2026:</strong> HDFC Capital Advisors and Shalimar Corp created a ₹750 crore platform for residential and mixed-use projects in Lucknow, Varanasi and Kanpur, with over 5 million sq ft of development potential and about 3,000 homes. HDFC Capital MD & CEO Vipul Roongta said emerging urban centres in Uttar Pradesh "are set to lead the next phase of housing growth" ({HDFC}).',
 f'<strong>14 July 2026:</strong> Shalimar announced its first Varanasi project, <strong>Shalimar Courtyard</strong> on Lahartara Road — about 3.75 acres, 244 homes in 6 towers, around 400 m from Varanasi Junction ({VNS}).']))

body.append(H2('oneworld', 'Shalimar OneWorld, Gomti Nagar Extension — how it is set up'))
body.append(P(f'Shalimar OneWorld is an integrated township at <strong>Village Baghamau, Gomti Nagar Extension</strong>, near Amar Shaheed Path ({OW}). It is not one RERA project: each phase — such as Valencia County, Marbella, Pinnacle, Twenty One, Whispering Woods, Belvedere Suites and Belvedere Court, all listed on the {WEB} — is registered separately.'))
body.append(P(f'Two points matter for buyers. First, published figures for the township\'s total size differ (about 200, 212 and 225 acres have all appeared), so ask for the approved layout of your phase rather than relying on a headline number ({OW}). Second, <strong>the RERA promoter can be a group company</strong>: Whispering Woods (GH-14) is registered by M/s Shalimar Lakecity Private Limited, formerly M/s ANS Developers Private Limited ({R_WW}). Your builder–buyer agreement should name the same company as the RERA record of your phase.'))
body.append(P(f'For the area itself, see our {S("blog/gomti-nagar-extension-lucknow-guide-2026", "Gomti Nagar Extension guide")}.'))

body.append(H2('projects', 'Shalimar projects and their RERA records'))
body.append(P('The table below is taken from UP RERA registration data. "RERA completion date" is the date the promoter committed to in its registration — it can be extended, so always check the live record on up-rera.in.'))
body.append(TABLE(['Project', 'Location', 'RERA no.', 'Registered', 'RERA completion date', 'Size (RERA)'], [
 [f'Shalimar Gallant West ({R_GW})', 'Lucknow (Mahanagar)', 'UPRERAPRJ569037', '20 Oct 2022', '20 Oct 2026', '69 flats — 67 × 4 BHK + 2 × 1 BHK (EWS/LIG); 8,162 sq m land'],
 [f'Shalimar Sky Garden ({R_SG})', 'Lucknow (Vibhuti Khand)', 'UPRERAPRJ160941', '25 Oct 2023', '25 Oct 2028', '3 BHK & 4 BHK flats in a 22-floor tower plus commercial space; 13,067.82 sq m land'],
 [f'Whispering Woods, GH-14, OneWorld ({R_WW})', 'Lucknow', 'UPRERAPRJ380751', '1 Oct 2022', '30 Sep 2026', 'Promoter: Shalimar Lakecity Pvt Ltd'],
 [f'Sheres Shalimar Mannat Phase-1 ({R_MN})', 'Barabanki (Nawabganj)', 'UPRERAPRJ8345', '1 Nov 2015', '29 Sep 2020 — shown as completed', '268 flats — 96 × 2 BHK (58.21 sq m) + 172 × 3 BHK (85.26 sq m)'],
 [f'Shalimar Paradise Phase-1 ({R_PD})', 'Barabanki (Nawabganj)', 'UPRERAPRJ9777', '25 Jun 2013', '30 Dec 2018 — shown as completed', '154 villas and plots; 48,254 sq m land'],
 [f'Iridium — commercial ({R_IR})', 'Lucknow', 'UPRERAPRJ17421', '1 Sep 2018', '28 Feb 2022', 'Commercial'],
]))
body.append(P(f'<strong>Newer launches (from listings — confirm on up-rera.in):</strong> Shalimar Evara Heights, Mohammadpur Chauki — listed with RERA no. UPRERAPRJ908475 (May 2026), about 1.68 acres and 112 flats in 4 towers ({EH}); Shalimar Evara, Faizabad Road — listed with RERA no. UPRERAPRJ742268 (November 2025) ({EV}). We have not yet seen the RERA records for these two, so treat the details as the seller\'s.'))

body.append(H3('Gallant West — completion date is now'))
body.append(P(f'Gallant West\'s RERA completion date is 20 October 2026, and the record still shows construction in progress ({R_GW}). If you have booked or are about to, check on up-rera.in whether the promoter has applied for an extension, and read the latest quarterly progress report. Under the RERA Act, a buyer is entitled to interest for delay beyond the agreed date, or a refund with interest.'))
body.append(H3('Whispering Woods — completion date has passed'))
body.append(P(f'The RERA completion date for Whispering Woods (GH-14) was 30 September 2026 ({R_WW}). Check the live record for an extension or a completion/occupancy certificate before paying further instalments or buying on resale.'))
body.append(H3('Why some "Lucknow" projects are registered in Barabanki'))
body.append(P('Mannat and Paradise are marketed on Faizabad Road, Lucknow, but their land is in Nawabganj tehsil of Barabanki district, and RERA lists them there. In practice this means the sale deed is registered at the Barabanki sub-registrar office and Barabanki\'s circle rates apply. Make sure your documents and stamp duty calculation use the correct district.'))

body.append(H2('checklist', 'Buying a Shalimar flat or plot? Check these first'))
body.append('<ol style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:8px 0;line-height:1.75;color:#374151;">{x}</li>' for x in [
 '<strong>RERA number of your exact phase</strong> — a township can have many. Search it on up-rera.in.',
 '<strong>Promoter name</strong> — it must match the company in your builder–buyer agreement and on the payment receipts.',
 '<strong>Completion date and extensions</strong> — compare the RERA date with the possession date in your agreement.',
 '<strong>Quarterly progress report</strong> — RERA promoters file construction progress; read the latest one for your tower.',
 '<strong>Carpet area</strong> — the agreement should state carpet area as per RERA, not only super area.',
 f'<strong>For resale in a completed project</strong> — ask for the completion/occupancy certificate, the seller\'s registered sale deed, maintenance dues clearance, and an {S("blog/encumbrance-certificate-lucknow-how-to-apply-online", "encumbrance certificate")}; check past registries on {S("blog/igrsup-lucknow-property-search-tutorial", "IGRSUP")}.',
 '<strong>District</strong> — for Faizabad Road projects, confirm whether the land is in Lucknow or Barabanki.']) + '</ol>')
body.append('<div style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #FF5C00;border-radius:0 12px 12px 0;padding:16px 20px;margin:24px 0;">'
 '<p style="margin:0 0 6px;font-weight:700;color:#011f4b;font-size:16px;">Want us to check a Shalimar unit for you?</p>'
 '<p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">We check the RERA record, promoter, completion status, title chain and encumbrance — <strong>₹5,000 for residential flats and plots, PDF report in 48 hours</strong>. ' + S('services/property-verification-lucknow', 'See what we check →') + '</p>'
 '<p style="margin:0 0 8px;">{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}</p></div>')
body.append(P('Buying or selling a flat in a Shalimar project? DSD Properties also helps with resale purchases and sales in Lucknow — message us on WhatsApp with the project and tower.'))
body.append('{{CONSULTATION_BUTTON:Buy or Sell a Shalimar Flat — Talk to Us}}')

body.append('<section id="FAQs">\n' + H2('faq', '❓ Frequently Asked Questions'))
for q, a in FAQ:
    body.append(f'<h3 style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #008080;padding:14px 18px;border-radius:0 10px 10px 0;cursor:pointer;color:#011f4b;font-size:15px;font-weight:600;margin:14px 0 0;">{q}</h3>')
    body.append(f'<p style="display:none;background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 10px 10px;padding:14px 18px;font-size:14.5px;color:#374151;margin:0 0 10px;line-height:1.85;">{a}</p>')
body.append('</section>')
body.append('<p style="font-size:13px;color:#6b7280;margin-top:30px;padding:14px 18px;background:#f8f8f8;border-left:3px solid #ccc;border-radius:4px;"><strong>Disclaimer:</strong> DSD Properties is an independent advisory and is not affiliated with Shalimar Corp. Facts are taken from the sources linked above as of 18 October 2026. RERA records change — confirm every detail on up-rera.in before you pay.</p>')
html = '\n'.join(body)

schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
 {"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": re.sub(r'\s+', ' ', re.sub('<[^>]+>', '', a)).strip()}} for q, a in FAQ]}
row = {
 "title": "Shalimar Corp Lucknow 2026: Projects, RERA Records & Buyer Checklist",
 "slug": "shalimar-corp-lucknow-projects-rera-guide-2026",
 "meta_description": "Shalimar Corp Lucknow: company facts, OneWorld, Gallant West, Sky Garden, Mannat RERA numbers and dates, HDFC ₹750 cr deal, and what to check before booking.",
 "meta_keywords": "shalimar corp lucknow, shalimar oneworld, shalimar gallant west, shalimar sky garden, shalimar mannat, shalimar rera, shalimar projects lucknow",
 "tag": "Buying Tips",
 "blog_summary": "Independent guide to Shalimar Corp in Lucknow: company profile (est. 1988), the 1 Oct 2026 HDFC Capital ₹750 crore platform, how Shalimar OneWorld is registered phase by phase, RERA numbers and completion dates for Gallant West, Sky Garden, Whispering Woods, Mannat and Paradise, and a buyer checklist.",
 "alt": "Shalimar Corp Lucknow projects and RERA guide 2026",
 "language": "en", "status": "draft", "author_id": 9,
 "content_html": html,
 "seo_schema": json.dumps(schema, ensure_ascii=False, indent=2)}
assert len(row['meta_description']) <= 160, len(row['meta_description'])
json.dump(row, open('row.json', 'w', encoding='utf8'), ensure_ascii=False, indent=1)
print('ok', len(html), len(row['meta_description']), len(row['title']))
