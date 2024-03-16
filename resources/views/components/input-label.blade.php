@props(['value', 'css_framework' => 'boostrap', 'required' => false])

@if ($css_framework === 'boostrap')
    <label {{ $attributes->merge(['class' => 'col-form-label']) }}>
        @if ($required)
            <span>*</span>
        @endif
        {{ $value ?? $slot }}
    </label>
@else
    <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
        {{ $value ?? $slot }}
    </label>
@endif

