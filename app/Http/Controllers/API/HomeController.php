<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ServiceCategory;
use App\ProductCategory;
use App\Brand;
use App\Product;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];

        $result['brand'] = Brand::all()->toArray();

        $result['service_category'] = ServiceCategory::where('parent_id',0)->get()->toArray();
        
        $result['product_category'] = ProductCategory::where('parent_id',0)->get()->toArray();


        return response($result);
    }


    //this is working with only one depth children
    public function subServiceCategory($id){

        $service = ServiceCategory::find($id);

        $result = [];
        
        if($service != null){
            $result = $service->children()->with('children')->get()->toArray();
        }
        
        return response($result);
    }


    //this is working with only one depth children
    public function subProductCategory($id){

        $product = ProductCategory::find($id);

        $result = [];
        
        if($product != null){
            $result = $product->children()->with('children')->get()->toArray();
        }
        
        return response($result);
    }


    
    //this is working with only one depth children
    public function Products(Request $request){

        $brand_id = @$request->get('brand_id');
        
        //this will also determine attribute groups
        $pro_cat_id = @$request->get('product_category_id');
        
        //ids of the attributes
        $attributes = @$request->get('attributes');
        
        //order, might include price, created_at
        $order = @$request->get('order');

        //order_type, one of these: asc or desc
        $order_type = @$request->get('order_type');

        if($order != "price"&&$order != "created_at"){
            $order = "";
        }

        if($order_type!="asc"&&$order_type!="desc"){
            $order_type = "";
        }

        if(!\is_array($attributes)){
            $attributes = [];
        }

        $products = Product::where('brand_id',$brand_id)->where('product_category_id',$pro_cat_id)
        ->where('attributes',function($q) use($attributes){
            $q->whereIn('id',$attributes);
        })->orderBy($order, $order_type)->paginate(20);

        dd($products);
        $result = [];
        $result['products'] = $products->toArray();

        $result['metadata'] = [

        ];



        if($product != null){
            $result = $product->children()->with('children')->get()->toArray();
        }
        
        return response($result);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
