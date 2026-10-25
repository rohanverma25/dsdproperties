<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** One notification sent from /admin/push. */
class SitePushSend extends Model
{
    protected $fillable = ['title', 'message', 'url', 'image', 'audience', 'onesignal_id', 'status', 'error'];
}
