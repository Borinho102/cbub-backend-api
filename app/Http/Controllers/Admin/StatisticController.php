<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DashboardStatisticType;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $type)
    {
        switch ($type) {
            case DashboardStatisticType::TopShopCard:
                $statistics = OrderItem::query()
                    ->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount, shop_id')
                    ->with('shop:id,name')
                    ->orderBy('total_amount', 'desc')
                    ->groupBy('business_id')
                    ->get()
                    ->take(6);
                $total_orders = array_sum(array_column($statistics->all(), 'total_orders'));
                $total_amount = array_sum(array_column($statistics->all(), 'total_amount'));
                return response([
                    'data' => $statistics->transform(function ($statistic) use ($total_amount) {
                        return [
                            ...$statistic->toArray(),
                            'total_amount' => $statistic->total_amount,
                            'percentage' => round(($statistic->total_amount / $total_amount) * 100, 0),
                            'shop' => [
                                'name' => $statistic->shop->name,
                                'logo' => $statistic->shop->logo
                            ]
                        ];
                    }),
                    'total_amount' => $total_amount,
                    'total_count' => $total_orders
                ]);
            case DashboardStatisticType::TopProductCard:
                $statistics = OrderItem::query()
                    ->selectRaw('count(quantity) as total_sales, sum(total_amount) as total_amount, item_id, item_type')
                    ->with('item:id,name')
                    ->orderBy('total_amount', 'desc')
                    ->groupBy('item_id')
                    ->get()
                    ->take(5);
                $total_sales = array_sum(array_column($statistics->all(), 'total_sales'));
                $total_amount = array_sum(array_column($statistics->all(), 'total_amount'));
                return response([
                    'data' => $statistics->transform(function ($statistic) use ($total_amount) {
                        return [
                            ...collect($statistic)->except('item_id', 'item', 'item_type', 'total_amount')->all(),
                            'total_amount' => $statistic->total_amount,
                            'percentage' => round(($statistic->total_amount / $total_amount) * 100, 0),
                            'product' => [
                                'name' => $statistic->item->name,
                                'thumbnail' => $statistic->item->thumbnail
                            ]
                        ];
                    }),
                    'total_amount' => $total_amount,
                    'total_count' => $total_sales
                ]);
            case DashboardStatisticType::TopCustomerCard:
                $statistics = Order::query()
                    ->selectRaw('count(id) as total_orders, sum(amount) as total_amount, customer_id, customer_type')
                    ->with('customer.country')
                    ->orderBy('total_amount', 'desc')
                    ->groupBy('customer_id')
                    ->get()
                    ->take(5);
                $total_orders = array_sum(array_column($statistics->all(), 'total_orders'));
                $total_amount = array_sum(array_column($statistics->all(), 'total_amount'));
                return response([
                    'data' => $statistics->transform(function ($statistic) use ($total_amount) {
                        return [
                            ...collect($statistic)->except('customer_id', 'customer', 'customer_type', 'total_amount')->all(),
                            'total_amount' => $statistic->total_amount,
                            'percentage' => round(($statistic->total_amount / $total_amount) * 100, 0),
                            'customer' => [
                                'name' => $statistic->customer->name . ' ' . $statistic->customer->country->emoji,
                                'image' => $statistic->customer->image
                            ]
                        ];
                    }),
                    'total_amount' => $total_amount,
                    'total_count' => $total_orders
                ]);
            case DashboardStatisticType::TotalSalesThisWeek:
                $last_week_amount = Order::query()
                    ->whereBetween('created_at', [now()->subMonth(2), now()->subMonth()])
                    ->sum('amount') ?? 0;

                $statistics = Order::query()
                    ->selectRaw('count(id) as total_orders, sum(amount) as total_amount, customer_id, customer_type, created_at')
                    ->whereBetween('created_at', [now()->subMonth(), now()])
                    ->orderBy('created_at', 'asc')
                    ->groupBy('created_at')
                    ->get();
                $total_orders = array_sum(array_column($statistics->all(), 'total_orders'));
                $total_amount = array_sum(array_column($statistics->all(), 'total_amount'));
                $labels = array_column($statistics->all(), 'created_at');
                $percentage_difference = $last_week_amount == 0 ? 100 : (($total_amount - $last_week_amount) / $last_week_amount) * 100;

                return response([
                    'data' => $statistics->transform(function ($statistic) {
                        return (float) $statistic->total_amount;
                    })->take(7),
                    'labels' => collect($labels)->transform(function ($label) {
                        return Carbon::parse($label)->format('m-d-Y');
                    })->take(7),
                    'total_amount' => $total_amount,
                    'total_count' => $total_orders,
                    'percentage_difference' => $percentage_difference > 0 ?
                        '+' . $percentage_difference . '%' :
                        '-' . $percentage_difference . '%'
                ]);
            case DashboardStatisticType::NewOrdersThisWeek:
                $last_week_orders = Order::query()
                    ->whereBetween('created_at', [now()->subMonth(2), now()->subMonth()])
                    ->sum('amount') ?? 0;

                $statistics = Order::query()
                    ->selectRaw('count(id) as total_orders, customer_id, customer_type, created_at')
                    ->whereBetween('created_at', [now()->subMonth(), now()])
                    ->orderBy('created_at', 'asc')
                    ->groupBy('created_at')
                    ->get();
                $total_orders = array_sum(array_column($statistics->all(), 'total_orders'));
                $labels = array_column($statistics->all(), 'created_at');
                $percentage_difference = $last_week_orders == 0 ? 100 : (($total_orders - $last_week_orders) / $last_week_orders) * 100;

                return response([
                    'data' => $statistics->transform(function ($statistic) {
                        return (float) $statistic->total_orders;
                    })->take(7),
                    'labels' => collect($labels)->transform(function ($label) {
                        return Carbon::parse($label)->format('m-d-Y');
                    })->take(7),
                    'total_count' => $total_orders,
                    'percentage_difference' => $percentage_difference > 0 ?
                        '+' . $percentage_difference . '%' :
                        '-' . $percentage_difference . '%'
                ]);
            case DashboardStatisticType::NewCustomersThisWeek:
                $statistics = Order::query()
                    ->selectRaw('count(distinct(customer_id)) as total_count, created_at')
                    ->whereHas('customer', function ($q) {
                        $q->whereDoesntHave('orders', function ($q) {
                            $q->where('created_at', '<', now()->subMonth(2));
                        })
                        ->whereHas('orders', function ($q) {
                            $q->whereBetween('created_at', [now()->subMonth(), now()]);
                        });
                    })
                    ->orderBy('created_at', 'asc')
                    ->groupBy('created_at')
                    ->get();
                $total_customers = array_sum(array_column($statistics->all(), 'total_count'));
                $labels = array_column($statistics->all(), 'created_at');

                return response([
                    'data' => $statistics->transform(function ($statistic) {
                        return (float) $statistic->total_count;
                    })->take(7),
                    'labels' => collect($labels)->transform(function ($label) {
                        return Carbon::parse($label)->format('m-d-Y');
                    })->take(7),
                    'total_count' => $total_customers
                ]);
            case DashboardStatisticType::LatestOrderCard:
                return response([
                    'orders' => Order::latest()
                        ->with('customer.country')
                        ->limit(5)
                        ->get()
                        ->transform(function ($order) {
                            return [
                                'order_id' => $order->order_id,
                                'amount' => $order->amount,
                                'currency' => $order->currency,
                                'customer' => [
                                    'name' => $order->customer->name,
                                    'image' => $order->customer->image
                                ],
                                'date' => $order->created_at->format('d/m/Y')
                            ];
                        })
                ]);
            case DashboardStatisticType::TopBusinessChart:
                $period = request('period', 'monthly');
                $topBusinesses = OrderItem::query()
                    ->join('businesses', 'order_items.business_id', '=', 'businesses.id')
                    ->select(
                        'businesses.name as business_name',
                        DB::raw('count(distinct(order_items.order_id)) as orders_count'),
                        DB::raw('sum(order_items.total_amount) as total_amount')
                    )
                    ->when($period == 'weekly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount, business_id')
                            ->whereBetween('order_items.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    })
                    ->when($period == 'monthly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount, business_id')
                            ->whereRaw("year(order_items.created_at) = ?", [request('year', now()->year)]);
                    })
                    ->when($period == 'yearly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount, business_id')
                            ->whereRaw("year(order_items.created_at) <= ?", [request('year', now()->year)]);
                    })
                    ->groupBy('business_id')
                    ->orderByDesc('total_amount')
                    ->orderByDesc('orders_count')
                    ->limit(request('limit', 5))
                    ->get();

                $data = [];
                $labels = [];
                if ($period == 'weekly') {
                    $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                } else if ($period == 'monthly') {
                    $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                }
                $count = $period == 'weekly' ? 7 : ($period == 'monthly' ? 12 : 0);

                foreach ($topBusinesses as $key => $business) {
                    $items = OrderItem::query()
                        ->select(
                            DB::raw('count(distinct(order_items.order_id)) as orders_count'),
                            DB::raw('sum(order_items.total_amount) as total_amount')
                        )
                        ->where('business_id', $business->business_id)
                        ->when($period == 'weekly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount, business_id, DAY(order_items.created_at) as day')
                                ->whereBetween('order_items.created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                ->orderBy('day');
                        })
                        ->when($period == 'monthly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount, business_id, month(order_items.created_at) as month')
                                ->whereRaw("year(order_items.created_at) = ?", [request('year', now()->year)])
                                ->orderBy('month');
                        })
                        ->when($period == 'yearly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount, business_id, year(order_items.created_at) as year')
                                ->whereRaw("year(order_items.created_at) <= ?", [request('year', now()->year)])
                                ->orderBy('year');
                        })
                        ->groupBy($period == 'weekly' ?
                            'day' : ($period == 'monthly' ? 'month' : 'year')
                        )
                        ->get();

                    $data[$key] = [
                        'label' => $business->business_name,
                        'data' => array_fill(0, $count, 0),
                        'fill' => true,
                        'borderWidth' => 2,
                        'tension' => 0,
                        'pointRadius' => 0,
                        'pointHoverRadius' => 3,
                        'pointBorderWidth' => 0,
                        'pointHoverBorderWidth' => 0,
                        'clip' => 20
                    ];

                    foreach ($items as $item) {
                        if ($period == 'monthly') {
                            $data[$key]['data'][$item->month - 1] = (float) $item->total_amount;
                        } else if ($period == 'yearly') {
                            $data[$key]['data'][] = $item->total_amount;
                            $labels[] = $item->year;
                        } else if ($period == 'weekly') {
                            $dayOfWeek = idate('w', $item->created_at->timestamp);
                            $data[$key]['data'][$dayOfWeek == 0 ? 6 : $dayOfWeek - 1] = $item->total_amount;
                        }
                    }
                }

                return response([
                    'labels' => $labels,
                    'datatsets' => $data
                ]);
            default:
                abort(404);
        }
    }
}
