<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BlogApiController extends Controller
{
    /**
     * Get paginated blogs with search and category filtering
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 12);
            $page = $request->input('page', 1);
            $category = $request->input('category', 'all');
            $search = $request->input('search', '');
            
            // Start query
            $query = BlogPost::where('status', 'published')
                ->where('language', 'en')
                ->orderBy('created_at', 'desc');
            
            // Apply category filter
            if ($category && $category !== 'all') {
                $query->whereJsonContains('tags', $category);
            }
            
            // Apply search filter
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('meta_description', 'like', '%' . $search . '%')
                      ->orWhere('meta_keywords', 'like', '%' . $search . '%')
                      ->orWhere('content_html', 'like', '%' . $search . '%');
                });
            }
            
            // Paginate results
            $blogs = $query->paginate($perPage, [
                'id',
                'title',
                'slug',
                'featured_image',
                'alt',
                'meta_description',
                'tags',
                'created_at'
            ], 'page', $page);
            
            // Format response
            return response()->json([
                'success' => true,
                'blogs' => $blogs->items(),
                'pagination' => [
                    'total' => $blogs->total(),
                    'per_page' => $blogs->perPage(),
                    'current_page' => $blogs->currentPage(),
                    'last_page' => $blogs->lastPage(),
                    'total_pages' => $blogs->lastPage(),
                    'from' => $blogs->firstItem(),
                    'to' => $blogs->lastItem(),
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load blogs',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
    
    public function search(Request $request): JsonResponse
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $results = BlogPost::where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('meta_description', 'like', "%{$q}%")
                      ->orWhere('meta_keywords', 'like', "%{$q}%")
                      ->orWhere('tag', 'like', "%{$q}%");
            })
            ->latest('updated_at')
            ->limit(8)
            ->get(['title', 'slug', 'featured_image', 'meta_description']);

        return response()->json(['results' => $results]);
    }

    /**
     * Get blog categories with post counts
     *
     * @return JsonResponse
     */
    public function categories(): JsonResponse
    {
        try {
            $blogs = BlogPost::where('status', 'published')
                ->where('language', 'en')
                ->get(['tags']);
            
            $categories = [];
            
            foreach ($blogs as $blog) {
                if ($blog->tags && is_array($blog->tags)) {
                    foreach ($blog->tags as $tag) {
                        if (!isset($categories[$tag])) {
                            $categories[$tag] = 0;
                        }
                        $categories[$tag]++;
                    }
                }
            }
            
            // Sort by count descending
            arsort($categories);
            
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load categories',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
}
