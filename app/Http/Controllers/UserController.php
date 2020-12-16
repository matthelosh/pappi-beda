<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator, Redirect, Response;
use Illuminate\Support\Facades\Hash;
use App\Imports\ImportUsers;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('req')) {
            switch($request->query('req'))
            {
                case "select":
                    $where = Auth::user()->sekolah_id == 'all' ? [['level','<>','admin']]:[['sekolah_id','=',Auth::user()->sekolah_id],['level','=','guru']];

                    $datas = User::where($where)->get();
                    $users = [];
                    foreach($datas as $user)
                    {
                        array_push($users, ['id' => $user->nip, 'text' => $user->nama]);
                    }
                    return response()->json(['status' => 'sukses', 'msg' => 'Data Semua Pengguna', 'users' => $users]);
                break;
                case "dt":
                    $where = (AUth::user()->level == 'operator') ? ['sekolah_id','=', Auth::user()->sekolah_id] : ['level','<>','xxx'];
                    $users = User::where([
                        ['level','<>','admin'],
                        $where
                    ])->with('sekolahs')->get();

                    return DataTables::of($users)->addIndexColumn()->make(true);
                break;
            }

        } else {
            $users = User::where('level','<>', 'admin')->with('sekolahs')->get();
            return response()->json(['status' => 'sukses', 'msg' => 'Data Semua Pengguna', 'users' => $users]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $redirect = (Auth::user()->level == 'admin') ? '/users' : '/operator/'.Auth::user()->sekolah_id.'/users';
        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'nama' => 'required',
            'jk' => 'required',
            'username' => 'required',
            'role' => 'required',
            'level' => 'required',
            'status' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'hp' => 'required',
            'alamat' => 'required',
            'sekolah_id' => 'required'
        ]);
        
        if( $validator->passes()) {
            
            try {
                User::create([
                    'nip' => $request->nip,
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'username' => $request->username,
                    'role' => $request->role,
                    'level' => $request->level,
                    'status' => $request->status,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'hp' => $request->hp,
                    'alamat' => $request->alamat,
                    'default_password' => ($request->role == 'admin') ? 'qwerty' : '12345',
                    'sekolah_id' => $request->sekolah_id
                ]);
                return redirect($redirect)->with(['status' => 'sukses', 'msg' => 'Data Pengguna disimpan']);
            } catch (\Exception $e)
            {
                return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
            }
        } else {
            return back()->with(['status' => 'error', 'error' => $validator->errors()->all()]);
            // dd($validator->errors()->all());
        }
    }

    public function import(Request $request)
    { 
        $file = $request->file('file');
         try {
            $users = $request->datas;
            foreach ( $users as $user )
            {
                User::updateOrCreate([
                    'nip' => $user['nip'],
                    'username' => $user['username']],
                    [
                    'nama' => $user['nama'],
                    'jk' => $user['jk'],
                    'role' => $user['role'],
                    'level' => 'guru',
                    'status' => $user['status'],
                    'password' => Hash::make($user['password']),
                    'email' => $user['email'],
                    'hp' => $user['hp'],
                    'alamat' => $user['alamat'],
                    'default_password' => ($user['role'] == 'admin') ? 'qwerty' : '12345',
                    'sekolah_id' => $user['sekolah_id'] ?? Auth::user()->sekolah_id
                ]);
            }

            return response()->json(['status' => 'sukses', 'msg' => 'Data Pengguna tersimpan.']);

         } catch (\Exception $e) {
             return response()->json(['status' => 'gagal', 'code' => $e->getCode(),'msg' => $e->getMessage()], 409);
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $nip)
    {
        // dd($request->all());
        $nip = ($nip == $request->nip) ? $nip : $request->nip;
        // dd($nip);
        $user = User::where('nip', $nip)->with('sekolahs')->first();

        return response()->json(['status' => 'sukses', 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        try {
            User::findOrFail($id)->update([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'username' => $request->username,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'hp' => $request->hp,
                'alamat' => $request->alamat
            ]);
            return back()->with(['status' => 'sukses', 'msg' => 'Data PEngguna diperbarui']);
        } catch (\Exception $e) 
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $nip = $request->nip;
        try 
        {
            User::where('nip', $nip)->delete();
            return response()->json(['status' => 'sukses', 'msg' => 'Data Pengguna dihapus']);
        }
        catch (\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }

    public function resetAll(Request $request)
    {
        try 
        {
            $users = User::where('level', '<>', 'admin')->get();
            foreach($users as $user)
            {
                $user->update([
                    'password' => Hash::make($user->default_password)
                ]);
            }

            return response()->json(['status' => 'sukses', 'msg' => 'Sandi Semua Pengguna disetel ulang']);
        } catch (\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode(). ':'. $e->getMessage()]);
        }
    }

    public function reset(Request $request, $nip)
    {
        try {
            $user = User::where('nip', $nip)->first();
            $user->update([
                'password' => Hash::make($user->default_password)
            ]);
            return response()->json(['status' => 'sukses', 'msg' => 'Sandi Pengguna disetel ulang']);
        }catch (\Exception $e)
        {
            return response()->json(['status' => 'error', 'msg' => $e->getCode(). ':'. $e->getMessage()]);
        }
    }

    public function uploadFoto(Request $request, $npsn, $nip)
    {
        try {
            $file = $request->file;
            $path = $file->storeAs('public/img', $npsn.'_'.$nip.'.jpg');
            return response()->json(['status' => 'sukses','msg' => 'Foto Pengguna tersimpan']);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'gagal', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }
}
