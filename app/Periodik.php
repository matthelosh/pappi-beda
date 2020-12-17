<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodik extends Model
{
    protected $fillable = ['sekolah_id','periode_id','rombel_id', 'siswa_id'];


    public function sekolahs()
    {
        return $this->belongsTo('App\Sekolah', 'sekolah_id', 'npsn');
    }

    public function siswas()
    {
        return $this->belongsTo('App\Siswa', 'siswa_id', 'nisn');
    }

    public function rombels()
    {
        return $this->belongsTo('App\Rombel', 'rombel_id', 'kode_rombel');
    }
}
