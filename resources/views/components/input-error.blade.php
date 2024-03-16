@props(['message' => false, 'css_framework' => 'bootstrap'])

@if ($message)
    @if ($css_framework === 'bootstrap')
        <div {{ $attributes->merge(['class' => 'invalid-feedback'])->except('message', 'css_framework') }}>
            {{ $message }}
        </div>
    @else
        <span {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1'])->except('message', 'css_framework') }}>
            {{ $message }}
        </span>
    @endif
@endif
