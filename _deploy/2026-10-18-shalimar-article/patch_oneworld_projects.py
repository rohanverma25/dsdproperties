# Adds an interactive "Shalimar OneWorld — projects on sale" section to post 170 (from the developer's sheet the user shared, Aug 2026).
# Only: project name, property type, unit types, possession. Each card has an "Invest in <name>" WhatsApp button.
import json, re, sys, urllib.parse
cur = open('current.html', encoding='utf8', newline='').read()
if 'id="oneworld-projects"' in cur: sys.exit('ABORT: already added')

P = [  # name, type, unit types, possession (Mon YYYY), sort key
 ('Pinnacle', 'Apartments', ['4 BHK + S'], 'Dec 2028', 202812),
 ('Marbella', 'Apartments', ['2 BHK + Study', '3 BHK', '3 BHK + S'], 'Feb 2029', 202902),
 ('Twenty One', 'Apartments', ['3 BHK + S'], 'Feb 2029', 202902),
 ('Valencia Towers 2', 'Apartments', ['4 BHK + S'], 'Jul 2029', 202907),
 ('Valencia Tower', 'Apartments', ['4 BHK + S'], 'Oct 2028', 202810),
 ('Valencia County East', 'Villas', ['4 BHK + S'], 'Oct 2026', 202610),
 ('Valencia County East Phase 2', 'Villas', ['4 BHK + S'], 'Dec 2029', 202912),
 ('Whispering Woods', 'Apartments', ['3 BHK + S'], 'Sep 2026', 202609),
 ('Belvedere Suites', 'Apartments', ['4 BHK + S'], 'Sep 2026', 202609),
 ('Shalimar Business District (SBD)', 'Office Space', ['Office space'], 'Dec 2027', 202712),
]
ICON = {'Apartments': '🏢', 'Villas': '🏡', 'Office Space': '💼'}
COL = {'Apartments': '#008080', 'Villas': '#7c3aed', 'Office Space': '#b45309'}
def band(k): return 'soon' if k <= 202612 else ('mid' if k <= 202812 else 'late')
BADGE = {'soon': ('Possession due 2026', '#fef3c7', '#92400e'), 'mid': ('Possession 2027–28', '#e0f2fe', '#075985'), 'late': ('Possession 2029', '#ecfdf5', '#065f46')}

cards = []
for name, typ, units, poss, k in P:
    short = name.replace('Shalimar Business District (SBD)', 'SBD')
    msg = f"Hi, I want to invest in Shalimar OneWorld {name} ({', '.join(units)}, possession {poss}). Please share details."
    wa = 'https://wa.me/918595002933?text=' + urllib.parse.quote(msg)
    bl, bbg, bfg = BADGE[band(k)]
    chips = ''.join(f'<span style="display:inline-block;background:#f1f5f9;border:1px solid #e2e8f0;color:#011f4b;font-size:13px;font-weight:600;padding:4px 10px;border-radius:999px;margin:0 6px 6px 0;">{u}</span>' for u in units)
    cards.append(
     f'<div class="ow-card" data-type="{typ}" data-poss="{band(k)}" data-k="{k}" style="background:#fff;border:1px solid #e2e8f0;border-top:4px solid {COL[typ]};border-radius:14px;padding:16px 16px 14px;display:flex;flex-direction:column;box-shadow:0 2px 10px rgba(1,31,75,.05);">'
     f'<div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">'
     f'<div><div style="font-size:12px;font-weight:700;letter-spacing:.05em;color:{COL[typ]};text-transform:uppercase;">{ICON[typ]} {typ}</div>'
     f'<div style="font-size:18px;font-weight:800;color:#011f4b;line-height:1.25;margin-top:3px;">{name}</div></div></div>'
     f'<div style="margin:10px 0 6px;">{chips}</div>'
     f'<div style="display:flex;align-items:center;gap:8px;margin:2px 0 14px;font-size:14px;color:#374151;"><span>📅 Possession: <strong>{poss}</strong></span>'
     f'<span style="background:{bbg};color:{bfg};font-size:11.5px;font-weight:700;padding:3px 8px;border-radius:999px;white-space:nowrap;">{bl}</span></div>'
     f'<a href="{wa}" target="_blank" rel="noopener" style="margin-top:auto;display:block;text-align:center;background:#FF5C00;color:#fff;font-weight:700;font-size:15px;padding:11px 12px;border-radius:10px;text-decoration:none;">Invest in {short} →</a>'
     '</div>')

btn = lambda f, label, active=False: (f'<button type="button" class="ow-f" data-f="{f}" aria-pressed="{"true" if active else "false"}" '
      'style="border:1px solid #cbd5e1;background:#fff;color:#011f4b;font-weight:600;font-size:13.5px;padding:7px 14px;border-radius:999px;cursor:pointer;margin:0 6px 8px 0;">' + label + '</button>')
SECTION = f'''<!-- oneworld-projects -->
<h2 id="oneworld-projects" style="font-size:22px;font-weight:700;color:#011f4b;margin:36px 0 12px;border-left:5px solid #FF5C00;padding-left:14px;">Shalimar OneWorld — projects on sale now</h2>
<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 12px;">These are the OneWorld projects in Shalimar's current sales sheet (prices effective 1 August 2026), with the property type, unit types and the <strong>possession date the developer quotes</strong>. Tap a filter to narrow the list, and tap <strong>Invest</strong> to ask us on WhatsApp for current price, availability and a site visit.</p>
<div id="ow-wrap" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:16px;margin:10px 0 18px;">
 <div style="margin-bottom:4px;">
  {btn("all","All projects",True)}{btn("Apartments","🏢 Apartments")}{btn("Villas","🏡 Villas")}{btn("Office Space","💼 Office")}
 </div>
 <div style="margin-bottom:10px;">
  {btn("soon","Possession 2026")}{btn("mid","2027–28")}{btn("late","2029")}
 </div>
 <p id="ow-count" style="font-size:13px;color:#64748b;margin:0 0 12px;">Showing all {len(P)} projects, earliest possession first</p>
 <div id="ow-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:14px;">
{chr(10).join(cards)}
 </div>
 <p style="font-size:12.5px;color:#64748b;margin:14px 0 0;line-height:1.7;"><strong>+ S</strong> = an additional room as written in the developer's sheet; confirm its use and size in the floor plan. Possession dates are the developer's targets and can differ from the RERA completion date — for example, Whispering Woods' RERA completion date was 30 September 2026. Check the RERA record of your tower on up-rera.in before you pay.</p>
</div>
<script>
(function () {{
  var wrap = document.getElementById('ow-wrap'); if (!wrap) return;
  var grid = document.getElementById('ow-grid'), count = document.getElementById('ow-count');
  var cards = Array.prototype.slice.call(grid.querySelectorAll('.ow-card'));
  cards.sort(function (a, b) {{ return (+a.getAttribute('data-k')) - (+b.getAttribute('data-k')); }});
  cards.forEach(function (c) {{ grid.appendChild(c); }});
  var typeF = 'all', possF = 'all';
  var btns = Array.prototype.slice.call(wrap.querySelectorAll('.ow-f'));
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
    count.textContent = n ? ('Showing ' + n + ' of ' + cards.length + ' projects, earliest possession first') : 'No project matches these filters';
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
  paint();
}})();
</script>
'''
anchor = '<h2 id="projects"'
assert cur.count(anchor) == 1
new = cur.replace(anchor, SECTION + anchor)
open('new.html', 'w', encoding='utf8', newline='').write(new)
json.dump({"seo_schema": None}, open('newmeta.json', 'w'))
print('ok', len(cur), len(new))
