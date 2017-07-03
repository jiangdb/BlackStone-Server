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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/register', 'UserController@register');
Route::post('/user/login', 'UserController@login');

Route::post('/token/refresh', 'TokenController@refresh');

Route::get('/work', 'WorkController@work');
Route::post('/work', 'WorkController@storeWork');
Route::get('/work/{id}', 'WorkController@showWork');

Route::post('/device/register', 'DeviceController@register');
Route::post('/device/work', 'DeviceController@work');
