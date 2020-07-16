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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['apiKey']], function() {
    Route::get('get/genres', 'GenresController@index');
    Route::post('save/genres', 'GenresController@store');

    Route::get('get/movies', 'MoviesController@index');
    Route::get('get/movies/genre/{id}', 'MoviesController@index');
    Route::post('save/movies', 'MoviesController@store');
    Route::put('update/movie/{id}', 'MoviesController@update');
    Route::get('get/movies/{id}', 'MoviesController@show');
});