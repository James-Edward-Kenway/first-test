<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $fillable = ['id','name','image64','order','image128'];
}
