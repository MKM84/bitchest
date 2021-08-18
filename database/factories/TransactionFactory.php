<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'cryptocurrency_id' => $this->faker->numberBetween(1, 10),
            'progression_id' => $this->faker->numberBetween(1, 300),
            'quantity' => $this->faker->randomFloat(2, 1, 10),
            'total_solde' => $this->faker->randomFloat(2, 1000, 30000),
            'state' => $this->faker->boolean,
            'purchase_date' => $this->faker->dateTimeBetween('-1 year','now', 'Europe/Paris' ),
            'selling_date' => $this->faker->dateTimeBetween('-1 year','now', 'Europe/Paris' ),
            'purchase_price' => $this->faker->randomFloat(2, 0, 100000),
            'selling_price' => $this->faker->randomFloat(2, 0, 100000),


        ];
    }
}
