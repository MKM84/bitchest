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
        // $id = Auth::user()->id;

        // $progession = Cryptocurrency::find(1)->progressions;
        // $trans = Transaction::find(1)->user;
        // $userTransactions = User::find($id)->transactions;
        // $userCryptos = Arr::pluck($userTransactions, 'cryptocurrency_id');

        // $cryptoCurrentValueArray = [];
        // $i = 0;
        // foreach ($userCryptos as $id) {
        //     $actualValue =  Progression::all()->sortByDesc("id")->where('cryptocurrency_id', $id)->unique('cryptocurrency_id');
        //     $cryptoCurrentValueArray[$i] = $actualValue;
        //     $i++;

        //     return ['progession' => $progession, 'trans' => $trans, 'userTransactions' => $userTransactions, 'userCryptos' => array_unique($userCryptos), 'actualValue' => $cryptoCurrentValueArray];

        // }
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

}
