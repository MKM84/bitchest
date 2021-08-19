<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


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
                'logo' => 'a',
                'current_value'=>getFirstCotation("Bitcoin")*1000,
            
            ],
            [
                'name' => 'Ethereum',
                'logo' => 'a',
                'current_value'=>getFirstCotation("Ethereum")*1000,
             
            ],
            [
                'name' => 'Ripple',
                'logo' => 'v',
                'current_value'=>getFirstCotation("Ripple")*1000,
              
            ],
            [
                'name' => 'Bitcoin Cash',
                'logo' => 'b',
                'current_value'=>getFirstCotation("Bitcoin Cash")*1000,
                
            ],
            [
                'name' => 'Cardano',
                'logo' => 'z',
                'current_value'=>getFirstCotation("Cardano")*1000,
              
            ],
            [
                'name' => 'Litecoin',
                'logo' => 'e',
                'current_value'=>getFirstCotation("Litecoin")*1000,
              
            ],
            [
                'name' => 'NEM',
                'logo' => 'r',
                'current_value'=>getFirstCotation("NEM")*1000,
               
            ],
            [
                'name' => 'Stellar',
                'logo' => 't',
                'current_value'=>getFirstCotation("Stellar")*1000,
              
            ],
            [
                'name' => 'IOTA',
                'logo' => 'r',
                'current_value'=>getFirstCotation("IOTA")*1000,
            
            ],
            [
                'name' => 'Das',
                'logo' => 't',
                'current_value'=>getFirstCotation("Das")*1000,
              
            ],
        ]);

        //
     
    }
}
