<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $fillable = ['title', 'description', 'images', 'address', 'discount'];
    //
}
