<?php

namespace App\Http\Controllers;

use App\Sekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SekolahController extends Controller
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
                    $sekolahs = Sekolah::with('ks', 'operators')->get();
                    return DataTables::of($sekolahs)->addIndexColumn()->toJson();
                break;
                case "select":
                    $sekolahs = Sekolah::with('ks', 'operators')->get();
                    $datas = [];
                    foreach($sekolahs as $sekolah)
                    {
                        array_push($datas, ['id' => $sekolah->npsn, 'text' => $sekolah->nama_sekolah]);
                    }

                    return response()->json(['status' => 'sukses', 'sekolahs' => $datas]);
                break;
            }
        } else {

            try {
                Sekolah::create($request->all());
                return response()->json(['status' => 'sukses', 'msg' => 'Data Sekolah disimpan']);
            } catch(\Exception $e)
            {
                return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
            }


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
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function show(Sekolah $sekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit(Sekolah $sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sekolah $sekolah)
    {
        //
    }
}
