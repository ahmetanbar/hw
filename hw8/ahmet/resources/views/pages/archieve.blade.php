@extends('layouts.app')

@section('content')
    <p class="text-center">Hello World</p>

    @if(count($articles)>0)
        @foreach($articles as $article)
            <div class="well">
                <a href="./archieve/{{$article->id}}"><h1>{{$article->header}}</h1></a>
                <nav class="nav">
                    <a class="nav-link" href="./archieve/{{$article->id}}">Date: {{date('Y-m-d H:i', strtotime($article->created_at))}}</a>
                    <a class="nav-link" href="./archieve/category/{{$article->category}}">{{$article->category}}</a>
                    <a class="nav-link" href="profile/{{$article->author_id}}">{{$article->name}} {{$article->surname}}</a>
                    <a class="nav-link" href="./archieve/{{$article->id}}">Comments: {{$article->comments}}</a>
                    <a class="nav-link" href="./archieve/{{$article->id}}">Views: {{$article->comments}}</a>
                </nav>
            </div>

        @endforeach

        {{$articles->links()}}

    @else
        <p>No posts found</p>
    @endif

@endsection
