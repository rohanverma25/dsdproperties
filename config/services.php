<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'openai' => [
    'key' => env('OPENAI_API_KEY'),
    'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
    'timeout' => (int) env('OPENAI_TIMEOUT', 90),
    ],
    
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'news_fetch' => ['token' => env('NEWS_FETCH_TOKEN')],
    'newsapi'    => ['key'   => env('NEWS_API_KEY')],
    'anthropic'  => ['key'   => env('ANTHROPIC_API_KEY')],
    'gemini'     => ['key'   => env('GEMINI_API_KEY')],
    'groq'       => ['key'   => env('GROQ_API_KEY')],

    'ipinfo' => [
        // Full API (city/region/country). Falls back to Lite when its quota is hit.
        'token'      => env('IPINFO_TOKEN'),
        // Optional separate token for the Lite endpoint; defaults to IPINFO_TOKEN.
        'lite_token' => env('IPINFO_LITE_TOKEN'),
    ],

    // Cloudflare Turnstile on the public lead forms (rendered by <x-honeypot />, checked in ChecksHoneypot).
    // Leave both keys empty and the forms work exactly as before.
    'turnstile' => [
        'site_key'   => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
    ],

];
