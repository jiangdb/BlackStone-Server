<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('share/{id}', 'ShareController@share')->name('share');

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.', 'namespace' => 'Admin'], function(){
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('firmware/{firmware}/download', 'FirmwareController@download')->name('firmware.download');
    Route::resource('firmware', 'FirmwareController');
    Route::get('devices/list', 'DeviceController@getDevices')->name('devices.list');
    Route::resource('devices', 'DeviceController');
    Route::get('user/list', 'UserController@getUsers')->name('user.list');
    Route::resource('user', 'UserController');
    Route::get('challenge', 'ChallengeController@index')->name('challenge.index');
    Route::get('challenge/ajax/leaderboard', 'ChallengeController@leaderBoard')->name('challenge.ajax.leaderboard');
    Route::post('challenge/clear', 'ChallengeController@clear')->name('challenge.clear');
});
