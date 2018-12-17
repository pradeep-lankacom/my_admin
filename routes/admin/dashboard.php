<?php
/**
 * Created by PhpStorm.
 * User: pradeepm
 * Date: 12/3/2018
 * Time: 3:06 PM
 */


    Route::get('/admin', [
        'as' => 'admin',
        'uses' => 'admin\AdminController@dashborad',
    ]);


Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login_submit', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/home', 'admin\AdminController@dashborad')->name('admin.home');
    Route::get('/dashboard', 'admin\AdminController@dashborad')->name('admin.home');
});
