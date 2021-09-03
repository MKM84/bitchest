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
        // get all cryptocurrency
        $cryptocurrencies = \App\Models\Cryptocurrency::all(); 
        // date today now
        $date_now = now(); 
        // date today before 30 days
        $date_initial = date('Y-m-d', strtotime($date_now . ' - 30 days')); 

        foreach ($cryptocurrencies as $crypto) {
            // get current value of crypto
            $current_value = $crypto->current_value; 
            // get name of crypto
            $cryptoname = $crypto->name; 

            $progress_value = $current_value;

            for ($i = 0; $i < 30; $i++) {
                //Add 1 days to date
                $date = date('Y-m-d', strtotime($date_initial . ' + ' . ($i + 1) . ' days'));

                // get value of cotation
                $rate = getCotationFor($cryptoname) * 500; 
                if ($i == 0) {
                    $progress_value = $current_value;
                    $rate = "0";
                } else {
                    // update progress value with cotation
                    $progress_value += $rate; 
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
