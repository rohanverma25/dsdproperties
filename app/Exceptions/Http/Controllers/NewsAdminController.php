<?php

// FILE: app/Http/Controllers/NewsAdminController.php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsAdminController extends Controller
{
    // GET /admin/news
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $articles = NewsArticle::where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $pending   = NewsArticle::pending()->count();
        $published = NewsArticle::published()->count();

        return view('news.admin', compact('articles', 'pending', 'published'));
    }

    // PATCH /admin/news/{id}/publish
    // Publishes article OR toggles HOT flag
    public function publish(Request $request, int $id)
    {
        $article = NewsArticle::findOrFail($id);

        if ($request->input('toggle_hot')) {
            // Just toggle the HOT badge
            $article->update(['is_hot' => !$article->is_hot]);
            return back()->with('success', 'HOT badge updated.');
        }

        // Publish the article
        $article->update(['status' => 'published']);
        return back()->with('success', "'{$article->title}' is now live on the website.");
    }

    // DELETE /admin/news/{id}
    public function destroy(int $id)
    {
        $article = NewsArticle::findOrFail($id);
        $title   = $article->title;
        $article->delete();

        return back()->with('success', "'{$title}' was deleted.");
    }
}
