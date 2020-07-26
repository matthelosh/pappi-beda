<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ortu extends Model
{
    protected $fillable = [
        'siswa_id',
        'nama_ayah',
        'job_ayah',
        'nama_ibu',
        'job_ibu',
        'nama_wali',
        'hub_wali',
        'job_wali',
        'alamat_wali'
    ];

    public function siswas()
    {
        return $this->belongsTo('App\Siswa', 'siswa_id', 'nisn');
    }
}
