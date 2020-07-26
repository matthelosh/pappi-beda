<?php

namespace App\Imports;

use App\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class ImportUsers implements ToModel, WithValidation, WithHeadingRow, SkipsOnError
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'username' => $row['username'],
            'jk' => $row['jk'],
            'password' => Hash::make($row['password']),
            'email' => $row['email'],
            'hp' => $row['hp'],
            'default_password' => $row['default_password'],
            'alamat' => $row['alamat'],
            'level' => $row['level'],
            'role' => $row['role']
        ]);
    }

    public function rules(): array
    {
        return [
            'nip' => Rule::unique('users', 'nip')
        ];
    }
    public function customValidationMessages()
    {
        return [
            '1.in' => 'Data sudah ada for :nip',
        ];
    }
    public function onError(\Throwable $e)
    {
        return $e->getCode().':'.$e->getMessage();
    }
}
