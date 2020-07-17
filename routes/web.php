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
    Route::post('/', 'LoginController@login')->name('login.post');
    Route::get('/siswa', function(){
        return view('login-siswa');
    });
});

Route::get('/logout', 'LoginController@logout')->name('logout');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function() {
    Route::get('/', 'DashController@index')->name('dashboard');
});

// Menu 

Route::group(['prefix' => 'menus', 'middleware' => 'auth'], function() {
    Route::get('/', 'MenuController@index')->name('menus');
    Route::post('/', 'MenuController@store')->name('menus.store');
    Route::get('/show', 'MenuController@show')->name('menus.show');
    
});

// Users
Route::group(['prefix' => 'users', 'middleware' =>  ['auth', 'isAdmin']], function(){
	Route::get('/', 'DashController@users')->name('users.page');
    Route::post('/', 'UserController@create')->name('users.create');
    Route::post('/get', 'UserController@index')->name('users.index');
    Route::put('/', 'UserController@update')->name('users.update');
    Route::post('/import', 'UserController@import')->name('users.import');
    Route::put('/reset', 'UserController@resetAll')->name('users.resetall');
    Route::put('/reset/{nip}', 'UserController@reset')->name('users.reset');
	Route::get('/{id}', 'UserController@edit')->name('users.edit');
	Route::delete('/{id}', 'UserController@destroy')->name('users.delete');
	
});

Route::group(['prefix' => 'sekolah', 'middleware' => ['auth', 'isAdmin']], function() {
    Route::get('/', 'DashController@sekolahs')->name('sekolahs.page');
    Route::post('/', 'SekolahController@index')->name('sekolahs.index');
});


Route::group(['prefix' => 'preferences', 'middleware' => ['auth', 'isAdmin']], function () {
    Route::get('menus', 'DashController@menus')->name('preferences.menus');
});