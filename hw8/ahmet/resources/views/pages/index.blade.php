@extends('layouts.app')

@section('content')
    <p style="padding: 10px; text-align: center; font-size: 35px;" >CodeNote</p>

    @if(count($articles)>0)
        @foreach($articles as $article)
            <div class="well">
                <a href="./archieve/{{$article->id}}"><h1>{{$article->header}}</h1></a>
                <nav class="nav navbar-nav">
                    <i class="material-icons  md-30">date_range</i>
                    <i class="nav-link">{{date('Y-m-d H:i', strtotime($article->created_at))}}</i>
                    <i class="material-icons" >account_balance</i>
                    <a class="nav-link" href="{{route('categorize',['category' => $article->category->name]) }}">{{$article->category->name}}</a>
                    <i class="material-icons" >account_circle </i>
                    <a class="nav-link" href="{{route('profile_show',['id' => $article->user->username]) }}">{{$article->user->name}} {{$article->user->surname}}</a>
                </nav>

                <nav class="nav navbar-nav navbar-right">
                    <i class="material-icons">comment</i>
                    <i class="nav-link">Comments: {{$article->comment_num}}</i>
                    <i class="material-icons">assessment</i>
                    <i class="nav-link">Views: {{$article->view_num}}</i>
                </nav>
                <br>
            </div>

        @endforeach
    @else
        <p>No posts found</p>
    @endif

@endsection
