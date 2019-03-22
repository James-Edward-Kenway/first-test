<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use UseImage;
    public $fillable = ['id','name','description','address','phone','images'];

    protected $appends = [
        'subscribed',
    ];
    public function roles(){
        return $this->hasMany('App\RolesOfStores','store_id','id');
    }

    public function delete(){

        \DB::table('roles_of_stores')->where('store_id',$this->id)->delete();
        \DB::table('store_subscription')->where('store_id',$this->id)->delete();

        foreach(Product::where('store_id',$this->id)->get() as $pro){
            $pro->delete();
        }
        foreach(Service::where('store_id',$this->id)->get() as $pro){
            $pro->delete();
        }
        
        foreach(Action::where('store_id',$this->id)->get() as $pro){
            $pro->delete();
        }
        foreach(Discount::where('store_id',$this->id)->get() as $pro){
            $pro->delete();
        }
        
        

        $this->removeAllImages();
        
        $path = "/images/store/".$this->id."/";
        try{
            rmdir(public_path($path));
        }catch(\Exception $e){}
        
        return parent::delete();
    }
    public function getSubscribedAttribute(){
        if(\Auth::check()){
            return !is_null(\DB::table('store_subscription')->where('store_id',$this->id)->where('user_id', \Auth::user()->id)->first());
        }
        return false;
    }
    
    public function limitCheck($limit){
        $res = false;
        $limit = $this->limits()->where('type',$limit)->where('till','>',date('Y-m-d H:i:s'))->first();
        if($limit!=null&&$limit->count!=0){
            if($limit->count>0){
                $limit->count--;
                $limit->save();
            }
            $res = true;
        }
        return $res;
    }
    
    public function limits(){
        return $this->hasMany('App\Limit','store_id','id');
    }
    
}
