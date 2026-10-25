<?php

/*
|--------------------------------------------------------------------------
| Mobile sticky CTA — one button per page, worded for that page
|--------------------------------------------------------------------------
| Resolved by App\Support\PageCta from the page's slug (and blog tag).
| Order of checks: seller pages → area rules (first match wins) → legal tags → default.
|
| Area rules: 'match' is a list of slug fragments; the first rule with any fragment
| contained in the slug wins, so put more specific fragments first. 'name' is dropped
| into area_text / area_message — keep it short so the button fits one line on a phone.
*/

return [

    'whatsapp_number' => '918595002933',

    'default' => 'Buy Property in Lucknow',

    // Seller guides → seller account page instead of WhatsApp
    'seller' => [
        'text'       => 'Sell Property in Lucknow',
        'url'        => '/seller/register',
        'tags'       => ['Seller Guide', 'Selling Tips'],
        'slug_match' => ['sell'],   // e.g. best-time-to-sell…, …-sellers-guide-…
    ],

    // Legal / verification articles with no specific area
    'legal' => [
        'text'    => 'Get Legal Help for Your Property',
        'message' => 'Hi, I need legal help regarding a property.',
        'tags'    => ['Legal Advice', 'Legal Guide', 'Property Law', 'Property Verification'],
    ],

    // Area guides: button and WhatsApp message built from each rule's 'name'
    'area_text'    => 'Talk to :name Expert — Free',
    'area_message' => "Hi, I read your :name guide. I'd like to talk to an expert about :name — price, availability and verification.",

    'areas' => [
        ['match' => ['it-city-wellness-city'],               'name' => 'Land Pooling'],
        ['match' => ['it-city'],                             'name' => 'IT City'],
        ['match' => ['wellness-city'],                       'name' => 'Wellness City'],
        ['match' => ['ai-city'],                             'name' => 'AI City'],
        ['match' => ['saumitra-vihar'],                      'name' => 'Saumitra Vihar'],
        ['match' => ['varun-vihar'],                         'name' => 'Varun Vihar'],
        ['match' => ['naimish-nagar'],                       'name' => 'Naimish Nagar'],
        ['match' => ['anant-nagar'],                         'name' => 'Anant Nagar'],
        ['match' => ['atal-nagar'],                          'name' => 'Atal Nagar'],
        ['match' => ['vashishtha-nagar'],                    'name' => 'Vashishtha Nagar'],
        ['match' => ['vrindavan-yojna', 'vrindavan-yojana'], 'name' => 'Vrindavan Yojana'],
        ['match' => ['park-view-apartment'],                 'name' => 'LDA Park View'],
        ['match' => ['lake-view-apartment'],                 'name' => 'LDA Lake View'],
        ['match' => ['narmada-apartment'],                   'name' => 'LDA Narmada'],
        ['match' => ['sardar-vallabhbhai-patel'],            'name' => 'LDA Sardar Patel'],
        ['match' => ['gomti-nagar-extension'],               'name' => 'Gomti Nagar Ext.'],
        ['match' => ['sushant-golf-city'],                   'name' => 'Sushant Golf City'],
        ['match' => ['vibhuti-khand'],                       'name' => 'Vibhuti Khand'],
        ['match' => ['sultanpur-road'],                      'name' => 'Sultanpur Road'],
        ['match' => ['kanpur-road'],                         'name' => 'Kanpur Road'],
        ['match' => ['raebareli-road'],                      'name' => 'Raebareli Road'],
        ['match' => ['kisan-path'],                          'name' => 'Kisan Path'],
        ['match' => ['mohanlalganj'],                        'name' => 'Mohanlalganj'],
        ['match' => ['bakshi-ka-talab', '-bkt-'],            'name' => 'BKT'],
    ],
];
