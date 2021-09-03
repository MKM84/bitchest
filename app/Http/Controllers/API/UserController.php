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
                DB::raw("DATE_FORMAT(purchase_date, '%d/%m/%Y %H:%i:%s') as purchase_date"),
                "sum_purchase",
                DB::raw("DATE_FORMAT(selling_date, '%d/%m/%Y %H:%i:%s') as selling_date"),
                "selling_price",
                "balance"
            )
            ->where('user_id', $id)
            ->orderByDesc('transactions.updated_at')
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
                DB::raw("DATE_FORMAT(purchase_date, '%d/%m/%Y %H:%i:%s') as purchase_date"),
                "purchase_price",
                "logo",
                'transactions.id as id_transaction',
                "sum_purchase"
            )
            ->where('transactions.state', 0)
            ->where('user_id', $user_id)
            ->where('transactions.cryptocurrency_id', $crypto_id)
            ->orderByDesc('transactions.updated_at')
            ->get();

        $cryptoName = Cryptocurrency::all()->where('id', $crypto_id)->pluck('name')->toArray();
        $cryptoLogo = Cryptocurrency::all()->where('id', $crypto_id)->pluck('logo')->toArray();
        $actualValue = $this->getCurrentValueByCrypto($crypto_id);

        return ['cryptosToSellData' => ['name' => $cryptoName, 'logo' => $cryptoLogo, 'actualValue' => $actualValue, 'cryptosToSell' => $cryptosToSell]];
    }

    public function addTransaction(Request $request)
    {
        $user_id = Auth::user()->id;

        Transaction::create([
            'user_id' => $user_id,
            'cryptocurrency_id' => $request->input('cryptocurrency_id'),
            'progression_id' =>  $this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->id,
            'quantity' => $request->input('quantity'),
            'state' => 0,
            'purchase_date' => now(),
            'selling_date' => null,
            'purchase_price' => $this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->progress_value,
            'selling_price' => null,
            'sum_selling' => 0,
            'sum_purchase' => $this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->progress_value * $request->input('quantity'),
            'balance' => null,
        ]);

        $user = User::find($user_id);

        $userSolde = ($user->user_solde) - ($this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->progress_value * $request->input('quantity'));

        User::where('id', $user_id)
            ->update(['user_solde' => $userSolde]);

        return response()->json([
            'done' => true
        ]);
    }


    public function sellTransaction($idTransaction)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $transaction = Transaction::find($idTransaction);

        Transaction::where('id',  $idTransaction)->update([

            'state' => 1,
            'selling_date' => now(),
            'selling_price' => $this->getCurrentValueByCrypto($transaction->cryptocurrency_id)->progress_value,
            'sum_selling' => $this->getCurrentValueByCrypto($transaction->cryptocurrency_id)->progress_value * $transaction->quantity,
            'balance' => ($this->getCurrentValueByCrypto($transaction->cryptocurrency_id)->progress_value * $transaction->quantity) - $transaction->sum_purchase,
        ]);

        $user = User::find($user_id);

        $userSolde = ($user->user_solde) + $transaction->sum_purchase;

        User::where('id', $user_id)
            ->update(['user_solde' => $userSolde]);

        return response()->json([
            'done' => true
        ]);
    }
}
