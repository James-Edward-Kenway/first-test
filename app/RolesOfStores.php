<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesOfStores extends Model
{
    public $fillable = ['id','user_id','store_id','role'];
    
    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function stores(){
        return $this->belongsTo('App\Store','store_id','id');
    }
}
