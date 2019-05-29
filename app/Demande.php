<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model

{
<<<<<<< HEAD
    protected $fillable = [
        'id','motif'
=======

    protected $fillable = [
        'id', 'user_id', 'dateDebut', 'dateFin', 'statut','typeDemande', 'motif'
>>>>>>> 6c4a08a1b8a4aa93faa2c3e3cd2dd3cd0d9b81da
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
