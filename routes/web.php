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

Route::get('/', function() {
    if(Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

Route::group(['prefix' => 'login'], function(){
    Route::get('/', 'LoginController@index')->name('login');
    Route::post('/', 'LoginController@login')->name('post-login');
});

Route::get('/logout', 'LoginController@logout');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function() {
    Route::get('/', 'DashController@index')->name('dashboard');
});
