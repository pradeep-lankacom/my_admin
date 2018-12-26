<?php
/**
 * Created by PhpStorm.
 * User: pradeepm
 * Date: 12/3/2018
 * Time: 3:06 PM
 */


Route::group(['prefix' => 'admin', 'middleware' => ['role.permission:SuperAdmin']], function () {
    Route::get('/users', 'admin\AdminController@index')->name('user.list');
    Route::get('/users/get_user_list', 'admin\AdminController@getUserList')->name('user.get_list');
    Route::get('/user/create', 'admin\AdminController@create')->name('user.create');
    Route::post('/user/store', 'admin\AdminController@store')->name('user.store');

});
