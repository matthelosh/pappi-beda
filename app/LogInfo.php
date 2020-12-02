<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogInfo extends Model
{
    protected $fillable = ['log_id','sekolah_id','user_id','client_ip', 'client_os', 'logout_time'];

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'nip');
    }
}
