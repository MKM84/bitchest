<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sum_purchase',
        'sum_selling',
        'balance',
        'quantity',
        'state',
        'purchase_date',
        'selling_date',
        'purchase_price',
        'selling_price'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cryptocurrency() {
        return $this->hasOne(Cryptocurrency::class);
    }

    public function progression() {
        return $this->hasOne(Progression::class);
    }

    // function return all transactions by one user and one crypto
    // public function getAllUserTransactionsByCrypto($id,$id_crypto){
    //     $alluser_transactions_bycrypto = DB::table('transactions')
    //     ->join('cryptocurrencies', 'transactions.cryptocurrency_id', '=', 'cryptocurrencies.id')
    //     ->join('users', 'transactions.user_id', '=', 'users.id')
    //     ->select("cryptocurrencies.name as name_crypto","state","quantity","purchase_date"
    //     ,"purchase_price","selling_date","selling_price","balance")
    //     ->where('user_id', $id)
    //     ->where('transactions.cryptocurrency_id', $id_crypto)
    //     ->get();


    //     return $alluser_transactions_bycrypto;
    // }
    //function return all crypto to sell by user and crypto
    public function getAllUserTransactionsToSellByCrypto($id,$id_crypto){
        $alluser_transactions_to_sell_bycrypto = DB::table('transactions')
        ->join('cryptocurrencies', 'transactions.cryptocurrency_id', '=', 'cryptocurrencies.id')
        ->join('users', 'transactions.user_id', '=', 'users.id')
        ->select("cryptocurrencies.name as name_crypto","state","quantity","purchase_date"
        ,"purchase_price","selling_date","selling_price","balance")
        ->where('transactions.state',0)
        ->where('user_id', $id)
        ->where('transactions.cryptocurrency_id', $id_crypto)
        ->get();

        return $alluser_transactions_to_sell_bycrypto;
    }

}
