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

Route::get('/home/{lang?}', '\App\Http\Controllers\PostController@home')->name('home');
Route::view('/create', 'home');
Route::post('/create', '\App\Http\Controllers\PostController@create')->name('create');  //csrf protection
Route::get('/post/{id}/{lang?}', '\App\Http\Controllers\PostController@showPost')->name('post');
Route::get('/{code}/{lang?}', '\App\Http\Controllers\PostController@showPostWithCode')->name('post.code');