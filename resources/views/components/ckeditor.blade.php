
<textarea {!! $attributes->merge(['class' => 'ckeditor']) !!}></textarea>

@slot('styles')

@endslot

@slot('scripts')
    <script src="{{ mix('backend/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ mix('backend/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
@endslot

