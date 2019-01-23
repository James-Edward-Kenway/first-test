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
Route::get('home','API\HomeController@index');
Route::get('home','API\HomeController@index');
