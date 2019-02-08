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

Route::get('home','HomeController@index');

Route::get('sub_service_category/{id}','HomeController@subServiceCategory');

Route::get('sub_product_category/{id}','HomeController@subProductCategory');

Route::get('products','HomeController@products');

Route::get('services','HomeController@services');

Route::get('service_attributes/{id}','HomeController@serviceAttributes');

Route::get('product_attributes/{id}','HomeController@productAttributes');

Route::get('brands','HomeController@brands');

Route::get('product_category','HomeController@productCategory');

Route::get('service_category','HomeController@serviceCategory');

Route::get('user/register','UserController@register');

Route::get('actions', 'HomeController@actions');

Route::get('discounts', 'HomeController@discounts');

Auth::routes();

Route::get('check', 'UserController@check');

Route::middleware('auth:api')->group(function(){


});

