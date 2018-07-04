<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $comment_number=5;

        $profile=DB::table('users')
            ->where('users.username', $username)
            ->first();

        if(!count($profile)){
            return abort(404);
        }

        $comments=DB::table('comments')
            ->join('articles','comments.article_id','=','articles.id')
            ->select('articles.header', 'comments.*')
            ->where('comments.user_id', $profile->id)
            ->take($comment_number)
            ->get();
        $articles=DB::table('articles')
            ->where('articles.author_id', $profile->id)
            ->take($comment_number)
            ->get();

        $data = [
            'profile'  => $profile,
            'articles'   => $articles,
            'comments' => $comments
        ];

        return view('pages.profile')->with('data',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
