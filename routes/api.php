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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1', 'as' => 'api.v1.'], function(){

    Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
        Route::get('/login', 'UserController@login')->name('login');
        Route::put('/update', 'UserController@update')->name('update')->middleware(['jwt.refresh','jwt.auth']);
    });

    Route::group(['prefix' => 'device', 'as' => 'device.'], function() {
        Route::get('/', 'DeviceController@index')->name('index');
        Route::post('/register', 'DeviceController@register')->name('register');
        Route::put('/online', 'DeviceController@online')->name('online');
        Route::get('/ota/{model}', 'DeviceController@getOta')->name('ota')->middleware(['jwt.refresh','jwt.auth']);
        Route::get('/ota/{id}/download', 'DeviceController@downloadOta')->name('ota.download');
//        Route::post('/work', 'Api\DeviceController@work');
    });

    Route::get('/token/refresh', 'TokenController@refresh');

    Route::group(['prefix' => 'work', 'middleware' => ['jwt.refresh','jwt.auth'], 'as' => 'work.'], function() {
        Route::get('/', 'WorkController@index')->name('index');
        Route::get('/{id}', 'WorkController@show')->name('show');
        Route::post('/', 'WorkController@store')->name('store');
        Route::delete('/{id}', 'WorkController@destroy')->name('delete');
    });

    Route::group(['prefix' => 'challenge', 'middleware' => ['jwt.refresh','jwt.auth'], 'as' => 'challenge.'], function() {
        Route::get('/leaderboard', 'ChallengeController@leaderBoard')->name('leaderboard');
        Route::post('/', 'ChallengeController@store')->name('store');
    });

    /*
    Route::get('/work', 'WorkController@work');
    Route::get('/work/{id}', 'WorkController@showWork');
    */
});

