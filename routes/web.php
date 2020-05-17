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
Auth::routes(['register'=>false]);
Route::group(['middleware'=>'auth'],function(){
    Route::get('/clear-cache', function() {
        Artisan::call('cache:clear');
        return redirect()->route('home');
    }); 
});
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

Route::get('/try', function () {
    return view('try');
});




