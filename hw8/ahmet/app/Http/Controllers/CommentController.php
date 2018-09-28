<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Article;
use Auth;

class CommentController extends Controller
{

    public function __construct()
    {
    }

    public function store(Request $request)
    {
        if(!Auth::guest()){
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
        return redirect()->route('home');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if(!Auth::guest()) {
            if (Auth::user()->can('EUD', $comment)) {
                $comment->status = 1;
                $comment->save();

                return redirect()->route('profile_show', ['id' => $comment->user->username]);
            }
        }

        return redirect()->route('home');
    }

    public function edit($id)
    {
        $comment = Comment::findorFail($id);

        if(!Auth::guest()) {
            if (Auth::user()->can('EUD', $comment)) {
                $article = Article::where('status',0)->findorFail($comment->article_id);
                $article->view_num = $article->view_num + 1;
                $article->save();

                return view('pages.show',['edit_comment'=>$comment],['article'=>$article]);
            }
        }

        return redirect()->route('home');
    }

    public function update(Request $request,$id)
    {
        $comment = Comment::find($id);

        if(!Auth::guest()) {
            if (Auth::user()->can('EUD', $comment)) {
                $comment->comment = $request->input('comment');
                $comment->save();

                return redirect()->route('archieve_show', ['id' =>  $comment->article_id]);
            }
        }

        return redirect()->route('home');
    }
}
