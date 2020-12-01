<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $fillable = ['sekolah_id', 'kode_rombel', 'nama_rombel', 'tingkat', 'guru_id', 'periode_id','status'];

    public function sekolahs()
    {
        return $this->belongsTo('App\Sekolah', 'sekolah_id', 'npsn');
    }

    public function gurus()
    {
        return $this->belongsTo('App\User', 'guru_id', 'nip');
    }
}
