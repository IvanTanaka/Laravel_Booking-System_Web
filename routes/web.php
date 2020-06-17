<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/login/cashier', 'Auth\LoginController@showCashierLoginForm');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/cashier', 'Auth\LoginController@cashierLogin');

Route::prefix('/admin')->group(function(){
    Route::get('/', 'Admin\HomeController@index');
    Route::prefix('redeem')->group(function(){
        Route::get('/', 'Admin\RedeemController@index');
        Route::get('/{redeem_id}/accept', 'Admin\RedeemController@accept');
        Route::get('/{redeem_id}/reject', 'Admin\RedeemController@reject');
    });
    Route::get('/category', 'Admin\CategoryController@index');
    Route::post('/category/update', 'Admin\CategoryController@update');
});

Route::prefix('/cashier')->group(function(){
    Route::get('/', 'Cashier\HomeController@index');
    Route::get('/order', 'Cashier\OrderController@index');
    Route::get('/today/order', 'Cashier\OrderController@index');
    Route::get('/order/{order_id}/accept', 'Cashier\OrderController@accept');
    Route::get('/order/{order_id}/reject', 'Cashier\OrderController@reject');
});
Route::middleware(['auth'])->group(function () {
    Route::middleware(['first_register'])->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('stores','BranchController');
        Route::resource('menus','MenuController');
        Route::resource('cashiers','CashierController');
        Route::resource('news','NewsController');
        Route::get('sales','OrderController@index');
        Route::get('redeem','RedeemController@index');
    });
    Route::get('/register/franchise', 'FranchiseController@create');
    Route::post('/register/franchise', 'FranchiseController@store');
});

