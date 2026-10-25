<?php

namespace App\Http\Controllers;

use App\Models\GoogleReview;
use Illuminate\Http\Request;

class GoogleReviewController extends Controller
{
    private array $categories = [
        'Property Law',
        'Legal Advice',
        'LDA Scheme Guide',
        'Buying Tips',
        'Selling Tips',
    ];

    public function adminIndex()
    {
        $reviews    = GoogleReview::orderBy('sort_order')->orderByDesc('review_date')->get();
        $categories = $this->categories;
        return view('admin.reviews.index', compact('reviews', 'categories'));
    }

    public function publicIndex()
    {
        $reviews = GoogleReview::active()
            ->orderBy('sort_order')
            ->orderByDesc('review_date')
            ->paginate(12);

        $avgRating    = round(GoogleReview::active()->avg('rating'), 1);
        $totalReviews = GoogleReview::active()->count();

        return view('pages.reviews', compact('reviews', 'avgRating', 'totalReviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|min:1|max:5',
            'review_text'   => 'required|string|max:2000',
            'review_date'   => 'required|date',
            'sort_order'    => 'nullable|integer|min:0|max:9999',
            'tags'          => 'nullable|array',
            'tags.*'        => 'string',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['tags']       = !empty($validated['tags']) ? $validated['tags'] : null;
        GoogleReview::create($validated);

        return back()->with('success', 'Review added successfully.');
    }

    public function update(Request $request, GoogleReview $review)
    {
        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|min:1|max:5',
            'review_text'   => 'required|string|max:2000',
            'review_date'   => 'required|date',
            'sort_order'    => 'nullable|integer|min:0|max:9999',
            'tags'          => 'nullable|array',
            'tags.*'        => 'string',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['tags']       = !empty($validated['tags']) ? $validated['tags'] : null;
        $review->update($validated);

        return back()->with('success', 'Review updated.');
    }

    public function toggle(GoogleReview $review)
    {
        $review->update(['is_active' => !$review->is_active]);
        return back()->with('success', 'Review visibility updated.');
    }

    public function destroy(GoogleReview $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
