<?php

// The one source for the Google review numbers shown anywhere on the site
// (home, /reviews, the reviews box on blog and service pages, /reviews schema).
// Only a curated subset of reviews is stored in the google_reviews table, so never
// count that table for a total. Update these two values when the Google Business
// profile changes, then deploy.
// Plain values with no env() on purpose, so a stale server .env can't override them.
return [
    'total'  => 49,   // Google Business profile, 26 Nov 2026
    'rating' => 5.0,
];
