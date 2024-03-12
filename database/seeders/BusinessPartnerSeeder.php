<?php

namespace Database\Seeders;

use App\Models\BusinessPartner;
use App\Models\BusinessPartnerUser;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BusinessPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!BusinessPartner::count()) {
            $this->command->info('Truncating Cbub Business Partners\' tables');
            $this->truncateBusinessPartnersTable();
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
                    'about' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis id dolor soluta, natus quo possimus, laborum quos neque praesentium commodi, quia sequi deserunt veritatis. Ipsam veritatis laborum dignissimos quas quibusdam!'
                ]
            ];

            foreach ($businesses as $business) {
                $businessPartner = BusinessPartner::create([
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
                ]);

                $businessPartner
                    ->addMedia($business['logo'])
                    ->preservingOriginal()
                    ->toMediaCollection('logo');

                BusinessPartnerUser::create([
                    'business_partner_id' => $businessPartner->id,
                    'user_id' => 1
                ]);
            }
        }
    }


    /**
     * Truncates the business partners table
     * @return void
     */
    public function truncateBusinessPartnersTable()
    {
        Schema::disableForeignKeyConstraints();
        BusinessPartner::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
