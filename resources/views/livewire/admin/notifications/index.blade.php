<div class="px-4 sm:px-6 lg:px-8 py-4 w-full max-w-9xl mx-auto">
    <div>
        <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
            {{ __('Notifications') }}
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
                    <a class="text-indigo-500 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-500" href="#">{{ __('Notifications') }}</a>
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
            <a wire:navigate href="{{ route('admin.notifications.create') }}" class="px-4 py-1.5 rounded cursor-pointer bg-indigo-500 hover:bg-indigo-600 text-white">{{ __('New Notification') }}</a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('All Notifications') }} <span class="text-slate-400 dark:text-slate-500 font-medium">{{ $count }}</span></h2>
        </header>

        <div x-data="handleSelect">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-slate-300">
                    <!-- Table header -->
                    <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/20 border-t border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">{{ __('Title') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">{{ __('Body') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">{{ __('Type') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">{{ __('Shop') }}</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span class="font-semibold text-center">{{ __('Created On') }}</span>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span class="font-semibold text-center">{{ __('Dispatch On') }}</span>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <span class="sr-only">Menu</span>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700" x-data="{ open: false }">
                        @foreach ($notifications as $notification)
                            <tr>
                                <td class="px-2 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center">{{ $notification->title }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-wrap">
                                    <div class="text-center">{{ substr($notification->body, 0, 70) }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center font-medium text-sky-500">
                                        <div class="text-xs inline-flex font-medium rounded-md text-center px-2.5 py-1 {{ randomBadgeColor() }}">
                                            {{ \App\Enums\NotificationType::getDescription($notification->type) }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center">{{ $notification->shop?->name }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center">{{ $notification->created_at?->format('d M Y') }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if ($notification->broadcast_at)
                                        @if ($notification->broadcast_at->isPast())
                                            <div class="text-center">{{ $notification->broadcast_at->format('d M Y') }}</div>
                                        @else
                                            <div class="text-center">
                                                <x-badge-status status="pending" label="{{ 'To be broadcast in ' . now()->diffInDays($notification->broadcast_at) . ' days' }}" />
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center">
                                        <button
                                            class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 transform"
                                            :class="{ 'rotate-180': open }"
                                            @click.prevent="open = !open"
                                            :aria-expanded="open"
                                            aria-controls="description-{{ $notification->id }}"
                                        >
                                            <span class="sr-only">Menu</span>
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                <path d="M16 20l-5.4-5.4 1.4-1.4 4 4 4-4 1.4 1.4z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr id="description-{{ $notification->id }}" role="region" x-show="open" x-cloak>
                                <td colspan="10" class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div class="flex items-center bg-slate-50 dark:bg-slate-900/30 dark:text-slate-400 p-3 mt-2">
                                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-slate-500 mr-2">
                                            <path d="M1 16h3c.3 0 .5-.1.7-.3l11-11c.4-.4.4-1 0-1.4l-3-3c-.4-.4-1-.4-1.4 0l-11 11c-.2.2-.3.4-.3.7v3c0 .6.4 1 1 1zm1-3.6l10-10L13.6 4l-10 10H2v-1.6z" />
                                        </svg>
                                        <div class="italic">{{ $notification->body }}</div>
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
        {{ $notifications->links() }}
    </div>
</div>
