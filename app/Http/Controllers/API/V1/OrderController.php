<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\OrderStatus;
use App\Events\NewOrderCreated;
use App\Http\Controllers\ApiController;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $relationships = request('relationships');

        $orders = Order::query()
            ->withCount('items')
            ->with('shop:id,name,email,slug,address,phone,currency_id')
            ->when($relationships, function ($q) use ($relationships) {
                $q->with($relationships);
            })
            ->where('customer_id', auth('api')->user()->id)
            ->where('customer_type', User::class)
            ->when($search = request('search'), function ($q) use ($search) {
                $q->where('order_id', 'like', '%' . $search . '%');
            })
            ->when($status = request('status'), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(request('page_size', 10))
            ->through(function ($order) {
                return OrderResource::make($order);
            });

        return $this->successfulResponse(
            $orders,
            'ORDERS_RETRIEVED',
            'Orders successfully retrieved'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'total_amount' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.shop_id' => 'required|exists:shops,id',
            'products.*.price' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
            'delivery_address' => 'nullable|exists:delivery_addresses,id',
            'delivery_notes' => 'nullable|string',
            'payment_method' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            $products = collect($request->products)->groupBy('shop_id');
            $orders = [];

            foreach ($products as $shopId => $shopProducts) {
                $totalAmount = 0;
                $orderItems = [];
                $shop = Shop::with('currency')->find($shopId);
                $order = Order::create([
                    'order_id' => generateOrderID(),
                    'customer_type' => User::class,
                    'customer_id' => auth('api')->user()->id,
                    'amount' => $shopProducts->sum('price'),
                    'currency' => $shop->currency->code,
                    'status' => OrderStatus::Pending,
                    'business_id' => $shop->business_id,
                    'delivery_address_id' => $request->delivery_address,
                    'shop_id' => $shopId,
                    'description' => $request->delivery_notes
                ]);

                foreach ($shopProducts as $product) {
                    $product_ = Product::with('active_discount')->find($product['id']);
                    $price = $product_->active_discount ? $product_->active_discount->new_price : $product_->price;
                    $totalAmount += $price * $product['quantity'];
                    $orderItems[] = [
                        'order_id' => $order->id,
                        'item_type' => Product::class,
                        'item_id' => $product_->id,
                        'shop_id' => $shop->id,
                        'business_id' => $shop->business_id,
                        'quantity' => $product['quantity'],
                        'unit_amount' => $price,
                        'total_amount' => $product['quantity'] * $product['price'],
                        'currency' => $shop->currency->code,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                OrderItem::insert($orderItems);

                $order->update(['amount' => $totalAmount]);

                $orders[] = $order;
            }

            DB::commit();

            foreach ($orders as $order) {
                event(new NewOrderCreated($order));
            }

            return $this->successfulResponse(
                true,
                'ORDERS_CREATED',
                'Orders successfully created!'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $relationships = request('relationships');

        $order = Order::query()
            ->withCount('items')
            ->with(['items.item', 'shop:id,name,email,slug,address,phone,currency_id', 'statuses'])
            ->when($relationships, function ($q) use ($relationships) {
                $q->with($relationships);
            })
            ->where('customer_id', auth('api')->user()->id)
            ->where('customer_type', User::class)
            ->when($search = request('search'), function ($q) use ($search) {
                $q->where('order_id', 'like', '%' . $search . '%');
            })
            ->findOrFail($id);

        return $this->successfulResponse(
            OrderResource::make($order),
            'ORDER_RETRIEVED',
            'Order details successfully retrieved'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
