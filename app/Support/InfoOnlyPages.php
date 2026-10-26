<?php

namespace App\Support;

/**
 * Pages that only inform: no lead CTAs at all (user, 27 Oct 2026).
 * On these pages the layouts drop the sidebar inquiry form, the exit-intent popup, the mobile sticky
 * buy/sell bar, the header call button and the footer WhatsApp button, and blog content loses its
 * consultation / verification buttons. Add a path here to switch a page over; remove it to undo.
 */
class InfoOnlyPages
{
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

    /**
     * Strip lead CTAs from blog content_html. Removes the shared verification boxes, the
     * {{CONSULTATION_BUTTON}} shortcode and the sample-report link, and turns any remaining link to a
     * service page, WhatsApp or a phone number into plain text, so the sentence still reads.
     */
    public static function cleanContent(string $html): string
    {
        $html = preg_replace('~<div class="(?:dsd-verify-cta|dsd-cta-box)"[^>]*>(?:(?!</div>).)*</div>~su', '', $html);
        $html = preg_replace('~<p class="dsd-sample-link"[^>]*>.*?</p>~su', '', $html);
        $html = preg_replace('~\{\{CONSULTATION_BUTTON(?::.*?)?\}\}~u', '', $html);
        $html = preg_replace('~<p[^>]*>\s*</p>~u', '', $html);
        $html = preg_replace(
            '~<a\b[^>]*href="(?:https?://(?:www\.)?dsdproperties\.in)?/services/[^"]*"[^>]*>(.*?)</a>|<a\b[^>]*href="(?:https://wa\.me/|https://api\.whatsapp\.com/|tel:)[^"]*"[^>]*>(.*?)</a>~su',
            '$1$2',
            $html
        );
        return $html;
    }
}
