<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
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
        return $query->where('category', $category);
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
        return match($this->category) {
            'lda'      => 'LDA Update',
            'it-city'  => 'IT City',
            'price'    => 'Price Trends',
            'projects' => 'New Projects',
            'policy'   => 'Policy',
            'rera'     => 'RERA',
            default    => 'News',
        };
    }
}
