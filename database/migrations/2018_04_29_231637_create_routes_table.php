<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("airlineCode", 3);
            $table->integer("flightNumber");
            $table->integer("sequence");
            $table->string("aircraftType", 4);
            $table->string("callsign", 7);
            $table->string("departure", 4);
            $table->string("arrival", 4);
            $table->string("daySequence")->comment("Format: 1234567 (1 Mon, 2 Tue, 3 Wed, 4 Thu, 5 Fri, 6 Sat, 7 Sun");
            $table->time("departureTime");
            $table->time("timeEnroute");
            $table->integer("cruise");
            $table->float("fuel", 10, 2)->comment("In metric tons");
            $table->mediumText("route");
            $table->string("remarks");
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
        Schema::dropIfExists('routes');
    }
}
