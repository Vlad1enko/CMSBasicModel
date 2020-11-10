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

use App\Http\Controllers\PageController;

Route::resource('pages', PageController::class)->except([
    'index','show'
]);

Route::get('/pages/{parent?}/{lang?}', '\App\Http\Controllers\PageController@index')->name('index');
Route::get('/storage/{filename}', function() {
    return '../storage/app/public/{filename}';
})->name('file');
Route::post('/changeOrder/{lang?}', '\App\Http\Controllers\PageController@changeOrder')->name('changeOrder');
Route::post('/changeAdminOrder/{lang?}', '\App\Http\Controllers\PageController@changeAdminOrder')->name('changeAdminOrder');
Route::get('/pages/id/{id}/{lang?}', '\App\Http\Controllers\PageController@show')->name('show');
Route::get('/admin/{lang?}', '\App\Http\Controllers\PageController@admin')->name('admin');
Route::get('/pages/code/{code}/{lang?}', '\App\Http\Controllers\PageController@showPostWithCode')->name('post.code');