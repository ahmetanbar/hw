<?php

Auth::routes();

Route::get('/profile','ProfilesController@index');
Route::get('/profile/{username}','ProfilesController@show')->name('profile_show');

Route::get('/archieve','ArticleController@index')->name('archieve_index');
Route::get('/','ArticleController@home')->name('home');
Route::get('/archieve/category/{category}','ArticleController@categorize')->name('categorize');
Route::get('/archieve/{id}','ArticleController@show')->name('archieve_show');
Route::post('/archieve','ArticleController@store');


Route::get('/about', function () {
    return view('pages.about');
})->name('about');

