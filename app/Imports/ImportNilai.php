<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportNilai implements WithMultipleSheets
{
    protected $headings;
    protected $rombel;
    protected $tingkat;
    protected $periode;
    protected $mapel;
    protected $aspek;
    // protected $jenis;

    public function __construct($headings, $rombel, $tingkat, $periode, $mapel, $aspek)
    {
        $this->headings = $headings;
        $this->rombel = $rombel;
        $this->tingkat = $tingkat;
        $this->periode = $periode;
        $this->mapel = $mapel;
        $this->aspek = $aspek;
        // $this->jenis = $jenis;
    }

    public function sheets():array
    {
        $jenises = ['UH', 'PTS', 'PAS'];
        // foreach($jenises as $k=>$jenis) {
        //     // return [
        //     //     $jenises[$k] => new Nilai($this->headings, $this->rombel, $this->tingkat, $this->periode, $this->mapel, $this->aspek, $jenises[$k])
        //     // ];
        //     dd($jenises[$k]);
        //     return [];
        // }

        return [
            'UH' => new Nilai($this->headings, $this->rombel, $this->tingkat, $this->periode, $this->mapel, $this->aspek, 'uh'),
            'PTS' => new Nilai($this->headings, $this->rombel, $this->tingkat, $this->periode, $this->mapel, $this->aspek, 'pts'),
            'PAS' => new Nilai($this->headings, $this->rombel, $this->tingkat, $this->periode, $this->mapel, $this->aspek, 'pas'),
        ];
    }
}