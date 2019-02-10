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

Route::prefix('{lang?}')->middleware('locale')->group(function() {

    Route::get('/', function () {
        return view('front/index');
    });
    Route::get('/homepage', function () {
        return view('front/index');
    });
    Route::get('/about', function () {
        return view('front/index');
    });
    Route::get('/contact', function () {
        return view('front/index');
    });
});



Route::match(['get','post'], '/{locale}/login', function ($locale){
    App::setLocale($locale);
    echo __('lang.homepage');
    return "DENEME 1 ";
});







Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return "ADMIN PANEL";
    });
    if (Auth::check()) {
        // The user is logged in...
    }
    Route::get('users', function () {
        return "USERS PANEL";
    });
    Route::get('articles', function () {
        return "ARTICLES PANEL";
    });
    Route::get('harvard', function() {
        return "HARVARD COMMIT :D";
    });
});
