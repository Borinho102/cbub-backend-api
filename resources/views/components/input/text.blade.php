@props(['disabled' => false, 'name'])

<input name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}  {!! $attributes->merge(['class' => 'form-input w-full'])  !!}>
@error($name)<x-input.error :message="$message" />@enderror

