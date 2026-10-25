<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\PropertyListing;
use App\Models\Seller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = Seller::findOrFail(session('seller_id'));

        $stats = [
            'total'     => $seller->listings()->count(),
            'published' => $seller->listings()->where('status', 'published')->count(),
            'pending'   => $seller->listings()->where('status', 'pending')->count(),
            'draft'     => $seller->listings()->where('status', 'draft')->count(),
            'views'     => $seller->listings()->sum('views'),
            'inquiries' => $seller->listings()->withCount('inquiries')->get()->sum('inquiries_count'),
        ];

        $recentListings = $seller->listings()
            ->with('images')
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard.index', compact('seller', 'stats', 'recentListings'));
    }

    public function profile()
    {
        $seller = Seller::findOrFail(session('seller_id'));
        return view('seller.dashboard.profile', compact('seller'));
    }

    public function updateProfile(Request $request)
    {
        $seller = Seller::findOrFail(session('seller_id'));

        $rules = [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:100',
            'about'    => 'nullable|string|max:1000',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = $request->only('name', 'phone', 'whatsapp', 'city', 'about');

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/sellers'), $name);
            $data['profile_photo'] = 'uploads/sellers/' . $name;
        }

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $seller->update($data);
        session(['seller_name' => $seller->name]);

        return back()->with('success', 'Profile updated successfully.');
    }
}
