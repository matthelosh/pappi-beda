<?php
namespace App\Traits;

// use Illuminate\Http\Request;
use App\Nilai1;
use App\Nilai2;
use App\Nilai3;
use App\Nilai4;
use App\Kkm;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;

trait NilaiTrait
{
    public function rekap($request)
    {
        $nilai3 = Nilai3::all();
        return  $nilai3;
    }

    

    public function rpts($request)
    {
        $rombel = $request->session()->get('rombel');
        $nisn = $request->query('nisn');
        $periode = $request->session()->get('periode_aktif');
        $datas = [];
        $key_mapels = ($rombel->tingkat > 3) ? array('tingkat', 'LIKE', '%') : array('tingkat', '!=', 'besar');
        $mapels = 'App\Mapel'::where([$key_mapels])->get();
        $semester = (substr($periode,4,1) == '1') ? 'ganjil': 'genap';
        $semester_id = substr($periode,4,1);
        $kdds = [];
        $tematik = ($rombel->tingkat > 3) ? ['ppkn','bid','ipa','ips','sbdp'] : ['ppkn','bid','mtk','sbdp','pjok'];

        

        // $datas['tgl'] = $tgl_rapor->tanggal;
        foreach($mapels as $mapel)
        {

            $datas[$mapel->kode_mapel]['nama_mapel'] = $mapel->nama_mapel;
            $datas[$mapel->kode_mapel]['kkm'] = Kkm::where([
                ['periode_id','=',$periode],
                ['mapel_id','=', $mapel->kode_mapel],
                ['rombel_id','=',$rombel->kode_rombel]
            ])->select('nilai')
            ->first();
            $datas[$mapel->kode_mapel]['nilais']['uh'] = [];
            $datas[$mapel->kode_mapel]['nilais']['pts'] = [];
            $kds  = 'App\Prosem'::where([
                ['semester','=', $semester_id],
                ['tingkat','=', $rombel->tingkat],
                ['mapel_id','=',$mapel->kode_mapel],
                ['ket','LIKE','ts%']

            ])
            // ->whereIn('tema_id',[$rombel->tingkat.'-1',$rombel->tingkat.'-2'])
            // ->groupBy('kd_id')
            ->get();
            $kdz = [];
            foreach($kds as $kd)
            {
                // $kdd = explode(',',$kd->kd_id);
                $datas[$mapel->kode_mapel]['nilais']['uh'][$kd->kd_id] = 'App\Nilai3'::where([
                    ['periode_id','=', $periode],
                    ['siswa_id','=', $nisn],
                    ['rombel_id','=', $rombel->kode_rombel],
                    ['jenis','=','uh'],
                    ['kd_id','=',$kd->kd_id],
                    ['mapel_id','=',$mapel->kode_mapel]
                ])->select('nilai')->first();

                $datas[$mapel->kode_mapel]['nilais']['pts'][$kd->kd_id] = 'App\Nilai3'::where([
                    ['periode_id','=', $periode],
                    ['siswa_id','=', $nisn],
                    ['rombel_id','=', $rombel->kode_rombel],
                    ['jenis','=','pts'],
                    ['kd_id','=',$kd->kd_id],
                    ['mapel_id','=',$mapel->kode_mapel]
                ])->select('nilai')->first();

                array_push($kdz, $kd->kd_id);
            }




        }
        // $datas['tgl'] = $tgl_rapor->tanggal;
        // dd($datas);
        return $datas;
    }

    public function rpas($request)
    {
        // Ambil Mapel
        $nisn = $request->query('nisn');
        $periode = $request->session()->get('periode_aktif');
        // dd($periode);
        $rombel = $request->session()->get('rombel');
        $mapel = ($rombel->tingkat < 4) ? ['tingkat', '<>', 'besar']:['tingkat', '<>', 'aa'];
        $mapels = 'App\Mapel'::where([$mapel])->get();
        $datas = [];
        foreach($mapels as $mapel)
        {
            $datas[$mapel->kode_mapel]['nama_mapel'] = $mapel->nama_mapel;
            $datas[$mapel->kode_mapel]['kkm'] = Kkm::where([
                ['periode_id','=',$periode],
                ['mapel_id','=', $mapel->kode_mapel],
                ['rombel_id','=',$rombel->kode_rombel]
            ])->select('nilai')
            ->first();

        // NA = ( (NUH*2) + NPTS + NPAS ) / 4
            // Rata2 Harian
            $rth = DB::table('nilai3s')->select(DB::raw(
                'AVG(nilai) AS nilai'
            ))->where([
                ['siswa_id','=', $request->query('nisn')],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                ['rombel_id','=',$rombel->kode_rombel],
                ['mapel_id', '=', $mapel->kode_mapel],
                ['jenis','=','uh']
            ])->first();
            
            // Rata2 PTS
            $rtt = DB::table('nilai3s')->select(DB::raw(
                'AVG(nilai) AS nilai'
            ))->where([
                ['siswa_id','=', $request->query('nisn')],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                ['rombel_id','=',$rombel->kode_rombel],
                ['mapel_id', '=', $mapel->kode_mapel],
                ['jenis','=','pts']
            ])->first();
            
            // Rata2 PAS
            $rta = DB::table('nilai3s')->select(DB::raw(
                'AVG(nilai) AS nilai'
            ))->where([
                ['siswa_id','=', $request->query('nisn')],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                ['rombel_id','=',$rombel->kode_rombel],
                ['mapel_id', '=', $mapel->kode_mapel],
                ['jenis','=','pas']
            ])->first();

            $na3 = (($rth->nilai*2)+($rtt->nilai)+($rta->nilai))/4;
            $datas[$mapel->kode_mapel]['k3']['na'] = $na3;

            $rt3 = DB::table('nilai3s')->select(DB::raw(
                'kd_id, AVG(nilai) as rt2'
            ))
            ->where([
                ['mapel_id', '=', $mapel->kode_mapel],
                ['siswa_id', '=', $request->query('nisn')],
            ])->groupBy('mapel_id', 'kd_id')
            ->get();

            foreach($rt3 as $rt)
            {
                $datas[$mapel->kode_mapel]['k3']['rt'][$rt->kd_id] = $rt->rt2;
            }

            $maxkd3 = (isset($datas[$mapel->kode_mapel]['k3']['rt'])) ? array_keys((
                $datas[$mapel->kode_mapel]['k3']['rt']), max($datas[$mapel->kode_mapel]['k3']['rt'])
            ) : null;
            $max3 = (isset($datas[$mapel->kode_mapel]['k3']['rt'])) ? max($datas[$mapel->kode_mapel]['k3']['rt']) : null;
            // $datas[$mapel->kode_mapel]['k3']['maxkd']=$maxkd3;
            if ( isset($maxkd3) ) {
                foreach ($maxkd3 as $m)
                {
                    $kd = 'App\Kd'::where([
                        ['kode_kd','=',$m],
                        ['mapel_id','=',$mapel->kode_mapel],
                        ['tingkat','=',$rombel->tingkat]
                    ])->first();

                    // $datas[$mapel->kode_mapel]['k3']['max'][$m] = $kd;
                    $datas[$mapel->kode_mapel]['k3']['max'][$m] = $this->kata_op3($max3). ($kd ? $kd->teks_kd : 'Mohon cek tabel KD');
                    // $datas[$mapel->kode_mapel]['k3']['max'][$m] = $this->kata_op3($max3) . ($kd) ? $kd['teks_kd'] : 'Tolong cek Tabel KD '.$m;
                }
            } else {
                $datas[$mapel->kode_mapel]['k3']['max'] = null;
            }

            $minkd3 = (isset($datas[$mapel->kode_mapel]['k3']['rt'])) ? array_keys((
                $datas[$mapel->kode_mapel]['k3']['rt']), min($datas[$mapel->kode_mapel]['k3']['rt'])
            ) : null;
            $min3 = (isset($datas[$mapel->kode_mapel]['k3']['rt'])) ? min($datas[$mapel->kode_mapel]['k3']['rt']) : null;
            
            if ( isset($minkd3) ) {
                foreach ($minkd3 as $m)
                {
                    $kd = 'App\Kd'::where([
                        ['kode_kd','=',$m],
                        ['mapel_id','=',$mapel->kode_mapel],
                        ['tingkat','=',$rombel->tingkat]
                    ])->first();

                    $datas[$mapel->kode_mapel]['k3']['min'][$m] = $this->kata_op3($min3) . ($kd ? $kd['teks_kd'] : 'Tolong cek Tabel KD '.$m);
                }
            } else {
                $datas[$mapel->kode_mapel]['k3']['min'] = null;
            }

        // Nilai K4
             // Rata2 Harian
             $rth4 = DB::table('nilai4s')->select(DB::raw(
                'AVG(nilai) AS nilai'
            ))->where([
                ['siswa_id','=', $request->query('nisn')],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                ['rombel_id','=',$rombel->kode_rombel],
                ['mapel_id', '=', $mapel->kode_mapel],
                ['jenis','=','uh']
            ])->first();
            
            // Rata2 PTS
            $rtt4 = DB::table('nilai4s')->select(DB::raw(
                'AVG(nilai) AS nilai'
            ))->where([
                ['siswa_id','=', $request->query('nisn')],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                ['rombel_id','=',$rombel->kode_rombel],
                ['mapel_id', '=', $mapel->kode_mapel],
                ['jenis','=','pts']
            ])->first();
            
            // Rata2 PAS
            $rta4 = DB::table('nilai4s')->select(DB::raw(
                'AVG(nilai) AS nilai'
            ))->where([
                ['siswa_id','=', $request->query('nisn')],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                ['rombel_id','=',$rombel->kode_rombel],
                ['mapel_id', '=', $mapel->kode_mapel],
                ['jenis','=','pas']
            ])->first();

            $na4 = (($rth4->nilai*2)+($rtt4->nilai)+($rta4->nilai))/4;
            $datas[$mapel->kode_mapel]['k4']['na'] = $na4;

            $rt4 = DB::table('nilai4s')->select(DB::raw(
                'kd_id, AVG(nilai) as rt2'
            ))
            ->where([
                ['mapel_id', '=', $mapel->kode_mapel],
                ['siswa_id', '=', $request->query('nisn')],
            ])->groupBy('mapel_id', 'kd_id')
            ->get();

            foreach($rt4 as $rt)
            {
                $datas[$mapel->kode_mapel]['k4']['rt'][$rt->kd_id] = $rt->rt2;
            }

            $maxkd4 = (isset($datas[$mapel->kode_mapel]['k4']['rt'])) ? array_keys((
                $datas[$mapel->kode_mapel]['k4']['rt']), max($datas[$mapel->kode_mapel]['k4']['rt'])
            ) : null;
            $max4 = (isset($datas[$mapel->kode_mapel]['k4']['rt'])) ? max($datas[$mapel->kode_mapel]['k4']['rt']) : null;
            // $datas[$mapel->kode_mapel]['k3']['maxkd']=$maxkd3;
            if ( isset($maxkd4) ) {
                foreach ($maxkd4 as $m)
                {
                    $kd = 'App\Kd'::where([
                        ['kode_kd','=',$m],
                        ['mapel_id','=',$mapel->kode_mapel],
                        ['tingkat','=',$rombel->tingkat]
                    ])->first();

                    // $datas[$mapel->kode_mapel]['k3']['max'][$m] = $kd;
                    $datas[$mapel->kode_mapel]['k4']['max'][$m] = $this->kata_op3($max4). ($kd ? $kd->teks_kd : 'Mohon cek tabel KD');
                    // $datas[$mapel->kode_mapel]['k3']['max'][$m] = $this->kata_op3($max3) . ($kd) ? $kd['teks_kd'] : 'Tolong cek Tabel KD '.$m;
                }
            } else {
                $datas[$mapel->kode_mapel]['k4']['max'] = null;
            }

            $minkd4 = (isset($datas[$mapel->kode_mapel]['k4']['rt'])) ? array_keys((
                $datas[$mapel->kode_mapel]['k4']['rt']), min($datas[$mapel->kode_mapel]['k4']['rt'])
            ) : null;
            $min4 = (isset($datas[$mapel->kode_mapel]['k4']['rt'])) ? min($datas[$mapel->kode_mapel]['k4']['rt']) : null;
            
            if ( isset($minkd4) ) {
                foreach ($minkd4 as $m)
                {
                    $kd = 'App\Kd'::where([
                        ['kode_kd','=',$m],
                        ['mapel_id','=',$mapel->kode_mapel],
                        ['tingkat','=',$rombel->tingkat]
                    ])->first();

                    $datas[$mapel->kode_mapel]['k4']['min'][$m] = $this->kata_op3($min4) . ($kd ? $kd['teks_kd'] : 'Tolong cek Tabel KD '.$m);
                }
            } else {
                $datas[$mapel->kode_mapel]['k4']['min'] = null;
            }
        }



        // dd($datas);

        return $datas;
    }

    public function saran($request)
    {
        $datas = [];
        $nisn = $request->query('nisn');
        $periode = $request->session()->get('periode_aktif');
        // $sarans = 
        $datas['pts'] = 'App\Saran'::where([
            ['periode_id','=',$periode],
            ['siswa_id','=', $nisn],
            ['jenis_rapor','=','pts']
        ])->select('teks','id')->first();
        $datas['pas'] = 'App\Saran'::where([
            ['periode_id','=',$periode],
            ['siswa_id','=', $nisn],
            ['jenis_rapor','=','pas']
        ])->select('teks','id')->first();
        // dd($datas);
        return $datas;
    }

    public function sikap($request)
    {
        $datas = ['k1'=>null,'k2' => null];
        $nisn = $request->query('nisn');
        $periode = $request->session()->get('periode_aktif');
        $n1s = DB::table('nilai1s')->select(DB::raw('
            kd_id,
            AVG(nilai) AS rt1
        '))
        ->where([
            ['siswa_id','=', $nisn],
            ['periode_id','=', $periode],
            ['rombel_id','=', $request->session()->get('rombel_id')],
        ])
        ->groupBy('kd_id')
        ->get();
        if($n1s->count() > 0) {
            foreach($n1s as $n)
            {
                $kd = 'App\ButirSikap'::where('kode_kd','=',$n->kd_id)->first();
                $datas['k1'][$n->kd_id] = $this->kata_op1($n->rt1).$kd->teks;
            }
        }
        $n2s = DB::table('nilai2s')->select(DB::raw('
            kd_id,
            AVG(nilai) AS rt2
        '))
        ->where([
            ['siswa_id','=', $nisn],
            ['periode_id','=', $periode],
            ['rombel_id','=', $request->session()->get('rombel_id')],
        ])
        ->groupBy('kd_id')
        ->get();
        if($n1s->count() > 0) {
            foreach($n2s as $n)
            {
                $kd = 'App\ButirSikap'::where('kode_kd','=',$n->kd_id)->first();
                $datas['k2'][$n->kd_id] = $this->kata_op1($n->rt2).$kd->teks;
            }
        }
        // dd($datas);
        return $datas;
    }

    public function kata_op1($nilai)
    {
        $teks = '';
        switch($nilai)
        {
            case($nilai >=90):
                return " sangat ";
            break;
            case($nilai >=80):
                return " baik dalam ";
            break;
            case($nilai >=70):
                return " cukup dalam ";
            break;
            default:
                return " perlu bimbingan dalam ";
            break;
            
        }
    }

    public function kata_op3($nilai)
    {
        switch($nilai)
        {
            case($nilai >= 90):
                return "sangat baik dalam ";
            break;
            case($nilai >= 80):
                return "baik dalam ";
            break;
            case($nilai >= 70):
                return "cukup dalam ";
            break;
            default:
                return "perlu bimbingan dalam ";
            break;
        }
        // return "halo";
    }
    public function ekskul($request)
    {
        $datas = [];
        
        $ekskuls = 'App\Ekskul'::where('sekolah_id','=', $request->session()->get('sekolah_id'))->get();
        foreach($ekskuls as $eks)
        {
            $datas[$eks->kode_ekskul]['nama_ekskul'] = $eks->nama_ekskul;
            // $datas[$eks->kode_ekskul]['nama_ekskul'] = $eks->nama_ekskul;
            

            $n_eks = 'App\NilaiEkskul'::where([
                ['sekolah_id','=',$request->session()->get('sekolah_id')],
                ['periode','=',$request->session()->get('periode_aktif')],
                ['siswa_id','=',$request->query('nisn')],
                ['tingkat','=',$request->session()->get('rombel')->tingkat],
                ['ekskul_id','=', $eks->kode_ekskul]
            ])
            ->first();
            
            $datas[$eks->kode_ekskul]['ket'] = $n_eks ? $n_eks->keterangan : null;
            $datas[$eks->kode_ekskul]['id_nilai'] = $n_eks ? $n_eks->id : null;

        }

        // dd($datas);
        return $datas;
    }
}
