<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="mb-8">
        <!-- Title -->
        <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Settings ✨</h1>
    </div>

    @if ($menu === 'profile')
        <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">
                <!-- Sidebar -->
                <x-settings.sidebar :active-menu="$menu" />

                <!-- Panel -->
                <x-settings.profile />

            </div>
        </div>
    @elseif ($menu === 'notifications')
        <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">
                <!-- Sidebar -->
                <x-settings.sidebar :active-menu="$menu" />

                <!-- Panel -->
                <x-settings.notifications />
            </div>
        </div>
    @elseif ($menu === 'change-password')
        <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">
                <!-- Sidebar -->
                <x-settings.sidebar :active-menu="$menu" />

                <!-- Panel -->
                <x-settings.change-password />
            </div>
        </div>
    @endif
</div>
