<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< HEAD
=======
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
>>>>>>> 2d6c64693df82a4d5f58b664ad41b57e156ad900

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        //
=======
        \App\Models\Transaction::factory(100)->create();
        // Find users that have admin status

        $admins = DB::table('users')->where('status', 'admin')->get('id')->toArray();
        // The Arr::pluck method retrieves all of the values for a given key from an array:
        $admin_ids = Arr::pluck($admins, 'id');

        // The whereIn method verifies that a given column's value is contained within the given array:
        DB::table('transactions')
            ->whereIn('user_id', $admin_ids)
            ->delete();
>>>>>>> 2d6c64693df82a4d5f58b664ad41b57e156ad900
    }
}
