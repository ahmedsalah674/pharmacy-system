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
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/try', function () {
    return view('try');
});




