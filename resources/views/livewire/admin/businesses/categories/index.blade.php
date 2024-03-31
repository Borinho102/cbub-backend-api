
<div background="bg-white dark:bg-slate-900">
    <!-- Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
                {{ __('Business Category') }}
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
                        <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#0">{{ __('Business Category List') }}</a>
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
                <a wire:navigate href="{{ route('admin.businesses.categories.create') }}" class="px-4 py-1.5 rounded cursor-pointer bg-indigo-500 hover:bg-indigo-600 text-white">{{ __('New Category') }}</a>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-900">
            <div x-data="handleSelect">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full dark:text-slate-300">
                        <!-- Table header -->
                        <thead class="text-xs font-semibold uppercase text-slate-500 border-t border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-start">{{ __('Name') }}</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-center">{{ __('Status') }}</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-center">{{ __('Businesses') }}</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-center">{{ __('Created At') }}</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-center">{{ __('Option') }}</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700 border-b border-slate-200 dark:border-slate-700">
                            <!-- Row -->
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-9 h-9 shrink-0 mr-2 sm:mr-3">
                                                <img class="w-9 h-9 rounded-full object-cover" src="{{ $category->logo }}" width="36" height="36" alt="{{ $category->name }}" />
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-800 dark:text-slate-100">{{ $category->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-center">
                                            @if ($category->is_active)
                                                <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-emerald-100 dark:bg-emerald-400/30 text-emerald-600 dark:text-emerald-400">{{ __('Active') }}</div>
                                            @else
                                                <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-amber-100 dark:bg-amber-400/30 text-amber-600 dark:text-amber-400">{{ __('Inactive') }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-center">{{ $category->businesses_count }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-center">{{ $category->created_at->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                        <div class="relative inline-flex" x-data="{ open: false }">
                                            <button class="inline-flex justify-center items-center group" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                                                <div class="flex items-center truncate">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                    </svg>
                                                </div>
                                            </button>
                                            <div
                                                class="origin-top-right z-10 absolute top-full left-0 min-w-44 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-1.5 rounded shadow-lg overflow-hidden mt-1"
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
                                                        <a class="font-medium text-sm text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-200 flex items-center py-1 px-3" wire:navigate href="{{ route('admin.businesses.categories.edit', $category->id) }}" @click="open = false" @focus="open = true" @focusout="open = false">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="font-medium text-sm text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-200 flex items-center py-1 px-3" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
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
            {{ $categories->links() }}
        </div>
    </div>
</div>
