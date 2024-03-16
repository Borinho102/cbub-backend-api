<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessUser;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Business::count()) {
            $this->command->info('Truncating Cbub Business Partners\' tables');
            $this->truncateBusinesssTable();
            $currency = Currency::where('code', 'XAF')->first();
            $country = Country::where('currency_code', $currency->code)->first();
            $city = City::where('code', 'lit')->first(); // Littoral

            $businesses = [
                [
                    'name' => 'Santa Lucia Bonamoussadi',
                    'email' => 'Info@complexesantalucia.com',
                    'phone' => '+237695211141',
                    'initials' => 'SLB',
                    'slug' => Str::slug('Santa Lucia Bonamoussadi'),
                    'address' => 'Douala, Bonamoussadi',
                    'logo' => public_path('images/santa_lucia_logo.png'),
                    'about' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis id dolor soluta, natus quo possimus, laborum quos neque praesentium commodi, quia sequi deserunt veritatis. Ipsam veritatis laborum dignissimos quas quibusdam!',
                    'category_id' => BusinessCategory::find(1)->id
                ]
            ];

            foreach ($businesses as $business) {
                $Business = Business::create([
                    'name' => $business['name'],
                    'email' => $business['email'],
                    'phone' => $business['phone'],
                    'initials' => $business['initials'],
                    'slug' => $business['slug'],
                    'currency_id' => $currency->id,
                    'country_id' => $country->id,
                    'city_id' => $city->id,
                    'address' => $business['address'],
                    'about' => $business['about'],
                    'category_id' => $business['category_id']
                ]);

                $Business
                    ->addMedia($business['logo'])
                    ->preservingOriginal()
                    ->toMediaCollection('logo');

                BusinessUser::create([
                    'business_id' => $Business->id,
                    'user_id' => 1
                ]);
            }
        }
    }


    /**
     * Truncates the business partners table
     * @return void
     */
    public function truncateBusinesssTable()
    {
        Schema::disableForeignKeyConstraints();
        Business::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
