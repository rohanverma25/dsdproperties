<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * One WhatsApp conversation with one number.
 *
 * Chats are created on first contact (inbound or outbound) and linked to a
 * CrmLead whenever a lead with the same number exists, so the inbox and the
 * follow-up tracker stay one system rather than two.
 */
class WaChat extends Model
{
    protected $fillable = [
        'jid', 'phone', 'name', 'crm_lead_id',
        'unread_count', 'last_preview', 'last_message_at', 'archived',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'archived'        => 'boolean',
        'unread_count'    => 'integer',
    ];

    public function messages()
    {
        return $this->hasMany(WaMessage::class);
    }

    public function lead()
    {
        return $this->belongsTo(CrmLead::class, 'crm_lead_id');
    }

    public function labels()
    {
        return $this->belongsToMany(WaLabel::class, 'wa_chat_label')->orderBy('sort');
    }

    public function scopeInbox(Builder $q): Builder
    {
        return $q->where('archived', false)->orderByDesc('last_message_at');
    }

    /**
     * Chats nobody has acted on: not a lead, not archived, and the last word
     * is still the customer's. Replying, making a lead or archiving clears it.
     */
    public function scopeNotHandled(Builder $q): Builder
    {
        return $q->where('archived', false)
            ->whereNull('crm_lead_id')
            ->whereRaw("(select m.direction from wa_messages m where m.wa_chat_id = wa_chats.id and m.type != 'note' order by m.sent_at desc, m.id desc limit 1) = 'in'");
    }

    /**
     * What the website's pre-filled message says about this enquiry.
     *
     * Every wa.me link on the site ends with "Button: …" and "Page: …"
     * (partials/whatsapp-message-tag). The latest inbound message carrying
     * them is the current enquiry. Returns scheme_interest, intent and
     * source_page where they can be told; missing keys mean "unknown".
     */
    public function websiteEnquiry(): array
    {
        $body = $this->messages()
            ->where('direction', 'in')
            ->where('body', 'like', '%Page:%')
            ->latest('sent_at')
            ->value('body');

        if (! $body) {
            return [];
        }

        $page = preg_match('~^\s*Page:\s*(\S+)~mi', $body, $m) ? $m[1] : null;
        $text = strtolower(preg_replace('~^\s*Page:.*$~mi', '', $body));   // message + button only
        $path = strtolower((string) $page);

        $schemes = [
            'Saumitra Vihar' => ['saumitra'],
            'IT City'        => ['it city', 'it-city'],
            'Wellness City'  => ['wellness'],
        ];

        $scheme = null;

        // The words they sent beat the page they happened to be on.
        foreach ([$text, $path] as $haystack) {
            foreach ($schemes as $name => $needles) {
                if (Str::contains($haystack, $needles)) {
                    $scheme = $name;
                    break 2;
                }
            }
        }

        $verification = Str::contains($text, ['verif', 'सत्यापन'])
            || (Str::contains($path, 'property-verification') && ! Str::contains($text, 'plot'));

        return array_filter([
            'scheme_interest' => $scheme,
            'intent'          => $verification ? 'verification' : 'buy',
            'source_page'     => $page ? mb_substr($page, 0, 255) : null,
            'button'          => preg_match('~^\s*Button:\s*(.+)$~mi', $body, $m) ? trim($m[1]) : null,
        ]);
    }

    /** "919812345678@s.whatsapp.net" -> "919812345678" */
    public static function jidToPhone(string $jid): string
    {
        return preg_replace('/\D+/', '', explode('@', $jid)[0]);
    }

    public static function phoneToJid(string $phone): string
    {
        return CrmLead::normalisePhone($phone) . '@s.whatsapp.net';
    }

    /**
     * Find (or start) the chat for a jid, keeping the CrmLead link fresh.
     * Safe to call on every inbound message.
     */
    public static function forJid(string $jid, ?string $name = null): self
    {
        $phone = self::jidToPhone($jid);

        $chat = self::firstOrNew(['jid' => $jid]);
        $chat->phone = $phone;

        // Only fill the name in — never overwrite a name an admin has set.
        if ($name && ! $chat->name) {
            $chat->name = $name;
        }

        // A privacy id (@lid) is not a phone number; matching its digits against
        // leads would link a stranger's lead.
        if (! $chat->crm_lead_id && ! $chat->is_privacy_id) {
            $chat->crm_lead_id = CrmLead::query()
                ->where('phone', 'like', '%' . substr($phone, -10))
                ->value('id');
        }

        $chat->save();

        return $chat;
    }

    /** True for a chat WhatsApp gave us under a privacy id instead of the number. */
    public function getIsPrivacyIdAttribute(): bool
    {
        return str_ends_with((string) $this->jid, '@lid');
    }

    /**
     * Move a chat saved under a privacy id onto its real number.
     *
     * If a chat with that number already exists the two are merged into it —
     * messages, labels, lead link and name — and the privacy-id chat goes away.
     * Returns the chat that now holds the conversation.
     */
    public static function resolvePrivacyId(string $lidJid, string $pnJid): ?self
    {
        $old = self::where('jid', $lidJid)->first();

        if (! $old) {
            return null;
        }

        $lidDigits = self::jidToPhone($lidJid);
        $phone     = self::jidToPhone($pnJid);

        // A lead created from this chat was given the privacy id as its "phone".
        if ($old->crm_lead_id) {
            $lead = CrmLead::find($old->crm_lead_id);

            if ($lead && str_ends_with(preg_replace('/\D+/', '', (string) $lead->phone), substr($lidDigits, -10))) {
                $lead->forceFill(['phone' => $phone])->save();
            } elseif ($lead) {
                // Linked by a coincidental digit match on the privacy id, not on purpose.
                $old->crm_lead_id = null;
            }
        }

        return \Illuminate\Support\Facades\DB::transaction(function () use ($old, $pnJid, $phone) {
            $target = self::where('jid', $pnJid)->first();

            if (! $target) {
                $old->forceFill(['jid' => $pnJid, 'phone' => $phone])->save();

                return self::forJid($pnJid);   // re-runs the lead match on the real number
            }

            WaMessage::where('wa_chat_id', $old->id)->update(['wa_chat_id' => $target->id]);
            $target->labels()->syncWithoutDetaching($old->labels()->pluck('wa_labels.id'));

            $latest = $target->messages()->latest('sent_at')->first();

            $target->forceFill([
                'name'            => $target->name ?: $old->name,
                'crm_lead_id'     => $target->crm_lead_id ?: $old->crm_lead_id,
                'unread_count'    => $target->unread_count + $old->unread_count,
                'archived'        => $target->archived && $old->archived,
                'last_preview'    => $latest ? mb_substr($latest->preview, 0, 280) : $target->last_preview,
                'last_message_at' => $latest?->sent_at ?? $target->last_message_at,
            ])->save();

            $old->labels()->detach();
            $old->delete();

            return $target;
        });
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->lead?->name ?: ($this->name ?: '+' . $this->phone);
    }

    public function getFirstNameAttribute(): string
    {
        return trim(explode(' ', $this->display_name)[0]);
    }

    public function getInitialsAttribute(): string
    {
        $name = $this->display_name;

        if (str_starts_with($name, '+')) {
            return '#';
        }

        $parts = preg_split('/\s+/', trim($name));

        return strtoupper(mb_substr($parts[0], 0, 1) . (count($parts) > 1 ? mb_substr(end($parts), 0, 1) : ''));
    }
}
