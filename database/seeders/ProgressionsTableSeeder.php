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
        // function return value of cotation for crypto
        function getCotationFor($cryptoname)
        {
            return ((rand(0, 99) > 40) ? 1 : -1) * ((rand(0, 99) > 49) ? ord(substr($cryptoname, 0, 1)) : ord(substr($cryptoname, -1))) * (rand(1, 10) * .01);
        }

        $cryptocurrencies = \App\Models\Cryptocurrency::all(); // get all cryptocurrency

        $date_now = now(); // date today now
        $date_initial = date('Y-m-d', strtotime($date_now . ' - 30 days')); // date today before 30 days

        foreach ($cryptocurrencies as $crypto) {
            $current_value = $crypto->current_value; // get current value of crypto
            $cryptoname = $crypto->name; // get name of crypto

            $progress_value = $current_value; 

            for ($i = 0; $i < 30; $i++) { 

                //Add 1 days to date
                $date = date('Y-m-d', strtotime($date_initial . ' + ' . ($i + 1) . ' days')); 

                
                $rate = getCotationFor($cryptoname) * 1000; // get value of cotation
                if ($i == 0) {
                    $progress_value = $current_value;
                    $rate = "0";
                } else {
                    $progress_value += $rate; // update progress value with cotation
                }
                // Add in table progressions the value
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