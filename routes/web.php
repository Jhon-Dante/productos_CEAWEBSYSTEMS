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

Route::get('/', function () {
    return view('products.index');
});


Route::resource('products','ProductsController');
Route::get('products/1/get','ProductsController@get');
Route::get('products/{id}/show','ProductsController@show');
Route::post('products/store','ProductsController@store');
Route::post('products/update','ProductsController@update');
Route::get('products/{id}/delete','ProductsController@delete');

Route::resource('comments','CommentsController');
Route::post('comments/store','CommentsController@store');
Route::get('comments/{id}/delete','CommentsController@delete');