<?php

use Illuminate\Database\Seeder;
use App\Menu;
use Illuminate\Support\Facades\DB;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'title' => 'Menu',
                'url' => '/preferences/menu',
                'icon' => 'cil-list-rich',
                'parent_id' => 3,
                'role' => 'admin'
            ]
        ];

        foreach($menus as $menu) {
            DB::table('menus')->insert($menu);
        }
    }
}
