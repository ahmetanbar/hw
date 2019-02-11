<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Front extends Controller {

    public function index() {
        return view('home');
    }

    public function about() {
        return 'contact us page';
    }

    public function users() {
        return 'User List';
    }

    public function user_profile($lang,$username) {
        return 'product details page'.$username;
    }

    public function blog() {
        return view('front/index');
    }

    public function blog_categories($lang,$category=null) {
        return 'product categories page';
    }

    public function blog_post($lang,$pid) {
        return 'blog post page';
    }

    public function search($lang,$query,$type=null) {
        return "$query search page";
    }

    public function contact() {
        return 'contact us page';
    }

    public function login() {
        return 'login page';
    }

    public function logout() {
        return 'logout page';
    }

    public function signup() {
        return 'login page';
    }
}