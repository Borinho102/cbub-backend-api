<div class="flex flex-row justify-between items-end flex-nowrap col-span-full sm:col-span-6 xl:col-span-4 bg-amber-50 dark:bg-slate-800 shadow-lg rounded-sm border border-amber-50 dark:border-slate-700">
    <header class="w-1/3 flex justify-between items-start p-4">
        <div>
            <h2 class="text-3xl font-semibold text-slate-800 dark:text-slate-100 mb-2" id="total-orders-count"></h2>
            <div class="text-xs font-bold text-slate-500 dark:text-slate-500 uppercase mb-1">New Orders</div>
            <div class="flex flex-col items-start">
                <div class="text-xl font-bold text-slate-800 dark:text-slate-100 mr-2" id="new-orders-percentage-diff"></div>
                <div class="text-xs font-bold text-slate-500 dark:text-slate-500">This Week</div>
            </div>
        </div>
    </header>
    <!-- Chart built with Chart.js 3 -->
    <!-- Check out src/js/components/total-sales-card.js for config -->
    <div class="w-2/3 max-sm:max-h-[100px] xl:max-h-[100px] mb-2">
        <!-- Change the height attribute to adjust the chart height -->
        <canvas id="new-orders-chart" height="100"></canvas>
    </div>
</div>
