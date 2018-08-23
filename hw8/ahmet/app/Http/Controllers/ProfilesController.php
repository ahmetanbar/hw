<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Comment;
use App\articles;
class ProfilesController extends Controller
{
    public function index()
    {
       //Will add directing to user's profile
    }

    public function show($username)
    {
        $comment_number=5;

        $profile= User::where('username', $username)
            ->first();

        if(!count($profile)){
            return abort(404);
        }

        $comments=Comment::join('articles','article_id','=','articles.id')
            ->select('articles.header', 'comments.*')
            ->where('user_id', $profile->id)
            ->take($comment_number)
            ->get();
        $articles=articles::where('articles.author_id', $profile->id)
            ->take($comment_number)
            ->get();

        $data = [
            'profile'  => $profile,
            'articles'   => $articles,
            'comments' => $comments
        ];

        return view('pages.profile',['data'=>$data]);
    }
}
