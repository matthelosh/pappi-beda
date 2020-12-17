<?php

namespace App\Http\Controllers;

use App\Periodik;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PeriodikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sekolah_id = $request->session()->get('sekolah_id');
        $periode = $request->periode ?? $request->session()->get('periode_aktif');
        $periodes = 'App\Periode'::get();

        if($request->req) {
            switch($request->req)
            {
                case "dt":
                    return DataTables::of($periodes)->addIndexColumn()->toJson();
                break;
                case "dt_detil":
                    $datas = Periodik::where([
                        ['sekolah_id','=', $request->session()->get('sekolah_id')],
                        ['periode_id','=', $request->periode_id],
                    ])->with('siswas', 'rombels')
                    ->orderBy('rombel_id')->get();

                    return DataTables::of($datas)->addIndexColumn()->toJson();
                break;
            }
        }
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $sekolah_id = $request->session()->get('sekolah_id');
            $periode = $request->periode ?? $request->session()->get('periode_aktif');
            $rombel_id = $request->rombel_id;
            $siswas = 'App::Siswa'::where('sekolah_id', $sekolah_id)->get();

            foreach($siswas as $siswa)
            {
                Periodik::create([
                    'sekolah_id' => $sekolah_id,
                    'periode_id' => $periode,
                    'rombel_id' => $rombel_id,
                    'siswa_id' => $siswa->nisn
                ]);
            }
            return response()->json(['status'=> 'sukses', 'msg' => 'Data Periodik Rombel Siswa disimpan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'gagal', 'msg' => $e->getCode.':'.$e->getMessage()]);
        }
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Periodik  $periodik
     * @return \Illuminate\Http\Response
     */
    public function show(Periodik $periodik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periodik  $periodik
     * @return \Illuminate\Http\Response
     */
    public function edit(Periodik $periodik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periodik  $periodik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Periodik $periodik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periodik  $periodik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periodik $periodik)
    {
        //
    }
}
