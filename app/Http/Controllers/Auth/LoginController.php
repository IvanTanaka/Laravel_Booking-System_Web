<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::HOME;


    public function showAdminLoginForm()
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        Auth::guard('cashier')->logout();
        return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/admin');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function showCashierLoginForm()
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        Auth::guard('cashier')->logout();
        return view('auth.cashier_login', ['url' => 'cashier']);
    }

    public function cashierLogin(Request $request)
    {
        if (Auth::guard('cashier')->attempt(['username' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/cashier');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest','guest:admin','guest:cashier'])->except('logout');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        Auth::guard('cashier')->logout();
        return back();
    }

}
