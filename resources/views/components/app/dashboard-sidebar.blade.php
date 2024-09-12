<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div
        class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        x-cloak
    ></div>

    <!-- Sidebar -->
    <div
        id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto max-lg:-translate-x-64 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'"
        @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false"
    >
        @if (appGuard() === 'admins')
            <!-- Sidebar header -->
            <div class="flex justify-between mb-10 pr-3 sm:px-2">
                <!-- Close button -->
                <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                    </svg>
                </button>
                <!-- Logo -->
                <a class="block shrink-0 bg-white rounded-full w-10 h-10 sidebar-expanded:w-14 sidebar-expanded:h-14" wire:navigate
                    href="{{ route('admin.dashboard') }}"
                >
                    <img
                        src="{{ asset('images/logo.png') }}"
                        class="flex-shrink-0 w-10 h-10 sidebar-expanded:w-14 sidebar-expanded:h-14" alt="cbub's logo"
                    >
                </a>
            </div>

            <!-- Links -->
            <div class="space-y-8">
                <!-- Pages group -->
                <div>
                    <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                    </h3>
                    <ul class="mt-3">
                        <!-- Dashboard -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(Route::is('admin.dashboard')){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(Route::is('admin.dashboard')){{ 'hover:text-slate-200' }}@endif" href="{{ route('admin.dashboard') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(Route::is('admin.dashboard')){{ 'text-indigo-500' }}@else{{ 'text-slate-400' }}@endif" d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                        <path class="fill-current @if(Route::is('admin.dashboard')){{ 'text-indigo-600' }}@else{{ 'text-slate-600' }}@endif" d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                        <path class="fill-current @if(Route::is('admin.dashboard')){{ 'text-indigo-200' }}@else{{ 'text-slate-400' }}@endif" d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Dashboard') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['businesses'])){{ 'bg-slate-900' }}@endif" x-data="{ open: {{ in_array(Request::segment(3), ['businesses']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['businesses'])){{ 'hover:text-slate-200' }}@endif" href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['businesses'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Business</span>
                                    </div>
                                    <!-- Icon -->
                                    <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(3), ['businesses'])){{ 'rotate-180' }}@endif" :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-9 mt-1 @if(!in_array(Request::segment(3), ['businesses'])){{ 'hidden' }}@endif" :class="open ? '!block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a
                                            class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is(['admin.businesses.index', 'admin.businesses.create', 'admin.businesses.edit'])){{ '!text-indigo-500' }}@endif"
                                            wire:navigate
                                            href="{{ route('admin.businesses.index') }}"
                                        >
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Business List</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a
                                            class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is(['admin.businesses.categories.index', 'admin.businesses.categories.create', 'admin.businesses.categories.edit'])){{ '!text-indigo-500' }}@endif"
                                            wire:navigate
                                            href="{{ route('admin.businesses.categories.index') }}"
                                        >
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Business Categories</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- Shops -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['shops'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['shops'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('admin.shops.index') }}">
                                <div class="flex items-center">
                                    <svg stroke="currentColor" class="shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['shops'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M15.75 10.5V6C15.75 3.92893 14.0711 2.25 12 2.25C9.92893 2.25 8.25 3.92893 8.25 6V10.5M19.606 8.50723L20.8692 20.5072C20.9391 21.1715 20.4183 21.75 19.7504 21.75H4.24963C3.58172 21.75 3.06089 21.1715 3.13081 20.5072L4.39397 8.50723C4.45424 7.93466 4.93706 7.5 5.51279 7.5H18.4872C19.0629 7.5 19.5458 7.93466 19.606 8.50723ZM8.625 10.5C8.625 10.7071 8.4571 10.875 8.25 10.875C8.04289 10.875 7.875 10.7071 7.875 10.5C7.875 10.2929 8.04289 10.125 8.25 10.125C8.4571 10.125 8.625 10.2929 8.625 10.5ZM16.125 10.5C16.125 10.7071 15.9571 10.875 15.75 10.875C15.5429 10.875 15.375 10.7071 15.375 10.5C15.375 10.2929 15.5429 10.125 15.75 10.125C15.9571 10.125 16.125 10.2929 16.125 10.5Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Shops') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Product -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['products'])){{ 'bg-slate-900' }}@endif" x-data="{ open: {{ in_array(Request::segment(3), ['products']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['products'])){{ 'hover:text-slate-200' }}@endif" href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 @if(in_array(Request::segment(3), ['products'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Products</span>
                                    </div>

                                    <!-- Icon -->
                                    <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(3), ['products'])){{ 'rotate-180' }}@endif" :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-9 mt-1 @if(!in_array(Request::segment(3), ['products'])){{ 'hidden' }}@endif" :class="open ? '!block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('admin.products.index')){{ '!text-indigo-500' }}@endif" wire:navigate href="{{ route('admin.products.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product List</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is(['admin.products.categories.index', 'admin.products.categories.create', 'admin.products.categories.edit'])){{ '!text-indigo-500' }}@endif" href="{{ route('admin.products.categories.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product Categories</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('admin.products.discounts.index')){{ '!text-indigo-500' }}@endif" href="{{ route('admin.products.discounts.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Discounts</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('admin.products.reviews.index')){{ '!text-indigo-500' }}@endif" href="{{ route('admin.products.reviews.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reviews</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('admin.products.stocks.index')){{ '!text-indigo-500' }}@endif" href="{{ route('admin.products.stocks.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Stocks</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- Orders -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['orders'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['orders'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('admin.orders.index') }}">
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['orders'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M2.25 3H3.63568C4.14537 3 4.59138 3.34265 4.7227 3.83513L5.1059 5.27209M7.5 14.25C5.84315 14.25 4.5 15.5931 4.5 17.25H20.25M7.5 14.25H18.7183C19.8394 11.9494 20.8177 9.56635 21.6417 7.1125C16.88 5.89646 11.8905 5.25 6.75 5.25C6.20021 5.25 5.65214 5.2574 5.1059 5.27209M7.5 14.25L5.1059 5.27209M6 20.25C6 20.6642 5.66421 21 5.25 21C4.83579 21 4.5 20.6642 4.5 20.25C4.5 19.8358 4.83579 19.5 5.25 19.5C5.66421 19.5 6 19.8358 6 20.25ZM18.75 20.25C18.75 20.6642 18.4142 21 18 21C17.5858 21 17.25 20.6642 17.25 20.25C17.25 19.8358 17.5858 19.5 18 19.5C18.4142 19.5 18.75 19.8358 18.75 20.25Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Orders') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Customers -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['customers'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['customers'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('admin.customers.index') }}">
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['customers'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M15 19.1276C15.8329 19.37 16.7138 19.5 17.625 19.5C19.1037 19.5 20.5025 19.1576 21.7464 18.5478C21.7488 18.4905 21.75 18.4329 21.75 18.375C21.75 16.0968 19.9031 14.25 17.625 14.25C16.2069 14.25 14.956 14.9655 14.2136 16.0552M15 19.1276V19.125C15 18.0121 14.7148 16.9658 14.2136 16.0552M15 19.1276C15 19.1632 14.9997 19.1988 14.9991 19.2343C13.1374 20.3552 10.9565 21 8.625 21C6.29353 21 4.11264 20.3552 2.25092 19.2343C2.25031 19.198 2.25 19.1615 2.25 19.125C2.25 15.6042 5.10418 12.75 8.625 12.75C11.0329 12.75 13.129 14.085 14.2136 16.0552M12 6.375C12 8.23896 10.489 9.75 8.625 9.75C6.76104 9.75 5.25 8.23896 5.25 6.375C5.25 4.51104 6.76104 3 8.625 3C10.489 3 12 4.51104 12 6.375ZM20.25 8.625C20.25 10.0747 19.0747 11.25 17.625 11.25C16.1753 11.25 15 10.0747 15 8.625C15 7.17525 16.1753 6 17.625 6C19.0747 6 20.25 7.17525 20.25 8.625Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Customers') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Promo Codes -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['promo-codes'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['promo-codes'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('admin.promo_codes.index') }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['promo-codes'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Promo Codes') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Users -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['admins'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['admins'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('admin.admins.index') }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['admins'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Users / Admins') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Roles & Permissions -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(7), ['rabc'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(7), ['rabc'])){{ 'hover:text-slate-200' }}@endif" href="/APP__/u/1/secure.portal.99/admin/control/rabc">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(7), ['rabc'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Roles & Permissions') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Notifications -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['notifications'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['notifications'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('admin.notifications.index') }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['notifications'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Notifications') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Settings -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['settings'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['settings'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('admin.settings', 'profile') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(3), ['settings'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M19.714 14.7l-7.007 7.007-1.414-1.414 7.007-7.007c-.195-.4-.298-.84-.3-1.286a3 3 0 113 3 2.969 2.969 0 01-1.286-.3z" />
                                        <path class="fill-current @if(in_array(Request::segment(3), ['settings'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M10.714 18.3c.4-.195.84-.298 1.286-.3a3 3 0 11-3 3c.002-.446.105-.885.3-1.286l-6.007-6.007 1.414-1.414 6.007 6.007z" />
                                        <path class="fill-current @if(in_array(Request::segment(3), ['settings'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M5.7 10.714c.195.4.298.84.3 1.286a3 3 0 11-3-3c.446.002.885.105 1.286.3l7.007-7.007 1.414 1.414L5.7 10.714z" />
                                        <path class="fill-current @if(in_array(Request::segment(3), ['settings'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M19.707 9.292a3.012 3.012 0 00-1.415 1.415L13.286 5.7c-.4.195-.84.298-1.286.3a3 3 0 113-3 2.969 2.969 0 01-.3 1.286l5.007 5.006z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Settings') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Horizon Dashboard -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150" wire:navigate href="/secure.portal.99/console/jobs/overview">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <circle class="fill-current text-slate-400" cx="18.5" cy="5.5" r="4.5" />
                                        <circle class="fill-current text-slate-600" cx="5.5" cy="5.5" r="4.5" />
                                        <circle class="fill-current text-slate-600" cx="18.5" cy="18.5" r="4.5" />
                                        <circle class="fill-current text-slate-400" cx="5.5" cy="18.5" r="4.5" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Queue & Jobs') }}</span>
                                </div>
                            </a>
                        </li>

                        {{-- <!-- Messages -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['messages'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['messages'])){{ 'hover:text-slate-200' }}@endif" href="{{ route('messages') }}">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <path class="fill-current @if(in_array(Request::segment(1), ['messages'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M14.5 7c4.695 0 8.5 3.184 8.5 7.111 0 1.597-.638 3.067-1.7 4.253V23l-4.108-2.148a10 10 0 01-2.692.37c-4.695 0-8.5-3.184-8.5-7.11C6 10.183 9.805 7 14.5 7z" />
                                            <path class="fill-current @if(in_array(Request::segment(1), ['messages'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M11 1C5.477 1 1 4.582 1 9c0 1.797.75 3.45 2 4.785V19l4.833-2.416C8.829 16.85 9.892 17 11 17c5.523 0 10-3.582 10-8s-4.477-8-10-8z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Messages</span>
                                    </div>
                                    <!-- Badge -->
                                    <div class="flex flex-shrink-0 ml-2">
                                        <span class="inline-flex items-center justify-center h-5 text-xs font-medium text-white bg-indigo-500 px-2 rounded">4</span>
                                    </div>
                                </div>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>

            <!-- Expand / collapse button -->
            <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
                <div class="px-3 py-2">
                    <button @click="sidebarExpanded = !sidebarExpanded">
                        <span class="sr-only">Expand / collapse sidebar</span>
                        <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                            <path class="text-slate-400" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                            <path class="text-slate-600" d="M3 23H1V1h2z" />
                        </svg>
                    </button>
                </div>
            </div>
        @elseif (appGuard() === 'business')
            <!-- Sidebar header -->
            <div class="flex justify-between mb-10 pr-3 sm:px-2">
                <!-- Close button -->
                <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                    </svg>
                </button>
                <!-- Logo -->
                <a class="block" wire:navigate href="{{ route('business.dashboard') }}">
                    <svg width="32" height="32" viewBox="0 0 32 32">
                        <defs>
                            <linearGradient x1="28.538%" y1="20.229%" x2="100%" y2="108.156%" id="logo-a">
                                <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                                <stop stop-color="#A5B4FC" offset="100%" />
                            </linearGradient>
                            <linearGradient x1="88.638%" y1="29.267%" x2="22.42%" y2="100%" id="logo-b">
                                <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                                <stop stop-color="#38BDF8" offset="100%" />
                            </linearGradient>
                        </defs>
                        <rect fill="#6366F1" width="32" height="32" rx="16" />
                        <path d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z" fill="#4F46E5" />
                        <path d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z" fill="url(#logo-a)" />
                        <path d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z" fill="url(#logo-b)" />
                    </svg>
                </a>
            </div>

            <!-- Links -->
            <div class="space-y-8">
                <!-- Pages group -->
                <div>
                    <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                    </h3>
                    <ul class="mt-3">
                        <!-- Dashboard -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(Route::is('business.dashboard')){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(Route::is('business.dashboard')){{ 'hover:text-slate-200' }}@endif" href="{{ route('business.dashboard') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(Route::is('business.dashboard')){{ 'text-indigo-500' }}@else{{ 'text-slate-400' }}@endif" d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                        <path class="fill-current @if(Route::is('business.dashboard')){{ 'text-indigo-600' }}@else{{ 'text-slate-600' }}@endif" d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                        <path class="fill-current @if(Route::is('business.dashboard')){{ 'text-indigo-200' }}@else{{ 'text-slate-400' }}@endif" d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Dashboard') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Shops -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['shops'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['shops'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('business.shops.index') }}">
                                <div class="flex items-center">
                                    <svg stroke="currentColor" class="shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['shops'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M15.75 10.5V6C15.75 3.92893 14.0711 2.25 12 2.25C9.92893 2.25 8.25 3.92893 8.25 6V10.5M19.606 8.50723L20.8692 20.5072C20.9391 21.1715 20.4183 21.75 19.7504 21.75H4.24963C3.58172 21.75 3.06089 21.1715 3.13081 20.5072L4.39397 8.50723C4.45424 7.93466 4.93706 7.5 5.51279 7.5H18.4872C19.0629 7.5 19.5458 7.93466 19.606 8.50723ZM8.625 10.5C8.625 10.7071 8.4571 10.875 8.25 10.875C8.04289 10.875 7.875 10.7071 7.875 10.5C7.875 10.2929 8.04289 10.125 8.25 10.125C8.4571 10.125 8.625 10.2929 8.625 10.5ZM16.125 10.5C16.125 10.7071 15.9571 10.875 15.75 10.875C15.5429 10.875 15.375 10.7071 15.375 10.5C15.375 10.2929 15.5429 10.125 15.75 10.125C15.9571 10.125 16.125 10.2929 16.125 10.5Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Shops') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Product -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['products'])){{ 'bg-slate-900' }}@endif" x-data="{ open: {{ in_array(Request::segment(3), ['products']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['products'])){{ 'hover:text-slate-200' }}@endif" href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['products'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Products</span>
                                    </div>

                                    <!-- Icon -->
                                    <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(3), ['products'])){{ 'rotate-180' }}@endif" :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-9 mt-1 @if(!in_array(Request::segment(3), ['products'])){{ 'hidden' }}@endif" :class="open ? '!block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('business.products.index')){{ '!text-indigo-500' }}@endif" wire:navigate href="{{ route('business.products.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product List</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is(['business.products.categories.index', 'business.products.categories.create', 'business.products.categories.edit'])){{ '!text-indigo-500' }}@endif" href="{{ route('business.products.categories.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product Categories</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('business.products.discounts.index')){{ '!text-indigo-500' }}@endif" href="{{ route('business.products.discounts.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Discounts</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('business.products.reviews.index')){{ '!text-indigo-500' }}@endif" href="{{ route('business.products.reviews.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reviews</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('business.products.stocks.index')){{ '!text-indigo-500' }}@endif" href="{{ route('business.products.stocks.index') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Stocks</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- Orders -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['orders'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['orders'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('business.orders.index') }}">
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['orders'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M2.25 3H3.63568C4.14537 3 4.59138 3.34265 4.7227 3.83513L5.1059 5.27209M7.5 14.25C5.84315 14.25 4.5 15.5931 4.5 17.25H20.25M7.5 14.25H18.7183C19.8394 11.9494 20.8177 9.56635 21.6417 7.1125C16.88 5.89646 11.8905 5.25 6.75 5.25C6.20021 5.25 5.65214 5.2574 5.1059 5.27209M7.5 14.25L5.1059 5.27209M6 20.25C6 20.6642 5.66421 21 5.25 21C4.83579 21 4.5 20.6642 4.5 20.25C4.5 19.8358 4.83579 19.5 5.25 19.5C5.66421 19.5 6 19.8358 6 20.25ZM18.75 20.25C18.75 20.6642 18.4142 21 18 21C17.5858 21 17.25 20.6642 17.25 20.25C17.25 19.8358 17.5858 19.5 18 19.5C18.4142 19.5 18.75 19.8358 18.75 20.25Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Orders') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Customers -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['customers'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['customers'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('business.customers.index') }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['customers'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Customers') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Promo Codes -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['promo-codes'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['promo-codes'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('business.promo_codes.index') }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['promo-codes'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Promo Codes') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Users -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['users'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['users'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('business.users.index') }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['users'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Users') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Notifications -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['notifications'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['notifications'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('business.notifications.index') }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-6 h-6 @if(in_array(Request::segment(3), ['notifications'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Notifications') }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- Settings -->
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(3), ['settings'])){{ 'bg-slate-900' }}@endif">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(3), ['settings'])){{ 'hover:text-slate-200' }}@endif" wire:navigate href="{{ route('business.settings', 'profile') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(3), ['settings'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M19.714 14.7l-7.007 7.007-1.414-1.414 7.007-7.007c-.195-.4-.298-.84-.3-1.286a3 3 0 113 3 2.969 2.969 0 01-1.286-.3z" />
                                        <path class="fill-current @if(in_array(Request::segment(3), ['settings'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M10.714 18.3c.4-.195.84-.298 1.286-.3a3 3 0 11-3 3c.002-.446.105-.885.3-1.286l-6.007-6.007 1.414-1.414 6.007 6.007z" />
                                        <path class="fill-current @if(in_array(Request::segment(3), ['settings'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M5.7 10.714c.195.4.298.84.3 1.286a3 3 0 11-3-3c.446.002.885.105 1.286.3l7.007-7.007 1.414 1.414L5.7 10.714z" />
                                        <path class="fill-current @if(in_array(Request::segment(3), ['settings'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M19.707 9.292a3.012 3.012 0 00-1.415 1.415L13.286 5.7c-.4.195-.84.298-1.286.3a3 3 0 113-3 2.969 2.969 0 01-.3 1.286l5.007 5.006z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ __('Settings') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Expand / collapse button -->
            <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
                <div class="px-3 py-2">
                    <button @click="sidebarExpanded = !sidebarExpanded">
                        <span class="sr-only">Expand / collapse sidebar</span>
                        <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                            <path class="text-slate-400" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                            <path class="text-slate-600" d="M3 23H1V1h2z" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
