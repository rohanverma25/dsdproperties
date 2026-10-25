@extends('layouts.user-app')

@section('title', 'Property Registry Help in Greater Noida — Sale Deed & Advocate | DSD')
@section('meta_description', 'Registering property in Greater Noida? We draft the sale deed, verify GNIDA dues and OC, and our advocate attends the registry. Fixed fee.')
@php
    $city      = 'Greater Noida';
    $pageUrl   = 'https://dsdproperties.in/services/property-registry-greater-noida';
    $phone     = '+918595002933';
    $phoneDisp = '+91 85950 02933';
    $waText    = rawurlencode('Hello DSD Properties, I need help with a property registry in Greater Noida. Please share the process and fees.');

    $badges = [
        'Deeds drafted by our in-house advocates',
        'GNIDA dues, OC & farmer land rights verified before drafting',
        'Attendance at Greater Noida Sub-Registrar offices',
    ];

    $sros = [
        ['name' => 'SRO Greater Noida — 1', 'covers' => 'Alpha, Beta, Gamma, Delta, Omicron and other older GNIDA sectors; also covers Group Housing Society areas in the western zones.'],
        ['name' => 'SRO Greater Noida — 2', 'covers' => 'Newer GNIDA sectors including Zeta, Eta, Xu, Pari Chowk belt and the Knowledge Park sectors.'],
        ['name' => 'SRO Dadri',             'covers' => 'Dadri tehsil villages including properties on the Noida–Greater Noida boundary and the rural belt beyond the GNIDA boundary.'],
        ['name' => 'SRO Jewar',             'covers' => 'Jewar tehsil area including villages near the upcoming Jewar International Airport and the south-eastern agricultural belt.'],
    ];

    $deeds = [
        ['title' => 'Agreement to Sell (ATS)', 'body' => 'Payment milestones with dates, token forfeiture terms, the seller\'s obligation to obtain GNIDA\'s NOC and clear all outstanding dues before execution, and a written exit clause if OC status or farmer land encumbrances cannot be confirmed during the agreement period.'],
        ['title' => 'Sale Deed (Bainama)',      'body' => 'Flat number, tower, sector, super built-up area in the same unit as the allotment letter, lease deed details, e-Stamp certificate number, full payment schedule, and title warranty and indemnity clauses that survive registration.'],
        ['title' => 'Gift Deed & Family Partition', 'body' => 'Drafted to qualify for the concessional flat stamp duty for transfers between blood relatives in Uttar Pradesh, with the relationship evidence the Sub-Registrar will ask to see attached correctly.'],
        ['title' => 'Supporting instruments',   'body' => 'Power of Attorney for NRI or out-of-station sellers, relinquishment deed, sub-lease deed for leasehold properties, rectification deed, and possession letters.'],
    ];

    $steps = [
        ['label' => 'Reviewed within 24 working hours', 'title' => 'Send the papers', 'body' => 'Share the allotment letter, lease deed, previous sale deed, GNIDA dues certificate, OC or Completion Certificate, RERA certificate, and identity proof of both parties on WhatsApp. We read the title chain first — including farmer land status, outstanding builder dues and OC compliance — because most registry problems are already visible at this stage.'],
        ['label' => 'You approve before anything is stamped', 'title' => 'Draft and review', 'body' => 'One of our advocates drafts the deed and sends you a PDF. You get one walkthrough call to understand each clause, and revisions until the draft says what you actually agreed. Nothing moves to stamping until you confirm in writing.'],
        ['label' => 'Verified against the published list', 'title' => 'Duty calculation and slot', 'body' => 'We pull the circle rate for your specific sector from the Gautam Buddha Nagar district schedule, compute duty on the higher of circle rate and agreed consideration, prepare the e-Stamp application in the buyer\'s name, and book the slot at the correct Sub-Registrar office.'],
        ['label' => 'Someone stands with you', 'title' => 'Execution day', 'body' => 'Your advocate attends — token, biometric and photo capture, witness formalities, answering the reader\'s queries on the lease deed and GNIDA allotment, and confirming the endorsed receipt is generated before you leave the building.'],
    ];

    $pricing = [
        ['item' => 'Agreement to Sell — drafting and review', 'note' => 'Includes one revision round'],
        ['item' => 'Sale deed — drafting, duty computation and execution-day attendance', 'note' => 'Government stamp duty and registration fee paid separately by you, directly'],
        ['item' => 'Gift deed or family partition', 'note' => 'Relationship documentation assistance included'],
    ];

    $comparison = [
        ['feature' => 'Draft quality',       'broker' => 'Reused template with names swapped',  'self' => 'Typist-shop format, clauses unread',  'dsd' => 'Advocate-drafted against the actual allotment letter and lease deed'],
        ['feature' => 'Circle rate check',   'broker' => 'Estimated verbally',                   'self' => 'Whatever the deed writer assumes',    'dsd' => 'Sector-level rate pulled from Gautam Buddha Nagar district schedule'],
        ['feature' => 'GNIDA dues',          'broker' => 'Taken on seller\'s word',              'self' => 'Rarely checked independently',        'dsd' => 'GNIDA dues certificate and OC status verified before drafting'],
        ['feature' => 'Sub-Registrar day',   'broker' => 'You are handed to a tout',             'self' => 'You queue and guess',                 'dsd' => 'Advocate attends with you, start to receipt'],
        ['feature' => 'After registration',  'broker' => 'Contact goes cold',                    'self' => 'Mutation often forgotten',            'dsd' => 'Written dakhil kharij roadmap handed over the same week'],
        ['feature' => 'What you pay',        'broker' => 'Percentage of deal value',             'self' => 'Unpredictable',                       'dsd' => 'Fixed fee, quoted before work starts'],
    ];

    $problems = [
        ['icon' => '🌾', 'title' => 'Farmer land (Section 17 abadi plots) transfers without valid title', 'body' => 'When GNIDA acquired agricultural land from farmers, certain residential plots within the original village boundaries (abadi) were excluded from acquisition. These plots — and some parcels where farmers were given "return plots" as compensation — have title histories that are different from GNIDA-allocated plots. Builders and agents sometimes sell these as ordinary GNIDA property. The distinction matters enormously: an abadi plot has a very different title chain, different registration route and different encumbrance exposure.'],
        ['icon' => '🏗️', 'title' => 'GNIDA builder dues transfer to the buyer if not cleared', 'body' => 'Outstanding GNIDA dues — whether they are installment arrears, interest, penalty or maintenance charges owed by the builder — follow the property into the buyer\'s name on sub-lease registration. A buyer who does not obtain and verify the GNIDA dues certificate before signing an agreement to sell can inherit years of accumulated charges and face refusal of mutation until they are settled. Brokers rarely raise this because it can kill the deal at the negotiation stage.'],
        ['icon' => '🙈', 'title' => 'Nobody explains what you are signing', 'body' => 'Between the token counter, biometric capture and the reader\'s queries, first-time buyers sign what they are handed. Clauses about payment mode, possession date and who bears past dues get read for the first time months later — often in a dispute.'],
    ];

    $relatedLinks = [
        ['href' => '/services/property-verification-greater-noida', 'tag' => 'Service', 'title' => 'Property verification in Greater Noida before you pay a token', 'arrow' => 'View service →'],
        ['href' => '/blog/igrsup-lucknow-property-search-tutorial', 'tag' => 'Tutorial', 'title' => 'Check any UP property on IGRSUP yourself', 'arrow' => 'Read →'],
        ['href' => '/blog/stamp-duty-registration-charges-lucknow-2026', 'tag' => 'Guide', 'title' => 'Stamp duty &amp; registration charges in UP 2026', 'arrow' => 'Read →'],
        ['href' => '/services/property-registry-noida', 'tag' => 'Service', 'title' => 'Property registry assistance in Noida', 'arrow' => 'View service →'],
    ];

    $faqs = [
        ['q' => 'Which Sub-Registrar office covers my Greater Noida property?', 'a' => 'Greater Noida has two main GNIDA-area SROs (SRO-1 and SRO-2) that divide the GNIDA sectors between them, plus the Dadri SRO for village-belt properties and the Jewar SRO for the Jewar tehsil area. Which office applies depends on your specific sector. We confirm the correct office from your sector number before booking any slot — presenting at the wrong office wastes a day.'],
        ['q' => 'Is Greater Noida property freehold or leasehold?', 'a' => 'All land in Greater Noida is owned by GNIDA and given on 90-year lease. What is registered when you buy a flat or plot is a sub-lease deed — the builder sub-leases the unit to you from the original lease given by GNIDA to the builder. This means the title chain has two layers. Defects in the original lease — construction violations, OC not obtained, plot area discrepancy — pass through to all sub-lessees. Unlike freehold, the lease can lapse or be revoked by GNIDA in specific circumstances.'],
        ['q' => 'How do I verify GNIDA builder dues before buying?', 'a' => 'You need a dues clearance certificate from GNIDA, obtained on the basis of the allotment number. The certificate shows outstanding installments, interest, penalty and maintenance charges owed by the builder. This must be obtained before the agreement to sell is signed — not at the time of registration. We obtain and review this certificate as part of our pre-drafting review, and our draft agreement to sell requires the seller to produce a no-dues certificate before the stamp duty is paid.'],
        ['q' => 'What is an OC and why does it matter for Greater Noida registry?', 'a' => 'An Occupancy Certificate is issued by GNIDA after verifying that the building was constructed as per the sanctioned plan. A flat in a building without an OC is in a technically unauthorised structure — banks may refuse home loans, and GNIDA can include it in regularisation or enforcement proceedings. We check OC status for the specific building before advising on whether to proceed to registry. Projects where OC was obtained only for some floors are a common problem in Greater Noida.'],
        ['q' => 'What are "farmer land" or abadi plots in Greater Noida?', 'a' => 'When GNIDA acquired agricultural land, certain residential plots within the original village boundaries (abadi area) were excluded from acquisition. Farmers were also given "return plots" as part of the compensation settlement. These plots have a completely different title chain from GNIDA-allocated plots — they are not covered by the standard builder-GNIDA lease structure and have different encumbrance and encroachment exposures. Buying an abadi or return plot without understanding this distinction can leave you with a title that is difficult to mortgage or resell.'],
        ['q' => 'What are stamp duty rates in Greater Noida in 2026?', 'a' => 'Stamp duty in Uttar Pradesh (which covers Greater Noida / Gautam Buddha Nagar) is 7% for male buyers, with a 1% concession for women buyers subject to the ₹1 crore ceiling. The registration fee is 1% of the transaction value. Duty is computed on whichever is higher — the circle rate for your specific sector in the Gautam Buddha Nagar schedule, or the agreed consideration. We verify the applicable rate before the e-Stamp is generated.'],
        ['q' => 'Does buying near Jewar Airport area have special issues?', 'a' => 'Yes. Land acquisition for the Jewar International Airport has been ongoing in multiple phases. Properties in the Jewar tehsil — especially agricultural land — may be subject to outstanding acquisition notifications, acquisition awards, or be in the future expansion zone. Selling such land in the middle of an acquisition process is legally possible but the title is clouded, and the state can proceed with acquisition at the notified award rate regardless of what you paid. We check acquisition status for Jewar belt properties before any work begins.'],
        ['q' => 'Who drafts the deed?', 'a' => 'Advocates on our team enrolled with the Bar Council, acting in their professional capacity. DSD Properties coordinates the engagement and handles the registry logistics; the legal drafting is advocate work. Your draft is prepared against your actual allotment letter, lease deed and revenue record, not a typist-shop format.'],
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            ['@type' => 'ProfessionalService', '@id' => $pageUrl . '#service', 'name' => 'Property Registry Assistance in Greater Noida — DSD Properties', 'description' => 'Sale deed drafting, GNIDA dues and OC checks, farmer land due diligence, and advocate attendance at Greater Noida Sub-Registrar offices.', 'url' => $pageUrl, 'telephone' => $phone, 'priceRange' => '₹5000-₹25000', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Greater Noida', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'], 'areaServed' => ['@type' => 'GeoCircle', 'geoMidpoint' => ['@type' => 'GeoCoordinates', 'latitude' => 28.4744, 'longitude' => 77.5040], 'geoRadius' => '20000'], 'serviceType' => 'Property registration and deed drafting assistance'],
            ['@type' => 'FAQPage', '@id' => $pageUrl . '#faq', 'mainEntity' => collect($faqs)->map(fn($f) => ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]])->all()],
            ['@type' => 'BreadcrumbList', '@id' => $pageUrl . '#breadcrumb', 'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://dsdproperties.in/'], ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://dsdproperties.in/services'], ['@type' => 'ListItem', 'position' => 3, 'name' => 'Property Registry Assistance in Greater Noida', 'item' => $pageUrl]]],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
@include('pages.services.partials.registry-page-content')
@endsection
