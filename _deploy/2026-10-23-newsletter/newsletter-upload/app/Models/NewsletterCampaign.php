<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterCampaign extends Model
{
    protected $fillable = ['week', 'subject', 'intro', 'items', 'sources', 'status', 'total', 'sent', 'failed', 'started_at', 'finished_at'];

    protected $casts = ['started_at' => 'datetime', 'finished_at' => 'datetime', 'items' => 'array'];

    /** English headline + summary for a story in this email; falls back to the story's own (Hindi) text. */
    public function itemFor($story): array
    {
        $i = ($this->items ?? [])[$story->id] ?? [];
        return [
            'title'   => trim($i['title'] ?? '') ?: $story->title,
            'summary' => trim($i['summary'] ?? '') ?: $story->summary,
            'english' => trim($i['title'] ?? '') !== '',
        ];
    }

    public function deliveries()
    {
        return $this->hasMany(NewsletterDelivery::class, 'campaign_id');
    }

    public function sourceList(): array
    {
        return array_values(array_filter(explode(',', (string) $this->sources)));
    }
}
