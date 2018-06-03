<?php

use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("airports")->insert([
            'id' => 'PAFA',
            'name' => 'Fairbanks Intl Airport',
            'country' => 'US',
            'lat' => 0,
            'lon' => 0
        ]);
        \DB::table("airports")->insert([
            'id' => 'PANC',
            'name' => 'Anchorage Intl Airport',
            'country' => 'US',
            'lat' => 0,
            'lon' => 0
        ]);
        \DB::table("routes")->insert([
            'airlineCode' => 'NEE',
            'flightNumber' => 100,
            'sequence' => 1,
            'aircraftType' => 'B738',
            'callsign' => 'NEE100',
            'departure' => 'PAFA',
            'arrival' => 'PANC',
            'daySequence' => 'MoTuWeThFr',
            'departureTime' => '08:00',
            'timeEnroute' => '00:45',
            'cruise' => 330,
            'fuel' => 6.2,
            'route' => 'PUYVO2 PUYVO KROTO4',
            'remarks' => 'test route only',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        \DB::table("routes")->insert([
            'airlineCode' => 'NEE',
            'flightNumber' => 102,
            'sequence' => 1,
            'aircraftType' => 'B738',
            'callsign' => 'NEE102',
            'departure' => 'PAFA',
            'arrival' => 'PANC',
            'daySequence' => 'MoTuThFr',
            'departureTime' => '13:00',
            'timeEnroute' => '00:45',
            'cruise' => 330,
            'fuel' => 6.2,
            'route' => 'PUYVO2 PUYVO KROTO4',
            'remarks' => 'test route only',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
