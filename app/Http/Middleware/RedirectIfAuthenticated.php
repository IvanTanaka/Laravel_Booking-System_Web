<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if (Auth::guard($guard)->check()) {
            if('owner'==$guard){
                return redirect(RouteServiceProvider::HOME);
            }
            if('cashier'==$guard){
                return redirect('/cashier');
            }
            if('admin'==$guard){
                return redirect('/admin');
            }
        }

        return $next($request);
    }
}
