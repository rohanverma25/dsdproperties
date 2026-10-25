<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (session()->has('seller_id')) {
            return redirect()->route('seller.dashboard');
        }
        return view('seller.auth.register');
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:sellers,email',
            'phone'    => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'city'     => 'nullable|string|max:100',
            'about'    => 'nullable|string|max:1000',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $photo = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/sellers'), $name);
            $photo = 'uploads/sellers/' . $name;
        }

        $seller = Seller::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'whatsapp'      => $request->whatsapp,
            'password'      => $request->password,
            'profile_photo' => $photo,
            'city'          => $request->city ?: 'Lucknow',
            'about'         => $request->about,
        ]);

        session([
            'seller_id'   => $seller->id,
            'seller_name' => $seller->name,
        ]);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Welcome! Your seller account has been created.');
    }

    public function showLogin()
    {
        if (session()->has('seller_id')) {
            return redirect()->route('seller.dashboard');
        }
        return view('seller.auth.login');
    }

    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $seller = Seller::where('email', $request->email)->first();

        if (!$seller || !$seller->verifyPassword($request->password)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }

        if ($seller->status === 'suspended') {
            return back()->withErrors(['email' => 'Your account has been suspended. Please contact support.']);
        }

        session([
            'seller_id'   => $seller->id,
            'seller_name' => $seller->name,
        ]);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Welcome back, ' . $seller->name . '!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['seller_id', 'seller_name']);
        return redirect()->route('seller.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
