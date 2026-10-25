<?php

namespace App\Support;

use App\Mail\WeeklyNewsletter;
use App\Models\NewsArticle;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterDelivery;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

/**
 * Weekly newsletter: weeks, the stories in a week, the audience, and batch sending.
 * A "week" is an ISO week (Monday–Sunday, India time), written like "2026-W43".
 */
class Newsletter
{
    const TZ = 'Asia/Kolkata';

    /** [start, end] of an ISO week, or null if the key is malformed. */
    public static function weekRange(string $week): ?array
    {
        if (! preg_match('/^(\d{4})-W(\d{2})$/', strtoupper($week), $m) || (int) $m[2] < 1 || (int) $m[2] > 53) {
            return null;
        }
        $start = CarbonImmutable::now(self::TZ)->setISODate((int) $m[1], (int) $m[2])->startOfDay();
        return [$start, $start->addDays(6)->endOfDay()];
    }

    public static function weekKey(\DateTimeInterface $date): string
    {
        $d = CarbonImmutable::instance($date)->setTimezone(self::TZ);
        return sprintf('%d-W%02d', $d->isoWeekYear, $d->isoWeek);
    }

    /** "19–25 October 2026" (or "28 Sep – 4 Oct 2026" across months). */
    public static function weekLabel(string $week): string
    {
        [$s, $e] = self::weekRange($week) ?? [null, null];
        if (! $s) return $week;
        return $s->month === $e->month
            ? $s->format('j') . '–' . $e->format('j F Y')
            : $s->format('j M') . ' – ' . $e->format('j M Y');
    }

    /** Published stories dated inside the week, newest first. */
    public static function stories(string $week): Collection
    {
        [$s, $e] = self::weekRange($week) ?? [null, null];
        if (! $s) return collect();
        return NewsArticle::published()
            ->whereBetween('created_at', [$s->setTimezone(config('app.timezone')), $e->setTimezone(config('app.timezone'))])
            ->orderByDesc('created_at')->get();
    }

    /** Weeks that have at least one story, newest first: [week => count]. */
    public static function weeks(): array
    {
        $out = [];
        foreach (NewsArticle::published()->orderByDesc('created_at')->pluck('created_at') as $at) {
            $k = self::weekKey($at);
            $out[$k] = ($out[$k] ?? 0) + 1;
        }
        return $out;
    }

    /** Distinct valid emails from the chosen form sources, minus unsubscribes: [email => name]. */
    public static function audience(array $sources): array
    {
        $sources = array_values(array_intersect($sources, array_keys(config('newsletter.sources'))));
        if (! $sources) return [];
        $blocked = DB::table('newsletter_unsubscribes')->pluck('email')->map(fn ($e) => strtolower($e))->flip();
        $out = [];
        $rows = DB::table('form_submissions')->whereIn('source_form', $sources)
            ->whereNotNull('email')->where('email', '!=', '')
            ->orderByDesc('created_at')->get(['email', 'name']);
        foreach ($rows as $r) {
            $email = strtolower(trim($r->email));
            if (isset($out[$email]) || isset($blocked[$email]) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) continue;
            $out[$email] = $r->name ? mb_substr(trim($r->name), 0, 100) : null;
        }
        return $out;
    }

    public static function unsubscribeUrl(string $email, ?int $campaignId = null): string
    {
        return URL::signedRoute('newsletter.unsubscribe', ['email' => $email, 'c' => $campaignId]);
    }

    /** Signed link that records which language the reader prefers ('en' or 'hi'). */
    public static function languageUrl(string $email, string $lang): string
    {
        return URL::signedRoute('newsletter.language', ['email' => $email, 'lang' => $lang]);
    }

    /** Freeze the audience into delivery rows and mark the campaign as sending. */
    public static function start(NewsletterCampaign $c): int
    {
        $now = now();
        $rows = [];
        foreach (self::audience($c->sourceList()) as $email => $name) {
            $rows[] = ['campaign_id' => $c->id, 'email' => $email, 'name' => $name, 'status' => 'queued', 'created_at' => $now, 'updated_at' => $now];
        }
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('newsletter_deliveries')->insertOrIgnore($chunk);
        }
        $total = $c->deliveries()->count();
        $c->update(['status' => 'sending', 'total' => $total, 'started_at' => $c->started_at ?? $now]);
        return $total;
    }

    /** Make url()/route() produce live-site links, whatever APP_URL the sender runs with. */
    public static function useSiteUrl(): void
    {
        URL::forceRootUrl(rtrim(config('newsletter.site_url'), '/'));
        URL::forceScheme('https');
    }

    /** Send up to $limit queued emails of one campaign. Returns [sent, failed, left]. */
    public static function sendBatch(NewsletterCampaign $c, ?int $limit = null): array
    {
        self::useSiteUrl();
        $limit = $limit ?? config('newsletter.batch_size');
        $stories = self::stories($c->week);
        $sent = $failed = 0;

        foreach ($c->deliveries()->where('status', 'queued')->orderBy('id')->limit($limit)->get() as $d) {
            // Someone may unsubscribe while a campaign is going out
            if (DB::table('newsletter_unsubscribes')->where('email', $d->email)->exists()) {
                $d->update(['status' => 'skipped']);
                continue;
            }
            if (! $d->token) {
                $d->update(['token' => \Illuminate\Support\Str::random(28)]);
            }
            try {
                Mail::mailer(config('newsletter.mailer'))->to($d->email)
                    ->send(new WeeklyNewsletter($c, $stories, $d->email, $d->name, $d->token));
                $d->update(['status' => 'sent', 'sent_at' => now(), 'error' => null]);
                $sent++;
                usleep(2_000_000); // Hostinger rate-limits fast bursts (451 after ~47 mails in one minute)
            } catch (\Throwable $e) {
                // 4xx = temporary (rate limit): keep it queued for the next batch and stop this one
                if (preg_match('/code "4\d\d"|ratelimit/i', $e->getMessage())) {
                    $d->update(['error' => mb_substr($e->getMessage(), 0, 300)]);
                    break;
                }
                $d->update(['status' => 'failed', 'error' => mb_substr($e->getMessage(), 0, 300)]);
                $failed++;
            }
        }

        $left = $c->deliveries()->where('status', 'queued')->count();
        $c->update([
            'sent'   => $c->deliveries()->where('status', 'sent')->count(),
            'failed' => $c->deliveries()->where('status', 'failed')->count(),
        ] + ($left === 0 ? ['status' => 'done', 'finished_at' => now()] : []));

        return [$sent, $failed, $left];
    }
}
