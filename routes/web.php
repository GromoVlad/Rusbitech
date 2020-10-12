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

/*
Route::get('/', 'App\Http\Controllers\MainController@newsList')->name('newsList');
Route::get('/news/{id}', 'App\Http\Controllers\MainController@news')->name('news');
*/

Route::get('/{any}', 'App\Http\Controllers\SpaController@index')->where('any', '.*');

