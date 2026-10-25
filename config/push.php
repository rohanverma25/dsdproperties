<?php

/*
|--------------------------------------------------------------------------
| Browser push (OneSignal)
|--------------------------------------------------------------------------
| Visitors pick from four topics. Each topic is a OneSignal data tag
| (topic_<key> = "1"), so a send to one topic is a tag filter. The other
| keys say which pages belong to a topic, so the prompt can pre-tick it.
|
| The REST API key is secret: it lives only in .env, never in the page.
*/

return [

    'app_id'       => env('ONESIGNAL_APP_ID'),
    'rest_api_key' => env('ONESIGNAL_REST_API_KEY'),

    // Served from public/push/onesignal/ so its scope never touches /admin or /seller.
    'worker_path'  => 'push/onesignal/OneSignalSDKWorker.js',
    'worker_scope' => '/push/onesignal/',

    'icon'         => 'images/push-icon-192.png',

    'topics' => [
        'lda' => [
            'label'           => 'LDA schemes & lottery',
            'news_categories' => ['lda', 'it-city'],
            'blog_tags'       => ['LDA Scheme Guide', 'LDA Schemes', 'Locality Guide'],
            'url_words'       => ['lda', 'yojana', 'yojna', 'vihar', 'naimish', 'it-city', 'kisan-path', 'anant-nagar'],
        ],
        'awas' => [
            'label'           => 'Awas Vikas & govt flats',
            'news_categories' => [],
            'blog_tags'       => ['Awas Vikas'],
            'url_words'       => ['awas-vikas', 'aawas', 'upavp', 'pm-awas', 'pmay'],
        ],
        'projects' => [
            'label'           => 'New projects & RERA',
            'news_categories' => ['projects', 'rera'],
            'blog_tags'       => [],
            'url_words'       => ['rera', 'shalimar', 'emaar', 'eldeco', 'omaxe', 'oneworld', 'builder', 'project'],
        ],
        'rules' => [
            'label'           => 'Rules, registry & prices',
            'news_categories' => ['policy', 'price'],
            'blog_tags'       => ['Legal Advice', 'Legal Guide', 'Property Law', 'Property Verification', 'Buying Tips', 'Selling Tips', 'Seller Guide'],
            'url_words'       => ['stamp', 'registry', 'igrs', 'verification', 'mutation', 'dakhil', 'khatauni', 'circle-rate', 'tax'],
        ],
    ],

];
