<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prosem extends Model
{
    protected $fillable = ['semester', 'mapel_id', 'tingkat', 'kd_id', 'ket'];

    public function mapels()
    {
        return $this->belongsTo('App\Mapel', 'mapel_id', 'kode_mapel');
    }

    public function kds()
    {
        return $this->belongsTo('App\Kd', 'kd_id', 'kode_kd');
    }
}
