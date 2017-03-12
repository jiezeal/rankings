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

Route::group(['prefix' => 'web', 'namespace' => 'Web'], function(){
    Route::resource('/index', 'DiscussionController');
    Route::resource('/test', 'DiscussionController@test');
    Route::resource('/user', 'UserController');
    Route::resource('/login_interface', 'UserController@loginInterface');
    Route::resource('/login', 'UserController@login');
    Route::resource('/logout', 'UserController@logout');
    Route::resource('/user/verify/{verify}', 'UserController@verify');
});
