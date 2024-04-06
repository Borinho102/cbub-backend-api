<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Product;
use App\Models\ProductCategory;
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
            $product
                ->addMedia(public_path(sprintf("images/applications-image-%s.jpg", random_int(10, 31))))
                ->preservingOriginal()
                ->toMediaCollection('preview');
        });
    }
}
