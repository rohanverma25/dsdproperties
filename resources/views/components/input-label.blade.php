@props(['value'])

{{-- Styled inline rather than with Tailwind classes: this project cannot run a
     CSS build on shared hosting, so the compiled stylesheet may not contain
     utilities for markup that was added after the last build. --}}
<label {{ $attributes->merge(['style' => 'display:block;font-size:.875rem;font-weight:600;color:#374151;margin-bottom:6px;']) }}>
    {{ $value ?? $slot }}
</label>
