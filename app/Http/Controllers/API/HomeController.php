<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ServiceCategory;
use App\ProductCategory;
use App\Brand;

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
    public function subProductCategory($id){

        $product = ProductCategory::find($id);

        $result = [];
        
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
