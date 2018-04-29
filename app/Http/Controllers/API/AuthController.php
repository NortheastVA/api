<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Auth;   // Facade

class AuthController extends APIController
{
    public function __construct() {
        $this->middleware('jwt.renew')->only('getRenew');
        $this->middleware('jwt.refresh')->only('getRefresh');
    }

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

    public function getLogout() {
        // Check if using JWT
        if (\Auth::guard('jwt')->user()) {
            \Auth::guard('jwt')->logout();
        }
        // Check cookies
        if (\Auth::guard("web")->user()) {
            \Auth::guard("web")->logout();
        }
        return response()->ok();
    }

    public function getRefresh() { return response()->ok(['token' => \Auth::guard('jwt')->token ]); }
    public function getRenew() { return response()->ok(['token' => \Auth::guard('jwt')->getToken() ]); }
}
