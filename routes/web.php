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

Route::group(['prefix' => 'rombels', 'middleware' => ['auth', 'isAdmin']], function(){
    Route::get('/', 'DashController@rombels')->name('rombels.page');
    Route::post('/', 'RombelController@index')->name('rombels.index');
    Route::post('/create', 'RombelController@create')->name('rombels.create');
    Route::post('/import', 'RombelController@import')->name('rombels.import');
    Route::post('/update', 'RombelController@update')->name('rombels.update');
    Route::delete('/{id}', 'RombelController@delete')->name('rombels.delete');
});

Route::group(['prefix' => 'siswas', 'middleware' => ['auth', 'isAdmin']], function() {
    Route::get('/', 'DashController@siswas')->name('siswas.page');
    Route::post('/', 'SiswaController@index')->name('siswas.index');
    Route::post('/create', 'SiswaController@create')->name('siswas.create');
    Route::post('/import', 'SiswaController@import')->name('siswas.import');
    Route::post('/out', 'SiswaController@out')->name('siswas.out');
    Route::post('/in', 'SiswaController@in')->name('siswas.in');
    Route::post('/pindah', 'SiswaController@pindah')->name('siswas.pindah');
    Route::put('/{id}', 'SiswaController@update')->name('siswas.update');
    Route::delete('/{id}', 'SiswaController@destroy')->name('siswas.delete');
});
Route::group(['prefix' => 'ortus', 'middleware' => ['auth', 'isAdmin']], function() {
    // Route::get()
    Route::put('/{id}', 'OrtuController@update')->name('ortus.update');
    Route::post('/siswa/{nisn}', 'OrtuController@edit')->name('ortus.edit');
    Route::post('/create', 'OrtuController@create')->name('ortus.create');
});

Route::group(['prefix' => 'mapels', 'middleware' => ['auth', 'isAdmin']], function() {
    Route::get('/', 'DashController@mapels')->name('mapels.page');
    Route::post('/', 'MapelController@index')->name('mapels.index');
    Route::post('/create', 'MapelController@create')->name('mapels.create');
    Route::post('/import', 'MapelController@import')->name('mapels.import');
    Route::put('/{id}', 'MapelController@update')->name('mapels.update');
    Route::delete('/{id}', 'MapelController@destroy')->name('mapels.delete');
});


Route::group(['prefix' => 'preferences', 'middleware' => ['auth', 'isAdmin']], function () {
    Route::get('menus', 'DashController@menus')->name('preferences.menus');
});