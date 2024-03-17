@props(['message' => false, 'framework' => 'bootstrap'])

@if ($message)
    @if ($framework === 'bootstrap')
        <div {{ $attributes->merge(['class' => 'invalid-feedback'])->except('message', 'framework') }}>
            {{ $message }}
        </div>
    @else
        <span {{ $attributes->merge(['class' => 'tw-text-sm tw-text-red-600 tw-space-y-1'])->except('message', 'framework') }}>
            {{ $message }}
        </span>
    @endif
@endif
