<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterDelivery extends Model
{
    protected $fillable = ['campaign_id', 'email', 'name', 'status', 'token', 'error', 'sent_at'];

    protected $casts = ['sent_at' => 'datetime', 'opened_at' => 'datetime', 'clicked_at' => 'datetime'];

    public function campaign()
    {
        return $this->belongsTo(NewsletterCampaign::class, 'campaign_id');
    }
}
