@if ($paginator->hasPages())
    <style>
    .dsd-pager { display:flex; flex-wrap:wrap; align-items:center; justify-content:center; gap:6px; margin-top:8px; font-family:'Poppins',sans-serif; }
    .dsd-pager__item {
        display:inline-flex; align-items:center; justify-content:center;
        min-width:38px; height:38px; padding:0 10px;
        border:1px solid var(--border-color,#e5e7eb); border-radius:8px;
        background:var(--card-bg,#fff); color:var(--text-secondary,#4b5563);
        font-size:.85rem; font-weight:600; text-decoration:none;
        font-family:'Poppins',sans-serif; transition:all .18s;
    }
    a.dsd-pager__item:hover { border-color:var(--color-secondary,#008080); color:var(--color-secondary,#008080); background:var(--color-light-teal,#e0f2f1); text-decoration:none; }
    .dsd-pager__item--active { background:var(--color-primary,#011f4b); border-color:var(--color-primary,#011f4b); color:#fff; cursor:default; }
    .dsd-pager__item--disabled { color:var(--text-tertiary,#9ca3af); cursor:default; opacity:.5; }
    .dsd-pager__item--dots { border-color:transparent; background:transparent; cursor:default; }
    </style>
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="dsd-pager">
        @if ($paginator->onFirstPage())
            <span class="dsd-pager__item dsd-pager__item--arrow dsd-pager__item--disabled" aria-hidden="true">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="dsd-pager__item dsd-pager__item--arrow" aria-label="{{ __('pagination.previous') }}">&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="dsd-pager__item dsd-pager__item--dots" aria-disabled="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="dsd-pager__item dsd-pager__item--active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="dsd-pager__item" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="dsd-pager__item dsd-pager__item--arrow" aria-label="{{ __('pagination.next') }}">&raquo;</a>
        @else
            <span class="dsd-pager__item dsd-pager__item--arrow dsd-pager__item--disabled" aria-hidden="true">&raquo;</span>
        @endif
    </nav>
@endif
