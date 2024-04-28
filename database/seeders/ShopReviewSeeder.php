<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shop::chunk(500, function ($shops) {
            foreach ($shops as $shop) {
                foreach (User::all() as $user) {
                    Review::updateOrCreate([
                        'reviewable_id' => $shop->id,
                        'reviewable_type' => Shop::class,
                        'user_id' => $user->id
                    ], [
                        'published' => random_int(0, 1),
                        'rating' => random_int(3, 5),
                        'title' => fake()->words(3, true),
                        'body' => fake()->sentence(1, true)
                    ]);
                }
            }
        });
    }
}
