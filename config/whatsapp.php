<?php

return [

    /*
    | The Baileys gateway (whatsapp-service/) that owns the WhatsApp socket.
    | Laravel calls it over HTTP; it calls back on the webhook route below.
    */
    'base_url'      => env('WHATSAPP_URL', 'http://127.0.0.1:3001'),
    'api_token'     => env('WHATSAPP_API_TOKEN', ''),
    'webhook_token' => env('WHATSAPP_WEBHOOK_TOKEN', ''),
    'timeout'       => (int) env('WHATSAPP_TIMEOUT', 15),

    /* How often the inbox page polls for new messages, in milliseconds. */
    'poll_ms' => (int) env('WHATSAPP_POLL_MS', 6000),

    /*
    | Canned replies now live in the wa_quick_replies table so the office can
    | edit them at /admin/whatsapp/settings. See App\Models\WaQuickReply.
    */

    /*
    | Media. The gateway refuses anything larger before it downloads it, so
    | keep max_mb in step with WA_MAX_MEDIA_MB in whatsapp-service/.env.
    */
    'media' => [
        'disk'   => env('WHATSAPP_MEDIA_DISK', 'local'),
        'max_mb' => (int) env('WHATSAPP_MAX_MEDIA_MB', 25),
    ],

    /*
    | Web Push, so a new message reaches the phone with the panel closed.
    | Generate the pair once with `php artisan whatsapp:vapid` and paste it in.
    | The public key is handed to the browser; the private key never leaves here.
    */
    'vapid' => [
        'subject'     => env('WHATSAPP_VAPID_SUBJECT', 'mailto:dheer725@gmail.com'),
        'public_key'  => env('WHATSAPP_VAPID_PUBLIC_KEY', ''),
        'private_key' => env('WHATSAPP_VAPID_PRIVATE_KEY', ''),
    ],

];
