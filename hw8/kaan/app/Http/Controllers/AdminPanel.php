<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPanel extends Controller {

    public function index() {
        return view('admin/dashboard');
    }

    public function users() {
        return view('admin/usertables');
    }

    public function overview() {
        return view('admin/widgets');
    }

    public function user_profile($lang,$username) {
        return view('admin/profile');
    }

    public function blog() {
        return view('admin/articlestables');
    }


    public function blog_post($lang,$pid) {
        return view('admin/article');
    }

    public function search($lang,$query,$type=null) {
        return "$query search page";
    }

    public function login() {
        return view('admin/login');
    }

    public function logout() {
        return 'logout page';
    }

}