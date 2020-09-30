<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\PostController;

Route::resource('posts', PostController::class)->except([
    'index','show'
]);

Route::get('/posts/{lang?}', '\App\Http\Controllers\PostController@index')->name('index');
Route::get('/posts/id/{id}/{lang?}', '\App\Http\Controllers\PostController@show')->name('show');
Route::get('/admin/{lang?}', '\App\Http\Controllers\PostController@admin')->name('admin');

// Route::get('/post/updatePost/{id}', '\App\Http\Controllers\PostController@edit')->name('updatePost');
// Route::post('/post/update/{id}', '\App\Http\Controllers\PostController@update')->name('update');
// Route::get('/post/deletePost/{id}', '\App\Http\Controllers\PostController@deletePost')->name('deletePost');
// Route::view('/post/create', 'home');
// Route::post('/post/create', '\App\Http\Controllers\PostController@store')->name('create');  //csrf protection
// Route::get('/post/{id}/{lang?}', '\App\Http\Controllers\PostController@show')->name('post');

Route::get('/posts/code/{code}/{lang?}', '\App\Http\Controllers\PostController@showPostWithCode')->name('post.code');