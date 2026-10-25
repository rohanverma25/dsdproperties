<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Picks the single mobile CTA button for a page from config/page_cta.php.
 *
 * Returns ['text' => …, 'url' => …, 'kind' => 'buy'|'sell'|'legal', 'external' => bool].
 * Buy and legal buttons open WhatsApp with a message naming the button and the page,
 * so every enquiry arrives already tagged with where it came from.
 */
class PageCta
{
    public static function resolve(?string $slug = null, ?string $tag = null): array
    {
        $cfg  = config('page_cta');
        $slug = Str::lower((string) $slug);
        $tag  = trim((string) $tag);

        $seller = $cfg['seller'];
        if (in_array($tag, $seller['tags'], true) || ($slug !== '' && Str::contains($slug, $seller['slug_match']))) {
            return ['text' => $seller['text'], 'url' => $seller['url'], 'kind' => 'sell', 'external' => false];
        }

        if ($slug !== '') {
            foreach ($cfg['areas'] as $rule) {
                if (Str::contains($slug, $rule['match'])) {
                    return self::whatsapp(
                        str_replace(':name', $rule['name'], $cfg['area_text']),
                        'buy',
                        str_replace(':name', $rule['name'], $cfg['area_message'])
                    );
                }
            }
        }

        if (in_array($tag, $cfg['legal']['tags'], true)) {
            return self::whatsapp($cfg['legal']['text'], 'legal', $cfg['legal']['message'] ?? null);
        }

        return self::whatsapp($cfg['default'], 'buy');
    }

    private static function whatsapp(string $text, string $kind, ?string $message = null): array
    {
        // "Buy Plots in IT City" → "Hi, I want to buy Plots in IT City."
        $message = ($message ?? 'Hi, I want to ' . Str::lcfirst($text) . '.') . "\nPage: " . url()->current();

        return [
            'text'     => $text,
            'url'      => 'https://wa.me/' . config('page_cta.whatsapp_number') . '?text=' . rawurlencode($message),
            'kind'     => $kind,
            'external' => true,
        ];
    }
}
