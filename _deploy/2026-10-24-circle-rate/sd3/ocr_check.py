# Independent check of the Sadar Tritiya transcription: machine-OCR every table page of RateList_229,
# group number tokens into rows, key them by V-code and compare with form2/3/4.tsv. Also checks Form 1
# (index, pages 16-40) ward + V-code pairs. Prints every row that does not match exactly.
# Run with a venv that has rapidocr-onnxruntime + pymupdf:  <venv>/python ocr_check.py
import csv, os, re
import fitz, numpy as np
from rapidocr_onnxruntime import RapidOCR

here = os.path.dirname(os.path.abspath(__file__))
rd = lambda f: list(csv.reader(open(os.path.join(here, f), encoding='utf-8'), delimiter='\t'))
f2, f3, f4 = rd('form2.tsv'), rd('form3.tsv'), rd('form4.tsv')
ocr = RapidOCR()
doc = fitz.open(os.path.join(here, '..', 'src', 'RateList_229_01-08-2025.pdf'))

def page_rows(i):   # pages are scanned both ways up, so read each one in both orientations
    return one_rows(i, 90) + one_rows(i, -90)

def one_rows(i, rot):
    pix = doc[i].get_pixmap(matrix=fitz.Matrix(3, 3).prerotate(rot))
    img = np.frombuffer(pix.samples, dtype=np.uint8).reshape(pix.height, pix.width, pix.n)[:, :, :3]
    res, _ = ocr(img)
    toks = sorted((sum(p[1] for p in b) / 4, min(p[0] for p in b), t.replace(' ', '').replace(',', ''))
                  for b, t, c in (res or []) if re.fullmatch(r'\d{1,6}', t.replace(' ', '').replace(',', '')))
    rows, cur = [], []
    for t in toks:
        if cur and abs(t[0] - cur[-1][0]) > 25: rows.append(cur); cur = []
        cur.append(t)
    if cur: rows.append(cur)
    return [[t[2] for t in sorted(r, key=lambda t: t[1])] for r in rows]

def collect(pages, form1=False):
    found = {}
    for i in pages:
        for n in page_rows(i):
            vi = [k for k, x in enumerate(n) if re.fullmatch(r'0{1,3}\d{3}', x) and len(x) >= 4]
            if not vi: continue
            k = vi[0]; vc = n[k][-4:]
            if form1:
                found.setdefault(vc, []).append([x for x in n[k + 1:] + n[:k] if re.fullmatch(r'0\d{2}', x)])
            else:
                found.setdefault(vc, []).append(n[k + 1:])
    return found

bad = 0
g = collect(range(40, 60))
for r in f2:
    want = r[6:9]
    got = [x[1:] if x and len(x[0]) <= 3 else x for x in g.get(r[2], [])]
    if want not in got: print('f2', r[0], r[1], r[2], 'mine', want, 'ocr', g.get(r[2])); bad += 1
g = collect(range(74, 99))
for r in f4:
    want = r[2:5] + r[9:12] + ([] if r[5] == '-' else r[5:9])
    if want not in g.get(r[0], []): print('f4', r[1], r[0], 'mine', want, 'ocr', g.get(r[0])); bad += 1
g = collect(range(60, 74))
for r in f3:
    if r[3] == '-': continue
    want = [r[4]] + r[6:9]
    if want not in g.get(r[3], []): print('f3', r[0], r[2], r[3], 'mine', want, 'ocr', g.get(r[3])); bad += 1
g = collect(range(15, 40), form1=True)
for r in f2:
    if not any(r[3] in x for x in g.get(r[2], [])): print('form1', r[0], r[1], r[2], r[3], 'ocr', g.get(r[2])); bad += 1
print('rows to look at:', bad)
