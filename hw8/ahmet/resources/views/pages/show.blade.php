@extends('layouts.app')

@section('content')

    <a href="./" class="btn btn-default">Go Back</a>
    <br>
    <br>

    @if(count($article)>0)
        @foreach($article as $article)

            <nav class="nav navbar-nav">
                <i class="material-icons  md-30">date_range</i>
                <a class="nav-link" href="./{{$article->id}}">{{date('Y-m-d H:i', strtotime($article->created_at))}}</a>
                <i class="material-icons" >account_balance</i>
                <a class="nav-link" href="/archieve/category/{{$article->category}}">{{$article->category}}</a>
                <i class="material-icons" >account_circle </i>
                <a class="nav-link" href="profile/{{$article->author_id}}">{{$article->name}} {{$article->surname}}</a>
            </nav>

            <nav class="nav navbar-nav navbar-right">
                <i class="material-icons">comment</i>
                <a class="nav-link" href="./{{$article->id}}">Comments: {{$article->comments}}</a>
                <i class="material-icons">assessment</i>
                <a class="nav-link" href="./{{$article->id}}">Views: {{$article->viewing}}</a>
            </nav>
            <br>
            <h1>{{$article->header}}</h1>

            <div>
                {{$article->article}}
            </div>
            <hr>
            <small>Written on {{$article->created_at}}</small>
        @endforeach
    @else
        <p>No article found</p>
    @endif



@endsection
