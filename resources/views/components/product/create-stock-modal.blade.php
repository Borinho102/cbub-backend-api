<form wire:submit.prevent="saveStock" class="p-6">
    <x-modal.dialog name="create-stock-modal" focusable>
        <x-slot name="title">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add Product Stock') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __(sprintf('Enter the quantity to be added/removed from the stock of the selected product.')) }}
            </p>
        </x-slot>

        <x-slot name="content">
            <div class="mt-6">
                <x-input.label for="price" value="{{ __('Product') }}" required/>
                <x-select
                    class="w-full"
                    :placeholder="__('Select Product')"
                    wire:model="productStockForm.product_id"
                    option-value="id"
                    option-label="name"
                    :async-data="route('misc.search.products')"
                />
            </div>
            <div class="mt-6">
                <x-input.label for="type" value="{{ __('Type') }}" required/>

                <x-input.select
                    wire:model.blur="productStockForm.type"
                    id="type"
                    name="productStockForm.type"
                    class="mt-1 block w-3/4"
                >
                    <option>{{ __('Select Type') }}</option>
                    @foreach (\App\Enums\StockMovementType::asSelectArray() as $key => $type)
                        <option value="{{ $key }}" wire:key="type-{{ $key }}">{{ $type }}</option>
                    @endforeach
                </x-input.select>

                <x-input.error :messages="$errors->get('product_stock_form.type')" class="mt-2" />
            </div>
            <div class="mt-6">
                <x-input.label for="quantity" value="{{ __('Quantity') }}" required/>

                <x-input.text
                    wire:model.blur="productStockForm.quantity"
                    id="price"
                    name="productStockForm.quantity"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Quantity') }}"
                />

                <x-input.error :messages="$errors->get('product_stock_form.quantity')" class="mt-2" />
            </div>
            <div class="mt-6">
                <x-input.label for="comment" value="{{ __('Comment') }}"/>

                <x-input.textarea
                    id="comment"
                    wire:model.blur="productStockForm.comment"
                    name="productStockForm.comment"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Comment') }}"
                />

                <x-input.error :messages="$errors->get('product_stock_form.comment')" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="mt-6 flex justify-end">
                <x-button.danger x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button.danger>

                <x-button.primary class="ms-3" type="submit">
                    {{ __('Update Stock') }}
                </x-button.primary>
            </div>
        </x-slot>
    </x-modal.dialog>
</form>
