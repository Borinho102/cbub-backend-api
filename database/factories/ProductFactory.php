<?php

namespace Database\Factories;

use App\Enums\StockMovementType;
use App\Models\Admin;
use App\Models\Business;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
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
            'business_id' => Business::inRandomOrder()->first()->id
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->stocks()->save(new ProductStock([
                'prev_quantity' => 0,
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
        });
    }
}
