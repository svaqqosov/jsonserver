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

Route::get('project/{id}', 'IndexController@show');
Route::post('project', 'IndexController@store');
Route::put('project/{id}', 'IndexController@put');
Route::patch('project/{id}', 'IndexController@put');
