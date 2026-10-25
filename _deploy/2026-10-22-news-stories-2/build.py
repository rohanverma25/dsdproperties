# 22 Oct 2026 (second run): 1 new story (UP RERA Jan–Sep 2026 figures, AajTak) + an update box on the
# Bhaskar bribery-sting story (LDA inquiry committee, Amar Ujala). Officials named in the video are left out, as before.
import json
from helpers import *

AT = 'https://www.aajtak.in/business/real-estate/story/up-rera-217-real-estate-projects-noida-highest-project-cost-2026-ntc-rlch-rptc-2677454-2026-10-22'
AU = 'https://www.amarujala.com/lucknow/lucknow-news-lucknow-news-c-13-1-lko1069-1977515-2026-10-22'
BRIBE = 'vikas-pradhikaran-rishwat-rate-card-bhaskar-sting-seal-avaidh-nirman-october-2026'

def update_box(title, body):
    return ('<div style="background:#eff6ff;border:1px solid #bfdbfe;border-left:4px solid #2563eb;border-radius:0 12px 12px 0;padding:16px 20px;margin:24px 0;">'
            f'<p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>{body}</div>')

S = [dict(
 slug='up-rera-jan-sep-2026-217-projects-lucknow-59-sabse-zyada-october-2026',
 title='UP RERA: जनवरी–सितंबर 2026 में 217 प्रोजेक्ट रजिस्टर्ड, लखनऊ में सबसे ज़्यादा 59 प्रोजेक्ट और 15,959 यूनिट',
 summary='जनवरी से सितंबर 2026 के बीच यूपी रेरा में 217 रियल एस्टेट प्रोजेक्ट रजिस्टर्ड हुए, जिनमें 66,158 यूनिट और करीब ₹46,795 करोड़ की लागत प्रस्तावित है। प्रोजेक्ट की संख्या में लखनऊ सबसे आगे है: 59 प्रोजेक्ट, 15,959 यूनिट और ₹5,795.33 करोड़। यूनिट और लागत में गौतमबुद्ध नगर आगे है।',
 meta_description='UP RERA जनवरी–सितंबर 2026: 217 प्रोजेक्ट, 66,158 यूनिट, ₹46,795 करोड़। लखनऊ में सबसे ज़्यादा 59 प्रोजेक्ट, 15,959 यूनिट, ₹5,795.33 करोड़। खरीदने से पहले रेरा पर क्या जांचें।',
 category='rera', is_hot=1, source_name='आज तक', source_url=AT,
 full_content=dateline('22 अक्टूबर 2026') + facts([
   '<strong>जनवरी से सितंबर 2026</strong> के बीच यूपी रेरा में <strong>217 रियल एस्टेट प्रोजेक्ट</strong> रजिस्टर्ड हुए।',
   'इन प्रोजेक्ट में <strong>66,158 यूनिट</strong> बनाने की योजना है, और इनकी कुल अनुमानित लागत <strong>₹46,795 करोड़</strong> है।',
   'प्रोजेक्ट की संख्या में <strong>लखनऊ सबसे आगे</strong>: <strong>59 प्रोजेक्ट</strong>, <strong>15,959 यूनिट</strong> और <strong>₹5,795.33 करोड़</strong> की लागत।',
   'यूनिट और लागत में <strong>गौतमबुद्ध नगर</strong> आगे: 37 प्रोजेक्ट, 18,599 यूनिट और ₹21,221 करोड़ से ज़्यादा।']) +
 h2('आंकड़े एक नज़र में') +
 table(['', 'प्रोजेक्ट', 'यूनिट', 'लागत'], [
   ['<strong>पूरा उत्तर प्रदेश</strong>', '217', '66,158', '₹46,795 करोड़'],
   ['<strong>लखनऊ</strong>', '59', '15,959', '₹5,795.33 करोड़'],
   ['गौतमबुद्ध नगर (नोएडा)', '37', '18,599', '₹21,221 करोड़ से ज़्यादा']]) +
 p('आज तक की 22 अक्टूबर की रिपोर्ट के अनुसार ये आंकड़े जनवरी से सितंबर 2026 के बीच यूपी रेरा में हुए रजिस्ट्रेशन के हैं। लखनऊ में प्रोजेक्ट सबसे ज़्यादा हैं, लेकिन नोएडा के प्रोजेक्ट बड़े हैं, इसलिए यूनिट और लागत में वह आगे है। (' + link(AT, 'आज तक, 22 अक्टूबर 2026') + ')') +
 p('इससे पहले अक्टूबर की रेरा बैठक में लखनऊ के 12 प्रोजेक्ट मंज़ूर हुए थे: ' + site('news/up-rera-lucknow-12-projects-approved-october-2026', 'वह खबर') + '।') +
 h2('खरीदारों के लिए इसका मतलब') +
 ul(['<strong>लखनऊ में नए प्रोजेक्ट तेज़ी से आ रहे हैं,</strong> यानी चुनने के विकल्प ज़्यादा हैं और जल्दबाज़ी की ज़रूरत नहीं है। "आखिरी यूनिट बची है" जैसे दबाव में बुकिंग न करें।',
     '<strong>बुकिंग से पहले रेरा नंबर up-rera.in पर खुद जांचें:</strong> प्रमोटर का नाम, प्रोजेक्ट पूरा होने की तारीख, कोई एक्सटेंशन, और पिछली तिमाही की प्रगति रिपोर्ट (QPR)।',
     'जिस टावर या प्लॉट की बुकिंग कर रहे हैं, वह उसी रेरा रजिस्ट्रेशन में शामिल है या नहीं, यह भी देखें। बड़े प्रोजेक्ट अलग-अलग चरणों में अलग नंबर से रजिस्टर होते हैं।',
     'बड़े बिल्डरों के लखनऊ प्रोजेक्ट और उनके रेरा रिकॉर्ड: ' + site('blog/shalimar-corp-lucknow-projects-rera-guide-2026', 'शालीमार') + ' · ' + site('blog/shalimar-oneworld-lucknow-projects-price-possession-2026', 'शालीमार वनवर्ल्ड') + '।']) +
 VERIFY() + sources([link(AT, 'आज तक, 22 अक्टूबर 2026')]))]

U = [dict(slug=BRIBE,
  anchor=h2('भास्कर के अनुसार "रेट कार्ड"'),
  insert_before=update_box('अपडेट, 22 अक्टूबर: एलडीए ने वायरल वीडियो की जांच के लिए समिति बनाई',
    p('अवैध निर्माण के बदले लेन-देन के कथित मामले का वीडियो सोशल मीडिया पर वायरल होने के बाद एलडीए उपाध्यक्ष प्रथमेश कुमार ने जांच के आदेश दिए हैं। अपर सचिव ज्ञानेंद्र वर्मा की अध्यक्षता में समिति बनी है, जिसमें ओएसडी (आईटी) और एक अधिशासी अभियंता सदस्य हैं और लेखाधिकारी संयोजक हैं। समिति जांचेगी कि वीडियो सही है या नहीं, और <strong>एक सप्ताह में</strong> अपनी रिपोर्ट वीसी को सौंपेगी।') +
    p('वीडियो में दिख रहे अधिकारियों पर अभी सिर्फ आरोप हैं, इसलिए हम उनके नाम नहीं दे रहे। रिपोर्ट आने पर यह खबर अपडेट होगी। (' + link(AU, 'अमर उजाला, 22 अक्टूबर 2026') + ')')))]

json.dump(S, open('stories.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
json.dump(U, open('updates.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
print(len(S), 'stories,', len(U), 'updates')
