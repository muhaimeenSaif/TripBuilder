<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->string('airline')->foreign()->references('code')->on('airlines');
            $table->integer('number')->primary();
            $table->string('departure_airport')->foreign()->references('code')->on('airports');
            $table->time('departure_time');
            $table->string('arrival_airport')->foreign()->references('code')->on('airports');
            $table->time('arrival_time');
            $table->decimal('price');
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
        Schema::dropIfExists('flights');
    }
}
