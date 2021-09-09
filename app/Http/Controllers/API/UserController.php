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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    // Get Curent value of One Crypto
    public function getCurrentValueByCrypto($id)
    {
        $currentValueByCrypto =  DB::table('progressions')
            ->select('progress_value', 'id')
            ->where('cryptocurrency_id', $id)
            ->orderByDesc('progress_date')
            ->first();
        return $currentValueByCrypto;
    }

    // Get Wallets of one user who have connected
    public function userWallet()
    {
        $wallet_array = [];
        //Get id of User connection
        $id = Auth::user()->id;
        // Get Wallets of one user group by Crypto (sum of quantity and price_sum)
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
            // Get current value of one crypto
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
    // Get History of transaction  of one user who have connected (sell and buy)
    public function getHistory()
    {
        //Get id of User connection
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
                DB::raw("DATE_FORMAT(purchase_date, '%d/%m/%Y %H:%i:%s') as purchase_date"),
                "sum_purchase",
                DB::raw("DATE_FORMAT(selling_date, '%d/%m/%Y %H:%i:%s') as selling_date"),
                "selling_price",
                "balance"
            )->where('user_id', $id)
            ->orderByDesc('transactions.updated_at')
            ->get();

        return ['historyByCrypto' => $historyByCrypto];
    }
    // Return informations of User
    public function getUserInfos()
    {
        return ['userInfos' => Auth::user(), 'userSolde' => $this->userSold];
    }
    //Update user Info
    public function EditUserInfos($id, Request $request)
    {
        // validator request informations user
        $validator_user = Validator::make($request->all(), [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|string|email'
        ]);
        // validator request for password user
        $validator_user_password = Validator::make($request->all(), [
            'password' => 'required',
            'repeatPassword' => 'required|same:password'
        ]);
        if($validator_user->fails())
        {
            return response()->json(['done' => false]);
        }
        //Get id of User connection
        $user = User::find($id);
        if($validator_user_password->fails())
        {
            //update informations of user
            $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email')
        ]);
        }
        else{
            //update informations and password of user
            $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
            ]);
        }
        return response()->json(['done' => true]);
    }
    //

    //Get All Transactions To sell by one user who have connected
    public function getCryptosToSell($crypto_id)
    {
        //Get id of User connection
        $user_id = Auth::user()->id;

        $cryptosToSell = DB::table('transactions')
            ->join('cryptocurrencies', 'transactions.cryptocurrency_id', '=', 'cryptocurrencies.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select(
                "cryptocurrencies.name as crypto_name",
                "cryptocurrencies.id as crypto_id",
                "state",
                "quantity",
                DB::raw("DATE_FORMAT(purchase_date, '%d/%m/%Y %H:%i:%s') as purchase_date"),
                "purchase_price",
                "logo",
                'transactions.id as id_transaction',
                "sum_purchase"
            )->where('transactions.state', 0)
            ->where('user_id', $user_id)
            ->where('transactions.cryptocurrency_id', $crypto_id)
            ->orderByDesc('transactions.updated_at')
            ->get();
        // Get name of One crypto
        $cryptoName = Cryptocurrency::all()->where('id', $crypto_id)->pluck('name');
        //Get logo of One Crypto
        $cryptoLogo = Cryptocurrency::all()->where('id', $crypto_id)->pluck('logo');
        //Get current Value of Crypto
        $actualValue = $this->getCurrentValueByCrypto($crypto_id);

        return ['cryptosToSellData' => ['name' => $cryptoName, 'logo' => $cryptoLogo, 'actualValue' => $actualValue, 'cryptosToSell' => $cryptosToSell]];
    }
    public function addTransaction(Request $request)
    {
        $request->validate([
            'quantity' => 'required'
        ]);
        //Get id of User connection
        $user_id = Auth::user()->id;
        // Get info of One User
        $user = User::find($user_id);

        //Add one transaction with informations
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

        //Update user_solde where user buy crypto
        $userSolde = ($user->user_solde) - ($this->getCurrentValueByCrypto($request->input('cryptocurrency_id'))->progress_value * $request->input('quantity'));

        //Update user_solde to table users
        User::where('id', $user_id)
            ->update(['user_solde' => $userSolde]);

        return response()->json([
            'done' => true
        ]);
    }


    public function sellTransaction($idTransaction)
    {
        //Get id of User connection
        $user_id = Auth::user()->id;
        // Get info of One User
        $user = User::find($user_id);
        //Get one Transaction by $idTransaction
        $transaction = Transaction::find($idTransaction);

        //Update one transaction to change state and completely informations.
        Transaction::where('id',  $idTransaction)->update([
            'state' => 1,
            'selling_date' => now(),
            'selling_price' => $this->getCurrentValueByCrypto($transaction->cryptocurrency_id)->progress_value,
            'sum_selling' => $this->getCurrentValueByCrypto($transaction->cryptocurrency_id)->progress_value * $transaction->quantity,
            'balance' => ($this->getCurrentValueByCrypto($transaction->cryptocurrency_id)->progress_value * $transaction->quantity) - $transaction->sum_purchase,
        ]);
        //Update user_solde where user selling it transaction
        $userSolde = ($user->user_solde) + $transaction->sum_purchase;

        //Update user_solde to table users
        User::where('id', $user_id)
            ->update(['user_solde' => $userSolde]);

        return response()->json([
            'done' => true
        ]);
    }
    public function sellAllByCrypto($id)
     {

        return response()->json([
            'done' => true,
            'id' => $id
        ]);

     }
}
