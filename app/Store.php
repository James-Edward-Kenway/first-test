<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use UseImage;
    public $fillable = ['id','name','description','address','phone','images'];

    public function roles(){
        return $this->hasMany('App\RolesOfStores','store_id','id');
    }
    
}
