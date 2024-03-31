<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                {{ __('Product') }}
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
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#0">{{ __('Product List') }}</a>
                    </li>
                </ul>
                <!-- End -->
            </div>
        </div>

        <!-- Page header -->
        <div class="flex justify-between items-center mb-4 md:mb-2 mt-12">
            <livewire:admin.products.filter lazy />
            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <!-- Search form -->
                <x-search-form wire:model.live="query" name="query" />

                <!-- Export button -->
                <a
                    wire:navigate
                    href="{{ route('admin.products.create') }}"
                    class="btn bg-indigo-500 hover:bg-indigo-600 text-white"
                >{{ __('New Product') }}</a>
            </div>
        </div>

        <!-- Page content -->
        <div>
            <div class="mt-8">
                <div class="grid grid-cols-12 gap-6">
                    <x-product.items :products="$products" />
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>

            <!-- (Popular Categories) -->
            <div class="mt-8">
                <h2 class="text-xl leading-snug text-slate-800 dark:text-slate-100 font-bold mb-5">Popular Categories</h2>
                <div class="grid grid-cols-12 gap-6">
                    <x-product.shop-cards-05 />
                </div>
            </div>
        </div>
    </div>
</div>
