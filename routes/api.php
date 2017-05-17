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
Route::get('{slug}', 'IndexController@index')->where('slug', '([a-z]+)?');
Route::get('{slug}/{id}', 'IndexController@show')->where('slug', '([a-z]+)?');
Route::post('{slug}', 'IndexController@store')->where('slug', '([a-z]+)?');
Route::put('{slug}/{id}', 'IndexController@put')->where('slug', '([a-z]+)?');
Route::patch('{slug}/{id}', 'IndexController@patch')->where('slug', '([a-z]+)?');
Route::delete('{slug}/{id}', 'IndexController@delete')->where('slug', '([a-z]+)?');

//Route::get('project', 'IndexController@show');
//Route::get('project/{id}', 'IndexController@show');
//Route::post('project', 'IndexController@store');
//Route::put('project/{id}', 'IndexController@put');
//Route::patch('project/{id}', 'IndexController@patch');
//Route::delete('project/{id}', 'IndexController@delete');