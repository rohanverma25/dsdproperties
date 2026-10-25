<button {{ $attributes->merge([
    'type'  => 'submit',
    'style' => 'display:inline-flex;align-items:center;justify-content:center;gap:6px;'
             . 'padding:12px 22px;min-height:46px;border:0;border-radius:8px;cursor:pointer;'
             . 'background:#0d6efd;color:#fff;font-size:.95rem;font-weight:600;'
]) }}>
    {{ $slot }}
</button>
