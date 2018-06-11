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
            $table->integer("user_id");
            $table->integer("route_id");
            $table->enum("online", ["VATSIM", "IVAO", "POSCON", "Other", "Offline"]);
            $table->mediumText("route");
            $table->date("departureDate");
            $table->time("departureTime");
            $table->timestamps();
        });

        Schema::table("bookings", function (Blueprint $table) {
            $table->foreign("route_id")
                ->references("id")->on("routes")
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table->foreign("user_id")
                ->references("id")->on("users")
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
