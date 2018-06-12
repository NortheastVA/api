<?php
namespace App\Helpers;

use App\Booking;
use App\FlightLog;
use App\FlightMap;

class ACARSHelper {
    public static $cmd = [
        'position' => "\App\Helpers\ACARSHelper::position",
        'close' => "\App\Helpers\ACARSHelper::close"
    ];

    public static function position($data) {
        $position = FlightMap::where('user_id', \Auth::user()->id)->first();
        if (!$position) $position = new FlightMap(["user_id" => \Auth::user()->id]);
        $position->booking_id = $data->booking;
        $position->lat = $data->lat;
        $position->lon = $data->lon;
        $position->hdg = $data->hdg;
        $position->alt = $data->alt;
        $position->spd = $data->spd;
        $position->stage = $data->stage;
        $position->save();

        return "OK";
    }

    public static function close($data) {
        $position = FlightMap::where('user_id', \Auth::user()->id)->first();
        $booking = Booking::find($data->booking);
        if (!$booking) return "FAIL INVALID BOOKING";
        if ($position) $position->delete();

        /*
         * @TODO: Insert signature check here.
         */

        $flightlog = new FlightLog();
        $flightlog->user_id = \Auth::user()->id;
        $flightlog->callsign = $booking->routeInfo->callsign;
        $flightlog->departure = $booking->routeInfo->departure;
        $flightlog->arrival = $booking->routeInfo->arrival;
        $flightlog->route = $booking->route;
        $flightlog->remarks = $booking->remarks;
        $flightlog->obt = $data->obt;
        $flightlog->log = $data->flightlog;
        $flightlog->save();

        $booking->delete();

        return "OK";
    }
}
