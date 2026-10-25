@extends('layouts.user-app')

@section('title', 'DSD Properties Blog - Real Estate Insights & Property Updates in Lucknow')
@section('meta_description', 'Expert insights on Lucknow real estate, LDA plots, property investment guides, and latest updates on IT City, Wellness City, and Varun Vihar.')
@section('meta_keywords', 'Lucknow real estate blog, LDA plots guide, property investment Lucknow, IT City updates, real estate news')

@push('styles')
<style>
/* Blog Index Optimized Styles */
.blog-hero {
    background: linear-gradient(135deg, #011f4b 0%, #008080 100%);
    padding: 4rem 0 3rem;
    position: relative;
    overflow: hidden;
}

.blog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,0 L1200,0 L1200,80 Q900,100 600,80 T0,80 Z" fill="rgba(255,255,255,0.05)"/></svg>') bottom center no-repeat;
    background-size: cover;
}

.blog-hero-content {
    position: relative;
    z-index: 1;
}

.search-filter-container {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    margin-top: -2rem;
    margin-bottom: 3rem;
}

.search-box {
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-box input:focus {
    outline: none;
    border-color: #008080;
    box-shadow: 0 0 0 4px rgba(0, 128, 128, 0.1);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
}

.category-filters {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}

.category-btn {
    padding: 0.625rem 1.25rem;
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.category-btn:hover {
    border-color: #008080;
    color: #008080;
    transform: translateY(-2px);
}

.category-btn.active {
    background: #008080;
    border-color: #008080;
    color: white;
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.blog-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    cursor: pointer;
}

.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.blog-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
    background: #f3f4f6;
}

.blog-content {
    padding: 1.5rem;
}

.blog-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.blog-category {
    display: inline-block;
    padding: 0.375rem 0.875rem;
    background: #e0f2f1;
    color: #008080;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.blog-date {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.blog-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.blog-excerpt {
    color: #6b7280;
    font-size: 0.9375rem;
    line-height: 1.6;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.read-more {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #008080;
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    transition: gap 0.3s ease;
}

.read-more:hover {
    gap: 0.75rem;
}

.loading-spinner {
    display: none;
    text-align: center;
    padding: 3rem;
}

.loading-spinner.active {
    display: block;
}

.spinner {
    border: 3px solid #f3f4f6;
    border-top: 3px solid #008080;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.no-results {
    text-align: center;
    padding: 4rem 2rem;
    display: none;
}

.no-results.active {
    display: block;
}

.no-results-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}

.pagination {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.page-btn {
    padding: 0.625rem 1rem;
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 8px;
    color: #374151;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.page-btn:hover:not(:disabled) {
    border-color: #008080;
    color: #008080;
}

.page-btn.active {
    background: #008080;
    border-color: #008080;
    color: white;
}

.page-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .blog-hero {
        padding: 3rem 0 2rem;
    }
    
    .search-filter-container {
        padding: 1.25rem;
        margin-top: -1.5rem;
    }
    
    .blog-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .category-filters {
        gap: 0.5rem;
    }
    
    .category-btn {
        font-size: 0.8125rem;
        padding: 0.5rem 1rem;
    }
}

@media (max-width: 480px) {
    .blog-title {
        font-size: 1.125rem;
    }
    
    .blog-excerpt {
        font-size: 0.875rem;
    }
}
</style>
@endpush

@section('content')
<!-- Blog Hero -->
<section class="blog-hero">
    <div class="blog-hero-content container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Real Estate Insights</h1>
            <p class="text-xl text-teal-100 max-w-2xl mx-auto">Expert guides on Lucknow properties, LDA plots, and investment opportunities</p>
        </div>
    </div>
</section>

<!-- Search and Filter -->
<section class="container mx-auto px-4">
    <div class="search-filter-container">
        <div class="search-box">
            <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="blogSearch" placeholder="Search blogs by title, location, or keywords..." />
        </div>
        
        <div class="category-filters">
            <button class="category-btn active" data-category="all">All Posts</button>
            <button class="category-btn" data-category="lda-plots">LDA Plots</button>
            <button class="category-btn" data-category="investment-guide">Investment Guides</button>
            <button class="category-btn" data-category="legal-advice">Legal Advice</button>
            <button class="category-btn" data-category="market-trends">Market Trends</button>
            <button class="category-btn" data-category="property-news">Property News</button>
        </div>
    </div>
</section>

<!-- Blog Grid -->
<section class="container mx-auto px-4">
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner"></div>
        <p class="text-gray-600 mt-4">Loading blogs...</p>
    </div>
    
    <div class="blog-grid" id="blogGrid">
        <!-- Blogs will be loaded via AJAX -->
    </div>
    
    <div class="no-results" id="noResults">
        <div class="no-results-icon">📝</div>
        <h3 class="text-2xl font-bold text-gray-700 mb-2">No blogs found</h3>
        <p class="text-gray-500">Try adjusting your search or filter criteria</p>
    </div>
    
    <div class="pagination-container" id="paginationContainer">
        <!-- Pagination will be loaded via AJAX -->
    </div>
</section>

<!-- Newsletter Section -->
@include('components.newsletter-form')
@endsection

@push('scripts')
<script>
// Blog AJAX Handler
const BlogHandler = {
    currentPage: 1,
    perPage: 12,
    currentCategory: 'all',
    currentSearch: '',
    debounceTimer: null,
    
    init() {
        this.bindEvents();
        this.loadBlogs();
    },
    
    bindEvents() {
        // Search input with debounce
        document.getElementById('blogSearch').addEventListener('input', (e) => {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.currentSearch = e.target.value;
                this.currentPage = 1;
                this.loadBlogs();
            }, 500);
        });
        
        // Category filters
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                e.target.classList.add('active');
                this.currentCategory = e.target.dataset.category;
                this.currentPage = 1;
                this.loadBlogs();
            });
        });
    },
    
    async loadBlogs() {
        const spinner = document.getElementById('loadingSpinner');
        const grid = document.getElementById('blogGrid');
        const noResults = document.getElementById('noResults');
        
        // Show loading
        spinner.classList.add('active');
        grid.innerHTML = '';
        noResults.classList.remove('active');
        
        try {
            const response = await fetch(`/api/blogs?page=${this.currentPage}&per_page=${this.perPage}&category=${this.currentCategory}&search=${encodeURIComponent(this.currentSearch)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) throw new Error('Failed to load blogs');
            
            const data = await response.json();
            
            // Hide loading
            spinner.classList.remove('active');
            
            if (data.blogs && data.blogs.length > 0) {
                this.renderBlogs(data.blogs);
                this.renderPagination(data.pagination);
            } else {
                noResults.classList.add('active');
            }
        } catch (error) {
            console.error('Error loading blogs:', error);
            spinner.classList.remove('active');
            grid.innerHTML = '<div class="col-span-full text-center py-8 text-red-600">Error loading blogs. Please try again.</div>';
        }
    },
    
    renderBlogs(blogs) {
        const grid = document.getElementById('blogGrid');
        grid.innerHTML = blogs.map(blog => `
            <article class="blog-card" onclick="window.location.href='/blog/${blog.slug}'">
                <img src="${blog.featured_image || '/images/blog-placeholder.jpg'}" 
                     alt="${blog.alt || blog.title}" 
                     class="blog-image"
                     loading="lazy"
                     onerror="this.src='/images/blog-placeholder.jpg'">
                <div class="blog-content">
                    <div class="blog-meta">
                        ${blog.tags && blog.tags[0] ? `<span class="blog-category">${this.formatCategory(blog.tags[0])}</span>` : ''}
                        <span class="blog-date">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            ${this.formatDate(blog.created_at)}
                        </span>
                    </div>
                    <h2 class="blog-title">${blog.title}</h2>
                    <p class="blog-excerpt">${blog.meta_description || this.stripHtml(blog.content_html).substring(0, 150) + '...'}</p>
                    <a href="/blog/${blog.slug}" class="read-more">
                        Read Full Guide
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </article>
        `).join('');
    },
    
    renderPagination(pagination) {
        const container = document.getElementById('paginationContainer');
        if (!pagination || pagination.total_pages <= 1) {
            container.innerHTML = '';
            return;
        }
        
        let paginationHTML = '<div class="pagination">';
        
        // Previous button
        paginationHTML += `<button class="page-btn" ${pagination.current_page === 1 ? 'disabled' : ''} onclick="BlogHandler.goToPage(${pagination.current_page - 1})">Previous</button>`;
        
        // Page numbers
        for (let i = 1; i <= pagination.total_pages; i++) {
            if (i === 1 || i === pagination.total_pages || (i >= pagination.current_page - 1 && i <= pagination.current_page + 1)) {
                paginationHTML += `<button class="page-btn ${i === pagination.current_page ? 'active' : ''}" onclick="BlogHandler.goToPage(${i})">${i}</button>`;
            } else if (i === pagination.current_page - 2 || i === pagination.current_page + 2) {
                paginationHTML += '<span class="px-2">...</span>';
            }
        }
        
        // Next button
        paginationHTML += `<button class="page-btn" ${pagination.current_page === pagination.total_pages ? 'disabled' : ''} onclick="BlogHandler.goToPage(${pagination.current_page + 1})">Next</button>`;
        
        paginationHTML += '</div>';
        container.innerHTML = paginationHTML;
    },
    
    goToPage(page) {
        this.currentPage = page;
        this.loadBlogs();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    
    formatCategory(category) {
        return category.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    },
    
    formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    },
    
    stripHtml(html) {
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || '';
    }
};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    BlogHandler.init();
});
</script>
@endpush
