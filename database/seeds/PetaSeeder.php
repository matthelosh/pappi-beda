<?php

use Illuminate\Database\Seeder;
use App\Pemetaan;

class PetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subtemas = 'App\Subtema'::all();
        $mapelsk = 'App\Mapel'::where('tingkat','!=', 'besar')->whereNotIn('kode_mapel',['pabp', 'big', 'bd'])->get();
        $mapelsb = 'App\Mapel'::whereNotIn('kode_mapel',['pabp', 'big', 'bd', 'mtk','pjok'])->get();
        
        foreach($subtemas as $subtema)
        {
            $tema = explode("-",$subtema->tema_id);
            if($subtema->tingkat > 3 && (Int)$tema[1] < 6) {
                $semester = '1';
            } elseif($subtema->tingkat < 4 && (Int)$tema[1] < 5) {
                $semester = '1';
            } else {
                $semester = '2';
            }
            foreach (((Int)$subtema->tingkat > 3) ? $mapelsb : $mapelsk as $mapel) {
                Pemetaan::create([
                    'semester' => $semester ,
                    'mapel_id' => $mapel->kode_mapel, 
                    'tema_id' => $subtema->tema_id, 
                    'subtema_id' => $subtema->kode_subtema,
                    'kd_id' => '0',
                    'tingkat' => $subtema->tingkat,
                    'kata_kunci' => '0'
                ]);
            }
        }
        // dd($subtemas);
    }
}
