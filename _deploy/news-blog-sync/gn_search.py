import sys,re,html,urllib.parse,urllib.request
seen=set()
for q in sys.argv[1:]:
    u='https://news.google.com/rss/search?q='+urllib.parse.quote(q+' when:3d')+'&hl=hi&gl=IN&ceid=IN:hi'
    x=urllib.request.urlopen(u,timeout=30).read().decode('utf-8')
    print('###',q)
    for it in re.findall(r'<item>(.*?)</item>',x,re.S)[:30]:
        t=html.unescape(re.search(r'<title>(.*?)</title>',it,re.S).group(1))
        if t in seen: continue
        seen.add(t)
        d=re.search(r'<pubDate>(.*?)</pubDate>',it).group(1)[5:22]; l=re.search(r'<link>(.*?)</link>',it).group(1)
        print(d,'|',t[:170],'|',l)
