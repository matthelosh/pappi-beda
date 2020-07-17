<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator, Redirect, Response;
use Illuminate\Support\Facades\Hash;
use App\Imports\ImportUsers;
use Maatwebsite\Excel\Facades\Excel;
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

            }
        } else {
            $users = User::where('level','<>', 'admin')->get();
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
        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'nama' => 'required',
            'jk' => 'required',
            'username' => 'required',
            'role' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'hp' => 'required',
            'alamat' => 'required'
        ]);
        
        if( $validator->passes()) {
            try {
                User::create([
                    'nip' => $request->nip,
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'username' => $request->username,
                    'role' => $request->role,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'hp' => $request->hp,
                    'alamat' => $request->alamat,
                    'default_password' => ($request->role == 'admin') ? 'qwerty' : '12345'
                ]);
                return redirect('/users')->with(['status' => 'sukses', 'msg' => 'Data Pengguna disimpan']);
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
            $import = new ImportUsers();
            $import->import($file);
            // dd($import);
            $errors = ($import->errors()) ??  '';
            return back()->with(['status' => 'sukses', 'msg' => 'Data Pengguna telah diimpor', 'errors' => $errors]);
         } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $msg = '';
             $failures = $e->failures();
             foreach ($failures as $failure) {
                //$failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $values = $failure->values(); // The values of the row that has failed.
                $msg .= 'Pengguna dengan '.$failure->attribute().':'.$values['nip']. ' sudah ada. <br>';
            }
            return back()->with(['status' => 'error', 'msg' => $msg]);
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
        $user = User::where('nip', $nip)->first();

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
    public function destroy(Request $request, $nip)
    {
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
}
