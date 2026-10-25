# Removes BSP and basic cost from build.py everywhere (user request, 19 Oct 2026) and bakes in the 2-col/mobile CSS.
s = open('build.py', encoding='utf8').read()
def r(a, b, n=1):
    global s
    c = s.count(a)
    assert c == n, (c, a[:90])
    s = s.replace(a, b)

r("    minbsp = min(r[3] for r in rows)\n", "")
r("        tot = inr(sb * bsp) if sb else '—'\n", "")
r("""               f'<td style="padding:7px 8px;border-top:1px solid #eef2f7;">₹{bsp:,}</td>'\n""", "")
r("""               f'<td style="padding:7px 8px;border-top:1px solid #eef2f7;font-weight:700;color:#011f4b;">{tot}</td></tr>')""", "")
r("""f'<td style="padding:7px 8px;border-top:1px solid #eef2f7;">{num(ca) if ca else "—"}</td>'\n""",
  """f'<td style="padding:7px 8px;border-top:1px solid #eef2f7;">{num(ca) if ca else "—"}</td></tr>')\n""")
r(' data-bsp="{minbsp}"', '')
r("""<span>📅 Possession: <strong>{poss}</strong></span><span>💰 BSP from <strong>₹{minbsp:,}/sq ft</strong></span>""", """<span>📅 Possession: <strong>{poss}</strong></span>""")
r("""<th style="text-align:left;padding:4px 8px;">BSP</th><th style="text-align:left;padding:4px 8px;">Basic cost*</th>""", "")
r("""<option value="k">Earliest possession</option><option value="bsp">Lowest BSP per sq ft</option><option value="-bsp">Highest BSP per sq ft</option>""",
  """<option value="k">Earliest possession</option><option value="-k">Latest possession</option>""")
r("""<div id="ow-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:14px;">""",
  """<div id="ow-grid" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;">""")
r("""both in sq ft as given in the price sheet. BSP = basic sale price per sq ft of SBUA, applicable from 1 August 2026. <strong>*Basic cost = SBUA × BSP</strong> — it excludes preferential location charges, car parking, club and maintenance charges, GST, stamp duty and registration. <strong>+ S</strong>""",
  """both in sq ft as given in Shalimar's project sheet. <strong>+ S</strong>""")
CSS = ('<style id="ow-grid-css">\n'
 '#ow-grid{grid-template-columns:repeat(2,minmax(0,1fr))}\n'
 '#ow-grid .ow-card{min-width:0;max-width:100%;box-sizing:border-box}\n'
 '#ow-grid table{margin:0 !important;border:0 !important;box-shadow:none !important;min-width:0 !important;width:100% !important}\n'
 '#ow-grid table th{background:#f1f5f9 !important;color:#475569 !important;padding:6px 8px !important;font-size:11.5px !important;border:0 !important}\n'
 '#ow-grid table td{padding:7px 8px !important;font-size:13.5px !important;background:#fff !important;border:0 !important;border-top:1px solid #eef2f7 !important;white-space:nowrap}\n'
 '#ow-wrap{max-width:100%;box-sizing:border-box}\n'
 '@media (max-width:700px){#ow-wrap{padding:12px !important} #ow-grid{grid-template-columns:minmax(0,1fr) !important;gap:12px !important} #ow-grid .ow-card{padding:14px 12px !important} #ow-grid table th{padding:5px 6px !important;font-size:11px !important} #ow-grid table td{padding:6px 6px !important;font-size:13px !important}}\n'
 '</style>\n')
r("INTERACTIVE = f'''<div id=\"ow-wrap\"", "INTERACTIVE = CSS_BLOCK + f'''<div id=\"ow-wrap\"")
s = s.replace("btn = lambda f, label", "CSS_BLOCK = " + repr(CSS) + "\nbtn = lambda f, label", 1)

r("""num(ca) if ca else '—', u, poss if i == 0 else '', f'₹{bsp:,}', inr(sb * bsp) if sb else '—'])""", """num(ca) if ca else '—', u, poss if i == 0 else ''])""")
r("""b.append(H2('price-table', 'Complete price sheet (BSP from 1 August 2026)'))""", """b.append(H2('size-table', 'All unit options — sizes and possession'))""")
r("""'Possession', 'BSP (₹/sq ft)', 'Basic cost*'], full, minw=820))""", """'Possession'], full, minw=640))""")
r("""b.append(P_('<span style="font-size:13px;color:#64748b;">*Basic cost = SBUA × BSP. It is not the final price: preferential location charges, parking, club and maintenance charges, GST, stamp duty and registration are extra. Prices can change; ask for the latest sheet.</span>'))""",
  """b.append(P_('<span style="font-size:13px;color:#64748b;">For current prices and the full cost sheet, tap Invest on any project or message us on WhatsApp.</span>'))""")
r("""b.append(P_('The same data in one table — every row from Shalimar\\'s sheet.'))""", """b.append(P_('Every unit option from Shalimar\\'s project sheet in one table.'))""")
r("""('What is the price per sq ft in Shalimar OneWorld?', 'From 1 August 2026 the basic sale price (BSP) ranges from ₹9,000 per sq ft of super built-up area (Marbella 2 BHK + Study and 3 BHK) to ₹12,000 per sq ft (Pinnacle). Offices in Shalimar Business District are ₹11,000 per sq ft. Other charges, GST, stamp duty and registration are extra.'),""",
  """('What unit sizes are available in Shalimar OneWorld?', 'On Shalimar\\'s August 2026 project sheet, apartments range from 1,530 sq ft super built-up area (Marbella 2 BHK + Study, 964.67 sq ft carpet) to 5,340 sq ft (Belvedere Suites 4 BHK + S). Villas in Valencia County East are 6,530 sq ft, and in Phase 2 7,790 sq ft.'),""")
r("""('Which is the cheapest unit in Shalimar OneWorld?', 'On the 1 August 2026 sheet, the lowest basic cost is the Marbella 2 BHK + Study: 1,530 sq ft super built-up area at ₹9,000 per sq ft, a basic cost of about ₹1.38 crore before other charges.'),""",
  """('How do I get the current price of a Shalimar OneWorld project?', 'Prices change with each sheet. Tap Invest on any project in this guide or message DSD Properties on WhatsApp for the current price, availability and the full cost sheet, which should list every charge, GST, stamp duty and registration.'),""")
r("""'Shalimar\\'s price sheet effective 1 August 2026 lists""", """'Shalimar\\'s project sheet of August 2026 lists""")
r("""'<strong>BSP ₹9,000–₹12,000 per sq ft</strong> of super built-up area, applicable from 1 August 2026; the lowest basic cost is about ₹1.38 crore (Marbella 2 BHK + Study).',""",
  """'Units range from <strong>1,530 sq ft</strong> (Marbella 2 BHK + Study) to <strong>7,790 sq ft</strong> (Valencia County East Phase 2 villa) super built-up area.',""")
r("""on Shalimar\\'s current price sheet:""", """on Shalimar\\'s current project sheet:""")
r("""Sources: Shalimar OneWorld price sheet (BSP applicable from 1 August 2026);""", """Sources: Shalimar OneWorld project sheet (August 2026);""")
r("""'All Shalimar OneWorld projects on sale — prices, sizes and possession'""", """'All Shalimar OneWorld projects on sale — sizes and possession'""")
r("""Each card shows every unit option on the price sheet: super built-up area, carpet area, BSP and the basic cost. Tap <strong>Invest</strong> to ask us on WhatsApp for current availability, the full cost sheet and a site visit.""",
  """Each card shows every unit option on the project sheet with its super built-up and carpet area. Tap <strong>Invest</strong> to ask us on WhatsApp for the current price, availability and a site visit.""")
r("""b.append(P_('Prices are per sq ft of <strong>super built-up area (SBUA)</strong>,""", """b.append(P_('Developers usually quote prices per sq ft of <strong>super built-up area (SBUA)</strong>,""")
r("""'<strong>Get the full cost sheet</strong> — BSP plus every other charge, GST, stamp duty and registration, in writing.',""",
  """'<strong>Get the full cost sheet</strong> — base price plus every other charge, GST, stamp duty and registration, in writing.',""")
r("""'Possession (price sheet)'""", """'Possession (project sheet)'""")
r("""and the price sheet also shows September 2026 possession.""", """and Shalimar\\'s sheet also shows September 2026 possession.""")
r("""They are not on the current price sheet;""", """They are not on the current project sheet;""")
r("""'The price sheet writes units like""", """'The project sheet writes units like""")
r("""Prices, sizes and possession dates are from Shalimar\\'s price sheet with BSP applicable from 1 August 2026;""", """Sizes and possession dates are from Shalimar\\'s project sheet of August 2026;""")
r("""Prices and availability change — confirm the latest cost sheet""", """Availability changes — confirm the latest cost sheet""")
r(""""title": "Shalimar OneWorld Lucknow 2026: All Projects, Prices, Sizes, Possession & RERA",""", """"title": "Shalimar OneWorld Lucknow 2026: All Projects, Sizes, Possession & RERA",""")
r(""""meta_description": "Shalimar OneWorld, Gomti Nagar Extension: all 10 projects with BSP from ₹9,000/sq ft, SBUA, carpet area, possession dates and official RERA numbers.",""",
  """"meta_description": "Shalimar OneWorld, Gomti Nagar Extension: all 10 projects with unit sizes, carpet areas, possession dates, official RERA numbers and completed phases.",""")
r("""shalimar oneworld price, """, "")
r("""every project on the price sheet (BSP from 1 Aug 2026) with super built-up and carpet areas, unit types, basic cost and possession,""",
  """every project on Shalimar's August 2026 project sheet with super built-up and carpet areas, unit types and possession,""")
r(""""alt": "Shalimar OneWorld Lucknow projects price and possession 2026",""", """"alt": "Shalimar OneWorld Lucknow projects, sizes and possession 2026",""")
r("""shalimar_oneworld_lucknow_2026.webp""", """shalimar_oneworld_lucknow_2026_v2.webp""")
r("""    print(name, [(r[0], r[1], r[3], inr(r[1]*r[3]) if r[1] else '-') for r in rows])\n""", "")
open('build.py', 'w', encoding='utf8').write(s)
print('edited')
