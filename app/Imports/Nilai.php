<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Exception;
use Illuminate\Support\Facades\Auth;

class Nilai implements ToCollection, WithHeadingRow
{
    protected $headings;
    protected $rombel;
    protected $tingkat;
    protected $periode;
    protected $mapel;
    protected $aspek;
    protected $jenis;

    public function __construct($headings, $rombel, $tingkat, $periode, $mapel, $aspek, $jenis)
    {
        $this->headings = $headings;
        $this->rombel = $rombel;
        $this->tingkat = $tingkat;
        $this->periode = $periode;
        $this->mapel = $mapel;
        $this->aspek = $aspek;
        $this->jenis = $jenis;
    }

    public function collection(Collection $rows)
    {
        $keys = $this->headings[0][0];
        // dd($this->periode);
        // dd(array_slice($keys[0],2,1));
        // $d = array_slice($this->headings[0], 0,2);
        $kds = array_merge(array_diff_key($keys, ['0', '1']));
        $nilai = ($this->aspek == '3') ? 'App\Nilai3' : 'App\Nilai4';
        foreach($kds as $kd)
        {
            if('App\Kd'::where([['mapel_id', '=', $this->mapel],['tingkat','=',$this->tingkat],['kode_kd','=',str_replace("_",".",$kd)]])->count() > 0 ) {
                foreach($rows as $row)
                {
                    $nilai::create([
                        'sekolah_id' => Auth::user()->sekolah_id,
                        'periode_id' => $this->periode,
                        'jenis' => strtolower($this->jenis),
                        'mapel_id' => $this->mapel,
                        'kd_id' =>str_replace("_",".",$kd),
                        'tingkat' => $this->tingkat,
                        'rombel_id' => $this->rombel,
                        'siswa_id' => $row['nisn'],
                        'nilai' => ($row[$kd] != '' || $row[$kd] != null) ? $row[$kd] : 0
                    ]);
                }
            } else {
                throw new Exception("Maaf! Impor Nilai Gagal. KD ".str_replace("_",".",$kd)." tidak ada untuk mapel ".$this->mapel." di kelas ".$this->tingkat .". Mohon cek kembali file excel Anda.", 11);
            }
        }
        // $s=array_reduce($keys, function($i, $keys) {
        //     return $keys[$i];
        // });
    }
}