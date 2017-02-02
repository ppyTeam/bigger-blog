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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('blog', 'PostController@index')->name('api.blog.list.default');
Route::get('blog/page/{page}', 'PostController@index')->name('api.blog.list')->where('page', '\d+');
Route::get('blog/{id}', 'PostController@show')->name('api.blog.show')->where('id', '\d+');

Route::get('categories', 'CategoryController@index')->name('api.categories.list');
Route::get('category/{name}', 'CategoryController@show')->name('api.categories.show.default');
Route::get('category/{name}/page/{page}', 'CategoryController@show')->name('api.categories.show')->where('page', '\d+');

Route::get('tags', 'TagController@index')->name('api.tags.list');
Route::get('tag/{name}', 'TagController@show')->name('api.tags.show.default');
Route::get('tag/{name}/page/{page}', 'TagController@show')->name('api.tags.show')->where('page', '\d+');

Route::get('archives', 'ArchivesController@index')->name('api.archives.default');
Route::get('archives/page/{page}', 'ArchivesController@index')->name('api.archives')->where('page', '\d+');