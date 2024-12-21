@props(['mode' => 'create'])

<form wire:submit.prevent="saveDiscount" class="p-6"
    x-data="{
        mode: @js($mode)
    }"
    x-on:open-modal.window="mode = $event.detail.mode"
>
    <x-modal.dialog name="product-discount-modal">
        <x-slot name="title">
            <div x-show="mode == 'update'">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Update Discount Price') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once a discount price is added, customers will be able to pay using the new discount price.') }}
                </p>
            </div>
            <div x-show="mode == 'create'">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Add Discount Price') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once a discount price is added, customers will be able to pay using the new discount price.') }}
                </p>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="mt-6">
                <x-input.label for="product_id" value="{{ __('Product') }}" required/>
                <x-select
                    class="w-full"
                    id="product_id"
                    :placeholder="__('Select Product')"
                    wire:model="discountForm.product_id"
                    option-value="id"
                    option-label="name"
                    :async-data="route('misc.search.products')"
                />
            </div>
            <div class="mt-6">
                <x-input.label for="price" value="{{ __('Discount Price') }}" required/>

                <x-input.text
                    wire:model="discountForm.price"
                    id="price"
                    name="discountForm.price"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Discount Price') }}"
                />

                <x-input.error :messages="$errors->get('discount_form.price')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input.label for="start_time" value="{{ __('Start Time') }}" />
                <x-datetime-picker
                    id="start_time"
                    :placeholder="__('Start Time')"
                    wire:model.defer="discountForm.start_time"
                    min-time="08:00"
                    max-time="18:00"
                />
                <x-input.error :messages="$errors->get('discount_form.start_time')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input.label for="end_time" value="{{ __('End Time') }}" />
                <x-datetime-picker
                    id="end_time"
                    :placeholder="__('End Time')"
                    min-time="08:00"
                    max-time="18:00"
                    wire:model.defer="discountForm.end_time"
                />
                <x-input.error :messages="$errors->get('discount_form.end_time')" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="mt-6 flex justify-end">
                <x-button.danger x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button.danger>

                <div x-show="mode == 'update'">
                    <x-button.primary class="ms-3" type="submit">
                        <div wire:loading wire:target="saveDiscount">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        {{ __('Update Discount') }}
                    </x-button.primary>
                </div>

                <div x-show="mode == 'create'">
                    <x-button.primary class="ms-3" type="submit">
                        <div wire:loading wire:target="saveDiscount">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        {{ __('Create Discount') }}
                    </x-button.primary>
                </div>
            </div>
        </x-slot>
    </x-modal.dialog>
</form>
