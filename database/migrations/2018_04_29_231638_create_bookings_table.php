<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("route_id");
            $table->enum("online", ["VATSIM", "IVAO", "Offline"]);
            $table->mediumText("route");
            $table->date("departureDate");
            $table->time("departureTime");
            $table->timestamps();
        });

        Schema::table("bookings", function (Blueprint $table) {
            $table->foreign("route")
                ->references("id")->on("routes")
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
        Schema::dropIfExists('bookings');
    }
}
