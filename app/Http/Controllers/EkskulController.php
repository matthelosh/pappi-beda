<?php

namespace App\Http\Controllers;

use App\Ekskul;
use App\NilaiEkskul;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
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
    public function saveNilai(Request $request)
    {
        // dd($request->all());
        try {
            $npsn = $request->session()->get('sekolah_id');
            if ($request->id_nilai == '0') {
                NilaiEkskul::create([
                    'sekolah_id' => $request->session()->get('sekolah_id'),
                    'siswa_id' => $request->siswa_id,
                    'periode' => $request->periode_id,
                    'rombel_id' => $request->rombel_id,
                    'ekskul_id' => $request->ekskul_id,
                    'keterangan' => $request->keterangan,
                    'tingkat' => $request->session()->get('rombel')->kode_rombel
                ]);
            } else {
                NilaiEkskul::find($request->id_nilai)->update(['keterangan' => $request->keterangan]);
            }
            return response()->json(['status'=>'sukses', 'msg'=>'Nilai Ekskul disimpan.']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'gagal', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ekskul  $ekskul
     * @return \Illuminate\Http\Response
     */
    public function show(Ekskul $ekskul)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ekskul  $ekskul
     * @return \Illuminate\Http\Response
     */
    public function edit(Ekskul $ekskul)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ekskul  $ekskul
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ekskul $ekskul)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ekskul  $ekskul
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ekskul $ekskul)
    {
        //
    }
}
