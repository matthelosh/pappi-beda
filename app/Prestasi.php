<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = ['sekolah_id','periode','tingkat','rombel_id','siswa_id', 'olahraga','kesenian'];

    public function siswas()
    {
        return $this->belongsTo('App\Siswa','siswa_id','nisn');
    }
}
