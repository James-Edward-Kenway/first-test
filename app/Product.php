<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['id','product_category_id','brand_id','user_id','title','description','image','price'];

    public function attributes(){
        return $this->belongsToMany('App\Attribute', 'attribute_product', 'product_id', 'attribute_id');
    }
    
}
