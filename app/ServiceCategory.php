<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    public $fillable = ['id','name','order','image64','image128','parent_id'];

    public function children(){
        return $this->hasMany('App\ServiceCategory', 'parent_id', 'id');
    }

    public function services(){
        return $this->hasMany('App\Service', 'service_category_id', 'id');
    }
    public function attributesGroups(){
        return $this->belongsToMany('App\AttributeCategory', 'attribute_categories_services_categories', 'service_category_id', 'attribute_category_id');
    }
}
