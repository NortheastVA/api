<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Auth;   // Facade
class AuthController extends APIController
{
    public function getLogin(Request $request) {
        $ok = false;
        $cred = $request->only("username","password");
        if (Auth::attempt(['email' => $cred['username'], 'password' => $cred['password']])) {
            $ok = true;
        } elseif (Auth::attempt([
            'pilotnumber' => str_replace(env('AIRLINE_CODE', 'ZZZ'), '', $cred['username']),
            'password' => $cred['password']])) {

            $ok = true;
        }

        if ($ok) {
            if ($request->has("token")) {
                $token = Auth::guard('jwt')->login(\Auth::user());

                return response()->json([
                    'status' => 'OK',
                    'token' => $token
                ]);
            } else {
                return response()->json(["status" => "OK"]);
            }
        } else {
            return response()->unauthenticated();
        }
    }
}
