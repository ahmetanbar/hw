@extends('layouts.app')

@section('content')
    <p style="padding: 10px; text-align: center; font-size: 35px;" >CodeNote</p>

    @if(count($articles)>0)
        @foreach($articles as $article)
            <div class="well">
                <a href="./archieve/{{$article->id}}"><h1>{{$article->header}}</h1></a>
                <nav class="nav navbar-nav">
                    <i class="material-icons  md-30">date_range</i>
                    <a class="nav-link" href="{{route('archieve.show',['id'=>$article->id])}}">{{date('Y-m-d H:i', strtotime($article->created_at))}}</a>
                    <i class="material-icons" >account_balance</i>
                    <a class="nav-link" href="{{route('categorize',['category' => $article->category]) }}">{{$article->category}}</a>
                    <i class="material-icons" >account_circle </i>
                    <a class="nav-link" href="{{route('profile.show',['id' => $article->username]) }}">{{$article->name}} {{$article->surname}}</a>
                </nav>

                <nav class="nav navbar-nav navbar-right">
                    <i class="material-icons">comment</i>
                    <a class="nav-link" href="{{route('archieve.show',['id'=>$article->id])}}">Comments: {{$article->comments}}</a>
                    <i class="material-icons">assessment</i>
                    <a class="nav-link" href="{{route('archieve.show',['id'=>$article->id])}}">Views: {{$article->viewing}}</a>
                </nav>
                <br>
            </div>

        @endforeach
    @else
        <p>No posts found</p>
    @endif

@endsection
