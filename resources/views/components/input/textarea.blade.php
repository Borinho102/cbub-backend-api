@props(['disabled' => false, 'name'])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-textarea w-full'])->except('messages') !!}>{{ $value ?? $slot }}</textarea>
@error($name)<x-input.error :message="$message" />@enderror

