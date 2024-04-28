
// Import utilities
import { tailwindConfig, formatValue, formatThousands, hexToRGB } from '../utils';

const topCustomersCard = () => {
  const ctx = document.getElementById('customers-statistics');
  if (!ctx) return;

  const darkMode = localStorage.getItem('dark-mode') === 'true';

  fetch('/secure.portal.99/console/statistics/3')
    .then(a => {
      return a.json();
    })
    .then(response => {
        let html = '<ul class="space-y-1 text-sm text-slate-800 dark:text-slate-100 mt-3 mb-4">'
        response.data.forEach(data => {
            html += `
                <li class="relative px-2 py-1">
                    <div class="absolute inset-0" aria-hidden="true"></div>
                    <div class="relative flex justify-between space-x-2">
                        <div class="flex flex-row flex-nowrap items-center">
                            <img class="h-8 w-8 rounded-full mr-2" src="${data.customer.image}" />
                            <div>
                                <div class="line-clamp-1 text-sm text-gray-600 font-semibold">${data.customer.name}</div>
                                <div class="text-xs text-gray-600 font-medium">${formatThousands(data.total_orders)} Orders</div>
                            </div>
                        </div>
                        <div class="font-medium text-sm">${formatValue(data.total_amount)}</div>
                    </div>
                </li>
            `
        });
        html += '</ul>'
        ctx.innerHTML = html
    });
};

export default topCustomersCard;
