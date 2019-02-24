<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $fillable = ['relative'];

    public function url(){
        $url = url($this->name);
        return $url;
    }

    public function filePath(){
        $path = public_path($this->name);
        return $path;
    }
    public static function path($str){
        return new Image(['relative'=>$str]);
    }
}
