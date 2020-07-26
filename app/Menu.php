<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'url', 'parent_id', 'role','icon'];

    public function childs()
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id');
    }
}
