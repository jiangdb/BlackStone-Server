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


Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1', 'as' => 'api.v1.'], function(){
    Route::group(['prefix' => 'device', 'as' => 'device.'], function() {
        Route::post('/register', 'DeviceController@register')->name('register');
        Route::get('/ota/{model}', 'DeviceController@getOta')->name('ota');
        Route::get('/ota/{id}/download', 'DeviceController@downloadOta')->name('ota.download');
//        Route::post('/work', 'Api\DeviceController@work');
    });
    /*
    Route::post('/user/register', 'UserController@register');
    Route::post('/user/login', 'UserController@login');

    Route::post('/token/refresh', 'TokenController@refresh');

    Route::get('/work', 'WorkController@work');
    Route::post('/work', 'WorkController@storeWork');
    Route::get('/work/{id}', 'WorkController@showWork');
    */
});

