<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // =======================
        // ADDING CURRENCIES
        // =======================

        DB::table('currencies')->insert([
            [
                'name' => 'Franc CFA',
                'code' => 'XAF',
                'symbol' => 'XAF',
                'format' => '1,0 XAF',
                'exchange_rate' => 1.0,
                'active' => 1,
            ],
            [
                'name' => 'Franc CFA',
                'code' => 'XOF',
                'symbol' => 'XOF',
                'format' => '1,0 XOF',
                'exchange_rate' => 1.0,
                'active' => 1,
            ],
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'format' => '$1,0.00',
                'exchange_rate' => 0.0016,
                'active' => 1,
            ],
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'format' => '1.0,00 €',
                'exchange_rate' => 0.0015,
                'active' => 1,
            ],
        ]);
    }
}
