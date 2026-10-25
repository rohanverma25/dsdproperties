@extends('admin.layouts.app')
@section('page-title', 'WhatsApp settings')

@section('content')
<div class="mx-auto max-w-3xl">

    <div class="mb-5 flex items-center justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.12em] text-slate-400">WhatsApp</p>
            <h1 class="text-2xl font-bold leading-tight text-brandNavy">Quick replies &amp; labels</h1>
        </div>
        <a href="{{ route('admin.whatsapp.index') }}" class="btn-outline btn-sm">
            <i class="fa-solid fa-inbox"></i> Inbox
        </a>
    </div>

    @foreach(['success' => 'success', 'info' => 'info', 'error' => 'danger'] as $key => $tone)
        @if(session($key))
            <div class="alert-{{ $tone }} mb-4">{{ session($key) }}</div>
        @endif
    @endforeach

    @if($errors->any())
        <div class="alert-danger mb-4">
            <ul class="list-disc space-y-0.5 pl-4">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- ------------------------------------------------------- quick replies --}}
    <section class="card-p mb-6">
        <h2 class="text-base font-bold text-brandNavy">Quick replies</h2>
        <p class="help mb-4">
            Type <code class="rounded bg-slate-100 px-1 font-mono text-[11px]">/shortcut</code> in the composer to drop
            one in. <code class="rounded bg-slate-100 px-1 font-mono text-[11px]">{name}</code> becomes the contact's
            first name and <code class="rounded bg-slate-100 px-1 font-mono text-[11px]">{scheme}</code> the scheme on
            their lead.
        </p>

        <div class="space-y-3">
            @forelse($replies as $reply)
                <div class="rounded-xl border border-slate-200 p-3">
                    {{-- The delete button needs its own form, so it sits outside
                         the edit form and is tied to it by the `form` attribute. --}}
                    <form method="POST" action="{{ route('admin.whatsapp.replies.update', $reply) }}"
                          id="reply-{{ $reply->id }}">
                        @csrf @method('PUT')
                        <div class="mb-2 flex flex-wrap gap-2">
                            <div class="w-32">
                                <label class="label text-xs" for="shortcut-{{ $reply->id }}">Shortcut</label>
                                <input id="shortcut-{{ $reply->id }}" name="shortcut" value="{{ $reply->shortcut }}"
                                       class="input input-sm font-mono" required>
                            </div>
                            <div class="min-w-[8rem] flex-1">
                                <label class="label text-xs" for="label-{{ $reply->id }}">Name</label>
                                <input id="label-{{ $reply->id }}" name="label" value="{{ $reply->label }}"
                                       class="input input-sm" required>
                            </div>
                            <div class="flex items-end pb-1">
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                                    <input type="checkbox" name="active" value="1" @checked($reply->active)
                                           class="rounded border-slate-300 text-brandTeal focus:ring-brandTeal">
                                    Shown
                                </label>
                            </div>
                        </div>

                        <label class="label text-xs" for="body-{{ $reply->id }}">Message</label>
                        <textarea id="body-{{ $reply->id }}" name="body" rows="2" class="input text-sm" required>{{ $reply->body }}</textarea>
                    </form>

                    <div class="mt-2 flex justify-end gap-2">
                        <button form="reply-{{ $reply->id }}" class="btn-primary btn-sm">
                            <i class="fa-solid fa-check"></i> Save
                        </button>
                        <form method="POST" action="{{ route('admin.whatsapp.replies.destroy', $reply) }}"
                              onsubmit="return confirm('Delete the “{{ $reply->label }}” quick reply?')">
                            @csrf @method('DELETE')
                            <button class="btn-ghost btn-sm text-rose-600"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                    No quick replies yet — add the first one below.
                </p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('admin.whatsapp.replies.store') }}"
              class="mt-4 rounded-xl border border-dashed border-slate-300 p-3">
            @csrf
            <p class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400">Add a quick reply</p>
            <div class="mb-2 flex flex-wrap gap-2">
                <div class="w-32">
                    <label class="label text-xs" for="new-shortcut">Shortcut</label>
                    <input id="new-shortcut" name="shortcut" placeholder="rates" class="input input-sm font-mono" required>
                </div>
                <div class="min-w-[8rem] flex-1">
                    <label class="label text-xs" for="new-label">Name</label>
                    <input id="new-label" name="label" placeholder="Current rates" class="input input-sm" required>
                </div>
            </div>
            <label class="label text-xs" for="new-body">Message</label>
            <textarea id="new-body" name="body" rows="2" class="input text-sm"
                      placeholder="Hello {name}, sharing the current rates…" required></textarea>
            <input type="hidden" name="active" value="1">
            <div class="mt-2 flex justify-end">
                <button class="btn-teal btn-sm"><i class="fa-solid fa-plus"></i> Add</button>
            </div>
        </form>
    </section>

    {{-- -------------------------------------------------------------- labels --}}
    <section class="card-p">
        <h2 class="text-base font-bold text-brandNavy">Labels</h2>
        <p class="help mb-4">
            Colour tags for chats — lighter than a CRM stage, and a chat can carry several.
            Deleting a label removes it from every chat but never touches the messages.
        </p>

        <div class="space-y-2">
            @forelse($labels as $label)
                <div class="flex flex-wrap items-end gap-2 rounded-xl border border-slate-200 p-3">
                    <form method="POST" action="{{ route('admin.whatsapp.labels.update', $label) }}"
                          class="flex flex-1 flex-wrap items-end gap-2">
                        @csrf @method('PUT')
                        <div class="min-w-[8rem] flex-1">
                            <label class="label text-xs" for="label-name-{{ $label->id }}">Name</label>
                            <input id="label-name-{{ $label->id }}" name="name" value="{{ $label->name }}"
                                   class="input input-sm" required>
                        </div>
                        <div class="w-36">
                            <label class="label text-xs" for="label-colour-{{ $label->id }}">Colour</label>
                            <select id="label-colour-{{ $label->id }}" name="colour" class="input input-sm">
                                @foreach($colours as $colour)
                                    <option value="{{ $colour }}" @selected($label->colour === $colour)>{{ ucfirst($colour) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="mb-1 rounded px-2 py-1 text-[11px] font-semibold ring-1 {{ $label->classes }}">{{ $label->name }}</span>
                        <button class="btn-primary btn-sm"><i class="fa-solid fa-check"></i> Save</button>
                    </form>
                    <form method="POST" action="{{ route('admin.whatsapp.labels.destroy', $label) }}"
                          onsubmit="return confirm('Remove the “{{ $label->name }}” label from every chat?')">
                        @csrf @method('DELETE')
                        <button class="btn-ghost btn-sm text-rose-600"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            @empty
                <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                    No labels yet.
                </p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('admin.whatsapp.labels.store') }}"
              class="mt-4 flex flex-wrap items-end gap-2 rounded-xl border border-dashed border-slate-300 p-3">
            @csrf
            <div class="min-w-[8rem] flex-1">
                <label class="label text-xs" for="new-label-name">New label</label>
                <input id="new-label-name" name="name" placeholder="Follow up Monday" class="input input-sm" required>
            </div>
            <div class="w-36">
                <label class="label text-xs" for="new-label-colour">Colour</label>
                <select id="new-label-colour" name="colour" class="input input-sm">
                    @foreach($colours as $colour)
                        <option value="{{ $colour }}">{{ ucfirst($colour) }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn-teal btn-sm"><i class="fa-solid fa-plus"></i> Add</button>
        </form>
    </section>
</div>
@endsection
