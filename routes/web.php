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

Route::get('/', 'RedirectController@index');
Route::post('/', 'RedirectController@index');
Route::post('/clear', 'RedirectController@clear');
Route::get('/{hash}', 'RedirectController@redirect');
