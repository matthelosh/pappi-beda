<?php

namespace App\Http\Controllers;

use App\Nilai3;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportFormatNilai;
use App\Imports\ImportNilai;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\HeadingRowImport;

class NilaiController extends Controller
{
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
