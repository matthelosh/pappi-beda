<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kd extends Model
{
    protected $fillable = [
        'kode_kd', 'teks_kd', 'mapel_id', 'tingkat'
    ];

    public function mapels()
    {
        return $this->belongsTo('App\Mapel', 'mapel_id', 'kode_mapel');
    }
}
