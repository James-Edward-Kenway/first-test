<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// public controll

Route::get('home','HomeController@index');

Route::get('product_attributes/{id}','HomeController@productAttributes');
Route::get('sub_product_category/{id}','HomeController@subProductCategory');
Route::get('product_category','HomeController@productCategory');
Route::get('products','HomeController@products');
Route::get('trending_products','HomeController@trendingProducts');
Route::get('popular_services','HomeController@popularServices');

Route::get('services','HomeController@services');
Route::get('service_attributes/{id}','HomeController@serviceAttributes');
Route::get('sub_service_category/{id}','HomeController@subServiceCategory');
Route::get('service_category','HomeController@serviceCategory');

Route::get('brands','HomeController@brands');
Route::get('actions', 'HomeController@actions');
Route::get('discounts', 'HomeController@discounts');
Route::get('banners', 'HomeController@banners');

Route::get('store/show','PublicController@getStore');

// user controll

Route::post('user/register','UserController@register');
Route::get('user/login','UserController@login');

Route::get('store/product_categories','HomeController@productCategories');
Route::get('store/service_categories','HomeController@serviceCategories');

Route::get('user/google_register','UserController@googleRegister');
Route::get('user/google_login','UserController@googleLogin');

Route::get('store/gettarifs','ProfileController@getTarifs');
Route::get('user/getusertarifs','ProfileController@getUserTarifs');

Route::group(['middleware' => 'middle'], function () {
    
    // user controll
    Route::get('user/token','ProfileController@token');
    Route::get('user/logout','ProfileController@logout');
    Route::post('user/edit','ProfileController@editUser');

    Route::get('user/getpaymentpaymelink','ProfileController@getpaymentpaymelink');

    Route::get('user/getpaymentlogs','ProfileController@getPaymentLogs');
    
    Route::get('user/buyusertarif','ProfileController@buyUserTarif');
    Route::get('user/getusertariflogs','ProfileController@getUserTarifLogs');
    Route::get('user/getlimits','ProfileController@getLimits');


    Route::get('user/paymelink','ProfileController@paymeLink');

    Route::get('store/listofusers','ProfileController@listOfUsers');
    Route::get('store/changeroles','ProfileController@changeRoles');
    Route::get('store/adduserrole','ProfileController@addUserRole');


    Route::get('store/buytarif','ProfileController@buyTarif');
    Route::get('store/getstoretariflogs','ProfileController@getStoreTarifLogs');
    // subcriptions
    Route::get('user/subscribe','ProfileController@subscribe');
    Route::get('user/unsubscribe','ProfileController@unsubscribe');


    //store controll

    Route::post('store/add','StoreController@addStore');
    Route::get('store/delete','StoreController@deteleStore');
    Route::post('store/update','StoreController@updateStore');
    Route::get('store/roles','StoreController@getRoles');
    Route::get('store/mystores','StoreController@getStores');
    Route::get('store/getfavproducts','StoreController@getFavProducts');
    Route::get('store/getfavservices','StoreController@getFavServices');

    


    // product and service controll

    Route::post('store/add_product','StoreController@addProduct');
    Route::post('store/add_service','StoreController@addService');
    Route::get('store/delete_product','StoreController@deleteProduct');
    Route::get('store/delete_service','StoreController@deleteService');
    Route::post('store/update_product','StoreController@updateProduct');
    Route::post('store/update_service','StoreController@updateService');

    //action and discount controll

    Route::post('store/update_action','StoreController@updateAction');
    Route::post('store/update_discount','StoreController@updateDiscount');
    Route::post('store/add_action','StoreController@addAction');
    Route::post('store/add_discount','StoreController@addDiscount');
    Route::get('store/delete_action','StoreController@deleteAction');
    Route::get('store/delete_discount','StoreController@deleteDiscount');
    
    //wishlist
    Route::get('user/wishlist_services','ProfileController@wishlistServices');
    Route::get('user/wishlist_products','ProfileController@wishlistProducts');
    Route::get('user/add_wishlist_product','ProfileController@addToWishlistProduct');
    Route::get('user/add_wishlist_service','ProfileController@addToWishlistService');
    Route::get('user/delete_wishlist_product','ProfileController@deleteWishlistProduct');
    Route::get('user/delete_wishlist_service','ProfileController@deleteWishlistService');
    //likes
    Route::get('user/product_likes','ProfileController@productLikes');
    Route::get('user/service_likes','ProfileController@serviceLikes');
    Route::get('user/add_product_likes','ProfileController@addToProductLikes');
    Route::get('user/add_service_likes','ProfileController@addToServiceLikes');
    Route::get('user/delete_product_likes','ProfileController@deleteProductLikes');
    Route::get('user/delete_service_likes','ProfileController@deleteServiceLikes');




});



Route::get('test', 'HomeController@test');