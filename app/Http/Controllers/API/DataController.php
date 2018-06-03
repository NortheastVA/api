<?php
namespace App\Http\Controllers\API;

use App\Airport;
use Illuminate\Http\Request;

class DataController extends APIController
{
    public function getAirport(Request $request, $id) {
        $airport = Airport::find($id);
        if (!$airport) return response()->notfound();

        return response()->ok(['data' => $airport]);
    }
}
