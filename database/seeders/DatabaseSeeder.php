<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        DB::table('users')->insert([
            [
                'firstname' => 'Majed',
                'lastname' => 'Khreim',
                'email' => 'majed@majed.fr',
                'password' => Hash::make('password1'),
                'status' => 1,
                'user_solde' => 500000
            ],

            [
                'firstname' => 'Ludovic',
                'lastname' => 'Charlier',
                'email' => 'ludovic@ludovic.fr',
                'password' => Hash::make('password2'),
                'status' => 0,
                'user_solde' => 500000
            ],
        ]);
        $this->call(CryptocurrenciesTableSeeder::class);
        $this->call(ProgressionsTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);








    }
}
