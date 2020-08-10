<?php

namespace App\Http\Controllers;

use App\Subtema;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubtemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $req= $request->query('req') ? $request->query('req') : '0';
        if($req !='0') {
            switch($req) {
                case "dt": 
                    $subtemas = Subtema::where([
                        ['tema_id', '=', $request->query('tema')],
                        ['tingkat', '=', $request->session()->get('rombel')->tingkat],
                    ])->get();

                    return DataTables::of($subtemas)->addIndexColumn()->toJson();
                break;
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
     * @param  \App\Subtema  $subtema
     * @return \Illuminate\Http\Response
     */
    public function show(Subtema $subtema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subtema  $subtema
     * @return \Illuminate\Http\Response
     */
    public function edit(Subtema $subtema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subtema  $subtema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subtema $subtema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subtema  $subtema
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subtema $subtema)
    {
        //
    }
}
