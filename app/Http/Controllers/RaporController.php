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
        $sekolah = 'App\Sekolah'::where('npsn', $request->session()->get('sekolah_id'))->with('ks')->first();
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
        $tgl_pas = 'App\TanggalRapor'::where([
            ['periode_id','=', $request->session()->get('periode_aktif')],
            ['sekolah_id','=', $request->session()->get('sekolah_id')],
            ['jenis_rapor','=','pas']
        ])->first();
        $pas = $this->rpas($request);
        $sarans = $this->saran($request);
        $ekskuls = $this->ekskul($request);
        // dd($pts);
        $sikaps = $this->sikap($request);
        return view('pages.guru.dashboard', [
            'page_title' => 'Rapor Siswa', 
            'menus' => $this->showMenus($request), 
            'siswa' => $siswa, 
            'sekolah' => $sekolah, 
            'tanggal_rapor' => [
                'pts' => ($tgl_pts) ?  $tgl_pts->tanggal : date('Y-m-d'),
                'pas' => ($tgl_pas) ? $tgl_pas->tanggal : date('Y-m-d')
            ], 
            'pts' => $pts, 
            'pas' => $pas, 
            'sarans' => $sarans, 
            'sikaps' => $sikaps, 
            'ekskuls' => $ekskuls,
            'fisik' => $this->fisik($request),
            'prestasis' => [],
            'absensi' => [],
            'detil'=>[],
            'data_rapor' => $this->dataRapor($request)
        ]);
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


    // Data Rapor
        // saran

    public function createSaran(Request $request)
    {
        $saran = 'App\Saran';
        $saran::updateOrCreate([
            'periode_id' => $request->semester,
            'jenis_rapor' => $request->jenis_rapor,
            'siswa_id' => $request->siswa_id,
            'sekolah_id' => $request->session()->get('sekolah_id')
            ],
            ['teks' => $request->teks_saran]
        );
    

        return response()->json([
            'status' => 'sukses',
            'msg' => 'Saran disimpan'
        ]);
    }

    public function saveFisik(Request $request)
    {
        $fisik = 'App\FisikSiswa';

        try {
            $fisik::updateOrCreate(
                [
                    // 'id' => $request->id_fisik,
                    'sekolah_id' => $request->session()->get('sekolah_id'),
                    'rombel_id' => $request->session()->get('rombel')->kode_rombel,
                    'tingkat' => $request->session()->get('rombel')->tingkat,
                    'periode' => $request->periode,
                    'siswa_id' => $request->siswa_id
                ],
                [
                    'tb' => $request->tb,
                    'bb' => $request->bb
                ]
            );
            return response()->json(['status' => 'sukses','msg' => 'Data Fisik Siswa Disimpan.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'gagal', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    public function saveKesehatan(Request $request)
    {
        $kesehatan = 'App\KesehatanSiswa';

        try {
            $kesehatan::updateOrCreate(
                [
                    'sekolah_id' => $request->session()->get('sekolah_id'),
                    'rombel_id' => $request->session()->get('rombel')->kode_rombel,
                    'tingkat' => $request->session()->get('rombel')->tingkat,
                    'periode' => $request->session()->get('periode_aktif'),
                    'siswa_id' => $request->nisn
                ],
                [
                    'pendengaran' => $request->pendengaran,
                    'penglihatan' => $request->penglihatan,
                    'gigi' => $request->gigi,
                    'lain' => $request->lain
                ]
            );

            return response()->json(['status'=>'sukses','msg' => 'Data Kesehatan Disimpan.', 'icon' => 'info']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'gagal','msg' => $e->getCode().':'.$e->getMessage(), 'icon' => 'error']);
        }
    }
    public function savePrestasi(Request $request)
    {
        $prestasi = 'App\Prestasi';

        try {
            $prestasi::updateOrCreate(
                [
                    'sekolah_id' => $request->session()->get('sekolah_id'),
                    'rombel_id' => $request->session()->get('rombel')->kode_rombel,
                    'tingkat' => $request->session()->get('rombel')->tingkat,
                    'periode' => $request->session()->get('periode_aktif'),
                    'siswa_id' => $request->siswa_id
                ],
                [
                    'kesenian' => $request->kesenian,
                    'olahraga' => $request->olahraga
                ]
            );

            return response()->json(['status'=>'sukses','msg' => 'Data Prestasi Disimpan.', 'icon' => 'info']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'gagal','msg' => $e->getCode().':'.$e->getMessage(), 'icon' => 'error']);
        }
    }
    public function saveAbsensi(Request $request)
    {
        $absensi = 'App\Absensi';

        try {
            $absensi::updateOrCreate(
                [
                    'sekolah_id' => $request->session()->get('sekolah_id'),
                    'rombel_id' => $request->session()->get('rombel')->kode_rombel,
                    'tingkat' => $request->session()->get('rombel')->tingkat,
                    'periode' => $request->session()->get('periode_aktif'),
                    'siswa_id' => $request->siswa_id
                ],
                [
                    'ijin' => $request->ijin,
                    'sakit' => $request->sakit,
                    'alpa' => $request->alpa
                ]
            );

            return response()->json(['status'=>'sukses','msg' => 'Data Prestasi Disimpan.', 'icon' => 'info']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'gagal','msg' => $e->getCode().':'.$e->getMessage(), 'icon' => 'error']);
        }
    }
}
