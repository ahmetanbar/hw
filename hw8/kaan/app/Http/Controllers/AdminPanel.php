<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AdminPanel extends Controller {

    public function index() {
        if (Auth::check()) {
            // The user is logged in...
        }
        return view('admin/dashboard');
    }

    public function users() {
        return view('admin/usertables');
    }

    public function overview() {
        return view('admin/widgets');
    }

    public function user_profile($lang,$username) {
        return view('admin/profile', compact('username'));
    }

    public function blog() {
        return view('admin/articlestables');
    }


    public function blog_post($lang,$pid) {
        return view('admin/article');
    }

    public function search($lang,Request $request) {
        $find = $request->input('find');
        return view('admin/search', compact('find'));

    }

    public function settings() {
        return view('admin/settings');
    }

    public function inbox() {
        return view('admin/messages');
    }

    public function login() {
        return view('admin/login');
    }

    public function logout() {
        return 'logout page';
    }

}