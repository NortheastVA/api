<?php
namespace App\Http\Controllers\API;

use App\Airport;
use App\Route;
use Illuminate\Http\Request;

class DataController extends APIController
{
    public function getAirport(Request $request, $id) {
        $airport = Airport::find($id);
        if (!$airport) return response()->notfound();

        return response()->ok(['data' => $airport]);
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
}
