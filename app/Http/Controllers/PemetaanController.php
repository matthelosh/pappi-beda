<?php

namespace App\Http\Controllers;

use App\Pemetaan;
use Illuminate\Http\Request;

class PemetaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $req = $request->query('req') ? $request->query('req'): '0';
        if($req != '0') {
            switch($req) 
            {
                default:

                break;
            }
        } else {
            $pemetaans = Pemetaan::where([
                ['tingkat','=', $request->session()->get('rombel')->tingkat],
                ['subtema_id','=', $request->query('subtema')]

            ])->get();
            $tingkat = ($request->session()->get('rombel')->tingkat > 3) ? ['tingkat','<>','!'] : ['tingkat','!=', 'besar'];
            $mapelsk = 'App\Mapel'::where('tingkat','!=', 'besar')->whereNotIn('kode_mapel',['pabp', 'big', 'bd'])->get();
            $mapelsb = 'App\Mapel'::whereNotIn('kode_mapel',['pabp', 'big', 'bd', 'mtk','pjok'])->get();
            $datas = [];
            foreach(($request->session()->get('rombel')->tingkat > 4) ? $mapelsb : $mapelsk as $mapel) {
                $datas[$mapel->kode_mapel] = [];
            }
            foreach($pemetaans as $item)
            {
                // array_push($datas[$item->mapel_id], $item->kd_id);
                $datas[$item->mapel_id] = $item->kd_id;
            }
            return response()->json(['datas' => $datas]);
        }
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Pemetaan  $pemetaan
     * @return \Illuminate\Http\Response
     */
    public function show(Pemetaan $pemetaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pemetaan  $pemetaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemetaan $pemetaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pemetaan  $pemetaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username, $subtema, $mapel)
    {
        try {
            Pemetaan::where([
                ['subtema_id','=',$subtema],
                ['mapel_id','=',$mapel]
            ])->update([
                'kd_id' => $request->kds
            ]);
            return response()->json(['status' => 'sukses', 'msg' => 'KD telah ditambahkan ke subtema.']);
        }catch(\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pemetaan  $pemetaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemetaan $pemetaan)
    {
        //
    }
}
