<?php

namespace App\Console\Commands;

use App\Enums\StockMovementType;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Console\Command;

class CreateInitProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-init-product-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::query()
            ->whereDoesntHave('stocks')
            ->chunk(500, function ($products) {
                foreach ($products as $product) {
                    $product->stocks()->save(new ProductStock([
                        'prev_quantity' => 0,
                        'new_quantity' => $product->quantity,
                        'type' => StockMovementType::In,
                        'comment' => 'Initial stock',
                        'author_id' => 1,
                        'author_type' => Admin::class
                    ]));
                }
            });
    }
}
