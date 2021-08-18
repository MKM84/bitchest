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

        $cryptocurrencies = \App\Models\Cryptocurrency::all();

        $date_now = now();
        $date_initial = date('Y-m-d', strtotime($date_now . ' - 30 days'));

        foreach ($cryptocurrencies as $crypto) {
            $current_value = $crypto->current_value;
            $cryptoname = $crypto->name;

            $progress_value = $current_value;

            for ($i = 0; $i < 30; $i++) {

                $date = date('Y-m-d', strtotime($date_initial . ' + ' . ($i + 1) . ' days'));


                $rate = getCotationFor($cryptoname) * 1000;
                if ($i == 0) {
                    $progress_value = $current_value;
                    $rate = "0";
                } else {
                    $progress_value += $rate;
                }

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
