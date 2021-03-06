<?php

Auth::routes();

Route::get('/changePassword','HomeController@showChangePasswordForm')->name('get_changePass');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

Route::get('/update','HomeController@showChangeProfileForm')->name('get_changePro');
Route::post('/update','HomeController@changeProfile')->name('changeProfile');

Route::get('/profile','ProfilesController@index')->name('profile');
Route::get('/profile/{username}','ProfilesController@show')->name('profile_show');

Route::get('/archieve','ArticleController@index')->name('archieve_index');
Route::get('/','ArticleController@home')->name('home');
Route::get('/archieve/category/{category}','ArticleController@categorize')->name('categorize');
Route::get('/archieve/{id}','ArticleController@show')->name('archieve_show');

Route::post('/archieve','CommentController@store')->name('comment_store');
Route::delete('/article/{id}/2', 'CommentController@destroy')->name('destroy_comment');
Route::get('/article/{id}/comment-edit','CommentController@edit')->name('edit_comment');
Route::put('/article/{id}/comment-edit','CommentController@update')->name('update_comment');


Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/article/add','ArticleController@getCategories')->name('add_article');
Route::post('/article/add','ArticleController@store')->name('article_store');
Route::delete('/article/{id}', 'ArticleController@destroy')->name('destroy_article');
Route::get('/article/{id}/edit','ArticleController@edit')->name('edit_article');
Route::put('/article/{id}/edit','ArticleController@update')->name('update_article');

