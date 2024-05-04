// Import Chart.js
import {
  Chart, LineController, LineElement, Filler, PointElement, LinearScale, TimeScale, Tooltip,
} from 'chart.js';
import 'chartjs-adapter-moment';

// Import utilities
import { tailwindConfig, formatValue, hexToRGB } from '../utils';

Chart.register(LineController, LineElement, Filler, PointElement, LinearScale, TimeScale, Tooltip);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const totalSalesCard = () => {
    const ctx = document.getElementById('total-sales-chart');
    if (!ctx) return;

    const darkMode = localStorage.getItem('dark-mode') === 'true';

    const chartAreaBg = {
        light: '#f8fafc',
        dark: `rgba(${hexToRGB('#0F172A')}, 0.24)`
    };

    const tooltipBodyColor = {
        light: '#1e293b',
        dark: '#f1f5f9'
    };

    const tooltipBgColor = {
        light: '#ffffff',
        dark: '#334155'
    };

    const tooltipBorderColor = {
        light: '#e2e8f0',
        dark: '#475569'
    };

    fetch('/miscellaneous/statistics/6')
        .then(a => {
            return a.json();
        })
        .then(response => {
            const countElt = document.getElementById('total-sales-amount');
            if (countElt) {
                countElt.textContent = formatValue(response.total_amount);
            }

            const percentageElt = document.getElementById('total-sales-percentage-diff');
            if (percentageElt) {
                percentageElt.textContent = response.percentage_difference
            }

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.labels,
                    datasets: [
                        {
                            data: response.data,
                            fill: true,
                            backgroundColor: `rgba(${hexToRGB(tailwindConfig().theme.colors.green[50])}, 1)`,
                            borderColor: tailwindConfig().theme.colors.green[500],
                            borderWidth: 2,
                            tension: 0.2,
                            pointRadius: 0,
                            pointHoverRadius: 3,
                            pointBackgroundColor: tailwindConfig().theme.colors.green[500],
                            pointHoverBackgroundColor: tailwindConfig().theme.colors.green[500],
                            pointBorderWidth: 0,
                            pointHoverBorderWidth: 0,
                            clip: 20,
                        }
                    ],
                },
                options: {
                    layout: {
                      padding: 20,
                    },
                    scales: {
                      y: {
                        display: false,
                        beginAtZero: true,
                      },
                      x: {
                        type: 'time',
                        time: {
                            parser: 'MM-DD-YYYY',
                            unit: 'month',
                        },
                        display: false,
                      },
                    },
                    plugins: {
                      tooltip: {
                        callbacks: {
                          title: () => false, // Disable tooltip title
                          label: (context) => formatValue(context.parsed.y),
                        },
                        bodyColor: darkMode ? tooltipBodyColor.dark : tooltipBodyColor.light,
                        backgroundColor: darkMode ? tooltipBgColor.dark : tooltipBgColor.light,
                        borderColor: darkMode ? tooltipBorderColor.dark : tooltipBorderColor.light,
                      },
                      legend: {
                        display: false,
                      },
                    },
                    interaction: {
                      intersect: false,
                      mode: 'nearest',
                    },
                    maintainAspectRatio: false,
                },
            });

            document.addEventListener('darkMode', (e) => {
                const { mode } = e.detail;
                if (mode === 'on') {
                    chart.options.chartArea.backgroundColor = chartAreaBg.dark;
                    chart.options.plugins.tooltip.bodyColor = tooltipBodyColor.dark;
                    chart.options.plugins.tooltip.backgroundColor = tooltipBgColor.dark;
                    chart.options.plugins.tooltip.borderColor = tooltipBorderColor.dark;
                } else {
                    chart.options.chartArea.backgroundColor = chartAreaBg.light;
                    chart.options.plugins.tooltip.bodyColor = tooltipBodyColor.light;
                    chart.options.plugins.tooltip.backgroundColor = tooltipBgColor.light;
                    chart.options.plugins.tooltip.borderColor = tooltipBorderColor.light;
                }
                chart.update('none');
            });
        });
};

export default totalSalesCard;
