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
Route::group(['middleware'=>'auth'],function(){
    Route::get('/clear-cache', function() {
        Artisan::call('cache:clear');
        return redirect()->route('home');
    }); 
});
//home routes
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
//profile routes
Route::get('profile/show/{id}','ProfileController\ProfileController@show')->name('profile.show');
Route::get('/profile/edit','ProfileController\ProfileController@edit')->name('profile.edit');
Route::put('/profile/update','ProfileController\ProfileController@update')->name('profile.update');


Route::get('/try', function () {
    return view('try');
});




