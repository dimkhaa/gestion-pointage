<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nom','prenom','nom', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function pointages(){
        return $this->hasMany('App\Pointage');
    }

    public function horaire(){
        return $this->belongsTo('App\Horaire');
    }

    public function demandes(){
        return $this->hasMany('App\Demande');
    }
    public function service(){
        return $this->belongsTo('App\Service');
    }
}
