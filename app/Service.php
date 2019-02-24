<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use UseImage;
    public $fillable = ['id','service_category_id','brand_id','user_id','title','description','image','price'];
    
    protected $hidden = ['attribute_category_id','service_category_id'];

    public function attributes(){
        return $this->belongsToMany('App\Attribute', 'attribute_service', 'service_id', 'attribute_id');
    }
    public function delete(){
        \DB::table('attribute_service')->where('service_id',$this->id)->delete();
        \DB::table('service_likes')->where('service_id',$this->id)->delete();
        \DB::table('service_wishlist')->where('service_id',$this->id)->delete();
        $this->removeAllImages();
        return parent::delete();
    }
}
