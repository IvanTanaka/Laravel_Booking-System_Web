<?php

namespace App\Http\Controllers\APi\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function App\Helpers\random_str;
use function App\Helpers\api_response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required','string','regex:/^([0-9\s\-\+\(\)]*)$/','min:10'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {
        $customerEmail = Customer::where('email',$request->email)->count();

        if($customerEmail==0){
            $user =  Customer::create([
                'name' => $request['name'],
                'email' => strtolower($request['email']),
                'phone_number' => $request['phone_number'],
                'password' => Hash::make($request['password']),
                "api_token" => random_str(100)
            ]);
            $wallet = new Wallet();
            $wallet->customer_id = $user->id;
            $wallet->save();
            return api_response(true, 200, "User registered",[ 
                "name" => $user->name,
                "email" => $user->email,
                "phone_number" => $user->phone_number,
                "token" => $user->api_token
            ]);
        }else{
            return api_response(false, 409, "This email is already registered");
        }

    }
}
