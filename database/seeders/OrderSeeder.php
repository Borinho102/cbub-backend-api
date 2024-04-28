<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Order::count()) {
            $this->command->info('Truncating Order\'s tables');
            $this->truncateOrdersTable();

            for ($i = 0; $i < 500; $i++) {
                $user = User::with('current_location')
                    ->whereHas('current_location')
                    ->inRandomOrder()->first();

                $order = Order::create([
                    'customer_id' => $user->id,
                    'customer_type' => User::class,
                    'order_id' => generateOrderID(),
                    'amount' => random_int(13500, 67900),
                    'currency' => 'XAF',
                    'location_id' => $user->current_location->id,
                    'status' => ['pending', 'refunded', 'approved'][random_int(0, 2)],
                    'description' => fake()->sentence(30)
                ]);

                $products = Product::inRandomOrder()
                    ->limit(random_int(1, 10))
                    ->get();

                $order_amount = 0;
                foreach ($products as $product) {
                    $qty = random_int(1, 4);
                    $date = now()->subDays(random_int(0, 7));
                    $item = OrderItem::create([
                        'item_id' => $product->id,
                        'item_type' => Product::class,
                        'business_id' => $product->business_id,
                        'shop_id' => $product->shop_id,
                        'order_id' => $order->id,
                        'quantity' => $qty,
                        'unit_amount' => $product->price,
                        'total_amount' => $qty * $product->price
                    ]);
                    $order->update([
                        'created_at' => $date,
                        'updated_at' => $date
                    ]);
                    $order_amount += $item->total_amount;
                }

                $order->update(['amount' => $order_amount]);
            }
        }
    }

    /**
     * Truncates the orders table
     * @return void
     */
    public function truncateOrdersTable()
    {
        Schema::disableForeignKeyConstraints();
        Order::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
