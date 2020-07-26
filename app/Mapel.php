<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'tingkat',
        'label'
    ];

    public function kds()
    {
        return $this->hasMany('App\Kd', 'mapel_id', 'kode_mapel');
    }
}
