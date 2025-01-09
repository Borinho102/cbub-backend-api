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
                        <x-input.text wire:model.blur="form.name" name="form.name" id="name" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Email')" for="email" required/>
                        <x-input.text wire:model.blur="form.email" name="form.email" id="email" type="email"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Phone Number')" for="phone" required/>
                        <x-input.text wire:model.blur="form.phone" name="form.phone" id="phone" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Address')" for="address" required/>
                        <x-input.text wire:model.blur="form.address" name="form.address" id="address" type="text"/>
                    </div>

                    <div class="col-span-1">
                        <x-input.label :value="__('Business Category')" for="name" required/>
                        <x-select
                            class="w-full"
                            placeholder="Select Business Category"
                            wire:model="form.category_id"
                            option-value="id"
                            option-label="name"
                            :async-data="route('misc.search.business_categories')"
                        />
                    </div>

                    <div class="col-span-1">
                        <x-input.label :value="__('Country')" for="name" required/>
                        <x-select
                            class="w-full"
                            placeholder="Select Business Country"
                            wire:model="form.country_id"
                            option-value="id"
                            option-label="name"
                            :async-data="route('misc.search.countries')"
                        />
                    </div>

                    <div class="col-span-3">
                        <x-input.label :value="__('About')" for="about"/>
                        <x-input.textarea wire:model.blur="form.about" name="form.about" id="about" rows="4" cols="12"></x-input.textarea>
                    </div>

                    @if (isset($this->form->business) && $this->form->business->logo)
                        <div class="col-span-3">
                            <x-input.label :value="__('Logo')" for="logo" required="{{ !isset($this->form->business) }}"/>
                            <x:input.image initialImage="{{ $this->form->business->logo }}" name="logo_preview" id="logo_preview"/>
                            <x:input.file wire:model.blur="form.logo" name="form.logo" id="logo"/>
                        </div>
                    @else
                        <div class="col-span-3">
                            <x-input.label :value="__('Logo')" for="logo" required="{{ !isset($this->form->business) }}"/>
                            <x:input.file wire:model.blur="form.logo" name="form.logo" id="logo"/>
                        </div>
                    @endif

                    @if(!isset($this->form->business))
                        <div class="col-span-3 border-b my-2">
                        </div>
                        <div>
                            <x-input.label :value="__('Owner Name')" for="owner_name" required/>
                            <x-input.text wire:model.blur="form.owner_name" id="owner_name" name="form.owner_name" type="text"/>
                        </div>

                        <div>
                            <x-input.label :value="__('Owner Email')" for="owner_email" required/>
                            <x-input.text wire:model.blur="form.owner_email" id="owner_email" name="form.owner_email" type="text"/>
                        </div>

                        <div>
                            <x-input.label :value="__('Owner Phone')" for="owner_phone" required/>
                            <x-input.text wire:model.blur="form.owner_phone" id="owner_email" name="form.owner_email" type="text"/>
                        </div>

                        <div>
                            <x-input.label :value="__('Owner Address')" for="owner_address"/>
                            <x-input.text wire:model.blur="form.owner_address" id="owner_address" name="form.owner_address" type="text"/>
                        </div>
                    @endif

                    <div class="mt-4 flex flex-row justify-end gap-x-2 col-span-3">
                        <x-button.danger type="button">
                            {{ __('Clear') }}
                        </x-button.danger>

                        @isset($this->form->business)
                            <x-button.primary type="submit">
                                <div wire:loading wire:target="save">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                {{ __('Update') }}
                            </x-button.primary>
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
                </div>
            </x-form-section>
        </div>
    </div>
</div>
