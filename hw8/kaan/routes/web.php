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

Route::get('/', function () {
    $articles=\App\article::take(5)->get();
    return view('home')->with('articles',$articles);
});

//Route::get('/deneme', 'HomeController@get_article');


Route::get('/deneme/{cate}/{id}','HomeController@get_deneme_isim');

Route::get('/deneme/{isim}','HomeController@get_deneme_isim');


Route::post('/addarticle','Homecontroller@post_article');
Route::get('/addarticle','Homecontroller@get_article');

