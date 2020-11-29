<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = ['sekolah_id','periode','rombel_id','tingkat','siswa_id','alpa','ijin','sakit'];

    public function siswas()
    {
        return $this->belongsTo('App\Siswa','siswa_id','nisn');
    }
}
