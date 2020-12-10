<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nip', 'nama', 'username', 'email', 'password', 'default_password', 'jk', 'hp', 'alamat', 'level', 'role', 'sekolah_id','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sekolahs()
    {
        return $this->belongsTo('App\Sekolah', 'sekolah_id', 'npsn');
    }

    public function logs()
    {
        return $this->hasMany('App\LogInfo', 'user_id', 'nip');
    }
}
