<?php

namespace App\Http\Controllers;

use App\Mapel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\ImportMapel;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
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
                    if($request->query('rombel_id')) {
                        $rombel = 'App\Rombel'::where('kode_rombel', $request->query('rombel_id'))->first();
                        if ((Int) $rombel->tingkat > 3 ) {
                            $mapels = Mapel::all();
                        } else {
                            $mapels = Mapel::where('tingkat', '<>', 'besar')->get();
                        }
                    } else {
                        $mapels = Mapel::all();
                    }
                    return DataTables::of($mapels)->addIndexColumn()->toJson();
                break;
                case "select":
                    if ($request->q != '') {
                        $mapels = Mapel::where('nama_mapel', 'LIKE', '%'.$request->q.'%')->get();
                    } else {
                        $role = Auth::user()->role;
                        $rombel = 'App\Rombel'::where('kode_rombel', $request->session()->get('rombel_id'))->first();
                        $kode_mapel = '%';
                        
                        if($role == 'wali' && (Int) $rombel->tingkat < 4 ) {
                            $mapels = Mapel::where([
                                ['tingkat', '<>', 'besar'],
                                // ['kode_mapel', '<>', ['pabp', 'pjok', 'big']],
                            ])->get();
                        } elseif ($role == 'wali' && (Int) $rombel->tingkat > 3) {
                            $mapels = Mapel::where([
                                // ['kode_mapel', '<>', ['pabp', 'pjok', 'big']]
                            ])->get();
                        } elseif( $role != 'wali' ) {
                            $kode = $role == 'gpai' ? 'pabp' : ($role == 'gor' ? 'pjok' : 'big');
                             $mapels = Mapel::where('kode_mapel',$kode)->get();
                        }
                    }
                    $datas = [];
                    foreach($mapels as $mapel)
                    {
                        array_push($datas, ['id' => $mapel->kode_mapel, 'text' => $mapel->label]);
                    }
                    return response()->json(['status' => 'sukses', 'msg' => 'Data Mapel', 'mapels' => $datas]);
                break;
            }
        }
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        try {
            Excel::import(new ImportMapel, $file);
            return redirect('/mapels')->with(['status' => 'sukses', 'msg' => 'Data Mapel Diimpor']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
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
            Mapel::create([
                'kode_mapel' => $request->kode_mapel,
                'nama_mapel' => $request->nama_mapel,
                'tingkat' => $request->tingkat,
                'label' => $request->label
            ]);
            return redirect('/mapels')->with(['status' => 'sukses', 'msg' => 'Data Mapel ditambahkan']);
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
     * @param  \App\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function show(Mapel $mapel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function edit(Mapel $mapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            Mapel::findOrFail($id)->update($request->all());
            return redirect('/mapels')->with(['status' => 'sukses', 'msg' => 'Data Mapel Diperbarui']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            Mapel::findOrFail($id)->delete();
            return response()->json(['status' => 'sukses' , 'msg' => 'Data Mapel Dihapus']);
        } catch(\Exception $e)
        {
            return response()->json(['status' => 'error' , 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }
}
