<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Services\Utils\Initials;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();
        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'initials' => Initials::generate($name),
            'slug' => str()->slug($name),
            'address' => fake()->address(),
            'about' => fake()->sentences(1, true),
            'category_id' => BusinessCategory::inRandomOrder()->first()->id
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Business $business) {
            $business
                ->addMedia(public_path('images/business_placeholder.png'))
                ->preservingOriginal()
                ->toMediaCollection('logo');
        });
    }
}
