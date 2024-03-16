@props(['css_framework' => 'bootstrap', 'disabled' => false, 'name'])

@error($name)
    @php
        $attributes = $attributes->merge(['class' => 'is-invalid'])
    @endphp
@enderror

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'custom-select form-control'])->except('css_framework') !!}>
    {{ $slot }}
</select>
@error($name)<x-input-error :message="$message" :css-framework="$css_framework" />@enderror
