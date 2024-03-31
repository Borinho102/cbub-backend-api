@props(['name', 'multiple' => true, 'disabled' => false])

<select name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-select w-full']) !!} id="select2">
    {{ $slot }}
</select>
@error($name)<x-input.error :message="$message" />@enderror

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endpush

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('livewire:load', function () {
            $('#select2').select2();

            Livewire.on('select2Updated', function () {
                $('#select2').select2();
            });
        });
    </script>
@endpush

