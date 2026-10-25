{{-- Tag search / create picker. --}}
<script>
const createTagUrl = '{{ route("seller.tags.store") }}';
function tagPicker(allTags, initial) {
    return {
        tags: allTags,
        selected: initial,
        search: '',
        open: false,
        creating: false,
        get filtered() {
            const q = this.search.trim().toLowerCase();
            const avail = this.tags.filter(t => !this.selected.some(s => s.id === t.id));
            return q ? avail.filter(t => t.name.toLowerCase().includes(q)) : avail;
        },
        get canCreate() {
            const q = this.search.trim();
            return q.length > 0 && !this.tags.some(t => t.name.toLowerCase() === q.toLowerCase());
        },
        choose(tag) {
            if (!this.selected.some(s => s.id === tag.id)) this.selected.push(tag);
            this.search = '';
            this.open = false;
        },
        remove(tag) { this.selected = this.selected.filter(s => s.id !== tag.id); },
        async create() {
            const name = this.search.trim();
            if (!name || this.creating) return;
            this.creating = true;
            try {
                const resp = await fetch(createTagUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ name }),
                });
                const tag = await resp.json();
                if (resp.ok) {
                    if (!this.tags.find(t => t.id === tag.id)) this.tags.push(tag);
                    this.choose(tag);
                }
            } catch (_) {
                alert('Failed to create tag. Please try again.');
            } finally {
                this.creating = false;
            }
        },
    };
}

</script>
