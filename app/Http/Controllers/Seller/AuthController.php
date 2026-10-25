<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registration is a 3-step wizard. Each step saves to the DB as soon as
     * it's completed (step 1 already creates the Seller row), instead of
     * only persisting on a final submit — so partial sign-ups aren't lost.
     */
    public function showRegister()
    {
        if (session()->has('seller_id')) {
            $seller = Seller::find(session('seller_id'));
            if ($seller) {
                return redirect()->route('seller.register.step' . min($seller->registration_step + 1, 3));
            }
            session()->forget(['seller_id', 'seller_name']);
        }
        return view('seller.auth.register-step1');
    }

    public function registerStep1(Request $request)
    {
        if (session()->has('seller_id')) {
            return redirect()->route('seller.register.step2');
        }

        $v = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:sellers,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $seller = Seller::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'password'          => $request->password,
            'city'              => 'Lucknow',
            'status'            => 'incomplete',
            'registration_step' => 1,
        ]);

        session([
            'seller_id'   => $seller->id,
            'seller_name' => $seller->name,
        ]);

        return redirect()->route('seller.register.step2');
    }

    public function showRegisterStep2()
    {
        $seller = $this->requireDraftSeller();
        if (!$seller instanceof Seller) {
            return $seller;
        }
        return view('seller.auth.register-step2', compact('seller'));
    }

    public function registerStep2(Request $request)
    {
        $seller = $this->requireDraftSeller();
        if (!$seller instanceof Seller) {
            return $seller;
        }

        $v = Validator::make($request->all(), [
            'whatsapp' => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:100',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $seller->update([
            'whatsapp'          => $request->whatsapp,
            'city'              => $request->city ?: 'Lucknow',
            'registration_step' => max($seller->registration_step, 2),
        ]);

        if ($request->boolean('skip_to_dashboard')) {
            return redirect()->route('seller.dashboard')
                ->with('success', 'You can finish your profile anytime from Profile settings.');
        }

        return redirect()->route('seller.register.step3');
    }

    public function showRegisterStep3()
    {
        $seller = $this->requireDraftSeller();
        if (!$seller instanceof Seller) {
            return $seller;
        }
        return view('seller.auth.register-step3', compact('seller'));
    }

    public function registerStep3(Request $request)
    {
        $seller = $this->requireDraftSeller();
        if (!$seller instanceof Seller) {
            return $seller;
        }

        if ($request->boolean('skip_to_dashboard')) {
            return redirect()->route('seller.dashboard')
                ->with('success', 'Welcome! You can add a photo and bio anytime from Profile settings.');
        }

        $v = Validator::make($request->all(), [
            'about'         => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $data = [
            'about'             => $request->about,
            'status'            => 'active',
            'registration_step' => 3,
        ];

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/sellers'), $name);
            $data['profile_photo'] = 'uploads/sellers/' . $name;
        }

        $seller->update($data);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Welcome! Your seller account is all set up.');
    }

    private function requireDraftSeller()
    {
        if (!session()->has('seller_id')) {
            return redirect()->route('seller.register')
                ->with('error', 'Please start your registration first.');
        }

        $seller = Seller::find(session('seller_id'));
        if (!$seller) {
            session()->forget(['seller_id', 'seller_name']);
            return redirect()->route('seller.register');
        }

        return $seller;
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
