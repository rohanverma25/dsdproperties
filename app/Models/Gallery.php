<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['type', 'name', 'slug', 'description'];

    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order');
    }

    public function pageLinks()
    {
        return $this->hasMany(GalleryPageLink::class);
    }
}
