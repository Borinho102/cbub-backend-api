<div background="bg-gray-100 dark:bg-slate-900">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-4 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                {{ __('Broadcast Notification') }}
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
                        <a class="text-slate-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" wire:navigate href="{{ route('admin.notifications.index') }}">{{ __('Notifications') }}</a>
                        <svg class="h-4 w-4 fill-current text-slate-400 dark:text-slate-600 mx-3" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#0">{{ __('Send') }}</a>
                    </li>
                </ul>
                <!-- End -->
            </div>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-between mt-6">
            <x-form-section submit="send">
                <div class="w-full grid gap-5 grid-cols-1 md:grid-cols-2">
                    <div class="col-span-2">
                        <x-select
                            class="w-full"
                            :label="__('Notification Type')"
                            placeholder="Select type"
                            wire:model.live="form.type"
                            :options="$types"
                            option-value="id"
                            option-label="name"
                        />
                    </div>

                    @if (in_array($form->type, [\App\Enums\NotificationType::NewProduct, \App\Enums\NotificationType::ProductDiscount, \App\Enums\NotificationType::Publicity, \App\Enums\NotificationType::Announcement]))
                        <div class="col-span-2">
                            <x-select
                                class="w-full"
                                :label="__('Product')"
                                placeholder="Select product"
                                wire:model.blur="form.product"
                                option-value="id"
                                option-label="name"
                                :async-data="route('misc.search.products')"
                            />
                        </div>
                    @elseif ($form->type === \App\Enums\NotificationType::PromoCode)
                        <div class="col-span-2">
                            <x-select
                                class="w-full"
                                :label="__('Promo Code')"
                                placeholder="Select promo code"
                                wire:model.blur="form.promo_code"
                                option-value="id"
                                option-label="name"
                                :async-data="route('misc.search.promo_codes')"
                            />
                        </div>
                    @endif

                    <div class="col-span-1">
                        <x-input.label :value="__('Title (English)')" for="title_en" required/>
                        <x-input.text wire:model.blur="form.title_en" name="form.title_en" id="title_en" type="text"/>
                    </div>

                    <div class="col-span-1">
                        <x-input.label :value="__('Title (French)')" for="title_fr" required/>
                        <x-input.text wire:model.blur="form.title_fr" name="form.title_fr" id="title_fr" type="text"/>
                    </div>

                    <div class="col-span-1">
                        <x-input.label :value="__('Body (English)')" for="body_en" required/>
                        <x-input.textarea wire:model="form.body_en" name="form.body_en" id="body_en" rows="4" cols="12"></x-input.textarea>
                    </div>

                    <div class="col-span-1">
                        <x-input.label :value="__('Body (French)')" for="body_fr" required/>
                        <x-input.textarea wire:model="form.body_fr" name="form.body_fr" id="body_fr" rows="4" cols="12"></x-input.textarea>
                    </div>

                    <div class="col-span-2">
                        <x-select
                            class="w-full"
                            :label="__('User(s)')"
                            :placeholder="__('Select user(s)')"
                            multiselect
                            wire:model="form.users"
                            option-value="id"
                            option-label="name"
                            :async-data="route('misc.search.users')"
                        />
                    </div>

                    <div class="col-span-2">
                        <x-input.label :value="__('Broadcast At')" for="broadcast_at"/>
                        <x-datetime-picker
                            id="broadcast_at"
                            :placeholder="__('Broadcast At')"
                            wire:model="form.broadcast_at"
                        />
                    </div>

                    <div class="col-span-1">
                        <x-input.label :value="__('Image (English)')" for="image_en"/>
                        <x:input.file wire:model.blur="form.image_en" name="form.image_en" id="image_en"/>
                    </div>

                    <div class="col-span-1">
                        <x-input.label :value="__('Image (French)')" for="image_fr"/>
                        <x:input.file wire:model.blur="form.image_fr" name="form.image_fr" id="image_fr"/>
                    </div>

                    <div class="mt-4 flex flex-row justify-end gap-x-2 col-span-2">
                        <x-button.danger type="button">
                            {{ __('Clear') }}
                        </x-button.danger>

                        <x-button.primary type="submit">
                            <div wire:loading wire:target="send">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            {{ __('Send') }}
                        </x-button.primary>
                    <div>
                </div>
            </x-form-section>
        </div>
    </div>
</div>

