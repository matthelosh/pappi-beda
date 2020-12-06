<?php

namespace App;

// use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    // use SoftDeletes;
    // use SoftCascadeTrait;

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

    // protected $softCascade = ['ortus','ekskuls','fisiks', 'kesehatans', 'prestasis','absens','nilais'];

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

    public function ekskuls()
    {
        return $this->hasMany('App\Ekskul', 'siswa_id', 'nisn');
    }

    public function fisiks()
    {
        return $this->hasMany('App\FisikSiswa','siswa_id','nisn');
    }

    public function kesehatans()
    {
        return $this->hasMany('App\KesehatanSiswa','siswa_id','nisn');
    }

    public function prestasis()
    {
        return $this->hasMany('App\Kesenian','siswa_id','nisn');
    }

    public function absens()
    {
        return $this->hasMany('App\Absensi','siswa_id','nisn');
    }

    public function nilais()
    {
        return $this->hasMany('App\Nilai','siswa_id','nisn');
    }

    public function periodiks()
    {
        return $this->hasMany('App\Periodik', 'siswa_id', 'nisn');
    }
}
