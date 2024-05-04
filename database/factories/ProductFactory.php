<?php

namespace Database\Factories;

use App\Enums\ModelAccessAction;
use App\Enums\StockMovementType;
use App\Models\Admin;
use App\Models\Business;
use App\Models\ModelAccessLog;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDiscount;
use App\Models\ProductStock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);
        $description = fake()->sentence(30, true);
        $business = Business::with(['shops' => function ($q) {
            $q->inRandomOrder();
        }])->inRandomOrder()->first();

        return [
            'name' => [
                'en' => $name,
                'fr' => $name
            ],
            'slug' => [
                'en' => str()->slug($name),
                'fr' => str()->slug($name)
            ],
            'short_description' => [
                'en' => $description,
                'fr' => $description
            ],
            'description' => [
                'en' => $description,
                'fr' => $description
            ],
            'price' => random_int(4000, 97000),
            'quantity' => random_int(10, 100),
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
            'business_id' => $business->id,
            'shop_id' => $business->shops->first()->id
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->discounts()->save(new ProductDiscount([
                'old_price' => $product->price,
                'new_price' => $product->price / 2,
                'discount_percentage' => 50,
                'user_id' => 1,
                'user_type' => Admin::class,
                'start_date' => now(),
                'end_date' => now()->addHours(random_int(4, 24)),
            ]));

            $product->stocks()->save(new ProductStock([
                'old_quantity' => 0,
                'new_quantity' => $product->quantity,
                'type' => StockMovementType::In,
                'comment' => 'Initial stock',
                'author_id' => 1,
                'author_type' => Admin::class
            ]));

            $product
                ->addMedia(public_path(sprintf("images/applications-image-%s.jpg", random_int(10, 31))))
                ->preservingOriginal()
                ->toMediaCollection('thumbnail');

            ModelAccessLog::create([
                'model_id' => $product->id,
                'model_type' => Product::class,
                'user_id' => User::inRandomOrder()->first()->id,
                'user_type' => User::class,
                'action' => ModelAccessAction::Search,
                'data' => [
                    'query' => fake()->word()
                ]
            ]);

            ModelAccessLog::create([
                'model_id' => $product->id,
                'model_type' => Product::class,
                'user_id' => User::inRandomOrder()->first()->id,
                'user_type' => User::class,
                'action' => ModelAccessAction::Click,
                'data' => null
            ]);

            ModelAccessLog::create([
                'model_id' => $product->id,
                'model_type' => Product::class,
                'user_id' => User::inRandomOrder()->first()->id,
                'user_type' => User::class,
                'action' => ModelAccessAction::Wishlist,
                'data' => null
            ]);
        });
    }
}
