<?php
namespace App\Traits;

// use Illuminate\Http\Request;
use App\Nilai1;
use App\Nilai2;
use App\Nilai3;
use App\Nilai4;

trait NilaiTrait
{
    public function rekap($request)
    {
        $nilai3 = Nilai3::all();
        return  $nilai3;
    }
    
}