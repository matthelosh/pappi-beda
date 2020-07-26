<?php

namespace App\Imports;

use App\Siswa;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSiswa implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Siswa([
            'nis' => $row['nis'],
            'nisn'=> $row['nisn'],
            'nama_siswa'=> $row['nama_siswa'],
            'jk'=> $row['jk'],
            'agama'=> $row['agama'],
            'alamat'=> $row['alamat'],
            'desa'=> $row['desa'],
            'kec'=> $row['kec'],
            'kab'=> $row['kab'],
            'prov'=> $row['prov'],
            'hp'=> $row['hp'],
            'sekolah_id'=> $row['sekolah_id'],
            'rombel_id'=> $row['rombel_id']
        ]);
    }
}
