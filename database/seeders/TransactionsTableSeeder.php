<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 100 transactions
        \App\Models\Transaction::factory(400)->create();

        // Modify the faker data :
        // ---------------------------

        // Get id (status => 0) in Table users
        $admins = DB::table('users')->where('status', 0)->get('id')->toArray();
        $clients = DB::table('users')->where('status', 1)->get('id')->toArray();


        // The Arr::pluck method retrieves all of the values for a given key from an array
        $admins_ids = Arr::pluck($admins, 'id');



        // The whereIn method verifies that a given column's value is contained within the given array
        // delete on table transactions all user admin
        DB::table('transactions')
            ->whereIn('user_id', $admins_ids)
            ->delete();

        // Set the selling price & date to null if there's no selling operation
        DB::table('transactions')
            ->where('state', false)
            ->update([
                'selling_price'    => null,
                'selling_date'     => null
            ]);


        // foreach ($clients as $client) {
        //     $client_id = Arr::pluck($client, 'id');
        //     $user_transaction = DB::table('transactions')
        //         ->whereIn('user_id', $client_id)
        //         ->where('state', false)
        //         ->selectRaw(
        //             'ROUND(SUM(transactions.sum_purchase), 2) as sum_purchase_client,
        //             transactions.user_id as id_user'
        //         )->groupBy('transactions.user_id')->get();
        //             if(isset($user_transaction->id_user)) {
        //                 DB::table('users')
        //                 ->where('id', $user_transaction->id_user)
        //                 ->update([
        //                     'user_solde'    => $user_transaction->sum_purchase_client
        //                 ]);
        //             }

        // }

                    $user_transactions = DB::table('transactions')
                ->where('state', false)
                ->selectRaw(
                    'ROUND(SUM(transactions.sum_purchase), 2) as sum_purchase_client,
                    transactions.user_id as id_user'
                )->groupBy('transactions.user_id')->get();

                foreach ($user_transactions as $user_transaction) {
                                            DB::table('users')
                        ->where('id', $user_transaction->id_user)
                        ->update([
                            'user_solde'    => $user_transaction->sum_purchase_client
                        ]);
                }
    }
}
