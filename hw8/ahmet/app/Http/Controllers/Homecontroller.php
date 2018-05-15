<?php

namespace App\Http\Controllers;

use App\articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class Homecontroller extends Controller
{
    public function get_controller(){
        return view('home');
    }
//
//    public function get_article(){
//        $art_id=Input::get('id');
//        $cate=Input::get('cate');
//        return view('deneme')->with('art_id',$art_id)->with('cate',$cate);
//    }

    public function get_deneme_isim($isim){
        return view('deneme')->with('isim',$isim);
    }

    public function get_article(){
        return view('addarticle');
    }

    public function post_article(Request $request){
        articles::create($request->all());
        return 'islem basarili';
    }



}


