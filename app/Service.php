<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $fillable = ['id','service_category_id','brand_id','user_id','title','description','image','price'];
    
    protected $hidden = ['attribute_category_id','service_category_id'];

    public function attributes(){
        return $this->belongsToMany('App\Attribute', 'attribute_service', 'service_id', 'attribute_id');
    }
}
