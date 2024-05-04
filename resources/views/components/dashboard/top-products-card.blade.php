<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('Top Products') }}</h2>
    </header>
    <div class="grow px-3">
        <div class="flex flex-col h-full">
            <!-- Card content -->
            <div class="grow min-h-72" id="product-statistics">
                <div class="h-full flex flex-col justify-center items-center text-indigo-600">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Loading...</span>
                </div>
            </div>
            <!-- Card footer -->
            <div class="text-center pt-4 pb-1 border-t border-slate-100 dark:border-slate-700">
                <a class="text-sm font-medium text-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400" href="#0">Products Report -&gt;</a>
            </div>
        </div>
    </div>
</div>
