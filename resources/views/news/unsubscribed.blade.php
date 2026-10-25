@extends('layouts.app-article')

{{-- Newsletter unsubscribe / language page. A GET shows a confirm button (mail scanners open links but
     don't press buttons); the POST back to the same signed URL saves the choice. --}}
@section('seo')
    <title>{{ ($mode ?? '') === 'language' ? 'Email language' : 'Unsubscribe' }} | DSD Properties</title>
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<div style="max-width:560px;margin:60px auto;padding:0 16px;text-align:center;">
    @if($done)
        <div style="width:56px;height:56px;border-radius:50%;background:#ecfdf5;color:#059669;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:26px;">✓</div>
        @if($mode === 'language')
            <h1 style="font-size:1.5rem;font-weight:800;color:#011f4b;margin:0 0 10px;">Thanks, preference saved</h1>
            <p style="color:#4b5563;line-height:1.7;margin:0 0 22px;">We'll send the weekly email to {{ $email }} in {{ $lang === 'hi' ? 'Hindi (हिंदी)' : 'English' }} where we can.</p>
        @else
            <h1 style="font-size:1.5rem;font-weight:800;color:#011f4b;margin:0 0 10px;">You're unsubscribed</h1>
            <p style="color:#4b5563;line-height:1.7;margin:0 0 22px;">{{ $email }} won't receive the DSD Properties weekly email any more.</p>
        @endif
        <a href="{{ url('/news') }}" style="display:inline-block;background:#011f4b;color:#fff;padding:12px 20px;border-radius:10px;font-weight:700;text-decoration:none;">Read Lucknow property news</a>
    @else
        <form method="POST" action="{{ request()->fullUrl() }}">
            <input type="hidden" name="confirm" value="1">
            @if($mode === 'language')
                <h1 style="font-size:1.5rem;font-weight:800;color:#011f4b;margin:0 0 10px;">Get the weekly email in {{ $lang === 'hi' ? 'Hindi (हिंदी)' : 'English' }}?</h1>
                <p style="color:#4b5563;line-height:1.7;margin:0 0 22px;">For {{ $email }}</p>
                <button type="submit" style="background:#011f4b;color:#fff;border:0;padding:13px 22px;border-radius:10px;font-weight:700;font-size:15px;cursor:pointer;">Yes, save my preference</button>
            @else
                <h1 style="font-size:1.5rem;font-weight:800;color:#011f4b;margin:0 0 10px;">Unsubscribe from the weekly email?</h1>
                <p style="color:#4b5563;line-height:1.7;margin:0 0 22px;">{{ $email }} will stop receiving the DSD Properties weekly report.</p>
                <button type="submit" style="background:#dc2626;color:#fff;border:0;padding:13px 22px;border-radius:10px;font-weight:700;font-size:15px;cursor:pointer;">Unsubscribe</button>
            @endif
        </form>
    @endif
</div>
@endsection
