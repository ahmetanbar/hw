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
use Illuminate\Support\Facades\Auth;

/*Route::get('/', function()
{
    return view('home');
});
*/
#


Route::prefix('admin/{lang?}')->middleware('locale')->group(function ($lang) {
    if (!Auth::check()) {
        Route::get('/','AdminPanel@index');
        Route::get('/overview','AdminPanel@overview');
        Route::get('/users','AdminPanel@users');
        Route::get('/profile/{username}','AdminPanel@user_profile');
        Route::get('/articles','AdminPanel@blog');
        Route::get('/article/post/{pid}','AdminPanel@blog_post');
        Route::get('search','AdminPanel@search');
        Route::get('/settings','AdminPanel@settings');
        Route::get('/inbox','AdminPanel@inbox');
        Route::get('/logout','AdminPanel@logout');
    }else{
        Route::any('{all?}', 'AdminPanel@login') ->where('all', '.+');



    }

});

Route::prefix('{lang?}')->middleware('locale')->group(function($lang) {
    Route::get('/','Front@index');
    Route::get('/about','Front@about');
    Route::get('/users','Front@users');
    Route::get('/profile/{username}','Front@user_profile');
    Route::get('/blog','Front@blog');
    Route::get('/blog/categories/{category?}','Front@blog_categories');
    Route::get('/blog/post/{pid}','Front@blog_post');
    Route::post('/search','Front@search');
    Route::get('/contact','Front@contact');
    Route::get('/signup','Front@signup');
    Route::get('/settings','Front@settings');
    Route::get('/login','Front@login');
    Route::get('/logout','Front@logout');
});


