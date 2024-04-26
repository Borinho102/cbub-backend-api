
// Import utilities
import { formatValue } from '../utils';

const topCategoriesCard = () => {
  const ctx = document.getElementById('business-statistics');
  if (!ctx) return;
  const darkMode = localStorage.getItem('dark-mode') === 'true';

  fetch('/secure.portal.99/console/statistics/1')
    .then(a => {
      return a.json();
    })
    .then(response => {
        let html = ''
        response.data.forEach(data => {
            html += `
                <li class="relative px-2 py-1">
                    <div class="absolute inset-0" aria-hidden="true"></div>
                    <div class="relative flex justify-between space-x-2">
                        <div class="flex flex-row flex-nowrap items-center">
                            <img class="h-6 w-6 rounded-full mr-2" src="${data.business.logo}" />
                            <div>
                                <div class="line-clamp-1 text-sm text-gray-600 font-semibold">${data.business.name}</div>
                                <div class="text-xs text-gray-600 font-medium">${data.total_orders} Orders</div>
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

export default topCategoriesCard;
