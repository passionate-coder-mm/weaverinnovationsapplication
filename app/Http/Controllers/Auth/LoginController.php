<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
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
     protected $redirectTo = '/admin-dashboard';
    // protected function redirectTo( ) {
    //     if (Auth::user()->role == 3 || Auth::user()->role == '2') {
    //         return redirect('admin-dashboard');
    //          // return $next($request);
    //      }
    //      else  {
    //          return redirect('user-dashboard');
    //      }
    //      return $next($request);
       
    // }
     

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
