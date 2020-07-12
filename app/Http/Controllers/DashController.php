<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class DashController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->level == 'admin') {
            return view('pages.admin.dashboard', ['page_title' => 'Dashboard']);
            // Session::set([''])
        } else {
            return view('pages.guru.dashboard', ['page_title' => 'Dashboard']);
        }
    }
}
