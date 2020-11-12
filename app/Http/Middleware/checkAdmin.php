<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class checkAdmin
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

/*
        if(Auth::guard('restaurant')->id())
        {
            return $next($request);
        }       
        else if(Auth::guard('manager')->id())
        {
            return $next($request);
        }
        else{
            return view('admin.login');
        }
*/
        if(Auth::guard('restaurant')){
            return $next($request);
        }
        else if(Auth::guard('manager')){
            return $next($request);
        }
        else{
            return view('admin.login');
        }

    }
}
