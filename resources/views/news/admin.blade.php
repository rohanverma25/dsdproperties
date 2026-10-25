{{--
    resources/views/news/admin.blade.php
    URL: /admin/news  (protect this with auth middleware!)

    Add to routes/web.php:
    Route::middleware('auth')->group(function () {
        Route::get('/admin/news', [NewsAdminController::class, 'index'])->name('admin.news');
        Route::patch('/admin/news/{id}/publish', [NewsAdminController::class, 'publish'])->name('admin.news.publish');
        Route::delete('/admin/news/{id}', [NewsAdminController::class, 'destroy'])->name('admin.news.destroy');
    });
--}}

@extends('layouts.app')

@section('seo')
    <title>News Admin — DSD Properties</title>
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">News Admin</h1>
            <p class="text-sm text-gray-500 mt-1">Review AI-generated articles and publish them to the site</p>
        </div>
        <div class="flex gap-3 text-sm">
            <span class="bg-yellow-100 text-yellow-800 font-semibold px-3 py-1.5 rounded-full">
                {{ $pending }} pending
            </span>
            <span class="bg-green-100 text-green-800 font-semibold px-3 py-1.5 rounded-full">
                {{ $published }} published
            </span>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tab toggle --}}
    <div class="flex gap-2 mb-6">
        <a href="?status=pending"
           class="px-4 py-2 rounded-full text-sm font-medium
                  {{ request('status', 'pending') === 'pending' ? 'bg-blue-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Pending Review
        </a>
        <a href="?status=published"
           class="px-4 py-2 rounded-full text-sm font-medium
                  {{ request('status') === 'published' ? 'bg-blue-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Published
        </a>
    </div>

    {{-- Articles table --}}
    @if($articles->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <div class="text-4xl mb-3">📭</div>
            <p class="font-medium text-gray-600">No {{ request('status', 'pending') }} articles</p>
            @if(request('status', 'pending') === 'pending')
                <p class="text-sm mt-1">The cron runs at 8 AM daily. You can also run: <code class="bg-gray-100 px-1.5 py-0.5 rounded">php artisan news:fetch</code></p>
            @endif
        </div>
    @else
        <div class="space-y-4">
            @foreach($articles as $article)
                <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex-1 min-w-0">
                            {{-- Tags --}}
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                @include('news._category_badge', ['category' => $article->category, 'label' => $article->category_label])
                                <span class="text-xs text-gray-400">{{ $article->created_at->format('M j, Y · h:i A') }}</span>
                                @if($article->source_name)
                                    <span class="text-xs text-gray-400">· {{ $article->source_name }}</span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <h3 class="font-bold text-gray-900 mb-2">{{ $article->title }}</h3>

                            {{-- Summary preview --}}
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $article->summary }}</p>

                            {{-- Source URL --}}
                            @if($article->source_url)
                                <a href="{{ $article->source_url }}" target="_blank"
                                   class="text-xs text-blue-600 hover:underline mt-1.5 inline-block">
                                    View original source →
                                </a>
                            @endif
                        </div>

                        {{-- Action buttons --}}
                        <div class="flex flex-col gap-2 flex-shrink-0">

                            @if($article->status === 'pending')
                                {{-- Publish button --}}
                                <form action="{{ route('admin.news.publish', $article->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="w-full bg-green-600 text-white text-xs font-semibold
                                                   px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        ✓ Publish
                                    </button>
                                </form>

                                {{-- Toggle HOT badge --}}
                                <form action="{{ route('admin.news.publish', $article->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="toggle_hot" value="1">
                                    <button type="submit"
                                            class="w-full {{ $article->is_hot ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600' }}
                                                   text-xs font-semibold px-4 py-2 rounded-lg hover:opacity-80 transition-opacity">
                                        🔥 {{ $article->is_hot ? 'HOT ✓' : 'Mark HOT' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('news.show', $article->slug) }}" target="_blank"
                                   class="block text-center bg-blue-50 text-blue-700 text-xs font-semibold
                                          px-4 py-2 rounded-lg hover:bg-blue-100 transition-colors">
                                    View Live →
                                </a>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('admin.news.destroy', $article->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this article?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-red-50 text-red-600 text-xs font-semibold
                                               px-4 py-2 rounded-lg hover:bg-red-100 transition-colors">
                                    ✕ Delete
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
            <div class="mt-8">{{ $articles->links() }}</div>
        @endif
    @endif
</div>
@endsection
