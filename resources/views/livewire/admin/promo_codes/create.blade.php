<div background="bg-gray-100 dark:bg-slate-900">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                @if (isset($form->promoCode))
                    {{ __('Update Promo Code') }}
                @else
                    {{ __('Create Promo Code') }}
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
                        <a class="text-slate-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" wire:navigate href="{{ route('admin.promo_codes.index') }}">{{ __('Promo Codes') }}</a>
                        <svg class="h-4 w-4 fill-current text-slate-400 dark:text-slate-600 mx-3" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#0">{{ __('New Promo Code') }}</a>
                    </li>
                </ul>
                <!-- End -->
            </div>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-between mt-6">
            <x-form-section submit="save">
                <div class="mb-8 border-b border-slate-200 dark:border-slate-700">
                    <ul class="text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar">
                        <li class="pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <div
                                class="{{ $activeTab === 'general' ? 'text-indigo-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-300' }} whitespace-nowrap cursor-pointer"
                                wire:click="$set('activeTab', 'general')"
                            >
                                {{ __('General') }}
                            </div>
                        </li>
                        <li class="pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <div
                                class="{{ $activeTab === 'restriction' ? 'text-indigo-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-300' }} whitespace-nowrap cursor-pointer"
                                wire:click="$set('activeTab', 'restriction')"
                            >
                                {{ __('Restriction') }}
                            </div>
                        </li>
                    </ul>
                </div>
                @if ($activeTab === 'general')
                    <div class="w-full grid gap-5 grid-cols-1 md:grid-cols-2">
                        <div class="col-span-2">
                            <x-select
                                class="w-full"
                                :label="__('Business')"
                                placeholder="Select business"
                                wire:model="form.business_id"
                                option-value="id"
                                option-label="name"
                                :async-data="route('misc.search.businesses')"
                            />
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('Title')" for="title" required/>
                            <x-input.text wire:model.change="form.title" name="form.title" id="title" type="text"/>
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('Code')" for="code" required/>
                            <x-input.text wire:model.live.debounce.500ms="form.code" name="form.code" id="code" type="text"/>
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('Discount Type')" for="discount_type" required/>
                            <x-input.select wire:model.live="form.discount_type" name="form.discount_type" id="discount_type">
                                <option>{{ __('Select Discount Type') }}</option>
                                @foreach (\App\Models\PromoCode::DISCOUNT_TYPES as $key => $type)
                                    <option value="{{ $key }}" wire:key="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </x-input.select>
                        </div>

                        @if ($form->discount_type === 'percentage')
                            <div class="col-span-1">
                                <x-input.label :value="__('Discount Percentage')" for="discount_percentage" required/>
                                <x-input.text wire:model.change="form.discount_percentage" name="form.discount_percentage" id="discount_percentage" type="number" min="5" max="100"/>
                            </div>
                        @else
                            <div class="col-span-1">
                                <x-input.label :value="__('Discount Price')" for="discount_price" required/>
                                <x-input.text wire:model.change="form.discount_price" name="form.discount_price" id="discount_price" type="text"/>
                            </div>
                        @endif

                        <div class="col-span-1">
                            <x-input.label :value="__('Start Date')" for="start_date" required/>
                            <x-datetime-picker
                                id="start_date"
                                parse-format="DD-MM-YYYY"
                                :placeholder="__('Start Date')"
                                wire:model.live="form.start_date"
                            />
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('End Date')" for="end_date" required/>
                            <x-datetime-picker
                                id="end_date"
                                parse-format="DD-MM-YYYY"
                                :placeholder="__('End Date')"
                                wire:model.live="form.end_date"
                            />
                        </div>
                    </div>
                @elseif ($activeTab === 'restriction')
                    <div class="w-full grid gap-5 grid-cols-1 md:grid-cols-2">
                        <div class="col-span-1">
                            <x-select
                                class="w-full"
                                :label="__('Product(s)')"
                                placeholder="Select Product(s)"
                                multiselect
                                wire:model="form.products"
                                option-value="id"
                                option-label="name"
                                :async-data="route('misc.search.products')"
                            />
                        </div>

                        <div class="col-span-1">
                            <x-select
                                class="w-full"
                                :label="__('Product Categorie(s)')"
                                placeholder="Select categorie(s)"
                                multiselect
                                wire:model="form.categories"
                                option-value="id"
                                option-label="name"
                                :async-data="route('misc.search.product_categories')"
                            />
                        </div>

                        <div class="col-span-2">
                            <x-select
                                class="w-full"
                                :label="__('User(s)')"
                                placeholder="Select user(s)"
                                multiselect
                                wire:model="form.users"
                                option-value="id"
                                option-label="name"
                                :async-data="route('misc.search.users')"
                            />
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('Minimum Spend')" for="minimum_spend"/>
                            <x-input.text wire:model.change="form.minimum_spend" name="form.minimum_spend" id="minimum_spend" type="text"/>
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('Maximum Spend')" for="maximum_spend"/>
                            <x-input.text wire:model.change="form.maximum_spend" name="form.maximum_spend" id="maximum_spend" type="text"/>
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('Maximum Usage')" for="max_usage"/>
                            <x-input.text wire:model.change="form.max_usage" name="form.max_usage" id="max_usage" type="number"/>
                        </div>

                        <div class="col-span-1">
                            <x-input.label :value="__('Maximum Usage / User')" for="max_usage_per_user"/>
                            <x-input.text wire:model.change="form.max_usage_per_user" name="form.max_usage_per_user" id="max_usage_per_user" type="number"/>
                        </div>
                    </div>
                @endif
                <div class="mt-10 flex flex-row justify-end gap-x-2">
                    <x-button.danger type="button">
                        {{ __('Clear') }}
                    </x-button.danger>

                    @isset ($this->form->promoCode)
                        <x-button.default type="submit">
                            {{ __('Update') }}
                        </x-button>
                    @else
                        <x-button.primary type="submit">
                            {{ __('Create') }}
                        </x-button.primary>
                    @endisset
                <div>
            </x-form-section>
        </div>
    </div>
</div>
