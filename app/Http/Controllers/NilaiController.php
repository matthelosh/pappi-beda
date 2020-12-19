<?php

namespace App\Http\Controllers;

use App\Nilai3;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportFormatNilai;
use App\Imports\ImportNilai;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\HeadingRowImport;
use App\Traits\NilaiTrait;
use Ramsey\Uuid\Rfc4122\NilTrait;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;


class NilaiController extends Controller
{
    use NilaiTrait;
    public function index(Request $request)
    {
        if($request->query('req')) {
            switch($request->query('req'))
            {
                case "view":
                    $status_form = 'create';
                    $input = $request->all();
                    $rombel = $request->rombel;
                    // dd($request->all());
                    $nilai = '';
                    switch($request->aspek)
                    {
                        case "1":
                            $nilai = 'App\Nilai1';
                        break;
                        case "2":
                            $nilai = 'App\Nilai2';
                        break;
                        case "3":
                            $nilai = 'App\Nilai3';
                        break;
                        case "4":
                            $nilai = 'App\Nilai4';
                        break;
                    }
                    $nilais = $nilai::where([
                        ['sekolah_id','=',$request->session()->get('sekolah_id')],
                        ['periode_id','=',$request->periode_id],
                        ['jenis','=',$request->jenis],
                        ['mapel_id','=',$request->mapel_id],
                        ['rombel_id','=',$rombel],
                        ['kd_id','=',$request->kd_id]
                    ])->get();
                    $siswas = 'App\Siswa'::where('rombel_id', $rombel)->get();
                    $datas = [];
                    foreach($siswas as $siswa)
                        {
                            array_push($datas, ['nisn' => $siswa->nisn, 'nama_siswa' => $siswa->nama_siswa, 'nilai' => ($request->aspek == '1' || $request->aspek == '2') ? 80: 0, 'id_nilai' => null]);
                        }

                    if($nilais->count() > 0) {
                        for($i=0;$i < count($datas); $i++)
                           {
                               foreach($nilais as $nilai)
                               {
                                   if($nilai->siswa_id == $datas[$i]['nisn']) {
                                       $datas[$i]['nilai'] = $nilai->nilai;
                                       $datas[$i]['id_nilai'] = $nilai->id;
                                   }
                               }
                           }
                        $status_form = 'update';
                    }
                    // dd($datas);
                    // dd($input);
                    return response()->json(['status' => 'sukses', 'datas' => $datas, 'status_form' => $status_form, 'msg' => 'Data Nilai Siswa']);
                break;
            }
        }
    }

    public function rekap(Request $request)
    {
        // dd($request->all());
        switch($request->aspek)
        {
            case "1":
                $nilai = 'App\Nilai1';
            break;
            case "2":
                $nilai = 'App\Nilai2';
            break;
            case "3":
                $nilai = 'App\Nilai3';
            break;
            case "4":
                $nilai = 'App\Nilai4';
            break;
        }
        $datas = [];
        $siswas = 'App\Siswa'::where('rombel_id', $request->rombel)->get();
        foreach($siswas as $siswa) {
            $datas[] = ['nisn'=> $siswa->nisn,'nama_siswa' => $siswa->nama_siswa];
        }

        foreach($siswas as $siswa) {
            $nu = $nilai::where([
                ['sekolah_id','=',$request->session()->get('sekolah_id')],
                ['rombel_id','=', $request->rombel],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                ['siswa_id', '=', $siswa->nisn],
                ['mapel_id','=', $request->mapel],
                ['jenis','=',$request->jenis]
            ])
            ->get();
                for($i=0;$i < count($datas); $i++) {
                    
                    if($datas[$i]['nisn'] == $siswa->nisn){
                        $datas[$i]['rekap'] = $nilai::where([
                            ['sekolah_id','=',$request->session()->get('sekolah_id')],
                            ['rombel_id','=', $request->rombel],
                            ['periode_id','=', $request->session()->get('periode_aktif')],
                            ['siswa_id', '=', $siswa->nisn],
                            ['mapel_id','=', $request->mapel],
                            ['jenis','=',$request->jenis]
                        ])->avg('nilai');
                    }
                    foreach($nu as $n) {
                        if($datas[$i]['nisn'] == $n->siswa_id) {
                            $datas[$i][$n->kd_id] =$n->nilai;
                        }
                    }

                    
                    // $datas[$i]['rekap'] = $rt;
                }
            
            
        }

            // End K3
            
            $kds = $nilai::select('kd_id')->where([
                ['sekolah_id','=',$request->session()->get('sekolah_id')],
                ['rombel_id','=', $request->rombel],
                ['periode_id','=', $request->session()->get('periode_aktif')],
                
                ['mapel_id','=', $request->mapel],
                ['jenis','=',$request->jenis]
            ])->groupBy('kd_id')
            ->get();
        
        // dd($kds);
        return response()->json(['datas' => $datas, 'kds'=>$kds]);

    }

    // public function rekap(Request $request)
    // {

    //     $datas = [];
    //     $rombel = ($request->query('rombel') == '0') ? ['rombel_id', '<>','0'] : ['rombel_id', '=', $request->query('rombel')];

    //     $siswas = 'App\Siswa'::where([
    //         $rombel
    //     ])
    //     ->with('rombels')
    //     ->get();
    //     foreach($siswas as $siswa)
    //     {
    //         array_push($datas, ['NISN' => $siswa->nisn, 'NAMA SISWA' => $siswa->nama_siswa, 'KODE ROMBEL' => $siswa->rombel_id, 'NAMA ROMBEL' => $siswa->rombels->nama_rombel, 'uh' => 0, 'pts' => 0, 'pas' => 0]);
    //     }
    //     if (Auth::user()->role != 'wali' ) {

    //         $mapel = (Auth::user()->role == 'gpai') ? 'pabp' : (Auth::user()->role == 'gor' ? 'pjok' : 'big');
    //         $nilai_pabp_3 = DB::table('nilai3s')
    //                     ->select(DB::raw('nilai3s.siswa_id,
    //                     AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_'.$mapel.'_uh",
    //                     AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_'.$mapel.'_pts",
    //                     AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_'.$mapel.'_pas"
    //                     '))
    //                     ->groupBy('nilai3s.siswa_id')

    //                     ->orderBy('nilai3s.rombel_id')
    //                     ->where([
    //                         ['periode_id','=', $request->session()->get('periode_aktif')],
    //                         $rombel
    //                     ]);


    //         $nilai4 = DB::table('nilai4s')
    //                     ->select(DB::raw('nilai4s.siswa_id,
    //                     AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n4_'.$mapel.'_uh",

    //                     AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n4_'.$mapel.'_pts",


    //                     AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n4_'.$mapel.'_pas"

    //                     '))
    //                     ->groupBy('nilai4s.siswa_id')
    //                     ->where([
    //                         ['periode_id','=', $request->session()->get('periode_aktif')],
    //                         $rombel
    //                     ]);
    //     } else {
    //         $mapel = $request->query('mapel');
    //         $nilai_pabp_3 = DB::table('nilai3s')
    //                     ->select(DB::raw('nilai3s.siswa_id,
    //                     AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_'.$mapel.'_uh",
    //                     AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_'.$mapel.'_pts",
    //                     AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_'.$mapel.'_pas"
    //                     '))
    //                     ->groupBy('nilai3s.siswa_id')

    //                     ->orderBy('nilai3s.rombel_id')
    //                     ->where([
    //                         ['periode_id','=', $request->session()->get('periode_aktif')],
    //                         $rombel
    //                     ]);


    //         $nilai4 = DB::table('nilai4s')
    //                     ->select(DB::raw('nilai4s.siswa_id,
    //                     AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n4_'.$mapel.'_uh",

    //                     AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n4_'.$mapel.'_pts",


    //                     AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n4_'.$mapel.'_pas"

    //                     '))
    //                     ->groupBy('nilai4s.siswa_id')
    //                     ->where([
    //                         ['periode_id','=', $request->session()->get('periode_aktif')],
    //                         $rombel
    //                     ]);
    //     }

    //     $rekap34 = DB::table('siswas')
    //                     ->joinSub($nilai_pabp_3, 'nilai3', function($join) {
    //                         $join->on('siswas.nisn', '=', 'nilai3.siswa_id');

    //                     })
    //                     ->leftJoinSub($nilai4, 'nilai4', function ($join) {
    //                         $join->on('siswas.nisn', '=', 'nilai4.siswa_id');

    //                     })
    //                     ->select('siswas.nis','siswas.nisn', 'siswas.rombel_id', 'siswas.nama_siswa', 'siswas.jk', 'nilai4.*', 'nilai3.*')
    //                     ->get();

    //     $kkms = 'App\Kkm'::all();


    //     return response()->json(['rekap34' => $rekap34, 'kkms' => $kkms]);
    // }


    public function import(Request $request)
    {
        // dd($request->all());
        try { 
            $nilais = $request->nilais;
            switch($request->aspek)
            {
                case "1":
                    $Nilai = 'App\Nilai1';
                break;
                case "2":
                    $Nilai = 'App\Nilai2';
                break;
                case "3":
                    $Nilai = 'App\Nilai3';
                break;
                case "4":
                    $Nilai = 'App\Nilai4';
                break;

            }
            $datas1 = [];

            $i=0;
            foreach($nilais as $nilai)
            {
                $kds = array_keys($nilai);
                $kds = array_slice($kds,2);
                $ns = array_slice($nilai,2, count($nilais) - 2, true);
                $siswa_id = $nilai['nisn'];
                $datas = [];
                foreach($ns as $k=>$j) 
                {
                    $Nilai::updateOrCreate(
                        [
                            'sekolah_id' => $request->session()->get('sekolah_id'),
                            'periode_id' => $request->periode,
                            'rombel_id' => $request->rombel,
                            'mapel_id' => $request->mapel,
                            'jenis' => $request->jenis,
                            'kd_id' => $k,
                            'siswa_id' => $siswa_id
                        ],
                        [
                            'nilai' => $j 
                        ]
                    );
                    // $datas[] = [$k=>$j];
                }
                // array_push($datas1, $datas);
                
            }
            // dd($datas1);
            return response()->json(['status' => 'sukses', 'msg' => 'Data Nilai siswa diimpor']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'gagal', 'msg' => $e->getCode().$e->getMessage()]);
        }
    }

    public function entri(Request $request)
    {

        // dd($request->query('rombel'));
        try {
            $rombel = $request->query('rombel');
            $nilai = (($request->aspek == '1') ? 'App\Nilai1' : (($request->aspek == '2') ? 'App\Nilai2': (($request->aspek == '3') ? 'App\Nilai3' : 'App\Nilai4')));
            $mapel = $request->mapel_id;
            $kd = $request->kd_id;
            $periode = ($request->periode_id) ? $request->periode_id : $request->session()->get('periode_aktif');
            $kd = $request->kd_id;
            $jenis = $request->jenis;

            foreach($request->nilais as $nisn => $nil)
            {
                // $nilai::create([
                //     'sekolah_id' => $request->session()->get('sekolah_id'),
                //     'periode_id' => $periode,
                //     'kd_id' => $kd,
                //     'mapel_id' => $mapel,
                //     'rombel_id' => $rombel,
                //     'jenis' => $jenis,
                //     'siswa_id' => $nisn,
                //     'nilai' => $nil
                // ]);
                $nilai::updateOrCreate(
                    [
                        'sekolah_id' => $request->session()->get('sekolah_id'),
                        'periode_id' => $periode,
                        'rombel_id' => $rombel,
                        'mapel_id' => $mapel,
                        'jenis' => $jenis,
                        'kd_id' => $kd,
                        'siswa_id' => $nisn
                    ],
                    [
                        'nilai' => $nil
                    ]
                );

            }
            // return redirect('/'.$request->session()->get('username').'/nilais/entri')->with(['status' => 'sukses', 'msg' => 'Nilai disimpan']);
            return response()->json(['status' => 'sukses', 'msg' => 'Nilai Tersimpan']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        }
    }



    public function unduhFormat(Request $request)
    {
        $rombel = 'App\Rombel'::where('kode_rombel', $request->rombel)->first();
        $mapel = $request->mapel;
        $aspek = $request->aspek;


        $siswas = 'App\Siswa'::where([
            ['sekolah_id','=', Auth::user()->sekolah_id],
            ['rombel_id','=',$request->rombel]
        ])->get();
        
        $datas = [];
        foreach ( $siswas as $siswa )
        {
            $datas[] = ['nisn' => $siswa->nisn, 'nama_siswa' => $siswa->nama_siswa];
            
        }

        return response()->json(['status' => 'sukses', 'msg' => 'Data Siswa', 'data' => $datas]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $nilai = (($request->aspek == '1') ? 'App\Nilai1' : (($request->aspek == '2') ? 'App\Nilai2': (($request->aspek == '3') ? 'App\Nilai3' : 'App\Nilai4')));;
        $nilai::updateOrCreate(
            [
                'id' => $request->id_nilai,
                'sekolah_id' => $request->session()->get('sekolah_id'),
                'periode_id' => $request->periode,
                'rombel_id' => $request->rombel_id,
                'mapel_id' => $request->mapel_id,
                'jenis' => $request->jenis,
                'kd_id' => $request->kd_id,
                'siswa_id' => $request->siswa_id
            ],
            [
                'nilai' => $request->nilai
            ]
        );
        return response()->json(['status'=> 'sukses', 'msg' => 'Nilai diperbarui']);
    }
}
