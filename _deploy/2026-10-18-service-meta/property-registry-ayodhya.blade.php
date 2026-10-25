@extends('layouts.user-app')

@section('title', 'Property Registry Assistance in Ayodhya — Sale Deed Drafting & Sub-Registrar Support | DSD Properties')
@section('meta_description', 'Sale deed drafting, ADA title checks, Ram Mandir corridor zone due diligence, and advocate attendance at Ayodhya Sub-Registrar offices. Fixed fee, quoted upfront.')

@php
    $city      = 'Ayodhya';
    $pageUrl   = 'https://dsdproperties.in/services/property-registry-ayodhya';
    $phone     = '+918595002933';
    $phoneDisp = '+91 85950 02933';
    $waText    = rawurlencode('Hello DSD Properties, I need help with a property registry in Ayodhya. Please share the process and fees.');

    $badges = [
        'Deeds drafted by our in-house advocates',
        'ADA & corridor zone status verified before drafting',
        'Attendance at Ayodhya Sub-Registrar offices',
    ];

    $sros = [
        ['name' => 'SRO Ayodhya Sadar', 'covers' => 'Ayodhya city, Ram Mandir precinct, Faizabad urban area and the older municipal wards of the merged Ayodhya-Faizabad zone.'],
        ['name' => 'SRO Sohawal',        'covers' => 'Western tehsil of Ayodhya district — Sohawal block villages and the Lucknow Road corridor properties.'],
        ['name' => 'SRO Bikapur',        'covers' => 'Southern blocks of Ayodhya district including Bikapur tehsil villages and agricultural land in the south-east belt.'],
        ['name' => 'SRO Milkipur',       'covers' => 'Eastern tehsil area including Milkipur block villages and the border belt with Sultanpur district.'],
        ['name' => 'SRO Maya',           'covers' => 'Northern blocks of Ayodhya district including Maya tehsil and Saryu river-bank rural properties.'],
    ];

    $deeds = [
        ['title' => 'Agreement to Sell (ATS)', 'body' => 'Payment milestones with dates, token forfeiture terms, the seller\'s obligation to clear encumbrances before execution, and a written exit clause if ADA approvals or corridor zone status cannot be confirmed during the agreement period.'],
        ['title' => 'Sale Deed (Bainama)',      'body' => 'Boundaries on all four sides, khasra or plot number, area in the same unit as the parent deed, e-Stamp certificate number, full payment schedule, title warranty and indemnity clauses that survive registration.'],
        ['title' => 'Gift Deed & Family Partition', 'body' => 'Drafted to qualify for the concessional flat stamp duty for transfers between blood relatives in Uttar Pradesh, with the relationship evidence the Sub-Registrar will ask to see attached correctly.'],
        ['title' => 'Supporting instruments',   'body' => 'Power of Attorney for NRI or out-of-station sellers, relinquishment deed, rectification deed for errors in an already-registered document, and possession letters.'],
    ];

    $steps = [
        ['label' => 'Reviewed within 24 working hours', 'title' => 'Send the papers', 'body' => 'Share the previous title deed, khatauni extract, identity proof of both parties, and agreed terms on WhatsApp. We read the parent deed first — including checking ADA approval status and whether the property falls within any notified corridor or pilgrimage zone — because most problems are already visible in it.'],
        ['label' => 'You approve before anything is stamped', 'title' => 'Draft and review', 'body' => 'One of our advocates drafts the deed and sends you a PDF. You get one walkthrough call to understand each clause, and revisions until the draft says what you actually agreed. Nothing moves to stamping until you confirm in writing.'],
        ['label' => 'Verified against the published list', 'title' => 'Duty calculation and slot', 'body' => 'We pull the circle rate for your specific ward or village from the Ayodhya district schedule, compute duty on the higher of circle rate and agreed consideration, prepare the e-Stamp application in the buyer\'s name, and book the slot at the correct Sub-Registrar office.'],
        ['label' => 'Someone stands with you', 'title' => 'Execution day', 'body' => 'Your advocate attends — token, biometric and photo capture, witness formalities, answering the reader\'s queries, and confirming the endorsed receipt is generated before you leave the building.'],
    ];

    $pricing = [
        ['item' => 'Agreement to Sell — drafting and review', 'note' => 'Includes one revision round'],
        ['item' => 'Sale deed — drafting, duty computation and execution-day attendance', 'note' => 'Government stamp duty and registration fee paid separately by you, directly'],
        ['item' => 'Gift deed or family partition', 'note' => 'Relationship documentation assistance included'],
    ];

    $comparison = [
        ['feature' => 'Draft quality',       'broker' => 'Reused template with names swapped',   'self' => 'Typist-shop format, clauses unread',  'dsd' => 'Advocate-drafted, with title warranty and indemnity clauses'],
        ['feature' => 'Circle rate check',   'broker' => 'Estimated verbally',                    'self' => 'Whatever the deed writer assumes',    'dsd' => 'Ward-level rate pulled from the published Ayodhya district list'],
        ['feature' => 'Concessions applied', 'broker' => 'Rarely raised',                         'self' => 'Missed if you did not know to ask',   'dsd' => 'Female buyer and blood-relative concessions checked for eligibility'],
        ['feature' => 'Sub-Registrar day',   'broker' => 'You are handed to a tout',              'self' => 'You queue and guess',                 'dsd' => 'Advocate attends with you, start to receipt'],
        ['feature' => 'After registration',  'broker' => 'Contact goes cold',                     'self' => 'Mutation often forgotten',            'dsd' => 'Written dakhil kharij roadmap handed over the same week'],
        ['feature' => 'What you pay',        'broker' => 'Percentage of deal value',              'self' => 'Unpredictable',                       'dsd' => 'Fixed fee, quoted before work starts'],
    ];

    $problems = [
        ['icon' => '🕌', 'title' => 'Ram Mandir corridor and development zone boundaries shift', 'body' => 'The Ayodhya Development Authority has notified multiple zones — the Ram Mandir precinct, the pilgrim corridor, the Saryu riverfront development area — with different usage restrictions and acquisition notifications. A property that was freely transferable before a notification may have restricted use or an outstanding acquisition proceedings after it. These do not always appear in the khatauni or in the parent deed.'],
        ['icon' => '📋', 'title' => 'The old Faizabad district records are still in transition', 'body' => 'When Faizabad was merged into Ayodhya, the legacy revenue records, sub-registrar jurisdictions and circle rate schedules all had to be realigned. Properties in the Faizabad urban area may have records split across the old and new nomenclature. Applying the wrong circle rate for your ward — or presenting at the wrong SRO — results in either a deficient stamp or a rejected appointment.'],
        ['icon' => '🙈', 'title' => 'Nobody explains what you are signing', 'body' => 'Between the token counter, biometric capture and the reader\'s queries, first-time buyers sign what they are handed. Clauses about payment mode, possession date and who bears past dues get read for the first time months later — often in a dispute.'],
    ];

    $relatedLinks = [
        ['href' => '/services/property-verification-ayodhya', 'tag' => 'Service', 'title' => 'Property verification in Ayodhya before you pay a token', 'arrow' => 'View service →'],
        ['href' => '/blog/igrsup-lucknow-property-search-tutorial', 'tag' => 'Tutorial', 'title' => 'Check any UP property on IGRSUP yourself', 'arrow' => 'Read →'],
        ['href' => '/blog/stamp-duty-registration-charges-lucknow-2026', 'tag' => 'Guide', 'title' => 'Stamp duty &amp; registration charges in UP 2026', 'arrow' => 'Read →'],
        ['href' => '/services/property-registry-lucknow', 'tag' => 'Service', 'title' => 'Property registry assistance in Lucknow', 'arrow' => 'View service →'],
    ];

    $faqs = [
        ['q' => 'Which Sub-Registrar office covers my Ayodhya property?', 'a' => 'Ayodhya district has five Sub-Registrar offices — Sadar (Ayodhya-Faizabad city), Sohawal, Bikapur, Milkipur and Maya. Jurisdiction follows the property\'s tehsil and ward, not your residential address. Since the Faizabad merger, some properties previously registered at Faizabad Sadar are now under Ayodhya Sadar with updated nomenclature. We confirm the correct office before booking any slot.'],
        ['q' => 'Does the Ram Mandir corridor affect property registration in Ayodhya?', 'a' => 'If the property falls within a notified acquisition zone or a corridor restriction zone, registration can be complicated by outstanding government notifications or encumbrance proceedings. These restrictions are not always visible in the IGRSUP title search — they may be registered in a separate acquisition register. We check both the revenue record and relevant ADA notifications for your specific survey number before advising on whether to proceed to registration.'],
        ['q' => 'What is ADA and how does it affect registry in Ayodhya?', 'a' => 'The Ayodhya Development Authority is the planning body for Ayodhya. Properties within the ADA area require ADA approval for development, and layouts or plots marketed as ADA-approved need that approval verified against the original sanction letter — not just the seller\'s representation. We verify ADA layout sanction status before the deed is drafted, because a purchase without verified approval can face demolition or conversion notices later.'],
        ['q' => 'What are stamp duty rates in Ayodhya in 2026?', 'a' => 'Stamp duty in Uttar Pradesh is 7% for male buyers, with a 1% concession available to women buyers subject to the ₹1 crore ceiling. The registration fee is 1% of the transaction value. Duty is computed on whichever is higher — the circle rate for your specific ward/village in the Ayodhya district schedule, or the agreed consideration. We verify the applicable rate on IGRSUP before the e-Stamp is generated.'],
        ['q' => 'Can agricultural land be registered as residential in Ayodhya?', 'a' => 'Agricultural land in the ADA area requires land use conversion (change of land use order) before it can be registered and developed as residential. Buying agricultural land without a CLU order means the buyer takes on the conversion risk, the risk of denial, and the risk of development restrictions. If you are being offered an ADA plot in what was agricultural land, we check whether the CLU order actually exists before the agreement is drafted.'],
        ['q' => 'What is dakhil kharij and do I need it after Ayodhya registry?', 'a' => 'Dakhil kharij is mutation — the update to the revenue (khatauni) record to reflect the new ownership. Registration transfers title under the Transfer of Property Act; mutation updates the government\'s land records for tax and future transactions. Skipping it causes problems at resale, bank loans, and property disputes. Every registry client receives a written dakhil kharij roadmap — tehsil, application, documents, fee — handed over the same week as registration.'],
        ['q' => 'Who drafts the deed?', 'a' => 'Advocates on our team enrolled with the Bar Council, acting in their professional capacity. DSD Properties coordinates the engagement and handles the registry logistics; the legal drafting is advocate work. Your draft is not a typist-shop format — it is prepared against your actual parent deed and revenue record.'],
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            ['@type' => 'ProfessionalService', '@id' => $pageUrl . '#service', 'name' => 'Property Registry Assistance in Ayodhya — DSD Properties', 'description' => 'Sale deed drafting, ADA and corridor zone checks, and advocate attendance at Ayodhya Sub-Registrar offices.', 'url' => $pageUrl, 'telephone' => $phone, 'priceRange' => '₹5000-₹25000', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Ayodhya', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'], 'areaServed' => ['@type' => 'GeoCircle', 'geoMidpoint' => ['@type' => 'GeoCoordinates', 'latitude' => 26.7922, 'longitude' => 82.1998], 'geoRadius' => '40000'], 'serviceType' => 'Property registration and deed drafting assistance'],
            ['@type' => 'FAQPage', '@id' => $pageUrl . '#faq', 'mainEntity' => collect($faqs)->map(fn($f) => ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]])->all()],
            ['@type' => 'BreadcrumbList', '@id' => $pageUrl . '#breadcrumb', 'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://dsdproperties.in/'], ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://dsdproperties.in/services'], ['@type' => 'ListItem', 'position' => 3, 'name' => 'Property Registry Assistance in Ayodhya', 'item' => $pageUrl]]],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
@include('pages.services.partials.registry-page-content')
@endsection
