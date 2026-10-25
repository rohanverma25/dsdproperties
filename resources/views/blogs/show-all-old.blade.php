@extends('layouts.user-app')
@section('content')
<style>
    .blog-card {
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .blog-card:hover {
        transform: translateY(-5px);
    }
    
    .blog-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    .blog-image img {
        transition: transform 0.5s ease;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .blog-card:hover .blog-image img {
        transform: scale(1.05);
    }
    
    .category-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(1, 31, 75, 0.85);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }
    
    .featured-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--color-accent);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }
    
    .author-info {
        display: flex;
        align-items: center;
    }
    .author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }
    
    .filter-btn {
        transition: all 0.3s ease;
    }
    .filter-btn.active {
        background-color: var(--color-primary);
        color: white;
    }
</style>

<!-- Hero Section -->
<section class="relative gradient-primary text-white py-20 md:py-28">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Real Estate Blog</h1>
            <p class="text-xl text-teal-100 max-w-2xl mx-auto">
                Stay updated with the latest trends, insights, and tips about the Lucknow property market.
            </p>
            <div class="mt-8 mx-auto relative" id="blog-search-wrapper" style="max-width:560px;width:100%;padding:0 16px;box-sizing:border-box;">
                <div style="display:flex;width:100%;">
                    <input
                        type="text"
                        id="blog-search-input"
                        value="{{ $search ?? '' }}"
                        placeholder="Search articles..."
                        autocomplete="off"
                        style="flex:1;min-width:0;padding:12px 20px;border-radius:9999px 0 0 9999px;border:none;outline:none;font-size:16px;color:#1f2937;width:100%;"
                    >
                    <button type="button" id="blog-search-btn" style="padding:12px 20px;border-radius:0 9999px 9999px 0;border:none;cursor:pointer;font-size:15px;font-weight:600;color:#fff;white-space:nowrap;flex-shrink:0;background-color:var(--color-accent);">
                        Search
                    </button>
                </div>

                <!-- Live search dropdown -->
                <div id="blog-search-dropdown"
                     class="absolute left-0 right-0 bg-white rounded-2xl shadow-2xl mt-2 overflow-hidden z-50 hidden">
                    <div id="blog-search-results"></div>
                    <div id="blog-search-loading" class="hidden" style="padding:16px;text-align:center;font-size:14px;color:#6b7280;">Searching...</div>
                    <div id="blog-search-empty"   class="hidden" style="padding:16px;text-align:center;font-size:14px;color:#6b7280;">No results found.</div>
                </div>
            </div>
            @if(!empty($search))
            <p class="mt-3 text-teal-200 text-sm">Showing results for: <span class="font-semibold text-white">"{{ $search }}"</span> &mdash; <a href="{{ route('blog.index') }}" class="underline">Clear</a></p>
            @endif
        </div>
    </div>
</section>

<!-- Blog Categories Section -->
<section class="py-12" style="background-color: var(--color-light-teal);">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-3">
            <button class="filter-btn active px-4 py-2 bg-card rounded-full text-sm font-medium">
                All Posts
            </button>
            <button class="filter-btn px-4 py-2 bg-card rounded-full text-sm font-medium">
                Buying Tips
            </button>
            <button class="filter-btn px-4 py-2 bg-card rounded-full text-sm font-medium">
                Investment
            </button>
            <button class="filter-btn px-4 py-2 bg-card rounded-full text-sm font-medium">
                Legal Advice
            </button>
            <button class="filter-btn px-4 py-2 bg-card rounded-full text-sm font-medium">
                Market Trends
            </button>
            <button class="filter-btn px-4 py-2 bg-card rounded-full text-sm font-medium">
                Property Spotlight
            </button>
        </div>
    </div>
</section>

<!-- Featured Post Section -->
<section class="py-12 bg-card">
    <div class="container mx-auto px-4">
        <div class="bg-card rounded-xl overflow-hidden card-shadow max-w-5xl mx-auto">
            <div class="md:flex">
                <div class="">
                    <div class="md:h-full">
                        <img src="https://dsdproperties.in/public/images/blogs/lucknow-real-estate-2026-2027.png" alt="Featured post">
                        <div class="featured-badge">FEATURED</div>
                    </div>
                </div>
                <div class="md:w-1/2 p-8">
                    <div class="category-badge">Market Trends</div>
                    <h2 class="text-2xl font-bold mb-4 mt-2">Lucknow Real Estate Market 2026-2027</h2>
                    <p class="mb-6">Planning to buy property in Lucknow in 2026? Read the verified price forecast, SCR infrastructure update, top 7 hotspots &amp; investment safety checklist.</p>
                    <div class="flex items-center justify-between">
                        <div class="author-info">
                            <!-- <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Author" class="author-avatar"> -->
                            <div>
                                <div class="font-medium">Anjali Singh</div>
                                <div class="text-sm">Mar 4, 2026</div>
                            </div>
                        </div>
                        <a href="{{url('blog/lucknow-real-estate-market-predictions-2026-2027')}}" class="bg-accent hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition">
                            Read Article
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts Section -->
<section class="py-16" style="background-color: var(--color-light-teal);">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Latest Articles</h2>
            <p class="max-w-2xl mx-auto">
                Explore our most recent insights on the Lucknow property market.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($blog as $post)
            <div class="blog-card bg-card rounded-xl overflow-hidden card-shadow">
                <div class="blog-image">
                    @if($post->featured_image)
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}">
                    @endif
                    @if($post->tag)
                    <div class="category-badge">{{$post->tag}}</div>  
                    @endif
                    @if($loop->index == 0)
                    <div class="featured-badge">NEW</div>
                    @endif
                </div>
                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex items-center text-sm mb-3 gap-4">
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @php
                                $readTime = 5; // default fallback
                                if (isset($blog) && isset($blog->content_html)) {
                                    $wordCount = str_word_count(strip_tags($blog->content_html));
                                    $readTime = max(1, ceil($wordCount / 200));
                                }
                            @endphp
                            {{ $readTime }} min read
                        </span>
                    </div>
                    <a href="{{ route('blog.show', $post->slug) }}"><h3 class="text-xl font-bold mb-3 hover:text-accent transition">{{ $post->title }}</h3></a>
                    <p class="mb-4 flex-grow">{{ Str::limit(strip_tags($post->meta_description), 120) }}</p>
                    <div class="flex items-center justify-between mt-auto">
                        <!-- <div class="author-info">
                            <img src="https://randomuser.me/api/portraits/{{ $loop->index % 2 == 0 ? 'women' : 'men' }}/{{ $loop->index + 20 }}.jpg" alt="Author" class="author-avatar">
                            <span class="text-sm">{{ $loop->index % 2 == 0 ? 'Priya Singh' : 'Amit Verma' }}</span>
                        </div> -->
                        <a href="{{ route('blog.show', $post->slug) }}" class="font-medium hover:underline flex items-center" style="color: var(--color-accent);">
                            Read More <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                @if(!empty($search))
                <h3 class="text-xl font-semibold mb-2">No results for "{{ $search }}"</h3>
                <p class="mb-4">Try a different keyword or browse all posts.</p>
                <a href="{{ route('blog.index') }}" class="px-5 py-2 rounded-full text-white text-sm font-medium" style="background-color: var(--color-accent);">View All Posts</a>
                @else
                <h3 class="text-xl font-semibold mb-2">No blog posts found</h3>
                <p>Check back later for new content.</p>
                @endif
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $blog->links('pagination::tailwind') }}
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<x-newsletter 
    title="Subscribe to Our Newsletter"
    description="Get the latest real estate insights and property updates delivered to your inbox." 
/>

<!-- Popular Articles Section -->
<section class="py-16 bg-card">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Popular Articles</h2>
            <p class="max-w-2xl mx-auto">
                Check out our most-read articles on the Lucknow property market.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Popular Post 1 -->
            <div class="rounded-xl overflow-hidden card-shadow flex" style="background-color: var(--color-light-teal);">
                <div class="w-1/3">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=300&q=80" alt="Popular post" class="w-full h-full object-cover">
                </div>
                <div class="w-2/3 p-6">
                    <div class="text-sm mb-2">Featured</div>
                    <h3 class="text-lg font-bold mb-2">Top Residential Areas in Lucknow for 2025</h3>
                    <p class="text-sm mb-3">Discover the best neighborhoods to invest in Lucknow's growing real estate market.</p>
                    <a href="{{url('blog/top-residential-areas-lucknow-2025-5DYWl')}}" class="font-medium hover:underline text-sm" style="color: var(--color-accent);">Read Article</a>
                </div>
            </div>
            
            <!-- Popular Post 2 -->
            <div class="rounded-xl overflow-hidden card-shadow flex" style="background-color: var(--color-light-teal);">
                <div class="w-1/3">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=300&q=80" alt="Popular post" class="w-full h-full object-cover">
                </div>
                <div class="w-2/3 p-6">
                    <div class="text-sm mb-2">Investment Guide</div>
                    <h3 class="text-lg font-bold mb-2">Understanding RERA Regulations in Uttar Pradesh</h3>
                    <p class="text-sm mb-3">A comprehensive guide to real estate regulations for property buyers in UP.</p>
                    <a href="{{url('/blog/understanding-rera-guide-lucknow-property-buyers-C7ECl')}}" class="font-medium hover:underline text-sm" style="color: var(--color-accent);">Read Article</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category filter
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Live search
    const input      = document.getElementById('blog-search-input');
    const dropdown   = document.getElementById('blog-search-dropdown');
    const results    = document.getElementById('blog-search-results');
    const loading    = document.getElementById('blog-search-loading');
    const empty      = document.getElementById('blog-search-empty');
    const searchBtn  = document.getElementById('blog-search-btn');

    let debounceTimer = null;

    function showDropdown() { dropdown.classList.remove('hidden'); }
    function hideDropdown() { dropdown.classList.add('hidden'); }

    function renderResults(blogs) {
        results.innerHTML = '';
        loading.classList.add('hidden');

        if (!blogs.length) {
            empty.classList.remove('hidden');
            return;
        }
        empty.classList.add('hidden');

        blogs.forEach((blog, index) => {
            const url = '/blog/' + blog.slug;
            const item = document.createElement('a');
            item.href = url;
            item.target = '_blank';
            item.rel = 'noopener noreferrer';
            item.style.cssText = 'display:flex;align-items:center;gap:12px;padding:12px 16px;text-decoration:none;border-bottom:1px solid #f3f4f6;transition:background 0.15s;cursor:pointer;';
            item.onmouseover = () => item.style.background = '#f9fafb';
            item.onmouseout  = () => item.style.background = '';

            const imgHtml = blog.featured_image
                ? `<img src="${blog.featured_image}" alt="" style="width:56px;height:56px;object-fit:cover;border-radius:8px;flex-shrink:0;">`
                : `<div style="width:56px;height:56px;border-radius:8px;flex-shrink:0;background:#e5e7eb;display:flex;align-items:center;justify-content:center;">
                     <svg width="22" height="22" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                   </div>`;

            const title = `<p style="margin:0;font-size:14px;font-weight:600;color:#111827;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${blog.title}</p>`;
            const desc  = blog.meta_description
                ? `<p style="margin:4px 0 0;font-size:12px;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${blog.meta_description.substring(0, 90)}</p>`
                : '';

            item.innerHTML = imgHtml + `<div style="min-width:0;flex:1;">${title}${desc}</div>`;
            results.appendChild(item);
        });
    }

    function doSearch(q) {
        if (q.length < 2) { hideDropdown(); return; }

        results.innerHTML = '';
        empty.classList.add('hidden');
        loading.classList.remove('hidden');
        showDropdown();

        fetch('/api/blogs/search?q=' + encodeURIComponent(q))
            .then(r => r.json())
            .then(data => renderResults(data.results || []))
            .catch(() => { loading.classList.add('hidden'); empty.classList.remove('hidden'); });
    }

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const q = this.value.trim();
        if (q.length < 2) { hideDropdown(); return; }
        debounceTimer = setTimeout(() => doSearch(q), 300);
    });

    // Click search button → open blog listing with search
    searchBtn.addEventListener('click', function() {
        const q = input.value.trim();
        if (q) window.location.href = '/blog?search=' + encodeURIComponent(q);
    });

    // Enter key → same as button
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') searchBtn.click();
        if (e.key === 'Escape') hideDropdown();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!document.getElementById('blog-search-wrapper').contains(e.target)) {
            hideDropdown();
        }
    });
});
</script>
@endsection