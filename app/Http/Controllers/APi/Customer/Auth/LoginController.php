<?php

namespace App\Http\Controllers\APi\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use function App\Helpers\random_str;
use function App\Helpers\api_response;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $customer = Customer::where('email',$request->email)->get();
        if(count($customer)==1){
            if(Hash::check($request->password, $customer[0]->password)){
                $customer = Customer::find($customer[0]->id);
                $customer->api_token = random_str(100);
                $customer->update();
                return api_response(
                    true,
                    200,
                    "Login success",
                    [
                        "name" => $customer->name,
                        "email" => $customer->email,
                        "phone_number" => $customer->phone_number,
                        "token" => $customer->api_token
                    ]
                    );
            }
            return api_response(false, 401, "Incorrect password.");
        }elseif(count($customer)<1){
            return api_response(false, 401, "This email is not registered yet.");
        }
        return api_response(false, 500, "Server error.");
    }

    public function login_token(Request $request){
        $customer = Customer::where('api_token',$request->token)->get();
        if(count($customer)==1){
            return api_response(true, 200, "User is authenticated.",["isLogin" => true]);
        }elseif(count($customer)<1){
            return api_response(true, 200, "User is not authenticated.",["isLogin" => false]);
        }
        return api_response(false, 500, "Server error.");
    }

}
