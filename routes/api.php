<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->group(function () {
    Route::post('/register','APi\Customer\Auth\RegisterController@create');
    Route::post('/login','APi\Customer\Auth\LoginController@login');
    Route::post('/login-token','APi\Customer\Auth\LoginController@login_token');
    Route::middleware('api_customer')->group(function(){

    });
});


Route::middleware('api_cashier')->get('/cashier/user', function (Request $request) {
    dd('here cashier');
    return $request->user();
});
//     Route::prefix('v1')->group(function(){
//         Route::post('/login', 'API\UserController@login');
//         Route::post('/register', 'API\UserAPIController@createOwner');
//         Route::get('/users', 'API\UserAPIController@showUsers');
//     });
