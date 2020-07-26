<?php

namespace App\Http\Controllers;

use App\Jurnal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
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
                    $rombel = Auth::user()->role == 'wali' ? ['rombel_id', '=',$request->session()->get('rombel_id')] : ['rombel_id','<>','!'];
                    $aspek = Auth::user()->role == 'wali' ? ['aspek', '=', '2'] : ['aspek','=', '1'];
                     $jurnals = Jurnal::where([
                        $rombel,
                        $aspek,
                        ['periode_id','=', $request->session()->get('periode_aktif')],
                    ])->with('siswas')->get();

                    return DataTables::of($jurnals)->addIndexColumn()->toJson();
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
            Jurnal::create([
                'tanggal' => $request->tanggal,
                'periode_id' => $request->session()->get('periode_aktif'),
                'rombel_id' => $request->session()->get('rombel_id'),
                'butir_sikap' => $request->butir_sikap,
                'aspek' => $request->aspek,
                'siswa_id' => $request->siswa_id,
                'catatan' => $request->catatan,
                'nilai' => $request->nilai
            ]);
            return redirect('/'.Auth::user()->username.'/jurnals')->with(['status' => 'sukses', 'msg' => 'Jurnal Siswa Disimpan']);
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
     * @param  \App\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function show(Jurnal $jurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function edit(Jurnal $jurnal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jurnal $jurnal)
    {
        //
    }
}
