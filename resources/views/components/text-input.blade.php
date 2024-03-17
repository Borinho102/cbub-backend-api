@props(['disabled' => false, 'framework' => 'bootstrap', 'name'])

@if ($framework === 'bootstrap')
    @error($name)
        @php
            $attributes = $attributes->merge(['class' => 'is-invalid'])
        @endphp
    @enderror
    <input name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "form-control"])->except('framework') !!}>
@else
    <input name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}  {!! $attributes->merge(['class' => 'tw-border-gray-300 focus:tw-border-indigo-500 focus:tw-ring-indigo-500 tw-rounded-md tw-shadow-sm'])->except('framework')  !!}>
@endif
@error($name)<x-input-error :message="$message" :framework="$framework" />@enderror

