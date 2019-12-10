<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    protected $table = 'airlines';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    //
    public function flights(){
        return $this->hasMany('App\Flight');
    }
}
