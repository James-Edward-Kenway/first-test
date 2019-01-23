<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeCategory extends Model
{
    public $fillable = ['order','id', 'name'];
    
    public function children(){
        return $this->hasMany('App\Attribute', 'attribute_category_id', 'id');
    }
}
