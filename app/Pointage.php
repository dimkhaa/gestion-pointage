<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    protected $fillable = [
        'id','date','type','user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
