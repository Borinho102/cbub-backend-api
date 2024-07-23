<div class="px-4 sm:px-6 lg:px-8 py-4 w-full max-w-9xl mx-auto">
    <div>
        <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
            {{ __('Customers') }}
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
                    <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#">{{ __('Customers') }}</a>
                </li>
            </ul>
            <!-- End -->
        </div>
    </div>

    <!-- Page header -->
    <div class="sm:flex sm:justify-end sm:items-center mb-4 mt-12">
        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <x-search-form wire:model.live="query" name="query" />

            <!-- Export button -->
            <a wire:navigate href="{{ route('business.customers.create') }}" class="px-4 py-1.5 rounded cursor-pointer bg-indigo-500 hover:bg-indigo-600 text-white">{{ __('New Customer') }}</a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('All Customers') }} <span class="text-slate-400 dark:text-slate-500 font-medium">{{ $count }}</span></h2>
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
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <span class="sr-only">{{ __('Favourite') }}</span>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Name') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Location') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold">{{ __('Orders') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Last order') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Total spent') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold">{{ __('Refunds') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span class="sr-only">{{ __('Menu') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
                        <!-- Row -->
                        @foreach($customers as $customer)
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center">
                                        <label class="inline-flex">
                                            <span class="sr-only">{{ __('Select') }}</span>
                                            <input class="table-item form-checkbox" type="checkbox" @click="uncheckParent" />
                                        </label>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center relative">
                                        <button>
                                            <svg class="w-4 h-4 shrink-0 fill-current @if($customer->favorite){{ 'text-amber-500' }}@else{{ 'text-slate-300 dark:text-slate-600' }}@endif" viewBox="0 0 16 16">
                                                <path d="M8 0L6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934h-6L8 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                            <img class="rounded-full h-full w-full object-cover" src="{{ $customer->user->image }}" alt="{{ $customer->user->name }}" />
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-800 dark:text-slate-100">{{ $customer->user->name }}</div>
                                            <div class="text-left">{{ $customer->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">@if($customer->user->default_address){{ $customer->user->default_address->name }}@else{{ '-' }}@endif</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $customer->orders_count }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left font-medium text-sky-500">{{ $customer->last_order->order_id }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left font-medium text-emerald-500">{{ currency((float) $customer->orders_amount, null, $customer->last_order->currency) }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center">@if($customer->refunds > 0){{ $customer->refunds }}@else{{ '-' }}@endif</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <button class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 rounded-full">
                                        <span class="sr-only">{{ __('Menu') }}</span>
                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                            <circle cx="16" cy="16" r="2" />
                                            <circle cx="10" cy="16" r="2" />
                                            <circle cx="22" cy="16" r="2" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $customers->links() }}
    </div>

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
