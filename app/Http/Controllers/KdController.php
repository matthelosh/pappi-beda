<?php

namespace App\Http\Controllers;

use App\Imports\ImportKd;
use App\Kd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
class KdController extends Controller
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
                    dd($request->session()->all());
                    if ($request->query('rombel_id') != 'all') {
                        $rombel = 'App\Rombel'::where('kode_rombel', $request->query('rombel_id'))->first();
                        $kds = Kd::where('tingkat', $rombel->tingkat)->with('mapels')->get();

                        // dd($kds);
                    } elseif ($request->query('rombel_id') == 'all' && Auth::user()->role != 'wali') {
                        $mapel = (Auth::user()->role == 'gpai') ? 'pabp': ((Auth::user()->role == 'gor') ? 'pjok' : 'big');
                        $kds = Kd::where('mapel_id', $mapel)->with('mapels')->get();
                    } else {
                        $kds = Kd::with('mapels')->get();
                    }
                    return DataTables::of($kds)->addIndexColumn()->toJson();
                break;
                case "select":
                    if($request->aspek == '1' || $request->aspek == '2') {
                        $kds = DB::table('butir_sikaps')->where('aspek', $request->aspek)->get();
                        // dd($kds);
                        $datas = [];
                        foreach($kds as $kd)
                        {
                            array_push($datas, ['id' => $kd->kode_kd, 'text' => $kd->teks]);
                        }

                        return response()->json($datas);
                    } else {
                        if($request->rombel != 'all') {
                            $rombel = 'App\Rombel'::where([
                                ['kode_rombel','=', $request->rombel]
                            ])->first();
                            $kds = Kd::where([
                                ['tingkat', '=', $rombel->tingkat],
                                ['mapel_id', '=', $request->mapel],
                                ['kode_kd', 'LIKE', $request->aspek.'.%']
                            ])->get();
                        } else {
                            $kds = Kd::all();
                        }


                        $datas = [];
                        foreach($kds as $kd)
                        {
                            array_push($datas, ['id' => $kd->kode_kd, 'text' => $kd->kode_kd.'. '.$kd->teks_kd]);
                        }
                        // dd($kds);
                        return response()->json($datas);
                    }
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
            $last = Kd::where([
                ['mapel_id', '=', $request->mapel_id],
                ['tingkat', '=', $request->tingkat]
            ])->get()->last();

            if(!$request->kode_kd) {
                if($last == null) {
                    $kode_kd = $request->ranah .'.'.'1';
                } else {
                    $last_kode = explode('.', $last->kode_kd);
                    $kode_kd = $request->ranah.'.'. ((Int) $last_kode + 1);
                }
            }

            Kd::create([
                'kode_kd' => ($request->kode_kd) ? $request->kode_kd : $kode_kd,
                'teks_kd' => $request->teks_kd,
                'mapel_id' => $request->mapel_id,
                'tingkat' => $request->tingkat
            ]);

            return redirect('/kds')->with(['status' => 'sukses', 'msg' => 'Kd Disimpan']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'sukses', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        try {
            Excel::import(new ImportKd, $file);
            return redirect('/kds')->with(['status' => 'sukses', 'msg' => 'Data KD diimpor']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'sukses', 'msg' => $e->getCode().':'.$e->getMessage()]);
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
     * @param  \App\Kd  $kd
     * @return \Illuminate\Http\Response
     */
    public function show(Kd $kd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kd  $kd
     * @return \Illuminate\Http\Response
     */
    public function edit(Kd $kd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kd  $kd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            Kd::findOrFail($id)->update($request->all());

            return redirect('/kds')->with(['status' => 'sukses', 'msg' => 'Data KD diperbarui']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kd  $kd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            Kd::findOrFail($id)->delete();
            return response()->json(['status' => 'sukses', 'msg' => 'Data KD Dihapus']);
        } catch (\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode.':'.$e->getMessage()]);
        }
    }
}
