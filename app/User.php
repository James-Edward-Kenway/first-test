<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Requests\Request;

class User extends Authenticatable
{
    use Notifiable, UseImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','balance','images'
    ];
    public $currentToken;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tokens(){
        return $this->hasMany('App\Token','user_id','id');
    }

    public static function getByToken(){
        $token = Token::current();
        return Token::current()!=null?Token::current()->user()->first():null;
    }
    
    public function roles(){
        return $this->hasMany('App\RolesOfStores','user_id','id');
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
        return $this->hasMany('App\UserLimit','user_id','id');
    }
    
    public function paymentLogs(){
        return $this->hasMany('App\PaymentLog','user_id','id');
    }
    public function canManipulate($id,$role){
        $store = RolesOfStores::where('user_id',$this->id)->where('store_id',$id)->whereIn('role',[1,$role])->first();
        if($store!=null){
            return true;
        } 
        return false;
    }

    
    public function wishlistProducts(){
        return $this->belongsToMany('App\Product', 'product_wishlist','user_id', 'product_id');
    }

    public function wishlistServices(){
        return $this->belongsToMany('App\Service', 'service_wishlist','user_id', 'service_id');
    }

    public function productLikes(){
        return $this->belongsToMany('App\Product', 'product_likes','user_id', 'product_id');
    }

    public function serviceLikes(){
        return $this->belongsToMany('App\Service', 'service_likes','user_id', 'service_id');
    }

    public function subscriptions(){
        return $this->belongsToMany('App\Store', 'store_subscription','user_id', 'store_id');
    }
}
