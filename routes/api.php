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
        Route::prefix('store')->group(function(){
            Route::get('/','APi\Customer\FranchiseController@search');
            Route::get('{branch_id}','APi\Customer\BranchController@view');
            Route::get('{branch_id}/product','APi\Customer\MenuController@index');
            Route::post('{branch_id}/order','APi\Customer\OrderController@submit');
        });
        Route::prefix('order')->group(function(){

        });
        Route::prefix('wallet')->group(function(){
            Route::middleware('cors')->get('/', 'APi\Customer\WalletController@index');
        });
        Route::prefix('topup')->group(function(){
            Route::get('/', 'APi\Customer\TopupController@index');
            Route::middleware('cors')->post('/', 'APi\Customer\TopupController@store');
            Route::middleware('cors')->get('{topup_id}', 'APi\Customer\TopupController@view');
        });
        Route::prefix('news')->group(function(){

        });
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
