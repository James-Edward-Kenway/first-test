<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use UseImage;
    public $fillable = ['title', 'description', 'images', 'address','store_id'];
    //
    public function delete(){
        $this->removeAllImages();
        parent::delete();
    }
}
