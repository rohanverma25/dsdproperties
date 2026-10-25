# New article: Shalimar OneWorld (Gomti Nagar Extension) — all projects, price sheet data, RERA. EN. 19 Oct 2026.
# Price/area/possession data: Shalimar OneWorld price sheet (BSP applicable from 1 Aug 2026) shared by the user.
# RERA numbers, validity dates and promoters: official UP RERA certificates hosted on shalimar-oneworld.com.
import json, re, urllib.parse

def A(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'
def S(path, text): return f'<a href="https://dsdproperties.in/{path}" style="color:#008080;font-weight:600;">{text}</a>'
OFF = A('https://shalimar-oneworld.com/', 'official Shalimar OneWorld website')
def CERT(fn, label='RERA certificate'): return A('https://shalimar-oneworld.com/pdf/' + urllib.parse.quote(fn), label)
CORP = S('blog/shalimar-corp-lucknow-projects-rera-guide-2026', 'Shalimar Corp guide')

LAKE = 'Shalimar Lakecity Pvt Ltd (formerly ANS Developers Pvt Ltd)'
# name, slug-id, type, possession(sheet), rera, rera_end, promoter, cert, rows[(unit, sbua, carpet, bsp)]
PROJ = [
 ('Pinnacle', 'pinnacle', 'Apartments', 'Dec 2028', 'UPRERAPRJ705722/01/2024', '31 Dec 2028', LAKE, 'RERA Registration - OW Pinnacle GH-13.pdf',
  [('4 BHK + S', 4500, 3041.37, 12000)]),
 ('Marbella', 'marbella', 'Apartments', 'Feb 2029', 'UPRERAPRJ460592/05/2024', '20 Feb 2029', LAKE, 'RERA Registration - OW Marbella (GH-18).pdf',
  [('2 BHK + Study', 1530, 964.67, 9000), ('3 BHK', 1770, 1103.96, 9000), ('3 BHK + S', 1965, 1168.32, 9500), ('3 BHK + S', 2300, 1379.41, 9500)]),
 ('Twenty One', 'twenty-one', 'Apartments', 'Feb 2029', 'UPRERAPRJ858081/05/2024', '20 Feb 2029', 'Shalimar Corp Ltd', 'RERA Registration - OW Twenty One (GH-21).pdf',
  [('3 BHK + S', 2550, 1521.28, 9500), ('3 BHK + S', 2650, 1547.38, 9500)]),
 ('Valencia Towers 2', 'valencia-towers-2', 'Apartments', 'Jul 2029', 'UPRERAPRJ944626/09/2024', '20 Jul 2029', None, '../pdf/REGISTRATION-CERTIFICATE-Valencia-Towers- Phase-2.pdf',
  [('4 BHK + S', 2875, 1918.57, 9200), ('4 BHK + S', 2975, 1981, 10000)]),
 ('Valencia Tower', 'valencia-tower', 'Apartments', 'Oct 2028', 'UPRERAPRJ496663', None, None, 'RERA Registration - OW Valencia Tower (GH-17).pdf',
  [('4 BHK + S', 3700, 2324, 10250)]),
 ('Valencia County East', 'valencia-county-east', 'Villas', 'Oct 2026', 'UPRERAPRJ707640', None, None, 'RERA Registration - OW Valencia County East (GH-18).pdf',
  [('4 BHK + S', 6530, 4846, 11500)]),
 ('Valencia County East Phase 2', 'valencia-county-east-2', 'Villas', 'Dec 2029', 'UPRERAPRJ225264/12/2025', '31 Dec 2029', LAKE, 'RERA-Registration-Valencia-County-East-Phase-2.pdf',
  [('4 BHK + S', 7790, 5849, 11500)]),
 ('Whispering Woods', 'whispering-woods', 'Apartments', 'Sep 2026', 'UPRERAPRJ380751', '30 Sep 2026', LAKE, 'RERA Registration - OW Whispering Woods (GH-14).pdf',
  [('3 BHK + S', 2050, 1390, 10000), ('3 BHK + S', 2345, 1470, 10000)]),
 ('Belvedere Suites', 'belvedere-suites', 'Apartments', 'Sep 2026', 'UPRERAPRJ263280', '30 Sep 2026', LAKE, 'RERA Registration - OW Belvedere Suites (GH-12).pdf',
  [('4 BHK + S', 3025, 1851, 10500), ('4 BHK + S', 3100, 1851, 10500), ('4 BHK + S', 5340, 3348.79, 10550)]),
 ('Shalimar Business District (SBD)', 'sbd', 'Office Space', 'Dec 2027', 'UPRERAPRJ143786/01/2024', '15 Dec 2027', LAKE, 'RERA Registration - OW Shalimar Business District Tower 1.pdf',
  [('Office space', None, None, 11000)]),
]
def fix_cert(fn):  # VT2 certificate sits in /pdf/ with a different name
    return A('https://shalimar-oneworld.com/pdf/' + urllib.parse.quote('REGISTRATION-CERTIFICATE-Valencia-Towers- Phase-2.pdf'), 'RERA certificate') if fn.startswith('../') else CERT(fn)
MON = {'Jan':1,'Feb':2,'Mar':3,'Apr':4,'May':5,'Jun':6,'Jul':7,'Aug':8,'Sep':9,'Oct':10,'Nov':11,'Dec':12}
key = lambda p: int(p.split()[1]) * 100 + MON[p.split()[0][:3]]
inr = lambda v: f'₹{v/1e7:.2f} Cr' if v >= 1e7 else f'₹{v/1e5:.1f} lakh'
num = lambda x: f'{x:,.0f}' if float(x).is_integer() else f'{x:,.2f}'
past = lambda e: e is not None and key(' '.join(e.split()[1:])) < 202610 or (e is not None and e.endswith('Sep 2026'))

P_ = lambda t: f'<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 16px;">{t}</p>'
H2 = lambda i, t: f'<h2 id="{i}" style="font-size:22px;font-weight:700;color:#011f4b;margin:36px 0 12px;border-left:5px solid #FF5C00;padding-left:14px;">{t}</h2>'
BOX = lambda title, inner, c='#008080', bg='#f0fdfa': f'<div style="background:{bg};border:1px solid {c}33;border-left:4px solid {c};border-radius:0 12px 12px 0;padding:16px 20px;margin:18px 0 22px;"><p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>{inner}</div>'
def TABLE(head, rows, minw=640):
    th = ''.join(f'<th style="padding:10px 12px;text-align:left;background:#011f4b;color:#fff;font-size:13px;white-space:nowrap;">{h}</th>' for h in head)
    tr = ''.join('<tr>' + ''.join(f'<td style="padding:9px 12px;border:1px solid #e2e8f0;font-size:14px;vertical-align:top;">{c}</td>' for c in r) + '</tr>' for r in rows)
    return f'<div style="overflow-x:auto;margin:14px 0 18px;"><table style="width:100%;border-collapse:collapse;min-width:{minw}px;"><thead><tr>{th}</tr></thead><tbody>{tr}</tbody></table></div>'

ICON = {'Apartments': '🏢', 'Villas': '🏡', 'Office Space': '💼'}
COL = {'Apartments': '#008080', 'Villas': '#7c3aed', 'Office Space': '#b45309'}
def band(k): return 'soon' if k <= 202612 else ('mid' if k <= 202812 else 'late')

cards = []
for name, sid, typ, poss, rera, rend, prom, cert, rows in PROJ:
    k = key(poss); short = 'SBD' if sid == 'sbd' else name
    minbsp = min(r[3] for r in rows)
    vr = ''
    for u, sb, ca, bsp in rows:
        tot = inr(sb * bsp) if sb else '—'
        vr += (f'<tr><td style="padding:7px 8px;border-top:1px solid #eef2f7;font-weight:600;color:#011f4b;">{u}</td>'
               f'<td style="padding:7px 8px;border-top:1px solid #eef2f7;">{num(sb) if sb else "—"}</td>'
               f'<td style="padding:7px 8px;border-top:1px solid #eef2f7;">{num(ca) if ca else "—"}</td>'
               f'<td style="padding:7px 8px;border-top:1px solid #eef2f7;">₹{bsp:,}</td>'
               f'<td style="padding:7px 8px;border-top:1px solid #eef2f7;font-weight:700;color:#011f4b;">{tot}</td></tr>')
    units = sorted(set(r[0] for r in rows), key=lambda x: [r[0] for r in rows].index(x))
    msg = f"Hi, I want to invest in Shalimar OneWorld {name} ({', '.join(units)}, possession {poss}). Please share current price, availability and a site visit."
    wa = 'https://wa.me/918595002933?text=' + urllib.parse.quote(msg)
    rinfo = f'RERA {rera}' + (f' · RERA end date {rend}' if rend else '')
    warn = ''
    if rend and rend.endswith('Sep 2026'):
        warn = '<div style="background:#fef3c7;color:#92400e;font-size:12.5px;font-weight:600;padding:6px 9px;border-radius:8px;margin:0 0 10px;">⚠ RERA end date has passed — check the extension or completion status before paying.</div>'
    cards.append(
     f'<div class="ow-card" data-type="{typ}" data-poss="{band(k)}" data-k="{k}" data-bsp="{minbsp}" style="background:#fff;border:1px solid #e2e8f0;border-top:4px solid {COL[typ]};border-radius:14px;padding:16px;display:flex;flex-direction:column;box-shadow:0 2px 10px rgba(1,31,75,.05);">'
     f'<div style="font-size:12px;font-weight:700;letter-spacing:.05em;color:{COL[typ]};text-transform:uppercase;">{ICON[typ]} {typ}</div>'
     f'<div style="font-size:18px;font-weight:800;color:#011f4b;line-height:1.25;margin:3px 0 6px;">{name}</div>'
     f'<div style="display:flex;flex-wrap:wrap;gap:6px 12px;font-size:13.5px;color:#374151;margin-bottom:6px;"><span>📅 Possession: <strong>{poss}</strong></span><span>💰 BSP from <strong>₹{minbsp:,}/sq ft</strong></span></div>'
     f'<div style="font-size:12px;color:#64748b;margin-bottom:8px;">{rinfo}</div>{warn}'
     f'<div style="overflow-x:auto;margin:0 0 12px;"><table style="width:100%;border-collapse:collapse;font-size:13px;color:#374151;"><thead><tr style="color:#64748b;font-size:11.5px;text-transform:uppercase;letter-spacing:.03em;"><th style="text-align:left;padding:4px 8px;">Unit</th><th style="text-align:left;padding:4px 8px;">SBUA</th><th style="text-align:left;padding:4px 8px;">Carpet</th><th style="text-align:left;padding:4px 8px;">BSP</th><th style="text-align:left;padding:4px 8px;">Basic cost*</th></tr></thead><tbody>{vr}</tbody></table></div>'
     f'<a href="{wa}" target="_blank" rel="noopener" style="margin-top:auto;display:block;text-align:center;background:#FF5C00;color:#fff;font-weight:700;font-size:15px;padding:11px 12px;border-radius:10px;text-decoration:none;">Invest in {short} →</a></div>')

btn = lambda f, label, active=False: (f'<button type="button" class="ow-f" data-f="{f}" aria-pressed="{"true" if active else "false"}" style="border:1px solid #cbd5e1;background:#fff;color:#011f4b;font-weight:600;font-size:13.5px;padding:7px 14px;border-radius:999px;cursor:pointer;margin:0 6px 8px 0;">{label}</button>')
INTERACTIVE = f'''<div id="ow-wrap" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:16px;margin:10px 0 18px;">
 <div>{btn("all","All projects",True)}{btn("Apartments","🏢 Apartments")}{btn("Villas","🏡 Villas")}{btn("Office Space","💼 Office")}</div>
 <div>{btn("soon","Possession 2026")}{btn("mid","2027–28")}{btn("late","2029")}</div>
 <div style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin:4px 0 12px;">
  <label for="ow-sort" style="font-size:13.5px;font-weight:600;color:#011f4b;">Sort by</label>
  <select id="ow-sort" style="border:1px solid #cbd5e1;border-radius:8px;padding:6px 10px;font-size:13.5px;color:#011f4b;background:#fff;">
   <option value="k">Earliest possession</option><option value="bsp">Lowest BSP per sq ft</option><option value="-bsp">Highest BSP per sq ft</option></select>
  <span id="ow-count" style="font-size:13px;color:#64748b;"></span></div>
 <div id="ow-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:14px;">
{chr(10).join(cards)}
 </div>
 <p style="font-size:12.5px;color:#64748b;margin:14px 0 0;line-height:1.7;">SBUA = super built-up area; carpet = carpet area; both in sq ft as given in the price sheet. BSP = basic sale price per sq ft of SBUA, applicable from 1 August 2026. <strong>*Basic cost = SBUA × BSP</strong> — it excludes preferential location charges, car parking, club and maintenance charges, GST, stamp duty and registration. <strong>+ S</strong> = an additional room as written in the sheet; confirm its use in the floor plan.</p>
</div>
<script>
(function () {{
  var wrap = document.getElementById('ow-wrap'); if (!wrap) return;
  var grid = document.getElementById('ow-grid'), count = document.getElementById('ow-count'), sel = document.getElementById('ow-sort');
  var cards = Array.prototype.slice.call(grid.querySelectorAll('.ow-card'));
  var typeF = 'all', possF = 'all';
  var btns = Array.prototype.slice.call(wrap.querySelectorAll('.ow-f'));
  function order() {{
    var s = sel.value, neg = s.charAt(0) === '-', f = neg ? s.slice(1) : s;
    cards.sort(function (a, b) {{ var d = (+a.getAttribute('data-' + f)) - (+b.getAttribute('data-' + f)); if (!d) d = (+a.getAttribute('data-k')) - (+b.getAttribute('data-k')); return neg ? -d : d; }});
    cards.forEach(function (c) {{ grid.appendChild(c); }});
  }}
  function paint() {{
    btns.forEach(function (b) {{
      var f = b.getAttribute('data-f'), on = (f === typeF) || (f === possF) || (f === 'all' && typeF === 'all' && possF === 'all');
      b.setAttribute('aria-pressed', on ? 'true' : 'false');
      b.style.background = on ? '#011f4b' : '#fff'; b.style.color = on ? '#fff' : '#011f4b'; b.style.borderColor = on ? '#011f4b' : '#cbd5e1';
    }});
    var n = 0;
    cards.forEach(function (c) {{
      var ok = (typeF === 'all' || c.getAttribute('data-type') === typeF) && (possF === 'all' || c.getAttribute('data-poss') === possF);
      c.style.display = ok ? 'flex' : 'none'; if (ok) n++;
    }});
    count.textContent = n ? ('Showing ' + n + ' of ' + cards.length + ' projects') : 'No project matches these filters';
  }}
  btns.forEach(function (b) {{
    b.addEventListener('click', function () {{
      var f = b.getAttribute('data-f');
      if (f === 'all') {{ typeF = 'all'; possF = 'all'; }}
      else if (f === 'soon' || f === 'mid' || f === 'late') {{ possF = (possF === f) ? 'all' : f; }}
      else {{ typeF = (typeF === f) ? 'all' : f; }}
      paint();
    }});
  }});
  sel.addEventListener('change', function () {{ order(); paint(); }});
  order(); paint();
}})();
</script>'''

# full static table (every row of the sheet)
full = []
for name, sid, typ, poss, rera, rend, prom, cert, rows in PROJ:
    for i, (u, sb, ca, bsp) in enumerate(rows):
        full.append([f'<strong>{name}</strong>' if i == 0 else '', typ if i == 0 else '', num(sb) if sb else '—', num(ca) if ca else '—', u, poss if i == 0 else '', f'₹{bsp:,}', inr(sb * bsp) if sb else '—'])

rera_rows = []
for name, sid, typ, poss, rera, rend, prom, cert, rows in PROJ:
    rera_rows.append([f'<strong>{name}</strong>', rera, rend or 'Not readable (certificate is a scanned image)', prom or 'Not readable from the certificate file', poss, fix_cert(cert)])

COMPLETED = [
 ['Valencia County', 'UPRERAPRJ612919', 'Villas', 'Registration ran 21 Oct 2020–30 Aug 2024 (after an extension)', CERT('RERA Registration - OW Valencia County (GH-17) Time Extension.pdf')],
 ['Vista (GH-1 & GH-2)', 'UPRERAPRJ4833', 'Apartments (2 & 3 BHK, 7 towers per the official site)', 'Registration ran 29 Jul 2017–28 Mar 2021', CERT('RERA Registration - OW Revised Group Housing GH-1 & GH-2 (Vista).pdf')],
 ['Belvedere Court 1', 'UPRERAPRJ12850', 'Not stated', 'Listed as completed', OFF],
 ['Belvedere Court 2 (GH-6)', 'UPRERAPRJ17338', 'Group housing (GH-6)', 'Registration ran 13 Aug 2018–4 Aug 2022', CERT('RERA Registration - OW Belvedere Court Phase-2 (GH-6).pdf')],
 ['Belvedere Court 3', 'UPRERAPRJ260653', 'Not stated', 'Listed as completed', OFF],
]

FAQ = [
 ('Where is Shalimar OneWorld?', 'Shalimar OneWorld is an integrated township at Village Baghamau, Gomti Nagar Extension, Lucknow, near Amar Shaheed Path. It is developed by the Shalimar Group; most phases are registered by Shalimar Lakecity Pvt Ltd.'),
 ('Which Shalimar OneWorld projects are on sale now?', 'Shalimar\'s price sheet effective 1 August 2026 lists Pinnacle, Marbella, Twenty One, Valencia Towers 2, Valencia Tower, Valencia County East, Valencia County East Phase 2, Whispering Woods, Belvedere Suites and Shalimar Business District (offices).'),
 ('What is the price per sq ft in Shalimar OneWorld?', 'From 1 August 2026 the basic sale price (BSP) ranges from ₹9,000 per sq ft of super built-up area (Marbella 2 BHK + Study and 3 BHK) to ₹12,000 per sq ft (Pinnacle). Offices in Shalimar Business District are ₹11,000 per sq ft. Other charges, GST, stamp duty and registration are extra.'),
 ('Which is the cheapest unit in Shalimar OneWorld?', 'On the 1 August 2026 sheet, the lowest basic cost is the Marbella 2 BHK + Study: 1,530 sq ft super built-up area at ₹9,000 per sq ft, a basic cost of about ₹1.38 crore before other charges.'),
 ('Who is the developer of Shalimar OneWorld?', 'Shalimar OneWorld is a Shalimar Group township. Most phases are registered on UP RERA by Shalimar Lakecity Pvt Ltd (formerly ANS Developers Pvt Ltd); Twenty One is registered by Shalimar Corp Ltd. Your agreement should name the same company as your phase\'s RERA certificate.'),
 ('Are Whispering Woods and Belvedere Suites delayed?', 'Both RERA registrations ran until 30 September 2026, and Shalimar\'s sheet also shows September 2026 possession. As of 19 October 2026 the official website still lists both as ongoing. Ask for an RERA extension letter or a completion/occupancy certificate before paying further.'),
 ('What does "+ S" mean in the unit type?', 'The price sheet writes units like "3 BHK + S" — an additional room beyond the bedrooms. Its exact use and size are in the floor plan; ask the sales team to show it before booking.'),
]

b = []
b.append(f'<p style="font-size:13px;color:#6b7280;margin:0 0 24px;padding-bottom:14px;border-bottom:1px solid #e2e8f0;">Sources: Shalimar OneWorld price sheet (BSP applicable from 1 August 2026); UP RERA registration certificates published on the {OFF}. Independent guide by DSD Properties — we are not the developer. <strong>Updated: 19 October 2026.</strong></p>')
b.append('<!-- key-facts -->\n' + BOX('Key Facts (updated 19 October 2026)', '<ul style="margin:0;padding-left:20px;">' + ''.join(f'<li style="margin:5px 0;line-height:1.7;">{x}</li>' for x in [
 '<strong>Shalimar OneWorld</strong> is the Shalimar Group\'s integrated township at Village Baghamau, <strong>Gomti Nagar Extension</strong>, near Amar Shaheed Path.',
 '<strong>10 projects</strong> are on Shalimar\'s current price sheet: 7 apartment projects, 2 villa projects and 1 office tower (Valencia County East has two phases).',
 '<strong>BSP ₹9,000–₹12,000 per sq ft</strong> of super built-up area, applicable from 1 August 2026; the lowest basic cost is about ₹1.38 crore (Marbella 2 BHK + Study).',
 'Possession dates run from <strong>September 2026 to December 2029</strong> and match the end of each project\'s RERA registration where the certificate is readable.',
 'Most phases are registered by <strong>Shalimar Lakecity Pvt Ltd</strong>; <strong>Twenty One</strong> is registered by <strong>Shalimar Corp Ltd</strong>.']) + '</ul>'))
b.append(P_(f'This guide covers only <strong>Shalimar OneWorld</strong>, the township in Gomti Nagar Extension. For the developer as a whole — its history, financial record and projects elsewhere in Lucknow and Varanasi — read our {CORP}.'))

b.append(H2('what', 'What is Shalimar OneWorld?'))
b.append(P_(f'Shalimar OneWorld is an integrated township — homes, villas, offices, a club and open spaces planned together — at <strong>Village Baghamau, Gomti Nagar Extension</strong>, near Amar Shaheed Path. The {OFF} describes it as a township on the banks of the Gomti, built around a central lake. It is built in phases, and <strong>each phase has its own UP RERA registration</strong>, so a buyer should always check the certificate of the exact phase and tower.'))
b.append(BOX('Who you are buying from', P_('The UP RERA certificates show that most OneWorld phases are registered by <strong>Shalimar Lakecity Private Limited</strong> (formerly ANS Developers Private Limited), with its office at Shalimar Titanium, Vibhuti Khand, Gomti Nagar. <strong>Twenty One</strong> is registered by <strong>Shalimar Corp Ltd</strong>. Both are Shalimar Group companies — make sure your agreement and receipts are in the name on your phase\'s certificate.').replace('margin:0 0 16px', 'margin:0')))

b.append(H2('projects', 'All Shalimar OneWorld projects on sale — prices, sizes and possession'))
b.append(P_('Tap a filter or change the sort order. Each card shows every unit option on the price sheet: super built-up area, carpet area, BSP and the basic cost. Tap <strong>Invest</strong> to ask us on WhatsApp for current availability, the full cost sheet and a site visit.'))
b.append(INTERACTIVE)

b.append(H2('price-table', 'Complete price sheet (BSP from 1 August 2026)'))
b.append(P_('The same data in one table — every row from Shalimar\'s sheet.'))
b.append(TABLE(['Project', 'Type', 'SBUA (sq ft)', 'Carpet (sq ft)', 'Unit type', 'Possession', 'BSP (₹/sq ft)', 'Basic cost*'], full, minw=820))
b.append(P_('<span style="font-size:13px;color:#64748b;">*Basic cost = SBUA × BSP. It is not the final price: preferential location charges, parking, club and maintenance charges, GST, stamp duty and registration are extra. Prices can change; ask for the latest sheet.</span>'))

b.append(H2('carpet', 'Super built-up area vs carpet area — what you actually get'))
b.append(P_('Prices are per sq ft of <strong>super built-up area (SBUA)</strong>, which includes walls and a share of lobbies, lifts and common areas. <strong>Carpet area</strong> is the floor inside your home. On this sheet, carpet area is roughly 58–75% of SBUA — for example, the Marbella 2 BHK + Study is 1,530 sq ft SBUA but 964.67 sq ft carpet (63%), while the Valencia County East villa is 6,530 sq ft SBUA and 4,846 sq ft carpet (74%). Compare projects on price per sq ft of <strong>carpet</strong> area, and make sure your agreement states the RERA carpet area.'))

b.append(H2('rera', 'RERA registration of each project'))
b.append(P_('From the registration certificates published on the official website. The RERA end date is the date by which the promoter committed to complete; it can be extended by UP RERA.'))
b.append(TABLE(['Project', 'RERA no.', 'RERA end date', 'Promoter on certificate', 'Possession (price sheet)', 'Certificate'], rera_rows, minw=860))
b.append(BOX('Two projects are past their RERA end date', P_('Whispering Woods and Belvedere Suites were registered until <strong>30 September 2026</strong>, and the price sheet also shows September 2026 possession. On 19 October 2026 the official website still lists both as ongoing. Before paying further instalments, ask for the RERA extension order or a completion/occupancy certificate, and check the live record on up-rera.in.').replace('margin:0 0 16px', 'margin:0'), c='#FF5C00', bg='#fff7ed'))

b.append(H2('completed', 'Completed Shalimar OneWorld phases'))
b.append(P_('The official website lists these OneWorld phases as completed. They are not on the current price sheet; homes here change hands on resale.'))
b.append(TABLE(['Phase', 'RERA no.', 'Type', 'RERA record', 'Source'], COMPLETED, minw=720))

b.append(H2('checklist', 'Before you book in Shalimar OneWorld'))
b.append('<ol style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:8px 0;line-height:1.75;color:#374151;">{x}</li>' for x in [
 '<strong>Get the full cost sheet</strong> — BSP plus every other charge, GST, stamp duty and registration, in writing.',
 '<strong>Check your phase\'s RERA certificate</strong> — number, promoter and end date — on up-rera.in, not only in the brochure.',
 '<strong>Agreement in the right name</strong> — Shalimar Lakecity Pvt Ltd or Shalimar Corp Ltd, exactly as on the certificate.',
 '<strong>Carpet area in the agreement</strong> — as per RERA, and see the "+ S" room on the floor plan.',
 '<strong>Construction progress</strong> — the official site publishes construction updates; compare them with the RERA quarterly report before each instalment.',
 f'<strong>Resale in completed phases</strong> — ask for the registered sale deed, society dues clearance and an {S("blog/encumbrance-certificate-lucknow-how-to-apply-online", "encumbrance certificate")}.']) + '</ol>')
b.append(BOX('Want an independent check before you pay?', '<p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">We check the RERA record, promoter, completion status, title and encumbrance — <strong>₹5,000 for residential flats and plots, PDF report in 48 hours</strong>. ' + S('services/property-verification-lucknow', 'See what we check →') + '</p><p style="margin:0;">{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}</p>', c='#FF5C00', bg='#fff7ed'))
b.append(P_(f'Buying or selling in Shalimar OneWorld? Message us on WhatsApp with the project and tower. For the area, read our {S("blog/gomti-nagar-extension-lucknow-guide-2026", "Gomti Nagar Extension guide")}, and for the developer, our {CORP}.'))
b.append('{{CONSULTATION_BUTTON:Buy or Sell in Shalimar OneWorld — Talk to Us}}')

b.append('<section id="FAQs">\n' + H2('faq', '❓ Frequently Asked Questions'))
for q, a in FAQ:
    b.append(f'<h3 style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #008080;padding:14px 18px;border-radius:0 10px 10px 0;cursor:pointer;color:#011f4b;font-size:15px;font-weight:600;margin:14px 0 0;">{q}</h3>')
    b.append(f'<p style="display:none;background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 10px 10px;padding:14px 18px;font-size:14.5px;color:#374151;margin:0 0 10px;line-height:1.85;">{a}</p>')
b.append('</section>')
b.append('<p style="font-size:13px;color:#6b7280;margin-top:30px;padding:14px 18px;background:#f8f8f8;border-left:3px solid #ccc;border-radius:4px;"><strong>Disclaimer:</strong> DSD Properties is an independent property advisory, not the developer. Prices, sizes and possession dates are from Shalimar\'s price sheet with BSP applicable from 1 August 2026; RERA details are from the certificates on the official OneWorld website as of 19 October 2026. Prices and availability change — confirm the latest cost sheet and the live RERA record before you pay.</p>')
html = '\n'.join(b)

schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [
 {"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": a}} for q, a in FAQ]}
row = {
 "title": "Shalimar OneWorld Lucknow 2026: All Projects, Prices, Sizes, Possession & RERA",
 "slug": "shalimar-oneworld-lucknow-projects-price-possession-2026",
 "meta_description": "Shalimar OneWorld, Gomti Nagar Extension: all 10 projects with BSP from ₹9,000/sq ft, SBUA, carpet area, possession dates and official RERA numbers.",
 "meta_keywords": "shalimar oneworld, shalimar one world lucknow, shalimar oneworld price, shalimar pinnacle, shalimar marbella, shalimar twenty one, valencia towers, valencia county east, whispering woods, belvedere suites, shalimar business district",
 "tag": "Buying Tips",
 "blog_summary": "Complete guide to Shalimar OneWorld, Gomti Nagar Extension: every project on the price sheet (BSP from 1 Aug 2026) with super built-up and carpet areas, unit types, basic cost and possession, plus official RERA numbers, end dates and promoters, completed phases and a buyer checklist.",
 "alt": "Shalimar OneWorld Lucknow projects price and possession 2026",
 "language": "en", "status": "draft", "author_id": 9,
 "featured_image": "https://dsdproperties.in/public/images/blogs/shalimar_oneworld_lucknow_2026.webp",
 "content_html": html,
 "seo_schema": json.dumps(schema, ensure_ascii=False, indent=2)}
assert len(row['meta_description']) <= 160, len(row['meta_description'])
json.dump(row, open('row.json', 'w', encoding='utf8'), ensure_ascii=False, indent=1)
# sanity: totals
for name, sid, typ, poss, rera, rend, prom, cert, rows in PROJ:
    print(name, [(r[0], r[1], r[3], inr(r[1]*r[3]) if r[1] else '-') for r in rows])
print('ok', len(html), len(row['meta_description']))
