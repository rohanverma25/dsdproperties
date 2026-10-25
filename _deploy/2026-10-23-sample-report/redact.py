# Blurs personal details (names, parentage, addresses, application/certificate numbers, officials' names
# and signatures) in the sample documents, and stamps a "नमूना / SAMPLE" watermark. Output: redacted/*.jpg
from PIL import Image, ImageDraw, ImageFilter, ImageFont
import os

HERE = os.path.dirname(os.path.abspath(__file__))
BOXES = {
    # file: [(x1, y1, x2, y2), ...] in original pixels
    'form45':         [(42, 330, 256, 795)],
    'form41':         [(36, 770, 192, 1010), (190, 900, 720, 950)],
    'bharmukt':       [(36, 96, 330, 118), (500, 120, 790, 146), (58, 216, 610, 250), (36, 258, 780, 300),
                       (222, 650, 426, 712), (436, 652, 810, 708)],
    'registry_index': [(148, 98, 332, 610), (332, 98, 472, 610)],
}
FONT = 'C:/Windows/Fonts/Nirmala.ttc'

os.makedirs(os.path.join(HERE, 'redacted'), exist_ok=True)
for name, boxes in BOXES.items():
    im = Image.open(os.path.join(HERE, 'src', name + '.jpg')).convert('RGB')
    for (x1, y1, x2, y2) in boxes:
        region = im.crop((x1, y1, x2, y2)).filter(ImageFilter.GaussianBlur(9))
        tint = Image.new('RGB', region.size, (226, 232, 240))
        im.paste(Image.blend(region, tint, 0.55), (x1, y1))
        d = ImageDraw.Draw(im)
        d.rectangle([x1, y1, x2, y2], outline=(148, 163, 184), width=1)
        if (x2 - x1) > 90 and (y2 - y1) > 18:
            f = ImageFont.truetype(FONT, 13)
            d.text(((x1 + x2) / 2, (y1 + y2) / 2), 'गोपनीय — छिपाया गया', font=f, fill=(71, 85, 105), anchor='mm')
    # diagonal watermark
    wm = Image.new('RGBA', im.size, (0, 0, 0, 0))
    wd = ImageDraw.Draw(wm)
    f = ImageFont.truetype(FONT, max(28, im.size[0] // 9))
    for k in range(-1, 3):
        wd.text((im.size[0] * 0.12, im.size[1] * (0.18 + 0.28 * k)), 'नमूना  ·  SAMPLE', font=f, fill=(255, 92, 0, 46))
    wm = wm.rotate(28, resample=Image.BICUBIC, center=(im.size[0] / 2, im.size[1] / 2))
    im = Image.alpha_composite(im.convert('RGBA'), wm).convert('RGB')
    im.save(os.path.join(HERE, 'redacted', name + '.jpg'), 'JPEG', quality=88)
    print('redacted', name)
