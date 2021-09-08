<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progressions', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal("progress_value", 8, 2);
            $table->float("rate");
            $table->date("progress_date");
            $table->timestamps();
            $table->foreignId("cryptocurrency_id")->constrained("cryptocurrencies");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progressions');
    }
}
