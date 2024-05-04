<?php

namespace App\Http\Controllers;

use App\Enums\DashboardStatisticType;
use App\Enums\ModelAccessAction;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ModelAccessLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
        $guard = appGuard();
        $user = auth($guard)->user();

        switch ($type) {
            case DashboardStatisticType::TopShopCard:
                $statistics = OrderItem::query()
                    ->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, shop_id')
                    ->with('shop:id,name')
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
                    ->orderBy('total_amount_', 'desc')
                    ->groupBy('business_id')
                    ->get()
                    ->take(6);
                $total_orders = array_sum(array_column($statistics->all(), 'total_orders'));
                $total_amount = array_sum(array_column($statistics->all(), 'total_amount_'));
                return response([
                    'data' => $statistics->transform(function ($statistic) use ($total_amount) {
                        return [
                            ...$statistic->toArray(),
                            'total_amount' => $statistic->total_amount_,
                            'percentage' => round(($statistic->total_amount_ / $total_amount) * 100, 0),
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
                    ->selectRaw('count(quantity) as total_sales, sum(total_amount) as total_amount_, item_id, item_type')
                    ->with('item:id,name')
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
                    ->orderBy('total_amount_', 'desc')
                    ->groupBy('item_id')
                    ->get()
                    ->take(5);
                $total_sales = array_sum(array_column($statistics->all(), 'total_sales'));
                $total_amount = array_sum(array_column($statistics->all(), 'total_amount_'));
                return response([
                    'data' => $statistics->transform(function ($statistic) use ($total_amount) {
                        return [
                            ...collect($statistic)->except('item_id', 'item', 'item_type', 'total_amount_')->all(),
                            'total_amount' => $statistic->total_amount_,
                            'percentage' => round(($statistic->total_amount_ / $total_amount) * 100, 0),
                            'product' => [
                                'name' => $statistic->item->name,
                                'thumbnail' => $statistic->item->thumbnail
                            ]
                        ];
                    }),
                    'total_amount' => $total_amount,
                    'total_count' => $total_sales
                ]);
            case DashboardStatisticType::TopRequestedProductChart:
                $statistics = ModelAccessLog::query()
                    ->selectRaw('count(model_id) as total_requests, model_id, model_type')
                    ->with('model:id,name')
                    ->whereHasMorph('model', [Product::class], function ($q) use ($user, $guard) {
                        $q->when($guard === 'business', function ($q) use ($user) {
                            $q->where('business_id', $user->business_id);
                        });
                    })
                    ->where('action', request('action', ModelAccessAction::Search))
                    ->orderBy('total_requests', 'desc')
                    ->groupBy('model_id')
                    ->get()
                    ->take(request('limit', 10));

                $total_sales = array_sum(array_column($statistics->all(), 'total_sales'));
                $total_amount = array_sum(array_column($statistics->all(), 'total_amount'));

                return response([
                    'data' => array_column($statistics->all(), 'total_requests'),
                    'labels' => $statistics->transform(function ($statistic) {
                        return $statistic->model->name;
                    }),
                ]);
            case DashboardStatisticType::TopCustomerCard:
                $statistics = Order::query()
                    ->selectRaw('count(id) as total_orders, sum(amount) as total_amount, customer_id, customer_type')
                    ->with('customer.country')
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
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
                $last_week_amount = OrderItem::query()
                    ->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
                    ->sum('total_amount') ?? 0;

                $statistics = OrderItem::query()
                    ->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(total_amount) as total_amount_, created_at')
                    ->whereBetween('created_at', [now()->subWeek(), now()])
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
                    ->orderBy('created_at', 'asc')
                    ->groupBy('created_at')
                    ->get();
                $total_orders = array_sum(array_column($statistics->all(), 'total_orders'));
                $total_amount = array_sum(array_column($statistics->all(), 'total_amount_'));
                $labels = array_column($statistics->all(), 'created_at');
                $percentage_difference = $last_week_amount == 0 ? 100 : (($total_amount - $last_week_amount) / $last_week_amount) * 100;

                return response([
                    'data' => $statistics->transform(function ($statistic) {
                        return (float) $statistic->total_amount_;
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
                $last_week_orders = OrderItem::query()
                    ->selectRaw('count(DISTINCT(order_id)) as total_count')
                    ->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
                    ->first();

                $statistics = OrderItem::query()
                    ->selectRaw('count(DISTINCT(order_id)) as total_orders, created_at')
                    ->whereBetween('created_at', [now()->subWeek(), now()])
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
                    ->orderBy('created_at', 'asc')
                    ->groupBy('created_at')
                    ->get();
                $total_orders = array_sum(array_column($statistics->all(), 'total_orders'));
                $labels = array_column($statistics->all(), 'created_at');
                $percentage_difference = $last_week_orders->total_count == 0 ? 100 : (($total_orders - $last_week_orders->total_count) / $last_week_orders->total_count) * 100;

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
                $last_week_customers = Customer::query()
                    ->selectRaw('count(distinct(user_id)) as total_count, created_at')
                    ->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
                    ->first();

                $customers = Customer::query()
                    ->selectRaw('count(distinct(user_id)) as total_count, created_at')
                    ->whereBetween('created_at', [now()->subWeek(), now()])
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('business_id', $user->business_id);
                    })
                    ->orderBy('created_at', 'asc')
                    ->groupBy('created_at')
                    ->get();

                $total_customers = array_sum(array_column($customers->all(), 'total_count'));
                $labels = array_column($customers->all(), 'created_at');
                $percentage_difference = $last_week_customers->total_count == 0 ? 100 : (($total_customers - $last_week_customers->total_count) / $last_week_customers->total_count) * 100;

                return response([
                    'data' => $customers->transform(function ($customer) {
                        return (float) $customer->total_count;
                    })->take(7),
                    'labels' => collect($labels)->transform(function ($label) {
                        return Carbon::parse($label)->format('m-d-Y');
                    })->take(7),
                    'total_count' => $total_customers,
                    'percentage_difference' => $percentage_difference > 0 ?
                        '+' . $percentage_difference . '%' :
                        '-' . $percentage_difference . '%'
                ]);
            case DashboardStatisticType::LatestOrderCard:
                return response([
                    'orders' => Order::latest()
                        ->with('customer.country')
                        ->when($guard === 'business', function ($q) use ($user) {
                            $q->where('business_id', $user->business_id);
                        })
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
            case DashboardStatisticType::TopBusinessShopChart:
                $period = request('period', 'monthly');
                $topShops = OrderItem::query()
                    ->join('shops', 'order_items.shop_id', '=', 'shops.id')
                    ->select(
                        'shops.name as shop_name',
                        DB::raw('count(distinct(order_items.order_id)) as orders_count'),
                        DB::raw('sum(order_items.total_amount) as total_amount_')
                    )
                    ->when($period == 'weekly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, shop_id')
                            ->whereBetween('order_items.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    })
                    ->when($period == 'monthly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, shop_id')
                            ->whereRaw("year(order_items.created_at) = ?", [request('year', now()->year)]);
                    })
                    ->when($period == 'yearly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, shop_id')
                            ->whereRaw("year(order_items.created_at) <= ?", [request('year', now()->year)]);
                    })
                    ->when($guard === 'business', function ($q) use ($user) {
                        $q->where('order_items.business_id', $user->business_id);
                    })
                    ->groupBy('shop_id')
                    ->orderByDesc('total_amount_')
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

                foreach ($topShops as $key => $shop) {
                    $items = OrderItem::query()
                        ->select(
                            DB::raw('count(distinct(order_items.order_id)) as orders_count'),
                            DB::raw('sum(order_items.total_amount) as total_amount_')
                        )
                        ->where('shop_id', $shop->shop_id)
                        ->when($period == 'weekly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id, DAY(order_items.created_at) as day')
                                ->whereBetween('order_items.created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                ->orderBy('day');
                        })
                        ->when($period == 'monthly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id, month(order_items.created_at) as month')
                                ->whereRaw("year(order_items.created_at) = ?", [request('year', now()->year)])
                                ->orderBy('month');
                        })
                        ->when($period == 'yearly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id, year(order_items.created_at) as year')
                                ->whereRaw("year(order_items.created_at) <= ?", [request('year', now()->year)])
                                ->orderBy('year');
                        })
                        ->groupBy($period == 'weekly' ?
                            'day' : ($period == 'monthly' ? 'month' : 'year')
                        )
                        ->get();

                    $data[$key] = [
                        'label' => $shop->shop_name,
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
                            $data[$key]['data'][$item->month - 1] = (float) $item->total_amount_;
                        } else if ($period == 'yearly') {
                            $data[$key]['data'][] = $item->total_amount_;
                            $labels[] = $item->year;
                        } else if ($period == 'weekly') {
                            $dayOfWeek = idate('w', $item->created_at->timestamp);
                            $data[$key]['data'][$dayOfWeek == 0 ? 6 : $dayOfWeek - 1] = $item->total_amount_;
                        }
                    }
                }

                return response([
                    'labels' => $labels,
                    'datatsets' => $data
                ]);
            case DashboardStatisticType::TopBusinessChart:
                $period = request('period', 'monthly');
                $topBusinesses = OrderItem::query()
                    ->join('businesses', 'order_items.business_id', '=', 'businesses.id')
                    ->select(
                        'businesses.name as business_name',
                        DB::raw('count(distinct(order_items.order_id)) as orders_count'),
                        DB::raw('sum(order_items.total_amount) as total_amount_')
                    )
                    ->when($period == 'weekly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id')
                            ->whereBetween('order_items.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    })
                    ->when($period == 'monthly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id')
                            ->whereRaw("year(order_items.created_at) = ?", [request('year', now()->year)]);
                    })
                    ->when($period == 'yearly', function ($q) {
                        $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id')
                            ->whereRaw("year(order_items.created_at) <= ?", [request('year', now()->year)]);
                    })
                    ->groupBy('business_id')
                    ->orderByDesc('total_amount_')
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
                            DB::raw('sum(order_items.total_amount) as total_amount_')
                        )
                        ->where('business_id', $business->business_id)
                        ->when($period == 'weekly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id, DAY(order_items.created_at) as day')
                                ->whereBetween('order_items.created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                ->orderBy('day');
                        })
                        ->when($period == 'monthly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id, month(order_items.created_at) as month')
                                ->whereRaw("year(order_items.created_at) = ?", [request('year', now()->year)])
                                ->orderBy('month');
                        })
                        ->when($period == 'yearly', function ($q) {
                            $q->selectRaw('count(DISTINCT(order_id)) as total_orders, sum(quantity) total_products, sum(total_amount) as total_amount_, business_id, year(order_items.created_at) as year')
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
                            $data[$key]['data'][$item->month - 1] = (float) $item->total_amount_;
                        } else if ($period == 'yearly') {
                            $data[$key]['data'][] = $item->total_amount_;
                            $labels[] = $item->year;
                        } else if ($period == 'weekly') {
                            $dayOfWeek = idate('w', $item->created_at->timestamp);
                            $data[$key]['data'][$dayOfWeek == 0 ? 6 : $dayOfWeek - 1] = $item->total_amount_;
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
