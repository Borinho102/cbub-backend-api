<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Business;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info("Seeding Tables 🌱");
        $this->call(CurrencySeeder::class);
        $this->call(WorldTablesSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(BusinessCategorySeeder::class);
        $this->call(ProductCategorySeeder::class);
        Business::factory(20)->create();
        User::factory(50)->create();
        Product::factory(50)->create();
        $this->call(ProductReviewSeeder::class);
        $this->call(ShopReviewSeeder::class);
        $this->call(DashboardTableSeeder::class);
        $this->call(OrderSeeder::class);
        $this->command->info("Seeding Completed! 🤩");
    }
}
