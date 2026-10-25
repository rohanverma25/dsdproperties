{{--
    One message bubble, server-rendered. Messages that arrive while the page is
    open are rendered by the matching Alpine template in index.blade.php — keep
    the two in step.
--}}
<div @class(['flex', 'justify-end' => $m->is_outbound])>
    <div @class([
            'max-w-[80%] rounded-2xl px-3 py-2 text-sm shadow-sm',
            'bg-brandTeal/25 text-slate-900 rounded-br-sm' => $m->is_outbound,
            'bg-white text-slate-800 rounded-bl-sm' => ! $m->is_outbound,
        ])>

        @if($m->is_viewable_image)
            <a href="{{ $m->media_url }}" target="_blank" rel="noopener" class="block">
                <img src="{{ $m->media_url }}" alt="{{ $m->media_name }}" loading="lazy"
                     class="mb-1 max-h-72 w-auto rounded-xl border border-black/5 bg-white object-contain">
            </a>
        @elseif($m->is_playable_audio)
            <audio controls preload="none" src="{{ $m->media_url }}" class="mb-1 w-56 max-w-full"></audio>
        @elseif($m->has_media)
            <a href="{{ $m->media_url }}"
               class="mb-1 flex items-center gap-2.5 rounded-xl bg-black/5 px-3 py-2 hover:bg-black/10">
                <i class="fa-solid fa-file-arrow-down text-slate-500"></i>
                <span class="min-w-0">
                    <span class="block truncate text-xs font-semibold text-slate-700">{{ $m->media_name }}</span>
                    @if($m->media_size_label)
                        <span class="block text-[10px] text-slate-500">{{ $m->media_size_label }}</span>
                    @endif
                </span>
            </a>
        @endif

        {{-- A media message only shows text when it actually had a caption. --}}
        @if(filled($m->body) || ! $m->has_media)
            <p class="whitespace-pre-wrap break-words">{{ $m->has_media ? $m->body : $m->preview }}</p>
        @endif

        <p class="mt-1 flex items-center justify-end gap-1.5 text-[10px] text-slate-500">
            <span>{{ $m->sent_at->format('d M, g:i a') }}</span>
            @if($m->is_outbound)
                <i class="{{ $m->status_icon }}" data-status="{{ $m->id }}"></i>
            @endif
        </p>
    </div>
</div>
