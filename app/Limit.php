<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    public $fillable = ['store_id', 'type', 'count','till'];
    
    public function store(){
        return $this->belongsTo('\App\Store','store_id','id');
    }
}
