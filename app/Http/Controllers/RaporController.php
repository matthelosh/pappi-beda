<?php

namespace App\Http\Controllers;

use App\Raporpas;
use Illuminate\Http\Request;
use App\Traits\MenuTrait;
use App\Traits\NilaiTrait;

class RaporController extends Controller
{
    use MenuTrait;
    use NilaiTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function cetak(Request $request)
    {
        $siswa = 'App\Siswa'::where('nisn', $request->query('nisn'))->first();
        $sekolah = 'App\Sekolah'::where('npsn', $request->session()->get('sekolah_id'))->first();
        $tanggal_rapor = 'App\TanggalRapor'::where([
            ['sekolah_id', '=', $sekolah->npsn],
            ['periode_id', '=', $request->session()->get('periode_aktif')]
        ])->first();
        $pts = $this->rpts($request);
        $tgl_pts = 'App\TanggalRapor'::where([
            ['periode_id','=', $request->session()->get('periode_aktif')],
            ['sekolah_id','=', $request->session()->get('sekolah_id')],
            ['jenis_rapor','=','pts']
        ])->first();
        $pas = [];
        $saran = '';
        // dd($pts);
        return view('pages.guru.dashboard', ['page_title' => 'Rapor Siswa', 'menus' => $this->showMenus($request), 'siswa' => $siswa, 'sekolah' => $sekolah, 'tanggal_rapor' => $tanggal_rapor, 'pts' => $pts, 'pas' => $pas, 'saran' => $saran, 'tgl_pts' => $tgl_pts->tanggal]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Raporpas  $raporpas
     * @return \Illuminate\Http\Response
     */
    public function show(Raporpas $raporpas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Raporpas  $raporpas
     * @return \Illuminate\Http\Response
     */
    public function edit(Raporpas $raporpas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Raporpas  $raporpas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Raporpas $raporpas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Raporpas  $raporpas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Raporpas $raporpas)
    {
        //
    }
}
