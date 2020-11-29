<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KesehatanSiswa extends Model
{
    protected $fillable = ['sekolah_id','periode','rombel_id','siswa_id','pendengaran','penglihatan','gigi','lain','tingkat'];

    public function siswas()
    {
        return $this->belongsTo('App\Siswa','siswa_id','nisn');
    }
}
