<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FisikSiswa extends Model
{
    protected $fillable = ['sekolah_id','periode','siswa_id','tingkat', 'rombel_id','tb','bb'];

    public function siswas()
    {
        return $this->belongsTo('App\Siswa','siswa_id','nisn');
    }
}
