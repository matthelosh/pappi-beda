<?php

namespace App\Http\Controllers;

use App\TanggalRapor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TanggalRaporController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->query('req')) {
            switch($request->query('req')) {
                case "dt": 
                    $tanggal_rapors = TanggalRapor::with('sekolahs', 'periodes')->get();
                    // dd($tanggal_rapors);
                    return DataTables::of($tanggal_rapors)->addIndexColumn()->toJson();
                break;
            }
        } else {
            return 'HAlo';
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
            TanggalRapor::create([
                'sekolah_id' => $request->sekolah_id,
                'periode_id' => $request->periode_id,
                'tanggal' => $request->tanggal,
                'jenis_rapor' => $request->jenis_rapor
            ]);
            return redirect('/tanggal-rapor')->with(['status' => 'sukses', 'msg' => 'Tanggal Rapor disimpan']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'sukses', 'msg' => $e->getCode().':'.$e->getCode()]);
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
     * @param  \App\TanggalRapor  $tanggalRapor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $tanggal_rapor = TanggalRapor::find($id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TanggalRapor  $tanggalRapor
     * @return \Illuminate\Http\Response
     */
    public function edit(TanggalRapor $tanggalRapor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TanggalRapor  $tanggalRapor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            TanggalRapor::findOrFail($id)->update($request->all());
            return redirect('/tanggal-rapor')->with(['status' => 'sukses', 'msg' => 'Tanggal Rapor Diupdate']);
        } catch (\Exception $e) 
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TanggalRapor  $tanggalRapor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            TanggalRapor::findOrFail($id)->delete();
            return response()->json(['status' => 'sukses', 'msg' => 'Tanggal Rapor Dihapus']);
        } catch (\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }
}
