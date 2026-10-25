# Decode Google News RSS article links to the publisher URL. Usage: python gn_decode.py links.txt (one news.google.com/rss/articles/... link per line)
import sys,re,json,urllib.request,urllib.parse
def dec(link):
    aid=link.split('/articles/')[1].split('?')[0]
    h=urllib.request.urlopen(urllib.request.Request('https://news.google.com/rss/articles/'+aid),timeout=30).read().decode()
    sg=re.search(r'data-n-a-sg="([^"]+)"',h).group(1); ts=re.search(r'data-n-a-ts="([^"]+)"',h).group(1)
    req=[["Fbv4je",json.dumps(["garturlreq",[["X","X",["X","X"],None,None,1,1,"US:en",None,1,None,None,None,None,None,0,1],"X","X",1,[1,1,1],1,1,None,0,0,None,0],aid,int(ts),sg])]]
    body='f.req='+urllib.parse.quote(json.dumps([req]))
    r=urllib.request.urlopen(urllib.request.Request('https://news.google.com/_/DotsSplashUi/data/batchexecute',data=body.encode(),headers={'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8',}),timeout=30).read().decode()
    return json.loads(json.loads(r.split('\n\n')[1])[0][2])[1]
for l in open(sys.argv[1]):
    try: print(dec(l.strip()))
    except Exception as e: print('ERR',e)
