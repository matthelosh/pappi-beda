<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiEkskul extends Model
{
    protected $fillable = ['sekolah_id', 'ekskul_id', 'periode', 'siswa_id', 'tingkat', 'keterangan'];

    public function siswas()
    {
        return $this->belongsTo('App\Siswa', 'siswa_id', 'nisn');
    }
}
