<?php

/*
 * The one real author of every article and news story on the site (18 Nov 2026).
 * Before this, blog posts showed ten invented personas ("Ravi Ahuja", "Neha Mishra"...) picked by author_id;
 * those were removed for E-E-A-T and honesty. Used by BlogController, blogs/show, news/show and /author/dheer-singh.
 * Keep every line here true: no invented years of experience, awards or numbers.
 */
return [
    'name'      => 'Dheer Singh',
    'slug'      => 'dheer-singh',
    'job_title' => 'Founder, DSD Properties',
    'bio'       => 'Dheer Singh is the founder of DSD Properties, Lucknow. He researches LDA, Awas Vikas (UPAVP) and UP RERA schemes '
                 . 'and writes the guides and news on this site from official orders, notices, layout plans and lottery lists. '
                 . 'DSD Properties also checks property documents for buyers before they pay.',
    'alumni_of' => 'APJ Abdul Kalam Technological University',
    'knows_about' => ['Real estate in Lucknow', 'LDA schemes', 'UP Awas Vikas Parishad schemes', 'UP RERA', 'Property documents and verification', 'Circle rates and stamp duty in Uttar Pradesh'],
    'same_as'   => ['https://www.linkedin.com/in/dheer-singh-416370137/'],
];
