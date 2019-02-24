<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use UseImage;
    public $fillable = ['title', 'description', 'images', 'address', 'discount','store_id'];

    public function delete(){
        $this->removeAllImages();
        parent::delete();
    }
}
