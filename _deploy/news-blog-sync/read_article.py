import sys, re, html, urllib.request, json
u = sys.argv[1]
try:
    x = urllib.request.urlopen(urllib.request.Request(u, headers={'Accept-Language': 'hi'}), timeout=30).read().decode('utf-8', 'ignore')
except Exception as e:
    print('FAIL', e); sys.exit()
for m in re.findall(r'"(datePublished|headline)"\s*:\s*"([^"]+)"', x)[:2]: print(m)
for m in re.finditer(r'"articleBody"\s*:\s*"', x):
    i = m.end(); j = i
    while j < len(x) and not (x[j] == '"' and x[j - 1] != '\\'): j += 1
    b = x[i:j]
    if len(b) > 300:
        try: print(json.loads('"' + b + '"')[:7000])
        except Exception: print(html.unescape(b)[:7000])
        sys.exit()
x = re.sub(r'<(script|style).*?</\1>', ' ', x, flags=re.S)
ps = [re.sub(r'\s+', ' ', html.unescape(re.sub('<[^>]+>', '', p))).strip() for p in re.findall(r'<p[^>]*>(.*?)</p>', x, re.S)]
print('\n'.join(p for p in ps if len(p) > 50)[:7000])
