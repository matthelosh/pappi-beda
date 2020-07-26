<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = [
        'tanggal',
        'periode_id',
        'rombel_id',
        'butir_sikap',
        'aspek',
        'siswa_id',
        'catatan',
        'nilai'
    ];

    public function siswas()
    {
        return $this->belongsTo('App\Siswa', 'siswa_id', 'nisn');
    }

    public function periodes()
    {
        return $this->belongsTo('App\Periode', 'periode_id', 'kode_periode');
    }
}
