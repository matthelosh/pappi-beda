<?php

namespace App\Imports;

use App\Rombel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportRombel implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rombel([
            'sekolah_id' => $row['sekolah_id'],
            'kode_rombel' => $row['kode_rombel'],
            'nama_rombel' => $row['nama_rombel'],
            'tingkat' => $row['tingkat'],
            'guru_id' => $row['guru_id'],
            
        ]);
    }
}
