<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cryptocurrency;
use App\Models\Progression;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{

    private $userSold;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
        $this->middleware(function ($request, $next) {
            $this->userSold = Auth::user()->user_solde;
            return $next($request);
        });
    }

    // Get Cryptos && actual vaur & user sold
    public function index()
    {
        $cryptosArray = array();

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

        return ['currencies' => array_reverse($cryptosArray), 'userSolde' => $this->userSold];
    }


    public function userWallet()
    {

        $wallet_array = [];
        $id = Auth::user()->id;

        $walletsUser = DB::table('transactions')
            ->join('cryptocurrencies', 'transactions.cryptocurrency_id', '=', 'cryptocurrencies.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('progressions', 'transactions.progression_id', '=', 'progressions.id')
            ->selectRaw("
            cryptocurrencies.id as id_crypto,
            cryptocurrencies.logo logo_crypto,
            cryptocurrencies.name as name_crypto,
            ROUND(SUM(transactions.quantity), 2) as quantity_sum,
            ROUND(SUM(transactions.purchase_price * transactions.quantity), 2) as prices_sum")
            ->where('user_id', $id)
            ->where('transactions.state', 0)
            ->groupBy('cryptocurrencies.id')
            ->get();


            function getCurrentValueByCrypto($id)
            {
                $currentValueByCrypto =  DB::table('progressions')
                    ->select('progress_value')
                    ->where('cryptocurrency_id', $id)
                    ->orderByDesc('progress_date')
                    ->first();
                return $currentValueByCrypto;
            }

        $i = 0;
        foreach ($walletsUser as $wall) {
            // get current value of crypto
            $currentvalue_of_crypto = getCurrentValueByCrypto($wall->id_crypto);

            $wallet_array[$i]["id_crypto"] = $wall->id_crypto;
            $wallet_array[$i]["name_crypto"] = $wall->name_crypto;
            $wallet_array[$i]["logo_crypto"] = $wall->logo_crypto;
            $wallet_array[$i]["quantity_sum"] = $wall->quantity_sum;
            $wallet_array[$i]["prices_sum"] = $wall->prices_sum;
            $wallet_array[$i]["current_value"] = $currentvalue_of_crypto->progress_value;

            $i++;
        }

        return ['userWallet' => $wallet_array];
    }

    public function getHistory() {
        $id = Auth::user()->id;

        $historyByCrypto = DB::table('transactions')
        ->join('cryptocurrencies', 'transactions.cryptocurrency_id', '=', 'cryptocurrencies.id')
        ->join('users', 'transactions.user_id', '=', 'users.id')
        ->select("cryptocurrencies.name as name_crypto","state","quantity","purchase_date", "logo"
        ,"purchase_price","sum_purchase","selling_date","selling_price","balance")
        ->where('user_id', $id)
        ->orderByDesc('transactions.purchase_date')
        ->get();

        return ['historyByCrypto' => $historyByCrypto];
    }

    public function getUserInfos()
    {
        return ['userInfos' => Auth::user()];
    }

    public function EditUserInfos($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());

        return response()->json(['done' => true]);
    }

    public function getCryptoEvolution($id)
    {
        $dateCryptoEvolution = Progression::all()->sortByDesc("id")->where('cryptocurrency_id', $id)->pluck('progress_date')->toArray();

        $valueCryptoEvolution = Progression::all()->sortByDesc("id")->where('cryptocurrency_id', $id)->pluck('progress_value')->toArray();

        $crypto = Cryptocurrency::find($id);

        return ['dateCryptoEvolution' => array_reverse($dateCryptoEvolution), 'valueCryptoEvolution' => array_reverse($valueCryptoEvolution), 'crypto' => $crypto];
    }
}
