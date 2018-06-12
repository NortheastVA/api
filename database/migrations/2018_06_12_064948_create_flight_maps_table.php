<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id");
            $table->integer("booking_id");
            $table->float("lat", 10, 6);
            $table->float("lon", 11, 6);
            $table->integer("hdg");
            $table->integer("alt");
            $table->integer("spd");
            $table->string("stage");
            $table->timestamps();
        });

        Schema::table("flight_maps", function (Blueprint $table) {
            $table->foreign("user_id")
                ->references("id")->on("users")
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table->foreign("booking_id")
                ->references("id")->on("bookings")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_maps');
    }
}
