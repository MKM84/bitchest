<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

use \App\Models\User;
use \App\Models\Cryptocurrency;
use \App\Models\Progression;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cryptocurrencies = Cryptocurrency::pluck('id')->all(); // get all crypto in table cryptocurrencies
        $currencyId = $this->faker->randomElement($cryptocurrencies); // get random cryptocurrencies id

        // get random date between now and 30 days before
        $date_purchasing = date('Y-m-d', strtotime("-" . $this->faker->numberBetween(16, 29) . " days"));
        $date_selling = date('Y-m-d', strtotime("-" . $this->faker->numberBetween(0, 15) . " days"));

        // get Progression crypto value of purchasing
        $progression = Progression::where('cryptocurrency_id', '=', $currencyId)->where('progress_date', '=', $date_purchasing)->first();
        // get Progression crypto value of selling
        $progression_selling = Progression::where('cryptocurrency_id', '=', $currencyId)->where('progress_date', '=', $date_selling)->first();

        // Transform date "2021-08-17" to "2021-08-17 14:45:37"
        $date_purchasing = $date_purchasing . " " . $this->faker->time();
        $date_selling = $date_selling . " " . $this->faker->time();

        // get all user where status = client
        $users = User::where('status', '=', 'client')->get();
        // get id of client users
        $users = $users->pluck('id')->all();

        // faker quantity of crypto
        $quantity = $this->faker->randomFloat(2, 1, 10);

        //calcul of total solde in case of purchase
        $sum_purchase = $quantity * $progression->progress_value;

        //get purchase price with progession
        $purchase_price = $progression->progress_value;
        //get selling price with progession_selling
        $selling_price = $progression_selling->progress_value;

        // faker of state boolean true or false
        $state = $this->faker->boolean;

        if ($state == 1 ) {
             //calcul of total solde in case of selling
             $sum_selling = $quantity * $progression_selling->progress_value;
             $balance = $sum_selling - $sum_purchase;
        }else {

            $sum_selling = 0;
            $balance = null;
        }





        return [
            'user_id' => $this->faker->randomElement($users),
            'sum_selling' => $sum_selling,
            'sum_purchase' => $sum_purchase,
            'balance' => $balance,
            'cryptocurrency_id' => $currencyId,
            'progression_id' => $progression->id,
            'quantity' => $quantity,
            'state' => $state,
            'purchase_date' => $date_purchasing,
            'selling_date' => $date_selling,
            'purchase_price' => $purchase_price,
            'selling_price' => $selling_price,
        ];
    }
}
