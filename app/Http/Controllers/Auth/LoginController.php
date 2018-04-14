<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     */
    public function authenticate(Request $request) {
        $cred = $request->only("username","password");
        if (\Auth::attempt(['email' => $cred['username'], 'password' => $cred['password']])) {
            return 'OK';
        } elseif (\Auth::attempt(['pilotID' => $cred['username'], 'password' => $cred['password']])) {
            return 'OK';
        } else {
            return response()->unauthenticated();
        }
    }
}
