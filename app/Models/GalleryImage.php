<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['gallery_id', 'image_path', 'caption', 'source_name', 'published_on', 'sort_order'];

    protected $casts = [
        'published_on' => 'date',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getUrlAttribute(): string
    {
        return asset($this->image_path);
    }
}
