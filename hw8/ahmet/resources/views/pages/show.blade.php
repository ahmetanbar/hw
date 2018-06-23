@extends('layouts.app')

@section('content')

    <a href="./" class="btn btn-default">Go Back</a>
    @if(count($article)>0)
        <h1>{{$article->header}}</h1>

        <div>
            {{$article->article}}
        </div>
        <hr>
        <small>Written on {{$article->created_at}}</small>
    @else
        <p>No article found</p>
    @endif



@endsection
