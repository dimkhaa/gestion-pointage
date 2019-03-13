<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = [
        'id','motif'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
