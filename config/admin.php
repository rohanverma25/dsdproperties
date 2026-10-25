<?php

return [

    /*
    | Who may reach /admin/*. Matched case-insensitively against the logged-in
    | user's email. Anyone else — including other registered users — gets a 403.
    |
    | Add more addresses in .env, comma separated:
    |   ADMIN_EMAILS="you@example.com,someone@example.com"
    */
    'emails' => array_values(array_filter(array_map(
        fn ($e) => strtolower(trim($e)),
        explode(',', env('ADMIN_EMAILS', 'dheer725@gmail.com'))
    ))),

    /*
    | Where new form submissions are announced. Defaults to the first admin
    | address so a missing .env key never silently drops the notification.
    | ADMIN_EMAILS may hold several addresses, so only the first is used here.
    */
    'inquiry_notification_email' => env('INQUIRY_NOTIFICATION_EMAIL')
        ?: trim(explode(',', env('ADMIN_EMAILS', 'dheer725@gmail.com'))[0]),

    /*
    | Paths under /admin that must stay reachable without the admin login.
    |
    | - the PWA's static files, so an installed app can still load its manifest,
    |   icons and offline page (normally served by Apache before Laravel)
    | - admin/verifications/*, which has its own separate `ver.admin` login
    */
    'public_paths' => [
        'admin/sw.js',
        'admin/manifest.webmanifest',
        'admin/offline.html',
        'admin/icons/*',
        'admin/verifications',
        'admin/verifications/*',
    ],
];
