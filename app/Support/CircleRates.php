<?php

namespace App\Support;

/**
 * Lucknow circle-rate lists (resources/data/circle-rates/*.json, one per sub-registrar office) for the
 * /lucknow-circle-rate page, its per-mohalla pages (/lucknow-circle-rate/{sro}/{mohalla}) and their sitemap.
 *
 * The worked examples here mirror the JS engine (resources/views/partials/circle-rate-engine.blade.php):
 * keep the two in step. tests/circle-rate check (_deploy) compares every page's figures with the engine.
 */
class CircleRates
{
    public const BIGHA_SQM = 2529.285264;   // Lucknow pakka bigha = 3,025 gaj
    public const GAJ_SQM = 0.83612736;  // exact, same as the JS engine
    public const SQFT_SQM = 0.09290304;

    private static ?array $all = null;

    /** All SRO lists keyed by slug, in SRO-number order. */
    public static function all(): array
    {
        if (self::$all === null) {
            $all = [];
            foreach (glob(resource_path('data/circle-rates/*.json')) as $file) {
                $l = json_decode(file_get_contents($file), true);
                $all[$l['slug']] = $l;
            }
            uasort($all, fn ($a, $b) => strcmp($a['sro_code'], $b['sro_code']));
            self::$all = $all;
        }
        return self::$all;
    }

    public static function slug(string $en): string
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($en)), '-');
    }

    /** The row of one mohalla, or null. */
    public static function find(string $sro, string $slug): ?array
    {
        foreach (self::all()[$sro]['rows'] ?? [] as $r) {
            if (self::slug($r['en']) === $slug) return $r;
        }
        return null;
    }

    public static function url(string $sro, array $row): string
    {
        return url('/lucknow-circle-rate/' . $sro . '/' . self::slug($row['en']));
    }

    /** Stamp duty + registration on a value, same rules as CRC.duty(): man 7%, woman 6% up to ₹1 crore. */
    public static function duty(float $value, bool $woman = false): array
    {
        $rate = $woman && $value <= 1e7 ? 0.06 : 0.07;
        $sd = (int) round($value * $rate);
        $reg = (int) round($value * 0.01);
        return ['rate' => $rate, 'sd' => $sd, 'reg' => $reg, 'total' => $sd + $reg];
    }

    /** Plot on a road under 9 m, same as CRC.value() type 'plot' (1,000 sq m rule; no park/corner). */
    public static function plotValue(array $row, float $sqm): float
    {
        $rate = $row['plot']['lt9'];
        return $sqm <= 1000 ? $sqm * $rate : 1000 * $rate + ($sqm - 1000) * $rate * 0.7;
    }

    /** Agricultural land of "general" type (सामान्य), same as CRC.value() type 'agri' with apos 'general', no adjacency. */
    public static function agriGeneralValue(array $row, float $sqm): ?float
    {
        if (empty($row['agri']['general'])) return null;
        $ha = $sqm / 10000;
        $full = $part = 0.0;
        if (($row['category'] ?? null) === 'Urban') {           // rule 12(अ)
            $full = min($ha, 0.10);
            $part = min(max($ha - 0.10, 0), 0.05);
        }                                                       // rule 12(ब) applies only next to a road/abadi, not to सामान्य
        $rest = max($ha - $full - $part, 0);
        $na = $row['plot']['lt9'];
        return $full * 10000 * $na + $part * 10000 * $na * 0.7 + $rest * $row['agri']['general'] * 1e5;
    }

    /** ₹ formatting used on the page: 1.23 Cr / 4.56 L / 78,900 (same as the page's money()). */
    public static function money(float $n): string
    {
        if ($n >= 1e7) return '₹' . number_format($n / 1e7, 2) . ' Cr';
        if ($n >= 1e5) return '₹' . number_format($n / 1e5, 2) . ' L';
        return '₹' . self::inr($n);
    }

    /** Indian digit grouping, like toLocaleString('en-IN'). */
    public static function inr(float $n): string
    {
        $n = (string) round($n);
        $neg = str_starts_with($n, '-');
        if ($neg) $n = substr($n, 1);
        $last = substr($n, -3);
        $rest = substr($n, 0, -3);
        if ($rest !== '') $last = ',' . $last;
        $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
        return ($neg ? '-' : '') . $rest . $last;
    }
}
