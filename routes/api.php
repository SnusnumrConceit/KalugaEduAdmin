<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
//    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('register', 'AuthController@register');

            Route::post('login', 'AuthController@login');

            Route::get('refresh', 'AuthController@refresh');

            Route::group(['middleware' => 'api:auth'], function () {
                Route::get('user', 'AuthController@user');

                Route::post('logout', 'AuthController@logout');
            });
        });
//    });
});
