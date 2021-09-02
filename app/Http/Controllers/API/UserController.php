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

    public function getCurrentValueByCrypto($id)
    {
        $currentValueByCrypto =  DB::table('progressions')
            ->select('progress_value', 'id')
            ->where('cryptocurrency_id', $id)
            ->orderByDesc('progress_date')
            ->first();
        return $currentValueByCrypto;
    }

    // Get Cryptos && actual vaule & user sold
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






        $i = 0;
        foreach ($walletsUser as $wall) {
            // get current value of crypto
            $currentvalue_of_crypto = $this->getCurrentValueByCrypto($wall->id_crypto);

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



    public function getHistory()
    {
        $id = Auth::user()->id;

        $historyByCrypto = DB::table('transactions')
            ->join('cryptocurrencies', 'transactions.cryptocurrency_id', '=', 'cryptocurrencies.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select(
                "cryptocurrencies.name as name_crypto",
                "state",
                "quantity",
                "purchase_date",
                "logo",
                "purchase_price",
                "sum_purchase",
                "selling_date",
                "selling_price",
                "balance"
            )
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


    public function getCryptosToSell($crypto_id)
    {
        $user_id = Auth::user()->id;

        $cryptosToSell = DB::table('transactions')
            ->join('cryptocurrencies', 'transactions.cryptocurrency_id', '=', 'cryptocurrencies.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select(
                "cryptocurrencies.name as crypto_name",
                "state",
                "quantity",
                "purchase_date",
                "purchase_price",
                "logo",
                "sum_purchase"
            )
            ->where('transactions.state', 0)
            ->where('user_id', $user_id)
            ->where('transactions.cryptocurrency_id', $crypto_id)
            ->get();

        $cryptoName = Cryptocurrency::all()->where('id', $crypto_id)->pluck('name')->toArray();
        $cryptoLogo = Cryptocurrency::all()->where('id', $crypto_id)->pluck('logo')->toArray();
        $actualValue = $this->getCurrentValueByCrypto($crypto_id);

        return ['cryptosToSellData' => ['name' => $cryptoName, 'logo' => $cryptoLogo, 'actualValue' => $actualValue, 'cryptosToSell' => $cryptosToSell]];
    }

    public function addTransaction(Request $request)
    {
        $user_id = Auth::user()->id;
        // $progress = $this->getCurrentValueByCrypto($request->input('cryptocurrency_id'));
        // $transaction = new Transaction([
            // 'user_id' => $user_id,
            // 'cryptocurrency_id' => $request->input('cryptocurrency_id'),
            // 'progression_id' =>  $this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->id,
            // 'quantity' => $request->input('quantity'),
            // 'state' => 0,
            // 'purchase_date' => now(),
            // 'selling_date' => null,
            // 'purchase_price' => $this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->progress_value,
            // 'selling_price' => null,
            // 'sum_selling' => 0,
            // 'sum_purchase' => $this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->progress_value * $request->input('quantity'),
            // 'balance' => null

            // 'user_id' => $user_id,
            // 'cryptocurrency_id' => 1,
            // 'progression_id' =>  30,
            // 'quantity' => 2,
            // 'state' => 0,
            // 'purchase_date' => now(),
            // 'purchase_price' => 40000,
            // 'sum_selling' => 0,
            // 'sum_purchase' => 80000,




        //     'sum_purchase' => 5000,
        //     'sum_selling' => 60000,
        //     'balance' => null,
        //     'quantity' => 3,
        //     'state' => 0,
        //     'purchase_date' => now(),
        //     'selling_date' =>  null,
        //     'purchase_price' => 40000,
        //     'selling_price' => null
        // ]);

       $transaction =  Transaction::create(
[           'sum_purchase' => 489997.00,
            'sum_selling' => 60000,
            'balance' => null,
            'quantity' => 3,
            'state' => 0,
            'purchase_date' => "2021-08-16 14:57:13",
            'selling_date' =>  null,
            'purchase_price' => 62420.00,
            'selling_price' => null]
       );
       $transaction->user()->attach($user_id);
       $transaction->cryptocurrency()->attach($request->cryptocurrency_id);
       $transaction->progression()->attach($this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->id);


        $transaction->save();

        return response()->json([
            'done' => true
        ]);
    }


}
