<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    protected $fillable = [
        'sekolah_id',
        'kode_ekskul',
        'nama_ekskul',
        'pembina'
    ];
}
