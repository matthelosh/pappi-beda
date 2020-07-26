<?php

namespace App\Http\Controllers;

use App\Imports\ImportRombel;
use App\Rombel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

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
                    $rombels =  Rombel::with('sekolahs', 'gurus')->get();

                    return DataTables::of($rombels)->addIndexColumn()->toJson();
                break;
                case "select":
                    if($request->q) {
                        $datas = Rombel::where('nama_rombel','LIKE', '%'.$request->q.'%')->get();
                    } else {
                    $datas = Rombel::all();
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
        $file = $request->file('file');
        $import = new ImportRombel();
        try {
            $import->import($file);
            return back()->with(['status' => 'sukses', 'msg' => 'Data Pengguna telah diimpor', 'errors' => $errors]);
        } catch (\Exception $e) {
           
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
            Rombel::create($request->all());
            return response()->json(['status' => 'sukses', 'msg' => 'Rombel disimpan']);
        } catch (\Exception $e) {
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
