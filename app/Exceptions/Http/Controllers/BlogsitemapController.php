<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BlogsitemapController extends Controller
{
    public function blogs()
    {
        $blogs = DB::table('blog_posts')
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();
        $content = view('sitemaps.blogs', compact('blogs'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}