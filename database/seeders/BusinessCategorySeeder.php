<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!BusinessCategory::count()) {
            $this->command->info('Truncating Cbub Business Categories\' tables');
            $this->truncateBusinesssCategoryTable();

            $categories = [
                [
                    'name' => [
                        'en' => 'Grocery Store',
                        'fr' => 'Super Marché'
                    ],
                    'description' => [
                        'en' => 'Grocery Store',
                        'fr' => 'Super Marché'
                    ],
                    'code' => 'GROCERY_STORE'
                ]
            ];

            foreach ($categories as $category) {
                BusinessCategory::create([
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'code' => $category['code']
                ]);
            }
        }
    }


    /**
     * Truncates the business categories table
     * @return void
     */
    public function truncateBusinesssCategoryTable()
    {
        Schema::disableForeignKeyConstraints();
        BusinessCategory::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
