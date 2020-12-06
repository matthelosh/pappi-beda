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
            // dd($this->getClientOS($request));
            
            $sekolah = 'App\Sekolah'::where('npsn', Auth::user()->sekolah_id)->first();
            $rombel = 'App\Rombel'::where('guru_id', Auth::user()->nip)->first();
            $periode = 'App\Periode'::where('status', 'aktif')->first();

            $user = Auth::user();
            $log_id = uniqid($user->nip.'_');
            // dd($log_id);
            session(['role' => $user->role, 'rombel_id' => ($user->role == 'wali') ? $rombel->kode_rombel : 'all', 'username' =>  Auth::user()->username, 'periode_aktif' => $periode->kode_periode, 'sekolah_id' => Auth::user()->sekolah_id, 'sekolah' => $sekolah, 'rombel' => ($user->role == 'wali') ? $rombel : [], 'log_id' => $log_id]);
            // session(['log_id' => $log_id]);
            'App\LogInfo'::create([
                'log_id' => $log_id,
                'sekolah_id' => $user->sekolah_id,
                'user_id' => $user->nip,
                'client_ip' => $request->getClientIp(),
                'client_os' => $this->getClientOS($request)
            ]);
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

    public function logout(Request $request)
    {
        $log_id = $request->session()->get('log_id');
        'App\LogInfo'::where('log_id', $log_id)->update(['logout_time' => date('Y-m-d H:i:s')]);
        // dd($log_id);
        $request->session()->flush();
        Auth::logout();

        return redirect('login');
    }

    public function getClientOS($request)
    {
        $user_agent = $request->header('User-Agent');
        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
    
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
    
        return $os_platform;
    }
}
