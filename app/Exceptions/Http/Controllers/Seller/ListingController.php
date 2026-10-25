<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\PropertyImage;
use App\Models\PropertyListing;
use App\Models\Seller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $tags = Tag::orderBy('name')->get(['id', 'name', 'slug']);
        return view('seller.listings.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'title'            => 'required|string|max:255',
            'property_type'    => 'required|in:' . implode(',', array_keys(PropertyListing::$propertyTypes)),
            'transaction_type' => 'required|in:sell,rent',
            'price'            => 'required_unless:price_on_request,1|nullable|integer|min:0',
            'area'             => 'nullable|numeric|min:0',
            'area_unit'        => 'required|in:' . implode(',', array_keys(PropertyListing::$areaUnits)),
            'bedrooms'         => 'nullable|integer|min:0|max:20',
            'bathrooms'        => 'nullable|integer|min:0|max:20',
            'balconies'        => 'nullable|integer|min:0|max:20',
            'floor_no'         => 'nullable|integer|min:0|max:200',
            'total_floors'     => 'nullable|integer|min:0|max:200',
            'furnishing'       => 'nullable|in:' . implode(',', array_keys(PropertyListing::$furnishingLabels)),
            'property_age'     => 'nullable|in:' . implode(',', array_keys(PropertyListing::$ageLabels)),
            'facing'           => 'nullable|string|max:50',
            'parking'          => 'nullable|string|max:50',
            'address'          => 'required|string',
            'locality'         => 'required|string|max:255',
            'landmark'         => 'nullable|string|max:255',
            'pincode'          => 'nullable|string|max:10',
            'description'      => 'required|string|min:30',
            'amenities'        => 'nullable|array',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'video'            => 'nullable|mimes:mp4,mov,webm,avi|max:102400',
            'youtube_url'      => 'nullable|url|max:500',
            'lat'              => 'nullable|numeric|between:-90,90',
            'lng'              => 'nullable|numeric|between:-180,180',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $seller   = $this->currentSeller();
        $slug     = PropertyListing::generateSlug($request->title);
        $featured = null;

        if ($request->hasFile('featured_image')) {
            $featured = $this->uploadImage($request->file('featured_image'), 'featured');
        }

        $video      = null;
        $youtubeUrl = null;
        if ($request->hasFile('video')) {
            $video = $this->uploadVideo($request->file('video'));
        } elseif ($request->filled('youtube_url')) {
            $youtubeUrl = $request->youtube_url;
        }

        $listing = $seller->listings()->create([
            'title'            => $request->title,
            'slug'             => $slug,
            'property_type'    => $request->property_type,
            'transaction_type' => $request->transaction_type,
            'price'            => $request->price_on_request ? 0 : (int) $request->price,
            'price_negotiable' => $request->boolean('price_negotiable'),
            'price_on_request' => $request->boolean('price_on_request'),
            'area'             => $request->area,
            'area_unit'        => $request->area_unit,
            'bedrooms'         => $request->bedrooms,
            'bathrooms'        => $request->bathrooms,
            'balconies'        => $request->balconies,
            'floor_no'         => $request->floor_no,
            'total_floors'     => $request->total_floors,
            'furnishing'       => $request->furnishing,
            'property_age'     => $request->property_age,
            'facing'           => $request->facing,
            'parking'          => $request->parking,
            'address'          => $request->address,
            'locality'         => $request->locality,
            'landmark'         => $request->landmark,
            'pincode'          => $request->pincode,
            'description'      => $request->description,
            'amenities'        => $request->amenities ?? [],
            'featured_image'   => $featured,
            'video_path'       => $video,
            'youtube_url'      => $youtubeUrl,
            'lat'              => $request->filled('lat') ? (float) $request->lat : null,
            'lng'              => $request->filled('lng') ? (float) $request->lng : null,
            'status'           => 'pending',
        ]);

        if ($request->hasFile('images')) {
            $sort = 0;
            foreach ($request->file('images') as $img) {
                $path = $this->uploadImage($img, 'gallery');
                PropertyImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                    'sort_order' => $sort++,
                ]);
            }
        }

        if ($request->filled('tags')) {
            $tagIds = array_filter(array_map('intval', (array) $request->input('tags')));
            $listing->tags()->sync(Tag::whereIn('id', $tagIds)->pluck('id'));
        }

        return redirect()->route('seller.listings.index')
            ->with('success', 'Property submitted for review. We will publish it within 24 hours.');
    }

    public function edit(PropertyListing $listing)
    {
        $this->authoriseListing($listing);
        $listing->load('images', 'tags');
        $tags = Tag::orderBy('name')->get(['id', 'name', 'slug']);
        return view('seller.listings.edit', compact('listing', 'tags'));
    }

    public function update(Request $request, PropertyListing $listing)
    {
        $this->authoriseListing($listing);

        $v = Validator::make($request->all(), [
            'title'            => 'required|string|max:255',
            'property_type'    => 'required|in:' . implode(',', array_keys(PropertyListing::$propertyTypes)),
            'transaction_type' => 'required|in:sell,rent',
            'price'            => 'required_unless:price_on_request,1|nullable|integer|min:0',
            'area'             => 'nullable|numeric|min:0',
            'area_unit'        => 'required|in:' . implode(',', array_keys(PropertyListing::$areaUnits)),
            'bedrooms'         => 'nullable|integer|min:0|max:20',
            'bathrooms'        => 'nullable|integer|min:0|max:20',
            'balconies'        => 'nullable|integer|min:0|max:20',
            'floor_no'         => 'nullable|integer|min:0|max:200',
            'total_floors'     => 'nullable|integer|min:0|max:200',
            'furnishing'       => 'nullable|in:' . implode(',', array_keys(PropertyListing::$furnishingLabels)),
            'property_age'     => 'nullable|in:' . implode(',', array_keys(PropertyListing::$ageLabels)),
            'facing'           => 'nullable|string|max:50',
            'parking'          => 'nullable|string|max:50',
            'address'          => 'required|string',
            'locality'         => 'required|string|max:255',
            'landmark'         => 'nullable|string|max:255',
            'pincode'          => 'nullable|string|max:10',
            'description'      => 'required|string|min:30',
            'amenities'        => 'nullable|array',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'video'            => 'nullable|mimes:mp4,mov,webm,avi|max:102400',
            'youtube_url'      => 'nullable|url|max:500',
            'lat'              => 'nullable|numeric|between:-90,90',
            'lng'              => 'nullable|numeric|between:-180,180',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $data = [
            'title'            => $request->title,
            'property_type'    => $request->property_type,
            'transaction_type' => $request->transaction_type,
            'price'            => $request->price_on_request ? 0 : (int) $request->price,
            'price_negotiable' => $request->boolean('price_negotiable'),
            'price_on_request' => $request->boolean('price_on_request'),
            'area'             => $request->area,
            'area_unit'        => $request->area_unit,
            'bedrooms'         => $request->bedrooms,
            'bathrooms'        => $request->bathrooms,
            'balconies'        => $request->balconies,
            'floor_no'         => $request->floor_no,
            'total_floors'     => $request->total_floors,
            'furnishing'       => $request->furnishing,
            'property_age'     => $request->property_age,
            'facing'           => $request->facing,
            'parking'          => $request->parking,
            'address'          => $request->address,
            'locality'         => $request->locality,
            'landmark'         => $request->landmark,
            'pincode'          => $request->pincode,
            'description'      => $request->description,
            'amenities'        => $request->amenities ?? [],
            'lat'              => $request->filled('lat') ? (float) $request->lat : null,
            'lng'              => $request->filled('lng') ? (float) $request->lng : null,
            'status'           => in_array($listing->status, ['rejected']) ? 'pending' : $listing->status,
        ];

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'), 'featured');
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

        if ($request->hasFile('images')) {
            $sort = $listing->images()->max('sort_order') + 1;
            foreach ($request->file('images') as $img) {
                $path = $this->uploadImage($img, 'gallery');
                PropertyImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                    'sort_order' => $sort++,
                ]);
            }
        }

        if ($request->filled('delete_images')) {
            $ids = array_map('intval', explode(',', $request->delete_images));
            PropertyImage::whereIn('id', $ids)
                ->where('listing_id', $listing->id)
                ->delete();
        }

        if ($request->has('tags')) {
            $tagIds = array_filter(array_map('intval', (array) $request->input('tags')));
            $listing->tags()->sync(Tag::whereIn('id', $tagIds)->pluck('id'));
        } else {
            $listing->tags()->detach();
        }

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

    private function uploadImage($file, string $type = 'gallery'): string
    {
        $dir  = 'uploads/properties/' . $type;
        $name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();
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
