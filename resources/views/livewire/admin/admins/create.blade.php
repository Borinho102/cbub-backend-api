<div background="bg-gray-100 dark:bg-slate-900">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                @if (isset($form->product))
                    {{ __('Update Admin') }}
                @else
                    {{ __('Add Admin') }}
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
                        <a class="text-slate-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" wire:navigate href="{{ route('admin.admins.index') }}">{{ __('Admins') }}</a>
                        <svg class="h-4 w-4 fill-current text-slate-400 dark:text-slate-600 mx-3" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#0">{{ __('New Admin') }}</a>
                    </li>
                </ul>
                <!-- End -->
            </div>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-between mt-6">
            <x-form-section submit="save">
                <div class="w-full grid gap-5 grid-cols-1 md:grid-cols-2">
                    <div>
                        <x-input.label :value="__('Name')" for="name" required/>
                        <x-input.text wire:model.blur="form.name" name="form.name" id="name" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Email')" for="email" required/>
                        <x-input.text wire:model.blur="form.email" name="form.email" id="email" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Phone')" for="phone" required/>
                        <x-input.text wire:model.blur="form.phone" name="form.phone" id="phone" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Address')" for="address"/>
                        <x-input.text wire:model.blur="form.address" name="form.address" id="address" type="text"/>
                    </div>

                    <div>
                        <x-input.label :value="__('Country')" for="country_id" required/>
                        <x-input.select wire:change="form.country_id" wire:model.blur="form.country_id" name="form.country_id" id="country_id">
                            <option>{{ __('Select Country') }}</option>
                            @foreach ($countries as $country)
                                <option wire:key="country-{{ $country->id }}" :value="{{ $country->id }}" @if ($country->id == $form->country_id) selected @endif>{{ $country->name }}</option>
                            @endforeach
                        </x-input.select>
                    </div>

                    <div>
                        <x-input.label :value="__('City')" for="city_id" required/>
                        <x-input.select wire:change="form.city_id" wire:model="form.city_id" name="form.city_id" id="city_id">
                            <option>{{ __('Select City') }}</option>
                            @foreach ($cities as $city)
                                <option :value="{{ $city->id }}" wire:key="city-{{ $city->id }}" @if ($city->id == $form->city_id) selected @endif>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </x-input.select>
                    </div>

                    <div class="col-span-2">
                        <x-input.label :value="__('Role(s)')" for="roles" required/>
                        <x-input.select wire:change="form.roles" wire:model="form.roles" name="form.roles" id="roles" multiple>
                            <option>{{ __('Select Role(s)') }}</option>
                            @foreach ($roles as $role)
                                <option wire:key="role-{{ $role->id }}" :value="{{ $role->id }}" @if (in_array($role->id, $form->roles)) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </x-input.select>
                    </div>

                    <div>
                        <x-input.label :value="__('Profile Picture')" for="profile_picture"/>
                        <x:input.file wire:model.blur="form.profile_picture" name="form.profile_picture" id="profile_picture"/>
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
