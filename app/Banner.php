<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $fillable = ['id','name','image','store_id','product_id','service_id','url','till'];
    //
}
