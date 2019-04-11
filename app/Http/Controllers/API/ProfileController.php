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
use App\Exceptions\InvalidPermissionException;
use App\Tarif;
use App\User;
use App\RolesOfStores;
use App\TarifLogs;

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

        $res = ['authorized'=>true, 'token'=>$token->toArray(), 'user'=>\Auth::user()->toArray()];

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
    public function getUserTarifs(Request $req){
        
        return ['success'=>true,'data'=>\App\Tarif::where('is_user',1)->get()];
    }
    public function buyUserTarif(Request $req){
        if(!$req->has('tarif_id')){
            return ['success'=>false,'info'=>'tarif id yo\'q'];
        }

        $tarif = Tarif::where('id',$req->get('tarif_id'))->first();

        if(!$tarif->is_user){
            return ['success'=>false,'info'=>'tarif user uchun mo\'ljallanmagan!'];
        }
        if(\Auth::user()->balance<=$tarif->price){
            return ['success'=>false,'info'=>'userda mablag\' yo\'q'];
        }

        $u = \Auth::user();
        $tarif->apply(true,\Auth::user()->id);

        
        $u->balance-=$tarif->price;
        $u->save();

        $lg = new TarifLogs();
        $lg->owner_id = $u->id;
        $lg->tarif_id = $tarif->id;
        $lg->is_user = true;
        $lg->save();


        return ['success'=>true];
    }

    // for stores
    public function getTarifs(Request $req){
        
        return ['success'=>true,'data'=>\App\Tarif::where('is_user',0)->get()];
    }

    public function buyTarif(Request $req){
        if(!$req->has('tarif_id')||!$req->has('store_id')){
            return ['success'=>false,'info'=>'tarif id yoki store_id yo\'q'];
        }

        $tarif = Tarif::where('id',$req->get('tarif_id'))->first();

        if($tarif->is_user){
            return ['success'=>false,'info'=>'tarif user uchun mo\'ljallangan!'];
        }
        if(\Auth::user()->balance<=$tarif->price){
            return ['success'=>false,'info'=>'userda mablag\' yo\'q'];
        }

        $u = \Auth::user();
        $tarif->apply(false,$req->get('store_id'));
        
        $u->balance-=$tarif->price;
        $u->save();

        $lg = new TarifLogs();
        $lg->owner_id = $req->get('store_id');
        $lg->tarif_id = $tarif->id;
        $lg->is_user = false;
        $lg->save();
        
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
            'login' => 'min:6',
            'new_password' => 'min:6',
            'new_password_confirmation' => 'same:new_password',
        ]);

        if($validate->fails()){
            return ['messages'=>(array)$validate->errors()->all(),'success'=>false];
        }

        $user = \Auth::user();

        if($request->hasFile('photo')){

            $path = "/images/user/".$user->id."/";
            $photo = md5('jpg'.microtime().rand(0,1000)).".jpg";
            $pub = public_path($path);

            if(!file_exists($pub)){
                mkdir($pub);
            }
            
            
            $request->file('photo')->storeAs($path, $photo, 'public_html');

            $user->addImage(Image::path($path.$photo));
        }
        
        
        if($request->has('login')){
            $u = User::where('login',$request->input('login'))->first();
            if($u==null){
                $user->login = $request->input('login');
            }else{
                return ['messages'=>['already used login!'],'success'=>false];
            }
        }
        if($request->has('old_password')){
            if(password_verify($request->input('old_password').'as@',$user->password)){
                $user->password = \password_hash($request->input('new_password').'as@',PASSWORD_BCRYPT);
            }else{
                return ['messages'=>['old password not correct!'],'success'=>false];
            }
        }
        $user->name = $request->input('name');
        $user->save();

        return ['success'=>true,$user->toArray()];
    }
    


    public function listOfUsers(Request $request){
        
        
        if(\Auth::user()->canManipulate($request->input('store_id'), StoreController::UPDATE_ROLES)){


            $users = User::whereHas('roles',function($q)use($request){
                $q->where('store_id', $request->get('store_id'));
            })->get();

            return ['success'=>true,'users'=>$users->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function changeRoles(Request $request){
        
        
        if(\Auth::user()->canManipulate($request->input('store_id'), StoreController::UPDATE_ROLES)){


            $user = User::where('id', $request->get('user_id'))->first();

            RolesOfStores::where('store_id',$request->input('store_id'))->where('user_id',$request->input('user_id'))->delete();

            foreach($request->input('roles') as $role){
                $ro = new RolesOfStores();
                $ro->user_id  = $user->id;
                $ro->store_id = $request->input('store_id');
                $ro->role     = 1 * $role;
                $ro->save();
            }

            
            $users = User::whereHas('roles',function($q)use($request){
                $q->where('store_id', $request->get('store_id'));
            })->get();

            return ['success'=>true,'users'=>$users->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function addUserRole(Request $request){
        
        
        if(\Auth::user()->canManipulate($request->input('store_id'), StoreController::UPDATE_ROLES)){
            
            $user = User::where('email',$request->get('user_email'))->first();

            RolesOfStores::where('store_id',$request->input('store_id'))->where('user_id',$user->id)->delete();

            foreach($request->input('roles') as $role){
                $ro = new RolesOfStores();
                $ro->user_id  = $user->id;
                $ro->store_id = $request->input('store_id');
                $ro->role     = 1 * $role;
                $ro->save();
            }

            $users = User::whereHas('roles',function($q)use($request){
                $q->where('store_id', $request->get('store_id'));
            })->get();

            return ['success'=>true,'users'=>$users->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function getPaymentLogs(Request $request){
        
        $logs = \Auth::user()->paymentLogs()->paginate(50);
        return $logs->toArray();
    }
    public function getUserTarifLogs(Request $request){
        
        $logs = TarifLogs::where('is_user',1)->where('owner_id',\Auth::user()->id)->with('tarif')->paginate(50);
        return $logs->toArray();
    }
    public function getStoreTarifLogs(Request $request){
        
        $logs = TarifLogs::where('is_user',0)->where('owner_id',$request->input('store_id',0))->with('tarif')->paginate(50);
        return $logs->toArray();
    }
    public function getLimits(Request $request){
        
        $logs = \Auth::user()->limits;
        return $logs->toArray();
    }
    public function paymeLink(Request $request){
        
        $sum = $request->get('sum',0);
        if($sum<1000){
            return ['success'=>false,'info'=>'minimal summa 1000 so"m'];
        }
        return ['success'=>true,'link'=>'https://merchant.paycom.uz/aaaaaaaaaaa'];

    }

}
