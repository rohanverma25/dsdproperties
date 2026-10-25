# Builds a new EN blog post: every ongoing Shalimar Corp project (residential + commercial) on one interactive map.
# Facts come only from shalimarcorp.com project pages (fetched 22 Oct 2026), its RERA page, and shalimar-oneworld.com.
# Coordinates come from the Google Maps embeds on each official project page. Sky Garden's embed is a wide-area map, so its pin is approximate.
import json, math, html

WA = 'https://wa.me/918595002933?text='
def wa(msg):
    from urllib.parse import quote
    return WA + quote(msg)
def gmap(lat, lng): return f'https://www.google.com/maps/search/?api=1&query={lat},{lng}'
SITE = 'https://dsdproperties.in/'
def L(path, text): return f'<a href="{SITE}{path}" style="color:#008080;font-weight:600;">{text}</a>'
def X(url, text): return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'

SC = 'https://www.shalimarcorp.com/'
P = [  # key, name, group, area, lat, lng, approx, type, config, scale, rera, url, highlights, amenities, note
 dict(k='oneworld', name='Shalimar OneWorld (township)', grp='city', area='Gomti Nagar Extension, Lucknow', lat=26.82282, lng=81.01911, approx=False,
      typ='Integrated township', cfg='Apartments, villas, offices (10 projects on sale)', scale='225-acre township (as Shalimar lists it)', rera='Phase-wise (see our OneWorld guide)',
      url='https://www.shalimar-oneworld.com/',
      hi=['Shalimar\'s flagship township off Amar Shaheed Path, Gomti Nagar Extension', 'Projects on sale include Pinnacle, Marbella, Twenty One, Valencia Towers, Valencia County East villas and Whispering Woods', 'Each phase has its own RERA number and possession date'],
      am=['Apartments', 'Villas', 'Office tower', 'Several RERA phases'],
      note='Shalimar publishes the acreage inconsistently (200, 212 and 225 acres appear in different places). Check the RERA record of the exact phase you buy in.'),
 dict(k='sbd', name='Shalimar Business District (SBD), Tower 1', grp='commercial', area='Gomti Nagar Extension (inside OneWorld)', lat=26.82282, lng=81.01911, approx=False,
      typ='Office tower', cfg='Office spaces (the Shalimar listing card also shows "3, 4 and Prime 4 BHK Residences")', scale='Tower 1', rera='UPRERAPRJ143786/01/2024',
      url='https://www.shalimar-oneworld.com/shalimar-business-district/',
      hi=['Office tower inside Shalimar OneWorld', 'RERA validity to 15 Dec 2027 (per the certificate on shalimar-oneworld.com)'],
      am=['Business-district location', 'Inside OneWorld township'],
      note='The Shalimar commercial listing card repeats a residential line ("3, 4 and Prime 4 BHK") under SBD. Ask the sales team for the unit sizes in writing.'),
 dict(k='skygarden', name='Shalimar Sky Garden', grp='city', area='Vibhuti Khand / near Polytechnic, Ayodhya Road, Lucknow', lat=26.87273, lng=81.00005, approx=True,
      typ='Luxury high-rise apartments', cfg='3 BHK + Servant, 4 BHK + Servant, 4 BHK Prime', scale='2 towers of 22 floors', rera='UPRERAPRJ160941',
      url=SC+'sky-garden',
      hi=['Shalimar calls it the "tallest landmark within 5 km radius"', 'Podium and bridge-level plans', 'Has its own retail street (listed separately below)'],
      am=['Swimming pool & kids pool', 'Waterbody with infinity edge', 'Gym / aerobics, steam & sauna', 'Banquet / party hall', 'Automatic cricket practice nets', 'Green decks & walking track'],
      note='On the UP RERA record this project is filed under the commercial category, and the promoter was formerly Supreme Realestate Developers. Check the RERA completion date and the builder-buyer agreement.'),
 dict(k='skyretail', name='Shalimar Sky Garden Retail Street', grp='commercial', area='Near Polytechnic, Ayodhya Road, Lucknow', lat=26.87273, lng=81.00005, approx=True,
      typ='Retail shops', cfg='Retail shops on 2 levels', scale='2 levels', rera='UPRERAPRJ160941 (shared with Sky Garden)',
      url=SC+'sky-garden-retail-street',
      hi=['Two levels of retail at the base of Sky Garden', 'Positioned for shopping, dining and leisure'],
      am=['Ground + first-floor retail', 'Residents of 2 towers above'],
      note='The retail units share one RERA number with the apartments. Ask which floor and frontage your shop has, and whether there is a lock-in or assured-rent clause.'),
 dict(k='gallant', name='Shalimar Gallant West', grp='city', area='Mahanagar, Lucknow', lat=26.88400, lng=80.95319, approx=False,
      typ='Ultra-luxury apartments', cfg='4 BHK only', scale='2 towers, "only 71 exclusive families"', rera='UPRERAPRJ569037',
      url=SC+'gallant-west',
      hi=['4 BHK-only residences in Mahanagar', 'Very low density: 71 homes in 2 towers', '26+ lifestyle features'],
      am=['All-weather infinity pool', 'Bar & barbeque area', 'Cricket practice net', 'Event lawn & party hall', 'Steam & wellness zone', 'Kids pool & play area'],
      note='The RERA record we checked on 18 Oct shows 69 flats and a completion date of 20 Oct 2026. Ask whether an extension has been filed, and get the current possession date in writing.'),
 dict(k='gbcrown', name='Shalimar Garden Bay Crown', grp='city', area='IIM Road, Lucknow (inside Shalimar Garden Bay)', lat=26.92403, lng=80.88425, approx=False,
      typ='Apartments', cfg='2 BHK, 2 BHK + Study, 3 BHK', scale='220 units, 3 towers', rera='UPRERAPRJ557069',
      url=SC+'garden-bay-crown',
      hi=['At the entrance of the 72-acre Shalimar Garden Bay township', 'Offers 2 BHK and 2 BHK + Study homes as well as 3 BHK', 'IIM Road side of the city'],
      am=['Swimming pool with water beds', 'Gymnasium', 'Badminton court', 'Multi-use games court', 'Party hall', 'Green lawns & walking track'],
      note='Garden Bay also has older RERA registrations: villas/plots UPRERAPRJ9256 and group housing UPRERAPRJ9203. Make sure your allotment letter names Crown (UPRERAPRJ557069).'),
 dict(k='evaraheights', name='Shalimar Evara Heights', grp='ayodhya', area='Lucknow–Ayodhya Road', lat=26.90077, lng=81.10460, approx=True,
      typ='Low-rise apartments', cfg='2 & 3 BHK', scale='Part of a 14.23-acre gated township ("Club Evara")', rera='UPRERAPRJ908475/05/2026',
      url=SC+'evara-heights',
      hi=['Newest RERA registration in the list (May 2026)', 'Low-rise elevation, large landscaped greens', 'Walkthrough video and VR tour on the official page'],
      am=['Club Evara: club house & pool', 'Gym & indoor games', 'Senior citizen court', 'Yoga & picnic lawns', 'Dog park', 'Reflexology path'],
      note='The Evara Heights page has no map pin of its own. We placed it at the Evara pin because both pages describe the same 14.23-acre township. Confirm the exact plot location at the site office.'),
 dict(k='evara', name='Shalimar Evara', grp='ayodhya', area='Lucknow–Ayodhya Road', lat=26.90077, lng=81.10460, approx=False,
      typ='See note: plots or apartments', cfg='Listing: "14.23 acres villa plots"; project page: 2 & 3 BHK apartments', scale='Project page: 4 towers up to G+6', rera='UPRERAPRJ742268/11/2025',
      url=SC+'evara',
      hi=['Phase registered in November 2025', '12+ lifestyle features', 'Next to Mannat on the same stretch of Ayodhya Road'],
      am=['Banquet hall', 'Gymnasium', 'Pickle ball', 'Parks & jogging track', 'Dog park', 'Kids play area'],
      note='Shalimar\'s own website describes Evara two ways: villa plots on the listing page, and 2 & 3 BHK apartments in 4 towers on the project page. The RERA certificate settles which one your registration covers. Read it before you pay a booking amount.'),
 dict(k='mannat', name='Shalimar Mannat Extension 3', grp='ayodhya', area='Ayodhya Road, Barabanki', lat=26.90174, lng=81.09962, approx=False,
      typ='Apartments', cfg='2 BHK, 2 BHK + Study, 3 BHK', scale='200 units, 12 towers (Towers M & N in the RERA certificate title)', rera='UPRERAPRJ555231',
      url=SC+'mannat-extension-3',
      hi=['Third phase of the Mannat township (27.21 acres)', 'Shalimar pitches it at "most competitive prices"', 'Earlier phases: Mannat UPRERAPRJ8345 and Mannat Extension UPRERAPRJ243983'],
      am=['Community centre', 'Landscaped green lawns', '18+ lifestyle features'],
      note='This project is in Barabanki district, not Lucknow. The registry happens at the Barabanki sub-registrar, and local rules and circle rates differ. Count the commute to your workplace before you book.'),
 dict(k='courtyard', name='Shalimar Courtyard', grp='varanasi', area='Lahartara Road, Varanasi', lat=25.32243, lng=82.98464, approx=False,
      typ='Luxury apartments', cfg='3 BHK + SQ + Terrace, 4 BHK + SQ', scale='3.75 acres, 6 towers, 244 units', rera='UPRERAPRJ582759/03/2026',
      url=SC+'courtyard-varanasi',
      hi=['Shalimar\'s first project in Varanasi, registered March 2026', 'Mediterranean-classical design around a central courtyard', '20+ lifestyle leisures'],
      am=['"The Granada" pool with deck', 'Double-height café', 'Pickleball & half basketball', 'Snooker & TT room', 'Yoga lawn & pet park', 'Twin multipurpose halls'],
      note='Varanasi project; Lucknow buyers investing remotely should check the RERA quarterly progress before each instalment.'),
]
GRP = {'city': ('Lucknow city', '#008080'), 'ayodhya': ('Ayodhya Road', '#FF5C00'), 'commercial': ('Commercial', '#7c3aed'), 'varanasi': ('Varanasi', '#011f4b')}

def km(a, b, c, d):
    R = 6371; p1, p2 = math.radians(a), math.radians(c); dp = math.radians(c - a); dl = math.radians(d - b)
    return 2 * R * math.asin(math.sqrt(math.sin(dp/2)**2 + math.cos(p1)*math.cos(p2)*math.sin(dl/2)**2))
LM = [('Hazratganj', 26.8500, 80.9462), ('Charbagh station', 26.8317, 80.9196), ('Lucknow airport', 26.7606, 80.8893)]

H2 = lambda t, i: f'<h2 id="{i}" style="font-size:23px;font-weight:800;color:#011f4b;margin:38px 0 12px;border-left:5px solid #FF5C00;padding-left:14px;">{t}</h2>'
Pp = lambda t: f'<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 16px;">{t}</p>'

STYLE = '''<style>
.scp-wrap{--t:#008080;--n:#011f4b;--o:#FF5C00}
.scp-chips{display:flex;flex-wrap:wrap;gap:8px;margin:0 0 10px}
.scp-chip{border:1.5px solid #cbd5e1;background:#fff;color:#334155;border-radius:999px;padding:7px 14px;font-size:13.5px;font-weight:700;cursor:pointer}
.scp-chip.on{background:var(--n);border-color:var(--n);color:#fff}
#scp-map{height:460px;border-radius:14px;border:1px solid #e2e8f0;background:#eef2f7;overflow:hidden}
.scp-legend{display:flex;flex-wrap:wrap;gap:14px;font-size:13px;color:#475569;margin:8px 0 0}
.scp-legend i{display:inline-block;width:11px;height:11px;border-radius:50%;margin-right:6px;vertical-align:-1px}
.scp-pop b{color:#011f4b;font-size:14.5px}.scp-pop{font-size:13px;line-height:1.55;color:#374151;min-width:210px}
.scp-pop a{color:#008080;font-weight:700}
.scp-tbl{width:100%;border-collapse:collapse;min-width:720px}
.scp-tbl th{background:#011f4b;color:#fff;text-align:left;padding:10px;font-size:13.5px}
.scp-tbl td{padding:10px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#374151;vertical-align:top}
.scp-tbl tr:nth-child(even) td{background:#f8fafc}
.scp-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:20px;margin:10px 0 26px}
.scp-card{border:1px solid #e5e9f0;border-radius:18px;overflow:hidden;background:#fff;display:flex;flex-direction:column;box-shadow:0 10px 30px rgba(1,31,75,.08);transition:transform .2s,box-shadow .2s}
.scp-card:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(1,31,75,.14)}
.scp-card__top{position:relative;padding:18px 18px 16px;background:linear-gradient(135deg,var(--c) 0%,#011f4b 115%);color:#fff}
.scp-card__top::after{content:"";position:absolute;right:-30px;top:-30px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.08)}
.scp-tag{display:inline-block;font-size:10.5px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;background:rgba(255,255,255,.18);border-radius:999px;padding:4px 10px;margin-bottom:10px}
.scp-card h3{margin:0 0 6px;font-size:19px;color:#fff;font-weight:800;line-height:1.25;position:relative;z-index:1}
.scp-loc{font-size:13px;color:rgba(255,255,255,.85);margin:0;line-height:1.5}
.scp-card .scp-card__top .scp-tag,.scp-card .scp-card__top h3{color:#fff!important}
.scp-card .scp-card__top .scp-loc{color:rgba(255,255,255,.9)!important}
.scp-card .scp-card__top .scp-approx{color:#fff!important}
.scp-approx{display:inline-block;margin-left:4px;font-size:10.5px;font-weight:700;background:#FF5C00;color:#fff;border-radius:6px;padding:1px 6px;vertical-align:1px}
.scp-facts{display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid #eef2f6}
.scp-fact{padding:12px 16px;font-size:13px;color:#334155;line-height:1.45}
.scp-fact+.scp-fact{border-left:1px solid #eef2f6}
.scp-fact small{display:block;font-size:10.5px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:#94a3b8;margin-bottom:3px}
.scp-rera{display:flex;align-items:center;gap:10px;margin:12px 16px 4px;padding:9px 12px;border-radius:10px;background:#f0fdfa;border:1px dashed #00808055}
.scp-rera svg{flex:none}.scp-rera small{display:block;font-size:10.5px;font-weight:800;letter-spacing:.06em;color:#008080}
.scp-rera span{font-family:ui-monospace,Consolas,monospace;font-size:12.5px;color:#011f4b;overflow-wrap:break-word}
.scp-card ul{list-style:none;margin:10px 16px 6px;padding:0}
.scp-card li{position:relative;padding-left:24px;font-size:14px;line-height:1.55;color:#374151;margin:7px 0}
.scp-card li::before{content:"✓";position:absolute;left:0;top:1px;width:17px;height:17px;border-radius:50%;background:#effaf9;color:#008080;font-size:11px;font-weight:800;text-align:center;line-height:17px}
.scp-am{display:flex;flex-wrap:wrap;gap:6px;padding:4px 16px 12px}
.scp-am span{font-size:11.5px;background:#f1f5f9;color:#334155;border-radius:8px;padding:5px 9px;font-weight:600}
.scp-am .more{background:#011f4b;color:#fff}
.scp-note{margin:0 16px 14px;border-radius:10px;background:#fff7ed;border:1px solid #fed7aa}
.scp-note summary{cursor:pointer;list-style:none;padding:9px 12px;font-size:13px;font-weight:700;color:#9a3412}
.scp-note summary::-webkit-details-marker{display:none}
.scp-note summary::after{content:"+";float:right;font-weight:800}.scp-note[open] summary::after{content:"–"}
.scp-note p{margin:0;padding:0 12px 10px;font-size:13px;line-height:1.6;color:#7c2d12}
.scp-btns{margin-top:auto;display:grid;grid-template-columns:1fr 1.25fr;gap:8px;padding:4px 16px 16px}
.scp-btns a,.scp-btns button{display:flex;align-items:center;justify-content:center;gap:6px;white-space:nowrap;border-radius:11px;padding:11px 8px;font-size:13.5px;font-weight:700;text-decoration:none;cursor:pointer;font-family:inherit}
.scp-b1{border:1.5px solid #cbd5e1;background:#fff;color:#011f4b}.scp-b1:hover{border-color:#008080;color:#008080}
.scp-b2{background:#25D366;color:#fff;border:0}.scp-b2:hover{background:#1ebe5b}
.scp-gm{display:block;text-align:center;font-size:12px;color:#64748b;padding:0 16px 14px;margin-top:-6px}
.scp-gm a{color:#008080;font-weight:700}
.scp-fit{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:12px;margin:8px 0 22px}
.scp-fit div{border:1px solid #e2e8f0;border-radius:14px;padding:14px 16px;background:#fff}
.scp-fit p{margin:0;font-size:14px;line-height:1.65;color:#374151}.scp-fit b{display:block;color:#011f4b;margin-bottom:4px;font-size:15px}
@media(max-width:600px){#scp-map{height:380px}.scp-facts{grid-template-columns:1fr}}
</style>'''

def card(p):
    g, c = GRP[p['grp']]
    msg = f"Hi, I am interested in {p['name']} ({p['cfg']}), {p['area']}. Please share current price, availability and a site visit."
    am = p['am'][:4]; rest = p['am'][4:]
    shield = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#008080" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>'
    pin = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>'
    wai = '<svg width="16" height="16" viewBox="0 0 24 24" fill="#fff"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.3 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.4-.7-2.8-1.1-4.6-4-4.8-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2.1 1-2.4c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .6l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.3 2.4 1.5.3.1.5.1.7-.1l.9-1.1c.2-.3.4-.2.7-.1l2 1c.3.1.5.2.6.3.1.2.1.7-.1 1.3z"/></svg>'
    return (f'<div class="scp-card" id="p-{p["k"]}" style="--c:{c}"><div class="scp-card__top"><span class="scp-tag">{g} · {p["typ"]}</span>'
            f'<h3>{p["name"]}</h3><p class="scp-loc">📍 {p["area"]}{"<span class=scp-approx>approx. pin</span>" if p["approx"] else ""}</p></div>'
            f'<div class="scp-facts"><div class="scp-fact"><small>🏠 Homes / units</small>{p["cfg"]}</div><div class="scp-fact"><small>🏢 Scale</small>{p["scale"]}</div></div>'
            f'<div class="scp-rera">{shield}<div><small>UP RERA</small><span>{p["rera"]}</span></div></div>'
            '<ul>' + ''.join(f'<li>{h}</li>' for h in p['hi']) + '</ul>'
            '<div class="scp-am">' + ''.join(f'<span>{a}</span>' for a in am)
            + (f'<span class="more" title="{html.escape(", ".join(rest))}">+{len(rest)} more</span>' if rest else '') + '</div>'
            f'<details class="scp-note"><summary>⚠ Check before booking</summary><p>{p["note"]}</p></details>'
            f'<div class="scp-btns"><button type="button" class="scp-b1" onclick="window.scpFocus&&scpFocus(\'{p["k"]}\')">{pin}Show on map</button>'
            f'<a class="scp-b2" href="{wa(msg)}" target="_blank" rel="noopener">{wai}WhatsApp us</a></div>'
            f'<span class="scp-gm">or open in <a href="{gmap(p["lat"], p["lng"])}" target="_blank" rel="noopener">Google Maps ↗</a></span></div>')

pts = [dict(k=p['k'], n=p['name'], g=p['grp'], a=p['area'], la=p['lat'], ln=p['lng'], c=p['cfg'], r=p['rera'], ap=p['approx'], gm=gmap(p['lat'], p['lng'])) for p in P]
MAPJS = '''<script>
(function(){
var PTS=%s, COL=%s, wrap=document.getElementById('scp-map'); if(!wrap) return;
var byK={}, ready=null, pending=null, started=false;
window.scpFocus=function(k){ wrap.scrollIntoView({behavior:'smooth',block:'center'}); if(ready){ready(k);} else {pending=k; load();} };
function go(){
  var map=L.map('scp-map',{scrollWheelZoom:false});
  var osm=L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; OpenStreetMap'}).addTo(map);
  var sat=L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{maxZoom:19,attribution:'Esri World Imagery'});
  L.control.layers({'Street map':osm,'Satellite':sat}).addTo(map);
  var seen={}, mk=[];
  PTS.forEach(function(p){
    var key=p.la+','+p.ln, off=seen[key]||0; seen[key]=off+1;
    var ll=[p.la+off*0.0025,p.ln+off*0.0025];
    var m=L.circleMarker(ll,{radius:9,color:'#fff',weight:2,fillColor:COL[p.g],fillOpacity:.95}).addTo(map);
    m.bindPopup('<div class="scp-pop"><b>'+p.n+'</b><br>'+p.a+(p.ap?' <em>(approx.)</em>':'')+'<br>'+p.c+'<br>RERA: '+p.r+'<br><a href="#p-'+p.k+'">Project details</a> &middot; <a href="'+p.gm+'" target="_blank" rel="noopener">Google Maps</a></div>');
    m.bindTooltip(p.n,{direction:'top',offset:[0,-8]}); m.g=p.g; mk.push(m); byK[p.k]=m;
  });
  function show(g){
    var b=[]; mk.forEach(function(m){ var on=(g==='all'?m.g!=='varanasi':m.g===g); if(on){m.addTo(map);b.push(m.getLatLng());} else if(g!=='all'){map.removeLayer(m);} else {m.addTo(map);} });
    if(b.length===1) map.setView(b[0],14); else map.fitBounds(b,{padding:[40,40]});
  }
  document.querySelectorAll('.scp-chip').forEach(function(ch){ ch.addEventListener('click',function(){
    document.querySelectorAll('.scp-chip').forEach(function(x){x.classList.remove('on')}); ch.classList.add('on'); show(ch.getAttribute('data-g')); }); });
  show('all');
  ready=function(k){ var m=byK[k]; if(!m) return; document.querySelectorAll('.scp-chip').forEach(function(x){x.classList.toggle('on',x.getAttribute('data-g')===m.g)}); show(m.g); map.setView(m.getLatLng(),15); m.openPopup(); };
  if(pending) ready(pending);
}
function load(){
  if(started) return; started=true;
  var c=document.createElement('link'); c.rel='stylesheet'; c.href='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css'; document.head.appendChild(c);
  var s=document.createElement('script'); s.src='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js'; s.onload=go; document.head.appendChild(s);
}
if('IntersectionObserver' in window){ var io=new IntersectionObserver(function(e){ if(e[0].isIntersecting){io.disconnect();load();} },{rootMargin:'300px'}); io.observe(wrap); } else load();
})();
</script>''' % (json.dumps(pts, ensure_ascii=False), json.dumps({k: v[1] for k, v in GRP.items()}))

rows = ''.join(f'<tr><td><a href="#p-{p["k"]}" style="color:#011f4b;font-weight:700;">{p["name"]}</a></td><td>{p["area"]}</td><td>{p["cfg"]}</td><td>{p["scale"]}</td><td style="font-size:12.5px">{p["rera"]}</td></tr>' for p in P)
lk = [p for p in P if p['grp'] != 'varanasi' and p['k'] not in ('sbd', 'skyretail', 'evaraheights')]
drows = ''.join('<tr><td><strong>' + p['name'].replace(' (township)', '') + '</strong></td>' + ''.join(f'<td>{km(p["lat"], p["lng"], a, b):.1f} km</td>' for _, a, b in LM) + '</tr>' for p in lk)

FAQ = [
 ('How many ongoing projects does Shalimar Corp list?', 'As of 22 October 2026, shalimarcorp.com lists eight ongoing residential projects and two commercial ones. The residential projects are Shalimar OneWorld (a township with several phases), Evara Heights, Evara, Sky Garden, Gallant West, Garden Bay Crown, Mannat Extension 3 and Courtyard in Varanasi. The commercial projects are Shalimar Business District Tower 1 and Sky Garden Retail Street.'),
 ('Which Shalimar project has only 4 BHK homes?', 'Shalimar Gallant West in Mahanagar is a 4 BHK-only project with 2 towers. Shalimar says 71 families will live there, while the RERA record we checked shows 69 flats.'),
 ('Which Shalimar projects are on Ayodhya Road?', 'Evara, Evara Heights and Mannat Extension 3 are on the Lucknow–Ayodhya Road. Mannat Extension 3 is in Barabanki district. Sky Garden and its retail street are near Polytechnic, at the city end of Ayodhya Road.'),
 ('Does Shalimar publish prices on its website?', 'No. None of the ongoing project pages on shalimarcorp.com shows a price. For OneWorld, our separate guide lists projects, unit types and possession dates. Ask the developer for a dated price sheet, and compare it with the agreement before you pay.'),
 ('Is Shalimar Evara a plotted project or apartments?', 'Shalimar\'s website says both. The listing page calls Evara "14.23 acres villa plots", while the project page shows 2 & 3 BHK apartments in 4 towers of up to G+6. Read the RERA certificate for UPRERAPRJ742268/11/2025 to see what is registered.'),
 ('How do I check a Shalimar project\'s RERA status?', 'Search the RERA number on up-rera.in and read four things: the promoter name, the proposed completion date, any extension orders and the latest quarterly progress report. We also do this as part of our ₹5,000 property verification.'),
]
faq_html = ('<section id="FAQs">' + H2('❓ Frequently Asked Questions', 'faq') + ''.join(
 f'<h3 style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #008080;padding:14px 18px;border-radius:0 10px 10px 0;cursor:pointer;color:#011f4b;font-size:15px;font-weight:600;margin:14px 0 0;">{q}</h3>'
 f'<p style="display:none;background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 10px 10px;padding:14px 18px;font-size:14.5px;color:#374151;margin:0 0 10px;line-height:1.85;">{a}</p>' for q, a in FAQ) + '</section>')

body = (STYLE + '<div class="scp-wrap">'
 + '<p style="font-size:13px;color:#6b7280;margin:0 0 22px;padding-bottom:14px;border-bottom:1px solid #e2e8f0;">Sources: the project pages, RERA list and map pins on the ' + X(SC, 'official Shalimar Corp website') + ' and ' + X('https://www.shalimar-oneworld.com/', 'shalimar-oneworld.com') + ', reviewed on 22 October 2026. This is an independent guide by DSD Properties; we are not the developer. <strong>Updated: 22 October 2026.</strong></p>'
 + '<div style="background:#f0fdfa;border:1px solid #00808033;border-left:4px solid #008080;border-radius:0 12px 12px 0;padding:16px 20px;margin:0 0 24px;"><p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">Key Facts (22 October 2026)</p><ul style="margin:0;padding-left:20px;">'
 + ''.join(f'<li style="margin:5px 0;line-height:1.7;">{x}</li>' for x in [
   'Shalimar Corp lists <strong>8 ongoing residential</strong> and <strong>2 commercial</strong> projects on its website: 7 in the Lucknow area and 1 in Varanasi.',
   'They range from <strong>2 BHK homes on Ayodhya Road</strong> (Mannat Extension 3, Garden Bay Crown) to <strong>4 BHK-only residences in Mahanagar</strong> (Gallant West) and <strong>22-floor towers</strong> (Sky Garden).',
   'Every project page shows a <strong>UP RERA number</strong>. The newest is Evara Heights (UPRERAPRJ908475/05/2026).',
   '<strong>No prices</strong> are published on the project pages. Two projects need a closer look before booking: Evara, where Shalimar\'s own pages disagree on plots versus apartments, and Gallant West, whose RERA completion date is 20 Oct 2026.'])
 + '</ul></div>'
 + Pp('Shalimar is one of Lucknow\'s oldest developers, and its projects sit in very different parts of the city: Mahanagar, IIM Road, Gomti Nagar Extension, Ayodhya Road, and now Varanasi. The official website gives each project its own page, but you can\'t see them side by side or on one map. This guide does that. It puts every ongoing Shalimar project on one interactive map, compares them in one table, and lists the checks to make before you book. For the company\'s history and its full RERA record, see our ' + L('blog/shalimar-corp-lucknow-projects-rera-guide-2026', 'Shalimar Corp guide') + '. For OneWorld\'s individual towers and villas, see the ' + L('blog/shalimar-oneworld-lucknow-projects-price-possession-2026', 'Shalimar OneWorld guide') + '.')
 + H2('All Shalimar projects on one map', 'map')
 + Pp('Tap a pin to see the project, its homes and RERA number. Use the buttons to show one area at a time. You can switch to satellite view from the layer button at the top right.')
 + '<div class="scp-chips">' + '<button class="scp-chip on" data-g="all">All Lucknow area</button>' + ''.join(f'<button class="scp-chip" data-g="{k}">{v[0]}</button>' for k, v in GRP.items()) + '</div>'
 + '<!-- shalimar-projects-map --><div id="scp-map" role="region" aria-label="Map of Shalimar Corp projects"></div>'
 + '<div class="scp-legend">' + ''.join(f'<span><i style="background:{v[1]}"></i>{v[0]}</span>' for v in GRP.values()) + '</div>'
 + '<p style="font-size:12.5px;color:#6b7280;margin:8px 0 0;">Pins are taken from the Google Maps embeds on Shalimar\'s official project pages. Two pins are approximate: Sky Garden, whose official embed is a wide-area map, and Evara Heights, which has no pin of its own. Projects at the same address are shown slightly apart so you can tap each one.</p>'
 + MAPJS
 + H2('Shalimar ongoing projects at a glance', 'compare')
 + '<div style="overflow-x:auto;margin:0 0 10px;-webkit-overflow-scrolling:touch;"><table class="scp-tbl"><thead><tr><th>Project</th><th>Location</th><th>Homes / units</th><th>Scale</th><th>UP RERA</th></tr></thead><tbody>' + rows + '</tbody></table></div>'
 + '<p style="font-size:12.5px;color:#6b7280;margin:0 0 18px;">Details exactly as published on each official project page (22 Oct 2026). Swipe the table sideways on a phone.</p>'
 + H2('How far is each project from the city?', 'distance')
 + Pp('These are straight-line distances, measured "as the crow flies". The road distance is usually 20–40% more.')
 + '<div style="overflow-x:auto;margin:0 0 20px;"><table class="scp-tbl" style="min-width:520px"><thead><tr><th>Project</th>' + ''.join(f'<th>{n}</th>' for n, _, _ in LM) + '</tr></thead><tbody>' + drows + '</tbody></table></div>'
 + H2('Every project in detail', 'projects')
 + '<div class="scp-cards">' + ''.join(card(p) for p in P) + '</div>'
 + H2('Which Shalimar project suits whom?', 'fit')
 + '<div class="scp-fit">' + ''.join(f'<div><b>{t}</b><p>{d}</p></div>' for t, d in [
   ('Large family, central address', '<a href="#p-gallant" style="color:#008080;font-weight:700;">Gallant West</a> (4 BHK only, Mahanagar) or <a href="#p-skygarden" style="color:#008080;font-weight:700;">Sky Garden</a> (3/4 BHK + servant, 22 floors).'),
   ('Township with everything inside', '<a href="#p-oneworld" style="color:#008080;font-weight:700;">Shalimar OneWorld</a>, Gomti Nagar Extension: apartments, villas and an office tower in one township.'),
   ('First home or 2 BHK budget', '<a href="#p-gbcrown" style="color:#008080;font-weight:700;">Garden Bay Crown</a> (IIM Road) or <a href="#p-mannat" style="color:#008080;font-weight:700;">Mannat Extension 3</a> (Ayodhya Road, Barabanki).'),
   ('New launch, low-rise greens', '<a href="#p-evaraheights" style="color:#008080;font-weight:700;">Evara Heights</a> and <a href="#p-evara" style="color:#008080;font-weight:700;">Evara</a> on Ayodhya Road, in a 14.23-acre gated township.'),
   ('Shop or office investment', '<a href="#p-skyretail" style="color:#008080;font-weight:700;">Sky Garden Retail Street</a> (2 retail levels) or <a href="#p-sbd" style="color:#008080;font-weight:700;">SBD Tower 1</a> in OneWorld.'),
   ('Investing outside Lucknow', '<a href="#p-courtyard" style="color:#008080;font-weight:700;">Shalimar Courtyard</a>, Lahartara Road, Varanasi: 3/4 BHK + SQ, 244 units.')]) + '</div>'
 + H2('What the official website doesn\'t tell you', 'gaps')
 + '<ol style="margin:0 0 18px;padding-left:22px;">' + ''.join(f'<li style="margin:8px 0;line-height:1.75;color:#374151;">{x}</li>' for x in [
   '<strong>Prices.</strong> No ongoing project page shows a price. Ask for a dated price sheet that lists BSP, PLC, parking, club and maintenance separately.',
   '<strong>Evara: plots or flats?</strong> The listing page says "14.23 acres villa plots". The project page says 2 & 3 BHK apartments in 4 towers of up to G+6. Settle this from the RERA certificate.',
   '<strong>Gallant West dates.</strong> The RERA record showed completion due 20 Oct 2026 and 69 flats. Shalimar\'s page says 71 families. Ask for the extension order, if any.',
   '<strong>Barabanki vs Lucknow.</strong> Mannat Extension 3 is in Barabanki district, so the registry office, circle rate and civic body all differ from Lucknow.',
   '<strong>Shared registrations.</strong> Sky Garden\'s apartments and retail street share one RERA number (UPRERAPRJ160941), filed under the commercial category.'])
 + '</ol>'
 + H2('Before you book any Shalimar home', 'checklist')
 + '<ol style="margin:0 0 18px;padding-left:22px;">' + ''.join(f'<li style="margin:8px 0;line-height:1.75;color:#374151;">{x}</li>' for x in [
   'Search the project\'s RERA number on ' + X('https://www.up-rera.in/', 'up-rera.in') + ' and note the promoter, the completion date and the latest quarterly report.',
   'Match the tower, floor and unit in your allotment letter to the RERA-registered plan.',
   'Take the builder-buyer agreement home before you pay more than 10%, and read the possession and delay-penalty clauses.',
   'For ready or resale homes, ask for the completion or occupancy certificate and an ' + L('blog/encumbrance-certificate-lucknow-how-to-apply-online', 'encumbrance certificate') + '.',
   'For plots, check the approved layout and khasra: ' + L('blog/how-to-check-lda-approved-map-lucknow-2026', 'how to check an approved map') + '.'])
 + '</ol>'
 + '<div style="background:#fff7ed;border:1px solid #FF5C0033;border-left:4px solid #FF5C00;border-radius:0 12px 12px 0;padding:16px 20px;margin:18px 0 22px;"><p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">Want an independent check before you pay?</p><p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">We check the RERA record, promoter, completion status, title and encumbrance. <strong>₹5,000 for residential flats and plots, with a PDF report in 48 hours.</strong> ' + L('services/property-verification-lucknow', 'See what we check →') + '</p><p style="margin:0;">{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}</p></div>'
 + Pp('Buying or selling in a Shalimar project? We can help with resale pricing, a site visit, or a second opinion on the agreement.')
 + '{{CONSULTATION_BUTTON:Buy or Sell in a Shalimar Project — Talk to Us}}'
 + faq_html
 + '<p style="font-size:13px;color:#6b7280;margin:26px 0 0;padding-top:12px;border-top:1px solid #e2e8f0;">Sources: ' + ', '.join([X(SC + 'residential-ongoing-projects.php', 'Shalimar Corp, residential ongoing projects'), X(SC + 'commercial-ongoing-projects.php', 'commercial ongoing projects'), X(SC + 'rera-projects.php', 'RERA projects list'), X('https://www.shalimar-oneworld.com/', 'Shalimar OneWorld'), 'individual project pages on shalimarcorp.com (all reviewed 22 Oct 2026)']) + '. Project details can change, so always confirm with the developer and on up-rera.in.</p>'
 + '</div>')

schema = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": a}} for q, a in FAQ]}
row = dict(
 title='Shalimar Corp Ongoing Projects 2026: All 10 Projects on One Map — Locations, Homes & RERA',
 slug='shalimar-corp-ongoing-projects-lucknow-map-2026',
 meta_description='Every ongoing Shalimar Corp project on one interactive map: OneWorld, Sky Garden, Gallant West, Garden Bay Crown, Evara, Evara Heights, Mannat Ext 3, Courtyard Varanasi, SBD and Retail Street, with RERA numbers.',
 meta_keywords='shalimar corp projects, shalimar ongoing projects lucknow, shalimar sky garden, shalimar gallant west, shalimar garden bay crown, shalimar evara, shalimar evara heights, shalimar mannat extension 3, shalimar courtyard varanasi, shalimar projects map',
 tag='Buying Tips',
 blog_summary='All 10 ongoing Shalimar Corp projects, both residential and commercial, on one interactive map. Includes a comparison table, distances from Hazratganj, Charbagh and the airport, detailed project cards with RERA numbers, and the checks the official website leaves out.',
 alt='Map of all ongoing Shalimar Corp projects in Lucknow and Varanasi 2026',
 language='en', status='draft', author_id=9,
 featured_image='https://dsdproperties.in/public/images/blogs/shalimar_projects_map_2026.webp',
 seo_schema=json.dumps(schema, ensure_ascii=False, indent=2),
 content_html=body)
json.dump(row, open('row.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
open('new.html', 'w', encoding='utf-8').write(body)
print('ok', len(body), 'bytes;', len(P), 'projects')
for p in lk: print(p['name'], [f'{km(p["lat"], p["lng"], a, b):.1f}' for _, a, b in LM])
