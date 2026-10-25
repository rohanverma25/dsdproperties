@extends('layouts.user-app')

@section('title', 'Property Registry Assistance in Gorakhpur — Sale Deed Drafting & Sub-Registrar Support | DSD Properties')
@section('meta_description', 'Sale deed drafting, GDA approval checks, Rapti flood zone due diligence, and advocate attendance at Gorakhpur Sub-Registrar offices. Fixed fee, quoted upfront.')

@php
    $city      = 'Gorakhpur';
    $pageUrl   = 'https://dsdproperties.in/services/property-registry-gorakhpur';
    $phone     = '+918595002933';
    $phoneDisp = '+91 85950 02933';
    $waText    = rawurlencode('Hello DSD Properties, I need help with a property registry in Gorakhpur. Please share the process and fees.');

    $badges = [
        'Deeds drafted by our in-house advocates',
        'GDA approval & Rapti flood zone verified before drafting',
        'Attendance at Gorakhpur Sub-Registrar offices',
    ];

    $sros = [
        ['name' => 'SRO Gorakhpur Sadar', 'covers' => 'GDA-approved sectors, Rapti Nagar, Taramandal, Betiahata and the older city wards on the northern and eastern sides.'],
        ['name' => 'SRO Gorakhpur City',  'covers' => 'Inner-city wards including Golghar, civil lines, railway area and the commercial core of Gorakhpur.'],
        ['name' => 'SRO Sahjanwa',        'covers' => 'Southern tehsil of Gorakhpur district — Sahjanwa block villages and the NH-29 corridor belt towards Varanasi.'],
        ['name' => 'SRO Gola',            'covers' => 'Eastern tehsil including Gola block villages and the border belt with Maharajganj district.'],
        ['name' => 'SRO Bansgaon',        'covers' => 'Northern tehsil including Bansgaon block villages and the Rapti river-side rural stretch.'],
    ];

    $deeds = [
        ['title' => 'Agreement to Sell (ATS)', 'body' => 'Payment milestones with dates, token forfeiture terms, the seller\'s obligation to clear encumbrances before execution, and a written exit clause if GDA approvals or flood zone status cannot be confirmed during the agreement period.'],
        ['title' => 'Sale Deed (Bainama)',      'body' => 'Boundaries on all four sides, khasra or plot number, area in the same unit as the parent deed, e-Stamp certificate number, full payment schedule, title warranty and indemnity clauses that survive registration.'],
        ['title' => 'Gift Deed & Family Partition', 'body' => 'Drafted to qualify for the concessional flat stamp duty for transfers between blood relatives in Uttar Pradesh, with the relationship evidence the Sub-Registrar will ask to see attached correctly.'],
        ['title' => 'Supporting instruments',   'body' => 'Power of Attorney for NRI or out-of-station sellers, relinquishment deed, rectification deed for errors in an already-registered document, and possession letters.'],
    ];

    $steps = [
        ['label' => 'Reviewed within 24 working hours', 'title' => 'Send the papers', 'body' => 'Share the previous title deed, khatauni extract, identity proof of both parties, and agreed terms on WhatsApp. We read the parent deed first — including GDA approval sanction, Gorakhnath Math trust land status, and whether the property falls within the Rapti-Rohini flood-susceptible zone — because most problems are already visible in it.'],
        ['label' => 'You approve before anything is stamped', 'title' => 'Draft and review', 'body' => 'One of our advocates drafts the deed and sends you a PDF. You get one walkthrough call to understand each clause, and revisions until the draft says what you actually agreed. Nothing moves to stamping until you confirm in writing.'],
        ['label' => 'Verified against the published list', 'title' => 'Duty calculation and slot', 'body' => 'We pull the circle rate for your specific ward or village from the Gorakhpur district schedule, compute duty on the higher of circle rate and agreed consideration, prepare the e-Stamp application in the buyer\'s name, and book the slot at the correct Sub-Registrar office.'],
        ['label' => 'Someone stands with you', 'title' => 'Execution day', 'body' => 'Your advocate attends — token, biometric and photo capture, witness formalities, answering the reader\'s queries, and confirming the endorsed receipt is generated before you leave the building.'],
    ];

    $pricing = [
        ['item' => 'Agreement to Sell — drafting and review', 'note' => 'Includes one revision round'],
        ['item' => 'Sale deed — drafting, duty computation and execution-day attendance', 'note' => 'Government stamp duty and registration fee paid separately by you, directly'],
        ['item' => 'Gift deed or family partition', 'note' => 'Relationship documentation assistance included'],
    ];

    $comparison = [
        ['feature' => 'Draft quality',       'broker' => 'Reused template with names swapped',  'self' => 'Typist-shop format, clauses unread',  'dsd' => 'Advocate-drafted, with title warranty and indemnity clauses'],
        ['feature' => 'Circle rate check',   'broker' => 'Estimated verbally',                   'self' => 'Whatever the deed writer assumes',    'dsd' => 'Ward-level rate pulled from the published Gorakhpur district list'],
        ['feature' => 'Concessions applied', 'broker' => 'Rarely raised',                        'self' => 'Missed if you did not know to ask',   'dsd' => 'Female buyer and blood-relative concessions checked for eligibility'],
        ['feature' => 'Sub-Registrar day',   'broker' => 'You are handed to a tout',             'self' => 'You queue and guess',                 'dsd' => 'Advocate attends with you, start to receipt'],
        ['feature' => 'After registration',  'broker' => 'Contact goes cold',                    'self' => 'Mutation often forgotten',            'dsd' => 'Written dakhil kharij roadmap handed over the same week'],
        ['feature' => 'What you pay',        'broker' => 'Percentage of deal value',             'self' => 'Unpredictable',                       'dsd' => 'Fixed fee, quoted before work starts'],
    ];

    $problems = [
        ['icon' => '🌊', 'title' => 'Rapti and Rohini flood zone land transfers without disclosure', 'body' => 'Gorakhpur has historically been prone to Rapti and Rohini river flooding. The state has notified flood-zone classifications for parts of the district, and properties in these zones can face development restrictions, mandatory setbacks, and bank lending refusals. Sellers rarely disclose flood zone status voluntarily. We check the ward\'s flood zone classification before the deed is drafted — not after.'],
        ['icon' => '🛕', 'title' => 'Gorakhnath Math trust land is registered but encumbered', 'body' => 'Certain properties in and around Gorakhpur city are historically associated with Gorakhnath Math trust ownership. A property may appear to have a clean chain of sale deeds while the original trust deed in the ancestor\'s name was never legally severed from Math ownership. These titles look clean until a trust claim surfaces at resale or in a family dispute.'],
        ['icon' => '🙈', 'title' => 'Nobody explains what you are signing', 'body' => 'Between the token counter, biometric capture and the reader\'s queries, first-time buyers sign what they are handed. Clauses about payment mode, possession date and who bears past dues get read for the first time months later — often in a dispute.'],
    ];

    $relatedLinks = [
        ['href' => '/services/property-verification-gorakhpur', 'tag' => 'Service', 'title' => 'Property verification in Gorakhpur before you pay a token', 'arrow' => 'View service →'],
        ['href' => '/blog/igrsup-lucknow-property-search-tutorial', 'tag' => 'Tutorial', 'title' => 'Check any UP property on IGRSUP yourself', 'arrow' => 'Read →'],
        ['href' => '/blog/stamp-duty-registration-charges-lucknow-2026', 'tag' => 'Guide', 'title' => 'Stamp duty &amp; registration charges in UP 2026', 'arrow' => 'Read →'],
        ['href' => '/services/property-registry-lucknow', 'tag' => 'Service', 'title' => 'Property registry assistance in Lucknow', 'arrow' => 'View service →'],
    ];

    $faqs = [
        ['q' => 'Which Sub-Registrar office covers my Gorakhpur property?', 'a' => 'Gorakhpur district has five Sub-Registrar offices. Sadar covers GDA-approved sectors and the newer residential areas; City covers the inner-city wards; Sahjanwa covers the southern tehsil; Gola covers the eastern belt; and Bansgaon covers the northern tehsil. Jurisdiction follows the property location, not your address. We confirm the correct office before booking any slot.'],
        ['q' => 'How do I know if my Gorakhpur property is in a flood zone?', 'a' => 'The Rapti and Rohini rivers have notified flood-zone classifications for parts of Gorakhpur district. These zones are tracked in government records separate from the revenue record — checking only the khatauni will not reveal flood zone status. We verify the classification for your specific survey number and khasra before advising on whether to proceed to registration.'],
        ['q' => 'What is GDA and why does GDA approval matter for registry?', 'a' => 'The Gorakhpur Development Authority is the planning body for Gorakhpur. Properties in the GDA area — which covers the city and surrounding areas — require GDA layout sanction for residential development. A layout marketed as GDA-approved needs that sanction verified against the original letter, not just a seller\'s representation. Without verified GDA approval, the buyer can face demolition notices or be unable to obtain a building plan sanction later.'],
        ['q' => 'What are the stamp duty rates in Gorakhpur in 2026?', 'a' => 'Stamp duty in Uttar Pradesh is 7% for male buyers, with a 1% concession for women buyers subject to the ₹1 crore ceiling. The registration fee is 1% of the transaction value. Duty is computed on whichever is higher — the circle rate for your specific ward/village in the Gorakhpur district schedule, or the agreed consideration. We verify the applicable rate on IGRSUP before the e-Stamp is generated.'],
        ['q' => 'What is dakhil kharij and do I need it after Gorakhpur registry?', 'a' => 'Dakhil kharij is mutation — the update to the revenue (khatauni) record to reflect the new ownership. Registration transfers title; mutation updates the government\'s land records. Skipping it causes problems at resale, home loans, and property disputes. Every registry client receives a written dakhil kharij roadmap — tehsil, application, documents, fee — handed over the same week as registration.'],
        ['q' => 'Can Gorakhnath Math land be registered and sold freely?', 'a' => 'Trust land associated with Gorakhnath Math is subject to trust deed restrictions and requires the trust\'s consent for alienation. In practice, some properties have been sold through an unbroken chain of private deeds without that consent ever being formally obtained. The property can then be registered at the Sub-Registrar — but the trust\'s underlying claim survives and can resurface in litigation. A proper title chain review covering all the way back to the original trust grant is what protects against this.'],
        ['q' => 'Who drafts the deed?', 'a' => 'Advocates on our team enrolled with the Bar Council, acting in their professional capacity. DSD Properties coordinates the engagement and handles the registry logistics; the legal drafting is advocate work. Your draft is prepared against your actual parent deed and revenue record, not filled into a typist-shop format.'],
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            ['@type' => 'ProfessionalService', '@id' => $pageUrl . '#service', 'name' => 'Property Registry Assistance in Gorakhpur — DSD Properties', 'description' => 'Sale deed drafting, GDA approval checks, Rapti flood zone due diligence, and advocate attendance at Gorakhpur Sub-Registrar offices.', 'url' => $pageUrl, 'telephone' => $phone, 'priceRange' => '₹5000-₹25000', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Gorakhpur', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'], 'areaServed' => ['@type' => 'GeoCircle', 'geoMidpoint' => ['@type' => 'GeoCoordinates', 'latitude' => 26.7606, 'longitude' => 83.3732], 'geoRadius' => '40000'], 'serviceType' => 'Property registration and deed drafting assistance'],
            ['@type' => 'FAQPage', '@id' => $pageUrl . '#faq', 'mainEntity' => collect($faqs)->map(fn($f) => ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]])->all()],
            ['@type' => 'BreadcrumbList', '@id' => $pageUrl . '#breadcrumb', 'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://dsdproperties.in/'], ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://dsdproperties.in/services'], ['@type' => 'ListItem', 'position' => 3, 'name' => 'Property Registry Assistance in Gorakhpur', 'item' => $pageUrl]]],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
@include('pages.services.partials.registry-page-content')
@endsection
