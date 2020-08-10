<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemetaan extends Model
{
    protected $fillable = [
        'semester',
        'mapel_id', 
        'tema_id', 
        'subtema_id',
        'kd_id',
        'tingkat',
        'kata_kunci'
    ];

    public function mapels ()
    {
        return $this->belongsTo('App\Mapel', 'mapel_id', 'kode_mapel');
    }

    public function temas()
    {
        return $this->belongsTo('App\Tema', 'tema_id', 'kode_tema');

    }

    public function subtemas()
    {
        return $this->belongsTo('App\Subtema', 'subtema_id', 'kode_subtema');
    }

    public function kds()
    {
        return $this->belongsTo('App\Kd', 'kd_id', 'kode_dk');
    }
}
