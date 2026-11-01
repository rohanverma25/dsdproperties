<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
        'waiting_for', 'requirement',
    ];

    protected $casts = [
        'next_followup_at' => 'date',
        'last_contact_at'  => 'datetime',
        'flexible'         => 'boolean',
        'no_answer_count'  => 'integer',
    ];

    /**
     * The person wrote to us again on WhatsApp.
     *
     * A lead that was parked as lost or dormant comes back as new and due
     * today — someone who returns on their own is the warmest lead there is.
     * Open and won leads only get their last-contact time moved.
     */
    public function reopenOnReply(\DateTimeInterface $at): void
    {
        $this->last_contact_at = $at;

        if (in_array($this->stage, ['lost', 'dormant'], true)) {
            $this->activities()->create([
                'type'        => 'whatsapp',
                'note'        => "Wrote again on WhatsApp — reopened (was {$this->stage}).",
                'happened_at' => $at,
            ]);

            $this->stage            = 'new';
            $this->no_answer_count  = 0;
            $this->next_followup_at = now()->toDateString();
        }

        $this->save();
    }

    public function activities()
    {
        return $this->hasMany(CrmLeadActivity::class);
    }

    /** Usually one; more only if WhatsApp handed the same person over twice. */
    public function waChats()
    {
        return $this->hasMany(WaChat::class, 'crm_lead_id');
    }

    /**
     * For the lead cards: the last WhatsApp message and the last inbox note of
     * each lead, set as `latestWhatsapp` / `latestChatNote` (null when none).
     * Two queries for the whole list rather than two per card.
     */
    public static function loadWhatsappSummary(Collection $leads): void
    {
        $chats = WaChat::whereIn('crm_lead_id', $leads->pluck('id'))->pluck('crm_lead_id', 'id');

        $latest = function (bool $notes) use ($chats) {
            $type = $notes ? "= 'note'" : "!= 'note'";

            return WaMessage::whereIn('wa_chat_id', $chats->keys())
                ->whereRaw("type {$type}")
                ->whereRaw("sent_at = (select max(m2.sent_at) from wa_messages m2 where m2.wa_chat_id = wa_messages.wa_chat_id and m2.type {$type})")
                ->orderBy('sent_at')->orderBy('id')
                ->get()
                ->keyBy(fn ($m) => $chats[$m->wa_chat_id]);   // later rows win: newest per lead
        };

        $messages = $chats->isEmpty() ? collect() : $latest(false);
        $notes    = $chats->isEmpty() ? collect() : $latest(true);

        foreach ($leads as $lead) {
            $lead->setRelation('latestWhatsapp', $messages->get($lead->id));
            $lead->setRelation('latestChatNote', $notes->get($lead->id));
        }
    }

    /**
     * The newest thing written about this lead: a logged activity's note or a
     * note from the WhatsApp inbox, whichever is later; else the lead's notes.
     */
    public function getLastNoteAttribute(): ?string
    {
        $activity = $this->latestActivity;
        $chatNote = $this->relationLoaded('latestChatNote') ? $this->latestChatNote : null;

        if ($chatNote && (! $activity?->note || $chatNote->sent_at->gt($activity->happened_at))) {
            return $chatNote->body;
        }

        return $activity?->note ?: $this->notes;
    }

    /**
     * Activities, inbox notes and WhatsApp messages as one list, newest first.
     *
     * Messages are grouped into one entry per day so months of imported
     * history stay readable. Items: ['kind' => activity|note|whatsapp, 'at', ...].
     */
    public function timeline(int $messageLimit = 500): \Illuminate\Support\Collection
    {
        $messages = WaMessage::whereIn('wa_chat_id', $this->waChats()->pluck('id'))
            ->orderByDesc('sent_at')->orderByDesc('id')
            ->limit($messageLimit)
            ->get()
            ->reverse();

        [$notes, $chat] = $messages->partition(fn (WaMessage $m) => $m->is_note);

        // Messages sent from the panel used to be logged as activities too;
        // those rows would now show twice.
        $sent = $chat->where('direction', 'out')->map(fn ($m) => mb_substr($m->preview, 0, 500))->flip();

        $activities = $this->activities
            ->reject(fn ($a) => $a->type === 'whatsapp' && ! $a->outcome && $sent->has((string) $a->note))
            ->map(fn ($a) => ['kind' => 'activity', 'at' => $a->happened_at, 'activity' => $a]);

        $days = $chat->groupBy(fn ($m) => $m->sent_at->toDateString())
            ->map(fn ($day) => ['kind' => 'whatsapp', 'at' => $day->last()->sent_at, 'messages' => $day->values()]);

        return $activities
            ->concat($notes->map(fn ($m) => ['kind' => 'note', 'at' => $m->sent_at, 'message' => $m]))
            ->concat($days->values())
            ->sortByDesc(fn ($item) => $item['at']->getTimestamp())
            ->values();
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

    /** On hold until something happens (registry opens, plot comes in). Closed leads never count. */
    public function scopeWaiting(Builder $q): Builder
    {
        return $q->whereNotNull('waiting_for')->whereNotIn('stage', self::CLOSED_STAGES);
    }

    public function getWaitingLabelAttribute(): ?string
    {
        return $this->waiting_for
            ? (config("crm.waiting_reasons.{$this->waiting_for}") ?? $this->waiting_for)
            : null;
    }

    /**
     * What they waited for has happened: take the lead off hold and put it on
     * today's list, with a timeline note saying why it came back.
     */
    public function releaseFromWaiting(): void
    {
        if (! $this->waiting_for) {
            return;
        }

        $this->activities()->create([
            'type'        => 'note',
            'note'        => 'Back from waiting (' . $this->waiting_label . ')'
                             . ($this->requirement ? ' — wanted: ' . $this->requirement : '') . '.',
            'happened_at' => now(),
        ]);

        $this->forceFill([
            'waiting_for'      => null,
            'next_followup_at' => now()->toDateString(),
        ])->save();
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
