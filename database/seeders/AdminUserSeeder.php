<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
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
        if (! Admin::count()) {
            $this->command->info('Truncating Admin\'s tables');
            $this->truncateAdminUsersTable();
            $currency = Currency::where('code', 'XAF')->first();
            $country = Country::where('currency_code', $currency->code)->first();
            $city = City::where('code', 'lit')->first(); // Littoral

            $users = [
                [
                    'name' => 'Vitih Dinga',
                    'email' => 'vdinga@scdp.cm',
                    'username' => 'vitih',
                    'address' => 'Douala',
                    'email_verified_at' => Carbon::now(),
                    'two_factor_auth' => true,
                    'password' => '#VitihDinga',
                    'roles' => ['admin', 'owner'],
                ],
                [
                    'name' => 'Jordy Parker',
                    'email' => 'jordylontsi@gmail.com',
                    'username' => 'jordyparker',
                    'address' => 'Douala',
                    'email_verified_at' => Carbon::now(),
                    'two_factor_auth' => true,
                    'password' => 'password',
                    'roles' => ['admin', 'developer']
                ],
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
                    'email_verified_at' => $user['email_verified_at'],
                ]);

                $adminUser
                    ->addMedia(public_path('images/default_avatar.png'))
                    ->preservingOriginal()
                    ->toMediaCollection('avatar');

                $adminUser->syncRoles($user['roles']);
            }

            $this->seedUsers($country, $city, $currency);
        }
    }

    /**
     * Truncates the users table
     *
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
    private function seedUsers(Country $country, City $city, Currency $currency)
    {
        $users = [
            [
                'first_name' => 'Customer 1',
                'last_name' => 'Customer 1',
                'username' => 'customer.1',
                'email' => 'customer.1@gmail.com',
                'password' => bcrypt('password'),
                'permissions' => [],
                'roles' => ['customer'],
                'email_verified_at' => Carbon::now(),
                'phone_verified_at' => Carbon::now(),
            ],
        ];

        foreach ($users as $user) {
            $user_ = User::create([
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'currency_id' => $currency->id,
                'country_id' => $country->id,
                'city_id' => $city->id,
                'password' => $user['password'],
                'email_verified_at' => $user['email_verified_at'],
            ]);

            $user_
                ->addMedia(public_path('images/default_avatar.png'))
                ->preservingOriginal()
                ->toMediaCollection('avatar');

            $user_->syncRoles($user['roles']);
            $user_->syncPermissions($user['permissions']);
        }
    }
}
