@extends('layouts.user-app')

@section('title', 'Property Registry Assistance in Noida — Sale Deed Drafting & Sub-Registrar Support | DSD Properties')
@section('meta_description', 'Sale deed drafting, Noida Authority lease status checks, builder dues verification, and advocate attendance at Noida Sub-Registrar offices. Fixed fee, quoted upfront.')

@php
    $city      = 'Noida';
    $pageUrl   = 'https://dsdproperties.in/services/property-registry-noida';
    $phone     = '+918595002933';
    $phoneDisp = '+91 85950 02933';
    $waText    = rawurlencode('Hello DSD Properties, I need help with a property registry in Noida. Please share the process and fees.');

    $badges = [
        'Deeds drafted by our in-house advocates',
        'Noida Authority dues & lease status verified before drafting',
        'Attendance at Noida Sub-Registrar offices',
    ];

    $sros = [
        ['name' => 'SRO Noida — Sector 33', 'covers' => 'Sectors 1–50, most Noida Authority residential sectors, commercial and industrial sectors in the older belt.'],
        ['name' => 'SRO Noida — Sector 39', 'covers' => 'Sectors 51–100 and the newer residential sectors of Noida including Expressway-adjacent sectors.'],
        ['name' => 'SRO Noida — Sector 45', 'covers' => 'Sectors 100+ and the Noida Extension / sector-wise boundaries; also covers select commercial zones.'],
        ['name' => 'SRO Dadri',             'covers' => 'Properties in the Dadri tehsil area, including villages on the Noida-Greater Noida boundary and the rural belt.'],
    ];

    $deeds = [
        ['title' => 'Agreement to Sell (ATS)', 'body' => 'Payment milestones with dates, token forfeiture terms, the seller\'s obligation to obtain Noida Authority\'s NOC and clear all builder dues before execution, and a written exit clause if dues cannot be confirmed before the agreement period ends.'],
        ['title' => 'Sale Deed (Bainama)',      'body' => 'Flat number, floor, sector, plot number and super built-up area in the same unit as the allotment letter, lease deed details, e-Stamp certificate number, full payment schedule, and title warranty and indemnity clauses that survive registration.'],
        ['title' => 'Gift Deed & Family Partition', 'body' => 'Drafted to qualify for the concessional flat stamp duty for transfers between blood relatives in Uttar Pradesh, with the relationship evidence the Sub-Registrar will ask to see attached correctly.'],
        ['title' => 'Supporting instruments',   'body' => 'Power of Attorney for NRI or out-of-station sellers, relinquishment deed, sub-lease deed for leasehold properties, rectification deed, and possession letters.'],
    ];

    $steps = [
        ['label' => 'Reviewed within 24 working hours', 'title' => 'Send the papers', 'body' => 'Share the allotment letter, lease deed, previous sale deed, Noida Authority dues certificate, RERA registration certificate, and identity proof of both parties on WhatsApp. We read the title chain first — including lease status, outstanding builder dues and RERA compliance — because most problems are already visible in the original lease deed.'],
        ['label' => 'You approve before anything is stamped', 'title' => 'Draft and review', 'body' => 'One of our advocates drafts the deed and sends you a PDF. You get one walkthrough call to understand each clause, and revisions until the draft says what you actually agreed. Nothing moves to stamping until you confirm in writing.'],
        ['label' => 'Verified against the published list', 'title' => 'Duty calculation and slot', 'body' => 'We pull the circle rate for your specific sector from the Gautam Buddha Nagar district schedule, compute duty on the higher of circle rate and agreed consideration, prepare the e-Stamp application in the buyer\'s name, and book the slot at the correct SRO.'],
        ['label' => 'Someone stands with you', 'title' => 'Execution day', 'body' => 'Your advocate attends — token, biometric and photo capture, witness formalities, answering the reader\'s queries on the lease deed and allotment letter, and confirming the endorsed receipt is generated before you leave the building.'],
    ];

    $pricing = [
        ['item' => 'Agreement to Sell — drafting and review', 'note' => 'Includes one revision round'],
        ['item' => 'Sale deed — drafting, duty computation and execution-day attendance', 'note' => 'Government stamp duty and registration fee paid separately by you, directly'],
        ['item' => 'Gift deed or family partition', 'note' => 'Relationship documentation assistance included'],
    ];

    $comparison = [
        ['feature' => 'Draft quality',       'broker' => 'Reused template with names swapped',  'self' => 'Typist-shop format, clauses unread',  'dsd' => 'Advocate-drafted against the actual allotment letter and lease deed'],
        ['feature' => 'Circle rate check',   'broker' => 'Estimated verbally',                   'self' => 'Whatever the deed writer assumes',    'dsd' => 'Sector-level rate pulled from the Gautam Buddha Nagar district schedule'],
        ['feature' => 'Dues verification',   'broker' => 'Taken on seller\'s word',              'self' => 'Rarely checked independently',        'dsd' => 'Noida Authority dues certificate verified before drafting'],
        ['feature' => 'Sub-Registrar day',   'broker' => 'You are handed to a tout',             'self' => 'You queue and guess',                 'dsd' => 'Advocate attends with you, start to receipt'],
        ['feature' => 'After registration',  'broker' => 'Contact goes cold',                    'self' => 'Mutation often forgotten',            'dsd' => 'Written dakhil kharij roadmap handed over the same week'],
        ['feature' => 'What you pay',        'broker' => 'Percentage of deal value',             'self' => 'Unpredictable',                       'dsd' => 'Fixed fee, quoted before work starts'],
    ];

    $problems = [
        ['icon' => '🏗️', 'title' => 'Builder dues transfer to the buyer if not cleared at registry', 'body' => 'In a Noida resale, any outstanding dues to Noida Authority — maintenance charges, interest on delayed installments, penalty for construction violations — follow the property, not the seller. A buyer who does not obtain and verify the dues clearance certificate from Noida Authority before registration can inherit years of unpaid charges and be refused mutation until they are cleared. Brokers rarely raise this because it can kill the deal.'],
        ['icon' => '📄', 'title' => 'Noida flats are leasehold — the sub-lease deed structure matters', 'body' => 'Noida Authority is the lessor for all land in Noida. What is registered when you buy a flat is a sub-lease deed, not a freehold sale deed. If the original lease deed between the builder and Noida Authority has violations — construction beyond sanctioned floors, OC not obtained, plot area discrepancy — those defects are passed on to every subsequent sub-lessee. A flat with an OC obtained for only a few floors but sold for all floors is a common version of this problem.'],
        ['icon' => '🙈', 'title' => 'Nobody explains what you are signing', 'body' => 'Between the token counter, biometric capture and the reader\'s queries, first-time buyers sign what they are handed. Clauses about payment mode, possession date and who bears past dues get read for the first time months later — often in a dispute.'],
    ];

    $relatedLinks = [
        ['href' => '/services/property-verification-noida', 'tag' => 'Service', 'title' => 'Property verification in Noida before you pay a token', 'arrow' => 'View service →'],
        ['href' => '/blog/igrsup-lucknow-property-search-tutorial', 'tag' => 'Tutorial', 'title' => 'Check any UP property on IGRSUP yourself', 'arrow' => 'Read →'],
        ['href' => '/blog/stamp-duty-registration-charges-lucknow-2026', 'tag' => 'Guide', 'title' => 'Stamp duty &amp; registration charges in UP 2026', 'arrow' => 'Read →'],
        ['href' => '/services/property-registry-greater-noida', 'tag' => 'Service', 'title' => 'Property registry assistance in Greater Noida', 'arrow' => 'View service →'],
    ];

    $faqs = [
        ['q' => 'Which Sub-Registrar office covers my Noida flat or plot?', 'a' => 'Noida has three Sub-Registrar offices — Sector 33, Sector 39 and Sector 45 — plus the Dadri SRO for the village-belt properties. Which SRO applies depends on your specific sector number, and the boundaries have been revised as new sectors were notified. We confirm the correct SRO from your sector number before booking any slot — a presentation at the wrong office is a wasted day.'],
        ['q' => 'Is a Noida flat freehold or leasehold?', 'a' => 'All land in Noida is owned by Noida Authority and given on 99-year lease. What you register when you buy a flat is a sub-lease deed — the builder sub-leases the flat to you from the original lease given by Noida Authority to the builder. This means the title chain has two layers: the original lease deed (builder–Noida Authority) and the sub-lease deeds (each subsequent sale). Defects in the original lease — construction violations, OC not obtained — pass through to all sub-leases.'],
        ['q' => 'How do I check builder dues to Noida Authority before buying a resale flat?', 'a' => 'You need a dues clearance certificate from Noida Authority, obtained on the basis of the allotment number and the seller\'s identity. The certificate shows outstanding installments, interest, maintenance and penalty charges. This must be obtained and verified before the agreement to sell is signed — not at the time of registration. We obtain and review the dues certificate as part of our pre-drafting review.'],
        ['q' => 'What is an OC (Occupancy Certificate) and why does it matter for registry?', 'a' => 'An Occupancy Certificate is issued by Noida Authority after it verifies that the building has been constructed as per the sanctioned plan. A flat in a building without an OC — or with an OC obtained only for some floors — is technically in an unauthorised structure. Banks may refuse home loans, and Noida Authority may include the flat in a future regularisation or demolition drive. We check OC status for the building before advising on whether to proceed to registry.'],
        ['q' => 'What are stamp duty rates in Noida in 2026?', 'a' => 'Stamp duty in Uttar Pradesh (which covers Noida / Gautam Buddha Nagar) is 7% for male buyers, with a 1% concession for women buyers subject to the ₹1 crore ceiling. The registration fee is 1% of the transaction value. Duty is computed on whichever is higher — the circle rate for your sector in the Gautam Buddha Nagar schedule, or the agreed consideration. We verify the applicable rate before the e-Stamp is generated.'],
        ['q' => 'Do I need RERA registration verified for a Noida resale?', 'a' => 'For a primary sale from the builder, RERA registration of the project is mandatory. For a resale flat, RERA does not directly govern the transaction — but checking whether the project was ever registered, and whether the builder has been subject to RERA recovery proceedings, gives you critical information about the building\'s compliance history. We check RERA UP for project status as part of the pre-drafting review.'],
        ['q' => 'Who drafts the deed?', 'a' => 'Advocates on our team enrolled with the Bar Council, acting in their professional capacity. DSD Properties coordinates the engagement and handles the registry logistics; the legal drafting is advocate work. Your draft is prepared against your actual allotment letter, lease deed and revenue record, not a typist-shop format.'],
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            ['@type' => 'ProfessionalService', '@id' => $pageUrl . '#service', 'name' => 'Property Registry Assistance in Noida — DSD Properties', 'description' => 'Sale deed drafting, Noida Authority dues and lease status checks, and advocate attendance at Noida Sub-Registrar offices.', 'url' => $pageUrl, 'telephone' => $phone, 'priceRange' => '₹5000-₹25000', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Noida', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'], 'areaServed' => ['@type' => 'GeoCircle', 'geoMidpoint' => ['@type' => 'GeoCoordinates', 'latitude' => 28.5355, 'longitude' => 77.3910], 'geoRadius' => '20000'], 'serviceType' => 'Property registration and deed drafting assistance'],
            ['@type' => 'FAQPage', '@id' => $pageUrl . '#faq', 'mainEntity' => collect($faqs)->map(fn($f) => ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]])->all()],
            ['@type' => 'BreadcrumbList', '@id' => $pageUrl . '#breadcrumb', 'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://dsdproperties.in/'], ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://dsdproperties.in/services'], ['@type' => 'ListItem', 'position' => 3, 'name' => 'Property Registry Assistance in Noida', 'item' => $pageUrl]]],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
@include('pages.services.partials.registry-page-content')
@endsection
