<?php
namespace App\Http\Controllers\BlogEditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogEditor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BlogEditorController extends Controller
{
    public function index()
    {
        $blogs = BlogEditor::orderBy('updated_at', 'desc')->get();
        return view('blog_editor.index', compact('blogs'));
    }

    public function edit($id)
    {
        $blog = BlogEditor::findOrFail($id);
        return view('blog_editor.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content_html' => 'required',
            'title' => 'required|string|max:255',
        ]);

        $blog = BlogEditor::findOrFail($id);
        $blog->title = $request->title;
        $blog->content_html = $request->content_html;
        $blog->save();
return redirect()->back()->with('success', 'Blog fully updated!');
        //return redirect()->route('blog_editor.index')->with('success', 'Blog updated successfully!');
    }

    public function autosave(Request $request, $id)
    {
        $blog = BlogEditor::findOrFail($id);
        $blog->content_html = $request->content_html;
        $blog->save();

        return response()->json(['status' => 'success', 'message' => 'Auto-saved']);
    }

    public function preview($id)
    {
        $blog = BlogEditor::findOrFail($id);
        return view('blog_editor.preview', compact('blog'));
    }
    public function fullEdit($id)
    {
        $blog = BlogEditor::findOrFail($id);

        return view('blog_editor.settings', compact('blog'));
    }

public function fullUpdate(Request $request, $id)
{
    try {

        $blog = BlogEditor::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content_html' => 'required',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        DB::beginTransaction();

        $blog->update([
            'title'            => $request->title,
            'slug'             => $request->slug,
            'featured_image'   => $request->featured_image,
            'alt'              => $request->alt,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'tag'              => $request->tag,
            'tags'             => $request->tags,
            'outline'          => $request->outline,
            'content_html'     => $request->content_html,
            'seo_schema'       => $request->seo_schema,
            'blog_summary'     => $request->blog_summary ?? "test summary",
            'language'         => $request->language,
            'alternate_slug'   => $request->alternate_slug,
            'status'           => $request->status,
        ]);

        DB::commit();

        return redirect()->back()->with('success', 'Blog fully updated!');

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('Blog Full Update Failed', [
            'blog_id'   => $id,
            'user_id'   => auth()->id(),
            'error'     => $e->getMessage(),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
            'request'   => $request->except(['content_html']), // avoid huge logs
        ]);

        return redirect()->back()->withInput()->with('error', 'Something went wrong while updating the blog.');
    }
}
    public function create()
{
    // Returns the same layout as full_edit but with an empty model
    return view('blog_editor.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content_html' => 'required',
        'status' => 'required|in:draft,published',
    ]);

    // Create the record with all fields from your schema
    BlogEditor::create([
        'title'            => $request->title,
        'slug'             => $request->slug,
        'featured_image'   => $request->featured_image,
        'alt'              => $request->alt,
        'meta_description' => $request->meta_description,
        'meta_keywords'    => $request->meta_keywords,
        'tag'              => $request->tag,
        'tags'             => $request->tags,
        'outline'          => $request->outline,
        'content_html'     => $request->content_html,
        'seo_schema'       => $request->seo_schema,
        'blog_summary'     => $request->blog_summary??"test summary",
        'status'           => $request->status,
        'language'         => $request->language,
        'author_id'        => auth()->id() ?? 1, // Uses logged in user or default
    ]);

    return redirect()->route('blog_editor.index')->with('success', 'New blog created successfully!');
}

public function toggleStatus($id)
{
    $blog = BlogEditor::findOrFail($id);
    
    // Toggle logic
    $blog->status = ($blog->status === 'published') ? 'draft' : 'published';
    $blog->save();

    return back()->with('success', 'Status updated to ' . $blog->status);
}

public function destroy($id)
{
    $blog = BlogEditor::findOrFail($id);
    $blog->delete();

    return redirect()->route('blog_editor.index')->with('success', 'Blog deleted successfully');
}
}
?>