# 24 Oct 2026, second run: Saumitra Vihar gets RERA approval. Source: Hindustan Lucknow print, 24 Oct 2026
# ("लखनऊ, प्रमुख संवाददाता"), clipping sent by the user; no online copy found (source_url null).
# The Additional Housing Commissioner is quoted saying RERA approved it; the RERA number is not public yet, so the
# blog posts say "approved, per UPAVP" and still tell buyers to check the number on up-rera.in.
# Price: the paper's ₹2,600–3,000/sq ft is reported as news. Posts 95/96 keep DSD's ~₹4,000 market assessment
# (user decision 16 Oct, see memory saumitra-vihar-facts).
import json
from helpers import *

HT = 'हिन्दुस्तान (लखनऊ), 24 अक्टूबर 2026'
N4 = 'saumitra-vihar-yojana-rera-manjuri-diwali-launch-october-2026'
SV_HI = site('blog/saumitra-vihar-yojana-lucknow-hindi-2026', 'सौमित्र विहार योजना गाइड')

def update_box(title, body):
    return ('<div style="background:#eff6ff;border:1px solid #bfdbfe;border-left:4px solid #2563eb;border-radius:0 12px 12px 0;padding:16px 20px;margin:24px 0;">'
            f'<p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>{body}</div>')

S = [dict(created_at='2026-10-24 10:00:00',
 slug=N4,
 title='सौमित्र विहार योजना को रेरा से मंज़ूरी: आवास विकास दिवाली तक लॉन्च की तैयारी में, पहले चरण में 2,000 से ज़्यादा भूखंड',
 summary='आवास विकास परिषद की न्यू जेल रोड स्थित सौमित्र विहार आवासीय योजना को यूपी रेरा से मंज़ूरी मिल गई है। अपर आवास आयुक्त राकेश कुमार सिंह के अनुसार अब बुकिंग खोलने में अड़चन नहीं है, लेकिन भूखंडों की दरें, संख्या और तारीख अभी तय नहीं हैं। पहले चरण में 2,000 से ज़्यादा भूखंडों का पंजीकरण खुल सकता है; दर ₹2,600 से ₹3,000 प्रति वर्गफुट के बीच हो सकती है।',
 meta_description='सौमित्र विहार योजना लखनऊ को रेरा मंज़ूरी (अक्टूबर 2026)। आवास विकास दिवाली तक लॉन्च की तैयारी में, 2,000+ भूखंड, दर ₹2,600–3,000 प्रति वर्गफुट संभावित, तारीख तय नहीं।',
 category='projects', is_hot=1, source_name='हिन्दुस्तान', source_url=None,
 full_content=dateline('24 अक्टूबर 2026') + facts([
   'आवास विकास परिषद की न्यू जेल रोड स्थित <strong>सौमित्र विहार योजना को यूपी रेरा से मंज़ूरी</strong> मिल गई है।',
   'अपर आवास आयुक्त <strong>राकेश कुमार सिंह</strong>: अब बुकिंग खोलने में अड़चन नहीं; <strong>दरें, भूखंडों की संख्या और तारीख अभी तय नहीं</strong>।',
   'पहले चरण में <strong>2,000 से ज़्यादा भूखंडों</strong> का पंजीकरण खुल सकता है। परिषद <strong>दिवाली तक</strong> योजना लॉन्च कर सकता है।',
   'भूखंड की दर <strong>₹2,600 से ₹3,000 प्रति वर्गफुट</strong> के बीच हो सकती है (अंतिम दर अभी तय नहीं)।']) +
 h2('क्या हुआ') +
 p('हिन्दुस्तान की 24 अक्टूबर की रिपोर्ट के अनुसार सौमित्र विहार का रेरा पंजीकरण लंबे समय से लंबित था। ज़रूरी दस्तावेज़ों और रेरा की आपत्तियों का निस्तारण न होने से योजना लॉन्च नहीं हो पा रही थी। अब सभी आपत्तियां दूर कर ली गई हैं और रेरा ने पंजीकरण को मंज़ूरी दे दी है। रिपोर्ट के अनुसार आवास आयुक्त अनिल ढींगरा के प्रयासों के बाद प्रक्रिया तेज़ हुई और अधिकारी अब लॉन्चिंग की तैयारी पर ध्यान दे रहे हैं।') +
 p('अपर आवास आयुक्त राकेश कुमार सिंह ने कहा: "सौमित्र विहार योजना को यूपी रेरा से मंज़ूरी मिल गई है। इससे अब योजना की बुकिंग खोलने में अड़चन नहीं रह गई है। भूखंडों की दरें और संख्या जल्दी ही तय होंगी। बुकिंग भी जल्दी ही खोली जाएगी। हालांकि अभी तिथि तय नहीं है।"') +
 h2('अभी क्या तय नहीं है') +
 ul(['<strong>रेरा पंजीकरण नंबर</strong> अभी सार्वजनिक नहीं हुआ है। ब्रोशर आने पर उसका नंबर up-rera.in पर खुद जांचें।',
     '<strong>भूखंडों की अंतिम संख्या और दर</strong>: रिपोर्ट में ₹2,600 से ₹3,000 प्रति वर्गफुट की संभावना बताई गई है, लेकिन अंतिम दर तय होने के बाद ही पंजीकरण की प्रक्रिया साफ़ होगी।',
     '<strong>लॉन्च की तारीख</strong>: दिवाली तक की तैयारी है, पर तारीख घोषित नहीं हुई। इस योजना की कई तारीखें पहले भी निकल चुकी हैं (जनवरी 2025, होली 2025, नवंबर 2025, अगस्त 2026, नवरात्रि 2026)।']) +
 p('इससे पहले की खबर: ' + site('news/saumitra-vihar-600-bhukhand-panjikaran-diwali-awas-vikas-october-2026', 'दिवाली पर पंजीकरण खोलने की तैयारी') + '।') +
 h2('खरीदारों के लिए इसका मतलब') +
 ul(['<strong>पंजीकरण सिर्फ upavp.in पर</strong> होगा। ब्रोशर आने से पहले "बुकिंग" या "प्लॉट पक्का" के नाम पर किसी को पैसा न दें।',
     'दस्तावेज़ अभी से तैयार रखें: आधार, पैन, फोटो, पते का प्रमाण, और आरक्षित श्रेणी के लिए आय प्रमाण पत्र।',
     'योजना न्यू जेल रोड पर है: लोकेशन, 8 सेक्टर, प्लॉट साइज़ और कुल ख़र्च का हिसाब: ' + SV_HI + '।',
     'आसपास की निजी प्लॉटिंग में "सौमित्र विहार के पास" के नाम पर ऊंचे दाम मांगे जा सकते हैं। ऐसी ज़मीन लेने से पहले खतौनी, नक्शा और मंज़ूरी ज़रूर जंचवाएं।']) +
 VERIFY() +
 sources([HT + ' (प्रिंट संस्करण)']))]

U = [dict(id=160, before_h2='खरीदारों के लिए इसका मतलब',
  box=update_box('अपडेट, 24 अक्टूबर: रेरा से मंज़ूरी मिली, दिवाली तक लॉन्च की तैयारी',
    p('हिन्दुस्तान के अनुसार सौमित्र विहार योजना को यूपी रेरा से मंज़ूरी मिल गई है। अपर आवास आयुक्त राकेश कुमार सिंह ने कहा कि अब बुकिंग खोलने में अड़चन नहीं है, लेकिन दरें, भूखंडों की संख्या और तारीख अभी तय नहीं। पहले चरण में 2,000 से ज़्यादा भूखंड और ₹2,600–3,000 प्रति वर्गफुट की संभावित दर बताई गई है। पूरी खबर: ' + site('news/' + N4, 'सौमित्र विहार को रेरा मंज़ूरी') + '।')))]

A = lambda url, t: f'<a href="{url}" style="color:#008080;font-weight:600;">{t}</a>'
OWN = lambda t: A('https://dsdproperties.in/news/' + N4, t)
EN_LI = ('<strong>24 October 2026:</strong> UP RERA has approved Saumitra Vihar, Additional Housing Commissioner Rakesh Kumar Singh told Hindustan. '
         'UPAVP is preparing to launch by Diwali with 2,000+ plots in phase 1, but the date, plot count and rates are not fixed yet (the paper reports ₹2,600–3,000/sq ft as possible). '
         'The RERA number is not public yet. (Hindustan, print · ' + OWN('our news report') + ')')
HI_LI = ('<strong>24 अक्टूबर 2026:</strong> अपर आवास आयुक्त राकेश कुमार सिंह ने हिन्दुस्तान को बताया कि सौमित्र विहार को यूपी रेरा से मंज़ूरी मिल गई है। '
         'परिषद दिवाली तक लॉन्च की तैयारी में है, पहले चरण में 2,000 से ज़्यादा भूखंड; तारीख, संख्या और दरें अभी तय नहीं (अख़बार के अनुसार ₹2,600–3,000 प्रति वर्गफुट संभव)। '
         'रेरा नंबर अभी सार्वजनिक नहीं। (हिन्दुस्तान, प्रिंट · ' + OWN('पूरी खबर') + ')')
EN_REPL = [
 ['8 sectors, RERA approval pending. Launch date', '8 sectors, RERA approved (Oct 2026). Launch date'],
 ['<span class="dsd-dot wait"></span> RERA: final certificate pending</span>', '<span class="dsd-dot done"></span> RERA: approved, per UPAVP (24 Oct)</span>'],
 ['Checked 16 Oct 2026', 'Checked 24 Oct 2026'],
 ['<li><strong>The final RERA certificate is still pending.</strong> UPAVP applied to UP RERA on 11 August 2026 (Dainik Jagran).',
  '<li><strong>RERA has approved the scheme, according to UPAVP.</strong> Additional Housing Commissioner Rakesh Kumar Singh told Hindustan on 24 October 2026 that UP RERA has cleared it and booking can now open; rates, plot numbers and the date are not fixed yet. UPAVP had applied to UP RERA on 11 August 2026 (Dainik Jagran).'],
 ['Do not treat it as approved until the RERA number shows on up-rera.in.</li>', 'The RERA number is not public yet, so check it on up-rera.in before you pay.</li>'],
 ['The final RERA certificate has not come through yet. Until that clears and UPAVP puts up the official brochure, nobody can sell you a plot here.',
  'RERA approval came in October 2026, but until UPAVP puts up the official brochure and opens registration, nobody can sell you a plot here.'],
 ['Planned in 8 sectors. RERA approval is still pending.', 'Planned in 8 sectors. RERA approval reported on 24 Oct 2026.'],
 ['<td><span class="dsd-badge wait">Final certificate pending</span></td>', '<td><span class="dsd-badge ok">Approved (per UPAVP, 24 Oct 2026)</span></td>'],
 ['<td>Applied 11 August 2026; green signal reported in September</td>', '<td>Applied 11 August 2026; approval confirmed by the Additional Housing Commissioner on 24 October 2026; RERA number not yet public</td>'],
 ['<li>The final RERA certificate has not come yet — the application was filed on 11 August 2026</li>', '<li>RERA approval came only in October 2026, and the RERA number is not public yet</li>'],
 ['RERA approval is still pending, and the expected rate', 'RERA approval came only in October 2026, and the expected rate'],
 ['No, not yet. As of 16 October 2026 there is no registration link, brochure or price list on upavp.in.',
  'Not yet. RERA approval came in October 2026, but as of 24 October there is no registration link, brochure or price list on upavp.in.'],
 ['Public registration will open only after the final RERA certificate is issued.', 'In October 2026 UPAVP said it is preparing to launch by Diwali, but no date is fixed (Hindustan, 24 October 2026).'],
 ['Not yet. UPAVP applied to UP RERA on 11 August 2026 (Dainik Jagran). A News Nation report on 17 September 2026 said the scheme had RERA’s green signal and only the final certificate was pending, but as of 16 October 2026 the approval is not complete. When the brochure comes out, take the RERA number from it and check it yourself on up-rera.in before applying. Anyone telling you today that this scheme is already RERA registered is giving you wrong information.',
  'Yes, according to UPAVP. Additional Housing Commissioner Rakesh Kumar Singh told Hindustan on 24 October 2026 that UP RERA has approved the scheme. UPAVP had applied on 11 August 2026 (Dainik Jagran). The RERA registration number is not public yet. When the brochure comes out, take the RERA number from it and check it yourself on up-rera.in before applying.'],
 ['the final RERA certificate is still pending, registration has not opened', 'RERA approval has only just come (October 2026) and its number is not public yet, registration has not opened'],
]
HI_REPL = [
 ['8 सेक्टर, RERA मंज़ूरी बाकी —', '8 सेक्टर, RERA मंज़ूरी मिली (अक्टूबर 2026) —'],
 ['<span class="dsd-dot wait"></span> रेरा: अंतिम प्रमाणपत्र बाकी</span>', '<span class="dsd-dot done"></span> रेरा: मंज़ूरी मिली (परिषद, 24 अक्टूबर)</span>'],
 ['जाँचा गया 16 अक्टूबर 2026', 'जाँचा गया 24 अक्टूबर 2026'],
 ['<li><strong>रेरा का अंतिम प्रमाणपत्र अभी बाकी है।</strong> UPAVP ने 11 अगस्त 2026 को यूपी रेरा में आवेदन किया था (दैनिक जागरण)।',
  '<li><strong>रेरा से मंज़ूरी मिल गई है (परिषद के अनुसार)।</strong> अपर आवास आयुक्त राकेश कुमार सिंह ने 24 अक्टूबर 2026 को हिन्दुस्तान को बताया कि यूपी रेरा ने योजना को मंज़ूरी दे दी है और अब बुकिंग खोलने में अड़चन नहीं है; दरें, भूखंडों की संख्या और तारीख अभी तय नहीं। UPAVP ने 11 अगस्त 2026 को यूपी रेरा में आवेदन किया था (दैनिक जागरण)।'],
 ['जब तक up-rera.in पर रेरा नंबर न दिखे, योजना को मंज़ूर न मानें।</li>', 'रेरा नंबर अभी सार्वजनिक नहीं है, इसलिए पैसे देने से पहले up-rera.in पर ज़रूर जाँचें।</li>'],
 ['रेरा का अंतिम प्रमाणपत्र अभी नहीं मिला है। जब तक वह पास नहीं होता और UPAVP आधिकारिक ब्रोशर जारी नहीं करता, यहाँ कोई आपको प्लॉट बेच नहीं सकता।',
  'रेरा की मंज़ूरी अक्टूबर 2026 में मिली है, लेकिन जब तक UPAVP आधिकारिक ब्रोशर जारी नहीं करता और रजिस्ट्रेशन नहीं खुलता, यहाँ कोई आपको प्लॉट बेच नहीं सकता।'],
 ['8 सेक्टरों में नियोजित। RERA मंज़ूरी अभी बाकी है।', '8 सेक्टरों में नियोजित। RERA मंज़ूरी 24 अक्टूबर 2026 को बताई गई।'],
 ['<td><span class="dsd-badge wait">अंतिम प्रमाणपत्र बाकी</span></td>', '<td><span class="dsd-badge ok">मंज़ूरी मिली (परिषद, 24 अक्टूबर 2026)</span></td>'],
 ['<td>11 अगस्त 2026 को आवेदन; सितंबर में हरी झंडी की ख़बर</td>', '<td>11 अगस्त 2026 को आवेदन; 24 अक्टूबर 2026 को अपर आवास आयुक्त ने मंज़ूरी की पुष्टि की; रेरा नंबर अभी सार्वजनिक नहीं</td>'],
 ['<td>रेरा मंज़ूरी के बाद खुलेगा</td>', '<td>दिवाली तक लॉन्च की तैयारी, तारीख तय नहीं</td>'],
 ['<li>रेरा का अंतिम प्रमाणपत्र अभी नहीं मिला — आवेदन 11 अगस्त 2026 को हुआ था</li>', '<li>रेरा मंज़ूरी अक्टूबर 2026 में मिली, पर रेरा नंबर अभी सार्वजनिक नहीं</li>'],
 ['रेरा मंज़ूरी अभी बाकी है, और अनुमानित दर', 'रेरा मंज़ूरी अक्टूबर 2026 में जाकर मिली है, और अनुमानित दर'],
 ['नहीं, अभी नहीं। 16 अक्टूबर 2026 तक upavp.in पर न कोई रजिस्ट्रेशन लिंक है, न ब्रोशर, न रेट लिस्ट।',
  'अभी नहीं। रेरा मंज़ूरी अक्टूबर 2026 में मिल गई है, लेकिन 24 अक्टूबर तक upavp.in पर न कोई रजिस्ट्रेशन लिंक है, न ब्रोशर, न रेट लिस्ट।'],
 ['रेरा का अंतिम प्रमाणपत्र मिलने के बाद ही सार्वजनिक रजिस्ट्रेशन खुलेगा।', 'अक्टूबर 2026 में परिषद ने दिवाली तक लॉन्च की तैयारी की बात कही है, लेकिन तारीख अभी तय नहीं है (हिन्दुस्तान, 24 अक्टूबर 2026)।'],
 ['अभी नहीं। UPAVP ने 11 अगस्त 2026 को यूपी रेरा में आवेदन किया था (दैनिक जागरण)। 17 सितंबर 2026 की न्यूज़ नेशन रिपोर्ट के अनुसार योजना को रेरा से हरी झंडी मिल चुकी है और सिर्फ़ अंतिम प्रमाणपत्र बाकी है, लेकिन 16 अक्टूबर 2026 तक मंज़ूरी पूरी नहीं हुई है। ब्रोशर आने पर उसमें से रेरा नंबर लेकर आवेदन से पहले खुद up-rera.in पर जाँचिए। जो आज आपसे कह रहा है कि यह योजना पहले से रेरा पंजीकृत है, वह गलत जानकारी दे रहा है।',
  'हाँ, परिषद के अनुसार। अपर आवास आयुक्त राकेश कुमार सिंह ने 24 अक्टूबर 2026 को हिन्दुस्तान को बताया कि यूपी रेरा ने योजना को मंज़ूरी दे दी है। UPAVP ने 11 अगस्त 2026 को आवेदन किया था (दैनिक जागरण)। रेरा पंजीकरण नंबर अभी सार्वजनिक नहीं है। ब्रोशर आने पर उसमें से रेरा नंबर लेकर आवेदन से पहले खुद up-rera.in पर जाँचिए।'],
 ['रेरा का अंतिम प्रमाणपत्र अभी बाकी है, रजिस्ट्रेशन खुला नहीं है', 'रेरा मंज़ूरी अभी अक्टूबर 2026 में मिली है और उसका नंबर सार्वजनिक नहीं है, रजिस्ट्रेशन खुला नहीं है'],
]
B = [dict(id=95, date='24 October 2026', new_box_title='🔴 Latest Update — 24 October 2026', li=EN_LI, replace=EN_REPL),
     dict(id=96, date='24 अक्टूबर 2026', new_box_title='🔴 ताज़ा अपडेट — 24 अक्टूबर 2026', li=HI_LI, replace=HI_REPL)]

json.dump(S, open('stories.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
json.dump(U, open('updates.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
json.dump(B, open('blog_updates.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
print(len(S), 'stories,', len(U), 'news updates,', len(B), 'blog updates')
