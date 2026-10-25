<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $blog = BlogPost::latest('updated_at')
            ->where('language', 'en')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('meta_description', 'like', "%{$search}%")
                      ->orWhere('meta_keywords', 'like', "%{$search}%");
                });
            })
            ->paginate(20)
            ->withQueryString();

        return view('blogs.show-all', compact('blog', 'search'));
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

    return view('blogs.show', compact('blog', 'recentBlogs', 'author', 'relatedPosts', 'approvedComments'));
}
    public function previewBlog(){
        $recentBlogs = BlogPost::latest()->paginate(10);
        return view('blogs.preview-blog-page', compact('recentBlogs'));
    }

    public function homePage(){
        $blogs       = BlogPost::whereNotNull('featured_image')->latest()->take(3)->get();
        $recentPosts = BlogPost::orderBy('created_at', 'DESC')->paginate(20);
        $news        = \App\Models\NewsArticle::latest()->take(3)->get();
        $properties  = \App\Models\PropertyListing::published()->with('images')->latest()->take(6)->get();
        return view('pages.home', compact('blogs', 'recentPosts', 'news', 'properties'));
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
    public function authorsBlogs($authorId)
    {
  $authors = [
    [
        'id' => 1,
        'name' => 'Ravi Ahuja',
        'description' => 'Ravi Ahuja is a seasoned real estate consultant with over 12 years of experience in Lucknow’s residential market. He specializes in premium apartments and plotted developments, helping families find their dream homes with transparency and trust.'
    ],
    [
        'id' => 2,
        'name' => 'Anjali Singh',
        'description' => 'Anjali Singh is an expert in commercial properties, office spaces, and retail projects across Uttar Pradesh. With a keen eye for business growth opportunities, she assists startups and corporates in securing the right locations for long-term success.'
    ],
    [
        'id' => 3,
        'name' => 'Vikram Yadav',
        'description' => 'Vikram Yadav focuses on agricultural land, plots, and farmhouse properties. With strong connections in rural and semi-urban areas, he has successfully guided investors toward profitable land deals while ensuring all documentation is clear and hassle-free.'
    ],
    [
        'id' => 4,
        'name' => 'Priya Verma',
        'description' => 'Priya Verma is a luxury property consultant specializing in high-end bungalows, villas, and gated communities. She has worked with elite clients in Lucknow’s posh localities, ensuring exclusivity, confidentiality, and premium investment opportunities.'
    ],
    [
        'id' => 5,
        'name' => 'Rahul Gupta',
        'description' => 'Rahul Gupta is known for his expertise in affordable housing and government-approved projects. He has assisted hundreds of first-time homebuyers in making the right choice by balancing budget, location, and future appreciation potential.'
    ],
    [
        'id' => 6,
        'name' => 'Neha Mishra',
        'description' => 'Neha Mishra is a trusted investment advisor with over a decade of experience in real estate portfolio management. She helps clients build wealth through strategic property investments in upcoming residential and commercial hubs in Lucknow.'
    ],
    [
        'id' => 7,
        'name' => 'Amit Tiwari',
        'description' => 'Amit Tiwari specializes in rental and lease properties, catering to both landlords and tenants. His expertise lies in matching properties with the right clients and ensuring long-term occupancy with legally secure agreements.'
    ],
    [
        'id' => 8,
        'name' => 'Kavita Joshi',
        'description' => 'Kavita Joshi works extensively with NRI clients looking to invest in Indian real estate. She provides end-to-end support including property selection, legal verification, and asset management, making her a reliable partner for overseas investors.'
    ],
    [
        'id' => 9,
        'name' => 'Sanjay Kumar',
        'description' => 'Sanjay Kumar is a property legal advisor with deep expertise in documentation, registrations, and dispute resolution. With more than 15 years in the field, he ensures that every property transaction is safe, compliant, and stress-free for his clients.'
    ],
    [
        'id' => 10,
        'name' => 'Deepa Agarwal',
        'description' => 'Deepa Agarwal is passionate about smart city projects and modern infrastructure developments. She specializes in identifying opportunities in Lucknow’s upcoming townships and future-ready projects, offering valuable insights to forward-looking investors.'
    ],
];
  return $authors[$authorId] ?? null;   
    }
}
