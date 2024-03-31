<div background="bg-gray-100 dark:bg-slate-900">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                @isset($form->business)
                    {{ __('Edit Business') }}
                @else
                    {{ __('Add Business') }}
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
                        <a class="text-slate-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" wire:navigate href="{{ route('admin.businesses.index') }}">{{ __('Businesses') }}</a>
                        <svg class="h-4 w-4 fill-current text-slate-400 dark:text-slate-600 mx-3" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#0">{{ __('New Business') }}</a>
                    </li>
                </ul>
                <!-- End -->
            </div>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-between mt-6">
            <x-form-section submit="save">
                <div class="w-full grid gap-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                    <div>
                        <x-input.label :value="__('Name')" for="name" required/>
                        <x-input.text wire:model.live="form.name" name="form.name" id="name" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Category')" for="category_id" required/>
                        <x-input.select wire:model.live="form.category_id" name="form.category_id" id="category">
                            <option value="">{{ __('Select Business Category') }}</option>
                            @foreach ($categories as $category)
                                <option :value="{{ $category->id }}" wire:key="category-{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-input.select>
                    </div>

                    <div>
                        <x-input.label :value="__('Phone Number')" for="phone" required/>
                        <x-input.text wire:model.live="form.phone" name="form.phone" id="phone" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Email')" for="email" required/>
                        <x-input.text wire:model.live="form.email" name="form.email" id="email" type="email"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Address')" for="address" required/>
                        <x-input.text wire:model.live="form.address" name="form.address" id="address" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Country')" for="country" required/>
                        <x-input.select wire:model.live="form.country_id" name="form.country_id" id="country">
                            <option value="">{{ __('Select Business Country') }}</option>
                            @foreach ($countries as $country)
                                <option :value="{{ $country->id }}" wire:key="country-{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </x-input.select>
                    </div>

                    <div>
                        <x-input.label :value="__('City')" for="city" required/>
                        <x-input.select wire:model.live="form.city_id" name="form.city_id" id="city">
                            <option value="">{{ __('Select Business City') }}</option>
                            @foreach ($cities as $city)
                                <option :value="{{ $city->id }}" wire:key="city-{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </x-input.select>
                    </div>

                    <div>
                        <x-input.label :value="__('Website')" for="website"/>
                        <x-input.text wire:model.live="form.website" name="form.website" id="website" type="url"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Facebook')" for="facebook"/>
                        <x-input.text wire:model.live="form.facebook" name="form.facebook" id="facebook" type="url"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Twitter')" for="twitter"/>
                        <x-input.text wire:model.live="form.twitter" name="form.twitter" id="twitter" type="url"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Instagram')" for="instagram"/>
                        <x-input.text wire:model.live="form.instagram" name="form.instagram" id="instagram" type="url"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Linkedin')" for="linkedin"/>
                        <x-input.text wire:model.live="form.linkedin" id="linkedin" name="form.linkedin" type="url"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Youtube')" for="youtube"/>
                        <x-input.text wire:model.live="form.youtube" id="youtube" name="form.youtube" type="url"/>
                    </div>

                    <div class="col-span-3">
                        <x-input.label :value="__('About')" for="about"/>
                        <x-input.textarea wire:model.live="form.about" name="form.about" id="about" rows="4" cols="12"></x-input.textarea>
                    </div>

                    <div class="col-span-3">
                        <x-input.label :value="__('Logo')" for="logo" required="{{ !isset($this->form->business) }}"/>
                        <x:input.file wire:model.live="form.logo" name="form.logo" id="logo"/>
                    </div>

                    <div class="mt-4 flex flex-row justify-end gap-x-2 col-span-3">
                        <x-button.danger type="button">
                            {{ __('Clear') }}
                        </x-button.danger>

                        @isset($this->form->business)
                            <x-button.default type="submit">
                                {{ __('Update') }}
                            </x-button>
                        @else
                            <x-button.primary type="submit">
                                {{ __('Create') }}
                            </x-button.primary>
                        @endisset
                    <div>
                </div>
            </x-form-section>
        </div>
    </div>
</div>
