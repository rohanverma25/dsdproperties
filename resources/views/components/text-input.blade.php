@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'style' => 'display:block;width:100%;box-sizing:border-box;padding:11px 13px;font-size:1rem;'
             . 'border:1px solid #d1d5db;border-radius:8px;background:#fff;color:#111827;min-height:46px;'
]) !!}>
