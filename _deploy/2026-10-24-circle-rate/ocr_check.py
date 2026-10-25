# Independent check of the hand transcription: machine-OCR every table page of the official PDF,
# read the numbers row by row, and compare them with form2/3/4.tsv. Prints every mismatch.
# Run with the scratch venv that has rapidocr-onnxruntime + pymupdf:  <venv>/python ocr_check.py
import csv, os, re, sys, json
import fitz
import numpy as np
from rapidocr_onnxruntime import RapidOCR

here = os.path.dirname(os.path.abspath(__file__))
rd = lambda f: list(csv.reader(open(os.path.join(here, f), encoding='utf-8'), delimiter='\t'))
F = {'f2': rd('form2.tsv'), 'f3': rd('form3.tsv'), 'f4': rd('form4.tsv')}
# expected numbers per row (vcode + rates), keyed by serial
EXP = {
    'f2': {int(r[0]): [r[2], r[3].zfill(3), r[5], r[6], r[7]] for r in F['f2']},
    'f3': {int(r[0]): [r[3], r[4], r[5], r[6], r[7]] for r in F['f3']},
    'f4': {int(r[0]): [r[3]] + r[4:10] for r in F['f4']},
}
ocr = RapidOCR()
doc = fitz.open(os.path.join(here, 'src', 'RateList_227_01-08-2025.pdf'))

def form_of(i):
    if 25 <= i <= 37: return 'f2'
    if 38 <= i <= 42: return 'f3'
    if 43 <= i <= 60: return 'f4'

found = {'f2': {}, 'f3': {}, 'f4': {}}
for i in range(25, 61):
    f = form_of(i)
    pix = doc[i].get_pixmap(matrix=fitz.Matrix(3, 3).prerotate(-90))
    img = np.frombuffer(pix.samples, dtype=np.uint8).reshape(pix.height, pix.width, pix.n)[:, :, :3]
    res, _ = ocr(img)
    toks = []
    for box, text, conf in res or []:
        t = text.replace(' ', '').replace('`', '').replace(',', '')
        if re.fullmatch(r'\d{1,6}', t):
            ys = [p[1] for p in box]; xs = [p[0] for p in box]
            toks.append((sum(ys) / 4, min(xs), t))
    # group into rows by y
    toks.sort()
    rows, cur = [], []
    for t in toks:
        if cur and abs(t[0] - cur[-1][0]) > 18:
            rows.append(cur); cur = []
        cur.append(t)
    if cur: rows.append(cur)
    for r in rows:
        r.sort(key=lambda t: t[1])
        nums = [t[2] for t in r]
        vi = [k for k, x in enumerate(nums) if re.fullmatch(r'0\d{3}', x)]
        if not vi: continue
        k = vi[0]
        after = nums[k + 1:]
        if f == 'f2' and after and re.fullmatch(r'0?\d{2}', after[0]): after = after[1:]   # drop ward no.
        found[f].setdefault(nums[k], []).append((i + 1, after))

bad = 0; ok = 0
for f in ('f2', 'f3', 'f4'):
    for sr, exp in EXP[f].items():
        vc = exp[0]
        want = exp[2:] if f == 'f2' else exp[1:]
        got = found[f].get(vc, [])
        if any(g[1] == want for g in got): ok += 1; continue
        print(f'{f} #{sr} vcode {vc}: mine {want}  ocr {[g for g in got]}'); bad += 1
print('rows checked:', sum(len(v) for v in EXP.values()), 'exact OCR matches:', ok, 'to look at:', bad)
