<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai3 extends Model
{
    protected $fillable = [ 
        'sekolah_id',
        'periode_id',
        'rombel_id',
        'mapel_id',
        'jenis',
        'kd_id',
        'siswa_id',
        'nilai'
    ];

    public function sekolahs()
    {
        return $this->belongsTo('App\Sekolah', 'sekolah_id', 'npsn');
    }

    public function periodes() 
    {
        return $this->belongsTo('App\Periode', 'periode', 'kode_periode');
    }

    public function rombels()
    {
        return $this->belongsTo('App\Rombel', 'rombel_id', 'kode_rombel');
    }

    public function mapels()
    {
        return $this->belongsTo('App\Mapel', 'mapel_id', 'kode_mapel');
    }

    public function siswas()
    {
        return $this->belongsTo('App\Siswa', 'siswa_id', 'nisn');
    }
}
