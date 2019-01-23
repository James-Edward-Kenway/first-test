<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    public $fillable = ['id','name','image64','image128','parent_id'];
}
