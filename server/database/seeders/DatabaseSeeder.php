<?php

namespace Database\Seeders;

use App\Models\Coin;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create some top crypto coins and some of my favourites (dont reorder top three!)
        if (Coin::count() == 0) {
            Coin::create([ 'name' => 'Tether', 'symbol' => 'USDT' ]); // USDT: 1
            Coin::create([ 'name' => 'Euro', 'symbol' => 'EUR' ]); // EUR: 2
            Coin::create([ 'name' => 'Binance Coin', 'symbol' => 'BNB' ]); // BNB: 3
            Coin::create([ 'name' => 'Bitcoin', 'symbol' => 'BTC' ]);
            Coin::create([ 'name' => 'Ethereum', 'symbol' => 'ETH' ]);
            Coin::create([ 'name' => 'Cardano', 'symbol' => 'ADA' ]);
            Coin::create([ 'name' => 'Polkadot', 'symbol' => 'DOT' ]);
            Coin::create([ 'name' => 'Ripple', 'symbol' => 'XRP' ]);
            Coin::create([ 'name' => 'Uniswap', 'symbol' => 'UNI' ]);
            Coin::create([ 'name' => 'Litecoin', 'symbol' => 'LTC' ]);
            Coin::create([ 'name' => 'Dogecoin', 'symbol' => 'DOGE' ]);
            Coin::create([ 'name' => 'Pancakeswap', 'symbol' => 'CAKE' ]);
        } else {
            // Create 100 random users
            User::factory(100)
                ->has(Settings::factory())
                ->create();
        }
    }
}
