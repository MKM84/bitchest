<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class ProgressionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        //
        function getCotationFor($cryptoname)
        {
            return ((rand(0, 99) > 40) ? 1 : -1) * ((rand(0, 99) > 49) ? ord(substr($cryptoname, 0, 1)) : ord(substr($cryptoname, -1))) * (rand(1, 10) * .01);
        }

        $cryptocurrencies = \App\Models\Cryptocurrency::all(); // Recupere les cryptos

        $date_now = now(); // date d'aujourd'hui
        $date_initial = date('Y-m-d', strtotime($date_now . ' - 30 days')); // date d'aujourd'hui - 30 jours

        foreach ($cryptocurrencies as $crypto) {
            $current_value = $crypto->current_value; // recupere la valeur initiale de chaque crypto
            $cryptoname = $crypto->name; // recupere le nom de chaque crypto

            $progress_value = $current_value; // stock la valeur initiale dans une variable progess_value

            for ($i = 0; $i < 30; $i++) { 

                $date = date('Y-m-d', strtotime($date_initial . ' + ' . ($i + 1) . ' days')); //ajoute 1 jour à chaque tour de boucle

                
                $rate = getCotationFor($cryptoname) * 1000; // genere une valeur pour la quotation
                if ($i == 0) {
                    $progress_value = $current_value;
                    $rate = "0";
                } else {
                    $progress_value += $rate; // modifie la progress_value en fonction du taux (rate)
                }
                // ajout dans la table progressions les valeurs
                DB::table('progressions')->insert([
                    [
                        'progress_value' => $progress_value,
                        'rate' => $rate,
                        'progress_date' => $date,
                        'cryptocurrency_id' => $crypto->id,
                    ]
                ]);
            }
        }
    }
}