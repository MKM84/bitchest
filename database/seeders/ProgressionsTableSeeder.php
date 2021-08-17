<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProgressionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    function getCotationFor($cryptoname){	
        return ((rand(0, 99)>40) ? 1 : -1) * ((rand(0, 99)>49) ? ord(substr($cryptoname,0,1)) : ord(substr($cryptoname,-1))) * (rand(1,10) * .01);
    }
    
    public function run()
    {
        //

        for($x=1;$x<=10;$x++){

        for($i=0;$i<30;$i++){
            
            DB::table('progressions')->insert([
                [
                    'progress_value' => DB::table('cryptocurrencies')->where('current_value', $x),
                    'rate' => getCotationFor($x),
                    'progress_date'=>date(),
                    'cryptocurrency_id'=>$x,
                ]
            ]);

        }

    }


    }
}
