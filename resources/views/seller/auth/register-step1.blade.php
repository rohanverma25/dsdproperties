@extends('seller.auth.partials.wizard-layout', ['step' => 1, 'title' => 'Create Seller Account'])

@section('content')
    <h1 class="text-lg font-bold text-brand mb-1">Create Seller Account</h1>
    <p class="text-sm text-slate-500 mb-5">Start listing your properties — it's 100% free</p>

    <div class="flex gap-2.5 mb-6 p-3.5 bg-green-50 border border-green-200 rounded-xl text-center">
        <div class="flex-1 text-xs text-green-800"><strong class="block text-lg">✓</strong>Free Listing</div>
        <div class="flex-1 text-xs text-green-800"><strong class="block text-lg">∞</strong>Unlimited Photos</div>
        <div class="flex-1 text-xs text-green-800"><strong class="block text-lg">👥</strong>Direct Inquiries</div>
    </div>

    @if ($errors->any())
        <div class="px-3.5 py-2.5 rounded-lg text-sm mb-4 bg-red-50 text-red-800 border border-red-200">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('seller.register.step1') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Full Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Your full name"
                class="w-full px-3 py-2.5 text-sm rounded-lg border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-brand-teal/20 focus:border-brand-teal">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Email Address <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com"
                class="w-full px-3 py-2.5 text-sm rounded-lg border {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-brand-teal/20 focus:border-brand-teal">
            @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+91 98765 43210"
                class="w-full px-3 py-2.5 text-sm rounded-lg border {{ $errors->has('phone') ? 'border-red-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-brand-teal/20 focus:border-brand-teal">
            @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required placeholder="Min. 8 characters"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-brand-teal/20 focus:border-brand-teal">
                @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required placeholder="Re-enter password"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-teal/20 focus:border-brand-teal">
            </div>
        </div>

        <button type="submit"
            class="w-full mt-2 py-3 rounded-lg bg-brand hover:bg-[#023372] text-white text-sm font-semibold transition-colors">
            Continue →
        </button>
        <p class="text-[11px] text-center text-slate-400">Step 1 of 3 — your account is created right away, so you never lose progress.</p>
    </form>
@endsection
