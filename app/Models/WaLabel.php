<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A colour tag on a chat — the WhatsApp Business "labels" idea.
 *
 * Labels are lighter than CRM stages: a chat can carry several, and applying
 * one never changes the lead's follow-up date.
 */
class WaLabel extends Model
{
    /** Tailwind classes per colour name, so a stored row never holds markup. */
    public const COLOURS = [
        'slate'   => 'bg-slate-100 text-slate-700 ring-slate-200',
        'sky'     => 'bg-sky-100 text-sky-800 ring-sky-200',
        'rose'    => 'bg-rose-100 text-rose-700 ring-rose-200',
        'amber'   => 'bg-amber-100 text-amber-800 ring-amber-200',
        'violet'  => 'bg-violet-100 text-violet-700 ring-violet-200',
        'emerald' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
    ];

    protected $fillable = ['name', 'colour', 'sort'];

    public function chats()
    {
        return $this->belongsToMany(WaChat::class, 'wa_chat_label');
    }

    public function getClassesAttribute(): string
    {
        return self::COLOURS[$this->colour] ?? self::COLOURS['slate'];
    }
}
