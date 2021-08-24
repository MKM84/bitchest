<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CryptocurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */



    public function run()
    {
        // get random first cotation of crypto
        function getFirstCotation($cryptoname){
            return ord(substr($cryptoname,0,1)) + rand(0, 10);
          }
        // insert in table cryptocurrencies the crypto with name, logo (picture) and current value

        DB::table('cryptocurrencies')->insert([
            [
                'name' => 'Bitcoin',
                'logo' => 'bitcoin.png',
                'current_value'=>getFirstCotation("Bitcoin")*1000,

            ],
            [
                'name' => 'Ethereum',
                'logo' => 'ethereum.png',
                'current_value'=>getFirstCotation("Ethereum")*1000,

            ],
            [
                'name' => 'Ripple',
                'logo' => 'ripple.png',
                'current_value'=>getFirstCotation("Ripple")*1000,

            ],
            [
                'name' => 'Bitcoin Cash',
                'logo' => 'bitcoin_cash.png',
                'current_value'=>getFirstCotation("Bitcoin Cash")*1000,

            ],
            [
                'name' => 'Cardano',
                'logo' => 'cardano.png',
                'current_value'=>getFirstCotation("Cardano")*1000,

            ],
            [
                'name' => 'Litecoin',
                'logo' => 'litecoin.png',
                'current_value'=>getFirstCotation("Litecoin")*1000,

            ],
            [
                'name' => 'NEM',
                'logo' => 'nem.png',
                'current_value'=>getFirstCotation("NEM")*1000,

            ],
            [
                'name' => 'Stellar',
                'logo' => 'stellar.png',
                'current_value'=>getFirstCotation("Stellar")*1000,

            ],
            [
                'name' => 'IOTA',
                'logo' => 'iota.png',
                'current_value'=>getFirstCotation("IOTA")*1000,

            ],
            [
                'name' => 'Dash',
                'logo' => 'dash.png',
                'current_value'=>getFirstCotation("Dash")*1000,

            ],
        ]);

        //

    }
}
