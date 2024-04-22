<div class="flex flex-row">
    <x-input.select wire:model.live="category" name="category" id="filter_category" class="mr-2">
        <option>{{ __('Filter By Category') }}</option>
        @foreach ($categories as $category)
            <option :value="{{ $category->id }}" wire:key="category-{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </x-input.select>
    <x-input.select wire:model.live="business" name="business" id="filter_business">
        <option value>{{ __('Filter By Business') }}</option>
        @foreach ($businesses as $busines)
            <option :value="{{ $busines->id }}" wire:key="busines-{{ $busines->id }}">{{ $busines->name }}</option>
        @endforeach
    </x-input.select>
</div>
