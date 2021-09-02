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
        \App\Models\Transaction::factory(100)->create();

    // Modify the faker data :
    // ---------------------------

        // Delete users that have admin status
        $admins = DB::table('users')->where('status', 0)->get('id')->toArray();

        // The Arr::pluck method retrieves all of the values for a given key from an array
        $admins_ids = Arr::pluck($admins, 'id');

        // The whereIn method verifies that a given column's value is contained within the given array
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


            $soldeUsersTotal = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->selectRaw("
            transactions.user_id as id_user,
            ROUND(SUM(transactions.sum_purchase), 2) as totalsolde")
            ->where('transactions.state', 0)
            ->groupBy('transactions.user_id')
            ->get();

            foreach($soldeUsersTotal as $soldeUserTotal){

                DB::table('users')
            ->where('id', $soldeUserTotal->id_user)
            ->update([
                'user_solde'    => $soldeUserTotal->totalsolde
            ]);
        }

        // // Calculate the sum in case of selling
        // DB::update("UPDATE `transactions` SET `sum` = `quantity` * `selling_price` WHERE `state` = 1");

        // // Calculate the sum in case of purchase
        // DB::update("UPDATE `transactions` SET `sum` = `quantity` * `purchase_price` WHERE `state` = 0");
    }



}
