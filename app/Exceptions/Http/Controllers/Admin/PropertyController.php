<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyListing;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = PropertyListing::with('seller')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%$q%")
                    ->orWhere('locality', 'like', "%$q%");
            });
        }

        $listings  = $query->paginate(20)->withQueryString();
        $counts    = [
            'all'       => PropertyListing::count(),
            'pending'   => PropertyListing::where('status', 'pending')->count(),
            'published' => PropertyListing::where('status', 'published')->count(),
            'rejected'  => PropertyListing::where('status', 'rejected')->count(),
            'draft'     => PropertyListing::where('status', 'draft')->count(),
        ];

        return view('admin.properties.index', compact('listings', 'counts'));
    }

    public function show(PropertyListing $property)
    {
        $property->load(['seller', 'images', 'inquiries' => fn($q) => $q->latest()->take(10)]);
        return view('admin.properties.show', compact('property'));
    }

    public function updateStatus(Request $request, PropertyListing $property)
    {
        $request->validate([
            'status'           => 'required|in:published,rejected,pending,archived,draft',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);

        $property->update([
            'status'           => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
        ]);

        $label = ucfirst($request->status);
        return back()->with('success', "Property \"{$property->title}\" has been {$label}.");
    }

    public function destroy(PropertyListing $property)
    {
        $property->delete();
        return redirect()->route('admin.properties.index')
            ->with('success', 'Property deleted permanently.');
    }
}
