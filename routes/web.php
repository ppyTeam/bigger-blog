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

Route::get('/blog', 'PostController@index')->name('blog.list.default');
Route::get('/blog/page/{page}', 'PostController@index')->name('blog.list')->where('page', '\d+');
Route::get('/blog/{id}', 'PostController@show')->name('blog.show')->where('id', '\d+');

Route::get('/categories', 'CategoryController@index')->name('categories.list');
Route::get('/category/{name}', 'CategoryController@show')->name('categories.show.default');
Route::get('/category/{name}/page/{page}', 'CategoryController@show')->name('categories.show')->where('page', '\d+');


Route::get('/tags', 'TagController@index')->name('tags.list');
Route::get('/tag/{name}', 'TagController@show')->name('tags.show.default');
Route::get('/tag/{name}/page/{page}', 'TagController@show')->name('tags.show')->where('page', '\d+');

Route::get('/archives', 'ArchivesController@index')->name('archives.default');
Route::get('/archives/page/{page}', 'ArchivesController@index')->name('archives')->where('page', '\d+');