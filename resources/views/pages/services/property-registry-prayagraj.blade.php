@extends('layouts.user-app')

@section('title', 'Property Registry Help in Prayagraj — Sale Deed & Advocate | DSD')
@section('meta_description', 'Registering property in Prayagraj? We draft the sale deed, check flood zones and Waqf Board claims, and our advocate attends the registry. Fixed fee.')
@php
    $city      = 'Prayagraj';
    $pageUrl   = 'https://dsdproperties.in/services/property-registry-prayagraj';
    $phone     = '+918595002933';
    $phoneDisp = '+91 85950 02933';
    $waText    = rawurlencode('Hello DSD Properties, I need help with a property registry in Prayagraj. Please share the process and fees.');

    $badges = [
        'Deeds drafted by our in-house advocates',
        'Flood zone & PDA approval verified before drafting',
        'Attendance at Prayagraj Sub-Registrar offices',
    ];

    $sros = [
        ['name' => 'SRO Prayagraj Sadar',  'covers' => 'Civil Lines, Allahpur, Naini industrial area, PDA sectors and the newer residential colonies along the Kanpur and Lucknow road corridors.'],
        ['name' => 'SRO Prayagraj City',   'covers' => 'Inner-city wards — Chowk, Atala, Kydganj, Allapur and the dense older fabric of the city including the Triveni Sangam zone.'],
        ['name' => 'SRO Naini',            'covers' => 'Naini tehsil on the Yamuna bank — industrial estates, Naini bridge corridor and properties south of the Yamuna.'],
        ['name' => 'SRO Phulpur',          'covers' => 'Western tehsil including Phulpur block villages and agricultural land stretching towards Pratapgarh district.'],
        ['name' => 'SRO Soraon',           'covers' => 'Eastern tehsil including Soraon block villages and the Ganga-side rural belt approaching Mirzapur.'],
    ];

    $deeds = [
        ['title' => 'Agreement to Sell (ATS)', 'body' => 'Payment milestones with dates, token forfeiture terms, the seller\'s obligation to clear encumbrances before execution, and a written exit clause if PDA approvals, flood zone status, or Waqf Board records cannot be confirmed during the agreement period.'],
        ['title' => 'Sale Deed (Bainama)',      'body' => 'Boundaries on all four sides, khasra or plot number, area in the same unit as the parent deed, e-Stamp certificate number, full payment schedule, title warranty and indemnity clauses that survive registration.'],
        ['title' => 'Gift Deed & Family Partition', 'body' => 'Drafted to qualify for the concessional flat stamp duty for transfers between blood relatives in Uttar Pradesh, with the relationship evidence the Sub-Registrar will ask to see attached correctly.'],
        ['title' => 'Supporting instruments',   'body' => 'Power of Attorney for NRI or out-of-station sellers, relinquishment deed, rectification deed for errors in an already-registered document, and possession letters.'],
    ];

    $steps = [
        ['label' => 'Reviewed within 24 working hours', 'title' => 'Send the papers', 'body' => 'Share the previous title deed, khatauni extract, identity proof of both parties, and agreed terms on WhatsApp. We read the parent deed first — including PDA approval status, Waqf Board records, Allahabad High Court proximity notifications and whether the property falls in the Ganga-Yamuna flood zone — because most problems are already visible in it.'],
        ['label' => 'You approve before anything is stamped', 'title' => 'Draft and review', 'body' => 'One of our advocates drafts the deed and sends you a PDF. You get one walkthrough call to understand each clause, and revisions until the draft says what you actually agreed. Nothing moves to stamping until you confirm in writing.'],
        ['label' => 'Verified against the published list', 'title' => 'Duty calculation and slot', 'body' => 'We pull the circle rate for your specific ward or village from the Prayagraj district schedule, compute duty on the higher of circle rate and agreed consideration, prepare the e-Stamp application in the buyer\'s name, and book the slot at the correct Sub-Registrar office.'],
        ['label' => 'Someone stands with you', 'title' => 'Execution day', 'body' => 'Your advocate attends — token, biometric and photo capture, witness formalities, answering the reader\'s queries, and confirming the endorsed receipt is generated before you leave the building.'],
    ];

    $pricing = [
        ['item' => 'Agreement to Sell — drafting and review', 'note' => 'Includes one revision round'],
        ['item' => 'Sale deed — drafting, duty computation and execution-day attendance', 'note' => 'Government stamp duty and registration fee paid separately by you, directly'],
        ['item' => 'Gift deed or family partition', 'note' => 'Relationship documentation assistance included'],
    ];

    $comparison = [
        ['feature' => 'Draft quality',       'broker' => 'Reused template with names swapped',    'self' => 'Typist-shop format, clauses unread',  'dsd' => 'Advocate-drafted, with title warranty and indemnity clauses'],
        ['feature' => 'Circle rate check',   'broker' => 'Estimated verbally',                     'self' => 'Whatever the deed writer assumes',    'dsd' => 'Ward-level rate pulled from the published Prayagraj district list'],
        ['feature' => 'Concessions applied', 'broker' => 'Rarely raised',                          'self' => 'Missed if you did not know to ask',   'dsd' => 'Female buyer and blood-relative concessions checked for eligibility'],
        ['feature' => 'Sub-Registrar day',   'broker' => 'You are handed to a tout',               'self' => 'You queue and guess',                 'dsd' => 'Advocate attends with you, start to receipt'],
        ['feature' => 'After registration',  'broker' => 'Contact goes cold',                      'self' => 'Mutation often forgotten',            'dsd' => 'Written dakhil kharij roadmap handed over the same week'],
        ['feature' => 'What you pay',        'broker' => 'Percentage of deal value',               'self' => 'Unpredictable',                       'dsd' => 'Fixed fee, quoted before work starts'],
    ];

    $problems = [
        ['icon' => '🌊', 'title' => 'Ganga and Yamuna flood zone properties are transferred without disclosure', 'body' => 'Large parts of Prayagraj — particularly in Naini and along the Sangam belt — fall within the flood plains of the Ganga and Yamuna. Properties in these zones can face development restrictions, NGT orders and bank lending refusals. Sellers rarely disclose flood zone status voluntarily. We check the ward classification and NGT notifications for your specific survey number before the deed is drafted.'],
        ['icon' => '⚖️', 'title' => 'Waqf Board land and Allahabad HC surroundings create hidden encumbrances', 'body' => 'Prayagraj has a significant Waqf property footprint, and properties adjacent to the Allahabad High Court precinct have had government acquisition and restriction notifications over the years. A property may appear to have a clear chain of private deeds while an older Waqf or acquisition record sits in a separate register. These do not surface in a standard IGRSUP title search.'],
        ['icon' => '🙈', 'title' => 'Nobody explains what you are signing', 'body' => 'Between the token counter, biometric capture and the reader\'s queries, first-time buyers sign what they are handed. Clauses about payment mode, possession date and who bears past dues get read for the first time months later — often in a dispute.'],
    ];

    $relatedLinks = [
        ['href' => '/services/property-verification-prayagraj', 'tag' => 'Service', 'title' => 'Property verification in Prayagraj before you pay a token', 'arrow' => 'View service →'],
        ['href' => '/blog/igrsup-lucknow-property-search-tutorial', 'tag' => 'Tutorial', 'title' => 'Check any UP property on IGRSUP yourself', 'arrow' => 'Read →'],
        ['href' => '/blog/stamp-duty-registration-charges-lucknow-2026', 'tag' => 'Guide', 'title' => 'Stamp duty &amp; registration charges in UP 2026', 'arrow' => 'Read →'],
        ['href' => '/services/property-registry-lucknow', 'tag' => 'Service', 'title' => 'Property registry assistance in Lucknow', 'arrow' => 'View service →'],
    ];

    $faqs = [
        ['q' => 'Which Sub-Registrar office covers my Prayagraj property?', 'a' => 'Prayagraj district has five main Sub-Registrar offices. Sadar covers Civil Lines, PDA sectors and the newer residential belt; City covers the inner-city wards including the Sangam zone; Naini covers the south-bank industrial and residential belt; Phulpur covers the western tehsil; and Soraon covers the eastern tehsil. Jurisdiction follows the property\'s ward and tehsil, not your address. We confirm the correct office before booking.'],
        ['q' => 'Does the Ganga or Yamuna flood zone affect property registration?', 'a' => 'If the property falls within a notified flood zone, registration can proceed — but development, construction, and in some cases bank lending are restricted. The NGT has issued directives on flood-plain construction in Prayagraj. These restrictions are not visible in the IGRSUP title search; they are in separate flood zone maps and NGT orders. We check both before advising on whether to proceed to registration.'],
        ['q' => 'How do I check if a Prayagraj property is Waqf Board land?', 'a' => 'Waqf properties are listed in the UP Sunni Waqf Board or UP Shia Waqf Board registers, which are separate from IGRSUP. A property may have an unbroken chain of private sale deeds while the original Waqf grant in the ancestor\'s name was never legally severed. The Supreme Court and various High Court judgments have addressed this issue repeatedly — the safest approach is checking the full title chain back to the original grant, not just the last two sale deeds.'],
        ['q' => 'What are the stamp duty rates in Prayagraj in 2026?', 'a' => 'Stamp duty in Uttar Pradesh is 7% for male buyers, with a 1% concession for women buyers subject to the ₹1 crore ceiling. The registration fee is 1% of the transaction value. Duty is computed on whichever is higher — the circle rate for your specific ward or village in the Prayagraj district schedule, or the agreed consideration. We verify the applicable rate on IGRSUP before the e-Stamp is generated.'],
        ['q' => 'What is PDA and does PDA approval matter for my Prayagraj purchase?', 'a' => 'The Prayagraj Development Authority is the planning body for Prayagraj. Properties in PDA-planned sectors require PDA layout sanction for residential development. A plot marketed as PDA-approved needs that sanction verified against the original letter. Without verified PDA approval, the buyer can face development restrictions or be unable to obtain a building plan sanction. We check PDA sanction status before the agreement to sell is drafted.'],
        ['q' => 'What is dakhil kharij and do I need it after Prayagraj registry?', 'a' => 'Dakhil kharij is mutation — the update to the revenue (khatauni) record reflecting the new ownership. Registration transfers title; mutation updates the land records for tax and future transactions. Skipping it causes problems at resale, home loans, and property disputes. Every registry client receives a written dakhil kharij roadmap — tehsil, application, documents, fee — handed over the same week as registration.'],
        ['q' => 'Who drafts the deed?', 'a' => 'Advocates on our team enrolled with the Bar Council, acting in their professional capacity. DSD Properties coordinates the engagement and handles the registry logistics; the legal drafting is advocate work. Your draft is prepared against your actual parent deed and revenue record, not a typist-shop format.'],
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            ['@type' => 'ProfessionalService', '@id' => $pageUrl . '#service', 'name' => 'Property Registry Assistance in Prayagraj — DSD Properties', 'description' => 'Sale deed drafting, Ganga-Yamuna flood zone checks, Waqf Board and PDA due diligence, and advocate attendance at Prayagraj Sub-Registrar offices.', 'url' => $pageUrl, 'telephone' => $phone, 'priceRange' => '₹5000-₹25000', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Prayagraj', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'], 'areaServed' => ['@type' => 'GeoCircle', 'geoMidpoint' => ['@type' => 'GeoCoordinates', 'latitude' => 25.4358, 'longitude' => 81.8463], 'geoRadius' => '40000'], 'serviceType' => 'Property registration and deed drafting assistance'],
            ['@type' => 'FAQPage', '@id' => $pageUrl . '#faq', 'mainEntity' => collect($faqs)->map(fn($f) => ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]])->all()],
            ['@type' => 'BreadcrumbList', '@id' => $pageUrl . '#breadcrumb', 'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://dsdproperties.in/'], ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://dsdproperties.in/services'], ['@type' => 'ListItem', 'position' => 3, 'name' => 'Property Registry Assistance in Prayagraj', 'item' => $pageUrl]]],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
@include('pages.services.partials.registry-page-content')
@endsection
