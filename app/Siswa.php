<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nis',
        'nisn',
        'nama_siswa',
        'jk',
        'agama',
        'alamat',
        'desa',
        'kec',
        'kab',
        'prov',
        'hp',
        'sekolah_id',
        'rombel_id'
    ];

    public function sekolahs()
    {
        return $this->belongsTo('App\Sekolah', 'sekolah_id', 'npsn');
    }

    public function rombels()
    {
        return $this->belongsTo('App\Rombel', 'rombel_id', 'kode_rombel');
    }

    public function ortus()
    {
        return $this->hasOne('App\Ortu', 'siswa_id', 'nisn');
    }
}
