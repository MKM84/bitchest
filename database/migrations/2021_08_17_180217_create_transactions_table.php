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
            $table->unsignedDecimal("total_solde")->default(0);
            $table->unsignedDecimal("quantity");
            $table->boolean("state")->default(0);
            $table->datetime("purchase_date");
            $table->datetime("selling_date");
            $table->unsignedDecimal("purchase_price");
            $table->unsignedDecimal("selling_price")->nullable();

            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("cryptocurrency_id")->constrained("cryptocurrencies");
            $table->foreignId("progression_id")->constrained("progressions");

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
