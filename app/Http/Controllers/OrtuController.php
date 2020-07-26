<?php

namespace App\Http\Controllers;

use App\Ortu;
use Illuminate\Http\Request;

class OrtuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            Ortu::create([
                'siswa_id' => $request->siswa_id,
                'nama_ayah' => $request->nama_ayah,
                'job_ayah' => $request->job_ayah,
                'nama_ibu' => $request->nama_ibu,
                'job_ibu' => $request->job_ibu,
                'nama_wali' => $request->nama_wali,
                'hub_wali' => $request->hub_wali,
                'job_wali' => $request->job_wali,
                'alamat_wali' => $request->alamat_wali
            ]);

            return redirect('/siswas')->with(['status' => 'sukses', 'msg' => 'Ortu disimpan']);
        } catch (\Exception $e) {
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
     * @param  \App\Ortu  $ortu
     * @return \Illuminate\Http\Response
     */
    public function show(Ortu $ortu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ortu  $ortu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $nisn, $nis = null)
    {
        $nisn = ($nis == null) ? $nisn : $nis;
        $ortu = Ortu::where('siswa_id', $nisn)->first();
        // dd($nisn);
        return response()->json(['status' => 'sukses', 'msg' => 'Data Ortu', 'ortu' => $ortu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ortu  $ortu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id2 = null)
    {
        $id = ($id2 == null) ? $id : $id2;
        try {
            Ortu::findOrFail($id)->update($request->all());
            return redirect('/siswas')->with(['status' => 'sukses', 'msg' => 'Data Ortu diperbarui']);
        } catch (\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ortu  $ortu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ortu $ortu)
    {
        //
    }
}
