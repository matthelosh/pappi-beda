<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TanggalRapor extends Model
{
    protected $fillable = ['sekolah_id', 'periode_id', 'tanggal'];

    public function sekolahs()
    {
        return $this->belongsTo('App\Sekolah', 'sekolah_id', 'npsn');
    }

    public function periodes()
    {
        return $this->belongsTo('App\Periode', 'periode_id', 'kode_periode');
    }
}
