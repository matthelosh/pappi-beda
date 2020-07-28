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

class NilaiController extends Controller
{
    use NilaiTrait;
    public function index(Request $request)
    {
        if($request->query('req')) {
            switch($request->query('req'))
            {
                case "view":
                    $input = $request->all();
                    $rombel = $request->rombel;
                    // dd($request->all());
                    $nilai = ($request->aspek == '3') ? 'App\Nilai3' : 'App\Nilai4';
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
                            array_push($datas, ['nisn' => $siswa->nisn, 'nama_siswa' => $siswa->nama_siswa, 'nilai' => 0, 'id_nilai' => null]);
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
                    }

                    // dd($nilais);
                    return response()->json(['status' => 'sukses', 'datas' => $datas, 'msg' => 'Data Siswa']);
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
        ])->get();
        foreach($siswas as $siswa)
        {
            array_push($datas, ['NIS' => ($siswa->nis)?$siswa->nis: null, 'NISN' => $siswa->nisn, 'NAMA SISWA' => $siswa->nama_siswa, 'n1' => [], 'n2' => [], 'n3' => [], 'n4' => [] ]);
        }



        $nilai3 = DB::table('nilai3s')
                    ->select(DB::raw('nilai3s.siswa_id, 
                    AVG(CASE WHEN nilai3s.mapel_id = "pabp" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_pabp_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "ppkn" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_ppkn_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "bid" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_bid_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "mtk" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_mtk_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "ipa" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_ipa_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "ips" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_ips_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "sbdp" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_sbdp_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "pjok" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_pjok_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "bd" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_bd_uh",
                    AVG(CASE WHEN nilai3s.mapel_id = "big" AND nilai3s.jenis = "uh" THEN nilai3s.nilai END) as "n3_big_uh",
                    
                    AVG(CASE WHEN nilai3s.mapel_id = "pabp" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_pabp_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "ppkn" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_ppkn_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "bid" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_bid_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "mtk" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_mtk_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "ipa" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_ipa_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "ips" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_ips_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "sbdp" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_sbdp_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "pjok" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_pjok_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "bd" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_bd_pts",
                    AVG(CASE WHEN nilai3s.mapel_id = "big" AND nilai3s.jenis = "pts" THEN nilai3s.nilai END) as "n3_big_pts",

                    
                    AVG(CASE WHEN nilai3s.mapel_id = "pabp" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_pabp_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "ppkn" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_ppkn_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "bid" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_bid_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "mtk" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_mtk_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "ipa" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_ipa_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "ips" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_ips_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "sbdp" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_sbdp_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "pjok" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_pjok_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "bd" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_bd_pas",
                    AVG(CASE WHEN nilai3s.mapel_id = "big" AND nilai3s.jenis = "pas" THEN nilai3s.nilai END) as "n3_big_pas"
                    
                    '))
                    ->groupBy('nilai3s.siswa_id')
                    ->where([
                        ['periode_id','=', $request->session()->get('periode_aktif')],
                        $rombel
                    ]);

        $nilai4 = DB::table('nilai4s')
                    ->select(DB::raw('nilai4s.siswa_id, 
                    AVG(CASE WHEN nilai4s.mapel_id = "pabp" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_pabp_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "ppkn" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_ppkn_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "bid" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_bid_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "mtk" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_mtk_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "ipa" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_ipa_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "ips" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_ips_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "sbdp" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_sbdp_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "pjok" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_pjok_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "bd" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_bd_uh",
                    AVG(CASE WHEN nilai4s.mapel_id = "big" AND nilai4s.jenis = "uh" THEN nilai4s.nilai END) as "n3_big_uh",
                    
                    AVG(CASE WHEN nilai4s.mapel_id = "pabp" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_pabp_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "ppkn" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_ppkn_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "bid" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_bid_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "mtk" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_mtk_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "ipa" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_ipa_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "ips" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_ips_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "sbdp" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_sbdp_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "pjok" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_pjok_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "bd" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_bd_pts",
                    AVG(CASE WHEN nilai4s.mapel_id = "big" AND nilai4s.jenis = "pts" THEN nilai4s.nilai END) as "n3_big_pts",

                    
                    AVG(CASE WHEN nilai4s.mapel_id = "pabp" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_pabp_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "ppkn" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_ppkn_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "bid" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_bid_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "mtk" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_mtk_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "ipa" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_ipa_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "ips" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_ips_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "sbdp" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_sbdp_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "pjok" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_pjok_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "bd" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_bd_pas",
                    AVG(CASE WHEN nilai4s.mapel_id = "big" AND nilai4s.jenis = "pas" THEN nilai4s.nilai END) as "n3_big_pas"
                    
                    '))
                    ->groupBy('nilai4s.siswa_id')
                    ->where([
                        ['periode_id','=', $request->session()->get('periode_aktif')],
                        $rombel
                    ]);

        $rekap34 = DB::table('siswas')
                        ->joinSub($nilai3, 'nilai3', function($join) {
                            $join->on('siswas.nisn', '=', 'nilai3.siswa_id');
                            
                        })
                        // ->joinSub($nilai4, 'nilai4', function ($join) {
                        //     $join->on('siswas.nisn', '=', 'nilai4.siswa_id');
                        //     // $join->type('left');
                        // })
                        ->select('siswas.nis','siswas.nisn', 'siswas.rombel_id', 'siswas.nama_siswa', 'siswas.jk', 'nilai3.*')
                        ->get();

// s
        
        return response()->json($datas);
        // return DataTables::of($rekaps)->addIndexColumn()->toJson();
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('file_nilai');
            $mime = $file->getClientMimeType();
            $nama = $file->getClientOriginalName();
            $pecah = explode('.', $nama);
            $rombel = 'App\Rombel'::where('kode_rombel', $pecah[1])->first();
            $headings = (new HeadingRowImport)->toArray($file);
            Excel::import(new ImportNilai($headings, $pecah[1], $rombel->tingkat, $request->session()->get('periode_aktif'),$pecah[2],$pecah[3]), $file);

            return back()->with(['status' => 'sukses', 'msg' => 'Nilai dimpor']);
        } catch(\Exception $e)
        {
            return back()->with(['status' => 'error', 'msg' => $e->getCode().':'.$e->getMessage()]);
        
        }
        
    }

    public function entri(Request $request)
    {
        try {
            $rombel = $request->session()->get('rombel_id');
            $nilai = ($request->aspek == '3') ? 'App\Nilai3' : 'App\Nilai4';
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
            return redirect('/'.$request->session()->get('username').'/nilais/entri')->with(['status' => 'sukses', 'msg' => 'Nilai disimpan']);
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
        $file =  Excel::download(new ExportFormatNilai($mapel, $rombel, $aspek), 'FormatNilai.xlsx');

        return $file;
        // return (new ExportFormatNilai($mapel, $rombel, $aspek))->download('invoices.xlsx', \Maatwebsite\Excel\Excel::XLSX); 
    }
}
