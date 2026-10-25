@extends('layouts.user-app')

@section('title', 'Property Registry Assistance in Agra — Sale Deed Drafting & Sub-Registrar Support | DSD Properties')
@section('meta_description', 'Sale deed drafting, Taj Trapezium Zone checks, ASI buffer zone due diligence, and advocate attendance at Agra Sub-Registrar offices. Fixed fee, quoted upfront.')

@php
    $city      = 'Agra';
    $pageUrl   = 'https://dsdproperties.in/services/property-registry-agra';
    $phone     = '+918595002933';
    $phoneDisp = '+91 85950 02933';
    $waText    = rawurlencode('Hello DSD Properties, I need help with a property registry in Agra. Please share the process and fees.');

    $badges = [
        'Deeds drafted by our in-house advocates',
        'TTZ & ASI buffer zone status verified before drafting',
        'Attendance at Agra Sub-Registrar offices',
    ];

    $sros = [
        ['name' => 'SRO Agra Sadar',    'covers' => 'ADA sectors, Kamla Nagar, Sikandra, Bodla and the newer residential colonies along the Mathura Road and Delhi Road belt.'],
        ['name' => 'SRO Agra City',     'covers' => 'Inner-city wards — Tajganj (immediately adjacent to the Taj Mahal), Sadar Bazar, Shahganj and the heritage core of Agra.'],
        ['name' => 'SRO Fatehabad',     'covers' => 'Southern tehsil of Agra district including Fatehabad block villages and the NH-2 / Agra-Gwalior corridor belt.'],
        ['name' => 'SRO Etmadpur',      'covers' => 'North-eastern tehsil including Etmadpur block and Yamuna-side villages approaching Firozabad district.'],
        ['name' => 'SRO Bah',           'covers' => 'Far south-western tehsil bordering Rajasthan — Bah block villages and the Chambal river-side rural belt.'],
    ];

    $deeds = [
        ['title' => 'Agreement to Sell (ATS)', 'body' => 'Payment milestones with dates, token forfeiture terms, the seller\'s obligation to clear encumbrances before execution, and a written exit clause if TTZ clearance, ASI buffer zone status, or ADA approvals cannot be confirmed during the agreement period.'],
        ['title' => 'Sale Deed (Bainama)',      'body' => 'Boundaries on all four sides, khasra or plot number, area in the same unit as the parent deed, e-Stamp certificate number, full payment schedule, title warranty and indemnity clauses that survive registration.'],
        ['title' => 'Gift Deed & Family Partition', 'body' => 'Drafted to qualify for the concessional flat stamp duty for transfers between blood relatives in Uttar Pradesh, with the relationship evidence the Sub-Registrar will ask to see attached correctly.'],
        ['title' => 'Supporting instruments',   'body' => 'Power of Attorney for NRI or out-of-station sellers, relinquishment deed, rectification deed for errors in an already-registered document, and possession letters.'],
    ];

    $steps = [
        ['label' => 'Reviewed within 24 working hours', 'title' => 'Send the papers', 'body' => 'Share the previous title deed, khatauni extract, identity proof of both parties, and agreed terms on WhatsApp. We read the parent deed first — including TTZ zone classification, ASI 100m/200m/300m buffer zone status, Army Cantonment boundaries and Yamuna flood zone — because most problems are already visible in it.'],
        ['label' => 'You approve before anything is stamped', 'title' => 'Draft and review', 'body' => 'One of our advocates drafts the deed and sends you a PDF. You get one walkthrough call to understand each clause, and revisions until the draft says what you actually agreed. Nothing moves to stamping until you confirm in writing.'],
        ['label' => 'Verified against the published list', 'title' => 'Duty calculation and slot', 'body' => 'We pull the circle rate for your specific ward or village from the Agra district schedule, compute duty on the higher of circle rate and agreed consideration, prepare the e-Stamp application in the buyer\'s name, and book the slot at the correct Sub-Registrar office.'],
        ['label' => 'Someone stands with you', 'title' => 'Execution day', 'body' => 'Your advocate attends — token, biometric and photo capture, witness formalities, answering the reader\'s queries, and confirming the endorsed receipt is generated before you leave the building.'],
    ];

    $pricing = [
        ['item' => 'Agreement to Sell — drafting and review', 'note' => 'Includes one revision round'],
        ['item' => 'Sale deed — drafting, duty computation and execution-day attendance', 'note' => 'Government stamp duty and registration fee paid separately by you, directly'],
        ['item' => 'Gift deed or family partition', 'note' => 'Relationship documentation assistance included'],
    ];

    $comparison = [
        ['feature' => 'Draft quality',       'broker' => 'Reused template with names swapped',  'self' => 'Typist-shop format, clauses unread',  'dsd' => 'Advocate-drafted, with title warranty and indemnity clauses'],
        ['feature' => 'Circle rate check',   'broker' => 'Estimated verbally',                   'self' => 'Whatever the deed writer assumes',    'dsd' => 'Ward-level rate pulled from the published Agra district list'],
        ['feature' => 'Concessions applied', 'broker' => 'Rarely raised',                        'self' => 'Missed if you did not know to ask',   'dsd' => 'Female buyer and blood-relative concessions checked for eligibility'],
        ['feature' => 'Sub-Registrar day',   'broker' => 'You are handed to a tout',             'self' => 'You queue and guess',                 'dsd' => 'Advocate attends with you, start to receipt'],
        ['feature' => 'After registration',  'broker' => 'Contact goes cold',                    'self' => 'Mutation often forgotten',            'dsd' => 'Written dakhil kharij roadmap handed over the same week'],
        ['feature' => 'What you pay',        'broker' => 'Percentage of deal value',             'self' => 'Unpredictable',                       'dsd' => 'Fixed fee, quoted before work starts'],
    ];

    $problems = [
        ['icon' => '🏛️', 'title' => 'Taj Trapezium Zone and ASI buffer zones restrict construction — and sales', 'body' => 'The Supreme Court-mandated Taj Trapezium Zone covers a 10,400 sq km area around the Taj Mahal with specific industrial and polluting-industry restrictions. Additionally, the Archaeological Survey of India enforces 100m, 200m and 300m buffer zones around every protected monument in Agra. Buying in these zones does not void a sale deed, but it does restrict what you can build, and the restrictions are not disclosed by brokers because they reduce price. We check the zone classification for your specific survey number before drafting.'],
        ['icon' => '🎖️', 'title' => 'Army Cantonment land has separate registry rules', 'body' => 'Parts of Agra fall within or adjacent to the Agra Cantonment. Cantonment land is governed by the Cantonments Act and transfers require Cantonment Board approval — the process, timeline and eligible buyers differ from civilian property. A sale deed registered without proper Cantonment approval can be declared void. We verify whether your property falls within Cantonment limits before any work begins.'],
        ['icon' => '🙈', 'title' => 'Nobody explains what you are signing', 'body' => 'Between the token counter, biometric capture and the reader\'s queries, first-time buyers sign what they are handed. Clauses about payment mode, possession date and who bears past dues get read for the first time months later — often in a dispute.'],
    ];

    $relatedLinks = [
        ['href' => '/services/property-verification-agra', 'tag' => 'Service', 'title' => 'Property verification in Agra before you pay a token', 'arrow' => 'View service →'],
        ['href' => '/blog/igrsup-lucknow-property-search-tutorial', 'tag' => 'Tutorial', 'title' => 'Check any UP property on IGRSUP yourself', 'arrow' => 'Read →'],
        ['href' => '/blog/stamp-duty-registration-charges-lucknow-2026', 'tag' => 'Guide', 'title' => 'Stamp duty &amp; registration charges in UP 2026', 'arrow' => 'Read →'],
        ['href' => '/services/property-registry-lucknow', 'tag' => 'Service', 'title' => 'Property registry assistance in Lucknow', 'arrow' => 'View service →'],
    ];

    $faqs = [
        ['q' => 'Which Sub-Registrar office covers my Agra property?', 'a' => 'Agra district has five Sub-Registrar offices. Sadar covers ADA sectors and the newer residential belt; City (Tajganj) covers the heritage core and Taj Mahal adjacent wards; Fatehabad covers the southern tehsil; Etmadpur covers the north-eastern blocks; and Bah covers the far south-western tehsil. Jurisdiction follows the property\'s ward and tehsil, not your address. We confirm the correct office before booking any slot.'],
        ['q' => 'What is the Taj Trapezium Zone and does it affect my property purchase?', 'a' => 'The Taj Trapezium Zone (TTZ) is a 10,400 sq km area around the Taj Mahal designated by the Supreme Court. Within the TTZ, certain types of construction and industrial activity are restricted. The zone does not prevent residential property purchases, but it restricts what can be built and in some sub-zones imposes specific conditions on development approvals. We check whether your specific survey number falls within a restricted TTZ sub-zone before drafting the agreement.'],
        ['q' => 'What is the ASI buffer zone and can I build in it?', 'a' => 'The Archaeological Survey of India enforces 100m, 200m and 300m buffer zones around every protected monument in Agra, including the Taj Mahal, Agra Fort, Fatehpur Sikri and others. Within 100m of a protected monument, no new construction is permitted. Between 100m and 200m, construction requires prior permission from the National Monuments Authority. Beyond 200m, standard local planning rules apply. Broker representations about "outside the restricted zone" should always be verified against the actual survey map.'],
        ['q' => 'Does Cantonment land require special approval for registry in Agra?', 'a' => 'Yes. Property within the Agra Cantonment is governed by the Cantonments Act, and transfers require Cantonment Board approval before they can be registered. The Board has the right of pre-emption in some cases. Registering without approval is a defective title. We verify whether the property\'s survey number falls within the Cantonment boundary before any work begins.'],
        ['q' => 'What are stamp duty rates in Agra in 2026?', 'a' => 'Stamp duty in Uttar Pradesh is 7% for male buyers, with a 1% concession for women buyers subject to the ₹1 crore ceiling. The registration fee is 1% of the transaction value. Duty is computed on whichever is higher — the circle rate for your ward or village in the Agra district schedule, or the agreed consideration. We verify the applicable rate on IGRSUP before the e-Stamp is generated.'],
        ['q' => 'What is dakhil kharij and do I need it after Agra registry?', 'a' => 'Dakhil kharij is mutation — the update to the revenue (khatauni) record to reflect the new ownership. Registration transfers title; mutation updates the government\'s land records for tax and future transactions. Skipping it causes problems at resale, bank loans, and property disputes. Every registry client receives a written dakhil kharij roadmap — tehsil, application, documents, fee — handed over the same week as registration.'],
        ['q' => 'Who drafts the deed?', 'a' => 'Advocates on our team enrolled with the Bar Council, acting in their professional capacity. DSD Properties coordinates the engagement and handles the registry logistics; the legal drafting is advocate work. Your draft is prepared against your actual parent deed and revenue record, not a typist-shop format.'],
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            ['@type' => 'ProfessionalService', '@id' => $pageUrl . '#service', 'name' => 'Property Registry Assistance in Agra — DSD Properties', 'description' => 'Sale deed drafting, TTZ and ASI buffer zone checks, Army Cantonment due diligence, and advocate attendance at Agra Sub-Registrar offices.', 'url' => $pageUrl, 'telephone' => $phone, 'priceRange' => '₹5000-₹25000', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Agra', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'], 'areaServed' => ['@type' => 'GeoCircle', 'geoMidpoint' => ['@type' => 'GeoCoordinates', 'latitude' => 27.1767, 'longitude' => 78.0081], 'geoRadius' => '40000'], 'serviceType' => 'Property registration and deed drafting assistance'],
            ['@type' => 'FAQPage', '@id' => $pageUrl . '#faq', 'mainEntity' => collect($faqs)->map(fn($f) => ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]])->all()],
            ['@type' => 'BreadcrumbList', '@id' => $pageUrl . '#breadcrumb', 'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://dsdproperties.in/'], ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://dsdproperties.in/services'], ['@type' => 'ListItem', 'position' => 3, 'name' => 'Property Registry Assistance in Agra', 'item' => $pageUrl]]],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
@include('pages.services.partials.registry-page-content')
@endsection
