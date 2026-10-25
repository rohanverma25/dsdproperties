<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function store(Request $request, $slug)
    {
        $blog = BlogPost::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name'    => 'required|string|min:2|max:100',
            'email'   => 'required|email|max:191',
            'comment' => 'required|string|min:5|max:2000',
        ]);

        BlogComment::create([
            'blog_post_id' => $blog->id,
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'comment'      => $validated['comment'],
            'status'       => 'pending',
            'ip_address'   => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your comment has been submitted and is awaiting moderation.',
        ]);
    }

    public function approve(BlogComment $comment)
    {
        $comment->update(['status' => 'approved']);
        return back()->with('success', 'Comment approved.');
    }

    public function spam(BlogComment $comment)
    {
        $comment->update(['status' => 'spam']);
        return back()->with('success', 'Comment marked as spam.');
    }

    public function destroy(BlogComment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }

    public function adminIndex(Request $request)
    {
        $status   = $request->input('status', 'pending');
        $comments = BlogComment::with('post')
            ->where('status', $status)
            ->latest()
            ->paginate(30);

        return view('admin.comments.index', compact('comments', 'status'));
    }
}
