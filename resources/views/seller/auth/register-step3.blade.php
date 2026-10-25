@extends('seller.auth.partials.wizard-layout', ['step' => 3, 'title' => 'Your Profile'])

@section('content')
    <h1 class="text-lg font-bold text-brand mb-1">Almost done!</h1>
    <p class="text-sm text-slate-500 mb-6">Add a photo and short intro — this builds trust with buyers</p>

    @if ($errors->any())
        <div class="px-3.5 py-2.5 rounded-lg text-sm mb-4 bg-red-50 text-red-800 border border-red-200">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('seller.register.step3.post') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Profile Photo</label>
            <input type="file" name="profile_photo" accept="image/*"
                class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-brand-teal/10 file:text-brand-teal file:text-xs file:font-semibold hover:file:bg-brand-teal/20">
            <p class="text-[11px] text-slate-400 mt-1">Optional. JPG/PNG, max 2MB</p>
            @error('profile_photo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">About You / Agency</label>
            <textarea name="about" rows="4" placeholder="Brief intro — your experience, areas you cover..."
                class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-teal/20 focus:border-brand-teal resize-y">{{ old('about', $seller->about) }}</textarea>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 mt-2">
            <button type="submit" name="skip_to_dashboard" value="1"
                class="order-2 sm:order-1 w-full sm:w-auto py-3 px-4 rounded-lg border border-slate-200 text-slate-500 text-sm font-medium hover:bg-slate-50 transition-colors">
                Skip for now
            </button>
            <button type="submit"
                class="order-1 sm:order-2 w-full py-3 rounded-lg bg-brand hover:bg-[#023372] text-white text-sm font-semibold transition-colors">
                Finish & Go to Dashboard →
            </button>
        </div>
        <p class="text-[11px] text-center text-slate-400">Step 3 of 3 — you can always update this later from Profile settings.</p>
    </form>
@endsection
