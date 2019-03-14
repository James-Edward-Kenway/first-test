<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Store;

class PublicController extends Controller
{
    
    public function getStore(Request $req){

        if(!$req->has('store_id')){
            return response('store_id is not given!',400);
        }
        $id = $req->get('store_id');

        $store = Store::find($id);
        if($store==null) return ['success'=>false];
        $subed = null;

        $data = ['product_count'=>\DB::table('products')->where('store_id', $id)->count(),
        'service_count'=>\DB::table('services')->where('store_id', $id)->count(),
        'subscirber_count'=>\DB::table('store_subscription')->where('store_id', $id)->count(),
        'action_count'=>\DB::table('actions')->where('store_id', $id)->count(),
        'discount_count'=>\DB::table('discounts')->where('store_id', $id)->count(),];

        return ['success'=>true,'data'=>$store->toArray() + ['meta_data'=>$data, 'subscribed' => !is_null($subed)]];
    }

}
