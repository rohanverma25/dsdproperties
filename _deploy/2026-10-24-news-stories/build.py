# 24 Oct 2026: 3 new stories + 7 update boxes on older stories + matching one-line updates in the blog guides.
# Sources were fetched directly (Google News links decoded to the publisher URL):
#   ETV Bharat 24 Oct (registration extended to 27 Oct, LDA VC quote), Dainik Bhaskar 24 Oct (same + OTS 1,567),
#   Amar Ujala 24 Oct (phase 2: 1,000 + 1,000 plots, Sharda Nagar 312 + 936 flats from 26 Oct, lottery ~3 Nov,
#   ~26,500 applications; SA Apartment demolition order), NBT 23 Oct (Prabandh Nagar resurvey),
#   Prabhat Khabar 24 Oct (Nagar Nigam mutation rules; LDA unsealing case + action on zone-3 staff).
# Amar Ujala's print story (written before the extension) said the 24 Oct deadline was unlikely to move; ETV and
# Bhaskar report the official 3-day extension, so the extension is used. Hindustan's headline gives the Sharda Nagar
# 2BHK as ₹35 lakh while Amar Ujala says about ₹30 lakh: both are shown, buyers told to check the LDA booklet.
# Names of the LDA officials in the unsealing / bribery case are left out, as in story 165.
import json
from helpers import *

ETV_EXT = 'https://www.etvbharat.com/hi/state/lucknow-lda-registration-period-extended-varun-vihar-naimish-nagar-schemes-ups26102400323'
BH_EXT  = 'https://www.bhaskar.com/local/uttar-pradesh/lucknow/news/lda-lucknow-varun-vihar-naimish-nagar-plot-registration-deadline-139468826.html'
AU_P2   = 'https://www.amarujala.com/lucknow/up-a-new-offering-from-the-lda-registration-for-2-000-plots-and-1-300-flats-to-begin-soon-find-out-what-the-2026-10-24'
LH_BAG  = 'https://www.livehindustan.com/uttar-pradesh/lucknow/story-lda-bagheswari-apartment-registration-starts-october-26-for-936-flats-and-312-pmay-homes-201792763484967.amp.html'
AU_SA   = 'https://www.amarujala.com/lucknow/order-issued-to-demolish-sa-apartment-in-golaganj-within-15-days-lucknow-news-c-13-lko1070-1978859-2026-10-24'
BH_OTS  = 'https://www.bhaskar.com/local/uttar-pradesh/lucknow/news/lda-ots-scheme-lucknow-map-penalty-waiver-application-deadline-139468847.html'
NBT_PN  = 'https://navbharattimes.indiatimes.com/state/uttar-pradesh/lucknow/prabandh-nagar-scheme-land-will-be-resurveyed-court-increased-compensation-rate-50-fold/articleshow/135134366.cms'
PK_MUT  = 'https://www.prabhatkhabar.com/state/uttar-pradesh/lucknow-property-mutation-new-rules-nagar-nigam-house-tax-transfer-document-verification/amp'

N1 = 'varun-vihar-naimish-nagar-panjikaran-27-october-tak-badha-2026'
N2 = 'lda-dusra-charan-2000-bhukhand-sharda-nagar-1248-flat-panjikaran-october-2026'
N3 = 'nagar-nigam-dakhil-kharij-namantaran-niyam-sakht-lucknow-october-2026'
CALC = site('lda-plot-calculator', 'LDA Plot Cost Calculator')
VV_HI, NN_HI = site('blog/varun-vihar-yojana-lucknow-hindi-2026', 'वरुण विहार योजना गाइड'), site('blog/naimish-nagar-yojana-lucknow-lda-plots-guide-2026-hindi', 'नैमिष नगर योजना गाइड')

def update_box(title, body):
    return ('<div style="background:#eff6ff;border:1px solid #bfdbfe;border-left:4px solid #2563eb;border-radius:0 12px 12px 0;padding:16px 20px;margin:24px 0;">'
            f'<p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>{body}</div>')

S = [
dict(created_at='2026-10-24 09:00:00',
 slug=N1,
 title='वरुण विहार और नैमिष नगर: पंजीकरण की आखिरी तारीख बढ़कर 27 अक्टूबर, बैंक अवकाश के कारण एलडीए ने दिए तीन दिन',
 summary='एलडीए ने वरुण विहार और नैमिष नगर योजनाओं के भूखंडों के पंजीकरण की आखिरी तारीख 24 से बढ़ाकर 27 अक्टूबर 2026 कर दी है। चौथे शनिवार और रविवार को बैंक बंद रहने से पंजीकरण राशि जमा करने में दिक्कत न हो, इसलिए यह फैसला लिया गया। अब तक करीब 26,500 लोग आवेदन कर चुके हैं और लॉटरी 3 नवंबर को होने की उम्मीद है।',
 meta_description='वरुण विहार नैमिष नगर पंजीकरण की आखिरी तारीख अब 27 अक्टूबर 2026। बैंक अवकाश के कारण एलडीए ने 3 दिन बढ़ाए। करीब 26,500 आवेदन, लॉटरी 3 नवंबर को संभावित।',
 category='lda', is_hot=1, source_name='ईटीवी भारत', source_url=ETV_EXT,
 full_content=dateline('24 अक्टूबर 2026') + facts([
   'वरुण विहार और नैमिष नगर योजनाओं में भूखंडों के पंजीकरण की आखिरी तारीख <strong>3 दिन बढ़ाकर 27 अक्टूबर 2026</strong> कर दी गई है।',
   'वजह: महीने के <strong>चौथे शनिवार और रविवार को बैंक बंद</strong> रहने से आवेदकों को पंजीकरण राशि जमा करने में दिक्कत हो सकती थी।',
   'पंजीकरण सिर्फ एलडीए की वेबसाइट <strong>registration.ldalucknow.in</strong> पर होगा। एकमुश्त भुगतान चुनने वालों को आवंटन में वरीयता मिलेगी।',
   'अमर उजाला के अनुसार अब तक दोनों योजनाओं में <strong>करीब 26,500 आवेदन</strong> आ चुके हैं और <strong>लॉटरी 3 नवंबर</strong> को होने की उम्मीद है।']) +
 h2('एलडीए ने क्या कहा') +
 p('एलडीए उपाध्यक्ष प्रथमेश कुमार ने बताया कि माह के चौथे शनिवार और रविवार को बैंकों में साप्ताहिक अवकाश के कारण आवेदकों को पंजीकरण धनराशि जमा करने में असुविधा हो सकती थी। इसलिए आखिरी तारीख 3 दिन बढ़ाकर 27 अक्टूबर की गई है, ताकि आवेदक ज़रूरी औपचारिकताएं पूरी कर सकें (ईटीवी भारत, दैनिक भास्कर, 24 अक्टूबर)।') +
 p('अमर उजाला के अनुसार केनरा बैंक और कुछ अन्य बैंकों से पंजीकरण शुल्क जमा करने वालों को दिक्कत आई थी, और एलडीए ने बैंकों से ये खामियां दूर करने को कहा है।') +
 h2('दोनों योजनाओं के पहले चरण में क्या है') +
 table(['योजना', 'कहां', 'भूखंड', 'साइज़', 'दर'], [
   ['नैमिष नगर (ब्रह्म खंड, भूमि खंड फेज-1 और 2)', 'सीतापुर रोड, करीब 4,100 एकड़', '1,673', '72 से 450 वर्ग मीटर', '₹3,800 प्रति वर्गफुट'],
   ['वरुण विहार (काशी खंड, कैलाश खंड फेज-1 और 2)', 'आगरा एक्सप्रेसवे के पास, करीब 6,580 एकड़', '2,847', '112.5 से 450 वर्ग मीटर', '₹2,800 प्रति वर्गफुट']]) +
 p('लॉटरी में नाम न आने वालों के लिए दोनों योजनाओं का दूसरा चरण भी आ रहा है: ' + site('news/' + N2, 'दूसरे चरण में 2,000 भूखंड की खबर') + '।') +
 h2('खरीदारों के लिए इसका मतलब') +
 ul(['जिनका पंजीकरण बैंक भुगतान में अटका था, उनके पास अब <strong>27 अक्टूबर</strong> तक का समय है। भुगतान की रसीद और आवेदन संख्या संभाल कर रखें।',
     'आवेदन सिर्फ <strong>registration.ldalucknow.in</strong> पर करें। किसी दूसरे लिंक या एजेंट के ज़रिये पैसा न भेजें।',
     'एकमुश्त भुगतान पर वरीयता है, इसलिए पहले अपना कुल ख़र्च जोड़ लें: ' + CALC + '।',
     'पूरी जानकारी: ' + VV_HI + ' · ' + NN_HI + '।']) +
 cta('लॉटरी में प्लॉट मिला? आगे क्या करें', 'आवंटन पत्र, भुगतान और फ्री-होल्ड की पूरी प्रक्रिया पर WhatsApp पर सलाह लें।', 'WhatsApp पर पूछें', 'नमस्ते, मुझे वरुण विहार/नैमिष नगर के पंजीकरण और लॉटरी के बारे में जानकारी चाहिए।') +
 sources([link(ETV_EXT, 'ईटीवी भारत, 24 अक्टूबर 2026'), link(BH_EXT, 'दैनिक भास्कर, 24 अक्टूबर 2026'), link(AU_P2, 'अमर उजाला, 24 अक्टूबर 2026')])),

dict(created_at='2026-10-24 08:00:00',
 slug=N2,
 title='एलडीए का दूसरा चरण: वरुण विहार और नैमिष नगर में 2,000 नए भूखंड नवंबर अंत तक, शारदानगर के 1,248 फ्लैटों का पंजीकरण 26 अक्टूबर से',
 summary='एलडीए नैमिष नगर और वरुण विहार के दूसरे चरण में एक-एक हज़ार भूखंडों का पंजीकरण नवंबर के अंत तक खोल सकता है; इसके लिए रेरा में आवेदन हो चुका है। दर पहले चरण जैसी ही रहेगी। शारदानगर योजना में वन बीएचके के 312 और टू बीएचके के 936 फ्लैटों का पंजीकरण 26 अक्टूबर से होगा। पहले चरण की लॉटरी में नाम न आने वालों से दूसरे चरण में ₹1,100 फॉर्म शुल्क नहीं लिया जाएगा।',
 meta_description='एलडीए दूसरा चरण 2026: नैमिष नगर (भार्गव खंड) और वरुण विहार में 1,000-1,000 भूखंड नवंबर अंत तक, रेरा में आवेदन। शारदानगर में 1,248 फ्लैट का पंजीकरण 26 अक्टूबर से।',
 category='projects', is_hot=1, source_name='अमर उजाला', source_url=AU_P2,
 full_content=dateline('24 अक्टूबर 2026') + facts([
   '<strong>नैमिष नगर और वरुण विहार के दूसरे चरण</strong> में <strong>एक-एक हज़ार भूखंडों</strong> का पंजीकरण खोलने के लिए एलडीए ने <strong>रेरा में आवेदन</strong> कर दिया है। मंज़ूरी मिलते ही <strong>नवंबर के अंत तक</strong> पंजीकरण खुल सकता है।',
   'नैमिष नगर के दूसरे चरण के 1,000 भूखंड <strong>भार्गव खंड</strong> में होंगे। साइज़ पहले चरण की तरह <strong>72 से 400 वर्ग मीटर</strong>।',
   'दर पहले चरण जैसी: <strong>नैमिष नगर ₹3,800</strong> और <strong>वरुण विहार ₹2,800 प्रति वर्गफुट</strong>।',
   '<strong>शारदानगर योजना</strong> में <strong>312 वन बीएचके</strong> (करीब ₹9 लाख) और <strong>936 टू बीएचके</strong> फ्लैटों का पंजीकरण <strong>26 अक्टूबर</strong> से।']) +
 h2('दूसरे चरण के भूखंड') +
 p('अमर उजाला की 24 अक्टूबर की रिपोर्ट के अनुसार एलडीए की योजना है कि विधानसभा चुनाव से पहले पंजीकरण खोलकर लॉटरी निकाल दी जाए, ताकि आचार संहिता के कारण आवेदन और लॉटरी में दिक्कत न आए। एलडीए उपाध्यक्ष प्रथमेश कुमार ने बताया कि दूसरे चरण के भूखंडों का आकार पहले चरण की तरह 72 से 400 वर्ग मीटर तक रहेगा।') +
 table(['योजना', 'दूसरे चरण के भूखंड', 'दर (प्रति वर्गफुट)', 'स्थिति'], [
   ['नैमिष नगर (सीतापुर रोड)', '1,000 (भार्गव खंड)', '₹3,800', 'रेरा में आवेदन, नवंबर अंत तक पंजीकरण संभावित'],
   ['वरुण विहार (आगरा एक्सप्रेसवे के पास)', '1,000', '₹2,800', 'रेरा में आवेदन, नवंबर अंत तक पंजीकरण संभावित']]) +
 h2('पहले चरण में नाम नहीं आया तो फॉर्म शुल्क माफ') +
 p('एलडीए उपाध्यक्ष के अनुसार नैमिष नगर और वरुण विहार में पहले चरण की लॉटरी में जिनका नाम नहीं आएगा, वे अगर दूसरे चरण में उसी योजना में आवेदन करते हैं तो उनसे <strong>₹1,100 पंजीकरण फॉर्म का पैसा नहीं लिया जाएगा</strong>। दोबारा आवेदन न करना चाहने वालों की पंजीकरण राशि वापस कर दी जाएगी; जो दोबारा आवेदन करेंगे उनकी राशि जमा रहेगी। पहले चरण की लॉटरी 3 नवंबर को होने की उम्मीद है, और पहले चरण की आखिरी तारीख अब ' + site('news/' + N1, '27 अक्टूबर') + ' है।') +
 h2('शारदानगर के 1,248 फ्लैट') +
 p('शारदानगर योजना में वन बीएचके के 312 और टू बीएचके के 936 फ्लैटों का ऑनलाइन पंजीकरण 26 अक्टूबर से registration.ldalucknow.in पर होगा। अमर उजाला के अनुसार वन बीएचके करीब ₹9 लाख और टू बीएचके करीब ₹30 लाख का होगा। हिन्दुस्तान की ' + link(LH_BAG, 'खबर') + ' की हेडलाइन में इसी बागेश्वरी अपार्टमेंट के टू बीएचके की कीमत ₹35 लाख बताई गई है, इसलिए <strong>अंतिम कीमत एलडीए की बुकलेट से ही पक्की करें</strong>।') +
 h2('खरीदारों के लिए इसका मतलब') +
 ul(['पहले चरण में आवेदन किया है तो लॉटरी के नतीजे तक पंजीकरण राशि वापस न मांगें, अगर दूसरे चरण में भी आवेदन करना है। राशि जमा रहने पर फॉर्म शुल्क नहीं देना होगा।',
     'दूसरे चरण की तारीख रेरा मंज़ूरी पर टिकी है। "पहले से बुकिंग" या "कोटा" के नाम पर पैसा मांगने वालों से बचें; पंजीकरण सिर्फ एलडीए की वेबसाइट पर होता है।',
     'फ्लैट लेना है तो पहले देख लें कि ₹9 लाख वाले वन बीएचके किस श्रेणी (आय सीमा) के लिए हैं। आय प्रमाण पत्र की शर्तें: ' + site('blog/lda-yojana-ews-lig-mig-aarakshan-aay-praman-patra-hindi-2026', 'EWS/LIG/MIG आरक्षण और आय प्रमाण पत्र गाइड') + '।',
     'भूखंड का कुल ख़र्च: ' + CALC + ' · ' + VV_HI + ' · ' + NN_HI + '।']) +
 VERIFY() +
 sources([link(AU_P2, 'अमर उजाला, 24 अक्टूबर 2026'), link(LH_BAG, 'हिन्दुस्तान, 23 अक्टूबर 2026 (हेडलाइन)')])),

dict(created_at='2026-10-24 07:00:00',
 slug=N3,
 title='लखनऊ नगर निगम में दाखिल-खारिज के नियम सख्त: गैर-पंजीकृत कागज़ या सिर्फ शपथपत्र पर नहीं होगा गृहकर नामांतरण, स्टांप शुल्क की भी जांच',
 summary='लखनऊ नगर निगम ने गृहकर नामांतरण (दाखिल-खारिज) की प्रक्रिया सख्त कर दी है। अब गैर-पंजीकृत बंटवारा पत्र, दानपत्र, अनुबंध या किरायानामा, या सिर्फ शपथपत्र के आधार पर नामांतरण नहीं होगा। दस्तावेज़ों पर स्टांप शुल्क पूरा जमा है या नहीं, इसकी जांच होगी, एक साल पुराने पंजीकृत दस्तावेज़ भी जांच के दायरे में होंगे। कमी मिलने पर नामांतरण रुक जाएगा।',
 meta_description='लखनऊ नगर निगम दाखिल-खारिज नए नियम 2026: गैर-पंजीकृत दस्तावेज़ या शपथपत्र पर गृहकर नामांतरण नहीं, स्टांप शुल्क की जांच, 1 साल पुराने दस्तावेज़ भी जांचे जाएंगे।',
 category='policy', is_hot=0, source_name='प्रभात खबर', source_url=PK_MUT,
 full_content=dateline('24 अक्टूबर 2026') + facts([
   'लखनऊ नगर निगम में <strong>गृहकर नामांतरण</strong> अब <strong>सिर्फ शपथपत्र</strong> या <strong>गैर-पंजीकृत दस्तावेज़ों</strong> के आधार पर नहीं होगा।',
   'गैर-पंजीकृत <strong>बंटवारा पत्र, दानपत्र, अनुबंध या किरायानामा</strong> पर नामांतरण नहीं किया जाएगा। एक साल से ज़्यादा के किराये/पट्टे का समझौता भी पंजीकृत होना ज़रूरी।',
   'दस्तावेज़ों पर <strong>स्टांप शुल्क पूरा जमा है या नहीं</strong>, इसकी जांच होगी। <strong>एक साल पुराने पंजीकृत दस्तावेज़</strong> भी जांच के दायरे में।',
   'कमी या गड़बड़ी मिलने पर <strong>नामांतरण रोक</strong> दिया जाएगा और मामला सक्षम अधिकारी के पास भेजा जाएगा।']) +
 h2('क्या बदला') +
 p('प्रभात खबर की 24 अक्टूबर की रिपोर्ट के अनुसार शासन के निर्देश पर नगर निगम के मुख्य कर निर्धारण अधिकारी विनय राय ने सभी जोनल अधिकारियों को निर्देश जारी किए हैं। अब तक कई मामलों में संपत्ति के मालिक बदलने के बाद शपथपत्र के आधार पर नामांतरण आगे बढ़ जाता था। अब मकान या दुकान की बिक्री, दान और बंटवारे के आधार पर नामांतरण से पहले उन दस्तावेज़ों का पंजीकरण जांचा जाएगा, और विलेखों पर लगे स्टांप की भी जांच होगी।') +
 p('<strong>ध्यान दें:</strong> यह नगर निगम के <strong>गृहकर रिकॉर्ड</strong> का नामांतरण है। खतौनी (राजस्व रिकॉर्ड) का दाखिल-खारिज तहसील में अलग प्रक्रिया से होता है: ' + site('blog/dakhil-kharij-lucknow-mutation-process-guide-hindi', 'दाखिल खारिज की पूरी गाइड') + '।') +
 h2('खरीदारों के लिए इसका मतलब') +
 ul(['मकान या दुकान <strong>सिर्फ एग्रीमेंट, पावर ऑफ अटॉर्नी या नोटरी कागज़</strong> पर ले रहे हैं, तो नगर निगम में आपके नाम नामांतरण नहीं होगा। पंजीकृत बैनामा ही करवाएं: ' + site('blog/bainama-vs-registry-vs-power-of-attorney-lucknow-2026', 'बैनामा, रजिस्ट्री और पावर ऑफ अटॉर्नी का फर्क') + '।',
     'रजिस्ट्री में <strong>स्टांप शुल्क सर्किल रेट से कम</strong> जमा हुआ है तो नामांतरण अटक सकता है। सर्किल रेट और स्टांप शुल्क पहले जांच लें: ' + site('lucknow-circle-rate', 'लखनऊ सर्किल रेट और स्टांप ड्यूटी कैलकुलेटर') + '।',
     'पारिवारिक बंटवारा या दानपत्र अपंजीकृत है तो पहले उसका पंजीकरण कराएं, उसके बाद नामांतरण के लिए आवेदन करें।',
     'पुरानी प्रॉपर्टी ख़रीदने से पहले पिछले बैनामों की चेन और उन पर लगा स्टांप ज़रूर जंचवाएं।']) +
 VERIFY() +
 sources([link(PK_MUT, 'प्रभात खबर, 24 अक्टूबर 2026')])),
]

# Update boxes, inserted before the h2 whose text is given (matched in insert.php)
U = [
 dict(id=146, before_h2='पूरी जानकारी',
      box=update_box('अपडेट, 24 अक्टूबर: पंजीकरण की आखिरी तारीख अब 27 अक्टूबर',
        p('बैंक अवकाश के कारण एलडीए ने पंजीकरण की आखिरी तारीख 3 दिन बढ़ाकर 27 अक्टूबर 2026 कर दी है। लॉटरी 3 नवंबर को होने की उम्मीद है। पूरी खबर: ' + site('news/' + N1, 'पंजीकरण 27 अक्टूबर तक') + '। (ईटीवी भारत, अमर उजाला, 24 अक्टूबर 2026)'))),
 dict(id=170, before_h2='खरीदारों के लिए इसका मतलब',
      box=update_box('अपडेट, 24 अक्टूबर: तारीख बढ़कर 27 अक्टूबर, करीब 26,500 आवेदन',
        p('एलडीए ने बैंक अवकाश के कारण पंजीकरण 27 अक्टूबर तक बढ़ा दिया है। अमर उजाला के अनुसार दोनों योजनाओं में करीब 26,500 आवेदन आ चुके हैं और लॉटरी 3 नवंबर को होने की उम्मीद है। दूसरे चरण में 1,000-1,000 नए भूखंड भी आ रहे हैं: ' + site('news/' + N2, 'दूसरे चरण की खबर') + '।'))),
 dict(id=151, before_h2='खरीदारों के लिए इसका मतलब',
      box=update_box('अपडेट, 24 अक्टूबर: दूसरे चरण के 1,000 भूखंड भार्गव खंड में, रेरा में आवेदन',
        p('अमर उजाला के अनुसार नैमिष नगर के दूसरे चरण में भार्गव खंड के 1,000 भूखंडों (72 से 400 वर्ग मीटर, ₹3,800 प्रति वर्गफुट) के लिए रेरा में आवेदन कर दिया गया है और मंज़ूरी मिलते ही नवंबर के अंत तक पंजीकरण खुल सकता है। पहले चरण में नाम न आने वालों से ₹1,100 फॉर्म शुल्क नहीं लिया जाएगा। पूरी खबर: ' + site('news/' + N2, 'दूसरा चरण') + '।'))),
 dict(id=154, before_h2='फ्लैट खरीदारों के लिए इसका मतलब',
      box=update_box('अपडेट, 23 अक्टूबर: 15 दिन में अपार्टमेंट गिराने का आदेश',
        p('अमर उजाला के अनुसार एलडीए की विहित प्राधिकारी कोर्ट ने शुक्रवार (23 अक्टूबर) को एसए अपार्टमेंट को ध्वस्त करने का आदेश जारी कर दिया। बिल्डर को 15 दिन में इमारत खुद गिरानी होगी, नहीं तो एलडीए गिराएगा। जांच में सामने आया कि नक्शा तीन मंज़िल का पास था, जबकि छह मंज़िल बनाई गई। बिल्डर और आवंटियों का मरम्मत का प्रस्ताव एलडीए ने ठुकरा दिया।') +
        p('<strong>फ्लैट मालिकों के लिए:</strong> एलडीए उन्हें विस्थापित नहीं मानेगा, इसलिए प्राधिकरण से कोई आवास या फ्लैट नहीं मिलेगा। फ्लैट मालिक बिल्डर से ही इसकी मांग कर सकते हैं। (' + link(AU_SA, 'अमर उजाला, 24 अक्टूबर 2026') + ')'))),
 dict(id=155, before_h2='खरीदारों के लिए इसका मतलब',
      box=update_box('अपडेट, 23 अक्टूबर: योजना की ज़मीन का दोबारा सर्वे होगा',
        p('नवभारत टाइम्स के अनुसार एलडीए प्रबंध नगर योजना की ज़मीन का ड्रोन और भौतिक सर्वे दोबारा कराएगा, जिसमें अतिक्रमण, पेड़, जल स्रोत और विवादमुक्त गाटों की पहचान होगी। योजना करीब 2,000 एकड़ (840.892 हेक्टेयर) की है, जिसमें घैला, ककौली और अल्लूनगर डिगुरिया गांवों की करीब 3,350 बीघा ज़मीन आनी है। लारा कोर्ट ने मुआवज़ा ₹1,10,71,000 प्रति बीघा तय किया है। सर्वे और कमेटी की रिपोर्ट के बाद प्रस्ताव एलडीए बोर्ड में जाएगा। कुछ गाटों के मामले हाईकोर्ट में लंबित हैं। (' + link(NBT_PN, 'नवभारत टाइम्स, 23 अक्टूबर 2026') + ')'))),
 dict(id=156, before_h2='आवंटियों और खरीदारों के लिए इसका मतलब',
      box=update_box('अपडेट, 23 अक्टूबर: 1,567 आवेदन, नक्शा और शमन के बकाये भी शामिल',
        p('दैनिक भास्कर के अनुसार शुक्रवार शाम 6 बजे तक ओटीएस के तहत 1,567 आवेदन आ चुके थे। इस बार मानचित्र और शमन मानचित्र के बकायेदार भी शामिल हैं: जिन्होंने मानचित्र शुल्क की किस्तें समय पर नहीं दीं, उन्हें भी दंड ब्याज से राहत मिलेगी। आवेदन का निस्तारण 3 महीने में होगा। ₹50 लाख से ज़्यादा बकाये पर 30 दिन में एक-तिहाई रकम और बाकी 6 महीने में तीन द्विमासिक किस्तों में जमा की जा सकेगी। एलडीए में हेल्प डेस्क बनाई गई है। (' + link(BH_OTS, 'दैनिक भास्कर, 24 अक्टूबर 2026') + ')'))),
 dict(id=165, before_h2='खरीदारों के लिए इसका मतलब',
      box=update_box('अपडेट, 24 अक्टूबर: एक आदेश की आड़ में दो इमारतों की सील खुली, विहित प्राधिकारी को नोटिस',
        p('प्रभात खबर के अनुसार दुबग्गा की एक अवैध इमारत की सील कंपाउंडिंग के बाद खोलने के आदेश की आड़ में अमीनाबाद की एक दुकान की सील खोलने का आदेश भी जारी कर दिया गया। एलडीए उपाध्यक्ष ने विहित प्राधिकारी को कारण बताओ नोटिस दिया और दुबग्गा की इमारत दोबारा सील करने को कहा। अवैध निर्माण के बदले वसूली के आरोप में प्रवर्तन ज़ोन-3 के ज़ोनल अधिकारी और एक अवर अभियंता पर कार्रवाई हुई है और ज़ोन-3 का काम ज़ोन-2 को दिया गया है। (' + link(PK_MUT, 'प्रभात खबर, 24 अक्टूबर 2026') + ')'))),
]

# One-line updates for the related blog guides (applied by _deploy/news-blog-sync/push_blog_updates.php).
# Old bullets inside the box are a dated record and are never edited; the "replace" pairs fix the deadline
# everywhere else in the post (title, meta, summary, FAQ schema, stat bar, intro, FAQ).
A = lambda url, t: f'<a href="{url}" style="color:#008080;font-weight:600;" target="_blank" rel="noopener">{t}</a>'
OWN = lambda slug, t: f'<a href="https://dsdproperties.in/news/{slug}" style="color:#008080;font-weight:600;">{t}</a>'
EN_REPL = [['Register by 24 Oct', 'Register by 27 Oct'], ['registration till 24 Oct', 'registration till 27 Oct'],
           ['until 24 October 2026', 'until 27 October 2026'], ['from 24 September to 24 October 2026', 'from 24 September to 27 October 2026'],
           ['is open until 24 October.', 'is open until 27 October (extended from 24 October).'],
           ['>24 Oct<', '>27 Oct<'], ['till 24 Oct 2026', 'till 27 Oct 2026'],
           ['24 October 2026 — last date for registration', '27 October 2026 — last date for registration (extended from 24 October)'],
           ['The last date is 24 October 2026.', 'The last date is 27 October 2026 (extended from 24 October).'],
           ['<strong>24 October 2026</strong> — last date for registration', '<strong>27 October 2026</strong> — last date for registration (extended from 24 October)']]
HI_REPL = [['पंजीकरण 24 अक्टूबर तक', 'पंजीकरण 27 अक्टूबर तक'], ['24 सितंबर से 24 अक्टूबर 2026 तक', '24 सितंबर से 27 अक्टूबर 2026 तक'],
           ['पंजीकरण 24 अक्टूबर 2026 तक', 'पंजीकरण 27 अक्टूबर 2026 तक'], ['>24 अक्टूबर<', '>27 अक्टूबर<'],
           ['24 अक्टूबर 2026 तक खुला है', '27 अक्टूबर 2026 तक खुला है'],
           ['दोनों का पंजीकरण 24 अक्टूबर तक है।', 'दोनों का पंजीकरण 27 अक्टूबर तक है (पहले 24 अक्टूबर तक था)।'],
           ['24 अक्टूबर 2026 — पंजीकरण की आखिरी तारीख', '27 अक्टूबर 2026 — पंजीकरण की आखिरी तारीख (पहले 24 अक्टूबर थी)'],
           ['पंजीकरण की आखिरी तारीख 24 अक्टूबर 2026 है।', 'पंजीकरण की आखिरी तारीख 27 अक्टूबर 2026 है (पहले 24 अक्टूबर थी)।'],
           ['<strong>24 सितंबर से 24 अक्टूबर 2026</strong>', '<strong>24 सितंबर से 27 अक्टूबर 2026</strong>'], ['<strong>24 अक्टूबर 2026 तक</strong>', '<strong>27 अक्टूबर 2026 तक</strong>'],
           ['<strong>24 अक्टूबर 2026</strong> — पंजीकरण की आखिरी तारीख', '<strong>27 अक्टूबर 2026</strong> — पंजीकरण की आखिरी तारीख (पहले 24 अक्टूबर थी)']]
EN_LI = ('<strong>24 October 2026:</strong> LDA extended registration by 3 days to <strong>27 October 2026</strong>, because banks were shut on the weekend. '
         'About 26,500 people have applied for both schemes; the lottery is expected on 3 November. Phase 2 (1,000 more plots each in Varun Vihar and Naimish Nagar) '
         'is waiting for RERA approval and may open by end-November at the same rate. (' + A(ETV_EXT, 'ETV Bharat') + ', ' + A(AU_P2, 'Amar Ujala') + ')')
HI_LI = ('<strong>24 अक्टूबर 2026:</strong> बैंक अवकाश के कारण एलडीए ने पंजीकरण 3 दिन बढ़ाकर <strong>27 अक्टूबर 2026</strong> तक कर दिया। दोनों योजनाओं में करीब 26,500 आवेदन, '
         'लॉटरी 3 नवंबर को संभावित। दूसरे चरण में 1,000-1,000 नए भूखंड रेरा मंज़ूरी के बाद नवंबर अंत तक इसी दर पर आ सकते हैं। (' + A(ETV_EXT, 'ईटीवी भारत') + ', ' + A(AU_P2, 'अमर उजाला') + ' · ' + OWN(N1, 'पूरी खबर') + ')')
B = [
 dict(id=91,  date='24 October 2026',  li=EN_LI, replace=EN_REPL),
 dict(id=105, date='24 October 2026',  li=EN_LI, replace=EN_REPL),
 dict(id=92,  date='24 अक्टूबर 2026', li=HI_LI, replace=HI_REPL),
 dict(id=106, date='24 अक्टूबर 2026', li=HI_LI, replace=HI_REPL),
 dict(id=119, date='24 अक्टूबर 2026',
      li='<strong>24 अक्टूबर 2026 (नगर निगम):</strong> लखनऊ नगर निगम में गृहकर नामांतरण अब सिर्फ शपथपत्र या गैर-पंजीकृत बंटवारा पत्र, दानपत्र, अनुबंध या किरायानामा पर नहीं होगा; दस्तावेज़ों पर स्टांप शुल्क की जांच होगी और कमी मिलने पर नामांतरण रुकेगा। (' + A(PK_MUT, 'प्रभात खबर') + ' · ' + OWN(N3, 'पूरी खबर') + ')'),
 dict(id=116, date='24 October 2026', new_box_title='🔴 Latest Update — 24 October 2026',
      li='<strong>24 October 2026 (Nagar Nigam house-tax mutation):</strong> Lucknow Nagar Nigam will no longer mutate house-tax records on an affidavit or on unregistered partition deeds, gift deeds, agreements or rent deeds. Stamp duty on the documents will be checked, including registered documents a year old, and mutation will be stopped if duty is short. This is separate from the tehsil (khatauni) dakhil kharij described below. (' + A(PK_MUT, 'Prabhat Khabar') + ')'),
]

for s in S: assert s['category'] in ('lda', 'it-city', 'price', 'projects', 'policy', 'rera')
json.dump(S, open('stories.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
json.dump(U, open('updates.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
json.dump(B, open('blog_updates.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
print(len(S), 'stories,', len(U), 'news updates,', len(B), 'blog updates')
