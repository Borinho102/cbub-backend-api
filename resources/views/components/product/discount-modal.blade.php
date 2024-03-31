<form wire:submit.prevent="saveDiscount" class="p-6">
    <x-modal.dialog name="product-discount-modal" focusable>
        <x-slot name="title">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add Discount Price') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once a discount price is added, customers will be able to pay using the new discount price.') }}
            </p>
        </x-slot>

        <x-slot name="content">
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
                <x-input.label for="end_date" value="{{ __('End Date') }}" />

                <x-input.text
                    wire:model="discountForm.end_date"
                    id="end_date"
                    name="discountForm.end_date"
                    type="date"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('End Date') }}"
                />

                <x-input.error :messages="$errors->get('discount_form.end_date')" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="mt-6 flex justify-end">
                <x-button.danger x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button.danger>

                <x-button.primary class="ms-3" type="submit">
                    {{ __('Create Discount') }}
                </x-button.primary>
            </div>
        </x-slot>
    </x-modal.dialog>
</form>
