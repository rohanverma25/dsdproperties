{{--
    resources/views/news/_category_badge.blade.php
    Usage: @include('news._category_badge', ['category' => $article->category, 'label' => $article->category_label])
--}}
@php
    $colors = [
        'lda'      => 'bg-green-50 text-green-700 border-green-200',
        'it-city'  => 'bg-blue-50 text-blue-700 border-blue-200',
        'price'    => 'bg-orange-50 text-orange-700 border-orange-200',
        'projects' => 'bg-purple-50 text-purple-700 border-purple-200',
        'policy'   => 'bg-red-50 text-red-700 border-red-200',
        'rera'     => 'bg-teal-50 text-teal-700 border-teal-200',
    ];
    $color = $colors[$category] ?? 'bg-gray-50 text-gray-700 border-gray-200';
@endphp

<span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border {{ $color }}">
    {{ $label }}
</span>
