<?php


namespace App\Http\Controllers;
use Session;
use DB;
use App\User;
use Auth;

class ProfilesController extends Controller
{
    public function index()
    {   if(Auth::user())
            return $this->show(Auth::user()->username);
        else
            return redirect()->route('home');
    }

    public function show($username)
    {
        $content_num=5;

        $user_info= User::where('username', $username)
            ->first();

        if(!count($user_info)){
            return abort(404);
        }

        $user_info->comment=$user_info->comment->take($content_num);
        $user_info->article=$user_info->article->take($content_num);

        return view('pages.profile',['user_info'=>$user_info]);
    }
}
