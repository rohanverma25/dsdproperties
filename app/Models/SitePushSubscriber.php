<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** A browser that allowed website notifications (OneSignal). */
class SitePushSubscriber extends Model
{
    protected $fillable = ['subscription_id', 'topics', 'page_topic', 'source_path', 'source_type'];
}
