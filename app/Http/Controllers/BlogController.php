<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogComment;
use App\Models\GoogleReview;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $category = $request->input('category');

        // Fixed category list — keys match exact DB values
        $allTags = [
            'Property Law'     => 'Property Law',
            'Legal Advice'     => 'Legal Advice',
            'LDA Scheme Guide' => 'LDA Scheme Guide',
            'Buying Tips'      => 'Buying Tips',
            'Selling Tips'     => 'Selling Tips',
        ];

        // /blog lists English articles only (user, 17 Nov 2026). Hindi posts stay live at their own URLs.
        $blog = BlogPost::where('status', 'published')
            ->where('language', 'en')
            ->latest('updated_at')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('meta_description', 'like', "%{$search}%")
                      ->orWhere('meta_keywords', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($query, $category) {
                $query->where('tag', $category);
            })
            ->paginate(20)
            ->withQueryString();

        return view('blogs.show-all', compact('blog', 'search', 'allTags', 'category'));
    }

public function show($slug)
{
    $blog = BlogPost::where('slug', $slug)->firstOrFail();
    $author = $this->authorsBlogs($blog->author_id);

    // ── Recent blogs for sidebar (exclude current) ──
    $recentBlogs = BlogPost::where('id', '!=', $blog->id)
                           ->latest()
                           ->paginate(10);

    // ── Related posts: same category tag, exclude current ──
    $relatedPosts = BlogPost::where('id', '!=', $blog->id)
                            ->where('tag', $blog->tag)
                            ->latest()
                            ->take(4)
                            ->get();

    // ── Fallback: if same category has < 4 posts, fill with recent ──
    if ($relatedPosts->count() < 4) {
        $existingIds = $relatedPosts->pluck('id')->push($blog->id);

        $fillPosts = BlogPost::whereNotIn('id', $existingIds)
                             ->latest()
                             ->take(4 - $relatedPosts->count())
                             ->get();

        $relatedPosts = $relatedPosts->concat($fillPosts);
    }

    $approvedComments = BlogComment::where('blog_post_id', $blog->id)
                                    ->approved()
                                    ->latest()
                                    ->get();

    // Option A: NULL tags = show on all pages; tagged = show only on matching blog category
    // Option A: NULL tags = show on all pages; tagged = show only on matching blog category
    $googleReviews = GoogleReview::active()
                                 ->when($blog->tag, function ($q) use ($blog) {
                                     $q->where(function ($inner) use ($blog) {
                                         $inner->whereNull('tags')
                                               ->orWhereJsonContains('tags', $blog->tag);
                                     });
                                 })
                                 ->orderByRaw('CASE WHEN tags IS NOT NULL THEN 0 ELSE 1 END ASC')
                                 ->orderBy('sort_order')
                                 ->orderByDesc('review_date')
                                 ->get();

    return view('blogs.show', compact('blog', 'recentBlogs', 'author', 'relatedPosts', 'approvedComments', 'googleReviews'));
}
    public function previewBlog(){
        $recentBlogs = BlogPost::latest()->paginate(10);
        return view('blogs.preview-blog-page', compact('recentBlogs'));
    }

    public function homePage(){
        $blogs       = BlogPost::whereNotNull('featured_image')->latest()->take(3)->get();
        $news        = \App\Models\NewsArticle::published()->listed()->latest()->take(3)->get();
        $properties  = \App\Models\PropertyListing::published()->with('images')->latest()->take(6)->get();
        $reviews     = \App\Models\GoogleReview::active()->orderBy('sort_order')->orderByDesc('review_date')->take(6)->get();
        $reviewCount = config('google_reviews.total');
        $reviewAvg   = number_format(config('google_reviews.rating'), 1);
        $localities  = \App\Models\PropertyListing::published()->distinct()->orderBy('locality')->pluck('locality');
        return view('pages.home', compact('blogs', 'news', 'properties', 'reviews', 'reviewCount', 'reviewAvg', 'localities'));
    }
    public function store(Request $request)
    {
        //
    }

    public function edit(Blog $blog)
    {
        //
    }

    public function update(Request $request, Blog $blog)
    {
        //
    }

    public function destroy(Blog $blog)
    {
        //
    }
    // Every post is written by the one real author in config/author.php (18 Nov 2026). This used to pick one of ten
    // invented personas by author_id (and off by one); they were removed. author_id is now ignored.
    public function authorsBlogs($authorId)
    {
        $a = config('author');
        return ['name' => $a['name'], 'description' => $a['bio'], 'url' => url('/author/' . $a['slug'])];
    }

}
