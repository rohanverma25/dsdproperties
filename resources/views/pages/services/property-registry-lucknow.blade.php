
@extends('layouts.user-app')

@section('title', 'Property Registry Help in Lucknow — Sale Deed & Advocate | DSD')
@section('meta_description', 'Registering property in Lucknow? We draft the sale deed, check circle rate and stamp duty, and our advocate attends the registry. Fixed fee.')
@section('og_image', 'https://dsdproperties.in/images/services/property-registry-lucknow.webp')

@php

    $city      = 'Lucknow';
    $pageUrl   = 'https://dsdproperties.in/services/property-registry-lucknow';
    $phone     = '+918595002933';
    $phoneDisp = '+91 85950 02933';
    $waText    = rawurlencode('Hello DSD Properties, I need help with a property registry in Lucknow. Please share the process and fees.');

    $badges = [
        'Deeds drafted by our in-house advocates',
        'Circle rate & stamp duty checked on IGRSUP',
        'Attendance at all 5 Lucknow Sub-Registrar offices',
    ];

    $sros = [
        ['name' => 'SRO Lucknow Sadar', 'covers' => 'Hazratganj, Aminabad, Gomti Nagar, Aliganj, Indira Nagar and the older municipal wards. Circle rates are published as Sadar-1 to Sadar-5.'],
        ['name' => 'SRO Sarojini Nagar', 'covers' => 'Shaheed Path, Sushant Golf City, Vrindavan Yojna, Kanpur Road and Sultanpur Road belt. Circle rates published as Sarojini Nagar-1 and 2.'],
        ['name' => 'SRO Bakshi Ka Talab', 'covers' => 'Sitapur Road corridor, IIM Road belt, Kursi Road villages and the northern rural blocks.'],
        ['name' => 'SRO Mohanlalganj', 'covers' => 'Southern rural belt including the Raebareli Road villages and Gosainganj side.'],
        ['name' => 'SRO Malihabad', 'covers' => 'Western rural belt including Malihabad, Kakori side villages and the Hardoi Road blocks.'],
    ];

    $deeds = [
        [
            'title' => 'Agreement to Sell (ATS)',
            'body'  => 'Payment milestones with dates, token forfeiture terms stated in figures rather than adjectives, the seller\'s obligation to clear encumbrances before execution, and a written exit route if a title defect surfaces during the agreement period.',
        ],
        [
            'title' => 'Sale Deed (Bainama)',
            'body'  => 'Boundaries described on all four sides, khasra or gata number, plot area in the same unit as the parent deed, e-Stamp certificate number, full payment schedule with mode of payment, and title warranty and indemnity clauses that survive registration.',
        ],
        [
            'title' => 'Gift Deed (Dan Patra) & Family Partition',
            'body'  => 'Drafted to qualify for the concessional flat stamp duty notified for transfers between blood relatives in Uttar Pradesh, with the relationship evidence the Sub-Registrar will ask to see attached correctly.',
        ],
        [
            'title' => 'Supporting instruments',
            'body'  => 'Power of Attorney for NRI or out-of-station sellers, relinquishment deed, rectification deed for errors in an already-registered document, and possession letters.',
        ],
    ];

    $steps = [
        [
            'label' => 'Reviewed within 24 working hours',
            'title' => 'Send the papers',
            'body'  => 'Share the previous title deed, khatauni or khasra extract, identity proof of both parties, and the agreed price and payment terms — on WhatsApp or through the portal. We read the parent deed first, because most registry problems are already visible in it.',
        ],
        [
            'label' => 'You approve before anything is stamped',
            'title' => 'Draft and review',
            'body'  => 'One of our advocates drafts the deed and we send you a PDF. You get one walkthrough call to understand each clause, and revisions until the draft says what you actually agreed. Nothing moves to stamping until you confirm in writing.',
        ],
        [
            'label' => 'Verified against the published list',
            'title' => 'Duty calculation and slot',
            'body'  => 'We pull the circle rate for your specific ward or village from the district list, compute duty on the higher of circle rate and agreed consideration, prepare the e-Stamp application in the buyer\'s name for you to pay, and book the execution slot at the correct Sub-Registrar office.',
        ],
        [
            'label' => 'Someone stands with you',
            'title' => 'Execution day',
            'body'  => 'Your advocate attends with you — token, biometric and photo capture, witness formalities, answering the reader\'s queries, and confirming the endorsed receipt is generated before you leave the building.',
        ],
    ];

    // TODO(Dheer): confirm these three figures before publishing.
    $pricing = [
        ['item' => 'Agreement to Sell — drafting and review', 'fee' => '₹—,—',  'note' => 'Includes one revision round'],
        ['item' => 'Sale deed — drafting, duty computation and execution-day attendance', 'fee' => '₹—,—', 'note' => 'Government stamp duty and registration fee paid separately by you, directly'],
        ['item' => 'Gift deed or family partition', 'fee' => '₹—,—', 'note' => 'Relationship documentation assistance included'],
    ];

    $comparison = [
        ['feature' => 'Draft quality',        'broker' => 'Reused template with names swapped', 'self' => 'Typist-shop format, clauses unread', 'dsd' => 'Advocate-drafted, with title warranty and indemnity clauses'],
        ['feature' => 'Circle rate check',    'broker' => 'Estimated verbally',                  'self' => 'Whatever the deed writer assumes',  'dsd' => 'Ward-level rate pulled from the published district list'],
        ['feature' => 'Concessions applied',  'broker' => 'Rarely raised',                       'self' => 'Missed if you did not know to ask',  'dsd' => 'Female buyer and blood-relative concessions checked for eligibility'],
        ['feature' => 'Sub-Registrar day',    'broker' => 'You are handed to a tout',            'self' => 'You queue and guess',               'dsd' => 'Advocate attends with you, start to receipt'],
        ['feature' => 'After registration',   'broker' => 'Contact goes cold',                   'self' => 'Mutation often forgotten',          'dsd' => 'Written dakhil kharij roadmap handed over the same week'],
        ['feature' => 'What you pay',         'broker' => 'Percentage of deal value',            'self' => 'Unpredictable',                     'dsd' => 'Fixed fee, quoted before work starts'],
    ];

    $faqs = [
        [
            'q' => 'Which Sub-Registrar office will register my Lucknow property?',
            'a' => 'It depends on where the property physically sits, not on where you live. Lucknow district has five Sub-Registrar offices — Sadar, Sarojini Nagar, Bakshi Ka Talab, Mohanlalganj and Malihabad. Sadar covers the older city wards, Sarojini Nagar covers the Shaheed Path, Sushant Golf City and Sultanpur Road belt, and the other three cover the northern, southern and western rural blocks. Registering at the wrong office is a common cause of rejection at the counter. We confirm the correct office from the village or colony name before booking any slot.',
        ],
        [
            'q' => 'What are the stamp duty and registration charges in Lucknow in 2026?',
            'a' => 'Stamp duty in Uttar Pradesh is charged at 7 percent for male buyers, with a 1 percent concession available to women buyers subject to the value ceiling notified by the state. The registration fee is 1 percent of the value. Duty is calculated on whichever is higher — the circle rate or the agreed consideration — so the ward-level circle rate matters more than the price you negotiated. Rates and concessions change by notification, so we verify the current position on IGRSUP for your specific transaction before the e-Stamp is purchased.',
        ],
        [
            'q' => 'Can a woman buyer really save up to ₹1 lakh on stamp duty?',
            'a' => 'The Uttar Pradesh Cabinet raised the ceiling for the 1 percent women buyer concession from ₹10 lakh to ₹1 crore, which lifts the maximum benefit from ₹10,000 to ₹1 lakh. Two things to be clear about: the concession does not apply at all if the property value crosses ₹1 crore, and the treatment of joint ownership depends on how the deed is framed. We check eligibility against the current notification and the ownership structure you want before drafting, rather than after.',
        ],
        [
            'q' => 'Is an Agreement to Sell legally binding before the sale deed is executed?',
            'a' => 'An Agreement to Sell creates a contractual obligation between the parties, but under Section 54 of the Transfer of Property Act it does not by itself transfer ownership — only a registered sale deed does that. What the agreement protects is your right to enforce the bargain, including specific performance, and your right to the token amount back on the terms written into it. That is why the forfeiture and refund clauses need to be specific. A vague agreement is worth very little when the seller changes his mind.',
        ],
        [
            'q' => 'Who actually drafts my deed?',
            'a' => 'Advocates on our own team, all enrolled with the Bar Council, in their professional capacity as advocates. Your draft is not produced by a deed writer or filled into a typist-shop format. DSD Properties is the property services company that coordinates the engagement, arranges the documentation and handles the registry logistics around it; the legal drafting itself is advocate work. If a matter turns contentious and needs litigation, we say so and connect you directly with the advocate rather than routing it through us.',
        ],
        [
            'q' => 'What happens if the deed is registered below the circle rate?',
            'a' => 'Under Section 47-A of the Indian Stamp Act, 1899 as amended in Uttar Pradesh, the Collector can reopen an instrument where the value appears understated, and recover the deficient duty along with a penalty. These notices often arrive months or years after registration, by which time the seller is unreachable. Getting the ward-level circle rate right on the day is considerably cheaper than defending a deficiency proceeding later.',
        ],
        [
            'q' => 'Do you handle dakhil kharij (mutation) after the registry?',
            'a' => 'Mutation is a separate service, but every registry client receives a written roadmap — which application goes to which tehsil, the documents to attach, the fee, and the realistic timeline — handed over in the same week as registration. Registration transfers title; mutation updates the revenue record so the property is recorded in your name for tax and future sale. Skipping it causes problems at resale, not at purchase, which is why so many buyers discover the gap years later.',
        ],
        [
            'q' => 'Can an NRI seller or buyer register through a Power of Attorney?',
            'a' => 'Yes, but the Power of Attorney has to be drawn and attested correctly for the Sub-Registrar to accept it — executed before the Indian Consulate or apostilled depending on the country, then stamped in Uttar Pradesh within the prescribed period after it reaches India. A defective POA is one of the more common reasons an execution slot is wasted. We review the POA before the slot is booked, not on the day.',
        ],
    ];

    $problems = [
        ['icon' => '⚠️', 'title' => 'The deed is a template with the names changed', 'body' => 'Broker-supplied drafts routinely leave out the title warranty and indemnity clauses. Without them, you have no written recourse against the seller if a family partition suit, an undisclosed bank charge, or a co-sharer\'s claim surfaces after registration.'],
        ['icon' => '📋', 'title' => 'Duty is computed on the wrong circle rate', 'body' => 'Lucknow\'s circle rates are published ward by ward — Sadar alone is split across five separate schedules and Sarojini Nagar across two. Applying a neighbouring ward\'s rate under-stamps the deed, and under Section 47-A of the Indian Stamp Act the Collector can reopen the instrument and recover the shortfall with penalty long after possession has changed hands.'],
        ['icon' => '🙈', 'title' => 'Nobody explains what you are signing', 'body' => 'Between the token counter, biometric capture and the reader\'s queries, first-time buyers sign what they are handed. Clauses about payment mode, possession date and who bears past dues get read for the first time months later — often in a dispute.'],
    ];

    $relatedLinks = [
        ['href' => '/blog/stamp-duty-registration-charges-lucknow-2026', 'tag' => 'Guide', 'title' => 'Stamp duty &amp; registration charges in Lucknow 2026', 'arrow' => 'Read →'],
        ['href' => '/blog/igrsup-lucknow-property-search-tutorial',       'tag' => 'Tutorial', 'title' => 'Check any Lucknow property on IGRSUP yourself', 'arrow' => 'Read →'],
        ['href' => '/services/property-verification-lucknow',              'tag' => 'Service',  'title' => 'Property verification before you pay a token', 'arrow' => 'View service →'],
        ['href' => '/blog/transforming-agricultural-land-residential-property-lucknow', 'tag' => 'Guide', 'title' => 'Converting agricultural land to residential use', 'arrow' => 'Read →'],
    ];

    // ---------- JSON-LD (built from the same arrays) ----------
    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            [
                '@type'       => 'ProfessionalService',
                '@id'         => $pageUrl . '#service',
                'name'        => 'Property Registry Assistance in Lucknow — DSD Properties',
                'description' => 'Sale deed and agreement-to-sell drafting, circle rate and stamp duty computation, and advocate attendance at Lucknow Sub-Registrar offices.',
                'url'         => $pageUrl,
                'telephone'   => $phone,
                'priceRange'  => '₹5000-₹25000',
                'image'       => 'https://dsdproperties.in/images/services/property-registry-lucknow.webp',
                'address'     => [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => 'Sanjar Gold Complex, Vrindavan Sector 2',
                    'addressLocality' => 'Lucknow',
                    'addressRegion'   => 'Uttar Pradesh',
                    'postalCode'      => '226029',
                    'addressCountry'  => 'IN',
                ],
                'areaServed'  => [
                    '@type'       => 'GeoCircle',
                    'geoMidpoint' => ['@type' => 'GeoCoordinates', 'latitude' => 26.8467, 'longitude' => 80.9462],
                    'geoRadius'   => '40000',
                ],
                'serviceType' => 'Property registration and deed drafting assistance',
            ],
            [
                '@type'      => 'FAQPage',
                '@id'        => $pageUrl . '#faq',
                'mainEntity' => collect($faqs)->map(fn ($f) => [
                    '@type'          => 'Question',
                    'name'           => $f['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                ])->all(),
            ],
            [
                '@type'           => 'BreadcrumbList',
                '@id'             => $pageUrl . '#breadcrumb',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',     'item' => 'https://dsdproperties.in/'],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://dsdproperties.in/services'],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => 'Property Registry Assistance in Lucknow', 'item' => $pageUrl],
                ],
            ],
        ],
    ];
@endphp

@push('head')
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
@include('pages.services.partials.registry-page-content')
@endsection
