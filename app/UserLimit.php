<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLimit extends Model
{
    public $fillable = ['user_id', 'type', 'count','till'];
    
    public function user(){
        return $this->belongsTo('\App\User','user_id','id');
    }
}
