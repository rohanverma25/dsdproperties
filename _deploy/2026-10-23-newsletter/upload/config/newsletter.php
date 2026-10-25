<?php

/*
|--------------------------------------------------------------------------
| Weekly newsletter
|--------------------------------------------------------------------------
| One email a week built from that week's /news stories (page: /news/weekly/{week}).
| It goes only to people who gave us their email on our own forms (form_submissions),
| minus anyone who unsubscribed. Sent in small hourly batches to stay inside the
| Hostinger mailbox limits; check those limits in hPanel before raising batch_size.
*/

return [

    'mailer'       => 'newsletter',   // config/mail.php → mailers.newsletter
    'from_address' => env('NEWSLETTER_FROM_ADDRESS', env('NEWSLETTER_MAIL_USERNAME')),
    'from_name'    => env('NEWSLETTER_FROM_NAME', 'DSD Properties'),
    'reply_to'     => env('NEWSLETTER_REPLY_TO'),

    'batch_size'   => (int) env('NEWSLETTER_BATCH_SIZE', 50),

    // form_submissions.source_form values whose emails may receive the newsletter.
    // 'newsletter' = people who signed up for it; the rest contacted us through a form.
    'sources' => [
        'newsletter'   => 'Newsletter sign-ups',
        'contact_us'   => 'Contact form',
        'exit_intent'  => 'Blog popup enquiries',
        'blog_sidebar' => 'Blog sidebar form',
    ],

    'utm' => 'utm_source=newsletter&utm_medium=email',

    // Links in the email are built with this root, even when sent from the CLI/cron or a local machine.
    'site_url' => env('NEWSLETTER_SITE_URL', 'https://dsdproperties.in'),
];
