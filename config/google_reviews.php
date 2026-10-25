<?php

// Headline numbers from the Google Business profile. Only a curated subset of
// reviews is stored in the google_reviews table, so the public total and rating
// shown on the site come from here. Update when the Google profile changes.
return [
    'total'  => (int) env('GOOGLE_REVIEWS_TOTAL', 42),
    'rating' => (float) env('GOOGLE_REVIEWS_RATING', 5.0),
];
