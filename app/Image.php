<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $fillable = ['name','id','model'];

    public function url(){
        $url = url($this->name);
        return $url;
    }

    public function filePath(){
        $path = public_path($this->name);
        return $path;
    }
}
