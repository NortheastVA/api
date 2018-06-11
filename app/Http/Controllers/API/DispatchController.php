<?php
namespace App\Http\Controllers\API;

use App\ActionLog;
use App\Airport;
use App\Booking;
use App\Helpers\RoleHelper;
use App\Route;
use Illuminate\Http\Request;
use Validator;

class DispatchController extends APIController
{
    public function getBooking(Request $request, $id = null) {
        if ($id == null) {
            $booking = Booking::where("user_id", \Auth::user()->id)->get()->toArray();
        } else {
            $booking = Booking::find($id);
            if ($booking->user_id != \Auth::user()->id && !RoleHelper::roleForAction("HR")) {
                return response()->forbidden();
            }
            if (!$booking) return response()->notfound();
        }

        return response()->ok(['data' => $booking]);
    }

    public function postBooking(Request $request) {
        $validator = Validator::make($request->all(), [
            "route_id" => "required|integer",
            "online" => "required",
            "departureDate" => "required|date_format:Y-m-d",
            "departureTime" => "required|date_format:H:i"
        ]);
        if ($validator->fails()) return response()->malformed();

        $route = Route::find($request->input("route_id"));
        if (!$route) return response()->notfound(["details" => "route"]);

        $booking = new Booking();
        $booking->user_id = \Auth::user()->id;
        $booking->route_id = $route->id;
        $booking->online = $request->input("online");
        $booking->route = $request->input("route", $route->route);
        $booking->departureDate = $request->input("departureDate");
        $booking->departureTime = $request->input("departureTime");
        $booking->save();

        return response()->ok();
    }

    public function deleteBooking(Request $request, $id) {
        $booking = Booking::find($id);
        if (!$booking) return response()->notfound();

        if ($booking->user_id != \Auth::user()->id && !\Auth::user()->hasRole(RoleHelper::roleForAction("HR"))) {
            return response()->forbidden();
        }

        // Log HR action
        if ($booking->user_id != \Auth::user()->id) {
            \Auth::user()->log("DELETE booking $id (route $booking->route_id) for user $booking->user_id $booking->user->fullname");
        }

        $booking->delete();

        return response()->ok();
    }
}
