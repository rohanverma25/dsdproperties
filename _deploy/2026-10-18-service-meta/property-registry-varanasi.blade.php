@extends('layouts.user-app')

@section('title', 'Property Registry Assistance in Varanasi — Sale Deed Drafting & Sub-Registrar Support | DSD Properties')
@section('meta_description', 'Sale deed drafting, Devasthan and Waqf Board title checks, and advocate attendance at Varanasi Sub-Registrar offices. Fixed fee, quoted upfront. Call or WhatsApp DSD Properties.')

@php
    $city      = 'Varanasi';
    $pageUrl   = 'https://dsdproperties.in/services/property-registry-varanasi';
    $phone     = '+918595002933';
    $phoneDisp = '+91 85950 02933';
    $waText    = rawurlencode('Hello DSD Properties, I need help with a property registry in Varanasi. Please share the process and fees.');

    $badges = [
        'Deeds drafted by our in-house advocates',
        'Devasthan & Waqf Board titles reviewed before drafting',
        'Attendance at all Varanasi Sub-Registrar offices',
    ];

    $sros = [
        ['name' => 'SRO Varanasi Sadar', 'covers' => 'Cantonment, Nadesar, Sigra, Lanka, BHU campus-adjacent colonies and the older municipal wards of Varanasi city.'],
        ['name' => 'SRO Varanasi City', 'covers' => 'Kotwali, Dashashwamedh, Bhelupura, Luxa and the dense inner-city wards including the ghat belt and heritage zone.'],
        ['name' => 'SRO Pindra', 'covers' => 'North-eastern blocks of Varanasi district including Pindra tehsil villages and the Ganga-side rural stretch.'],
        ['name' => 'SRO Ramnagar', 'covers' => 'Southern bank of the Ganga — Ramnagar town, Chunar Road belt and villages across the river from the main city.'],
        ['name' => 'SRO Chiraigaon', 'covers' => 'South-western rural blocks of Varanasi district including Chiraigaon, Arajiline and NH-2 corridor villages.'],
    ];

    $deeds = [
        ['title' => 'Agreement to Sell (ATS)', 'body' => 'Payment milestones with dates, token forfeiture terms stated in figures, the seller\'s obligation to clear encumbrances before execution, and a written exit route if a title defect — including Devasthan or Waqf encumbrance — surfaces during the agreement period.'],
        ['title' => 'Sale Deed (Bainama)',      'body' => 'Boundaries described on all four sides, khasra or gata number, plot area in the same unit as the parent deed, e-Stamp certificate number, full payment schedule with mode, title warranty and indemnity clauses that survive registration.'],
        ['title' => 'Gift Deed & Family Partition', 'body' => 'Drafted to qualify for the concessional flat stamp duty for transfers between specified blood relatives in Uttar Pradesh, with the relationship evidence the Sub-Registrar will ask to see attached in the correct form.'],
        ['title' => 'Supporting instruments',   'body' => 'Power of Attorney for NRI or out-of-station sellers, relinquishment deed, rectification deed for errors in an already-registered document, and possession letters.'],
    ];

    $steps = [
        ['label' => 'Reviewed within 24 working hours', 'title' => 'Send the papers', 'body' => 'Share the previous title deed, khatauni extract, identity proof of both parties, and agreed price terms on WhatsApp. We read the parent deed first — including checking whether the property appears in any Devasthan or Waqf Board record — because most registry problems are already visible in it.'],
        ['label' => 'You approve before anything is stamped', 'title' => 'Draft and review', 'body' => 'One of our advocates drafts the deed and sends you a PDF. You get one walkthrough call to understand each clause, and revisions until the draft says what you actually agreed. Nothing moves to stamping until you confirm in writing.'],
        ['label' => 'Verified against the published list', 'title' => 'Duty calculation and slot', 'body' => 'We pull the circle rate for your specific ward or village from the Varanasi district schedule, compute duty on the higher of circle rate and agreed consideration, prepare the e-Stamp application in the buyer\'s name, and book the execution slot at the correct Sub-Registrar office.'],
        ['label' => 'Someone stands with you', 'title' => 'Execution day', 'body' => 'Your advocate attends — token, biometric and photo capture, witness formalities, answering the reader\'s queries, and confirming the endorsed receipt is generated before you leave the building.'],
    ];

    $pricing = [
        ['item' => 'Agreement to Sell — drafting and review', 'note' => 'Includes one revision round'],
        ['item' => 'Sale deed — drafting, duty computation and execution-day attendance', 'note' => 'Government stamp duty and registration fee paid separately by you, directly'],
        ['item' => 'Gift deed or family partition', 'note' => 'Relationship documentation assistance included'],
    ];

    $comparison = [
        ['feature' => 'Draft quality',       'broker' => 'Reused template with names swapped',   'self' => 'Typist-shop format, clauses unread',  'dsd' => 'Advocate-drafted, with title warranty and indemnity clauses'],
        ['feature' => 'Circle rate check',   'broker' => 'Estimated verbally',                    'self' => 'Whatever the deed writer assumes',    'dsd' => 'Ward-level rate pulled from the published Varanasi district list'],
        ['feature' => 'Concessions applied', 'broker' => 'Rarely raised',                         'self' => 'Missed if you did not know to ask',   'dsd' => 'Female buyer and blood-relative concessions checked for eligibility'],
        ['feature' => 'Sub-Registrar day',   'broker' => 'You are handed to a tout',              'self' => 'You queue and guess',                 'dsd' => 'Advocate attends with you, start to receipt'],
        ['feature' => 'After registration',  'broker' => 'Contact goes cold',                     'self' => 'Mutation often forgotten',            'dsd' => 'Written dakhil kharij roadmap handed over the same week'],
        ['feature' => 'What you pay',        'broker' => 'Percentage of deal value',              'self' => 'Unpredictable',                       'dsd' => 'Fixed fee, quoted before work starts'],
    ];

    $problems = [
        ['icon' => '🛕', 'title' => 'Devasthan and Waqf Board land is harder to spot than it looks', 'body' => 'Varanasi has a significant stock of properties on or adjacent to Devasthan (endowment/temple trust) and Waqf Board land. These titles do not always surface in a standard IGRSUP search — a parent deed that looks clean can be attached to a religious trust encumbrance that only shows up in a separate register. Buying without checking both records means the encumbrance transfers with the property.'],
        ['icon' => '📋', 'title' => 'Circle rates vary block by block in the heritage zone', 'body' => 'Varanasi\'s circle rate schedule is published ward-by-ward and the ghat-belt wards carry very different rates from the surrounding colonies. Applying the wrong rate under-stamps the deed, and under Section 47-A of the Indian Stamp Act the Collector can reopen the instrument and recover the shortfall with penalty — sometimes years after registration.'],
        ['icon' => '🙈', 'title' => 'Nobody explains what you are signing', 'body' => 'Between the token counter, biometric capture and the reader\'s queries, first-time buyers sign what they are handed. Clauses about payment mode, possession date and who bears past dues get read for the first time months later — often in a dispute.'],
    ];

    $relatedLinks = [
        ['href' => '/services/property-verification-varanasi', 'tag' => 'Service',  'title' => 'Property verification in Varanasi before you pay a token', 'arrow' => 'View service →'],
        ['href' => '/blog/igrsup-lucknow-property-search-tutorial', 'tag' => 'Tutorial', 'title' => 'Check any UP property on IGRSUP yourself', 'arrow' => 'Read →'],
        ['href' => '/blog/stamp-duty-registration-charges-lucknow-2026', 'tag' => 'Guide', 'title' => 'Stamp duty &amp; registration charges in UP 2026', 'arrow' => 'Read →'],
        ['href' => '/services/property-registry-lucknow', 'tag' => 'Service', 'title' => 'Property registry assistance in Lucknow', 'arrow' => 'View service →'],
    ];

    $faqs = [
        ['q' => 'Which Sub-Registrar office covers my Varanasi property?', 'a' => 'Varanasi district has five Sub-Registrar offices. Sadar covers the Cantonment, Sigra and Lanka belt; City (Kotwali) covers the inner-city and ghat wards; Pindra covers the north-eastern rural blocks; Ramnagar covers the south bank of the Ganga; and Chiraigaon covers the south-western rural blocks. Jurisdiction follows the property\'s location, not your address, and presenting a deed at the wrong office wastes a booked slot. We confirm the correct office from the village or colony name before booking.'],
        ['q' => 'How do I know if a Varanasi property is on Devasthan or Waqf land?', 'a' => 'These properties do not always appear in a standard IGRSUP revenue record search. Devasthan properties are tracked in a separate Devasthan register maintained by the UP Devasthan department, and Waqf Board properties are listed in the UP Waqf Board records. Checking both — alongside the khatauni — is part of how we review a parent deed before drafting. If the title is on or adjacent to trust land, we tell you before any work proceeds.'],
        ['q' => 'What are the stamp duty rates for Varanasi in 2026?', 'a' => 'Stamp duty in Uttar Pradesh is 7% for male buyers, with a 1% concession for women buyers subject to the ₹1 crore ceiling notified by the state. The registration fee is 1% of the transaction value. Duty is calculated on whichever is higher — the published circle rate for your ward or the agreed consideration. Varanasi\'s ghat-belt wards carry separate rates from the outer colonies. We verify the applicable rate on IGRSUP for your specific transaction before the e-Stamp is generated.'],
        ['q' => 'Can I register a property near the Varanasi ghats?', 'a' => 'You can, but the title chain needs careful scrutiny. Ghat-adjacent properties often have heritage zone notifications, old trust-land associations, or overlapping ownership claims that are not visible on the face of the parent deed. Additionally, the circle rates for central wards including the ghat belt differ significantly from peri-urban areas. We review the parent deed and the applicable registers before advising whether the title is clean enough to proceed to drafting.'],
        ['q' => 'Does the BHU campus area have any special registry restrictions?', 'a' => 'Properties immediately adjacent to the Banaras Hindu University campus are sometimes associated with endowment or trust ownership going back to the university\'s founding grants. The practical issue is that these titles can have co-sharers or original grantor claims that surface only when the property is sold, mortgaged, or put into dispute. A thorough parent deed review covering the full chain of title — not just the most recent sale deed — is what protects against this.'],
        ['q' => 'What is dakhil kharij and do I need it after registry?', 'a' => 'Dakhil kharij is mutation — the update to the revenue (khatauni) record that shows the property is now in your name. Registration transfers title; mutation updates the government\'s land records. Skipping it does not void the sale but causes significant problems at resale, at the time of taking a loan against the property, or when the property is involved in a partition. Every registry client receives a written dakhil kharij roadmap — application form, tehsil, documents required, fee — handed over the same week as registration.'],
        ['q' => 'Who actually drafts the deed?', 'a' => 'Advocates on our team enrolled with the Bar Council, acting in their professional capacity. Your draft is not produced by a deed writer or filled into a typist-shop format. DSD Properties coordinates the engagement and handles the registry logistics; the legal drafting is advocate work. If the matter needs litigation, we say so and connect you directly with the advocate.'],
        ['q' => 'Can an NRI seller register through a Power of Attorney?', 'a' => 'Yes, but the POA must be drawn and attested correctly — executed before the Indian Consulate or apostilled depending on the country, then stamped in Uttar Pradesh within the prescribed period after it reaches India. A defective POA is one of the more common reasons an execution slot is wasted. We review the POA before the slot is booked, not on the day.'],
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            ['@type' => 'ProfessionalService', '@id' => $pageUrl . '#service', 'name' => 'Property Registry Assistance in Varanasi — DSD Properties', 'description' => 'Sale deed drafting, Devasthan and Waqf Board title checks, and advocate attendance at Varanasi Sub-Registrar offices.', 'url' => $pageUrl, 'telephone' => $phone, 'priceRange' => '₹5000-₹25000', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Varanasi', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'], 'areaServed' => ['@type' => 'GeoCircle', 'geoMidpoint' => ['@type' => 'GeoCoordinates', 'latitude' => 25.3176, 'longitude' => 82.9739], 'geoRadius' => '40000'], 'serviceType' => 'Property registration and deed drafting assistance'],
            ['@type' => 'FAQPage', '@id' => $pageUrl . '#faq', 'mainEntity' => collect($faqs)->map(fn($f) => ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]])->all()],
            ['@type' => 'BreadcrumbList', '@id' => $pageUrl . '#breadcrumb', 'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://dsdproperties.in/'], ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://dsdproperties.in/services'], ['@type' => 'ListItem', 'position' => 3, 'name' => 'Property Registry Assistance in Varanasi', 'item' => $pageUrl]]],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
@include('pages.services.partials.registry-page-content')
@endsection
