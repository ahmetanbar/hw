<?php

Auth::routes();

Route::get('/profile','ProfilesController@index');
Route::get('/profile/{username}','ProfilesController@show')->name('profile_show');

Route::get('/archieve','ArticleController@index')->name('archieve_index');
Route::get('/','ArticleController@home')->name('home');
Route::get('/archieve/category/{category}','ArticleController@categorize')->name('categorize');
Route::get('/archieve/{id}','ArticleController@show')->name('archieve_show');
Route::post('/archieve','CommentController@store')->name('comment_store');

Route::get('/article/add',function () {
    return view('pages.add_article');
})->name('add_article');
Route::post('/article/add','ArticleController@store')->name('article_store');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

