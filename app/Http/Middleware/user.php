<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::check())
        {
            if(Auth::user()->type==1)
            {
                return $next($request);

            }
            else
            {
                return redirect('/');
                //  echo 'user';
            }
        }
        else
        {
            return redirect('/');
        }
    }
}
