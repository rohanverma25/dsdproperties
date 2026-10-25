<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
