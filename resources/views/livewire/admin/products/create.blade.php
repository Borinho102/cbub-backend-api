<div background="bg-gray-100 dark:bg-slate-900 h-full">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto h-full">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                @if (isset($form->product))
                    {{ __('Update Product') }}
                @else
                    {{ __('New Product') }}
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
        @if ($showForm)
            <div class="w-full flex flex-col md:flex-row justify-between mt-6">
                <x-form-section submit="save">
                    <div class="w-full grid items-center gap-5 grid-cols-1 md:grid-cols-2">
                        <div class="col-span-2">
                            <x-input.label :value="__('Parent Product')" for="form.parent_id"/>
                            <x-select
                                class="w-full"
                                :placeholder="__('Select Parent Product')"
                                wire:model.live="form.parent_id"
                                option-value="id"
                                option-label="name"
                                :async-data="route('misc.search.products')"
                                required
                            />
                        </div>

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
                            <div class="{{ !isset($form->parentProduct) ? 'col-span-2' : 'col-span-1' }}">
                                <x-input.label :value="__('Quantity')" for="quantity" required/>
                                <x-input.text wire:model.blur="form.quantity" name="form.quantity" id="quantity" type="number"/>
                            </div>
                        @endif

                        @if (isset($form->parentProduct))
                            <div class="col-span-1">
                                <x-input.label :value="__('Items Number')" for="items"/>
                                <x-input.text wire:model.blur="form.items_count" name="form.items_count" id="items_count" type="number"/>
                            </div>
                        @endif

                        @if (!isset($form->parentProduct))
                            <div class="col-span-1">
                                <x-input.label :value="__('Category')" for="form.category_id" required/>
                                <x-select
                                    class="w-full"
                                    :placeholder="__('Select Category')"
                                    wire:model="form.category_id"
                                    option-value="id"
                                    option-label="name"
                                    :async-data="route('misc.search.product_categories')"
                                />
                            </div>

                            <div class="col-span-1">
                                <x-input.label :value="__('Shop')" for="form.shop_id" required/>
                                <x-select
                                    class="w-full"
                                    :placeholder="__('Select Shop')"
                                    wire:model="form.shop_id"
                                    option-value="id"
                                    option-label="name"
                                    :async-data="route('misc.search.shops')"
                                    required
                                />
                            </div>
                        @endif

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
                                @foreach ([] as $id => $tag)
                                    <x-select.option wire:key="tag-{{ $id }}" label="{{ $tag }}" value="{{ $id }}" />
                                @endforeach
                            </x-select>
                        </div>

                        @if (isset($this->form->product) || isset($form->logo))
                            <div class="col-span-1">
                                <x-input.label :value="__('Thumbnail Image')" for="thumbnail" required="{{ !isset($this->form->product) }}"/>
                                <x:input.image wire:model.blur="form.thumbnail" initialImage="{{ isset($form->thumbnail) ? $form->thumbnail->temporaryUrl() : $this->form->product->thumbnail }}" name="form.thumbnail" id="thumbnail"/>
                            </div>
                        @else
                            <div class="col-span-1">
                                <x-input.label :value="__('Thumbnail Image')" for="thumbnail" required="{{ !isset($this->form->product) }}"/>
                                <x:input.image wire:model.blur="form.thumbnail" name="form.thumbnail" id="thumbnail"/>
                            </div>
                        @endif

                        <div>
                            <x-input.label :value="__('Other Images')" for="other_images"/>
                            <x:input.file wire:model.blur="form.images" name="form.images" id="other_images"/>
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('Specifications')" for="form.specifications"/>
                            <x:input.file wire:model.blur="form.specifications" name="form.specifications" id="specifications" accept="application/pdf"/>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-row justify-end gap-x-2 col-span-2">
                        <x-button.danger type="button">
                            {{ __('Clear') }}
                        </x-button.danger>

                        @isset ($this->form->category)
                            <x-button.default type="submit">
                                <div wire:loading wire:target="save">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                {{ __('Update') }}
                            </x-button>
                        @else
                            <x-button.primary type="submit">
                                <div wire:loading wire:target="save">
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
        @else
            <div class="h-full flex flex-col items-center justify-center mt-20">
                <div class="flex flex-col items-center justify-between">
                    <div>
                        <h1 class="text-lg font-bold text-center">{{ __('Product Type') }}</h1>
                        <p>{{ __('Select the type of product or service you want to create') }}</p>
                    </div>
                    <div class="w-5/5 flex flex-row gap-x-6 justify-center items-center mt-6">
                        <div type="button" wire:click="selectProductType('{{ \App\Enums\ProductType::Physical }}')" class="w-1/3 flex flex-col gap-y-4 items-center p-10 {{ \App\Enums\ProductType::Physical == $productType ? 'border-2 border-purple-600 rounded' : '' }} hover:border-2 hover:border-purple-600 hover:rounded hover:cursor-pointer">
                            <img class="h-24 w-24" src="{{ asset('images/physical-goods.svg') }}" alt="physical goods">
                            <h1 class="font-bold text-md">{{ __('Physical Product') }}</h1>
                            <p class="text-center">{{ __('Products that are tangible and can be shipped or picked up') }}</p>
                        </div>
                        <div type="button" wire:click="selectProductType('{{ \App\Enums\ProductType::Digital }}')" class="w-1/3 flex flex-col gap-y-4 items-center p-10 {{ \App\Enums\ProductType::Digital == $productType ? 'border-2 border-purple-600 rounded' : '' }} hover:border-2 hover:border-purple-600 hover:rounded hover:cursor-pointer">
                            <img class="h-24 w-24" src="{{ asset('images/digital-goods.png') }}" alt="digital goods">
                            <h1 class="font-bold text-md">{{ __('Digital Goods') }}</h1>
                            <p class="text-center">{{ __('Products that are digital and can be downloaded or accessed online') }}</p>
                        </div>
                        <div type="button" wire:click="selectProductType('{{ \App\Enums\ProductType::Service }}')" class="w-1/3 flex flex-col gap-y-4 items-center p-10 {{ \App\Enums\ProductType::Service == $productType ? 'border-2 border-purple-600 rounded' : '' }} hover:border-2 hover:border-purple-600 hover:rounded hover:cursor-pointer">
                            <img class="h-24 w-24" src="{{ asset('images/services.png') }}" alt="service">
                            <h1 class="font-bold text-md">{{ __('Services') }}</h1>
                            <p class="text-center">{{ __('Services that are offered to customers') }}</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <x-button.default type="button" x-on:click="$wire.set('showForm', true)">
                            {{ __('Continue') }}
                            <x-icon name="arrow-right" class="h-5 w-5 ml-2" />
                        </x-button.default>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
{{-- Cropper.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />

{{-- Sortable.js --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.1/Sortable.min.js"></script>
@endpush
