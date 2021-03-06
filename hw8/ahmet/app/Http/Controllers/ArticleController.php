<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Article;
use App\Comment;
use Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $pag_num=6;

        $articles=Article::where('status',0)
            ->paginate($pag_num);

        return view('pages.archieve',['articles'=>$articles]);
    }

    public function home()
    {
        $art_num=5;

        $articles=Article::where('status',0)
            ->orderBy('id','desc')
            ->take($art_num)
            ->get();

        return view('pages.index',['articles'=>$articles]);
    }

    public function categorize($category)
    {
        $pag_num=6;

        $articles=Category::where('name',$category)->first()->article()->where('status',0)->paginate($pag_num);

        return view('pages.archieve',['articles'=>$articles]);
    }

    public function store(Request $request)
    {
        if(!Auth::guest()){
            $this->validate($request, [
                'title'=>'required|max:250',
                'category_id'=>'required',
                'body'=>'required'
            ]);

            $article=new Article;
            $article->author_id=Auth::id();
            $article->header = $request->input('title');
            $article->article = $request->input('body');
            $article->category_id = $request->input('category_id');
            $article->save();

            return redirect()->route('archieve_show', ['id' =>  $article->id]);
        }

        return redirect()->route('home');
    }

    public function show($id)
    {
        $article = Article::where('status',0)->findorFail($id);
        $article->view_num = $article->view_num + 1;
        $article->save();
        return view('pages.show',['article'=>$article]);
    }

    public function getCategories()
    {
        if(!Auth::guest())
            return view('pages.add_article',['categories'=>Category::all()]);
        return redirect()->route('home');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if(!Auth::guest()) {
            if (Auth::user()->can('EUD', $article)) {
                $article->status = 1;
                $article->save();
                return redirect()->route('profile_show', ['id' => $article->user->username]);
            }
        }
        return redirect()->route('home');
    }

    public function edit($id)
    {
        $article = Article::find($id);
        if(!Auth::guest()){
            if (Auth::user()->can('EUD', $article)) {
                return view('pages.edit',['article'=>$article],['categories'=>Category::all()]);
            }
        }
        return redirect()->route('home');
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if(!Auth::guest()) {
            if (Auth::user()->can('EUD', $article)) {
                $this->validate($request, [
                    'header' => 'required|max:250',
                    'category_id' => 'required',
                    'article' => 'required',
                ]);

                $article->author_id = Auth::id();
                $article->header = $request->input('header');
                $article->article = $request->input('article');
                $article->category_id = $request->input('category_id');
                $article->save();

                return redirect()->route('archieve_show', ['id' => $article->id]);
            }
        }
    }
}