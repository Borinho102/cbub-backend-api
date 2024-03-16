@props(['framework' => 'bootstrap', 'disabled' => false, 'name'])

@error($name)
    @php
        $attributes = $attributes->merge(['class' => 'is-invalid'])
    @endphp
@enderror

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'custom-select form-control'])->except('framework') !!}>
    {{ $slot }}
</select>
@error($name)<x-input-error :message="$message" :framework="$framework" />@enderror
