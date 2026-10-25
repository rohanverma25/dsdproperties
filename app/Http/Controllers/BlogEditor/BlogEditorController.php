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
        try {
            $blog = BlogEditor::findOrFail($id);

            if ($request->expectsJson()) {
                $blog->content_html = $this->decodeContent($request) ?? $blog->content_html;
                $blog->save();
                return response()->json([
                    'status'   => 'success',
                    'message'  => 'Content saved',
                    'saved_at' => now()->format('d M Y, H:i:s'),
                ]);
            }

            $request->validate([
                'content_html' => 'required',
                'title'        => 'required|string|max:255',
            ]);

            $blog->title        = $request->title;
            $blog->content_html = $this->decodeContent($request) ?? $blog->content_html;
            $blog->save();

            return redirect()->back()->with('success', 'Content saved successfully.');
        } catch (\Exception $e) {
            Log::error('Blog Update Failed', ['id' => $id, 'error' => $e->getMessage()]);
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Save failed: ' . $e->getMessage());
        }
    }

    /**
     * Save only content_html — called via AJAX to avoid large form POST issues.
     */
    private function decodeContent(Request $request): ?string
    {
        $raw = $request->input('content_html');
        if ($raw === null) return null;
        if ($request->input('_b64')) {
            $decoded = base64_decode($raw, true);
            return $decoded !== false ? $decoded : $raw;
        }
        return $raw;
    }

    public function autosave(Request $request, $id)
    {
        try {
            $blog = BlogEditor::findOrFail($id);
            $content = $this->decodeContent($request);
            if ($content !== null) $blog->content_html = $content;
            $blog->save();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Content saved',
                'saved_at'  => now()->format('d M Y, H:i:s'),
                'size_kb'   => round(strlen($request->content_html ?? '') / 1024, 1),
            ]);
        } catch (\Exception $e) {
            Log::error('Blog Autosave Failed', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save all metadata fields except content_html.
     * Kept small intentionally so it never hits hosting size limits.
     */
    public function saveMetadata(Request $request, $id)
    {
        try {
            $blog = BlogEditor::findOrFail($id);

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
                'seo_schema'       => $request->seo_schema,
                'blog_summary'     => $request->blog_summary ?? '',
                'language'         => $request->language,
                'alternate_slug'   => $request->alternate_slug,
                'status'           => $request->status,
            ]);

            return response()->json([
                'status'   => 'success',
                'message'  => 'Settings saved',
                'saved_at' => now()->format('d M Y, H:i:s'),
            ]);
        } catch (\Exception $e) {
            Log::error('Blog Metadata Save Failed', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
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
        // Legacy fallback — should not normally be called since settings.blade.php uses AJAX.
        try {
            $blog = BlogEditor::findOrFail($id);

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
                'content_html'     => $this->decodeContent($request) ?? '',
                'seo_schema'       => $request->seo_schema,
                'blog_summary'     => $request->blog_summary ?? '',
                'language'         => $request->language,
                'alternate_slug'   => $request->alternate_slug,
                'status'           => $request->status,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json(['status' => 'success', 'message' => 'Blog fully updated']);
            }
            return redirect()->back()->with('success', 'Blog fully updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Blog Full Update Failed', [
                'id'    => $id,
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Save failed: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('blog_editor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content_html' => 'required',
            'status'       => 'required|in:draft,published',
        ]);

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
            'content_html'     => $this->decodeContent($request) ?? '',
            'seo_schema'       => $request->seo_schema,
            'blog_summary'     => $request->blog_summary ?? '',
            'status'           => $request->status,
            'language'         => $request->language,
            'author_id'        => auth()->id() ?? 1,
        ]);

        return redirect()->route('blog_editor.index')->with('success', 'Blog created successfully!');
    }

    public function toggleStatus($id)
    {
        $blog = BlogEditor::findOrFail($id);
        $blog->status = ($blog->status === 'published') ? 'draft' : 'published';
        $blog->save();
        return back()->with('success', 'Status changed to ' . $blog->status);
    }

    public function destroy($id)
    {
        $blog = BlogEditor::findOrFail($id);
        $blog->delete();
        return redirect()->route('blog_editor.index')->with('success', 'Blog deleted.');
    }
}
