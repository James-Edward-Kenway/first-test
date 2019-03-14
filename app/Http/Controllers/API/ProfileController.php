<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Token;
use App\Exceptions\UnauthorizedException;
use App\Image;
use App\Product;
use App\Service;
use App\Store;

class ProfileController extends Controller
{

    public function token(Request $req){
        
        $token = \Auth::user()->currentToken;
        
        if($token==null){
            return ['authorized'=>false];
        }

        $token->token = bcrypt(microtime().'i'.random_int(0,100000));
        $token->save();
        $res = [];

        $res = ['authorized'=>true, 'token'=>$token->toArray()];

        return $res;
    }


    public function wishlistProducts(Request $req){
        $products = \Auth::user()->wishlistProducts()->paginate(50);
        return $products;
    }
    public function wishlistServices(Request $req){
        $services = \Auth::user()->wishlistServices()->paginate(50);
        return $services;
    }

    public function subscribe(Request $req){
        if(!$req->has('store_id')){
            return ['success'=>false];
        }

        \Auth::user()->subscriptions()->attach(Store::find($req->get('store_id')));
        return ['success'=>true];
    }
    public function unsubscribe(Request $req){
        if(!$req->has('store_id')){
            return ['success'=>false];
        }

        \Auth::user()->subscriptions()->detach(Store::find($req->get('store_id')));
        return ['success'=>true];
    }

    public function addToWishlistProduct(Request $req){
        if(!$req->has('product_id')){
            return ['success'=>false];
        }

        \Auth::user()->wishlistProducts()->attach(Product::find($req->get('product_id')));
        return ['success'=>true];
    }


    public function addToWishlistService(Request $req){
        if(!$req->has('service_id')){
            return ['success'=>false];
        }

        \Auth::user()->wishlistServices()->attach(Service::find($req->get('service_id')));
        return ['success'=>true];
    }
    public function deleteWishlistProduct(Request $req){
        if(!$req->has('product_id')){
            return ['success'=>false];
        }

        \Auth::user()->wishlistProducts()->detach(Product::find($req->get('product_id')));
        return ['success'=>true];
    }
    public function deleteWishlistService(Request $req){
        if(!$req->has('service_id')){
            return ['success'=>false];
        }

        \Auth::user()->wishlistServices()->detach(Service::find($req->get('service_id')));
        return ['success'=>true];
    }

    
    public function productLikes(Request $req){
        $products = \Auth::user()->productLikes()->paginate(50);
        return $products;
    }
    public function serviceLikes(Request $req){
        $services = \Auth::user()->serviceLikes()->paginate(50);
        return $services;
    }

    public function addToServiceLikes(Request $req){
        if(!$req->has('service_id')){
            return ['success'=>false];
        }

        $ser = Service::find($req->get('service_id'));
        $ser->like_count++;
        $ser->save();

        \Auth::user()->serviceLikes()->attach($ser);
        return ['success'=>true];
    }

    public function addToProductLikes(Request $req){
        if(!$req->has('product_id')){
            return ['success'=>false];
        }
        $pro = Product::find($req->get('product_id'));
        $pro->like_count++;
        $pro->save();

        \Auth::user()->productLikes()->attach($pro);
        return ['success'=>true];
    }

    public function deleteProductLikes(Request $req){
        if(!$req->has('product_id')){
            return ['success'=>false];
        }
        $pro = Product::find($req->get('product_id'));
        $pro->like_count--;
        $pro->save();

        \Auth::user()->productLikes()->detach($pro);
        return ['success'=>true];
    }
    
    public function deleteServiceLikes(Request $req){
        if(!$req->has('service_id')){
            return ['success'=>false];
        }

        $ser = Service::find($req->get('service_id'));
        $ser->like_count--;
        $ser->save();

        \Auth::user()->serviceLikes()->detach($ser);
        return ['success'=>true];
    }
    public function logout(Request $req){
        \Auth::user()->currentToken->delete();
        return ['success'=>true];
    }
    public function editUser(Request $request){

        //validation
        $validate = validator($request->all(), [
            'name' => 'required|max:255',
            'photo' => 'mimes:jpeg,png',
            'old_password' => 'min:6',
            'new_password' => 'min:6',
            'new_password_confirmation' => 'same:new_password',
        ]);

        if($validate->fails()){
            return ['messages'=>$validate->errors()->all(),'success'=>false];
        }


        if($request->hasFile('photo')){

            $path = "/images/user/".\Auth::user()->id."/";
            $photo = md5('jpg'.microtime().rand(0,1000)).".jpg";
            $pub = public_path($path);

            if(!file_exists($pub)){
                mkdir($pub);
            }
            
            $request->file('photo')->storeAs($path, $photo, 'public_html');

            \Auth::user()->addImage(Image::path($path.$photo));
        }
        
        if($request->has('old_password')){
            if(password_verify($request->input('old_password'),\Auth::user()->password)){
                \Auth::user()->password = \password_hash($request->input('password').'as@',PASSWORD_BCRYPT);
            }else{
                return ['messages'=>['old_password'=>'old password not correct!'],'success'=>false];
            }
        }
        \Auth::user()->update(['name'=>$request->input('name')]);

        return ['success'=>true,\Auth::user()->toArray()];
    }
    


}
