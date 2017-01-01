<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Route::get('/', function () {
//    return view('index');
//});
Route::get('/', 'PostController@index');

Route::get('/blog', 'PostController@index')->name('blog.list');
Route::get('/blog/{id}', 'PostController@show')->name('blog.show')->where('id', '\d+');

Route::get('/categories', 'CategoryController@index')->name('categories.list');
Route::get('/categories/{id}', 'CategoryController@show')->name('categories.show')->where('id', '\d+');
