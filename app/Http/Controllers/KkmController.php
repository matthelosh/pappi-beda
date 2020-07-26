<?php

namespace App\Http\Controllers;

use App\Kkm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KkmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->query('req')) {
            switch($request->query('req'))
            {
                case "dt":
                    if($request->session()->get('rombel_id')) {
                        $kkm = Kkm::where([
                            ['rombel_id', '=', $request->session()->get('rombel_id')],
                            ['periode_id', '=', $request->session()->get('periode_aktif')]
                        ])->with('mapels')->get();
                    }

                    return DataTables::of($kkm)->addIndexColumn()->toJson();
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
             Kkm::create([
                'sekolah_id' =>$request->sekolah_id, 
                'periode_id' =>$request->periode_id, 
                'mapel_id' => $request->mapel_id, 
                'rombel_id' => (!$request->rombel_id) ? $request->session()->get('rombel_id') : $request->rombel_id,
                'nilai' => $request->nilai
             ]);
             $red_url = ($request->user()->level != 'admin') ? '/'.$request->user()->username.'/kkm' : '/kkm';

             return redirect($red_url)->with(['status' => 'sukses', 'msg' => 'KKM disimpan']);
         } catch (\Exception $e)
         {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
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
     * @param  \App\Kkm  $kkm
     * @return \Illuminate\Http\Response
     */
    public function show(Kkm $kkm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kkm  $kkm
     * @return \Illuminate\Http\Response
     */
    public function edit(Kkm $kkm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kkm  $kkm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kkm $kkm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kkm  $kkm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kkm $kkm)
    {
        //
    }
}
