<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class BlogPost extends Model
{
    public function comments()
    {
        return $this->hasMany(\App\Models\BlogComment::class, 'blog_post_id');
    }

protected $fillable = [
'title','slug', 'alternate_slug', 'meta_description','tags','outline','content_html','status','meta_keywords','language','blog_schema', 'featured_image','alt'
];

protected $casts = [
'tags' => 'array',
'outline' => 'array',
];
}
?>