<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ListingDraft;
use App\Models\PropertyImage;
use App\Models\PropertyListing;
use App\Models\Seller;
use App\Models\Tag;
use App\Support\ListingFormData;
use App\Support\PropertyTypeSchema;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    private function currentSeller(): Seller
    {
        return Seller::findOrFail(session('seller_id'));
    }

    public function index()
    {
        $seller   = $this->currentSeller();
        $listings = $seller->listings()->with('images')->latest()->paginate(10);
        return view('seller.listings.index', compact('seller', 'listings'));
    }

    public function create()
    {
        $tags  = Tag::orderBy('name')->get(['id', 'name', 'slug']);
        $draft = ListingDraft::where('seller_id', session('seller_id'))->latest()->first();

        return view('seller.listings.create', [
            'tags'       => $tags,
            'draftData'  => optional($draft)->data ?? [],
            'draftStep'  => optional($draft)->step ?? 1,
            'typeSchema' => PropertyTypeSchema::forJs(),
        ]);
    }

    /**
     * Autosave a step's fields as the seller fills the wizard, instead of
     * only persisting once the whole form is submitted at the end.
     */
    public function saveDraft(Request $request)
    {
        $step = max(1, min(4, (int) $request->input('step', 1)));

        $data = $request->except(['_token', 'step', 'featured_image', 'images', 'video', 'brochure']);

        $draft = ListingDraft::firstOrNew(['seller_id' => session('seller_id')]);
        $draft->step = max($draft->step ?? 1, $step);
        $draft->data = array_merge($draft->data ?? [], $data);
        $draft->seller_id = session('seller_id');
        $draft->save();

        return response()->json(['saved' => true, 'step' => $draft->step]);
    }

    public function store(Request $request)
    {
        $v = ListingFormData::validator($request);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $seller = $this->currentSeller();

        $data = ListingFormData::columns($request);
        $data['slug']   = PropertyListing::generateSlug($request->title);
        $data['status'] = 'pending';

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'), 'featured');
        }

        if ($request->hasFile('video')) {
            $data['video_path'] = $this->uploadVideo($request->file('video'));
        } elseif ($request->filled('youtube_url')) {
            $data['youtube_url'] = $request->youtube_url;
        }

        if ($request->hasFile('brochure')) {
            $data['brochure_path'] = $this->uploadBrochure($request->file('brochure'));
        }

        $listing = $seller->listings()->create($data);

        // No cover photo chosen but gallery photos were: promote the first one.
        if (empty($data['featured_image']) && $request->hasFile('images')) {
            $first = $this->uploadImage($request->file('images')[0], 'featured');
            $listing->update(['featured_image' => $first]);
        }

        $this->storeGalleryImages($request, $listing);

        $this->syncTags($request, $listing);

        ListingDraft::where('seller_id', $seller->id)->delete();

        return redirect()->route('seller.listings.index')
            ->with('success', 'Property submitted for review. We will publish it within 24 hours.');
    }

    public function edit(PropertyListing $listing)
    {
        $this->authoriseListing($listing);
        $listing->load('images', 'tags');
        $tags = Tag::orderBy('name')->get(['id', 'name', 'slug']);
        return view('seller.listings.edit', [
            'listing'    => $listing,
            'tags'       => $tags,
            'typeSchema' => PropertyTypeSchema::forJs(),
        ]);
    }

    public function update(Request $request, PropertyListing $listing)
    {
        $this->authoriseListing($listing);

        $v = ListingFormData::validator($request, isUpdate: true, existing: $listing);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $data = ListingFormData::columns($request, $listing);

        // A rejected listing goes back into the review queue once it is corrected.
        $data['status'] = $listing->status === 'rejected' ? 'pending' : $listing->status;

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'), 'featured');
        }

        if ($request->hasFile('brochure')) {
            $data['brochure_path'] = $this->uploadBrochure($request->file('brochure'));
        }

        if ($request->hasFile('video')) {
            $data['video_path']  = $this->uploadVideo($request->file('video'));
            $data['youtube_url'] = null;
        } elseif ($request->filled('youtube_url')) {
            $data['youtube_url'] = $request->youtube_url;
            $data['video_path']  = null;
        } elseif ($request->input('delete_video') === '1') {
            $data['video_path']  = null;
            $data['youtube_url'] = null;
        }

        $listing->update($data);

        $this->storeGalleryImages($request, $listing);

        if ($request->filled('delete_images')) {
            $ids = array_filter(array_map('intval', explode(',', $request->delete_images)));
            PropertyImage::whereIn('id', $ids)
                ->where('listing_id', $listing->id)
                ->delete();
        }

        $this->syncTags($request, $listing, detachWhenEmpty: true);

        return redirect()->route('seller.listings.index')
            ->with('success', 'Listing updated successfully.');
    }

    public function destroy(PropertyListing $listing)
    {
        $this->authoriseListing($listing);
        $listing->delete();
        return redirect()->route('seller.listings.index')
            ->with('success', 'Listing deleted.');
    }

    public function inquiries(PropertyListing $listing)
    {
        $this->authoriseListing($listing);
        $inquiries = $listing->inquiries()->latest()->paginate(20);
        return view('seller.listings.inquiries', compact('listing', 'inquiries'));
    }

    /** Appends any newly uploaded gallery photos after the existing ones. */
    private function storeGalleryImages(Request $request, PropertyListing $listing): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $sort = (int) $listing->images()->max('sort_order') + 1;

        foreach ($request->file('images') as $img) {
            PropertyImage::create([
                'listing_id' => $listing->id,
                'image_path' => $this->uploadImage($img, 'gallery'),
                'sort_order' => $sort++,
            ]);
        }
    }

    private function syncTags(Request $request, PropertyListing $listing, bool $detachWhenEmpty = false): void
    {
        $tagIds = array_filter(array_map('intval', (array) $request->input('tags', [])));

        if (! $tagIds) {
            if ($detachWhenEmpty) $listing->tags()->detach();
            return;
        }

        $listing->tags()->sync(Tag::whereIn('id', $tagIds)->pluck('id'));
    }

    private function uploadImage($file, string $type = 'gallery'): string
    {
        $dir  = 'uploads/properties/' . $type;
        $name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($dir), $name);
        return $dir . '/' . $name;
    }

    private function uploadBrochure($file): string
    {
        $dir  = 'uploads/properties/brochures';
        $name = time() . '_' . bin2hex(random_bytes(4)) . '.pdf';
        $file->move(public_path($dir), $name);
        return $dir . '/' . $name;
    }

    private function uploadVideo($file): string
    {
        $dir  = 'uploads/properties/videos';
        $name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($dir), $name);
        return $dir . '/' . $name;
    }

    private function authoriseListing(PropertyListing $listing): void
    {
        if ($listing->seller_id !== session('seller_id')) {
            abort(403, 'Unauthorized.');
        }
    }
}
