<div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Add Product') }}
                            <small>{{ __('Cbub Admin Panel') }}</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i data-feather="home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">{{ __('Products') }}</li>
                        <li class="breadcrumb-item active">{{ __('Add Product') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row product-adding">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Product Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="digital-add needs-validation">
                            <div class="form-group">
                                <x-input-label :value="__('Name (English)')" for="name_en" required/>
                                <x-text-input wire:model.live="form.name_en" name="form.name_en" id="name_en" type="text"/>
                            </div>

                            <div class="form-group">
                                <x-input-label :value="__('Name (French)')" for="name_fr" required/>
                                <x-text-input wire:model.live="form.name_fr" name="form.name_fr" id="name_fr" type="text"/>
                            </div>

                            <div class="form-group">
                                <x-input-label :value="__('Sku')" for="sku"/>
                                <x-text-input wire:model.live="form.sku" name="form.sku" id="sku" type="text"/>
                            </div>

                            <div class="form-group">
                                <x-input-label :value="__('Price')" for="price" required/>
                                <x-text-input wire:model.live="form.price" name="form.price" id="price" type="text"/>
                            </div>

                            <div class="form-group">
                                <x-input-label :value="__('Quantity')" for="quantity" required/>
                                <x-text-input wire:model.live="form.quantity" name="form.quantity" id="quantity" type="number"/>
                            </div>

                            <div class="form-group">
                                <x-input-label :value="__('Category')" for="category_id" required/>
                                <x-select-option wire:model.live="form.category_id" name="form.category_id" id="category_id">
                                    <option>{{ __('Select Category') }}</option>
                                    @foreach ($categories as $category)
                                        @if ($form->category_id == $category->id)
                                            <option selected :value="{{ $category->id }}">{{ $category->name }}</option>
                                        @else
                                            <option :value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </x-select-option>
                            </div>

                            <div class="form-group">
                                <x-input-label :value="__('Business')" for="business_id" required/>
                                <x-select-option wire:model.live="form.business_id" name="form.business_id" id="business_id">
                                    <option>{{ __('Select Business') }}</option>
                                    @foreach ($businesses as $business)
                                        @if ($form->business_id == $business->id)
                                            <option selected :value="{{ $business->id }}">{{ $business->name }} ({{ $business->country->name }})</option>
                                        @else
                                            <option :value="{{ $business->id }}">{{ $business->name }} ({{ $business->country->name }})</option>
                                        @endif
                                    @endforeach
                                </x-select-option>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Add Description') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="digital-add needs-validation">
                            <div class="form-group">
                                <x-input-label :value="__('Short Description (English)')" for="short_description_en" required/>
                                <x-text-area-input wire:model.live="form.short_description_en" name="form.short_description_en" id="short_description_en" rows="3" cols="12"></x-text-area-input>
                            </div>

                            <div class="form-group">
                                <x-input-label :value="__('Short Description (French)')" for="short_description_fr" required/>
                                <x-text-area-input wire:model.live="form.short_description_fr" name="form.short_description_fr" id="short_description_fr" rows="3" cols="12"></x-text-area-input>
                            </div>

                            <div class="digital-add needs-validation">
                                <div class="form-group mb-0">
                                    <div class="description-sm">
                                        <x-ckeditor id="product-description" class="ckeditor" name="description" cols="10" rows="4" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Add Images') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="digital-add needs-validation">
                            <label class="col-form-label pt-0">Images</label>
                            <div class="dropzone digits" id="singleFileUpload">
                                <div class="dz-message needsclick"><i class="fa fa-cloud-upload"></i>
                                    <h4 class="mb-0 f-w-600">Drop files here or click to upload.</h4>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-end mb-0 mt-4">
                            <x-primary-button type="button" class="btn-light me-2">
                                {{ __('Clear') }}
                            </x-primary-button>
                            <x-primary-button type="submit" class="btn-primary">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
