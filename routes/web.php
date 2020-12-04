<?php

use App\Http\Controllers\RombelController;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::user()->level == 'admin') {
            return redirect('/dashboard');
        } else {
            return redirect('/'.Auth::user()->username.'/dashboard');
        }
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

// Route Admin

    Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function() {
        // dd($request->session->all());
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
        Route::post('/create', 'UserController@create')->name('users.create');
        Route::post('/', 'UserController@index')->name('users.index');
        Route::put('/', 'UserController@update')->name('users.update');
        Route::post('/import', 'UserController@import')->name('users.import');
        Route::put('/reset', 'UserController@resetAll')->name('users.resetall');
        Route::put('/reset/{nip}', 'UserController@reset')->name('users.reset');
        Route::get('/{id}', 'UserController@edit')->name('users.edit');
        Route::delete('/{id}', 'UserController@destroy')->name('users.delete');
        
    });

    Route::group(['prefix' => 'sekolah', 'middleware' => ['auth']], function() {
        Route::get('/', 'DashController@sekolahs')->name('sekolahs.page');
        Route::post('/', 'SekolahController@index')->name('sekolahs.index');
    });

    Route::group(['prefix' => 'rombels', 'middleware' => ['auth']], function(){
        Route::get('/', 'DashController@rombels')->name('rombels.page')->middleware('isAdmin');
        Route::post('/', 'RombelController@index')->name('rombels.index');
        Route::post('/create', 'RombelController@create')->name('rombels.create')->middleware('isAdmin');
        Route::post('/import', 'RombelController@import')->name('rombels.import')->middleware('isAdmin');
        Route::post('/update', 'RombelController@update')->name('rombels.update')->middleware('isAdmin');
        Route::delete('/{id}', 'RombelController@delete')->name('rombels.delete')->middleware('isAdmin');
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

    Route::group(['prefix' => 'mapels', 'middleware' => ['auth']], function() {
        Route::get('/', 'DashController@mapels')->name('mapels.page');
        Route::post('/', 'MapelController@index')->name('mapels.index');
        Route::post('/create', 'MapelController@create')->name('mapels.create');
        Route::post('/import', 'MapelController@import')->name('mapels.import');
        Route::put('/{id}', 'MapelController@update')->name('mapels.update');
        Route::delete('/{id}', 'MapelController@destroy')->name('mapels.delete');
    });

    // Ekskul Admin
    Route::group(['prefix' => 'ekskul', 'middleware' => ['auth', 'isAdmin']], function() {
        Route::get('/', 'DashController@ekskul')->name('ekskul.page');
    });
    // Kd
    Route::group(['prefix' =>'kds', 'middleware' => ['auth']], function() {
        Route::get('/', 'DashController@kds')->name('kds.page');
        Route::post('/', 'KdController@index')->name('kds.index');
        Route::post('/create', 'KdController@create')->name('kds.create');
        Route::post('/import', 'KdController@import')->name('kds.import');
        Route::put('/{id}', 'KdController@update')->name('kds.update');
        Route::delete('/{id}', 'KdController@destroy')->name('kds.delete');
    });

    // Periode
        Route::group(['prefix' => 'periode', 'middleware' => ['auth']], function(){
            Route::get('/', 'DashController@periode')->name('periode.page');
            Route::post('/', 'PeriodeController@index')->name('periode.index');
            Route::post('/create', 'PeriodeController@create')->name('periode.create');
            Route::post('/import', 'PeriodeController@import')->name('periode.import');
            Route::put('/activate/{id}', 'PeriodeController@activate')->name('periode.activate');
            Route::put('/{id}', 'PeriodeController@import')->name('periode.update');
            Route::delete('/{id}', 'PeriodeController@destroy')->name('periode.delete');
        });

    // Tanggal Rapor
        Route::group(['prefix' => 'tanggal-rapor', 'middleware' => ['auth', 'isAdmin']], function(){
            Route::get('/', 'DashController@tanggalRapor')->name('tanggal-rapor.page');
            Route::post('/', 'TanggalRaporController@index')->name('tanggal-rapor.index');
            Route::post('/create', 'TanggalRaporController@create')->name('tanggal-rapor.create');
            Route::get('/{id}', 'TanggalRaporController@show')->name('tanggal-rapor.show');
            Route::put('/{id}', 'TanggalRaporController@update')->name('tanggal-rapor.update');
            Route::delete('/{id}', 'TanggalRaporController@destroy')->name('tanggal-rapor.delete');
        });

    // Backup
        Route::group(['prefix' => 'backup', 'middleware' =>['auth', 'isAdmin']], function(){
            Route::get('/', 'DashController@backup')->name('backup.page');
        });

    // Restore
        Route::group(['prefix' => 'restore', 'middleware' =>['auth', 'isAdmin']], function(){
            Route::get('/', 'DashController@restore')->name('restore.page');
        });
    Route::group(['prefix' => 'preferences', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('menus', 'DashController@menus')->name('preferences.menus');
    });

    Route::group(['prefix' => 'logs', 'middleware' => ['auth', 'isAdmin']], function(){
        Route::get('/', 'DashController@logs')->name('logs');
        Route::post('/', 'LogInfoController@index')->name('logs.index');
    });

// Route Operator
    Route::group(['prefix' => 'operator', 'middleware' => ['auth','isOperator']], function(){
        Route::group(['prefix' => '{sekolah_id}', 'middleware' => ['auth', 'isOperator']], function(){
            Route::get('/dashboard', 'DashOperatorController@dashboard')->name('operator.dashboard');

            Route::group(['prefix'=> 'users', 'middleware' => ['auth','isOperator']], function(){
                Route::get('/', 'DashOperatorController@users')->name('operator.users');
                Route::post('/', 'UserController@index')->name('operator.users.create');
                Route::post('/create', 'UserController@create')->name('operator.users.create');
                Route::put('/', 'UserController@update')->name('operator.users.update');
                Route::post('/import', 'UserController@import')->name('operator.users.import');
                Route::post('/get', 'UserController@index')->name('operator.users.index');
                Route::get('/edit', 'UserController@edit')->name('operator.users.edit');
                Route::delete('/', 'UserController@destroy')->name('operator.users.delete');
            });

            Route::group(['prefix' => 'siswas', 'middleware' => ['auth', 'isOperator']], function(){
                Route::get('/', 'DashOperatorController@siswa')->name('operator.siswa');
                Route::post('/', 'SiswaController@index')->name('operator.siswa.index');
                Route::post('/create', 'SiswaController@create')->name('operator.siswa.create');
                Route::post('/import', 'SiswaController@import')->name('operator.siswa.import');
                Route::put('/{id}', 'SiswaController@update')->name('operator.siswa.update');
                Route::delete('/{id}', 'SiswaController@destroy')->name('operator.siswa.delete');
            });

            Route::group(['prefix' => 'rombels', 'middleware' => ['auth','isOperator']], function(){
                Route::get('/', 'DashOperatorController@rombel')->name('operator.rombel');
                Route::post('/', 'RombelController@index')->name('operator.rombel.index');
                Route::post('/create', 'RombelController@create')->name('operator.rombel.create');
                Route::post('/import', 'RombelController@import')->name('operator.rombel.import');
            });
        });
    });

// Route Guru
    Route::group(['prefix' => '{username}', 'middleware' => ['auth', 'isGuru']], function(){
        Route::get('/dashboard', 'DashGuruController@dashboard')->name('guru.dashboard');

        Route::group(['prefix' => 'siswaku'], function(){
            Route::get('/', 'DashGuruController@siswaku')->name('siswaku.page');
            Route::post('/', 'SiswaController@index')->name('siswaku.index'); 
            Route::post('/ortu/create', 'OrtuController@create')->name('siswaku.ortu.create');
            Route::put('/ortu/{id}', 'OrtuController@update')->name('siswaku.ortu.update');
            Route::post('/{nisn}/ortu', 'OrtuController@edit')->name('siswaku.ortu.edit');
            Route::put('/{id}', 'SiswaController@update')->name('siswaku.update');
        });
        Route::group(['prefix' => 'mapelku'], function(){
            Route::get('/', 'DashGuruController@mapelku')->name('mapelku.page');
            Route::post('/', 'MapelController@index')->name('mapelku.index');
        });
        Route::group(['prefix' => 'kdku'], function(){
            Route::get('/', 'DashGuruController@kdku')->name('kdku.page');
            Route::post('/', 'KdController@index')->name('kdku.index');
            Route::post('/import', 'KdController@import')->name('kdku.index');
        });

        Route::group(['prefix' => 'kkm', 'middleware'=>['auth', 'isGuru']], function() {
            Route::get('/', 'DashGuruController@kkm')->name('kkm.page');
            Route::post('/', 'KkmController@index')->name('kkm.index');
            Route::post('/create', 'KkmController@create')->name('kkm.create');
        });

        Route::group(['prefix' => 'nilais', 'middleware' => ['auth', 'isGuru']], function() {
            Route::post('/', 'NilaiController@index')->name('nilais.index');
            Route::get('/format', 'NilaiController@unduhFormat')->name('nilais.format.unduh');
            Route::get('/entri', 'DashGuruController@entriNilai')->name('nilais.page');
            Route::get('/rekap', 'DashGuruController@rekapNilai')->name('nilais.rekap.page');
            Route::post('/rekap', 'NilaiController@rekap')->name('nilais.rekap.index');
            Route::post('/entri', 'NilaiController@entri')->name('nilais.entri');
            Route::post('/import', 'NilaiController@import')->name('nilais.import');
            Route::put('/update', 'NilaiController@update')->name('nilais.update');
        });

        Route::group(['prefix' => 'jurnals', 'middleware' => ['auth', 'isGuru']], function() {
            Route::get('/', 'DashGuruController@jurnal')->name('jurnals.page');
            Route::post('/', 'JurnalController@index')->name('jurnals.index');
            Route::post('/create', 'JurnalController@create')->name('jurnals.create');
            Route::get('/{id}', 'JurnalController@show')->name('jurnals.show');
            Route::put('/{id}', 'JurnalController@update')->name('jurnals.update');
            Route::delete('/{id}', 'JurnalController@destroy')->name('jurnals.delete');
        });

        Route::group(['prefix' => 'rapor', 'middleware' => ['auth', 'isGuru']], function(){
            Route::get('/', 'DashGuruController@rapor')->name('rapor.page');
            // Route::get('/', 'DashGuruController@rapor')->name('rapor.page');
            Route::get('/cetak', 'RaporController@cetak')->name('rapor.cetak');
            Route::post('/data/saran', 'RaporController@createSaran')->name('rapor.create.saran');
            Route::post('/data/fisik','RaporController@saveFisik')->name('rapor.save.fisik');
            Route::post('/data/kesehatan','RaporController@saveKesehatan')->name('rapor.save.kesehatan');
            Route::post('/data/prestasi','RaporController@savePrestasi')->name('rapor.save.prestasi');
            Route::post('/data/absensi','RaporController@saveAbsensi')->name('rapor.save.absensi');
        });

        Route::group(['prefix' => 'ekskul', 'middleware' => ['auth', 'isGuru']], function(){
            Route::post('/', 'EkskulController@saveNilai')->name('ekskul.saveNilai');
        });

        Route::group(['prefix' => 'tema', 'middleware' => ['auth']], function(){
            Route::get('/', 'DashGuruController@tema')->name('tema.page');
            Route::post('/', 'TemaController@index')->name('tema.index');
        });

        Route::group(['prefix' => 'subtema', 'middleware' => ['auth', 'isGuru']], function(){
            Route::post('/', 'SubtemaController@index')->name('subtema.index');
        });

        Route::group(['prefix' => 'pemetaan', 'middleware'=>['auth', 'isGuru']], function(){
            Route::post('/', 'PemetaanController@index')->name('pemetaan.index');
            Route::put('/{subtema_id}/{mapel_id}', 'PemetaanController@update')->name('pemetaan.update');
        });

    });

