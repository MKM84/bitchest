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

use DB;

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

    // User wallet
    public function userWallet()
    {
        //initial array
        $wallet_array = [];
        
        //get id of user connect
        $id = Auth::user()->id;
        //initial Progression Model
        $progress=new Progression();
        //initiale Transaction Model
        $transaction=new Transaction();

        // get wallet of user
        $walletByUser=$transaction->getWallets($id);

        $i = 0;
        foreach ($walletByUser as $wall) {
            // get current value of crypto
            $currentvalue_of_crypto=$progress->getCurrentValueByCrypto($wall->id_crypto);

            $wallet_array[$i]["id_crypto"] = $wall->id_crypto;
            $wallet_array[$i]["name_crypto"] = $wall->name_crypto;
            $wallet_array[$i]["quantity_sum"] = $wall->quantity_sum;
            $wallet_array[$i]["prices_sum"] = $wall->prices_sum;
            $wallet_array[$i]["current_value"]=$currentvalue_of_crypto->progress_value;
         
            $i++;
        }

        // get all transactions by user connect and crypto id -> 2
        $allusertransactionsbycrypto = $transaction->getAllUserTransactionsByCrypto($id,2);
        // get all transactions to sell by user connect and crypto id -> 2
        $allusertransactionstosellbycrypto = $transaction->getAllUserTransactionsToSellByCrypto($id,2);

        //return data for vue
        return ['wallet' => $wallet_array,'allusertransactionsbycrypto' => $allusertransactionsbycrypto,
        'allusertransactionstosellbycrypto' => $allusertransactionstosellbycrypto];
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


    public function getCryptoEvolution($id) {
        $dateCryptoEvolution = Progression::all()->sortByDesc("id")->where('cryptocurrency_id', $id)->pluck('progress_date')->toArray();

        $valueCryptoEvolution = Progression::all()->sortByDesc("id")->where('cryptocurrency_id', $id)->pluck('progress_value')->toArray();

        return ['dateCryptoEvolution' => $dateCryptoEvolution, 'valueCryptoEvolution' => $valueCryptoEvolution];
    }

}
