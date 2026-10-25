@extends('layouts.user-app')

{{--
    Stamp duty calculator for Lucknow, English (/tools/stamp-duty-calculator-lucknow) and Hindi
    (/tools/stamp-duty-calculator-lucknow-hindi, route passes $lang = 'hi'). Rebuilt 25 Oct 2026.
    - Circle-rate value comes from the DM lists in resources/data/circle-rates/*.json (all SROs, searched together),
      or the buyer types it in. Valuation and duty come from partials/circle-rate-engine (window.CRC), the same
      engine as /lucknow-circle-rate, so both pages always agree.
    - Rates checked against the official IGRSUP e-calculator on 25 Oct 2026 (see the engine's header).
    - The whole calculator sits inside #stamp-calc, so partials/ga4 sends calculator_use on first use and tracks
      the wa.me buttons itself (no manual events here, to avoid double counting).
--}}
@php
    $lang = ($lang ?? 'en') === 'hi' ? 'hi' : 'en';
    $hi = $lang === 'hi';
    $enUrl = url('/tools/stamp-duty-calculator-lucknow');
    $hiUrl = url('/tools/stamp-duty-calculator-lucknow-hindi');
    $pageUrl = $hi ? $hiUrl : $enUrl;

    // All SRO lists, trimmed to what the calculator needs
    $files = glob(resource_path('data/circle-rates/*.json'));
    $srcs = array_map(fn ($f) => json_decode(file_get_contents($f), true), $files);
    usort($srcs, fn ($a, $b) => strcmp($a['sro_code'], $b['sro_code']));
    $road = fn ($x) => array_filter(['segment' => $x['segment'], 'segment_en' => $x['segment_en'] ?? null, 'plot' => $x['plot'],
        'shop' => $x['shop'], 'office' => $x['office'], 'godown' => $x['godown']], fn ($v) => $v !== null);
    $lists = []; $rows = [];
    foreach ($srcs as $i => $l) {
        $lists[] = ['sro' => $l['sro'], 'sro_hi' => $l['sro_hi'], 'slug' => $l['slug'],
            'construction_3floor' => $l['construction_3floor'], 'general_roads' => array_map($road, $l['general_roads'] ?? [])];
        foreach ($l['rows'] as $r) {
            $rows[] = ['id' => count($rows), 'list' => $i, 'en' => $r['en'], 'hi' => $r['hi'], 'plot' => $r['plot'], 'flat' => $r['flat'],
                'commercial' => $r['commercial'] ?? null, 'roads' => array_map($road, $r['roads']), 'note' => $r['note'] ?? null,
                'amended' => $r['amended'] ?? null];
        }
    }
    $sroNames = implode(', ', array_map(fn ($l) => $hi ? $l['sro_hi'] : $l['sro'], $lists));
    $wa = '918595002933';
    $sampleUrl = 'https://dsdproperties.in/public/downloads/DSD-Property-Verification-Sample-Report-Lucknow.pdf';

    $T = $hi ? [
        'title' => 'स्टांप ड्यूटी कैलकुलेटर लखनऊ 2026: सर्किल रेट के साथ रजिस्ट्री खर्च निकालें',
        'desc' => 'लखनऊ में रजिस्ट्री का खर्च निकालें: अपना मोहल्ला चुनें, सर्किल रेट से न्यूनतम मूल्य अपने आप आएगा। पुरुष 7%, महिला 6% (₹1 करोड़ तक), रजिस्ट्री शुल्क 1%। IGRSUP से मिलाकर जांचा गया।',
        'h1' => 'स्टांप ड्यूटी और रजिस्ट्री शुल्क कैलकुलेटर — लखनऊ',
        'lead' => 'अपना मोहल्ला चुनें, प्रॉपर्टी का साइज़ डालें। सर्किल रेट (डीएम रेट) से न्यूनतम मूल्य अपने आप निकलेगा, और स्टांप ड्यूटी उसी पर या सौदे की कीमत पर लगेगी, जो ज़्यादा हो।',
        'tags' => ['पुरुष 7%', 'महिला 6% (₹1 करोड़ तक)', 'रजिस्ट्री शुल्क 1%', 'मोहल्ला-वार सर्किल रेट'],
        'checked' => 'दरें 25 अक्टूबर 2026 को IGRSUP के आधिकारिक ई-कैलकुलेटर से मिलाकर जांची गईं।',
        'buyer' => 'ख़रीदार कौन है?', 'man' => 'पुरुष', 'woman' => 'महिला', 'joint' => 'पुरुष + महिला (संयुक्त)',
        'deal' => 'सौदे की कीमत (बैनामे में लिखी रकम)', 'deal_help' => 'जितने में आप ख़रीद रहे हैं। खाली छोड़ सकते हैं।',
        'cv' => 'सर्किल रेट से न्यूनतम मूल्य', 'find' => 'मोहल्ले से निकालें', 'know' => 'मूल्य मुझे पता है',
        'search' => 'अपना मोहल्ला खोजें', 'search_ph' => 'जैसे: इन्दिरा नगर, आलमबाग, गोमती नगर',
        'search_help' => 'अभी इन उप निबंधक कार्यालयों (SRO) के मोहल्ले हैं: ' . $sroNames . '। बाकी जल्द जुड़ेंगे।',
        'none' => 'यह मोहल्ला अभी हमारी सूची में नहीं है। "मूल्य मुझे पता है" चुनकर मूल्य डालें, या WhatsApp पर पूछें।',
        'type' => 'प्रॉपर्टी', 'plot' => 'प्लॉट', 'flat' => 'फ़्लैट', 'house' => 'मकान', 'shop' => 'दुकान / ऑफ़िस',
        'road' => 'सामने की सड़क', 'area' => ['plot' => 'प्लॉट का क्षेत्रफल', 'flat' => 'फ़्लैट का कवर्ड एरिया', 'house' => 'ज़मीन का क्षेत्रफल', 'shop' => 'कारपेट एरिया'],
        'units' => ['sqm' => 'वर्ग मीटर', 'sqft' => 'वर्ग फुट', 'gaj' => 'गज'],
        'fcat' => 'फ़्लैट की श्रेणी', 'ordinary' => 'साधारण', 'premium' => 'प्रीमियम',
        'premium_help' => 'प्रीमियम = स्विमिंग पूल, क्लब, जिम में से कोई दो हों, या मुख्य सड़क पर हो।',
        'floor' => 'मंज़िल', 'floors' => ['0' => 'भूतल से तीसरी मंज़िल', '5' => 'चौथी से छठी (−5%)', '10' => 'सातवीं या ऊपर (−10%)', 'pent' => 'पेंटहाउस (कोई छूट नहीं)'],
        'built' => 'कुल निर्मित (कवर्ड) एरिया, सभी मंज़िलें', 'ctype' => 'छत का प्रकार',
        'ctypes' => ['rcc' => 'आरसीसी', 'rbc' => 'आरबीसी', 'kadi' => 'कड़ी / गर्डर-पटिया / डाट', 'tin' => 'टिन / एस्बेस्टस शेड', 'kachcha' => 'कच्चा / छप्पर / खपरैल'],
        'class' => 'फ़िनिश', 'c1' => 'प्रथम श्रेणी', 'c2' => 'द्वितीय श्रेणी', 'age' => 'मकान कितने साल पुराना है',
        'use' => 'उपयोग', 'uses' => ['shop' => 'दुकान', 'office' => 'ऑफ़िस', 'godown' => 'गोदाम'],
        'sfloors' => ['100' => 'भूतल / अपर या लोअर ग्राउंड', '90' => 'बेसमेंट या पहली मंज़िल (90%)', '80' => 'दूसरी से चौथी (80%)', '70' => 'पांचवीं या ऊपर (70%)'],
        'ac' => 'एसी, या शॉपिंग कॉम्प्लेक्स / मॉल में (+20%, मंज़िल की छूट नहीं)',
        'park' => 'पार्क के सामने (+10%)', 'corner' => 'एक से ज़्यादा सड़कों पर (+10%)',
        'manual' => 'सर्किल रेट के हिसाब से मूल्य (₹)', 'manual_help' => 'IGRSUP या सब-रजिस्ट्रार से मिला मूल्य।',
        'total' => 'सरकार को कुल भुगतान', 'enter' => 'मूल्य डालें →', 'stamp' => 'स्टांप ड्यूटी', 'reg' => 'रजिस्ट्री शुल्क',
        'basis' => 'किस मूल्य पर लगेगा', 'basis_help' => 'सर्किल रेट मूल्य और सौदे की कीमत में से ज़्यादा',
        'rate' => 'दर', 'saving' => 'महिला के नाम पर रजिस्ट्री से बचत', 'cvbox' => 'सर्किल रेट मूल्य कैसे निकला',
        'cvtotal' => 'सर्किल रेट मूल्य', 'on_deal' => 'सौदे की कीमत ज़्यादा है, इसलिए ड्यूटी उसी पर', 'on_cv' => 'सर्किल रेट मूल्य ज़्यादा है, इसलिए ड्यूटी उसी पर',
        'cap' => 'महिला ख़रीदार की 1% छूट सिर्फ़ ₹1 करोड़ तक के मूल्य पर है। इससे ऊपर पूरे मूल्य पर 7% लगेगा।',
        'jointnote' => 'IGRSUP के कैलकुलेटर में संयुक्त ख़रीदार का विकल्प नहीं है। हमने सुरक्षित तौर पर 7% जोड़ा है। कुछ कार्यालय पुरुष + महिला संयुक्त बैनामे पर 6.5% लेते हैं (तब स्टांप ड्यूटी %s होगी)। अपने सब-रजिस्ट्रार से पक्का करें।',
        'devfee' => 'IGRSUP की रसीद में स्टांप ड्यूटी का 2% "विकास शुल्क" के रूप में अलग दिखता है; कुल रकम यही रहती है।',
        'final' => 'यह अनुमान डीएम की मूल्यांकन सूची के नियमों पर है। अंतिम गणना सब-रजिस्ट्रार / IGRSUP पोर्टल की होगी।',
        'cta_v' => 'रजिस्ट्री से पहले काग़ज़ जंचवाएं (₹5,000)', 'cta_w' => 'WhatsApp पर पूछें', 'sample' => 'नमूना रिपोर्ट देखें →',
        'ratesh' => 'लखनऊ में स्टांप ड्यूटी की दरें (बैनामा)', 'who' => 'ख़रीदार', 'sd' => 'स्टांप ड्यूटी', 'rf' => 'रजिस्ट्री शुल्क',
        'r_man' => '7%', 'r_woman' => '6% (मूल्य ₹1 करोड़ तक) · 7% (₹1 करोड़ से ऊपर)', 'r_joint' => '7% (कुछ कार्यालय 6.5% लेते हैं)', 'r_reg' => '1%, कोई ऊपरी सीमा नहीं',
        'ex_h' => 'उदाहरण', 'faq_h' => 'अक्सर पूछे जाने वाले सवाल',
        'more' => 'मोहल्ले-वार पूरी सर्किल रेट सूची', 'more2' => 'स्टांप ड्यूटी और रजिस्ट्री की पूरी गाइड',
        'switch' => 'Read in English', 'verify_h' => 'स्टांप ड्यूटी भरने से पहले यह भी जांच लें',
        'verify_p' => 'सर्किल रेट सिर्फ़ न्यूनतम मूल्य बताता है, यह नहीं कि बेचने वाला सच में मालिक है। हम खतौनी, रजिस्ट्री की चेन, भार-मुक्त प्रमाणपत्र, कोर्ट केस और एलडीए/जिला पंचायत की मंज़ूरी जांच कर 48 घंटे में रिपोर्ट देते हैं — ₹5,000।',
        'see' => 'देखें हम क्या जांचते हैं',
    ] : [
        'title' => 'Stamp Duty Calculator Lucknow 2026: Registry Cost with Mohalla Circle Rate',
        'desc' => 'Work out stamp duty and registry charges in Lucknow. Pick your mohalla and the DM circle-rate value fills in itself. Men 7%, women 6% up to ₹1 crore, registration 1%. Checked against IGRSUP.',
        'h1' => 'Stamp Duty & Registry Calculator — Lucknow',
        'lead' => 'Pick your mohalla and enter the size. The circle-rate (DM rate) minimum value fills in by itself, and stamp duty is charged on that or on your sale price, whichever is higher.',
        'tags' => ['Men 7%', 'Women 6% (up to ₹1 crore)', 'Registration 1%', 'Mohalla-wise circle rate'],
        'checked' => 'Rates checked against the official IGRSUP e-calculator on 25 October 2026.',
        'buyer' => 'Who is buying?', 'man' => 'Man', 'woman' => 'Woman', 'joint' => 'Man + woman (joint)',
        'deal' => 'Sale price (amount in the sale deed)', 'deal_help' => 'What you are paying. You can leave it empty.',
        'cv' => 'Circle-rate (minimum) value', 'find' => 'Find from my mohalla', 'know' => 'I know the value',
        'search' => 'Search your mohalla', 'search_ph' => 'e.g. Indira Nagar, Alambagh, Gomti Nagar',
        'search_help' => 'Covers the mohallas of these sub-registrar offices (SROs) for now: ' . $sroNames . '. More are being added.',
        'none' => 'This mohalla is not in our list yet. Choose "I know the value" and type it in, or ask us on WhatsApp.',
        'type' => 'Property', 'plot' => 'Plot', 'flat' => 'Flat', 'house' => 'House', 'shop' => 'Shop / office',
        'road' => 'Road in front of the property', 'area' => ['plot' => 'Plot area', 'flat' => 'Covered area of the flat', 'house' => 'Land (plot) area', 'shop' => 'Carpet area'],
        'units' => ['sqm' => 'sq m', 'sqft' => 'sq ft', 'gaj' => 'gaj (sq yd)'],
        'fcat' => 'Flat category', 'ordinary' => 'Ordinary', 'premium' => 'Premium',
        'premium_help' => 'Premium = the complex has any two of pool, club, gym, or it is on a main road segment.',
        'floor' => 'Floor', 'floors' => ['0' => 'Ground to 3rd floor', '5' => '4th to 6th floor (−5%)', '10' => '7th floor and above (−10%)', 'pent' => 'Penthouse (no rebate)'],
        'built' => 'Covered (built-up) area, all floors', 'ctype' => 'Construction (roof type)',
        'ctypes' => ['rcc' => 'RCC', 'rbc' => 'RBC', 'kadi' => 'Kadi / girder-patiya / dat', 'tin' => 'Tin / asbestos / fibre shed', 'kachcha' => 'Kachcha / chhappar / khaprail'],
        'class' => 'Finish', 'c1' => 'First class', 'c2' => 'Second class', 'age' => 'Age of the building (years)',
        'use' => 'Use', 'uses' => ['shop' => 'Shop', 'office' => 'Office', 'godown' => 'Godown'],
        'sfloors' => ['100' => 'Ground / upper or lower ground', '90' => 'Basement or 1st floor (90%)', '80' => '2nd to 4th floor (80%)', '70' => '5th floor and above (70%)'],
        'ac' => 'Air-conditioned, or in a shopping complex / mall (+20%, no floor rebate)',
        'park' => 'Park facing (+10%)', 'corner' => 'Road on more than one side (+10%)',
        'manual' => 'Circle-rate value (₹)', 'manual_help' => 'The value from IGRSUP or the sub-registrar office.',
        'total' => 'Total government charges', 'enter' => 'Enter a value →', 'stamp' => 'Stamp duty', 'reg' => 'Registration fee',
        'basis' => 'Charged on', 'basis_help' => 'The higher of circle-rate value and sale price',
        'rate' => 'Rate', 'saving' => 'Saved by registering in a woman’s name', 'cvbox' => 'How the circle-rate value was worked out',
        'cvtotal' => 'Circle-rate value', 'on_deal' => 'Sale price is higher, so duty is on the sale price', 'on_cv' => 'Circle-rate value is higher, so duty is on that',
        'cap' => 'The woman buyer’s 1% concession applies only when the value is up to ₹1 crore. Above that, 7% is charged on the full value.',
        'jointnote' => 'The IGRSUP calculator has no joint-buyer option, so we use 7% to be safe. Some offices charge 6.5% on a man + woman joint deed (stamp duty would then be %s). Confirm with your sub-registrar.',
        'devfee' => 'IGRSUP’s receipt shows 2% of the stamp duty separately as a “development fee”; the total stays the same.',
        'final' => 'This estimate follows the rules in the DM valuation list. The sub-registrar’s calculation on the IGRSUP portal is final.',
        'cta_v' => 'Get the papers checked first (₹5,000)', 'cta_w' => 'Ask us on WhatsApp', 'sample' => 'See a sample report →',
        'ratesh' => 'Stamp duty rates in Lucknow (sale deed)', 'who' => 'Buyer', 'sd' => 'Stamp duty', 'rf' => 'Registration fee',
        'r_man' => '7%', 'r_woman' => '6% (value up to ₹1 crore) · 7% (above ₹1 crore)', 'r_joint' => '7% (some offices charge 6.5%)', 'r_reg' => '1%, no upper limit',
        'ex_h' => 'Worked examples', 'faq_h' => 'Frequently asked questions',
        'more' => 'Full mohalla-wise circle rate list', 'more2' => 'Complete stamp duty & registration guide',
        'switch' => 'हिंदी में पढ़ें', 'verify_h' => 'Before you pay stamp duty, check the papers too',
        'verify_p' => 'The circle rate tells you the minimum value, not whether the seller really owns the property. We check the khatauni, the chain of sale deeds, the encumbrance certificate, court cases and the LDA / zila panchayat approval, and send a report in 48 hours for ₹5,000.',
        'see' => 'See what we check',
    ];
    // Worked examples (computed with the same rates as the engine)
    $ex = [[5000000, 'm'], [5000000, 'f'], [12000000, 'f'], [8000000, 'j']];
    $exRows = array_map(function ($e) { [$v, $b] = $e; $r = ($b === 'f' && $v <= 10000000) ? 0.06 : 0.07;
        return [$v, $b, $r, $v * $r, $v * 0.01]; }, $ex);
    $inr = fn ($n) => '₹' . preg_replace('/(\d)(?=(\d\d)+\d$)/', '$1,', (string) round($n));
    $faqs = $hi ? [
        ['लखनऊ में 2026 में स्टांप ड्यूटी कितनी है?', 'बैनामे पर पुरुष ख़रीदार को 7% स्टांप ड्यूटी और 1% रजिस्ट्री शुल्क देना होता है। महिला ख़रीदार को ₹1 करोड़ तक के मूल्य पर 6% स्टांप ड्यूटी देनी होती है। हमने ये दरें 25 अक्टूबर 2026 को IGRSUP के आधिकारिक ई-कैलकुलेटर से मिलाकर जांचीं।'],
        ['क्या यूपी में महिलाओं को स्टांप ड्यूटी में छूट मिलती है?', 'हाँ, 1% की छूट, लेकिन सिर्फ़ तब जब प्रॉपर्टी का मूल्य ₹1 करोड़ तक हो। ₹1 करोड़ से ऊपर पूरे मूल्य पर 7% लगता है, यानी कोई छूट नहीं। 22 जुलाई 2025 को यूपी कैबिनेट ने यह सीमा ₹10 लाख से बढ़ाकर ₹1 करोड़ की थी।'],
        ['पति-पत्नी संयुक्त नाम से ख़रीदें तो कितनी स्टांप ड्यूटी लगेगी?', 'IGRSUP के ई-कैलकुलेटर में संयुक्त ख़रीदार का अलग विकल्प नहीं है, इसलिए हम सुरक्षित तौर पर 7% जोड़ते हैं। कुछ सब-रजिस्ट्रार कार्यालय पुरुष + महिला संयुक्त बैनामे पर 6.5% लेते हैं। रजिस्ट्री से पहले अपने कार्यालय से पक्का करें।'],
        ['स्टांप ड्यूटी सौदे की कीमत पर लगती है या सर्किल रेट पर?', 'दोनों में से जो ज़्यादा हो। अगर आपने सर्किल रेट से कम कीमत पर सौदा किया है, तब भी ड्यूटी सर्किल रेट के मूल्य पर ही लगेगी।'],
        ['लखनऊ में रजिस्ट्री शुल्क कितना है? क्या कोई अधिकतम सीमा है?', 'रजिस्ट्री शुल्क मूल्य का 1% है। IGRSUP के कैलकुलेटर में ₹2 करोड़ पर ₹2,00,000 आता है, यानी कोई ऊपरी सीमा नहीं है।'],
        ['अपनी प्रॉपर्टी का सर्किल रेट कैसे पता करें?', 'इस कैलकुलेटर में अपना मोहल्ला खोजें, सड़क की चौड़ाई और क्षेत्रफल डालें। मूल्य डीएम लखनऊ की मूल्यांकन सूची (01.08.2025 से लागू) से निकलता है। अभी ' . $sroNames . ' के मोहल्ले शामिल हैं।'],
        ['IGRSUP पर "विकास शुल्क" अलग क्यों दिखता है?', 'IGRSUP की गणना में स्टांप ड्यूटी का 2% विकास शुल्क के रूप में अलग दिखता है, जैसे ₹50 लाख पर पुरुष के लिए ₹3,43,000 + ₹7,000। कुल रकम फिर भी 7% (₹3,50,000) ही रहती है।'],
    ] : [
        ['How much is stamp duty in Lucknow in 2026?', 'On a sale deed, a man pays 7% stamp duty plus a 1% registration fee. A woman buyer pays 6% stamp duty when the value is up to ₹1 crore. We checked these rates against the official IGRSUP e-calculator on 25 October 2026.'],
        ['Do women pay less stamp duty in Uttar Pradesh?', 'Yes, 1% less, but only when the property value is up to ₹1 crore. Above ₹1 crore, 7% is charged on the full value, so there is no concession. The UP Cabinet raised this limit from ₹10 lakh to ₹1 crore on 22 July 2025.'],
        ['What is the stamp duty if a husband and wife buy jointly?', 'The IGRSUP e-calculator has no separate joint-buyer option, so we use 7% to be safe. Some sub-registrar offices charge 6.5% on a man + woman joint deed. Confirm with your office before the registry.'],
        ['Is stamp duty charged on the sale price or the circle rate?', 'On whichever is higher. Even if you agree a price below the circle rate, duty is charged on the circle-rate value.'],
        ['What is the registration fee in Lucknow, and is there a maximum?', 'The registration fee is 1% of the value. On ₹2 crore the IGRSUP calculator gives ₹2,00,000, so there is no upper limit.'],
        ['How do I find the circle rate of my property?', 'Search your mohalla in this calculator and enter the road width and area. The value comes from the DM Lucknow valuation list in force from 01.08.2025. It covers the mohallas of ' . $sroNames . ' for now.'],
        ['Why does IGRSUP show a separate "development fee"?', 'IGRSUP shows 2% of the stamp duty separately as a development fee, e.g. ₹3,43,000 + ₹7,000 for a man buying at ₹50 lakh. The total is still 7% (₹3,50,000).'],
    ];
@endphp

@section('title', $T['title'])
@section('meta_description', $T['desc'])
@section('meta_keywords', $hi ? 'स्टांप ड्यूटी कैलकुलेटर लखनऊ, रजिस्ट्री खर्च लखनऊ, स्टांप ड्यूटी यूपी 2026, महिला स्टांप ड्यूटी छूट, सर्किल रेट लखनऊ, stamp duty calculator lucknow hindi' : 'stamp duty calculator lucknow, lucknow stamp duty 2026, registry charges lucknow, stamp duty for women up, circle rate stamp duty calculator, up stamp duty calculator')
@section('canonical', $pageUrl)

@push('head')
<link rel="alternate" hreflang="en-IN" href="{{ $enUrl }}">
<link rel="alternate" hreflang="hi-IN" href="{{ $hiUrl }}">
<link rel="alternate" hreflang="x-default" href="{{ $enUrl }}">
<script type="application/ld+json">
{!! json_encode(['@context' => 'https://schema.org', '@graph' => [
    ['@type' => 'WebApplication', 'name' => $T['h1'], 'url' => $pageUrl, 'applicationCategory' => 'FinanceApplication',
     'operatingSystem' => 'Any', 'inLanguage' => $hi ? 'hi-IN' : 'en-IN', 'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'INR'],
     'provider' => ['@type' => 'Organization', 'name' => 'DSD Properties', 'url' => 'https://dsdproperties.in']],
    ['@type' => 'FAQPage', 'mainEntity' => array_map(fn ($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]], $faqs)],
]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<style>
.sd{--n:#011f4b;--t:#008080;--o:#FF5C00;--g:#64748b;--line:#e2e8f0;--soft:#f6f8fb;background:#f7fafc;color:#1f2937;overflow-x:hidden}
.sd-hero{background:linear-gradient(135deg,#011f4b 0%,#013970 55%,#006d73 100%);color:#fff;padding:36px 0 64px}
.sd-shell{max-width:1120px;margin:0 auto;padding:0 16px}
.sd-top{display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center}
.sd-pill{display:inline-flex;align-items:center;gap:7px;padding:6px 13px;border-radius:999px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);font-size:12px;font-weight:700}
.sd-pill i{width:7px;height:7px;border-radius:9px;background:#4ade80}
.sd-lang{color:#fff;font-size:13px;font-weight:700;text-decoration:underline}
.sd-hero h1{margin:14px 0 10px;font-size:clamp(1.6rem,5vw,2.6rem);line-height:1.15;font-weight:800;max-width:760px;text-wrap:balance}
.sd-hero p{margin:0;max-width:680px;color:rgba(255,255,255,.82);font-size:15px;line-height:1.75}
.sd-tags{display:flex;flex-wrap:wrap;gap:7px;margin-top:14px}
.sd-tags span{padding:5px 11px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.14);font-size:12px}
.sd-main{margin-top:-40px;padding-bottom:40px}
.sd-grid{display:grid;grid-template-columns:minmax(0,1.1fr) minmax(0,.9fr);gap:18px;align-items:start}
@media(max-width:860px){.sd-grid{grid-template-columns:1fr}}
.sd-card{background:#fff;border:1px solid var(--line);border-radius:20px;box-shadow:0 14px 40px rgba(1,31,75,.07);padding:20px}
@media(min-width:768px){.sd-card{padding:24px}}
@media(min-width:861px){.sd-sticky{position:sticky;top:88px}}
.sd-label{display:block;font-size:12px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--g);margin:0 0 7px}
.sd-field{margin-bottom:16px}
.sd-hint{font-size:12.5px;color:var(--g);margin:6px 2px 0;line-height:1.6}
.sd select,.sd .num{width:100%;box-sizing:border-box;padding:12px 14px;border:1.5px solid var(--line);border-radius:11px;background:var(--soft);font:inherit;font-size:16px;color:var(--n);font-weight:600}
.sd .big-in{font-size:20px;font-weight:800}
.sd select:focus,.sd .num:focus{outline:none;border-color:var(--t);background:#fff}
.sd-two{display:grid;grid-template-columns:1.4fr 1fr;gap:10px}
.sd-seg{display:flex;gap:6px;flex-wrap:wrap}
.sd-seg button{flex:1;min-width:0;padding:10px 8px;border:1.5px solid var(--line);border-radius:10px;background:#fff;font:inherit;font-size:13.5px;font-weight:600;color:#334155;cursor:pointer}
.sd-seg button.on{border-color:var(--t);background:#effaf9;color:var(--n)}
.sd-chk{display:flex;gap:10px;align-items:flex-start;font-size:14px;color:#334155;margin:8px 0;cursor:pointer;line-height:1.45}
.sd-chk input{margin-top:3px;width:17px;height:17px;accent-color:var(--t)}
.sd-sec{border-top:1px dashed var(--line);padding-top:16px;margin-top:4px}
.sd-search{position:relative}
.sd-list{position:absolute;left:0;right:0;top:100%;z-index:20;background:#fff;border:1px solid var(--line);border-radius:12px;box-shadow:0 12px 30px rgba(1,31,75,.12);max-height:300px;overflow:auto;margin-top:4px}
.sd-list button{display:block;width:100%;text-align:left;padding:10px 14px;border:0;border-bottom:1px solid #f1f5f9;background:#fff;font:inherit;font-size:14px;color:var(--n);cursor:pointer}
.sd-list button:hover,.sd-list button:focus{background:#effaf9}
.sd-list small{color:var(--g)}
.sd-picked{margin-top:8px;padding:10px 12px;border-radius:10px;background:#effaf9;border:1px solid #b2dfdb;font-size:13.5px;color:#134e4a}
.sd-empty{margin-top:8px;padding:10px 12px;border-radius:10px;background:#fff7ed;border:1px solid #fed7aa;font-size:13px;color:#7c2d12;line-height:1.6}
.sd-note{margin-top:8px;padding:10px 12px;border-radius:10px;background:#fef9c3;border:1px solid #fde68a;font-size:12.5px;color:#713f12;line-height:1.5}
.sd-result{background:linear-gradient(135deg,#011f4b,#035e6b);color:#fff;border-radius:16px;padding:20px 22px;margin-bottom:14px}
.sd-result small{font-size:12px;letter-spacing:.06em;text-transform:uppercase;opacity:.8}
.sd-result .big{font-size:clamp(1.9rem,6vw,2.6rem);font-weight:800;line-height:1.1;margin:4px 0 6px;font-variant-numeric:tabular-nums}
.sd-result p{margin:0;font-size:13.5px;opacity:.9}
.sd-row{display:flex;justify-content:space-between;gap:12px;padding:9px 0;border-bottom:1px dashed var(--line);font-size:14px}
.sd-row span:last-child{font-weight:700;color:var(--n);font-variant-numeric:tabular-nums;white-space:nowrap}
.sd-row.tot{border-top:2px solid var(--n);border-bottom:0;margin-top:4px;padding-top:12px;font-size:15.5px}
.sd-row.tot span:last-child{color:var(--o)}
.sd-row.save span:last-child{color:var(--t)}
.sd-sub{font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--t);margin:14px 0 2px}
.sd-how{font-size:12.5px;color:var(--g);line-height:1.6;margin:10px 0 0}
.sd-cta{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:14px}
@media(max-width:560px){.sd-cta{grid-template-columns:1fr}}
.sd-cta a{display:flex;align-items:center;justify-content:center;padding:13px;border-radius:12px;font-weight:700;font-size:14.5px;text-decoration:none;text-align:center}
.sd-cta .vf{background:var(--o);color:#fff}.sd-cta .wa{background:#25D366;color:#fff}
.sd-sample{display:block;text-align:center;margin-top:8px;font-size:14px;color:var(--t);font-weight:700}
.sd-info h2{font-size:clamp(1.25rem,3vw,1.5rem);font-weight:800;color:var(--n);margin:32px 0 10px}
.sd-tw{overflow-x:auto;-webkit-overflow-scrolling:touch;border-radius:14px}
.sd-tbl{width:100%;min-width:520px;border-collapse:collapse;font-size:14px;background:#fff;border:1px solid var(--line);border-radius:14px;overflow:hidden}
.sd-tbl th{background:var(--n);color:#fff;text-align:left;padding:10px 12px;font-weight:700}
.sd-tbl td{padding:10px 12px;border-bottom:1px solid var(--line);vertical-align:top}
.sd-tbl td.r,.sd-tbl th.r{text-align:right;white-space:nowrap;font-variant-numeric:tabular-nums}
.sd-src{font-size:12.5px;color:var(--g);margin:8px 0 0}
.sd-faq details{border:1px solid var(--line);border-radius:12px;padding:12px 16px;margin-bottom:10px;background:#fff}
.sd-faq summary{cursor:pointer;font-weight:700;color:var(--n);font-size:15px}
.sd-faq p{margin:8px 0 2px;font-size:14px;line-height:1.7;color:#475569}
.sd-links{display:flex;flex-wrap:wrap;gap:10px;margin-top:14px}
.sd-links a{padding:10px 14px;border:1.5px solid var(--t);border-radius:10px;color:var(--t);font-weight:700;font-size:14px;text-decoration:none}
.sd-verify{margin-top:30px;background:#fff7ed;border:1px solid #fed7aa;border-radius:18px;padding:20px 22px}
.sd-verify h2{margin:0 0 6px}
.sd-verify p{margin:0 0 12px;font-size:14.5px;line-height:1.7;color:#7c2d12}
</style>
@endpush

@section('content')
<div class="sd" lang="{{ $hi ? 'hi' : 'en' }}">
  <section class="sd-hero">
    <div class="sd-shell">
      <div class="sd-top">
        <span class="sd-pill"><i></i> {{ $hi ? 'बैनामा · लखनऊ, उत्तर प्रदेश' : 'Sale deed · Lucknow, Uttar Pradesh' }}</span>
        <a class="sd-lang" href="{{ $hi ? $enUrl : $hiUrl }}" hreflang="{{ $hi ? 'en' : 'hi' }}">{{ $T['switch'] }}</a>
      </div>
      <h1>{{ $T['h1'] }}</h1>
      <p>{{ $T['lead'] }}</p>
      <div class="sd-tags">@foreach($T['tags'] as $tg)<span>✓ {{ $tg }}</span>@endforeach</div>
    </div>
  </section>

  <section class="sd-shell sd-main">
    <div class="sd-grid" id="stamp-calc">
      {{-- INPUTS --}}
      <div class="sd-card">
        <div class="sd-field">
          <span class="sd-label">{{ $T['buyer'] }}</span>
          <div class="sd-seg" id="s-buyer">
            <button type="button" class="on" data-v="m">{{ $T['man'] }}</button>
            <button type="button" data-v="f">{{ $T['woman'] }}</button>
            <button type="button" data-v="j">{{ $T['joint'] }}</button>
          </div>
        </div>
        <div class="sd-field">
          <label class="sd-label" for="s-deal">{{ $T['deal'] }}</label>
          <input id="s-deal" class="num big-in" type="text" inputmode="numeric" autocomplete="off" placeholder="₹ 45,00,000">
          <p class="sd-hint">{{ $T['deal_help'] }}</p>
        </div>

        <div class="sd-sec">
          <span class="sd-label">{{ $T['cv'] }}</span>
          <div class="sd-seg" id="s-mode" style="margin-bottom:14px">
            <button type="button" class="on" data-v="find">{{ $T['find'] }}</button>
            <button type="button" data-v="know">{{ $T['know'] }}</button>
          </div>

          <div id="g-know" hidden>
            <div class="sd-field">
              <label class="sd-label" for="s-manual">{{ $T['manual'] }}</label>
              <input id="s-manual" class="num big-in" type="text" inputmode="numeric" autocomplete="off" placeholder="₹ 47,50,000">
              <p class="sd-hint">{{ $T['manual_help'] }}</p>
            </div>
          </div>

          <div id="g-find">
            <div class="sd-field sd-search">
              <label class="sd-label" for="s-q">{{ $T['search'] }}</label>
              <input id="s-q" class="num" type="search" autocomplete="off" placeholder="{{ $T['search_ph'] }}">
              <div class="sd-list" id="s-list" hidden></div>
              <div class="sd-picked" id="s-picked" hidden></div>
              <div class="sd-empty" id="s-none" hidden>{{ $T['none'] }}</div>
              <p class="sd-hint">{{ $T['search_help'] }}</p>
            </div>
            <div id="g-prop" hidden>
              <div class="sd-field">
                <span class="sd-label">{{ $T['type'] }}</span>
                <div class="sd-seg" id="s-type">
                  <button type="button" class="on" data-v="plot">{{ $T['plot'] }}</button>
                  <button type="button" data-v="flat">{{ $T['flat'] }}</button>
                  <button type="button" data-v="house">{{ $T['house'] }}</button>
                  <button type="button" data-v="shop">{{ $T['shop'] }}</button>
                </div>
              </div>
              <div class="sd-field">
                <label class="sd-label" for="s-road">{{ $T['road'] }}</label>
                <select id="s-road"></select>
              </div>
              <div class="sd-field">
                <label class="sd-label" for="s-area" id="s-area-l">{{ $T['area']['plot'] }}</label>
                <div class="sd-two">
                  <input id="s-area" class="num" type="number" inputmode="decimal" min="0" step="any" value="100">
                  <select id="s-unit">@foreach($T['units'] as $k => $u)<option value="{{ $k }}">{{ $u }}</option>@endforeach</select>
                </div>
              </div>
              <div id="g-flat" hidden>
                <div class="sd-field">
                  <span class="sd-label">{{ $T['fcat'] }}</span>
                  <div class="sd-seg" id="s-fcat"><button type="button" class="on" data-v="ordinary">{{ $T['ordinary'] }}</button><button type="button" data-v="premium">{{ $T['premium'] }}</button></div>
                  <p class="sd-hint">{{ $T['premium_help'] }}</p>
                </div>
                <div class="sd-field">
                  <label class="sd-label" for="s-floor">{{ $T['floor'] }}</label>
                  <select id="s-floor">@foreach($T['floors'] as $k => $u)<option value="{{ $k }}">{{ $u }}</option>@endforeach</select>
                </div>
              </div>
              <div id="g-house" hidden>
                <div class="sd-field">
                  <label class="sd-label" for="s-built">{{ $T['built'] }}</label>
                  <input id="s-built" class="num" type="number" inputmode="decimal" min="0" step="any" value="100">
                </div>
                <div class="sd-field">
                  <label class="sd-label" for="s-ctype">{{ $T['ctype'] }}</label>
                  <select id="s-ctype">@foreach($T['ctypes'] as $k => $u)<option value="{{ $k }}">{{ $u }}</option>@endforeach</select>
                </div>
                <div class="sd-field">
                  <span class="sd-label">{{ $T['class'] }}</span>
                  <div class="sd-seg" id="s-class"><button type="button" class="on" data-v="0">{{ $T['c1'] }}</button><button type="button" data-v="1">{{ $T['c2'] }}</button></div>
                </div>
                <div class="sd-field">
                  <label class="sd-label" for="s-age">{{ $T['age'] }}</label>
                  <input id="s-age" class="num" type="number" inputmode="numeric" min="0" step="1" value="5">
                </div>
              </div>
              <div id="g-shop" hidden>
                <div class="sd-field">
                  <span class="sd-label">{{ $T['use'] }}</span>
                  <div class="sd-seg" id="s-use">@foreach($T['uses'] as $k => $u)<button type="button" data-v="{{ $k }}" @class(['on' => $loop->first])>{{ $u }}</button>@endforeach</div>
                </div>
                <div class="sd-field">
                  <label class="sd-label" for="s-sfloor">{{ $T['floor'] }}</label>
                  <select id="s-sfloor">@foreach($T['sfloors'] as $k => $u)<option value="{{ $k }}">{{ $u }}</option>@endforeach</select>
                </div>
                <label class="sd-chk"><input type="checkbox" id="s-ac"> {{ $T['ac'] }}</label>
              </div>
              <div id="g-extra">
                <label class="sd-chk"><input type="checkbox" id="s-park"> {{ $T['park'] }}</label>
                <label class="sd-chk"><input type="checkbox" id="s-corner"> {{ $T['corner'] }}</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- RESULT --}}
      <div class="sd-card sd-sticky">
        <div class="sd-result">
          <small>{{ $T['total'] }}</small>
          <div class="big" id="r-total">{{ $T['enter'] }}</div>
          <p id="r-line"></p>
        </div>
        <div id="r-rows"></div>
        <div id="r-cv" hidden><div class="sd-sub">{{ $T['cvbox'] }}</div><div id="r-cvrows"></div></div>
        <div class="sd-note" id="r-note" hidden></div>
        <p class="sd-how">{{ $T['devfee'] }} {{ $T['final'] }}</p>
        <div class="sd-cta">
          <a class="vf" id="r-verify" href="{{ url('/services/property-verification-lucknow') }}">{{ $T['cta_v'] }}</a>
          <a class="wa" id="r-wa" href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">{{ $T['cta_w'] }}</a>
        </div>
        <a class="sd-sample" href="{{ $sampleUrl }}" target="_blank" rel="noopener">{{ $T['sample'] }}</a>
      </div>
    </div>

    {{-- INFO --}}
    <div class="sd-info">
      <h2>{{ $T['ratesh'] }}</h2>
      <div class="sd-tw"><table class="sd-tbl">
        <thead><tr><th>{{ $T['who'] }}</th><th>{{ $T['sd'] }}</th><th>{{ $T['rf'] }}</th></tr></thead>
        <tbody>
          <tr><td>{{ $T['man'] }}</td><td><strong>{{ $T['r_man'] }}</strong></td><td rowspan="3" style="vertical-align:middle"><strong>{{ $T['r_reg'] }}</strong></td></tr>
          <tr><td>{{ $T['woman'] }}</td><td><strong>{{ $T['r_woman'] }}</strong></td></tr>
          <tr><td>{{ $T['joint'] }}</td><td><strong>{{ $T['r_joint'] }}</strong></td></tr>
        </tbody>
      </table></div>
      <p class="sd-src">{{ $T['checked'] }} <a href="https://igrsup.gov.in/igrsup/stampFeesCalculator.action" target="_blank" rel="noopener">IGRSUP e-calculator ↗</a></p>

      <h2>{{ $T['ex_h'] }}</h2>
      <div class="sd-tw"><table class="sd-tbl">
        <thead><tr><th>{{ $T['basis'] }}</th><th>{{ $T['who'] }}</th><th class="r">{{ $T['sd'] }}</th><th class="r">{{ $T['rf'] }}</th><th class="r">{{ $T['total'] }}</th></tr></thead>
        <tbody>
          @foreach($exRows as [$v, $b, $r, $s, $g])
            <tr><td>{{ $inr($v) }}</td><td>{{ ['m' => $T['man'], 'f' => $T['woman'], 'j' => $T['joint']][$b] }}</td><td class="r">{{ $inr($s) }} ({{ $r * 100 }}%)</td><td class="r">{{ $inr($g) }}</td><td class="r"><strong>{{ $inr($s + $g) }}</strong></td></tr>
          @endforeach
        </tbody>
      </table></div>

      <h2>{{ $T['faq_h'] }}</h2>
      <div class="sd-faq">
        @foreach($faqs as $f)<details><summary>{{ $f[0] }}</summary><p>{{ $f[1] }}</p></details>@endforeach
      </div>
      <div class="sd-links">
        <a href="{{ url('/lucknow-circle-rate') }}">{{ $T['more'] }} →</a>
        <a href="{{ url('/blog/stamp-duty-registration-charges-lucknow-2026') }}">{{ $T['more2'] }} →</a>
      </div>

      <div class="sd-verify">
        <h2>{{ $T['verify_h'] }}</h2>
        <p>{{ $T['verify_p'] }}</p>
        <div class="sd-cta" style="margin-top:0">
          <a class="vf" href="{{ url('/services/property-verification-lucknow') }}">{{ $T['see'] }}</a>
        </div>
        <a class="sd-sample" href="{{ $sampleUrl }}" target="_blank" rel="noopener">{{ $T['sample'] }}</a>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
@include('partials.circle-rate-engine')
<script>
(function () {
    var DATA = @json(['lists' => $lists, 'rows' => $rows]);
    var T = @json($T), HI = {{ $hi ? 'true' : 'false' }}, WA = '{{ $wa }}';
    var ROWS = DATA.rows, LISTS = DATA.lists;
    var $ = function (id) { return document.getElementById(id); };
    function inr(n) { return Math.round(n).toLocaleString('en-IN'); }
    function money(n) {
        if (n >= 1e7) return '₹' + (n / 1e7).toFixed(2) + (HI ? ' करोड़' : ' Cr');
        if (n >= 1e5) return '₹' + (n / 1e5).toFixed(2) + (HI ? ' लाख' : ' L');
        return '₹' + inr(n);
    }
    function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
    function norm(s) { return String(s).toLowerCase().replace(/[\s.()\-]/g, '').replace(/ड़/g, 'ड').replace(/ँ|ं/g, 'ं'); }
    function pick(id) { var b = document.querySelector('#' + id + ' button.on'); return b ? b.getAttribute('data-v') : null; }
    function digits(el) { var d = (el.value || '').replace(/\D/g, ''); return d ? +d : 0; }
    function fmtInput(el) { var n = digits(el); el.value = n ? n.toLocaleString('en-IN') : ''; }
    var U = T.units, SQ = HI ? ' वर्ग मीटर' : ' sq m';
    function sqmTxt(v) { return (Math.round(v * 100) / 100).toLocaleString('en-IN') + SQ; }
    function sroName(r) { var l = LISTS[r.list]; return HI ? l.sro_hi : l.sro; }

    // ── Mohalla search across all SROs ──
    var q = $('s-q'), list = $('s-list'), picked = null;
    function search() {
        var s = norm(q.value);
        $('s-none').hidden = true;
        if (s.length < 2) { list.hidden = true; return; }
        var hits = ROWS.map(function (r) {
            var e = norm(r.en), h = norm(r.hi);
            return [(e.indexOf(s) === 0 || h.indexOf(s) === 0) ? 2 : (e.indexOf(s) > -1 || h.indexOf(s) > -1) ? 1 : 0, r];
        }).filter(function (x) { return x[0]; }).sort(function (a, b) { return b[0] - a[0] || a[1].en.localeCompare(b[1].en); }).slice(0, 30);
        if (!hits.length) { list.hidden = true; $('s-none').hidden = false; return; }
        list.innerHTML = hits.map(function (x) { var r = x[1];
            return '<button type="button" data-id="' + r.id + '">' + esc(HI ? r.hi : r.en) + ' · ' + esc(HI ? r.en : r.hi) + ' <small>(' + esc(sroName(r)) + ')</small></button>'; }).join('');
        list.hidden = false;
    }
    function choose(id) {
        picked = ROWS[id]; list.hidden = true; q.value = HI ? picked.hi : picked.en;
        $('s-picked').hidden = false;
        $('s-picked').innerHTML = '<strong>' + esc(picked.en) + ' · ' + esc(picked.hi) + '</strong> — SRO ' + esc(sroName(picked)) +
            (picked.amended ? '<div class="sd-note">' + (HI ? 'इस जगह की दरें डीएम लखनऊ के आदेश 1952 (दिनांक 04.06.2026) से बदली गई हैं; यहां नई दरें हैं।' : 'Rates here were revised by DM Lucknow order 1952 dated 04.06.2026; the revised rates are used.') + '</div>' : '') +
            (picked.note ? '<div class="sd-note">' + esc(picked.note) + '</div>' : '');
        $('g-prop').hidden = false; fillRoads(); calc();
    }
    q.addEventListener('input', search);
    q.addEventListener('focus', search);
    list.addEventListener('click', function (e) { var b = e.target.closest('button[data-id]'); if (b) choose(+b.getAttribute('data-id')); });
    document.addEventListener('click', function (e) { if (!e.target.closest('.sd-search')) list.hidden = true; });

    var WID = HI ? { lt9: '9 मीटर से कम चौड़ी', '9_12': '9 से 12 मीटर', '12_18': '12 से 18 मीटर', gt18: '18 मीटर से ज़्यादा' }
                 : { lt9: 'Under 9 m wide', '9_12': '9 to 12 m', '12_18': '12 to 18 m', gt18: 'Above 18 m' };
    function fillRoads() {
        var road = $('s-road'), prev = road.value, all = CRC.roads(picked, LISTS[picked.list]), per = HI ? '/वर्ग मीटर' : '/sq m';
        var opt = function (x, t) { return '<option value="' + x.v + '">' + t + ' (₹' + inr(x.rate) + per + ')</option>'; };
        var gen = all.filter(function (x) { return x.kind === 'gen'; });
        road.innerHTML = all.filter(function (x) { return x.kind === 'width'; }).map(function (x) { return opt(x, WID[x.v]); }).join('') +
            all.filter(function (x) { return x.kind === 'seg'; }).map(function (x) { return opt(x, (HI ? 'मुख्य सड़क पर: ' : 'On main road: ') + esc(x.name)); }).join('') +
            (gen.length ? '<optgroup label="' + (HI ? 'मुख्य सड़कें (सभी मोहल्लों के लिए एक दर)' : 'Main roads with one rate for all mohallas') + '">' + gen.map(function (x) { return opt(x, esc(x.name)); }).join('') + '</optgroup>' : '');
        if ([].some.call(road.options, function (o) { return o.value === prev; })) road.value = prev;
    }

    function lineTxt(l) {
        var x = ' × ₹';
        switch (l.k) {
            case 'land': return [(HI ? 'ज़मीन: ' : 'Land: ') + sqmTxt(l.area) + x + inr(l.rate) + (l.pct ? ' (+' + l.pct + '%)' : ''), money(l.amount)];
            case 'bump': return [(HI ? 'पार्क के सामने / एक से ज़्यादा सड़क' : 'Park facing / more than one road') + ' (+' + l.pct + '%)', money(l.amount)];
            case 'flat_build': return [(HI ? 'निर्माण: ' : 'Construction: ') + sqmTxt(l.area) + x + inr(l.rate) + ' (' + (l.cat === 'premium' ? T.premium : T.ordinary) + ')', money(l.amount)];
            case 'flat_land': return [(HI ? 'ज़मीन का हिस्सा: 30% = ' : 'Land share: 30% = ') + sqmTxt(l.area) + x + inr(l.rate), money(l.amount)];
            case 'floor_rebate': return [(HI ? 'मंज़िल की छूट' : 'Floor rebate') + ' (−' + l.pct + '%)', '−' + money(l.amount)];
            case 'house_build': return [(HI ? 'निर्माण: ' : 'Building: ') + sqmTxt(l.area) + x + inr(l.rate), money(l.amount)];
            case 'depreciation': return [(HI ? 'मूल्य ह्रास (' + l.age + ' / ' + l.life + ' साल)' : 'Depreciation (' + l.age + ' of ' + l.life + ' years)'), '−' + money(l.amount)];
            case 'carpet': return [(HI ? 'कारपेट: ' : 'Carpet: ') + sqmTxt(l.area) + x + inr(l.rate) + ' (' + T.uses[l.use] + (l.seg ? (HI ? ', मुख्य सड़क' : ', main road') : '') + ')', money(l.amount)];
            case 'shop_floor': return [(HI ? 'मंज़िल (' : 'Floor (') + l.pct + '%)', '−' + money(l.amount)];
            case 'ac': return [(HI ? 'एसी / शॉपिंग कॉम्प्लेक्स (+20%)' : 'AC / shopping complex (+20%)'), money(l.amount)];
        }
    }
    function row(l) { return '<div class="sd-row' + (l[2] ? ' ' + l[2] : '') + '"><span>' + l[0] + '</span><span>' + l[1] + '</span></div>'; }

    function calc() {
        var mode = pick('s-mode'), type = pick('s-type'), buyer = pick('s-buyer');
        $('g-find').hidden = mode !== 'find'; $('g-know').hidden = mode !== 'know';
        $('g-flat').hidden = type !== 'flat'; $('g-house').hidden = type !== 'house'; $('g-shop').hidden = type !== 'shop';
        $('g-extra').hidden = !(type === 'plot' || type === 'house');
        $('s-area-l').textContent = T.area[type];

        var deal = digits($('s-deal')), cv = 0, res = null, unit = $('s-unit').value;
        if (mode === 'know') cv = digits($('s-manual'));
        else if (picked) {
            res = CRC.value({
                type: type, row: picked, list: LISTS[picked.list], road: $('s-road').value,
                area: CRC.toSqm(parseFloat($('s-area').value) || 0, unit),
                park: $('s-park').checked, corner: $('s-corner').checked, fcat: pick('s-fcat'), floor: $('s-floor').value,
                built: CRC.toSqm(parseFloat($('s-built').value) || 0, unit), ctype: $('s-ctype').value, cls: +pick('s-class'),
                age: parseInt($('s-age').value, 10) || 0, use: pick('s-use'), sfloor: $('s-sfloor').value, ac: $('s-ac').checked
            });
            cv = res.value;
        }
        var basis = Math.max(cv, deal);
        $('r-cv').hidden = !res;
        if (!basis) {
            $('r-total').textContent = T.enter; $('r-line').textContent = ''; $('r-rows').innerHTML = ''; $('r-note').hidden = true;
            return;
        }
        var D = CRC.duty(basis, buyer);
        $('r-total').textContent = money(D.total);
        $('r-line').textContent = T.stamp + ' ' + money(D.sd) + ' + ' + T.reg + ' ' + money(D.reg);
        var rows = [[T.basis + '<br><small style="color:#94a3b8">' + T.basis_help + '</small>', money(basis)]];
        if (cv && deal) rows.push([deal > cv ? T.on_deal : T.on_cv, '']);
        rows.push([T.stamp + ' (' + Math.round(D.rate * 1000) / 10 + '%)', money(D.sd)]);
        rows.push([T.reg + ' (1%)', money(D.reg)]);
        if (D.saving) rows.push([T.saving, money(D.saving), 'save']);
        rows.push([T.total, money(D.total), 'tot']);
        $('r-rows').innerHTML = rows.map(row).join('');
        if (res) $('r-cvrows').innerHTML = res.lines.map(lineTxt).map(row).join('') + row([T.cvtotal, money(cv)]);

        var note = D.womanCapped ? T.cap : buyer === 'j' ? T.jointnote.replace('%s', money(D.jointAlt)) : '';
        $('r-note').hidden = !note; $('r-note').textContent = note;

        var where = picked && mode === 'find' ? (HI ? picked.hi + ', लखनऊ' : picked.en + ', Lucknow') : (HI ? 'लखनऊ' : 'Lucknow');
        var msg = HI ? 'नमस्ते, मैंने ' + where + ' की प्रॉपर्टी (मूल्य ' + money(basis) + ') पर स्टांप ड्यूटी ' + money(D.sd) + ' निकाली। '
                     : 'Hi, I worked out stamp duty of ' + money(D.sd) + ' on a property in ' + where + ' (value ' + money(basis) + '). ';
        $('r-wa').href = 'https://wa.me/' + WA + '?text=' + encodeURIComponent(msg + (HI ? 'रजिस्ट्री के बारे में सवाल है।' : 'I have a question about the registry.'));
    }

    ['s-buyer', 's-mode', 's-type', 's-fcat', 's-class', 's-use'].forEach(function (id) {
        $(id).addEventListener('click', function (e) {
            var b = e.target.closest('button'); if (!b) return;
            [].forEach.call(this.querySelectorAll('button'), function (x) { x.classList.toggle('on', x === b); });
            calc();
        });
    });
    ['s-deal', 's-manual'].forEach(function (id) { $(id).addEventListener('input', function () { fmtInput(this); calc(); }); });
    ['s-road', 's-area', 's-unit', 's-floor', 's-built', 's-ctype', 's-age', 's-sfloor', 's-ac', 's-park', 's-corner'].forEach(function (id) {
        $(id).addEventListener('input', calc); $(id).addEventListener('change', calc);
    });
    calc();
})();
</script>
@endpush
