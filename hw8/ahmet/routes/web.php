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

//Route::get('/', function () {
//    return view('pages.index');
//});
Route::get('/','ArticleController@deneme');

Auth::routes();

Route::get('/archieve/category/{category}','ArticleController@deneme');

Route::resource('archieve','ArticleController');

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/home', 'HomeController@index')->name('home');

