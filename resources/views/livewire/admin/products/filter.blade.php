<div class="d-flex flex-row">
    <x-select-option wire:model.live="form.category" name="form.category" id="filter_category" class="me-2">
        <option>{{ __('Filter By Category') }}</option>
        @foreach ($categories as $category)
            <option :value="{{ $category->id }}" wire:key="category-{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </x-select-option>
    <x-select-option wire:model.live="form.business" name="form.business" id="filter_business">
        <option>{{ __('Filter By Business') }}</option>
        @foreach ($businesses as $busines)
            <option :value="{{ $busines->id }}" wire:key="busines-{{ $busines->id }}">{{ $busines->name }}</option>
        @endforeach
    </x-select-option>
</div>
