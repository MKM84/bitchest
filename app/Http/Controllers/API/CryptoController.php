<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cryptocurrency;
use App\Models\Progression;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    // Get Cryptos
    public function index()
    {
        $cryptosArray = array();

        //Get all last current values of cryptos
        $currencies = Progression::select(
            'progressions.id',
            'progress_value as current_value',
            'cryptocurrency_id',
            'cryptocurrencies.name',
            'cryptocurrencies.current_value as initial_value',
            'cryptocurrencies.id as id',
            'cryptocurrencies.logo as logo',
            'cryptocurrencies.name as name'
        )
            ->join('cryptocurrencies', 'progressions.cryptocurrency_id', '=', 'cryptocurrencies.id')
            ->orderByDesc("progressions.id")
            ->get()
            ->unique('cryptocurrency_id');

        $i = 0;
        foreach ($currencies as $value) {
            $cryptosArray[$i] = $value;
            $i++;
        }
        return ['currencies' => array_reverse($cryptosArray)];
    }


    // get crypto evolution for the last 30 days
    public function getCryptoEvolution($id)
    {
        //Get all date of current value changing of one crypto during 30 days
        $dateCryptoEvolution = Progression::all()->sortByDesc("id")->where('cryptocurrency_id', $id)->pluck('progress_date')->toArray();

        //Get all current value of one crypto during 30 days
        $valueCryptoEvolution = Progression::all()->sortByDesc("id")->where('cryptocurrency_id', $id)->pluck('progress_value')->toArray();
        //Get  Information of one Crypto
        $crypto = Cryptocurrency::find($id);

        return ['dateCryptoEvolution' => array_reverse($dateCryptoEvolution), 'valueCryptoEvolution' => array_reverse($valueCryptoEvolution), 'crypto' => $crypto];
    }
}
