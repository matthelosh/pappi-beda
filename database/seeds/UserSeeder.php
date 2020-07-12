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
            'nip' => '001',
            'username' => 'admin',
            'nama' => 'Administrator',
            'password' => Hash::make('qwerty'),
            'email' => 'admin@sdn1-bedalisodo.sch.id',
            'jk' => 'l',
            'hp' => '6285850758384',
            'alamat' => 'SD Negeri 1 Bedalisodo',
            'level' => 'admin',
            'role' => 'admin'
        ]);
    }
}
