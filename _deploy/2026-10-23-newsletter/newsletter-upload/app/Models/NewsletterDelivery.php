<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterDelivery extends Model
{
    protected $fillable = ['campaign_id', 'email', 'name', 'status', 'error', 'sent_at'];

    protected $casts = ['sent_at' => 'datetime'];

    public function campaign()
    {
        return $this->belongsTo(NewsletterCampaign::class, 'campaign_id');
    }
}
