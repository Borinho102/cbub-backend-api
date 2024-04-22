<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Admin;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Admin::count()) {
            $this->command->info('Truncating Admin\'s tables');
            $this->truncateAdminUsersTable();
            //Artisan::call("passport:install --force");
            $currency = Currency::where('code', 'XAF')->first();
            $country = Country::where('currency_code', $currency->code)->first();
            $city = City::where('code', 'lit')->first(); // Littoral

            $users = [
                [
                    'name' => 'Super Admin',
                    'email' => 'superadmin@gmail.com',
                    'username' => 'superadmin',
                    'address' => 'Douala',
                    'email_verified_at' => Carbon::now(),
                    'two_factor_auth' => true,
                    'password' => 'password'
                ]
            ];

            foreach ($users as $user) {
                $adminUser = Admin::create([
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'currency_id' => $currency->id,
                    'country_id' => $country->id,
                    'city_id' => $city->id,
                    'address' => $user['address'],
                    'password' => bcrypt($user['password']),
                    'email_verified_at' => $user['email_verified_at']
                ]);

                $adminUser
                    ->addMedia(public_path('images/default_avatar.png'))
                    ->preservingOriginal()
                    ->toMediaCollection('avatar');
            }

            $this->seedUsers($country, $city, $currency);
        }
    }

    /**
     * Truncates the users table
     * @return void
     */
    public function truncateAdminUsersTable()
    {
        Schema::disableForeignKeyConstraints();
        Admin::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Seed users
     */
    private function seedUsers(Country $country, City $city, Currency $currency) {
        $users = [
            [
                'name' => 'Business User 1',
                'email' => 'business.user.1@gmail.com',
                'password' => bcrypt('business-user-1'),
                'permissions' => [],
                'roles' => [],
                'email_verified_at' => Carbon::now(),
                'phone_verified_at' => Carbon::now()
            ]
        ];

        foreach ($users as $user) {
            $businessUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'currency_id' => $currency->id,
                'country_id' => $country->id,
                'city_id' => $city->id,
                'password' => $user['password'],
                'email_verified_at' => $user['email_verified_at']
            ]);

            $businessUser
                ->addMedia(public_path('images/default_avatar.png'))
                ->preservingOriginal()
                ->toMediaCollection('avatar');

            //$businessUser->syncRoles($user['roles']);
            //$businessUser->syncPermissions($user['permissions']);
        }
    }
}
