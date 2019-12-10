<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{       
    protected $table = 'flights';   
    protected $primaryKey = 'number';

    public function airlines() {
        return $this->belongsTo('App\Airline','airline');
    }
    public function airport_depart() {
        return $this->hasMany('App\Airport','code','departure_airport');
    }
    public function airport_arrive() {
        return $this->hasMany('App\Airport','code','arrival_airport');
    }
}
