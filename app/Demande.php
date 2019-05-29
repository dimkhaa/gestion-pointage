<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model

{
    protected $fillable = [
        'id', 'user_id', 'dateDebut', 'dateFin', 'statut','typeDemande', 'motif'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
