<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Comment;
use DB;
use Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $pag_num=6;

        $articles=Article::paginate($pag_num);

        return view('pages.archieve',['articles'=>$articles]);
    }

    public function home()
    {
        $art_num=5;

        $articles=Article::orderBy('id','desc')
            ->take($art_num)
            ->get();

        return view('pages.index',['articles'=>$articles]);
    }

    public function categorize($category)
    {
        $pag_num=6;

        $articles=Article::orderBy('id','desc')
            ->where('category', $category)
            ->paginate($pag_num);

        return view('pages.archieve',['articles'=>$articles]);
    }

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

    public function show($id)
    {
        $article = Article::find($id);
        $article->view_num = $article->view_num + 1;
        $article->save();

        return view('pages.show',['article'=>$article]);
    }

}