@props(['message' => false])

@if ($message)
    <span {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1'])->except('message') }}>
        {{ $message }}
    </span>
@endif
