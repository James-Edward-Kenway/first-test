<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Request;
use App\Store;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\InvalidPermissionException;
use App\Product;
use App\Service;
use App\Action;

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
        
        $this->validate($request,[
            'name' => 'required|max:128',
            'description' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $store = new Store(['name'=>$request->get('name'), 'description'=>$request->get('description'),
         'address'=>$request->get('address'), 'phone'=>$request->get('phone'), 'status' => 3]);

        $store->save();
        $roles = $store->roles()->create(['user_id'=>$this->user->id,'role'=>StoreController::SUPERUSER]);

        return $store->toArray();
        
    }

    public function deteleStore(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }

        if($this->user->canManipulate($request->get('store_id'), StoreController::STORE_DELETE)){
            Store::where('id',$request->get('store_id'))->delete();
            return ['success'=>true];
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function updateStore(Request $request){

        $this->validate($request,[
            'store_id' => 'required',
            'name' => 'required|max:128',
            'description' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        if($this->user->canManipulate($request->get('store_id'), StoreController::STORE_UPDATE)){

            $store = Store::where('id',$request->get('store_id'))->first();
            $store->update(['name'=>$request->get('name'),'phone'=>$request->get('phone'),'description'=>$request->get('description'),'address'=>$request->get('address')]);
            return ['success'=>true];
        }else{
            throw new InvalidPermissionException();
        }
    }
    
    public function addProduct(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::ADD_PRODUCT)){

            $this->validate($request,[
                'name' => 'required|max:128',
                'description' => 'required',
                'brand_id' => 'required',
                'store_id' => 'required',
                'price'=> 'required'
            ]);

            $product = new Product([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'brand_id' => $request->get('brand_id'),
                'store_id' => $request->get('store_id'),
                'price'=> $request->get('price')
            ]);

            $product->save();

            return $product->toArray();
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function addService(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::ADD_SERVICE)){

            $this->validate($request,[
                'name' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'price'=> 'required'
            ]);

            $service = new Service([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'price'=> $request->get('price')
            ]);

            $service->save();

            return $service->toArray();
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

            $this->validate($request,[
                'name' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'price'=> 'required'
            ]);

            $service = Service::find($request->get('service_id'));
            $service->save([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'price'=> $request->get('price')
            ]);


            return $service->toArray();
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function updateProduct(Request $request){
        
        if(!$request->has('store_id')||!$request->has('product_id')){
            return response('store_id or product_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::UPDATE_PRODUCT)){

            $this->validate($request,[
                'name' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'price'=> 'required'
            ]);

            $pro = Product::find($request->get('product_id'));
            $pro->save([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'price'=> $request->get('price')
            ]);


            return $pro->toArray();
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function addAction(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::ADD_ACTION)){

            $this->validate($request,[
                'title' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'address'=> 'required'
            ]);

            $action = new Action([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'address'=> $request->get('address')
            ]);

            $action->save();

            return $action->toArray();
        }else{
            throw new InvalidPermissionException();
        }
    }

    public function addDiscount(Request $request){
        
        if(!$request->has('store_id')){
            return response('store_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::ADD_DISCOUNT)){

            $this->validate($request,[
                'title' => 'required|max:128',
                'discount' => 'required',
                'description' => 'required',
                'store_id' => 'required',
                'address'=> 'required'
            ]);

            $discount = new Discount([
                'title' => $request->get('title'),
                'discount' => $request->get('discount'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'address'=> $request->get('address')
            ]);

            $discount->save();

            return $discount->toArray();
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function updateAction(Request $request){
        
        if(!$request->has('store_id')||!$request->has('action_id')){
            return response('store_id or action_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::UPDATE_ACTION)){

            $this->validate($request,[
                'title' => 'required|max:128',
                'description' => 'required',
                'store_id' => 'required',
                'address'=> 'required'
            ]);

            $action = Action::find($request->get('action_id'));
            $action->save([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'address'=> $request->get('address')
            ]);


            return $action->toArray();
        }else{
            throw new InvalidPermissionException();
        }
    }
    public function updateDiscount(Request $request){
        
        if(!$request->has('store_id')||!$request->has('discount_id')){
            return response('store_id or discount_id is not given!',400);
        }
        
        if($this->user->canManipulate($request->get('store_id'), StoreController::UPDATE_DISCOUNT)){

            $this->validate($request,[
                'title' => 'required|max:128',
                'description' => 'required',
                'discount' => 'required',
                'store_id' => 'required',
                'address'=> 'required'
            ]);

            $action = Action::find($request->get('action_id'));
            $action->save([
                'title' => $request->get('title'),
                'discount' => $request->get('discount'),
                'description' => $request->get('description'),
                'store_id' => $request->get('store_id'),
                'address'=> $request->get('address')
            ]);


            return $action->toArray();
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
