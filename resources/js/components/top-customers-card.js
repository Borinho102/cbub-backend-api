
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
        console.log(response)
        let html = ''
        response.data.forEach(data => {
            html += `
                <li class="relative px-2 py-1">
                    <div class="absolute inset-0" aria-hidden="true"></div>
                    <div class="relative flex justify-between space-x-2">
                        <div class="flex flex-row flex-nowrap items-center">
                            <img class="h-6 w-6 rounded-full mr-2" src="${data.customer.profile_picture}" />
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

        ctx.innerHTML = html
    });
};

export default topCustomersCard;
