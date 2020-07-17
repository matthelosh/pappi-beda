<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nip' => '196205191982011006',
            'username' => 'pakendro',
            'nama' => 'Endro Saptomintono, S. Pd.',
            'password' => Hash::make('12345'),
            'email' => 'endro@sdn1-bedalisodo.sch.id',
            'jk' => 'l',
            'hp' => '628585858585',
            'alamat' => 'SD Negeri 1 Bedalisodo',
            'level' => 'guru',
            'role' => 'wali'
        ]);
    }
}
