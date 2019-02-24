<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Request;
use App\Store;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\InvalidPermissionException;
use App\Product;
use App\Service;
use App\Action;
use App\ProductCategory;
use App\ServiceCategory;
use App\Image;

class StoreController extends UserController
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        if(!$this->authenticated){
            
            throw new UnauthorizedException();
        }
    }
    const SUPERUSER = 1;
    const UPDATE_ROLES = 2;
    const STORE_DELETE = 3;
    const STORE_UPDATE = 4;
    const ADD_PRODUCT = 5;
    const ADD_SERVICE = 6;
    const DELETE_PRODUCT = 7;
    const DELETE_SERVICE = 8;
    const UPDATE_PRODUCT = 9;
    const UPDATE_SERVICE = 10;
    const ADD_ACTION = 11;
    const ADD_DISCOUNT = 12;
    const DELETE_ACTION = 13;
    const DELETE_DISCOUNT = 14;
    const UPDATE_ACTION = 15;
    const UPDATE_DISCOUNT = 16;

    public function addStore(Request $request){
        
        $validate = validator($request->all(),[
            'name' => 'required|max:128',
            'description' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'photo' => 'mimes:jpeg,png',
        ]);


        if($validate->fails()){
            return ['messages'=>$validate->errors()->all()]+['success'=>false];
        }

        $store = new Store(['name'=>$request->input('name'), 'description'=>$request->input('description'),
         'address'=>$request->input('address'), 'phone'=>$request->input('phone'), 'status' => 3]);

        $store->save();
        $roles = $store->roles()->create(['user_id'=>$this->user->id,'role'=>StoreController::SUPERUSER]);

        if($request->hasFile('photo')){

            $path = "/images/store/".$store->id."/";
            $photo = md5('jpg'.microtime().rand(0,1000)).".jpg";
            $pub = public_path($path);
            if(!file_exists($pub)){
                mkdir($pub);
            }
            $request->file('photo')->storeAs($path, $photo, 'public_html');

            $store->addImage(Image::path($path.$photo));
            $store->save();
        }
        return ['success'=>true, $store->toArray()];
        
    }

    public function getRoles(Request $req){
        $roles = \DB::table('roles_of_stores')->where('user_id', $this->user->id)->where('store_id', $req->get('store_id',0))->get();
        return $roles;
    }

    public function getStores(Request $req){
        $user = $this->user->id;
        $stores = Store::whereHas('roles',function($q) use($user){
            $q->where('user_id', $user);
        })->get();
        return $stores;
    }


    public function deteleStore(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }

        if($this->user->canManipulate($request->get('store_id'), StoreController::STORE_DELETE)){
            $store = Store::where('id',$request->get('store_id'))->first();
            if($store!=null){
                $store->delete();
            }
            return ['success'=>true];
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function updateStore(Request $request){

        $validate = validator($request->all(),[
            'store_id' => 'required',
            'name' => 'required|max:128',
            'description' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'photo' => 'mimes:jpeg,png',
        ]);

        if($validate->fails()){
            return ['messages'=>$validate->errors()->all()]+['success'=>false];
        }

        if($this->user->canManipulate($request->get('store_id'), StoreController::STORE_UPDATE)){

            $store = Store::where('id',$request->get('store_id'))->first();
            

            $store->update(['name'=>$request->get('name'),'phone'=>$request->get('phone'),'description'=>$request->get('description'),'address'=>$request->get('address')]);
            
            if($request->hasFile('photo')){

                $path = "/images/store/".$store->id."/";
                $photo = md5('jpg'.microtime().rand(0,1000)).".jpg";
                $pub = public_path($path);
                if(!file_exists($pub)){
                    mkdir($pub);
                }
                $request->file('photo')->storeAs($path, $photo, 'public_html');
                $store->removeAllImages();
                $store->addImage(Image::path($path.$photo));
                $store->save();
            }
            return ['success'=>true,$store->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }
    
    public function addProduct(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->input('store_id'), StoreController::ADD_PRODUCT)){

            $validate = validator($request->all(),[
                'name' => 'required|max:128',
                'description' => 'required',
                'brand_id' => 'required',
                'store_id' => 'required',
                'price'=> 'required',
                'photo.*' => 'mimes:jpeg,png',
            ]);
 
            if($validate->fails()){
                return ['messages'=>$validate->errors()->all()]+['success'=>false];
            }

            $product = new Product([
                'title' => $request->input('name'),
                'description' => $request->input('description'),
                'brand_id' => $request->input('brand_id'),
                'store_id' => $request->input('store_id'),
                'price'=> $request->input('price'),
                'user_id'=> $this->user->id,
            ]);
            
            $product->save();

            if($request->hasFile('photo')){

                $path = "/images/store/".$product->store_id."/product/".$product->id.'/';
                $pub = public_path($path);
                try{
                    if(!file_exists($pub)){
                        mkdir($pub);
                    }
                }catch(\Exception $e){}
                
                foreach($request->file('photo') as $file){

                    $photo = md5('jpg'.microtime().rand(0,1000)).".jpg";
                    $file->storeAs($path, $photo, 'public_html');
                    $product->addImage(Image::path($path.$photo));
                }

                $product->save();
            }

            return ['success'=>true, $product->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function addService(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::ADD_SERVICE)){

            $validate = validator($request->all(),[
                'name' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'price'=> 'required',
                'photo.*' => 'mimes:jpeg,png',
            ]);

            if($validate->fails()){
                return ['messages'=>$validate->errors()->all()]+['success'=>false];
            }

            $service = new Service([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'price'=> $request->get('price'),
                'user_id'=> $this->user->id,
                'image'=> ''
            ]);

            $service->save();

            return ['success'=>true, $service->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function deleteService(Request $request){
        
        if(!$request->has('store_id')||!$request->has('service_id')){
            return response('store_id or service_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::DELETE_SERVICE)){

            $service = Service::find($request->get('service_id',0));

            if($service==null){
                return ['success'=>false];
            }

            $service->delete();

            return ['success'=>true];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function deleteProduct(Request $request){
        
        if(!$request->has('store_id')||!$request->has('service_id')){
            return response('store_id or service_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::DELETE_PRODUCT)){

            $pro = Product::find($request->get('product_id',0));

            if($pro==null){
                return ['success'=>false];
            }

            $pro->delete();

            return ['success'=>true];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function updateService(Request $request){
        
        if(!$request->has('store_id')||!$request->has('service_id')){
            return response('store_id or service_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::UPDATE_SERVICE)){

            $validate = validator($request->all(),[
                'name' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'photo.*' => 'mimes:jpeg,png',
                'price'=> 'required'
            ]);

            if($validate->fails()){
                return ['messages'=>$validate->errors()->all()]+['success'=>false];
            }

            $service = Service::find($request->get('service_id'));
            $service->save([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'price'=> $request->get('price')
            ]);


            return ['success'=>true, $service->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function updateProduct(Request $request){
        
        if(!$request->has('store_id')||!$request->has('product_id')){
            return response('store_id or product_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->input('store_id'), StoreController::UPDATE_PRODUCT)){

            $validate = validator($request->all(),[
                'name' => 'required|max:128',
                'description' => 'required',
                'brand_id' => 'required',
                'price'=> 'required',
                'photo.*' => 'mimes:jpeg,png',
            ]);

            if($validate->fails()){
                return ['messages'=>$validate->errors()->all()]+['success'=>false];
            }

            $product = Product::find($request->input('product_id'));

            if($request->hasFile('photo')){

                $path = "/images/store/".$product->store_id."/product/".$product->id.'/';
                $pub = public_path($path);
                try{
                    if(!file_exists($pub)){
                        mkdir($pub);
                    }
                }catch(\Exception $e){}
                
                foreach($request->file('photo') as $file){

                    $photo = md5('jpg'.microtime().rand(0,1000)).".jpg";
                    $file->storeAs($path, $photo, 'public_html');
                    $product->removeAllImages();
                    $product->addImage(Image::path($path.$photo));
                }
            }
            $product->save([
                'title' => $request->input('name'),
                'description' => $request->input('description'),
                'brand_id' => $request->input('brand_id'),
                'price'=> $request->input('price'),
                'user_id'=> $this->user->id,
            ]);

            return ['success'=>true, $product->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function addAction(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::ADD_ACTION)){

            $validate = validator($request->all(),[
                'title' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'address'=> 'required'
            ]);

            if($validate->fails()){
                return ['messages'=>$validate->errors()->all()]+['success'=>false];
            }

            $action = new Action([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'address'=> $request->get('address')
            ]);

            $action->save();

            return ['success'=>true, $action->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function addDiscount(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::ADD_DISCOUNT)){

            $validate = validator($request->all(),[
                'title' => 'required|max:128',
                'discount' => 'required',
                'description' => 'required',
                'store_id' => 'required',
                'address'=> 'required'
            ]);

            if($validate->fails()){
                return ['messages'=>$validate->errors()->all()]+['success'=>false];
            }

            $discount = new Discount([
                'title' => $request->get('title'),
                'discount' => $request->get('discount'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'address'=> $request->get('address')
            ]);

            $discount->save();

            return ['success'=>true, $discount->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function updateAction(Request $request){
        
        if(!$request->has('store_id')||!$request->has('action_id')){
            return response('store_id or action_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::UPDATE_ACTION)){

            $validate = validator($request->all(),[
                'title' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'address'=> 'required'
            ]);

            if($validate->fails()){
                return ['messages'=>$validate->errors()->all()]+['success'=>false];
            }

            $action = Action::find($request->get('action_id'));
            $action->save([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'address'=> $request->get('address')
            ]);


            return ['success'=>true, $action->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function updateDiscount(Request $request){
        
        if(!$request->has('store_id')||!$request->has('discount_id')){
            return response('store_id or discount_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::UPDATE_DISCOUNT)){

            $validate = validator($request->all(),[
                'title' => 'required|max:128',
                'description' => 'required',
                'discount' => 'required',
                'store_id' => 'required',
                'address'=> 'required'
            ]);

            if($validate->fails()){
                return ['messages'=>$validate->errors()->all()]+['success'=>false];
            }

            $action = Action::find($request->get('action_id'));
            $action->save([
                'title' => $request->get('title'),
                'discount' => $request->get('discount'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'address'=> $request->get('address')
            ]);


            return ['success'=>true, $action->toArray()];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function deleteDiscount(Request $request){
        
        if(!$request->has('store_id')||!$request->has('discount_id')){
            return response('store_id or discount_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::DELETE_DISCOUNT)){


            $discount = Discount::find($request->get('discount_id'));

            $discount->delete();

            return ['success'=>true];
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function deleteAction(Request $request){
        
        if(!$request->has('store_id')||!$request->has('action_id')){
            return response('store_id or action_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::DELETE_ACTION)){


            $action = Discount::find($request->get('action_id'));

            $action->delete();

            return ['success'=>true];
        }else{
            throw new InvalidPermissionException();
        }
    }

}
