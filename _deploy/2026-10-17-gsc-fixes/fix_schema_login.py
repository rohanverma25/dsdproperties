import json, re
EN = 'When we checked igrsup.gov.in on 17 October 2026, the property search links opened a User Login page (user ID, password and captcha). If you do not have an account, use the Register Now option on the home page first.'
HI = '17 अक्टूबर 2026 को जाँचने पर igrsup.gov.in के सम्पत्ति खोज वाले लिंक पहले यूज़र लॉगिन पेज (यूज़र आईडी, पासवर्ड और कैप्चा) पर ले गए। अकाउंट न हो तो होम पेज पर Register Now से पहले रजिस्टर करें।'
for pid, pat, new in [(115, r'[^."]*completely free and does not require login\.', EN),
                      (120, r'[^."]*bilkul muft hai aur iske liye login nahi chahiye\.', HI)]:
    f = json.load(open(f'{pid}.fields.json', encoding='utf8'))
    s, n = re.subn(pat, ' ' + new, f['seo_schema'])
    s = s.replace('  ' + new, ' ' + new).replace('" ' + new, '"' + new)
    json.loads(s)
    f['seo_schema'] = s
    json.dump(f, open(f'{pid}.fields.json', 'w', encoding='utf8'), ensure_ascii=False)
    left = re.findall(r'does not require login|login nahi chahiye', s)
    print(pid, 'replaced', n, 'left', len(left))
