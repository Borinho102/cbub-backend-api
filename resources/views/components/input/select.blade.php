@props(['disabled' => false, 'name'])

<select name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-select w-full']) !!}>
    {{ $slot }}
</select>
@error($name)<x-input.error :message="$message" />@enderror
