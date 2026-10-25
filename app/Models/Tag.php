<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function listings()
    {
        return $this->belongsToMany(PropertyListing::class, 'listing_tag', 'tag_id', 'listing_id');
    }

    public static function findOrCreateByName(string $name): self
    {
        $slug = Str::slug($name);
        return static::firstOrCreate(['slug' => $slug], ['name' => trim($name)]);
    }
}
