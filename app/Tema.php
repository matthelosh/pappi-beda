<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $fillable = [
        'tingkat',
        'kode_Tema',
        'teks_tema'
    ];

    public function mapels()
    {
        return $this->belongsTo('App\Mapel', 'mapel_id', 'kode_mapel');
    }

    public function subtemas()
    {
        return $this->hasMany('App\Subtema', 'tema_id', 'kode_tema');
    }
}
