import json
S = json.load(open('fi_svg.json'))
px, py = S['pin']; jx, jy = S['jail']
html = f'''<!doctype html><html><head><meta charset="utf-8">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{{margin:0;padding:0;box-sizing:border-box}}
body{{width:1200px;height:630px;overflow:hidden;font-family:Outfit,sans-serif;background:#011f4b;color:#fff}}
.wrap{{position:relative;width:1200px;height:630px;background:
 radial-gradient(900px 500px at 85% 40%,rgba(0,128,128,.28),transparent 60%),
 linear-gradient(135deg,#011f4b 0%,#022c5e 55%,#013a4d 100%);}}
.grid{{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:40px 40px}}
.bar{{position:absolute;left:0;top:0;bottom:0;width:8px;background:linear-gradient(#ff6a00,#008080)}}
.left{{position:absolute;left:60px;top:52px;width:600px}}
.pill{{display:inline-block;background:#ff6a00;color:#fff;font-weight:700;font-size:15px;letter-spacing:.06em;padding:7px 16px;border-radius:999px}}
h1{{font-size:76px;line-height:.98;font-weight:800;margin-top:22px;letter-spacing:-.01em}}
h1 span{{color:#2dd4bf;display:block}}
.sub{{font-size:23px;color:#cbd5e1;margin-top:14px;font-weight:500}}
.rule{{width:380px;height:3px;background:#0f766e;margin:22px 0 22px}}
.stats{{display:flex;gap:12px}}
.st{{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:12px 14px;min-width:128px}}
.st b{{display:block;font-size:30px;font-weight:800;color:#5eead4;line-height:1.05}}
.st i{{font-style:normal;font-size:14px;color:#cbd5e1}}
.status{{margin-top:22px;display:flex;align-items:center;gap:10px;font-size:18px;color:#fde68a;font-weight:600}}
.dot{{width:12px;height:12px;border-radius:50%;background:#f59e0b;box-shadow:0 0 0 5px rgba(245,158,11,.22)}}
.site{{position:absolute;left:60px;bottom:30px;font-size:17px;color:#94a3b8;font-weight:500}}
.map{{position:absolute;right:46px;top:70px;width:470px;height:490px;border-radius:18px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.12);overflow:hidden}}
.map svg{{position:absolute;left:0;top:36px}}
.cap{{position:absolute;left:18px;top:14px;font-size:14px;color:#94a3b8;letter-spacing:.08em;font-weight:600}}
.key{{position:absolute;left:18px;bottom:16px;display:flex;gap:16px;font-size:13.5px;color:#cbd5e1}}
.key span{{display:flex;align-items:center;gap:7px}}
.key i{{width:16px;height:12px;border-radius:3px;display:inline-block}}
.lbl{{font-family:Outfit,sans-serif;font-weight:600}}
</style></head><body><div class="wrap"><div class="grid"></div><div class="bar"></div>
<div class="left">
 <span class="pill">UPAVP · LAND POOLING TOWNSHIP</span>
 <h1>Saumitra Vihar<span>Yojana</span></h1>
 <p class="sub">New Jail Road, Lucknow · 2026 Buyer Guide</p>
 <div class="rule"></div>
 <div class="stats">
  <div class="st"><b>560</b><i>Acres township</i></div>
  <div class="st"><b>2,092</b><i>Plots in Phase 1</i></div>
  <div class="st"><b>8</b><i>Sectors</i></div>
  <div class="st"><b>~₹4,000</b><i>Per sq ft (expected)</i></div>
 </div>
 <div class="status"><span class="dot"></span>RERA approval pending · Registration not open yet</div>
</div>
<div class="site">dsdproperties.in</div>
<div class="map"><div class="cap">LOCATION · NOT TO SCALE</div>
<svg width="{S['w']}" height="{S['h']}" viewBox="0 0 {S['w']} {S['h']}">
 <path d="{S['canal']}" fill="none" stroke="#38bdf8" stroke-width="13" stroke-linecap="round" opacity=".55"/>
 <path d="{S['road']}" fill="none" stroke="#f87171" stroke-width="7" stroke-linecap="round" opacity=".9"/>
 <path d="{S['outline']}" fill="rgba(255,122,26,.42)" stroke="#ff8a3d" stroke-width="3" stroke-dasharray="8 6" stroke-linejoin="round"/>
 <circle cx="{jx:.1f}" cy="{jy:.1f}" r="6" fill="#94a3b8"/>
 <text class="lbl" x="{jx-12:.1f}" y="{jy-14:.1f}" fill="#cbd5e1" font-size="15" text-anchor="end">Lucknow Jail</text>
 <g transform="translate({px:.1f},{py:.1f})"><path d="M0,0 C-12,-16 -14,-22 -14,-28 a14,14 0 1,1 28,0 c0,6 -2,12 -14,28z" fill="#ff6a00" stroke="#fff" stroke-width="2"/><circle cx="0" cy="-28" r="5" fill="#fff"/></g>
 <text class="lbl" transform="translate({S['rl'][0]:.1f},{S['rl'][1]+24:.1f}) rotate({S['rl'][2] if S['rl'][2]>-90 else S['rl'][2]+180:.1f})" fill="#fca5a5" font-size="16" text-anchor="middle">New Jail Road (NH-230)</text>
 <text class="lbl" transform="translate({S['cl'][0]+20:.1f},{S['cl'][1]:.1f}) rotate({S['cl'][2] if S['cl'][2]<90 else S['cl'][2]-180:.1f})" fill="#7dd3fc" font-size="16" text-anchor="middle">Sharda Canal</text>
 <text class="lbl" x="{S['cen'][0]-10:.1f}" y="{S['cen'][1]+60:.1f}" fill="#fff" font-size="18" text-anchor="middle">Saumitra Vihar</text>
</svg><div class="key"><span><i style="background:rgba(255,122,26,.6);border:2px dashed #ff8a3d"></i>Approx. scheme area</span><span><i style="background:#f87171"></i>New Jail Road</span><span><i style="background:#38bdf8"></i>Sharda Canal</span></div></div>
</div></body></html>'''
open('fi.html', 'w', encoding='utf8').write(html)
print('ok')
