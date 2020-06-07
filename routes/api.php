<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/tasks', 'TaskController@index');
    Route::get('/tasks/{id}', 'TaskController@show');
    Route::post('/tasks', 'TaskController@store');
    Route::patch('/tasks/{id}', 'TaskController@update');
    Route::delete('/tasks/{id}', 'TaskController@destroy');

    Route::post('/logout', 'AuthController@logout');
});

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');


