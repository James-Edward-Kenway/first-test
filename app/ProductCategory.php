<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    
    public $fillable = ['id','name','image64','image128','order','parent_id'];
    
    public function children(){
        return $this->hasMany('App\ProductCategory', 'parent_id', 'id');
    }
}
