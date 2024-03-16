<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BusinessCategory;
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
        $this->call(AdminUserSeeder::class);
        $this->call(BusinessCategorySeeder::class);
        $this->call(BusinessSeeder::class);
        $this->command->info("Seeding Completed! 🤩");
    }
}
