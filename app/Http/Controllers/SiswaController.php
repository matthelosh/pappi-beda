<?php

namespace App\Http\Controllers;

use App\Siswa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\ImportSiswa;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
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
                    $rombel_id = ($request->query('rombel_id')) ??'';

                    if($rombel_id == '' && Auth::user()->level == 'admin') {
                        $siswas = Siswa::with('sekolahs', 'rombels', 'ortus')->get();
                    } elseif($rombel_id == '' && Auth::user()->level == 'operator') {
                        $siswas = Siswa::where([
                            ['sekolah_id','=', Auth::user()->sekolah_id]
                        ])->with('sekolahs','rombels','ortus')
                        ->get();
                    } else {
                        $siswas = Siswa::where([
                            ['rombel_id','=', $rombel_id],
                            ['sekolah_id','=', $request->session()->get('sekolah_id')],
                            ])->with('sekolahs', 'rombels', 'ortus')->get();
                    }
                    return DataTables::of($siswas)->addIndexColumn()->toJson();
                break;
                case "dt-members":
                    // echo $request->query('rombel_id');
                    $members = Siswa::where([
                        ['rombel_id', '=',$request->query('rombel_id')],
                        // ['sekolah_id','=', $request->session()->get('sekolah_id')],
                    ])->get();
                    // dd($members);
                    return DataTables::of($members)->addIndexColumn()->toJson();
                break;
                case "dt-non-members":
                    $non_members = Siswa::where([
                        ['rombel_id', '=','0'],
                        // ['sekolah_id','=', $request->session()->get('sekolah_id')],
                    ])->get();
                    return DataTables::of($non_members)->addIndexColumn()->toJson();
                break;
                case "select":
                    if($request->query('rombel') != 'null') {
                        if($request->q != '') {
                            $siswas = Siswa::where([
                                ['rombel_id', '=', $request->query('rombel')],
                                ['sekolah_id','=', $request->session()->get('sekolah_id')],
                                ['nama_siswa', 'LIKE' ,'%'.$request->q.'%']
                            ])->get();
                        } else {
                            $datas = Siswa::where('rombel_id', $request->query('rombel'))->get();
                            $siswas = [];
                            foreach($datas as $siswa)
                            {
                                array_push($siswas, ['id' => $siswa->nisn, 'text' => $siswa->nama_siswa]);
                                
                            }
                            return response()->json($siswas);
                        }
                    } else {
                        if($request->q != '') {
                            $siswas = Siswa::where([
                                ['nama_siswa', 'LIKE' ,'%'.$request->q.'%'],
                                ['rombel_id', '<>', '0'],
                                ['sekolah_id','=', $request->session()->get('sekolah_id')],
                            ])->get();
                        } else {
                            $siswas = Siswa::where([
                                ['rombel_id','<>', '0'],
                                ['sekolah_id','=', $request->session()->get('sekolah_id')],
                            ])->get();
                        }
                    }
                    $datas = [];
                    foreach($siswas as $siswa)
                    {
                        array_push($datas, ['id' => $siswa->nisn, 'text' => $siswa->nama_siswa]);
                    }

                    return response()->json(['status' => 'sukses', 'msg' => 'Data Siswa', 'siswas' => $datas]);
                break;
            }
        }
    }

    public function import(Request $request)
    {
        // $file=$request->file('file');
        $redirect = (Auth::user()->level == 'admin') ? '/siswas' : '/operator/'.Auth::user()->sekolah_id.'/siswas';

        // Excel::import(new ImportSiswa, $file);

        // return redirect($redirect)->with(['status' => 'sukses', 'msg' => 'Data Siswa diimpor']);

        try {

            $siswas = $request->datas;
            foreach($siswas as $siswa) {
                Siswa::create([
                    'nis' => $siswa['nis'],
                    'nisn' =>  $siswa['nisn'],
                    'nama_siswa' =>  $siswa['nama_siswa'],
                    'jk' =>  $siswa['jk'],
                    'agama' => $siswa['agama'],
                    'alamat' =>  $siswa['alamat'],
                    'desa' =>  $siswa['desa'],
                    'kec' =>  $siswa['kec'],
                    'kab' =>  $siswa['kab'],
                    'prov' =>  $siswa['prov'],
                    'hp' =>  $siswa['hp'],
                    'sekolah_id' =>  $siswa['sekolah_id'],
                    'rombel_id' =>  $siswa['rombel_id']
                ]);
            }

            return response()->json(['status' => 'sukses', 'msg' => 'Data Siswa disimpan']);

        } catch(\Exception $e) {
            return response()->json(['status' => 'gagal', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    public function out(Request $request)
    {
        $ids = $request->ids;
        $ket = ($request->query('ket') == 'keluar') ? '0' : 'lulus';
        try {
            foreach($ids as $id)
            {
                Siswa::findOrFail($id)->update(['rombel_id' => $ket]);
            }
            return response()->json(['status' => 'sukses', 'msg' => 'Siswa dikeluarkan']);
        } catch(\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }
    public function in(Request $request)
    {
        $ids = $request->ids;
        try {
            foreach($ids as $id)
            {
                Siswa::findOrFail($id)->update(['rombel_id' => $request->rombel_id]);
            }
            return response()->json(['status' => 'sukses', 'msg' => 'Siswa dimasukkan']);
        } catch(\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    public function pindah(Request $request)
    {
        $ids = $request->ids;
        $tujuan = $request->tujuan;
        try {
            foreach($ids as $id)
            {
                Siswa::findOrFail($id)->update(['rombel_id' => $tujuan]);
            }
            return response()->json(['status' => 'sukses', 'msg' => 'Siswa dipindah ke rombel baru']);
        } catch(\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $redirect = (Auth::user()->level == 'admin') ? '/siswas' : '/operator/'.Auth::user()->sekolah_id.'/siswas';
        try {
            $foto = $request->file('foto_siswa');
            $dest = public_path('img/siswas/');
            $nama = $request->sekolah_id.'_'.$request->nisn.'.jpg';

            if($foto) {
                $simpan = $foto->move($dest, $nama);
            }
            Siswa::create([
                'nis' => $request->nis,
                'nisn' =>  $request->nisn,
                'nama_siswa' =>  $request->nama_siswa,
                'jk' =>  $request->jk,
                'agama' => $request->agama,
                'alamat' =>  $request->alamat,
                'desa' =>  $request->desa,
                'kec' =>  $request->kec,
                'kab' =>  $request->kab,
                'prov' =>  $request->prov,
                'hp' =>  $request->hp,
                'sekolah_id' =>  $request->sekolah_id,
                'rombel_id' =>  $request->rombel_id
            ]);
            return redirect($redirect)->with(['status' => 'sukses', 'msg' => 'Data Siswa Disimpan']);
        } catch(\Exception $e)
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
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sekolah_id, $id)
    {
        $redirect = (Auth::user()->level == 'operator') ? '/operator/'.Auth::user()->sekolah_id.'/siswas' : (Auth::user()->level=='admin' ? '/siswas' : '/'.Auth::user()->username.'/siswaku');
        try {
            $foto = $request->file('foto_siswa');
            $dest = public_path('img/siswas/');
            $nama = $request->sekolah_id.'_'.$request->nisn.'.jpg';
            if($foto) {
                $simpan = $foto->move($dest, $nama);
            }
            
            'App\Siswa'::findOrFail($id)->update([
                'nis' => $request->nis,
                'nisn' =>  $request->nisn,
                'nama_siswa' =>  $request->nama_siswa,
                'jk' =>  $request->jk,
                'agama' => $request->agama,
                'alamat' =>  $request->alamat,
                'desa' =>  $request->desa,
                'kec' =>  $request->kec,
                'kab' =>  $request->kab,
                'prov' =>  $request->prov,
                'hp' =>  $request->hp,
                'sekolah_id' =>  $request->sekolah_id,
                'rombel_id' =>  $request->rombel_id
            ]);
            return redirect($redirect)->with(['status' => 'sukses', 'msg' => 'Data Siswa Diperbarui']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
            // dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $sekolah_id, $id)
    {
        try {
            Siswa::findOrFail($id)->delete();
            return response()->json(['status' => 'sukses', 'msg' => 'Data Siswa Dihapus']);
        } catch(\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }
}
