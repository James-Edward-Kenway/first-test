<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Store;

class PublicController extends Controller
{
    public function __construct()
    {
        
    }
    
    public function getStore(Request $req){

        if(!$req->has('store_id')){
            return response('store_id is not given!',400);
        }
        $id = $req->get('store_id');

        $store = Store::find($id);
        if($store==null) return ['success'=>false];

        return ['success'=>true,'data'=>$store->toArray()];
    }
}
