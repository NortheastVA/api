<?php
namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends APIController
{
    public function getUser(Request $request, $id = null) {
        if (!$id) {
            return response()->ok(['data' => User::with(['roles'])->find(\Auth::user()->id)]);
        }
        $user = User::with(['roles'])->find($id);
        if (!$user) return response()->notfound();
        return response()->ok(['data' => $user]);
    }

    public function getUserByCallsign(Request $request, $callsign) {
        $callsign = str_replace(env('AIRLINE_CODE', 'NEE'), "", $callsign);
        $user = User::with(['roles'])->where('pilotnumber', $callsign)->first();
        if (!$user) return response()->notfound();
        return response()->ok(['data' => $user]);
    }
}
