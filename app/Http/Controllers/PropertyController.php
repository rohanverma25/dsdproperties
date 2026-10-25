<?php

namespace App\Http\Controllers;

use App\Mail\PropertyInquiryAdmin;
use App\Mail\PropertyInquiryBuyer;
use App\Models\PropertyInquiry;
use App\Models\PropertyListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = PropertyListing::published()->with('images');

        if ($request->filled('type')) {
            $query->where('property_type', $request->type);
        }
        if ($request->filled('locality')) {
            $query->where('locality', 'like', '%' . $request->locality . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', $request->bedrooms);
        }

        $listings = $query->latest()->paginate(12)->withQueryString();

        $localities = PropertyListing::published()
            ->select('locality')
            ->distinct()
            ->orderBy('locality')
            ->pluck('locality');

        return view('properties.index', compact('listings', 'localities'));
    }

    public function show(string $slug)
    {
        $listing = PropertyListing::where('slug', $slug)
            ->where('status', 'published')
            ->with(['seller', 'images'])
            ->firstOrFail();

        $listing->increment('views');

        $related = PropertyListing::published()
            ->where('id', '!=', $listing->id)
            ->where('locality', $listing->locality)
            ->with('images')
            ->take(4)
            ->get();

        return view('properties.show', compact('listing', 'related'));
    }

    public function inquiry(Request $request, PropertyListing $listing)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        PropertyInquiry::create([
            'listing_id' => $listing->id,
            'name'       => $request->name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        $inquiryData = [
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'message' => $request->message,
        ];

        try {
            if ($request->filled('email')) {
                Mail::to($request->email)->queue(new PropertyInquiryBuyer($inquiryData, $listing));
            }
            Mail::to('dheer725@gmail.com')->queue(new PropertyInquiryAdmin($inquiryData, $listing));
        } catch (\Exception $e) {
            Log::error('Property inquiry email failed: ' . $e->getMessage());
        }

        return back()->with('inquiry_sent', 'Thank you! The seller will contact you shortly.');
    }
}
