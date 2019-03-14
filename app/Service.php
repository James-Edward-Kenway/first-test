<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use UseImage;
    public $fillable = ['id','service_category_id','phone','address','brand_id','user_id','title','description','images','price','like_count','store_id'];
    
    protected $hidden = ['attribute_category_id','service_category_id'];

    protected $appends = [
        'liked',
        'wished',
    ];
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
    public function getLikedAttribute(){
        if(\Auth::check()){
            return !is_null(\DB::table('service_likes')->where('service_id',$this->id)->where('user_id', \Auth::user()->id)->first());
        }
        return false;
    }

    public function getWishedAttribute(){
        if(\Auth::check()){
            return !is_null(\DB::table('service_wishlist')->where('service_id',$this->id)->where('user_id', \Auth::user()->id)->first());
        }
        return false;
    }

}
