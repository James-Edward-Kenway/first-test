<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Token;

class ProfileController extends UserController
{
    public function __construct(Request $req)
    {
        parent::__construct($req);
        if(!$this->authenticated){
            throw new UnauthorizedException();
        }
    }

    public function token(Request $req){
        
        $token = Token::where('user_id',$this->user_id)->where('token', $this->token)->first();
        
        if($token==null){
            return ['authorized'=>false];
        }

        $token->token = bcrypt(microtime().'i'.random_int(0,100000));
        $token->save();
        $res = [];

        $res = ['authorized'=>true, 'token'=>$token->toArray()];

        return $res;
    }

    public function wishlistProductIds(Request $req){
        DB::table('product_wishlist')->where('user_id', $this->user->id)->get('product_id');
    }
    public function wishlistServiceIds(Request $req){
        DB::table('service_wishlist')->where('user_id', $this->user->id)->get('service_id');
    }

    public function wishlistProducts(Request $req){
        $products = $this->user->wishlistProducts()->paginate(50);
        return $products;
    }
    public function wishlistServices(Request $req){
        $services = $this->user->wishlistServices()->paginate(50);
        return $services;
    }

    public function addToWishlistProduct(Request $req){
        if(!$req->has('product_id')){
            return ['success'=>false];
        }

        $this->user->wishlistProducts()->attach(Product::find($req->get('product_id')));
        return ['success'=>true];
    }


    public function addToWishlistService(Request $req){
        if(!$req->has('service_id')){
            return ['success'=>false];
        }

        $this->user->wishlistServices()->attach(Service::find($req->get('service_id')));
        return ['success'=>true];
    }
    public function deleteWishlistProduct(Request $req){
        if(!$req->has('product_id')){
            return ['success'=>false];
        }

        $this->user->wishlistProducts()->detach(Product::find($req->get('product_id')));
        return ['success'=>true];
    }
    public function deleteWishlistService(Request $req){
        if(!$req->has('service_id')){
            return ['success'=>false];
        }

        $this->user->wishlistServices()->detach(Service::find($req->get('service_id')));
        return ['success'=>true];
    }

    public function productLikesIds(Request $req){
        $products = $this->user->productLikes()->get('product_id');
        return $products;
    }
    public function serviceLikesIds(Request $req){
        $services = $this->user->serviceLikes()->get('service_id');
        return $services;
    }
    
    public function productLikes(Request $req){
        $products = $this->user->productLikes()->paginate(50);
        return $products;
    }
    public function serviceLikes(Request $req){
        $services = $this->user->serviceLikes()->paginate(50);
        return $services;
    }

    public function addToServiceLikes(Request $req){
        if(!$req->has('service_id')){
            return ['success'=>false];
        }

        $ser = Service::find($req->get('service_id'));
        $ser->like_count++;
        $ser->save();

        $this->user->serviceLikes()->attach($ser);
        return ['success'=>true];
    }

    public function addToProductLikes(Request $req){
        if(!$req->has('product_id')){
            return ['success'=>false];
        }
        $pro = Product::find($req->get('product_id'));
        $pro->like_count++;
        $pro->save();

        $this->user->productLikes()->attach($pro);
        return ['success'=>true];
    }

    public function deleteProductLikes(Request $req){
        if(!$req->has('product_id')){
            return ['success'=>false];
        }
        $pro = Product::find($req->get('product_id'));
        $pro->like_count--;
        $pro->save();

        $this->user->productLikes()->detach($pro);
        return ['success'=>true];
    }
    
    public function deleteServiceLikes(Request $req){
        if(!$req->has('service_id')){
            return ['success'=>false];
        }

        $ser = Service::find($req->get('service_id'));
        $ser->like_count--;
        $ser->save();

        $this->user->serviceLikes()->detach($ser);
        return ['success'=>true];
    }


}
