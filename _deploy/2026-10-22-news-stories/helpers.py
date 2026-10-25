# Builds 6 hand-checked Hindi news stories (18 Oct 2026) into stories.json for insert.php.
import json, urllib.parse

WA = 'https://wa.me/918595002933?text='
def link(url, text, ext=True):
    extra = ' target="_blank" rel="noopener"' if ext else ''
    return f'<a href="{url}"{extra} style="color:#008080;font-weight:600;">{text}</a>'
def site(path, text): return link('https://dsdproperties.in/' + path, text, ext=False)
def facts(items):
    lis = ''.join(f'<li style="margin:5px 0;line-height:1.7;">{i}</li>' for i in items)
    return ('<div style="background:#f0fdfa;border:1px solid rgba(0,128,128,0.25);border-left:4px solid #008080;'
            'border-radius:0 12px 12px 0;padding:16px 20px;margin:0 0 24px;">'
            '<p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">मुख्य बातें</p>'
            f'<ul style="margin:0;padding-left:20px;">{lis}</ul></div>')
def h2(t): return f'<h2 style="font-size:21px;font-weight:700;color:#011f4b;margin:28px 0 10px;border-left:5px solid #FF5C00;padding-left:12px;">{t}</h2>'
def p(t): return f'<p style="font-size:15.5px;line-height:1.85;color:#374151;margin:0 0 14px;">{t}</p>'
def ul(items): return '<ul style="margin:0 0 16px;padding-left:22px;">' + ''.join(f'<li style="margin:6px 0;line-height:1.75;color:#374151;">{i}</li>' for i in items) + '</ul>'
def cta(title, body, button, msg):
    return ('<div style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #FF5C00;border-radius:0 12px 12px 0;padding:16px 20px;margin:24px 0;">'
            f'<p style="margin:0 0 6px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>'
            f'<p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">{body}</p>'
            f'<p style="margin:0;text-align:center;"><a href="{WA + urllib.parse.quote(msg)}" target="_blank" rel="noopener" '
            'style="display:inline-block;background:#FF5C00;color:#fff;font-weight:700;padding:10px 22px;border-radius:10px;text-decoration:none;">'
            f'{button}</a></p></div>')
VERIFY = lambda: cta('खरीदने से पहले जाँच कराएँ',
    'खतौनी, रजिस्ट्री की चेन, भार-मुक्त प्रमाणपत्र (Encumbrance), LDA/जिला पंचायत की मंज़ूरी और कोर्ट केस — <strong>आवासीय प्लॉट और फ़्लैट के लिए ₹5,000, 48 घंटे में PDF रिपोर्ट</strong>। '
    + site('services/property-verification-lucknow', 'देखें हम क्या-क्या जाँचते हैं →'),
    'प्रॉपर्टी वेरिफिकेशन कराएँ — ₹5,000', 'नमस्ते, मुझे प्रॉपर्टी वेरिफिकेशन करानी है।')
def sources(items): return '<p style="font-size:13px;color:#6b7280;margin:24px 0 0;padding-top:12px;border-top:1px solid #e2e8f0;">स्रोत: ' + ', '.join(items) + '</p>'
def dateline(d): return f'<p style="font-size:13px;color:#FF5C00;font-weight:700;letter-spacing:.04em;margin:0 0 14px;">लखनऊ • {d}</p>'

def table(head, rows):
    th = ''.join(f'<th style="padding:8px 10px;text-align:left;background:#011f4b;color:#fff;font-size:14px;">{h}</th>' for h in head)
    tr = ''.join('<tr>' + ''.join(f'<td style="padding:8px 10px;border-bottom:1px solid #e2e8f0;font-size:14.5px;color:#374151;">{c}</td>' for c in r) + '</tr>' for r in rows)
    return f'<div style="overflow-x:auto;margin:0 0 18px;"><table style="width:100%;border-collapse:collapse;"><thead><tr>{th}</tr></thead><tbody>{tr}</tbody></table></div>'

