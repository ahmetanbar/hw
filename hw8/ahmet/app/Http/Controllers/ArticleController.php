<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\articles;
use App\deneme;
use App\Comment;
use DB;
use Auth;
use App\Post;

use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    public function index()
    {
        $articles=articles::orderBy('articles.id','desc')
            ->join('users','articles.author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->paginate(6);
        return view('pages.archieve')->with('articles',$articles);
    }

    public function home()
    {
        $art_num=5;
        $articles=articles::orderBy('articles.id','desc')
            ->join('users','articles.author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->take($art_num)
            ->get();
        return view('pages.index')->with('articles',$articles);
    }

    public function categorize($category)
    {
        $articles=articles::orderBy('articles.id','desc')
            ->join('users','articles.author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->where('articles.category', $category)
            ->paginate(6);
        return view('pages.archieve')->with('articles',$articles);
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

        return redirect()->route('archieve_show', ['id' => $request->input('art_id')])->with('success','Comment Created');
    }

    public function show($id)
    {
        DB::update('update articles set viewing=viewing+1 where id = ?', [$id]);

        $article=DB::table('articles')
            ->join('users','articles.author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username','articles.*')
            ->where('articles.id', $id)
            ->get();
        $comments=DB::table('comments')
            ->join('users','comments.user_id','=','users.id')
            ->select('users.name', 'users.surname','users.username', 'comments.*')
            ->where('comments.article_id', $id)
            ->get();

//        $article=articles::join('users','articles.author_id','=','users.id')
//            ->select('users.name', 'users.surname', 'users.username','articles.*')
//            ->where('articles.id', $id)
//            ->get();
//
//        $comments=Comment::join('users','comments.user_id','=','users.id')
//            ->select('users.name', 'users.surname','users.username', 'comments.*')
//            ->where('comments.article_id', $id)
//            ->get();

        $artcomment = array_merge($article->toArray(), $comments->toArray());

        return view('pages.show')->with('artcomment',$artcomment);
    }

}
