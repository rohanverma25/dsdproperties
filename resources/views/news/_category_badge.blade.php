{{--
    resources/views/news/_category_badge.blade.php
    Usage: @include('news._category_badge', ['category' => $article->category, 'label' => $article->category_label])
    Colours come from NewsArticle::CATEGORIES.
--}}
@php
    $c = \App\Models\NewsArticle::CATEGORIES[$category]['color'] ?? '#64748b';
@endphp

<span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border"
      style="color:{{ $c }}; background:color-mix(in srgb, {{ $c }} 10%, #fff); border-color:color-mix(in srgb, {{ $c }} 30%, #fff);">
    {{ $label }}
</span>
