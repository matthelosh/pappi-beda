<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Traits\MenuTrait;

class DashOperatorController extends Controller
{
    use MenuTrait;

    private $menus;

    public function dashboard(Request $request)
    {
        $sekolah = 'App\Sekolah'::where('npsn', Auth::user()->sekolah_id)->first();
        $periode = 'App\Periode'::where('status', 'aktif')->first();
            session(['role' => Auth::user()->role, 'rombel_id' => 'all', 'username' =>  Auth::user()->username, 'periode_aktif' => $periode->kode_periode, 'sekolah_id' => Auth::user()->sekolah_id, 'sekolah' => $sekolah]);

        return view('pages.operator.dashboard', ['page_title' => 'Dashboard', 'menus' => $this->showMenus($request)]);
    }

    // Users Index Page
    public function users(Request $request)
    {
        $users = 'App\User'::where('sekolah_id', '=', $request->session()->get('sekolah_id'))->get();
        return view('pages.operator.dashboard', ['page_title' => 'Pengguna', 'menus' => $this->showMenus($request), 'users' => $users]);
    }

    public function siswa(Request $request)
    {
        return view('pages.operator.dashboard', ['page_title' => 'Siswa', 'menus' => $this->showMenus($request)]);
    }

    public function rombel(Request $request)
    {
        return view('pages.operator.dashboard', ['page_title' => 'Rombel', 'menus' => $this->showMenus($request)]);
    }

}
