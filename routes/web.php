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

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.', 'namespace' => 'Admin'], function(){
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('firmware/{firmware}/download', 'FirmwareController@download')->name('firmware.download');
    Route::resource('firmware', 'FirmwareController');
});
