<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saran extends Model
{
    protected $fillable = ['sekolah_id','periode_id','siswa_id','jenis_rapor', 'teks'];

    public function siswas()
    {
        $this->belongsTo('App\Siswa', 'siswa_id','nisn');
    }
}
