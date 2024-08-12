<div background="bg-gray-100 dark:bg-slate-900">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                {{ __('Update Order') }}
            </h2>
            <div class="text-start">
                <!-- Start -->
                <ul class="inline-flex flex-wrap text-sm font-medium">
                    <li class="flex items-center">
                        <a class="text-slate-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" wire:navigate href="{{ route('business.dashboard') }}">{{ __('Dashboard') }}</a>
                        <svg class="h-4 w-4 fill-current text-slate-400 dark:text-slate-600 mx-3" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a class="text-slate-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" wire:navigate href="{{ route('business.orders.index') }}">{{ __('Orders') }}</a>
                        <svg class="h-4 w-4 fill-current text-slate-400 dark:text-slate-600 mx-3" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#">#{{ $order->order_id }}</a>
                    </li>
                </ul>
                <!-- End -->
            </div>
        </div>
        <div class="w-full flex flex-col md:flex-row justify-between mt-6">
            <x-form-section submit="update">
                <div class="w-full grid gap-5 grid-cols-1 md:grid-cols-2">
                    <div class="mt-6 col-span-2">
                        <x-input.label for="price" value="{{ __('Status') }}" required/>
                        <x-select
                            class="w-full"
                            :placeholder="__('Select Status')"
                            wire:model.blur="form.status"
                            option-value="id"
                            option-label="name"
                            :options="$statuses"
                        />
                    </div>

                    @if ($order && $order->status == \App\Enums\OrderStatus::Pending && $form->status === \App\Enums\OrderStatus::Approved)
                        @foreach ($form->orderItems as $key => $item)
                            @php
                                $product = $form->products->where('id', $item['item_id'])->first();
                            @endphp
                            @if ($product)
                                <div class="col-span-2 mt-6 border rounded-md p-4">
                                    <div class="flex flex-row justify-between gap-x-4">
                                        <div class="w-full">
                                            <x-input.label :value="__('Product Ordered')" for="form.orderItems.{{ $key }}.id" required/>
                                            <x-input.text
                                                :value="$product->name"
                                                name="products.{{ $product->id }}"
                                                disabled
                                            />
                                        </div>
                                        <div class="w-8"></div>
                                        <div class="w-full">
                                            <x-input.label :value="__('Available Quantity')" for="form.orderItems.{{ $key }}.quantity"/>
                                            <x-input.text
                                                :value="$product->quantity"
                                                name="available_quantity.{{ $key }}"
                                                :max="$product->quantity"
                                                disabled
                                            />
                                        </div>
                                    </div>
                                    <div class="flex flex-row justify-between gap-x-4 mt-4">
                                        <div class="w-full">
                                            <x-input.label for="price" value="{{ __('Status') }}" required/>
                                            <x-select
                                                class="w-full"
                                                :placeholder="__('Select Status')"
                                                wire:model="form.orderItems.{{ $key }}.status"
                                                option-value="id"
                                                option-label="name"
                                                :options="$statuses"
                                            />
                                        </div>
                                        <div class="w-8"></div>
                                        <div class="w-full">
                                            <x-input.label :value="__('Quantity Ordered')" for="form.orderItems.{{ $key }}.quantity" required/>
                                            <x-input.text
                                                wire:model="form.orderItems.{{ $key }}.quantity"
                                                name="form.orderItems.{{ $key }}.quantity"
                                            />
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <x-input.label for="note" value="{{ __('Note') }}"/>
                                        <x-input.textarea
                                            class="w-full"
                                            :placeholder="__('Anything you would like the customer to know ?')"
                                            wire:model="form.orderItems.{{ $key }}.description"
                                            name="form.orderItems.{{ $key }}.description"
                                            :rows="2"
                                        />
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <div class="mt-4 col-span-2">
                        <x-input.label for="note" value="{{ __('Note') }}"/>
                        <x-input.textarea
                            class="w-full"
                            :placeholder="__('Anything you would like the customer to know ?')"
                            wire:model="form.note"
                            name="form.note"
                            :rows="4"
                        />
                    </div>
                </div>
                <div class="mt-10 flex flex-row justify-end gap-x-2">
                    <x-button.danger type="button">
                        {{ __('Clear') }}
                    </x-button.danger>

                    <x-button.primary type="submit">
                        <div wire:loading wire:target="update">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        {{ __('Update') }}
                    </x-button.primary>
                <div>
            </x-form-section>
        </div>
    </div>
</div>
