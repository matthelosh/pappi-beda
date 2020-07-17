<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use Validator, Redirect, Response;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::where('parent_id','=',0)->get();
        $allMenus = Menu::pluck('title', 'id', 'url')->all();
        return view('pages.admin.dashboard', ['page_title' => 'Menu','menus' => compact($menus), 'allMenus' => compact($allMenus)]);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required',
            'ikon' => 'required',
            'role' => 'required'
        ]);
        if ($validator->passes()) {
            Menu::create([
                'parent_id' => $request->parent_id,
                'title' => $request->title,
                'url' => $request->url,
                'icon' => 'cil-'.$request->ikon,
                'role' => $request->role
            ]);
            return response()->json(['status'=> 'sukses', 'msg' => 'Menu Ditambahkan']);
        } else {
            return response()->json(['status' => 'error', 'error' => $validator->errors()->all()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $menus = Menu::where('parent_id', '=', 0)->get();
        return view('pages.admin.dashboard', ['page_title' => 'Menu Dinamis', 'menus' => compact($menus)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
