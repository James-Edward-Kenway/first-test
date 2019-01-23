<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $fillable = ['id','service_category_id','brand_id','user_id','title','description','image','price'];
    //
}
