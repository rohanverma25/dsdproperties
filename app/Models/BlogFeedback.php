<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogFeedback extends Model
{
    protected $table = 'blog_feedbacks';

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'suggestion',
        'page_url',
        'ip_address'
    ];
}