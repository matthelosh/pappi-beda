<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'alamat',
        'desa',
        'kec',
        'kab',
        'prov',
        'kode_pos',
        'telp',
        'email',
        'website',
        'operator_id',
        'ks_id'
    ];

    public function ks()
    {
        return $this->belongsTo('App\User', 'ks_id', 'nip');
    }

    public function operators()
    {
        return $this->belongsTo('App\User', 'operator_id', 'nip');
    }

    public function gurus()
    {
        return $this->hasMany('App\User', 'sekolah_id', 'npsn');
    }

}
