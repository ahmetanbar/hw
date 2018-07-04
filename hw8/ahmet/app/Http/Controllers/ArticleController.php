<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\articles;
use App\deneme;
use App\Comment;
use DB;
use Auth;

use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles=DB::table('articles')
            ->orderBy('articles.id','desc')
            ->join('users','articles.author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->paginate(6);
        return view('pages.archieve')->with('articles',$articles);
    }

    //        $articles= articles::orderBy('created_at','desc')->paginate(6);
    //        $articles= articles::orderBy('id','desc')->take($art_num)->get();

    public function home()
    {
        $art_num=5;
        $articles=DB::table('articles')
            ->orderBy('articles.id','desc')
            ->join('users','articles.author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->take($art_num)
            ->get();
        return view('pages.index')->with('articles',$articles);
    }

    public function categorize($category)
    {
        $articles=DB::table('articles')
            ->orderBy('articles.id','desc')
            ->join('users','articles.author_id','=','users.id')
            ->select('users.name', 'users.surname', 'users.username', 'articles.*')
            ->where('articles.category', $category)
            ->paginate(6);
        return view('pages.archieve')->with('articles',$articles);


//        $article=DB::table('articles')
//            ->join('users','articles.author_id','=','users.id')
//            ->select('users.name', 'users.surname', 'articles.*')
//            ->where('articles.id', $id)
//            ->get()
//
//        return 123;
    }

    //        $users = DB::table('articles')->get();
    //        return $users;
    ////        $articles= articles::orderBy('id','desc')->take($art_num)->get();
    //        return $articles[0]['id'];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('archieve.show', ['id' => $request->input('art_id')])->with('success','Comment Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article=DB::table('articles')
            ->join('users','articles.author_id','=','users.id')
            ->select('users.name', 'users.surname', 'articles.*')
            ->where('articles.id', $id)
            ->get();

        $comments=DB::table('comments')
            ->join('users','comments.user_id','=','users.id')
            ->select('users.name', 'users.surname','users.id', 'comments.*')
            ->where('comments.article_id', $id)
            ->get();

        $artcomment = array_merge($article->toArray(), $comments->toArray());

        return view('pages.show')->with('artcomment',$artcomment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
