<?php

use Illuminate\Database\Seeder;
use App\Sekolah;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sekolah::create([
            'npsn' => '20518848',
            'nama_sekolah' => 'SD Negeri 1 Bedalisodo',
            'alamat' => 'Jl. Raya Sengon No. 293',
            'desa' => 'Dalisodo',
            'kec' => 'Wagir',
            'kab' => 'Malang',
            'prov' => 'Jawa Timur',
            'kode_pos' => '65158',
            'telp' => '-',
            'email' => 'sdn.bedali01@gmail.com',
            'website' => 'https://sdn1-bedalisodo.sch.id',
            'operator_id' => '201903',
            'ks_id' => '196107031992011007'
        ]);
    }
}
