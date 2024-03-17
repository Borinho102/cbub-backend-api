@props(['value', 'framework' => 'boostrap', 'required' => false])

@if ($framework === 'boostrap')
    <label {{ $attributes->merge(['class' => 'col-form-label']) }}>
        @if ($required)
            <span>*</span>
        @endif
        {{ $value ?? $slot }}
    </label>
@else
    <label {{ $attributes->merge(['class' => 'tw-block tw-font-medium tw-text-sm tw-text-gray-700']) }}>
        {{ $value ?? $slot }}
    </label>
@endif

