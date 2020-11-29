<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Validator, Redirect, Response;
use App\User;
use Session; 

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            if(Auth::user()->level == 'admin') {
                return redirect('/dashboard');
            } elseif (Auth::user()->level == 'operator') {
                return redirect('/operator/'.Auth::user()->sekolah_id.'/dashboard');
            } else {
                return redirect('/'.Auth::user()->username.'/dashboard');
            }
        }
        return view('login');
    }

    public function login(Request $request)
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');
        if(Auth::attempt($credentials)) {
            // dd(Auth::user());
            if (Auth::user()->level == 'admin'){
                return redirect()->intended('dashboard');
            } elseif (Auth::user()->level == 'operator') {
                return redirect('/operator/'.Auth::user()->sekolah_id.'/dashboard');
            } else {
                return redirect('/'.Auth::user()->username.'/dashboard');
            }
        } 

        return Redirect::to('login')->withInput(['username' => $request->username])->with(['status' => 'error', 'msg' => 'Username dan atau Password Tidak Benar'], 403);
    }

    public function logout()
    {
        // Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
