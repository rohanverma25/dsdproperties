<?php

namespace App\Http\Controllers;

use App\Models\BlogFeedback;
use Illuminate\Http\Request;

class BlogFeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|min:2|max:100',
            'mobile'     => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'suggestion' => 'required|string|min:5|max:1000',
        ]);

        BlogFeedback::create([
            'name'       => $validated['name'],
            'mobile'     => $validated['mobile'],
            'suggestion' => $validated['suggestion'],
            'page_url'   => $request->input('page_url', ''),
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['success' => true]);
    }

    public function adminIndex(Request $request)
    {
        $feedbacks = BlogFeedback::latest()->paginate(30);
        return view('admin.feedbacks.index', compact('feedbacks'));
    }
}
