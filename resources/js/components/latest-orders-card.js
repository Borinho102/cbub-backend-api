
// Import utilities
import { formatValue, formatThousands } from '../utils';

const latestOrdersCard = () => {
  const ctx = document.getElementById('latest-orders');
  if (!ctx) return;

  const darkMode = localStorage.getItem('dark-mode') === 'true';

  fetch('/miscellaneous/statistics/5')
    .then(a => {
      return a.json();
    })
    .then(response => {
        let html = `
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-slate-300">
                    <!-- Table header -->
                    <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/20 border border-slate-100 dark:border-slate-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <div class="font-semibold text-left">Order Reference</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Customer</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold">Amount</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Payment Status</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Date</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
        `
        response.orders.forEach(order => {
            html += `
                <tr>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-medium text-slate-800 dark:text-slate-100">${ order.order_id }</div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 shrink-0 mr-2 sm:mr-3">
                                <img class="rounded-full h-full w-full object-cover" src="${ order.customer.image }" alt="${ order.customer.name }" />
                            </div>
                            <div class="font-medium text-slate-800 dark:text-slate-100">${ order.customer.name }</div>
                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="text-left">${ formatValue(order.amount, order.currency) }</div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="text-left">pending payment</div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="text-center">${order.date}</div>
                    </td>
                </tr>
            `
        });

        html += '</tbody></table></div>'
        ctx.innerHTML = html
    });
};

export default latestOrdersCard;
