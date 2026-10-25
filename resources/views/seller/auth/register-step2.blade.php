@extends('seller.auth.partials.wizard-layout', ['step' => 2, 'title' => 'Contact Details'])

@section('content')
    <h1 class="text-lg font-bold text-brand mb-1">Hi {{ $seller->name }} 👋</h1>
    <p class="text-sm text-slate-500 mb-6">A couple of contact details so buyers can reach you</p>

    @if ($errors->any())
        <div class="px-3.5 py-2.5 rounded-lg text-sm mb-4 bg-red-50 text-red-800 border border-red-200">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('seller.register.step2.post') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">WhatsApp Number</label>
            <input type="tel" name="whatsapp" value="{{ old('whatsapp', $seller->whatsapp) }}" placeholder="Same as phone or different"
                class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-teal/20 focus:border-brand-teal">
            <p class="text-[11px] text-slate-400 mt-1">Buyers will message you here — leave blank to use your phone number.</p>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">City</label>
            <input type="text" name="city" value="{{ old('city', $seller->city ?: 'Lucknow') }}" placeholder="Lucknow"
                class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-teal/20 focus:border-brand-teal">
        </div>

        <div class="flex flex-col sm:flex-row gap-3 mt-2">
            <button type="submit" name="skip_to_dashboard" value="1"
                class="order-2 sm:order-1 w-full sm:w-auto py-3 px-4 rounded-lg border border-slate-200 text-slate-500 text-sm font-medium hover:bg-slate-50 transition-colors">
                Skip for now
            </button>
            <button type="submit"
                class="order-1 sm:order-2 w-full py-3 rounded-lg bg-brand hover:bg-[#023372] text-white text-sm font-semibold transition-colors">
                Continue →
            </button>
        </div>
        <p class="text-[11px] text-center text-slate-400">Step 2 of 3 — saved automatically, come back anytime from your profile.</p>
    </form>
@endsection
