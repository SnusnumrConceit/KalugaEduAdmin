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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Auth::routes();

// Send reset password mail
Route::post('reset-password', 'AuthController@sendPasswordResetLink');

// handle reset password form process
//Route::post('reset/password', 'AuthController@callResetPassword');

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', 'AuthController@login');

        Route::get('refresh', 'AuthController@refresh');

        Route::group(['middleware' => 'auth'], function () {
            Route::get('user', 'AuthController@user');

            Route::post('logout', 'AuthController@logout');

            Route::post('register', 'AuthController@register');

            Route::post('reset/password', 'AuthController@customResetPassword');

//            // Send reset password mail
//            Route::post('reset-password', 'AuthController@sendPasswordResetLink');
//
//            // handle reset password form process
//            Route::post('reset/password', 'AuthController@callResetPassword');
        });
    });
});


Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('categories', 'CategoryController');
Route::get('/admin/categories/search', 'CategoryController@search');
Route::get('/categories/{category}/documents', 'CategoryController@getDocuments');

Route::get('/admin/roles', 'RoleController@index');

Route::resource('documents', 'DocumentController');
Route::get('/admin/documents/search', 'DocumentController@search');

Route::post('/admin/documents/upload', 'DocumentController@upload');
Route::post('/admin/documents/remove', 'DocumentController@remove');
Route::post('/admin/documents/download', 'DocumentController@download');

Route::resource('users', 'UserController');
Route::get('/admin/users/search', 'UserController@search');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');