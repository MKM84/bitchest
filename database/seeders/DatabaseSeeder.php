<?php

namespace Database\Seeders;

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
         \App\Models\User::factory(10)->create();
         $this->call(CryptocurrenciesTableSeeder::class);
         $this->call(ProgressionsTableSeeder::class);
         $this->call(TransactionsTableSeeder::class);
        //  \App\Models\Transaction::factory(10)->create();







    }
}
