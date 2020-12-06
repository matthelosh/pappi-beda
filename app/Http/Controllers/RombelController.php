<?php

namespace App\Http\Controllers;

use App\Imports\ImportRombel;
use App\Rombel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
// use Session;

class RombelController extends Controller
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
                    $where = (Auth::user()->level == 'admin') ? [] : [
                        ['sekolah_id','=',Auth::user()->sekolah_id],
                        ['status','=','aktif'],
                        ['tapel','=', substr($request->session()->get('periode_aktif'), 0,4)]
                    ];
                    $rombels =  Rombel::where($where)->with('sekolahs', 'gurus', 'siswas')->get();
                    return DataTables::of($rombels)->addIndexColumn()->toJson();
                break;
                case "select":
                    $where = (Auth::user()->level == 'operator') ?[['sekolah_id','=', Auth::user()->sekolah_id]]: [];
                    // dd($where);
                    if($request->q) {
                        $datas = Rombel::where(
                            $where
                        )->where([
                            ['nama_rombel','LIKE', '%'.$request->q.'%'],
                            ['status','=','aktif'],
                            ['tapel','=', substr($request->session()->get('periode_aktif'), 0, 4)]
                        ])->get();
                    } else {
                    $datas = Rombel::where($where)->where([
                        ['status','=','aktif'],['tapel','=', substr($request->session()->get('periode_aktif'), 0, 4)]
                    ])->get();
                    }
                    $rombels = [];
                    foreach($datas as $rombel)
                    {
                        array_push($rombels, ['id' => $rombel->kode_rombel, 'text' => $rombel->nama_rombel]);

                    }
                    return response()->json(['status' => 'sukses', 'rombels' => $rombels]);

            }
        }
    }

    public function import(Request $request)
    {
        try {
            $rombels = $request->datas;
            foreach ( $rombels as $rombel )
            {
                Rombel::updateOrCreate(
                    [
                        'sekolah_id' => Auth::user()->sekolah_id,
                        'kode_rombel' => Auth::user()->sekolah_id.'-'.$rombel['kode_rombel'],
                        'tapel' => $rombel['tapel'] ?? substr($request->session()->get('periode_aktif'), 0,4)
                    ],
                    [
                        'nama_rombel' => $rombel['nama_rombel'],
                        'tingkat' => $rombel['tingkat'],
                        'guru_id' => $rombel['guru_id'] ?? '0'
                    ]
                );

                return response()->json(['status' => 'sukses','msg' => 'Data Rombel disimpan']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'gagal', 'msg' => $e->getCode().':'.$e->getMessage()]);
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
            Rombel::updateOrCreate(
                [
                    'sekolah_id' => Auth::user()->sekolah_id,
                    'kode_rombel' => Auth::user()->sekolah_id.'-'.$request->kode_rombel,
                    'tapel' => substr($request->session()->get('periode_aktif'), 0,4),
                    
                ],
                [ 
                    
                    'nama_rombel' => $request->nama_rombel,
                    'tingkat' => $request->tingkat,
                    'guru_id' => $request->guru_id
                ]
            );
            return response()->json(['status' => 'sukses', 'msg' => 'Rombel disimpan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()], 409);
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
     * @param  \App\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function show(Rombel $rombel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function edit(Rombel $rombel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rombel $rombel)
    {
        $id = $request->id;
        try {
            Rombel::findOrFail($id)->update($request->except('id'));
            return response()->json(['status' => 'sukses', 'msg' => 'Rombel diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        try {
            Rombel::findOrFail($id)->delete();
            return response()->json(['status' => 'sukses', 'msg' => 'Rombel dihapus']);
        } catch (\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }
}
