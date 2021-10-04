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

Route::prefix('movie')->group(function() {
    Route::get('/', 'MovieController@index');
    Route::get('/add_categories', 'MovieController@add_categories');
    Route::get('/add_top_rated_movies', 'MovieController@add_top_rated_movies');
    Route::get('/add_latest_movie', 'MovieController@add_latest_movie');

});
