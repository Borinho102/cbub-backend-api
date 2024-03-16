
@props(['framework' => 'bootstrap', 'name'])

@if ($framework === 'bootstrap')
    @error($name)
        @php
            $attributes = $attributes->merge(['class' => 'is-invalid'])
        @endphp
    @enderror
    <input name="{{ $name }}" type="file" {!! $attributes->merge(['class' => "form-control"])->except('framework') !!} >
@else
    <input name="{{ $name }}" type="file" {!! $attributes->merge(['class' => "form-control"])->except('framework') !!} >
@endif
@error($name)<x-input-error :message="$message" :framework="$framework" />@enderror

