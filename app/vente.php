<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vente extends Model
{
    public function  prevente(){
        return $this->hasMany('App\Prevente');
    }
    public function caisse(){
        return $this->belongsTo('App\Caisse');
    }
    public function client(){
        return $this->belongsTo('App\Client');
    }
}
