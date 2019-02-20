<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    
    public $fillable = ['id','name','image64','image128','order','parent_id'];
    
    public function children(){
        return $this->hasMany('App\ProductCategory', 'parent_id', 'id');
    }

    public function products(){
        return $this->hasMany('App\Product', 'product_category_id', 'id');
    }

    public function attributesGroups(){
        return $this->belongsToMany('App\AttributeCategory', 'attribute_categories_product_categories', 'product_category_id', 'attribute_category_id');
    }
}
