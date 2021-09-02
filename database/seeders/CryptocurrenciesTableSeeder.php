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

        $ratio = 500;
        DB::table('cryptocurrencies')->insert([
            [
                'name' => 'Bitcoin',
                'logo' => 'bitcoin.png',
                'current_value'=>getFirstCotation("Bitcoin")*$ratio,

            ],
            [
                'name' => 'Ethereum',
                'logo' => 'ethereum.png',
                'current_value'=>getFirstCotation("Ethereum")*$ratio,

            ],
            [
                'name' => 'Ripple',
                'logo' => 'ripple.png',
                'current_value'=>getFirstCotation("Ripple")*$ratio,

            ],
            [
                'name' => 'Bitcoin Cash',
                'logo' => 'bitcoin_cash.png',
                'current_value'=>getFirstCotation("Bitcoin Cash")*$ratio,

            ],
            [
                'name' => 'Cardano',
                'logo' => 'cardano.png',
                'current_value'=>getFirstCotation("Cardano")*$ratio,

            ],
            [
                'name' => 'Litecoin',
                'logo' => 'litecoin.png',
                'current_value'=>getFirstCotation("Litecoin")*$ratio,

            ],
            [
                'name' => 'NEM',
                'logo' => 'nem.png',
                'current_value'=>getFirstCotation("NEM")*$ratio,

            ],
            [
                'name' => 'Stellar',
                'logo' => 'stellar.png',
                'current_value'=>getFirstCotation("Stellar")*$ratio,

            ],
            [
                'name' => 'IOTA',
                'logo' => 'iota.png',
                'current_value'=>getFirstCotation("IOTA")*$ratio,

            ],
            [
                'name' => 'Dash',
                'logo' => 'dash.png',
                'current_value'=>getFirstCotation("Dash")*$ratio,

            ],
        ]);

        //

    }
}
