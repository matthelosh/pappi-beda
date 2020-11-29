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
        $periode = 'App\Periode'::where('status', 'aktif')->first();
            session(['role' => Auth::user()->role, 'rombel_id' => 'all', 'username' =>  Auth::user()->username, 'periode_aktif' => $periode->kode_periode, 'sekolah_id' => Auth::user()->sekolah_id]);

        return view('pages.operator.dashboard', ['page_title' => 'Dashboard', 'menus' => $this->showMenus($request)]);
    }

    // Users Index Page
    public function users(Request $request)
    {
        $users = 'App\User'::where('sekolah_id', '=', $request->session()->get('sekolah_id'))->get();
        return view('pages.operator.dashboard', ['page_title' => 'Pengguna', 'menus' => $this->showMenus($request), 'users' => $users]);
    }

    function menus(Request $request)
    {
        $datas = 'App\Menu'::paginate(10);
        return view('pages.admin.dashboard', ['page_title' => 'Menu', 'menus' => $this->showMenus($request), 'datas' => $datas]);
    }

    public function sekolahs(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Data Sekolah', 'menus' => $this->showMenus($request)]);
    }

    public function rombels(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Data Rombel', 'menus' => $this->showMenus($request)]);
    }

    public function siswas(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Data Siswa', 'menus' => $this->showMenus($request)]);
    }

    public function mapels(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Data Mapel', 'menus' => $this->showMenus($request)]);
    }

    public function kds(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Data Kompetensi', 'menus' => $this->showMenus($request)]);
    }

    public function periode(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Data Periode', 'menus' => $this->showMenus($request)]);
    }

    public function tanggalRapor(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Tanggal Rapor', 'menus' => $this->showMenus($request)]);
    }

    public function ekskul(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Ekstrakurikuler', 'menus' => $this->showMenus($request)]);
    }
}
