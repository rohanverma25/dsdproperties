<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInquiry extends Model
{
    protected $table = 'property_inquiries';

    protected $fillable = ['listing_id', 'name', 'phone', 'email', 'message', 'ip_address'];

    public function listing()
    {
        return $this->belongsTo(PropertyListing::class, 'listing_id');
    }
}
