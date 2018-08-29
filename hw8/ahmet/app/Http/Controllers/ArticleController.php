<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Article;
use App\Comment;
use DB;
use Auth;


use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    public function index()
    {
        $pag_num=6;
        $articles=Article::orderBy('id','desc')
            ->join('users','author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->paginate($pag_num);
        return view('pages.archieve',['articles'=>$articles]);
    }

    public function home()
    {
        $art_num=5;
        $articles=Article::orderBy('id','desc')
            ->join('users','author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->take($art_num)
            ->get();
        return view('pages.index',['articles'=>$articles]);
    }

    public function categorize($category)
    {
        $articles=Article::orderBy('id','desc')
            ->join('users','author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->where('category', $category)
            ->paginate(6);

        $articles=Article::orderBy('id','desc')
            ->where('category', $category)
            ->paginate(6);

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

        DB::update('update articles set comment_num=comment_num +1 where id = ?', [$request->input('art_id')]);

        return redirect()->route('archieve_show', ['id' => $request->input('art_id')])->with('success','Comment Created');
    }

    public function show($id)
    {
        DB::update('update articles set view_num=view_num+1 where id = ?', [$id]);

        $article = Article::find($id);

        return view('pages.show',['article'=>$article]);
    }

}