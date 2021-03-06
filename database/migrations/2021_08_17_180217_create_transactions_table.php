<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade")->default(0);
            $table->foreignId("cryptocurrency_id")->constrained("cryptocurrencies")->default(0);
            $table->foreignId("progression_id")->constrained("progressions")->nullable();
            $table->unsignedDecimal("quantity");
            $table->boolean("state")->default(0);
            $table->datetime("purchase_date");
            $table->datetime("selling_date")->nullable();
            $table->unsignedDecimal("purchase_price",8, 2);
            $table->unsignedDecimal("selling_price", 8, 2)->nullable();
            $table->unsignedDecimal("sum_selling", 30, 2)->default(0);
            $table->unsignedDecimal("sum_purchase", 30, 2)->default(0);
            $table->decimal("balance", 30, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
