<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    // baris ini dihapus:
    // protected $redirectTo = '/home';
    // diganti dengan:
	protected function redirectTo( ) {
		if (Auth::check() && Auth::user()->role == 'admin') {
			return redirect('/admin');
		}
		elseif (Auth::check() && Auth::user()->role == 'staf') {
			return redirect('/staf');
		}
		else {
			return redirect('/login');
		}
	}


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
