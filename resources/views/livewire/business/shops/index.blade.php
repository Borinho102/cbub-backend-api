
<div background="bg-white dark:bg-slate-900">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-4 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                {{ __('Shops') }}
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
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#">{{ __('Shops') }}</a>
                    </li>
                </ul>
                <!-- End -->
            </div>
        </div>

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-4 mt-12">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">

            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <!-- Search form -->
                <x-search-form wire:model.live="query" name="query" />

                <!-- Create button -->
                <a wire:navigate href="{{ route('business.shops.create') }}" class="px-4 py-1.5 rounded cursor-pointer bg-indigo-500 hover:bg-indigo-600 text-white">{{ __('Add Shop') }}</a>
            </div>
        </div>

        <div class="mt-8">
            <div class="grid grid-cols-12 gap-6">
                @foreach ($shops as $shop)
                    <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="flex flex-col h-full">
                            <!-- Image -->
                            <img class="w-full" src="{{ asset('images/applications-image-01.jpg') }}" width="286" height="160" alt="Application 01" />
                            <!-- Card Content -->
                            <div class="grow flex flex-col p-5">
                                <!-- Card body -->
                                <div class="grow">
                                    <!-- Header -->
                                    <header class="mb-3">
                                        <h3 class="text-lg text-slate-800 dark:text-slate-100 font-semibold line-clamp-2">{{ $shop->name }}</h3>
                                    </header>
                                    <!-- Rating and price -->
                                    <div class="flex flex-wrap justify-between items-center mb-4">
                                        <!-- Rating -->
                                        <div class="flex items-center space-x-2 mr-2">
                                            <!-- Stars -->
                                            <div class="flex space-x-1">
                                                @for ($i = 1; $i <= round($shop->rating_avg); $i++)
                                                    <span>
                                                        <span class="sr-only">{{ $i }} star</span>
                                                        <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                        </svg>
                                                    </span>
                                                @endfor
                                                @for ($i = 1; $i <= 5 - round($shop->rating_avg); $i++)
                                                    <span>
                                                        <span class="sr-only">{{ $i }} star</span>
                                                        <svg class="w-4 h-4 fill-current text-slate-300 dark:text-slate-600" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                        </svg>
                                                    </span>
                                                @endfor
                                            </div>
                                            <!-- Rate -->
                                            <div class="inline-flex text-sm font-medium text-amber-600">{{ $shop->reviews_count }}</div>
                                        </div>
                                    </div>
                                    <!-- Features list -->
                                    <ul class="text-sm space-y-2 mb-5 dark:text-slate-300">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 fill-current text-slate-400 dark:text-slate-500 shrink-0 mr-3" viewBox="0 0 16 16">
                                                <path d="M15.686 5.695L10.291.3c-.4-.4-.999-.4-1.399 0s-.4.999 0 1.399l.6.599-6.794 3.697-1-1c-.4-.399-.999-.399-1.398 0-.4.4-.4 1 0 1.4l1.498 1.498 2.398 2.398L.6 13.988 2 15.387l3.696-3.697 3.997 3.996c.5.5 1.199.2 1.398 0 .4-.4.4-.999 0-1.398l-.999-1 3.697-6.694.6.6c.599.6 1.199.2 1.398 0 .3-.4.3-1.1-.1-1.499zM8.493 11.79L4.196 7.494l6.695-3.697 1.298 1.299-3.696 6.694z" />
                                            </svg>
                                            <div>{{ $shop->orders_count }} {{ __('Orders') }}</div>
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 fill-current text-slate-400 dark:text-slate-500 shrink-0 mr-3" viewBox="0 0 16 16">
                                                <path d="M15 15V5l-5-5H2c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h12c.6 0 1-.4 1-1zM3 2h6v4h4v8H3V2z" />
                                            </svg>
                                            <div>{{ $shop->products_count }} {{ __('Products') }}</div>
                                        </li>
                                        <li class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3 fill-current text-slate-400 dark:text-slate-500 shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                            </svg>
                                            <div>{{ $shop->product_sold_count }} {{ __('Product Sold') }}</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Card footer -->
                                <div>
                                    <a class="btn-sm w-full bg-indigo-500 hover:bg-indigo-600 text-white" wire:navigate href="{{ route('business.shops.edit', $shop->id) }}">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $shops->links() }}
        </div>
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
                },
            }))
        })
    </script>
</div>
