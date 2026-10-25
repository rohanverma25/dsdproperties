<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table = 'property_images';

    protected $fillable = ['listing_id', 'image_path', 'caption', 'sort_order'];

    public function listing()
    {
        return $this->belongsTo(PropertyListing::class, 'listing_id');
    }

    public function getUrlAttribute(): string
    {
        return asset($this->image_path);
    }
}
