# Applies DM Lucknow order 1952/मु0नि0लि0-स्टाम्प सूची/2026 dated 04.06.2026 (revised rates, in force from 04.06.2026)
# to the built SRO JSONs in resources/data/circle-rates/. Run it after any build_data.py; it is idempotent (sets values,
# and keeps the 01.08.2025 values once, under "before_2026_06").
# Source: RateList_234_04-06-2026.pdf (IGRSUP serves it as the BKT file). SROs whose JSON does not exist yet are skipped
# and reported, so their amendments get applied when those lists are built.
import json, os, re, sys

here = os.path.dirname(os.path.abspath(__file__))
DATA = os.path.join(here, '..', '..', '..', 'resources', 'data', 'circle-rates')
ORDER = {'no': '1952', 'date': '2026-06-04', 'text': 'DM Lucknow order 1952 dated 04.06.2026'}
AGRI = ('district_road', 'link_road', 'near_abadi', 'general')

def key(s):
    s = s.replace('़', '').replace('ँ', 'ं').replace('ॉं', 'ा').replace('ॉ', 'ा').replace('ठ्ठ', 'ट्ठ').replace('ठठ्ठ', 'ट्ठ')
    s = s.replace('ै', 'ौ') if False else s
    return re.sub(r'[\s\.\(\)]', '', s)

def load(slug):
    p = os.path.join(DATA, 'lucknow-%s.json' % slug)
    return (p, json.load(open(p, encoding='utf-8'))) if os.path.exists(p) else (p, None)

def remember(r, field):
    r.setdefault('before_2026_06', {})
    if field not in r['before_2026_06']: r['before_2026_06'][field] = json.loads(json.dumps(r.get(field)))
    r['amended'] = ORDER['date']

def lines(f):
    return [l.rstrip('\n').split('|') for l in open(os.path.join(here, f), encoding='utf-8') if l.strip() and not l.startswith('#')]

def apply_agri(d, f, alias):
    idx = {}
    for r in d['rows']: idx.setdefault(key(r['hi']), []).append(r)
    n = 0
    for p in lines(f):
        if p[0] == 'FORM3':
            road, vill, val = p[1], p[2], int(p[3])
            hits = [x for r in d['rows'] for x in r['roads'] if key(x['listed_for']) == key(alias.get(vill, vill)) and key(x['segment']) == key(alias.get(road, road))]
            if not hits and vill.startswith('उक्त रोड'):    # road with one rate for every mohalla on it
                hits = [x for x in d.get('general_roads', []) if key(x['segment']) == key(alias.get(road, road))]
            if not hits: sys.exit('Form 3 row not found: %s / %s' % (road, vill))
            for x in hits:
                x.setdefault('agri_before_2026_06', x['agri']); x['agri'] = val; x['amended'] = ORDER['date']
            n += 1; continue
        name = alias.get(p[0], p[0])
        rs = [r for r in idx.get(key(name), []) if '(' not in r['en']] or idx.get(key(name), [])
        if len(rs) != 1: sys.exit('village not matched once in %s: %s -> %s' % (f, p[0], [r['hi'] for r in rs]))
        remember(rs[0], 'agri'); rs[0]['agri'] = dict(zip(AGRI, map(int, p[1:5]))); n += 1
    return n

ALIAS_MLG = {'अकबरपुरबेनीगंज': 'अकबरपुर बेनीगंज', 'अनैयाखरगापुर': 'अनैया खरगापुर', 'अमवामुर्तजापुर': 'अमवा मुर्तजापुर',
    'अमिलिहाखेडा': 'अमिलिहा खेडा', 'अचलीखेडा': 'अचली खेड़ा', 'आदमपुरनौबस्ता': 'आदमपुर नौबस्ता', 'उतरावां': 'उतरावॉ',
    'कटरानगराम': 'कटरा नगराम', 'कपेरामदारपुर': 'कपेरा मदार पुर', 'करसण्डा': 'करसन्डा', 'काजीखेडा': 'काजी खेड़ा',
    'कोडरारायपुर': 'कोड़रा रायपुर', 'खवासखेडा': 'खवास खेड़ा', 'खुजैहटा': 'खुजेहटा', 'गोमीखेडा': 'गोमी खेड़ा',
    'गौतमखेडा': 'गौतम खेडा', 'चमरतलिया': 'चमर तलिया', 'चैगानपुर': 'चौगानपुर', 'जमालपुरददुरी': 'जमालपुर ददुरी',
    'जहांगीरपुर': 'जहॉंगीर पुर', 'टिकराजुगराज': 'टिकरा जुगराज', 'डांडासिकन्दरपुर': 'डांडा सिकन्दर पुर',
    'डेवरियाभरसवां': 'डेवरिया भरसवा', 'दाउदपुरसौदापुर': 'दाउद पुर सौदापुर', 'दूल्हापुर हुसैनाबाद': 'दुल्हापुर हुसौनाबाद',
    'देहरामऊ': 'देहरा मऊ', 'देवेती': 'देवती', 'धरमंगतखेडा': 'धरमंगदत खेडा', 'धरमावतखेडा': 'धरमावत खेड़ा',
    'परसपुरठठ्ठा': 'परसपुर ठट्ठा', 'बखारी': 'बरवारी', 'बघौली': 'बधौली', 'बरुवा': 'बरूआ', 'बलसिंहखेडा': 'बलसिंह खेडा',
    'ब्रहमदासपुर': 'ब्रह्मदासपुर', 'भदेसुवा': 'भदेसवा', 'भौराकलां': 'भोराकला', 'मदारीखेडा': 'मदारीखेडा',
    'मलूकपुरढकवा': 'मलूकपुर ढकवा', 'मितौलीआदमपुर': 'मितौली आदमपुर', 'मेहदौली': 'मेंहदौली', 'मेहिउददीनपुर': 'मोहिउददीनपुर',
    'मोहम्मदपुरगढी': 'मोहम्मद पुर गढी', 'रसूलपुर आशिकअली': 'रसूलपुर आशिक अली', 'रसूलपुर टिकनियामऊ': 'रसूलपुर टिकनिया मऊ',
    'रामपुरगढीजमुनी': 'रामपुर गढी जमुनी', 'रावभानखेडा': 'रामभानखेडा', 'शिवढरा': 'शिवढ़रा', 'शेरपुरलवल': 'शेरपुर लवल',
    'सरईगुदौली': 'सरई गुदौली', 'सेल्हूमऊ': 'सेल्हू मऊ', 'हरिनामखेडा': 'हरिनाम खेडा', 'हरिहरपुरपटसा': 'हरिहरपुर पटसा',
    'गढी मुस्तफाबाद': 'गढ़ी मुस्तफाबाद', 'गढा': 'गढ़ा', 'गढी': 'गढ़ी', 'कुढा': 'कुढ़ा', 'घोडसारा': 'घोड़सारा'}

report = []
# Mohanlalganj: Form 4 agri for 161 villages + Form 3 Pahasa on the Purvanchal Expressway
p, d = load('mohanlalganj')
if d:
    n = apply_agri(d, 'mlg_agri.txt', ALIAS_MLG)
    n += apply_agri(d, 'mlg_form3_rows.txt', {}) if os.path.exists(os.path.join(here, 'mlg_form3_rows.txt')) else 0
    d['amendment'] = ORDER; json.dump(d, open(p, 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
    report.append('mohanlalganj: %d changes' % n)
# Sadar tehsil: पपनामऊ (SD2) and तिलकनगर (SD3) by V-code
for slug, vc, setv in [('sadar-dwitiya', '1114', {'lt9': 8000, '9_12': 8800, '12_18': 9500, 'gt18': 10500, 'agri': [95, 88, 95, 75]}),
                       ('sadar-tritiya', '0014', {'9_12': 23000, '12_18': 25500, 'gt18': 26500})]:
    p, d = load(slug)
    if not d: report.append('%s: not built' % slug); continue
    rs = [r for r in d['rows'] if r['vcode'] == vc]
    assert len(rs) == 1, (slug, vc)
    r = rs[0]; remember(r, 'plot')
    for k, v in setv.items():
        if k == 'agri': remember(r, 'agri'); r['agri'] = dict(zip(AGRI, v))
        else: r['plot'][k] = v
    r.pop('note', None) if slug == 'sadar-tritiya' else None
    d['amendment'] = ORDER; json.dump(d, open(p, 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
    report.append('%s: %s %s' % (slug, r['hi'], r['plot']))
ALIAS_SN1 = {'जैतिखेड़ा': 'जैतीखेडा', 'पूरब कल्ली': 'कल्ली पूरब', 'भागूखेड़ा': 'भागूखेडा', 'शाहपुर मझिंगवा': 'शाहपुर मझगवां',
             'सरैया': 'सरैयॉ',
             'कानपुर रोड स्थित जुनाबगंज चौराहे से प्रयागराज-मोहनलालगंज रोड पर भागू खेडा चौराहा तक':
             'कानपुर रोड स्थित जुनाबगंज चौराहे से प्रयागराज-मोहनलालगंज रोड पर भागूखेडा चौराहे तक'}
ALIAS_SN2 = {'अमांवा': 'अमावां', 'ऐन': 'ऐंन', 'औरांवा': 'औरावां', 'कूढ़ाईट गांव': 'कूढ़ाईटगांव', 'दाराबनगर बरकोता': 'दराबनगर बरकोता',
             'भटगांव': 'भटगावं', 'मिर्जापुर लुट्ठौवा': 'मिर्जापुर लुटौवा', 'सरांय मुहीब': 'सरांय मुहिब', 'हुलासखेडा': 'हुलास खेड़ा',
             'बंथरा सिकन्दरपुर': 'बन्थरा सिकन्दरपुर', 'भौंकापुर': 'भौकापुर', 'किशनपुर कौडिया': 'किशनपुर कौडिया',
             'बिजनौर रोड (बिजनौर चौराहा/सी0आर0पी0एफ0 से बंथरा थाने तक)': 'बिजनौर रोड (बिजनौर चौराहा/सी0आर0पी0एफ0 से बंथरा थाने तक)',
             'कानपुर रोड स्थित जुनाबगंज चौराहे से प्रयागराज-मोहनलालगंज रोड पर भागू खेडा चौराहा तक':
             'कानपुर रोड स्थित जुनाबगंज चौराहा से प्रयागराज-मोहनलालगंज रोड पर भागूखेडा चौराहा तक'}
ALIASES = {'sarojini-nagar': ALIAS_SN1, 'sarojini-nagar-dwitiya': ALIAS_SN2}
for slug, f in [('bakshi-ka-talab', 'bkt.txt'), ('malihabad', 'malihabad.txt'), ('sarojini-nagar', 'sn1.txt'), ('sarojini-nagar-dwitiya', 'sn2.txt')]:
    p, d = load(slug)
    if not d: report.append('%s: not built yet, %s waits' % (slug, f)); continue
    n = apply_agri(d, f, ALIASES.get(slug, {})); d['amendment'] = ORDER
    json.dump(d, open(p, 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':')); report.append('%s: %d changes' % (slug, n))
print('\n'.join(report))
