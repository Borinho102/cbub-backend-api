<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">{{ __('Product Stocks ✨') }}</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Dropdown -->
            <x-date-select />

            <!-- Filter button -->
            <x-dropdown-filter align="right" />
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <div class="flex justify-between items-center">
            <header class="px-5 py-4">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('Product Stocks') }} <span class="text-slate-400 dark:text-slate-500 font-medium">{{ $count }}</span></h2>
            </header>
            <div class="table-items-action {{ isset($selectedItems) && count($selectedItems) == 1 ? 'block' : 'hidden' }} mr-2">
                <div class="flex items-center">
                    <button
                        x-data=""
                        x-on:click.prevent="$wire.dispatchTo('admin.products.product-stock-list', 'show-add-stock-modal')"
                        class="mr-3 btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-green-500">
                        {{ __('Add Stock') }}
                    </button>

                    <button
                        x-data=""
                        x-on:click.prevent="$wire.dispatchTo('admin.products.product-stock-list', 'show-remove-stock-modal')"
                        class="btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-red-500">

                        {{ __('Remove Stock') }}
                    </button>
                </div>
            </div>
        </div>

        <div x-data="handleSelect">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-slate-300">
                    <!-- Table header -->
                    <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/20 border-t border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px"></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Product') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Previous Quantity') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('New Quantity') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Type') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Author') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold">{{ __('Date') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span class="sr-only">{{ __('Menu') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                        @foreach ($product_stocks as $key => $product_stock)
                            <tbody class="text-sm" x-data="{ open: false }">
                                <!-- Row -->
                                <tr>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center">
                                            <label class="inline-flex">
                                                <span class="sr-only">{{ __('Select') }}</span>
                                                <input wire:model.live="selectedItems" value="{{ $product_stock->id }}" class="table-item form-checkbox" type="checkbox" />
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                                <img class="rounded-full h-full w-full object-cover" src="{{ $product_stock->product->preview_image }}" alt="{{ $product_stock->product->name }}" />
                                            </div>
                                            <div class="font-medium text-slate-800 dark:text-slate-100">{{ $product_stock->product->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center uppercase font-medium">{{ $product_stock->old_quantity }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center uppercase font-medium">{{ $product_stock->new_quantity }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @if ($product_stock->type === \App\Enums\StockMovementType::In)
                                            <div class="text-center uppercase text-green-500 font-medium">{{ $product_stock->type }}</div>
                                        @elseif ($product_stock->type === \App\Enums\StockMovementType::Out)
                                            <div class="text-center uppercase text-red-500 font-medium">{{ $product_stock->type }}</div>
                                        @endif
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                                <img class="rounded-full h-full w-full object-cover" src="{{ $product_stock->author->image ?? $product_stock->author->profile_picture }}" alt="{{ $product_stock->author->name }}" />
                                            </div>
                                            <div class="font-medium text-slate-800 dark:text-slate-100">{{ $product_stock->author->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center">{{ $product_stock->created_at->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center space-x-1">
                                            <button
                                                class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 transform"
                                                :class="{ 'rotate-180': open }"
                                                @click.prevent="open = !open"
                                                :aria-expanded="open"
                                                aria-controls="description-{{ $product_stock->id }}"
                                            >
                                                <span class="sr-only">Menu</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <path d="M16 20l-5.4-5.4 1.4-1.4 4 4 4-4 1.4 1.4z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!--
                                Example of content revealing when clicking the button on the right side:
                                Note that you must set a "colspan" attribute on the <td> element,
                                and it should match the number of columns in your table
                                -->
                                <tr id="description-{{ $product_stock->id }}" role="region" x-show="open" x-cloak>
                                    <td colspan="10" class="px-2 first:pl-5 last:pr-5 py-3">
                                        <div class="flex items-center bg-slate-50 dark:bg-slate-900/30 dark:text-slate-400 p-3 -mt-3">
                                            <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-slate-500 mr-2">
                                                <path d="M1 16h3c.3 0 .5-.1.7-.3l11-11c.4-.4.4-1 0-1.4l-3-3c-.4-.4-1-.4-1.4 0l-11 11c-.2.2-.3.4-.3.7v3c0 .6.4 1 1 1zm1-3.6l10-10L13.6 4l-10 10H2v-1.6z" />
                                            </svg>
                                            <div class="italic">{{ $product_stock->comment }}</div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $product_stocks->links() }}
    </div>

    <x-product.update-stock-modal
        :movementType="$stockMovementType"
        :selectedProduct="$selectedProduct" />

    <script>
        // A basic demo function to handle "select all" functionality
        document.addEventListener('alpine:init', () => {
            Alpine.data('handleSelect', () => ({
                selectall: false,
                selectAction() {
                    countEl = document.querySelector('.table-items-action');
                    if (!countEl) return;
                    checkboxes = document.querySelectorAll('input.table-item:checked');
                    if (checkboxes.length == 1) {
                        countEl.classList.remove('hidden');
                    } else {
                        countEl.classList.add('hidden');
                    }
                },
                uncheckParent() {
                    this.selectall = false;
                    document.getElementById('parent-checkbox').checked = false;
                    this.selectAction();
                }
            }))
        })
    </script>
</div>
