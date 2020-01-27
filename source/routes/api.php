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

Route::post('/login', 'Api\LoginController@login');

Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('groups')->group(function () {

        Route::get('/', 'GroupController@index');

        Route::post('/create', 'GroupController@store');

        Route::get('/{group}', 'GroupController@show');

        Route::put('/{group}', 'GroupController@update');

        Route::delete('/{group}', 'GroupController@destroy');

    });

});
