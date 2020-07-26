<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = [
        'kode_periode',
        'tapel',
        'semester',
        'label',
        'status'
    ];
}
