<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Traits\MenuTrait;

class DashGuruController extends Controller
{
    use MenuTrait;

    private $menus;
    public function dashboard(Request $request)
    {
        $sekolah = 'App\Sekolah'::where('npsn', Auth::user()->sekolah_id)->first();
        $rombel = 'App\Rombel'::where('guru_id', Auth::user()->nip)->first();
        $periode = 'App\Periode'::where('status', 'aktif')->first();
        if($rombel) {
            // session(['role' => 'wali', 'rombel_id' => $rombel->kode_rombel, 'username' =>  Auth::user()->username, 'periode_aktif' => $periode->kode_periode, 'sekolah_id' => Auth::user()->sekolah_id, 'sekolah' => $sekolah, 'rombel' => $rombel]);
            $jurnals = [];
            // $jurnals = 'App\Jurnal'::where([
            //     ['periode_id' ,'=', $periode->kode_periode],
            //     ['rombel_id', '=', $rombel->kode_rombel]
            // ])->with('siswas')->get();
        } else {
            if(Auth::user()->role == 'gpai') {
                $jurnals = 'App\Jurnal'::where('periode_id', '=', $periode->kode_periode);
            } else {
                $jurnals = (Object) [];
            }
            session(['role' => Auth::user()->role, 'rombel_id' => 'all', 'username' =>  Auth::user()->username, 'periode_aktif' => $periode->kode_periode, 'sekolah_id' => Auth::user()->sekolah_id, 'sekolah' => $sekolah]);
        }

    //    dd($request->session->all());
        return view('pages.guru.dashboard', ['page_title' => 'Dashboard', 'menus' => $this->showMenus($request), 'jurnals' => $jurnals]);
    }

    // Users Index Page

    public function siswaku(Request $request)
    {
        return view('pages.guru.dashboard', ['page_title' => 'Data Siswa', 'menus' => $this->showMenus($request)]);
    }

    public function mapelku(Request $request)
    {
        return view('pages.guru.dashboard', ['page_title' => 'Data Mapel', 'menus' => $this->showMenus($request)]);
    }

    public function kdku(Request $request)
    {
        return view('pages.guru.dashboard', ['page_title' => 'Data Kompetensi', 'menus' => $this->showMenus($request)]);
    }

    public function kkm(Request $request)
    {
        return view('pages.guru.dashboard', ['page_title' => 'Data KKM', 'menus' => $this->showMenus($request)]);
    }

    public function entriNilai(Request $request)
    {
       return view('pages.guru.dashboard', ['page_title' => 'Entri Nilai', 'menus' => $this->showMenus($request)]);
    }
    public function rekapNilai(Request $request)
    {
       return view('pages.guru.dashboard', ['page_title' => 'Rekap Nilai', 'menus' => $this->showMenus($request)]);
    }

    public function jurnal(Request $request)
    {
        return view('pages.guru.dashboard', ['page_title' => 'Jurnal Sikap', 'menus' => $this->showMenus($request)]);
    }

    public function rapor(Request $request)
    {
        $siswas = 'App\Siswa'::where('rombel_id', $request->session()->get('rombel_id'))->get();
        return view('pages.guru.dashboard', ['page_title' => 'Cetak Rapor', 'menus' => $this->showMenus($request), 'siswas' => $siswas]);
    }

    public function tema(Request $request)
    {
        return view('pages.guru.dashboard', ['page_title' => 'Tema' , 'menus' => $this->showMenus($request)]);
    }

    public function periode(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Data Periode', 'menus' => $this->showMenus($request)]);
    }

    public function tanggalRapor(Request $request)
    {
        return view('pages.admin.dashboard', ['page_title' => 'Tanggal Rapor', 'menus' => $this->showMenus($request)]);
    }

    public function profil(Request $request)
    {
        return view('pages.guru.dashboard', ['page_title' => 'Profil', 'menus' => $this->showMenus($request)]);
    }

    public function cetakNisn(Request $request)
    {
        $siswas = 'App\Siswa'::where([
            ['sekolah_id','=', $request->session()->get('sekolah_id')],
            ['rombel_id','=', $request->query('rombel')]
        ])->with('ortus')->get();
        return view('pages.misc.kartu_nisn', ['siswas' => $siswas, 'sekolah' => $request->session()->get('sekolah')]);
    }
}
