<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $sellers = Seller::withCount('listings')
            ->when($request->q, fn($q, $search) => $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%"))
            ->latest()
            ->paginate(20);

        return view('admin.sellers.index', compact('sellers'));
    }

    public function impersonate(Seller $seller)
    {
        session([
            'seller_id'          => $seller->id,
            'seller_name'        => $seller->name,
            'admin_impersonating' => true,
        ]);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Logged in as ' . $seller->name);
    }
}
