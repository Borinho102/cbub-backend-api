<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div>
        <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
            {{ __('Product Discounts') }}
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
                    <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#0">{{ __('Product Discounts') }}</a>
                </li>
            </ul>
            <!-- End -->
        </div>
    </div>

    <!-- Page header -->
    <div class="flex justify-end items-center mb-4 md:mb-2 mt-12">
        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <x-search-form wire:model.live="query" name="query" />

            <!-- Export button -->
            <button type="button" class="px-4 py-1.5 rounded cursor-pointer bg-indigo-500 hover:bg-indigo-600 text-white"
                x-data=""
                x-on:click.prevent="$wire.dispatchTo('admin.products.product-discount-list', 'show-discount-modal')"
            >
                {{ __('Add Discount') }}
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('All Discounts') }} <span class="text-slate-400 dark:text-slate-500 font-medium">{{ $count }}</span></h2>
        </header>

        <div x-data="handleSelect">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-slate-300">
                    <!-- Table header -->
                    <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/20 border-t border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <div class="flex items-center">
                                    <label class="inline-flex">
                                        <span class="sr-only">{{ __('Select all') }}</span>
                                        <input id="parent-checkbox" class="form-checkbox" type="checkbox" @click="toggleAll" />
                                    </label>
                                </div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Product') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Old Price') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('New Price') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Percentage Off') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold">{{ __('Status') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold">{{ __('End Date') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold">{{ __('Created At') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span class="sr-only">{{ __('Menu') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                        @foreach($product_discounts as $discount)
                            <tbody class="text-sm" x-data="{ open: false }">
                                <!-- Row -->
                                <tr>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center">
                                            <label class="inline-flex">
                                                <span class="sr-only">{{ __('Select') }}</span>
                                                <input class="table-item form-checkbox" type="checkbox" @click="uncheckParent" />
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                                <img class="rounded-full h-full w-full object-cover" src="{{ $discount->product->thumbnail }}" alt="{{ $discount->product->name }}" />
                                            </div>
                                            <div class="font-medium text-slate-800 dark:text-slate-100">{{ $discount->product->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center text-red-500 dark:text-red-400 font-medium">{{ currency($discount->old_price) }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center text-green-500 dark:text-green-400 font-medium">{{ currency($discount->new_price) }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center">{{ (int) $discount->discount_percentage }}%</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-center">
                                            <x-toggle id="product-discount-toggle-{{ $discount->id }}" :checked="$discount->is_active == 1" wire:change="toggleStatus({{ $discount->id }})" primary xl />
                                            {{-- @if ($discount->is_active && (!$discount->end_date || !$discount->end_date->isPast()))
                                                <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-emerald-100 dark:bg-emerald-400/30 text-emerald-600 dark:text-emerald-400">{{ __('Active') }}</div>
                                            @else
                                                <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-amber-100 dark:bg-amber-400/30 text-amber-600 dark:text-amber-400">{{ __('Inactive') }}</div>
                                            @endif --}}
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center font-medium {{ $discount->end_date && $discount->end_date->isPast() ? 'text-red-500' : 'text-green-500' }}">
                                            @if ($discount->end_date)
                                                {{ $discount->end_date->format('d/m/Y H:m') }}
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center">{{ $discount->created_at->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="space-x-1">
                                            <button
                                                type="button"
                                                x-on:click.prevent="$wire.dispatchTo('admin.products.product-discount-list', 'show-discount-modal', { discount_id: {{ $discount->id }} })"
                                                class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 rounded-full inline-block"
                                            >
                                                <span class="sr-only">Edit</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <path d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                                </svg>
                                            </button>
                                            <button
                                                class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 transform"
                                                :class="{ 'rotate-180': open }"
                                                @click.prevent="open = !open"
                                                :aria-expanded="open"
                                                aria-controls="description-{{ $discount->id }}"
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
                                <tr id="description-{{ $discount->id }}" role="region" x-show="open" x-cloak>
                                    <td colspan="10" class="px-2 first:pl-5 last:pr-5 py-3">
                                        <div class="flex items-center bg-slate-50 dark:bg-slate-900/30 dark:text-slate-400 p-3 -mt-3">
                                            <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-slate-500 mr-2">
                                                <path d="M1 16h3c.3 0 .5-.1.7-.3l11-11c.4-.4.4-1 0-1.4l-3-3c-.4-.4-1-.4-1.4 0l-11 11c-.2.2-.3.4-.3.7v3c0 .6.4 1 1 1zm1-3.6l10-10L13.6 4l-10 10H2v-1.6z" />
                                            </svg>
                                            <div class="italic">{{ $discount->id }}</div>
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
        {{ $product_discounts->links() }}
    </div>

    <x-product.discount-modal />

    <script>
        // A basic demo function to handle "select all" functionality
        document.addEventListener('alpine:init', () => {
            Alpine.data('handleSelect', () => ({
                selectall: false,
                selectAction() {
                    countEl = document.querySelector('.table-items-action');
                    if (!countEl) return;
                    checkboxes = document.querySelectorAll('input.table-item:checked');
                    document.querySelector('.table-items-count').innerHTML = checkboxes.length;
                    if (checkboxes.length > 0) {
                        countEl.classList.remove('hidden');
                    } else {
                        countEl.classList.add('hidden');
                    }
                },
                toggleAll() {
                    this.selectall = !this.selectall;
                    checkboxes = document.querySelectorAll('input.table-item');
                    [...checkboxes].map((el) => {
                        el.checked = this.selectall;
                    });
                    this.selectAction();
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
