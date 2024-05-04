<div class="flex flex-row">
    <x-input.select wire:model.live="category" name="category" id="filter_category">
        <option>{{ __('Filter By Category') }}</option>
        @foreach ($categories as $category)
            <option :value="{{ $category->id }}" wire:key="category-{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </x-input.select>
</div>
