<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $fillable = ['attribute_category_id','id', 'title'];
    
}
