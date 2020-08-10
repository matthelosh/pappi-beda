<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtema extends Model
{
    protected $dillable = [
        'tingkat',
        'tema_id',
        'kode_subtema',
        'teks_subtema'
    ];

    public function mapels()
    {
        return $this->belongsTo('App\Mapel', 'mapel_id', 'kode_mapel');
    }

    public function temas()
    {
        return $this->belongsTo('App\Tema', 'tema_id', 'kode_tema');
    }
}
