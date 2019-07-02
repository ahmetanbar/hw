<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
class CommentController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }


    public function store(Request $request)
    {
    	$request->validate([
            'comment'=>'required',
        ]);
   
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
            // dd($input);
        Comment::create($input);
   
        return back();
    }
}
