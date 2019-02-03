<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }
    public function entreprise(){
        return $this->belongsTo('App\Entreprise');
    }
}
