<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup', 'UsersController@create')->name('signup');

Route::resource('users','UsersController');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');


//填写表单页面
Route::get('password/reset',  'PasswordController@showLinkRequestForm')->name('password.request');
//处理表单数据
Route::post('password/email',  'PasswordController@sendResetLinkEmail')->name('password.email');

//显示更新密码表单,内置token
Route::get('password/reset/{token}',  'PasswordController@showResetForm')->name('password.reset');
//对提交的token和email进行验证,验证成功更新密码
Route::post('password/reset',  'PasswordController@reset')->name('password.update');
