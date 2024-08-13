<header class="sticky top-0 bg-white dark:bg-[#182235] border-b border-slate-200 dark:border-slate-700 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">
            <!-- Header: Left side -->
            <div class="flex">
                <x-application-logo height="h-14" width="w-14" />
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">

                <!-- Divider -->
                <hr class="w-px h-6 bg-slate-200 dark:bg-slate-700 border-none" />

                <!-- User button -->
                <a class="inline-flex items-center justify-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white whitespace-nowrap rounded" wire:navigate href="{{ route('guest.business.login') }}">{{ __('Login') }}</a>
            </div>
        </div>
    </div>
</header>
