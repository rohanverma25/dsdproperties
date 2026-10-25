<button {{ $attributes->merge([
    'type'  => 'button',
    'style' => 'display:inline-flex;align-items:center;justify-content:center;gap:6px;'
             . 'padding:12px 22px;min-height:46px;border:1px solid #d1d5db;border-radius:8px;cursor:pointer;'
             . 'background:#fff;color:#374151;font-size:.95rem;font-weight:600;'
]) }}>
    {{ $slot }}
</button>
