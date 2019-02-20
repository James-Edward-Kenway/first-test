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


// user controll

Route::get('user/register','UserController@register');
Route::get('user/login','UserController@login');

Route::get('user/token','ProfileController@token');

//wishlist
Route::get('user/wishlist_product_ids','ProfileController@wishlistProductIds');
Route::get('user/wishlist_service_ids','ProfileController@wishlistServiceIds');
Route::get('user/wishlist_services','ProfileController@wishlistServices');
Route::get('user/wishlist_products','ProfileController@wishlistProducts');
Route::get('user/add_wishlist_product','ProfileController@addToWishlistProduct');
Route::get('user/add_wishlist_service','ProfileController@addToWishlistService');
Route::get('user/delete_wishlist_product','ProfileController@deleteWishlistProduct');
Route::get('user/delete_wishlist_service','ProfileController@deleteWishlistService');
//likes
Route::get('user/product_likes_ids','ProfileController@productLikesIds');
Route::get('user/service_likes_ids','ProfileController@serviceLikesIds');
Route::get('user/product_likes','ProfileController@productLikes');
Route::get('user/service_likes','ProfileController@serviceLikes');
Route::get('user/add_product_likes','ProfileController@addToProductLikes');
Route::get('user/add_service_likes','ProfileController@addToServiceLikes');
Route::get('user/delete_product_likes','ProfileController@deleteProductLikes');
Route::get('user/delete_service_likes','ProfileController@deleteServiceLikes');


//store controll

Route::get('store/add','StoreController@addStore');
Route::get('store/delete','StoreController@deleteStore');
Route::get('store/update','StoreController@updateStore');
Route::get('store/show','PublicController@getStore');

// product and service controll

Route::get('store/add_product','StoreController@addProduct');
Route::get('store/add_service','StoreController@addService');
Route::get('store/delete_product','StoreController@deleteProduct');
Route::get('store/delete_service','StoreController@deleteService');
Route::get('store/update_product','StoreController@updateProduct');
Route::get('store/update_service','StoreController@updateService');

//action and discount controll

Route::get('store/update_action','StoreController@updateAction');
Route::get('store/update_discount','StoreController@updateDiscount');
Route::get('store/add_action','StoreController@addAction');
Route::get('store/add_discount','StoreController@addDiscount');
Route::get('store/delete_action','StoreController@deleteAction');
Route::get('store/delete_discount','StoreController@deleteDiscount');
