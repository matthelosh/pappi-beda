<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kkm extends Model
{
    protected $fillable = ['sekolah_id', 'periode_id', 'mapel_id', 'rombel_id','nilai' ];

    public function mapels()
    {
        return $this->belongsTo('App\Mapel', 'mapel_id', 'kode_mapel');
    }

    public function sekolahs()
    {
        return $this->belongsTo('App\Sekolah', 'sekolah_id', 'npsn');
    }

    public function rombels()
    {
        return $this->belongsTo('App\Rombel', 'rombel_id', 'kode_rombel');
    }

    public function periodes()
    {
        return $this->belongsTo('App\Periode', 'periode_id', 'kode_periode');
    }
}
