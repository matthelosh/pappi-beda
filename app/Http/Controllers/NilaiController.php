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
        // if($request->query('rombel' == '0')) {
        //     $data = [
        //         "id"=> null,
        //         "nis"=> null,
        //         "nisn"=> null,
        //         "nama_siswa"=> "Pilih Rombel Dulu",
        //         "jk"=> null,
        //         "alamat"=> null,
        //         "desa"=> null,
        //         "kec"=> null,
        //         "kab"=> null,
        //         "prov"=> null,
        //         "hp"=> null,
        //         "sekolah_id"=> null,
        //         "rombel_id"=> null,
        //         "created_at"=> null,
        //         "updated_at"=> null,
        //         "agama"=> null,
        //         "siswa_id"=> null,
        //         "n3_pabp_uh"=> null,
        //         "n3_ppkn_uh"=> null,
        //         "n3_bid_uh"=> null,
        //         "n3_mtk_uh"=> null,
        //         "n3_ipa_uh"=> null,
        //         "n3_ips_uh"=> null,
        //         "n3_sbdp_uh"=> null,
        //         "n3_pjok_uh"=> null,
        //         "n3_bd_uh"=> null,
        //         "n3_big_uh"=> null,
        //     ];
        // }
        /**
         *  nis , nama siswa, rombel, mapel
         *                            3.1,3.2,3,3,3.4 | 4.1, 4.2, 4.3, 4.4
         * 1, 'A', 'i', 'pabp', 80,90,80,70
         */
        $datas = [];
        $rombel = ($request->query('rombel') == '0') ? ['rombel_id', '<>','0'] : ['rombel_id', '=', $request->query('rombel')];

        $siswas = 'App\Siswa'::where([
            $rombel
        ])
        ->with('rombels')
        ->get();
        foreach($siswas as $siswa)
        {
            array_push($datas, ['NISN' => $siswa->nisn, 'NAMA SISWA' => $siswa->nama_siswa, 'KODE ROMBEL' => $siswa->rombel_id, 'NAMA ROMBEL' => $siswa->rombels->nama_rombel, 'uh' => 0, 'pts' => 0, 'pas' => 0]);
        }
        // dd($rombel);
        if (Auth::user()->role != 'wali' ) {

            $mapel = (Auth::user()->role == 'gpai') ? 'pabp' : (Auth::user()->role == 'gor' ? 'pjok' : 'big');
            $nilai_pabp_3 = DB::table('nilai3s')
                        ->select(DB::raw('nilai3s.siswa_id,
                        AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_'.$mapel.'_uh",
                        AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_'.$mapel.'_pts",
                        AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_'.$mapel.'_pas"
                        '))
                        ->groupBy('nilai3s.siswa_id')

                        ->orderBy('nilai3s.rombel_id')
                        ->where([
                            ['periode_id','=', $request->session()->get('periode_aktif')],
                            $rombel
                        ]);
                        // ->get();


            $nilai4 = DB::table('nilai4s')
                        ->select(DB::raw('nilai4s.siswa_id,
                        AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n4_'.$mapel.'_uh",

                        AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n4_'.$mapel.'_pts",


                        AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n4_'.$mapel.'_pas"

                        '))
                        ->groupBy('nilai4s.siswa_id')
                        ->where([
                            ['periode_id','=', $request->session()->get('periode_aktif')],
                            $rombel
                        ]);
        } else {
            // $rombel = $request->query('rombel');
            $mapel = $request->query('mapel');
            // dd($rombel);
            $nilai_pabp_3 = DB::table('nilai3s')
                        ->select(DB::raw('nilai3s.siswa_id,
                        AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_'.$mapel.'_uh",
                        AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_'.$mapel.'_pts",
                        AVG(CASE WHEN nilai3s.mapel_id = "'.$mapel.'" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_'.$mapel.'_pas"
                        '))
                        ->groupBy('nilai3s.siswa_id')

                        ->orderBy('nilai3s.rombel_id')
                        ->where([
                            ['periode_id','=', $request->session()->get('periode_aktif')],
                            $rombel
                        ]);
                        // ->get();


            $nilai4 = DB::table('nilai4s')
                        ->select(DB::raw('nilai4s.siswa_id,
                        AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n4_'.$mapel.'_uh",

                        AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n4_'.$mapel.'_pts",


                        AVG(CASE WHEN nilai4s.mapel_id = "'.$mapel.'" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n4_'.$mapel.'_pas"

                        '))
                        ->groupBy('nilai4s.siswa_id')
                        ->where([
                            ['periode_id','=', $request->session()->get('periode_aktif')],
                            $rombel
                        ]);
        }

        $rekap34 = DB::table('siswas')
                        ->joinSub($nilai_pabp_3, 'nilai3', function($join) {
                            $join->on('siswas.nisn', '=', 'nilai3.siswa_id');

                        })
                        ->leftJoinSub($nilai4, 'nilai4', function ($join) {
                            $join->on('siswas.nisn', '=', 'nilai4.siswa_id');

                        })
                        ->select('siswas.nis','siswas.nisn', 'siswas.rombel_id', 'siswas.nama_siswa', 'siswas.jk', 'nilai4.*', 'nilai3.*')
                        ->get();

        $kkms = 'App\Kkm'::all();

// s
        // dd($nilai_pabp_3);

        return response()->json(['rekap34' => $rekap34, 'kkms' => $kkms]);
        // return DataTables::of($rekaps)->addIndexColumn()->toJson();
    }

    // public function import(Request $request)
    // {
    //     try {
    //         $file = $request->file('file_nilai');
    //         $mime = $file->getClientMimeType();
    //         $nama = $file->getClientOriginalName();
    //         $pecah = explode('.', $nama);
    //         $rombel = 'App\Rombel'::where('kode_rombel', $pecah[1])->first();
    //         $headings = (new HeadingRowImport)->toArray($file);
    //         // dd($headings);
    //         Excel::import(new ImportNilai($headings, $pecah[1], $rombel->tingkat, $request->session()->get('periode_aktif'),$pecah[2],$pecah[3]), $file);

    //         return back()->with(['status' => 'sukses', 'msg' => 'Nilai dimpor']);
    //     } catch(\Exception $e)
    //     {
    //         return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);

    //     }

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
            // dd($nilai);
            // $kds = array_keys($nilais[0]);
            // $kds = array_slice($kds,2);
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
                            'rombel_id' => $request->session()->get('rombel')->kode_rombel,
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
        try {
            $rombel = $request->session()->get('rombel_id');
            $nilai = (($request->aspek == '1') ? 'App\Nilai1' : (($request->aspek == '2') ? 'App\Nilai2': (($request->aspek == '3') ? 'App\Nilai3' : 'App\Nilai4')));
            $mapel = $request->mapel_id;
            $kd = $request->kd_id;
            $periode = ($request->periode_id) ? $request->periode_id : $request->session()->get('periode_aktif');
            $kd = $request->kd_id;
            $jenis = $request->jenis;

            foreach($request->nilais as $nisn => $nil)
            {
                $nilai::create([
                    'sekolah_id' => $request->session()->get('sekolah_id'),
                    'periode_id' => $periode,
                    'kd_id' => $kd,
                    'mapel_id' => $mapel,
                    'rombel_id' => $rombel,
                    'jenis' => $jenis,
                    'siswa_id' => $nisn,
                    'nilai' => $nil
                ]);

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

        // $file =  Excel::download(new ExportFormatNilai($mapel, $rombel, $aspek), 'FormatNilai.xlsx');
        // return $file;

        // $data_kds = 'App\Kd'::where([
        //     ['tingkat','=',$rombel->tingkat],
        //     ['mapel_id','=', $mapel],
        //     ['kode_kd', 'LIKE', $aspek.'.%']
        // ])->get();

        $siswas = 'App\Siswa'::where([
            ['sekolah_id','=', Auth::user()->sekolah_id],
            ['rombel_id','=',$request->rombel]
        ])->get();
        
        $datas = [];
        // $datas = [
        //     [
        //         'nisn' => '123',
        //         'nama' => 'Bejo',
        //         '3.1' => '',
        //         '3.2' => ''
        //     ],
        //     [
        //         'nisn' => '124',
        //         'nama' => 'Beji',
        //         '3.1' => '',
        //         '3.2' => ''
        //     ],
        // ];
        // $kds = [];
        // foreach($data_kds as $kd) 
        // {
        //     array_push($kds, [$kd->kode_kd => '']);
        // }
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
        // $nilai = ($request->aspek == '3') ? 'App\Nilai3' : 'App\Nilai4';
        $nilai::find($request->id_nilai)
                ->update(['nilai' => $request->nilai]);
        return response()->json(['status'=> 'sukses', 'msg' => 'Nilai diperbarui']);
    }
}
