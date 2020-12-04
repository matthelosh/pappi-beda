<?php

namespace App\Http\Controllers;

use App\LogInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        switch($request->query('req'))
        {
            case "dt":
                $logs = 'App\LogInfo'::with('users')->orderBy('created_at', 'desc')->orderBy('sekolah_id')->get();
                return DataTables::of($logs)->addIndexColumn()->make(true);
            break;
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
     * @param  \App\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function show(LogInfo $logInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(LogInfo $logInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogInfo $logInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogInfo $logInfo)
    {
        //
    }
}
