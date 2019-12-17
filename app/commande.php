<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    public  function livraison(){
        return $this->hasMany('App\Livraison');
    }
    public function  commandeModele(){
        return $this->hasMany('App\commandeModele');
    }
    public function  modeleFournisseur(){
        return $this->hasMany('App\modeleFournisseur');
    }

}
