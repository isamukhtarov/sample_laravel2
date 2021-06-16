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
Route::put('image/{image}/edit', 'ImageController@update')->name('edit.image');
Route::post('image/{image}/change-order', 'ImageController@changeOrder')->name('change.order');
Route::delete('image/{image}/delete', 'ImageController@destroy')->name('delete.image');
