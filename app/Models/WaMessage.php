<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaMessage extends Model
{
    /** Receipts only ever move forward, so a late "sent" can't undo a "read". */
    public const STATUS_ORDER = ['pending' => 0, 'failed' => 0, 'sent' => 1, 'delivered' => 2, 'read' => 3];

    protected $fillable = [
        'wa_chat_id', 'wa_message_id', 'direction', 'type', 'body', 'status', 'error', 'sent_at',
        'media_path', 'media_mime', 'media_name', 'media_size',
    ];

    protected $casts = ['sent_at' => 'datetime', 'media_size' => 'integer'];

    public function chat()
    {
        return $this->belongsTo(WaChat::class, 'wa_chat_id');
    }

    public function getIsOutboundAttribute(): bool
    {
        return $this->direction === 'out';
    }

    /**
     * A private note written in the inbox. Stored as an outbound row of type
     * 'note' (direction is an in/out enum) with no WhatsApp id; it is never
     * sent and never counts as a reply.
     */
    public function getIsNoteAttribute(): bool
    {
        return $this->type === 'note';
    }

    public function scopeNotNote($q)
    {
        return $q->where('type', '!=', 'note');
    }

    /** The preview without the website's "Button:" / "Page:" lines, on one line. */
    public function getShortTextAttribute(): string
    {
        $text = preg_replace('~^\s*(Button|Page)\s*:.*$~mi', '', $this->preview);

        return trim(preg_replace('/\s+/', ' ', $text));
    }

    /** Tick icon for the bubble — mirrors WhatsApp's own single/double/blue ticks. */
    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'fa-regular fa-clock',
            'sent'      => 'fa-solid fa-check',
            'delivered' => 'fa-solid fa-check-double',
            'read'      => 'fa-solid fa-check-double text-sky-500',
            'failed'    => 'fa-solid fa-triangle-exclamation text-rose-500',
            default     => 'fa-solid fa-check',
        };
    }

    /** What to show in the chat list when the body is empty (media, stickers, …). */
    public function getPreviewAttribute(): string
    {
        if (filled($this->body)) {
            return $this->body;
        }

        return $this->mediaLabel();
    }

    public function mediaLabel(): string
    {
        return match ($this->type) {
            'image'    => '📷 Photo',
            'video'    => '🎥 Video',
            'audio'    => '🎤 Voice message',
            'document' => '📄 ' . ($this->media_name ?: 'Document'),
            'sticker'  => 'Sticker',
            'location' => '📍 Location',
            'contact'  => '👤 Contact',
            default    => 'Message',
        };
    }

    /** True once the file itself is on disk, not just its label in the thread. */
    public function getHasMediaAttribute(): bool
    {
        return filled($this->media_path);
    }

    /** Admin-only streaming URL; the files never sit under the web root. */
    public function getMediaUrlAttribute(): ?string
    {
        return $this->has_media ? route('admin.whatsapp.media', $this) : null;
    }

    public function getMediaSizeLabelAttribute(): ?string
    {
        if (! $this->media_size) {
            return null;
        }

        return $this->media_size >= 1048576
            ? round($this->media_size / 1048576, 1) . ' MB'
            : max(1, (int) round($this->media_size / 1024)) . ' KB';
    }

    /** Only these render inline; everything else gets a download row. */
    public function getIsViewableImageAttribute(): bool
    {
        return $this->has_media
            && $this->type === 'image'
            && str_starts_with((string) $this->media_mime, 'image/');
    }

    public function getIsPlayableAudioAttribute(): bool
    {
        return $this->has_media && in_array($this->type, ['audio', 'video'], true);
    }
}
