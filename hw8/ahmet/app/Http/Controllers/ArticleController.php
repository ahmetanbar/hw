<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Comment;
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
            'title'=>'required',
            'category'=>'required',
            'body'=>'required'
        ]);

        $Article=new Article;
        $Article->author_id=Auth::id();
        $Article->header = $request->input('title');
        $Article->article = $request->input('body');
        $Article->category = $request->input('category');
        $Article->status=0;
        $Article->view_num=0;
        $Article->comment_num=0;
        $Article->save();

        return redirect()->route('archieve_show', ['id' =>  $Article->id]);
    }

    public function show($id)
    {
        $article = Article::find($id);
        $article->view_num = $article->view_num + 1;
        $article->save();

        return view('pages.show',['article'=>$article]);
    }

}