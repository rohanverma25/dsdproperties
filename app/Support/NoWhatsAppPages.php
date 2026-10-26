<?php

namespace App\Support;

/**
 * Pages that must not open WhatsApp (user, 27 Oct 2026: too many casual chats). Leads are still welcome
 * through the inquiry form, so every WhatsApp CTA on these pages scrolls to the form instead: content
 * buttons and links, the consultation shortcode and the mobile sticky bar. The footer WhatsApp button is
 * hidden. Add a path here to switch a page over; remove it to undo.
 */
class NoWhatsAppPages
{
    /** Where WhatsApp CTAs go instead: the sidebar inquiry form (components/inquiry-form). */
    public const FORM_ANCHOR = '#ebook-form-container';

    /** Request paths, without the leading slash. */
    public const PATHS = [
        'lda-schemes',
        'blog/transfer-property-after-death-lucknow-guide',
        'blog/lda-yojana-ews-lig-mig-aarakshan-aay-praman-patra-hindi-2026',
        'blog/lda-vs-nagar-nigam-lucknow-2026',
        'blog/naimish-nagar-yojana-lucknow-lda-plots-guide-2026',
        'blog/varun-vihar-yojana-lucknow-hindi-2026',
        'blog/varun-vihar-yojana-lucknow-lda-plots-guide-2026',
        'blog/dhara-80-krishi-bhumi-aawasiya-hindi-lucknow-2026',
        'blog/transforming-agricultural-land-residential-property-lucknow',
        'blog/vashishtha-nagar-yojana-lda-lucknow-2026',
        'blog/understanding-rera-guide-lucknow-property-buyers-C7ECl',
        'blog/bainama-vs-registry-vs-power-of-attorney-lucknow-2026',
        'blog/documents-needed-to-sell-property-lucknow-2026',
        'blog/awadh-vihar-yojana-lucknow-avadh-vihar-guide-2026',
        'blog/lda-sardar-vallabhbhai-patel-housing-scheme-lucknow',
        'blog/lda-aishbagh-square-mill-road-lucknow',
        'blog/atal-nagar-awasiya-yojana-phase-2-devpur-para-lucknow-2026',
    ];

    public static function active(): bool
    {
        return in_array(trim(request()->path(), '/'), self::PATHS, true);
    }

    /** Point WhatsApp links in blog content_html at the inquiry form. */
    public static function cleanContent(string $html): string
    {
        return preg_replace_callback(
            '~<a\b([^>]*)href="(?:https://wa\.me/|https://api\.whatsapp\.com/)[^"]*"([^>]*)>~i',
            fn($m) => '<a' . preg_replace('~\s(?:target|rel)="[^"]*"~i', '', $m[1] . 'href="' . self::FORM_ANCHOR . '"' . $m[2]) . '>',
            $html
        );
    }
}
