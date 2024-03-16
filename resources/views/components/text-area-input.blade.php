@props(['disabled' => false, 'framework' => 'bootstrap', 'name'])

@if ($framework === 'bootstrap')
    @error($name)
        @php
            $attributes = $attributes->merge(['class' => 'is-invalid'])
        @endphp
    @enderror
    <textarea name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "form-control"])->except('framework', 'messages') !!}>{{ $value ?? $slot }}</textarea>
    @error($name)<x-input-error :message="$message" :framework="$framework" />@enderror
@else
    <textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'])->except('framework', 'messages') !!}>{{ $value ?? $slot }}</textarea>
    @error($name)<x-input-error :message="$message" :framework="$framework" />@enderror
@endif
