<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogEditor extends Model
{
    protected $table = 'blog_posts'; // same table, but unique model name

    protected $guarded = [];
}
?>