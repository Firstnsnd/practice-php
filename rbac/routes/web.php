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



// 后台
Route::group(['prefix' => 'admin'], function () {


  // 登录页面
  Route::get('login', 'Admin\LoginController@showLoginForm');
  Route::post('login', 'Admin\LoginController@login');
  Route::get('logout', 'Admin\LoginController@logout');
  //验证码
  Route::get('validate_code/create', 'Admin\LoginController@validateCode');
  
  Route::get('permission/noPermission', 'Admin\PermissionController@noPermission');
    Route::group(['middleware'=>'check.login'], function(){
      // 首页
      Route::get('index', 'Admin\IndexController@index');

        Route::group(['middleware'=>'check.permission'], function(){
              // 商品管理
              Route::get('product/index', 'Admin\ProductController@index');
              Route::get('product/create', 'Admin\ProductController@create');
              Route::get('product/edit/{id}', 'Admin\ProductController@edit');
              Route::get('product/delete/{id}', 'Admin\ProductController@destroy');

              // 订单管理
              Route::get('order/index', 'Admin\OrderController@index');
              Route::get('order/create', 'Admin\OrderController@create');
              Route::get('order/edit/{id}', 'Admin\OrderController@edit');
              Route::get('order/delete/{id}', 'Admin\OrderController@destroy');

              // 管理员管理
              Route::get('manager/index', 'Admin\ManagerController@index');
              Route::get('manager/create', 'Admin\ManagerController@create');
              Route::post('manager/create', 'Admin\ManagerController@store');
              Route::get('manager/edit/{id}', 'Admin\ManagerController@edit');
              Route::post('manager/edit', 'Admin\ManagerController@update');
              Route::get('manager/delete/{id}', 'Admin\ManagerController@destroy');

              // 角色管理
              Route::get('role/index', 'Admin\RoleController@index');
              Route::get('role/create', 'Admin\RoleController@create');
              Route::post('role/create', 'Admin\RoleController@store');
              Route::get('role/edit/{id}', 'Admin\RoleController@edit');
              Route::post('role/edit', 'Admin\RoleController@update');
              Route::get('role/delete/{id}', 'Admin\RoleController@destroy');

              // 权限管理
              Route::get('permission/index', 'Admin\PermissionController@index');
              Route::get('permission/create', 'Admin\PermissionController@create');
              Route::post('permission/create', 'Admin\PermissionController@store');
              Route::get('permission/edit/{id}', 'Admin\PermissionController@edit');
              Route::post('permission/edit', 'Admin\PermissionController@update');
              Route::get('permission/delete/{id}', 'Admin\PermissionController@destroy');

        });
    });
});
