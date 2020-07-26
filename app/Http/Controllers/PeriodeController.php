<?php

namespace App\Http\Controllers;

use App\Periode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PeriodeController extends Controller
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
                    $periodes = Periode::all();
                    return DataTables::of($periodes)->addIndexColumn()->toJson();
                break;
                case "select":
                    if($request->q != '') {
                        $periodes = Periode::where('%'.$request->q.'%')->get();
                    } else {
                        $periodes = Periode::all();
                    }
                    $datas = [];
                    foreach($periodes as $periode)
                    {
                        $status = ($periode->status == 'aktif') ? '*': '';
                        array_push($datas, ['id' => $periode->kode_periode, 'text' => $periode->tapel.' - '.$periode->label .' '. $status]);
                    }

                    return response()->json(['status' =>' sukses', 'periodes' => $datas]);
                break;
            }
        }
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        try {
            Excel::import(new ImportPeriode, $file);
            return redirect('/periode')->with(['status' => 'sukses', 'msg' => 'Data Periode Diimpor']);
        } catch (\Exception $e) {
            return back()->with(['status' => 'sukses', 'msg' => $e->getCode().':'.$e->getMessage()]);
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
            $cek_aktif = Periode::where('status', 'aktif')->first();
            $status = ($cek_aktif) ? 'nonaktif' : 'aktif';
            Periode::create([
                'kode_periode' => $request->kode_periode,
                'tapel' => $request->tapel,
                'semester' => $request->semester,
                'label' => $request->label,
                'status' => $status
            ]);
            return redirect('/periode')->with(['status' => 'sukes', 'msg' => 'Data Periode Disimpan']);
        } catch (\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    public function activate(Request $request, $id)
    {
        try {
            Periode::findOrFail($id)->update(['status' => 'aktif']);
            Periode::where('id', '<>', $id)->update(['status' => 'nonaktif']);

            return response()->json(['status' => 'sukses', 'msg' => 'Periode Diaktifkan']);
        } catch(\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
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
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function show(Periode $periode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function edit(Periode $periode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Periode::findOrFail($id)->update($request->all());
            return redirect('/periode')->with(['status' => 'sukses', 'msg' => 'Data Periode Diperbarui']);
        } catch (\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            Periode::findOrFail($id)->delete();
            return response()->json(['status' => 'sukses', 'msg' => 'Data Periode Dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }
}
