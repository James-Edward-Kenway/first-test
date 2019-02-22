<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $fillable = ['id','name','description','address','phone','images'];

    public function roles(){
        return $this->hasMany('App\RolesOfStores','store_id','id');
    }
    
    public function getImages(){
        $imgs = json_decode($this->images);
        $arrs = [];
        foreach($imgs as $img){
            $arrs[] = new Image(['name'=>$img]);
        }
        return $arrs;
    }
}
