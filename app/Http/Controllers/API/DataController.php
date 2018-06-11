<?php
namespace App\Http\Controllers\API;

use App\ActionLog;
use App\Airport;
use App\Route;
use Illuminate\Http\Request;
use Validator;

class DataController extends APIController
{
    public function getAirport(Request $request, $id) {
        $airport = Airport::find($id);
        if (!$airport) return response()->notfound();

        return response()->ok(['data' => $airport]);
    }

    public function postAirport(Request $request, $icao) {
        $validator = Validator::make($request->all(), [
            "name" => "required|max:128",
            "country" => "required|max:2",
            "lat" => "required|between:-90,90",
            "lon" => "required|between:-180,180"
        ]);
        if ($validator->fails()) return response()->malformed();

        $airport = Airport::firstOrCreate($icao);
        $airport->name = $request->input("name", $airport->name);
        $airport->country = $request->input("country", $airport->country);
        $airport->lat = $request->input("lat", $airport->lat);
        $airport->lon = $request->input("lon", $airport->lon);
        $airport->save();

        \Auth::user()->log("POST airport $icao, data " . json_encode($request->all()));

        return response()->ok();
    }

    public function deleteAirport(Request $request, $icao) {
        $airport = Airport::find($icao);
        if (!$airport) return response()->notfound();

        \Auth::user()->log("DELETE airport $icao");

        // Remove routes departing from or arriving to this destination
        Route::where("departure", $icao)->orWhere("arrival", $icao)->delete();

        $airport->delete();

        return response()->ok();
    }

    public function getRoute(Request $request, $id = null) {
        if ($id != null) {
            $route = Route::find($id);
            if (!$route) return response()->notfound();
            // Eager load the relationships so we can access the data proper
            $route->load('departureAirport', 'arrivalAirport');
            return response()->ok(['data' => [$route]]);
        }

        if (!$request->has("payload")) {
            return response()->malformed();
        }

        $payload = json_decode($request->input("payload"), true);

        $route = Route::orderBy("id", "DESC");

        if (isset($payload['id'])) {
            $route = $route->where("id", $payload['id']);
        }
        if (isset($payload['departure'])) {
            $route = $route->where("departure", $payload['departure']);
        }
        if (isset($payload['arrival'])) {
            $route = $route->where("arrival", $payload['arrival']);
        }
        if (isset($payload['aircraftType'])) {
            $route = $route->where("aircraftType", $payload['aircraftType']);
        }
        if (isset($payload['lengthMin'])) {
            $route = $route->where("timeEnroute", "<=", $payload['lengthMin'] . ":00");
        }
        if (isset($payload['lengthMax'])) {
            $route = $route->where("timeEnroute", "<=", $payload['lengthMax'] . ":00");
        }
        if (isset($payload['airlineCode'])) {
            $route = $route->where("airlineCode", $payload['airlineCode']);
        }
        if (isset($payload['flightNumber'])) {
            $route = $route->where("flightNumber", $payload['flightNumber']);
        }

        return response()->ok(['data' => $route->get()->toArray()]);
    }

    public function postRoute(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "flightNumber" => ["required", "regex:/^[0-9A-Z]{1,4}$/"],
            "sequence" => "required|between:0,99",
            "aircraftType" => "required",
            "callsign" => ["required", "regex:/^[A-Z]{3}[0-9A-Z}{1,4}$/"],
            "departure" => "required",
            "arrival" => "required",
            "daySequence" => ["required","regex:/^[1]{,1}[2]{,1}[3]{,1}[4]{,1}[5]{,1}[6]{,1}[7]{,1}","between:1,1234567"],
            "departureTime" => "required|date_format:H:i",
            "timeEnroute" => "required|date_format:H:i",
            "cruise" => "required|between:0,60000",
            "fuel" => "required|between:0,250",
            "route" => "required",
        ]);
        if ($validator->fails()) return response()->malformed();

        $departure = Airport::find($request->input("departure"));
        if (!$departure) return response()->notfound(["details" => "departure"]);
        $arrival = Airport::find($request->input("arrival"));
        if (!$arrival) return response()->notfound(["details" => "arrival"]);

        if ($id == 0) {
            $route = new Route();
        } else {
            $route = Route::find($id);
            if (!$route) return response()->notfound(["details" => "route"]);
        }
        $route->airlineCode = $request->input("airlineCode", "NEE");
        $route->flightNumber = $request->input("flightNumber");
        $route->sequence = $request->input("sequence");
        $route->aircraftType = $request->input("aircraftType");
        $route->callsign = $request->input("callsign");
        $route->departure = $request->input("departure");
        $route->arrival = $request->input("arrival");
        $route->daySequence = $request->input("daySequence");
        $route->departureTime = $request->input("departureTime");
        $route->timeEnroute = $request->input("timeEnroute");
        $route->cruise = $request->input("cruise");
        $route->fuel = $request->input("fuel");
        $route->route = $request->input("route");
        $route->remarks = $request->input("remarks");
        $route->save();

        \Auth::user()->log("POST route $id, data " . json_encode($request->all()));

        return response()->ok();
    }

    public function deleteRoute(Request $request, $id) {
        $route = Route::find($id);
        if (!$route) return response()->notfound();

        $route->delete();

        \Auth::user()->log("DELETE route $id");

        return response()->ok();
    }
}
