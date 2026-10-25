# Independent check of the Mohanlalganj transcription: OCR every table page of RateList_232, group number tokens into
# rows, key each row by its serial number and compare with what build_data.py wrote to the JSON.
# Run with a venv that has rapidocr-onnxruntime + pymupdf:  <venv>/python ocr_check.py
import json, os, re
import fitz, numpy as np
from rapidocr_onnxruntime import RapidOCR

here = os.path.dirname(os.path.abspath(__file__))
J = json.load(open(os.path.join(here, '..', '..', '..', 'resources', 'data', 'circle-rates', 'lucknow-mohanlalganj.json'), encoding='utf-8'))
doc = fitz.open(os.path.join(here, '..', 'src', 'RateList_232_01-08-2025.pdf'))
ocr = RapidOCR()

def rows_of(i):
    pix = doc[i].get_pixmap(matrix=fitz.Matrix(2.5, 2.5))
    img = np.frombuffer(pix.samples, dtype=np.uint8).reshape(pix.height, pix.width, pix.n)[:, :, :3]
    res, _ = ocr(img)
    toks = sorted((sum(p[1] for p in b) / 4, min(p[0] for p in b), t.replace(' ', '').replace(',', ''))
                  for b, t, c in (res or []) if re.fullmatch(r'\d{1,6}|-', t.replace(' ', '').replace(',', '')))
    out, cur = [], []
    for t in toks:
        if cur and abs(t[0] - cur[-1][0]) > 22: out.append(cur); cur = []
        cur.append(t)
    if cur: out.append(cur)
    return [[t[2] for t in sorted(r, key=lambda t: t[1])] for r in out]

def collect(pages):
    got = {}
    for i in pages:
        for n in rows_of(i):
            if n and n[0].isdigit(): got.setdefault(int(n[0]), []).append(n[1:])
    return got

bad = 0
g = collect(range(33, 50))                      # Form 2: sr, pargana, plot, ordinary, premium
for r in J['rows']:
    want = [r['ward'], str(r['plot']['lt9']), str(r['flat']['ordinary']), str(r['flat']['premium'])]
    if want not in g.get(r['sr'], []): print('f2', r['sr'], r['hi'], 'mine', want, 'ocr', g.get(r['sr'])); bad += 1
g = collect(range(59, 86))                      # Form 4
for r in J['rows']:
    a = r['agri']; c = r['commercial']; p = r['plot']
    want = [str(p['9_12']), str(p['12_18']), str(p['gt18'])] + ([str(a[k]) for k in ('district_road', 'link_road', 'near_abadi', 'general')] if a else ['-'] * 4) + [str(c['shop']), str(c['office']), str(c['godown'])]
    if want not in g.get(r['sr'], []): print('f4', r['sr'], r['hi'], 'mine', want, 'ocr', g.get(r['sr'])); bad += 1
g = collect(range(50, 59))                      # Form 3, in printed order
seg = [x for r in J['rows'] for x in r['roads']]
order = [l.rstrip('\n').split('|') for l in open(os.path.join(here, 'form3_src.txt'), encoding='utf-8') if l.strip()]
for k, s in enumerate(order, 1):
    want = [s[2], s[3], s[4], s[5], s[6]]
    if want not in g.get(k, []): print('f3', k, s[1], 'mine', want, 'ocr', g.get(k)); bad += 1
print('rows to look at:', bad)
