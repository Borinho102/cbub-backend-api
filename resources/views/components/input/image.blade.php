@props([
    'id',
    'name',
    'initialImage' => null,
    'placeholder' => null,
    'canEdit' => false,
    'height' => 'h-36',
    'width' => 'w-36'
])

<div class="mb-2 flex flex-row {{ $height }} {{ $width }} {{ !isset($initialImage) ? 'cursor-pointer' : '' }}"
    x-on:click="browseFile"
>
    <input {!! $attributes !!} id="{{ $id }}" type="file" class="hidden"/>
    @if (isset($initialImage))
        <div class="w-full h-full flex items-center justify-center p-4 bg-white border rounded border-gray-300 font-normal hover:border-purple-700 border-dashed text-gray-400 text-sm hover:text-purple-700">
            <img class="h-full w-full object-contain" src="{{ $initialImage }}" />
        </div>
        @if ($canEdit)
            <button type="button"  x-on:click="browseFile" class="ml-4 text-purple-600">
                <x-icon name="pencil" class="h-6 w-6" />
            </button>
        @endif
    @else
        <div class="w-full h-full flex flex-col items-center justify-center bg-white border rounded border-gray-300 font-normal hover:border-purple-700 border-dashed text-gray-400 text-sm hover:text-purple-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
            </svg>
            <span>{{ $placeholer ?? __('Browse') }}</span>
        </div>
    @endif
</div>
@error($name)<x-input.error :message="$message" />@enderror

<script>
    function browseFile() {
        let file = document.getElementById("{{ $id }}")
        if (file) {
            file.click()
        }
    }
</script>
