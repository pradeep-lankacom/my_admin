<?php
/**
 * Created by PhpStorm.
 * User: pradeepm
 * Date: 12/3/2018
 * Time: 3:06 PM
 */


Route::group(['prefix' => 'admin', 'middleware' => ['role.permission:SuperAdmin']], function () {
    Route::get('/category', 'admin\CategoryController@index')->name('category.list');
    Route::get('/category/get_category_list', 'admin\CategoryController@getCategoryList')->name('user.category_list');
    Route::get('/category/create', 'admin\CategoryController@create')->name('category.create');
    Route::post('/category/store', 'admin\CategoryController@store')->name('category.store');

});
