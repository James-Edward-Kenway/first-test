<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $fillable = ['id','name','description','address','phone'];

    public function roles(){
        return $this->hasMany('App\RolesOfStores','store_id','id');
    }
}
