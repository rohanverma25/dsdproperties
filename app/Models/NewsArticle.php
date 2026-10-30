<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    // The /news categories, in tab order. One place for labels, colours and filters.
    // Keep the list short (20 at most): file a story under an existing category when
    // one fits, and add a new one only for a topic we write about repeatedly.
    // 'tab': shorter label for the filter chip (defaults to 'label').
    // 'match': title/summary words that also put a story under this tab, so a scheme
    // tab picks up its stories even when they are filed under LDA, prices etc.
    public const CATEGORIES = [
        'saumitra-vihar' => ['label' => 'Saumitra Vihar', 'color' => '#7c3aed', 'match' => ['सौमित्र', 'Saumitra']],
        'it-city'        => ['label' => 'IT City',        'color' => '#2563eb', 'match' => ['आईटी सिटी', 'IT City']],
        'wellness-city'  => ['label' => 'Wellness City',  'color' => '#0d9488', 'match' => ['वेलनेस सिटी', 'Wellness City']],
        'lda'            => ['label' => 'LDA Update',     'color' => '#16a34a', 'tab' => 'LDA'],
        'projects'       => ['label' => 'New Projects',   'color' => '#9333ea'],
        'price'          => ['label' => 'Prices',         'color' => '#ea580c'],
        'policy'         => ['label' => 'Policy',         'color' => '#dc2626'],
        'rera'           => ['label' => 'RERA',           'color' => '#0891b2'],
    ];

    // Columns that can be filled by the cron job
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'full_content',
        'meta_description',
        'category',
        'source_name',
        'source_url',
        'is_hot',
        'status',
    ];

    // Cast is_hot to boolean so you can do  $article->is_hot  directly
    protected $casts = [
        'is_hot' => 'boolean',
    ];

    // ── SCOPES ────────────────────────────────────────────
    // Usage: NewsArticle::published()->get()
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Usage: NewsArticle::pending()->get()
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Usage: NewsArticle::byCategory('lda')->get()
    public function scopeByCategory($query, $category)
    {
        $match = self::CATEGORIES[$category]['match'] ?? [];

        return $query->where(function ($q) use ($category, $match) {
            $q->where('category', $category);
            foreach ($match as $word) {
                $q->orWhere('title', 'like', "%{$word}%")->orWhere('summary', 'like', "%{$word}%");
            }
        });
    }

    // ── HELPERS ───────────────────────────────────────────
    // Returns the full URL for this article
    // e.g. https://dsdproperties.in/news/lda-it-city-plots
    public function getUrlAttribute(): string
    {
        return url('/news/' . $this->slug);
    }

    // Returns a human-readable category label
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category]['label'] ?? 'News';
    }

    public function getCategoryColorAttribute(): string
    {
        return self::CATEGORIES[$this->category]['color'] ?? '#64748b';
    }
}
