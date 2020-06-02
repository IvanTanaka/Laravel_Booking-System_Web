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

Route::middleware(['auth'])->group(function () {
    Route::middleware(['auth','first_register'])->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('stores','BranchController');
        Route::resource('menus','MenuController');
        Route::resource('cashiers','CashierController');
        Route::resource('news','NewsController');
        Route::get('/sales','OrderController@index');
    });
    Route::get('/register/franchise', 'FranchiseController@create');
    Route::post('/register/franchise', 'FranchiseController@store');
});

