<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Article;
use Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'comment'=>'required'
        ]);

        $comment=new Comment;
        $comment->comment = $request->input('comment');
        $comment->user_id=Auth::id();
        $comment->article_id=$request->input('art_id');
        $comment->status=0;
        $comment->save();

        $article = Article::find($request->input('art_id'));
        $article->comment_num = $article->comment_num + 1;
        $article->save();

        return redirect()->route('archieve_show', ['id' => $request->input('art_id')])->with('success','Comment Created');
    }
}
