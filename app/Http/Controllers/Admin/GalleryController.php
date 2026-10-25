<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\GalleryPageLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::withCount('images')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $galleries = $query->paginate(20)->withQueryString();

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:news_clipping,ground_reality',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);
        $original = $slug;
        $i = 1;
        while (Gallery::where('slug', $slug)->exists()) {
            $slug = $original . '-' . (++$i);
        }

        $gallery = Gallery::create([
            'type'        => $request->type,
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.galleries.edit', $gallery)
            ->with('success', "Gallery \"{$gallery->name}\" created. Slug: [gallery:{$gallery->slug}]");
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load(['images', 'pageLinks']);
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function uploadImages(Request $request, Gallery $gallery)
    {
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|max:5120',
        ]);

        $dir = 'uploads/galleries/' . $gallery->id;
        $maxSort = (int) $gallery->images()->max('sort_order');

        foreach ($request->file('images') as $i => $file) {
            $name = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($dir), $name);

            GalleryImage::create([
                'gallery_id'  => $gallery->id,
                'image_path'  => $dir . '/' . $name,
                'sort_order'  => $maxSort + $i + 1,
            ]);
        }

        return back()->with('success', 'Images uploaded.');
    }

    public function updateImage(Request $request, GalleryImage $image)
    {
        $request->validate([
            'caption'      => 'nullable|string|max:255',
            'source_name'  => 'nullable|string|max:255',
            'published_on' => 'nullable|date',
            'sort_order'   => 'nullable|integer',
        ]);

        $image->update($request->only(['caption', 'source_name', 'published_on', 'sort_order']));

        return back()->with('success', 'Image updated.');
    }

    public function destroyImage(GalleryImage $image)
    {
        $gallery = $image->gallery;
        $fullPath = public_path($image->image_path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
        $image->delete();

        return redirect()->route('admin.galleries.edit', $gallery)->with('success', 'Image deleted.');
    }

    public function addPageLink(Request $request, Gallery $gallery)
    {
        $request->validate([
            'page_url' => 'required|string|max:255',
        ]);

        $pageUrl = '/' . ltrim(trim($request->page_url), '/');

        GalleryPageLink::firstOrCreate([
            'gallery_id' => $gallery->id,
            'page_url'   => $pageUrl,
        ]);

        return back()->with('success', 'Page link added.');
    }

    public function removePageLink(GalleryPageLink $link)
    {
        $gallery = $link->gallery;
        $link->delete();

        return redirect()->route('admin.galleries.edit', $gallery)->with('success', 'Page link removed.');
    }

    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->images as $image) {
            $fullPath = public_path($image->image_path);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery deleted.');
    }
}
