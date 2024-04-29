<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">{{ __('Product Reviews ✨') }}</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Delete button -->
            <x-actions.delete-button />

            <!-- Dropdown -->
            <x-date-select />

            <!-- Filter button -->
            <x-dropdown-filter align="right" />
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('All Reviews') }} <span class="text-slate-400 dark:text-slate-500 font-medium">{{ $count }}</span></h2>
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
                                <div class="font-semibold text-left">{{ __('Customer') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Rating') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">{{ __('Published?') }}</div>
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
                        @foreach ($product_reviews as $review)
                            <tbody class="text-sm" x-data="{ open: false }">
                                <!-- Row -->
                                <tr wire:key="product-review-{{ $review->id }}">
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
                                                <img class="rounded-full h-full w-full object-cover" src="{{ $review->reviewable->thumbnail }}" alt="{{ $review->reviewable->name }}" />
                                            </div>
                                            <div class="font-medium text-slate-800 dark:text-slate-100">{{ $review->reviewable->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                                <img class="rounded-full h-full w-full object-cover" src="{{ $review->user->image }}" alt="{{ $review->user->name }}" />
                                            </div>
                                            <div class="font-medium text-slate-800 dark:text-slate-100">{{ $review->user->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex space-x-1">
                                            @for ($i = 1; $i <= $review->rating; $i++)
                                                <button>
                                                    <span class="sr-only">{{ $i }} star</span>
                                                    <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                                        <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                    </svg>
                                                </button>
                                            @endfor
                                            @for ($i = 1; $i <= 5 - $review->rating; $i++)
                                                <button>
                                                    <span class="sr-only">{{ $i }} star</span>
                                                    <svg class="w-4 h-4 fill-current text-slate-300 dark:text-slate-600" viewBox="0 0 16 16">
                                                        <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                                    </svg>
                                                </button>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <x-toggle id="product-review-toggle-{{ $review->id }}" :checked="$review->published == 1" wire:change="toggleStatus({{ $review->id }})" primary xl />
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-center">{{ $review->created_at->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center">
                                            <button
                                                class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 transform"
                                                :class="{ 'rotate-180': open }"
                                                @click.prevent="open = !open"
                                                :aria-expanded="open"
                                                aria-controls="description-{{ $review->id }}"
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
                                <tr id="description-{{ $review->id }}" role="region" x-show="open" x-cloak>
                                    <td colspan="10" class="px-2 first:pl-5 last:pr-5 py-3">
                                        <div class="flex items-center bg-slate-50 dark:bg-slate-900/30 dark:text-slate-400 p-3 -mt-3">
                                            <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-slate-500 mr-2">
                                                <path d="M1 16h3c.3 0 .5-.1.7-.3l11-11c.4-.4.4-1 0-1.4l-3-3c-.4-.4-1-.4-1.4 0l-11 11c-.2.2-.3.4-.3.7v3c0 .6.4 1 1 1zm1-3.6l10-10L13.6 4l-10 10H2v-1.6z" />
                                            </svg>
                                            <div class="italic">{{ $review->title }} | {{ $review->body }}</div>
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
        {{ $product_reviews->links() }}
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
