@props(['movementType', 'selectedProduct' => null])

<form wire:submit.prevent="updateStock" class="p-6">
    <x-modal.dialog name="update-stock-modal" focusable>
        <x-slot name="title">
            @if ($movementType == \App\Enums\StockMovementType::In)
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Add Product Stock') }}
                </h2>
                @if (! is_null($selectedProduct))
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __(sprintf('Enter the quantity to be added to the “%s” stock and provide any comments.', $selectedProduct->product->name)) }}
                    </p>
                @endif
            @else
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Remove Product Stock') }}
                </h2>
                @if (! is_null($selectedProduct))
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __(sprintf('Enter the quantity to be reduced to the “%s” stock and provide any comments.', $selectedProduct->product->name)) }}
                    </p>
                @endif
            @endif
        </x-slot>

        <x-slot name="content">
            @if (! is_null($selectedProduct))
                <div class="mt-6">
                    <x-input.label for="product" value="{{ __('Product') }}" required/>

                    <x-input.text
                        id="product"
                        type="text"
                        disabled
                        value="{{ $selectedProduct->product->name }}"
                        name="product"
                        class="mt-1 block w-3/4"
                        placeholder="{{ __('Product') }}"
                    />
                </div>
            @endif

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
                <x-input.label for="quantity" value="{{ __('Comment') }}"/>

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
