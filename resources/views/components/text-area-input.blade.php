@props(['disabled' => false, 'framework' => 'bootstrap', 'messages' => []])

@if ($framework === 'bootstrap')
    @if (count($messages) > 0)
        @php
            $attributes = $attributes->merge(['class' => 'is-invalid'])
        @endphp
    @endif
    <textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "form-control"])->except('framework', 'messages') !!}>{{ $value ?? $slot }}</textarea>
    <x-input-error :messages="$messages" :framework="$framework" />
@else
    <textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'])->except('framework', 'messages') !!}>{{ $value ?? $slot }}</textarea>
    <x-input-error :messages="$messages" :framework="$framework" />
@endif
