@extends('layouts.app')

@section('content')
    <p class="text-center">Hello World</p>

    @if(count($articles)>0)
        @foreach($articles as $article)
            <div class="well">
                <a href="./archieve/{{$article->id}}"><h1>{{$article->header}}</h1></a>
                <nav class="nav">
                    <a class="nav-link" href="./archieve/{{$article->id}}">Date</a>
                    <a class="nav-link" href="./archieve/category/{{$article->category}}">{{$article->category}}</a>
                    <a class="nav-link" href="profile/{{$article->author_id}}">Author</a>
                    <a class="nav-link" href="./archieve/{{$article->id}}">{{$article->comments}} Comments</a>
                </nav>
            </div>

        @endforeach

        @if(count($articles)>5)
            {{$articles->links()}}
        @endif

    @else
        <p>No posts found</p>
    @endif

@endsection
