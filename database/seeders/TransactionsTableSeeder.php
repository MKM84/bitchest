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
        \App\Models\Transaction::factory(100)->create();
        // Find users that have admin status

        $admins = DB::table('users')->where('status', 'admin')->get('id')->toArray();

        // The Arr::pluck method retrieves all of the values for a given key from an array:
        $admin_ids = Arr::pluck($admins, 'id');

        // The whereIn method verifies that a given column's value is contained within the given array:
        DB::table('transactions')
            ->whereIn('user_id', $admin_ids)
            ->delete();
    }

    
    
}
