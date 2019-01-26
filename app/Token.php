<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $fillable = ['id','token','description','user_id'];
    
    public function user(){
        return $this->hasOne('App\User','id','user_id');
    }
}
