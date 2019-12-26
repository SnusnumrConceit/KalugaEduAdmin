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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');

    Route::post('login', 'AuthController@login');

    Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('user', 'AuthController@user');

        Route::post('logout', 'AuthController@logout');
    });
});


Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('categories', 'CategoryController');
Route::get('/admin/categories/search', 'CategoryController@search');

Route::resource('documents', 'DocumentController');
Route::get('/admin/documents/search', 'DocumentController@search');

Route::resource('users', 'UserController');
Route::get('/admin/users/search', 'UserController@search');
