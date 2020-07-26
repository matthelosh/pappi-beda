<?php

namespace App\Exports;

use App\Siswa;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportFormatNilai implements WithMultipleSheets, ShouldAutoSize
{

    protected $rombel;
    protected $mapel;
    protected $aspek;

    public function __construct($mapel, $rombel,  $aspek)
    {
        $this->mapel = $mapel;
        $this->rombel = $rombel->kode_rombel;
        $this->tingkat = $rombel->tingkat;
        $this->aspek = $aspek;
    }
    
    public function sheets(): array
    {
        $sheets = [];
        $tipes = ['UH', 'PTS', 'PAS'];
        for($i=0;$i<count($tipes);$i++) {
            $sheets[] = new FormatNilai($this->rombel, $this->tingkat, $this->mapel, $tipes[$i], $this->aspek);   
        }

        return $sheets; 

    }
}
