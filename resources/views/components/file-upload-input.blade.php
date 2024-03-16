
@props(['css_framework' => 'bootstrap', 'name'])

@if ($css_framework === 'bootstrap')
    @error($name)
        @php
            $attributes = $attributes->merge(['class' => 'is-invalid'])
        @endphp
    @enderror
    <input name="{{ $name }}" type="file" {!! $attributes->merge(['class' => "form-control"])->except('css_framework') !!} >
@else
    <input name="{{ $name }}" type="file" {!! $attributes->merge(['class' => "form-control"])->except('css_framework') !!} >
@endif
@error($name)<x-input-error :message="$message" :css-framework="$css_framework" />@enderror

