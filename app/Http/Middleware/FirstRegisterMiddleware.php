<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use App\Models\Franchise;
use Auth;
use Closure;

class FirstRegisterMiddleware
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

        $user = Auth::user();
        $franchise = Franchise::where('user_id',$user->id)->count();
        if($franchise>0){
            return $next($request);
        }return redirect('register\franchise');
    }
}
