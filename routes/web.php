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
    // 帖子
    Route::resource('/index', 'DiscussionController');

    // 点赞
    Route::resource('/ranking', 'RankingController');
    Route::resource('/ranking_list', 'RankingController@rankingList');

    // 用户
    Route::resource('/user', 'UserController');
    Route::resource('/login_interface', 'UserController@loginInterface');
    Route::resource('/login', 'UserController@login');
    Route::resource('/logout', 'UserController@logout');
    Route::resource('/user/verify/{verify}', 'UserController@verify');
});
