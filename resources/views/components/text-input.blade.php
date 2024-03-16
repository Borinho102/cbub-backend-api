@props(['disabled' => false, 'css_framework' => 'bootstrap', 'name'])

@if ($css_framework === 'bootstrap')
    @error($name)
        @php
            $attributes = $attributes->merge(['class' => 'is-invalid'])
        @endphp
    @enderror
    <input name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "form-control"])->except('css_framework') !!}>
@else
    <input name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}  {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'])->except('css_framework')  !!}>
@endif
@error($name)<x-input-error :message="$message" :css-framework="$css_framework" />@enderror

