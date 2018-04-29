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
            $table->integer("flightNumber", 4);
            $table->integer("sequence", 1);
            $table->string("aircraftType", 4);
            $table->string("callsign", 7);
            $table->string("departure", 4);
            $table->string("arrival", 4);
            $table->string("daySequence")->comment("Format: SuMoTuWeThFrSa, any order only on active days");
            $table->time("departureTime");
            $table->time("timeEnroute");
            $table->integer("cruise", 3);
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
