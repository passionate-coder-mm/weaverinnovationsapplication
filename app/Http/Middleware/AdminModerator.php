<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminModerator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    { 
        // if (Auth::check() && Auth::user()->role == '1' && Auth::user()->role == '2') {
        //     // return redirect('/admindashboard');
        //     return $next($request);
        // }
        // else  {
        //     return redirect('/userdashboard');
        // }
        //return $next($request);
    }
}
