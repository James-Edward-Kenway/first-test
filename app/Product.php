<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use UseImage;

    public $fillable = ['id','product_category_id','brand_id','user_id','store_id','like_count','title','description','images','price'];

    protected $hidden = ['attribute_category_id','product_category_id'];

    protected $appends = [
        'liked',
        'wished',
    ];
    
    public function attributes(){
        return $this->belongsToMany('App\Attribute', 'attribute_product', 'product_id', 'attribute_id');
    }
    public function store(){
        return $this->hasOne('App\Store');
    }
    public function delete(){
        \DB::table('attribute_product')->where('product_id',$this->id)->delete();
        \DB::table('product_likes')->where('product_id',$this->id)->delete();
        \DB::table('product_wishlist')->where('product_id',$this->id)->delete();
        $this->removeAllImages();
        return parent::delete();
    }

    public function getLikedAttribute(){
        if(\Auth::check()){
            return !is_null(\DB::table('product_likes')->where('product_id',$this->id)->where('user_id', \Auth::user()->id)->first());
        }
        return false;
    }

    public function getWishedAttribute(){
        if(\Auth::check()){
            return !is_null(\DB::table('product_wishlist')->where('product_id',$this->id)->where('user_id', \Auth::user()->id)->first());
        }
        return false;
    }

    
}
