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

Route::get('home','API\HomeController@index');

Route::get('sub_service_category/{id}','API\HomeController@subServiceCategory');

Route::get('sub_product_category/{id}','API\HomeController@subProductCategory');

Route::get('products','API\HomeController@products');

Route::get('services','API\HomeController@services');

Route::get('service_attributes/{id}','API\HomeController@serviceAttributes');

Route::get('product_attributes/{id}','API\HomeController@productAttributes');

Route::get('brands','API\HomeController@brands');

Route::get('product_category','API\HomeController@productCategory');

Route::get('service_category','API\HomeController@serviceCategory');


