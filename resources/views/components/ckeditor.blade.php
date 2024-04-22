@props(['disabled' => false, 'name'])

<textarea name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'ckeditor']) !!}></textarea>
@error($name)<x-input.error :message="$message" />@enderror

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#product-description'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('message', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush

