<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Request;
use App\Http\Controllers\Controller;
use App\ServiceCategory;
use App\ProductCategory;
use App\Brand;
use App\Product;
use Illuminate\Support\Facades\URL;
use App\Service;
use App\Action;
use App\Discount;
use App\Banner;
use App\Store;

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
            $result = $this->getchild($service);
        }
        
        return response($result);
    }

    function getchild($cat){

        if($cat->children != null){
            foreach($cat->children as $k => $child){
                $cat->children[$k] = $this->getchild($child);
            }
        }
        return $cat;
    }


    //this is working with only one depth children
    public function subProductCategory($id){

        $product = ProductCategory::find($id);

        $result = [];
        
        if($product != null){
            $result = $this->getchild($product);
        }
        
        return response($result);
    }


    
    public function products(Request $request){

        
        $title = @$request->get('name');

        $store_id = @$request->get('store_id');

        $brand_id = @$request->get('brand_id');
        
        //this will also determine attribute groups
        $pro_cat_id = @$request->get('product_category_id');
        
        //ids of the attributes
        $attributes = @$request->get('attributes');
        
        //order, might include price, created_at
        $order = @$request->get('order');

        //order_type, one of these: asc or desc
        $order_type = @$request->get('order_type');

        if($order != "price" && $order != "created_at"){
            $order = "id";
        }

        if($order_type!="asc"&&$order_type!="desc"){
            $order_type = "desc";
        }

        $products = Product::orderBy($order, $order_type);

        if(\is_numeric($brand_id)){
            $products->where('brand_id', $brand_id);
        }

        if(\is_numeric($store_id)){
            $products->where('store_id', $store_id);
        }

        if(is_numeric($pro_cat_id)){

            $pro_cat_arr = [];
            $list = [];
            $cat = ProductCategory::find($pro_cat_id);

            if($cat!=null){

                $list = array_prepend($list, $cat, $cat->id);
                ref:
                if(!empty($list)){
                    $arr = head($list);
                    array_forget($list, $arr->id);

                    if(!$arr->children->isEmpty()){
                        foreach($arr->children as $child){
                            $list = array_prepend($list, $child, $child->id);
                        }
                    }else{
                        $pro_cat_arr = array_prepend($pro_cat_arr, $arr->id);
                    }
                    goto ref;
                }
                $products->whereIn('product_category_id',$pro_cat_arr);
            }
        }

        if($title!=null){
            $products->where('title','like','%'.$title.'%');
        }

        if(\is_array($attributes)){
            $products->join('attribute_categories_product_categories', function($q){
                $q->on('products.id','=','attribute_categories_product_categories.product_category_id');
            })->whereIn('attribute_categories_product_categories.attribute_category_id', $attributes);
        }

        $products = $products->paginate(20)->toArray();


        $attrs = ['brand_id'=>$brand_id, 'product_category_id'=>$pro_cat_id, 'order'=>$order, 'order_type'=>$order_type, 'attributes'=>$attributes];
        $products['first_page_url'] .= '&'.http_build_query($attrs);

        $products['last_page_url'] .= '&'.http_build_query($attrs);
        
        if($products['next_page_url']!=null){
            $products['next_page_url'] .= '&'.http_build_query($attrs);
        }
        
        if($products['prev_page_url']!=null){
            $products['prev_page_url'] .= '&'.http_build_query($attrs);
        }

        if(false){
            $data = $products['data'];

            foreach($data as $k => $v){
                if(\DB::table('product_likes')->where('product_id', $v['id'])->where('product_id', $v['id'])){

                }
            }

            $products['data'] = $data;
        }
        return $products;


    }



    public function services(Request $request){

        
        $title = @$request->get('name');

        $store_id = @$request->get('store_id');

        $brand_id = @$request->get('brand_id');
        
        //this will also determine attribute groups
        $ser_cat_id = @$request->get('service_category_id');
        
        //ids of the attributes
        $attributes = @$request->get('attributes');
        
        //order, might include price, created_at
        $order = @$request->get('order');

        //order_type, one of these: asc or desc
        $order_type = @$request->get('order_type');

        if($order != "price" && $order != "created_at"){
            $order = "id";
        }

        if($order_type!="asc"&&$order_type!="desc"){
            $order_type = "desc";
        }

        $services = Service::orderBy($order, $order_type);

        if(\is_numeric($store_id)){
            $services->where('store_id', $store_id);
        }
        if(\is_numeric($brand_id)){
            $services->where('brand_id', $brand_id);
        }

        if($title!=null){
            $services->where('title','like','%'.$title.'%');
        }

        if(is_numeric($ser_cat_id)){
            $services->where('service_category_id', $ser_cat_id);
        }


        if(\is_array($attributes)){
            $services->join('attribute_categories_services_categories', function($q){
                $q->on('services.id','=','attribute_categories_services_categories.service_category_id');
            })->whereIn('attribute_categories_services_categories.attribute_category_id', $attributes);
        }


        $services = $services->paginate(20)->toArray();


        $attrs = ['brand_id'=>$brand_id, 'service_category_id'=>$ser_cat_id, 'order'=>$order, 'order_type'=>$order_type, 'attributes'=>$attributes];
        $services['first_page_url'] .= '&'.http_build_query($attrs);

        $services['last_page_url'] .= '&'.http_build_query($attrs);
        
        if($services['next_page_url']!=null){
            $services['next_page_url'] .= '&'.http_build_query($attrs);
        }
        
        if($services['prev_page_url']!=null){
            $services['prev_page_url'] .= '&'.http_build_query($attrs);
        }

        return response($services);
    }

    public function serviceAttributes($id){

        $groups = ServiceCategory::find($id)->attributesGroups()->with('children')->get();

        return $groups;
    }


    public function productAttributes($id){

        $groups = ProductCategory::find($id)->attributesGroups()->with('children')->get();

        return $groups;
    }

    public function brands(){
        $brands = Brand::all();
        return $brands;
    }


    public function serviceCategory(){
        $cats = ServiceCategory::orderBy('id','desc')->get();
        return $cats;
    }

    
    public function productCategories(Request $req){
        $cats = ProductCategory::whereHas('products',function($q) use($req){
            $q->where('store_id', $req->get('store_id',0));
        })->orderBy('id','desc')->get();
        return $cats;
    }
    public function serviceCategories(Request $req){
        $cats = ServiceCategory::whereHas('services',function($q) use($req){
            $q->where('store_id', $req->get('store_id',0));
        })->orderBy('id','desc')->get();
        return $cats;
    }

    
    public function productCategory(){
        $cats = ProductCategory::orderBy('id','desc')->get();
        return $cats;
    }

    public function actions(Request $request)
    {
        $actions = Action::orderBy('id','desc');
        if($request->has('store_id')){
            $actions = $actions->where('store_id', $request->get('store_id'));
        }
        return $actions->paginate(20);
    }

    public function discounts(Request $request)
    {
        $discounts = Discount::orderBy('id','desc');
        if($request->has('store_id')){
            $discounts = $discounts->where('store_id', $request->get('store_id'));
        }
        return $discounts->paginate(20);
    }

    public function banners(Request $request)
    {
        $banners = Banner::orderBy('created_at','desc')->paginate(20);
        return $banners;
    }

    public function trendingProducts(Request $request)
    {
        $pros = Product::orderBy('like_count','desc')->orderBy('id','desc')->paginate(20);
        return $pros;
    }

    public function popularServices(Request $request)
    {
        $ser = Service::orderBy('like_count','desc')->orderBy('id','desc')->paginate(20);
        return $ser;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
