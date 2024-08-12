@foreach ($products as $product)
    <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 overflow-hidden z-80">
        <div class="flex flex-col h-full">
            <!-- Image -->
            <div class="relative">
                <img class="w-full h-40" src="{{ $product->thumbnail }}" alt="Application 05" />
                <!-- Popular label -->
                <div class="absolute top-0 left-4 mt-4">
                    <div class="inline-flex items-center text-xs font-medium text-slate-100 dark:text-slate-300 bg-slate-900/60 dark:bg-slate-800/60 rounded-full text-center px-2 py-0.5">
                        <svg class="w-3 h-3 shrink-0 fill-current text-amber-500 mr-1" viewBox="0 0 12 12">
                            <path d="M11.953 4.29a.5.5 0 00-.454-.292H6.14L6.984.62A.5.5 0 006.12.173l-6 7a.5.5 0 00.379.825h5.359l-.844 3.38a.5.5 0 00.864.445l6-7a.5.5 0 00.075-.534z" />
                        </svg>
                        <span>Popular</span>
                    </div>
                </div>
                <div class="absolute top-0 right-0 mt-2 mr-2">
                    <div class="relative inline-flex" x-data="{ open: false }">
                        <button class="inline-flex justify-center items-center group" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                            <div class="flex items-center truncate text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                </svg>
                            </div>
                        </button>
                        <div
                            class="origin-top-right z-99 absolute top-full left-0 min-w-44 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-1.5 rounded shadow-lg overflow-x-visible mt-1"
                            @click.outside="open = false"
                            @keydown.escape.window="open = false" x-show="open"
                            x-transition:enter="transition ease-out duration-200 transform"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-out duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            x-cloak
                        >
                            <ul>
                                <li>
                                    <a class="font-medium text-sm text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-200 flex items-center py-1 px-3" wire:navigate href="#" @click="open = false" @focus="open = true" @focusout="open = false">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Content -->
            <div class="grow flex flex-col p-5">
                <!-- Card body -->
                <div class="grow">
                    <!-- Header -->
                    <header class="mb-2">
                        <h3 class="text-lg text-slate-800 dark:text-slate-100 font-semibold mb-1">{{ $product->name }}</h3>
                        <div class="text-sm line-clamp-3">{{ $product->description }}</div>
                    </header>
                    <!-- Rating and Price -->
                    <div class="flex flex-wrap items-center justify-between mb-5">
                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mr-2">
                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                            </svg>
                            <!-- Rate -->
                            <div class="text-sm font-medium whitespace-nowrap">
                                <span>{{ $product->rating_avg }}</span> <span class="text-slate-400 dark:text-slate-500">({{ $product->reviews_count }})</span>
                            </div>
                        </div>
                        <!-- Price -->
                        <div class="flex items-center space-x-2">
                            @if ($product->active_discount)
                                <div class="inline-flex text-sm font-medium bg-green-100 dark:bg-green-500/30 text-green-500 dark:text-green-400 rounded-full text-center px-2 py-0.5">{{ currency($product->active_discount->new_price) }}</div>
                                <div class="inline-flex text-sm font-medium text-red-500 dark:text-red-400 line-through">{{ currency($product->price) }}</div>
                            @else
                                <div class="inline-flex text-sm font-medium bg-green-100 dark:bg-green-500/30 text-green-500 dark:text-green-400 rounded-full text-center px-2 py-0.5">{{ currency($product->price) }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Card footer -->
                <div>
                    <a wire:navigate href="{{ route('admin.products.edit', $product->id) }}" class="btn-sm w-full bg-indigo-500 hover:bg-indigo-600 text-white">
                        {{ __('Edit') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
