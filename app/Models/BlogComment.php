<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = ['blog_post_id', 'name', 'email', 'comment', 'status', 'ip_address'];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
