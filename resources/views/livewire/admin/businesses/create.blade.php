<div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Add Business') }}
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
                        <li class="breadcrumb-item">{{ __('Dashboard') }}</li>
                        <li class="breadcrumb-item active">{{ __('Add Business') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form wire:submit="save" class="row">
            <div class="row product-adding">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            Business Information
                        </div>
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="form-group">
                                    <x-input-label :value="__('Name')" for="name" required/>
                                    <x-text-input wire:model.live="form.name" name="form.name" id="name" type="text"/>
                                </div>
                                <div class="form-group">
                                    <x-input-label :value="__('Category')" for="sku" required/>
                                    <x-select-option wire:model.live="form.category_id" name="form.category_id" id="category">
                                        <option value="">{{ __('Select Business Category') }}</option>
                                        @foreach ($categories as $category)
                                            <option :value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </x-select-option>
                                </div>

                                <div class="form-group">
                                    <x-input-label :value="__('Phone Number')" for="phone" required/>
                                    <x-text-input wire:model.live="form.phone" name="form.phone" id="phone" type="text"/>
                                </div>

                                <div class="form-group">
                                    <x-input-label :value="__('Email')" for="email" required/>
                                    <x-text-input wire:model.live="form.email" name="form.email" id="email" type="email"/>
                                </div>

                                <div class="form-group">
                                    <x-input-label :value="__('Address')" for="address" required/>
                                    <x-text-input wire:model.live="form.address" name="form.address" id="address" type="text"/>
                                </div>

                                <div class="form-group">
                                    <x-input-label :value="__('Country')" for="country" required/>
                                    <x-select-option wire:model.live="form.country_id" name="form.country_id" id="country">
                                        <option value="">{{ __('Select Business Country') }}</option>
                                        @foreach ($countries as $country)
                                            <option :value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </x-select-option>
                                </div>

                                <div class="form-group">
                                    <x-input-label :value="__('City')" for="city" required/>
                                    <x-select-option wire:model.live="form.city_id" name="form.city_id" id="city">
                                        <option value="">{{ __('Select Business City') }}</option>
                                        @foreach ($cities as $city)
                                            <option :value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </x-select-option>
                                </div>

                                <div class="form-group col-xl-12">
                                    <x-input-label :value="__('Logo')" for="logo" required/>
                                    <x:file-upload-input wire:model.live="form.logo" name="form.logo" id="logo"/>
                                </div>

                                <div class="form-group">
                                    <x-input-label :value="__('About')" for="about"/>
                                    <x-text-area-input wire:model.live="form.about" name="form.about" id="about" name="about" rows="4" cols="12"></x-text-area-input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            Social Media Links
                        </div>
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="form-group">
                                    <x-input-label :value="__('Website')" for="website"/>
                                    <x-text-input wire:model.live="form.website" name="form.website" id="website" type="url"/>
                                </div>
                                <div class="form-group">
                                    <x-input-label :value="__('Facebook')" for="facebook"/>
                                    <x-text-input wire:model.live="form.facebook" name="form.facebook" id="facebook" type="url"/>
                                </div>
                                <div class="form-group">
                                    <x-input-label :value="__('Twitter')" for="twitter"/>
                                    <x-text-input wire:model.live="form.twitter" name="form.twitter" id="twitter" type="url"/>
                                </div>
                                <div class="form-group">
                                    <x-input-label :value="__('Instagram')" for="instagram"/>
                                    <x-text-input wire:model.live="form.instagram" name="form.instagram" id="instagram" type="url"/>
                                </div>
                                <div class="form-group">
                                    <x-input-label :value="__('Linkedin')" for="linkedin"/>
                                    <x-text-input wire:model.live="form.linkedin" id="linkedin" name="form.linkedin" type="url"/>
                                </div>
                                <div class="form-group">
                                    <x-input-label :value="__('Youtube')" for="youtube"/>
                                    <x-text-input wire:model.live="form.youtube" id="youtube" name="form.youtube" type="url"/>
                                </div>
                                <div class="mt-4">
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
        </form>
    </div>
</div>
