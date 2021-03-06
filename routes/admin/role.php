<?php
/**
 * Created by PhpStorm.
 * User: pradeepm
 * Date: 12/3/2018
 * Time: 3:06 PM
 */


Route::prefix('admin')->group(function() {
    Route::get('/roles', 'admin\RoleController@index')->name('role.list');
    Route::get('/roles/create', 'admin\RoleController@create')->name('role.create');
    Route::post('/roles/store', 'admin\RoleController@store')->name('role.store');
    Route::get('/roles/get_role_list', 'admin\RoleController@getRoleList')->name('role.get_role_list');
    Route::get('/permission', 'admin\PermissionController@listPermissions')->name('permission.list');
    Route::get('/permissions/create', 'admin\PermissionController@create')->name('permission.create');
    Route::get('/permissions/get_permission_list', 'admin\PermissionController@getPermissionList')->name('permission.get_permission_list');
    Route::post('/permissions/store', 'admin\PermissionController@store')->name('permission.store');
});
