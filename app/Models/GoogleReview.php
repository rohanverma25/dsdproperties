<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleReview extends Model
{
    protected $fillable = [
        'reviewer_name',
        'rating',
        'review_text',
        'review_date',
        'is_active',
        'sort_order',
        'tags',
    ];

    protected $casts = [
        'review_date' => 'date',
        'is_active'   => 'boolean',
        'tags'        => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
