<?php


namespace App\Http\Controllers;
use Session;
use DB;
use App\User;
use Auth;

class ProfilesController extends Controller
{
    public function index()
    {     if(Auth::user())
            return $this->show(Auth::user()->username);
        else
            return redirect()->route('home');
    }

    public function show($username)
    {
        $user_info= User::where('username', $username)
            ->first();

        if(!count($user_info)){
            return abort(404);
        }

        return view('pages.profile',['user_info'=>$user_info]);
    }
}
