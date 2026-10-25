<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmLead extends Model
{
    use SoftDeletes;

    /** Stages that are finished — no follow-up is ever due for these. */
    public const CLOSED_STAGES = ['won', 'lost', 'dormant'];

    public const STAGES   = ['new', 'qualified', 'site_visit', 'negotiation', 'won', 'lost', 'dormant'];
    public const CHANNELS = ['whatsapp', 'form', 'referral', 'walkin'];
    public const INTENTS  = ['buy', 'rent', 'sell', 'verification'];

    protected $fillable = [
        'name', 'phone', 'alt_phone', 'source_page', 'source_channel', 'intent',
        'scheme_interest', 'area', 'budget_min', 'budget_max', 'flexible',
        'stage', 'next_followup_at', 'last_contact_at', 'no_answer_count', 'notes',
    ];

    protected $casts = [
        'next_followup_at' => 'date',
        'last_contact_at'  => 'datetime',
        'flexible'         => 'boolean',
        'no_answer_count'  => 'integer',
    ];

    public function activities()
    {
        return $this->hasMany(CrmLeadActivity::class);
    }

    public function latestActivity()
    {
        return $this->hasOne(CrmLeadActivity::class)->latestOfMany('happened_at');
    }

    /** Leads whose follow-up date has arrived (or passed) and that are still open. */
    public function scopeDueToday(Builder $q): Builder
    {
        return $q->whereNotNull('next_followup_at')
                 ->whereDate('next_followup_at', '<=', now()->toDateString())
                 ->whereNotIn('stage', self::CLOSED_STAGES);
    }

    /** Open leads whose follow-up date is already in the past. */
    public function scopeOverdue(Builder $q): Builder
    {
        return $q->whereNotNull('next_followup_at')
                 ->whereDate('next_followup_at', '<', now()->toDateString())
                 ->whereNotIn('stage', self::CLOSED_STAGES);
    }

    /** Strip everything but digits and force a 91 country code, ready for wa.me. */
    public function getWhatsappPhoneAttribute(): string
    {
        return self::normalisePhone($this->phone);
    }

    /**
     * Matches a number however it happens to be stored.
     *
     * New leads are saved normalised (91XXXXXXXXXX) but imported and older rows
     * hold bare 10-digit numbers, so a lookup on one form alone silently misses
     * and creates a duplicate card for someone already on file.
     */
    public function scopeMatchingPhone(Builder $q, ?string $phone): Builder
    {
        $normalised = self::normalisePhone($phone);

        if ($normalised === '') {
            return $q->whereRaw('1 = 0');
        }

        $variants = [$normalised];

        if (str_starts_with($normalised, '91') && strlen($normalised) === 12) {
            $variants[] = substr($normalised, 2);
        }

        return $q->whereIn('phone', $variants);
    }

    public static function normalisePhone(?string $phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if (strlen($digits) === 10) {
            return '91' . $digits;
        }

        // 0XXXXXXXXXX — drop the trunk prefix before adding the country code.
        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            return '91' . substr($digits, 1);
        }

        return $digits;
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->next_followup_at
            && ! in_array($this->stage, self::CLOSED_STAGES, true)
            && $this->next_followup_at->lt(now()->startOfDay());
    }

    public function getBudgetLabelAttribute(): ?string
    {
        if (! $this->budget_min && ! $this->budget_max) {
            return null;
        }

        $fmt = fn ($n) => $n >= 10000000
            ? rtrim(rtrim(number_format($n / 10000000, 2), '0'), '.') . ' Cr'
            : rtrim(rtrim(number_format($n / 100000, 2), '0'), '.') . ' L';

        if ($this->budget_min && $this->budget_max) {
            return $fmt($this->budget_min) . ' – ' . $fmt($this->budget_max);
        }

        return $this->budget_min ? $fmt($this->budget_min) . '+' : 'upto ' . $fmt($this->budget_max);
    }
}
