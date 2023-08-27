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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function authenticated( Request $request, $user ) {

        if($user->lock){
            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();

            return redirect()->back()
                             ->withErrors(["inactive" => "Whoops! Looks like your account isn locked."]);
        }

        if($user->suspend){
            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();

            return redirect()->back()
                             ->withErrors(["inactive" => "Whoops! Looks like your account isn suspended."]);
        }

        return redirect()->intended($this->redirectPath());   
    }
}
