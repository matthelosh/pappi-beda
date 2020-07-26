<?php
namespace App\Traits;

// use Illuminate\Http\Request;
use App\Menu;

trait MenuTrait
{
    public function showMenus($request)
    {
        // $menuAdmin = Menu::where('role', '!=', 'guru')->where('parent_id',0)->with('childs')->get();
        // $menuGuru = Menu::where('role', '!=', 'admin')->where('parent_id',0)->with('childs')->get();

        // dd($request->user());
        if($request->user()->level == 'admin') {
            $menus = Menu::where('role', '<>', 'wali')->where('parent_id', 0)->with('childs')->get();
        } else {
            if($request->user()->role == 'wali') {
                $menus = Menu::where('role', '<>', 'admin')->where('parent_id', 0)->with('childs')->get();
                // $menus = Menu::where('role', '<>', 'admin')->where('role', 'LIKE', '%'.$request->user()->role)->where('parent_id', 0)->with('childs')->get();
            } else {
                $menus = Menu::where('role', '<>', 'admin')->where('parent_id', 0)->with('childs')->get();
                // $menus = Menu::where('role', '<>', 'admin')->where('role', 'LIKE', '%'.$request->session()->get('role').'%')->where('parent_id', 0)->with('childs')->get();
            }
        }

        // dd($menus);
        return $menus;
    }
}