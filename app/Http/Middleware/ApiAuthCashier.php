<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Cashier;
use function App\Helpers\api_response;


class ApiAuthCustomer
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = Cashier::where('api_token', $token)->first();
        if ($user) {
            auth()->login($user);
            return $next($request);
        }
        return api_response(false,401,"Unauthorized");
    }
}