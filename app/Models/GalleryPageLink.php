<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryPageLink extends Model
{
    protected $fillable = ['gallery_id', 'page_url'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
