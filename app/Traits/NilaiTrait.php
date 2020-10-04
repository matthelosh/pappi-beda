<?php
namespace App\Traits;

// use Illuminate\Http\Request;
use App\Nilai1;
use App\Nilai2;
use App\Nilai3;
use App\Nilai4;
use Illuminate\Support\Facades\DB;

trait NilaiTrait
{
    public function rekap($request)
    {
        $nilai3 = Nilai3::all();
        return  $nilai3;
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

            $na3 = DB::table('nilai3s')->select(DB::raw(
                'AVG(nilai) AS na'
            ))->where([
                ['siswa_id','=', $request->query('nisn')],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                ['rombel_id','=',$rombel->kode_rombel],
                ['mapel_id', '=', $mapel->kode_mapel]
            ])->first();
            $datas[$mapel->kode_mapel]['k3']['na'] = $na3->na;

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
        }

        

        dd($datas);
        
        return [];
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
        foreach($mapels as $mapel)
        {
            $datas[$mapel->kode_mapel]['nama_mapel'] = $mapel->nama_mapel;

            $kds  = 'App\Prosem'::where([
                ['semester','=', $semester_id],
                ['tingkat','=', $rombel->tingkat],
                ['mapel_id','=',$mapel->kode_mapel],
                
            ])
            // ->whereIn('tema_id',[$rombel->tingkat.'-1',$rombel->tingkat.'-2'])
            // ->groupBy('kd_id')
            ->get();
            
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
            }

        }
        // dd($datas);
        return $datas;    
    }
    
    
}