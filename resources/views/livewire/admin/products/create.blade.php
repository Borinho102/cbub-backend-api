<div background="bg-gray-100 dark:bg-slate-900">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                @if (isset($form->product))
                    {{ __('Update Product') }}
                @else
                    {{ __('Add Product') }}
                @endif
            </h2>
            <div class="text-start">
                <!-- Start -->
                <ul class="inline-flex flex-wrap text-sm font-medium">
                    <li class="flex items-center">
                        <a class="text-slate-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" wire:navigate href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                        <svg class="h-4 w-4 fill-current text-slate-400 dark:text-slate-600 mx-3" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a class="text-slate-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" wire:navigate href="{{ route('admin.products.index') }}">{{ __('Products') }}</a>
                        <svg class="h-4 w-4 fill-current text-slate-400 dark:text-slate-600 mx-3" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#0">{{ __('New Product') }}</a>
                    </li>
                </ul>
                <!-- End -->
            </div>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-between mt-6">
            <x-form-section submit="save">
                <div class="w-full grid gap-5 grid-cols-1 md:grid-cols-2">
                    <div>
                        <x-input.label :value="__('Name (English)')" for="name_en" required/>
                        <x-input.text wire:model.blur="form.name_en" name="form.name_en" id="name_en" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Name (French)')" for="name_fr" required/>
                        <x-input.text wire:model.blur="form.name_fr" name="form.name_fr" id="name_fr" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Price')" for="price" required/>
                        <x-input.text wire:model.blur="form.price" name="form.price" id="price" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Sku')" for="sku"/>
                        <x-input.text wire:model.blur="form.sku" name="form.sku" id="sku" type="text"/>
                    </div>

                    @if (!isset($form->product))
                        <div class="col-span-2">
                            <x-input.label :value="__('Quantity')" for="quantity" required/>
                            <x-input.text wire:model.blur="form.quantity" name="form.quantity" id="quantity" type="number"/>
                        </div>
                    @endif

                    <div class="col-span-1">
                        <x-select
                            class="w-full"
                            :label="__('Category')"
                            placeholder="Category"
                            wire:model="form.category_id"
                            option-value="id"
                            option-label="name"
                            :async-data="route('misc.search.product_categories')"
                        />
                    </div>

                    <div class="col-span-1">
                        <x-select
                            class="w-full"
                            :label="__('Business')"
                            placeholder="Business"
                            wire:model="form.business_id"
                            option-value="id"
                            option-label="name"
                            :async-data="route('misc.search.businesses')"
                            required
                        />
                    </div>

                    <div>
                        <x-input.label :value="__('Short Description (English)')" for="short_description_en" required/>
                        <x-input.textarea wire:model.blur="form.short_description_en" name="form.short_description_en" id="short_description_en" rows="3" cols="12"></x-input.textarea>
                    </div>

                    <div>
                        <x-input.label :value="__('Short Description (French)')" for="short_description_fr" required/>
                        <x-input.textarea wire:model.blur="form.short_description_fr" name="form.short_description_fr" id="short_description_fr" rows="3" cols="12"></x-input.textarea>
                    </div>

                    <div>
                        <x-input.label :value="__('Description (English)')" for="description_en"/>
                        <x-input.textarea wire:model.blur="form.description_en" name="form.description_en" id="description_en" rows="3" cols="12"></x-input.textarea>
                    </div>

                    <div>
                        <x-input.label :value="__('Description (French)')" for="description_fr"/>
                        <x-input.textarea wire:model.blur="form.description_fr" name="form.description_fr" id="description_fr" rows="3" cols="12"></x-input.textarea>
                    </div>

                    <div class="col-span-2">
                        <x-select
                            class="w-full"
                            :label="__('Select Tag(s)')"
                            placeholder="Select Tag(s)"
                            multiselect
                            wire:model="form.tags"
                        >
                            @foreach ($tagOptions as $id => $tag)
                                <x-select.option wire:key="tag-{{ $id }}" label="{{ $tag }}" value="{{ $id }}" />
                            @endforeach
                        </x-select>
                    </div>

                    <div>
                        <x-input.label :value="__('Thumbnail Image')" for="logo" required="{{ !isset($this->form->product) }}"/>
                        <x:input.file wire:model.blur="form.thumbnail" name="form.thumbnail" id="thumbnail"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Other Images')" for="other_images"/>
                        <x:input.file wire:model.blur="form.images" name="form.images" id="other_images"/>
                    </div>
                </div>
                <div class="mt-4 flex flex-row justify-end gap-x-2 col-span-2">
                    <x-button.danger type="button">
                        {{ __('Clear') }}
                    </x-button.danger>

                    @isset ($this->form->category)
                        <x-button.default type="submit">
                            <div wire:loading>
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            {{ __('Update') }}
                        </x-button>
                    @else
                        <x-button.primary type="submit">
                            <div wire:loading>
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            {{ __('Create') }}
                        </x-button.primary>
                    @endisset
                <div>
            </x-form-section>
        </div>
    </div>
</div>

@push('scripts')
{{-- Cropper.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />

{{-- Sortable.js --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.1/Sortable.min.js"></script>
@endpush
