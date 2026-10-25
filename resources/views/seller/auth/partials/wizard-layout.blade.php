<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Create Seller Account' }} — DSD Properties</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#011f4b', teal: '#008080' },
                    },
                },
            },
        };
    </script>
</head>
<body class="font-sans bg-slate-50 min-h-screen flex items-start justify-center px-4 py-7 sm:py-10">
<div class="w-full max-w-xl">
    <div class="text-center mb-6">
        <a href="{{ url('/') }}" class="text-xl sm:text-2xl font-bold text-brand no-underline">
            DSD <span class="text-brand-teal">Properties</span>
        </a>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Seller Account Portal — List your property for free</p>
    </div>

    {{-- Step progress --}}
    <div class="flex items-center gap-2 mb-6 px-1" aria-label="Registration progress">
        @foreach ([1 => 'Account', 2 => 'Contact', 3 => 'Profile'] as $num => $label)
            <div class="flex-1 flex flex-col items-center gap-1.5">
                <div class="h-1.5 w-full rounded-full {{ $step >= $num ? 'bg-brand-teal' : 'bg-slate-200' }}"></div>
                <span class="text-[11px] font-medium {{ $step >= $num ? 'text-brand' : 'text-slate-400' }}">
                    {{ $num }}. {{ $label }}
                </span>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-lg shadow-brand/5 p-6 sm:p-9">
        @yield('content')
    </div>

    <div class="text-center mt-5 text-sm text-slate-500">
        Already have an account? <a href="{{ route('seller.login') }}" class="text-brand-teal font-medium no-underline">Login here</a>
    </div>
</div>
</body>
</html>
