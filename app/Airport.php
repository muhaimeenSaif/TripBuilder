<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $table = 'airports';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    //
    public function flights(){
        return $this->belongsToMany('App\Flight');
    }
}
