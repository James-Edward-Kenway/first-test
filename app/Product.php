<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use UseImage;
    public $fillable = ['id','product_category_id','brand_id','user_id','store_id','like_count','title','description','images','price'];

    protected $hidden = ['attribute_category_id','product_category_id'];
    
    public function attributes(){
        return $this->belongsToMany('App\Attribute', 'attribute_product', 'product_id', 'attribute_id');
    }
    public function delete(){
        \DB::table('attribute_product')->where('product_id',$this->id)->delete();
        \DB::table('product_likes')->where('product_id',$this->id)->delete();
        \DB::table('product_wishlist')->where('product_id',$this->id)->delete();
        $this->removeAllImages();
        return parent::delete();
    }

    
}
