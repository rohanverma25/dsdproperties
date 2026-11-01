<?php

return [

    /*
    | WhatsApp presets shown in the dropdown on each lead card.
    | {name} and {scheme} are substituted before the wa.me link is built.
    | Edit the wording here — no code change needed.
    */
    'whatsapp_templates' => [
        'intro' => [
            'label' => 'First message',
            'body'  => "Hello {name}, this is DSD Properties. You enquired about {scheme}. Is this a good time to talk?",
        ],
        'followup' => [
            'label' => 'Follow-up',
            'body'  => "Hello {name}, DSD Properties here. Any thoughts on {scheme}? Happy to answer any questions.",
        ],
        'site_visit' => [
            'label' => 'Site visit',
            'body'  => "Hello {name}, which day suits you for a site visit to {scheme}? We can go along with you.",
        ],
        'documents' => [
            'label' => 'Documents',
            'body'  => "Hello {name}, we have checked the papers and registry details for {scheme}. Shall I send them across?",
        ],
        'no_answer' => [
            'label' => 'Missed call',
            'body'  => "Hello {name}, tried calling just now — you were probably busy. Let me know a good time to call back.",
        ],
    ],

    /*
    | The pages a lead can come from. Shown as a dropdown on the lead form.
    | The first entry marked 'default' => true is preselected.
    */
    'source_pages' => [
        'https://dsdproperties.in/blog/wellness-city-lucknow-lda-plots-guide-2026' => [
            'label'   => 'Wellness City — LDA plots guide',
            'default' => true,
        ],
        'https://dsdproperties.in/services/property-verification-lucknow' => [
            'label' => 'Property Verification Lucknow',
        ],
        'https://dsdproperties.in/blog/it-city-lucknow-lda-plots-guide-2026' => [
            'label' => 'IT City — LDA plots guide',
        ],
        'https://dsdproperties.in/blog/varun-vihar-yojana-lucknow-lda-plots-guide-2026' => [
            'label' => 'Varun Vihar Yojana — LDA plots guide',
        ],
        'https://dsdproperties.in/blog/naimish-nagar-yojana-lucknow-lda-plots-guide-2026' => [
            'label' => 'Naimish Nagar Yojana — LDA plots guide',
        ],
    ],

    /*
    | Outcome -> what happens on save.
    | followup_days: default days added to today for next_followup_at.
    |                null means the follow-up date is cleared.
    | stage:         forced stage, or null to leave the stage as it is.
    */
    'outcomes' => [
        'no_answer' => [
            'label'         => 'No answer',
            'followup_days' => 1,
            'stage'         => null,
            'class'         => 'btn-outline-secondary',
            'selected'     => 'bg-slate-600 text-white border-slate-600',
        ],
        'call_later' => [
            'label'         => 'Call later',
            'followup_days' => 3,
            'stage'         => null,
            'class'         => 'btn-outline-primary',
            'selected'     => 'bg-brandNavy text-white border-brandNavy',
        ],
        'interested' => [
            'label'         => 'Interested',
            'followup_days' => 2,
            'stage'         => 'qualified',
            'class'         => 'btn-outline-success',
            'selected'     => 'bg-emerald-600 text-white border-emerald-600',
        ],
        'site_visit_fixed' => [
            'label'         => 'Site visit fixed',
            'followup_days' => 2,
            'stage'         => 'site_visit',
            'class'         => 'btn-outline-info',
            'selected'     => 'bg-brandTeal text-brandNavy border-brandTeal',
        ],
        'not_interested' => [
            'label'         => 'Not interested',
            'followup_days' => null,
            'stage'         => 'lost',
            'class'         => 'btn-outline-danger',
            'selected'     => 'bg-rose-600 text-white border-rose-600',
        ],
    ],

    /*
    | Schemes offered as suggestions in the lead form's Scheme box. Free text
    | is still allowed, but picking from here keeps the Waiting screen's
    | groups and the All-leads filter clean.
    */
    'schemes' => ['Saumitra Vihar', 'IT City', 'Wellness City'],

    /*
    | Why a lead is on hold. A waiting lead may have no follow-up date; it
    | stays out of Today until "Back to Today" on the Waiting screen.
    | Add or reword entries here; keep the keys once leads use them.
    */
    'waiting_reasons' => [
        'it_city_resale'  => 'IT City Resale Plot',
        'wellness_resale' => 'Wellness City Resale Plot',
        'it_city_land'    => 'Land in IT City',
        'wellness_land'   => 'Land in Wellness City',
        'lucknow_land'    => 'Land Plots in Lucknow',
        'saumitra_plot'   => 'Needs Plot in Saumitra Vihar',
        'other'           => 'Other',
    ],

    /* Consecutive no-answers before a lead goes dormant and drops off the Today list. */
    'no_answer_limit' => 3,
];
