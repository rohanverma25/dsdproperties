@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['style' => 'margin:6px 0 0;padding-left:18px;font-size:.82rem;color:#dc2626;']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
