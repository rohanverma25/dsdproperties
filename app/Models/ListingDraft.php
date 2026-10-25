<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingDraft extends Model
{
    protected $fillable = ['seller_id', 'step', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
