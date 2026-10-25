<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A canned reply, expanded in the composer by typing its shortcut.
 *
 * These used to be a config array; they live in the database so the office can
 * reword them without a deploy.
 */
class WaQuickReply extends Model
{
    protected $fillable = ['shortcut', 'label', 'body', 'sort', 'active'];

    protected $casts = ['active' => 'boolean', 'sort' => 'integer'];

    public function scopeActive($q)
    {
        return $q->where('active', true)->orderBy('sort')->orderBy('id');
    }

    /** Shortcuts are matched case-insensitively and always stored bare. */
    public function setShortcutAttribute($value): void
    {
        $this->attributes['shortcut'] = strtolower(ltrim(trim((string) $value), '/'));
    }

    /** Fill the placeholders a reply may use before it goes in the composer. */
    public function render(WaChat $chat): string
    {
        return strtr($this->body, [
            '{name}'   => $chat->first_name,
            '{scheme}' => $chat->lead?->scheme_interest ?: 'the property',
        ]);
    }
}
