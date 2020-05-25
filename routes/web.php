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
Auth::routes();
//home routes
Route::get('/',function(){return redirect()->route('home');});
Route::get('/home', 'HomeController@index')->name('home');
//profile routes
Route::get('profile/show/{id}','ProfileController\ProfileController@show')->name('profile.show');
Route::get('/profile/edit','ProfileController\ProfileController@edit')->name('profile.edit');
Route::put('/profile/update','ProfileController\ProfileController@update')->name('profile.update');
Route::get('/profile/password/change','ProfileController\ProfileController@changepassword')->name('profile.change.password');
Route::put('/profile/password/change','ProfileController\ProfileController@change')->name('profile.change');

//product (item) routes

Route::get('/product/create','ProductController\ProductController@create')->name('product.create');
Route::post('/product/store','ProductController\ProductController@store')->name('product.store');
Route::get('/product/show/{id}','ProductController\ProductController@show')->name('product.show');
Route::get('/product/all','ProductController\ProductController@index')->name('product.all');
Route::get('/product/edit/{id}','ProductController\ProductController@edit')->name('product.edit');
Route::post('/product/update/{id}','ProductController\ProductController@update')->name('product.update');
Route::post('/product/delete','ProductController\ProductController@destroy')->name('product.delete');

//orders routes

Route::get('/order/create','OrderController\OrderController@create')->name('order.create');
Route::post('/order/store','OrderController\OrderController@store')->name('order.store');
Route::get('/order/show/{id}','OrderController\OrderController@show')->name('order.show');
Route::get('/order/edit/{id}','OrderController\OrderController@edit')->name('order.edit');
Route::post('/order/upudate/{order_id}','OrderController\OrderController@update')->name('order.update');
//change get method to post method after create all orders page
Route::get('/order/delete/{id}','OrderController\OrderController@destroy')->name('order.delete');
Route::get('/try', function () {
    return view('try');
});




