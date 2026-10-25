# Adds (1) a dated history timeline with an SVG graphic and (2) a balanced "why buyers trust Shalimar" section
# to live post 170. Only dated, sourced facts. 18 Oct 2026.
import json, re, sys
cur = open('current.html', encoding='utf8', newline='').read()
h = cur

def A(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'
TOF = A('https://www.tofler.in/shalimar-corp-limited/company/U70100DL1988PLC390006', 'company filings (Tofler)')
GPTW = A('https://www.greatplacetowork.in/great/company/shalimar-corp-ltd', 'Great Place to Work')
HDFC = A('https://therealtytoday.com/news/residential/hdfc-capital-shalimar-corp-create-750-crore-platform-for-housing-in-lucknow-varanasi-kanpur', 'Realty Today')
VNS = A('https://theprint.in/ani-press-releases/shalimar-corp-limited-brings-four-decades-of-trusted-excellence-to-varanasi-marking-its-grand-entry-into-purvanchal/2985806/', 'ThePrint / ANI')
R_GW = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/shalimar-gallant-west/upreraprj569037', 'RERA')
R_SG = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/shalimar-sky-garden/upreraprj160941', 'RERA')
R_WW = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/whispering-woods-gh-14-integrated-township/upreraprj380751', 'RERA')
R_MN = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/barabanki/sheres-shalimar-mannat-phase-1/upreraprj8345', 'RERA')
R_PD = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/barabanki/shalimar-paradise-phase-1/upreraprj9777', 'RERA')
R_IR = A('https://www.aurumproptech.in/pulse/rera/uttar-pradesh/lucknow/iridium/upreraprj17421', 'RERA')
P = lambda t: f'<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 16px;">{t}</p>'
H2 = lambda i, t: f'<h2 id="{i}" style="font-size:22px;font-weight:700;color:#011f4b;margin:36px 0 12px;border-left:5px solid #FF5C00;padding-left:14px;">{t}</h2>'

# ── timeline data: (year label, date text, title, detail, source, kind) ──
T = [
 ('1988', '11 Aug 1988', 'Company incorporated', 'Shalimar Corp Limited is incorporated (CIN U70100DL1988PLC390006).', TOF, 'co'),
 ('2013', '25 Jun 2013', 'Shalimar Paradise Phase-1', 'Villas and plots, Nawabganj (Barabanki) — 154 units on 48,254 sq m.', R_PD, 'pr'),
 ('2015', '1 Nov 2015', 'Shalimar Mannat Phase-1', '268 flats (2 and 3 BHK), Nawabganj (Barabanki).', R_MN, 'pr'),
 ('2018', 'Sep–Dec 2018', 'Iridium registered; Paradise Ph-1 completed', 'Iridium (commercial) registered 1 Sep 2018. Paradise Phase-1 shows a completion date of 30 Dec 2018 and is listed as completed.', f'{R_IR}, {R_PD}', 'done'),
 ('2020', '29 Sep 2020', 'Mannat Phase-1 completed', 'RERA lists Mannat Phase-1 as fully built.', R_MN, 'done'),
 ('2022', 'Oct 2022', 'Whispering Woods and Gallant West', 'Whispering Woods, GH-14, OneWorld (1 Oct 2022) and Gallant West, 69 flats (20 Oct 2022) registered.', f'{R_WW}, {R_GW}', 'pr'),
 ('2023', '2023', 'Workplace recognition; Sky Garden', 'Listed in Great Place to Work\'s "India\'s Best Companies to Work For 2023 (Top 100)". Sky Garden registered on 25 Oct 2023.', f'{GPTW}, {R_SG}', 'co'),
 ('2025', 'FY 2024-25', 'Operating revenue over ₹500 crore', 'Reported in the company\'s filings for the year ending March 2025.', TOF, 'co'),
 ('2026', 'Jul–Oct 2026', 'Varanasi entry; HDFC Capital platform', 'First Varanasi project, Shalimar Courtyard (14 Jul 2026). ₹750 crore platform with HDFC Capital for Lucknow, Varanasi and Kanpur (1 Oct 2026); ₹6,000 crore launched in the previous three years.', f'{VNS}, {HDFC}', 'co'),
]

# ── SVG overview graphic (proportional year axis 1988–2026) ──
x0, x1, y0, y1 = 40, 860, 1988, 2026
X = lambda y: x0 + (x1 - x0) * (y - y0) / (y1 - y0)
col = {'co': '#FF5C00', 'pr': '#008080', 'done': '#16a34a'}
svg = ['<svg viewBox="0 0 900 190" role="img" aria-label="Shalimar Corp milestones 1988 to 2026" style="width:100%;height:auto;display:block;">',
       '<rect x="0" y="0" width="900" height="190" rx="14" fill="#f8fafc"/>',
       f'<line x1="{x0}" y1="110" x2="{x1}" y2="110" stroke="#011f4b" stroke-width="3" stroke-linecap="round"/>']
for yr in range(1990, 2030, 5):
    if yr <= 2026:
        svg.append(f'<line x1="{X(yr):.1f}" y1="104" x2="{X(yr):.1f}" y2="116" stroke="#94a3b8" stroke-width="1.5"/><text x="{X(yr):.1f}" y="138" font-size="12" fill="#64748b" text-anchor="middle" font-family="Arial">{yr}</text>')
labels = {}
for i, (lab, _, title, _, _, kind) in enumerate(T):
    yr = int(lab)
    cx = X(yr + (0.6 if lab == '2025' else 0))
    up = i % 2 == 0
    ly = 62 if up else 168
    svg.append(f'<line x1="{cx:.1f}" y1="110" x2="{cx:.1f}" y2="{78 if up else 150}" stroke="{col[kind]}" stroke-width="1.5"/>')
    svg.append(f'<circle cx="{cx:.1f}" cy="110" r="8" fill="{col[kind]}" stroke="#fff" stroke-width="2.5"/>')
    short = {'1988': 'Incorporated', '2013': 'Paradise Ph-1', '2015': 'Mannat Ph-1', '2018': 'Paradise done', '2020': 'Mannat done',
             '2022': 'Gallant West', '2023': 'Sky Garden', '2025': '₹500 Cr+ revenue', '2026': 'HDFC ₹750 Cr'}[lab]
    svg.append(f'<text x="{cx:.1f}" y="{ly - 16 if up else ly}" font-size="13" font-weight="700" fill="#011f4b" text-anchor="middle" font-family="Arial">{lab}</text>')
    svg.append(f'<text x="{cx:.1f}" y="{ly - 1 if up else ly + 15}" font-size="11.5" fill="#475569" text-anchor="middle" font-family="Arial">{short}</text>')
svg.append('</svg>')
legend = ('<div style="display:flex;flex-wrap:wrap;gap:14px;font-size:13px;color:#475569;margin:8px 4px 4px;">'
          '<span><i style="display:inline-block;width:11px;height:11px;border-radius:50%;background:#FF5C00;margin-right:6px;"></i>Company milestone</span>'
          '<span><i style="display:inline-block;width:11px;height:11px;border-radius:50%;background:#008080;margin-right:6px;"></i>Project registered</span>'
          '<span><i style="display:inline-block;width:11px;height:11px;border-radius:50%;background:#16a34a;margin-right:6px;"></i>Project completed (per RERA)</span></div>')

cards = []
for lab, date, title, detail, src, kind in T:
    cards.append(f'<div style="position:relative;padding:0 0 18px 30px;border-left:3px solid #e2e8f0;margin-left:8px;">'
                 f'<span style="position:absolute;left:-9px;top:3px;width:15px;height:15px;border-radius:50%;background:{col[kind]};border:3px solid #fff;box-shadow:0 0 0 1px {col[kind]};"></span>'
                 f'<div style="font-size:13px;font-weight:700;color:{col[kind]};letter-spacing:.03em;">{date}</div>'
                 f'<div style="font-size:16px;font-weight:700;color:#011f4b;margin:2px 0 4px;">{title}</div>'
                 f'<div style="font-size:14.5px;color:#374151;line-height:1.7;">{detail} <span style="color:#6b7280;">({src})</span></div></div>')

HIST = (H2('history', 'Shalimar\'s history, year by year') +
 P('The timeline below uses only dated records: the company\'s incorporation filing, UP RERA registrations and completion dates, and dated news. Shalimar does not publish year-wise sales or sq ft figures, so we show milestones rather than a growth curve.') +
 '<div style="border:1px solid #e2e8f0;border-radius:14px;padding:10px;margin:8px 0 22px;background:#fff;">' + ''.join(svg) + legend + '</div>' +
 '<div style="margin:6px 0 18px;">' + ''.join(cards) + '</div>' +
 P('Project dates before 2013 are not in the RERA system (UP RERA began registering projects in 2017, and older projects appear only if they were still ongoing then), so Shalimar projects completed before then are not dated here.'))

TRUST = (H2('trust', 'Why buyers trust Shalimar — and what to check') +
 P('Trust in a developer should rest on records, not reputation. Here is what the public record shows in Shalimar\'s favour, and the open points a careful buyer should check.') +
 '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px;margin:10px 0 20px;">' +
 ''.join(f'<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px 16px;"><div style="font-size:15px;font-weight:700;color:#166534;margin-bottom:4px;">✓ {t}</div><div style="font-size:14px;color:#374151;line-height:1.7;">{d}</div></div>' for t, d in [
   ('38 years as a registered company', f'Incorporated on 11 August 1988 and shown as active in its filings ({TOF}).'),
   ('Completed RERA projects on record', f'Mannat Phase-1 (268 flats) and Paradise Phase-1 (154 villas and plots) are listed as completed on UP RERA ({R_MN}, {R_PD}).'),
   ('Institutional partner', f'In October 2026 HDFC Capital, the real estate private equity arm of the HDFC Group, set up a ₹750 crore platform with Shalimar ({HDFC}).'),
   ('Size of the business', f'Operating revenue of over ₹500 crore in FY 2024-25, per its filings ({TOF}).'),
   ('Workplace recognition', f'Great Place to Work-Certified and listed among India\'s Best Companies to Work For 2023 (Top 100) ({GPTW}).'),
   ('Registered projects you can look up', 'Every current project in this guide has a public RERA number, so buyers can check dates and progress themselves on up-rera.in.')]) +
 '</div>' +
 '<div style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #FF5C00;border-radius:0 12px 12px 0;padding:14px 18px;margin:0 0 20px;">' +
 '<div style="font-size:15px;font-weight:700;color:#9a3412;margin-bottom:6px;">Check before you pay</div>' +
 '<ul style="margin:0;padding-left:20px;">' + ''.join(f'<li style="margin:5px 0;line-height:1.7;color:#374151;">{x}</li>' for x in [
   f'Gallant West\'s RERA completion date is 20 October 2026 and the record still shows construction in progress ({R_GW}).',
   f'Whispering Woods\' RERA completion date (30 September 2026) has passed ({R_WW}) — check for an extension or completion certificate.',
   'Some OneWorld phases are registered by a group company (Shalimar Lakecity Pvt Ltd), not Shalimar Corp — make sure your agreement names the RERA promoter.',
   'Shalimar\'s track-record figures (projects delivered, sq ft) are its own and differ between its website and press releases.']) +
 '</ul></div>' +
 P('Our view: a long record and an institutional partner are good signs, but they do not replace checking your own unit. The safest buyer is the one who verifies the RERA record, the promoter and the title before paying.'))

# ── insert: history after the company-profile note, trust before the checklist ──
anchor1 = '<h2 id="news"'
anchor2 = '<h2 id="checklist"'
assert h.count(anchor1) == 1 and h.count(anchor2) == 1 and 'id="history"' not in h
h = h.replace(anchor1, HIST + '\n' + anchor1).replace(anchor2, TRUST + '\n' + anchor2)

# ── extra FAQ ──
faq_q = 'Is Shalimar Corp a trustworthy developer?'
faq_a = (f'Its record has clear positives: incorporated in 1988, completed projects listed on UP RERA (Mannat Phase-1, Paradise Phase-1), a ₹750 crore platform with HDFC Capital announced in October 2026, and operating revenue over ₹500 crore in FY 2024-25. '
         f'Two current projects are at or past their RERA completion dates (Gallant West, Whispering Woods), so check the live RERA record, the promoter name and the title of your unit before paying.')
end = h.find('</section>', h.find('<section id="FAQs">'))
q_html = '<h3 style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #008080;padding:14px 18px;border-radius:0 10px 10px 0;cursor:pointer;color:#011f4b;font-size:15px;font-weight:600;margin:14px 0 0;">' + faq_q + '</h3>'
a_html = '<p style="display:none;background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 10px 10px;padding:14px 18px;font-size:14.5px;color:#374151;margin:0 0 10px;line-height:1.85;">' + faq_a + '</p>'
h = h[:end] + q_html + '\n' + a_html + '\n' + h[end:]

open('new.html', 'w', encoding='utf8', newline='').write(h)
sec = h[h.find('<section id="FAQs">'):]
faqs = re.findall(r'<h3[^>]*>(.*?)</h3>\s*<p style="display:none;[^>]*>(.*?)</p>', sec, re.S)
schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
 {"@type": "Question", "name": re.sub('<[^>]+>', '', q).strip(), "acceptedAnswer": {"@type": "Answer", "text": re.sub(r'\s+', ' ', re.sub('<[^>]+>', '', a)).strip()}} for q, a in faqs]}
json.dump({"seo_schema": json.dumps(schema, ensure_ascii=False, indent=2)}, open('newmeta.json', 'w', encoding='utf8'), ensure_ascii=False)
print('ok', len(cur), len(h), 'faqs', len(faqs))
