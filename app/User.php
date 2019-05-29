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
<<<<<<< HEAD
        'id','nom','prenom','nom', 'email', 'password',
=======
        'id','email', 'password', 'nom', 'prenom',
>>>>>>> 6c4a08a1b8a4aa93faa2c3e3cd2dd3cd0d9b81da
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
<<<<<<< HEAD

=======
>>>>>>> 6c4a08a1b8a4aa93faa2c3e3cd2dd3cd0d9b81da
    public function demandes(){
        return $this->hasMany('App\Demande');
    }
    public function service(){
        return $this->belongsTo('App\Service');
    }
}
