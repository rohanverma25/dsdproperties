@php $outcomes = config('crm.outcomes'); @endphp

<div x-data="logModal" x-cloak
     @open-log.window="open($event.detail)"
     x-show="isOpen"
     class="fixed inset-0 z-[80] flex items-end justify-center sm:items-center">

    <div x-show="isOpen" x-transition.opacity @click="close()"
         class="absolute inset-0 bg-brandNavy/60 backdrop-blur-sm"></div>

    <form method="POST" :action="action" x-show="isOpen"
          x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="translate-y-6 opacity-0"
          x-transition:enter-end="translate-y-0 opacity-100"
          class="relative w-full max-w-lg overflow-hidden rounded-t-2xl bg-white shadow-2xl sm:rounded-2xl">
        @csrf
        <input type="hidden" name="outcome" :value="outcome">
        <input type="hidden" name="type"    :value="type">

        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Log activity</p>
                <p class="truncate text-base font-bold text-brandNavy" x-text="name"></p>
            </div>
            <button type="button" @click="close()" class="rounded-lg p-2 text-slate-400 hover:bg-slate-100" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="max-h-[70vh] overflow-y-auto px-5 py-4">
            <p class="label">What happened?</p>
            <div class="mb-4 grid grid-cols-2 gap-2">
                @foreach($outcomes as $key => $o)
                    <button type="button"
                            @click="pick(@js($key), {{ $o['followup_days'] ?? 'null' }})"
                            :class="outcome === @js($key)
                                ? '{{ $o['selected'] ?? 'bg-brandNavy text-white border-brandNavy' }}'
                                : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300'"
                            class="min-h-[52px] rounded-xl border px-3 py-2.5 text-sm font-semibold transition-colors
                                   {{ $loop->last ? 'col-span-2' : '' }}">
                        {{ $o['label'] }}
                    </button>
                @endforeach
            </div>

            <div x-show="needsDate" x-transition>
                <label class="label" for="log-followup">
                    Next follow-up date <span class="text-rose-500">*</span>
                </label>
                <input type="date" class="input" id="log-followup" name="next_followup_at"
                       x-model="date" :required="needsDate">
                <p class="help">You can change it, but it cannot be left empty.</p>
            </div>

            <div class="mt-4">
                <label class="label" for="log-note">Note <span class="font-normal text-slate-400">(optional)</span></label>
                <textarea class="input min-h-[80px] py-3" id="log-note" name="note" rows="2" x-model="note"></textarea>
            </div>
        </div>

        <div class="flex gap-2 border-t border-slate-200 bg-slate-50 px-5 py-4">
            <button type="button" @click="close()" class="btn-ghost flex-1">Cancel</button>
            <button type="submit" class="btn-primary flex-[2]" :disabled="!outcome">Save</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('logModal', () => ({
        isOpen: false, action: '', name: '',
        outcome: '', type: 'call', date: '', note: '', needsDate: true,

        open(detail) {
            this.action = detail.action;
            this.name   = detail.name;
            this.outcome = ''; this.date = ''; this.note = '';
            this.type = 'call'; this.needsDate = true;
            this.isOpen = true;
        },
        close() { this.isOpen = false; },

        pick(outcome, days) {
            this.outcome = outcome;
            this.type = outcome === 'site_visit_fixed' ? 'visit' : 'call';

            // A closed-out lead owes no next step; everything else gets a
            // prefilled, still-editable date that the server insists on.
            if (days === null) {
                this.needsDate = false;
                this.date = '';
            } else {
                this.needsDate = true;
                const d = new Date();
                d.setHours(12, 0, 0, 0);
                d.setDate(d.getDate() + days);
                this.date = d.toISOString().slice(0, 10);
            }
        },
    }));
});
</script>
@endpush
