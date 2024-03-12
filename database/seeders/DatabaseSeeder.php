<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $this->call(BusinessPartnerSeeder::class);
        $this->command->info("Seeding Completed! 🤩");
    }
}
